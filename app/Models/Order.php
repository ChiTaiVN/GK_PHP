<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 
        'order_code', 
        'total_amount', 
        'status'
    ];

    // Một đơn hàng có nhiều chi tiết đơn hàng
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }
}