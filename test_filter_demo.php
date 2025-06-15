<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Hệ Thống Lọc Sản Phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .test-section {
            margin: 30px 0;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #f8f9fa;
        }
        .test-result {
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
        }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .info { background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }
        .demo-link {
            display: inline-block;
            margin: 10px 5px;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s;
        }
        .demo-link:hover {
            background: #0056b3;
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">
            <i class="fas fa-filter"></i> Test Hệ Thống Lọc Sản Phẩm
        </h1>
        
        <?php
        // Include necessary files
        $basePath = dirname(__FILE__);
        if (file_exists($basePath . '/commons/env.php')) {
            require_once $basePath . '/commons/env.php';
            require_once $basePath . '/commons/function.php';
            
            echo '<div class="alert alert-success"><i class="fas fa-check"></i> Đã load thành công các file cơ bản</div>';
        } else {
            echo '<div class="alert alert-danger"><i class="fas fa-times"></i> Không tìm thấy file env.php</div>';
        }
        ?>
        
        <div class="test-section">
            <h3><i class="fas fa-link"></i> Demo Links - Các URL Test Bộ Lọc</h3>
            <p>Click vào các link dưới đây để test từng tính năng lọc:</p>
            
            <div class="row">
                <div class="col-md-6">
                    <h5>🔍 Test Tìm Kiếm</h5>
                    <a href="?act=san-pham-theo-danh-muc&search=sách" class="demo-link">
                        Tìm "sách"
                    </a>
                    <a href="?act=san-pham-theo-danh-muc&search=tình" class="demo-link">
                        Tìm "tình"
                    </a>
                </div>
                
                <div class="col-md-6">
                    <h5>💰 Test Lọc Giá</h5>
                    <a href="?act=san-pham-theo-danh-muc&min_price=50000&max_price=200000" class="demo-link">
                        50k - 200k
                    </a>
                    <a href="?act=san-pham-theo-danh-muc&max_price=100000" class="demo-link">
                        Dưới 100k
                    </a>
                </div>
            </div>
            
            <div class="row mt-3">
                <div class="col-md-6">
                    <h5>🔀 Test Sắp Xếp</h5>
                    <a href="?act=san-pham-theo-danh-muc&sort=price-low" class="demo-link">
                        Giá thấp → cao
                    </a>
                    <a href="?act=san-pham-theo-danh-muc&sort=name" class="demo-link">
                        Tên A-Z
                    </a>
                </div>
                
                <div class="col-md-6">
                    <h5>📊 Test Trạng Thái</h5>
                    <a href="?act=san-pham-theo-danh-muc&status=sale" class="demo-link">
                        Đang giảm giá
                    </a>
                    <a href="?act=san-pham-theo-danh-muc&status=available" class="demo-link">
                        Còn hàng
                    </a>
                </div>
            </div>
            
            <div class="row mt-3">
                <div class="col-12">
                    <h5>🔥 Test Kết Hợp Nhiều Filter</h5>
                    <a href="?act=san-pham-theo-danh-muc&search=sách&sort=price-low&min_price=50000&status=available" class="demo-link">
                        Tìm "sách" + Giá thấp + Từ 50k + Còn hàng
                    </a>
                    <a href="?act=san-pham-theo-danh-muc&max_price=500000&sort=newest&status=sale" class="demo-link">
                        Dưới 500k + Mới nhất + Giảm giá
                    </a>
                </div>
            </div>
        </div>
        
        <div class="test-section">
            <h3><i class="fas fa-database"></i> Test Database Connection</h3>
            <?php
            try {
                if (function_exists('connectDB')) {
                    $conn = connectDB();
                    echo '<div class="test-result success"><i class="fas fa-check"></i> Kết nối database thành công!</div>';
                    
                    // Test lấy số lượng sản phẩm
                    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM san_phams");
                    $stmt->execute();
                    $result = $stmt->fetch();
                    echo '<div class="test-result info"><i class="fas fa-info"></i> Tổng số sản phẩm: ' . $result['total'] . '</div>';
                    
                    // Test lấy danh mục
                    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM danh_mucs");
                    $stmt->execute();
                    $result = $stmt->fetch();
                    echo '<div class="test-result info"><i class="fas fa-info"></i> Tổng số danh mục: ' . $result['total'] . '</div>';
                    
                } else {
                    echo '<div class="test-result error"><i class="fas fa-times"></i> Function connectDB không tồn tại!</div>';
                }
            } catch (Exception $e) {
                echo '<div class="test-result error"><i class="fas fa-times"></i> Lỗi database: ' . $e->getMessage() . '</div>';
            }
            ?>
        </div>
        
        <div class="test-section">
            <h3><i class="fas fa-code"></i> Test Model Functions</h3>
            <?php
            try {
                if (file_exists($basePath . '/models/SanPham.php')) {
                    require_once $basePath . '/models/SanPham.php';
                    $sanPhamModel = new SanPham();
                    
                    echo '<div class="test-result success"><i class="fas fa-check"></i> Model SanPham loaded thành công!</div>';
                    
                    // Test method getAllProductWithFilters
                    if (method_exists($sanPhamModel, 'getAllProductWithFilters')) {
                        $testFilters = ['search' => 'sách', 'sort' => 'price-low'];
                        $products = $sanPhamModel->getAllProductWithFilters($testFilters);
                        echo '<div class="test-result success"><i class="fas fa-check"></i> Method getAllProductWithFilters hoạt động - Tìm thấy: ' . count($products) . ' sản phẩm</div>';
                    } else {
                        echo '<div class="test-result error"><i class="fas fa-times"></i> Method getAllProductWithFilters không tồn tại!</div>';
                    }
                    
                    // Test method getUniqueAuthors
                    if (method_exists($sanPhamModel, 'getUniqueAuthors')) {
                        $authors = $sanPhamModel->getUniqueAuthors();
                        echo '<div class="test-result success"><i class="fas fa-check"></i> Method getUniqueAuthors hoạt động - Tìm thấy: ' . count($authors) . ' tác giả</div>';
                        if (!empty($authors)) {
                            echo '<div class="test-result info"><i class="fas fa-info"></i> Một số tác giả: ' . implode(', ', array_slice($authors, 0, 3)) . '...</div>';
                        }
                    } else {
                        echo '<div class="test-result error"><i class="fas fa-times"></i> Method getUniqueAuthors không tồn tại!</div>';
                    }
                    
                    // Test method getPriceRange
                    if (method_exists($sanPhamModel, 'getPriceRange')) {
                        $priceRange = $sanPhamModel->getPriceRange();
                        echo '<div class="test-result success"><i class="fas fa-check"></i> Method getPriceRange hoạt động - Khoảng giá: ' . 
                             number_format($priceRange['min_price']) . 'đ - ' . number_format($priceRange['max_price']) . 'đ</div>';
                    } else {
                        echo '<div class="test-result error"><i class="fas fa-times"></i> Method getPriceRange không tồn tại!</div>';
                    }
                    
                } else {
                    echo '<div class="test-result error"><i class="fas fa-times"></i> File SanPham.php không tồn tại!</div>';
                }
            } catch (Exception $e) {
                echo '<div class="test-result error"><i class="fas fa-times"></i> Lỗi Model: ' . $e->getMessage() . '</div>';
            }
            ?>
        </div>
        
        <div class="test-section">
            <h3><i class="fas fa-cogs"></i> Test Controller Integration</h3>
            <?php
            try {
                if (file_exists($basePath . '/controllers/HomeController.php')) {
                    // Mô phỏng $_GET parameters
                    $_GET['act'] = 'san-pham-theo-danh-muc';
                    $_GET['search'] = 'test';
                    $_GET['sort'] = 'price-low';
                    
                    echo '<div class="test-result success"><i class="fas fa-check"></i> HomeController file tồn tại!</div>';
                    echo '<div class="test-result info"><i class="fas fa-info"></i> Đã set test parameters: act=' . $_GET['act'] . ', search=' . $_GET['search'] . ', sort=' . $_GET['sort'] . '</div>';
                } else {
                    echo '<div class="test-result error"><i class="fas fa-times"></i> File HomeController.php không tồn tại!</div>';
                }
            } catch (Exception $e) {
                echo '<div class="test-result error"><i class="fas fa-times"></i> Lỗi Controller: ' . $e->getMessage() . '</div>';
            }
            ?>
        </div>
        
        <div class="test-section">
            <h3><i class="fas fa-eye"></i> Test View Files</h3>
            <?php
            $viewFiles = [
                'views/sanPhamTheoDanhMuc.php' => 'Trang danh sách sản phẩm chính',
                'assets/css/product-filter.css' => 'CSS cho bộ lọc sản phẩm'
            ];
            
            foreach ($viewFiles as $file => $description) {
                if (file_exists($basePath . '/' . $file)) {
                    $fileSize = filesize($basePath . '/' . $file);
                    echo '<div class="test-result success"><i class="fas fa-check"></i> ' . $description . ' - File size: ' . number_format($fileSize) . ' bytes</div>';
                } else {
                    echo '<div class="test-result error"><i class="fas fa-times"></i> ' . $description . ' - File không tồn tại!</div>';
                }
            }
            ?>
        </div>
        
        <div class="test-section">
            <h3><i class="fas fa-rocket"></i> Truy Cập Hệ Thống</h3>
            <div class="text-center">
                <a href="<?= BASE_URL ?? '.' ?>?act=san-pham-theo-danh-muc" class="btn btn-primary btn-lg">
                    <i class="fas fa-shopping-cart"></i> Xem Trang Sản Phẩm Với Bộ Lọc
                </a>
                <a href="<?= BASE_URL ?? '.' ?>?act=san-pham-theo-danh-muc&search=sách&sort=price-low" class="btn btn-success btn-lg">
                    <i class="fas fa-filter"></i> Test Lọc Mẫu
                </a>
            </div>
            
            <hr>
            
            <h5>📋 Hướng dẫn sử dụng:</h5>
            <ol>
                <li><strong>Tìm kiếm:</strong> Nhập từ khóa vào ô tìm kiếm để tìm theo tên sách, tác giả</li>
                <li><strong>Lọc giá:</strong> Nhập khoảng giá hoặc click các nút giá có sẵn</li>
                <li><strong>Sắp xếp:</strong> Chọn cách sắp xếp từ dropdown</li>
                <li><strong>Trạng thái:</strong> Lọc theo trạng thái sản phẩm (còn hàng, giảm giá, mới)</li>
                <li><strong>Kết hợp:</strong> Có thể sử dụng nhiều bộ lọc cùng lúc</li>
            </ol>
        </div>
        
        <div class="alert alert-info">
            <h5><i class="fas fa-lightbulb"></i> Ghi chú:</h5>
            <ul class="mb-0">
                <li>Hệ thống sử dụng server-side filtering cho hiệu suất tốt nhất</li>
                <li>URL sẽ thay đổi theo các bộ lọc để có thể bookmark</li>
                <li>Giao diện responsive, hoạt động tốt trên mobile</li>
                <li>Có hiệu ứng loading và debounce cho trải nghiệm mượt mà</li>
            </ul>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
