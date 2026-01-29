@extends('app')

@section('title') Cadastro de Setores @endsection

@section('content')

@include('_inc.alerts')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
    <div class="d-flex flex-column justify-content-center">
        <h4 class="mb-1 mt-3">Setores</h4>
        <p class="text-muted">Sua lista de setores cadastrados</p>

    </div>
    <div class="d-flex align-content-center flex-wrap gap-3">
        <a href="{{ route('admin.departments.create') }}" class="btn btn-success waves-effect waves-light">Add Novo</a>
    </div>
</div>

<!-- Basic Bootstrap Table -->
<div class="card">
    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($departments as $department)
                    <tr>

                        <td>#{{ $department->id}}</td>

                        <td>{{ $department->nome }}</td>

                        <td>
                            <div class="w-100">
                                <a class="btn rounded-pill btn-outline-secondary waves-effect btn-sm" href="{{ route('admin.departments.edit', $department->id) }}">
                                    <i class="icon-base ti tabler-pencil ">Editar</i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        <div class="col-12 d-flex justify-content-end mt-4 pe-4">
            {{$departments->links()}}
        </div>
    </div>
</div>
<!--/ Basic Bootstrap Table -->

@endsection
