<?php 

// Biến môi trường, dùng chung toàn hệ thống
// Khai báo dưới dạng HẰNG SỐ để không phải dùng $GLOBALS

define('BASE_URL'   , 'http://localhost/duan_thuctap/');
define('BASE_URL_ADMIN'   , 'http://localhost/duan_thuctap/admin/');

define('DB_HOST'    , 'localhost');
define('DB_PORT'    , 3306);
define('DB_NAME'    , 'du-an-1-wd19314');  // Tên database
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');

define('PATH_ROOT'    , __DIR__ . '/../');

// Helper function to fix image URL path
function getImageUrl($imagePath) {
    // Remove leading slash if it exists to prevent double slashes
    $cleanPath = ltrim($imagePath, '/');
    return BASE_URL . $cleanPath;
}
