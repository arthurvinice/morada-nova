<div wire:poll.10s="loadNotifications">
    <div class="mb-3 d-flex gap-2 d-flex-wrap align-items-center justify-content-between">
        <div>
            <button wire:click="setStatus('nao_lidas')"
                class="btn btn-sm {{ $status === 'nao_lidas' ? 'btn-primary' : 'btn-outline-primary' }}">
                Não lidas ({{ $this->unreadCount }})
            </button>
            <button wire:click="setStatus('lidas')"
                class="btn btn-sm {{ $status === 'lidas' ? 'btn-success' : 'btn-outline-success' }}">
                Lidas
            </button>
        </div>
        @if (auth()->user()->nivel == 'Administrador' || auth()->user()->nivel == 'SuperAdmin')
            <a href="{{ route('admin.notification.create') }}" class="btn btn-sm btn-primary">
                <i class="icon-base ti tabler-copy-plus"></i>
                Criar notificação
            </a>
        @endif

    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Mensagem</th>
                    <th>Enviado às</th>
                    <th>Enviado por</th>
                     @if($status === 'lidas')
                        <th>
                            Lida em
                        </th>
                    @endif
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($notifications as $notification)
                    <tr>
                        <td>
                            {{ is_array(Arr::get($notification->data, 'titulo'))
                                ? '[inválido]'
                                : Arr::get($notification->data, 'titulo', '[sem título]') }}
                        </td>
                        <td>
                            {{ Str::limit(is_array($notification->data['message'] ?? '')
                                ? json_encode($notification->data['message'])
                                : ($notification->data['message'] ?? ''), 40) }}
                        </td>
                        <td>{{ $notification->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            @if ($notification->sender->nivel === 'Administrador')
                                {{ $notification->sender->name }}
                            @elseif ($notification->sender->nivel === 'SuperAdmin')
                                <span class="text-muted">Sistema</span>
                            @else
                                <span class="text-muted">Administrador</span>
                            @endif
                        </td>
                        @if($status === 'lidas')
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="icon-base ti tabler-square-check me-2" style="color: #28a745;"></i>
                                    <span>{{ $notification->read_at ? $notification->read_at->format('d/m/Y H:i') : '-' }}</span>
                                </div>
                            </td>
                        @endif
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.notification.show', $notification->id) }}"
                                   class="btn btn-sm btn-outline-info" title="Visualizar">
                                    <i class="icon-base ti tabler-eye"></i>
                                </a>

                                @if($status === 'nao_lidas')
                                    <button wire:click="markAsRead('{{ $notification->id }}')"
                                            class="btn btn-sm btn-outline-success" title="Marcar como lida">
                                        <i class="icon-base ti tabler-check"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <div class="empty-state">
                                <i class="icon-base ti tabler-bell-off mb-2" style="font-size: 2rem;"></i>
                                <p class="mb-0">Nenhuma notificação encontrada.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginação automática do Laravel -->
    {{ $notifications->links() }}

    <style>
    .empty-state {
        padding: 2rem;
        color: var(--bs-gray-500);
    }
    </style>
</div>
