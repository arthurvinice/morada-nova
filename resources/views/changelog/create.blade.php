@extends('app')

@section('title')
    Criar Changelog
@endsection

@section('content')
    <!-- Content -->
    <div class="container-fluid flex-grow-1 container-p-y mb-4" x-data="changelogForm()" x-init="init()">

        <!-- Basic Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">Início</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.changelog.index') }}">Changelog</a>
                </li>
                <li class="breadcrumb-item active">Criar</li>
            </ol>
        </nav>
        <!-- Basic Breadcrumb -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="ti tabler-library-plus me-2"></i>
                            Criar Nova Versão
                        </h5>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.changelog.store') }}" method="POST">
                            @csrf

                            <!-- Informações Básicas -->
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <label class="form-label" for="versao">
                                        Versão <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="versao" name="versao"
                                        class="form-control @error('versao') is-invalid @enderror"
                                        value="{{ old('versao') }}" placeholder="Ex: 2.1.0" x-model="versao" required>
                                    @error('versao')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                @if (auth()->user()->name == 'Arthur Vinícius')
                                    <div class="col-md-3">
                                        <label class="form-label" for="data_lancamento">
                                            Data de Lançamento (apenas para versões antigas)
                                        </label>
                                        <input type="date" id="data_lancamento" name="data_lancamento"
                                            class="form-control @error('data_lancamento') is-invalid @enderror"
                                            value="{{ old('data_lancamento') }}" placeholder="Ex: 2024-12-31">
                                        @error('data_lancamento')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif
                            </div>

                            <hr class="my-4">

                            <!-- Seção de Categorias -->
                            <div class="mb-4">
                                <h6 class="mb-3">
                                    <i class="ti tabler-category me-2"></i>
                                    Itens por Categoria
                                </h6>
                                <p class="text-muted small mb-4">
                                    Adicione os itens de cada categoria para esta versão. Você pode adicionar múltiplos
                                    itens por categoria.
                                </p>

                                @php
                                    $categoryIcons = [
                                        'Nova Funcionalidade' => 'ti tabler-star',
                                        'Atualização de Segurança' => 'ti tabler-shield-check',
                                        'Correção de Bug' => 'ti tabler-bug',
                                        'Mudança na Interface' => 'ti tabler-palette',
                                        'Melhoria de Performance' => 'ti tabler-rocket',
                                    ];
                                @endphp

                                @foreach ($categories as $category)
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0">
                                                    <i
                                                        class="{{ $categoryIcons[$category->nome] ?? 'ti tabler-circle' }} me-2"></i>
                                                    {{ $category->nome }}
                                                    <span class="badge bg-light text-dark ms-2"
                                                        x-text="getCategoryCount({{ $category->id }}) + ' ' + (getCategoryCount({{ $category->id }}) === 1 ? 'item' : 'itens')"></span>
                                                </h6>
                                                <button type="button" class="btn btn-sm btn-primary"
                                                    @click="addItem({{ $category->id }})">
                                                    <i class="ti tabler-plus me-1"></i>
                                                    Adicionar Item
                                                </button>
                                            </div>
                                        </div>

                                        <div class="card-body">
                                            <!-- Mensagem vazia -->
                                            <div x-show="!categorias[{{ $category->id }}] || categorias[{{ $category->id }}].length === 0"
                                                class="text-muted text-center py-3">
                                                <i class="ti tabler-inbox display-6 mb-2"></i>
                                                <p class="mb-0">Nenhum item adicionado para {{ $category->nome }}</p>
                                                <small>Clique em "Adicionar Item" para começar</small>
                                            </div>

                                            <!-- Lista de itens -->
                                            <template x-for="(item, index) in (categorias[{{ $category->id }}] || [])"
                                                :key="index">
                                                <div class="input-group mb-2">
                                                    <span class="input-group-text">
                                                        <i class="ti tabler-circle-dot"></i>
                                                    </span>
                                                    <input type="text"
                                                        :name="`categorias[{{ $category->id }}][${index}]`"
                                                        class="form-control" placeholder="Descrição do item..."
                                                        x-model="categorias[{{ $category->id }}][index]" required>
                                                    <button type="button" class="btn btn-outline-danger"
                                                        @click="removeItem({{ $category->id }}, index)">
                                                        <i class="ti tabler-trash"></i>
                                                    </button>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Botões de Ação -->
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.changelog.index') }}" class="btn btn-secondary">
                                    <i class="ti tabler-arrow-left me-1"></i>
                                    Voltar
                                </a>
                                <button type="submit" class="btn btn-primary" :disabled="!versao || !hasAnyItems()">
                                    <i class="ti tabler-device-floppy me-1"></i>
                                    Adicionar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Content -->

    @push('scripts')
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script>
            function changelogForm() {
                return {
                    versao: '{{ old('versao') }}',
                    categorias: @json(old('categorias', [])),

                    init() {
                        // Garantir que todas as categorias tenham arrays
                        @foreach ($categories as $category)
                            if (!this.categorias[{{ $category->id }}]) {
                                this.categorias[{{ $category->id }}] = [];
                            }
                        @endforeach
                    },

                    addItem(categoryId) {
                        if (!this.categorias[categoryId]) {
                            this.categorias[categoryId] = [];
                        }
                        this.categorias[categoryId].push('');

                        // Focar no último input adicionado
                        this.$nextTick(() => {
                            const inputs = document.querySelectorAll(`input[name^="categorias[${categoryId}]"]`);
                            if (inputs.length > 0) {
                                inputs[inputs.length - 1].focus();
                            }
                        });
                    },

                    removeItem(categoryId, index) {
                        if (this.categorias[categoryId]) {
                            this.categorias[categoryId].splice(index, 1);
                        }
                    },

                    getCategoryCount(categoryId) {
                        if (!this.categorias[categoryId]) {
                            return 0;
                        }
                        return this.categorias[categoryId].filter(item => item && item.trim()).length;
                    },

                    hasAnyItems() {
                        return Object.values(this.categorias).some(items =>
                            items && items.some(item => item && item.trim())
                        );
                    }
                }
            }
        </script>
    @endpush
@endsection
