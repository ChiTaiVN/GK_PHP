<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Lịch sử mua hàng - BookStore</title>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .order-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border-left: 5px solid var(--primary-color);
        }
        .order-header {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px dashed #eee;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }
        .status-pending { color: #f39c12; font-weight: bold; background: #fef5e7; padding: 5px 10px; border-radius: 5px; }
        .status-paid { color: #27ae60; font-weight: bold; background: #e9f7ef; padding: 5px 10px; border-radius: 5px; }
        .item-row { display: flex; justify-content: space-between; margin-bottom: 10px; color: #555; }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo"><a href="/" style="color: white; text-decoration: none;"><i class="fa-solid fa-book-open"></i> BookStore</a></div>
        <div class="links">
            <a href="/">Quay lại cửa hàng</a>
        </div>
    </nav>

    <div class="container">
        <h2 class="section-title"><i class="fa-solid fa-clock-rotate-left"></i> Lịch sử mua hàng</h2>

        @if($orders->isEmpty())
            <div style="text-align: center; padding: 50px; background: white; border-radius: 10px;">
                <i class="fa-solid fa-box-open fa-4x" style="color: #bdc3c7; margin-bottom: 20px;"></i>
                <p>Bạn chưa có đơn hàng nào.</p>
                <a href="/" class="btn" style="margin-top: 15px;">Mua sắm ngay</a>
            </div>
        @else
            @foreach($orders as $order)
                <div class="order-card">
                    <div class="order-header">
                        <div>
                            <h3 style="margin: 0; color: var(--primary-color);">Mã đơn: #{{ $order->order_code }}</h3>
                            <small style="color: #7f8c8d;">Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                        <div>
                            @if($order->status == 'pending')
                                <span class="status-pending"><i class="fa-solid fa-hourglass-half"></i> Chờ thanh toán</span>
                            @elseif($order->status == 'paid')
                                <span class="status-paid"><i class="fa-solid fa-check"></i> Đã thanh toán</span>
                            @else
                                <span>{{ $order->status }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="order-items">
                        @foreach($order->items as $item)
                            <div class="item-row">
                                <span><b>{{ $item->quantity }}x</b> {{ $item->book ? $item->book->title : 'Sách đã ngừng bán' }}</span>
                                <span>{{ number_format($item->price_at_time * $item->quantity, 0, ',', '.') }} đ</span>
                            </div>
                        @endforeach
                    </div>

                    <div style="text-align: right; border-top: 1px solid #eee; padding-top: 15px; margin-top: 15px;">
                        Tổng tiền: <b style="font-size: 1.2rem; color: var(--accent-color);">{{ number_format($order->total_amount, 0, ',', '.') }} VNĐ</b>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</body>
</html>