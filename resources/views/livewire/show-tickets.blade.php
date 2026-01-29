<!-- Content -->
<div class="container-fluid flex-grow-1 container-p-y">
    <!-- Basic Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">Início</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.suporte.ticket.index') }}">Tickets</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Detalhes do Ticket {{ $ticket->id ?? 'N/A' }}
            </li>
        </ol>
    </nav>
    <!-- Basic Breadcrumb -->

    @if ($loading)
        <div class="text-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Carregando...</span>
            </div>
        </div>
    @else
        @if ($ticket->status == 'Concluído')
            <div class="alert alert-info" role="alert">
                <i class="icon-base ti tabler-info-circle me-2"></i>
                Este ticket está <strong>Concluído</strong>. Nenhuma alteração pode ser feita.
            </div>
        @endif

        <!-- Layout Principal -->
        <div class="row g-3">
            <!-- Coluna 1 - Conteúdo Principal -->
            <div class="col-8">
                <!-- Card do Ticket -->
                <div class="card mb-3">
                    <div class="card-body">
                        <h4 class="h4 mb-3">{{ $ticket->titulo ?? 'TÍTULO' }}</h4>
                        <div class="text-body" style="text-align: justify;">
                            <p class="mb-0">
                                {!! nl2br(e($ticket->descricao)) ?? 'DESCRIÇÃO' !!}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Seção de Replies -->
                <div class="card">
                    <div class="card-body">
                        @livewire('ticket-replies', ['ticket' => $ticket])
                    </div>
                </div>
            </div>

            <!-- Coluna 2 - Sidebar -->
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <!-- Ticket Infos -->
                        <p class="mb-3">
                            <strong>Enviado por:</strong> {{ $ticket->client_people_name ?? 'Sem Nome' }}
                        </p>
                        <p class="mb-3">
                            <strong>Data de envio:</strong>
                            {{ $ticket->created_at ? $ticket->created_at->format('d/m/Y') : 'N/A' }}
                        </p>
                        <p class="mb-3">
                            <strong>Categoria:</strong> {{ $ticket->modulo ?? ($ticket->módulo ?? 'N/A') }}
                        </p>
                        <p class="mb-3">
                            <strong>Status:</strong>
                            @php
                                $status = $ticket->status ?? 'sem_status';
                                $statusLower = strtolower($status);
                            @endphp

                            @if ($statusLower == 'aberto')
                                <span class="badge bg-label-danger">Aberto</span>
                            @elseif($statusLower == 'em andamento' || $statusLower == 'em_andamento')
                                <span class="badge bg-label-warning">Em Andamento</span>
                            @elseif($statusLower == 'concluído' || $statusLower == 'concluido')
                                <span class="badge bg-label-success">Concluído</span>
                            @else
                                <span class="badge bg-label-secondary">{{ ucfirst($status) }}</span>
                            @endif
                        </p>
                        <!-- /Ticket Infos -->

                        <!-- Anexos -->
                        <div class="accordion mt-4" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#accordionOne" aria-expanded="false"
                                        aria-controls="accordionOne">
                                        <i class="bx bx-file me-2"></i>
                                        Anexos ({{ $anexos->count() }})
                                    </button>
                                </h2>

                                <div id="accordionOne" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        @if ($anexos->isEmpty())
                                            <div class="text-center text-muted py-3">
                                                <i class="bx bx-file me-2"></i>
                                                Nenhum anexo encontrado.
                                            </div>
                                        @else
                                            <div class="table-responsive">
                                                <table class="table table-sm">
                                                    <tbody class="table-border-bottom-0">
                                                        @foreach ($anexos as $anexo)
                                                            <tr>
                                                                <td style="width: 60%;">
                                                                    <div class="d-flex align-items-center">
                                                                        <i class="bx bx-file me-2 text-primary"></i>
                                                                        <div>
                                                                            <div class="fw-medium text-truncate"
                                                                                style="max-width: 150px;"
                                                                                title="{{ $anexo['nome_original'] ?? 'Arquivo sem nome' }}">
                                                                                {{ $anexo['nome_original'] ?? 'Arquivo sem nome' }}
                                                                            </div>
                                                                            <small class="text-muted">
                                                                                @if (isset($anexo['tamanho_bytes']) && $anexo['tamanho_bytes'] > 0)
                                                                                    {{ number_format($anexo['tamanho_bytes'] / 1024 / 1024, 2) }}
                                                                                    MB
                                                                                @else
                                                                                    Tamanho desconhecido
                                                                                @endif
                                                                                @if (isset($anexo['existe']) && $anexo['existe'])
                                                                                    • <span
                                                                                        class="text-success">Disponível</span>
                                                                                @else
                                                                                    • <span class="text-danger">Não
                                                                                        encontrado</span>
                                                                                @endif
                                                                            </small>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td style="width: 40%;">
                                                                    <div class="d-flex gap-1 justify-content-end">
                                                                        @if (isset($anexo['existe']) && $anexo['existe'])
                                                                            <button
                                                                                wire:click="downloadAnexo({{ $anexo['id'] }})"
                                                                                class="btn btn-sm btn-outline-primary"
                                                                                title="Fazer download">
                                                                                <i
                                                                                    class="icon-base ti tabler-download"></i>
                                                                            </button>
                                                                        @else
                                                                            <span
                                                                                class="text-muted small">Indisponível</span>
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Anexos -->
                    </div>
                </div>
            </div>
        </div>
        <!-- /Layout Principal -->
    @endif
</div>
<!--/ Content -->
