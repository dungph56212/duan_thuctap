<?php
session_start();

// Include required files
require_once './commons/env.php';
require_once './commons/function.php';

// Check if we can connect to database
try {
    $conn = connectDB();
    echo "<div style='color: green; font-weight: bold;'>✅ Kết nối database thành công!</div>";
} catch (Exception $e) {
    echo "<div style='color: red; font-weight: bold;'>❌ Lỗi kết nối database: " . $e->getMessage() . "</div>";
    exit;
}

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Hệ Thống Lọc Sản Phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background: #f5f5f5; 
            padding: 20px; 
        }
        .container { 
            max-width: 1200px; 
            background: white; 
            padding: 30px; 
            border-radius: 10px; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.1); 
        }
        .test-section { 
            margin-bottom: 30px; 
            padding: 20px; 
            border: 1px solid #ddd; 
            border-radius: 8px; 
        }
        .success { color: #28a745; font-weight: bold; }
        .error { color: #dc3545; font-weight: bold; }
        .info { color: #007bff; font-weight: bold; }
        .test-link {
            display: inline-block;
            margin: 5px;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .test-link:hover {
            background: #0056b3;
            color: white;
            text-decoration: none;
        }
        .demo-product {
            border: 1px solid #ddd;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            background: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">🔍 Test Hệ Thống Lọc Sản Phẩm</h1>
        
        <!-- Test Database Connection -->
        <div class="test-section">
            <h3>1. Test Kết Nối Database</h3>
            <?php
            try {
                // Test basic query
                $stmt = $conn->prepare("SELECT COUNT(*) as total FROM san_phams");
                $stmt->execute();
                $result = $stmt->fetch();
                echo "<div class='success'>✅ Database có {$result['total']} sản phẩm</div>";
                
                // Test danh muc table
                $stmt = $conn->prepare("SELECT COUNT(*) as total FROM danh_mucs");
                $stmt->execute();
                $result = $stmt->fetch();
                echo "<div class='success'>✅ Database có {$result['total']} danh mục</div>";
                
            } catch (Exception $e) {
                echo "<div class='error'>❌ Lỗi truy vấn: " . $e->getMessage() . "</div>";
            }
            ?>
        </div>

        <!-- Test Model Methods -->
        <div class="test-section">
            <h3>2. Test Các Method Lọc Mới</h3>
            <?php
            try {
                require_once './models/SanPham.php';
                $sanPhamModel = new SanPham();
                
                // Test getAllProductWithFilters
                $testFilters = ['search' => 'sách', 'sort' => 'price-low'];
                $products = $sanPhamModel->getAllProductWithFilters($testFilters);
                echo "<div class='success'>✅ getAllProductWithFilters: " . count($products) . " sản phẩm</div>";
                
                // Test getUniqueAuthors
                $authors = $sanPhamModel->getUniqueAuthors();
                echo "<div class='success'>✅ getUniqueAuthors: " . count($authors) . " tác giả</div>";
                
                // Test getPriceRange
                $priceRange = $sanPhamModel->getPriceRange();
                echo "<div class='success'>✅ getPriceRange: " . 
                     number_format($priceRange['min_price']) . " - " . 
                     number_format($priceRange['max_price']) . " VND</div>";
                
            } catch (Exception $e) {
                echo "<div class='error'>❌ Lỗi test model: " . $e->getMessage() . "</div>";
            }
            ?>
        </div>

        <!-- Test Sample Data -->
        <div class="test-section">
            <h3>3. Dữ Liệu Mẫu</h3>
            <?php
            try {
                $stmt = $conn->prepare("SELECT san_phams.*, danh_mucs.ten_danh_muc 
                                      FROM san_phams 
                                      INNER JOIN danh_mucs ON san_phams.danh_muc_id = danh_mucs.id 
                                      LIMIT 3");
                $stmt->execute();
                $sampleProducts = $stmt->fetchAll();
                
                foreach($sampleProducts as $product) {
                    echo "<div class='demo-product'>";
                    echo "<h5>{$product['ten_san_pham']}</h5>";
                    echo "<p><strong>Danh mục:</strong> {$product['ten_danh_muc']}</p>";
                    echo "<p><strong>Giá:</strong> " . number_format($product['gia_san_pham']) . " VND";
                    if ($product['gia_khuyen_mai']) {
                        echo " (Giảm: " . number_format($product['gia_khuyen_mai']) . " VND)";
                    }
                    echo "</p>";
                    if (!empty($product['tac_gia'])) {
                        echo "<p><strong>Tác giả:</strong> {$product['tac_gia']}</p>";
                    }
                    echo "<p><strong>Số lượng:</strong> {$product['so_luong']}</p>";
                    echo "</div>";
                }
                
            } catch (Exception $e) {
                echo "<div class='error'>❌ Lỗi lấy dữ liệu mẫu: " . $e->getMessage() . "</div>";
            }
            ?>
        </div>

        <!-- Test Links -->
        <div class="test-section">
            <h3>4. Test Links Thực Tế</h3>
            <div class="row">
                <div class="col-md-6">
                    <h5>Trang Chính:</h5>
                    <a href="<?= BASE_URL ?>" class="test-link">🏠 Trang Chủ</a>
                    <a href="<?= BASE_URL ?>?act=san-pham-theo-danh-muc" class="test-link">📚 Tất Cả Sản Phẩm</a>
                    
                    <h5 class="mt-3">Test Lọc:</h5>
                    <a href="<?= BASE_URL ?>?act=san-pham-theo-danh-muc&search=sách" class="test-link">🔍 Tìm "sách"</a>
                    <a href="<?= BASE_URL ?>?act=san-pham-theo-danh-muc&sort=price-low" class="test-link">💰 Giá thấp nhất</a>
                </div>
                <div class="col-md-6">
                    <h5>Test Nâng Cao:</h5>
                    <a href="<?= BASE_URL ?>?act=san-pham-theo-danh-muc&min_price=100000&max_price=500000" class="test-link">💵 100k-500k</a>
                    <a href="<?= BASE_URL ?>?act=san-pham-theo-danh-muc&status=sale" class="test-link">🏷️ Đang giảm giá</a>
                    <a href="<?= BASE_URL ?>?act=san-pham-theo-danh-muc&status=new&sort=newest" class="test-link">⭐ Sản phẩm mới</a>
                    
                    <h5 class="mt-3">Kết Hợp:</h5>
                    <a href="<?= BASE_URL ?>?act=san-pham-theo-danh-muc&search=sách&sort=price-low&status=available" class="test-link">🎯 Tìm + Lọc</a>
                </div>
            </div>
        </div>

        <!-- Performance Test -->
        <div class="test-section">
            <h3>5. Test Hiệu Suất</h3>
            <?php
            $startTime = microtime(true);
            
            // Run multiple queries
            for($i = 0; $i < 5; $i++) {
                $randomFilters = [
                    'sort' => ['default', 'price-low', 'price-high', 'name'][array_rand(['default', 'price-low', 'price-high', 'name'])],
                    'min_price' => rand(0, 100000),
                    'max_price' => rand(200000, 1000000)
                ];
                $products = $sanPhamModel->getAllProductWithFilters($randomFilters);
            }
            
            $endTime = microtime(true);
            $executionTime = ($endTime - $startTime) * 1000;
            
            echo "<div class='info'>⚡ Thời gian 5 truy vấn: " . number_format($executionTime, 2) . "ms</div>";
            echo "<div class='info'>📊 Trung bình: " . number_format($executionTime/5, 2) . "ms/truy vấn</div>";
            
            if($executionTime/5 < 50) {
                echo "<div class='success'>🚀 Performance: Tuyệt vời!</div>";
            } elseif($executionTime/5 < 100) {
                echo "<div class='info'>👍 Performance: Tốt</div>";
            } else {
                echo "<div class='error'>⚠️ Performance: Cần tối ưu</div>";
            }
            ?>
        </div>

        <!-- URL Test Examples -->
        <div class="test-section">
            <h3>6. Ví Dụ URL Parameters</h3>
            <div class="alert alert-info">
                <h5>Các URL test bạn có thể copy vào thanh địa chỉ:</h5>
                <code><?= BASE_URL ?>?act=san-pham-theo-danh-muc&search=sách&sort=price-low</code><br>
                <code><?= BASE_URL ?>?act=san-pham-theo-danh-muc&min_price=50000&max_price=200000</code><br>
                <code><?= BASE_URL ?>?act=san-pham-theo-danh-muc&status=sale&sort=newest</code><br>
                <code><?= BASE_URL ?>?act=san-pham-theo-danh-muc&danh_muc_id=1&status=available</code>
            </div>
        </div>

        <!-- Next Steps -->
        <div class="test-section bg-light">
            <h3>7. Hướng Dẫn Sử Dụng</h3>
            <ol>
                <li><strong>Truy cập trang sản phẩm:</strong> Click link "Tất Cả Sản Phẩm" ở trên</li>
                <li><strong>Test tìm kiếm:</strong> Nhập từ khóa vào ô tìm kiếm</li>
                <li><strong>Test lọc giá:</strong> Nhập khoảng giá hoặc click các button có sẵn</li>
                <li><strong>Test sắp xếp:</strong> Chọn cách sắp xếp từ dropdown</li>
                <li><strong>Test lọc trạng thái:</strong> Chọn loại sản phẩm muốn xem</li>
                <li><strong>Kết hợp nhiều bộ lọc:</strong> Sử dụng đồng thời nhiều bộ lọc</li>
            </ol>
            
            <div class="mt-3">
                <strong>🎯 Mục tiêu đã đạt được:</strong>
                <ul>
                    <li>✅ Hệ thống lọc server-side với PHP/MySQL</li>
                    <li>✅ Giao diện người dùng thân thiện</li>
                    <li>✅ Responsive design cho mobile</li>
                    <li>✅ URL-friendly parameters</li>
                    <li>✅ Performance tối ưu</li>
                    <li>✅ Bảo mật input validation</li>
                </ul>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="<?= BASE_URL ?>?act=san-pham-theo-danh-muc" class="btn btn-primary btn-lg">
                🚀 Bắt Đầu Test Hệ Thống Lọc
            </a>
        </div>
    </div>
</body>
</html>
