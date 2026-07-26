<div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Propriedades</h5>
            <div class="text-muted fs-6">
                <div class="d-flex align-items-center gap-3">
                    <div class="position-relative" style="width: 300px;">
                        <input type="text" class="form-control" placeholder="Buscar por nome ou rua..."
                            wire:model.live.debounce.500ms="busca" style="padding-right: 2.5rem;">
                        @if ($busca)
                        <span class="position-absolute top-50 translate-middle-y"
                            style="right: 10px; cursor: pointer; z-index: 10;" wire:click="$set('busca', '')">
                            <i class="ti ti-x"></i>
                        </span>
                        @endif
                    </div>

                    <select class="form-select" wire:model.live="filtroCidade" style="width: 160px;">
                        <option value="">Cidade</option>
                        @foreach ($cidades as $cidade)
                        <option value="{{ $cidade }}">{{ $cidade }}</option>
                        @endforeach
                    </select>

                    <select class="form-select" wire:model.live="filtroTipo" style="width: 160px;">
                        <option value="">Tipo</option>
                        @foreach ($propertyTypes as $tipo)
                        <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                        @endforeach
                    </select>

                    <select class="form-select" wire:model.live="filtroStatus" style="width: 160px;">
                        <option value="">Status</option>
                        <option value="available">Disponível</option>
                        <option value="rented">Alugado</option>
                        <option value="maintenance">Manutenção</option>
                    </select>

                    <button wire:click="limparFiltros"
                        class="btn btn-outline-secondary btn-lg flex-shrink-0 d-flex align-items-center justify-content-center p-2"
                        title="Resetar filtros">
                        <i class="tf-icons ti tabler-refresh" wire:loading.class="tabler-spin" wire:target="limparFiltros"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Tipo</th>
                        <th>Valor</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody class="table-border-bottom-0">

                    @forelse($properties as $p)
                    <tr>
                        <td>
                            <a href="{{route('admin.properties.edit', $p->uuid)}}">#{{$p->id}}</a>
                        </td>
                        <td>
                            <a href="{{route('admin.properties.edit', $p->uuid)}}">
                                {{ $p->nickname ?? $p->street . ', ' . $p->number }}
                            </a>
                            <br>
                            <small class="text-muted">{{ $p->city }}/{{ $p->state }}</small>
                        </td>
                        <td>
                            {{ $p->propertyType?->name ?? '—' }}
                        </td>
                        <td>
                            @if($p->rent_value)
                            R$ {{ number_format($p->rent_value, 2, ',', '.') }}
                            @else
                            <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            @switch($p->status)
                                @case('available')
                                    <span class="badge bg-label-success">Disponível</span>
                                @break
                                @case('rented')
                                    <span class="badge bg-label-info">Alugado</span>
                                @break
                                @case('maintenance')
                                    <span class="badge bg-label-warning">Manutenção</span>
                                @break
                                @case('deactivated')
                                    <span class="badge bg-label-secondary">Desativado</span>
                                @break
                                @default
                                    <span class="badge bg-label-secondary">{{ $p->status }}</span>
                            @endswitch
                        </td>
                        <td>
                            <a class="btn rounded-pill btn-outline-secondary waves-effect btn-sm"
                                href="{{route('admin.properties.edit', $p->uuid)}}">
                                <i class="icon-base ti tabler-pencil"></i>
                            </a>

                            <a class="btn rounded-pill btn-outline-danger waves-effect btn-sm"
                                href="javascript:void(0);">
                                <i class="icon-base ti tabler-trash"></i>
                            </a>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 mb-0">
                            <div class="d-flex flex-column align-items-center">
                                <i class="icon-base ti tabler-building-off icon-36px text-muted mb-3"></i>
                                <p class="text-muted mb-5">Nenhuma propriedade encontrada.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-12 pt-5">
                <div class="float-end px-5">
                    {{ $properties->links() }}
                </div>
            </div>
        </div>
    </div>
</div>