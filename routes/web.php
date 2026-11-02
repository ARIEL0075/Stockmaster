<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\UserController;

Route::get('/', function () {
    return view('welcome');
});

// Accessibles sans être connecté (guest : un utilisateur déjà connecté est redirigé)
Route::middleware('guest')->group(function () {
    Route::get('/login', [DashboardController::class, 'login'])->name('admin.login');
    Route::post('/login', [DashboardController::class, 'dologin'])->name('admin.dologin');
});

// Déconnexion : réservée aux utilisateurs connectés
Route::delete('/logout', [DashboardController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Espace admin : connexion obligatoire
Route::prefix('admin')->name('admin.')->middleware(['auth','active'])->group(function () {

    // Routes accessibles aux administrateurs et gestionnaires
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('/stock-movements', [DashboardController::class, 'stockMovements'])->name('stock-movements');

    Route::post('/stock-movements', [DashboardController::class, 'storeStockMovement'])->name('stock-movements.store');

    Route::get('/history', [DashboardController::class, 'history'])->name('history');

    Route::resource('products', ProductsController::class);
    Route::resource('categories', CategoriesController::class);

    // Routes réservées aux administrateurs
    Route::middleware('admin')->group(function () {

        Route::get('/users', [UserController::class, 'index'])->name('users.index');

        Route::resource('users', UserController::class)
            ->except(['index'])
            ->names('users');

        Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])
            ->name('users.toggleStatus');

    });

});