<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // Hiển thị danh sách tất cả các sách trong kho
    public function index()
    {
        $books = Book::orderBy('created_at', 'desc')->get();
        return view('admin.index', compact('books'));
    }

    // Hiển thị form thêm sách mới
    public function create()
    {
        return view('admin.create');
    }

    // Xử lý lưu sách mới vào Database
    public function store(Request $request)
    {
        // 1. Kiểm tra dữ liệu đầu vào
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|numeric|min:0',
            'description' => 'required',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Ràng buộc file ảnh
        ]);

        $imagePath = null;
        
        // 2. Xử lý Upload ảnh (nếu có)
        if ($request->hasFile('cover_image')) {
            // Lưu ảnh vào thư mục storage/app/public/books
            $imagePath = $request->file('cover_image')->store('books', 'public');
        }

        // 3. Tạo dữ liệu vào Database
        Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'description' => $request->description,
            'cover_image' => $imagePath,
        ]);

        return redirect('/admin')->with('success', 'Đã thêm sách mới thành công!');
    }
}