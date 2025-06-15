<?php
require_once 'commons/env.php';
require_once 'commons/function.php';

try {
    $conn = connectDB();
    echo "<h2>Kiểm tra trạng thái banner</h2>";
    
    $stmt = $conn->query("SELECT id, ten_banner, trang_thai, COUNT(*) as count FROM banner_ads GROUP BY trang_thai");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>Các trạng thái banner hiện có:</h3>";
    foreach ($results as $row) {
        echo "<p>Trạng thái: '<strong>" . $row['trang_thai'] . "</strong>' - Số lượng: " . $row['count'] . "</p>";
    }
    
    echo "<h3>Chi tiết tất cả banner:</h3>";
    $stmt = $conn->query("SELECT id, ten_banner, trang_thai FROM banner_ads ORDER BY id");
    $all = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Tên Banner</th><th>Trạng thái</th></tr>";
    foreach ($all as $banner) {
        echo "<tr>";
        echo "<td>" . $banner['id'] . "</td>";
        echo "<td>" . $banner['ten_banner'] . "</td>";
        echo "<td><strong>" . $banner['trang_thai'] . "</strong></td>";
        echo "</tr>";
    }
    echo "</table>";
    
} catch (Exception $e) {
    echo "Lỗi: " . $e->getMessage();
}
?>
