<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Orders;

class OrderController extends Controller
{
    public function orders() {
        return OrderResource::collection(Orders::with('cart')->get());
    }
}
