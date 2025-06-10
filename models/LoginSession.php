<?php

class LoginSession {
    private $conn;
    private $table_name = "login_sessions";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Tạo phiên đăng nhập mới
    public function createSession($user_id, $session_token, $ip_address = null, $user_agent = null) {
        $query = "INSERT INTO " . $this->table_name . " 
                 (user_id, session_token, ip_address, user_agent) 
                 VALUES (:user_id, :session_token, :ip_address, :user_agent)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":session_token", $session_token);
        $stmt->bindParam(":ip_address", $ip_address);
        $stmt->bindParam(":user_agent", $user_agent);
        
        return $stmt->execute();
    }

    // Lấy thông tin phiên đăng nhập
    public function getSession($session_token) {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE session_token = :session_token";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":session_token", $session_token);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cập nhật thời gian hoạt động cuối
    public function updateLastActivity($session_token) {
        $query = "UPDATE " . $this->table_name . " 
                 SET last_activity = CURRENT_TIMESTAMP 
                 WHERE session_token = :session_token";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":session_token", $session_token);
        
        return $stmt->execute();
    }

    // Xóa phiên đăng nhập
    public function deleteSession($session_token) {
        $query = "DELETE FROM " . $this->table_name . " 
                 WHERE session_token = :session_token";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":session_token", $session_token);
        
        return $stmt->execute();
    }

    // Xóa tất cả phiên đăng nhập của user
    public function deleteAllUserSessions($user_id) {
        $query = "DELETE FROM " . $this->table_name . " 
                 WHERE user_id = :user_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        
        return $stmt->execute();
    }

    // Xóa các phiên đăng nhập hết hạn
    public function deleteExpiredSessions($lifetime_minutes) {
        $query = "DELETE FROM " . $this->table_name . " 
                 WHERE last_activity < DATE_SUB(NOW(), INTERVAL :lifetime_minutes MINUTE)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":lifetime_minutes", $lifetime_minutes);
        
        return $stmt->execute();
    }

    // Lấy danh sách phiên đăng nhập của user
    public function getUserSessions($user_id) {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE user_id = :user_id 
                 ORDER BY last_activity DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Kiểm tra xem phiên đăng nhập có hợp lệ không
    public function isValidSession($session_token, $lifetime_minutes) {
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name . " 
                 WHERE session_token = :session_token 
                 AND last_activity >= DATE_SUB(NOW(), INTERVAL :lifetime_minutes MINUTE)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":session_token", $session_token);
        $stmt->bindParam(":lifetime_minutes", $lifetime_minutes);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'] > 0;
    }

    // Lấy số lượng phiên đăng nhập đang hoạt động
    public function getActiveSessionsCount() {
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name;
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'];
    }

    // Lấy thông tin chi tiết về phiên đăng nhập
    public function getSessionDetails($session_token) {
        $query = "SELECT ls.*, tk.email, tk.ho_ten 
                 FROM " . $this->table_name . " ls 
                 INNER JOIN tai_khoan tk ON ls.user_id = tk.id 
                 WHERE ls.session_token = :session_token";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":session_token", $session_token);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
} 