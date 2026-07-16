<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
class ProfileController extends Controller
{
    public function edit()
{
    $user = Auth::user();

    if ($user->hasRole('Admin')) {
        return view('profile.edit_admin', compact('user'));
    }

    return view('profile.edit_user', compact('user'));
}

    public function update(Request $request)
    {
        $user = Auth::user();

       $request->validate([
          'name' => 'required|string|max:255',
          'email' => 'required|email|max:255|unique:users,email,'.$user->id,
          'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'password' => 'nullable|confirmed|min:8'
]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->hasFile('photo')) {

    // Supprimer l'ancienne photo si elle existe
    if ($user->photo) {
        Storage::disk('public')->delete($user->photo);
    }

    // Enregistrer la nouvelle photo
    $user->photo = $request->file('photo')
                           ->store('profiles', 'public');
}

        if($request->filled('password')){
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success','Profil mis à jour avec succès.');
    }
    public function deletePhoto()
{
    $user = Auth::user();

    if ($user->photo) {

        Storage::disk('public')->delete($user->photo);

        $user->photo = null;

        $user->save();
    }

    return back()->with(
        'success',
        'Photo de profil supprimée avec succès.'
    );
}
}
