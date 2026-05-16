<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thanh Toán - BookStore</title>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo"><a href="/" style="color: white; text-decoration: none;"><i class="fa-solid fa-book-open"></i> BookStore</a></div>
        <div class="links">
            <a href="/cart">Quay lại Giỏ hàng</a>
        </div>
    </nav>

    <div class="container">
        <h2 class="section-title">Xác Nhận Đơn Hàng</h2>

        <div class="detail-container" style="align-items: flex-start;">
            
            <div class="detail-info" style="flex: 1; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                <h3>Thông tin khách hàng</h3>
                <p><b>Họ tên:</b> {{ Auth::user()->name }}</p>
                <p><b>Email:</b> {{ Auth::user()->email }}</p>
                <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
                <p style="color: #7f8c8d; font-size: 0.9rem;">
                    <i class="fa-solid fa-shield-halved"></i> Giao dịch của bạn được xử lý an toàn thông qua cổng thanh toán tự động PayOS.
                </p>
            </div>

            <div style="flex: 1.5; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                <h3>Tóm tắt đơn hàng</h3>
                <table class="cart-table">
                    @php $total = 0; @endphp
                    @foreach($cart as $details)
                        @php $total += $details['price'] * $details['quantity']; @endphp
                        <tr>
                            <td>{{ $details['title'] }} (x{{ $details['quantity'] }})</td>
                            <td style="text-align: right;"><b>{{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }} đ</b></td>
                        </tr>
                    @endforeach
                </table>
                <div class="cart-total" style="border-top: 2px dashed #eee; padding-top: 15px;">
                    Tổng thanh toán: <span style="color: var(--accent-color);">{{ number_format($total, 0, ',', '.') }} VNĐ</span>
                </div>

                <form action="/process-order" method="POST" style="text-align: right;">
                    @csrf
                    <button type="submit" class="btn" style="background: #111827; padding: 15px 30px; font-size: 1.1rem; margin-top: 20px;">
                        <i class="fa-solid fa-credit-card"></i> Thanh toán qua PayOS
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>