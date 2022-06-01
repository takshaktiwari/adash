<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use Takshak\Adash\Http\Middleware\RefererMiddleware;
use Takshak\Adash\Http\Middleware\GatesMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth', GatesMiddleware::class, RefererMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('password', [AdminController::class, 'password'])->name('password');
    Route::post('password', [AdminController::class, 'passwordUpdate'])->name('password.update');

    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class)->except(['show']);
    Route::get('login-to/{user:id}', [UserController::class, 'loginToUser'])->name('login-to');

    Route::resource('permissions', PermissionController::class)->except(['show']);
    Route::prefix('permissions')->name('permissions.')->group(function () {
        Route::get('roles', [PermissionController::class, 'rolePermissions'])->name('roles.index');
        Route::post('{role}', [PermissionController::class, 'rolePermissionsUpdate'])->name('roles.update');
    });
});
