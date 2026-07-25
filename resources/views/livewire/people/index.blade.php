<div>
    <div class="card">
        <h5 class="card-header">Inquilinos</h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Casa</th>
                        <th>Contato</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody class="table-border-bottom-0">


                    @forelse($people as $p)
                    <tr>
                        <td>
                            <a href="{{route('admin.people.edit', $p->uuid)}}">#{{$p->id}}</a>
                        </td>
                        <td>
                            <a href="{{route('admin.people.edit', $p->uuid)}}">{{$p->name}}</a>
                        </td>
                        <td>
                            @if($p->activeContract?->property)
                            {{ $p->activeContract->property->street }}, {{ $p->activeContract->property->number }}
                            <br>
                            <small class="text-muted">{{ $p->activeContract->property->city }}</small>
                            @else
                            <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            {{$p->phone}}
                        </td>
                        <td>

                            <a class="btn rounded-pill btn-outline-secondary waves-effect btn-sm"
                                href="{{route('admin.people.edit', $p->uuid)}}">
                                <i class="icon-base ti tabler-pencil"></i>
                            </a>

                            <a class="btn rounded-pill btn-outline-danger waves-effect btn-sm"
                                href="javascript:void(0);">
                                <i class="icon-base ti tabler-trash "></i>
                            </a>

                        </td>
                    </tr>

                </tbody>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-4 mb-0">
                        <div class="d-flex flex-column align-items-center">
                            <i class="icon-base ti tabler-user-off icon-36px text-muted mb-3"></i>
                            <p class="text-muted mb-5">Nenhum inquilino encontrado.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </table>
        </div>
    </div>
</div>