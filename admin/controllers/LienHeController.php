<?php
require_once __DIR__ . '/../../models/LienHe.php';

class LienHeController {
    
    public function index() {
        // Lấy tham số từ GET
        $page = $_GET['page'] ?? 1;
        $limit = $_GET['limit'] ?? 10;
        $filters = [
            'status' => $_GET['status'] ?? '',
            'priority' => $_GET['priority'] ?? '',
            'search' => $_GET['search'] ?? '',
            'date_from' => $_GET['date_from'] ?? '',
            'date_to' => $_GET['date_to'] ?? ''
        ];
        
        // Lấy danh sách liên hệ
        $result = LienHe::getAll($page, $limit, $filters);
        $ds_lienhe = $result['data'];
        $total_pages = $result['pages'];
        $current_page = $result['current_page'];
        $total_records = $result['total'];
        
        // Lấy thống kê
        $stats = LienHe::getStats();
        
        include __DIR__ . '/../views/lienhe/listLienHe.php';
    }
    
    public function view() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?ctl=lienhe');
            exit;
        }
        
        $lienhe = LienHe::getById($id);
        if (!$lienhe) {
            header('Location: index.php?ctl=lienhe');
            exit;
        }
        
        // Đánh dấu đã đọc
        if (!$lienhe['is_read']) {
            LienHe::markAsRead($id);
        }
        
        include __DIR__ . '/../views/lienhe/viewLienHe.php';
    }
    
    public function updateStatus() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $status = $_POST['status'] ?? null;
            $priority = $_POST['priority'] ?? null;
            
            if ($id && $status) {
                LienHe::updateStatus($id, $status, $priority);
                $_SESSION['success_message'] = 'Cập nhật trạng thái thành công!';
            }
        }
        
        $redirect = $_POST['redirect'] ?? 'index.php?ctl=lienhe';
        header('Location: ' . $redirect);
        exit;
    }
    
    public function reply() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $reply_message = $_POST['reply_message'] ?? '';
            $replied_by = $_SESSION['user_id'] ?? 1; // Lấy từ session admin
            
            if ($id && $reply_message) {
                LienHe::reply($id, $reply_message, $replied_by);
                
                // Gửi email phản hồi cho khách hàng
                $lienhe = LienHe::getById($id);
                if ($lienhe) {
                    $this->sendReplyEmail($lienhe, $reply_message);
                }
                
                $_SESSION['success_message'] = 'Gửi phản hồi thành công!';
            }
        }
        
        $redirect = $_POST['redirect'] ?? 'index.php?ctl=lienhe';
        header('Location: ' . $redirect);
        exit;
    }
    
    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            LienHe::delete($id);
            $_SESSION['success_message'] = 'Xóa liên hệ thành công!';
        }
        
        header('Location: index.php?ctl=lienhe');
        exit;
    }
    
    public function bulkAction() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['bulk_action'] ?? '';
            $selected_ids = $_POST['selected_ids'] ?? [];
            
            if (!empty($selected_ids) && $action) {
                switch ($action) {
                    case 'mark_read':
                        foreach ($selected_ids as $id) {
                            LienHe::markAsRead($id);
                        }
                        $_SESSION['success_message'] = 'Đã đánh dấu ' . count($selected_ids) . ' liên hệ là đã đọc!';
                        break;
                        
                    case 'mark_replied':
                        foreach ($selected_ids as $id) {
                            LienHe::updateStatus($id, 'replied');
                        }
                        $_SESSION['success_message'] = 'Đã cập nhật ' . count($selected_ids) . ' liên hệ thành đã phản hồi!';
                        break;
                        
                    case 'mark_closed':
                        foreach ($selected_ids as $id) {
                            LienHe::updateStatus($id, 'closed');
                        }
                        $_SESSION['success_message'] = 'Đã đóng ' . count($selected_ids) . ' liên hệ!';
                        break;
                        
                    case 'delete':
                        foreach ($selected_ids as $id) {
                            LienHe::delete($id);
                        }
                        $_SESSION['success_message'] = 'Đã xóa ' . count($selected_ids) . ' liên hệ!';
                        break;
                }
            }
        }
        
        header('Location: index.php?ctl=lienhe');
        exit;
    }
    
    public function stats() {
        $stats = LienHe::getStats();
        
        // Thống kê theo thời gian (7 ngày gần nhất)
        $daily_stats = $this->getDailyStats();
        
        include __DIR__ . '/../views/lienhe/statsLienHe.php';
    }
    
    private function getDailyStats() {
        $conn = connectDB();
        $sql = "SELECT DATE(created_at) as date, COUNT(*) as count 
                FROM lienhe 
                WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY) 
                GROUP BY DATE(created_at) 
                ORDER BY date DESC";
        
        $stmt = $conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    private function sendReplyEmail($lienhe, $reply_message) {
        $to = $lienhe['email'];
        $subject = 'Phản hồi liên hệ: ' . $lienhe['subject'];
        
        $body = "
<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; text-align: center; }
        .content { background: #f8f9fa; padding: 30px; }
        .reply-box { background: white; padding: 20px; border-left: 4px solid #28a745; margin: 20px 0; }
        .original-message { background: #e9ecef; padding: 15px; margin-top: 20px; border-radius: 5px; }
        .footer { text-align: center; padding: 20px; color: #6c757d; font-size: 12px; }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h2>Phản hồi từ đội ngũ hỗ trợ</h2>
        </div>
        <div class='content'>
            <p>Xin chào <strong>{$lienhe['name']}</strong>,</p>
            <p>Cảm ơn bạn đã liên hệ với chúng tôi. Dưới đây là phản hồi cho yêu cầu của bạn:</p>
            
            <div class='reply-box'>
                <h4>Phản hồi của chúng tôi:</h4>
                <p>$reply_message</p>
            </div>
            
            <div class='original-message'>
                <h5>Tin nhắn gốc của bạn:</h5>
                <p><strong>Chủ đề:</strong> {$lienhe['subject']}</p>
                <p><strong>Nội dung:</strong> {$lienhe['message']}</p>
                <p><small>Gửi lúc: " . date('d/m/Y H:i', strtotime($lienhe['created_at'])) . "</small></p>
            </div>
            
            <p>Nếu bạn có thêm câu hỏi, vui lòng liên hệ với chúng tôi:</p>
            <ul>
                <li>Email: support@yourdomain.com</li>
                <li>Điện thoại: +84 123 456 789</li>
            </ul>
            
            <p>Trân trọng,<br><strong>Đội ngũ hỗ trợ khách hàng</strong></p>
        </div>
        <div class='footer'>
            Email này được gửi từ hệ thống quản lý liên hệ.
        </div>
    </div>
</body>
</html>";
        
        $headers = [
            'MIME-Version: 1.0',
            'Content-type: text/html; charset=UTF-8',
            'From: Support <support@yourdomain.com>',
            'X-Mailer: PHP/' . phpversion()
        ];
        
        @mail($to, $subject, $body, implode("\r\n", $headers));
    }
}
