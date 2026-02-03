@extends('app')

@section('title') Cadastrar Usuário no sitema - {{env('APP_NAME')}} @endsection

@push('styles')
<link href="{{ asset('assets/vendor/libs/select2/select2.css') }}" rel="stylesheet" type="text/css" />
@endpush

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
        <li class="breadcrumb-item active">Cadastrar</li>
    </ol>
</nav>
<!-- Basic Breadcrumb -->

<!-- INÍCIO CONTAINER PRINCIPAL -->
<div class="row">



    <!-- Basic with Icons -->
    <div class="col-12">

        <div class="card mb-6">

            @include('_inc.alerts')

            <div class="card-header pt-4 pb-0 d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Cadastro de usuários</h5>
            </div>

            <div class="">
                <hr>
            </div>

            <div class="card-body pt-2">
                <form class="form" action="{{ route('admin.user.store') }}" method="POST">
                    @csrf

                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <label class="form-label" for="basic-icon-default-fullname">Nome</label>

                            <div class="input-group input-group-merge">

                                <input name="name" value="{{ old('name') }}" type="text" class="form-control"
                                    id="basic-icon-default-fullname" placeholder="João de Maria" aria-label="João de Maria"
                                    aria-describedby="basic-icon-default-fullname2" />
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label class="form-label" for="basic-icon-default-fullname">WhatsApp</label>

                            <div class="input-group input-group-merge">

                                <input name="phone" value="{{ old('phone') }}" type="text"
                                    class="form-control phone_with_ddd" id="basic-icon-default-fullname"
                                    placeholder="(xx) xxxxx-xxxx" aria-label=""
                                    aria-describedby="basic-icon-default-fullname2" />
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <label class="form-label" for="basic-icon-default-email">E-mail</label>
                            <div class="input-group input-group-merge">
                                <input name="email" value="{{ old('email') }}" type="email" id="basic-icon-default-email"
                                    class="form-control" placeholder="joaomaria@gmail.com" aria-label="joaomaria@gmail.com"
                                    aria-describedby="basic-icon-default-email2" />

                            </div>

                        </div>
                    </div>

                
                    <br>

                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-email">Senha</label>

                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">

                                <span class="input-group-text"><i class="menu-icon icon-base ti tabler-fingerprint"></i></span>

                                <input name="password" type="password" id="basic-icon-default-email" class="form-control"
                                    placeholder="******" aria-label="******" aria-describedby="basic-icon-default-email2" />

                            </div>

                            <div class="form-text">Informe uma senha com 8 caracteres e mistura com símbolos, letras maiúsculas
                                e minusculas.</div>

                        </div>
                    </div>

                    <br>

                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="multicol-country">Status</label>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-md mb-md-0 mb-5">
                                    <div class="form-check custom-option custom-option-basic">
                                        <label class="form-check-label custom-option-content" for="customRadioTemp1">
                                            <input name="is_ativo" class="form-check-input" type="radio" value="Inativo"
                                                id="customRadioTemp1" checked />
                                            <span class="custom-option-header">
                                                <span class="h6 mb-0">Inativo</span>
                                            </span>
                                            <span class="custom-option-body">
                                                <small>Não consegue acessar o sistema.</small>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-basic">
                                        <label class="form-check-label custom-option-content" for="customRadioTemp2">
                                            <input name="is_ativo" class="form-check-input" type="radio" value="Ativo"
                                                id="customRadioTemp2" />
                                            <span class="custom-option-header">
                                                <span class="h6 mb-0">Ativo</span>
                                            </span>
                                            <span class="custom-option-body">
                                                <small>Acessa normamente o sistema.</small>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div><!-- fim div row -->


                        </div>
                    </div>

                    <br>

                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="nivel">Nível</label>
                        <div class="col-sm-10">
                            <select name="role" id="role" class="select2 form-select" data-allow-clear="true">
                                <option value="">Selecione um Nível</option>

                                <option value="Padrão" {{ old('role')=='Padrão' ? 'selected' : '' }}>Padrão</option>
                                
                                <option value="Administrador" {{ old('role') == 'Administrador' ? 'selected' : '' }}>Administrador</option>

                                @if ( auth()->user()->role == 'SuperAdmin' )
                                <option value="SuperAdmin" {{ old('role')=='SuperAdmin' ? 'selected' : '' }}>Super Admin</option>
                                @endif

                            </select>
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-sm-10 d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.user.index') }}" class="btn btn-label-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Cadastrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
<!-- FIM CONTAINER PRINCIPAL -->

@endsection

@push('scripts')
<script src="{{ asset('assets/js/form-layouts.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"
    integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).ready(function() {
        $('.cep').mask('00000-000');
        $('.phone_with_ddd').mask('(00) 00000-0000');
        $('.cpf').mask('000.000.000-00', {
            reverse: true
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#nivel').select2({
            placeholder: 'Selecione um nivel',
            allowClear: true
        });
    });
</script>
@endpush