<?php
// File debug model banner
require_once 'admin/models/BannerAds.php';

echo "<h2>Debug Model BannerAds</h2>";

try {
    $model = new BannerAds();
    
    echo "<h3>1. Test getAllBannersWithPagination</h3>";
    $result = $model->getAllBannersWithPagination(10, 0, []);
    
    echo "<p><strong>Tổng banner:</strong> " . $result['total'] . "</p>";
    echo "<p><strong>Dữ liệu:</strong></p>";
    
    if (!empty($result['data'])) {
        echo "<table border='1' style='border-collapse: collapse;'>";
        echo "<tr><th>ID</th><th>Tên Banner</th><th>Trạng thái</th><th>Loại hiển thị</th><th>Ngày tạo</th></tr>";
        foreach ($result['data'] as $banner) {
            echo "<tr>";
            echo "<td>" . $banner['id'] . "</td>";
            echo "<td>" . htmlspecialchars($banner['ten_banner'] ?? 'N/A') . "</td>";
            echo "<td>" . $banner['trang_thai'] . "</td>";
            echo "<td>" . htmlspecialchars($banner['loai_hien_thi'] ?? 'N/A') . "</td>";
            echo "<td>" . $banner['ngay_tao'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color: orange;'>⚠️ Không có dữ liệu từ model</p>";
    }
    
    echo "<h3>2. Test getBannerStatistics</h3>";
    $stats = $model->getBannerStatistics();
    echo "<pre>";
    var_dump($stats);
    echo "</pre>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Lỗi: " . $e->getMessage() . "</p>";
    echo "<p>Chi tiết lỗi:</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>
