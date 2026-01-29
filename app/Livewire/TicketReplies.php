<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Exception;

class TicketReplies extends Component
{
    use WithFileUploads;

    public $ticket;
    public $ticketId;
    public $descricao = '';
    public $client_people_name = '';
    public $anexo;
    public $replies = [];
    public $totalReplies = 0;
    public $loading = false;
    public $sending = false;
    public $lastUpdated = null;
    public $hasNewReplies = false;
    public $newRepliesCount = 0;
    public $checkingUpdates = false;
    public $userIsTyping = false;
    public $lastKnownReplyCount = 0;
    public $lastKnownReplyIds = [];

    protected $rules = [
        'descricao' => 'required|string|min:3',
        'anexo' => 'nullable|file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png,txt,zip,rar',
    ];

    protected $messages = [
        'descricao.required' => 'A descrição da resposta é obrigatória.',
        'descricao.min' => 'A descrição deve ter pelo menos 3 caracteres.',
        'anexo.max' => 'O arquivo deve ter no máximo 10MB.',
        'anexo.mimes' => 'Apenas arquivos PDF, DOC, DOCX, JPG, JPEG, PNG, TXT, ZIP e RAR são permitidos.',
    ];

    private function logDebug($message, $data = [])
    {
        Log::channel('ticket_replies')->info($message, array_merge($data, [
            'ticket_id' => $this->ticketId,
            'user_id' => auth()->id(),
            'timestamp' => now()->toDateTimeString()
        ]));
    }

    private function logError($message, $data = [])
    {
        Log::channel('ticket_replies')->error($message, array_merge($data, [
            'ticket_id' => $this->ticketId,
            'user_id' => auth()->id(),
            'timestamp' => now()->toDateTimeString(),
            'user_agent' => request()->userAgent(),
            'ip' => request()->ip()
        ]));
    }

    public function mount($ticket = null, $ticketId = null)
    {
        if ($ticket) {
            // Converter para array se for objeto
            $this->ticket = is_array($ticket) ? $ticket : (array) $ticket;
            $this->ticketId = $this->ticket['id'] ?? $ticketId;

            // Definir automaticamente o nome do cliente
            $this->client_people_name = $this->ticket['client_people_name'] ?? '';
        } else {
            $this->ticketId = $ticketId;
        }

        $this->logDebug('Component mounted', [
            'has_ticket' => !empty($this->ticket),
            'ticket_id' => $this->ticketId,
            'client_people_name' => $this->client_people_name
        ]);

        // Obter dados do cache
        $cacheKey = "ticket_{$this->ticketId}_replies_data";
        $cachedData = Cache::get($cacheKey, [
            'count' => 0,
            'ids' => []
        ]);

        $this->lastKnownReplyCount = $cachedData['count'];
        $this->lastKnownReplyIds = $cachedData['ids'];

        $this->loadReplies();
    }

    public function updatedDescricao()
    {
        // Detectar quando usuário está digitando
        $this->userIsTyping = !empty(trim($this->descricao));
    }

    /**
     * Método específico para verificar novas respostas sem interferir no formulário
     */
    public function checkForNewReplies()
    {
        if (!$this->ticketId) {
            $this->logError('checkForNewReplies: ticket ID não definido');
            return;
        }

        // Se o usuário está digitando, não verificar para não atrapalhar
        if ($this->userIsTyping && !empty(trim($this->descricao))) {
            return;
        }

        $this->checkingUpdates = true;

        try {
            $endpoint = env('ENDPOINT_API_TICKET') . "/api/suporte/tickets/{$this->ticketId}/replies";

            $this->logDebug('checkForNewReplies: Fazendo requisição', [
                'endpoint' => $endpoint,
                'method' => 'GET'
            ]);

            $response = Http::timeout(15)
                ->withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ])
                ->get($endpoint);

