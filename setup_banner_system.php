<?php
// Banner System Setup Script
require_once 'commons/env.php';

try {
    $conn = connectDB();
    
    echo "<h2>🎯 Banner System Setup & Demo</h2>";
    
    // 1. Kiểm tra và tạo bảng banner_ads nếu chưa có
    echo "<h3>📋 1. Kiểm tra cấu trúc database:</h3>";
    
    $checkTable = $conn->query("SHOW TABLES LIKE 'banner_ads'");
    if ($checkTable->rowCount() == 0) {
        echo "❌ Bảng banner_ads chưa tồn tại. Đang tạo...<br>";
        
        $createTableSQL = "
        CREATE TABLE `banner_ads` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `ten_banner` varchar(255) NOT NULL COMMENT 'Tên banner',
            `mo_ta` text COMMENT 'Mô tả banner',
            `hinh_anh` varchar(500) NOT NULL COMMENT 'Đường dẫn hình ảnh',
            `link_url` varchar(500) COMMENT 'Link khi click vào banner',
            `thu_tu` int(11) DEFAULT 0 COMMENT 'Thứ tự hiển thị',
            `trang_thai` tinyint(1) DEFAULT 1 COMMENT '1: Hoạt động, 0: Không hoạt động',
            `loai_hien_thi` enum('popup','banner_top','banner_bottom','sidebar') DEFAULT 'popup' COMMENT 'Loại hiển thị',
            `thoi_gian_hien_thi` int(11) DEFAULT 5000 COMMENT 'Thời gian hiển thị popup (ms)',
            `hien_thi_lan_duy_nhat` tinyint(1) DEFAULT 1 COMMENT '1: Chỉ hiển thị 1 lần/session, 0: Hiển thị mỗi lần tải trang',
            `ngay_bat_dau` datetime DEFAULT NULL COMMENT 'Ngày bắt đầu hiển thị',
            `ngay_ket_thuc` datetime DEFAULT NULL COMMENT 'Ngày kết thúc hiển thị',
            `luot_xem` int(11) DEFAULT 0 COMMENT 'Số lượt xem',
            `luot_click` int(11) DEFAULT 0 COMMENT 'Số lượt click',
            `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `idx_trang_thai` (`trang_thai`),
            KEY `idx_loai_hien_thi` (`loai_hien_thi`),
            KEY `idx_thu_tu` (`thu_tu`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";
        
        $conn->exec($createTableSQL);
        echo "✅ Đã tạo bảng banner_ads thành công!<br>";
    } else {
        echo "✅ Bảng banner_ads đã tồn tại.<br>";
    }
    
    // 2. Tạo thư mục uploads nếu chưa có
    echo "<h3>📁 2. Kiểm tra thư mục uploads:</h3>";
    $uploadDirs = ['uploads', 'uploads/banners'];
    
    foreach ($uploadDirs as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
            echo "✅ Đã tạo thư mục: $dir<br>";
        } else {
            echo "✅ Thư mục $dir đã tồn tại.<br>";
        }
    }
    
    // 3. Tạo ảnh banner mẫu
    echo "<h3>🖼️ 3. Tạo ảnh banner mẫu:</h3>";
    
    function createSampleBannerImage($filename, $text, $bgColor, $textColor, $width = 800, $height = 400) {
        $image = imagecreate($width, $height);
        
        // Chuyển đổi màu hex sang RGB
        $bg = imagecolorallocate($image, 
            hexdec(substr($bgColor, 1, 2)), 
            hexdec(substr($bgColor, 3, 2)), 
            hexdec(substr($bgColor, 5, 2))
        );
        $textColorRGB = imagecolorallocate($image,
            hexdec(substr($textColor, 1, 2)), 
            hexdec(substr($textColor, 3, 2)), 
            hexdec(substr($textColor, 5, 2))
        );
        
        // Điền màu nền
        imagefill($image, 0, 0, $bg);
        
        // Thêm text
        $font_size = 20;
        $text_box = imagettfbbox($font_size, 0, __DIR__ . '/assets/fonts/arial.ttf', $text);
        $text_width = $text_box[4] - $text_box[0];
        $text_height = $text_box[1] - $text_box[7];
        
        $x = ($width - $text_width) / 2;
        $y = ($height - $text_height) / 2 + $text_height;
        
        // Fallback nếu không có font
        if (!file_exists(__DIR__ . '/assets/fonts/arial.ttf')) {
            imagestring($image, 5, $x, $y - 20, $text, $textColorRGB);
        } else {
            imagettftext($image, $font_size, 0, $x, $y, $textColorRGB, __DIR__ . '/assets/fonts/arial.ttf', $text);
        }
        
        // Lưu ảnh
        imagepng($image, $filename);
        imagedestroy($image);
        
        return file_exists($filename);
    }
    
    $sampleImages = [
        [
            'file' => 'uploads/banners/popup_sale.png',
            'text' => 'SALE 50% - KHONG BON LOI!',
            'bg' => '#ff6b6b',
            'textColor' => '#ffffff'
        ],
        [
            'file' => 'uploads/banners/top_banner.png', 
            'text' => 'MIEN PHI VAN CHUYEN TOAN QUOC',
            'bg' => '#4ecdc4',
            'textColor' => '#ffffff',
            'width' => 1200,
            'height' => 100
        ],
        [
            'file' => 'uploads/banners/sidebar_promo.png',
            'text' => 'GIAM GIA 30%',
            'bg' => '#45b7d1', 
            'textColor' => '#ffffff',
            'width' => 200,
            'height' => 400
        ],
        [
            'file' => 'uploads/banners/bottom_banner.png',
            'text' => 'DANG KY NHAN VOUCHER 100K',
            'bg' => '#96ceb4',
            'textColor' => '#2c3e50',
            'width' => 1200,
            'height' => 80
        ]
    ];
    
    foreach ($sampleImages as $img) {
        if (!file_exists($img['file'])) {
            $created = createSampleBannerImage(
                $img['file'], 
                $img['text'], 
                $img['bg'], 
                $img['textColor'],
                $img['width'] ?? 800,
                $img['height'] ?? 400
            );
            
            if ($created) {
                echo "✅ Đã tạo ảnh mẫu: " . basename($img['file']) . "<br>";
            } else {
                echo "❌ Lỗi tạo ảnh: " . basename($img['file']) . "<br>";
            }
        } else {
            echo "✅ Ảnh đã tồn tại: " . basename($img['file']) . "<br>";
        }
    }
    
    // 4. Thêm dữ liệu banner mẫu
    echo "<h3>📝 4. Thêm dữ liệu banner mẫu:</h3>";
    
    $checkBanners = $conn->query("SELECT COUNT(*) as count FROM banner_ads");
    $bannerCount = $checkBanners->fetch(PDO::FETCH_ASSOC)['count'];
    
    if ($bannerCount == 0) {
        $sampleBanners = [
            [
                'ten_banner' => 'Popup Sale Cuối Năm',
                'mo_ta' => 'Banner popup quảng cáo sale cuối năm với giảm giá 50%',
                'hinh_anh' => 'uploads/banners/popup_sale.png',
                'link_url' => '?act=khuyen-mai',
                'thu_tu' => 1,
                'trang_thai' => 1,
                'loai_hien_thi' => 'popup',
                'thoi_gian_hien_thi' => 6000,
                'hien_thi_lan_duy_nhat' => 1,
                'ngay_bat_dau' => date('Y-m-d H:i:s'),
                'ngay_ket_thuc' => date('Y-m-d H:i:s', strtotime('+30 days'))
            ],
            [
                'ten_banner' => 'Banner Top - Miễn phí vận chuyển',
                'mo_ta' => 'Banner hiển thị ở đầu trang về chính sách miễn phí vận chuyển',
                'hinh_anh' => 'uploads/banners/top_banner.png',
                'link_url' => '?act=chinh-sach-van-chuyen',
                'thu_tu' => 1,
                'trang_thai' => 1,
                'loai_hien_thi' => 'banner_top',
                'thoi_gian_hien_thi' => 0,
                'hien_thi_lan_duy_nhat' => 0,
                'ngay_bat_dau' => date('Y-m-d H:i:s'),
                'ngay_ket_thuc' => null
            ],
            [
                'ten_banner' => 'Sidebar Khuyến Mãi',
                'mo_ta' => 'Banner sidebar quảng cáo giảm giá 30% cho sản phẩm mới',
                'hinh_anh' => 'uploads/banners/sidebar_promo.png',
                'link_url' => '?act=san-pham-moi',
                'thu_tu' => 1,
                'trang_thai' => 1,
                'loai_hien_thi' => 'sidebar',
                'thoi_gian_hien_thi' => 0,
                'hien_thi_lan_duy_nhat' => 0,
                'ngay_bat_dau' => date('Y-m-d H:i:s'),
                'ngay_ket_thuc' => date('Y-m-d H:i:s', strtotime('+15 days'))
            ],
            [
                'ten_banner' => 'Banner Bottom - Đăng ký nhận voucher',
                'mo_ta' => 'Banner cuối trang khuyến khích đăng ký nhận voucher 100K',
                'hinh_anh' => 'uploads/banners/bottom_banner.png',
                'link_url' => '?act=dang-ky-voucher',
                'thu_tu' => 1,
                'trang_thai' => 1,
                'loai_hien_thi' => 'banner_bottom',
                'thoi_gian_hien_thi' => 0,
                'hien_thi_lan_duy_nhat' => 0,
                'ngay_bat_dau' => date('Y-m-d H:i:s'),
                'ngay_ket_thuc' => null
            ]
        ];
        
        $insertSQL = "INSERT INTO banner_ads (ten_banner, mo_ta, hinh_anh, link_url, thu_tu, trang_thai, loai_hien_thi, thoi_gian_hien_thi, hien_thi_lan_duy_nhat, ngay_bat_dau, ngay_ket_thuc) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertSQL);
        
        foreach ($sampleBanners as $banner) {
            $result = $stmt->execute([
                $banner['ten_banner'],
                $banner['mo_ta'], 
                $banner['hinh_anh'],
                $banner['link_url'],
                $banner['thu_tu'],
                $banner['trang_thai'],
                $banner['loai_hien_thi'],
                $banner['thoi_gian_hien_thi'],
                $banner['hien_thi_lan_duy_nhat'],
                $banner['ngay_bat_dau'],
                $banner['ngay_ket_thuc']
            ]);
            
            if ($result) {
                echo "✅ Đã thêm banner: " . $banner['ten_banner'] . "<br>";
            } else {
                echo "❌ Lỗi thêm banner: " . $banner['ten_banner'] . "<br>";
            }
        }
    } else {
        echo "✅ Đã có $bannerCount banner trong hệ thống.<br>";
    }
    
    // 5. Test hệ thống
    echo "<h3>🧪 5. Test hệ thống banner:</h3>";
    
    // Test API
    echo "<div style='background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "<h4>🔗 Test API endpoints:</h4>";
    echo "<a href='controllers/BannerController.php?action=getActiveBanners' target='_blank' class='btn'>Test API lấy banner</a><br><br>";
    echo "<a href='admin/?act=danh-sach-banner' target='_blank' class='btn'>Vào trang quản lý banner</a><br><br>";
    echo "<a href='index.php' target='_blank' class='btn'>Xem banner trên trang chủ</a>";
    echo "</div>";
    
    // 6. Thống kê
    echo "<h3>📊 6. Thống kê hệ thống:</h3>";
    
    $stats = $conn->query("
        SELECT 
            COUNT(*) as total_banners,
            SUM(CASE WHEN trang_thai = 1 THEN 1 ELSE 0 END) as active_banners,
            SUM(CASE WHEN loai_hien_thi = 'popup' THEN 1 ELSE 0 END) as popup_banners,
            SUM(CASE WHEN loai_hien_thi = 'banner_top' THEN 1 ELSE 0 END) as top_banners,
            SUM(CASE WHEN loai_hien_thi = 'banner_bottom' THEN 1 ELSE 0 END) as bottom_banners,
            SUM(CASE WHEN loai_hien_thi = 'sidebar' THEN 1 ELSE 0 END) as sidebar_banners,
            SUM(luot_xem) as total_views,
            SUM(luot_click) as total_clicks
        FROM banner_ads
    ")->fetch(PDO::FETCH_ASSOC);
    
    echo "<div style='display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin: 20px 0;'>";
    
    $statItems = [
        ['label' => 'Tổng Banner', 'value' => $stats['total_banners'], 'color' => '#007bff'],
        ['label' => 'Banner Hoạt Động', 'value' => $stats['active_banners'], 'color' => '#28a745'],
        ['label' => 'Popup Banner', 'value' => $stats['popup_banners'], 'color' => '#ffc107'],
        ['label' => 'Top Banner', 'value' => $stats['top_banners'], 'color' => '#17a2b8'],
        ['label' => 'Bottom Banner', 'value' => $stats['bottom_banners'], 'color' => '#6c757d'],
        ['label' => 'Sidebar Banner', 'value' => $stats['sidebar_banners'], 'color' => '#6f42c1'],
        ['label' => 'Tổng Lượt Xem', 'value' => number_format($stats['total_views']), 'color' => '#fd7e14'],
        ['label' => 'Tổng Lượt Click', 'value' => number_format($stats['total_clicks']), 'color' => '#e83e8c']
    ];
    
    foreach ($statItems as $item) {
        echo "<div style='background: {$item['color']}; color: white; padding: 20px; border-radius: 8px; text-align: center;'>";
        echo "<h3 style='margin: 0; font-size: 2rem;'>{$item['value']}</h3>";
        echo "<p style='margin: 5px 0 0 0;'>{$item['label']}</p>";
        echo "</div>";
    }
    
    echo "</div>";
    
    echo "<div style='background: #d4edda; border: 1px solid #c3e6cb; padding: 20px; border-radius: 5px; margin: 20px 0;'>";
    echo "<h3 style='color: #155724; margin-top: 0;'>🎉 Setup hoàn tất!</h3>";
    echo "<p style='color: #155724; margin-bottom: 0;'>Hệ thống banner đã được thiết lập thành công. Bạn có thể:</p>";
    echo "<ul style='color: #155724;'>";
    echo "<li>Quản lý banner tại: <a href='admin/?act=danh-sach-banner'>Admin Panel</a></li>";
    echo "<li>Xem banner hoạt động tại: <a href='index.php'>Trang chủ</a></li>";
    echo "<li>Kiểm tra API tại: <a href='controllers/BannerController.php?action=getActiveBanners'>Banner API</a></li>";
    echo "</ul>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div style='background: #f8d7da; border: 1px solid #f5c6cb; padding: 20px; border-radius: 5px; color: #721c24;'>";
    echo "<h3>❌ Lỗi setup:</h3>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "</div>";
}
?>

<style>
body { 
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
    max-width: 1200px; 
    margin: 0 auto; 
    padding: 20px;
    background: #f8f9fa;
}
h2, h3 { color: #333; }
h2 { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; border-radius: 8px; }
.btn {
    display: inline-block;
    padding: 8px 16px;
    background: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    margin: 5px;
    border: none;
    cursor: pointer;
}
.btn:hover { background: #0056b3; }
</style>
