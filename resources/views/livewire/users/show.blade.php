<div>
    <h4 class="py-3 mb-4">Meu perfil</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="nav-align-top mb-4">
                <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                    <li class="nav-item">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-justified-detalhes">
                            <i class="menu-icon icon-base ti tabler-user-circle"></i>
                            Informações Básicas
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-justified-profile">
                            <i class="menu-icon icon-base ti tabler-lock"></i>
                            Segurança
                        </button>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="navs-pills-justified-detalhes" role="tabpanel">
                        <div class="mb-4">
                            <h5 class="card-header">Detalhes do seu perfil</h5>

                            @include('_inc.alerts')

                            <hr class="my-3" />

                            <div class="card-body">
                                <form wire:submit="updateProfile">
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label for="name" class="form-label">Nome</label>
                                            <input class="form-control @error('name') is-invalid @enderror" type="text"
                                                id="name" wire:model="name" autofocus />
                                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label for="email" class="form-label">E-mail</label>
                                            <input class="form-control @error('email') is-invalid @enderror" type="text"
                                                id="email" wire:model="email" placeholder="joao@examplo.com" />
                                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>

                                    <div class="mt-2">
                                        <button type="submit" class="btn btn-primary me-2" wire:loading.attr="disabled" wire:target="updateProfile">
                                            <span wire:loading wire:target="updateProfile" class="spinner-border spinner-border-sm me-1"></span>
                                            Atualizar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="navs-pills-justified-profile" role="tabpanel">
                        <div class="mb-4">
                            <h5 class="card-header">Segurança do seu perfil</h5>

                            @if (session('warning'))
                                <div class="p-3">
                                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                                        <span class="alert-icon text-warning me-2"><i class="ti ti-warning ti-xs"></i></span>
                                        {{ session('warning') }}
                                    </div>
                                </div>
                            @endif

                            <hr class="my-3" />

                            <div class="card-body">
                                <form wire:submit="updatePasswordAction">
                                    <div class="row">
                                        <div class="mb-3 col-md-6 form-password-toggle">
                                            <label class="form-label" for="currentPassword">Senha atual</label>
                                            <div class="input-group input-group-merge">
                                                <input class="form-control @error('currentPassword') is-invalid @enderror"
                                                    type="password" wire:model="currentPassword" id="currentPassword" placeholder="******" />
                                                <span class="input-group-text cursor-pointer"><i class="menu-icon icon-base ti tabler-eye-off"></i></span>
                                                @error('currentPassword') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="mb-3 col-md-6 form-password-toggle">
                                            <label class="form-label" for="password">Nova senha</label>
                                            <div class="input-group input-group-merge">
                                                <input class="form-control @error('password') is-invalid @enderror"
                                                    type="password" wire:model="password" id="password" placeholder="******" />
                                                <span class="input-group-text cursor-pointer"><i class="menu-icon icon-base ti tabler-eye-off"></i></span>
                                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>

                                        <div class="mb-3 col-md-6 form-password-toggle">
                                            <label class="form-label" for="password_confirmation">Confirmar Nova senha</label>
                                            <div class="input-group input-group-merge">
                                                <input class="form-control" type="password"
                                                    wire:model="password_confirmation" id="password_confirmation" placeholder="******" />
                                                <span class="input-group-text cursor-pointer"><i class="menu-icon icon-base ti tabler-eye-off"></i></span>
                                            </div>
                                        </div>

                                        <div class="col-12 mb-4">
                                            <h6>Dica de senha forte:</h6>
                                            <ul class="ps-3 mb-0">
                                                <li class="mb-1">Use no mínimo 8 caracteres - quanto mais melhor</li>
                                                <li class="mb-1">Misture caracteres minúsculos e maiúsculos</li>
                                                <li>Use símbolos como: @ # + *</li>
                                            </ul>
                                        </div>

                                        <div>
                                            <button type="submit" class="btn btn-primary me-2" wire:loading.attr="disabled" wire:target="updatePasswordAction">
                                                <span wire:loading wire:target="updatePasswordAction" class="spinner-border spinner-border-sm me-1"></span>
                                                Atualizar senha
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>