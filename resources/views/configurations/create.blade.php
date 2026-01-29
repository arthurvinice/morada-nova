@extends('app')

@section('title')
    Cadastro das Configurações
@endsection

@section('content')
    @include('_inc.alerts')

    <div class="container">
        <div class="row">
            <div class="col-xl mb-6">
                <div class="card">
                    <h2 class="ms-2">Nova Configuração</h2>
                    <form action="{{ route('admin.configurations.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Dados da Configuração -->
                        <div class="row">

                            <div class="col-md-6">

                                <div class="form-group ms-4">
                                    <label>Nome Fantasia</label>
                                    <input type="text" name="nome_fantasia" class="form-control"
                                        value="{{ old('nome_fantasia') }}">
                                    @error('nome_fantasia')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group me-4"">

                                    <label>Razão Social</label>
                                    <input type="text" name="razao_social" class="form-control"
                                        value="{{ old('razao_social') }}">
                                    @error('razao_social')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>

                            </div>

                        </div>

                        {{-- SEGUNDA LINHA --}}

                        <div class="row justify-content-center g-3 px-1">

                            <div class="col-md-4">

                                <div class="form-group p-3">
                                    <label class="form-label" for="cnpj">CNPJ</label>
                                    <input type="text" name="cnpj" class="form-control cnpj"
                                        value="{{ old('cnpj') }}" placeholder="Ex.: xx.xxx.xxx/xxxx-xx">

                                    @error('cnpj')
                                        <div class="alert alert-warning small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="form-group p-3">
                                    <label>Telefone Principal</label>
                                    <input type="text" name="telefone_principal" class="form-control phone_with_ddd"
                                        value="{{ old('telefone_principal') }}" placeholder="Ex.: (xx) x.xxxx-xxxx"
                                        aria-label="(xx)x.xxxx-xxxx">
                                    @error('telefone_principal')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="form-group p-3">
                                    <label>Whatsapp</label>
                                    <input type="text" name="whatsapp" class="form-control phone_with_ddd"
                                        value="{{ old('whatsapp') }}" placeholder="Ex.: (xx) x.xxxx-xxxx"
                                        aria-label="(xx)x.xxxx-xxxx">
                                    @error('whatsapp')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                        </div>

                        {{-- TERCEIRA LINHA --}}

                        <div class="row justify-content-center g-3 px-1">

                            <div class="col-md-4">

                                <div class="form-group p-3">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="form-group p-3">
                                    <label>Logo</label>
                                    <input type="file" name="logo" class="form-control">
                                    @error('logo')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="form-group p-3">
                                    <label>Avatar</label>
                                    <input type="file" name="avatar" class="form-control">
                                    @error('avatar')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                        </div>

                        <!-- Dados do Endereço -->
                        <h4 class="mt-3 ms-2">Endereço</h4>

                        <div class="row justify-content-center g-3 px-1">

                            <div class="col-md-4">

                                <div class="form-group p-3">
                                    <label>Rua</label>
                                    <input type="text" name="rua" class="form-control" value="{{ old('rua') }}">
                                    @error('rua')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="form-group p-3">
                                    <label>Número</label>
                                    <input type="text" name="numero" class="form-control" value="{{ old('numero') }}">
                                    @error('numero')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="form-group p-3">
                                    <label>Bairro</label>
                                    <input type="text" name="bairro" class="form-control" value="{{ old('bairro') }}">
                                    @error('bairro')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                        </div>

                        <div class="row justify-content-center g-3 px-1">

                            <div class="col-md-4">

                                <div class="form-group p-3">
                                    <label>Cidade</label>
                                    <input type="text" name="cidade" class="form-control"
                                        value="{{ old('cidade') }}">
                                    @error('cidade')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="form-group p-3">
                                    <label>CEP</label>
                                    <input type="text" name="cep" class="form-control cep"
                                        value="{{ old('cep') }}" placeholder="Ex.: 59380-000">
                                    @error('cep')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="form-group p-3">

                                    <label class="form-label" for="estado">Estado</label>
                                    <div class="position-relative">
                                        <select id="estado" name="estado"
                                            class="select2 form-select select2-hidden-accessible" data-allow-clear="true"
                                            data-select2-id="estado" tabindex="-1" aria-hidden="true">
                                            <option value="AC" {{ old('estado') == 'AC' ? 'selected' : '' }}>Acre
                                            </option>
                                            <option value="AL" {{ old('estado') == 'AL' ? 'selected' : '' }}>Alagoas
                                            </option>
                                            <option value="AP" {{ old('estado') == 'AP' ? 'selected' : '' }}>Amapá
                                            </option>
                                            <option value="AM" {{ old('estado') == 'AM' ? 'selected' : '' }}>Amazonas
                                            </option>
                                            <option value="BA" {{ old('estado') == 'BA' ? 'selected' : '' }}>Bahia
                                            </option>
                                            <option value="CE" {{ old('estado') == 'CE' ? 'selected' : '' }}>Ceará
                                            </option>
                                            <option value="DF" {{ old('estado') == 'DF' ? 'selected' : '' }}>Distrito
                                                Federal</option>
                                            <option value="ES" {{ old('estado') == 'ES' ? 'selected' : '' }}>Espírito
                                                Santo</option>
                                            <option value="GO" {{ old('estado') == 'GO' ? 'selected' : '' }}>Goiás
                                            </option>
                                            <option value="MA" {{ old('estado') == 'MA' ? 'selected' : '' }}>Maranhão
                                            </option>
                                            <option value="MT" {{ old('estado') == 'MT' ? 'selected' : '' }}>Mato
                                                Grosso</option>
                                            <option value="MS" {{ old('estado') == 'MS' ? 'selected' : '' }}>Mato
                                                Grosso do Sul</option>
                                            <option value="MG" {{ old('estado') == 'MG' ? 'selected' : '' }}>Minas
                                                Gerais</option>
                                            <option value="PA" {{ old('estado') == 'PA' ? 'selected' : '' }}>Pará
                                            </option>
                                            <option value="PB" {{ old('estado') == 'PB' ? 'selected' : '' }}>Paraíba
                                            </option>
                                            <option value="PR" {{ old('estado') == 'PR' ? 'selected' : '' }}>Paraná
                                            </option>
                                            <option value="PE" {{ old('estado') == 'PE' ? 'selected' : '' }}>
                                                Pernambuco</option>
                                            <option value="PI" {{ old('estado') == 'PI' ? 'selected' : '' }}>Piauí
                                            </option>
                                            <option value="RJ" {{ old('estado') == 'RJ' ? 'selected' : '' }}>Rio de
                                                Janeiro</option>
                                            <option value="RN" {{ old('estado') == 'RN' ? 'selected' : '' }}>Rio
                                                Grande do Norte</option>
                                            <option value="RS" {{ old('estado') == 'RS' ? 'selected' : '' }}>Rio
                                                Grande do Sul</option>
                                            <option value="RO" {{ old('estado') == 'RO' ? 'selected' : '' }}>Rondônia
                                            </option>
                                            <option value="RR" {{ old('estado') == 'RR' ? 'selected' : '' }}>Roraima
                                            </option>
                                            <option value="SC" {{ old('estado') == 'SC' ? 'selected' : '' }}>Santa
                                                Catarina</option>
                                            <option value="SP" {{ old('estado') == 'SP' ? 'selected' : '' }}>São Paulo
                                            </option>
                                            <option value="SE" {{ old('estado') == 'SE' ? 'selected' : '' }}>Sergipe
                                            </option>
                                            <option value="TO" {{ old('estado') == 'TO' ? 'selected' : '' }}>Tocantins
                                            </option>
                                        </select>

                                        @error('estado')
                                            <div class="alert alert-warning small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                        </div>

                        <h4 class="mt-3 ms-2">Custom ID</h4>

                        <div class="row justify-content-center g-3 px-1">

                            <div class="col-md-4">
                                <label for="custom_client_id" class="form-label">ID do Cliente</label>
                                <input type="text" name="custom_client_id" class="form-control"
                                    value="custom_client_id"></label>
                                @error('custom_client_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary mt-3 ms-3 mb-3">Salvar</button>
                        <a href="{{ route('admin.configurations.index') }}"
                            class="btn btn-secondary mt-3 ms-3 mb-3">Voltar</a>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection


@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"
        integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function() {
            $('.cep').mask('00000-000');
            $('.phone_with_ddd').mask('(00) 00000-0000');
            $('.cnpj').mask('00.000.000/0000-00', {
                reverse: true
            });
        });
    </script>
@endpush
