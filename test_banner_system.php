<?php
// Test banner system
require_once 'commons/env.php';
require_once 'admin/models/BannerAds.php';

// Test connection
try {
    $bannerModel = new BannerAds();
    
    echo "<h2>Test Banner System</h2>";
    
    // Test 1: Lấy tất cả banner
    echo "<h3>1. Test getAllBannersWithPagination:</h3>";
    $result = $bannerModel->getAllBannersWithPagination(10, 0, []);
    echo "Tổng banner: " . $result['total'] . "<br>";
    
    foreach ($result['data'] as $banner) {
        echo "- {$banner['ten_banner']} ({$banner['loai_hien_thi']}) - Status: {$banner['trang_thai']}<br>";
    }
    
    // Test 2: Lấy banner active cho client
    echo "<h3>2. Test getActiveBannersForClient (popup):</h3>";
    $popupBanners = $bannerModel->getActiveBannersForClient('popup');
    echo "Popup banners: " . count($popupBanners) . "<br>";
    
    foreach ($popupBanners as $banner) {
        echo "- {$banner['ten_banner']} - Thứ tự: {$banner['thu_tu']}<br>";
    }
    
    echo "<h3>3. Test getActiveBannersForClient (banner_top):</h3>";
    $topBanners = $bannerModel->getActiveBannersForClient('banner_top');
    echo "Top banners: " . count($topBanners) . "<br>";
    
    // Test 3: Lấy thống kê
    echo "<h3>4. Test getBannerStatistics:</h3>";
    $stats = $bannerModel->getBannerStatistics();
    echo "Tổng banner: {$stats['total_banners']}<br>";
    echo "Banner active: {$stats['active_banners']}<br>";
    echo "Popup banners: {$stats['popup_banners']}<br>";
    echo "Tổng lượt xem: {$stats['total_views']}<br>";
    echo "Tổng lượt click: {$stats['total_clicks']}<br>";
    echo "CTR: {$stats['click_through_rate']}%<br>";
    
    echo "<h3>5. Test tạo banner mẫu (nếu chưa có):</h3>";
    if ($result['total'] == 0) {
        $sampleBanner = [
            'ten_banner' => 'Banner Test Popup',
            'mo_ta' => 'Banner test cho hệ thống popup',
            'hinh_anh' => 'assets/img/banner_test.jpg',
            'link_url' => 'https://example.com',
            'thu_tu' => 1,
            'trang_thai' => 1,
            'loai_hien_thi' => 'popup',
            'thoi_gian_hien_thi' => 5000,
            'hien_thi_lan_duy_nhat' => 1,
            'ngay_bat_dau' => date('Y-m-d H:i:s'),
            'ngay_ket_thuc' => date('Y-m-d H:i:s', strtotime('+30 days'))
        ];
        
        $result = $bannerModel->addBanner($sampleBanner);
        echo $result ? "Đã tạo banner mẫu thành công!" : "Lỗi tạo banner mẫu!";
    } else {
        echo "Đã có banner trong hệ thống.";
    }
    
} catch (Exception $e) {
    echo "Lỗi: " . $e->getMessage();
}
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
h2 { color: #333; }
h3 { color: #666; margin-top: 20px; }
</style>
