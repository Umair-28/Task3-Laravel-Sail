<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AuthController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

    // Auth APIs

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // User APIs
    Route::get('/users',[Controller::class, 'getAllUsers'] );
    Route::get('/users/{id}', [Controller::class, 'getUserById']);
    Route::delete('/users/{id}', [Controller::class, 'deleteUserById']);
    Route::put('/users/{id}', [Controller::class, 'updateUserById']);
    



