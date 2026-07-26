<div>
    @include('_inc.alerts')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <nav aria-label="breadcrumb" class="mb-0">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Início</a></li>
                <li class="breadcrumb-item active">Contratos</li>
            </ol>
        </nav>


    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Contratos</h5>
            <div class="text-muted fs-6">
                <div class="d-flex align-items-center gap-3">
                    <div class="position-relative" style="width: 320px;">
                        <input type="text" class="form-control" placeholder="Buscar por nome ou CPF do inquilino..."
                            wire:model.live.debounce.500ms="busca" style="padding-right: 2.5rem;">
                        @if ($busca)
                        <span class="position-absolute top-50 translate-middle-y"
                            style="right: 10px; cursor: pointer; z-index: 10;" wire:click="$set('busca', '')">
                            <i class="ti ti-x"></i>
                        </span>
                        @endif
                    </div>

                    <select class="form-select" wire:model.live="filtroStatus" style="width: 160px;">
                        <option value="">Status</option>
                        <option value="active">Ativo</option>
                        <option value="finished">Encerrado</option>
                        <option value="cancelled">Cancelado</option>
                    </select>

                    <button wire:click="limparFiltros"
                        class="btn btn-outline-secondary btn-lg flex-shrink-0 d-flex align-items-center justify-content-center p-2"
                        title="Resetar filtros">
                        <i class="tf-icons ti tabler-refresh" wire:loading.class="tabler-spin" wire:target="limparFiltros"></i>
                    </button>
                    <a href="{{ route('admin.contracts.create') }}"
                        class="btn btn-primary btn-lg flex-shrink-0 d-flex align-items-center justify-content-center p-2"
                        role="button">
                        <i class="tf-icons ti tabler-plus"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Imóvel</th>
                        <th>Inquilino</th>
                        <th>Início</th>
                        <th>Término</th>
                        <th>Valor</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($contracts as $contract)
                    <tr>
                        <td>#{{ $contract->id }}</td>
                        <td>{{ $contract->property->nickname ?: $contract->property->street . ', ' . $contract->property->number }}</td>
                        <td>{{ $contract->people->name }}</td>
                        <td>{{ $contract->start_date->format('d/m/Y') }}</td>
                        <td>{{ $contract->end_date?->format('d/m/Y') ?? '-' }}</td>
                        <td>R$ {{ number_format($contract->rent_value, 2, ',', '.') }}</td>
                        <td>
                            @if ($contract->status === 'active')
                            <span class="badge bg-label-success me-1">Ativo</span>
                            @elseif ($contract->status === 'finished')
                            <span class="badge bg-label-secondary me-1">Encerrado</span>
                            @else
                            <span class="badge bg-label-danger me-1">Cancelado</span>
                            @endif
                        </td>
                        <td>
                            <a class="btn rounded-pill btn-outline-secondary waves-effect btn-sm"
                                href="{{ route('admin.contracts.edit', $contract->id) }}">
                                <i class="icon-base ti tabler-pencil">Editar</i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Nenhum contrato encontrado</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-12 pt-5">
                <div class="float-end px-5">
                    {{ $contracts->links() }}
                </div>
            </div>
        </div>
    </div>
</div>