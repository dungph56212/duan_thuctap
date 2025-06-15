<?php
// controllers/LienHeController.php
require_once __DIR__ . '/../models/LienHe.php';

class LienHeController {
    public function index() {
        $success = false;
        $error = false;
        $reply_data = null;
        
        // Check for reply lookup
        if (isset($_GET['lookup']) && isset($_GET['email'])) {
            $email = trim($_GET['email']);
            $contact_id = isset($_GET['id']) ? (int)$_GET['id'] : null;
            
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // Get all contacts by email, including replies
                $reply_data = LienHe::getAllByEmail($email);
                
                // If specific contact ID provided, filter results
                if ($contact_id) {
                    $reply_data = array_filter($reply_data, function($item) use ($contact_id) {
                        return $item['id'] == $contact_id;
                    });
                }
            }
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $name = trim($_POST['name'] ?? '');
                $email = trim($_POST['email'] ?? '');
                $phone = trim($_POST['phone'] ?? '');
                $subject = trim($_POST['subject'] ?? '');
                $message = trim($_POST['message'] ?? '');
                
                // Validation
                if (empty($name) || empty($email) || empty($subject) || empty($message)) {
                    throw new Exception('Vui lòng điền đầy đủ thông tin bắt buộc.');
                }
                
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    throw new Exception('Email không hợp lệ.');
                }
                
                // Get user info
                $ip_address = $_SERVER['REMOTE_ADDR'] ?? null;
                $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? null;
                
                // Save to database
                $contact_id = LienHe::insert($name, $email, $phone, $subject, $message, $ip_address, $user_agent);
                
                // Send notification email to admin
                $this->sendAdminNotification($name, $email, $phone, $subject, $message, $contact_id);
                
                // Send confirmation email to customer
                $this->sendCustomerConfirmation($name, $email, $subject);
                
                $success = true;
                
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
        
        include_once __DIR__ . '/../views/lienhe.php';
    }
    
    /**
     * Gửi email thông báo cho admin
     */
    private function sendAdminNotification($name, $email, $phone, $subject, $message, $contact_id) {
        $to = 'admin@yourdomain.com'; // Thay bằng email quản trị viên thực tế
        $emailSubject = '[Website] Liên hệ mới #' . $contact_id . ' - ' . $subject;
        
        $body = "
<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #007bff; color: white; padding: 20px; text-align: center; }
        .content { background: #f8f9fa; padding: 30px; }
        .info-row { margin-bottom: 15px; }
        .label { font-weight: bold; color: #495057; }
        .value { color: #212529; }
        .message-box { background: white; padding: 20px; border-left: 4px solid #007bff; margin-top: 20px; }
        .footer { text-align: center; padding: 20px; color: #6c757d; font-size: 12px; }
        .btn { display: inline-block; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h2>Thông báo liên hệ mới từ website</h2>
        </div>
        <div class='content'>
            <div class='info-row'>
                <span class='label'>ID liên hệ:</span> 
                <span class='value'>#$contact_id</span>
            </div>
            <div class='info-row'>
                <span class='label'>Họ tên:</span> 
                <span class='value'>$name</span>
            </div>
            <div class='info-row'>
                <span class='label'>Email:</span> 
                <span class='value'>$email</span>
            </div>
            <div class='info-row'>
                <span class='label'>Điện thoại:</span> 
                <span class='value'>" . ($phone ?: 'Không cung cấp') . "</span>
            </div>
            <div class='info-row'>
                <span class='label'>Chủ đề:</span> 
                <span class='value'>$subject</span>
            </div>
            <div class='info-row'>
                <span class='label'>Thời gian:</span> 
                <span class='value'>" . date('d/m/Y H:i:s') . "</span>
            </div>
            <div class='message-box'>
                <div class='label'>Nội dung:</div>
                <div class='value'>$message</div>
            </div>
            <div style='text-align: center; margin-top: 30px;'>
                <a href='http://yourdomain.com/admin/index.php?ctl=lienhe&act=view&id=$contact_id' class='btn'>Xem chi tiết trong Admin</a>
            </div>
        </div>
        <div class='footer'>
            Email này được gửi tự động từ hệ thống website.
        </div>
    </div>
</body>
</html>";
        
        $headers = [
            'MIME-Version: 1.0',
            'Content-type: text/html; charset=UTF-8',
            'From: Website <no-reply@yourdomain.com>',
            'Reply-To: ' . $email,
            'X-Mailer: PHP/' . phpversion()
        ];
        
        @mail($to, $emailSubject, $body, implode("\r\n", $headers));
    }
    
    /**
     * Gửi email xác nhận cho khách hàng
     */
    private function sendCustomerConfirmation($name, $email, $subject) {
        $emailSubject = 'Xác nhận đã nhận liên hệ - ' . $subject;
        
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
        .footer { text-align: center; padding: 20px; color: #6c757d; font-size: 12px; }
        .highlight { color: #007bff; font-weight: bold; }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h2>Cảm ơn bạn đã liên hệ!</h2>
        </div>
        <div class='content'>
            <p>Xin chào <strong>$name</strong>,</p>
            <p>Chúng tôi đã nhận được liên hệ của bạn về chủ đề: <span class='highlight'>$subject</span></p>
            <p>Đội ngũ hỗ trợ khách hàng sẽ xem xét và phản hồi trong thời gian sớm nhất, thường trong vòng <strong>24 giờ</strong>.</p>
            <p>Nếu cần hỗ trợ gấp, vui lòng liên hệ:</p>
            <ul>
                <li>Điện thoại: <strong>+84 123 456 789</strong></li>
                <li>Email: <strong>support@yourdomain.com</strong></li>
            </ul>
            <p>Trân trọng,<br><strong>Đội ngũ hỗ trợ khách hàng</strong></p>
        </div>
        <div class='footer'>
            Email này được gửi tự động. Vui lòng không phản hồi email này.
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
        
        @mail($email, $emailSubject, $body, implode("\r\n", $headers));
    }
}
