<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Notifications\UserRoleChangedNotification;
use App\Notifications\UserDeletedNotification;

class UserController extends Controller
{
    public function index(Request $request)
{
    $query = User::query();

    // Recherche
    if ($request->filled('search')) {

        $query->where(function ($q) use ($request) {

            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('email', 'like', '%' . $request->search . '%');

        });

    }

    // Filtre par rôle
    if ($request->filled('role')) {

        $query->role($request->role);

    }

    $users = $query
                ->latest()
                ->paginate(10);

    $totalUsers = User::count();

    $totalAdmins = User::role('Admin')->count();

    $totalNormalUsers = User::role('User')->count();

    $verifiedUsers = User::whereNotNull('email_verified_at')->count();

    return view('users.index', compact(
        'users',
        'totalUsers',
        'totalAdmins',
        'totalNormalUsers',
        'verifiedUsers'
    ));
}
    public function updateRole(User $user)
{
    // Empêcher l'admin connecté de modifier son propre rôle
    if ($user->id == auth()->id()) {

        return back()->with('error', 'Vous ne pouvez pas modifier votre propre rôle.');

    }

    if ($user->hasRole('Admin')) {

        $user->syncRoles('User');

    } else {

        $user->syncRoles('Admin');

    }
              // Notifier tous les administrateurs
$admins = User::role('Admin')->get();

foreach ($admins as $admin) {

    $admin->notify(new UserRoleChangedNotification($user));

}
    return back()->with('success', 'Le rôle a été modifié avec succès.');
}
public function destroy(User $user)
{
    // Empêcher l'admin de supprimer son propre compte
    if ($user->id == auth()->id()) {

        return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');

    }

    // Notifier tous les administrateurs AVANT la suppression
    $admins = User::role('Admin')->get();

    foreach ($admins as $admin) {

        $admin->notify(new UserDeletedNotification($user));

    }

    // Retirer les rôles Spatie
    $user->syncRoles([]);

    // Supprimer l'utilisateur
    $user->delete();

    return back()->with('success', 'Utilisateur supprimé avec succès.');
}
}