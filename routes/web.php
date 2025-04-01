<?php

use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\VehiclesController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', [ClientController::class, 'index'])
    ->name('clientes.index')
    ->middleware('auth');
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    // Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

Route::get('admin/clientes/search', [ClientController::class, 'search'])->name('admin.clientes.search');
Route::get('admin/vehiculos/search', [VehiclesController::class, 'search'])->name('admin.vehiculos.search');
require __DIR__.'/auth.php';
