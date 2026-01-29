<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class NotificationsTable extends Component
{
    use WithPagination;

    public $status = 'nao_lidas';

    protected $paginationTheme = 'bootstrap';

    public function loadNotifications()
    {
        //limpeza do cache das computed properties
        unset($this->unreadCount, $this->readCount);
    }

    public function setStatus($status)
    {
        $this->status = $status;
        $this->resetPage();
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()->unreadNotifications->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
        }

        // Força refresh das computed properties
        $this->loadNotifications();
    }

    public function render()
    {
        if (!auth()->check()) {
            return view('livewire.notifications-table', [
                'notifications' => collect()->paginate(10),
            ]);
        }

        // Query para paginação automática
        $query = auth()->user()->notifications();

        // Filtrar por status
        if ($this->status === 'lidas') {
            $query->whereNotNull('read_at');
        } else {
            $query->whereNull('read_at');
        }

        // Ordenação automática por data mais recente
        $query->orderBy('created_at', 'desc');

        // Paginação automática
        $notifications = $query->paginate(10);

        // Transformar os dados para incluir o remetente
        $notifications->getCollection()->transform(function ($notification) {
            if (isset($notification->data['sender_id']) && $notification->data['sender_id']) {
                $notification->sender = User::find($notification->data['sender_id']);
            } else {
                $notification->sender = null;
            }
            return $notification;
        });

        return view('livewire.notifications-table', [
            'notifications' => $notifications,
        ]);
    }

    // Computed properties com verificação de autenticação
    public function getUnreadCountProperty()
    {
        if (!auth()->check()) {
            return 0;
        }
        return auth()->user()->unreadNotifications()->count();
    }

    public function getReadCountProperty()
    {
        if (!auth()->check()) {
            return 0;
        }
        return auth()->user()->readNotifications()->count();
    }
}
