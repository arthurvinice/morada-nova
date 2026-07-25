<div>
    @include('_inc.alerts')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <nav aria-label="breadcrumb" class="mb-0">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Início</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">Usuários</a></li>
                <li class="breadcrumb-item active">Editar Usuário</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Editar Usuário</h5>
        </div>

        <div class="card-body">
            <form wire:submit="update">
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" id="name" class="form-control @error('name') is-invalid @enderror"
                            wire:model="name" autofocus>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3 col-md-6" x-data="{ cpf: @entangle('cpf') }">
                        <label for="cpf" class="form-label">CPF</label>
                        <input type="text" id="cpf" class="form-control @error('cpf') is-invalid @enderror"
                            x-model="cpf" x-mask="000.000.000-00">
                        @error('cpf') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="text" id="email" class="form-control @error('email') is-invalid @enderror"
                            wire:model="email">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3 col-md-6" x-data="{ phone: @entangle('phone') }">
                        <label for="phone" class="form-label">Telefone</label>
                        <input type="text" id="phone" class="form-control @error('phone') is-invalid @enderror"
                            x-model="phone" x-mask="(00) 00000-0000">
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label for="role" class="form-label">Nível</label>
                        <select id="role" class="form-select @error('role') is-invalid @enderror" wire:model="role">
                            <option value="standard">Padrão</option>
                            <option value="admin">Administrador</option>
                        </select>
                        @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" class="form-select @error('status') is-invalid @enderror" wire:model="status">
                            <option value="active">Ativo</option>
                            <option value="inactive">Inativo</option>
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label for="password" class="form-label">Nova senha (opcional)</label>
                        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror"
                            wire:model="password" placeholder="Deixe em branco para manter a atual">
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mt-2">
                    <button type="submit" class="btn btn-primary me-2" wire:loading.attr="disabled" wire:target="update">
                        <span wire:loading wire:target="update" class="spinner-border spinner-border-sm me-1"></span>
                        Atualizar
                    </button>
                    <a href="{{ route('admin.user.index') }}" class="btn btn-label-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>