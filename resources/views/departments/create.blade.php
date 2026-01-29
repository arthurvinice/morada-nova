@extends('app')

@section('title') Cadastrar Novo Setor @endsection

@section('content')

@include('_inc.alerts')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-style1">
      <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}">Início</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{ route('admin.departments.index') }}">Setor</a>
      </li>
      <li class="breadcrumb-item active">Cadastro de Setor</li>
    </ol>
</nav>


<!-- Basic Layout -->
<div class="row justify-content-center flex-grow-1">
    <div class="col-12 col-md-8 col-lg-9">
        <div class="card">
            <div class="card-body">
                <form class="card-body" action="{{ route('admin.departments.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('post')

                    <h5 class="mb-1">Dados Principais</h5>

                    <div class="mb-2">
                        <hr>
                    </div>

                    <div class="row g-12">

                        {{-- NOME DO SETOR --}}

                        <div class="col-md-6">
                            <label class="form-label" for="multicol-username">Título do Setor</label>
                            <input type="text" name="nome" value="{{ old('nome') }}" id="multicol-username" class="form-control" placeholder="Saúde" />

                            @error('nome')
                                <div class="alert alert-warning small mt-1">{{ $message }}</div>
                            @enderror

                        </div>

                        {{-- CNPJ --}}

                        <div class="form-password-toggle col-md-6">
                            <label class="form-label" for="cnpj">CNPJ</label>
                            <input type="text" name="cnpj" class="form-control cnpj" value="{{ old('cnpj') }}" placeholder="Ex.: xx.xxx.xxx/xxxx-xx">

                            @error('cnpj')
                                <div class="alert alert-warning small mt-1">{{ $message }}</div>
                            @enderror
                        </div>


                        {{-- EMAIL --}}

                        <div class="col-md-6 mt-5">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" id="email" placeholder="email@exemplo.com">

                            @error('email')
                                <div class="alert alert-warning small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- LOGO --}}

                        <div class="col-md-6 mt-5">
                            <label for="logo" class="form-label">Enviar logo</label>
                            <input class="form-control" type="file" name="logo" id="logo">
                        </div>

                        {{-- TELEFONE PRINCIPAL --}}

                        <div class="form-password-toggle col-md-6 mt-5">
                            <label for="telefone_principal" class="form-label" for="multicol-confirm-password">Telefone Principal</label>
                            <input type="text" name="telefone_principal" value="{{ old('telefone_principal') }}" class="form-control phone_with_ddd" placeholder="Ex.: (xx) x.xxxx-xxxx" aria-label="(xx)x.xxxx-xxxx">

                            @error('telefone_principal')
                                <div class="alert alert-warning small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- TELEFONE SECUNDÁRIO --}}

                        <div class="form-password-toggle col-md-6 mt-5">
                            <label class="form-label" for="telefone_secundario">Telefone Secundário</label>
                            <input type="text" name="telefone_secundario" value="{{ old('telefone_secundario') }}" class="form-control phone_with_ddd" placeholder="Ex.: (xx) x.xxxx-xxxx" aria-label="(xx)x.xxxx-xxxx">

                            @error('telefone_secundario')
                                <div class="alert alert-warning small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                        <div class="col-12 mb-3 mt-6 ">
                            <h5 class="mb-1 mt-0">Endereço</h5>
                        </div>

                        <div class="mb-0">
                            <hr>
                        </div>

                        {{-- ENDEREÇO --}}
                    <div class="row g-6 mt-0">

                        <div class="col-md-3">
                            <label class="form-label" for="multicol-last-name">CEP</label>
                            {{-- <span class="text-danger">*</span> --}}
                            <input type="text" name="cep" id="multicol-last-name" value="{{old('cep')}}" class="form-control cep" placeholder="Ex.: 59380-000" />

                            @error('cep')
                            <div class="alert alert-warning small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="multicol-first-name">Rua / Avenida</label>
                            {{-- <span class="text-danger">*</span> --}}
                            <input type="text" name="rua" id="multicol-first-name" value="{{old('rua')}}" class="form-control" placeholder="Ex.: Av. Brasil" />
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="multicol-last-name">Número</label>
                            {{-- <span class="text-danger">*</span> --}}
                            <input type="text" name="numero" id="multicol-last-name" value="{{old('numero')}}" class="form-control" placeholder="Ex.: 15" />

                            @error('numero')
                                <div class="alert alert-warning small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">

                            <label class="form-label" for="bairro">Bairro</label>
                            {{-- <span class="text-danger">*</span> --}}
                            <input type="text" name="bairro" id="multicol-last-name" value="{{old('bairro')}}" class="form-control" placeholder="Ex.: Santa Maria Gorete" />

                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="multicol-last-name">Cidade</label>
                            <input type="text" name="cidade" id="multicol-last-name" value="{{old('cidade')}}" class="form-control" placeholder="Ex.: Currais Novos" disabled/>

                            @error('cidade')
                                <div class="alert alert-warning small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">

                            <label class="form-label" for="bairro">Estado</label>
                            <select id="uf" name="uf" class="select2 form-select" data-allow-clear="true" disabled>
                                <option value="" selected> Ex.: Rio Grande do Norte</option>
                                <option value="AC" {{ old('uf')=='AC' ? 'selected' : '' }}>Acre</option>
                                <option value="AL" {{ old('uf')=='AL' ? 'selected' : '' }}>Alagoas</option>
                                <option value="AP" {{ old('uf')=='AP' ? 'selected' : '' }}>Amapá</option>
                                <option value="AM" {{ old('uf')=='AM' ? 'selected' : '' }}>Amazonas</option>
                                <option value="BA" {{ old('uf')=='BA' ? 'selected' : '' }}>Bahia</option>
                                <option value="CE" {{ old('uf')=='CE' ? 'selected' : '' }}>Ceará</option>
                                <option value="DF" {{ old('uf')=='DF' ? 'selected' : '' }}>Distrito Federal</option>
                                <option value="ES" {{ old('uf')=='ES' ? 'selected' : '' }}>Espírito Santo</option>
                                <option value="GO" {{ old('uf')=='GO' ? 'selected' : '' }}>Goiás</option>
                                <option value="MA" {{ old('uf')=='MA' ? 'selected' : '' }}>Maranhão</option>
                                <option value="MT" {{ old('uf')=='MT' ? 'selected' : '' }}>Mato Grosso</option>
                                <option value="MS" {{ old('uf')=='MS' ? 'selected' : '' }}>Mato Grosso do Sul</option>
                                <option value="MG" {{ old('uf')=='MG' ? 'selected' : '' }}>Minas Gerais</option>
                                <option value="PA" {{ old('uf')=='PA' ? 'selected' : '' }}>Pará</option>
                                <option value="PB" {{ old('uf')=='PB' ? 'selected' : '' }}>Paraíba</option>
                                <option value="PR" {{ old('uf')=='PR' ? 'selected' : '' }}>Paraná</option>
                                <option value="PE" {{ old('uf')=='PE' ? 'selected' : '' }}>Pernambuco</option>
                                <option value="PI" {{ old('uf')=='PI' ? 'selected' : '' }}>Piauí</option>
                                <option value="RJ" {{ old('uf')=='RJ' ? 'selected' : '' }}>Rio de Janeiro</option>
                                <option value="RN" {{ old('uf')=='RN' ? 'selected' : '' }}>Rio Grande do Norte</option>
                                <option value="RS" {{ old('uf')=='RS' ? 'selected' : '' }}>Rio Grande do Sul</option>
                                <option value="RO" {{ old('uf')=='RO' ? 'selected' : '' }}>Rondônia</option>
                                <option value="RR" {{ old('uf')=='RR' ? 'selected' : '' }}>Roraima</option>
                                <option value="SC" {{ old('uf')=='SC' ? 'selected' : '' }}>Santa Catarina</option>
                                <option value="SP" {{ old('uf')=='SP' ? 'selected' : '' }}>São Paulo</option>
                                <option value="SE" {{ old('uf')=='AE' ? 'selected' : '' }}>Sergipe</option>
                                <option value="TO" {{ old('uf')=='TO' ? 'selected' : '' }}>Tocantins</option>
                            </select>

                        </div>

                        <div class="col-md-12">
                            <label class="form-label" for="multicol-first-name">Complemento</label>
                            <input type="text" name="complemento" value="{{old('complemento')}}" id="multicol-first-name" class="form-control" placeholder=" Ex.: Vizinho ao SESI" />

                            @error('complemento')
                                <div class="alert alert-warning small mt-1">{{ $message }}</div>
                            @enderror
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

                                <input class="form-check-input" type="checkbox" id="send_message" name="send_message" value="1" {{ old('send_message', isset($department) ? $department->send_message : '') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="send_message">Enviar mensagens transacionais</label>

                                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>

                            </div>

                            @error('nome')
                                <div class="alert alert-warning small mt-1">{{ $message }}</div>
                            @enderror

                        </div>

                        {{-- WEBHOOK N8N SERVICE--}}

                        <div class="form-password-toggle col-md-12 mt-5">
                            <label class="form-label" for="cnpj">Webhook N8N</label>
                            <input type="text" name="webhook_n8n_service" class="form-control" value="{{ old('webhook_n8n_service', isset($department) ? $department->webhook_n8n_service : '') }}" placeholder="Ex.: https://n8n.example.com">

                            @error('cnpj')
                                <div class="alert alert-warning small mt-1">{{ $message }}</div>
                            @enderror
                        </div>


                        {{-- WEBHOOK N8N ORDER--}}
{{--
                        <div class="form-password-toggle col-md-12 mt-5">
                            <label class="form-label" for="cnpj">Webhook N8N Demanda</label>
                            <input type="text" name="webhook_n8n_order" class="form-control" value="{{ old('webhook_n8n_order', isset($department) ? $department->webhook_n8n_order : '') }}" placeholder="Ex.: https://n8n.example.com">

                            @error('cnpj')
                                <div class="alert alert-warning small mt-1">{{ $message }}</div>
                            @enderror
                        </div> --}}

                        {{-- WEBHOOK N8N CAMPAIGN--}}
{{--
                        <div class="form-password-toggle col-md-12 mt-5">
                            <label class="form-label" for="cnpj">Webhook N8N Campanha</label>
                            <input type="text" name="webhook_n8n_campaign" class="form-control" value="{{ old('webhook_n8n_campaign', isset($department) ? $department->webhook_n8n_campaign : '') }}" placeholder="Ex.: https://n8n.example.com">

                            @error('cnpj')
                                <div class="alert alert-warning small mt-1">{{ $message }}</div>
                            @enderror
                        </div> --}}

                    </div>

                        <br>

                        <div class="pt-6 mt-3 d-flex justify-content-end">
                            <a href="{{ route('admin.departments.index') }}" class="btn btn-label-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary ms-3">Cadastrar</button>
                        </div>
                </form>
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

            $('input[name="cep"]').change('input', function() {
                let cep = $(this).val().replace(/\D/g, ''); //deixa o cep so com numero pra requisicao!!!

                if (cep.length === 8) {
                    $.getJSON(`https://viacep.com.br/ws/${cep}/json/`, function(data) {
                        if (!data.erro) {

                            $('#uf').val(data.uf).trigger('change');
                            $('input[name="cidade"]').val(data.localidade);
                            $('input[name="bairro"]').val(data.bairro);
                            $('input[name="rua"]').val(data.logradouro);
                            $('input[name="numero"]').val(data.complemento);
                            $('input[name="complemento"]').val(data.unidade);

                            // $('#uf').val(data.uf).removeAttr('disabled');
                            // $('input[name="cidade"').removeAttr('disabled');

                            console.log($('input[name="cidade"]').val());
                        } else {
                            alert('CEP não encontrado!');
                            $('input[name="cep"]').val('');
                        }
                    }).fail(function() {
                        alert('Erro ao buscar CEP!');
                    });
                }
            });
        });
    </script>

    {{-- função pra remover o disabled do campo cidade e uf --}}
    <script>
        document.getElementById('form-cadastro').addEventListener('submit', function(event) {
           document.querySelectorAll('input[disabled], select[disabled]').forEach(function(input) {
               input.removeAttribute('disabled');
           });
       });
   </script>

@endpush
