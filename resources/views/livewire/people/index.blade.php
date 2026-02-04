<div>
    <p> Because she competes with no one, no one can compete with her. </p>
    <div class="card">
        <h5 class="card-header">Inquilinos</h5>

        @foreach($people as $p)
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
            </table>
        </div>
        @endforeach
    </div>
</div>