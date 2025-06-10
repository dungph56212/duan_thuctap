<?php
require_once './models/KhuyenMai.php';
class KhuyenMaiController {
    public $model;
    public function __construct() {
        $this->model = new KhuyenMai();
    }
    public function danhSachKhuyenMai() {
        $list = $this->model->getAllKhuyenMai();
        require './views/khuyenmai/listKhuyenMai.php';
    }
    public function formAddKhuyenMai() {
        require './views/khuyenmai/addKhuyenMai.php';
    }
    public function postAddKhuyenMai() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'ma_khuyen_mai' => $_POST['ma_khuyen_mai'],
                'ten_khuyen_mai' => $_POST['ten_khuyen_mai'],
                'mo_ta' => $_POST['mo_ta'],
                'phan_tram_giam' => $_POST['phan_tram_giam'],
                'gia_giam' => $_POST['gia_giam'],
                'so_luong' => $_POST['so_luong'],
                'so_lan_su_dung' => $_POST['so_lan_su_dung'],
                'ngay_bat_dau' => $_POST['ngay_bat_dau'],
                'ngay_ket_thuc' => $_POST['ngay_ket_thuc'],
                'trang_thai' => $_POST['trang_thai'] ?? 1
            ];
            $this->model->addKhuyenMai($data);
            header('Location: ?act=danh-sach-khuyen-mai');
            exit();
        }
    }
    public function formEditKhuyenMai() {
        $id = $_GET['id'] ?? 0;
        $km = $this->model->getKhuyenMaiById($id);
        require './views/khuyenmai/editKhuyenMai.php';
    }
    public function postEditKhuyenMai() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $data = [
                'ma_khuyen_mai' => $_POST['ma_khuyen_mai'],
                'ten_khuyen_mai' => $_POST['ten_khuyen_mai'],
                'mo_ta' => $_POST['mo_ta'],
                'phan_tram_giam' => $_POST['phan_tram_giam'],
                'gia_giam' => $_POST['gia_giam'],
                'so_luong' => $_POST['so_luong'],
                'so_lan_su_dung' => $_POST['so_lan_su_dung'],
                'ngay_bat_dau' => $_POST['ngay_bat_dau'],
                'ngay_ket_thuc' => $_POST['ngay_ket_thuc'],
                'trang_thai' => $_POST['trang_thai'] ?? 1
            ];
            $this->model->updateKhuyenMai($id, $data);
            header('Location: ?act=danh-sach-khuyen-mai');
            exit();
        }
    }
    public function deleteKhuyenMai() {
        $id = $_GET['id'] ?? 0;
        $this->model->deleteKhuyenMai($id);
        header('Location: ?act=danh-sach-khuyen-mai');
        exit();
    }
    // Form nhập mã khuyến mãi cho user
    public function nhapMaKhuyenMai() {
        $message = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ma = $_POST['ma_khuyen_mai'];
            $km = $this->model->checkMaKhuyenMai($ma);
            if ($km) {
                $message = 'Áp dụng mã thành công!';
            } else {
                $message = 'Mã không hợp lệ hoặc đã hết hạn!';
            }
        }
        require './views/khuyenmai/nhapMaKhuyenMai.php';
    }
} 