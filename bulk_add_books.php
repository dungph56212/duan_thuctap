<?php
// bulk_add_books.php - Thêm nhiều sách cùng lúc
session_start();
require_once 'commons/env.php';
require_once 'commons/function.php';

if (isset($_POST['bulk_add'])) {
    try {
        $conn = connectDB();
        
        // Danh sách sách mẫu để thêm vào
        $sampleBooks = [
            [
                'ten_san_pham' => 'Đắc Nhân Tâm',
                'gia_san_pham' => 89000,
                'gia_khuyen_mai' => 69000,
                'hinh_anh' => 'dac-nhan-tam.jpg',
                'so_luong' => 50,
                'mo_ta' => 'Cuốn sách kinh điển về nghệ thuật giao tiếp và ứng xử của Dale Carnegie.',
                'danh_muc_id' => 1,
                'trang_thai' => 1
            ],
            [
                'ten_san_pham' => 'Nhà Giả Kim',
                'gia_san_pham' => 79000,
                'gia_khuyen_mai' => 59000,
                'hinh_anh' => 'nha-gia-kim.jpg',
                'so_luong' => 30,
                'mo_ta' => 'Tiểu thuyết nổi tiếng của Paulo Coelho về hành trình tìm kiếm kho báu.',
                'danh_muc_id' => 1,
                'trang_thai' => 1
            ],
            [
                'ten_san_pham' => 'Tôi Thấy Hoa Vàng Trên Cỏ Xanh',
                'gia_san_pham' => 65000,
                'gia_khuyen_mai' => 45000,
                'hinh_anh' => 'hoa-vang-co-xanh.jpg',
                'so_luong' => 40,
                'mo_ta' => 'Tiểu thuyết của Nguyễn Nhật Ánh về tuổi thơ dữ dội.',
                'danh_muc_id' => 1,
                'trang_thai' => 1
            ],
            [
                'ten_san_pham' => 'Sách Giáo Khoa Toán Lớp 12',
                'gia_san_pham' => 45000,
                'gia_khuyen_mai' => null,
                'hinh_anh' => 'sgk-toan-12.jpg',
                'so_luong' => 100,
                'mo_ta' => 'Sách giáo khoa Toán lớp 12 theo chương trình mới.',
                'danh_muc_id' => 2,
                'trang_thai' => 1
            ],
            [
                'ten_san_pham' => 'Sách Giáo Khoa Văn Lớp 11',
                'gia_san_pham' => 42000,
                'gia_khuyen_mai' => null,
                'hinh_anh' => 'sgk-van-11.jpg',
                'so_luong' => 80,
                'mo_ta' => 'Sách giáo khoa Ngữ văn lớp 11 theo chương trình mới.',
                'danh_muc_id' => 2,
                'trang_thai' => 1
            ],
            [
                'ten_san_pham' => 'One Piece - Tập 1',
                'gia_san_pham' => 25000,
                'gia_khuyen_mai' => 22000,
                'hinh_anh' => 'one-piece-tap-1.jpg',
                'so_luong' => 200,
                'mo_ta' => 'Manga nổi tiếng của Eiichiro Oda về băng hải tặc Mũ Rơm.',
                'danh_muc_id' => 3,
                'trang_thai' => 1
            ],
            [
                'ten_san_pham' => 'Doraemon - Tập 1',
                'gia_san_pham' => 20000,
                'gia_khuyen_mai' => 18000,
                'hinh_anh' => 'doraemon-tap-1.jpg',
                'so_luong' => 150,
                'mo_ta' => 'Truyện tranh thiếu nhi nổi tiếng về chú mèo máy Doraemon.',
                'danh_muc_id' => 3,
                'trang_thai' => 1
            ],
            [
                'ten_san_pham' => 'Sherlock Holmes - Cuộc Phiêu Lưu',
                'gia_san_pham' => 95000,
                'gia_khuyen_mai' => 75000,
                'hinh_anh' => 'sherlock-holmes.jpg',
                'so_luong' => 25,
                'mo_ta' => 'Tuyển tập truyện trinh thám kinh điển của Arthur Conan Doyle.',
                'danh_muc_id' => 1,
                'trang_thai' => 1
            ],
            [
                'ten_san_pham' => 'Lập Trình Web với PHP & MySQL',
                'gia_san_pham' => 299000,
                'gia_khuyen_mai' => 249000,
                'hinh_anh' => 'lap-trinh-php.jpg',
                'so_luong' => 15,
                'mo_ta' => 'Sách hướng dẫn lập trình web từ cơ bản đến nâng cao.',
                'danh_muc_id' => 4,
                'trang_thai' => 1
            ],
            [
                'ten_san_pham' => 'Học JavaScript Hiệu Quả',
                'gia_san_pham' => 259000,
                'gia_khuyen_mai' => 199000,
                'hinh_anh' => 'hoc-javascript.jpg',
                'so_luong' => 20,
                'mo_ta' => 'Sách học JavaScript từ cơ bản đến nâng cao với nhiều ví dụ thực tế.',
                'danh_muc_id' => 4,
                'trang_thai' => 1
            ]
        ];
        
        $sql = "INSERT INTO san_phams (
            ten_san_pham, gia_san_pham, gia_khuyen_mai, hinh_anh, 
            so_luong, luot_xem, ngay_nhap, mo_ta, danh_muc_id, trang_thai
        ) VALUES (
            :ten_san_pham, :gia_san_pham, :gia_khuyen_mai, :hinh_anh,
            :so_luong, 0, NOW(), :mo_ta, :danh_muc_id, :trang_thai
        )";
        
        $stmt = $conn->prepare($sql);
        $added = 0;
        $errors = [];
        
        foreach ($sampleBooks as $book) {
            try {
                $stmt->execute([
                    ':ten_san_pham' => $book['ten_san_pham'],
                    ':gia_san_pham' => $book['gia_san_pham'],
                    ':gia_khuyen_mai' => $book['gia_khuyen_mai'],
                    ':hinh_anh' => $book['hinh_anh'],
                    ':so_luong' => $book['so_luong'],
                    ':mo_ta' => $book['mo_ta'],
                    ':danh_muc_id' => $book['danh_muc_id'],
                    ':trang_thai' => $book['trang_thai']
                ]);
                $added++;
            } catch (Exception $e) {
                $errors[] = "Lỗi thêm '{$book['ten_san_pham']}': " . $e->getMessage();
            }
        }
        
        $success = "✅ Đã thêm $added sách thành công!";
        if (!empty($errors)) {
            $success .= "<br>⚠️ Một số lỗi: " . implode('<br>', array_slice($errors, 0, 3));
        }
        
    } catch (Exception $e) {
        $error = "❌ Lỗi: " . $e->getMessage();
    }
}

