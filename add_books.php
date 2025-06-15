<?php
// add_books.php - Thêm sách vào database
session_start();
require_once 'commons/env.php';
require_once 'commons/function.php';

// Xử lý thêm sách
if (isset($_POST['add_book'])) {
    try {
        $conn = connectDB();
        
        $sql = "INSERT INTO san_phams (
            ten_san_pham, 
            gia_san_pham, 
            gia_khuyen_mai, 
            hinh_anh, 
            so_luong, 
            luot_xem, 
            ngay_nhap, 
            mo_ta, 
            danh_muc_id, 
            trang_thai
        ) VALUES (
            :ten_san_pham,
            :gia_san_pham,
            :gia_khuyen_mai,
            :hinh_anh,
            :so_luong,
            :luot_xem,
            NOW(),
            :mo_ta,
            :danh_muc_id,
            :trang_thai
        )";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':ten_san_pham' => $_POST['ten_san_pham'],
            ':gia_san_pham' => $_POST['gia_san_pham'],
            ':gia_khuyen_mai' => $_POST['gia_khuyen_mai'] ?: null,
            ':hinh_anh' => $_POST['hinh_anh'],
            ':so_luong' => $_POST['so_luong'],
            ':luot_xem' => 0,
            ':mo_ta' => $_POST['mo_ta'],
            ':danh_muc_id' => $_POST['danh_muc_id'],
            ':trang_thai' => $_POST['trang_thai']
        ]);
        
        $success = "✅ Thêm sách thành công! ID: " . $conn->lastInsertId();
        
    } catch (Exception $e) {
        $error = "❌ Lỗi: " . $e->getMessage();
    }
}

