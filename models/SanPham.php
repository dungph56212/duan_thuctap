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
}
