<?php

use App\Http\Controllers\studentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::post('/students', [studentController::class, 'store']);
Route::get('/students', [studentController::class, 'index']);
Route::get('/students/{id}', [studentController::class, 'show']);
Route::put('/students/{id}', [studentController::class, 'update']);
Route::patch('/students/{id}', [studentController::class, 'updatePartial']);
Route::delete('/students/{id}', [studentController::class, 'destroy']);



Route::group([
    'middleware' => 'api',
    'prefix' => 'auth',
], function() {
    // Usar la sintaxis correcta para especificar el controlador y su método
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
    Route::get('/profile', [AuthController::class, 'profile'])->middleware('auth:api');
});