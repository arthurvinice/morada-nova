<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">Início</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.properties.index') }}">Propriedades</a>
            </li>
            <li class="breadcrumb-item active">Cadastro</li>
        </ol>
    </nav>

    @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if (session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row d-flex justify-content-center">
        <div class="col-xl-12 mb-6">
            <div class="card">
                <div class="card-body">
                    <form wire:submit.prevent="store" class="card-body">

                        <h6>Dados da Propriedade</h6>

                        <div class="row g-6">
                            <div class="col-md-6">
                                <label class="form-label" for="nickname">Apelido</label>
                                <input type="text" wire:model="nickname" id="nickname"
                                    class="form-control @error('nickname') is-invalid @enderror"
                                    placeholder="Ex.: Apto 101 - Ed. Solar" />
                                @error('nickname')
                                <div class="alert alert-warning small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="property_type_id">Tipo <span class="text-danger">*</span></label>
                                <select wire:model="property_type_id" id="property_type_id"
                                    class="form-select @error('property_type_id') is-invalid @enderror">
                                    <option value="">Selecione...</option>
                                    @foreach ($propertyTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                @error('property_type_id')
                                <div class="alert alert-warning small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label" for="zip_code">CEP <span class="text-danger">*</span>
                                    <i class="icon-base ti tabler-info-circle" data-bs-toggle="tooltip" data-bs-placement="right"
                                        data-bs-original-title="Digite o CEP para preencher o endereço automaticamente"></i>
                                </label>
                                <input type="text" wire:model.blur="zip_code" wire:change="buscarCep" id="zip_code"
                                    class="form-control @error('zip_code') is-invalid @enderror"
                                    placeholder="Ex.: 59000-000" x-mask="99999-999" />
                                @error('zip_code')
                                <div class="alert alert-warning small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="street">Rua <span class="text-danger">*</span></label>
                                <input type="text" wire:model="street" id="street"
                                    class="form-control @error('street') is-invalid @enderror"
                                    placeholder="Ex.: Rua das Rosas" />
                                @error('street')
                                <div class="alert alert-warning small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label" for="number">Número <span class="text-danger">*</span></label>
                                <input type="text" wire:model="number" id="number"
                                    class="form-control @error('number') is-invalid @enderror"
                                    placeholder="Ex.: 101" />
                                @error('number')
                                <div class="alert alert-warning small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label" for="complement">Complemento</label>
                                <input type="text" wire:model="complement" id="complement"
                                    class="form-control @error('complement') is-invalid @enderror"
                                    placeholder="Ex.: Bloco A" />
                                @error('complement')
                                <div class="alert alert-warning small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="city">Cidade <span class="text-danger">*</span></label>
                                <input type="text" wire:model="city" id="city"
                                    class="form-control @error('city') is-invalid @enderror"
                                    placeholder="Preenchido automaticamente pelo CEP" readonly />
                                @error('city')
                                <div class="alert alert-warning small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <label class="form-label" for="state">UF <span class="text-danger">*</span></label>
                                <input type="text" wire:model="state" id="state" maxlength="2"
                                    class="form-control @error('state') is-invalid @enderror"
                                    placeholder="UF" readonly />
                                @error('state')
                                <div class="alert alert-warning small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label" for="rent_value">Valor do Aluguel</label>
                                <input type="number" step="0.01" wire:model="rent_value" id="rent_value"
                                    class="form-control @error('rent_value') is-invalid @enderror"
                                    placeholder="Ex.: 1200.00" />
                                @error('rent_value')
                                <div class="alert alert-warning small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label" for="status">Status <span class="text-danger">*</span></label>
                                <select wire:model="status" id="status"
                                    class="form-select @error('status') is-invalid @enderror">
                                    <option value="available">Disponível</option>
                                    <option value="rented">Alugado</option>
                                    <option value="maintenance">Manutenção</option>
                                    <option value="deactivated">Desativado</option>
                                </select>
                                @error('status')
                                <div class="alert alert-warning small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label" for="description">Descrição</label>
                                <textarea wire:model="description" id="description" rows="3"
                                    class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Observações sobre o imóvel..."></textarea>
                                @error('description')
                                <div class="alert alert-warning small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="pt-6 mt-4 d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.properties.index') }}" class="btn btn-label-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary me-4" wire:loading.attr="disabled">
                                <span wire:loading.remove>Cadastrar</span>
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