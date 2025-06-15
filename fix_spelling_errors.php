<?php
// fix_spelling_errors.php - Sửa lỗi chính tả
require_once './commons/env.php';
require_once './commons/function.php';

echo "<h1>🔧 Sửa lỗi chính tả</h1>";
echo "<style>
body { font-family: Arial, sans-serif; margin: 20px; }
.error { color: red; font-weight: bold; }
.warning { color: orange; font-weight: bold; }
.success { color: green; font-weight: bold; }
.info { color: blue; font-weight: bold; }
</style>";

// Function to backup and fix file
function fixSpellingInFile($filePath, $replacements) {
    if (!file_exists($filePath)) {
        return "File không tồn tại: $filePath";
    }
    
    $content = file_get_contents($filePath);
    $original = $content;
    $changes = [];
    
    foreach ($replacements as $wrong => $correct) {
        if (strpos($content, $wrong) !== false) {
            $content = str_replace($wrong, $correct, $content);
            $changes[] = "$wrong → $correct";
        }
    }
    
    if (!empty($changes)) {
        // Backup original file
        $backupPath = $filePath . '.backup.' . date('YmdHis');
        file_put_contents($backupPath, $original);
        
        // Save fixed content
        file_put_contents($filePath, $content);
        
        return [
            'status' => 'success',
            'changes' => $changes,
            'backup' => $backupPath
        ];
    }
    
    return ['status' => 'no_changes'];
}

// Các lỗi chính tả cần sửa
$spellingFixes = [
    'Lưọng' => 'Lượng',
    'lưọng' => 'lượng',
    'Sô' => 'Số',
    'sô' => 'số',
    'Spham' => 'Sản phẩm',
    'spham' => 'sản phẩm',
    'Gía' => 'Giá',
    'gía' => 'giá',
    'Thêm vào giở hàng' => 'Thêm vào giỏ hàng',
    'thêm vào giở hàng' => 'thêm vào giỏ hàng',
    'Giở hàng' => 'Giỏ hàng',
    'giở hàng' => 'giỏ hàng',
    'Số Lưọng' => 'Số Lượng',
    'số lưọng' => 'số lượng'
];

// Files to check and fix
$filesToCheck = [
    'views/detailSanPham.php',
    'views/sanPhamTheoDanhMuc.php', 
    'views/gioHang.php',
    'views/thanhToan.php',
    'views/layout/header.php',
    'views/layout/menu.php',
    'admin/views/sanpham/detailSanPham.php',
    'admin/views/sanpham/addSanPham.php',
    'admin/views/sanpham/editSanPham.php',
    'admin/views/sanpham/listSanPham.php',
    'admin/views/bookmanager/add.php',
    'admin/views/bookmanager/edit.php',
    'admin/views/bookmanager/list.php'
];

echo "<h2>🔍 Kiểm tra và sửa lỗi trong files</h2>";

$totalFixed = 0;
foreach ($filesToCheck as $file) {
    echo "<h3>📄 $file</h3>";
    
    $result = fixSpellingInFile($file, $spellingFixes);
    
    if (is_string($result)) {
        echo "<p class='warning'>⚠️ $result</p>";
    } elseif ($result['status'] === 'no_changes') {
        echo "<p class='success'>✅ Không có lỗi chính tả</p>";
    } elseif ($result['status'] === 'success') {
        echo "<p class='success'>✅ Đã sửa " . count($result['changes']) . " lỗi:</p>";
        echo "<ul>";
        foreach ($result['changes'] as $change) {
            echo "<li class='info'>$change</li>";
        }
        echo "</ul>";
        echo "<p><small>Backup: {$result['backup']}</small></p>";
        $totalFixed += count($result['changes']);
    }
}

// Fix database data if needed
echo "<h2>🗄️ Kiểm tra và sửa lỗi trong database</h2>";

