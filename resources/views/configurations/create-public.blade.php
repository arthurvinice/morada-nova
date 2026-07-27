<!doctype html>

<html lang="pt-br" data-skin="default" data-assets-path="{{ asset('assets') }}/" data-bs-theme="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Morada Nova - Cadastro</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/morada-nova-logo.ico') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/iconify-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @livewireStyles
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <div class="layout-page">

                <div class="px-3 pt-3 pb-4">
                    <div class="d-flex justify-content-end mb-3">
                        <li class="nav-item dropdown list-unstyled m-0">
                            <a class="nav-link dropdown-toggle hide-arrow btn btn-icon btn-text-secondary rounded-pill"
                                href="javascript:void(0);" data-bs-toggle="dropdown">
                                <i class="icon-base ti tabler-sun icon-22px text-heading"></i>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <button type="button" class="dropdown-item align-items-center active"
                                        data-bs-theme-value="light">
                                        <i class="icon-base ti tabler-sun icon-22px me-3"></i>Claro
                                    </button>
                                </li>
                                <li>
                                    <button type="button" class="dropdown-item align-items-center"
                                        data-bs-theme-value="dark">
                                        <i class="icon-base ti tabler-moon-stars icon-22px me-3"></i>Escuro
                                    </button>
                                </li>
                            </ul>
                        </li>
                    </div>

                    <div class="text-center">
                        <img src="{{ asset('assets/img/morada-nova-logo-removebg.png') }}" class="img-fluid"
                            alt="Morada Nova" style="max-width: 280px; width: 70%;">
                    </div>
                </div>

                <div class="content-wrapper d-flex flex-column">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            @include('_inc.alerts')

                            <div class="col-xl mb-6">
                                <div class="card p-4">
                                    <div class="card-header d-flex flex-column align-items-center justify-content-center pb-0">
                                        <h3 class="ms-2">Crie sua conta e comece a gerenciar seus imóveis</h3>
                                        <p class="ms-2">Cadastre-se gratuitamente para começar.</p>
                                    </div>
                                    <hr>

                                    @livewire('configuration.create-public')
                                </div>
                            </div>
                        </div>
                    </div>

                    <footer class="content-footer footer bg-footer-theme mt-auto">
                        <div class="container-fluid">
                            <div class="footer-container d-flex align-items-center justify-content-center py-4">
                                <div class="text-body">
                                    © <script>document.write(new Date().getFullYear());</script>,
                                    feito por <a href="https://github.com/arthurvinice" target="_blank" class="footer-link">Arthur Vinícius</a>
                                </div>
                            </div>
                        </div>
                    </footer>

                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>

        <div class="layout-overlay layout-menu-toggle"></div>
        <div class="drag-target"></div>
    </div>

    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const themeButtons = document.querySelectorAll('[data-bs-theme-value]');

            themeButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const theme = this.getAttribute('data-bs-theme-value');
                    document.documentElement.setAttribute('data-bs-theme', theme);
                    themeButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    localStorage.setItem('theme', theme);
                });
            });

            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-bs-theme', savedTheme);

            const activeButton = document.querySelector(`[data-bs-theme-value="${savedTheme}"]`);
            if (activeButton) {
                themeButtons.forEach(btn => btn.classList.remove('active'));
                activeButton.classList.add('active');
            }
        });
    </script>

    @livewireScripts
</body>

</html>