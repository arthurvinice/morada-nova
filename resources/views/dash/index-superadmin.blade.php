@extends('app')

@section('title') Dashboard @endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />

@endpush

@section('content')

<div class="row">
    <!-- Card informações -->
    <div class="card mb-6">
        <div class="card-widget-separator-wrapper">
            <div class="card-body card-widget-separator">
                <div class="row gy-4 gy-sm-1">
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-center card-widget-1 border-end pb-4 pb-sm-0">
                            <div>
                                <h4 class="mb-0">{{ $peopleCreate->count() }}</h4>
                                <p class="mb-0">Total de Pessoas</p>
                            </div>
                            <div class="avatar me-sm-6">
                                <span class="avatar-initial rounded bg-label-secondary text-heading">
                                    <i class="icon-base ti tabler-friends icon-26px"></i>
                                </span>
                            </div>
                        </div>
                        <hr class="d-none d-sm-block d-lg-none me-6" />
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-center card-widget-2 border-end pb-4 pb-sm-0">
                            <div>
                                <h4 class="mb-0">{{ $users->count() }}</h4>
                                <p class="mb-0">Total de Usuários</p>
                            </div>
                            <div class="avatar me-lg-6">
                                <span class="avatar-initial rounded bg-label-secondary text-heading">
                                    <i class="icon-base ti tabler-users icon-26px"></i>
                                </span>
                            </div>
                        </div>
                        <hr class="d-none d-sm-block d-lg-none" />
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-center border-end pb-4 pb-sm-0 card-widget-3">
                            <div>
                                <h4 class="mb-0">{{ $atendimentosDoMes }}</h4>
                                <p class="mb-0">Total de Atendimentos</p>
                            </div>
                            <div class="avatar me-sm-6">
                                <span class="avatar-initial rounded bg-label-secondary text-heading">
                                    <i class="icon-base ti tabler-calendar-check icon-26px"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">{{ $categories->count() }}</h4>
                                <p class="mb-0">Total de Categorias</p>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-secondary text-heading">
                                    <i class="icon-base ti tabler-list-check icon-26px"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- FIM ROW -->

<div class="row">
    <div class="col-12">
        <!-- Hoverable Table rows -->
        <div class="card p-3">
            <h5 class="card-header">Usuários do Sistema</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Status</th>
                            <th>Nível</th>
                            <th>Setor</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                        @foreach ($users as $user)

                        <tr>
                            <td>#{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>

                            <td>
                                @if ($user->is_ativo)
                                    <span class="badge bg-label-success me-1">Ativo</span>
                                @else
                                    <span class="badge bg-label-danger me-1">Inativo</span>
                                @endif
                            </td>

                            <td>{{ $user->nivel }}</td>
                            <td>{{ $user->department->nome ?? '' }}</td>
                            <td>
                                <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-sm btn-icon btn-primary text-white">
                                    <i class="icon-base ti tabler-edit icon-18px"></i>
                                </a>
                            </td>
                        </tr>

                        @endforeach

                    </tbody>



                </table>

                <div class="col-12 d-flex justify-content-end mt-6 pe-6">
                    {{$users->links()}}
                </div>

            </div>

        </div>
        <!--/ Hoverable Table rows -->

    </div><!-- COL-8 -->


</div><!-- ROW -->


<div class="row">
    <div class="col-12">
        <hr class="my-3">
    </div>
</div> <!-- ROW -->




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
                                @if(old('pessoa_id'))
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
                                @if(old('user_id'))
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
</div> --}}

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
                <form class="card-body" action="{{ route('admin.service.store') }}" method="POST">
                    @csrf

                    <h4>Informações do agendamento</h4>

                    <div class="row g-6">
                        <div class="col-md-8">
                            <label class="form-label" for="pessoa_id">Nome</label>
                            <select class="form-control select2 form-select select2-people" name="pessoa_id" id="pessoa_id"
                                data-allow-clear="true" required>
                                @if(old('pessoa_id'))
                                <option value="{{ old('pessoa_id') }}" selected>
                                    {{ \App\Models\People::find(old('pessoa_id'))->nome }}
                                </option>
                                @endif
                            </select>

                            @error('pessoa_id')
                            <div class="alert alert-warning small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="multicol-last-name">Data</label>
                            <input type="datetime-local" name="data" id="multicol-last-name" class="form-control" placeholder="" required/>

                            @error('data')
                            <div class="alert alert-warning small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 my-3">
                            <label class="form-label" for="user_id">Pessoa que fez indicação</label>
                            <select class="form-control select2 form-select select2-users" name="user_id" id="user_id">
                                @if(old('user_id'))
                                <option value="{{ old('user_id') }}" selected>
                                    {{ \App\Models\User::find(old('user_id'))->name }}
                                </option>
                                @endif
                            </select>

                            @error('user_id')
                            <div class="alert alert-warning small mt-1">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="col-md-6 my-3">
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
                                        <input name="confirmacao" class="form-check-input" type="checkbox" value="1"
                                            id="customCheckTemp3" />
                                        <span class="custom-option-header">
                                            <span class="h6 mb-0">Confirmar</span>
                                        </span>
                                        <span class="custom-option-body">
                                            <small class="option-text">Marque esta opção caso a pessoa confirmou a presença no
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
                dropdownParent: modalElement || $('body')
            });
        });
    }

    // Aguarde o DOM estar totalmente carregado
    $(document).ready(function() {
        // Inicializa Select2 para elementos fora de modais
        initializeSelect2();

        // Inicializa Select2 quando o modal for aberto
        $('#serviceModal').on('shown.bs.modal', function () {
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
