<?php
// setup_categories.php - Tạo danh mục sách
session_start();
require_once 'commons/env.php';
require_once 'commons/function.php';

if (isset($_POST['create_categories'])) {
    try {
        $conn = connectDB();
        
        // Danh sách danh mục mẫu
        $categories = [
            ['ten_danh_muc' => 'Văn học', 'mo_ta' => 'Sách văn học, tiểu thuyết, thơ, truyện ngắn'],
            ['ten_danh_muc' => 'Giáo dục', 'mo_ta' => 'Sách giáo khoa, tham khảo, học thuật'],
            ['ten_danh_muc' => 'Truyện tranh', 'mo_ta' => 'Manga, comic, truyện tranh thiếu nhi'],
            ['ten_danh_muc' => 'Công nghệ', 'mo_ta' => 'Sách lập trình, CNTT, khoa học máy tính'],
            ['ten_danh_muc' => 'Kinh tế', 'mo_ta' => 'Sách kinh doanh, tài chính, marketing'],
            ['ten_danh_muc' => 'Khoa học', 'mo_ta' => 'Sách khoa học tự nhiên, toán học, vật lý'],
            ['ten_danh_muc' => 'Tâm lý - Kỹ năng sống', 'mo_ta' => 'Sách phát triển bản thân, tâm lý học'],
            ['ten_danh_muc' => 'Thiếu nhi', 'mo_ta' => 'Sách dành cho trẻ em, sách giáo dục sớm']
        ];
        
        $sql = "INSERT INTO danh_mucs (ten_danh_muc, mo_ta, trang_thai) VALUES (:ten_danh_muc, :mo_ta, 1)";
        $stmt = $conn->prepare($sql);
        
        $added = 0;
        $errors = [];
        
        foreach ($categories as $category) {
            try {
                $stmt->execute([
                    ':ten_danh_muc' => $category['ten_danh_muc'],
                    ':mo_ta' => $category['mo_ta']
                ]);
                $added++;
            } catch (Exception $e) {
                $errors[] = "Lỗi thêm '{$category['ten_danh_muc']}': " . $e->getMessage();
            }
        }
        
        $success = "✅ Đã tạo $added danh mục thành công!";
        if (!empty($errors)) {
            $success .= "<br>⚠️ Một số lỗi: " . implode('<br>', array_slice($errors, 0, 3));
        }
        
    } catch (Exception $e) {
        $error = "❌ Lỗi: " . $e->getMessage();
    }
}

