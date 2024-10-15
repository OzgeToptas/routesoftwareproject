<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orders extends Model
{
    use SoftDeletes;
    protected $table        = "orders";
    protected $guarded      = [];

    public function cart(){
        return $this->hasOne(Cart::class, 'order_id');
    }
}
