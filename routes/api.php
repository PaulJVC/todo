<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TaskController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('posts', PostController::class);
// Route::apiResource('tasks', TaskController::class);

// Task Routes
Route::get('/task/{task}', [TaskController::class, 'getTask']);
Route::get('/task/user/{user_id}', [TaskController::class, 'getUserTask']);
Route::post('/task', [TaskController::class, 'storeTask']);
Route::put('/task/update/{task}', [TaskController::class, 'updateTask']);
Route::get('/task/download/{task}', [TaskController::class, 'downloadAttachment']);

//Authentication Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');