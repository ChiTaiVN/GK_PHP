<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // 1. Chèn dữ liệu Users
        $adminId = DB::table('users')->insertGetId([
            'name' => 'Quản trị viên',
            'email' => 'admin@bookstore.com',
            'password' => Hash::make('123456'), // Mật khẩu mặc định là 123456
            'role' => 'admin',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $customerId = DB::table('users')->insertGetId([
            'name' => 'Khách hàng Cần Cù',
            'email' => 'student@bookstore.com',
            'password' => Hash::make('123456'),
            'role' => 'customer',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 2. Chèn dữ liệu Books
        $book1Id = DB::table('books')->insertGetId([
            'title' => 'C++ Cơ Bản cho Người Mới',
            'author' => 'Thầy Giáo IT',
            'description' => 'Sách hướng dẫn làm quen với cú pháp, biến, và vòng lặp trong C++.',
            'price' => 150000,
            'stock_quantity' => 100,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $book2Id = DB::table('books')->insertGetId([
            'title' => 'Cấu trúc Dữ liệu & Thuật toán Thực chiến',
            'author' => 'Chuyên gia Thuật toán',
            'description' => 'Nâng cao tư duy logic và tối ưu hóa code dành cho sinh viên CNTT.',
            'price' => 200000,
            'stock_quantity' => 50,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 3. Chèn dữ liệu Đơn hàng (Orders)
        $orderId = DB::table('orders')->insertGetId([
            'user_id' => $customerId,
            'order_code' => 'ORD-' . time(),
            'total_amount' => 350000,
            'status' => 'completed',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 4. Chèn dữ liệu Chi tiết đơn hàng (Order Items)
        DB::table('order_items')->insert([
            [
                'order_id' => $orderId,
                'book_id' => $book1Id,
                'quantity' => 1,
                'price_at_time' => 150000,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'order_id' => $orderId,
                'book_id' => $book2Id,
                'quantity' => 1,
                'price_at_time' => 200000,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ]);
    }
}