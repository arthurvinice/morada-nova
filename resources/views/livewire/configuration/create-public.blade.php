<div>
    <form wire:submit="register">
        <div class="row justify-content-center g-3 px-1">
            <div class="col-md-6">
                <div class="form-group p-3">
                    <label class="form-label" for="name">Nome completo</label>
                    <input type="text" id="name" class="form-control @error('name') is-invalid @enderror"
                        wire:model="name" autofocus>
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="col-md-6" x-data="{ cpf: @entangle('cpf') }">
                <div class="form-group p-3">
                    <label class="form-label" for="cpf">CPF</label>
                    <input type="text" id="cpf" class="form-control @error('cpf') is-invalid @enderror"
                        x-model="cpf" x-mask="000.000.000-00">
                    @error('cpf') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="row justify-content-center g-3 px-1">
            <div class="col-md-6">
                <div class="form-group p-3">
                    <label class="form-label" for="email">E-mail</label>
                    <input type="email" id="email" class="form-control @error('email') is-invalid @enderror"
                        wire:model="email">
                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="col-md-6" x-data="{ phone: @entangle('phone') }">
                <div class="form-group p-3">
                    <label class="form-label" for="phone">Telefone</label>
                    <input type="text" id="phone" class="form-control @error('phone') is-invalid @enderror"
                        x-model="phone" x-mask="(00) 00000-0000">
                    @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="row justify-content-center g-3 px-1">
            <div class="col-md-6">
                <div class="form-group p-3">
                    <label class="form-label" for="password">Senha</label>
                    <input type="password" id="password" class="form-control @error('password') is-invalid @enderror"
                        wire:model="password">
                    @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group p-3">
                    <label class="form-label" for="password_confirmation">Confirmar senha</label>
                    <input type="password" id="password_confirmation" class="form-control"
                        wire:model="password_confirmation">
                </div>
            </div>
        </div>

        <div class="form-check mt-4 ms-4">
            <input class="form-check-input @error('terms_accepted') is-invalid @enderror" type="checkbox"
                wire:model="terms_accepted" id="termsCheck">
            <label class="form-check-label" for="termsCheck">
                Eu li e concordo com os
                @if ($term)
                    <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#termosusoModal">Termos de Uso</a>
                @else
                    Termos de Uso
                @endif
            </label>
            @error('terms_accepted') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="d-flex justify-content-end">
            <a href="{{ route('login') }}" class="btn btn-secondary mt-3 me-3 mb-3">Voltar</a>
            <button type="submit" class="btn btn-primary mt-3 mb-3" wire:loading.attr="disabled" wire:target="register">
                <span wire:loading wire:target="register" class="spinner-border spinner-border-sm me-1"></span>
                Cadastrar
            </button>
        </div>
    </form>

    @if ($term)
        <div class="modal fade" id="termosusoModal" tabindex="-1" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ $term->title }}</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="terms-content mb-4">
                            {!! $term->content !!}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                            onclick="document.getElementById('termsCheck').click()">
                            Li e Aceito os Termos de Uso
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>