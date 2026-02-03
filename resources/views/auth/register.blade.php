<!doctype html>

<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="../../assets/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Morada Nova - Gestão Imobiliária</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/morada-nova-logo.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="../../assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="../../assets/vendor/fonts/tabler-icons.css" />
    {{-- <link rel="stylesheet" href="../../assets/vendor/fonts/flag-icons.css" /> --}}

    <!-- Core CSS -->
    <link rel="stylesheet" href="../../assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../../assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../../assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/typeahead-js/typeahead.css" />
    <!-- Vendor -->
    <link rel="stylesheet" href="../../assets/vendor/libs/@form-validation/form-validation.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="../../assets/vendor/css/pages/page-auth.css" />

    <!-- Helpers -->
    <script src="../../assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="../../assets/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../../assets/js/config.js"></script>
</head>

<body>
    <!-- Content -->

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <!-- Register Card -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-4 mt-2">
                            <img src="{{ asset('assets/img/morada-nova-logo-removebg.png')}}" alt="img-fluid mb-4" width="100">

                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-1 pt-2 text-center">Morada Nova - Gestão Imobiliária</h4>

                        @if($errors->all())

                        @foreach($errors->all() as $error)
                        <div class="alert alert-danger">
                            {{ $error }}
                        </div>
                        @endforeach

                        @endif

                        <form id="formAuthentication" class="mb-3" action="/register" method="post">

                            @csrf

                            <div class="mb-3">
                                <label for="username" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Seu nome" autofocus />
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="text" class="form-control" id="email" name="email"
                                    placeholder="Seu e-mail" />
                            </div>

                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="password">Senha</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                </div>
                            </div>

                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="password">Confirme Senha</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password_confirmation"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms" />
                                    <label class="form-check-label" for="terms-conditions">
                                        Eu aceito os
                                        <button type="button"
                                            class="btn btn-link p-0 align-baseline"
                                            data-bs-toggle="modal"
                                            data-bs-target="#termsModal">
                                            Termos de Uso
                                        </button>
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary d-grid w-100">Cadastrar</button>
                        </form>

                        <p class="text-center">
                            <span>Já tem uma conta?</span>
                            <a href="/login">
                                <span>Acesse aqui</span>
                            </a>
                        </p>

                    </div>
                </div>
                <!-- Register Card -->
                <div class="modal fade" id="termsModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title">
                                    Termos de Uso – SEMABET (Uso Acadêmico)
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body">

                                <p>
                                    O <strong>SEMABET</strong> é um sistema de apostas
                                    <strong>exclusivamente acadêmico</strong>, desenvolvido para fins
                                    educacionais no contexto das competições escolares do
                                    <strong>IFRN</strong>.
                                </p>

                                <p>
                                    Este sistema não envolve dinheiro real, prêmios financeiros,
                                    transações bancárias ou qualquer forma de ganho econômico.
                                </p>

                                <h6><strong>1. Natureza Fictícia</strong></h6>
                                <p>
                                    Todas as apostas, valores, créditos e resultados apresentados são
                                    totalmente fictícios, utilizados apenas para simulação e estudo.
                                </p>

                                <h6><strong>2. Finalidade Educacional</strong></h6>
                                <p>
                                    O sistema tem como objetivo o aprendizado de programação,
                                    desenvolvimento web, banco de dados e lógica de sistemas.
                                </p>

                                <h6><strong>3. Público-Alvo</strong></h6>
                                <p>
                                    Destina-se exclusivamente a estudantes, professores e participantes
                                    autorizados em atividades acadêmicas do IFRN.
                                </p>

                                <h6><strong>4. Proibições</strong></h6>
                                <ul>
                                    <li>Uso para apostas reais</li>
                                    <li>Uso comercial ou financeiro</li>
                                    <li>Associação com casas de apostas reais</li>
                                </ul>

                                <h6><strong>5. Responsabilidade</strong></h6>
                                <p>
                                    Os desenvolvedores e o IFRN não se responsabilizam por usos indevidos
                                    fora do contexto educacional.
                                </p>

                                <p class="mt-3">
                                    Ao aceitar estes termos, o usuário reconhece o caráter
                                    <strong>exclusivamente acadêmico e fictício</strong> do sistema.
                                </p>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal">
                                    Fechar
                                </button>

                                <button type="button" class="btn btn-primary"
                                    onclick="acceptTerms()">
                                    Aceitar Termos
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../../assets/vendor/libs/popper/popper.js"></script>
    <script src="../../assets/vendor/js/bootstrap.js"></script>
    <script src="../../assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../../assets/vendor/libs/hammer/hammer.js"></script>
    <script src="../../assets/vendor/libs/i18n/i18n.js"></script>
    <script src="../../assets/vendor/libs/typeahead-js/typeahead.js"></script>
    {{-- <script src="../../assets/vendor/js/menu.js"></script> --}}

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="../../assets/vendor/libs/@form-validation/popular.js"></script>
    <script src="../../assets/vendor/libs/@form-validation/bootstrap5.js"></script>
    <script src="../../assets/vendor/libs/@form-validation/auto-focus.js"></script>

    <!-- Main JS -->
    <script src="../../assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="../../assets/js/pages-auth.js"></script>

    <script>
        function acceptTerms() {
            const checkbox = document.getElementById('terms-conditions');
            checkbox.checked = true;

            const modal = bootstrap.Modal.getInstance(
                document.getElementById('termsModal')
            );
            modal.hide();
        }
    </script>

</body>

</html>