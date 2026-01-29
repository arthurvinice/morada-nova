<div class="ticket-replies-container">
    {{-- Mensagens flash --}}
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="icon-base ti tabler-check me-2"></i>
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="icon-base ti tabler-alert-triangle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Área do histórico com polling seletivo --}}
    <div wire:poll.1800s="checkForNewReplies">
        {{-- Lista de respostas existentes --}}
        <div class="">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">
                    <i class="icon-base ti tabler-messages me-2"></i>
                    Histórico de Respostas

                </h4>
                {{-- @if (!$loading)
                        ({{ $totalReplies }})
                        @if ($hasNewReplies)
                            <span class="badge bg-success ms-2 animate-pulse">
                                <i class="icon-base ti tabler-bell"></i>
                                {{ $newRepliesCount }} nova(s)
                            </span>
                        @endif
                    @endif --}}

                @if ($lastUpdated)
                    <small class="text-muted">
                        <i class="icon-base ti tabler-refresh me-1"></i>
                        Última verificação:
                        {{ \Carbon\Carbon::parse($lastUpdated)->timezone('America/Sao_Paulo')->format('H:i:s') }}
                    </small>
                @endif
            </div>
            <div class="card-body">
                @if ($loading && count($replies) == 0)
                    {{-- Loading state inicial --}}
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Carregando...</span>
                        </div>
                        <p class="mt-2 text-muted">Carregando respostas...</p>
                    </div>
                @elseif(count($replies) > 0)
                    {{-- Indicador discreto de verificação --}}
                    @if ($checkingUpdates)
                        <div class="text-center mb-2">
                            <small class="text-muted">
                                <span class="spinner-border spinner-border-sm me-1"></span>
                                Verificando novas respostas...
                            </small>
                        </div>
                    @endif

                    {{-- Alerta de novas respostas --}}
                    {{-- @if ($hasNewReplies && $newRepliesCount > 0)
                        <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
                            <i class="icon-base ti tabler-bell-ringing me-2"></i>
                            <strong>{{ $newRepliesCount }} nova(s) resposta(s) adicionada(s)!</strong>
                            <button type="button" wire:click="markRepliesAsRead"
                                class="btn btn-sm btn-outline-info ms-2">
                                Marcar como lida
                            </button>
                            <button type="button" class="btn-close" wire:click="dismissNewRepliesAlert"
                                aria-label="Close"></button>
                        </div>
                    @endif --}}

                    <div class="replies-list">
                        @foreach ($replies as $index => $reply)
                            <div
                                class="reply-item mb-3 p-3 border rounded {{ isset($reply['is_new']) && $reply['is_new'] ? 'border-success bg-light shadow-sm' : '' }}">
                                {{-- Cabeçalho da resposta --}}
                                <div class="reply-header d-flex justify-content-between align-items-center mb-2">
                                    <div class="author-info">
                                        @if (is_array($reply) && isset($reply['author']['type']) && $reply['author']['type'] === 'suporte')
                                            {{-- Resposta do suporte --}}
                                            <span class="badge bg-info me-2">
                                                <i class="icon-base ti tabler-headphones"></i> Suporte
                                            </span>
                                            <strong>{{ $reply['author']['name'] ?? 'Suporte' }}</strong>
                                        @else
                                            {{-- Resposta do cliente --}}
                                            <span class="badge bg-primary me-2">
                                                <i class="icon-base ti tabler-user"></i> Cliente
                                            </span>
                                            <strong>{{ $reply['author']['name'] ?? 'Cliente' }}</strong>
                                        @endif

                                        {{-- Indicador de nova resposta --}}
                                        @if (isset($reply['is_new']) && $reply['is_new'])
                                            <span class="badge bg-success ms-2 animate-pulse">
                                                <i class="icon-base ti tabler-sparkles"></i> Nova
                                            </span>
                                        @endif
                                    </div>

                                    <small class="text-muted">
                                        <i class="icon-base ti tabler-clock"></i>
                                        {{ is_array($reply) ? $reply['created_at'] ?? '' : '' }}
                                    </small>
                                </div>

                                {{-- Conteúdo da resposta --}}
                                <div class="reply-content mb-2">
                                    <p class="mb-0 h5">{!! nl2br(e(is_array($reply) ? $reply['descricao'] ?? '' : '')) !!}</p>
                                </div>

                                {{-- Anexo (se existir) --}}
                                @if (is_array($reply) && isset($reply['anexo']) && $reply['anexo'])
                                    <div class="reply-attachment d-inline-block">
                                        <div
                                            class="d-flex align-items-center justify-content-start p-2 bg-light rounded">
                                            <div class="d-flex align-items-center">
                                                <i class="icon-base ti tabler-paperclip me-2 text-primary"></i>
                                                <div>
                                                    <small
                                                        class="fw-medium">{{ $reply['anexo']['nome_arquivo'] ?? 'Anexo' }}</small>
                                                </div>
                                            </div>
                                            <button
                                                wire:click="downloadAnexo('{{ $reply['anexo']['download_url'] ?? '' }}')"
                                                class="btn btn-sm btn-outline-primary h6 mt-2 mb-1 ms-2"
                                                title="Fazer download">
                                                <i class="icon-base ti tabler-download"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center text-muted py-4">
                        <i class="icon-base ti tabler-message-x display-4 mb-3"></i>
                        <p class="mb-0">Ainda não há respostas para este ticket.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Formulário para nova resposta --}}
    @php
        $ticketStatus = $ticket['status'] ?? '';
        $clientName = $ticket['client_people_name'] ?? '';
        $userName = auth()->user()->name ?? '';
        $canReply = $ticketStatus !== 'Concluído' && $userName === $clientName;
    @endphp

    @if ($canReply)
        <div class="">
            <div class="card-header">
                <h4 class="card-title mb-0">
                    <i class="icon-base ti tabler-message-plus me-2"></i>
                    Adicionar Resposta
                </h4>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="addReply">
                    {{-- Campo de descrição --}}
                    <div class="form-group mb-3">
                        <label for="descricao" class="form-label">
                            <strong class="h5">Sua Resposta: <span class="text-danger">*</span></strong>
                        </label>
                        <textarea wire:model.live="descricao" class="form-control @error('descricao') is-invalid @enderror" id="descricao"
                            rows="5" placeholder="Digite sua resposta ao ticket..." wire:loading.attr="readonly"
                            wire:target="checkForNewReplies">
                    </textarea>

                        @error('descricao')
                            <div class="invalid-feedback">
                                <i class="icon-base ti tabler-alert-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Campo de anexo --}}
                    <div class="form-group mb-3">
                        <label for="anexo" class="form-label">
                            <strong class="h5">Anexo (Opcional):</strong>
                        </label>

                        {{-- Input de arquivo --}}
                        <input type="file" wire:model="anexo"
                            class="form-control @error('anexo') is-invalid @enderror" id="anexo"
                            accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.txt,.zip,.rar">

                        {{-- Preview do arquivo selecionado --}}
                        @if ($anexo)
                            <div class="mt-2 p-2 bg-light rounded d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <i class="icon-base ti tabler-file me-2 text-success"></i>
                                    <small class="fw-medium">{{ $anexo->getClientOriginalName() }}</small>
                                    <small
                                        class="text-muted ms-2">({{ number_format($anexo->getSize() / 1024 / 1024, 2) }}
                                        MB)</small>
                                </div>
                                <button type="button" wire:click="removeAnexo" class="btn btn-sm btn-outline-danger"
                                    title="Remover arquivo">
                                    <i class="icon-base ti tabler-x"></i>
                                </button>
                            </div>
                        @endif

                        {{-- Informações sobre o upload --}}
                        <div class="form-text">
                            <small class="text-muted">
                                <i class="icon-base ti tabler-info-circle"></i>
                                Arquivos permitidos: PDF, DOC, DOCX, JPG, JPEG, PNG, TXT, ZIP, RAR (máximo 10MB)
                            </small>
                        </div>

                        @error('anexo')
                            <div class="invalid-feedback d-block">
                                <i class="icon-base ti tabler-alert-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror

                        {{-- Loading do upload --}}
                        <div wire:loading wire:target="anexo" class="mt-2">
                            <div class="d-flex align-items-center text-primary">
                                <span class="spinner-border spinner-border-sm me-2"></span>
                                <small>Carregando arquivo...</small>
                            </div>
                        </div>
                    </div>

                    {{-- Botões de ação --}}
                    <div class="form-actions d-flex justify-content-end align-items-center">
                        <!-- Botão -->
                            <a href="{{ url()->previous() }}" class="btn btn-secondary waves-effect waves-light me-2">
                                <i class="bx bx-arrow-back me-1"></i>
                                Voltar
                            </a>
                        <!-- /Botão -->
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"
                            wire:target="addReply">
                            <span wire:loading.remove wire:target="addReply">
                                <i class="icon-base ti tabler-send"></i>
                                Enviar Resposta
                            </span>
                            <span wire:loading wire:target="addReply">
                                <span class="spinner-border spinner-border-sm me-2"></span>
                                Enviando...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @else
        {{-- Mensagem explicativa quando não pode responder --}}
        <div>
            {{-- class="card-header">
            <h4 class="card-title mb-0 text-muted">
                <i class="icon-base ti tabler-lock mb-1 "></i>
                @if ($ticketStatus === 'Concluído')
                    Ticket Concluído
                @elseif ($ticketStatus === 'Aberto')
                    Aguarde a resposta do suporte.
                @else
                    Ticket em andamento, aguarde a resposta!
                @endif
            </h4> --}}
        </div>
        {{-- <div class=""></div> --}}
    @endif

</div>
