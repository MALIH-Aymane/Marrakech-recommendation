<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function readAll()
    {
        Auth::user()
            ->unreadNotifications
            ->markAsRead();

        return back();
    }
}