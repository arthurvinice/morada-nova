@extends('app')

@section('title') Cadastro das Configurações @endsection

@section('content')

@include('_inc.alerts')

<div class="container">
    <h3 class="text-muted">Configurações do Cliente</h3>

    @if ($configurations->count() == 0)
        <a href="{{ route('admin.configurations.create') }}" class="btn btn-primary mb-3">Nova Configuração</a>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Avatar</th>
                <th>Nome Fantasia</th>
                <th>CNPJ</th>
                <th>Email</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($configurations as $config)
            <tr>
                <td>{{ $config->id }}</td>
                <td>
                    @if ($config->logo)
                        <img src="{{ url($config->logo) }}"  width="150" alt="logo" class="img img-fluid h-auto">
                    @else

                    @endif
                </td>
                <td>{{ $config->nome_fantasia }}</td>
                <td>{{ $config->cnpj }}</td>
                <td>{{ $config->email }}</td>
                <td>
                    <a href="{{ route('admin.configurations.show', $config) }}" class="btn btn-info btn-sm">Ver</a>
                    <a href="{{ route('admin.configurations.edit', $config) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('admin.configurations.destroy', $config) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Tem certeza?')"
                            class="btn btn-danger btn-sm">Excluir</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
