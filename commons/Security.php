<?php

class Security {
    
    /**
     * Generate CSRF token
     */
    public static function generateCSRFToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    /**
     * Validate CSRF token
     */
    public static function validateCSRFToken($token) {
        if (!isset($_SESSION['csrf_token'])) {
            return false;
        }
        
        return hash_equals($_SESSION['csrf_token'], $token);
    }
    
    /**
     * Check rate limiting for login attempts
     */
    public static function checkLoginRateLimit($ip, $maxAttempts = 5, $timeWindow = 300) {
        $key = 'login_attempts_' . $ip;
        
        if (!isset($_SESSION[$key])) {
            $_SESSION[$key] = [
                'attempts' => 0,
                'last_attempt' => time()
            ];
        }
        
        $data = $_SESSION[$key];
        
        // Reset if time window has passed
        if (time() - $data['last_attempt'] > $timeWindow) {
            $_SESSION[$key] = [
                'attempts' => 0,
                'last_attempt' => time()
            ];
            return true;
        }
        
        // Check if max attempts exceeded
        if ($data['attempts'] >= $maxAttempts) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Record failed login attempt
     */
    public static function recordFailedLogin($ip) {
        $key = 'login_attempts_' . $ip;
        
        if (!isset($_SESSION[$key])) {
            $_SESSION[$key] = [
                'attempts' => 0,
                'last_attempt' => time()
            ];
        }
        
        $_SESSION[$key]['attempts']++;
        $_SESSION[$key]['last_attempt'] = time();
    }
    
    /**
     * Reset login attempts on successful login
     */
    public static function resetLoginAttempts($ip) {
        $key = 'login_attempts_' . $ip;
        unset($_SESSION[$key]);
    }
    
    /**
     * Get remaining time for rate limit
     */
    public static function getRemainingTimeLimit($ip, $timeWindow = 300) {
        $key = 'login_attempts_' . $ip;
        
        if (!isset($_SESSION[$key])) {
            return 0;
        }
        
        $data = $_SESSION[$key];
        $remaining = $timeWindow - (time() - $data['last_attempt']);
        
        return max(0, $remaining);
    }
    
    /**
     * Sanitize input data
     */
    public static function sanitizeInput($data) {
        if (is_array($data)) {
            return array_map([self::class, 'sanitizeInput'], $data);
        }
        
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Generate secure password hash
     */
    public static function hashPassword($password) {
        return password_hash($password, PASSWORD_ARGON2ID, [
            'memory_cost' => 65536, // 64MB
            'time_cost' => 4,       // 4 iterations
            'threads' => 3,         // 3 threads
        ]);
    }
    
    /**
     * Check password strength
     */
    public static function checkPasswordStrength($password) {
        $errors = [];
        
        if (strlen($password) < 8) {
            $errors[] = "Mật khẩu phải có ít nhất 8 ký tự";
        }
        
        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = "Mật khẩu phải có ít nhất 1 chữ cái in hoa";
        }
        
        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = "Mật khẩu phải có ít nhất 1 chữ cái thường";
        }
        
        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = "Mật khẩu phải có ít nhất 1 số";
        }
        
        if (!preg_match('/[^A-Za-z0-9]/', $password)) {
            $errors[] = "Mật khẩu phải có ít nhất 1 ký tự đặc biệt";
        }
        
        return $errors;
    }
    
    /**
     * Check if email-based rate limiting is active
     */
    public static function isRateLimited($email) {
        $maxAttempts = 5;
        $timeWindow = 900; // 15 minutes
        
        if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = [];
        }
        
        if (!isset($_SESSION['login_attempts'][$email])) {
            return false;
        }
        
        $attempts = $_SESSION['login_attempts'][$email];
        $recentAttempts = array_filter($attempts, function($timestamp) use ($timeWindow) {
            return (time() - $timestamp) < $timeWindow;
        });
        
        return count($recentAttempts) >= $maxAttempts;
    }
    
    /**
     * Record login attempt for specific email
     */
    public static function recordLoginAttempt($email) {
        if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = [];
        }
        
        if (!isset($_SESSION['login_attempts'][$email])) {
            $_SESSION['login_attempts'][$email] = [];
        }
        
        $_SESSION['login_attempts'][$email][] = time();
        
        // Keep only last 10 attempts to prevent memory issues
        if (count($_SESSION['login_attempts'][$email]) > 10) {
            $_SESSION['login_attempts'][$email] = array_slice($_SESSION['login_attempts'][$email], -10);
        }
    }
    
    /**
     * Clear login attempts for specific email
     */
    public static function clearLoginAttempts($email) {
        if (isset($_SESSION['login_attempts'][$email])) {
            unset($_SESSION['login_attempts'][$email]);
        }
    }
    
    /**
     * Get remaining lockout time for specific email
     */
    public static function getRemainingLockoutTime($email) {
        $timeWindow = 900; // 15 minutes
        
        if (!isset($_SESSION['login_attempts'][$email])) {
            return 0;
        }
        
        $lastAttempt = max($_SESSION['login_attempts'][$email]);
        $remainingTime = $timeWindow - (time() - $lastAttempt);
        
        return max(0, $remainingTime);
    }
    
    /**
     * Validate password strength
     */
    public static function validatePasswordStrength($password) {
        $errors = [];
        
        if (strlen($password) < 8) {
            $errors[] = "Mật khẩu phải có ít nhất 8 ký tự";
        }
        
        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = "Mật khẩu phải có ít nhất 1 chữ hoa";
        }
        
        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = "Mật khẩu phải có ít nhất 1 chữ thường";
        }
        
        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = "Mật khẩu phải có ít nhất 1 số";
        }
        
        if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
            $errors[] = "Mật khẩu phải có ít nhất 1 ký tự đặc biệt";
        }
        
        return $errors;
    }
}
