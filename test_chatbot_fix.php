<?php
session_start();
require_once '../commons/env.php';
require_once '../commons/function.php';
require_once '../admin/models/AdminBookManager.php';

echo "<h1>Test Chatbot Analytics Fix</h1>";

try {
    $adminBookManager = new AdminBookManager();
    
    echo "<h2>Test 1: getChatbotStats()</h2>";
    $stats = $adminBookManager->getChatbotStats();
    echo "<pre>";
    print_r($stats);
    echo "</pre>";
    
    echo "<h2>Test 2: getRecentChats()</h2>";
    $recentChats = $adminBookManager->getRecentChats(5);
    echo "<p>Số lượng chat: " . count($recentChats) . "</p>";
    
    if (!empty($recentChats)) {
        echo "<h3>Sample chat data structure:</h3>";
        echo "<pre>";
        print_r($recentChats[0]);
        echo "</pre>";
        
        echo "<h3>All recent chats:</h3>";
        foreach ($recentChats as $index => $chat) {
            echo "<div style='border: 1px solid #ddd; margin: 10px 0; padding: 10px;'>";
            echo "<strong>Chat #" . ($index + 1) . "</strong><br>";
            echo "User ID: " . (isset($chat['user_id']) ? $chat['user_id'] : 'N/A') . "<br>";
            echo "Message: " . htmlspecialchars($chat['message'] ?? 'N/A') . "<br>";
            echo "Type: " . ($chat['message_type'] ?? 'N/A') . "<br>";
            echo "Time: " . ($chat['created_at'] ?? 'N/A') . "<br>";
            echo "Response Time: " . ($chat['response_time'] ?? 'N/A') . "ms<br>";
            echo "</div>";
        }
    } else {
        echo "<p>Không có chat nào.</p>";
    }
    
    echo "<h2>Test 3: getPopularQueries()</h2>";
    $popularQueries = $adminBookManager->getPopularQueries();
    echo "<pre>";
    print_r($popularQueries);
    echo "</pre>";
    
    echo "<h2>✅ Test hoàn thành - Không có lỗi!</h2>";
    
} catch (Exception $e) {
    echo "<h2 style='color: red;'>❌ Có lỗi xảy ra:</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}

echo "<hr>";
echo "<a href='../admin/?act=thong-ke-chatbot'>Xem trang Chatbot Analytics</a>";
?>

<style>
body {
    font-family: Arial, sans-serif;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    line-height: 1.6;
}
h1, h2, h3 {
    color: #333;
    border-bottom: 2px solid #007bff;
    padding-bottom: 10px;
}
pre {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 5px;
    border: 1px solid #e9ecef;
    overflow-x: auto;
}
a {
    color: #007bff;
    text-decoration: none;
    padding: 10px 20px;
    background: #f8f9fa;
    border-radius: 5px;
    border: 1px solid #007bff;
    display: inline-block;
    margin-top: 20px;
}
a:hover {
    background: #007bff;
    color: white;
}
</style>
