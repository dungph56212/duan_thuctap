<?php
require_once './models/TaiKhoan.php';

class ForgotPasswordController {
    public $model;
    public function __construct() {
        $this->model = new TaiKhoan();
    }

    // Hiển thị form quên mật khẩu và xử lý gửi mail
    public function forgotPassword() {
        $message = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['email'])) {
            $email = $_POST['email'];
            error_log('EMAIL NHAP: ' . $email);
            $user = $this->model->getUserByEmail($email);
            if (!$user) {
                error_log('KHONG TIM THAY USER: ' . $email);
            }
            if ($user) {
                $token = bin2hex(random_bytes(32));
                $this->model->saveResetToken($email, $token);
                // Gửi mail thật ở đây nếu có SMTP, còn không thì hiển thị link
                $resetLink = BASE_URL . '?act=reset-password&token=' . $token;
                $message = 'Link đặt lại mật khẩu: <a href="' . $resetLink . '">' . $resetLink . '</a>';
            } else {
                $message = 'Email không tồn tại trong hệ thống!';
            }
        }
        include './views/forgot_password.php';
    }

    // Hiển thị form đặt lại mật khẩu và xử lý cập nhật mật khẩu
    public function resetPassword() {
        $message = '';
        $token = $_GET['token'] ?? $_POST['token'] ?? '';
        if (!$token) {
            $message = 'Token không hợp lệ!';
            include './views/reset_password.php';
            return;
        }
        $email = $this->model->getEmailByToken($token);
        if (!$email) {
            $message = 'Token không hợp lệ hoặc đã hết hạn!';
            include './views/reset_password.php';
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['password'])) {
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];
            if ($password !== $password_confirm) {
                $message = 'Mật khẩu nhập lại không khớp!';
            } else {
                $this->model->updatePasswordByEmail($email, $password);
                $this->model->deleteResetToken($token);
                $message = 'Đặt lại mật khẩu thành công! Bạn có thể đăng nhập lại.';
            }
        }
        include './views/reset_password.php';
    }
} 