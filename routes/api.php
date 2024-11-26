<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;


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
// Route::apiResource('/users', DashboardController::class);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/users', [DashboardController::class, 'dashboard']);
Route::post('/users/{userId}/change-role', [DashboardController::class, 'changeUserRole']);
Route::post('/users/add', [DashboardController::class, 'add']);
Route::get('/users/{id}/view', [DashboardController::class, 'view']);
Route::get('/users/{id}/edit', [DashboardController::class, 'edit']);
Route::put('/users/{id}/update', [DashboardController::class, 'update']);
Route::post('/users/{userId}/delete', [DashboardController::class, 'delete']);



