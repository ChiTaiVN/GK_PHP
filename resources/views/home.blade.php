<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookStore - Tri thức trong tầm tay</title>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <nav class="navbar">
        <div class="logo"><a href="/" style="color: white; text-decoration: none;"><i class="fa-solid fa-book-open"></i> BookStore</a></div>
        
        <div class="links">
            <a href="/cart"><i class="fa-solid fa-cart-shopping"></i> Giỏ hàng 
                @if(session('cart'))
                    <span style="background: var(--accent-color); padding: 2px 8px; border-radius: 50%; font-size: 0.8rem;">
                        {{ count(session('cart')) }}
                    </span>
                @endif
            </a>
            
            @auth
                <a href="/history"><i class="fa-solid fa-clock-rotate-left"></i> Lịch sử mua</a>
            @endauth

            @if(Auth::check() && Auth::user()->role === 'admin')
                <a href="/admin" style="color: #f1c40f;"><i class="fa-solid fa-user-shield"></i> Trang Quản Trị</a>
            @endif
            
            @auth
                <span style="margin-left: 20px;">Xin chào, <b>{{ Auth::user()->name }}</b></span>
                
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" style="background:none; border:none; color:#e74c3c; cursor:pointer; font-weight:bold; margin-left:15px;">
                        <i class="fa-solid fa-power-off"></i> Đăng xuất
                    </button>
                </form>
            @else
                <a href="/login">Đăng nhập</a>
                <a href="/register">Đăng ký</a>
            @endauth
        </div>
    </nav>

    <div class="container">
        
        <div class="hero-banner">
            <h1>Chào mừng đến với BookStore!</h1>
            <p>Khám phá kho tàng tri thức với hàng ngàn đầu sách phong phú được cập nhật mỗi ngày.</p>
        </div>

        <h2 class="section-title">Sản Phẩm Nổi Bật</h2>
        
        @if(session('success'))
            <div style="background: #2ecc71; color: white; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div style="background: #e74c3c; color: white; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                <i class="fa-solid fa-triangle-exclamation"></i> {{ session('error') }}
            </div>
        @endif
        
        <div class="book-grid">
            @foreach($books as $book)
            <div class="book-card">
                
                @if($book->cover_image)
                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" style="width: 100%; height: 250px; object-fit: cover; border-radius: 5px; margin-bottom: 15px;">
                @else
                    <i class="fa-solid fa-book book-icon"></i>
                @endif
                
                <a href="/book/{{ $book->id }}" style="text-decoration: none;">
                    <h3 class="book-title">{{ $book->title }}</h3>
                </a>
                <p class="book-author">Tác giả: {{ $book->author }}</p>
                <div class="book-price">{{ number_format($book->price, 0, ',', '.') }} đ</div>
                
                <a href="{{ route('cart.add', $book->id) }}" class="btn">
                    <i class="fa-solid fa-cart-plus"></i> Thêm vào giỏ
                </a>
            </div>
            @endforeach
        </div>
    </div>

</body>
</html>