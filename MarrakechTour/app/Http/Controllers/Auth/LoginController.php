<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LoginHistory;
use Jenssegers\Agent\Agent;

class LoginController extends Controller
{
   public function showLoginForm()
{
    return view('auth.login');
}

public function login(Request $request)
{
    $credentials = $request->validate([

        'email' => ['required', 'email'],

        'password' => ['required'],

    ]);

    if (Auth::attempt($credentials)) {

        $request->session()->regenerate();

        $agent = new Agent();

       LoginHistory::create([
          'user_id' => auth()->id(),
          'ip_address' => $request->ip(),
         'browser' => $agent->browser(),
         'platform' => $agent->platform(),
         'user_agent' => $request->userAgent(),
         'login_at' => now(),
]);

        if (auth()->user()->hasRole('Admin')) {

               return redirect()->route('dashboard');

}

return redirect()->route('home');
    }

    return back()->withErrors([

        'email' => 'Adresse e-mail ou mot de passe incorrect.',

    ])->onlyInput('email');
}
}
