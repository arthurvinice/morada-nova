@extends('app')

@section('title') Editar Usuário no sitema - {{env('APP_NAME')}} @endsection

@push('styles')
    <link href="{{ asset('assets/vendor/libs/select2/select2.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')

<!-- Basic Breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="javascript:void(0);">Início</a>
        </li>
        <li class="breadcrumb-item">
            <a href="javascript:void(0);">Editar Usuário</a>
        </li>
        <li class="breadcrumb-item active">{{ $user->name }}</li>
    </ol>
</nav>
<!-- Basic Breadcrumb -->

<!-- INÍCIO CONTAINER PRINCIPAL -->
<div class="row">
    <!-- Basic with Icons -->
    <div class="col-12">

        @include('_inc.alerts')

        <div class="card mb-6">

            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Editar o perfil de {{ $user->name }}</h5>
            </div>

            <div class="card-body">
                <form class="form" action="{{ route('admin.user.perfil.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Nome</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-fullname2" class="input-group-text"><i class="menu-icon icon-base ti tabler-user"></i></span>

                                <input name="name" value="{{ $user->name }}" type="text" class="form-control" id="basic-icon-default-fullname"
                                    placeholder="João de Maria" aria-label="João de Maria"
                                    aria-describedby="basic-icon-default-fullname2" />


                            </div>

                            @error('name')
                                <div class="alert alert-warning small mt-1">{{ $message }}</div>
                            @enderror

                        </div>
                    </div>

                    <br>

                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">WhatsApp</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-fullname2" class="input-group-text">
                                    <i class="menu-icon icon-base ti tabler-brand-whatsapp"></i>
                                </span>

                                <input name="phone" value="{{ $user->phone }}" type="text" class="form-control phone_with_ddd" id="basic-icon-default-fullname"
                                    placeholder="(xx) xxxxx-xxxx" aria-label="João de Maria"
                                    aria-describedby="basic-icon-default-fullname2" />
                            </div>

                            @error('phone')
                                <div class="alert alert-warning small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <br>

                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-email">E-mail</label>

                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">

                                <span class="input-group-text"><i class="menu-icon icon-base ti tabler-mail"></i></span>

                                <input name="email" value="{{ $user->email }}" type="email" id="basic-icon-default-email" class="form-control"
                                    placeholder="joaomaria@gmail.com" aria-label="joaomaria@gmail.com"
                                    aria-describedby="basic-icon-default-email2" />

                            </div>

                            <div class="form-text">Informe um e-mail válido</div>

                            @error('email')
                                <div class="alert alert-warning small mt-1">{{ $message }}</div>
                            @enderror

                        </div>
                    </div>

                    <br>

                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-email">Senha</label>

                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">

                                <span class="input-group-text"><i class="menu-icon icon-base ti tabler-fingerprint"></i></span>

                                <input name="password" type="password" id="basic-icon-default-email" class="form-control"
                                    placeholder="******" aria-label="******"
                                    aria-describedby="basic-icon-default-email2" />

                            </div>

                            <div class="form-text">Informe uma senha com 8 caracteres e mistura com símbolos, letras maiúsculas e minusculas.</div>

                            @error('password')
                                <div class="alert alert-warning small mt-1">{{ $message }}</div>
                            @enderror

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
                                            <input name="status" class="form-check-input" type="radio" value="inactive" id="customRadioTemp1"
                                                {{ $user->status == 'inactive' ? 'checked' : '' }} />
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
                                            <input name="status" class="form-check-input" type="radio" value="active" id="customRadioTemp2"
                                            {{ $user->status == 'active' ? 'checked' : '' }}/>
                                            <span class="custom-option-header">
                                                <span class="h6 mb-0">Ativo</span>
                                            </span>
                                            <span class="custom-option-body">
                                                <small>Acessa normamente o sistema.</small>
                                            </span>
                                        </label>
                                    </div>
                                </div>

                                @error('status')
                                    <div class="alert alert-warning small mt-1">{{ $message }}</div>
                                @enderror

                            </div><!-- fim div row -->


                        </div>
                    </div>

                    <br>

                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="role-user">Nível</label>
                        <div class="col-sm-10">
                            <select name="role" id="role-user" class="select2 form-select" data-allow-clear="true">

                                <option value="">Selecione um Nível</option>
                                <option value="Padrão" {{ $user->role =='Padrão' ? 'selected' : '' }}>Padrão</option>
                                
                                <option value="Administrador" {{ $user->role == 'Administrador' ? 'selected' : '' }}>Administrador</option>

                                @if ( Auth::user()->role == 'SuperAdmin')

                                    <option value="SuperAdmin" {{ $user->role == 'SuperAdmin' ? 'selected' : '' }}>SuperAdmin</option>

                                @endif

                            </select>

                            @error('role')
                                <div class="alert alert-warning small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <br>

                    <div class="row justify-content-end">
                        <div class="col-sm-10 d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.user.index') }}" class="btn btn-label-secondary">Voltar</a>
                            <button type="submit" class="btn btn-primary">Atualizar</button>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function(){
            $('.cep').mask('00000-000');
            $('.phone_with_ddd').mask('(00) 00000-0000');
            $('.cpf').mask('000.000.000-00', {reverse: true});
        });
    </script>
@endpush
