<?php

namespace App\Livewire;

use Livewire\Component;

class NavbarNotifications extends Component
{
    public $notifications;
    public $notificationCount = null;
    public $hiddenNotifications = [];

    protected $listeners = ['refreshNotifications' => '$refresh', 'markAsRead'];

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $this->notifications = auth()->user()->unreadNotifications()->latest()->get();
        $this->notificationCount = $this->notifications->count();
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        $this->loadNotifications();
    }

    public function markAsRead($notificationId)
    {
        $notification = auth()->user()->unreadNotifications->where('id', $notificationId)->first();

        if ($notification) {
            $notification->markAsRead();
        }

        $this->loadNotifications();
    }

    public function hideNotification($notificationId)
    {
        $this->hiddenNotifications[] = $notificationId;
    }

    public function render()
    {
        return view('livewire.navbar-notifications');
    }
}

