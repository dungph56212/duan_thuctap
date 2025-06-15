<?php
// test_chatbot_analytics_final.php - Kiểm tra trang analytics hoàn chỉnh
require_once './commons/env.php';
require_once './commons/function.php';
require_once './admin/models/AdminBookManager.php';

// Đảm bảo có dữ liệu test
try {
    $conn = connectDB();
    
    // Kiểm tra bảng chat_history
    $checkTable = $conn->query("SHOW TABLES LIKE 'chat_history'");
    if ($checkTable->rowCount() == 0) {
        echo "<h2>❌ Bảng chat_history không tồn tại!</h2>";
        echo "<p>Cần tạo bảng chat_history trước:</p>";
        echo "<pre>
CREATE TABLE chat_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(50),
    user_message TEXT,
    bot_response TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
        </pre>";
        exit;
    }
    
    // Thêm dữ liệu test nếu chưa có
    $countData = $conn->query("SELECT COUNT(*) FROM chat_history")->fetchColumn();
    if ($countData < 5) {
        echo "<h3>🔄 Thêm dữ liệu test...</h3>";
        
        $testData = [
            ['user123', 'Tôi muốn tìm sách về lập trình', 'Chúng tôi có nhiều sách về lập trình như PHP, JavaScript, Python. Bạn quan tâm đến ngôn ngữ nào?'],
            ['user456', 'Có sách nào về JavaScript không?', 'Có, chúng tôi có "JavaScript Căn Bản" và "JavaScript Nâng Cao". Bạn muốn xem chi tiết không?'],
            ['user789', 'Giá sách như thế nào?', 'Giá sách dao động từ 50,000 - 500,000 VNĐ tùy theo từng loại. Bạn có ngân sách bao nhiêu?'],
            ['user123', 'Làm sao để đặt hàng?', 'Bạn có thể thêm sách vào giỏ hàng và tiến hành thanh toán. Chúng tôi hỗ trợ nhiều hình thức thanh toán.'],
            ['user456', 'Có giao hàng tận nơi không?', 'Có, chúng tôi giao hàng toàn quốc. Phí ship từ 15,000 - 30,000 VNĐ tùy khu vực.'],
            ['guest', 'Hello', 'Xin chào! Tôi có thể giúp gì cho bạn?'],
            ['user789', 'Tôi muốn tìm sách về PHP', 'Chúng tôi có "PHP Từ Căn Bản Đến Nâng Cao" và "Laravel Framework". Bạn quan tâm cuốn nào?']
        ];
        
        $stmt = $conn->prepare("INSERT INTO chat_history (user_id, user_message, bot_response, created_at) VALUES (?, ?, ?, ?)");
        
        foreach ($testData as $i => $data) {
            $created_at = date('Y-m-d H:i:s', strtotime("-" . rand(0, 168) . " hours")); // Random trong 7 ngày
            $stmt->execute([$data[0], $data[1], $data[2], $created_at]);
        }
        
        echo "<p>✅ Đã thêm " . count($testData) . " dữ liệu test</p>";
    }
    
    echo "<h1>🧪 Test Chatbot Analytics</h1>";
    
    // Test model
    $model = new AdminBookManager();
    
    echo "<h2>📊 Test Statistics</h2>";
    $stats = $model->getChatbotStats();
    echo "<pre>" . print_r($stats, true) . "</pre>";
    
    echo "<h2>💬 Test Recent Chats</h2>";
    $recentChats = $model->getRecentChats(10);
    echo "<p>Số lượng: " . count($recentChats) . "</p>";
    
    if (!empty($recentChats)) {
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr><th>User ID</th><th>Message Type</th><th>Message</th><th>Response Time</th><th>Created At</th></tr>";
        
        foreach (array_slice($recentChats, 0, 5) as $chat) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($chat['user_id'] ?? 'N/A') . "</td>";
            echo "<td>" . htmlspecialchars($chat['message_type'] ?? 'N/A') . "</td>";
            echo "<td>" . htmlspecialchars(substr($chat['message'] ?? 'N/A', 0, 50)) . "...</td>";
            echo "<td>" . htmlspecialchars($chat['response_time'] ?? 'N/A') . "</td>";
            echo "<td>" . htmlspecialchars($chat['created_at'] ?? 'N/A') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    echo "<h2>🔥 Test Popular Queries</h2>";
    $popularQueries = $model->getPopularQueries();
    echo "<p>Số lượng: " . count($popularQueries) . "</p>";
    
    if (!empty($popularQueries)) {
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr><th>Message</th><th>Count</th><th>Percentage</th></tr>";
        
        foreach ($popularQueries as $query) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars(substr($query['message'] ?? 'N/A', 0, 50)) . "...</td>";
            echo "<td>" . (int)($query['count'] ?? 0) . "</td>";
            echo "<td>" . number_format($query['percentage'] ?? 0, 1) . "%</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    echo "<h2>🎯 Test Analytics Page</h2>";
    echo "<p><a href='admin/?act=chatbot-analytics' target='_blank' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>➡️ Mở trang Analytics</a></p>";
    
    echo "<h2>✅ Tất cả test đã hoàn thành!</h2>";
    echo "<p style='color: green; font-weight: bold;'>Nếu không có lỗi ở trên, trang analytics sẽ hoạt động bình thường.</p>";
    
    // Hiển thị SQL debug
    echo "<h3>🔍 Debug SQL Tables</h3>";
    $tables = $conn->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "<p>Các bảng có sẵn: " . implode(', ', $tables) . "</p>";
    
    $chatCount = $conn->query("SELECT COUNT(*) FROM chat_history")->fetchColumn();
    echo "<p>Tổng số record trong chat_history: " . $chatCount . "</p>";
    
} catch (Exception $e) {
    echo "<h2>❌ Lỗi: " . $e->getMessage() . "</h2>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>
