<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PajakController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ModulController;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
});

Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('pajak')->group(function () {
        Route::get('/', [PajakController::class, 'index'])->name('pajak');
    });

    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingsCOntroller::class, 'index'])->name('settings');
        Route::resource('roles', RolesController::class);
        Route::resource('modul', ModulController::class);
        Route::resource('menu', MenuController::class);
        // Route::resource('shippernoorder', ShipperNoOrderController::class);
    });
});
