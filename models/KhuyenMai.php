<?php
class KhuyenMai {
    public $conn;
    public function __construct() {
        $this->conn = connectDB();
    }
    public function getAllKhuyenMai() {
        $sql = "SELECT * FROM khuyen_mai ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getKhuyenMaiById($id) {
        $sql = "SELECT * FROM khuyen_mai WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
    public function addKhuyenMai($data) {
        $sql = "INSERT INTO khuyen_mai (ma_khuyen_mai, ten_khuyen_mai, mo_ta, phan_tram_giam, gia_giam, so_luong, so_lan_su_dung, ngay_bat_dau, ngay_ket_thuc, trang_thai) VALUES (:ma_khuyen_mai, :ten_khuyen_mai, :mo_ta, :phan_tram_giam, :gia_giam, :so_luong, :so_lan_su_dung, :ngay_bat_dau, :ngay_ket_thuc, :trang_thai)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }
    public function updateKhuyenMai($id, $data) {
        $sql = "UPDATE khuyen_mai SET ma_khuyen_mai=:ma_khuyen_mai, ten_khuyen_mai=:ten_khuyen_mai, mo_ta=:mo_ta, phan_tram_giam=:phan_tram_giam, gia_giam=:gia_giam, so_luong=:so_luong, so_lan_su_dung=:so_lan_su_dung, ngay_bat_dau=:ngay_bat_dau, ngay_ket_thuc=:ngay_ket_thuc, trang_thai=:trang_thai WHERE id=:id";
        $data['id'] = $id;
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }
    public function deleteKhuyenMai($id) {
        $sql = "DELETE FROM khuyen_mai WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
    public function getKhuyenMaiByCode($ma_khuyen_mai) {
        $sql = "SELECT * FROM khuyen_mai WHERE ma_khuyen_mai = :ma_khuyen_mai";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':ma_khuyen_mai' => $ma_khuyen_mai]);
        return $stmt->fetch();
    }
    public function checkMaKhuyenMai($ma) {
        $sql = "SELECT * FROM khuyen_mai WHERE ma_khuyen_mai = :ma AND trang_thai = 1 AND so_luong > 0 AND ngay_bat_dau <= NOW() AND ngay_ket_thuc >= NOW()";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':ma' => $ma]);
        return $stmt->fetch();
    }
    public function updateUsageCount($id) {
        $sql = "UPDATE khuyen_mai SET so_lan_su_dung = so_lan_su_dung + 1, so_luong = so_luong - 1 WHERE id = :id AND so_luong > 0";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}