try {
    $conn = connectDB();
    
    // Check products
    echo "<h3>📦 Sản phẩm</h3>";
    $stmt = $conn->query("SELECT id, ten_san_pham FROM san_phams");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $productUpdates = 0;
    foreach ($products as $product) {
        $originalName = $product['ten_san_pham'];
        $fixedName = $originalName;
        
        foreach ($spellingFixes as $wrong => $correct) {
            $fixedName = str_replace($wrong, $correct, $fixedName);
        }
        
        if ($fixedName !== $originalName) {
            $updateStmt = $conn->prepare("UPDATE san_phams SET ten_san_pham = ? WHERE id = ?");
            $updateStmt->execute([$fixedName, $product['id']]);
            echo "<p class='info'>📝 Cập nhật ID {$product['id']}: '$originalName' → '$fixedName'</p>";
            $productUpdates++;
        }
    }
    
    if ($productUpdates == 0) {
        echo "<p class='success'>✅ Tên sản phẩm không có lỗi chính tả</p>";
    } else {
        echo "<p class='success'>✅ Đã cập nhật $productUpdates sản phẩm</p>";
    }
    
    // Check categories
    echo "<h3>📁 Danh mục</h3>";
    $stmt = $conn->query("SELECT id, ten_danh_muc FROM danh_mucs");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $categoryUpdates = 0;
    foreach ($categories as $category) {
        $originalName = $category['ten_danh_muc'];
        $fixedName = $originalName;
        
        foreach ($spellingFixes as $wrong => $correct) {
            $fixedName = str_replace($wrong, $correct, $fixedName);
        }
        
        if ($fixedName !== $originalName) {
            $updateStmt = $conn->prepare("UPDATE danh_mucs SET ten_danh_muc = ? WHERE id = ?");
            $updateStmt->execute([$fixedName, $category['id']]);
            echo "<p class='info'>📝 Cập nhật ID {$category['id']}: '$originalName' → '$fixedName'</p>";
            $categoryUpdates++;
        }
    }
    
    if ($categoryUpdates == 0) {
        echo "<p class='success'>✅ Tên danh mục không có lỗi chính tả</p>";
    } else {
        echo "<p class='success'>✅ Đã cập nhật $categoryUpdates danh mục</p>";
    }
    
} catch (Exception $e) {
    echo "<p class='error'>❌ Lỗi khi kiểm tra database: " . $e->getMessage() . "</p>";
}

echo "<h2>📊 Tóm tắt</h2>";
echo "<p class='info'>🔧 Tổng số lỗi đã sửa trong files: $totalFixed</p>";
echo "<p class='info'>📦 Sản phẩm đã cập nhật: " . ($productUpdates ?? 0) . "</p>";  
echo "<p class='info'>📁 Danh mục đã cập nhật: " . ($categoryUpdates ?? 0) . "</p>";

if ($totalFixed > 0 || ($productUpdates ?? 0) > 0 || ($categoryUpdates ?? 0) > 0) {
    echo "<p class='success'>✅ Hoàn tất! Hãy kiểm tra lại website để xem kết quả.</p>";
    echo "<p><strong>Lưu ý:</strong> Các file gốc đã được backup với timestamp.</p>";
} else {
    echo "<p class='warning'>⚠️ Không tìm thấy lỗi chính tả nào để sửa.</p>";
    echo "<p>Nếu bạn vẫn thấy lỗi trên giao diện, hãy:</p>";
    echo "<ul>";
    echo "<li>Clear cache trình duyệt (Ctrl+F5)</li>";
    echo "<li>Kiểm tra lại chính xác vị trí lỗi</li>";
    echo "<li>Gửi ảnh chụp màn hình vị trí lỗi</li>";
    echo "</ul>";
}

echo "<p style='margin-top: 30px;'>";
echo "<a href='check_spelling_errors.php' style='background: #17a2b8; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-right: 10px;'>🔍 Kiểm tra lại</a>";
echo "<a href='index.php' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🏠 Về trang chủ</a>";
echo "</p>";
?>
