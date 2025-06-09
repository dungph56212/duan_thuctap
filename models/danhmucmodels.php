<?php
    class DanhMuc{
        public $conn;

        public function __construct()
        {
            $this->conn = connectDB();
        }
        public function getAllDanhMuc(){
            try {
                $sql = 'select * from danh_mucs';
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll();
            } catch (Exception $e) {
                echo "lỗi" . $e->getMessage();
            }
        }

        public function getDetailDanhMuc($id){
            try {
                $sql = 'SELECT * FROM danh_mucs WHERE id = :id';
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([':id' => $id]);
                return $stmt->fetch();
            } catch (Exception $e) {
                echo "lỗi" . $e->getMessage();
            }
        }

        public function getAllCate(){
            try {
                $sql = 'select * from danh_mucs';
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll();
            } catch (Exception $e) {
                echo "lỗi" . $e->getMessage();
            }
        }
        public function getSubCategories($parentId) {
            $query = "SELECT * FROM danh_mucs WHERE parent_id = :parentId";
            $stmt = $this->conn->prepare($query);
            $stmt->execute(['parentId' => $parentId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

?>