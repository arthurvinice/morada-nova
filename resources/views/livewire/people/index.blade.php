<div>
    @include('_inc.alerts')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <nav aria-label="breadcrumb" class="mb-0">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Início</a></li>
                <li class="breadcrumb-item active">Inquilinos</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Inquilinos</h5>
            <div class="text-muted fs-6">
                <div class="d-flex align-items-center gap-3">
                    <div class="position-relative" style="width: 350px;">
                        <input type="text" class="form-control" placeholder="Buscar por nome ou CPF do cliente..."
                            wire:model.live.debounce.500ms="busca" style="padding-right: 2.5rem;">
                        @if ($busca)
                            <span class="position-absolute top-50 translate-middle-y"
                                style="right: 10px; cursor: pointer; z-index: 10;" wire:click="$set('busca', '')">
                                <i class="ti ti-x"></i>
                            </span>
                        @endif
                    </div>

                    <select class="form-select" wire:model.live="filtroCidade" style="width: 180px;">
                        <option value="">Cidade</option>
                        @foreach ($cidades as $cidade)
                            <option value="{{ $cidade }}">{{ $cidade }}</option>
                        @endforeach
                    </select>

                    <button wire:click="limparFiltros"
                        class="btn btn-outline-secondary btn-lg flex-shrink-0 d-flex align-items-center justify-content-center p-2"
                        title="Resetar filtros">
                        <i class="tf-icons ti tabler-refresh" wire:loading.class="tabler-spin" wire:target="limparFiltros"></i>
                    </button>

                    <a href="{{ route('admin.people.create') }}"
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
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Telefone</th>
                        <th>Imóvel</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($people as $person)
                        <tr>
                            <td>#{{ $person->id }}</td>
                            <td>{{ $person->name }}</td>
                            <td>{{ $person->cpf }}</td>
                            <td>{{ $person->phone }}</td>
                            <td>
                                @if ($person->activeContract && $person->activeContract->property)
                                    {{ $person->activeContract->property->nickname ?: $person->activeContract->property->street . ', ' . $person->activeContract->property->number }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <a class="btn rounded-pill btn-outline-secondary waves-effect btn-sm"
                                    href="{{ route('admin.people.edit', $person) }}">
                                    <i class="icon-base ti tabler-pencil">Editar</i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Nenhum inquilino encontrado</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-12 pt-5">
                <div class="float-end px-5">
                    {{ $people->links() }}
                </div>
            </div>
        </div>
    </div>
</div>