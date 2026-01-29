@extends('app')

@section('title') Cadastro das Configurações @endsection

@section('content')

@include('_inc.alerts')

<div class="container">
    <h1>{{ $configuration->nome_fantasia }}</h1>
    <div class="mb-3">
        <a href="{{ route('admin.configurations.index') }}" class="btn btn-secondary">&laquo; Voltar</a>
        <a href="{{ route('admin.configurations.edit', $configuration) }}" class="btn btn-primary">Editar Configuração</a>
    </div>
    <div class="row">
        <!-- Coluna para imagens -->
        <div class="col-md-4">
            @if($configuration->logo)
            <div class="mb-3">
                <h5>Logo</h5>
                <img src="{{ url(Storage::url($configuration->logo)) }}" class="img-fluid" alt="Logo">
            </div>
            @endif
            @if($configuration->avatar)
            <div class="mb-3">
                <h5>Avatar</h5>
                <img src="{{ url(Storage::url($configuration->avatar)) }}" class="img-fluid" alt="Avatar">
            </div>
            @endif
        </div>
        <!-- Coluna para informações -->
        <div class="col-md-8">
            <ul class="list-group">
                <li class="list-group-item"><strong>Razão Social:</strong> {{ $configuration->razao_social }}</li>
                <li class="list-group-item"><strong>CNPJ:</strong> {{ $configuration->cnpj }}</li>
                <li class="list-group-item"><strong>Telefone Principal:</strong> {{ $configuration->telefone_principal
                    }}</li>
                <li class="list-group-item"><strong>Whatsapp:</strong> {{ $configuration->whatsapp }}</li>
                <li class="list-group-item"><strong>Email:</strong> {{ $configuration->email }}</li>
                @if($configuration->address)
                <li class="list-group-item">
                    <strong>Endereço:</strong> {{ $configuration->address->rua }}, {{ $configuration->address->cidade
                    }}, {{ $configuration->address->uf }} - CEP: {{ $configuration->address->cep }}
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>
@endsection
