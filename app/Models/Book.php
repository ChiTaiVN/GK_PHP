<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    // Khai báo các cột có thể thêm/sửa dữ liệu
    protected $fillable = [
        'title', 
        'author', 
        'description', 
        'price', 
        'stock_quantity', 
        'cover_image'
    ];
}