// Lấy thống kê
try {
    $conn = connectDB();
    $stmt = $conn->query("SELECT COUNT(*) FROM san_phams");
    $totalBooks = $stmt->fetchColumn();
    
    $stmt = $conn->query("SELECT COUNT(*) FROM danh_mucs");
    $totalCategories = $stmt->fetchColumn();
    
    $stmt = $conn->query("SELECT SUM(so_luong) FROM san_phams");
    $totalQuantity = $stmt->fetchColumn();
    
} catch (Exception $e) {
    $totalBooks = 0;
    $totalCategories = 0;
    $totalQuantity = 0;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📚 Thêm Sách Hàng Loạt</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            padding: 30px;
            background: #f8f9fa;
        }
        
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .stat-number {
            font-size: 2.5em;
            font-weight: bold;
            color: #0984e3;
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: #666;
            font-weight: 500;
        }
        
        .content {
            padding: 40px;
        }
        
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .sample-books {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        
        .sample-books h3 {
            margin-bottom: 15px;
            color: #495057;
        }
        
        .book-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 15px;
        }
        
        .book-item {
            background: white;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }
        
        .book-title {
            font-weight: 600;
            color: #0984e3;
            margin-bottom: 5px;
        }
        
        .book-price {
            color: #e74c3c;
            font-weight: 500;
            margin-bottom: 5px;
        }
        
        .book-desc {
            color: #666;
            font-size: 0.9em;
        }
        
        .btn {
            background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            margin-bottom: 20px;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(116, 185, 255, 0.4);
        }
        
        .btn:active {
            transform: translateY(0);
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #ff7675 0%, #d63031 100%);
        }
        
        .btn-danger:hover {
            box-shadow: 0 5px 15px rgba(255, 118, 117, 0.4);
        }
        
        .navigation {
            padding: 20px;
            background: #f8f9fa;
            text-align: center;
        }
        
        .navigation a {
            color: #0984e3;
            text-decoration: none;
            margin: 0 15px;
            font-weight: 500;
            padding: 10px 20px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        
        .navigation a:hover {
            background: #0984e3;
            color: white;
        }
        
        .warning {
            background: #fff3cd;
            color: #856404;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #ffeaa7;
        }
        
        @media (max-width: 768px) {
            .header h1 {
                font-size: 2em;
            }
            
            .content {
                padding: 20px;
            }
            
            .stats {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📚 Thêm Sách Hàng Loạt</h1>
            <p>Thêm nhiều sách mẫu vào database cùng một lúc</p>
        </div>
        
        <div class="stats">
            <div class="stat-card">
                <div class="stat-number"><?= number_format($totalBooks) ?></div>
                <div class="stat-label">📚 Tổng số sách</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= number_format($totalCategories) ?></div>
                <div class="stat-label">📁 Danh mục</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= number_format($totalQuantity) ?></div>
                <div class="stat-label">📦 Tổng số lượng</div>
            </div>
        </div>
        
        <div class="content">
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?= $error ?></div>
            <?php endif; ?>
            
            <div class="warning">
                ⚠️ <strong>Lưu ý:</strong> Chức năng này sẽ thêm 10 cuốn sách mẫu vào database. 
                Hãy đảm bảo bạn đã tạo các danh mục với ID 1, 2, 3, 4 trước khi chạy.
            </div>
            
            <div class="sample-books">
                <h3>📖 Danh sách sách sẽ được thêm:</h3>
                <div class="book-list">
                    <div class="book-item">
                        <div class="book-title">📚 Đắc Nhân Tâm</div>
                        <div class="book-price">💰 89,000đ → 69,000đ</div>
                        <div class="book-desc">Cuốn sách kinh điển về giao tiếp</div>
                    </div>
                    <div class="book-item">
                        <div class="book-title">🌟 Nhà Giả Kim</div>
                        <div class="book-price">💰 79,000đ → 59,000đ</div>
                        <div class="book-desc">Tiểu thuyết nổi tiếng của Paulo Coelho</div>
                    </div>
                    <div class="book-item">
                        <div class="book-title">🌱 Tôi Thấy Hoa Vàng Trên Cỏ Xanh</div>
                        <div class="book-price">💰 65,000đ → 45,000đ</div>
                        <div class="book-desc">Tiểu thuyết của Nguyễn Nhật Ánh</div>
                    </div>
                    <div class="book-item">
                        <div class="book-title">📖 Sách Giáo Khoa Toán 12</div>
                        <div class="book-price">💰 45,000đ</div>
                        <div class="book-desc">SGK theo chương trình mới</div>
                    </div>
                    <div class="book-item">
                        <div class="book-title">📝 Sách Giáo Khoa Văn 11</div>
                        <div class="book-price">💰 42,000đ</div>
                        <div class="book-desc">SGK Ngữ văn lớp 11</div>
                    </div>
                    <div class="book-item">
                        <div class="book-title">🏴‍☠️ One Piece - Tập 1</div>
                        <div class="book-price">💰 25,000đ → 22,000đ</div>
                        <div class="book-desc">Manga nổi tiếng về hải tặc</div>
                    </div>
                    <div class="book-item">
                        <div class="book-title">🤖 Doraemon - Tập 1</div>
                        <div class="book-price">💰 20,000đ → 18,000đ</div>
                        <div class="book-desc">Truyện tranh thiếu nhi</div>
                    </div>
                    <div class="book-item">
                        <div class="book-title">🔍 Sherlock Holmes</div>
                        <div class="book-price">💰 95,000đ → 75,000đ</div>
                        <div class="book-desc">Truyện trinh thám kinh điển</div>
                    </div>
                    <div class="book-item">
                        <div class="book-title">💻 Lập Trình Web PHP</div>
                        <div class="book-price">💰 299,000đ → 249,000đ</div>
                        <div class="book-desc">Sách lập trình từ cơ bản đến nâng cao</div>
                    </div>
                    <div class="book-item">
                        <div class="book-title">⚡ Học JavaScript Hiệu Quả</div>
                        <div class="book-price">💰 259,000đ → 199,000đ</div>
                        <div class="book-desc">JavaScript với nhiều ví dụ thực tế</div>
                    </div>
                </div>
            </div>
            
            <form method="POST" action="">
                <button type="submit" name="bulk_add" class="btn" onclick="return confirm('Bạn có chắc muốn thêm 10 sách này vào database?')">
                    ✨ Thêm Tất Cả Sách Vào Database
                </button>
            </form>
            
            <form method="POST" action="" style="margin-top: 10px;">
                <button type="submit" name="clear_all" class="btn btn-danger" onclick="return confirm('⚠️ NGUY HIỂM: Bạn có chắc muốn XÓA TẤT CẢ sách trong database? Hành động này không thể hoàn tác!')">
                    🗑️ Xóa Tất Cả Sách (Nguy hiểm!)
                </button>
            </form>
        </div>
        
        <div class="navigation">
            <a href=".">🏠 Trang chủ</a>
            <a href="add_books.php">➕ Thêm sách lẻ</a>
            <a href="simple_chatbot_test.php">🤖 Test ChatBot</a>
            <a href="check_chatbot_errors.php">🔍 Check Errors</a>
        </div>
    </div>
</body>
</html>

<?php
// Xử lý xóa tất cả sách
if (isset($_POST['clear_all'])) {
    try {
        $conn = connectDB();
        $conn->exec("DELETE FROM san_phams");
        echo "<script>alert('✅ Đã xóa tất cả sách!'); window.location.reload();</script>";
    } catch (Exception $e) {
        echo "<script>alert('❌ Lỗi: " . addslashes($e->getMessage()) . "');</script>";
    }
}
?>
