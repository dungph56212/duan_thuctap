<?php 
session_start();

// Require file Common
require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
require_once './controllers/HomeController.php';

// Require toàn bộ file Models
require_once './models/SanPham.php';
require_once './models/TaiKhoan.php';
require_once './models/GioHang.php';
require_once './models/DonHang.php';
// Route
$act = $_GET['act'] ?? '/';
// var_dump($_GET['act']);die();
// if( $_GET['act']) {
//     $act = $_GET['act'];

// }else{
//     $act = '/';
// }

// Để bảo bảo tính chất chỉ gọi 1 hàm Controller để xử lý request thì mình sử dụng match

match ($act) {
    //route
    '/'                 => (new HomeController())->home(),
    'trangchu'           =>(new HomeController())->trangchu(),
    'danh-sach-san-pham' =>(new HomeController())->danhSachSanPham(),
    'chi-tiet-san-pham' => (new HomeController())->chiTietSanPham(),
    'them-gio-hang'     =>(new HomeController())->addGioHang(),
    'gio-hang'         =>(new HomeController())->gioHang(),
    'thanh-toan'         =>(new HomeController())->thanhToan(),
    'xu-ly-thanh-toan'         =>(new HomeController())->postThanhToan(),
    //auth    
    'login'  => (new HomeController())->formLogin(),
    'check-login'  => (new HomeController())->postLogin(),
    'register'  => (new HomeController())-> registers(),
};