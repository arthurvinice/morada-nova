@extends('app')

@section('title') Usuários Inativos do sitema - {{env('APP_NAME')}} @endsection

@section('content')

<!-- Basic Breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.dashboard')}}">Início</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{route('admin.user.index')}}">Usuários</a>
        </li>
        <li class="breadcrumb-item active">Inativos</li>
    </ol>
</nav>
<!-- Basic Breadcrumb -->

<div class="card">
    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Nome</th>
                    @if (auth()->user()->nivel == 'SuperAdmin')
                    <th>Departamento</th>
                    @endif
                    <th>Nível</th>
                    <th>Situação</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">

                @foreach ($users as $user)

                <tr>
                    <td>#{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    @if (auth()->user()->nivel == 'SuperAdmin')
                    <td>
                        <span class="badge bg-label-primary me-1 ">
                            {{ $user->department?->nome }}
                        </span>
                    @endif
                    <td>{{ $user->nivel }}</td>
                    <td><span class="badge bg-label-danger me-1 ">
                        Inativo
                    </span></td>

                    <td>
                        <div class="w-100">
                            <a class="btn rounded-pill btn-outline-secondary waves-effect btn-sm" href="{{route('admin.user.edit', $user->id)}}">
                                <i class="icon-base ti tabler-pencil ">Editar</i>
                            </a>
                        </div>
                    </td>
                </tr>

                @endforeach

            </tbody>
        </table>


    </div>

    <div class="row">
        <div class="col-12 pt-5">
            <div class="float-end px-5">
                {{ $users->links() }}
            </div>
        </div>
    </div>

</div>
@endsection