// Lấy danh sách danh mục
try {
    $conn = connectDB();
    $stmt = $conn->query("SELECT * FROM danh_mucs ORDER BY ten_danh_muc");
    $categories = $stmt->fetchAll();
} catch (Exception $e) {
    $categories = [];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📚 Thêm Sách Vào Database</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        
        .header p {
            opacity: 0.9;
            font-size: 1.1em;
        }
        
        .form-container {
            padding: 40px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 1.1em;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 1em;
            transition: all 0.3s ease;
        }
        
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .form-group textarea {
            height: 100px;
            resize: vertical;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn:active {
            transform: translateY(0);
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
        
        .quick-books {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        
        .quick-books h3 {
            margin-bottom: 15px;
            color: #495057;
        }
        
        .quick-book-btn {
            background: #28a745;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            margin: 5px;
            cursor: pointer;
            font-size: 0.9em;
        }
        
        .quick-book-btn:hover {
            background: #218838;
        }
        
        .navigation {
            padding: 20px;
            background: #f8f9fa;
            text-align: center;
        }
        
        .navigation a {
            color: #667eea;
            text-decoration: none;
            margin: 0 15px;
            font-weight: 500;
        }
        
        .navigation a:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .header h1 {
                font-size: 2em;
            }
            
            .form-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📚 Thêm Sách Mới</h1>
            <p>Thêm sách vào cơ sở dữ liệu một cách dễ dàng</p>
        </div>
        
        <div class="form-container">
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?= $error ?></div>
            <?php endif; ?>
            
            <!-- Quick Add Books -->
            <div class="quick-books">
                <h3>⚡ Thêm nhanh sách mẫu:</h3>
                <button class="quick-book-btn" onclick="fillSampleBook(1)">📖 Đắc Nhân Tâm</button>
                <button class="quick-book-btn" onclick="fillSampleBook(2)">🌟 Nhà Giả Kim</button>
                <button class="quick-book-btn" onclick="fillSampleBook(3)">🌱 Tôi Thấy Hoa Vàng</button>
                <button class="quick-book-btn" onclick="fillSampleBook(4)">📚 Sách Giáo Khoa</button>
                <button class="quick-book-btn" onclick="fillSampleBook(5)">🎭 Truyện Tranh</button>
            </div>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="ten_san_pham">📚 Tên Sách *</label>
                    <input type="text" id="ten_san_pham" name="ten_san_pham" required>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="gia_san_pham">💰 Giá Gốc (VNĐ) *</label>
                        <input type="number" id="gia_san_pham" name="gia_san_pham" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="gia_khuyen_mai">🏷️ Giá Khuyến Mãi (VNĐ)</label>
                        <input type="number" id="gia_khuyen_mai" name="gia_khuyen_mai" min="0">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="so_luong">📦 Số Lượng *</label>
                        <input type="number" id="so_luong" name="so_luong" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="danh_muc_id">📁 Danh Mục *</label>
                        <select id="danh_muc_id" name="danh_muc_id" required>
                            <option value="">-- Chọn danh mục --</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['ten_danh_muc']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="hinh_anh">🖼️ Hình Ảnh (URL hoặc tên file)</label>
                    <input type="text" id="hinh_anh" name="hinh_anh" placeholder="vd: book1.jpg hoặc https://example.com/image.jpg">
                </div>
                
                <div class="form-group">
                    <label for="mo_ta">📝 Mô Tả</label>
                    <textarea id="mo_ta" name="mo_ta" placeholder="Mô tả chi tiết về cuốn sách..."></textarea>
                </div>
                
                <div class="form-group">
                    <label for="trang_thai">📊 Trạng Thái</label>
                    <select id="trang_thai" name="trang_thai">
                        <option value="1">🟢 Đang bán</option>
                        <option value="0">🔴 Ngừng bán</option>
                    </select>
                </div>
                
                <button type="submit" name="add_book" class="btn">
                    ✨ Thêm Sách Vào Database
                </button>
            </form>
        </div>
        
        <div class="navigation">
            <a href=".">🏠 Trang chủ</a>
            <a href="simple_chatbot_test.php">🤖 Test ChatBot</a>
            <a href="check_chatbot_errors.php">🔍 Check Errors</a>
        </div>
    </div>
    
    <script>
        const sampleBooks = {
            1: {
                ten_san_pham: "Đắc Nhân Tâm",
                gia_san_pham: 89000,
                gia_khuyen_mai: 69000,
                so_luong: 50,
                hinh_anh: "dac-nhan-tam.jpg",
                mo_ta: "Cuốn sách kinh điển về nghệ thuật giao tiếp và ứng xử của Dale Carnegie. Đây là một trong những cuốn sách bán chạy nhất mọi thời đại."
            },
            2: {
                ten_san_pham: "Nhà Giả Kim",
                gia_san_pham: 79000,
                gia_khuyen_mai: 59000,
                so_luong: 30,
                hinh_anh: "nha-gia-kim.jpg",
                mo_ta: "Tiểu thuyết nổi tiếng của Paulo Coelho kể về hành trình tìm kiếm kho báu và ý nghĩa cuộc sống của chàng chăn cừu Santiago."
            },
            3: {
                ten_san_pham: "Tôi Thấy Hoa Vàng Trên Cỏ Xanh",
                gia_san_pham: 65000,
                gia_khuyen_mai: 45000,
                so_luong: 40,
                hinh_anh: "hoa-vang-co-xanh.jpg",
                mo_ta: "Tiểu thuyết của Nguyễn Nhật Ánh về tuổi thơ dữ dội và những kỷ niệm khó quên của hai anh em nhà họ Thiều."
            },
            4: {
                ten_san_pham: "Sách Giáo Khoa Toán Lớp 12",
                gia_san_pham: 45000,
                gia_khuyen_mai: "",
                so_luong: 100,
                hinh_anh: "sgk-toan-12.jpg",
                mo_ta: "Sách giáo khoa Toán lớp 12 theo chương trình mới, bao gồm đầy đủ các chủ đề: Giải tích, Hình học, Xác suất thống kê."
            },
            5: {
                ten_san_pham: "One Piece - Tập 1",
                gia_san_pham: 25000,
                gia_khuyen_mai: 22000,
                so_luong: 200,
                hinh_anh: "one-piece-tap-1.jpg",
                mo_ta: "Manga nổi tiếng của Eiichiro Oda kể về cuộc phiêu lưu của Monkey D. Luffy và băng hải tặc Mũ Rơm."
            }
        };
        
        function fillSampleBook(id) {
            const book = sampleBooks[id];
            if (book) {
                document.getElementById('ten_san_pham').value = book.ten_san_pham;
                document.getElementById('gia_san_pham').value = book.gia_san_pham;
                document.getElementById('gia_khuyen_mai').value = book.gia_khuyen_mai;
                document.getElementById('so_luong').value = book.so_luong;
                document.getElementById('hinh_anh').value = book.hinh_anh;
                document.getElementById('mo_ta').value = book.mo_ta;
                document.getElementById('trang_thai').value = 1;
                
                // Scroll to form
                document.getElementById('ten_san_pham').scrollIntoView({ behavior: 'smooth' });
            }
        }
        
        // Format number inputs
        document.getElementById('gia_san_pham').addEventListener('input', function(e) {
            if (this.value) {
                this.value = Math.abs(parseInt(this.value));
            }
        });
        
        document.getElementById('gia_khuyen_mai').addEventListener('input', function(e) {
            if (this.value) {
                this.value = Math.abs(parseInt(this.value));
            }
        });
        
        document.getElementById('so_luong').addEventListener('input', function(e) {
            if (this.value) {
                this.value = Math.abs(parseInt(this.value));
            }
        });
    </script>
</body>
</html>
