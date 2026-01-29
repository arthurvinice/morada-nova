<!-- Table Tickets com Polling -->
<div class="card" wire:poll.1800s="checkForUpdates">
    <div class="col-12 d-flex justify-content-between align-items-start ps-4 pt-3 pb-4">
        <!-- Área de Filtros -->
        <div class="d-flex flex-column align-items-start">
            <!-- Botão de Filtros e indicador -->
            <div class="d-flex align-items-center mb-2">
                <button class="btn btn-secondary btn-sm d-flex align-items-center justify-content-center p-2"
                    data-bs-toggle="offcanvas" data-bs-target="#filtros">
                    <i class="icon-base ti tabler-filter"></i>
                </button>



                <!-- Indicador de filtros ativos -->
                @if ($this->temFiltrosAtivos)
                    <div class="d-flex align-items-center ms-2">
                        <span class="badge bg-primary me-2 py-2 px-3">
                            {{ ($filtroTicketId ? 1 : 0) +
                                ($filtroTitulo ? 1 : 0) +
                                ($filtroModulo ? 1 : 0) +
                                ($filtroStatus ? 1 : 0) +
                                ($filtroPrioridade ? 1 : 0) +
                                ($filtroProtocolo ? 1 : 0) +
                                ($filtroBusca ? 1 : 0) +
                                ($this->temFiltroPeriodoAtivo ? 1 : 0) }}
                            filtro(s) aplicado(s)
                        </span>
                        <button wire:click="limparFiltros" class="btn btn-outline-secondary btn-sm py-2">
                            <i class="icon-base ti tabler-refresh me-1"></i>
                            Limpar todos
                        </button>
                    </div>
                @endif
            </div>

            <!-- Tags dos Filtros Aplicados -->
            <div class="d-flex flex-wrap gap-1 mt-2">
                <!-- Filtro de Período -->
                @if ($this->temFiltroPeriodoAtivo)
                    <span class="badge bg-info d-flex align-items-center py-1 px-2">
                        <i class="icon-base ti tabler-calendar me-1" style="font-size: 0.7rem;"></i>
                        <small>{{ \Carbon\Carbon::parse($filtroDataInicio)->format('d/m') }} -
                            {{ \Carbon\Carbon::parse($filtroDataFim)->format('d/m') }}</small>
                        <button wire:click="removerFiltroPeriodo" class="btn-close btn-close-white ms-1"
                            style="font-size: 0.5rem;" title="Remover filtro de período"></button>
                    </span>
                @endif

                <!-- Filtro de ID do Ticket -->
                @if ($filtroTicketId)
                    <span class="badge bg-primary d-flex align-items-center py-1 px-2">
                        <i class="icon-base ti tabler-hash me-1" style="font-size: 0.7rem;"></i>
                        <small>ID: {{ $filtroTicketId }}</small>
                        <button wire:click="removerFiltroTicketId" class="btn-close btn-close-white ms-1"
                            style="font-size: 0.5rem;" title="Remover filtro de ID"></button>
                    </span>
                @endif

                <!-- Filtro de Título -->
                @if ($filtroTitulo)
                    <span class="badge bg-secondary d-flex align-items-center py-1 px-2">
                        <i class="icon-base ti tabler-file-text me-1" style="font-size: 0.7rem;"></i>
                        <small>{{ Str::limit($filtroTitulo, 15) }}</small>
                        <button wire:click="removerFiltroTitulo" class="btn-close btn-close-white ms-1"
                            style="font-size: 0.5rem;" title="Remover filtro de título"></button>
                    </span>
                @endif

                <!-- Filtro de Módulo -->
                @if ($filtroModulo)
                    <span class="badge bg-success d-flex align-items-center py-1 px-2">
                        <i class="icon-base ti tabler-folder me-1" style="font-size: 0.7rem;"></i>
                        <small>{{ $filtroModulo }}</small>
                        <button wire:click="removerFiltroModulo" class="btn-close btn-close-white ms-1"
                            style="font-size: 0.5rem;" title="Remover filtro de módulo"></button>
                    </span>
                @endif

                <!-- Filtro de Status -->
                @if ($filtroStatus)
                    <span class="badge bg-warning d-flex align-items-center py-1 px-2">
                        <i class="icon-base ti tabler-flag me-1" style="font-size: 0.7rem;"></i>
                        <small>{{ $filtroStatus }}</small>
                        <button wire:click="removerFiltroStatus" class="btn-close btn-close-white ms-1"
                            style="font-size: 0.5rem;" title="Remover filtro de status"></button>
                    </span>
                @endif

                <!-- Filtro de Protocolo -->
                @if ($filtroProtocolo)
                    <span class="badge bg-dark d-flex align-items-center py-1 px-2">
                        <i class="icon-base ti tabler-barcode me-1" style="font-size: 0.7rem;"></i>
                        <small>Protocolo: {{ $filtroProtocolo }}</small>
                        <button wire:click="removerFiltroProtocolo" class="btn-close btn-close-white ms-1"
                            style="font-size: 0.5rem;" title="Remover filtro de protocolo"></button>
                    </span>
                @endif

                <!-- Filtro de Busca -->
                @if ($filtroBusca)
                    <span class="badge bg-secondary d-flex align-items-center py-1 px-2">
                        <i class="icon-base ti tabler-search me-1" style="font-size: 0.7rem;"></i>
                        <small>"{{ Str::limit($filtroBusca, 12) }}"</small>
                        <button wire:click="removerFiltroBusca" class="btn-close btn-close-white ms-1"
                            style="font-size: 0.5rem;" title="Remover filtro de busca"></button>
                    </span>
                @endif
            </div>
        </div>

        <!-- Campo de busca rápida e botão novo ticket -->
        <div class="d-flex align-items-center gap-2">
            <div class="col-md-6" style="min-width: 300px;">
                <div class="input-group">
                    <input wire:model.live.debounce.500ms="filtroBusca" type="text" class="form-control"
                        placeholder="Buscar por ID, título ou usuário.." value="{{ $filtroBusca }}">
                    <span class="input-group-text">
                        <i class="icon-base ti tabler-search"></i>
                    </span>
                </div>
            </div>
            <a href="{{ route('admin.suporte.ticket.create') }}" class="btn btn-primary px-3 waves-effect waves-light me-3"
                role="button">
                <i class="menu-icon icon-base ti tabler-library-plus me-1"></i> Novo Ticket
            </a>
        </div>
    </div>

    {{-- Alerta de tickets atualizados --}}
    {{-- @if ($hasUpdates && $updatedTicketsCount > 0)
        <div class="mx-4 mb-3">
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="icon-base ti tabler-bell-ringing me-2"></i>
                <strong>{{ $updatedTicketsCount }} ticket(s) foi(ram) atualizado(s)!</strong>
                <small class="ms-2">Verifique as mudanças de status.</small>
                <button type="button" wire:click="markUpdatesAsRead" class="btn btn-sm btn-outline-info ms-2">
                    Marcar como visto
                </button>
                <button type="button" class="btn-close" wire:click="dismissUpdatesAlert" aria-label="Close"></button>
            </div>
        </div>
    @endif --}}

    {{-- Indicador discreto de verificação --}}
    @if ($checkingUpdates)
        <div class="text-center mb-2">
            <small class="text-muted">
                <span class="spinner-border spinner-border-sm me-1"></span>
                Verificando atualizações...
            </small>
        </div>
    @endif

    <!-- Loading indicator -->
    <div wire:loading wire:target="loadTickets,aplicarFiltro,limparFiltros" class="text-center py-3">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Carregando...</span>
        </div>
        <span class="ms-2">Carregando tickets...</span>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead>
                <tr class="text-nowrap">
                    <th>#ID</th>
                    <th class="ps-1">Título</th>
                    <th>Módulo</th>
                    <th>Cliente</th>
                    <th>Usuário</th>
                    <th>Data</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($tickets as $ticket)
                    <tr
                        class="{{ (isset($ticket->is_new) && $ticket->is_new) || (isset($ticket->is_updated) && $ticket->is_updated) ? 'table-success' : '' }}">
                        <td class="pe-2">
                            <div class="d-flex align-items-center">
                                <a href="{{ route('admin.suporte.ticket.show', $ticket->uuid) }}" title="Visualizar">
                                    #{{ $ticket->id }}
                                </a>
                                @if (isset($ticket->is_new) && $ticket->is_new)
                                    <span class="ms-2 animate-pulse">
                                        <i class="icon-base ti tabler-sparkles"></i>
                                    </span>
                                @elseif(isset($ticket->is_updated) && $ticket->is_updated)
                                    <span class="ms-2 animate-pulse">
                                        <i class="icon-base ti tabler-exclamation-circle"></i>
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="ps-1">
                            <a href="{{ route('admin.suporte.ticket.show', $ticket->uuid) }}" title="Visualizar">
                                {{ $ticket->titulo ?? 'Sem título' }}
                            </a>
                        </td>
                        <td>{{ $ticket->módulo ?? 'Geral' }}</td>
                        <td>{{ $configuration->nome_fantasia ?? 'Sem cliente' }}</td>
                        <td>{{ $ticket->client_people_name ?? 'Sem usuário' }}</td>
                        <td>{{ \Carbon\Carbon::parse($ticket->created_at)->format('d/m/Y H:i') }}</td>
                        <td>
                            @if ($ticket->status === 'Aberto')
                                <span class="badge bg-label-danger me-1">Aberto</span>
                            @elseif ($ticket->status === 'Em Andamento')
                                <span class="badge bg-label-warning me-1">Em Andamento</span>
                            @elseif ($ticket->status === 'Concluído')
                                <span class="badge bg-label-success me-1">Concluído</span>
                            @else
                                <span class="badge bg-label-info me-1">{{ ucfirst($ticket->status) }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <button wire:click="showTicket('{{ $ticket->uuid }}')"
                                    class="btn btn-sm btn-outline-info" title="Visualizar">
                                    <i class="icon-base ti tabler-eye"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <div class="empty-state">
                                <i class="icon-base ti tabler-inbox mb-2" style="font-size: 2rem;"></i>
                                <p class="mb-0">Nenhum ticket encontrado.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Status de atualização automática -->
        <div class="d-flex align-items-center justify-content-end mx-4 my-4">
            {{-- <span class="badge bg-success me-2">
                        <i class="icon-base ti tabler-refresh"></i>
                        Atualização automática
                    </span> --}}
            @if ($lastUpdated)
            <i class="icon-base ti tabler-refresh me-1" ></i>
                <small class="text-muted">
                    Última atualização:
                    {{ \Carbon\Carbon::parse($lastUpdated)->setTimezone('America/Sao_Paulo')->format('H:i:s') }}
                </small>
            @endif
        </div>

    </div>

    {{-- ******* MODAL ******* --}}

    <!-- MODAL PARA FILTROS -->
    <div class="offcanvas offcanvas-start" id="filtros" aria-hidden="true">
        <div class="offcanvas-header mb-6 border-bottom">
            <h5 class="offcanvas-title">
                <i class="icon-base ti tabler-filter me-2"></i>Filtros
            </h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>

        <div class="offcanvas-body pt-0 flex-grow-1">
            <!-- Período -->
            <div class="mb-4">
                <h6 class="text-muted mb-3">Período</h6>
                <div class="row">
                    <div class="col-6">
                        <label for="filtroDataInicio" class="form-label">Data Início</label>
                        <input wire:model.live="filtroDataInicio" class="form-control" type="date"
                            id="filtroDataInicio">
                    </div>
                    <div class="col-6">
                        <label for="filtroDataFim" class="form-label">Data Fim</label>
                        <input wire:model.live="filtroDataFim" class="form-control" type="date"
                            id="filtroDataFim">
                    </div>
                </div>
            </div>

            <!-- Módulo -->
            <div class="mb-4">
                <label for="filtroModulo" class="form-label">Módulo</label>
                <select wire:model.live="filtroModulo" id="filtroModulo" class="form-select">
                    <option value="">Todos os módulos</option>
                    <option value="Categoria">Categoria</option>
                    <option value="Agendamento">Agendamento</option>
                    <option value="Demanda">Demanda</option>
                </select>
            </div>

            <!-- Status -->
            <div class="mb-4">
                <label for="filtroStatus" class="form-label">Status</label>
                <select wire:model.live="filtroStatus" id="filtroStatus" class="form-select">
                    <option value="">Todos os status</option>
                    <option value="Aberto">Aberto</option>
                    <option value="Em Andamento">Em Andamento</option>
                    <option value="Concluído">Concluído</option>
                </select>
            </div>

            <!-- Filtros Rápidos -->
            <div class="mb-4">
                <h6 class="text-muted mb-3">Filtros Rápidos</h6>
                <div class="d-flex flex-wrap gap-2">
                    <button wire:click="aplicarFiltro('hoje')" class="btn btn-sm btn-outline-primary">
                        Hoje
                    </button>
                    <button wire:click="aplicarFiltro('semana')" class="btn btn-sm btn-outline-primary">
                        Esta semana
                    </button>
                    <button wire:click="aplicarFiltro('mes')" class="btn btn-sm btn-outline-primary">
                        Este mês
                    </button>
                    <button wire:click="aplicarFiltro('abertos')" class="btn btn-sm btn-outline-danger">
                        Apenas abertos
                    </button>
                </div>
            </div>

            <!-- Botões de ação -->
            <div class="d-flex justify-content-center mt-4">
                <button wire:click="limparFiltros" class="btn btn-outline-secondary">
                    <i class="icon-base ti tabler-refresh me-1"></i>
                    Limpar filtros
                </button>
            </div>
        </div>
    </div>

    <style>
        .empty-state {
            padding: 2rem;
            color: var(--bs-gray-500);
        }

        .table-responsive {
            min-height: 160px;
        }

        /* Estilo personalizado para os filtros */
        .badge {
            font-size: 0.85rem;
            padding: 0.5rem 0.75rem;
        }

        .btn-close-white {
            filter: invert(1) grayscale(100%) brightness(200%);
        }

        .btn-close:hover {
            opacity: 0.8;
        }

        /* Animação para os badges e linhas atualizadas */
        .badge,
        .table-success {
            transition: all 0.2s ease;
        }

        .badge:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .5;
            }
        }

        /* Destaque para tickets atualizados */
        .table-success {
            background-color: rgba(25, 135, 84, 0.1) !important;
        }
    </style>
</div>
