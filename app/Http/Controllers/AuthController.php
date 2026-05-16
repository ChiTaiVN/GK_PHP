<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Hiển thị form đăng nhập
    public function showLoginForm() {
        return view('auth.login');
    }

    // Xử lý đăng nhập
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Kiểm tra email và mật khẩu. Nếu đúng, tự động tạo session
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/'); // Chuyển về trang chủ
        }

        // Nếu sai, quay lại trang đăng nhập và báo lỗi
        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không chính xác.',
        ]);
    }

    // Hiển thị form đăng ký
    public function showRegisterForm() {
        return view('auth.register');
    }

    // Xử lý đăng ký
    public function register(Request $request) {
        // Kiểm tra tính hợp lệ của dữ liệu nhập vào
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed', // 'confirmed' tự động kiểm tra với trường password_confirmation
        ]);

        // Tạo user mới và mã hóa mật khẩu
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer'
        ]);

        // Đăng nhập luôn cho user sau khi đăng ký thành công
        Auth::login($user);
        return redirect('/');
    }

    // Xử lý đăng xuất
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}