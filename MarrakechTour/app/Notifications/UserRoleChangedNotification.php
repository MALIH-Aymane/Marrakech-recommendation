<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class UserRoleChangedNotification extends Notification
{
    use Queueable;

    public function __construct(public User $user)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [

            'title' => 'Rôle utilisateur modifié',

            'message' => 'Le rôle de "' . $this->user->name . '" a été modifié.',

            'user_id' => $this->user->id,

        ];
    }
}