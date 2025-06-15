<?php
// File kiểm tra và sửa cấu trúc bảng liên hệ
// Chạy file này qua trình duyệt: http://localhost/duan_thuctap/fix_lienhe_table.php

require_once 'commons/function.php';

try {
    $conn = connectDB();
    
    echo "<h2>🔍 Kiểm tra cấu trúc bảng liên hệ</h2>";
    
    // Kiểm tra xem bảng lienhe có tồn tại không
    $checkTable = $conn->query("SHOW TABLES LIKE 'lienhe'");
    
    if ($checkTable->rowCount() == 0) {
        echo "<p style='color: red;'>❌ Bảng 'lienhe' chưa tồn tại!</p>";
        echo "<p>🔧 Đang tạo bảng mới...</p>";
        
        // Tạo bảng mới
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
        
    } else {
        echo "<p style='color: blue;'>📋 Bảng 'lienhe' đã tồn tại. Đang kiểm tra cấu trúc...</p>";
        
        // Kiểm tra cấu trúc bảng hiện tại
        $describeTable = $conn->query("DESCRIBE lienhe");
        $currentColumns = $describeTable->fetchAll(PDO::FETCH_COLUMN);
        
        echo "<h3>Cột hiện tại trong bảng:</h3>";
        echo "<ul>";
        foreach ($currentColumns as $column) {
            echo "<li>$column</li>";
        }
        echo "</ul>";
        
        // Kiểm tra các cột cần thiết
        $requiredColumns = [
            'id', 'name', 'email', 'phone', 'subject', 'message', 
            'status', 'priority', 'reply_message', 'replied_by', 
            'replied_at', 'ip_address', 'user_agent', 'is_read', 
            'created_at', 'updated_at'
        ];
        
        $missingColumns = array_diff($requiredColumns, $currentColumns);
        
        if (!empty($missingColumns)) {
            echo "<h3 style='color: orange;'>⚠️ Các cột bị thiếu:</h3>";
            echo "<ul>";
            foreach ($missingColumns as $column) {
                echo "<li style='color: red;'>$column</li>";
            }
            echo "</ul>";
            
            echo "<p>🔧 Đang thêm các cột bị thiếu...</p>";
            
            // Thêm các cột bị thiếu
            $alterQueries = [];
            
            if (in_array('phone', $missingColumns)) {
                $alterQueries[] = "ALTER TABLE lienhe ADD COLUMN phone varchar(20) NULL COMMENT 'Số điện thoại' AFTER email";
            }
            
            if (in_array('subject', $missingColumns)) {
                $alterQueries[] = "ALTER TABLE lienhe ADD COLUMN subject varchar(500) NULL COMMENT 'Tiêu đề liên hệ' AFTER phone";
            }
            
            if (in_array('status', $missingColumns)) {
                $alterQueries[] = "ALTER TABLE lienhe ADD COLUMN status enum('pending','read','replied','closed') NOT NULL DEFAULT 'pending' COMMENT 'Trạng thái xử lý' AFTER message";
            }
            
            if (in_array('priority', $missingColumns)) {
                $alterQueries[] = "ALTER TABLE lienhe ADD COLUMN priority enum('low','normal','high','urgent') NOT NULL DEFAULT 'normal' COMMENT 'Mức độ ưu tiên' AFTER status";
            }
            
            if (in_array('reply_message', $missingColumns)) {
                $alterQueries[] = "ALTER TABLE lienhe ADD COLUMN reply_message text NULL COMMENT 'Nội dung phản hồi' AFTER priority";
            }
            
            if (in_array('replied_by', $missingColumns)) {
                $alterQueries[] = "ALTER TABLE lienhe ADD COLUMN replied_by int(11) NULL COMMENT 'ID admin phản hồi' AFTER reply_message";
            }
            
            if (in_array('replied_at', $missingColumns)) {
                $alterQueries[] = "ALTER TABLE lienhe ADD COLUMN replied_at datetime NULL COMMENT 'Thời gian phản hồi' AFTER replied_by";
            }
            
            if (in_array('ip_address', $missingColumns)) {
                $alterQueries[] = "ALTER TABLE lienhe ADD COLUMN ip_address varchar(45) NULL COMMENT 'Địa chỉ IP người gửi' AFTER replied_at";
            }
            
            if (in_array('user_agent', $missingColumns)) {
                $alterQueries[] = "ALTER TABLE lienhe ADD COLUMN user_agent text NULL COMMENT 'Thông tin trình duyệt' AFTER ip_address";
            }
            
            if (in_array('is_read', $missingColumns)) {
                $alterQueries[] = "ALTER TABLE lienhe ADD COLUMN is_read tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Đã đọc chưa' AFTER user_agent";
            }
            
            if (in_array('updated_at', $missingColumns)) {
                $alterQueries[] = "ALTER TABLE lienhe ADD COLUMN updated_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Thời gian cập nhật' AFTER created_at";
            }
            
            // Thực thi các câu lệnh ALTER
            foreach ($alterQueries as $query) {
                try {
                    $conn->exec($query);
                    echo "<p style='color: green;'>✅ " . substr($query, 0, 50) . "...</p>";
                } catch (Exception $e) {
                    echo "<p style='color: red;'>❌ Lỗi: " . $e->getMessage() . "</p>";
                }
            }
            
            // Thêm indexes
            $indexQueries = [
                "ALTER TABLE lienhe ADD INDEX idx_status (status)",
                "ALTER TABLE lienhe ADD INDEX idx_priority (priority)",
                "ALTER TABLE lienhe ADD INDEX idx_is_read (is_read)",
                "ALTER TABLE lienhe ADD INDEX idx_created_at (created_at)",
                "ALTER TABLE lienhe ADD INDEX idx_email (email)"
            ];
            
            echo "<p>🔧 Đang thêm indexes...</p>";
            foreach ($indexQueries as $query) {
                try {
                    $conn->exec($query);
                    echo "<p style='color: green;'>✅ Index được thêm</p>";
                } catch (Exception $e) {
                    // Bỏ qua lỗi nếu index đã tồn tại
                    if (strpos($e->getMessage(), "Duplicate key name") === false) {
                        echo "<p style='color: orange;'>⚠️ Index: " . $e->getMessage() . "</p>";
                    }
                }
            }
            
        } else {
            echo "<p style='color: green;'>✅ Bảng có đầy đủ các cột cần thiết!</p>";
        }
    }
    
    // Kiểm tra dữ liệu hiện tại
    echo "<h3>📊 Kiểm tra dữ liệu hiện tại:</h3>";
    $countResult = $conn->query("SELECT COUNT(*) as total FROM lienhe");
    $totalRecords = $countResult->fetch()['total'];
    
    if ($totalRecords == 0) {
        echo "<p style='color: orange;'>⚠️ Bảng chưa có dữ liệu. Đang thêm dữ liệu mẫu...</p>";
        
        // Thêm dữ liệu mẫu
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
    } else {
        echo "<p style='color: green;'>✅ Bảng đã có $totalRecords bản ghi</p>";
    }
    
    // Kiểm tra cấu trúc cuối cùng
    echo "<h3>📋 Cấu trúc bảng cuối cùng:</h3>";
    $finalStructure = $conn->query("DESCRIBE lienhe");
    echo "<table border='1' cellpadding='5' cellspacing='0' style='border-collapse: collapse;'>";
    echo "<tr><th>Cột</th><th>Kiểu dữ liệu</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    while ($row = $finalStructure->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $row['Field'] . "</td>";
        echo "<td>" . $row['Type'] . "</td>";
        echo "<td>" . $row['Null'] . "</td>";
        echo "<td>" . $row['Key'] . "</td>";
        echo "<td>" . $row['Default'] . "</td>";
        echo "<td>" . $row['Extra'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<div style='background: #e8f5e8; padding: 15px; border-radius: 10px; margin-top: 20px;'>";
    echo "<h3>🎉 Hoàn thành!</h3>";
    echo "<p>Bảng liên hệ đã được cấu hình đúng cách. Bạn có thể:</p>";
    echo "<ul>";
    echo "<li><a href='index.php?act=lienhe' target='_blank'>📝 Test form liên hệ (Client)</a></li>";
    echo "<li><a href='admin/index.php?ctl=lienhe' target='_blank'>⚙️ Quản lý liên hệ (Admin)</a></li>";
    echo "</ul>";
    echo "<p><small>Bạn có thể xóa file này sau khi hoàn thành: <code>fix_lienhe_table.php</code></small></p>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div style='color: red; border: 2px solid red; padding: 15px; border-radius: 5px;'>";
    echo "<h3>❌ Lỗi nghiêm trọng!</h3>";
    echo "<p><strong>Lỗi:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>File:</strong> " . $e->getFile() . "</p>";
    echo "<p><strong>Dòng:</strong> " . $e->getLine() . "</p>";
    echo "<details>";
    echo "<summary>Chi tiết Stack Trace</summary>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
    echo "</details>";
    echo "</div>";
}
?>

<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;
    background: #f8f9fa;
    line-height: 1.6;
}

h2, h3 {
    color: #333;
    border-bottom: 2px solid #007bff;
    padding-bottom: 10px;
}

table {
    width: 100%;
    margin: 10px 0;
    background: white;
}

table th {
    background: #007bff;
    color: white;
    padding: 8px;
}

table td {
    padding: 6px;
}

table tr:nth-child(even) {
    background: #f8f9fa;
}

p {
    margin: 8px 0;
}

ul {
    padding-left: 25px;
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

a {
    color: #007bff;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

details {
    margin-top: 10px;
}

summary {
    cursor: pointer;
    font-weight: bold;
    padding: 5px;
    background: #f1f1f1;
    border-radius: 3px;
}

pre {
    background: #f8f9fa;
    padding: 10px;
    border-radius: 5px;
    overflow-x: auto;
    font-size: 12px;
}
</style>
