<?php
/**
 * Authentication System Test File
 * Test các chức năng xác thực đã được cải thiện
 */

session_start();
require_once 'commons/env.php';
require_once 'commons/function.php';
require_once 'commons/Security.php';

echo "<h1>Test Hệ Thống Xác Thực</h1>";

// Test 1: CSRF Token Generation
echo "<h2>1. Test CSRF Token</h2>";
Security::generateCSRFToken();
echo "CSRF Token đã tạo: " . ($_SESSION['csrf_token'] ?? 'Không tạo được') . "<br>";

// Test 2: Password Strength Validation
echo "<h2>2. Test Password Strength Validation</h2>";
$testPasswords = [
    'weak' => 'abc',
    'medium' => 'Password123',
    'strong' => 'MyStr0ng!P@ssw0rd'
];

foreach ($testPasswords as $level => $password) {
    echo "<strong>Password ($level): $password</strong><br>";
    $errors = Security::validatePasswordStrength($password);
    if (empty($errors)) {
        echo "✅ Mật khẩu đạt yêu cầu<br>";
    } else {
        echo "❌ Lỗi: " . implode(', ', $errors) . "<br>";
    }
    echo "<br>";
}

// Test 3: Input Sanitization
echo "<h2>3. Test Input Sanitization</h2>";
$maliciousInput = "<script>alert('XSS')</script>test@example.com";
$sanitized = Security::sanitizeInput($maliciousInput);
echo "Input gốc: " . htmlspecialchars($maliciousInput) . "<br>";
echo "Sau khi sanitize: $sanitized<br><br>";

// Test 4: Password Hashing
echo "<h2>4. Test Password Hashing</h2>";
$testPassword = "MySecurePassword123!";
$hashed = Security::hashPassword($testPassword);
echo "Password gốc: $testPassword<br>";
echo "Password hash: $hashed<br>";
echo "Verify password: " . (Security::verifyPassword($testPassword, $hashed) ? "✅ Đúng" : "❌ Sai") . "<br><br>";

// Test 5: Rate Limiting Simulation
echo "<h2>5. Test Rate Limiting</h2>";
$testEmail = "test@example.com";

echo "Mô phỏng 6 lần thử đăng nhập thất bại:<br>";
for ($i = 1; $i <= 6; $i++) {
    Security::recordLoginAttempt($testEmail);
    $isLimited = Security::isRateLimited($testEmail);
    echo "Lần thử $i: " . ($isLimited ? "🔒 Bị khóa" : "✅ Cho phép") . "<br>";
}

$remainingTime = Security::getRemainingLockoutTime($testEmail);
echo "Thời gian còn lại để mở khóa: " . ceil($remainingTime / 60) . " phút<br><br>";

// Test 6: Session Security Functions
echo "<h2>6. Test Session Functions</h2>";
$_SESSION['test_error'] = "Đây là lỗi test";
$_SESSION['test_success'] = "Đây là thông báo thành công test";
$_SESSION['flash'] = true;

echo "Notification output:<br>";
echo displayNotification();

// Clean up test data
echo "<h2>7. Clean Up</h2>";
Security::clearLoginAttempts($testEmail);
deleteSessionError();
echo "✅ Đã xóa dữ liệu test<br>";

echo "<hr>";
echo "<p><strong>Kết luận:</strong> Hệ thống xác thực đã được cải thiện với các tính năng bảo mật nâng cao.</p>";
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
h1 { color: #333; }
h2 { color: #666; margin-top: 30px; }
code { background: #f4f4f4; padding: 2px 4px; }
.alert { padding: 10px; margin: 10px 0; border-radius: 4px; }
.alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
.alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
</style>
