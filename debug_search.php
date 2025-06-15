<?php
// Debug tìm kiếm - Đơn giản nhất
require_once './commons/env.php';
require_once './commons/function.php';

// Thiết lập debug
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h1>Debug Tìm Kiếm</h1>";

// 1. Kiểm tra BASE_URL
echo "<h3>1. BASE_URL:</h3>";
echo "BASE_URL = " . BASE_URL . "<br>";

// 2. Kiểm tra database
echo "<h3>2. Database:</h3>";
try {
    $conn = connectDB();
    echo "✅ Database OK<br>";
    
    // Đếm sản phẩm
    $count = $conn->query("SELECT COUNT(*) FROM san_phams WHERE trang_thai = 1")->fetchColumn();
    echo "Sản phẩm active: {$count}<br>";
    
    if ($count == 0) {
        echo "❌ KHÔNG CÓ SẢN PHẨM NÀO!<br>";
    }
} catch (Exception $e) {
    echo "❌ Database Error: " . $e->getMessage() . "<br>";
}

// 3. Kiểm tra $_GET
echo "<h3>3. Tham số truyền vào:</h3>";
echo "act = " . ($_GET['act'] ?? 'không có') . "<br>";
echo "keyword = " . ($_GET['keyword'] ?? 'không có') . "<br>";

// 4. Test tìm kiếm thực tế
if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    echo "<h3>4. Test tìm kiếm với từ khóa: '{$keyword}'</h3>";
    
    try {
        $sql = "SELECT sp.*, dm.ten_danh_muc 
                FROM san_phams sp 
                LEFT JOIN danh_mucs dm ON sp.danh_muc_id = dm.id 
                WHERE sp.ten_san_pham LIKE :keyword 
                AND sp.trang_thai = 1 
                LIMIT 5";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':keyword', "%{$keyword}%");
        $stmt->execute();
        $results = $stmt->fetchAll();
        
        echo "Tìm thấy: " . count($results) . " sản phẩm<br>";
        
        if (count($results) > 0) {
            echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
            echo "<tr><th>Tên sản phẩm</th><th>Giá</th><th>Danh mục</th></tr>";
            foreach ($results as $r) {
                echo "<tr>";
                echo "<td>{$r['ten_san_pham']}</td>";
                echo "<td>" . number_format($r['gia_khuyen_mai']) . "đ</td>";
                echo "<td>{$r['ten_danh_muc']}</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    } catch (Exception $e) {
        echo "❌ Lỗi tìm kiếm: " . $e->getMessage() . "<br>";
    }
}

// 5. Kiểm tra file Controllers và Models
echo "<h3>5. Kiểm tra files:</h3>";
$files = [
    './controllers/SearchController.php',
    './models/SanPham.php',
    './models/danhmucmodels.php',
    './views/timKiem.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        echo "✅ {$file}<br>";
    } else {
        echo "❌ THIẾU: {$file}<br>";
    }
}

// 6. Test route
echo "<h3>6. Test routes:</h3>";
$routes = [
    'Tìm kiếm cơ bản' => BASE_URL . '?act=tim-kiem&keyword=test',
    'Autocomplete' => BASE_URL . '?act=search-autocomplete&q=s'
];

foreach ($routes as $name => $url) {
    echo "{$name}: <a href='{$url}' target='_blank'>{$url}</a><br>";
}

// 7. Form test đơn giản
echo "<h3>7. Form test:</h3>";
?>
<form method="GET" style="background: #f0f0f0; padding: 20px; margin: 10px 0;">
    <input type="hidden" name="act" value="tim-kiem">
    <label>Từ khóa:</label>
    <input type="text" name="keyword" value="<?= $_GET['keyword'] ?? '' ?>" placeholder="Nhập từ khóa...">
    <button type="submit">Tìm kiếm</button>
</form>

<?php
// 8. Hiển thị một số sản phẩm mẫu
echo "<h3>8. Sản phẩm mẫu để test:</h3>";
try {
    $sql = "SELECT ten_san_pham FROM san_phams WHERE trang_thai = 1 LIMIT 10";
    $products = $conn->query($sql)->fetchAll();
    
    if (count($products) > 0) {
        echo "<ul>";
        foreach ($products as $p) {
            $searchUrl = "?act=tim-kiem&keyword=" . urlencode($p['ten_san_pham']);
            echo "<li><a href='{$searchUrl}'>{$p['ten_san_pham']}</a></li>";
        }
        echo "</ul>";
    } else {
        echo "Không có sản phẩm nào để test.<br>";
    }
} catch (Exception $e) {
    echo "Lỗi lấy sản phẩm mẫu: " . $e->getMessage() . "<br>";
}

?>
<style>
body { font-family: Arial, sans-serif; margin: 20px; }
h3 { color: #333; border-bottom: 1px solid #ccc; padding-bottom: 5px; }
table { margin: 10px 0; }
th, td { padding: 8px; text-align: left; }
th { background: #f0f0f0; }
</style>
