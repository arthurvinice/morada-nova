@extends('app')

@section('title')
    Dashboard
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    <link href="{{ asset('assets/vendor/libs/select2/select2.css') }}" rel="stylesheet" />

    <style>
        /* Estilo geral do Select2 */
        .select2-container--default .select2-selection--single {
            height: calc(1.5em + 1.25rem + 2px);
            padding: 0.625rem 0.75rem;
            font-size: 0.9375rem;
            font-weight: 400;
            line-height: 1.5;
            color: #6e6b7b;
            background-color: #fff;
            border: 1px solid #d8d6de;
            border-radius: 0.357rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        /* Ajuste do container */
        .select2-container {
            width: 100% !important;
        }

        /* Ajuste da seta dropdown */
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100%;
            right: 11px;
        }

        /* Ajuste do texto dentro do select */
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 1.25em !important;
            padding-left: 0;
            color: #6e6b7b;
        }

        /* Estilo do dropdown */
        .select2-dropdown {
            border: 1px solid #d8d6de;
            border-radius: 0.357rem;
        }

        /* Estilo do resultado da busca */
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #7367f0;
            color: white;
        }

        /* Estilo do input de busca */
        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid #d8d6de;
            border-radius: 0.357rem;
            padding: 0.438rem 1rem;
        }

        /* Estilo quando o select está focado */
        .select2-container--default.select2-container--focus .select2-selection--single,
        .select2-container--default.select2-container--open .select2-selection--single {
            border-color: #7367f0;
            box-shadow: 0 3px 10px 0 rgba(34, 41, 47, 0.1);
        }

        /* Estilo para select disabled */
        .select2-container--default.select2-container--disabled .select2-selection--single {
            background-color: #efefef;
            border-color: #d8d6de;
        }

        /* Ajustes para Select2 em modais */
        /* .modal {
                z-index: 1050;
            }

            .select2-container {
                z-index: 1060;
            }

            .select2-container--open {
                z-index: 1060;
            }

            .select2-dropdown {
                z-index: 1060;
            } */

        /* Correção para o dropdown do Select2 dentro do modal */
        /* .modal-open .select2-container--open .select2-dropdown {
                z-index: 1060;
            } */

        /* Corrigir z-index dos elementos */
        .modal-backdrop {
            z-index: 1050;
        }

        .modal {
            z-index: 1055;
        }

        .select2-container--open {
            z-index: 1056 !important;
        }

        .select2-dropdown {
            z-index: 1056 !important;
        }

        /* Garantir que o modal esteja visível */
        .modal-dialog {
            margin: 1.75rem auto;
        }

        /* Corrigir posicionamento do dropdown do Select2 */
        .select2-container--default .select2-results>.select2-results__options {
            max-height: 200px;
            overflow-y: auto;
        }
    </style>
@endpush

