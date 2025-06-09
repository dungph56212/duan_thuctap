# Hệ Thống Xác Thực Cải Tiến - Hướng Dẫn Sử Dụng

## Tổng Quan

Hệ thống xác thực đã được cải tiến với các tính năng bảo mật nâng cao và trải nghiệm người dùng tốt hơn.

## Các Tính Năng Mới

### 1. Bảo Mật CSRF (Cross-Site Request Forgery)
- Tự động tạo và xác thực CSRF token cho mọi form
- Bảo vệ chống các cuộc tấn công giả mạo request

### 2. Rate Limiting (Giới Hạn Tốc Độ)
- Giới hạn số lần thử đăng nhập: 5 lần trong 15 phút
- Tự động khóa tài khoản khi vượt quá giới hạn
- Hiển thị thời gian còn lại để thử lại

### 3. Validation Mạnh Mẽ
- Kiểm tra định dạng email chính xác
- Validation mật khẩu mạnh:
  - Tối thiểu 8 ký tự
  - Có chữ hoa, chữ thường
  - Có số và ký tự đặc biệt
- Sanitization input để chống XSS

### 4. Mã Hóa Mật Khẩu Nâng Cao
- Sử dụng Argon2ID algorithm
- Bảo mật cao hơn PASSWORD_DEFAULT

### 5. Thông Báo Thân Thiện
- Thông báo lỗi chi tiết cho từng trường
- Tự động ẩn thông báo sau 5 giây
- Hiệu ứng loading khi submit form
- Repopulation form data khi có lỗi

## Cấu Trúc File

### Commons/Security.php
Lớp xử lý bảo mật chính:
```php
Security::generateCSRFToken()          // Tạo CSRF token
Security::validateCSRFToken($token)    // Xác thực CSRF token
Security::hashPassword($password)      // Mã hóa mật khẩu
Security::verifyPassword($pass, $hash) // Xác thực mật khẩu
Security::sanitizeInput($input)        // Làm sạch input
Security::validatePasswordStrength()   // Kiểm tra độ mạnh mật khẩu
Security::isRateLimited($email)        // Kiểm tra rate limit
Security::recordLoginAttempt($email)   // Ghi nhận thử đăng nhập
```

### Commons/function.php
Các helper functions:
```php
displayNotification()                  // Hiển thị thông báo
old($field)                           // Lấy dữ liệu form cũ
displayFieldError($field)             // Hiển thị lỗi trường
deleteSessionError()                  // Xóa session lỗi
```

## Sử Dụng Trong Controller

### Đăng Nhập
```php
public function postLogin() {
    // 1. Xác thực CSRF token
    if (!Security::validateCSRFToken($_POST['csrf_token'])) {
        $_SESSION['error'] = "Token bảo mật không hợp lệ";
        return;
    }
    
    // 2. Sanitize input
    $email = Security::sanitizeInput(trim($_POST['email']));
    
    // 3. Kiểm tra rate limiting
    if (Security::isRateLimited($email)) {
        $minutes = ceil(Security::getRemainingLockoutTime($email) / 60);
        $_SESSION['error'] = "Thử lại sau {$minutes} phút";
        return;
    }
    
    // 4. Xử lý đăng nhập
    // ...
}
```

### Đăng Ký
```php
public function registers() {
    // 1. Tạo CSRF token cho GET request
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        Security::generateCSRFToken();
        require_once './views/auth/register.php';
        return;
    }
    
    // 2. Xác thực và xử lý POST request
    // ...
}
```

## Sử Dụng Trong View

### Form Đăng Nhập
```html
<form method="post">
    <!-- CSRF Token -->
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
    
    <!-- Email field -->
    <input type="email" name="email" value="<?= old('email') ?>" required>
    <?= displayFieldError('email') ?>
    
    <!-- Password field -->
    <input type="password" name="password" required>
    <?= displayFieldError('password') ?>
    
    <button type="submit">Đăng Nhập</button>
</form>

<!-- Hiển thị thông báo -->
<?= displayNotification() ?>
```

## JavaScript Enhancements

### Auto-hide Notifications
```javascript
// Tự động ẩn thông báo sau 5 giây
setTimeout(() => {
    document.querySelectorAll('.alert').forEach(alert => {
        alert.style.display = 'none';
    });
}, 5000);
```

### Loading States
```javascript
// Hiển thị loading khi submit form
document.querySelector('form').addEventListener('submit', function() {
    const button = this.querySelector('button[type="submit"]');
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';
    button.disabled = true;
});
```

## Testing

Chạy file test để kiểm tra hệ thống:
```
http://your-domain/duan_thuctap/test_auth.php
```

## Best Practices

1. **Luôn validate CSRF token** cho mọi form POST
2. **Sanitize input** trước khi xử lý
3. **Hash password** với Argon2ID
4. **Implement rate limiting** cho các action nhạy cảm
5. **Hiển thị thông báo** thân thiện với người dùng
6. **Log security events** để monitor

## Troubleshooting

### Lỗi "Token bảo mật không hợp lệ"
- Kiểm tra session có hoạt động không
- Đảm bảo CSRF token được tạo trước khi hiển thị form

### Rate Limiting Không Hoạt Động
- Kiểm tra session storage
- Verify logic thời gian trong Security class

### Form Data Không Repopulate
- Đảm bảo old() function được gọi đúng
- Kiểm tra $_SESSION['old_data'] có được set không

## Security Checklist

- [x] CSRF Protection
- [x] Rate Limiting  
- [x] Password Hashing (Argon2ID)
- [x] Input Sanitization
- [x] Email Validation
- [x] Password Strength Validation
- [x] Session Security
- [x] Error Handling
- [x] User Experience Improvements

## Tác Giả
Hệ thống được phát triển với focus vào bảo mật và trải nghiệm người dùng.
