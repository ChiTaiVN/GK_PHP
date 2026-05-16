<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book; // Nhúng Model Book vào

class HomeController extends Controller
{
    public function index()
    {
        // Lấy tất cả sách, sắp xếp mới nhất lên đầu
        $books = Book::orderBy('created_at', 'desc')->get();
        
        // Trả về view 'home' và truyền biến $books sang
        return view('home', compact('books'));
    }
}