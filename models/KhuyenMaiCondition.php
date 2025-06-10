<?php

class KhuyenMaiCondition {
    private $conn;
    private $table_name = "khuyen_mai_conditions";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lấy điều kiện theo ID
    public function getConditionById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy điều kiện theo khuyến mãi
    public function getConditionsByKhuyenMai($khuyen_mai_id) {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE khuyen_mai_id = :khuyen_mai_id 
                 ORDER BY condition_type";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":khuyen_mai_id", $khuyen_mai_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm điều kiện mới
    public function createCondition($khuyen_mai_id, $condition_type, $condition_value) {
        $query = "INSERT INTO " . $this->table_name . " 
                 (khuyen_mai_id, condition_type, condition_value) 
                 VALUES (:khuyen_mai_id, :condition_type, :condition_value)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":khuyen_mai_id", $khuyen_mai_id);
        $stmt->bindParam(":condition_type", $condition_type);
        $stmt->bindParam(":condition_value", $condition_value);
        return $stmt->execute();
    }

    // Cập nhật điều kiện
    public function updateCondition($id, $condition_type, $condition_value) {
        $query = "UPDATE " . $this->table_name . " 
                 SET condition_type = :condition_type, 
                     condition_value = :condition_value 
                 WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":condition_type", $condition_type);
        $stmt->bindParam(":condition_value", $condition_value);
        return $stmt->execute();
    }

    // Xóa điều kiện
    public function deleteCondition($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    // Xóa tất cả điều kiện của khuyến mãi
    public function deleteAllConditions($khuyen_mai_id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE khuyen_mai_id = :khuyen_mai_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":khuyen_mai_id", $khuyen_mai_id);
        return $stmt->execute();
    }

    // Kiểm tra điều kiện khuyến mãi
    public function checkConditions($khuyen_mai_id, $data) {
        $conditions = $this->getConditionsByKhuyenMai($khuyen_mai_id);
        
        foreach ($conditions as $condition) {
            switch ($condition['condition_type']) {
                case 'product':
                    if (!in_array($data['product_id'], json_decode($condition['condition_value'], true))) {
                        return false;
                    }
                    break;
                    
                case 'category':
                    if (!in_array($data['category_id'], json_decode($condition['condition_value'], true))) {
                        return false;
                    }
                    break;
                    
                case 'min_amount':
                    if ($data['total_amount'] < floatval($condition['condition_value'])) {
                        return false;
                    }
                    break;
                    
                case 'max_amount':
                    if ($data['total_amount'] > floatval($condition['condition_value'])) {
                        return false;
                    }
                    break;
                    
                case 'user_group':
                    if (!in_array($data['user_group'], json_decode($condition['condition_value'], true))) {
                        return false;
                    }
                    break;
            }
        }
        
        return true;
    }

    // Lấy thống kê điều kiện
    public function getConditionStats() {
        $query = "SELECT condition_type, COUNT(*) as count 
                 FROM " . $this->table_name . " 
                 GROUP BY condition_type 
                 ORDER BY count DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy thống kê điều kiện theo khuyến mãi
    public function getConditionStatsByKhuyenMai($khuyen_mai_id) {
        $query = "SELECT condition_type, COUNT(*) as count 
                 FROM " . $this->table_name . " 
                 WHERE khuyen_mai_id = :khuyen_mai_id 
                 GROUP BY condition_type 
                 ORDER BY count DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":khuyen_mai_id", $khuyen_mai_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách sản phẩm áp dụng khuyến mãi
    public function getApplicableProducts($khuyen_mai_id) {
        $query = "SELECT DISTINCT p.* 
                 FROM san_pham p 
                 INNER JOIN " . $this->table_name . " c ON 
                    (c.condition_type = 'product' AND p.id IN (SELECT JSON_UNQUOTE(JSON_EXTRACT(condition_value, '$[*]')) FROM " . $this->table_name . " WHERE khuyen_mai_id = :khuyen_mai_id AND condition_type = 'product'))
                    OR 
                    (c.condition_type = 'category' AND p.danh_muc_id IN (SELECT JSON_UNQUOTE(JSON_EXTRACT(condition_value, '$[*]')) FROM " . $this->table_name . " WHERE khuyen_mai_id = :khuyen_mai_id AND condition_type = 'category'))
                 WHERE c.khuyen_mai_id = :khuyen_mai_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":khuyen_mai_id", $khuyen_mai_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách danh mục áp dụng khuyến mãi
    public function getApplicableCategories($khuyen_mai_id) {
        $query = "SELECT DISTINCT d.* 
                 FROM danh_muc d 
                 INNER JOIN " . $this->table_name . " c ON 
                    c.condition_type = 'category' 
                    AND d.id IN (SELECT JSON_UNQUOTE(JSON_EXTRACT(condition_value, '$[*]')) FROM " . $this->table_name . " WHERE khuyen_mai_id = :khuyen_mai_id AND condition_type = 'category')
                 WHERE c.khuyen_mai_id = :khuyen_mai_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":khuyen_mai_id", $khuyen_mai_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 