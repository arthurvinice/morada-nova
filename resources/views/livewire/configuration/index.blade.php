<div>
    @include('_inc.alerts')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <nav aria-label="breadcrumb" class="mb-0">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Início</a></li>
                <li class="breadcrumb-item active">Configurações</li>
            </ol>
        </nav>

        <a href="{{ route('admin.configurations.create') }}"
            class="btn btn-primary btn-lg flex-shrink-0 d-flex align-items-center justify-content-center p-2"
            role="button" title="Nova configuração">
            <i class="tf-icons ti tabler-plus"></i>
        </a>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Configurações</h5>
            <div class="text-muted fs-6">
                <div class="d-flex align-items-center gap-3">
                    <div class="position-relative" style="width: 300px;">
                        <input type="text" class="form-control" placeholder="Buscar por nome..."
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
                        <option value="active">Ativa</option>
                        <option value="inactive">Inativa</option>
                    </select>

                    <button wire:click="limparFiltros"
                        class="btn btn-outline-secondary btn-lg flex-shrink-0 d-flex align-items-center justify-content-center p-2"
                        title="Resetar filtros">
                        <i class="tf-icons ti tabler-refresh" wire:loading.class="tabler-spin" wire:target="limparFiltros"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Nome</th>
                        <th>Status</th>
                        <th>Usuários</th>
                        <th>Imóveis</th>
                        <th>Inquilinos</th>
                        <th>Contratos</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($configurations as $configuration)
                        <tr>
                            <td>#{{ $configuration->id }}</td>
                            <td>{{ $configuration->name }}</td>
                            <td>
                                @if ($configuration->status === 'active')
                                    <span class="badge bg-label-success me-1">Ativa</span>
                                @else
                                    <span class="badge bg-label-secondary me-1">Inativa</span>
                                @endif
                            </td>
                            <td>{{ $configuration->users_count }}</td>
                            <td>{{ $configuration->properties_count }}</td>
                            <td>{{ $configuration->people_count }}</td>
                            <td>{{ $configuration->contracts_count }}</td>
                            <td>
                                <a class="btn rounded-pill btn-outline-secondary waves-effect btn-sm"
                                    href="{{ route('admin.configurations.edit', $configuration->uuid) }}">
                                    <i class="icon-base ti tabler-pencil">Editar</i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Nenhuma configuração encontrada</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-12 pt-5">
                <div class="float-end px-5">
                    {{ $configurations->links() }}
                </div>
            </div>
        </div>
    </div>
</div>