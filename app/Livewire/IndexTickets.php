<?php

namespace App\Livewire;

use App\Models\Configuration;
use Exception;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class IndexTickets extends Component
{
    public $tickets = [];
    public $loading = false;
    public $configuration = [];
    public $checkingUpdates = false;
    public $lastUpdated = null;
    public $hasUpdates = false;
    public $updatedTicketsCount = 0;
    public $lastKnownTicketData = [];

    // Propriedades públicas para os filtros
    public $filtroDataInicio = '';
    public $filtroDataFim = '';
    public $filtroTicketId = '';
    public $filtroTitulo = '';
    public $filtroModulo = '';
    public $filtroStatus = '';
    public $filtroPrioridade = '';
    public $filtroProtocolo = '';
    public $filtroBusca = '';

    public function mount()
    {
        $this->configuration = Configuration::first();

        // Define filtro padrão para últimos 30 dias
        $this->filtroDataInicio = now()->subDays(30)->format('Y-m-d');
        $this->filtroDataFim = now()->format('Y-m-d');

        // Carregar dados do cache
        $this->loadCacheData();

        $this->loadTickets();
    }

    public function updated($name, $value)
    {
        // Automaticamente recarrega quando qualquer filtro é atualizado
        if (str_starts_with($name, 'filtro')) {
            $this->loadTickets();
        }
    }

    private function loadCacheData()
    {
        $config_id = $this->configuration->custom_client_id ?? null;
        if (!$config_id) return;

        $cacheKey = "tickets_data_{$config_id}";
        $this->lastKnownTicketData = Cache::get($cacheKey, []);
    }

    private function saveCacheData($tickets)
    {
        $config_id = $this->configuration->custom_client_id ?? null;
        if (!$config_id) return;

        $cacheKey = "tickets_data_{$config_id}";

        // Criar hash dos dados relevantes para detecção de mudanças
        $ticketData = [];
        foreach ($tickets as $ticket) {
            $ticketData[$ticket->id] = [
                'status' => $ticket->status,
                'prioridade' => $ticket->prioridade,
                'titulo' => $ticket->titulo,
                'updated_at' => $ticket->updated_at ?? $ticket->created_at
            ];
        }

        Cache::put($cacheKey, $ticketData, now()->addHours(24));
        $this->lastKnownTicketData = $ticketData;
    }

    /**
     * Método para verificação automática de mudanças sem interferir nos filtros
     */
    public function checkForUpdates()
    {
        // Se está aplicando filtros manualmente, não verificar
        if ($this->loading) {
            return;
        }

        $this->checkingUpdates = true;

        try {
            $config_id = $this->configuration->custom_client_id ?? null;

            if (!$config_id) {
                return;
            }

            // Usar o mesmo endpoint que está sendo usado na loadTickets
            if ($this->temFiltrosAtivos) {
                $newTickets = $this->fetchFilteredTickets();
            } else {
                $response = Http::timeout(10)->get(env('ENDPOINT_API_TICKET') . '/api/suporte/tickets', [
                    'custom_client_id' => $config_id
                ]);

                if (!$response->successful()) {
                    return;
                }

                $newTickets = collect(json_decode($response->body()));
            }

            // Detectar mudanças
            $this->detectChanges($newTickets);

            // Atualizar dados se há mudanças
            if ($this->hasUpdates) {
                $this->tickets = $newTickets;
                $this->saveCacheData($newTickets);
                $this->lastUpdated = now()->setTimezone('America/Sao_Paulo')->toISOString();
            } else {
                // Apenas atualizar timestamp
                $this->lastUpdated = now()->setTimezone('America/Sao_Paulo')->toISOString();
            }

        } catch (Exception $e) {
            // Falha silenciosa na verificação automática
            logger('Erro na verificação automática de tickets: ' . $e->getMessage());
        } finally {
            $this->checkingUpdates = false;
        }
    }

    private function fetchFilteredTickets()
    {
        $config_id = $this->configuration->custom_client_id ?? null;
        $params = ['custom_client_id' => $config_id];

        // Adicionar filtros ativos aos parâmetros
        if (!empty($this->filtroModulo)) {
            $params['modulo'] = $this->filtroModulo;
        }
        if (!empty($this->filtroStatus)) {
            $params['status'] = $this->filtroStatus;
        }
        if (!empty($this->filtroPrioridade)) {
            $params['prioridade'] = $this->filtroPrioridade;
        }
        if (!empty($this->filtroProtocolo)) {
            $params['protocolo'] = $this->filtroProtocolo;
        }
        if (!empty($this->filtroDataInicio)) {
            $params['data_inicio'] = $this->filtroDataInicio;
        }
        if (!empty($this->filtroDataFim)) {
            $params['data_fim'] = $this->filtroDataFim;
        }
        if (!empty($this->filtroBusca)) {
            $params['busca_geral'] = $this->filtroBusca;
        }

        $response = Http::timeout(10)->get(env('ENDPOINT_API_TICKET') . '/api/suporte/tickets/filtered/search', $params);

        if (!$response->successful()) {
            return collect();
        }

        return collect(json_decode($response->body()));
    }

    private function detectChanges($newTickets)
    {
        $this->hasUpdates = false;
        $this->updatedTicketsCount = 0;

        if (empty($this->lastKnownTicketData)) {
            // Primeira carga, considerar como atualização
            $this->hasUpdates = count($newTickets) > 0;
            return;
        }

        $updatedTickets = [];

        foreach ($newTickets as $ticket) {
            $ticketId = $ticket->id;

            if (!isset($this->lastKnownTicketData[$ticketId])) {
                // Ticket novo
                $updatedTickets[] = $ticketId;
                $ticket->is_new = true;
            } else {
                $oldData = $this->lastKnownTicketData[$ticketId];

                // Verificar se houve mudanças nos campos relevantes
                if ($oldData['status'] !== $ticket->status ||
                    $oldData['prioridade'] !== $ticket->prioridade ||
                    $oldData['titulo'] !== $ticket->titulo) {

                    $updatedTickets[] = $ticketId;
                    $ticket->is_updated = true;
                }
            }
        }

        if (!empty($updatedTickets)) {
            $this->hasUpdates = true;
            $this->updatedTicketsCount = count($updatedTickets);
        }
    }

    public function loadTickets()
    {
        try {
            $this->loading = true;

            $config_id = $this->configuration->custom_client_id ?? null;

            if (!$config_id) {
                $this->tickets = collect();
                logger('Sem configuration ID encontrado');
                return;
            }

            // Se há filtros ativos, usar endpoint de filtros, senão usar endpoint padrão
            if ($this->temFiltrosAtivos) {
                $this->aplicarFiltrosAPI();
            } else {
                $response = Http::timeout(10)->get(env('ENDPOINT_API_TICKET') . '/api/suporte/tickets', [
                    'custom_client_id' => $config_id
                ]);

                if ($response->successful()) {
                    $this->tickets = collect(json_decode($response->body()));
                    $this->saveCacheData($this->tickets);
                    $this->lastUpdated = now()->setTimezone('America/Sao_Paulo')->toISOString();
                    logger('Tickets carregados sem filtros: ' . $this->tickets->count());
                } else {
                    $this->tickets = collect();
                    session()->flash('error', 'Erro ao carregar tickets');
                    logger('Erro na resposta da API: ' . $response->status());
                }
            }
        } catch (Exception $e) {
            $this->tickets = collect();
            session()->flash('error', 'Erro de conexão com a API');
            logger('Exceção ao carregar tickets: ' . $e->getMessage());
        } finally {
            $this->loading = false;
        }
    }

    private function aplicarFiltrosAPI()
    {
        try {
            $config_id = $this->configuration->custom_client_id ?? null;

            $params = ['custom_client_id' => $config_id];

            // Adicionar filtros ativos aos parâmetros
            if (!empty($this->filtroModulo)) {
                $params['modulo'] = $this->filtroModulo;
            }

            if (!empty($this->filtroStatus)) {
                $params['status'] = $this->filtroStatus;
            }

            if (!empty($this->filtroPrioridade)) {
                $params['prioridade'] = $this->filtroPrioridade;
            }

            if (!empty($this->filtroProtocolo)) {
                $params['protocolo'] = $this->filtroProtocolo;
            }

            if (!empty($this->filtroDataInicio)) {
                $params['data_inicio'] = $this->filtroDataInicio;
            }

            if (!empty($this->filtroDataFim)) {
                $params['data_fim'] = $this->filtroDataFim;
            }

            // Filtro de busca geral
            if (!empty($this->filtroBusca)) {
                $params['busca_geral'] = $this->filtroBusca;
            }

            logger('Enviando parâmetros para API de filtros:', $params);

            $response = Http::timeout(10)->get(env('ENDPOINT_API_TICKET') . '/api/suporte/tickets/filtered/search', $params);

            if ($response->successful()) {
                $this->tickets = collect(json_decode($response->body()));
                $this->saveCacheData($this->tickets);
                $this->lastUpdated = now()->setTimezone('America/Sao_Paulo')->toISOString();
                logger('Tickets filtrados carregados: ' . $this->tickets->count());
            } else {
                $this->tickets = collect();
                session()->flash('error', 'Erro ao aplicar filtros');
                logger('Erro ao aplicar filtros na API: ' . $response->status());
            }
        } catch (Exception $e) {
            $this->tickets = collect();
            session()->flash('error', 'Erro de conexão com a API ao filtrar');
            logger('Exceção ao aplicar filtros: ' . $e->getMessage());
        }
    }

    public function markUpdatesAsRead()
    {
        $this->hasUpdates = false;
        $this->updatedTicketsCount = 0;

        // Remover marcações de novos/atualizados
        foreach ($this->tickets as $ticket) {
            if (isset($ticket->is_new)) {
                unset($ticket->is_new);
            }
            if (isset($ticket->is_updated)) {
                unset($ticket->is_updated);
            }
        }
    }

    public function dismissUpdatesAlert()
    {
        $this->markUpdatesAsRead();
    }

    // Resto dos métodos permanecem iguais...
    public function limparFiltros()
    {
        $this->filtroDataInicio = now()->subDays(30)->format('Y-m-d');
        $this->filtroDataFim = now()->format('Y-m-d');
        $this->filtroTicketId = '';
        $this->filtroTitulo = '';
        $this->filtroModulo = '';
        $this->filtroStatus = '';
        $this->filtroPrioridade = '';
        $this->filtroProtocolo = '';
        $this->filtroBusca = '';

        $this->loadTickets();
    }

    // Métodos para remover filtros individuais
    public function removerFiltroTicketId()
    {
        $this->filtroTicketId = '';
        $this->loadTickets();
    }

    public function removerFiltroTitulo()
    {
        $this->filtroTitulo = '';
        $this->loadTickets();
    }

    public function removerFiltroModulo()
    {
        $this->filtroModulo = '';
        $this->loadTickets();
    }

    public function removerFiltroStatus()
    {
        $this->filtroStatus = '';
        $this->loadTickets();
    }

    public function removerFiltroPrioridade()
    {
        $this->filtroPrioridade = '';
        $this->loadTickets();
    }

    public function removerFiltroProtocolo()
    {
        $this->filtroProtocolo = '';
        $this->loadTickets();
    }

    public function removerFiltroBusca()
    {
        $this->filtroBusca = '';
        $this->loadTickets();
    }

    public function removerFiltroPeriodo()
    {
        $this->filtroDataInicio = now()->subDays(30)->format('Y-m-d');
        $this->filtroDataFim = now()->format('Y-m-d');
        $this->loadTickets();
    }

    // Filtros rápidos
    public function aplicarFiltro($tipo)
    {
        $hoje = now();

        switch($tipo) {
            case 'hoje':
                $this->filtroDataInicio = $hoje->format('Y-m-d');
                $this->filtroDataFim = $hoje->format('Y-m-d');
                break;

            case 'semana':
                $inicioSemana = $hoje->copy()->startOfWeek();
                $this->filtroDataInicio = $inicioSemana->format('Y-m-d');
                $this->filtroDataFim = $hoje->format('Y-m-d');
                break;

            case 'mes':
                $inicioMes = $hoje->copy()->startOfMonth();
                $this->filtroDataInicio = $inicioMes->format('Y-m-d');
                $this->filtroDataFim = $hoje->format('Y-m-d');
                break;

            case 'abertos':
                $this->filtroStatus = 'Aberto';
                break;

            case 'alta_prioridade':
                $this->filtroPrioridade = 'Alta';
                break;
        }

        // Força o reload após aplicar filtro rápido
        $this->loadTickets();
    }

    // Computed properties
    public function getTemFiltrosAtivosProperty()
    {
        return !empty($this->filtroTicketId) ||
               !empty($this->filtroTitulo) ||
               !empty($this->filtroModulo) ||
               !empty($this->filtroStatus) ||
               !empty($this->filtroPrioridade) ||
               !empty($this->filtroProtocolo) ||
               !empty($this->filtroBusca) ||
               $this->temFiltroPeriodoAtivo;
    }

    public function getTemFiltroPeriodoAtivoProperty()
    {
        $padrao30Dias = now()->subDays(30)->format('Y-m-d');
        $padraoHoje = now()->format('Y-m-d');

        return $this->filtroDataInicio !== $padrao30Dias || $this->filtroDataFim !== $padraoHoje;
    }

    public function showTicket($uuid)
    {
        return redirect()->route('admin.suporte.ticket.show', ['uuid' => $uuid]);
    }

    public function render()
    {
        return view('livewire.index-tickets');
    }
}
