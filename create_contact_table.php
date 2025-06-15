<?php
// File này sẽ tạo bảng liên hệ và dữ liệu mẫu
// Chạy file này qua trình duyệt: http://localhost/duan_thuctap/create_contact_table.php

require_once 'commons/function.php';

try {
    $conn = connectDB();
    
    echo "<h2>Đang tạo bảng liên hệ...</h2>";
    
    // Kiểm tra xem bảng đã tồn tại chưa
    $checkTable = $conn->query("SHOW TABLES LIKE 'lienhe'");
    if ($checkTable->rowCount() > 0) {
        echo "<p style='color: orange;'>⚠️ Bảng 'lienhe' đã tồn tại. Đang xóa bảng cũ...</p>";
        $conn->exec("DROP TABLE lienhe");
    }
    
    // Tạo bảng lienhe
    $createTableSQL = "
    CREATE TABLE `lienhe` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `name` varchar(255) NOT NULL COMMENT 'Tên người liên hệ',
      `email` varchar(255) NOT NULL COMMENT 'Email người liên hệ',
      `phone` varchar(20) NULL COMMENT 'Số điện thoại',
      `subject` varchar(500) NULL COMMENT 'Tiêu đề liên hệ',
      `message` text NOT NULL COMMENT 'Nội dung liên hệ',
      `status` enum('pending','read','replied','closed') NOT NULL DEFAULT 'pending' COMMENT 'Trạng thái xử lý',
      `priority` enum('low','normal','high','urgent') NOT NULL DEFAULT 'normal' COMMENT 'Mức độ ưu tiên',
      `reply_message` text NULL COMMENT 'Nội dung phản hồi',
      `replied_by` int(11) NULL COMMENT 'ID admin phản hồi',
      `replied_at` datetime NULL COMMENT 'Thời gian phản hồi',
      `ip_address` varchar(45) NULL COMMENT 'Địa chỉ IP người gửi',
      `user_agent` text NULL COMMENT 'Thông tin trình duyệt',
      `is_read` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Đã đọc chưa',
      `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Thời gian tạo',
      `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Thời gian cập nhật',
      PRIMARY KEY (`id`),
      KEY `idx_status` (`status`),
      KEY `idx_priority` (`priority`),
      KEY `idx_is_read` (`is_read`),
      KEY `idx_created_at` (`created_at`),
      KEY `idx_email` (`email`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Bảng quản lý liên hệ từ khách hàng'
    ";
    
    $conn->exec($createTableSQL);
    echo "<p style='color: green;'>✅ Tạo bảng 'lienhe' thành công!</p>";
    
    // Thêm dữ liệu mẫu
    echo "<h3>Đang thêm dữ liệu mẫu...</h3>";
    
    $sampleData = [
        [
            'name' => 'Nguyễn Văn An',
            'email' => 'an.nguyen@email.com',
            'phone' => '0901234567',
            'subject' => 'Hỏi về sản phẩm',
            'message' => 'Tôi muốn tìm hiểu về sản phẩm XYZ có sẵn không?',
            'status' => 'pending',
            'priority' => 'normal',
            'ip_address' => '192.168.1.100'
        ],
        [
            'name' => 'Trần Thị Bình',
            'email' => 'binh.tran@email.com',
            'phone' => '0987654321',
            'subject' => 'Khiếu nại đơn hàng',
            'message' => 'Đơn hàng #12345 của tôi bị chậm trễ, xin hỗ trợ.',
            'status' => 'read',
            'priority' => 'high',
            'ip_address' => '192.168.1.101'
        ],
        [
            'name' => 'Lê Văn Cường',
            'email' => 'cuong.le@email.com',
            'phone' => '0912345678',
            'subject' => 'Yêu cầu báo giá',
            'message' => 'Có thể gửi báo giá cho số lượng lớn không?',
            'status' => 'replied',
            'priority' => 'normal',
            'ip_address' => '192.168.1.102',
            'reply_message' => 'Cảm ơn anh đã liên hệ. Chúng tôi sẽ gửi báo giá chi tiết qua email trong ngày hôm nay.',
            'replied_by' => 1,
            'replied_at' => '2024-01-13 14:30:00'
        ],
        [
            'name' => 'Phạm Thị Dung',
            'email' => 'dung.pham@email.com',
            'phone' => '0923456789',
            'subject' => 'Hỗ trợ kỹ thuật',
            'message' => 'Sản phẩm bị lỗi sau khi mua 1 tuần.',
            'status' => 'pending',
            'priority' => 'urgent',
            'ip_address' => '192.168.1.103'
        ],
        [
            'name' => 'Hoàng Văn Em',
            'email' => 'em.hoang@email.com',
            'phone' => '0934567890',
            'subject' => 'Góp ý cải thiện',
            'message' => 'Website rất tốt nhưng cần cải thiện tốc độ tải.',
            'status' => 'closed',
            'priority' => 'low',
            'ip_address' => '192.168.1.104'
        ]
    ];
    
    $insertSQL = "INSERT INTO lienhe (name, email, phone, subject, message, status, priority, ip_address, reply_message, replied_by, replied_at, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW() - INTERVAL FLOOR(RAND() * 5) DAY)";
    $stmt = $conn->prepare($insertSQL);
    
    foreach ($sampleData as $data) {
        $stmt->execute([
            $data['name'],
            $data['email'],
            $data['phone'],
            $data['subject'],
            $data['message'],
            $data['status'],
            $data['priority'],
            $data['ip_address'],
            $data['reply_message'] ?? null,
            $data['replied_by'] ?? null,
            $data['replied_at'] ?? null
        ]);
        echo "<p>✅ Thêm liên hệ: " . $data['name'] . "</p>";
    }
    
    // Kiểm tra dữ liệu đã tạo
    $count = $conn->query("SELECT COUNT(*) as total FROM lienhe")->fetch()['total'];
    echo "<h3 style='color: green;'>🎉 Hoàn thành!</h3>";
    echo "<p><strong>Tổng cộng đã tạo: {$count} liên hệ</strong></p>";
    
    // Hiển thị thống kê
    echo "<h3>📊 Thống kê liên hệ:</h3>";
    $stats = $conn->query("
        SELECT 
            status,
            COUNT(*) as count 
        FROM lienhe 
        GROUP BY status
    ")->fetchAll();
    
    echo "<ul>";
    foreach ($stats as $stat) {
        echo "<li><strong>" . ucfirst($stat['status']) . ":</strong> " . $stat['count'] . " liên hệ</li>";
    }
    echo "</ul>";
    
    echo "<hr>";
    echo "<h3>🔗 Liên kết hữu ích:</h3>";
    echo "<ul>";
    echo "<li><a href='index.php?act=lienhe' target='_blank'>📝 Form liên hệ (Client)</a></li>";
    echo "<li><a href='admin/index.php?ctl=lienhe' target='_blank'>⚙️ Quản lý liên hệ (Admin)</a></li>";
    echo "</ul>";
    
    echo "<div style='background: #e8f5e8; padding: 15px; border-radius: 10px; margin-top: 20px;'>";
    echo "<h4>✅ Cài đặt hoàn tất!</h4>";
    echo "<p>Bạn có thể:</p>";
    echo "<ol>";
    echo "<li>Truy cập form liên hệ để test gửi liên hệ mới</li>";
    echo "<li>Vào admin để xem và quản lý các liên hệ</li>";
    echo "<li>Test chức năng phản hồi email</li>";
    echo "<li>Xóa file này sau khi hoàn thành: <code>create_contact_table.php</code></li>";
    echo "</ol>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Lỗi: " . $e->getMessage() . "</p>";
    echo "<p>Chi tiết lỗi:</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>

<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background: #f8f9fa;
}

h2, h3 {
    color: #333;
    border-bottom: 2px solid #007bff;
    padding-bottom: 10px;
}

p {
    margin: 10px 0;
}

pre {
    background: #f1f1f1;
    padding: 10px;
    border-radius: 5px;
    overflow-x: auto;
}

a {
    color: #007bff;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

ul {
    padding-left: 20px;
}

li {
    margin: 5px 0;
}

code {
    background: #f1f1f1;
    padding: 2px 5px;
    border-radius: 3px;
    font-family: 'Courier New', monospace;
}
</style>
