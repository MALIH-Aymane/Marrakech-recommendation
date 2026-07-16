<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewUserNotification extends Notification
{
    use Queueable;

    public function __construct(public User $newUser)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Nouvel utilisateur',
            'message' => $this->newUser->name . ' vient de créer un compte.',
            'user_id' => $this->newUser->id,
        ];
    }
}