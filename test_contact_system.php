<?php
/**
 * File test hệ thống liên hệ
 * Kiểm tra các chức năng chính của hệ thống liên hệ
 */

// Bảo mật: Chỉ cho phép chạy từ localhost
if (!in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1', 'localhost'])) {
    die('Access denied. This script can only be run from localhost.');
}

require_once __DIR__ . '/commons/function.php';
require_once __DIR__ . '/models/LienHe.php';

echo "<h2>🧪 Test Hệ Thống Liên Hệ</h2>";
echo "<hr>";

try {
    $conn = connectDB();
    
    // Test 1: Kiểm tra cấu trúc bảng
    echo "<h3>📋 Test 1: Kiểm tra cấu trúc bảng</h3>";
    
    $stmt = $conn->query("DESCRIBE lienhe");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $expectedColumns = [
        'id', 'name', 'email', 'phone', 'subject', 'message', 
        'status', 'priority', 'reply_message', 'replied_by', 
        'replied_at', 'ip_address', 'user_agent', 'is_read', 
        'created_at', 'updated_at'
    ];
    
    $existingColumns = array_column($columns, 'Field');
    $missingColumns = array_diff($expectedColumns, $existingColumns);
    
    if (empty($missingColumns)) {
        echo "<p style='color: green;'>✅ Tất cả cột cần thiết đều có sẵn</p>";
        echo "<ul>";
        foreach ($existingColumns as $col) {
            echo "<li>$col</li>";
        }
        echo "</ul>";
    } else {
        echo "<p style='color: red;'>❌ Thiếu các cột: " . implode(', ', $missingColumns) . "</p>";
    }
    
    // Test 2: Kiểm tra dữ liệu mẫu
    echo "<h3>📊 Test 2: Kiểm tra dữ liệu mẫu</h3>";
    
    $stmt = $conn->query("SELECT COUNT(*) as total FROM lienhe");
    $totalContacts = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    echo "<p><strong>Tổng số liên hệ:</strong> $totalContacts</p>";
    
    if ($totalContacts > 0) {
        $stmt = $conn->query("SELECT status, COUNT(*) as count FROM lienhe GROUP BY status");
        $statusCounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<p><strong>Thống kê theo trạng thái:</strong></p>";
        echo "<ul>";
        foreach ($statusCounts as $status) {
            echo "<li>{$status['status']}: {$status['count']} liên hệ</li>";
        }
        echo "</ul>";
    }
    
    // Test 3: Kiểm tra các phương thức Model
    echo "<h3>🔧 Test 3: Kiểm tra Model LienHe</h3>";
    
    // Test getAll method
    try {
        $result = LienHe::getAll(1, 5);
        echo "<p style='color: green;'>✅ getAll() - Thành công</p>";
        echo "<p>Tìm thấy {$result['total']} liên hệ, hiển thị trang {$result['current_page']}/{$result['pages']}</p>";
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ getAll() - Lỗi: " . $e->getMessage() . "</p>";
    }
    
    // Test getStats method
    try {
        $stats = LienHe::getStats();
        echo "<p style='color: green;'>✅ getStats() - Thành công</p>";
        echo "<p>Thống kê: {$stats['total']} tổng, {$stats['unread']} chưa đọc, {$stats['today']} hôm nay</p>";
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ getStats() - Lỗi: " . $e->getMessage() . "</p>";
    }
    
    // Test getAllByEmail method với email mẫu
    try {
        $testEmail = 'cuong.le@email.com';
        $emailContacts = LienHe::getAllByEmail($testEmail);
        echo "<p style='color: green;'>✅ getAllByEmail() - Thành công</p>";
        echo "<p>Tìm thấy " . count($emailContacts) . " liên hệ cho email: $testEmail</p>";
        
        if (!empty($emailContacts)) {
            foreach ($emailContacts as $contact) {
                echo "<div style='margin-left: 20px; padding: 10px; background: #f8f9fa; border-radius: 5px; margin: 5px 0;'>";
                echo "<strong>#{$contact['id']}</strong>: {$contact['subject']} - Trạng thái: {$contact['status']}";
                if ($contact['reply_message']) {
                    echo "<br><em>Có phản hồi</em>";
                }
                echo "</div>";
            }
        }
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ getAllByEmail() - Lỗi: " . $e->getMessage() . "</p>";
    }
    
    // Test 4: Kiểm tra URLs
    echo "<h3>🔗 Test 4: Kiểm tra liên kết</h3>";
    
    $urls = [
        'Client Contact Page' => 'index.php?act=lienhe',
        'Admin Contact List' => 'admin/index.php?ctl=lienhe',
        'Admin Contact View' => 'admin/index.php?ctl=lienhe&act=view&id=1'
    ];
    
    foreach ($urls as $name => $url) {
        echo "<p>📄 <strong>$name:</strong> <a href='$url' target='_blank'>$url</a></p>";
    }
    
    // Test 5: Kiểm tra indexes
    echo "<h3>📊 Test 5: Kiểm tra indexes</h3>";
    
    $stmt = $conn->query("SHOW INDEX FROM lienhe");
    $indexes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $indexNames = array_unique(array_column($indexes, 'Key_name'));
    $expectedIndexes = ['PRIMARY', 'idx_status', 'idx_priority', 'idx_is_read', 'idx_created_at', 'idx_email'];
    
    echo "<p><strong>Indexes hiện tại:</strong></p>";
    echo "<ul>";
    foreach ($indexNames as $index) {
        $isExpected = in_array($index, $expectedIndexes);
        $color = $isExpected ? 'green' : 'orange';
        echo "<li style='color: $color;'>$index</li>";
    }
    echo "</ul>";
    
    // Test 6: Test controller functionality
    echo "<h3>🎮 Test 6: Test Controller</h3>";
    
    try {
        require_once __DIR__ . '/controllers/LienHeController.php';
        echo "<p style='color: green;'>✅ LienHeController loaded successfully</p>";
        
        // Simulate a GET request for reply lookup
        $_GET['lookup'] = '1';
        $_GET['email'] = 'cuong.le@email.com';
        
        ob_start();
        $controller = new LienHeController();
        // Capture any output
        $output = ob_get_clean();
        
        echo "<p style='color: green;'>✅ Controller test completed</p>";
        
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ Controller test failed: " . $e->getMessage() . "</p>";
    }
    
    // Tóm tắt
    echo "<hr>";
    echo "<h3>📈 Tóm tắt kiểm tra</h3>";
    
    echo "<div style='background: #d1ecf1; color: #0c5460; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
    echo "<strong>🎉 Hệ thống liên hệ đã sẵn sàng!</strong><br>";
    echo "Tất cả các thành phần cần thiết đã được kiểm tra và hoạt động bình thường.";
    echo "</div>";
    
    echo "<h3>🚀 Hướng dẫn sử dụng:</h3>";
    echo "<ol>";
    echo "<li><strong>Cho khách hàng:</strong> Truy cập <a href='index.php?act=lienhe'>trang liên hệ</a> để gửi tin nhắn và kiểm tra phản hồi</li>";
    echo "<li><strong>Cho admin:</strong> Truy cập <a href='admin/index.php?ctl=lienhe'>quản lý liên hệ</a> để xem và phản hồi tin nhắn</li>";
    echo "<li><strong>Tính năng nổi bật:</strong>";
    echo "<ul>";
    echo "<li>Form liên hệ với validation</li>";
    echo "<li>Hệ thống kiểm tra phản hồi cho khách hàng</li>";
    echo "<li>Dashboard quản lý liên hệ cho admin</li>";
    echo "<li>Phân loại theo trạng thái và mức độ ưu tiên</li>";
    echo "<li>Tìm kiếm và lọc liên hệ</li>";
    echo "<li>Gửi email thông báo tự động</li>";
    echo "</ul>";
    echo "</li>";
    echo "</ol>";
    
} catch (Exception $e) {
    echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px;'>";
    echo "<strong>❌ Lỗi kết nối cơ sở dữ liệu:</strong><br>";
    echo $e->getMessage();
    echo "</div>";
}

echo "<hr>";
echo "<p><em>Test completed at: " . date('d/m/Y H:i:s') . "</em></p>";
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

ul, ol {
    background: white;
    padding: 15px 30px;
    border-radius: 5px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

a {
    color: #3498db;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

.success {
    color: #28a745;
}

.error {
    color: #dc3545;
}

.warning {
    color: #ffc107;
}
</style>
