<?php
// check_spelling_errors.php - Kiểm tra lỗi chính tả
require_once './commons/env.php';
require_once './commons/function.php';

echo "<h1>🔍 Kiểm tra lỗi chính tả</h1>";
echo "<style>
body { font-family: Arial, sans-serif; margin: 20px; }
.error { color: red; font-weight: bold; }
.warning { color: orange; font-weight: bold; }
.success { color: green; font-weight: bold; }
table { border-collapse: collapse; width: 100%; margin: 10px 0; }
th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
th { background-color: #f2f2f2; }
</style>";

// Các từ sai thường gặp
$commonMistakes = [
    'Lưọng' => 'Lượng',
    'lưọng' => 'lượng', 
    'Sô' => 'Số',
    'sô' => 'số',
    'Spham' => 'Sản phẩm',
    'spham' => 'sản phẩm',
    'Gía' => 'Giá',
    'gía' => 'giá',
    'Mưa' => 'Mua',
    'mưa' => 'mua',
    'Hàng' => 'Hàng', // Đúng rồi
    'hàng' => 'hàng', // Đúng rồi
    'Thêm' => 'Thêm', // Đúng rồi
    'thêm' => 'thêm', // Đúng rồi
];

echo "<h2>🔤 Kiểm tra các từ sai thường gặp</h2>";

$errors = [];
$viewFiles = [
    'views/detailSanPham.php',
    'views/sanPhamTheoDanhMuc.php',
    'views/gioHang.php',
    'views/thanhToan.php',
    'admin/views/sanpham/detailSanPham.php',
    'admin/views/sanpham/addSanPham.php',
    'admin/views/sanpham/editSanPham.php'
];

foreach ($viewFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        echo "<h3>📄 Kiểm tra file: $file</h3>";
        
        $fileErrors = [];
        foreach ($commonMistakes as $wrong => $correct) {
            if (strpos($content, $wrong) !== false) {
                $fileErrors[] = "$wrong → $correct";
                $errors[] = "$file: $wrong → $correct";
            }
        }
        
        if (empty($fileErrors)) {
            echo "<p class='success'>✅ Không tìm thấy lỗi chính tả phổ biến</p>";
        } else {
            echo "<div class='error'>❌ Tìm thấy lỗi:</div>";
            echo "<ul>";
            foreach ($fileErrors as $error) {
                echo "<li class='error'>$error</li>";
            }
            echo "</ul>";
        }
    } else {
        echo "<p class='warning'>⚠️ File $file không tồn tại</p>";
    }
}

// Kiểm tra database content
echo "<h2>🗄️ Kiểm tra nội dung database</h2>";

try {
    $conn = connectDB();
    
    // Kiểm tra tên sản phẩm
    $stmt = $conn->query("SELECT id, ten_san_pham FROM san_phams LIMIT 10");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>📦 Sản phẩm trong database:</h3>";
    if (!empty($products)) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Tên sản phẩm</th><th>Kiểm tra</th></tr>";
        
        foreach ($products as $product) {
            $hasError = false;
            $checkResult = "✅ OK";
            
            foreach ($commonMistakes as $wrong => $correct) {
                if (strpos($product['ten_san_pham'], $wrong) !== false) {
                    $hasError = true;
                    $checkResult = "❌ Có lỗi: $wrong";
                    break;
                }
            }
            
            echo "<tr>";
            echo "<td>" . $product['id'] . "</td>";
            echo "<td>" . htmlspecialchars($product['ten_san_pham']) . "</td>";
            echo "<td class='" . ($hasError ? 'error' : 'success') . "'>$checkResult</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='warning'>⚠️ Không có sản phẩm trong database</p>";
    }
    
    // Kiểm tra danh mục
    $stmt = $conn->query("SELECT id, ten_danh_muc FROM danh_mucs LIMIT 10");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>📁 Danh mục trong database:</h3>";
    if (!empty($categories)) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Tên danh mục</th><th>Kiểm tra</th></tr>";
        
        foreach ($categories as $category) {
            $hasError = false;
            $checkResult = "✅ OK";
            
            foreach ($commonMistakes as $wrong => $correct) {
                if (strpos($category['ten_danh_muc'], $wrong) !== false) {
                    $hasError = true;
                    $checkResult = "❌ Có lỗi: $wrong";
                    break;
                }
            }
            
            echo "<tr>";
            echo "<td>" . $category['id'] . "</td>";
            echo "<td>" . htmlspecialchars($category['ten_danh_muc']) . "</td>";
            echo "<td class='" . ($hasError ? 'error' : 'success') . "'>$checkResult</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
} catch (Exception $e) {
    echo "<p class='error'>❌ Lỗi kết nối database: " . $e->getMessage() . "</p>";
}

echo "<h2>📝 Tóm tắt</h2>";
if (empty($errors)) {
    echo "<p class='success'>✅ Không tìm thấy lỗi chính tả trong các file kiểm tra</p>";
} else {
    echo "<p class='error'>❌ Tìm thấy " . count($errors) . " lỗi chính tả:</p>";
    echo "<ul>";
    foreach ($errors as $error) {
        echo "<li class='error'>$error</li>";
    }
    echo "</ul>";
}

echo "<h2>🛠️ Cách sửa lỗi</h2>";
echo "<p>Nếu bạn thấy lỗi chính tả trong giao diện nhưng không tìm thấy trong code, có thể:</p>";
echo "<ul>";
echo "<li>✏️ Lỗi đến từ dữ liệu trong database</li>";
echo "<li>🎨 Lỗi do CSS hoặc JavaScript tạo ra</li>";
echo "<li>📱 Lỗi chỉ xuất hiện trên mobile/responsive</li>";
echo "<li>🌐 Lỗi trong file template khác</li>";
echo "</ul>";
echo "<p><strong>Hành động:</strong> Hãy chụp màn hình vị trí chính xác của lỗi để tôi có thể tìm và sửa!</p>";
?>
