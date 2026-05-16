<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 
        'book_id', 
        'quantity', 
        'price_at_time'
    ];

    // Một chi tiết đơn hàng thuộc về một cuốn sách
    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'id');
    }
}