<?php

namespace App\Notifications;

use App\Models\Attraction;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class UpdateAttractionNotification extends Notification
{
    use Queueable;

    public function __construct(public Attraction $attraction)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [

            'title' => 'Attraction modifiée',

            'message' => 'L\'attraction "' . $this->attraction->attraction . '" a été modifiée.',

            'attraction_id' => $this->attraction->id,

        ];
    }
}