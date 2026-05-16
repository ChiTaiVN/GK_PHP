<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giỏ hàng - BookStore</title>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo"><a href="/" style="color: white; text-decoration: none;"><i class="fa-solid fa-book-open"></i> BookStore</a></div>
        <div class="links">
            <a href="/">Tiếp tục mua sắm</a>
        </div>
    </nav>

    <div class="container">
        <h2 class="section-title">Giỏ hàng của bạn</h2>

        @if(session('success'))
            <div style="background: #2ecc71; color: white; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        <div class="cart-container">
            @if(session('cart') && count(session('cart')) > 0)
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Tên sách</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach(session('cart') as $id => $details)
                            @php $total += $details['price'] * $details['quantity']; @endphp
                            <tr>
                                <td><b>{{ $details['title'] }}</b><br><small>{{ $details['author'] }}</small></td>
                                <td>{{ number_format($details['price'], 0, ',', '.') }} đ</td>
                                <td>{{ $details['quantity'] }}</td>
                                <td><b>{{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }} đ</b></td>
                                <td>
                                    <a href="/remove-from-cart/{{ $id }}" class="btn-danger"><i class="fa-solid fa-trash"></i> Xóa</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="cart-total">
                    Tổng cộng: {{ number_format($total, 0, ',', '.') }} VNĐ
                </div>

                <div style="text-align: right;">
                    <a href="/checkout" class="btn" style="background: #27ae60;"><i class="fa-solid fa-credit-card"></i> Tiến hành thanh toán</a>
                </div>
            @else
                <div class="empty-cart">
                    <i class="fa-solid fa-cart-shopping fa-4x" style="margin-bottom: 20px; color: #bdc3c7;"></i>
                    <h3>Giỏ hàng đang trống</h3>
                    <p>Hãy tìm cho mình những cuốn sách thật hay nhé!</p>
                </div>
            @endif
        </div>
    </div>
</body>
</html>