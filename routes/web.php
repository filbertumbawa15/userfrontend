<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PajakController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ModulController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserController;
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

    Route::prefix('pajak')->middleware('checkcookie')->group(function () {
        Route::get('/', [PajakController::class, 'index'])->name('pajak');
    });

    Route::prefix('settings')->middleware('checkcookie')->group(function () {
        Route::get('/', [SettingsCOntroller::class, 'index'])->name('settings');

        Route::get('level/akses/{id}', [RolesController::class, 'akses'])->name('level.akses');
        Route::resource('level', RolesController::class);

        Route::resource('modul', ModulController::class);

        Route::resource('menu', MenuController::class);

        Route::resource('user', UserController::class);
    });

    Route::prefix('emkl')->middleware('checkcookie')->group(function () {
        Route::get('/', function () {
            echo "anjay";
        })->name('emkl');
    });
});
