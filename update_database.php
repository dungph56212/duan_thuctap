<?php
/**
 * File cập nhật cơ sở dữ liệu cho hệ thống liên hệ
 * Chạy file này trong trình duyệt để cập nhật cấu trúc bảng lienhe
 */

// Bảo mật: Chỉ cho phép chạy từ localhost
if (!in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1', 'localhost'])) {
    die('Access denied. This script can only be run from localhost.');
}

require_once __DIR__ . '/commons/function.php';

echo "<h2>Cập nhật cơ sở dữ liệu hệ thống liên hệ</h2>";
echo "<hr>";

try {
    $conn = connectDB();
    
    // Danh sách các câu lệnh SQL cần thực thi
    $sqlCommands = [
        // Thêm cột phone
        "ALTER TABLE `lienhe` ADD COLUMN `phone` varchar(20) NULL COMMENT 'Số điện thoại' AFTER `email`",
        
        // Thêm cột subject
        "ALTER TABLE `lienhe` ADD COLUMN `subject` varchar(500) NULL COMMENT 'Tiêu đề liên hệ' AFTER `phone`",
        
        // Thêm cột status
        "ALTER TABLE `lienhe` ADD COLUMN `status` enum('pending','read','replied','closed') NOT NULL DEFAULT 'pending' COMMENT 'Trạng thái xử lý' AFTER `message`",
        
        // Thêm cột priority
        "ALTER TABLE `lienhe` ADD COLUMN `priority` enum('low','normal','high','urgent') NOT NULL DEFAULT 'normal' COMMENT 'Mức độ ưu tiên' AFTER `status`",
        
        // Thêm cột reply_message
        "ALTER TABLE `lienhe` ADD COLUMN `reply_message` text NULL COMMENT 'Nội dung phản hồi' AFTER `priority`",
        
        // Thêm cột replied_by
        "ALTER TABLE `lienhe` ADD COLUMN `replied_by` int(11) NULL COMMENT 'ID admin phản hồi' AFTER `reply_message`",
        
        // Thêm cột replied_at
        "ALTER TABLE `lienhe` ADD COLUMN `replied_at` datetime NULL COMMENT 'Thời gian phản hồi' AFTER `replied_by`",
        
        // Thêm cột ip_address
        "ALTER TABLE `lienhe` ADD COLUMN `ip_address` varchar(45) NULL COMMENT 'Địa chỉ IP người gửi' AFTER `replied_at`",
        
        // Thêm cột user_agent
        "ALTER TABLE `lienhe` ADD COLUMN `user_agent` text NULL COMMENT 'Thông tin trình duyệt' AFTER `ip_address`",
        
        // Thêm cột is_read
        "ALTER TABLE `lienhe` ADD COLUMN `is_read` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Đã đọc chưa' AFTER `user_agent`",
        
        // Thêm cột updated_at
        "ALTER TABLE `lienhe` ADD COLUMN `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Thời gian cập nhật' AFTER `created_at`"
    ];
    
    // Danh sách indexes
    $indexCommands = [
        "ALTER TABLE `lienhe` ADD INDEX `idx_status` (`status`)",
        "ALTER TABLE `lienhe` ADD INDEX `idx_priority` (`priority`)",
        "ALTER TABLE `lienhe` ADD INDEX `idx_is_read` (`is_read`)",
        "ALTER TABLE `lienhe` ADD INDEX `idx_created_at` (`created_at`)",
        "ALTER TABLE `lienhe` ADD INDEX `idx_email` (`email`)"
    ];
    
    // Dữ liệu mẫu
    $sampleDataCommands = [
        "INSERT INTO `lienhe` (`name`, `email`, `phone`, `subject`, `message`, `status`, `priority`, `ip_address`) VALUES
        ('Nguyễn Văn An', 'an.nguyen@email.com', '0901234567', 'Hỏi về sản phẩm', 'Tôi muốn tìm hiểu về sản phẩm XYZ có sẵn không?', 'pending', 'normal', '192.168.1.100'),
        ('Trần Thị Bình', 'binh.tran@email.com', '0987654321', 'Khiếu nại đơn hàng', 'Đơn hàng #12345 của tôi bị chậm trễ, xin hỗ trợ.', 'read', 'high', '192.168.1.101'),
        ('Lê Văn Cường', 'cuong.le@email.com', '0912345678', 'Yêu cầu báo giá', 'Có thể gửi báo giá cho số lượng lớn không?', 'replied', 'normal', '192.168.1.102'),
        ('Phạm Thị Dung', 'dung.pham@email.com', '0923456789', 'Hỗ trợ kỹ thuật', 'Sản phẩm bị lỗi sau khi mua 1 tuần.', 'pending', 'urgent', '192.168.1.103'),
        ('Hoàng Văn Em', 'em.hoang@email.com', '0934567890', 'Góp ý cải thiện', 'Website rất tốt nhưng cần cải thiện tốc độ tải.', 'closed', 'low', '192.168.1.104')",
        
        "UPDATE `lienhe` 
        SET `reply_message` = 'Cảm ơn anh đã liên hệ. Chúng tôi sẽ gửi báo giá chi tiết qua email trong ngày hôm nay.',
            `replied_by` = 1,
            `replied_at` = NOW()
        WHERE `email` = 'cuong.le@email.com'"
    ];
    
    $successCount = 0;
    $errorCount = 0;
    
    echo "<h3>🔧 Bước 1: Thêm các cột mới</h3>";
    
    foreach ($sqlCommands as $index => $sql) {
        try {
            $conn->exec($sql);
            echo "<p style='color: green;'>✅ Thành công: " . substr($sql, 0, 50) . "...</p>";
            $successCount++;
        } catch (PDOException $e) {
            if (strpos($e->getMessage(), 'Duplicate column name') !== false) {
                echo "<p style='color: orange;'>⚠️ Cột đã tồn tại: " . substr($sql, 0, 50) . "...</p>";
            } else {
                echo "<p style='color: red;'>❌ Lỗi: " . $e->getMessage() . "</p>";
                $errorCount++;
            }
        }
    }
    
    echo "<h3>📊 Bước 2: Thêm indexes</h3>";
    
    foreach ($indexCommands as $sql) {
        try {
            $conn->exec($sql);
            echo "<p style='color: green;'>✅ Thành công: " . substr($sql, 0, 50) . "...</p>";
            $successCount++;
        } catch (PDOException $e) {
            if (strpos($e->getMessage(), 'Duplicate key name') !== false) {
                echo "<p style='color: orange;'>⚠️ Index đã tồn tại: " . substr($sql, 0, 50) . "...</p>";
            } else {
                echo "<p style='color: red;'>❌ Lỗi: " . $e->getMessage() . "</p>";
                $errorCount++;
            }
        }
    }
    
    echo "<h3>📝 Bước 3: Thêm dữ liệu mẫu</h3>";
    
    foreach ($sampleDataCommands as $sql) {
        try {
            $conn->exec($sql);
            echo "<p style='color: green;'>✅ Thành công: Thêm dữ liệu mẫu</p>";
            $successCount++;
        } catch (PDOException $e) {
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                echo "<p style='color: orange;'>⚠️ Dữ liệu mẫu đã tồn tại</p>";
            } else {
                echo "<p style='color: red;'>❌ Lỗi: " . $e->getMessage() . "</p>";
                $errorCount++;
            }
        }
    }
    
    echo "<hr>";
    echo "<h3>📈 Tóm tắt</h3>";
    echo "<p><strong>Thành công:</strong> $successCount câu lệnh</p>";
    echo "<p><strong>Lỗi:</strong> $errorCount câu lệnh</p>";
    
    if ($errorCount == 0) {
        echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
        echo "<strong>🎉 Cập nhật hoàn tất!</strong><br>";
        echo "Cơ sở dữ liệu đã được cập nhật thành công. Bạn có thể sử dụng hệ thống liên hệ ngay bây giờ.";
        echo "</div>";
        
        echo "<h3>🔗 Liên kết hữu ích:</h3>";
        echo "<ul>";
        echo "<li><a href='index.php?act=lienhe' target='_blank'>Trang liên hệ (Client)</a></li>";
        echo "<li><a href='admin/index.php?ctl=lienhe' target='_blank'>Quản lý liên hệ (Admin)</a></li>";
        echo "</ul>";
        
        // Kiểm tra cấu trúc bảng
        echo "<h3>📋 Cấu trúc bảng sau khi cập nhật:</h3>";
        $stmt = $conn->query("DESCRIBE lienhe");
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr style='background: #f8f9fa;'><th>Cột</th><th>Kiểu dữ liệu</th><th>Null</th><th>Mặc định</th><th>Ghi chú</th></tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td><strong>" . $row['Field'] . "</strong></td>";
            echo "<td>" . $row['Type'] . "</td>";
            echo "<td>" . $row['Null'] . "</td>";
            echo "<td>" . $row['Default'] . "</td>";
            echo "<td>" . $row['Extra'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
    } else {
        echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
        echo "<strong>⚠️ Có lỗi xảy ra!</strong><br>";
        echo "Vui lòng kiểm tra lại các lỗi ở trên và chạy lại script này.";
        echo "</div>";
    }
    
} catch (Exception $e) {
    echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px;'>";
    echo "<strong>❌ Lỗi kết nối cơ sở dữ liệu:</strong><br>";
    echo $e->getMessage();
    echo "</div>";
}

echo "<hr>";
echo "<p><em>Script được tạo lúc: " . date('d/m/Y H:i:s') . "</em></p>";
echo "<p><strong>Lưu ý:</strong> Sau khi cập nhật thành công, bạn có thể xóa file này để bảo mật.</p>";
?>

<style>
body {
    font-family: Arial, sans-serif;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    background: #f8f9fa;
}

h2 {
    color: #2c3e50;
    text-align: center;
    background: white;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

h3 {
    color: #34495e;
    border-left: 4px solid #3498db;
    padding-left: 10px;
    background: white;
    padding: 10px;
    border-radius: 0 5px 5px 0;
}

table {
    background: white;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

table th {
    padding: 10px;
    text-align: left;
}

table td {
    padding: 8px;
    border-bottom: 1px solid #eee;
}

a {
    color: #3498db;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}
</style>
