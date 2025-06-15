<?php
session_start();
require_once './commons/env.php';
require_once './commons/function.php';

echo "<h1>Thêm Dữ Liệu Mẫu Cho Chatbot</h1>";

try {
    $conn = connectDB();
    
    // Kiểm tra bảng chat_history có tồn tại không
    $checkTable = $conn->query("SHOW TABLES LIKE 'chat_history'");
    if ($checkTable->rowCount() == 0) {
        echo "<p>Tạo bảng chat_history...</p>";
        $createTable = "
        CREATE TABLE chat_history (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NULL,
            user_message TEXT NOT NULL,
            bot_response TEXT NOT NULL,
            session_id VARCHAR(255) NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $conn->exec($createTable);
        echo "<p>✅ Đã tạo bảng chat_history!</p>";
    } else {
        echo "<p>✅ Bảng chat_history đã tồn tại!</p>";
    }
    
    // Thêm dữ liệu mẫu
    $sampleData = [
        [
            'user_id' => 1,
            'user_message' => 'Xin chào, tôi muốn tìm sách về lập trình',
            'bot_response' => 'Chào bạn! Tôi có thể giúp bạn tìm sách về lập trình. Bạn quan tâm đến ngôn ngữ lập trình nào?'
        ],
        [
            'user_id' => 2,
            'user_message' => 'Có sách tiếng Anh nào hay không?',
            'bot_response' => 'Có rất nhiều sách tiếng Anh hay tại cửa hàng. Bạn muốn tìm thể loại nào? Văn học, khoa học, kinh doanh?'
        ],
        [
            'user_id' => null,
            'user_message' => 'Giá sách như thế nào?',
            'bot_response' => 'Giá sách rất đa dạng, từ 50,000đ đến 500,000đ tùy theo loại sách. Bạn có ngân sách cụ thể nào không?'
        ],
        [
            'user_id' => 1,
            'user_message' => 'Tôi muốn mua sách PHP',
            'bot_response' => 'Tuyệt vời! Chúng tôi có nhiều sách về PHP từ cơ bản đến nâng cao. Tôi sẽ tìm cho bạn những cuốn phù hợp nhất.'
        ],
        [
            'user_id' => 3,
            'user_message' => 'Làm sao để đặt hàng?',
            'bot_response' => 'Để đặt hàng, bạn có thể: 1) Thêm sách vào giỏ hàng, 2) Điền thông tin giao hàng, 3) Chọn phương thức thanh toán. Rất đơn giản!'
        ],
        [
            'user_id' => null,
            'user_message' => 'Có giao hàng tận nơi không?',
            'bot_response' => 'Có ạ! Chúng tôi có dịch vụ giao hàng tận nơi trong vòng 2-3 ngày làm việc. Phí ship chỉ từ 20,000đ.'
        ],
        [
            'user_id' => 2,
            'user_message' => 'Sách có bảo hành không?',
            'bot_response' => 'Sách có chính sách đổi trả trong 7 ngày nếu có lỗi từ nhà sản xuất. Chúng tôi cam kết chất lượng sản phẩm!'
        ],
        [
            'user_id' => 4,
            'user_message' => 'Tôi cần tư vấn sách cho trẻ em',
            'bot_response' => 'Tuyệt vời! Bạn có thể cho biết độ tuổi của bé không? Chúng tôi có nhiều sách phù hợp cho từng lứa tuổi.'
        ]
    ];
    
    // Xóa dữ liệu cũ (nếu có)
    $conn->exec("DELETE FROM chat_history WHERE user_message LIKE '%lập trình%' OR user_message LIKE '%tiếng Anh%'");
    
    echo "<p>Đang thêm " . count($sampleData) . " tin nhắn mẫu...</p>";
    
    $insertSQL = "INSERT INTO chat_history (user_id, user_message, bot_response, session_id, created_at) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertSQL);
    
    $count = 0;
    foreach ($sampleData as $data) {
        $sessionId = 'session_' . rand(1000, 9999);
        $createdAt = date('Y-m-d H:i:s', strtotime('-' . rand(1, 30) . ' days -' . rand(0, 23) . ' hours -' . rand(0, 59) . ' minutes'));
        
        $stmt->execute([
            $data['user_id'],
            $data['user_message'],
            $data['bot_response'],
            $sessionId,
            $createdAt
        ]);
        $count++;
    }
    
    echo "<p>✅ Đã thêm thành công $count tin nhắn mẫu!</p>";
    
    // Hiển thị thống kê
    $totalChats = $conn->query("SELECT COUNT(*) FROM chat_history")->fetchColumn();
    $totalUsers = $conn->query("SELECT COUNT(DISTINCT user_id) FROM chat_history WHERE user_id IS NOT NULL")->fetchColumn();
    $todayChats = $conn->query("SELECT COUNT(*) FROM chat_history WHERE DATE(created_at) = CURDATE()")->fetchColumn();
    
    echo "<h2>📊 Thống Kê Chat Hiện Tại:</h2>";
    echo "<ul>";
    echo "<li>Tổng số tin nhắn: <strong>$totalChats</strong></li>";
    echo "<li>Số người dùng đã chat: <strong>$totalUsers</strong></li>";
    echo "<li>Tin nhắn hôm nay: <strong>$todayChats</strong></li>";
    echo "</ul>";
    
    echo "<h2>🎉 Hoàn thành!</h2>";
    echo "<p>Bây giờ bạn có thể truy cập trang analytics để xem dữ liệu:</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Lỗi: " . $e->getMessage() . "</p>";
}
?>

<style>
body {
    font-family: Arial, sans-serif;
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    line-height: 1.6;
}
h1, h2 {
    color: #333;
    border-bottom: 2px solid #007bff;
    padding-bottom: 10px;
}
ul {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 5px;
}
.btn {
    display: inline-block;
    padding: 10px 20px;
    background: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    margin: 5px;
}
.btn:hover {
    background: #0056b3;
    color: white;
}
</style>

<div style="text-align: center; margin-top: 30px;">
    <a href="admin/?act=thong-ke-chatbot" class="btn">📊 Xem Chatbot Analytics</a>
    <a href="test_chatbot_fix.php" class="btn">🧪 Test Chatbot Fix</a>
    <a href="?" class="btn">🏠 Về Trang Chủ</a>
</div>
