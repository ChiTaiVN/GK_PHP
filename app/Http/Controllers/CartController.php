<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class CartController extends Controller
{
    // Hiển thị trang giỏ hàng
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    // Thêm sách vào giỏ
    public function add(Request $request, string $id)
    {
        $book = Book::findOrFail($id);
        $cart = session()->get('cart', []);

        // KIỂM TRA TỒN KHO
        $currentQty = isset($cart[$id]) ? $cart[$id]['quantity'] : 0;
        
        // Nếu số lượng định thêm vượt quá tồn kho thực tế
        if ($currentQty + 1 > $book->stock_quantity) {
            return redirect()->back()->with('error', 'Rất tiếc, quyển "' . $book->title . '" chỉ còn tối đa ' . $book->stock_quantity . ' cuốn trong kho!');
        }

        // Nếu sách đã có trong giỏ, tăng số lượng
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            // Nếu chưa có, thêm mới vào session
            $cart[$id] = [
                "title" => $book->title,
                "quantity" => 1,
                "price" => $book->price,
                "author" => $book->author
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Đã thêm sách vào giỏ hàng!');
    }

    // Xóa sách khỏi giỏ
    public function remove(string $id)
    {
        $cart = session()->get('cart');
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Đã xóa sách khỏi giỏ hàng!');
    }
}