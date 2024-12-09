<?php
class ProductModel {
    public $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function getAllProducts() {
        try {
            $sql = "SELECT * FROM san_phams"; 
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $th) {
            echo "Lỗi: " . $th->getMessage();
            return [];
        }
    }

    public function getProductById($id) {
        try {
            $sql = "SELECT * FROM san_phams WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $th) {
            echo "Lỗi: " . $th->getMessage();
            return false;
        }
    }
}
?>



