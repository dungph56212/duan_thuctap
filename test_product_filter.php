<?php
session_start();
require_once './commons/env.php';
require_once './commons/function.php';
require_once './controllers/HomeController.php';
require_once './models/SanPham.php';
require_once './models/danhmucmodels.php';

echo "<h1>Test Hệ Thống Lọc Sản Phẩm Nâng Cao</h1>";

$homeController = new HomeController();
$sanPhamModel = new SanPham();

// Test 1: Kiểm tra phương thức lọc cơ bản
echo "<h2>Test 1: Kiểm tra các phương thức lọc mới</h2>";
try {
    $testFilters = [
        'search' => 'sách',
        'sort' => 'price-low',
        'min_price' => 50000,
        'max_price' => 500000,
        'status' => 'available'
    ];
    
    $products = $sanPhamModel->getAllProductWithFilters($testFilters);
    echo "<p>✅ Lọc tất cả sản phẩm với filters: " . count($products) . " sản phẩm</p>";
    
    // Test với danh mục cụ thể
    $categoryProducts = $sanPhamModel->getListSanPhamDanhMucWithFilters(1, $testFilters);
    echo "<p>✅ Lọc sản phẩm theo danh mục 1: " . count($categoryProducts) . " sản phẩm</p>";
    
} catch (Exception $e) {
    echo "<p>❌ Lỗi test lọc sản phẩm: " . $e->getMessage() . "</p>";
}

// Test 2: Kiểm tra phương thức lấy tác giả
echo "<h2>Test 2: Kiểm tra danh sách tác giả</h2>";
try {
    $authors = $sanPhamModel->getUniqueAuthors();
    echo "<p>✅ Tìm thấy " . count($authors) . " tác giả duy nhất</p>";
    if (!empty($authors)) {
        echo "<ul>";
        foreach (array_slice($authors, 0, 5) as $author) {
            echo "<li>" . htmlspecialchars($author) . "</li>";
        }
        echo "</ul>";
    }
} catch (Exception $e) {
    echo "<p>❌ Lỗi lấy danh sách tác giả: " . $e->getMessage() . "</p>";
}

// Test 3: Kiểm tra khoảng giá
echo "<h2>Test 3: Kiểm tra khoảng giá sản phẩm</h2>";
try {
    $priceRange = $sanPhamModel->getPriceRange();
    echo "<p>✅ Khoảng giá tổng: " . number_format($priceRange['min_price']) . "đ - " . number_format($priceRange['max_price']) . "đ</p>";
    
    // Test với danh mục cụ thể
    $categoryPriceRange = $sanPhamModel->getPriceRange(1);
    echo "<p>✅ Khoảng giá danh mục 1: " . number_format($categoryPriceRange['min_price']) . "đ - " . number_format($categoryPriceRange['max_price']) . "đ</p>";
} catch (Exception $e) {
    echo "<p>❌ Lỗi lấy khoảng giá: " . $e->getMessage() . "</p>";
}

// Test 4: Kiểm tra các bộ lọc khác nhau
echo "<h2>Test 4: Kiểm tra các bộ lọc khác nhau</h2>";

$filterTests = [
    ['search' => 'tình', 'description' => 'Tìm kiếm với từ khóa "tình"'],
    ['sort' => 'price-high', 'description' => 'Sắp xếp theo giá cao'],
    ['status' => 'sale', 'description' => 'Chỉ sản phẩm đang giảm giá'],
    ['stock_status' => 'in_stock', 'description' => 'Chỉ sản phẩm còn nhiều hàng'],
    ['min_price' => 100000, 'max_price' => 300000, 'description' => 'Lọc giá 100k-300k']
];

foreach ($filterTests as $test) {
    try {
        $products = $sanPhamModel->getAllProductWithFilters($test);
        echo "<p>✅ " . $test['description'] . ": " . count($products) . " sản phẩm</p>";
    } catch (Exception $e) {
        echo "<p>❌ Lỗi " . $test['description'] . ": " . $e->getMessage() . "</p>";
    }
}

