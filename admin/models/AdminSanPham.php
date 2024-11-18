<?php
class AdminSanPham{
    public $conn;
    public function __construct(){
        $this->conn = connectDB();
    }
    public function getAllSanPham(){
        try {
            $sql = 'SELECT * FROM san_phams';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "lỗi" . $e->getMessage();
        }
    }
   
    
}