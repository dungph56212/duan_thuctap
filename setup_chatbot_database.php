<?php
// File: setup_chatbot_database.php
// Chạy file này một lần để tạo bảng chatbot trong database

require_once 'commons/env.php';
require_once 'commons/function.php';

try {
    $conn = connectDB();
    
    echo "Đang tạo bảng chatbot...\n";
    
    // Đọc và thực thi SQL từ file chatbot_database.sql
    $sql = file_get_contents('chatbot_database.sql');
    
    // Tách các câu lệnh SQL
    $statements = explode(';', $sql);
    
    foreach ($statements as $statement) {
        $statement = trim($statement);
        if (!empty($statement)) {
            $conn->exec($statement);
            echo "Đã thực thi: " . substr($statement, 0, 50) . "...\n";
        }
    }
    
    echo "✅ Tạo bảng chatbot thành công!\n";
    echo "Các bảng đã được tạo:\n";
    echo "- chat_history: Lưu trữ lịch sử chat\n";
    echo "- chatbot_settings: Cài đặt chatbot\n";
    
} catch (Exception $e) {
    echo "❌ Lỗi: " . $e->getMessage() . "\n";
}
?>
