<div>
    @include('_inc.alerts')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <nav aria-label="breadcrumb" class="mb-0">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Início</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.contracts.index') }}">Contratos</a></li>
                <li class="breadcrumb-item active">Novo Contrato</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Novo Contrato</h5>
        </div>

        <div class="card-body">
            <form wire:submit="store">
                <div class="row">
                    <div class="mb-3 col-md-4">
                        <label for="property_id" class="form-label">Imóvel</label>
                        <select id="property_id" wire:ignore
                            class="form-select select2 @error('property_id') is-invalid @enderror"
                            data-placeholder="Selecione o imóvel...">
                            <option></option>
                            @foreach ($properties as $property)
                                <option value="{{ $property->id }}" @selected($property_id == $property->id)>
                                    {{ $property->nickname ?: $property->street . ', ' . $property->number }}
                                </option>
                            @endforeach
                        </select>
                        @error('property_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3 col-md-4">
                        <label for="people_id" class="form-label">Inquilino</label>
                        <select id="people_id" wire:ignore
                            class="form-select select2 @error('people_id') is-invalid @enderror"
                            data-placeholder="Selecione o inquilino...">
                            <option></option>
                            @foreach ($people as $person)
                                <option value="{{ $person->id }}" @selected($people_id == $person->id)>
                                    {{ $person->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('people_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3 col-md-2">
                        <label for="start_date" class="form-label">Data de início</label>
                        <input type="date" id="start_date" class="form-control @error('start_date') is-invalid @enderror"
                            wire:model="start_date">
                        @error('start_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3 col-md-2">
                        <label for="end_date" class="form-label">Data de término</label>
                        <input type="date" id="end_date" class="form-control @error('end_date') is-invalid @enderror"
                            wire:model="end_date">
                        @error('end_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="mb-3 col-md-3">
                        <label for="rent_value" class="form-label">Valor do aluguel</label>
                        <input type="number" step="0.1" id="rent_value" placeholder="Ex.: 1500.00"
                            class="form-control @error('rent_value') is-invalid @enderror" wire:model="rent_value">
                        @error('rent_value') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3 col-md-2">
                        <label for="payday" class="form-label">Dia de Vencimento</label>
                        <input type="text" id="payday" placeholder="Ex.: 15"
                            class="form-control @error('payday') is-invalid @enderror" wire:model="payday">
                        @error('payday') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3 col-md-2">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" class="form-select @error('status') is-invalid @enderror" wire:model="status">
                            <option value="active">Ativo</option>
                            <option value="finished">Encerrado</option>
                            <option value="cancelled">Cancelado</option>
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3 col-md-5">
                        <label for="file" class="form-label">Arquivo do contrato</label>
                        <input type="file" id="file" class="form-control @error('file') is-invalid @enderror"
                            wire:model="file">
                        @error('file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div wire:loading wire:target="file" class="form-text">Enviando arquivo...</div>
                    </div>
                </div>

                <div class="row">
                    <div class="d-flex justify-content-end align-items-center mt-2 gap-2">
                        <a href="{{ route('admin.contracts.index') }}" class="btn btn-label-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary me-2" wire:loading.attr="disabled" wire:target="store">
                            <span wire:loading wire:target="store" class="spinner-border spinner-border-sm me-1"></span>
                            Salvar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @script
    <script>
        $(() => {
            const initSelect2 = (selector, field) => {
                const $select = $(wire.$el).find(selector);

                $select.select2({
                    width: '100%',
                    dropdownParent: $select.closest('.mb-3'),
                    allowClear: true,
                }).on('change', (e) => {
                    $wire.set(field, e.target.value);
                });
            };

            initSelect2('#property_id', 'property_id');
            initSelect2('#people_id', 'people_id');
        });
    </script>
    @endscript
</div>