<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\RoleAndPermissionController;
use App\Http\Middleware\Admin\AdminMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::prefix('admin')->name('admin.')->middleware(AdminMiddleware::class)
        ->group(function () {
            Route::get('/roles-permissions', [RoleAndPermissionController::class, 'index'])
                ->name('roles-permissions.index');
            Route::put('/users/{user}/roles', [RoleAndPermissionController::class, 'updateUserRoles'])
                ->name('users.update-roles');
            Route::put('/roles/{role}/permissions', [RoleAndPermissionController::class, 'updateRolePermissions'])
                ->name('roles.update-permissions');
        });

    Route::resource('articles', ArticleController::class);
});
