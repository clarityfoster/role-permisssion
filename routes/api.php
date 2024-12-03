<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Resources\UserResource;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/users', [DashboardController::class, 'dashboard'])->name('users.dashboard');
    Route::post('/users/search', [DashboardController::class, 'search'])->name('users.search');
    Route::post('/users/add', [DashboardController::class, 'add'])->name('users.add');
    Route::get('/users/{id}/view', [DashboardController::class, 'view'])->name('users.view');
    Route::get('/users/{id}/edit', [DashboardController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}/update', [DashboardController::class, 'update'])->name('users.update');
    Route::post('/users/{userId}/delete', [DashboardController::class, 'delete'])->name('users.delete');
    Route::post('/users/{userId}/suspend', [DashboardController::class, 'suspended'])->name('users.suspend');
    Route::post('/users/{userId}/unsuspend', [DashboardController::class, 'unsuspended'])->name('users.unsuspend');
    Route::post('/users/{userId}/change-role', [DashboardController::class, 'changeUserRole'])->name('users.changeRole');

    Route::get('/permissions-and-roles', [RolePermissionController::class, 'index'])->name('roles.index');
    Route::post('/roles/add', [RolePermissionController::class, 'add'])->name('roles.add');
    Route::post('/roles/{role}/permissions', [RolePermissionController::class, 'updateRolePermissions'])->name('roles.updatePermissions');
    Route::get('/roles/{role}/permissions', [RolePermissionController::class, 'getPermissions'])->name('roles.getPermissions');

    Route::get('/user', function (Request $request) {
        $user = $request->user();
        return new UserResource($request->user());
    })->name('user.profile');
});
