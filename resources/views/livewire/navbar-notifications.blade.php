<div class="navbar-nav-right d-flex align-items-center" wire:poll.5s="loadNotifications">
    <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-2">
        <a class="nav-link dropdown-toggle hide-arrow btn btn-icon btn-text-secondary rounded-pill" href="#"
            data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
            <span class="position-relative">
                <i class="icon-base ti tabler-bell icon-22px text-heading"></i>
                @if ($notifications->count())
                    <span class="badge rounded-pill bg-danger badge-dot badge-notifications border"></span>
                @endif
            </span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end p-0">
            <li class="dropdown-menu-header border-bottom">
                <div class="dropdown-header d-flex align-items-center py-3">
                    <h6 class="mb-0 me-auto">Notificações</h6>
                    <div class="d-flex align-items-center h6 mb-0">
                        <span class="badge bg-label-primary me-2">{{ $notifications->count() }}</span>
                        <button wire:click="markAllAsRead" class="dropdown-notifications-all p-2 btn btn-icon"
                            title="Marcar todas como lidas">
                            <i class="icon-base ti tabler-mail-opened text-heading"></i>
                        </button>
                    </div>
                </div>
            </li>
            <ul class="list-group list-group-flush">
                @forelse($notifications->reject(fn($n) => in_array($n->id, $hiddenNotifications)) as $notification)
                    <li class="dropdown-item">
                        <a class="d-flex w-100 align-items-center" href="{{ route('admin.notification.show', $notification->id) }}">

                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar">
                                        <span class="avatar-initial rounded-circle bg-label-danger">
                                            <i class="icon-base ti tabler-speakerphone"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 small">
                                        {{ $notification->data['titulo'] ?? 'Notificação' }}
                                    </h6>
                                    <small class="mb-1 d-block text-body">
                                        {{ Str::limit(
                                            is_array($notification->data['message'] ?? null)
                                            ? json_encode($notification->data['message'])
                                            : ($notification->data['message'] ?? 'Sem mensagem'), 40) }}
                                    </small>
                                    <small class="text-body-secondary">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </small>
                                </div>

                                <div class="flex-shrink-0 dropdown-notifications-actions">
                                    <a href="javascript:void(0)" class="dropdown-notifications-read">
                                        <span class="badge badge-dot"></span>
                                    </a>
                                    <a href="javascript:void(0)" wire:click="hideNotification('{{ $notification->id }}')"  class="dropdown-notifications-archive">
                                        <span class="icon-base ti tabler-x"></span>
                                    </a>
                                </div>
                            </div>
                        </a>
                        <br>
                        <small class="text-muted" style="font-size: 0.8rem"></small>
                    </li>

                @empty
                    <li class="dropdown-item text-center text-muted">Sem notificações</li>
                @endforelse

            </ul>
            <li class="border-top">
                <div class="d-grid p-4">
                    <a class="btn btn-primary btn-sm d-flex"
                        href="{{ route('admin.notification.index')}}">
                        <small class="align-middle">Ver todas as notificações</small>
                    </a>
                </div>
            </li>
        </ul>
    </li>
</div>
