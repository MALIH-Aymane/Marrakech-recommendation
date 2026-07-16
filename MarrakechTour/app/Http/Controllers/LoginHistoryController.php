<?php

namespace App\Http\Controllers;

use App\Models\LoginHistory;
use Illuminate\Http\Request;

class LoginHistoryController extends Controller
{
    /**
     * Afficher l'historique de connexion
     * de l'utilisateur connecté.
     */
    public function index()
    {
        $histories = auth()->user()
            ->loginHistories()
            ->latest('login_at')
            ->paginate(10);

        return view('profile.login-history', compact('histories'));
    }
    public function adminIndex()
{
    $histories = \App\Models\LoginHistory::with('user')
        ->latest('login_at')
        ->paginate(15);

    return view('dashboard.login-history', compact('histories'));
}
}
