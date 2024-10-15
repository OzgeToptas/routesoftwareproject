<?php

use App\Http\Controllers\Api\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('orders', [OrderController::class, 'orders'])->name('orders');
