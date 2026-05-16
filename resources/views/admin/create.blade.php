<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Sách Mới - Admin</title>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}"> 
</head>
<body>
    <div class="container">
        <h2 class="section-title">Thêm Sách Mới</h2>
        
        <div class="admin-form">
            <form action="/admin/book/store" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label>Tên sách</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label>Tác giả</label>
                    <input type="text" name="author" class="form-control" required>
                </div>
                
                <div style="display: flex; gap: 20px;">
                    <div class="form-group" style="flex: 1;">
                        <label>Giá bán (VNĐ)</label>
                        <input type="number" name="price" class="form-control" value="0" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label>Số lượng tồn kho</label>
                        <input type="number" name="stock_quantity" class="form-control" value="0" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Ảnh bìa</label>
                    <input type="file" name="cover_image" class="form-control" accept="image/*">
                </div>

                <div class="form-group">
                    <label>Mô tả nội dung</label>
                    <textarea name="description" class="form-control" rows="5" required></textarea>
                </div>

                <div style="text-align: right; margin-top: 20px;">
                    <a href="/admin" class="btn" style="background: #95a5a6; margin-right: 10px;">Hủy</a>
                    <button type="submit" class="btn" style="background: #27ae60;"><i class="fa-solid fa-save"></i> Lưu Sách</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>