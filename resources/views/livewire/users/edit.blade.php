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
                        <input type="text" id="name" class="form-control @error('form.name') is-invalid @enderror"
                            wire:model="form.name" autofocus>
                        @error('form.name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3 col-md-6" x-data="{ cpf: @entangle('form.cpf') }">
                        <label for="cpf" class="form-label">CPF</label>
                        <input type="text" id="cpf" class="form-control @error('form.cpf') is-invalid @enderror"
                            x-model="cpf" x-mask="000.000.000-00">
                        @error('form.cpf') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="text" id="email" class="form-control @error('form.email') is-invalid @enderror"
                            wire:model="form.email">
                        @error('form.email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3 col-md-6" x-data="{ phone: @entangle('form.phone') }">
                        <label for="phone" class="form-label">Telefone</label>
                        <input type="text" id="phone" class="form-control @error('form.phone') is-invalid @enderror"
                            x-model="phone" x-mask="(00) 00000-0000">
                        @error('form.phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label for="role" class="form-label">Nível</label>
                        <select id="role" class="form-select @error('form.role') is-invalid @enderror" wire:model="form.role">
                            <option value="standard">Padrão</option>
                            <option value="admin">Administrador</option>
                        </select>
                        @error('form.role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" class="form-select @error('form.status') is-invalid @enderror" wire:model="form.status">
                            <option value="active">Ativo</option>
                            <option value="inactive">Inativo</option>
                        </select>
                        @error('form.status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label for="password" class="form-label">Nova senha (opcional)</label>
                        <input type="password" id="password" class="form-control @error('form.password') is-invalid @enderror"
                            wire:model="form.password" placeholder="Deixe em branco para manter a atual">
                        @error('form.password') <div class="invalid-feedback">{{ $message }}</div> @enderror
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