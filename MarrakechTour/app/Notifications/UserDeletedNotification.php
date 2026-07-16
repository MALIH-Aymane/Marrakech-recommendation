<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class UserDeletedNotification extends Notification
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

            'title' => 'Utilisateur supprimé',

            'message' => 'Le compte de "' . $this->user->name . '" a été supprimé.',

            'user_id' => $this->user->id,

        ];
    }
}