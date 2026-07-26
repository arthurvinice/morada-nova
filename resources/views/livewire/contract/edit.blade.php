<div>
    @include('_inc.alerts')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <nav aria-label="breadcrumb" class="mb-0">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Início</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.contracts.index') }}">Contratos</a></li>
                <li class="breadcrumb-item active">Editar Contrato</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Editar Contrato</h5>
        </div>

        <div class="card-body">
            <form wire:submit="update">
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label for="property_id" class="form-label">Imóvel</label>
                        <select id="property_id" class="form-select @error('property_id') is-invalid @enderror"
                            wire:model="property_id">
                            <option value="">Selecione...</option>
                            @foreach ($properties as $property)
                            <option value="{{ $property->id }}">{{ $property->nickname ?: $property->street . ', ' . $property->number }}</option>
                            @endforeach
                        </select>
                        @error('property_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="people_id" class="form-label">Inquilino</label>
                        <select id="people_id" class="form-select @error('people_id') is-invalid @enderror"
                            wire:model="people_id">
                            <option value="">Selecione...</option>
                            @foreach ($people as $person)
                            <option value="{{ $person->id }}">{{ $person->name }}</option>
                            @endforeach
                        </select>
                        @error('people_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="file" class="form-label">Arquivo do contrato</label>
                    <input type="file" id="file" class="form-control @error('file') is-invalid @enderror"
                        wire:model="file">
                    @error('file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <div wire:loading wire:target="file" class="form-text">Enviando arquivo...</div>

                    @if ($contract->file && !$file)
                    <div class="form-text">
                        <i class="icon-base ti tabler-paperclip me-1"></i>
                        <a href="{{ Storage::disk('public')->url($contract->file) }}" target="_blank">
                            Ver arquivo atual
                        </a>
                    </div>
                    @endif
                </div>

                <div class="row">
                    <div class="mb-3 col-md-4">
                        <label for="start_date" class="form-label">Data de início</label>
                        <input type="date" id="start_date" class="form-control @error('start_date') is-invalid @enderror"
                            wire:model="start_date">
                        @error('start_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3 col-md-4">
                        <label for="end_date" class="form-label">Data de término</label>
                        <input type="date" id="end_date" class="form-control @error('end_date') is-invalid @enderror"
                            wire:model="end_date">
                        @error('end_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3 col-md-4">
                        <label for="payday" class="form-label">Dia do vencimento</label>
                        <input type="number" id="payday" min="1" max="31"
                            class="form-control @error('payday') is-invalid @enderror" wire:model="payday">
                        @error('payday') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label for="rent_value" class="form-label">Valor do aluguel</label>
                        <input type="number" step="0.01" id="rent_value"
                            class="form-control @error('rent_value') is-invalid @enderror" wire:model="rent_value">
                        @error('rent_value') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" class="form-select @error('status') is-invalid @enderror" wire:model="status">
                            <option value="active">Ativo</option>
                            <option value="finished">Encerrado</option>
                            <option value="cancelled">Cancelado</option>
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-2">
                    <button type="submit" class="btn btn-primary me-2" wire:loading.attr="disabled" wire:target="update">
                        <span wire:loading wire:target="update" class="spinner-border spinner-border-sm me-1"></span>
                        Atualizar
                    </button>
                    <a href="{{ route('admin.contracts.index') }}" class="btn btn-label-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>