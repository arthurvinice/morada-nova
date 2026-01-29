<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Campaign;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class ProcessScheduledCampaigns extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaigns:process-scheduled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process scheduled campaigns that are due for sending';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::channel('cron')->info('===== INICIANDO PROCESSAMENTO DE CAMPANHAS AGENDADAS =====');
        $this->info('Starting to process scheduled campaigns...');

        try {
            // Log das configurações atuais
            Log::channel('cron')->info('Verificando configuração da Z-API');
            $instance = config('z-api.instance');
            $token = config('z-api.token');
            $clientToken = config('z-api.client_token');

            Log::channel('cron')->info(
                'Configuração: ' .
                    'Instance: ' . (!empty($instance) ? 'Configurada' : 'AUSENTE') . ', ' .
                    'Token: ' . (!empty($token) ? 'Configurado' : 'AUSENTE') . ', ' .
                    'Client Token: ' . (!empty($clientToken) ? 'Configurado' : 'AUSENTE')
            );

            $baseUrl = "https://api.z-api.io/instances/{$instance}/token/{$token}";
            Log::channel('cron')->info("Base URL da API: {$baseUrl}");

            if (empty($instance) || empty($token) || empty($clientToken)) {
                Log::channel('cron')->error('Configurações da Z-API ausentes');
                $this->error('Z-API configuration missing');
                return 1;
            }

            Log::channel('cron')->info('Buscando campanhas agendadas para envio');

            // Buscar campanhas agendadas que estão prontas para envio
            $now = Carbon::now();
            Log::channel('cron')->info('Data/hora atual: ' . $now->toDateTimeString());

            $campaigns = Campaign::where('status', 'pending')
                ->where('is_scheduled', true)
                ->where('scheduled_at', '<=', $now)
                ->get();

            Log::channel('cron')->info("Encontradas {$campaigns->count()} campanhas para processar");

            if ($campaigns->isEmpty()) {
                Log::channel('cron')->info('Nenhuma campanha para processar neste momento');
                $this->info('No campaigns to process at this time.');

                // Verificar se existem campanhas agendadas para o futuro
                $futureCampaigns = Campaign::where('status', 'pending')
                    ->where('is_scheduled', true)
                    ->where('scheduled_at', '>', $now)
                    ->orderBy('scheduled_at', 'asc')
                    ->get();

                if ($futureCampaigns->count() > 0) {
                    Log::channel('cron')->info("Existem {$futureCampaigns->count()} campanhas agendadas para o futuro:");
                    foreach ($futureCampaigns as $campaign) {
                        Log::channel('cron')->info("- ID: {$campaign->id}, Nome: {$campaign->name}, Agendada para: {$campaign->scheduled_at}");
                    }
                } else {
                    Log::channel('cron')->info('Não existem campanhas agendadas para o futuro');
                }
                return 0;
            }

            foreach ($campaigns as $campaign) {
                Log::channel('cron')->info("Processando campanha ID: {$campaign->id} - {$campaign->name}");
                Log::channel('cron')->info("Detalhes da campanha: Agendada para {$campaign->scheduled_at}, Status atual: {$campaign->status}");

                try {
                    // Decodifica os recipients
                    $recipients = json_decode($campaign->recipients, true);
                    Log::channel('cron')->info('Destinatários decodificados: ' . (is_array($recipients) ? count($recipients) : 'INVÁLIDO'));

                    if (!is_array($recipients) || empty($recipients)) {
                        Log::channel('cron')->error("Lista de destinatários inválida ou vazia para campanha {$campaign->id}");
                        // Marcar como falha
                        $this->markCampaignAsFailed($campaign, "Lista de destinatários inválida ou vazia");
                        continue;
                    }

                    // Processamento dos envios
                    $successCount = 0;
                    $failCount = 0;
                    $sample = array_slice($recipients, 0, min(3, count($recipients)));
                    Log::channel('cron')->info('Amostra de destinatários: ' . json_encode($sample));

                    foreach ($recipients as $index => $recipient) {
                        try {
                            $phone = $this->formatWhatsAppNumber($recipient);
                            Log::channel('cron')->info("Processando destinatário {$index}: {$recipient} (formatado: {$phone})");

                            // [HIGHLIGHT] Verifica o tipo de mídia e define o endpoint e payload adequados:
                            if (!empty($campaign->image_url)) {
                                // Se houver imagem, use o endpoint de envio para imagem
                                $endpoint = "{$baseUrl}/send-image";  // <== Correção: usar endpoint send-image
                                $mediaUrl = asset('storage/' . $campaign->image_url);  // URL gerada de forma idêntica ao método send do controller
                                $payload = [
                                    'phone'   => $phone,
                                    'caption' => $campaign->message, // Pode ser 'caption' ou 'message', conforme a documentação
                                    'image'   => $mediaUrl
                                ];
                                Log::channel('cron')->info("Incluindo imagem no payload: " . $mediaUrl);
                            } elseif (!empty($campaign->video_url)) {
                                // Se houver vídeo, use o endpoint de envio para vídeo
                                $endpoint = "{$baseUrl}/send-video";  // <== Correção: usar endpoint send-video
                                $mediaUrl = asset('storage/' . $campaign->video_url);
                                $payload = [
                                    'phone'   => $phone,
                                    'caption' => $campaign->message,
                                    'video'   => $mediaUrl
                                ];
                                Log::channel('cron')->info("Incluindo vídeo no payload: " . $mediaUrl);
                            } elseif (!empty($campaign->audio_url)) {
                                // Se houver áudio, use o endpoint de envio para áudio
                                $endpoint = "{$baseUrl}/send-audio";  // <== Correção: usar endpoint send-audio
                                $mediaUrl = asset('storage/' . $campaign->audio_url);
                                $payload = [
                                    'phone' => $phone,
                                    'audio' => $mediaUrl
                                ];
                                Log::channel('cron')->info("Incluindo áudio no payload: " . $mediaUrl);
                            } else {
                                // Sem mídia, use o endpoint de envio de mensagem
                                $endpoint = "{$baseUrl}/send-message";
                                $payload = [
                                    'phone'   => $phone,
                                    'message' => $campaign->message
                                ];
                                Log::channel('cron')->info("Usando endpoint para texto: {$endpoint}");
                            }

                            Log::channel('cron')->info("Enviando requisição para Z-API: {$endpoint}");
                            $response = Http::withHeaders([
                                'Client-Token' => $clientToken,
                            ])->post($endpoint, $payload);

                            $statusCode = $response->status();
                            $responseData = $response->json();
                            Log::channel('cron')->info("Resposta da API (status {$statusCode}): " . $response->body());

                            if ($response->successful() && !isset($responseData['error'])) {
                                Log::channel('cron')->info("Mensagem enviada com sucesso para: {$phone}");
                                $successCount++;
                            } else {
                                $failCount++;
                                $errorMessage = isset($responseData['error']) ? $responseData['error'] : 'Erro desconhecido';
                                $errorDetail = isset($responseData['message']) ? $responseData['message'] : '';
                                Log::channel('cron')->warning("Falha ao enviar mensagem para {$phone}. Erro: {$errorMessage} - {$errorDetail}");
                            }
                            usleep(200000); // Delay de 200ms para evitar sobrecarga
                        } catch (\Exception $e) {
                            $failCount++;
                            Log::channel('cron')->error("Erro ao enviar mensagem para destinatário {$index}: " . $e->getMessage());
                            Log::channel('cron')->error("Stack trace: " . $e->getTraceAsString());
                        }
                    }

                    // Atualizar o status da campanha após processar todos os destinatários
                    $this->updateCampaignStatus($campaign, $successCount, $failCount);
                } catch (\Exception $e) {
                    Log::channel('cron')->error("Erro processando campanha {$campaign->id}: " . $e->getMessage());
                    Log::channel('cron')->error("Stack trace: " . $e->getTraceAsString());

                    // Marcar a campanha como falha
                    $this->markCampaignAsFailed($campaign, $e->getMessage());
                }
            }

            Log::channel('cron')->info('Processamento de campanhas agendadas concluído');
            return 0;
        } catch (\Exception $e) {
            Log::channel('cron')->critical("ERRO CRÍTICO: " . $e->getMessage());
            Log::channel('cron')->critical("Stack trace: " . $e->getTraceAsString());
            $this->error("Critical error: " . $e->getMessage());
            return 1;
        } finally {
            Log::channel('cron')->info('===== FINALIZADO PROCESSAMENTO DE CAMPANHAS AGENDADAS =====');
        }
    }

    private function formatWhatsAppNumber($number)
    {
        // Remove caracteres não numéricos
        $number = preg_replace('/[^0-9]/', '', $number);

        // Adiciona o prefixo "+55" se não estiver presente
        if (!str_starts_with($number, '55')) {
            $number = '55' . $number;
        }

        // Adiciona o "+" no início
        return '+' . $number;
    }

    /**
     * Atualiza o status da campanha após o processamento
     */
    private function updateCampaignStatus(Campaign $campaign, int $successCount, int $failCount): void
    {
        try {
            // Atualiza a campanha para 'completed' se os envios tiverem ocorrido
            $updateData = ['status' => 'completed'];

            if (Schema::hasColumn('campaigns', 'sent_at')) {
                $updateData['sent_at'] = Carbon::now();
            }
            if (Schema::hasColumn('campaigns', 'sent_count')) {
                $updateData['sent_count'] = $successCount;
            }
            if (Schema::hasColumn('campaigns', 'fail_count')) {
                $updateData['fail_count'] = $failCount;
            }
            $campaign->update($updateData);
            Log::channel('cron')->info("Campanha {$campaign->id} concluída. Sucessos: {$successCount}, Falhas: {$failCount}");
        } catch (\Exception $e) {
            Log::channel('cron')->error("Erro ao atualizar status da campanha {$campaign->id}: " . $e->getMessage());
            Log::channel('cron')->error("Stack trace: " . $e->getTraceAsString());

            // Tentar novamente com valores alternativos
            try {
                foreach (['completed', 'done', 'finished'] as $statusValue) {
                    try {
                        $campaign->update(['status' => $statusValue]);
                        Log::channel('cron')->info("Campanha {$campaign->id} marcada como {$statusValue} após tentar alternativas");
                        break;
                    } catch (\Exception $e2) {
                        Log::channel('cron')->warning("Falha ao tentar status '{$statusValue}': " . $e2->getMessage());
                    }
                }
            } catch (\Exception $e3) {
                Log::channel('cron')->critical("Todas as tentativas de atualizar o status falharam para campanha {$campaign->id}");
            }
        }
    }

    /**
     * Marca a campanha como falha
     */
    private function markCampaignAsFailed(Campaign $campaign, string $reason): void
    {
        try {
            $failData = ['status' => 'failed'];
            if (Schema::hasColumn('campaigns', 'sent_at')) {
                $failData['sent_at'] = Carbon::now();
            }
            $campaign->update($failData);
            Log::channel('cron')->info("Campanha {$campaign->id} marcada como falha. Motivo: {$reason}");
        } catch (\Exception $e) {
            Log::channel('cron')->critical("Não foi possível marcar a campanha {$campaign->id} como falha: " . $e->getMessage());
            try {
                foreach (['error', 'canceled'] as $statusValue) {
                    try {
                        $campaign->update(['status' => $statusValue]);
                        Log::channel('cron')->info("Campanha {$campaign->id} marcada como {$statusValue} após falha inicial");
                        break;
                    } catch (\Exception $e2) {
                        Log::channel('cron')->warning("Falha ao tentar status '{$statusValue}': " . $e2->getMessage());
                    }
                }
            } catch (\Exception $e3) {
                Log::channel('cron')->critical("Todas as tentativas de atualizar o status falharam para campanha {$campaign->id}");
            }
        }
    }
}
