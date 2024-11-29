<?php
class SanPham {
    public $conn; // khai báo phương thức của class sản phẩm
    public function __construct(){
        $this->conn = connectDB();
    }
    //VIẾT HÀM LẤT TOÀN BỘ DANH SÁCH SẢN PHẨM
    public function getAllProduct(){
        try{
            $sql = 'SELECT san_phams.*, danh_mucs.ten_danh_muc 
            FROM  san_phams
            INNER JOIN danh_mucs ON san_phams.danh_muc_id = danh_mucs.id
            ';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e){
            echo "Lỗi" . $e->getMessage();
        }
    }


    // Lấy dữ liệu của comment để render ra trang feedback
    public function getDataComment(){
        try{
            $sql = 'SELECT tai_khoans.ho_ten, tai_khoans.anh_dai_dien, binh_luans.noi_dung, binh_luans.ngay_dang FROM `binh_luans` JOIN tai_khoans ON binh_luans.tai_khoan_id = tai_khoans.id;
            ';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e){
            echo "Lỗi" . $e->getMessage();
        }
    }


    public function  getDetailSanPham($id){
        try {
            $sql = ' SELECT san_phams.*, danh_mucs.ten_danh_muc
            FROM san_phams
            INNER JOIN danh_mucs ON san_phams.danh_muc_id = danh_mucs.id
            
             WHERE san_phams.id = :id';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id'=>$id]);
            return $stmt->fetch();
        } catch (Exception $e) {
            echo "lỗi" . $e->getMessage();
        }
    }

    public function getListAnhSanPham($id){
        try {
            $sql = 'SELECT * FROM hinh_anh_san_phams WHERE san_pham_id = :id';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id'=>$id]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "lỗi" . $e->getMessage();
        }
    }

    public function getBinhLuanFromSanPham($id){
        try {
            $sql = 'SELECT binh_luans.*, tai_khoans.ho_ten, tai_khoans.anh_dai_dien
            FROM binh_luans
            INNER JOIN tai_khoans ON binh_luans.tai_khoan_id = tai_khoans.id
            WHERE binh_luans.san_pham_id = :id
            ';
            $stmt = $this->conn->prepare($sql);
            $stmt ->execute([':id'=>$id]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "lỗi" .$e->getMessage();
        }
    }
    public function getListSanPhamDanhMuc($danh_muc_id){
        try{
            $sql = 'SELECT san_phams.*, danh_mucs.ten_danh_muc 
            FROM  san_phams
            INNER JOIN danh_mucs ON san_phams.danh_muc_id = danh_mucs.id
            WHERE san_phams.danh_muc_id = '. $danh_muc_id;
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e){
            echo "Lỗi" . $e->getMessage();
        }
    }
}
