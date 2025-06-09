<?php

// Kết nối CSDL qua PDO
function connectDB() {
    // Kết nối CSDL
    $host = DB_HOST;
    $port = DB_PORT;
    $dbname = DB_NAME;

    try {
        $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname", DB_USERNAME, DB_PASSWORD);

        // cài đặt chế độ báo lỗi là xử lý ngoại lệ
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // cài đặt chế độ trả dữ liệu
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
        return $conn;
    } catch (PDOException $e) {
        echo ("Connection failed: " . $e->getMessage());
    }
}
// theem file
 function uploadFile($file, $folderUpload){
    $partStorage = $folderUpload . time() . $file['name'];
    $from = $file['tmp_name'];
    $to = PATH_ROOT . $partStorage;
    if(move_uploaded_file($from, $to)){
        return $partStorage;
    }
    return null;
 }
 // xoa file
 function deleteFile($file){
    $pathDelete = PATH_ROOT .$file;
    if(file_exists($pathDelete)){
        unlink($pathDelete);
    }
 }
// xóa sesion sau khi load trang
function deleteSessionError(){
    if(isset($_SESSION['flash'])){
        // HUY SESION SAU KHI ĐÃ TẢI TRANG 
        unset($_SESSION['flash']);
        unset($_SESSION['error']);
        unset($_SESSION['success']);
        unset($_SESSION['errors']);
        unset($_SESSION['old_data']);
    }
}

// Function to display notification messages
function displayNotification() {
    $output = '';
    
    if (isset($_SESSION['error']) && isset($_SESSION['flash'])) {
        $output .= '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>' . $_SESSION['error'] . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
    }
    
    if (isset($_SESSION['success']) && isset($_SESSION['flash'])) {
        $output .= '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>' . $_SESSION['success'] . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
    }
    
    return $output;
}

// Function to get old form data for repopulating forms after validation errors
function old($field, $default = '') {
    return isset($_SESSION['old_data'][$field]) ? $_SESSION['old_data'][$field] : $default;
}

// Function to display field-specific error messages
function displayFieldError($field) {
    if (isset($_SESSION['errors'][$field])) {
        return '<span class="text-danger small">' . $_SESSION['errors'][$field] . '</span>';
    }
    return '';
}

//upload album ảnh
function uploadFileAlbum($file, $folderUpload, $key){
    $partStorage = $folderUpload . time() . $file['name'][$key];
    $from = $file['tmp_name'][$key];
    $to = PATH_ROOT . $partStorage;
    if(move_uploaded_file($from, $to)){
        return $partStorage;
    }
    return null;
 }

 function checkLoginAdmin() {
    if(!isset($_SESSION['user_admin'])) {
       require_once './views/auth/formLogin.php';
        exit();
    }
   }
 function formatPrice($price){
    return number_format($price, 0, ',', '.');
 }
