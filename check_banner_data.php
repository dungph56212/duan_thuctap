<?php
// File kiểm tra dữ liệu banner
require_once 'commons/env.php';
require_once 'config/database.php';

try {
    $conn = connectDB();
    echo "<h2>Kiểm tra Database Banner</h2>";
    
    // Kiểm tra bảng banner_ads có tồn tại không
    $stmt = $conn->query('SHOW TABLES LIKE "banner_ads"');
    if ($stmt->rowCount() > 0) {
        echo "<p style='color: green;'>✓ Bảng banner_ads tồn tại</p>";
        
        // Đếm số lượng banner
        $stmt = $conn->query('SELECT COUNT(*) as total FROM banner_ads');
        $result = $stmt->fetch();
        echo "<p><strong>Số lượng banner:</strong> " . $result['total'] . "</p>";
        
        // Lấy cấu trúc bảng
        echo "<h3>Cấu trúc bảng banner_ads:</h3>";
        $stmt = $conn->query('DESCRIBE banner_ads');
        $columns = $stmt->fetchAll();
        echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
        echo "<tr><th>Cột</th><th>Kiểu dữ liệu</th><th>Null</th><th>Key</th><th>Default</th></tr>";
        foreach ($columns as $column) {
            echo "<tr>";
            echo "<td>" . $column['Field'] . "</td>";
            echo "<td>" . $column['Type'] . "</td>";
            echo "<td>" . $column['Null'] . "</td>";
            echo "<td>" . $column['Key'] . "</td>";
            echo "<td>" . $column['Default'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Lấy dữ liệu mẫu
        echo "<h3>Dữ liệu banner hiện tại:</h3>";
        $stmt = $conn->query('SELECT * FROM banner_ads ORDER BY id DESC LIMIT 10');
        $banners = $stmt->fetchAll();
        
        if (count($banners) > 0) {
            echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
            echo "<tr><th>ID</th><th>Tên Banner</th><th>Trạng thái</th><th>Loại hiển thị</th><th>Ngày tạo</th><th>Link</th></tr>";
            foreach ($banners as $banner) {
                echo "<tr>";
                echo "<td>" . $banner['id'] . "</td>";
                echo "<td>" . htmlspecialchars($banner['ten_banner'] ?? 'N/A') . "</td>";
                echo "<td>" . $banner['trang_thai'] . "</td>";
                echo "<td>" . htmlspecialchars($banner['loai_hien_thi'] ?? 'N/A') . "</td>";
                echo "<td>" . $banner['ngay_tao'] . "</td>";
                echo "<td>" . htmlspecialchars($banner['link_url'] ?? 'N/A') . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='color: orange;'>⚠️ Không có dữ liệu banner nào trong database</p>";
        }
        
    } else {
        echo "<p style='color: red;'>✗ Bảng banner_ads không tồn tại</p>";
        
        // Kiểm tra các bảng khác có liên quan đến banner
        $stmt = $conn->query('SHOW TABLES LIKE "%banner%"');
        $tables = $stmt->fetchAll();
        if (count($tables) > 0) {
            echo "<h3>Các bảng có chứa từ 'banner':</h3>";
            foreach ($tables as $table) {
                echo "<p>- " . array_values($table)[0] . "</p>";
            }
        }
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Lỗi kết nối database: " . $e->getMessage() . "</p>";
}
?>
