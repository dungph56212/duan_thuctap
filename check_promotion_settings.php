<?php
require_once 'config/database.php';

try {
    $conn = connectDB();
    
    // Kiểm tra bảng promotion_settings có tồn tại không
    $sql = "SHOW TABLES LIKE 'promotion_settings'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch();
    
    if ($result) {
        echo "✓ Bảng promotion_settings đã tồn tại\n";
        
        // Kiểm tra cấu trúc bảng
        $sql = "DESCRIBE promotion_settings";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "Cấu trúc bảng hiện tại:\n";
        foreach ($columns as $column) {
            echo "- {$column['Field']}: {$column['Type']}\n";
        }
        
    } else {
        echo "⚠ Bảng promotion_settings chưa tồn tại, đang tạo...\n";
        
        // Tạo bảng promotion_settings
        $createTableSQL = "
        CREATE TABLE `promotion_settings` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `auto_deactivate_expired` tinyint(1) DEFAULT 1,
            `notification_before_expiry` int(11) DEFAULT 7,
            `max_usage_per_customer` int(11) DEFAULT 1,
            `allow_stacking` tinyint(1) DEFAULT 0,
            `email_notifications` tinyint(1) DEFAULT 1,
            `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";
        
        $stmt = $conn->prepare($createTableSQL);
        if ($stmt->execute()) {
            echo "✓ Tạo bảng promotion_settings thành công!\n";
            
            // Thêm dữ liệu mặc định
            $insertDefaultSQL = "
            INSERT INTO promotion_settings 
            (auto_deactivate_expired, notification_before_expiry, max_usage_per_customer, allow_stacking, email_notifications)
            VALUES (1, 7, 1, 0, 1)
            ";
            
            $stmt = $conn->prepare($insertDefaultSQL);
            if ($stmt->execute()) {
                echo "✓ Thêm cài đặt mặc định thành công!\n";
            }
        } else {
            echo "✗ Lỗi khi tạo bảng promotion_settings\n";
        }
    }
    
    // Kiểm tra thống kê khuyến mãi hiện tại
    echo "\n=== THỐNG KÊ KHUYẾN MÃI ===\n";
    $sql = "SELECT 
                COUNT(*) as total_promotions,
                SUM(CASE WHEN trang_thai = 1 AND ngay_bat_dau <= NOW() AND ngay_ket_thuc >= NOW() THEN 1 ELSE 0 END) as active_promotions,
                SUM(so_lan_su_dung) as total_usage,
                SUM(CASE 
                    WHEN phan_tram_giam > 0 THEN so_lan_su_dung * 50000 
                    ELSE so_lan_su_dung * gia_giam 
                END) as total_discount_amount
            FROM khuyen_mai";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $stats = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "Tổng số khuyến mãi: " . ($stats['total_promotions'] ?? 0) . "\n";
    echo "Khuyến mãi đang hoạt động: " . ($stats['active_promotions'] ?? 0) . "\n";
    echo "Tổng lượt sử dụng: " . ($stats['total_usage'] ?? 0) . "\n";
    echo "Tổng giá trị giảm: " . number_format($stats['total_discount_amount'] ?? 0) . " VND\n";
    
    // Hiển thị danh sách khuyến mãi
    echo "\n=== DANH SÁCH KHUYẾN MÃI ===\n";
    $sql = "SELECT ma_khuyen_mai, ten_khuyen_mai, phan_tram_giam, gia_giam, so_luong, so_lan_su_dung, 
                   ngay_bat_dau, ngay_ket_thuc, trang_thai,
                   CASE 
                       WHEN ngay_ket_thuc < NOW() THEN 'Đã hết hạn'
                       WHEN ngay_bat_dau > NOW() THEN 'Chưa bắt đầu'
                       WHEN trang_thai = 1 AND ngay_bat_dau <= NOW() AND ngay_ket_thuc >= NOW() THEN 'Đang hoạt động'
                       ELSE 'Không hoạt động'
                   END as status_label
            FROM khuyen_mai ORDER BY id DESC LIMIT 10";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $promotions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($promotions)) {
        echo "Không có khuyến mãi nào trong hệ thống.\n";
    } else {
        foreach ($promotions as $promo) {
            echo "- {$promo['ma_khuyen_mai']}: {$promo['ten_khuyen_mai']}\n";
            echo "  Trạng thái: {$promo['status_label']}\n";
            echo "  Giảm: " . ($promo['phan_tram_giam'] > 0 ? $promo['phan_tram_giam'] . '%' : number_format($promo['gia_giam']) . ' VND') . "\n";
            echo "  Đã sử dụng: {$promo['so_lan_su_dung']}/{$promo['so_luong']}\n";
            echo "  Thời gian: " . date('d/m/Y', strtotime($promo['ngay_bat_dau'])) . " - " . date('d/m/Y', strtotime($promo['ngay_ket_thuc'])) . "\n\n";
        }
    }
    
} catch (Exception $e) {
    echo "Lỗi: " . $e->getMessage() . "\n";
}
?>
