<?php
// Debug banner cho frontend
require_once './commons/env.php';
require_once './commons/function.php';
require_once './controllers/BannerController.php';

echo "<h2>Test Banner Frontend</h2>";

try {
    $bannerController = new BannerController();
    $result = $bannerController->getActiveBanners();

    echo "<h3>Kết quả lấy banner:</h3>";
    var_dump($result);

    if ($result['success'] && !empty($result['banners'])) {
        echo "<h3>Danh sách banner active:</h3>";
        foreach ($result['banners'] as $banner) {
            echo "<div style='border: 1px solid #ccc; margin: 10px; padding: 10px;'>";
            echo "<strong>ID:</strong> " . $banner['id'] . "<br>";
            echo "<strong>Tên:</strong> " . htmlspecialchars($banner['ten_banner']) . "<br>";
            echo "<strong>Mô tả:</strong> " . htmlspecialchars($banner['mo_ta']) . "<br>";
            echo "<strong>Hình ảnh:</strong> " . htmlspecialchars($banner['hinh_anh']) . "<br>";
            echo "<strong>Link:</strong> " . htmlspecialchars($banner['lien_ket']) . "<br>";
            echo "<strong>Trạng thái:</strong> " . $banner['trang_thai'] . "<br>";
            echo "<strong>Thứ tự:</strong> " . $banner['thu_tu'] . "<br>";
            echo "<strong>Ngày bắt đầu:</strong> " . $banner['ngay_bat_dau'] . "<br>";
            echo "<strong>Ngày kết thúc:</strong> " . $banner['ngay_ket_thuc'] . "<br>";
            echo "</div>";
        }
    } else {
        echo "<p style='color: red;'>Không có banner nào hoặc có lỗi!</p>";
        if (!$result['success']) {
            echo "<p style='color: red;'>Lỗi: " . $result['message'] . "</p>";
        }
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>Exception: " . $e->getMessage() . "</p>";
}
?>
