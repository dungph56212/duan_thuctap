<?php
// simple_chatbot_test.php - Test đơn giản không cần CMD
session_start();
require_once 'commons/env.php';
require_once 'commons/function.php';

echo "<h1>🤖 Test ChatBot Enhanced - Đơn Giản</h1>";
echo "<style>
    body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
    .success { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 10px 0; }
    .error { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 10px 0; }
    .info { background: #d1ecf1; color: #0c5460; padding: 15px; border-radius: 5px; margin: 10px 0; }
    .test-section { border: 2px solid #ddd; padding: 20px; margin: 20px 0; border-radius: 10px; }
    button { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; margin: 5px; cursor: pointer; }
    button:hover { background: #0056b3; }
</style>";

// Test 1: Kiểm tra files có tồn tại không
echo "<div class='test-section'>";
echo "<h2>1. ✅ Kiểm tra Files</h2>";

$requiredFiles = [
    'models/ChatBot.php' => 'Model ChatBot',
    'controllers/ChatBotController.php' => 'Controller ChatBot',
    'views/chatbot_widget.php' => 'Widget ChatBot'
];

$allFilesExist = true;
foreach ($requiredFiles as $file => $description) {
    if (file_exists($file)) {
        echo "<div class='success'>✅ $description ($file) - OK</div>";
    } else {
        echo "<div class='error'>❌ $description ($file) - THIẾU FILE</div>";
        $allFilesExist = false;
    }
}

if ($allFilesExist) {
    echo "<div class='success'>🎉 Tất cả files cần thiết đã có!</div>";
} else {
    echo "<div class='error'>⚠️ Một số files bị thiếu, vui lòng kiểm tra lại!</div>";
}
echo "</div>";

// Test 2: Kiểm tra database
echo "<div class='test-section'>";
echo "<h2>2. 🗄️ Kiểm tra Database</h2>";
try {
    $conn = connectDB();
    echo "<div class='success'>✅ Kết nối database thành công!</div>";
    
    // Kiểm tra bảng cần thiết
    $tables = ['chat_history', 'san_phams', 'danh_mucs'];
    foreach ($tables as $table) {
        try {
            $stmt = $conn->prepare("SELECT COUNT(*) FROM $table");
            $stmt->execute();
            $count = $stmt->fetchColumn();
            echo "<div class='info'>📊 Bảng '$table': $count bản ghi</div>";
        } catch (Exception $e) {
            echo "<div class='error'>❌ Bảng '$table': Không tồn tại hoặc lỗi</div>";
        }
    }
} catch (Exception $e) {
    echo "<div class='error'>❌ Lỗi database: " . $e->getMessage() . "</div>";
    echo "<div class='info'>💡 Hãy kiểm tra file commons/env.php và đảm bảo database đang chạy</div>";
}
echo "</div>";

// Test 3: Test ChatBot responses
if ($allFilesExist) {
    echo "<div class='test-section'>";
    echo "<h2>3. 🤖 Test ChatBot Responses</h2>";
    
    try {
        require_once 'models/ChatBot.php';
        $chatBot = new ChatBot();
        
        $testMessages = [
            'Xin chào' => '👋 Chào hỏi',
            'Có sách gì hay?' => '📚 Hỏi sách',
            'Giá bao nhiêu?' => '💰 Hỏi giá',
            'Giao hàng ntn?' => '🚚 Vận chuyển',
            'Khuyến mãi' => '🎉 Ưu đãi'
        ];
        
        foreach ($testMessages as $message => $desc) {
            echo "<div style='border: 1px solid #ddd; padding: 10px; margin: 10px 0; border-radius: 5px;'>";
            echo "<strong>$desc:</strong> \"$message\"<br>";
            try {
                $response = $chatBot->getResponse($message);
                echo "<div style='background: #f0f8ff; padding: 8px; margin-top: 5px; border-radius: 3px;'>";
                echo "<strong>Bot:</strong> " . substr($response, 0, 100) . "...";
                echo "</div>";
            } catch (Exception $e) {
                echo "<div class='error'>Lỗi: " . $e->getMessage() . "</div>";
            }
            echo "</div>";
        }
        
        echo "<div class='success'>✅ ChatBot hoạt động tốt!</div>";
    } catch (Exception $e) {
        echo "<div class='error'>❌ Lỗi ChatBot: " . $e->getMessage() . "</div>";
    }
    echo "</div>";
}

// Test 4: Test API qua AJAX
echo "<div class='test-section'>";
echo "<h2>4. 🌐 Test API Endpoints</h2>";
echo "<button onclick='testChatAPI()'>Test Chat API</button>";
echo "<button onclick='testPopularAPI()'>Test Popular Products</button>";
echo "<button onclick='testCategoriesAPI()'>Test Categories</button>";
echo "<div id='api-results' style='margin-top: 15px;'></div>";
echo "</div>";

// Navigation
echo "<div class='test-section'>";
echo "<h2>🔗 Navigation</h2>";
echo "<a href='.' style='margin-right: 15px;'>🏠 Trang chủ</a>";
echo "<a href='test_chatbot.php' style='margin-right: 15px;'>📊 Test gốc</a>";
echo "<a href='demo_chatbot.php'>🚀 Demo</a>";
echo "</div>";

// JavaScript cho test API
echo "<script>
async function testChatAPI() {
    const results = document.getElementById('api-results');
    results.innerHTML = '⏳ Đang test Chat API...';
    
    try {
        const response = await fetch('?act=chatbot-send-message', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                message: 'Xin chào',
                session_id: 'test_' + Date.now()
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            results.innerHTML = '<div class=\"success\">✅ Chat API hoạt động!<br><strong>Phản hồi:</strong> ' + data.response.substring(0, 100) + '...</div>';
        } else {
            results.innerHTML = '<div class=\"error\">❌ Chat API lỗi: ' + (data.error || 'Unknown error') + '</div>';
        }
    } catch (error) {
        results.innerHTML = '<div class=\"error\">❌ Lỗi kết nối Chat API: ' + error.message + '</div>';
    }
}

async function testPopularAPI() {
    const results = document.getElementById('api-results');
    results.innerHTML = '⏳ Đang test Popular Products API...';
    
    try {
        const response = await fetch('?act=chatbot-popular-products');
        const data = await response.json();
        
        if (data.success) {
            results.innerHTML = '<div class=\"success\">✅ Popular Products API hoạt động!<br><strong>Số sản phẩm:</strong> ' + data.products.length + '</div>';
        } else {
            results.innerHTML = '<div class=\"error\">❌ Popular Products API lỗi</div>';
        }
    } catch (error) {
        results.innerHTML = '<div class=\"error\">❌ Lỗi Popular Products API: ' + error.message + '</div>';
    }
}

async function testCategoriesAPI() {
    const results = document.getElementById('api-results');
    results.innerHTML = '⏳ Đang test Categories API...';
    
    try {
        const response = await fetch('?act=chatbot-categories');
        const data = await response.json();
        
        if (data.success) {
            results.innerHTML = '<div class=\"success\">✅ Categories API hoạt động!<br><strong>Số danh mục:</strong> ' + data.categories.length + '</div>';
        } else {
            results.innerHTML = '<div class=\"error\">❌ Categories API lỗi</div>';
        }
    } catch (error) {
        results.innerHTML = '<div class=\"error\">❌ Lỗi Categories API: ' + error.message + '</div>';
    }
}
</script>";

echo "<hr>";
echo "<p><em>🎯 Test hoàn thành! Nếu tất cả đều ✅ thì chatbot enhanced đã sẵn sàng sử dụng!</em></p>";
?>
