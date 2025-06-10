<?php

class ActivityLog {
    private $conn;
    private $table_name = "activity_logs";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Ghi log hoạt động
    public function logActivity($user_id, $action, $description = null, $ip_address = null) {
        $query = "INSERT INTO " . $this->table_name . " 
                 (user_id, action, description, ip_address) 
                 VALUES (:user_id, :action, :description, :ip_address)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":action", $action);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":ip_address", $ip_address);
        
        return $stmt->execute();
    }

    // Lấy danh sách log theo user
    public function getUserLogs($user_id, $limit = 50, $offset = 0) {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE user_id = :user_id 
                 ORDER BY created_at DESC 
                 LIMIT :limit OFFSET :offset";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách log theo action
    public function getLogsByAction($action, $limit = 50, $offset = 0) {
        $query = "SELECT al.*, tk.email, tk.ho_ten 
                 FROM " . $this->table_name . " al 
                 LEFT JOIN tai_khoan tk ON al.user_id = tk.id 
                 WHERE al.action = :action 
                 ORDER BY al.created_at DESC 
                 LIMIT :limit OFFSET :offset";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":action", $action);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách log theo khoảng thời gian
    public function getLogsByDateRange($start_date, $end_date, $limit = 50, $offset = 0) {
        $query = "SELECT al.*, tk.email, tk.ho_ten 
                 FROM " . $this->table_name . " al 
                 LEFT JOIN tai_khoan tk ON al.user_id = tk.id 
                 WHERE al.created_at BETWEEN :start_date AND :end_date 
                 ORDER BY al.created_at DESC 
                 LIMIT :limit OFFSET :offset";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":start_date", $start_date);
        $stmt->bindParam(":end_date", $end_date);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy tổng số log
    public function getTotalLogs($filters = []) {
        $where_clause = "";
        $params = [];
        
        if (!empty($filters)) {
            $conditions = [];
            
            if (isset($filters['user_id'])) {
                $conditions[] = "user_id = :user_id";
                $params[':user_id'] = $filters['user_id'];
            }
            
            if (isset($filters['action'])) {
                $conditions[] = "action = :action";
                $params[':action'] = $filters['action'];
            }
            
            if (isset($filters['start_date']) && isset($filters['end_date'])) {
                $conditions[] = "created_at BETWEEN :start_date AND :end_date";
                $params[':start_date'] = $filters['start_date'];
                $params[':end_date'] = $filters['end_date'];
            }
            
            if (!empty($conditions)) {
                $where_clause = "WHERE " . implode(" AND ", $conditions);
            }
        }
        
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name . " " . $where_clause;
        
        $stmt = $this->conn->prepare($query);
        
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row['total'];
    }

    // Xóa log cũ
    public function deleteOldLogs($days) {
        $query = "DELETE FROM " . $this->table_name . " 
                 WHERE created_at < DATE_SUB(NOW(), INTERVAL :days DAY)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":days", $days, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    // Lấy thống kê hoạt động theo ngày
    public function getActivityStatsByDay($days = 30) {
        $query = "SELECT DATE(created_at) as date, 
                        COUNT(*) as total_activities,
                        COUNT(DISTINCT user_id) as unique_users
                 FROM " . $this->table_name . " 
                 WHERE created_at >= DATE_SUB(NOW(), INTERVAL :days DAY)
                 GROUP BY DATE(created_at)
                 ORDER BY date DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":days", $days, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy thống kê hoạt động theo action
    public function getActivityStatsByAction($days = 30) {
        $query = "SELECT action, COUNT(*) as count
                 FROM " . $this->table_name . " 
                 WHERE created_at >= DATE_SUB(NOW(), INTERVAL :days DAY)
                 GROUP BY action
                 ORDER BY count DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":days", $days, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy thống kê hoạt động theo user
    public function getActivityStatsByUser($days = 30) {
        $query = "SELECT al.user_id, tk.email, tk.ho_ten, COUNT(*) as activity_count
                 FROM " . $this->table_name . " al
                 LEFT JOIN tai_khoan tk ON al.user_id = tk.id
                 WHERE al.created_at >= DATE_SUB(NOW(), INTERVAL :days DAY)
                 GROUP BY al.user_id, tk.email, tk.ho_ten
                 ORDER BY activity_count DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":days", $days, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 