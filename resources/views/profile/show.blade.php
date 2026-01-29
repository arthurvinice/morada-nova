@extends('app')

@section('title')
    Perfil
@endsection

@section('content')
    <h4 class="py-3 mb-4">Meu perfil</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="nav-align-top mb-4">
                <ul class="nav nav-pills mb-3 nav-fill" role="tablist">

                    <li class="nav-item">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-justified-detalhes" aria-controls="navs-pills-justified-detalhes"
                            aria-selected="true">
                            <i class="menu-icon icon-base ti tabler-user-circle"></i>
                            Informações Básicas
                        </button>
                    </li>

                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-justified-profile" aria-controls="navs-pills-justified-profile"
                            aria-selected="false">
                            <i class="menu-icon icon-base ti tabler-lock"></i>
                            Segurança
                        </button>
                    </li>

                    {{-- <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-justified-messages" aria-controls="navs-pills-justified-messages"
                            aria-selected="false">
                            <i class="menu-icon icon-base ti tabler-bell"></i>
                            Notificações
                        </button>
                    </li> --}}

                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="navs-pills-justified-detalhes" role="tabpanel">
                        <div class="mb-4">
                            <h5 class="card-header">Detalhes do seu perfil</h5>
                            <!-- Account -->

                            @if (session('success'))
                                <div class="p-3">
                                    <div class="alert alert-success d-flex align-items-center" role="alert">
                                        <span class="alert-icon text-success me-2">
                                            <i class="ti ti-check ti-xs"></i>
                                        </span>
                                        {{ session('success') }}
                                    </div>
                                </div>
                                {{-- fim div alert --}}
                            @endif

                            @if (session('warning'))
                                <div class="p-3">
                                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                                        <span class="alert-icon text-warning me-2">
                                            <i class="ti ti-warning ti-xs"></i>
                                        </span>
                                        {{ session('warning') }}
                                    </div>
                                </div>
                                {{-- fim div alert --}}
                            @endif

                            <hr class="my-3" />

                            <div class="card-body">
                                <form id="formAccountSettings" action="{{ route('admin.user.perfil.update', $user->id) }}"
                                    method="POST">

                                    @csrf
                                    @method('PUT')

                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label for="firstName" class="form-label">Nome</label>
                                            <input class="form-control @error('name') is-invalid @enderror" type="text"
                                                id="name" name="name" value="{{ $user->name }}" autofocus />
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label for="email" class="form-label">E-mail</label>
                                            <input class="form-control @error('email') is-invalid @enderror" type="text"
                                                id="email" name="email" value="{{ $user->email }}"
                                                placeholder="joao@examplo.com" />

                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="mt-2">
                                        <button type="submit" class="btn btn-primary me-2">Atualizar</button>
                                        <button type="reset" class="btn btn-label-secondary">Cancelar</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /Account -->
                        </div>
                    </div>
                    {{-- FIm tab Informações Básicas --}}

                    <div class="tab-pane fade" id="navs-pills-justified-profile" role="tabpanel">
                        <div class="mb-4">
                            <h5 class="card-header">Segurança do seu perfil</h5>
                            <!-- Account -->

                            <hr class="my-3" />

                            <div class="card-body">
                                <form id="formPasswordSettings" method="POST"
                                    action="{{ route('admin.user.perfil.updatePassword', $user->id) }}">

                                    @csrf
                                    @method('PUT')

                                    <div class="row">
                                        <div class="mb-3 col-md-6 form-password-toggle">
                                            <label class="form-label" for="currentPassword">Senha atual</label>
                                            <div class="input-group input-group-merge">
                                                <input class="form-control @error('currentPassword') is-invalid @enderror"
                                                    type="password" value="{{ old('currentPassword') }}"
                                                    name="currentPassword" id="currentPassword" placeholder="******" />
                                                <span class="input-group-text cursor-pointer"><i
                                                        class="menu-icon icon-base ti tabler-eye-off"></i></span>

                                                @error('currentPassword')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-md-6 form-password-toggle">
                                            <label class="form-label" for="password">Nova senha</label>
                                            <div class="input-group input-group-merge">
                                                <input class="form-control @error('password') is-invalid @enderror"
                                                    type="password" value="{{ old('password') }}" id="password"
                                                    name="password" placeholder="******" />
                                                <span class="input-group-text cursor-pointer"><i
                                                        class="menu-icon icon-base ti tabler-eye-off"></i></span>

                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-3 col-md-6 form-password-toggle">
                                            <label class="form-label" for="password_confirmation">Confirmar Nova
                                                senha</label>
                                            <div class="input-group input-group-merge">
                                                <input
                                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                                    type="password" value="{{ old('password_confirmation') }}"
                                                    name="password_confirmation" id="password_confirmation"
                                                    placeholder="******" />
                                                <span class="input-group-text cursor-pointer"><i
                                                        class="menu-icon icon-base ti tabler-eye-off"></i></span>

                                                @error('password_confirmation')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12 mb-4">
                                            <h6>Dica de senha forte:</h6>
                                            <ul class="ps-3 mb-0">
                                                <li class="mb-1">Use no mínimo 8 caracteres - quanto mais melhor</li>
                                                <li class="mb-1">Misture caractes minúsculos e maiúsculos</li>
                                                <li>Use símbolos como: @ # + *</li>
                                            </ul>
                                        </div>

                                        <div>
                                            <button type="submit" class="btn btn-primary me-2">Atualizar senha</button>
                                            <button type="reset" class="btn btn-label-secondary">Cancelar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /Account -->
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
