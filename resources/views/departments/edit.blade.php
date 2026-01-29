@extends('app')

@section('title') Editar Setor {{ $department->nome }} @endsection

@section('content')


<nav aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-style1">
      <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}">Início</a>
      </li>
      <li class="breadcrumb-item">

        @if (Auth::user()->nivel == 'SuperAdmin')

            <a href="{{ route('admin.departments.index') }}">Setores</a>
        @else
            Setor
        @endif

      </li>
      <li class="breadcrumb-item active">{{ $department->nome }}</li>
    </ol>
</nav>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Basic Layout -->
    <div class="row">

        @include('_inc.alerts')

        <div class="col-xl mb-6">
            <div class="card">
                <div class="card-body">
                    <form class="card-body" action="{{ route('admin.departments.update', $department->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <h5 class="mb-6">Dados Principais</h5>
                        <div class="row g-12">

                            {{-- NOME DO SETOR --}}

                            <div class="col-md-6">
                                <label class="form-label" for="multicol-username">Título do Setor</label>
                                <input type="text" name="nome" value="{{ $department->nome }}" id="multicol-username" class="form-control" placeholder="Saúde" />

                                @error('nome')
                                    <div class="alert alert-warning small mt-1">{{ $message }}</div>
                                @enderror

                            </div>

                            {{-- CNPJ --}}

                            <div class="form-password-toggle col-md-6">
                                <label class="form-label" for="cnpj">CNPJ</label>
                                <input type="text" name="cnpj" value="{{ $department->cnpj }}" class="form-control cnpj" placeholder="Ex.: xx.xxx.xxx/xxxx-xx" maxlength="18">
                            </div>


                            {{-- EMAIL --}}

                            <div class="col-md-6 mt-5">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" value="{{ $department->email }}" class="form-control" name="email" id="email" placeholder="email@exemplo.com">
                            </div>

                            {{-- LOGO --}}

                            <div class="col-md-6 mt-5">
                                <label for="logo" class="form-label">Enviar logo</label>
                                <input class="form-control" value="{{ $department->logo }}" type="file" name="logo" id="logo">
                            </div>

                            {{-- TELEFONE PRINCIPAL --}}

                            <div class="form-password-toggle col-md-6 mt-5">
                                <label for="telefone_principal" class="form-label" for="multicol-confirm-password">Telefone Principal</label>
                                <input type="text" value="{{ $department->telefone_principal }}" name="telefone_principal" class="form-control phone_with_ddd" placeholder="Ex.: (xx) x.xxxx-xxxx" aria-label="(xx)x.xxxx-xxxx" maxlength="15">
                            </div>

                            {{-- TELEFONE SECUNDÁRIO --}}

                            <div class="form-password-toggle col-md-6 mt-5">
                                <label class="form-label" for="telefone_secundario">Telefone Secundário</label>
                                <input type="text" value="{{ $department->telefone_secundario }}" name="telefone_secundario" class="form-control phone_with_ddd" placeholder="Ex.: (xx) x.xxxx-xxxx" aria-label="(xx)x.xxxx-xxxx" maxlength="15">
                            </div>

                            <div class="col-12 mb-3 mt-6 ">
                                <h5 class="mb-1 mt-0">Endereço</h5>
                            </div>

                            {{-- ENDEREÇO --}}

                            {{-- RUA --}}
                            <div class="col-md-4 mt-2">
                                <label class="form-label mb-1" for="rua">Rua / Avenida</label>
                                <input type="text" value="{{ $department->rua }}" name="rua" id="rua" class="form-control" placeholder="Ex.: Av. Brasil">
                            </div>

                            {{-- NUMERO --}}

                            <div class="col-md-2 mt-2">
                                <label class="form-label mb-1" for="numero">Número</label>
                                <input type="text" value="{{ $department->numero }}" name="numero" id="numero" class="form-control" placeholder="15">
                            </div>

                            {{-- BAIRRO --}}

                            <div class="col-md-3 mb-3 mt-2" data-select2-id="12">

                                <label class="form-label mb-1" for="bairro">Bairro</label>
                                <div class="position-relative" data-select2-id="11">
                                    <input type="text" name="bairro" id="multicol-last-name" value="{{$department->bairro}}" class="form-control" placeholder="Santa Maria Gorete" />
                                </div>

                            </div>

                            {{-- CIDADE --}}

                            <div class="col-md-3 mt-2">
                                <label class="form-label mb-1" for="cidade">Cidade</label>
                                <input type="text" value="{{ $department->cidade }}" name="cidade" id="cidade" class="form-control form-control" placeholder="Currais Novos">
                            </div>

                            {{-- CEP --}}

                            <div class="col-md-3 mt-2">
                                <label class="form-label" for="multicol-last-name">CEP</label>
                                <input type="text" name="cep" value="{{ $department->cep }}" id="multicol-last-name" class="form-control cep" placeholder="Ex.: 59380-000">
                            </div>

                            {{-- UF --}}

                            <div class="col-md-3 mb-3 mt-2">

                                <label class="form-label" for="bairro">Estado</label>
                                <div class="position-relative">
                                    <select id="uf" name="uf" class="select2 form-select select2-hidden-accessible" data-allow-clear="true" data-select2-id="uf" tabindex="-1" aria-hidden="true">
                                        <option value="AC" {{ $department->uf == 'AC' ? 'selected' : ''}}>Acre</option>
                                        <option value="AL" {{ $department->uf == 'AL' ? 'selected' : ''}}>Alagoas</option>
                                        <option value="AP" {{ $department->uf == 'AP' ? 'selected' : ''}}>Amapá</option>
                                        <option value="AM" {{ $department->uf == 'AM' ? 'selected' : ''}}>Amazonas</option>
                                        <option value="BA" {{ $department->uf == 'BA' ? 'selected' : ''}}>Bahia</option>
                                        <option value="CE" {{ $department->uf == 'CE' ? 'selected' : ''}}>Ceará</option>
                                        <option value="DF" {{ $department->uf == 'DF' ? 'selected' : ''}}>Distrito Federal</option>
                                        <option value="ES" {{ $department->uf == 'ES' ? 'selected' : ''}}>Espírito Santo</option>
                                        <option value="GO" {{ $department->uf == 'GO' ? 'selected' : ''}}>Goiás</option>
                                        <option value="MA" {{ $department->uf == 'MA' ? 'selected' : ''}}>Maranhão</option>
                                        <option value="MT" {{ $department->uf == 'MT' ? 'selected' : ''}}>Mato Grosso</option>
                                        <option value="MS" {{ $department->uf == 'MS' ? 'selected' : ''}}>Mato Grosso do Sul</option>
                                        <option value="MG" {{ $department->uf == 'MG' ? 'selected' : ''}}>Minas Gerais</option>
                                        <option value="PA" {{ $department->uf == 'PA' ? 'selected' : ''}}>Pará</option>
                                        <option value="PB" {{ $department->uf == 'PB' ? 'selected' : ''}}>Paraíba</option>
                                        <option value="PR" {{ $department->uf == 'PR' ? 'selected' : ''}}>Paraná</option>
                                        <option value="PE" {{ $department->uf == 'PE' ? 'selected' : ''}}>Pernambuco</option>
                                        <option value="PI" {{ $department->uf == 'PI' ? 'selected' : ''}}>Piauí</option>
                                        <option value="RJ" {{ $department->uf == 'RJ' ? 'selected' : ''}}>Rio de Janeiro</option>
                                        <option value="RN" {{ $department->uf == 'RN' ? 'selected' : ''}}>Rio Grande do Norte</option>
                                        <option value="RS" {{ $department->uf == 'RS' ? 'selected' : ''}}>Rio Grande do Sul</option>
                                        <option value="RO" {{ $department->uf == 'RO' ? 'selected' : ''}}>Rondônia</option>
                                        <option value="RR" {{ $department->uf == 'RR' ? 'selected' : ''}}>Roraima</option>
                                        <option value="SC" {{ $department->uf == 'SC' ? 'selected' : ''}}>Santa Catarina</option>
                                        <option value="SP" {{ $department->uf == 'SP' ? 'selected' : ''}}>São Paulo</option>
                                        <option value="SE" {{ $department->uf == 'SE' ? 'selected' : ''}}>Sergipe</option>
                                        <option value="TO" {{ $department->uf == 'TO' ? 'selected' : ''}}>Tocantins</option>
                                    </select>
                                </div>

                            </div>

                            {{-- COMPLEMENTO --}}

                            <div class="col-md-6 mt-2">
                                <label class="form-label" for="multicol-first-name">Complemento</label>
                                <input type="text" value="{{ $department->complemento }}" name="complemento" id="multicol-first-name" class="form-control" placeholder="Vizinho ao SESI">
                            </div>


                        </div><!-- FIM ROW -->


                        <h5 class="mt-6">Mensagens Transacionais</h5>

                        <div class="mb-2">
                            <hr>
                        </div>

                        <div class="row g-12">

                            {{-- CHECKBOX --}}

                            <div class="col-md-6">

                                <div class="form-check form-switch">

                                    <input class="form-check-input" type="checkbox" id="send_message" name="send_message" value="1" {{ $department->send_message == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="send_message">Enviar mensagens transacionais</label>

                                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>

                                </div>

                                @error('nome')
                                    <div class="alert alert-warning small mt-1">{{ $message }}</div>
                                @enderror

                            </div>

                            {{-- WEBHOOK N8N SERVICE--}}

                            {{-- <div class="form-password-toggle col-md-12 mt-5">
                                <label class="form-label" for="webhook_n8n_service">Webhook N8N</label>
                                <input type="text" name="webhook_n8n_service" class="form-control" value="{{$department->webhook_n8n_service}}" placeholder="Ex.: https://n8n.example.com">

                                @error('cnpj')
                                    <div class="alert alert-warning small mt-1">{{ $message }}</div>
                                @enderror
                            </div> --}}


                            {{-- WEBHOOK N8N ORDER--}}

                            {{-- <div class="form-password-toggle col-md-12 mt-5">
                                <label class="form-label" for="webhook_n8n_order">Webhook N8N Demanda</label>
                                <input type="text" name="webhook_n8n_order" class="form-control" value="{{$department->webhook_n8n_order}}" placeholder="Ex.: https://n8n.example.com">

                                @error('cnpj')
                                    <div class="alert alert-warning small mt-1">{{ $message }}</div>
                                @enderror
                            </div> --}}

                            {{-- WEBHOOK N8N CAMPAIGN--}}

                            <div class="form-password-toggle col-md-12 mt-5">
                                <label class="form-label" for="webhook_n8n_campaign">Webhook N8N Campanha</label>
                                <input type="text" name="webhook_n8n_campaign" class="form-control" value="{{$department->webhook_n8n_campaign}}" placeholder="Ex.: https://n8n.example.com">

                                @error('cnpj')
                                    <div class="alert alert-warning small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                            <br>

                            <div class="pt-6 mt-3 d-flex justify-content-end">
                                <a href="{{ route('admin.departments.index') }}" class="btn btn-label-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary ms-3">Atualizar</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>
<!-- / Content -->

@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function(){
            $('.cep').mask('00000-000');
            $('.phone_with_ddd').mask('(00) 00000-0000');
            $('.cnpj').mask('00.000.000/0000-00', {reverse: true});
        });
    </script>
@endpush
