<?php 
session_start();
// Require file Common
require_once '../commons/env.php'; // Khai báo biến môi trường
require_once '../commons/function.php'; // Hàm hỗ trợ


// Require toàn bộ file Controllers
require_once './controllers/AdminDanhMucController.php';
require_once './controllers/AdminSanPhamController.php';
require_once './controllers/AdminBaoCaoThongKeController.php';
require_once './controllers/AdminTaiKhoanController.php';
require_once './controllers/AdminDonHangController.php';
require_once './controllers/AdminBinhLuanController.php';
require_once './controllers/KhuyenMaiController.php';

// Require toàn bộ file Models
require_once './models/AdminDanhMuc.php';
require_once './models/AdminSanPham.php';
require_once './models/AdminTaiKhoan.php';
require_once './models/AdminBaoCaoThongKe.php';
require_once './models/AdminDonHang.php';
require_once './models/AdminBinhLuan.php';
// Route
$act = $_GET['act'] ?? '';

if($act !=='login-admin' && $act !=='check-login-admin' && $act !=='logout-admin') {
  checkLoginAdmin();
}

// Để bảo bảo tính chất chỉ gọi 1 hàm Controller để xử lý request thì mình sử dụng match

match ($act) {  
  //route báo cáo thống kê - trang chủ
  ''=>(new AdminBaoCaoThongKeController())->home(),

  //route danh mục
  'danh-muc' => (new AdminDanhMucController())->danhSachDanhMuc(),
  'form-them-danh-muc' => (new AdminDanhMucController())->formAddDanhMuc(),
  'them-danh-muc' => (new AdminDanhMucController())->postAddDanhMuc(),
  'form-sua-danh-muc' => (new AdminDanhMucController())->formEditDanhMuc(),
  'sua-danh-muc' => (new AdminDanhMucController())->postEditDanhMuc(),
  'xoa-danh-muc' => (new AdminDanhMucController())->deleteDanhMuc(),
 
 //route sản phẩm
 'san-pham' => (new AdminSanPhamController())->danhSachSanPham(),
 'form-them-san-pham' => (new AdminSanPhamController())->formAddSanPham(),
 'them-san-pham' => (new AdminSanPhamController())->postAddSanPham(),
 'form-sua-san-pham' => (new AdminSanPhamController())->formEditSanPham(),
 'sua-san-pham' => (new AdminSanPhamController())->postEditSanPham(),
 'sua-album-anh-san-pham' => (new AdminSanPhamController())->postEditAnhSanPham(),
 'xoa-san-pham' => (new AdminSanPhamController())->deleteSanPham(),
 'chi-tiet-san-pham' => (new AdminSanPhamController())->detailSanPham(),
//  'xoa-san-pham' => (new AdminSanPhamController())->deleteSanPham(),

// bình luận
'update-trang-thai-binh-luan' =>(new AdminSanPhamController())->updateTrangThaiBinhLuan(),

// quản lý bình luận
'binh-luan' => (new AdminBinhLuanController())->danhSachBinhLuan(),
'chi-tiet-binh-luan' => (new AdminBinhLuanController())->chiTietBinhLuan(),
'cap-nhat-trang-thai-binh-luan' => (new AdminBinhLuanController())->updateTrangThaiBinhLuan(),
'duyet-hang-loat-binh-luan' => (new AdminBinhLuanController())->duyetHangLoatBinhLuan(),
'xoa-binh-luan' => (new AdminBinhLuanController())->xoaBinhLuan(),
'filter-binh-luan' => (new AdminBinhLuanController())->filterBinhLuan(),
'tra-loi-binh-luan' => (new AdminBinhLuanController())->traLoiBinhLuan(),
'bao-cao-binh-luan' => (new AdminBinhLuanController())->baoCaoBinhLuan(),
'get-pending-comments-count' => (new AdminBinhLuanController())->getPendingCommentsCount(),

//route quản lý tài khoản
  //quản lý tài khoản quản trị
  'list-tai-khoan-quan-tri' => (new AdminTaiKhoanController())->danhSachQuanTri(),
  'form-them-quan-tri' => (new AdminTaiKhoanController())->formAddQuanTri(),
  'them-quan-tri' => (new AdminTaiKhoanController())->postAddQuanTri(),
  'form-sua-quan-tri' => (new AdminTaiKhoanController())->formEditQuanTri(),
  'sua-quan-tri' => (new AdminTaiKhoanController())->postEditQuanTri(),
  // route reset password tk
  'reset-password-admin' =>(new AdminTaiKhoanController())->resetPassword(),

  // khách hàng
  'list-tai-khoan-khach-hang' =>(new AdminTaiKhoanController())->danhSachKhachHang(),
    
  'from-sua-khach-hang' =>(new AdminTaiKhoanController())->formEditKhachHang(),
  'sua-khach-hang' =>(new AdminTaiKhoanController())->postEditKhachHang(),  
  'chi-tiet-khach-hang' =>(new AdminTaiKhoanController())->detailKhachHang(),

  // route quản lí tài khoản cá nhân(quản trị)
  'form-sua-thong-tin-ca-nhan-quan-tri' =>(new AdminTaiKhoanController())->formEditCaNhanQuanTri(),
  'sua-thong-tin-ca-nhan-quan-tri' =>(new AdminTaiKhoanController())->postEditCaNhanQuanTri(),
  'sua-mat-khau-ca-nhan-quan-tri' =>(new AdminTaiKhoanController())->postEditMatKhauCaNhan(),


  //route auth
  'login-admin' =>(new AdminTaiKhoanController())->formLogin(),
  'check-login-admin' =>(new AdminTaiKhoanController())->login(),
  'logout-admin' =>(new AdminTaiKhoanController())->logout(),

 
//  //route đơn hàng
 'don-hang' => (new AdminDonHangController())->danhSachDonHang(),
 'form-sua-don-hang' => (new AdminDonHangController())->formEditDonHang(),
 'sua-don-hang' => (new AdminDonHangController())->postEditDonHang(),
//  'xoa-don-hang' => (new AdminDonHangController())->deleteDonHang(),
//  'sua-don-hang' => (new AdminDonHangController())->postEditDonHang(),
 'chi-tiet-don-hang' => (new AdminDonHangController())->detailDonHang(), // route quản lý tồn kho
 'quan-ly-ton-kho' => (new AdminBaoCaoThongKeController())->inventoryManagement(),
 'cap-nhat-ton-kho' => (new AdminBaoCaoThongKeController())->quickStockUpdate(),
 'cap-nhat-hang-loat-ton-kho' => (new AdminBaoCaoThongKeController())->bulkStockUpdate(),
 'xuat-bao-cao-ton-kho' => (new AdminBaoCaoThongKeController())->exportInventoryReport(),
 'lich-su-ton-kho' => (new AdminBaoCaoThongKeController())->inventoryHistory(),
 'canh-bao-ton-kho' => (new AdminBaoCaoThongKeController())->inventoryAlerts(),
 'danh-dau-da-doc-canh-bao' => (new AdminBaoCaoThongKeController())->markAlertRead(),
 'ajax-get-alerts' => (new AdminBaoCaoThongKeController())->getAjaxAlerts(),

// Quản lý khuyến mãi
'danh-sach-khuyen-mai' => (new KhuyenMaiController())->danhSachKhuyenMai(),
'form-them-khuyen-mai' => (new KhuyenMaiController())->formAddKhuyenMai(),
'them-khuyen-mai' => (new KhuyenMaiController())->postAddKhuyenMai(),
'form-sua-khuyen-mai' => (new KhuyenMaiController())->formEditKhuyenMai(),
'sua-khuyen-mai' => (new KhuyenMaiController())->postEditKhuyenMai(),
'xoa-khuyen-mai' => (new KhuyenMaiController())->deleteKhuyenMai(),

// Quản lý khuyến mãi nâng cao
'khuyen-mai-dang-hoat-dong' => (new KhuyenMaiController())->activeKhuyenMai(),
'khuyen-mai-sap-het-han' => (new KhuyenMaiController())->expiringKhuyenMai(),
'khuyen-mai-da-het-han' => (new KhuyenMaiController())->expiredKhuyenMai(),
'bao-cao-khuyen-mai' => (new KhuyenMaiController())->baoCaoKhuyenMai(),
'cai-dat-khuyen-mai' => (new KhuyenMaiController())->caiDatKhuyenMai(),
'post-cai-dat-khuyen-mai' => (new KhuyenMaiController())->postCaiDatKhuyenMai(),
'toggle-promotion-status' => (new KhuyenMaiController())->togglePromotionStatus(),
'duplicate-promotion' => (new KhuyenMaiController())->duplicatePromotion(),
'export-promotion-report' => (new KhuyenMaiController())->exportPromotionReport(),
'get-promotion-counts' => (new KhuyenMaiController())->getPromotionCounts(),

default => header("Location: " . BASE_URL_ADMIN)
};