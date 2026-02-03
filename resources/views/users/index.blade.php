@extends('app')

@section('title') Usuários do sitema - {{env('APP_NAME')}} @endsection

@section('content')

<!-- Basic Breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.dashboard')}}">Início</a>
        </li>
        <li class="breadcrumb-item active">Usuários</li>
    </ol>
</nav>
<!-- Basic Breadcrumb -->

@include('_inc.alerts')

 <div class="col-12 d-flex justify-content-end mt-2 mb-4 align-items-center">
    <a href="{{ route('admin.user.create') }}" class="btn btn-primary mt-3 me-4 px-2 waves-effect waves-light" role="button">
        <i class="menu-icon icon-base ti tabler-library-plus"></i> Novo Usuário
    </a>
</div>

<!-- Basic Bootstrap Table -->
<div class="card">
    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Nome</th>
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

                    <td><span class="badge bg-label-success me-1">{{ $user->role}}</span></td>

                    <td>

                        @if (!$user->status)
                            <span class="badge bg-label-danger me-1">Inativo</span>
                        @else
                            <span class="badge bg-label-success me-1">Ativo</span>
                        @endif

                    </td>

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
<!--/ Basic Bootstrap Table -->

@endsection
