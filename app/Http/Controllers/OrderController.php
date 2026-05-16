<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Book;

class OrderController extends Controller
{
    // Hiển thị trang tóm tắt đơn hàng
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect('/')->with('error', 'Giỏ hàng của bạn đang trống!');
        }
        return view('cart.checkout', compact('cart'));
    }
    
    // Hiển thị lịch sử mua hàng
    public function history()
    {
        // Lấy các đơn hàng của user đang đăng nhập, kèm theo chi tiết và thông tin sách
        $orders = Order::with('items.book')
                    ->where('user_id', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('orders.history', compact('orders'));
    }

    // Xử lý tạo đơn hàng và gọi API PayOS
    public function process(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) return redirect('/');

        $totalAmount = 0;
        foreach ($cart as $details) {
            $totalAmount += $details['price'] * $details['quantity'];
        }

        // Mã đơn hàng PayOS yêu cầu là SỐ NGUYÊN (INT)
        $orderCode = intval(date('ymdHi') . rand(10, 99));

        // 1. Lưu đơn hàng vào DB
        $order = Order::create([
            'user_id' => Auth::id(),
            'order_code' => $orderCode,
            'total_amount' => $totalAmount,
            'status' => 'pending' // Chờ thanh toán
        ]);

        // 2. Lưu chi tiết và trừ tồn kho
        foreach ($cart as $id => $details) {
            OrderItem::create([
                'order_id' => $order->id,
                'book_id' => $id,
                'quantity' => $details['quantity'],
                'price_at_time' => $details['price']
            ]);

            $book = Book::find($id);
            if ($book) {
                $book->stock_quantity -= $details['quantity'];
                $book->save();
            }
        }

        // 3. Chuẩn bị dữ liệu gửi lên PayOS
        $data = [
            "orderCode" => $orderCode,
            "amount" => $totalAmount,
            "description" => "Thanh toan don hang",
            "returnUrl" => route('checkout.success'),
            "cancelUrl" => route('checkout.cancel')
        ];

        // Tạo chữ ký (Signature)
        $signatureData = "amount=" . $data['amount'] . "&cancelUrl=" . $data['cancelUrl'] . "&description=" . $data['description'] . "&orderCode=" . $data['orderCode'] . "&returnUrl=" . $data['returnUrl'];
        $data['signature'] = hash_hmac('sha256', $signatureData, env('PAYOS_CHECKSUM_KEY'));

        // Gọi API
        $response = Http::withHeaders([
            'x-client-id' => env('PAYOS_CLIENT_ID'),
            'x-api-key' => env('PAYOS_API_KEY'),
            'Content-Type' => 'application/json'
        ])->post('https://api-merchant.payos.vn/v2/payment-requests', $data);

        $payosData = $response->json();

        // 4. Nếu PayOS trả về link thanh toán thành công
        if (isset($payosData['code']) && $payosData['code'] == '00') {
            session()->forget('cart'); // Xóa giỏ hàng
            return redirect($payosData['data']['checkoutUrl']); // Chuyển khách sang PayOS
        }

        return redirect('/cart')->with('error', 'Lỗi khởi tạo cổng thanh toán PayOS!');
    }

    // Khi khách thanh toán thành công và được PayOS chuyển về
    public function success() {
        return redirect('/')->with('success', 'Thanh toán hoàn tất! Cảm ơn bạn đã mua hàng.');
    }

    // Khi khách bấm Hủy thanh toán trên trang PayOS
    public function cancel() {
        return redirect('/')->with('error', 'Bạn đã hủy quá trình thanh toán.');
    }

// Webhook để PayOS báo về Server khi có tiền vào tài khoản
    public function webhook(Request $request) {
        try {
            $body = $request->all();

            // Dùng isset() để kiểm tra an toàn, tránh lỗi 500 khi PayOS Ping thử URL
            if (isset($body['success']) && $body['success'] == true && isset($body['data']['orderCode'])) {
                $orderCode = $body['data']['orderCode'];
                
                // Cập nhật trạng thái đơn hàng thành 'paid'
                $order = Order::where('order_code', $orderCode)->first();
                if ($order) {
                    $order->update(['status' => 'paid']);
                }
            }
            
            // Bắt buộc phải trả về JSON HTTP 200 báo thành công cho PayOS
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            // Nếu có lỗi code, vẫn phải trả về 200 kèm thông báo lỗi để PayOS không đánh dấu chết Webhook
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}