<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập - BookStore</title>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo"><a href="/" style="color: white; text-decoration: none;"><i class="fa-solid fa-book-open"></i> BookStore</a></div>
    </nav>

    <div class="auth-container">
        <h2>Đăng Nhập</h2>
        
        @if($errors->any())
            <div class="error-msg">{{ $errors->first() }}</div>
        @endif

        <form action="/login" method="POST">
            @csrf <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required placeholder="Nhập email...">
            </div>
            <div class="form-group">
                <label>Mật khẩu</label>
                <input type="password" name="password" class="form-control" required placeholder="Nhập mật khẩu...">
            </div>
            <button type="submit" class="btn btn-block">Đăng Nhập</button>
        </form>
        
        <p class="text-center">Chưa có tài khoản? <a href="/register">Đăng ký ngay</a></p>
    </div>
</body>
</html>