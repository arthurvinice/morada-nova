<div>
    @include('_inc.alerts')

    <div class="d-flex justify-content-between align-items-center mb-4">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-0">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">Início</a>
                </li>
                <li class="breadcrumb-item active">Usuários</li>
            </ol>
        </nav>

        <!-- Botão Adicionar Usuário -->
        <a href="{{ route('admin.user.create') }}"
            class="btn btn-primary px-2 waves-effect waves-light"
            role="button">
            <i class="menu-icon icon-base ti tabler-library-plus"></i>
            Novo Usuário
        </a>

    </div>


    <!-- Basic Bootstrap Table -->
    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Clientes</h5>
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

                    <button
                        class="btn btn-secondary btn-lg flex-shrink-0 d-flex align-items-center justify-content-center p-2"
                        data-bs-toggle="offcanvas" data-bs-target="#filtros">
                        <i class="tf-icons ti ti-filter"></i>
                    </button>
                    <button wire:click="limparFiltros"
                        class="btn btn-outline-secondary btn-lg flex-shrink-0 d-flex align-items-center justify-content-center p-2"
                        title="Atualizar">
                        <i class="tf-icons ti ti-refresh" wire:loading.class="ti-spin" wire:target="limparFiltros"></i>
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
                        <th>Nível</th>
                        <th>Situação</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">

                    @foreach ($users as $user)

                    <tr>
                        <td>#{{ $user->id }}</td>

                        <td>{{ $user->name }}</td>

                        <td><span class="badge bg-label-success me-1">{{ $user->role}}</span></td>

                        <td>

                            @if (!$user->status)
                            <span class="badge bg-label-danger me-1">Inativo</span>
                            @else
                            <span class="badge bg-label-success me-1">Ativo</span>
                            @endif

                        </td>

                        <td>
                            <div class="w-100">
                                <a class="btn rounded-pill btn-outline-secondary waves-effect btn-sm" href="{{route('admin.user.edit', $user->id)}}">
                                    <i class="icon-base ti tabler-pencil ">Editar</i>
                                </a>
                            </div>
                        </td>
                    </tr>

                    @endforeach

                </tbody>
            </table>


        </div>

        <div class="row">
            <div class="col-12 pt-5">
                <div class="float-end px-5">
                    {{ $users->links() }}
                </div>
            </div>
        </div>

    </div>
    <!-- Basic Bootstrap Table -->


</div>