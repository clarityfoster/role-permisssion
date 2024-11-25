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
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/users/{userId}/change-role', [DashboardController::class, 'changeUserRole']);
Route::post('/users/add', [DashboardController::class, 'add']);
Route::post('/users/{userId}/edit', [DashboardController::class, 'edit']);
Route::post('/users/{userId}/delete', [DashboardController::class, 'delete']);

Route::middleware('auth:sanctum')->get('/dashboard', [DashboardController::class, 'dashboard']);



