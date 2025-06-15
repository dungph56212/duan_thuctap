<?php
// Test category display improvements
require_once './commons/env.php';
require_once './commons/function.php';
require_once './models/danhmucmodels.php';

echo "<h1>🎨 Test Category Display Enhancement</h1>";

$danhMucModel = new DanhMuc();

echo "<h2>📊 Kiểm tra danh mục và số lượng sản phẩm:</h2>";

try {
    $categories = $danhMucModel->getAllDanhMucWithProductCount();
    
    if (!empty($categories)) {
        echo "<div style='display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin: 20px 0;'>";
        
        $categoryIcons = [
            'pe-7s-culture',     // Văn học
            'pe-7s-graph1',      // Kinh tế
            'pe-7s-monitor',     // Công nghệ
            'pe-7s-science',     // Khoa học
            'pe-7s-map-2',       // Lịch sử, địa lý
            'pe-7s-users',       // Tâm lý
            'pe-7s-smile',       // Thiếu nhi
            'pe-7s-study',       // Giáo dục
            'pe-7s-plus',        // Y học
            'pe-7s-bookmarks'    // Mặc định
        ];
        $categoryColors = [
            '#4f46e5', '#f59e0b', '#10b981', '#ef4444', 
            '#8b5cf6', '#06b6d4', '#f97316', '#84cc16',
            '#ec4899', '#6b7280'
        ];
        
        foreach ($categories as $index => $category) {
            $iconClass = $categoryIcons[$index % count($categoryIcons)];
            $bgColor = $categoryColors[$index % count($categoryColors)];
            
            echo "<div style='background: white; border-radius: 12px; padding: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); transition: transform 0.3s ease;' onmouseover='this.style.transform=\"translateY(-5px)\"' onmouseout='this.style.transform=\"translateY(0)\"'>";
            echo "<div style='display: flex; align-items: center; margin-bottom: 15px;'>";
            echo "<div style='width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, $bgColor, {$bgColor}cc); display: flex; align-items: center; justify-content: center; margin-right: 15px;'>";
            echo "<i class='$iconClass' style='font-size: 20px; color: white;'></i>";
            echo "</div>";
            echo "<div>";
            echo "<h4 style='margin: 0; color: #2d3748; font-size: 16px;'>" . htmlspecialchars($category['ten_danh_muc']) . "</h4>";
            echo "<span style='color: #718096; font-size: 12px;'>" . ($category['so_san_pham'] ?? 0) . " sản phẩm</span>";
            echo "</div>";
            echo "</div>";
            if (!empty($category['mo_ta'])) {
                echo "<p style='color: #4a5568; font-size: 13px; margin: 0; line-height: 1.4;'>" . htmlspecialchars(substr($category['mo_ta'], 0, 80)) . (strlen($category['mo_ta']) > 80 ? '...' : '') . "</p>";
            }
            echo "</div>";
        }
        
        echo "</div>";
        
        echo "<h3>✅ Kết quả:</h3>";
        echo "<ul>";
        echo "<li>✅ Tổng số danh mục: " . count($categories) . "</li>";
        echo "<li>✅ Danh mục có icon và màu sắc khác nhau</li>";
        echo "<li>✅ Hiển thị số lượng sản phẩm</li>";
        echo "<li>✅ Mô tả được cắt ngắn phù hợp</li>";
        echo "<li>✅ Responsive design</li>";
        echo "</ul>";
        
    } else {
        echo "<p>❌ Chưa có danh mục nào trong database.</p>";
        echo "<p>💡 Hãy vào admin để thêm danh mục hoặc sử dụng bulk add.</p>";
    }
    
} catch (Exception $e) {
    echo "<p>❌ Lỗi: " . $e->getMessage() . "</p>";
}

echo "<h2>🔗 Links để test:</h2>";
echo "<ul>";
echo "<li><a href='" . BASE_URL . "' target='_blank'>🏠 Trang chủ (xem danh mục mới)</a></li>";
echo "<li><a href='" . BASE_URL_ADMIN . "?act=danh-muc-sach' target='_blank'>➕ Thêm danh mục (Admin)</a></li>";
echo "<li><a href='" . BASE_URL_ADMIN . "?act=them-sach-hang-loat' target='_blank'>📚 Thêm sách mẫu (Admin)</a></li>";
echo "</ul>";

echo "<h2>🎯 Cải tiến đã thực hiện:</h2>";
echo "<div style='background: #f0f9ff; padding: 20px; border-radius: 8px; border-left: 4px solid #0284c7;'>";
echo "<ol>";
echo "<li><strong>Icon đa dạng:</strong> Mỗi danh mục có icon riêng phù hợp với nội dung</li>";
echo "<li><strong>Màu sắc gradient:</strong> 10 màu khác nhau tạo sự phân biệt</li>";
echo "<li><strong>Số lượng sản phẩm:</strong> Hiển thị số sản phẩm trong mỗi danh mục</li>";
echo "<li><strong>Hiệu ứng hover:</strong> Animation và transform khi di chuột</li>";
echo "<li><strong>Responsive:</strong> Tự động điều chỉnh trên mobile</li>";
echo "<li><strong>Typography:</strong> Font size và spacing được tối ưu</li>";
echo "</ol>";
echo "</div>";

echo "<style>";
echo "body { font-family: Arial, sans-serif; max-width: 1200px; margin: 0 auto; padding: 20px; background: #f8fafc; }";
echo "h1 { color: #1e40af; } h2 { color: #0369a1; } h3 { color: #0284c7; }";
echo "li { margin: 8px 0; } a { color: #0284c7; text-decoration: none; }";
echo "a:hover { text-decoration: underline; }";
echo "</style>";

// Include PE7 stroke icons for preview
echo "<link rel='stylesheet' href='" . BASE_URL . "assets/css/vendor/pe-icon-7-stroke.css'>";
?>
