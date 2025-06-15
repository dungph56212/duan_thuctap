<?php
// debug_chatbot_quick.php - Kiểm tra nhanh tình trạng
require_once './commons/env.php';
require_once './commons/function.php';

echo "<h1>🔍 Quick Debug Chatbot</h1>";
echo "<style>
body { font-family: Arial, sans-serif; margin: 20px; }
.success { color: green; font-weight: bold; }
.error { color: red; font-weight: bold; }
.warning { color: orange; font-weight: bold; }
table { border-collapse: collapse; width: 100%; margin: 10px 0; }
th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
th { background-color: #f2f2f2; }
</style>";

try {
    $conn = connectDB();
    echo "<p class='success'>✅ Kết nối database thành công</p>";
    
    // Kiểm tra bảng
    echo "<h2>📋 Kiểm tra bảng</h2>";
    $tables = $conn->query("SHOW TABLES LIKE 'chat_history'")->fetchAll();
    if (empty($tables)) {
        echo "<p class='error'>❌ Bảng chat_history không tồn tại</p>";
        echo "<p><a href='setup_chatbot_table_final.php'>➡️ Tạo bảng ngay</a></p>";
    } else {
        echo "<p class='success'>✅ Bảng chat_history đã tồn tại</p>";
        
        // Kiểm tra cấu trúc bảng
        $columns = $conn->query("DESCRIBE chat_history")->fetchAll(PDO::FETCH_ASSOC);
        echo "<h3>Cấu trúc bảng:</h3>";
        echo "<table>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
        foreach ($columns as $col) {
            echo "<tr>";
            echo "<td>" . $col['Field'] . "</td>";
            echo "<td>" . $col['Type'] . "</td>";
            echo "<td>" . $col['Null'] . "</td>";
            echo "<td>" . $col['Key'] . "</td>";
            echo "<td>" . ($col['Default'] ?? 'NULL') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Kiểm tra dữ liệu
        echo "<h2>📊 Kiểm tra dữ liệu</h2>";
        $count = $conn->query("SELECT COUNT(*) FROM chat_history")->fetchColumn();
        echo "<p>Tổng số record: <strong>" . $count . "</strong></p>";
        
        if ($count > 0) {
            // Thống kê cơ bản
            $stats = [];
            $stats['unique_users'] = $conn->query("SELECT COUNT(DISTINCT user_id) FROM chat_history WHERE user_id IS NOT NULL")->fetchColumn();
            $stats['today'] = $conn->query("SELECT COUNT(*) FROM chat_history WHERE DATE(created_at) = CURDATE()")->fetchColumn();
            $stats['this_week'] = $conn->query("SELECT COUNT(*) FROM chat_history WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)")->fetchColumn();
            
            echo "<table>";
            echo "<tr><th>Thống kê</th><th>Giá trị</th></tr>";
            echo "<tr><td>User unique</td><td>" . $stats['unique_users'] . "</td></tr>";
            echo "<tr><td>Tin nhắn hôm nay</td><td>" . $stats['today'] . "</td></tr>";
            echo "<tr><td>Tin nhắn tuần này</td><td>" . $stats['this_week'] . "</td></tr>";
            echo "</table>";
            
            // Sample data
            echo "<h3>Dữ liệu mẫu (5 record gần nhất):</h3>";
            $samples = $conn->query("SELECT * FROM chat_history ORDER BY created_at DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
            
            if (!empty($samples)) {
                echo "<table>";
                echo "<tr><th>ID</th><th>User ID</th><th>Message</th><th>Response</th><th>Created At</th></tr>";
                foreach ($samples as $sample) {
                    echo "<tr>";
                    echo "<td>" . $sample['id'] . "</td>";
                    echo "<td>" . ($sample['user_id'] ?? 'NULL') . "</td>";
                    echo "<td>" . htmlspecialchars(substr($sample['user_message'] ?? '', 0, 30)) . "...</td>";
                    echo "<td>" . htmlspecialchars(substr($sample['bot_response'] ?? '', 0, 30)) . "...</td>";
                    echo "<td>" . $sample['created_at'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        } else {
            echo "<p class='warning'>⚠️ Chưa có dữ liệu trong bảng</p>";
            echo "<p><a href='setup_chatbot_table_final.php'>➡️ Thêm dữ liệu mẫu</a></p>";
        }
    }
    
    // Kiểm tra file AdminBookManager
    echo "<h2>📁 Kiểm tra file</h2>";
    $modelFile = './admin/models/AdminBookManager.php';
    if (file_exists($modelFile)) {
        echo "<p class='success'>✅ File AdminBookManager.php tồn tại</p>";
        
        // Kiểm tra các method quan trọng
        $content = file_get_contents($modelFile);
        $methods = ['getChatbotStats', 'getRecentChats', 'getPopularQueries'];
        
        foreach ($methods as $method) {
            if (strpos($content, "function $method") !== false) {
                echo "<p class='success'>✅ Method $method() có trong file</p>";
            } else {
                echo "<p class='error'>❌ Method $method() không tìm thấy</p>";
            }
        }
    } else {
        echo "<p class='error'>❌ File AdminBookManager.php không tồn tại</p>";
    }
    
    // Kiểm tra view file
    $viewFile = './admin/views/bookmanager/chatbot_analytics.php';
    if (file_exists($viewFile)) {
        echo "<p class='success'>✅ File chatbot_analytics.php tồn tại</p>";
    } else {
        echo "<p class='error'>❌ File chatbot_analytics.php không tồn tại</p>";
    }
    
    echo "<h2>🎯 Hành động tiếp theo</h2>";
    echo "<p>1. <a href='setup_chatbot_table_final.php'>Thiết lập bảng và dữ liệu</a></p>";
    echo "<p>2. <a href='test_chatbot_analytics_final.php'>Test analytics đầy đủ</a></p>";
    echo "<p>3. <a href='admin/?act=chatbot-analytics' target='_blank'>Mở trang Analytics</a></p>";
    
} catch (Exception $e) {
    echo "<p class='error'>❌ Lỗi: " . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>
