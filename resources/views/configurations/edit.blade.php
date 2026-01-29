@extends('app')

@section('title')
    Cadastro das Configurações
@endsection

@section('content')
    <div class="container">

        @include('_inc.alerts')

        <h1>Editar Configuração</h1>
        <form action="{{ route('admin.configurations.update', $configuration) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Dados da Configuração -->
            <div class="form-group">
                <label>Nome Fantasia</label>
                <input type="text" name="nome_fantasia" class="form-control"
                    value="{{ old('nome_fantasia', $configuration->nome_fantasia) }}">
                @error('nome_fantasia')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Razão Social</label>
                <input type="text" name="razao_social" class="form-control"
                    value="{{ old('razao_social', $configuration->razao_social) }}">
                @error('razao_social')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>CNPJ</label>
                <input type="text" name="cnpj" class="form-control" value="{{ old('cnpj', $configuration->cnpj) }}">
                @error('cnpj')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Telefone Principal</label>
                <input type="text" name="telefone_principal" class="form-control"
                    value="{{ old('telefone_principal', $configuration->telefone_principal) }}">
                @error('telefone_principal')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Whatsapp</label>
                <input type="text" name="whatsapp" class="form-control"
                    value="{{ old('whatsapp', $configuration->whatsapp) }}">
                @error('whatsapp')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control"
                    value="{{ old('email', $configuration->email) }}">
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Logo</label>
                @if ($configuration->logo)
                    <div class="mb-2">
                        <img src="{{ url(Storage::url($configuration->logo)) }}" alt="Logo" style="max-width: 150px;">
                    </div>
                @endif
                <input type="file" name="logo" class="form-control">
                @error('logo')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Avatar</label>
                @if ($configuration->avatar)
                    <div class="mb-2">
                        <img src="{{ url(Storage::url($configuration->avatar)) }}" alt="Avatar"
                            style="max-width: 150px;">
                    </div>
                @endif
                <input type="file" name="avatar" class="form-control">
                @error('avatar')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Dados do Endereço -->
            <h4 class="mt-4">Endereço</h4>

            <div class="form-group">
                <label>Rua</label>
                <input type="text" name="rua" class="form-control"
                    value="{{ old('rua', $configuration->rua ?? null) }}">
                @error('rua')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Número</label>
                <input type="text" name="numero" class="form-control"
                    value="{{ old('numero', $configuration->numero ?? null) }}">
                @error('numero')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Bairro</label>
                <input type="text" name="bairro" class="form-control"
                    value="{{ old('bairro', $configuration->bairro ?? null) }}">
                @error('bairro')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Cidade</label>
                <input type="text" name="cidade" class="form-control"
                    value="{{ old('cidade', $configuration->cidade ?? null) }}">
                @error('cidade')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>CEP</label>
                <input type="text" name="cep" class="form-control"
                    value="{{ old('cep', $configuration->cep ?? null) }}">
                @error('cep')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">

                <label class="form-label" for="estado">Estado</label>
                <div class="position-relative">

                    <select id="estado" name="estado" class="select2 form-select select2-hidden-accessible"
                        data-allow-clear="true" data-select2-id="estado" tabindex="-1" aria-hidden="true">
                        <option value="AC"
                            {{ old('estado', $configuration->estado ?? '') == 'AC' ? 'selected' : '' }}>Acre</option>
                        <option value="AL"
                            {{ old('estado', $configuration->estado ?? '') == 'AL' ? 'selected' : '' }}>Alagoas</option>
                        <option value="AP"
                            {{ old('estado', $configuration->estado ?? '') == 'AP' ? 'selected' : '' }}>Amapá</option>
                        <option value="AM"
                            {{ old('estado', $configuration->estado ?? '') == 'AM' ? 'selected' : '' }}>Amazonas</option>
                        <option value="BA"
                            {{ old('estado', $configuration->estado ?? '') == 'BA' ? 'selected' : '' }}>Bahia</option>
                        <option value="CE"
                            {{ old('estado', $configuration->estado ?? '') == 'CE' ? 'selected' : '' }}>Ceará</option>
                        <option value="DF"
                            {{ old('estado', $configuration->estado ?? '') == 'DF' ? 'selected' : '' }}>Distrito Federal
                        </option>
                        <option value="ES"
                            {{ old('estado', $configuration->estado ?? '') == 'ES' ? 'selected' : '' }}>Espírito Santo
                        </option>
                        <option value="GO"
                            {{ old('estado', $configuration->estado ?? '') == 'GO' ? 'selected' : '' }}>Goiás</option>
                        <option value="MA"
                            {{ old('estado', $configuration->estado ?? '') == 'MA' ? 'selected' : '' }}>Maranhão</option>
                        <option value="MT"
                            {{ old('estado', $configuration->estado ?? '') == 'MT' ? 'selected' : '' }}>Mato Grosso
                        </option>
                        <option value="MS"
                            {{ old('estado', $configuration->estado ?? '') == 'MS' ? 'selected' : '' }}>Mato Grosso do Sul
                        </option>
                        <option value="MG"
                            {{ old('estado', $configuration->estado ?? '') == 'MG' ? 'selected' : '' }}>Minas Gerais
                        </option>
                        <option value="PA"
                            {{ old('estado', $configuration->estado ?? '') == 'PA' ? 'selected' : '' }}>Pará</option>
                        <option value="PB"
                            {{ old('estado', $configuration->estado ?? '') == 'PB' ? 'selected' : '' }}>Paraíba</option>
                        <option value="PR"
                            {{ old('estado', $configuration->estado ?? '') == 'PR' ? 'selected' : '' }}>Paraná</option>
                        <option value="PE"
                            {{ old('estado', $configuration->estado ?? '') == 'PE' ? 'selected' : '' }}>Pernambuco</option>
                        <option value="PI"
                            {{ old('estado', $configuration->estado ?? '') == 'PI' ? 'selected' : '' }}>Piauí</option>
                        <option value="RJ"
                            {{ old('estado', $configuration->estado ?? '') == 'RJ' ? 'selected' : '' }}>Rio de Janeiro
                        </option>
                        <option value="RN"
                            {{ old('estado', $configuration->estado ?? '') == 'RN' ? 'selected' : '' }}>Rio Grande do Norte
                        </option>
                        <option value="RS"
                            {{ old('estado', $configuration->estado ?? '') == 'RS' ? 'selected' : '' }}>Rio Grande do Sul
                        </option>
                        <option value="RO"
                            {{ old('estado', $configuration->estado ?? '') == 'RO' ? 'selected' : '' }}>Rondônia</option>
                        <option value="RR"
                            {{ old('estado', $configuration->estado ?? '') == 'RR' ? 'selected' : '' }}>Roraima</option>
                        <option value="SC"
                            {{ old('estado', $configuration->estado ?? '') == 'SC' ? 'selected' : '' }}>Santa Catarina
                        </option>
                        <option value="SP"
                            {{ old('estado', $configuration->estado ?? '') == 'SP' ? 'selected' : '' }}>São Paulo</option>
                        <option value="SE"
                            {{ old('estado', $configuration->estado ?? '') == 'SE' ? 'selected' : '' }}>Sergipe</option>
                        <option value="TO"
                            {{ old('estado', $configuration->estado ?? '') == 'TO' ? 'selected' : '' }}>Tocantins</option>
                    </select>

                    @error('estado')
                        <div class="alert alert-warning small mt-1">{{ $message }}</div>
                    @enderror
                </div>


                <h4 class="mt-3 ms-2">Custom ID</h4>

                <div class="row justify-content-start g-3 px-1">

                    <div class="col-md-4">
                        <label for="custom_client_id" class="form-label">ID do Cliente</label>
                        <input type="text" name="custom_client_id" class="form-control"
                            value="{{ old('custom_client_id', $configuration->custom_client_id ?? null) }}"></label>
                        @error('custom_client_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
            </div>


            <button type="submit" class="btn btn-primary mt-3">Atualizar</button>
            <a href="{{ route('admin.configurations.index') }}" class="btn btn-secondary mt-3">Voltar</a>
        </form>
    </div>
@endsection
