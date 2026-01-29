<!-- Content -->
<div class="container-fluid flex-grow-1 container-p-y">

    <!-- Basic Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">Início</a>
            </li>
            <li class="breadcrumb-item active">Criar Ticket</li>
        </ol>
    </nav>
    <!-- Basic Breadcrumb -->

    <!-- Card Criar Ticket -->
    <div class="card">
        <div class="card-body">

            <!-- Mensagens de erro do formulário -->
            @error('form')
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @enderror

            <form wire:submit.prevent="submitForm">
                <div class="row">

                    <!-- Coluna 1 -->
                    <div class="col-8 mb-4">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="titulo">Título</label>
                            <div class="col-sm-10">
                                <input type="text"
                                       class="form-control @error('titulo') is-invalid @enderror"
                                       id="titulo"
                                       wire:model="titulo"
                                       wire:loading.attr="disabled"
                                       placeholder="Título do ticket">
                                @error('titulo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="descricao">Descrição</label>
                            <div class="col-sm-10">
                                <textarea id="descricao"
                                          class="form-control @error('descricao') is-invalid @enderror"
                                          wire:model="descricao"
                                          wire:loading.attr="disabled"
                                          style="height: 200px;"
                                          placeholder="Descrição do ticket">
                                </textarea>
                                @error('descricao')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- /Coluna 1 -->

                    <!-- Coluna 2 -->
                    <div class="col-4 mb-4">
                        <div class="row mb-3">
                            <label for="modulo" class="col-sm-3 col-form-label">Categoria</label>
                            <div class="col-sm-9">
                                <select id="modulo"
                                        class="form-select @error('módulo') is-invalid @enderror"
                                        wire:model="módulo"
                                        wire:loading.attr="disabled">
                                    <option value="">Selecione uma categoria</option>
                                    <option value="Dúvida">Dúvida</option>
                                    <option value="Mau funcionamento">Mau funcionamento</option>
                                    <option value="Sugestão">Sugestão</option>
                                </select>
                                @error('módulo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Input de Arquivos Simples -->
                        <div class="mb-3">
                            <label class="form-label" for="newFiles">Anexos</label>
                            <input type="file"
                                   id="newFiles"
                                   class="form-control @error('newFiles.*') is-invalid @enderror"
                                   wire:model.live="newFiles"
                                   multiple
                                   accept=".jpeg,.jpg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx,.txt,.zip,.rar"
                                   wire:loading.attr="disabled">

                            <small class="text-muted">
                                Arquivos permitidos: JPG, PNG, PDF, DOC, XLS, TXT, ZIP (máx. 10MB cada)<br>
                                <strong>Dica:</strong> Você pode selecionar múltiplos arquivos de uma vez.
                            </small>

                            @error('newFiles.*')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Lista de Arquivos Selecionados -->
                        @if (!empty($files))
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label mb-0">Arquivos Selecionados ({{ count($files) }})</label>
                                    <button type="button"
                                            wire:click="clearAllFiles"
                                            class="btn btn-sm btn-outline-danger"
                                            wire:loading.attr="disabled"
                                            title="Limpar todos os arquivos">
                                        <i class="icon-base ti tabler-trash me-1"></i>
                                        Limpar todos
                                    </button>
                                </div>
                                <div class="list-group">
                                    @foreach ($files as $index => $file)
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="icon-base ti tabler-file me-2"></i>
                                                <strong>{{ $file->getClientOriginalName() }}</strong>
                                                {{-- <small class="text-muted d-block">
                                                    @if ($file->getSize() != null)
                                                        {{ number_format($file->getSize() / 1024 / 1024, 2) }} MB
                                                    @else
                                                        Tamanho desconhecido
                                                    @endif
                                                </small> --}}
                                            </div>
                                            <button type="button"
                                                    wire:click="removeFile({{ $index }})"
                                                    class="btn btn-sm btn-outline-danger"
                                                    wire:loading.attr="disabled"
                                                    title="Remover este arquivo">
                                                <i class="icon-base ti tabler-trash"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </div>
                    <!-- /Coluna 2 -->

                </div>

                <!-- Botão -->
                <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('admin.suporte.ticket.index') }}"
                       class="btn btn-secondary waves-effect waves-light me-2">
                        <i class="icon-base ti tabler-arrow-left me-1"></i>
                        Voltar
                    </a>

                    <button type="submit"
                            class="btn btn-primary waves-effect waves-light"
                            wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="submitForm">
                            <i class="icon-base ti tabler-plus me-1"></i>
                            Criar Ticket
                        </span>
                        <span wire:loading wire:target="submitForm">
                            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                            Criando Ticket...
                        </span>
                    </button>
                </div>
                <!-- /Botão -->
            </form>

        </div>
    </div>
    <!-- /Card Criar Ticket -->

</div>
<!--/ Content -->
