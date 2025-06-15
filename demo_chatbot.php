<?php
// demo_chatbot.php - Demo nhanh chatbot
session_start();
require_once 'commons/env.php';
require_once 'commons/function.php';
require_once 'models/ChatBot.php';

$chatBot = new ChatBot();

// Test các chức năng cơ bản
echo "<h1>🤖 Demo ChatBot AI</h1>";

echo "<h2>1. Test Database Connection</h2>";
try {
    $conn = connectDB();
    echo "✅ Database kết nối thành công!<br>";
    
    // Check if tables exist
    $tables = ['chat_history', 'chatbot_settings'];
    foreach ($tables as $table) {
        $stmt = $conn->prepare("SHOW TABLES LIKE '$table'");
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            echo "✅ Bảng '$table' đã tồn tại<br>";
        } else {
            echo "❌ Bảng '$table' chưa tồn tại - Cần chạy setup_chatbot_database.php<br>";
        }
    }
} catch (Exception $e) {
    echo "❌ Lỗi database: " . $e->getMessage() . "<br>";
}

echo "<h2>2. Test ChatBot Responses</h2>";
$testMessages = [
    'Xin chào',
    'Sản phẩm có gì?',
    'Giá bao nhiều?',
    'Giao hàng như thế nào?',
    'Khuyến mãi',
    'Cảm ơn',
    'Test message không có trong pattern'
];

foreach ($testMessages as $message) {
    $response = $chatBot->getResponse($message);
    echo "<div style='margin: 10px 0; padding: 10px; border: 1px solid #ddd; border-radius: 5px;'>";
    echo "<strong>Người dùng:</strong> $message<br>";
    echo "<strong>Bot:</strong> " . substr($response, 0, 100) . "...<br>";
    echo "</div>";
}

echo "<h2>3. Test Save & Retrieve Messages</h2>";
$sessionId = 'test_' . time();
$userId = 0; // guest user

// Save test message
$saved = $chatBot->saveMessage($userId, 'Test message', 'Test response', $sessionId);
if ($saved) {
    echo "✅ Lưu tin nhắn thành công (ID: $saved)<br>";
    
    // Retrieve messages
    $history = $chatBot->getChatHistory($userId, $sessionId, 10);
    echo "✅ Lấy lịch sử thành công (" . count($history) . " tin nhắn)<br>";
    
    if (!empty($history)) {
        echo "<div style='background: #f5f5f5; padding: 10px; margin: 10px 0;'>";
        foreach ($history as $chat) {
            echo "<div><strong>User:</strong> " . $chat['user_message'] . "</div>";
            echo "<div><strong>Bot:</strong> " . $chat['bot_response'] . "</div>";
            echo "<div><small>Time: " . $chat['created_at'] . "</small></div><hr>";
        }
        echo "</div>";
    }
} else {
    echo "❌ Lưu tin nhắn thất bại<br>";
}

echo "<h2>4. Test Statistics</h2>";
$stats = $chatBot->getChatStats();
if (!empty($stats)) {
    echo "✅ Lấy thống kê thành công:<br>";
    echo "<ul>";
    foreach ($stats as $key => $value) {
        echo "<li><strong>$key:</strong> $value</li>";
    }
    echo "</ul>";
} else {
    echo "❌ Không thể lấy thống kê<br>";
}

echo "<h2>5. Test Cleanup</h2>";
// Test cleanup (với 0 ngày để xóa tất cả)
$cleaned = $chatBot->cleanupOldChats(0);
if ($cleaned !== false) {
    echo "✅ Cleanup thành công - Đã xóa $cleaned tin nhắn cũ<br>";
} else {
    echo "❌ Cleanup thất bại<br>";
}

echo "<hr>";
echo "<h2>🔗 Links</h2>";
echo "<a href='test_chatbot.php' style='margin-right: 10px;'>📊 Test Interface</a>";
echo "<a href='setup_chatbot_database.php' style='margin-right: 10px;'>🔧 Setup Database</a>";
echo "<a href='?act=chatbot-test' style='margin-right: 10px;'>🌐 Test API</a>";
echo "<a href='.' style='margin-right: 10px;'>🏠 Trang chủ</a>";

echo "<hr>";
echo "<p><em>Demo hoàn thành! Kiểm tra các ✅ và ❌ ở trên để đảm bảo hệ thống hoạt động tốt.</em></p>";
?>
