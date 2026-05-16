<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>{{ $book->title }} - BookStore</title>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo"><a href="/" style="color: white; text-decoration: none;"><i class="fa-solid fa-book-open"></i> BookStore</a></div>
    </nav>

    <div class="container">
        <a href="/" style="text-decoration: none; color: var(--secondary-color); font-weight: bold;">
            <i class="fa-solid fa-arrow-left"></i> Quay lại Cửa hàng
        </a>

        <div class="detail-container">
            <div class="detail-image">
                <i class="fa-solid fa-book"></i>
            </div>
            
            <div class="detail-info">
                <h1 class="detail-title">{{ $book->title }}</h1>
                <div class="detail-author">Tác giả: <b>{{ $book->author }}</b></div>
                
                <div class="stock-status">
                    <i class="fa-solid fa-check-circle"></i> Còn {{ $book->stock_quantity }} quyển
                </div>
                
                <div class="detail-price">{{ number_format($book->price, 0, ',', '.') }} VNĐ</div>
                
                <div class="detail-desc">
                    <b>Mô tả nội dung:</b><br>
                    {{ $book->description }}
                </div>
                    <a href="{{ route('cart.add', $book->id) }}" class="btn" style="padding: 15px 30px; font-size: 1.1rem;">
                        <i class="fa-solid fa-cart-plus"></i> Thêm vào Giỏ hàng
                    </a>
            </div>
        </div>
    </div>
</body>
</html>