<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'app:create-admin';

    /**
     * The console command description.
     */
    protected $description = 'Créer un administrateur';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask('Nom');
        $email = $this->ask('Email');
        $password = $this->secret('Mot de passe');

        if (User::where('email', $email)->exists()) {
            $this->error('Cet email existe déjà.');
            return;
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $user->assignRole('Admin');

        $this->info('Administrateur créé avec succès !');
    }
}