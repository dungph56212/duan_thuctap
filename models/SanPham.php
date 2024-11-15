<?php
class SanPham {
    public $conn; // khai báo phương thức của class sản phẩm
    public function __construct(){
        $this->conn = connectDB();
    }
    //VIẾT HÀM LẤT TOÀN BỘ DANH SÁCH SẢN PHẨM
    public function getAllProduct(){
        try{
            $sql = 'SELECT * FROM  san_phams';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e){
            echo "Lỗi" . $e->getMessage();
        }
    }
}
