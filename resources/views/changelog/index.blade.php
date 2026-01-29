@extends('app')

@section('title')
    Changelog
@endsection

@section('content')
    <!-- Content -->
    <div class="container flex-grow-1 container-p-y mb-4">

        <!-- Basic Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">Início</a>
                </li>
                <li class="breadcrumb-item active">Changelog</li>
            </ol>
        </nav>
        <!-- Basic Breadcrumb -->

        <!-- Timeline Atualizações -->
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between">
                <h5 class="card-title m-0 me-2 pt-1 mb-2 d-flex align-items-center">
                    Atualizações
                </h5>

                {{-- botao de adicionar changelog --}}
                @if (auth()->user()->nivel == 'SuperAdmin')
                    <a href="{{ route('admin.changelog.create') }}"
                        class="btn btn-primary px-3 waves-effect waves-light me-3" role="button">
                        <i class="menu-icon icon-base ti tabler-library-plus me-1"></i> Adicionar Changelog
                    </a>
                @endif
            </div>

            <div class="card-body pb-0 mx-10">
                @if ($changelogs->count() > 0)
                    <ul class="timeline mb-0">
                        @foreach ($changelogs as $changelog)
                        <hr>
                            <li class="timeline-item timeline-item-transparent">
                                <span class="timeline-point timeline-point-primary"></span>
                                <div class="timeline-event">
                                    <div class="timeline-header mb-3">
                                        <div class="d-flex justify-content-between align-items-center mt-2 mb-2 w-100">
                                            <h6 class="mb-0">Versão {{ $changelog->versao }}</h6>
                                            <small class="text-body-secondary me-10">
                                                @if($changelog->data_lancamento)
                                                    {{ \Carbon\Carbon::parse($changelog->data_lancamento)->format('d/m/Y') }}
                                                @else
                                                {{ $changelog->created_at->format('d/m/Y') }}
                                                @endif
                                            </small>
                                        </div>

                                    </div>

                                    {{-- Descrição geral da versão --}}
                                    @if ($changelog->descricao)
                                        <p class="text-muted mb-3">{{ $changelog->descricao }}</p>
                                    @endif

                                    {{-- Itens por categoria --}}
                                    @php
                                        $categoryColors = [
                                            'Nova Funcionalidade' => 'success',
                                            'Atualização de Segurança' => 'warning',
                                            'Correção de Bug' => 'info',
                                            'Mudança na Interface' => 'primary',
                                            'Melhoria de Performance' => 'secondary',
                                        ];

                                        $categoryLabels = [
                                            'Nova Funcionalidade' => 'NOVO',
                                            'Atualização de Segurança' => 'SEGURANÇA',
                                            'Correção de Bug' => 'CORRIGIDO',
                                            'Mudança na Interface' => 'INTERFACE',
                                            'Melhoria de Performance' => 'PERFORMANCE',
                                        ];
                                    @endphp

                                    @foreach ($changelog->getFormattedCategories() as $categoryData)
                                        @php
                                            $color = $categoryColors[$categoryData['categoria']] ?? 'secondary';
                                            $label =
                                                $categoryLabels[$categoryData['categoria']] ??
                                                strtoupper($categoryData['categoria']);
                                        @endphp

                                        @foreach ($categoryData['descricoes'] as $descricao)
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <span class="badge bg-label-{{ $color }}">{{ $label }}</span>
                                                <p class="mb-0">{{ $descricao }}</p>
                                            </div>
                                        @endforeach
                                    @endforeach
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-center py-5">
                        <i class="ti tabler-file-search display-4 text-muted mb-3"></i>
                        <h6 class="text-muted">Nenhuma atualização encontrada</h6>
                        <p class="text-muted small">As atualizações aparecerão aqui quando forem criadas.</p>
                    </div>
                @endif
            </div>

            <!-- Div "Fale conosco" -->
            <div class="card-footer text-center">
                <span class="text-muted">
                    Gostaria de sugerir uma nova funcionalidade ou relatar um problema?
                    Nos envie um <a href="{{ route('admin.suporte.ticket.create') }}">ticket</a>!
                </span>
            </div>
        </div>
        <!-- /Timeline Atualizações -->
    </div>
    <!--/ Content -->

@endsection
