<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;    
use App\Http\Controllers\PostController;    
use App\Http\Controllers\logicController;   


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/user/create', [UserController::class, 'store'])->name('user.create')->middleware('auth:sanctum');
Route::put('/user/update/{id}', [UserController::class, 'update'])->name('user.update')->middleware('auth:sanctum');
Route::post('/register', [RegisterController::class, 'store'])->name('register');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth:sanctum');
Route::get('/posts', [PostController::class, 'index'])->name('posts.index')->middleware('auth:sanctum');
Route::post('/posts', [PostController::class, 'store'])
    ->middleware('auth:sanctum');
Route::patch('/posts/{post}', [PostController::class, 'update'])
    ->middleware('auth:sanctum');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])
    ->middleware('auth:sanctum');