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
                            <a href="{{route('admin.people.edit', $p->id)}}">#{{$p->id}}</a>
                        </td>
                        <td>
                            <a href="{{route('admin.people.edit', $p->id)}}">{{$p->name}}</a>
                        </td>
                        <td>
                            <p>cada</p>
                        </td>
                        <td>
                            {{$p->phone}}
                        </td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="icon-base ti tabler-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item waves-effect" href="javascript:void(0);"><i class="icon-base ti tabler-pencil me-1"></i> Editar</a>
                                    <a class="dropdown-item waves-effect" href="javascript:void(0);"><i class="icon-base ti tabler-trash me-1"></i> Deletar</a>
                                </div>
                            </div>
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