<?php
// setup_chatbot_table_final.php - Tạo bảng và dữ liệu cho chatbot
require_once './commons/env.php';
require_once './commons/function.php';

echo "<h1>🛠️ Thiết lập bảng Chatbot</h1>";

try {
    $conn = connectDB();
    
    // Tạo bảng chat_history
    echo "<h2>📋 Tạo bảng chat_history...</h2>";
    
    $createTable = "
    CREATE TABLE IF NOT EXISTS chat_history (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id VARCHAR(100),
        user_message TEXT,
        bot_response TEXT,
        session_id VARCHAR(100),
        ip_address VARCHAR(45),
        user_agent TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_user_id (user_id),
        INDEX idx_created_at (created_at),
        INDEX idx_session_id (session_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ";
    
    $conn->exec($createTable);
    echo "<p>✅ Bảng chat_history đã được tạo/cập nhật</p>";
    
    // Kiểm tra và thêm dữ liệu mẫu
    $count = $conn->query("SELECT COUNT(*) FROM chat_history")->fetchColumn();
    echo "<p>Số record hiện tại: " . $count . "</p>";
    
    if ($count < 20) {
        echo "<h2>📝 Thêm dữ liệu mẫu...</h2>";
        
        $sampleData = [
            // Dữ liệu từ nhiều ngày khác nhau
            ['user001', 'Xin chào, tôi muốn tìm sách về lập trình PHP', 'Xin chào! Chúng tôi có nhiều sách về PHP. Bạn là người mới bắt đầu hay đã có kinh nghiệm?', 'sess001'],
            ['user001', 'Tôi là người mới bắt đầu', 'Tôi khuyên bạn nên bắt đầu với "PHP Căn Bản" hoặc "Lập trình Web với PHP". Bạn muốn xem chi tiết không?', 'sess001'],
            ['user002', 'Có sách về JavaScript không?', 'Có, chúng tôi có "JavaScript Cơ Bản", "ES6 và Beyond", "React.js Thực Chiến". Bạn quan tâm loại nào?', 'sess002'],
            ['user002', 'Tôi muốn học React', 'Sách "React.js Thực Chiến" rất phù hợp. Giá 250,000 VNĐ. Bạn có muốn thêm vào giỏ hàng?', 'sess002'],
            ['user003', 'Làm sao để thanh toán?', 'Chúng tôi hỗ trợ thanh toán qua thẻ ATM, Visa/MasterCard, MoMo, ZaloPay. Bạn muốn dùng hình thức nào?', 'sess003'],
            ['guest001', 'Có giao hàng toàn quốc không?', 'Có, chúng tôi giao hàng toàn quốc. Phí ship 15-30k tùy khu vực. Đơn từ 300k được miễn phí ship.', 'sess004'],
            ['user004', 'Sách có bảo hành không?', 'Sách được đổi trả trong 7 ngày nếu có lỗi từ nhà xuất bản. Sách cũ không áp dụng đổi trả.', 'sess005'],
            ['user005', 'Có sách về Python không?', 'Có, chúng tôi có "Python Cơ Bản", "Django Framework", "Machine Learning với Python". Bạn quan tâm lĩnh vực nào?', 'sess006'],
            ['user005', 'Tôi muốn học AI', 'Tôi khuyên "Machine Learning với Python" và "Deep Learning Cơ Bản". Cả hai đều có ví dụ thực tế.', 'sess006'],
            ['user006', 'Giá sách như thế nào?', 'Sách dao động 50k-500k tùy loại. Sách cơ bản 50-150k, chuyên sâu 200-500k. Có khuyến mãi thường xuyên.', 'sess007'],
            ['user007', 'Có thể đặt hàng online không?', 'Có, bạn có thể đặt hàng trên website 24/7. Hỗ trợ hotline 1900-xxxx từ 8h-22h hàng ngày.', 'sess008'],
            ['user008', 'Sách có bản ebook không?', 'Một số sách có bản PDF/ePub. Giá ebook bằng 70% giá sách giấy. Bạn quan tâm sách nào?', 'sess009'],
            ['user003', 'Có sách về Node.js không?', 'Có "Node.js Cơ Bản" và "Building APIs with Node.js". Phù hợp cho backend developer.', 'sess010'],
            ['user009', 'Làm sao để kiểm tra đơn hàng?', 'Bạn có thể kiểm tra đơn hàng qua: 1) Đăng nhập tài khoản, 2) SMS xác nhận, 3) Email thông báo.', 'sess011'],
            ['user010', 'Có chương trình khuyến mãi không?', 'Hiện có: Giảm 20% cho đơn từ 500k, Mua 2 tặng 1 cho sách cũ, Miễn ship đơn từ 300k.', 'sess012'],
            ['user011', 'Tôi muốn tìm sách về Database', 'Chúng tôi có "MySQL Căn Bản", "PostgreSQL Advanced", "MongoDB Thực Chiến". Bạn dùng hệ CSDL nào?', 'sess013'],
            ['user012', 'Có hỗ trợ trả góp không?', 'Có, hỗ trợ trả góp 0% qua thẻ tín dụng cho đơn từ 1 triệu. Hoặc chia 3 kỳ với phí 2%.', 'sess014'],
            ['user013', 'Sách có mới nhất không?', 'Chúng tôi cập nhật liên tục. Có thông báo sách mới qua email/SMS. Đăng ký nhận thông tin nhé!', 'sess015'],
            ['user014', 'Có sách tiếng Anh không?', 'Có, chúng tôi có sách tiếng Anh gốc và bản dịch. Giá sách tiếng Anh cao hơn 30-50% so với bản dịch.', 'sess016'],
            ['user015', 'Làm sao để liên hệ?', 'Hotline: 1900-xxxx, Email: support@bookstore.com, Facebook: fb.com/bookstore, Địa chỉ: 123 ABC, HN', 'sess017']
        ];
        
        $stmt = $conn->prepare("
            INSERT INTO chat_history (user_id, user_message, bot_response, session_id, ip_address, created_at) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        
        foreach ($sampleData as $i => $data) {
            // Tạo thời gian ngẫu nhiên trong 7 ngày qua
            $randomHours = rand(0, 168); // 7 ngày * 24 giờ
            $created_at = date('Y-m-d H:i:s', strtotime("-{$randomHours} hours"));
            $ip = '192.168.1.' . rand(1, 255);
            
            $stmt->execute([
                $data[0], // user_id
                $data[1], // user_message
                $data[2], // bot_response
                $data[3], // session_id
                $ip,      // ip_address
                $created_at
            ]);
        }
        
        echo "<p>✅ Đã thêm " . count($sampleData) . " tin nhắn mẫu</p>";
    }
    
    // Thống kê sau khi setup
    echo "<h2>📊 Thống kê sau setup</h2>";
    $total = $conn->query("SELECT COUNT(*) FROM chat_history")->fetchColumn();
    echo "<p>Tổng tin nhắn: " . $total . "</p>";
    
    $unique_users = $conn->query("SELECT COUNT(DISTINCT user_id) FROM chat_history WHERE user_id IS NOT NULL")->fetchColumn();
    echo "<p>Số user unique: " . $unique_users . "</p>";
    
    $today = $conn->query("SELECT COUNT(*) FROM chat_history WHERE DATE(created_at) = CURDATE()")->fetchColumn();
    echo "<p>Tin nhắn hôm nay: " . $today . "</p>";
    
    echo "<h2>✅ Setup hoàn tất!</h2>";
    echo "<p><a href='test_chatbot_analytics_final.php' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>➡️ Chạy Test Analytics</a></p>";
    
} catch (Exception $e) {
    echo "<h2>❌ Lỗi: " . $e->getMessage() . "</h2>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>
