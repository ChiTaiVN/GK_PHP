<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Kho Sách - Admin</title>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar" style="background: #34495e;">
        <div class="logo"><i class="fa-solid fa-user-shield"></i> Trang Quản Trị</div>
        <div class="links">
            <a href="/">Xem trang Cửa hàng</a>
        </div>
    </nav>

    <div class="container">
        <div class="admin-header">
            <h2 class="section-title" style="margin: 0;">Quản lý Sách</h2>
            <a href="/admin/book/create" class="btn" style="background: #27ae60;"><i class="fa-solid fa-plus"></i> Thêm Sách Mới</a>
        </div>

        @if(session('success'))
            <div style="background: #2ecc71; color: white; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ảnh</th>
                    <th>Tên sách</th>
                    <th>Tác giả</th>
                    <th>Giá</th>
                    <th>Tồn kho</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($books as $book)
                <tr>
                    <td>{{ $book->id }}</td>
                    <td>
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" class="book-thumbnail">
                        @else
                            <div class="book-thumbnail"><i class="fa-solid fa-image" style="color: #ccc;"></i></div>
                        @endif
                    </td>
                    <td><b>{{ $book->title }}</b></td>
                    <td>{{ $book->author }}</td>
                    <td>{{ number_format($book->price, 0, ',', '.') }} đ</td>
                    <td>{{ $book->stock_quantity }}</td>
                    <td>
                        <button class="btn" style="background: #f39c12; padding: 5px 10px;"><i class="fa-solid fa-pen"></i> Sửa</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>