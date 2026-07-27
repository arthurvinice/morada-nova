<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">Início</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.people.index') }}">Inquilinos</a>
            </li>
            <li class="breadcrumb-item active">Editar</li>
        </ol>
    </nav>

    @include('_inc.alerts')

    <div class="row d-flex justify-content-center">
        <div class="col-xl-12 mb-6">
            <div class="card">
                <div class="card-body">
                    <form wire:submit.prevent="update" class="card-body">

                        <h6>Dados do Inquilino</h6>

                        <div class="row g-6">
                            <div class="col-md-6">
                                <label class="form-label" for="name">Nome <span class="text-danger">*</span></label>
                                <input type="text" wire:model="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Ex.: João Silva" />
                                @error('name')
                                <div class="alert alert-warning small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label" for="cpf">CPF <span class="text-danger">*</span></label>
                                <input type="text" wire:model="cpf" id="cpf"
                                    class="form-control @error('cpf') is-invalid @enderror"
                                    placeholder="Ex.: 000.000.000-00" x-mask="999.999.999-99" />
                                @error('cpf')
                                <div class="alert alert-warning small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label" for="phone">Telefone <span class="text-danger">*</span></label>
                                <input type="text" wire:model="phone" id="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    placeholder="Ex.: (84) 99999-9999" x-mask="(99) 99999-9999" />
                                @error('phone')
                                <div class="alert alert-warning small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="email">E-mail</label>
                                <input type="email" wire:model="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="Ex.: joao@email.com" />
                                @error('email')
                                <div class="alert alert-warning small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="document">Documento</label>
                                <input type="file" wire:model="document" id="document"
                                    class="form-control @error('document') is-invalid @enderror" />
                                <div wire:loading wire:target="document" class="small text-muted mt-1">Enviando arquivo...</div>
                                @if ($people->document)
                                <div class="small mt-1">
                                    Atual: <a href="{{ Storage::disk('public')->url($people->document) }}" target="_blank">visualizar documento</a>
                                </div>
                                @endif
                                @error('document')
                                <div class="alert alert-warning small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="pt-6 mt-4 d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.people.index') }}" class="btn btn-label-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary me-4" wire:loading.attr="disabled">
                                <span wire:loading.remove>Salvar</span>
                                <span wire:loading>
                                    <span class="spinner-border spinner-border-sm me-2"></span>
                                    Carregando...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@alpinejs/mask@3.x.x/dist/cdn.min.js" defer></script>
@endpush