<?php
// Simple test to check admin integration
require_once '../commons/env.php';
require_once '../commons/function.php';

echo "<h1>🧪 Test Admin Integration - Simple Check</h1>";

// Test database connection
try {
    $conn = connectDB();
    if ($conn) {
        echo "<p>✅ Database connection: OK</p>";
        
        // Test if admin tables exist
        $tables = ['san_phams', 'danh_mucs', 'chat_history'];
        foreach ($tables as $table) {
            $stmt = $conn->query("SHOW TABLES LIKE '$table'");
            if ($stmt->rowCount() > 0) {
                echo "<p>✅ Table $table: EXISTS</p>";
            } else {
                echo "<p>❌ Table $table: MISSING</p>";
            }
        }
    }
} catch (Exception $e) {
    echo "<p>❌ Database error: " . $e->getMessage() . "</p>";
}

// Test file structure
$files = [
    '../admin/controllers/AdminBookManagerController.php',
    '../admin/models/AdminBookManager.php',
    '../admin/views/bookmanager/dashboard.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        echo "<p>✅ File: " . basename($file) . " - EXISTS</p>";
    } else {
        echo "<p>❌ File: " . basename($file) . " - MISSING</p>";
    }
}

echo "<hr>";
echo "<h2>🔗 Quick Links:</h2>";
echo "<ul>";
echo "<li><a href='" . BASE_URL_ADMIN . "' target='_blank'>📊 Admin Login</a></li>";
echo "<li><a href='" . BASE_URL . "test_enhanced_chatbot.php' target='_blank'>🤖 Test Chatbot</a></li>";
echo "<li><a href='" . BASE_URL . "add_books.php' target='_blank'>📚 Add Books (Frontend)</a></li>";
echo "</ul>";

echo "<div style='background: #f8f9fa; padding: 15px; border-left: 4px solid #007bff; margin: 20px 0;'>";
echo "<h3>💡 Next Steps:</h3>";
echo "<ol>";
echo "<li>Login to admin panel</li>";
echo "<li>Go to 'Quản lý sách & AI' menu</li>";
echo "<li>Try dashboard, add books, manage categories</li>";
echo "<li>Test chatbot analytics</li>";
echo "</ol>";
echo "</div>";
?>
