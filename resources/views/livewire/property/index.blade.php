<div>
    <div class="card">
        <h5 class="card-header">Propriedades</h5>
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
    </div>
</div>