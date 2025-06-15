<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo Hệ Thống Lọc Sản Phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px 0;
        }
        
        .demo-container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        
        .demo-header {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .demo-content {
            padding: 30px;
        }
        
        .test-card {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        
        .test-card:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }
        
        .test-link {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
            padding: 12px 24px;
            border-radius: 25px;
            text-decoration: none;
            display: inline-block;
            margin: 5px;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .test-link:hover {
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40,167,69,0.3);
        }
        
        .status-badge {
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 10px;
        }
        
        .status-success {
            background: #d4edda;
            color: #155724;
        }
        
        .status-info {
            background: #d1ecf1;
            color: #0c5460;
        }
        
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        
        .feature-card {
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 25px;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .feature-card:hover {
            border-color: #007bff;
            box-shadow: 0 8px 25px rgba(0,123,255,0.15);
        }
        
        .feature-icon {
            font-size: 3rem;
            color: #007bff;
            margin-bottom: 15px;
        }
        
        .instruction-list {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .instruction-list h5 {
            color: #856404;
            margin-bottom: 15px;
        }
        
        .instruction-list ol li {
            margin-bottom: 8px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="demo-container">
        <div class="demo-header">
            <h1><i class="fas fa-filter"></i> Demo Hệ Thống Lọc Sản Phẩm Nâng Cao</h1>
            <p class="mb-0">Website Bán Sách với Bộ Lọc Thông Minh</p>
        </div>
        
        <div class="demo-content">
            <div class="instruction-list">
                <h5><i class="fas fa-info-circle"></i> Hướng Dẫn Sử Dụng</h5>
                <ol>
                    <li>Click vào các link test bên dưới để kiểm tra từng tính năng</li>
                    <li>Trang sản phẩm có đầy đủ bộ lọc: giá, tác giả, trạng thái, sắp xếp</li>
                    <li>Hệ thống hỗ trợ lọc theo URL parameters và form submit</li>
                    <li>Giao diện responsive, tương thích mobile</li>
                    <li>Hiệu ứng mượt mà, trải nghiệm người dùng tốt</li>
                </ol>
            </div>

            <!-- Test Links Section -->
            <div class="test-card">
                <h3><i class="fas fa-link"></i> Links Test Chính</h3>
                <div class="row">
                    <div class="col-md-6">
                        <h5>Trang Sản Phẩm Chính:</h5>
                        <a href="<?= BASE_URL ?>?act=san-pham-theo-danh-muc" class="test-link">
                            <i class="fas fa-shopping-cart"></i> Tất Cả Sản Phẩm
                        </a>
                        
                        <h5 class="mt-3">Test File Kiểm Tra:</h5>
                        <a href="test_product_filter.php" class="test-link">
                            <i class="fas fa-bug"></i> Test Hệ Thống Lọc
                        </a>
                    </div>
                    <div class="col-md-6">
                        <h5>Test Lọc Theo URL:</h5>
                        <a href="?act=san-pham-theo-danh-muc&search=sách&sort=price-low" class="test-link">
                            <i class="fas fa-search"></i> Tìm "sách" + Giá thấp
                        </a>
                        <a href="?act=san-pham-theo-danh-muc&min_price=100000&max_price=500000" class="test-link">
                            <i class="fas fa-dollar-sign"></i> Lọc giá 100k-500k
                        </a>
                        <a href="?act=san-pham-theo-danh-muc&status=sale&sort=newest" class="test-link">
                            <i class="fas fa-percentage"></i> Sản phẩm giảm giá
                        </a>
                    </div>
                </div>
            </div>

            <!-- Features Grid -->
            <div class="feature-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h4>Tìm Kiếm Thông Minh</h4>
                    <p>Tìm kiếm theo tên sách, tác giả với debounce 1 giây. Hỗ trợ từ khóa tiếng Việt.</p>
                    <span class="status-badge status-success">Hoạt động</span>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                    <h4>Lọc Khoảng Giá</h4>
                    <p>Nhập khoảng giá tùy chỉnh hoặc chọn các khoảng có sẵn. Hiển thị giá đã quy đổi.</p>
                    <span class="status-badge status-success">Hoạt động</span>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-sort"></i>
                    </div>
                    <h4>Sắp Xếp Đa Dạng</h4>
                    <p>Sắp xếp theo tên, giá, ngày thêm. Hỗ trợ cả ascending và descending.</p>
                    <span class="status-badge status-success">Hoạt động</span>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-tags"></i>
                    </div>
                    <h4>Lọc Trạng Thái</h4>
                    <p>Lọc sản phẩm còn hàng, đang giảm giá, sản phẩm mới. Hiển thị labels rõ ràng.</p>
                    <span class="status-badge status-success">Hoạt động</span>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-user-edit"></i>
                    </div>
                    <h4>Lọc Tác Giả</h4>
                    <p>Danh sách tác giả tự động từ database. Lọc theo tác giả yêu thích.</p>
                    <span class="status-badge status-info">Đã chuẩn bị</span>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h4>Responsive Design</h4>
                    <p>Giao diện tối ưu cho mobile, tablet và desktop. CSS Grid/Flexbox.</p>
                    <span class="status-badge status-success">Hoạt động</span>
                </div>
            </div>

            <!-- Test Scenarios -->
            <div class="test-card">
                <h3><i class="fas fa-flask"></i> Kịch Bản Test Gợi Ý</h3>
                <div class="row">
                    <div class="col-md-4">
                        <h5>Test Cơ Bản:</h5>
                        <ul class="list-unstyled">
                            <li>• Tìm kiếm từ khóa "sách"</li>
                            <li>• Lọc giá dưới 100k</li>
                            <li>• Sắp xếp theo tên A-Z</li>
                            <li>• Xem sản phẩm mới</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h5>Test Nâng Cao:</h5>
                        <ul class="list-unstyled">
                            <li>• Kết hợp nhiều bộ lọc</li>
                            <li>• Test responsive trên mobile</li>
                            <li>• Kiểm tra tốc độ load</li>
                            <li>• Test với data lớn</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h5>Test Performance:</h5>
                        <ul class="list-unstyled">
                            <li>• Debounce search input</li>
                            <li>• Query optimization</li>
                            <li>• CSS transitions</li>
                            <li>• Memory usage</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Technical Info -->
            <div class="test-card">
                <h3><i class="fas fa-cogs"></i> Thông Tin Kỹ Thuật</h3>
                <div class="row">
                    <div class="col-md-6">
                        <h5>Backend:</h5>
                        <ul>
                            <li>PHP với PDO prepared statements</li>
                            <li>Dynamic SQL query building</li>
                            <li>Input sanitization & validation</li>
                            <li>Efficient database queries</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h5>Frontend:</h5>
                        <ul>
                            <li>Bootstrap 5 responsive grid</li>
                            <li>CSS custom properties</li>
                            <li>JavaScript ES6+ features</li>
                            <li>Font Awesome icons</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="text-center mt-4">
                <h4>🚀 Bắt Đầu Test Ngay</h4>
                <a href="?act=san-pham-theo-danh-muc" class="btn btn-primary btn-lg me-3">
                    <i class="fas fa-play"></i> Xem Trang Sản Phẩm
                </a>
                <a href="test_product_filter.php" class="btn btn-success btn-lg">
                    <i class="fas fa-check-double"></i> Chạy Test Tự Động
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            // Animate cards on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animation = 'slideInUp 0.6s ease forwards';
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.feature-card, .test-card').forEach(card => {
                observer.observe(card);
            });

            // Add ripple effect to buttons
            document.querySelectorAll('.test-link, .btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    const ripple = document.createElement('span');
                    const rect = button.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;
                    
                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = x + 'px';
                    ripple.style.top = y + 'px';
                    ripple.classList.add('ripple');
                    
                    button.appendChild(ripple);
                    
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
        });
    </script>

    <style>
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: scale(0);
            animation: ripple-animation 0.6s linear;
            pointer-events: none;
        }

        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        .test-link, .btn {
            position: relative;
            overflow: hidden;
        }
    </style>
</body>
</html>
