<?php
// test_enhanced_chatbot.php - Test chatbot với tính năng nâng cao
session_start();
require_once 'commons/env.php';
require_once 'commons/function.php';
require_once 'models/ChatBot.php';

$chatBot = new ChatBot();

echo "<h1>🤖 Test Enhanced ChatBot AI</h1>";

echo "<style>
    body { font-family: Arial, sans-serif; max-width: 1200px; margin: 0 auto; padding: 20px; }
    .test-section { border: 1px solid #ddd; margin: 20px 0; padding: 20px; border-radius: 10px; }
    .success { color: green; padding: 10px; background: #e8f5e8; border-radius: 5px; margin: 10px 0; }
    .error { color: red; padding: 10px; background: #fee; border-radius: 5px; margin: 10px 0; }
    .info { color: blue; padding: 10px; background: #e8f4fd; border-radius: 5px; margin: 10px 0; }
    .response { background: #f9f9f9; padding: 15px; border-radius: 8px; margin: 10px 0; white-space: pre-wrap; }
    .test-message { background: #fff3cd; padding: 10px; border-radius: 5px; margin: 5px 0; }
    .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    button { padding: 10px 20px; margin: 5px; border: none; border-radius: 5px; cursor: pointer; background: #007bff; color: white; }
    button:hover { background: #0056b3; }
</style>";

// Test 1: Database Connection
echo "<div class='test-section'>";
echo "<h2>1. Test Database Connection</h2>";
try {
    $conn = connectDB();
    echo "<div class='success'>✅ Database kết nối thành công!</div>";
    
    // Check products table
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM san_phams");
    $stmt->execute();
    $productCount = $stmt->fetchColumn();
    echo "<div class='info'>📊 Tổng số sản phẩm: $productCount</div>";
    
    // Check categories
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM danh_mucs");
    $stmt->execute();
    $categoryCount = $stmt->fetchColumn();
    echo "<div class='info'>📁 Tổng số danh mục: $categoryCount</div>";
    
} catch (Exception $e) {
    echo "<div class='error'>❌ Lỗi database: " . $e->getMessage() . "</div>";
}
echo "</div>";

// Test 2: Enhanced Response Patterns
echo "<div class='test-section'>";
echo "<h2>2. Test Enhanced Response Patterns</h2>";
$enhancedTestMessages = [
    'Xin chào' => 'Chào hỏi cơ bản',
    'Có sách gì hay không?' => 'Hỏi về sản phẩm sách',
    'Giá sách bao nhiêu?' => 'Hỏi về giá cả',
    'Giao hàng như thế nào?' => 'Hỏi về vận chuyển',
    'Có khuyến mãi gì không?' => 'Hỏi về ưu đãi',
    'Tìm sách tiểu thuyết' => 'Tìm kiếm theo thể loại',
    'Liên hệ hotline' => 'Thông tin liên hệ',
    'Sách mới nhất' => 'Sản phẩm mới',
    'Đổi trả như thế nào?' => 'Chính sách đổi trả',
    'Top sách bán chạy' => 'Sản phẩm hot',
    'Website app' => 'Thông tin platform'
];

echo "<div class='grid'>";
foreach ($enhancedTestMessages as $message => $description) {
    echo "<div class='test-message'>";
    echo "<strong>Test:</strong> $description<br>";
    echo "<strong>Input:</strong> $message<br>";
    $response = $chatBot->getResponse($message);
    echo "<div class='response'>$response</div>";
    echo "</div>";
}
echo "</div>";
echo "</div>";

// Test 3: Product Search
echo "<div class='test-section'>";
echo "<h2>3. Test Product Search</h2>";
$searchQueries = [
    'truyện',
    'sách',
    'tiểu thuyết',
    'giáo khoa',
    'nguyễn nhật ánh'
];

foreach ($searchQueries as $query) {
    echo "<div class='test-message'>";
    echo "<strong>Tìm kiếm:</strong> $query<br>";
    $result = $chatBot->searchProductInfo($query);
    if ($result) {
        echo "<div class='response success'>$result</div>";
    } else {
        echo "<div class='response error'>Không tìm thấy sản phẩm nào</div>";
    }
    echo "</div>";
}
echo "</div>";

// Test 4: Popular Products
echo "<div class='test-section'>";
echo "<h2>4. Test Popular Products</h2>";
try {
    $popularProducts = $chatBot->getPopularProducts(5);
    if (!empty($popularProducts)) {
        echo "<div class='success'>✅ Lấy sản phẩm bán chạy thành công!</div>";
        echo "<div class='info'>📈 Số sản phẩm: " . count($popularProducts) . "</div>";
        
        echo "<table border='1' cellpadding='10' cellspacing='0' style='width: 100%; border-collapse: collapse;'>";
        echo "<tr style='background: #f0f0f0;'><th>STT</th><th>Tên sách</th><th>Giá</th><th>Danh mục</th><th>Lượt xem</th></tr>";
        
        foreach ($popularProducts as $index => $product) {
            echo "<tr>";
            echo "<td>" . ($index + 1) . "</td>";
            echo "<td>" . htmlspecialchars($product['ten_san_pham']) . "</td>";
            echo "<td>" . number_format($product['gia_san_pham']) . "đ</td>";
            echo "<td>" . htmlspecialchars($product['ten_danh_muc']) . "</td>";
            echo "<td>" . number_format($product['luot_xem']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<div class='error'>❌ Không có sản phẩm nào</div>";
    }
} catch (Exception $e) {
    echo "<div class='error'>❌ Lỗi: " . $e->getMessage() . "</div>";
}
echo "</div>";

// Test 5: Categories
echo "<div class='test-section'>";
echo "<h2>5. Test Categories</h2>";
try {
    $categories = $chatBot->getCategories();
    if (!empty($categories)) {
        echo "<div class='success'>✅ Lấy danh mục thành công!</div>";
        echo "<div class='info'>📁 Số danh mục: " . count($categories) . "</div>";
        
        echo "<table border='1' cellpadding='10' cellspacing='0' style='width: 100%; border-collapse: collapse;'>";
        echo "<tr style='background: #f0f0f0;'><th>STT</th><th>Tên danh mục</th><th>Số sản phẩm</th></tr>";
        
        foreach ($categories as $index => $category) {
            echo "<tr>";
            echo "<td>" . ($index + 1) . "</td>";
            echo "<td>" . htmlspecialchars($category['ten_danh_muc']) . "</td>";
            echo "<td>" . $category['product_count'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<div class='error'>❌ Không có danh mục nào</div>";
    }
} catch (Exception $e) {
    echo "<div class='error'>❌ Lỗi: " . $e->getMessage() . "</div>";
}
echo "</div>";

// Test 6: Smart Response
echo "<div class='test-section'>";
echo "<h2>6. Test Smart Response</h2>";
$smartQueries = [
    'tìm sách hay cho học sinh',
    'có sách nào giá rẻ không',
    'bao nhiêu tiền một cuốn',
    'khi nào giao hàng',
    'ở đâu có bán',
    'làm sao để đặt hàng',
    'tại sao giá đắt',
    'nên mua sách gì',
    'top sách hay nhất',
    'muốn mua sách online'
];

echo "<div class='grid'>";
foreach ($smartQueries as $query) {
    echo "<div class='test-message'>";
    echo "<strong>Query:</strong> $query<br>";
    $response = $chatBot->getSmartResponse($query);
    if ($response) {
        echo "<div class='response success'>$response</div>";
    } else {
        echo "<div class='response error'>Không có phản hồi thông minh</div>";
    }
    echo "</div>";
}
echo "</div>";
echo "</div>";

// Test 7: API Endpoints
echo "<div class='test-section'>";
echo "<h2>7. Test API Endpoints</h2>";
echo "<div class='info'>🌐 Test các API endpoints mới:</div>";
echo "<ul>";
echo "<li><strong>GET</strong> <code>?act=chatbot-popular-products</code> - Lấy sản phẩm bán chạy</li>";
echo "<li><strong>GET</strong> <code>?act=chatbot-categories</code> - Lấy danh mục</li>";
echo "<li><strong>POST</strong> <code>?act=chatbot-search-products</code> - Tìm kiếm sản phẩm</li>";
echo "</ul>";

echo "<div style='margin: 20px 0;'>";
echo "<button onclick='testAPI(\"chatbot-popular-products\")'>Test Popular Products API</button>";
echo "<button onclick='testAPI(\"chatbot-categories\")'>Test Categories API</button>";
echo "<button onclick='testAPISearch()'>Test Search API</button>";
echo "</div>";

echo "<div id='api-results'></div>";
echo "</div>";

echo "<hr>";
echo "<h2>🔗 Navigation</h2>";
echo "<a href='test_chatbot.php' style='margin-right: 10px;'>📊 Original Test</a>";
echo "<a href='demo_chatbot.php' style='margin-right: 10px;'>🚀 Demo</a>";
echo "<a href='.' style='margin-right: 10px;'>🏠 Trang chủ</a>";

echo "<script>
async function testAPI(endpoint) {
    const results = document.getElementById('api-results');
    results.innerHTML = 'Đang test API...';
    
    try {
        const response = await fetch('?act=' + endpoint);
        const data = await response.json();
        
        let html = '<div class=\"success\">✅ API ' + endpoint + ' thành công!</div>';
        html += '<pre style=\"background: #f8f9fa; padding: 15px; border-radius: 5px; overflow-x: auto;\">';
        html += JSON.stringify(data, null, 2);
        html += '</pre>';
        
        results.innerHTML = html;
    } catch (error) {
        results.innerHTML = '<div class=\"error\">❌ Lỗi API: ' + error.message + '</div>';
    }
}

async function testAPISearch() {
    const results = document.getElementById('api-results');
    results.innerHTML = 'Đang test Search API...';
    
    try {
        const response = await fetch('?act=chatbot-search-products', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                query: 'sách'
            })
        });
        const data = await response.json();
        
        let html = '<div class=\"success\">✅ Search API thành công!</div>';
        html += '<pre style=\"background: #f8f9fa; padding: 15px; border-radius: 5px; overflow-x: auto;\">';
        html += JSON.stringify(data, null, 2);
        html += '</pre>';
        
        results.innerHTML = html;
    } catch (error) {
        results.innerHTML = '<div class=\"error\">❌ Lỗi Search API: ' + error.message + '</div>';
    }
}
</script>";

echo "<hr>";
echo "<p><em>✨ Enhanced ChatBot Test hoàn thành! Kiểm tra các ✅ và ❌ để đảm bảo hệ thống hoạt động tốt.</em></p>";
?>
