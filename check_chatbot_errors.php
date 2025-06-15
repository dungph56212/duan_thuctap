<?php
// check_chatbot_errors.php - Kiểm tra lỗi chatbot
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔍 Kiểm tra Lỗi ChatBot</h1>";
echo "<style>
    body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; background: #f5f5f5; }
    .section { background: white; padding: 20px; margin: 15px 0; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    .success { color: #155724; background: #d4edda; padding: 10px; border-radius: 5px; margin: 5px 0; }
    .error { color: #721c24; background: #f8d7da; padding: 10px; border-radius: 5px; margin: 5px 0; }
    .warning { color: #856404; background: #fff3cd; padding: 10px; border-radius: 5px; margin: 5px 0; }
    .info { color: #0c5460; background: #d1ecf1; padding: 10px; border-radius: 5px; margin: 5px 0; }
    code { background: #f8f9fa; padding: 2px 6px; border-radius: 3px; font-family: monospace; }
</style>";

// 1. Kiểm tra PHP version
echo "<div class='section'>";
echo "<h2>1. 🐘 PHP Environment</h2>";
echo "<div class='info'>PHP Version: " . PHP_VERSION . "</div>";
if (version_compare(PHP_VERSION, '7.0.0') >= 0) {
    echo "<div class='success'>✅ PHP version OK</div>";
} else {
    echo "<div class='error'>❌ PHP version quá cũ, cần >= 7.0</div>";
}
echo "</div>";

// 2. Kiểm tra files
echo "<div class='section'>";
echo "<h2>2. 📁 Files Check</h2>";
$files = [
    'commons/env.php',
    'commons/function.php', 
    'models/ChatBot.php',
    'controllers/ChatBotController.php',
    'views/chatbot_widget.php',
    'index.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        echo "<div class='success'>✅ $file</div>";
        
        // Kiểm tra syntax error
        $output = shell_exec("php -l $file 2>&1");
        if (strpos($output, 'No syntax errors') !== false) {
            echo "<div class='info'>   → Syntax: OK</div>";
        } else {
            echo "<div class='error'>   → Syntax Error: $output</div>";
        }
    } else {
        echo "<div class='error'>❌ $file - FILE KHÔNG TỒN TẠI</div>";
    }
}
echo "</div>";

// 3. Kiểm tra database connection
echo "<div class='section'>";
echo "<h2>3. 🗄️ Database Connection</h2>";
try {
    if (file_exists('commons/env.php')) {
        require_once 'commons/env.php';
        
        if (file_exists('commons/function.php')) {
            require_once 'commons/function.php';
            
            $conn = connectDB();
            echo "<div class='success'>✅ Database connection thành công</div>";
            
            // Test query
            $stmt = $conn->query("SELECT VERSION()");
            $version = $stmt->fetchColumn();
            echo "<div class='info'>Database Version: $version</div>";
            
        } else {
            echo "<div class='error'>❌ Không tìm thấy commons/function.php</div>";
        }
    } else {
        echo "<div class='error'>❌ Không tìm thấy commons/env.php</div>";
    }
} catch (Exception $e) {
    echo "<div class='error'>❌ Database Error: " . $e->getMessage() . "</div>";
    echo "<div class='warning'>💡 Kiểm tra: XAMPP/Laragon có đang chạy? Database có tồn tại?</div>";
}
echo "</div>";

// 4. Kiểm tra tables
if (isset($conn)) {
    echo "<div class='section'>";
    echo "<h2>4. 📊 Database Tables</h2>";
    
    $requiredTables = ['chat_history', 'chatbot_settings', 'san_phams', 'danh_mucs'];
    
    foreach ($requiredTables as $table) {
        try {
            $stmt = $conn->prepare("SHOW TABLES LIKE '$table'");
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $stmt2 = $conn->prepare("SELECT COUNT(*) as count FROM $table");
                $stmt2->execute();
                $count = $stmt2->fetchColumn();
                echo "<div class='success'>✅ Table '$table': $count rows</div>";
            } else {
                echo "<div class='error'>❌ Table '$table': KHÔNG TỒN TẠI</div>";
                if ($table == 'chat_history' || $table == 'chatbot_settings') {
                    echo "<div class='warning'>   → Chạy: <code>php setup_chatbot_database.php</code></div>";
                }
            }
        } catch (Exception $e) {
            echo "<div class='error'>❌ Table '$table': " . $e->getMessage() . "</div>";
        }
    }
    echo "</div>";
}

// 5. Test ChatBot class
echo "<div class='section'>";
echo "<h2>5. 🤖 ChatBot Class Test</h2>";
try {
    if (file_exists('models/ChatBot.php')) {
        require_once 'models/ChatBot.php';
        
        $chatBot = new ChatBot();
        echo "<div class='success'>✅ ChatBot class loaded</div>";
        
        // Test basic response
        $response = $chatBot->getResponse('xin chào');
        if (!empty($response)) {
            echo "<div class='success'>✅ getResponse() works</div>";
            echo "<div class='info'>Sample response: " . substr($response, 0, 100) . "...</div>";
        } else {
            echo "<div class='error'>❌ getResponse() returns empty</div>";
        }
        
        // Test new methods
        if (method_exists($chatBot, 'searchProductInfo')) {
            echo "<div class='success'>✅ searchProductInfo() method exists</div>";
        } else {
            echo "<div class='error'>❌ searchProductInfo() method missing</div>";
        }
        
        if (method_exists($chatBot, 'getPopularProducts')) {
            echo "<div class='success'>✅ getPopularProducts() method exists</div>";
        } else {
            echo "<div class='error'>❌ getPopularProducts() method missing</div>";
        }
        
    } else {
        echo "<div class='error'>❌ models/ChatBot.php not found</div>";
    }
} catch (Exception $e) {
    echo "<div class='error'>❌ ChatBot Error: " . $e->getMessage() . "</div>";
}
echo "</div>";

// 6. Giải pháp
echo "<div class='section'>";
echo "<h2>6. 🛠️ Giải Pháp Nếu Có Lỗi</h2>";
echo "<div class='info'>";
echo "<strong>Nếu có lỗi database:</strong><br>";
echo "• Kiểm tra XAMPP/Laragon có đang chạy<br>";
echo "• Kiểm tra database name trong commons/env.php<br>";
echo "• Import file SQL vào database<br><br>";

echo "<strong>Nếu có lỗi file:</strong><br>";
echo "• Kiểm tra tất cả files đã upload đầy đủ<br>";
echo "• Kiểm tra quyền truy cập folder<br><br>";

echo "<strong>Nếu chatbot không hiển thị:</strong><br>";
echo "• Kiểm tra views/chatbot_widget.php đã include vào layout<br>";
echo "• Kiểm tra JavaScript console có lỗi không<br>";
echo "• Kiểm tra Font Awesome đã load<br>";
echo "</div>";
echo "</div>";

echo "<div class='section'>";
echo "<h2>🔗 Test Links</h2>";
echo "<a href='simple_chatbot_test.php' style='margin-right: 15px;'>🧪 Simple Test</a>";
echo "<a href='.' style='margin-right: 15px;'>🏠 Trang chủ</a>";
echo "<a href='test_chatbot.php'>📊 Full Test</a>";
echo "</div>";

echo "<p><em>🔍 Kiểm tra hoàn thành! Nếu có lỗi, hãy theo hướng dẫn trên để khắc phục.</em></p>";
?>
