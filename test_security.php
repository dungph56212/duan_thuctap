<?php
session_start();

// Include necessary files
require_once './commons/Security.php';
require_once './commons/function.php';

echo "<h2>Test Security Class - Hệ thống bảo mật</h2>";

// Test 1: CSRF Token Generation
echo "<h3>1. Test CSRF Token Generation</h3>";
$token1 = Security::generateCSRFToken();
$token2 = Security::generateCSRFToken();
echo "Token 1: " . $token1 . "<br>";
echo "Token 2: " . $token2 . "<br>";
echo "Same token (should be true): " . ($token1 === $token2 ? 'YES' : 'NO') . "<br><br>";

// Test 2: CSRF Token Validation
echo "<h3>2. Test CSRF Token Validation</h3>";
$validToken = $_SESSION['csrf_token'];
$invalidToken = 'invalid_token';
echo "Valid token validation: " . (Security::validateCSRFToken($validToken) ? 'PASS' : 'FAIL') . "<br>";
echo "Invalid token validation: " . (Security::validateCSRFToken($invalidToken) ? 'FAIL' : 'PASS') . "<br><br>";

// Test 3: Password Strength Validation
echo "<h3>3. Test Password Strength Validation</h3>";
$passwords = [
    'weak' => '123',
    'medium' => 'password123',
    'strong' => 'MyStr0ng!Pass'
];

foreach ($passwords as $type => $password) {
    $errors = Security::validatePasswordStrength($password);
    echo "Password '{$password}' ({$type}): ";
    if (empty($errors)) {
        echo "STRONG<br>";
    } else {
        echo "WEAK - " . implode(', ', $errors) . "<br>";
    }
}
echo "<br>";

// Test 4: Password Hashing
echo "<h3>4. Test Password Hashing</h3>";
$plainPassword = 'MyTestPassword123!';
$hashedPassword = Security::hashPassword($plainPassword);
echo "Plain password: " . $plainPassword . "<br>";
echo "Hashed password: " . $hashedPassword . "<br>";
echo "Password verification: " . (password_verify($plainPassword, $hashedPassword) ? 'PASS' : 'FAIL') . "<br><br>";

// Test 5: Input Sanitization
echo "<h3>5. Test Input Sanitization</h3>";
$dangerousInput = '<script>alert("XSS")</script><h1>Test</h1>';
$sanitizedInput = Security::sanitizeInput($dangerousInput);
echo "Original: " . $dangerousInput . "<br>";
echo "Sanitized: " . $sanitizedInput . "<br><br>";

// Test 6: Rate Limiting
echo "<h3>6. Test Rate Limiting</h3>";
$testEmail = 'test@example.com';

// Clear any existing attempts
Security::clearLoginAttempts($testEmail);
echo "Initial rate limit check: " . (Security::isRateLimited($testEmail) ? 'LIMITED' : 'OK') . "<br>";

// Record some failed attempts
for ($i = 1; $i <= 6; $i++) {
    Security::recordLoginAttempt($testEmail);
    $isLimited = Security::isRateLimited($testEmail);
    echo "After attempt {$i}: " . ($isLimited ? 'LIMITED' : 'OK');
    if ($isLimited) {
        $remaining = Security::getRemainingLockoutTime($testEmail);
        echo " (Remaining: {$remaining} seconds)";
    }
    echo "<br>";
}

// Clear attempts
Security::clearLoginAttempts($testEmail);
echo "After clearing attempts: " . (Security::isRateLimited($testEmail) ? 'LIMITED' : 'OK') . "<br><br>";

// Test 7: Helper Functions
echo "<h3>7. Test Helper Functions</h3>";

// Test displayNotification
$_SESSION['success'] = 'Test success message';
$_SESSION['flash'] = true;
echo "Success notification: " . displayNotification() . "<br>";

$_SESSION['error'] = 'Test error message';
$_SESSION['flash'] = true;
echo "Error notification: " . displayNotification() . "<br>";

// Test old() function
$_SESSION['old_data'] = ['email' => 'test@example.com', 'name' => 'Test User'];
echo "Old email value: " . old('email') . "<br>";
echo "Old name value: " . old('name') . "<br>";
echo "Non-existent old value: " . old('nonexistent') . "<br>";

// Test displayFieldError
$_SESSION['errors'] = ['email' => 'Email is required', 'password' => 'Password is too weak'];
echo "Email field error: " . displayFieldError('email') . "<br>";
echo "Password field error: " . displayFieldError('password') . "<br>";
echo "Non-existent field error: " . displayFieldError('nonexistent') . "<br>";

echo "<h3>All tests completed!</h3>";
echo "<p><a href='?act=login'>Test Login Form</a> | <a href='?act=register'>Test Register Form</a></p>";
?>
