<?php

use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthenticateController::class,'login'])->name('login');
Route::post('/login', [AuthenticateController::class,'authenticate'])->name('authenticate');
Route::get('/logout', [AuthenticateController::class,'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class,'index'])->name('home');
    Route::post('/upload-file', [HomeController::class,'store'])->name('upload-file');
});