// Test 5: Test URL parameters simulation
echo "<h2>Test 5: Mô phỏng URL parameters</h2>";
$_GET = [
    'act' => 'san-pham-theo-danh-muc',
    'search' => 'sách hay',
    'sort' => 'price-low',
    'min_price' => '50000',
    'max_price' => '200000',
    'status' => 'available'
];

echo "<p>📋 Mô phỏng URL: ?act=san-pham-theo-danh-muc&search=sách+hay&sort=price-low&min_price=50000&max_price=200000&status=available</p>";

try {
    // Mô phỏng controller call
    $filters = [
        'search' => $_GET['search'] ?? '',
        'sort' => $_GET['sort'] ?? 'default',
        'min_price' => isset($_GET['min_price']) ? (int)$_GET['min_price'] : null,
        'max_price' => isset($_GET['max_price']) ? (int)$_GET['max_price'] : null,
        'status' => $_GET['status'] ?? ''
    ];
    
    $products = $sanPhamModel->getAllProductWithFilters($filters);
    echo "<p>✅ Controller simulation thành công: " . count($products) . " sản phẩm</p>";
    
    // Hiển thị mẫu sản phẩm đầu tiên
    if (!empty($products)) {
        $firstProduct = $products[0];
        echo "<div style='border: 1px solid #ddd; padding: 10px; margin: 10px 0;'>";
        echo "<h4>" . htmlspecialchars($firstProduct['ten_san_pham']) . "</h4>";
        echo "<p>Giá: " . number_format($firstProduct['gia_san_pham']) . "đ";
        if ($firstProduct['gia_khuyen_mai']) {
            echo " (Giảm: " . number_format($firstProduct['gia_khuyen_mai']) . "đ)";
        }
        echo "</p>";
        if (!empty($firstProduct['tac_gia'])) {
            echo "<p>Tác giả: " . htmlspecialchars($firstProduct['tac_gia']) . "</p>";
        }
        echo "<p>Số lượng: " . $firstProduct['so_luong'] . "</p>";
        echo "<p>Danh mục: " . htmlspecialchars($firstProduct['ten_danh_muc']) . "</p>";
        echo "</div>";
    }
    
} catch (Exception $e) {
    echo "<p>❌ Lỗi controller simulation: " . $e->getMessage() . "</p>";
}

// Test 6: Kiểm tra performance
echo "<h2>Test 6: Kiểm tra hiệu suất</h2>";
$startTime = microtime(true);

for ($i = 0; $i < 10; $i++) {
    $randomFilters = [
        'sort' => ['default', 'price-low', 'price-high', 'name', 'newest'][rand(0, 4)],
        'min_price' => rand(0, 100000),
        'max_price' => rand(200000, 1000000)
    ];
    $sanPhamModel->getAllProductWithFilters($randomFilters);
}

$endTime = microtime(true);
$executionTime = ($endTime - $startTime) * 1000; // Convert to milliseconds

echo "<p>✅ Thời gian thực hiện 10 truy vấn lọc: " . number_format($executionTime, 2) . "ms</p>";
echo "<p>✅ Trung bình mỗi truy vấn: " . number_format($executionTime / 10, 2) . "ms</p>";

if ($executionTime / 10 < 100) {
    echo "<p>🚀 Performance tốt (< 100ms/truy vấn)</p>";
} else {
    echo "<p>⚠️ Performance có thể cần tối ưu (> 100ms/truy vấn)</p>";
}

echo "<h2>✅ Tất cả test hoàn thành!</h2>";
echo "<p><a href='" . BASE_URL . "?act=san-pham-theo-danh-muc'>Xem trang sản phẩm với bộ lọc mới</a></p>";
?>

<style>
body {
    font-family: Arial, sans-serif;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    line-height: 1.6;
}
h1, h2 {
    color: #333;
    border-bottom: 2px solid #007bff;
    padding-bottom: 10px;
}
p {
    margin: 10px 0;
}
ul {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 5px;
}
a {
    color: #007bff;
    text-decoration: none;
    padding: 10px 20px;
    background: #f8f9fa;
    border-radius: 5px;
    border: 1px solid #007bff;
    display: inline-block;
    margin-top: 20px;
}
a:hover {
    background: #007bff;
    color: white;
}
</style>
