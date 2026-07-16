<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\NewUserNotification;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    public function showRegisterForm()
{
    return view('auth.register');
}

public function register(Request $request)
{
    $validated = $request->validate([

        'name' => 'required|string|max:255',

        'email' => 'required|email|unique:users,email',

        'password' => 'required|confirmed|min:8',

        'phone' => ['nullable','string','max:30'],

    ]);

    $user = User::create([

        'name' => $validated['name'],

        'email' => $validated['email'],

        'password' => Hash::make($validated['password']),

        'phone' => $request->phone,

    ]);
    $user->assignRole('User');

    // Notifier tous les administrateurs
   $admins = User::role('Admin')->get();

       foreach ($admins as $admin) {

          $admin->notify(new NewUserNotification($user));

}

    auth()->login($user);

    return redirect()->route('home');
}
}
