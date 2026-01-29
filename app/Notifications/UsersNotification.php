<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class UsersNotification extends Notification
{
    use Queueable;

    public $message;
    public $titulo;
    public $sender_id;

    /**
     * Create a new notification instance.
     */
    public function __construct($message, $titulo, $sender_id)
    {
        $this->message = $message;
        $this->titulo = $titulo;
        $this->sender_id = $sender_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function sender()
    {
        return $this->sender_id ? User::find($this->sender_id) : null;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->message,
            'user_id' => $notifiable->id,
            'titulo' => $this->titulo,
            'sender_id' => $this->sender_id,
        ];
    }
}
