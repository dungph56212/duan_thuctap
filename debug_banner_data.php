<?php
// Debug file để kiểm tra dữ liệu banner
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Debug Banner Data</h2>";

// Include model
require_once './admin/models/BannerAds.php';

try {
    $bannerModel = new BannerAds();
    
    echo "<h3>1. Kiểm tra kết nối database</h3>";
    echo "Model được khởi tạo thành công<br>";
    
    echo "<h3>2. Lấy tất cả banner (không phân trang)</h3>";
    $allBanners = $bannerModel->getAllBannersWithPagination(100, 0, []);
    echo "Tổng số banner: " . $allBanners['total'] . "<br>";
    echo "Số banner lấy được: " . count($allBanners['data']) . "<br>";
    
    if (!empty($allBanners['data'])) {
        echo "<h3>3. Danh sách banner:</h3>";
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr>";
        echo "<th>ID</th>";
        echo "<th>Tên Banner</th>";
        echo "<th>Hình ảnh</th>";
        echo "<th>Trạng thái</th>";
        echo "<th>Loại hiển thị</th>";
        echo "<th>Thứ tự</th>";
        echo "<th>Ngày tạo</th>";
        echo "</tr>";
        
        foreach ($allBanners['data'] as $banner) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($banner['id']) . "</td>";
            echo "<td>" . htmlspecialchars($banner['ten_banner']) . "</td>";
            echo "<td>" . htmlspecialchars($banner['hinh_anh']) . "</td>";
            echo "<td>" . ($banner['trang_thai'] ? 'Hoạt động' : 'Không hoạt động') . "</td>";
            echo "<td>" . htmlspecialchars($banner['loai_hien_thi']) . "</td>";
            echo "<td>" . htmlspecialchars($banner['thu_tu']) . "</td>";
            echo "<td>" . htmlspecialchars($banner['created_at']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color: red;'>Không có dữ liệu banner nào!</p>";
    }
    
    echo "<h3>4. Kiểm tra trực tiếp database</h3>";
    require_once './commons/function.php';
    $conn = connectDB();
    $stmt = $conn->query("SELECT COUNT(*) as total FROM banner_ads");
    $count = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Tổng record trong bảng banner_ads: " . $count['total'] . "<br>";
    
    $stmt = $conn->query("SELECT * FROM banner_ads LIMIT 5");
    $directData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "Dữ liệu trực tiếp từ DB: " . count($directData) . " record<br>";
    
    if (!empty($directData)) {
        echo "<h4>Sample data:</h4>";
        foreach ($directData as $row) {
            echo "ID: " . $row['id'] . ", Tên: " . $row['ten_banner'] . ", Trạng thái: " . $row['trang_thai'] . "<br>";
        }
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Lỗi: " . $e->getMessage() . "</p>";
    echo "<p>Stack trace: <pre>" . $e->getTraceAsString() . "</pre></p>";
}
?>