@section('content')
    @include('_inc.alerts')

    <div class="row my-5">
        <!-- Hour chart  -->
        <div class="card bg-transparent shadow-none mb-5 border-0">
            <div class="card-body row p-0 pb-0 g-6">
                <div class="col-12 col-lg-10 card-separator">
                    <div class="d-flex justify-content-between flex-wrap gap-4 me-12">
                        <div class="d-flex align-items-center gap-4 me-6 me-sm-0">
                            <div class="avatar avatar-lg">
                                <div class="avatar-initial bg-label-primary rounded">
                                    <div>
                                        <img src="{{ asset('assets/svg/icons/calendario.svg') }}" alt="paypal"
                                            class="img-fluid" />
                                    </div>
                                </div>
                            </div>
                            <div class="content-right">
                                <p class="mb-0 fw-medium">Marcados para hoje</p>
                                <h4 class="text-primary mb-0"></h4>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-4">
                            <div class="avatar avatar-lg">
                                <div class="avatar-initial bg-label-info rounded">
                                    <div>
                                        <img src="{{ asset('assets/svg/icons/calendario-semana.svg  ') }}" alt="Lightbulb"
                                            class="img-fluid" />
                                    </div>
                                </div>
                            </div>
                            <div class="content-right">
                                <p class="mb-0 fw-medium">Marcados para a semana</p>
                                <h4 class="text-info mb-0"></h4>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-4">
                            <div class="avatar avatar-lg">
                                <div class="avatar-initial bg-label-warning rounded">
                                    <div>
                                        <img src="{{ asset('assets/svg/icons/calendario-mes.svg') }}" alt="Check"
                                            class="img-fluid" />
                                    </div>
                                </div>
                            </div>
                            <div class="content-right">
                                <p class="mb-0 fw-medium">Atendidos no mês</p>
                                <h4 class="text-warning mb-0"></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-2 ps-md-4 ps-lg-6">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <button type="button" class="btn btn-primary btn-md mt-2" data-bs-toggle="modal"
                                data-bs-target="#serviceModal">
                                <i class="menu-icon icon-base ti tabler-calendar"></i> Agendar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hour chart End  -->
    </div> <!-- ROW -->


    <div class="row">
        <div class="col-9">
            <!-- Hoverable Table rows -->
            <div class="card p-3">
                <h5 class="card-header">Demandas pendentes</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Categoria</th>
                                <th>Responsável</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        {{-- @dd($ultimasDemandasAbertas) --}}
                        <tbody class="table-border-bottom-0">


                        </tbody>
                    </table>

                </div>

            </div>
            <!--/ Hoverable Table rows -->

        </div><!-- COL-8 -->

        <div class="col-3">

            <!-- Hoverable Table rows -->
            <div class="card p-3">
                <h5 class="card-header">Gráfico Demandas</h5>
                    <div id="demandasChart">

                    </div>

            </div>
            <!--/ Hoverable Table rows -->

        </div><!-- COL-4 -->

    </div><!-- ROW -->
    <div class="row mt-5">

        {{-- GRAFICO GÊNERO --}}

        <div class="col-4">

            <div class="card" style="height: 400.5px">
                <div class="card-header">
                    <h5 class="mb-0 pb-0">Distribuição por Gênero</h5>
                </div>
                <div class="card-body d-flex justify-content-center align-items-center flex-column ">
                    <div class="mt-2 mb-2" id="graficoGenero" style="min-height: 300px;"></div>
                    <h6 class="mt-2 mb-1">Total de Pessoas: </h6>
                </div>
            </div>

        </div>

        {{-- TABELA AGENDAMENTOS --}}
        <div class="col-8">
            <!-- Hoverable Table rows -->
            <div class="card p-3">
                <h5 class="card-header">Agendamentos</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Data</th>
                                <th>Status</th>
                                <th>Whatsapp</th>
                            </tr>
                        </thead>

                        <tbody class="table-border-bottom-0">


                        </tbody>
                    </table>

                </div>

            </div>
            <!--/ Hoverable Table rows -->

        </div><!-- COL-8 -->
    </div>

    <div class="row">
        <div class="col-12">
            <hr class="mt-5 mb-2">
        </div>
    </div> <!-- ROW -->

    {{-- ANIVERSARIANTES --}}
    {{-- <div class="row">
        <div class="col-12 p-3">
            <!-- Hoverable Table rows -->
            <div class="card p-3">
                <h5 class="card-header">Aniversariantes do Dia</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Data</th>
                                <th>Telefone</th>
                                <th>Idade</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">

                            @foreach ($aniversariantesDoDia as $anviersariante)
                                <tr>
                                    <td>Maria José</td>
                                    <td>
                                        {{ date('d/m/Y', strtotime(today())) }}
                                    </td>

                                    <td>
                                        (**)
                                        *.****6142
                                        <a href="https://wa.me/5584998189508?text=%F0%9F%8E%89%20Parab%C3%A9ns%20pelo%20seu%20dia!%20%F0%9F%8E%82%0AO%20gabinete%20da%20Vice-Prefeita%20Milena%20Galv%C3%A3o%20deseja%20a%20voc%C3%AA%20um%20anivers%C3%A1rio%20repleto%20de%20alegrias%2C%20sa%C3%BAde%20e%20realiza%C3%A7%C3%B5es.%20Que%20este%20novo%20ciclo%20seja%20de%20muitas%20conquistas!%20%E2%9C%A8%F0%9F%92%90"
                                            target="_blank"
                                            class="ml-2 btn btn-xs btn-primary mt-2 waves-effect waves-light">
                                            <i class="menu-icon tf-icons ti ti-send"></i> Enviar
                                        </a>
                                    </td>

                                    <td>
                                        51 Anos
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>

            </div>
            <!--/ Hoverable Table rows -->

        </div><!-- COL-8 -->
    </div> <!-- ROW --> --}}
{{--
    <div class="row">
        <div class="col-12">
            <hr class="mt-2 mb-6">
        </div>
    </div> --}}

    <!-- ROW -->
    {{-- PARTE DE AGENDAMENTOS --}}
    {{-- <div class="row">

        <div class="col-4">

            <!-- Hoverable Table rows -->
            <div class="card p-3">
                <h5 class="card-header">Pessoas Cadastradas</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Telefone</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">

                            @foreach ($people as $p)
                                <tr>
                                    <td> <a href="{{ route('admin.people.edit', $p->id) }}"> {{ $p->nome }}</a></td>
                                    <td>{{ substr_replace($p->whatsapp, '(**)*.****', 0, -4) }}</td>
                                </tr>
                            @endforeach


                        </tbody>
                    </table>

                </div>

            </div>
            <!--/ Hoverable Table rows -->

        </div><!-- COL-4 -->
    </div> --}}
    <!-- Modal -->
    {{-- <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Agendar um atendimento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <form class="card-body" action="{{ route('admin.service.store') }}" method="POST">
                            @csrf

                            <h4>Informações do agendamento</h4>

                            <div class="row g-6">
                                <div class="col-md-4">
                                    <label class="form-label" for="pessoa_id">Nome</label>
                                    <select class="form-control select2 form-select select2-people" name="pessoa_id" id="pessoa_id"
                                        data-allow-clear="true" required>
                                        @if (old('pessoa_id'))
                                        <option value="{{ old('pessoa_id') }}" selected>
                                            {{ \App\Models\People::find(old('pessoa_id'))->nome }}
                                        </option>
                                        @endif
                                    </select>

                                    @error('pessoa_id')
                                        <div class="alert alert-warning small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label" for="multicol-last-name">Data</label>
                                    <input type="datetime-local" name="data" id="multicol-last-name" class="form-control" placeholder="" />

                                    @error('data')
                                    <div class="alert alert-warning small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                            <div class="col-md-3">
                                    <label class="form-label" for="user_id">Pessoa que fez indicação</label>
                                    <select class="form-control select2 form-select select2-users" name="user_id" id="user_id">
                                        @if (old('user_id'))
                                        <option value="{{ old('user_id') }}" selected>
                                            {{ \App\Models\User::find(old('user_id'))->name }}
                                        </option>
                                        @endif
                                    </select>

                                    @error('user_id')
                                        <div class="alert alert-warning small mt-1">{{ $message }}</div>
                                    @enderror

                                </div>

                                <div class="col-md-3">
                                    <label class="form-label" for="categoria">Categoria</label>
                                    <select id="categoria" name="categoria_id" class="select2 form-select" data-allow-clear="true">
                                        <option value="">Selecione uma categoria</option>

                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->titulo }}</option>
                                        @endforeach
                                    </select>

                                    @error('categoria_id')
                                    <div class="alert alert-warning small mt-1">{{ $message }}</div>
                                    @enderror

                                </div>

                                <br>

                                <div class="col-md-12 mt-3">
                                    <label class="form-label" for="multicol-email">Observação</label>

                                    <div class="input-group input-group-merge">
                                        <textarea name="observacao" placeholder="Informe aqui algo básico sobre o agendamento"
                                            class="form-control" cols="30" rows="5"></textarea>
                                    </div>
                                </div>

                                <br>

                                <div class="row my-5">
                                    <label class="col-sm-2 col-form-label" for="multicol-country">Confirmar o agendamento</label>
                                    <div class="col-sm-10">
                                        <div class="form-check custom-option custom-option-basic">
                                            <label class="form-check-label custom-option-content" for="customCheckTemp3">
                                                <input name="confirmacao" class="form-check-input" type="checkbox" value="1" id="customCheckTemp3" />
                                                <span class="custom-option-header">
                                                    <span class="h6 mb-0">Confirmar</span>
                                                </span>
                                                <span class="custom-option-body">
                                                    <small class="option-text">Marque esta opção caso a pessoa confirmou a presença no agendamento!</small>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-6 mt-4 d-grid gap-2 col-lg-6 mx-auto">
                                    <button type="submit" class="btn btn-primary me-4">Agendar</button>
                                </div>

                            </div> <!-- FIM ROW -->

                            <hr class="my-6 mx-n4" />

                        </form>

                    </div>
                </div>
            </div>
        /div> --}}

    {{-- modal 2 --}}

    <!-- Modal -->
    <div class="modal fade" id="serviceModal" tabindex="-1" role="dialog" aria-labelledby="serviceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="serviceModalLabel">Novo Agendamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="card-body" action="" method="POST">
                        @csrf

                        <h4>Informações do agendamento</h4>

                        <div class="row g-6">
                            <div class="col-md-8">
                                <label class="form-label" for="pessoa_id">Nome</label>
                                <select class="form-control select2 form-select select2-people" name="pessoa_id"
                                    id="pessoa_id" data-allow-clear="true" required>

                                </select>

                                @error('pessoa_id')
                                    <div class="alert alert-warning small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label" for="multicol-last-name">Data</label>
                                <input type="datetime-local" name="data" id="multicol-last-name" class="form-control"
                                    placeholder="" required />

                                @error('data')
                                    <div class="alert alert-warning small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 my-3">
                                <label class="form-label" for="user_id">Pessoa que fez indicação</label>
                                <select class="form-control select2 form-select select2-users" name="user_id"
                                    id="user_id">

                                </select>

                                @error('user_id')
                                    <div class="alert alert-warning small mt-1">{{ $message }}</div>
                                @enderror

                            </div>

                            <div class="col-md-6 my-3">
                                <label class="form-label" for="categoria">Categoria</label>
                                <select id="categoria" name="categoria_id" class="select2 form-select"
                                    data-allow-clear="true">
                                    <option value="">Selecione uma categoria</option>

                                </select>

                                @error('categoria_id')
                                    <div class="alert alert-warning small mt-1">{{ $message }}</div>
                                @enderror

                            </div>

                            <br>

                            <div class="col-md-12 mt-3">
                                <label class="form-label" for="multicol-email">Observação</label>

                                <div class="input-group input-group-merge">
                                    <textarea name="observacao" placeholder="Informe aqui algo básico sobre o agendamento" class="form-control"
                                        cols="30" rows="5"></textarea>
                                </div>
                            </div>

                            <br>

                            <div class="row my-5">
                                <label class="col-sm-2 col-form-label" for="multicol-country">Confirmar o
                                    agendamento</label>
                                <div class="col-sm-10">
                                    <div class="form-check custom-option custom-option-basic">
                                        <label class="form-check-label custom-option-content" for="customCheckTemp3">
                                            <input name="confirmacao" class="form-check-input" type="checkbox"
                                                value="1" id="customCheckTemp3" />
                                            <span class="custom-option-header">
                                                <span class="h6 mb-0">Confirmar</span>
                                            </span>
                                            <span class="custom-option-body">
                                                <small class="option-text">Marque esta opção caso a pessoa confirmou a
                                                    presença no
                                                    agendamento!</small>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-6 mt-4 d-grid gap-2 col-lg-6 mx-auto">
                                <button type="submit" class="btn btn-primary me-4">Agendar</button>
                            </div>

                        </div> <!-- FIM ROW -->

                        <hr class="my-6 mx-n4" />

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.44.0/apexcharts.min.js"></script>


    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>


    <script>
        function initializeSelect2(modalElement) {
            // Configuração do Select2 para pessoas
            $('.select2-people').each(function() {
                if ($(this).data('select2')) {
                    $(this).select2('destroy');
                }

                $(this).select2({
                    theme: 'default',
                    language: 'pt-BR',
                    ajax: {
                        url: '',
                        dataType: 'json',
                        delay: 250,
                        cache: true,
                        data: function(params) {
                            return {
                                q: params.term || '',
                                page: params.page || 1
                            };
                        },
                        processResults: function(data, params) {
                            params.page = params.page || 1;
                            return {
                                results: data.results,
                                pagination: {
                                    more: false
                                }
                            };
                        },
                    },
                    minimumInputLength: 3,
                    placeholder: 'Buscar pessoa...',
                    allowClear: true,
                    dropdownParent: modalElement || $('body')
                });
            });

            // Configuração do Select2 para usuários
            $('.select2-users').each(function() {
                if ($(this).data('select2')) {
                    $(this).select2('destroy');
                }

                $(this).select2({
                    theme: 'default',
                    language: 'pt-BR',
                    ajax: {
                        url: '',
                        dataType: 'json',
                        delay: 250,
                        cache: true,
                        data: function(params) {
                            return {
                                q: params.term || '',
                                page: params.page || 1
                            };
                        },
                        processResults: function(data, params) {
                            params.page = params.page || 1;
                            return {
                                results: data.results,
                                pagination: {
                                    more: false
                                }
                            };
                        },
                    },
                    minimumInputLength: 2,
                    placeholder: 'Buscar usuário...',
                    allowClear: true,
                    dropdownParent: modalElement || $('body')
                });
            });
        }

        // Aguarde o DOM estar totalmente carregado
        $(document).ready(function() {
            // Inicializa Select2 para elementos fora de modais
            initializeSelect2();

            // Inicializa Select2 quando o modal for aberto
            $('#serviceModal').on('shown.bs.modal', function() {
                initializeSelect2($(this));

                // Forçar focus no primeiro campo após pequeno delay
                setTimeout(function() {
                    $('#serviceModal .select2-people').select2('open');
                }, 200);
            });

            // Garantir que o modal não seja fechado ao clicar dentro dele
            $('#serviceModal .modal-content').on('click', function(e) {
                e.stopPropagation();
            });
        });
    </script>

    {{-- <script>
    function initializeSelect2(modalId) {
        // Configuração do Select2 para pessoas
        $('.select2-people').select2({
            theme: 'default',
            language: 'pt-BR',
            ajax: {
                url: '{{ route("admin.services.search-people") }}',
                dataType: 'json',
                delay: 250,
                cache: true,
                data: function(params) {
                    return {
                        q: params.term || '',
                        page: params.page || 1
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;
                    return {
                    results: data.results,
                        pagination: {
                            more: false
                        }
                    };
                },
            },
            minimumInputLength: 3,
            placeholder: 'Buscar pessoa...',
            allowClear: true,
            dropdownParent: modalId ? $(`#${modalId}`) : $('body')
        }).on('select2:open', function() {
        document.querySelector('.select2-search__field').focus();
        });

        // Configuração do Select2 para usuários
        $('.select2-users').select2({
        theme: 'default',
        language: 'pt-BR',
        ajax: {
            url: '{{ route("admin.services.search-users") }}',
            dataType: 'json',
            delay: 250,
            cache: true,
            data: function(params) {
                return {
                    q: params.term || '',
                    page: params.page || 1
                };
            },
                processResults: function(data, params) {
                    params.page = params.page || 1;
                    return {
                    results: data.results,
                        pagination: {
                            more: false
                        }
                    };
                },
        },
            minimumInputLength: 2,
            placeholder: 'Buscar usuário...',
            allowClear: true,
            dropdownParent: modalId ? $(`#${modalId}`) : $('body')
        }).on('select2:open', function() {
            document.querySelector('.select2-search__field').focus();
        });
    }

        // Inicializa Select2 quando o documento estiver pronto
        $(document).ready(function() {
            // Para formulários fora de modais
            initializeSelect2();
        });

        // Inicializa Select2 quando o modal for aberto
        $(document).on('shown.bs.modal', function (event) {
            const modalId = event.target.id;
            initializeSelect2(modalId);
        });

        // Destruir Select2 quando o modal for fechado
        $(document).on('hidden.bs.modal', function () {
            $('.select2-people').select2('destroy');
            $('.select2-users').select2('destroy');
        });

    </script> --}}

    {{-- <script src="{{ asset('assets/js/ui-modals.js') }}"></script> --}}
@endpush
