<?php

class KhuyenMaiUsage {
    private $conn;
    private $table_name = "khuyen_mai_usage";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Ghi nhận sử dụng khuyến mãi
    public function recordUsage($khuyen_mai_id, $user_id, $order_id = null) {
        $query = "INSERT INTO " . $this->table_name . " 
                 (khuyen_mai_id, user_id, order_id) 
                 VALUES (:khuyen_mai_id, :user_id, :order_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":khuyen_mai_id", $khuyen_mai_id);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":order_id", $order_id);
        return $stmt->execute();
    }

    // Lấy lịch sử sử dụng khuyến mãi của user
    public function getUserUsageHistory($user_id, $limit = 50, $offset = 0) {
        $query = "SELECT u.*, k.ma_khuyen_mai, k.ten_khuyen_mai, d.ma_don_hang 
                 FROM " . $this->table_name . " u 
                 INNER JOIN khuyen_mai k ON u.khuyen_mai_id = k.id 
                 LEFT JOIN don_hang d ON u.order_id = d.id 
                 WHERE u.user_id = :user_id 
                 ORDER BY u.used_at DESC 
                 LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy lịch sử sử dụng của khuyến mãi
    public function getKhuyenMaiUsageHistory($khuyen_mai_id, $limit = 50, $offset = 0) {
        $query = "SELECT u.*, tk.email, tk.ho_ten, d.ma_don_hang 
                 FROM " . $this->table_name . " u 
                 INNER JOIN tai_khoan tk ON u.user_id = tk.id 
                 LEFT JOIN don_hang d ON u.order_id = d.id 
                 WHERE u.khuyen_mai_id = :khuyen_mai_id 
                 ORDER BY u.used_at DESC 
                 LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":khuyen_mai_id", $khuyen_mai_id);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Kiểm tra xem user đã sử dụng khuyến mãi chưa
    public function hasUserUsedKhuyenMai($user_id, $khuyen_mai_id) {
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name . " 
                 WHERE user_id = :user_id AND khuyen_mai_id = :khuyen_mai_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":khuyen_mai_id", $khuyen_mai_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'] > 0;
    }

    // Lấy số lần sử dụng khuyến mãi
    public function getUsageCount($khuyen_mai_id) {
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name . " 
                 WHERE khuyen_mai_id = :khuyen_mai_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":khuyen_mai_id", $khuyen_mai_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'];
    }

    // Lấy số lần sử dụng khuyến mãi của user
    public function getUserUsageCount($user_id, $khuyen_mai_id) {
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name . " 
                 WHERE user_id = :user_id AND khuyen_mai_id = :khuyen_mai_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":khuyen_mai_id", $khuyen_mai_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'];
    }

    // Lấy thống kê sử dụng khuyến mãi
    public function getUsageStats() {
        $query = "SELECT k.id, k.ma_khuyen_mai, k.ten_khuyen_mai, 
                        COUNT(u.id) as total_usage,
                        COUNT(DISTINCT u.user_id) as unique_users
                 FROM khuyen_mai k 
                 LEFT JOIN " . $this->table_name . " u ON k.id = u.khuyen_mai_id 
                 GROUP BY k.id 
                 ORDER BY total_usage DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy thống kê sử dụng khuyến mãi theo thời gian
    public function getUsageStatsByTime($days = 30) {
        $query = "SELECT DATE(u.used_at) as date, 
                        COUNT(*) as total_usage,
                        COUNT(DISTINCT u.user_id) as unique_users
                 FROM " . $this->table_name . " u 
                 WHERE u.used_at >= DATE_SUB(NOW(), INTERVAL :days DAY)
                 GROUP BY DATE(u.used_at)
                 ORDER BY date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":days", $days, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy thống kê sử dụng khuyến mãi theo user
    public function getUsageStatsByUser($days = 30) {
        $query = "SELECT u.user_id, tk.email, tk.ho_ten, 
                        COUNT(*) as total_usage,
                        COUNT(DISTINCT u.khuyen_mai_id) as unique_promotions
                 FROM " . $this->table_name . " u 
                 INNER JOIN tai_khoan tk ON u.user_id = tk.id 
                 WHERE u.used_at >= DATE_SUB(NOW(), INTERVAL :days DAY)
                 GROUP BY u.user_id 
                 ORDER BY total_usage DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":days", $days, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Xóa lịch sử sử dụng khuyến mãi
    public function deleteUsageHistory($days) {
        $query = "DELETE FROM " . $this->table_name . " 
                 WHERE used_at < DATE_SUB(NOW(), INTERVAL :days DAY)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":days", $days, PDO::PARAM_INT);
        return $stmt->execute();
    }
} 