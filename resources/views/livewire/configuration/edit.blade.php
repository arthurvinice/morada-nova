<div>
    @include('_inc.alerts')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <nav aria-label="breadcrumb" class="mb-0">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Início</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.configurations.index') }}">Configurações</a></li>
                <li class="breadcrumb-item active">Editar Configuração</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Editar Configuração</h5>
        </div>

        <div class="card-body">
            <form wire:submit="update">
                <div class="row">
                    <div class="mb-3 col-md-8">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" id="name" class="form-control @error('name') is-invalid @enderror"
                            wire:model="name" autofocus>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3 col-md-4">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" class="form-select @error('status') is-invalid @enderror" wire:model="status">
                            <option value="active">Ativa</option>
                            <option value="inactive">Inativa</option>
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mt-2">
                    <button type="submit" class="btn btn-primary me-2" wire:loading.attr="disabled" wire:target="update">
                        <span wire:loading wire:target="update" class="spinner-border spinner-border-sm me-1"></span>
                        Atualizar
                    </button>
                    <a href="{{ route('admin.configurations.index') }}" class="btn btn-label-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-info mt-4">
        <div class="card-header bg-label-info">
            <h6 class="mb-0"><i class="icon-base ti tabler-building me-1"></i> Resumo desta configuração</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p class="text-muted mb-1">Usuários vinculados</p>
                    <p class="fw-medium mb-0">{{ $usersCount }}</p>
                </div>
                <div class="col-md-6">
                    <p class="text-muted mb-1">Imóveis cadastrados</p>
                    <p class="fw-medium mb-0">{{ $propertiesCount }}</p>
                </div>
            </div>
        </div>
    </div>
</div>