            $this->logDebug('checkForNewReplies: Resposta recebida', [
                'status' => $response->status(),
                'headers' => $response->headers(),
                'body_size' => strlen($response->body())
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['success']) && $data['success']) {
                    $newTotalReplies = $data['data']['total_replies'] ?? 0;
                    $newReplies = $data['data']['replies'] ?? [];

                    // Extrair IDs das novas respostas
                    $newReplyIds = collect($newReplies)->pluck('id')->toArray();

                    // Verificar se há respostas realmente novas
                    $reallyNewReplies = [];
                    if ($this->lastKnownReplyCount > 0) {
                        $reallyNewIds = array_diff($newReplyIds, $this->lastKnownReplyIds);

                        if (!empty($reallyNewIds)) {
                            // Marcar apenas as respostas realmente novas
                            foreach ($newReplies as &$reply) {
                                if (in_array($reply['id'] ?? null, $reallyNewIds)) {
                                    $reply['is_new'] = true;
                                    $reallyNewReplies[] = $reply;
                                }
                            }

                            $this->hasNewReplies = true;
                            $this->newRepliesCount = count($reallyNewReplies);
                        }
                    }

                    // Atualizar dados
                    $this->replies = $newReplies;
                    $this->totalReplies = $newTotalReplies;
                    $this->lastUpdated = now()->toISOString();

                    // Atualizar cache
                    $cacheKey = "ticket_{$this->ticketId}_replies_data";
                    Cache::put($cacheKey, [
                        'count' => $newTotalReplies,
                        'ids' => $newReplyIds
                    ], now()->addHours(24));

                    $this->lastKnownReplyCount = $newTotalReplies;
                    $this->lastKnownReplyIds = $newReplyIds;

                    // Atualizar dados do ticket se necessário
                    if (!$this->ticket && isset($data['data']['ticket'])) {
                        $this->ticket = $data['data']['ticket'];
                        $this->client_people_name = $this->ticket['client_people_name'] ?? '';
                    }

                    $this->logDebug('checkForNewReplies: Dados atualizados com sucesso', [
                        'total_replies' => $newTotalReplies,
                        'new_replies' => count($reallyNewReplies)
                    ]);
                } else {
                    $this->logError('checkForNewReplies: API retornou success=false', [
                        'response_data' => $data
                    ]);
                }
            } else {
                $this->logError('checkForNewReplies: Resposta não successful', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
            }

        } catch (Exception $e) {
            $this->logError('checkForNewReplies: Exception capturada', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
        } finally {
            $this->checkingUpdates = false;
        }
    }

    /**
     * Carregar respostas completo (usado no mount e após adicionar resposta)
     */
    public function loadReplies()
    {
        if (!$this->ticketId) {
            $this->logError('loadReplies: ticket ID não definido');
            return;
        }

        $this->loading = true;

        try {
            $endpoint = env('ENDPOINT_API_TICKET') . "/api/suporte/tickets/{$this->ticketId}/replies";

            $this->logDebug('loadReplies: Fazendo requisição', [
                'endpoint' => $endpoint,
                'method' => 'GET',
                'timeout' => 30,
                'env_endpoint' => env('ENDPOINT_API_TICKET')
            ]);

            $response = Http::timeout(30)
                ->withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ])
                ->get($endpoint);

            $this->logDebug('loadReplies: Resposta recebida', [
                'status' => $response->status(),
                'headers' => $response->headers(),
                'body_size' => strlen($response->body())
            ]);

            if ($response->successful()) {
                $data = $response->json();

                $this->logDebug('loadReplies: JSON decodificado', [
                    'has_success_key' => isset($data['success']),
                    'success_value' => $data['success'] ?? null,
                    'has_data_key' => isset($data['data']),
                    'data_structure' => array_keys($data['data'] ?? [])
                ]);

                if (isset($data['success']) && $data['success']) {
                    $this->replies = $data['data']['replies'] ?? [];
                    $this->totalReplies = $data['data']['total_replies'] ?? 0;
                    $this->lastUpdated = now()->toISOString();

                    // Atualizar cache
                    $newReplyIds = collect($this->replies)->pluck('id')->toArray();
                    $cacheKey = "ticket_{$this->ticketId}_replies_data";
                    Cache::put($cacheKey, [
                        'count' => $this->totalReplies,
                        'ids' => $newReplyIds
                    ], now()->addHours(24));

                    $this->lastKnownReplyCount = $this->totalReplies;
                    $this->lastKnownReplyIds = $newReplyIds;

                    // Atualizar dados do ticket se necessário
                    if (!$this->ticket && isset($data['data']['ticket'])) {
                        $this->ticket = $data['data']['ticket'];
                        $this->client_people_name = $this->ticket['client_people_name'] ?? '';
                    }

                    $this->logDebug('loadReplies: Dados carregados com sucesso', [
                        'total_replies' => $this->totalReplies,
                        'replies_count' => count($this->replies)
                    ]);
                } else {
                    $this->logError('loadReplies: API retornou success=false', [
                        'response_data' => $data
                    ]);
                    session()->flash('error', 'Erro ao carregar respostas do ticket.');
                }
            } else {
                $this->logError('loadReplies: Resposta HTTP não successful', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                session()->flash('error', 'Erro de comunicação com o servidor.');
            }

        } catch (Exception $e) {
            $this->logError('loadReplies: Exception capturada', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'code' => $e->getCode(),
                'previous' => $e->getPrevious() ? $e->getPrevious()->getMessage() : null
            ]);
            session()->flash('error', 'Erro de conexão ao carregar respostas.');
        } finally {
            $this->loading = false;
        }
    }

    public function addReply()
    {
        $this->validate();

        if (!$this->ticketId) {
            $this->logError('addReply: ticket ID não definido');
            session()->flash('error', 'ID do ticket não encontrado.');
            return;
        }

        if (empty($this->client_people_name)) {
            $this->logError('addReply: client_people_name não definido');
            session()->flash('error', 'Nome do cliente não foi definido corretamente.');
            return;
        }

        $this->sending = true;

        try {
            $endpoint = env('ENDPOINT_API_TICKET') . "/api/suporte/tickets/{$this->ticketId}/replies";

            $data = [
                'descricao' => $this->descricao,
                'client_people_name' => $this->client_people_name,
            ];

            $this->logDebug('addReply: Preparando requisição', [
                'endpoint' => $endpoint,
                'has_anexo' => !empty($this->anexo),
                'data' => $data
            ]);

            // Se há anexo, usar multipart/form-data
            if ($this->anexo) {
                $this->logDebug('addReply: Enviando com anexo', [
                    'filename' => $this->anexo->getClientOriginalName(),
                    'size' => $this->anexo->getSize(),
                    'mime' => $this->anexo->getMimeType()
                ]);

                $response = Http::timeout(60)
                    ->attach('anexo', file_get_contents($this->anexo->getRealPath()), $this->anexo->getClientOriginalName())
                    ->post($endpoint, $data);
            } else {
                $this->logDebug('addReply: Enviando sem anexo');

                $response = Http::timeout(30)
                    ->asForm()
                    ->post($endpoint, $data);
            }

            $this->logDebug('addReply: Resposta recebida', [
                'status' => $response->status(),
                'headers' => $response->headers(),
                'body_size' => strlen($response->body())
            ]);

            if ($response->successful()) {
                $responseData = $response->json();

                $this->logDebug('addReply: Resposta decodificada', [
                    'response_data' => $responseData
                ]);

                if (isset($responseData['success']) && $responseData['success']) {
                    // Limpar campos
                    $this->descricao = '';
                    $this->anexo = null;
                    $this->userIsTyping = false;

                    // Recarregar respostas imediatamente
                    $this->loadReplies();

                    session()->flash('message', $responseData['message'] ?? 'Resposta adicionada com sucesso!');

                    $this->logDebug('addReply: Resposta adicionada com sucesso');
                } else {
                    $this->logError('addReply: API retornou success=false', [
                        'response_data' => $responseData
                    ]);
                    session()->flash('error', $responseData['message'] ?? 'Erro ao adicionar resposta.');
                }

            } else {
                $responseBody = $response->body();
                $error = null;

                try {
                    $error = $response->json();
                } catch (Exception $jsonException) {
                    $this->logError('addReply: Erro ao decodificar JSON de erro', [
                        'json_error' => $jsonException->getMessage(),
                        'raw_body' => $responseBody
                    ]);
                }

                $this->logError('addReply: Resposta HTTP não successful', [
                    'status' => $response->status(),
                    'error_data' => $error,
                    'raw_body' => $responseBody
                ]);

                if ($response->status() === 422 && isset($error['errors'])) {
                    foreach ($error['errors'] as $field => $messages) {
                        foreach ($messages as $message) {
                            $this->addError($field, $message);
                        }
                    }
                } else {
                    session()->flash('error', $error['message'] ?? 'Erro ao adicionar resposta.');
                }
            }

        } catch (Exception $e) {
            $this->logError('addReply: Exception capturada', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            session()->flash('error', 'Erro de conexão ao enviar resposta. Tente novamente.');
        } finally {
            $this->sending = false;
        }
    }

    public function markRepliesAsRead()
    {
        $this->hasNewReplies = false;
        $this->newRepliesCount = 0;

        // Remover marcação de "novo" das respostas
        foreach ($this->replies as &$reply) {
            if (isset($reply['is_new'])) {
                unset($reply['is_new']);
            }
        }
    }

    public function dismissNewRepliesAlert()
    {
        $this->markRepliesAsRead();
    }

    public function removeAnexo()
    {
        $this->anexo = null;
    }

    public function downloadAnexo($downloadUrl)
    {
        try {
            $this->logDebug('downloadAnexo: Iniciando download', [
                'url' => $downloadUrl
            ]);

            $response = Http::timeout(30)->get($downloadUrl);

            if ($response->successful()) {
                $fileName = basename(parse_url($downloadUrl, PHP_URL_PATH)) . '_anexo';

                $contentDisposition = $response->header('Content-Disposition');
                if ($contentDisposition && preg_match('/filename="([^"]+)"/', $contentDisposition, $matches)) {
                    $fileName = $matches[1];
                }

                $this->logDebug('downloadAnexo: Download bem-sucedido', [
                    'filename' => $fileName,
                    'size' => strlen($response->body())
                ]);

                return response()->stream(function () use ($response) {
                    echo $response->body();
                }, 200, [
                    'Content-Type' => $response->header('Content-Type') ?? 'application/octet-stream',
                    'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
                    'Content-Length' => strlen($response->body()),
                ]);
            } else {
                $this->logError('downloadAnexo: Falha no download', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                session()->flash('error', 'Erro ao fazer download do arquivo.');
            }
        } catch (Exception $e) {
            $this->logError('downloadAnexo: Exception capturada', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            session()->flash('error', 'Erro de conexão ao fazer download do arquivo.');
        }
    }

    public function render()
    {
        return view('livewire.ticket-replies');
    }
}