// Lấy danh sách danh mục hiện tại
try {
    $conn = connectDB();
    $stmt = $conn->query("SELECT * FROM danh_mucs ORDER BY id");
    $currentCategories = $stmt->fetchAll();
} catch (Exception $e) {
    $currentCategories = [];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📁 Thiết Lập Danh Mục Sách</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #a29bfe 0%, #6c5ce7 100%);
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
            background: linear-gradient(135deg, #a29bfe 0%, #6c5ce7 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
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
        
        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        
        .current-categories {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        
        .current-categories h3 {
            margin-bottom: 15px;
            color: #495057;
        }
        
        .category-list {
            display: grid;
            gap: 10px;
        }
        
        .category-item {
            background: white;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .category-info {
            flex: 1;
        }
        
        .category-name {
            font-weight: 600;
            color: #6c5ce7;
            margin-bottom: 5px;
        }
        
        .category-desc {
            color: #666;
            font-size: 0.9em;
        }
        
        .category-id {
            background: #6c5ce7;
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.8em;
            font-weight: 600;
        }
        
        .new-categories {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        
        .new-categories h3 {
            margin-bottom: 15px;
            color: #495057;
        }
        
        .btn {
            background: linear-gradient(135deg, #a29bfe 0%, #6c5ce7 100%);
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
            box-shadow: 0 5px 15px rgba(162, 155, 254, 0.4);
        }
        
        .btn:active {
            transform: translateY(0);
        }
        
        .btn:disabled {
            background: #6c757d;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        
        .navigation {
            padding: 20px;
            background: #f8f9fa;
            text-align: center;
        }
        
        .navigation a {
            color: #6c5ce7;
            text-decoration: none;
            margin: 0 15px;
            font-weight: 500;
            padding: 10px 20px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        
        .navigation a:hover {
            background: #6c5ce7;
            color: white;
        }
        
        .step-indicator {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .step {
            display: flex;
            align-items: center;
            margin: 0 10px;
        }
        
        .step-number {
            background: #6c5ce7;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-right: 10px;
        }
        
        .step-text {
            font-weight: 500;
        }
        
        .step-arrow {
            margin: 0 15px;
            color: #6c5ce7;
            font-size: 1.2em;
        }
        
        @media (max-width: 768px) {
            .header h1 {
                font-size: 2em;
            }
            
            .content {
                padding: 20px;
            }
            
            .step-indicator {
                flex-direction: column;
                gap: 15px;
            }
            
            .step-arrow {
                transform: rotate(90deg);
                margin: 5px 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📁 Thiết Lập Danh Mục Sách</h1>
            <p>Tạo các danh mục cần thiết cho hệ thống quản lý sách</p>
        </div>
        
        <div class="content">
            <div class="step-indicator">
                <div class="step">
                    <div class="step-number">1</div>
                    <div class="step-text">Tạo danh mục</div>
                </div>
                <div class="step-arrow">→</div>
                <div class="step">
                    <div class="step-number">2</div>
                    <div class="step-text">Thêm sách</div>
                </div>
                <div class="step-arrow">→</div>
                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-text">Test chatbot</div>
                </div>
            </div>
            
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?= $error ?></div>
            <?php endif; ?>
            
            <?php if (!empty($currentCategories)): ?>
                <div class="current-categories">
                    <h3>📋 Danh mục hiện có (<?= count($currentCategories) ?> danh mục):</h3>
                    <div class="category-list">
                        <?php foreach ($currentCategories as $cat): ?>
                            <div class="category-item">
                                <div class="category-info">
                                    <div class="category-name"><?= htmlspecialchars($cat['ten_danh_muc']) ?></div>
                                    <div class="category-desc"><?= htmlspecialchars($cat['mo_ta'] ?? '') ?></div>
                                </div>
                                <div class="category-id">ID: <?= $cat['id'] ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="alert alert-info">
                    ✅ Bạn đã có danh mục rồi! Có thể bỏ qua bước này và chuyển sang thêm sách.
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    ℹ️ Chưa có danh mục nào. Hãy tạo danh mục trước khi thêm sách.
                </div>
            <?php endif; ?>
            
            <div class="new-categories">
                <h3>🆕 Danh mục sẽ được tạo:</h3>
                <div class="category-list">
                    <div class="category-item">
                        <div class="category-info">
                            <div class="category-name">📚 Văn học</div>
                            <div class="category-desc">Sách văn học, tiểu thuyết, thơ, truyện ngắn</div>
                        </div>
                    </div>
                    <div class="category-item">
                        <div class="category-info">
                            <div class="category-name">🎓 Giáo dục</div>
                            <div class="category-desc">Sách giáo khoa, tham khảo, học thuật</div>
                        </div>
                    </div>
                    <div class="category-item">
                        <div class="category-info">
                            <div class="category-name">🎭 Truyện tranh</div>
                            <div class="category-desc">Manga, comic, truyện tranh thiếu nhi</div>
                        </div>
                    </div>
                    <div class="category-item">
                        <div class="category-info">
                            <div class="category-name">💻 Công nghệ</div>
                            <div class="category-desc">Sách lập trình, CNTT, khoa học máy tính</div>
                        </div>
                    </div>
                    <div class="category-item">
                        <div class="category-info">
                            <div class="category-name">💰 Kinh tế</div>
                            <div class="category-desc">Sách kinh doanh, tài chính, marketing</div>
                        </div>
                    </div>
                    <div class="category-item">
                        <div class="category-info">
                            <div class="category-name">🔬 Khoa học</div>
                            <div class="category-desc">Sách khoa học tự nhiên, toán học, vật lý</div>
                        </div>
                    </div>
                    <div class="category-item">
                        <div class="category-info">
                            <div class="category-name">🧠 Tâm lý - Kỹ năng sống</div>
                            <div class="category-desc">Sách phát triển bản thân, tâm lý học</div>
                        </div>
                    </div>
                    <div class="category-item">
                        <div class="category-info">
                            <div class="category-name">🧸 Thiếu nhi</div>
                            <div class="category-desc">Sách dành cho trẻ em, sách giáo dục sớm</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <form method="POST" action="">
                <button type="submit" name="create_categories" class="btn" 
                        <?= !empty($currentCategories) ? 'onclick="return confirm(\'Bạn đã có danh mục rồi. Có chắc muốn thêm nữa không?\')"' : '' ?>>
                    ✨ Tạo Tất Cả Danh Mục
                </button>
            </form>
        </div>
        
        <div class="navigation">
            <a href=".">🏠 Trang chủ</a>
            <a href="add_books.php">➕ Thêm sách lẻ</a>
            <a href="bulk_add_books.php">📚 Thêm sách hàng loạt</a>
            <a href="simple_chatbot_test.php">🤖 Test ChatBot</a>
        </div>
    </div>
</body>
</html>
