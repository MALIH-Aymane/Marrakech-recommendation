<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

use App\Http\Controllers\AttractionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\LoginHistoryController;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [
        'localize',
        'localizationRedirect',
        'localeSessionRedirect',
        'localeViewPath',
    ],
], function () {

    /*
    |--------------------------------------------------------------------------
    | Pages publiques
    |--------------------------------------------------------------------------
    */

    Route::get('/', [AttractionController::class, 'home'])->name('home');

    Route::get('/attractions', [AttractionController::class, 'index'])
        ->name('attractions.index');

    Route::get('/attractions/{attraction}', [AttractionController::class, 'show'])
        ->name('attractions.show');

    /*
    |--------------------------------------------------------------------------
    | Authentification
    |--------------------------------------------------------------------------
    */

    Route::middleware('guest')->group(function () {

        Route::get('/login', [LoginController::class, 'showLoginForm'])
            ->name('login');

        Route::post('/login', [LoginController::class, 'login']);

        Route::get('/register', [RegisterController::class, 'showRegisterForm'])
            ->name('register');

        Route::post('/register', [RegisterController::class, 'register']);

    });

    /*
    |--------------------------------------------------------------------------
    | Utilisateur connecté
    |--------------------------------------------------------------------------
    */

    Route::middleware('auth')->group(function () {

        Route::post('/logout', [LogoutController::class, 'logout'])
            ->name('logout');

        Route::get('/profile', [ProfileController::class, 'edit'])
            ->name('profile.edit');

        Route::patch('/profile', [ProfileController::class, 'update'])
            ->name('profile.update');

        Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])
            ->name('profile.photo.delete');

        Route::get('/profile/login-history', [LoginHistoryController::class, 'index'])
            ->name('login.history');

    });

    /*
    |--------------------------------------------------------------------------
    | Administration
    |--------------------------------------------------------------------------
    */

    Route::middleware(['auth', 'role:Admin'])->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::post('/notifications/read-all', [NotificationController::class, 'readAll'])
            ->name('notifications.readAll');

        Route::get('/dashboard/login-history',[LoginHistoryController::class,'adminIndex'])
            ->name('dashboard.login-history');

        Route::get('/dashboard/login-history', [LoginHistoryController::class, 'dashboard'])
           ->name('dashboard.login-history');

        Route::get('/dashboard/login-history', [LoginHistoryController::class, 'adminIndex'])
           ->name('dashboard.login.history');

        /*
        | Utilisateurs
        */

        Route::get('/dashboard/users', [UserController::class, 'index'])
            ->name('users.index');

        Route::patch('/dashboard/users/{user}/role', [UserController::class, 'updateRole'])
            ->name('users.role');

        Route::delete('/dashboard/users/{user}', [UserController::class, 'destroy'])
            ->name('users.destroy');

        /*
        | Attractions
        */

        Route::get('/attractions/create', [AttractionController::class, 'create'])
            ->name('attractions.create');

        Route::post('/attractions', [AttractionController::class, 'store'])
            ->name('attractions.store');

        Route::get('/attractions/{attraction}/edit', [AttractionController::class, 'edit'])
            ->name('attractions.edit');

        Route::put('/attractions/{attraction}', [AttractionController::class, 'update'])
            ->name('attractions.update');

        Route::delete('/attractions/{attraction}', [AttractionController::class, 'destroy'])
            ->name('attractions.destroy');

    });

});