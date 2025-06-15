<?php
// Kiểm tra đơn giản bảng lienhe
require_once 'commons/function.php';

try {
    $conn = connectDB();
    
    echo "<h2>🔍 Kiểm tra bảng lienhe</h2>";
    
    // Kiểm tra bảng có tồn tại không
    $result = $conn->query("SHOW TABLES LIKE 'lienhe'");
    if ($result->rowCount() == 0) {
        echo "<p style='color: red;'>❌ Bảng 'lienhe' không tồn tại!</p>";
        
        // Tạo bảng đầy đủ
        echo "<p>🔧 Tạo bảng mới...</p>";
        $sql = "
        CREATE TABLE lienhe (
            id int(11) PRIMARY KEY AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            email varchar(255) NOT NULL,
            phone varchar(20),
            subject varchar(500),
            message text NOT NULL,
            status enum('pending','read','replied','closed') DEFAULT 'pending',
            priority enum('low','normal','high','urgent') DEFAULT 'normal',
            reply_message text,
            replied_by int(11),
            replied_at datetime,
            ip_address varchar(45),
            user_agent text,
            is_read tinyint(1) DEFAULT 0,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        
        $conn->exec($sql);
        echo "<p style='color: green;'>✅ Tạo bảng thành công!</p>";
        
    } else {
        echo "<p>📋 Bảng tồn tại. Kiểm tra cấu trúc:</p>";
        
        // Xem cấu trúc hiện tại
        $desc = $conn->query("DESCRIBE lienhe");
        echo "<table border='1'>";
        echo "<tr><th>Cột</th><th>Kiểu</th><th>Null</th><th>Default</th></tr>";
        $columns = [];
        while ($row = $desc->fetch()) {
            $columns[] = $row['Field'];
            echo "<tr><td>{$row['Field']}</td><td>{$row['Type']}</td><td>{$row['Null']}</td><td>{$row['Default']}</td></tr>";
        }
        echo "</table>";
        
        // Kiểm tra cột status
        if (!in_array('status', $columns)) {
            echo "<p style='color: red;'>❌ Thiếu cột 'status'!</p>";
            echo "<p>🔧 Thêm cột status...</p>";
            $conn->exec("ALTER TABLE lienhe ADD COLUMN status enum('pending','read','replied','closed') DEFAULT 'pending' AFTER message");
            echo "<p style='color: green;'>✅ Đã thêm cột status!</p>";
        }
        
        // Kiểm tra các cột khác
        $requiredCols = ['priority', 'reply_message', 'replied_by', 'replied_at', 'ip_address', 'user_agent', 'is_read'];
        foreach ($requiredCols as $col) {
            if (!in_array($col, $columns)) {
                echo "<p style='color: orange;'>⚠️ Thiếu cột '$col'</p>";
                
                switch ($col) {
                    case 'priority':
                        $conn->exec("ALTER TABLE lienhe ADD COLUMN priority enum('low','normal','high','urgent') DEFAULT 'normal' AFTER status");
                        break;
                    case 'reply_message':
                        $conn->exec("ALTER TABLE lienhe ADD COLUMN reply_message text AFTER priority");
                        break;
                    case 'replied_by':
                        $conn->exec("ALTER TABLE lienhe ADD COLUMN replied_by int(11) AFTER reply_message");
                        break;
                    case 'replied_at':
                        $conn->exec("ALTER TABLE lienhe ADD COLUMN replied_at datetime AFTER replied_by");
                        break;
                    case 'ip_address':
                        $conn->exec("ALTER TABLE lienhe ADD COLUMN ip_address varchar(45) AFTER replied_at");
                        break;
                    case 'user_agent':
                        $conn->exec("ALTER TABLE lienhe ADD COLUMN user_agent text AFTER ip_address");
                        break;
                    case 'is_read':
                        $conn->exec("ALTER TABLE lienhe ADD COLUMN is_read tinyint(1) DEFAULT 0 AFTER user_agent");
                        break;
                }
                echo "<p style='color: green;'>✅ Đã thêm cột '$col'!</p>";
            }
        }
    }
    
    // Thêm dữ liệu mẫu nếu bảng trống
    $count = $conn->query("SELECT COUNT(*) FROM lienhe")->fetchColumn();
    if ($count == 0) {
        echo "<p>📊 Thêm dữ liệu mẫu...</p>";
        $conn->exec("
            INSERT INTO lienhe (name, email, subject, message, status, priority) VALUES 
            ('Nguyễn Văn A', 'a@test.com', 'Test liên hệ', 'Nội dung test', 'pending', 'normal'),
            ('Trần Thị B', 'b@test.com', 'Khiếu nại', 'Sản phẩm lỗi', 'read', 'high'),
            ('Lê Văn C', 'c@test.com', 'Hỏi giá', 'Báo giá sản phẩm', 'replied', 'normal')
        ");
        echo "<p style='color: green;'>✅ Đã thêm 3 bản ghi mẫu!</p>";
    }
    
    // Kiểm tra cuối cùng
    echo "<h3>📊 Trạng thái cuối cùng:</h3>";
    $finalCheck = $conn->query("SELECT COUNT(*) as total, 
                                     SUM(CASE WHEN status='pending' THEN 1 ELSE 0 END) as pending,
                                     SUM(CASE WHEN status='read' THEN 1 ELSE 0 END) as read_count,
                                     SUM(CASE WHEN status='replied' THEN 1 ELSE 0 END) as replied
                                FROM lienhe")->fetch();
    
    echo "<ul>";
    echo "<li>Tổng: {$finalCheck['total']}</li>";
    echo "<li>Chờ xử lý: {$finalCheck['pending']}</li>";
    echo "<li>Đã đọc: {$finalCheck['read_count']}</li>";
    echo "<li>Đã phản hồi: {$finalCheck['replied']}</li>";
    echo "</ul>";
    
    echo "<div style='background: #d4edda; padding: 15px; margin-top: 20px; border-radius: 5px;'>";
    echo "<h4>✅ Hoàn thành!</h4>";
    echo "<p>Bảng đã sẵn sàng. Thử các link:</p>";
    echo "<ul>";
    echo "<li><a href='admin/index.php?ctl=lienhe' target='_blank'>Admin: Quản lý liên hệ</a></li>";
    echo "<li><a href='index.php?act=lienhe' target='_blank'>Client: Form liên hệ</a></li>";
    echo "</ul>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div style='background: #f8d7da; padding: 15px; border-radius: 5px; color: #721c24;'>";
    echo "<h3>❌ Lỗi: " . $e->getMessage() . "</h3>";
    echo "<p>File: " . $e->getFile() . " (Dòng " . $e->getLine() . ")</p>";
    echo "</div>";
}
?>

<style>
body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
table { border-collapse: collapse; width: 100%; margin: 10px 0; }
th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
th { background-color: #f2f2f2; }
a { color: #007bff; text-decoration: none; }
a:hover { text-decoration: underline; }
</style>
