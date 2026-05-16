<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    // Lấy chi tiết một cuốn sách dựa vào ID
    public function show($id)
    {
        // findOrFail sẽ tự động tìm sách theo ID, nếu không thấy sẽ văng lỗi 404
        $book = Book::findOrFail($id);
        
        return view('books.detail', compact('book'));
    }
}