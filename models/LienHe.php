<?php
require_once __DIR__ . '/../commons/function.php';

class LienHe {
    
    /**
     * Thêm liên hệ mới
     */
    public static function insert($name, $email, $phone, $subject, $message, $ip_address = null, $user_agent = null) {
        $conn = connectDB();
        $stmt = $conn->prepare("INSERT INTO lienhe (name, email, phone, subject, message, ip_address, user_agent, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$name, $email, $phone, $subject, $message, $ip_address, $user_agent]);
        return $conn->lastInsertId();
    }
    
    /**
     * Lấy tất cả liên hệ với phân trang và bộ lọc
     */
    public static function getAll($page = 1, $limit = 10, $filters = []) {
        $conn = connectDB();
        $offset = ($page - 1) * $limit;
        
        $whereClause = "WHERE 1=1";
        $params = [];
        
        if (!empty($filters['status'])) {
            $whereClause .= " AND status = :status";
            $params[':status'] = $filters['status'];
        }
        
        if (!empty($filters['priority'])) {
            $whereClause .= " AND priority = :priority";
            $params[':priority'] = $filters['priority'];
        }
        
        if (!empty($filters['search'])) {
            $whereClause .= " AND (name LIKE :search OR email LIKE :search2 OR subject LIKE :search3 OR message LIKE :search4)";
            $searchTerm = '%' . $filters['search'] . '%';
            $params[':search'] = $searchTerm;
            $params[':search2'] = $searchTerm;
            $params[':search3'] = $searchTerm;
            $params[':search4'] = $searchTerm;
        }
        
        if (!empty($filters['date_from'])) {
            $whereClause .= " AND DATE(created_at) >= :date_from";
            $params[':date_from'] = $filters['date_from'];
        }
        
        if (!empty($filters['date_to'])) {
            $whereClause .= " AND DATE(created_at) <= :date_to";
            $params[':date_to'] = $filters['date_to'];
        }
        
        // Đếm tổng số bản ghi
        $countSql = "SELECT COUNT(*) as total FROM lienhe $whereClause";
        $countStmt = $conn->prepare($countSql);
        $countStmt->execute($params);
        $total = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Lấy dữ liệu với phân trang
        $sql = "SELECT * FROM lienhe $whereClause ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
        
        $stmt = $conn->prepare($sql);
        
        // Bind các parameters từ filters
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        // Bind limit và offset với kiểu integer
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return [
            'data' => $data,
            'total' => $total,
            'pages' => ceil($total / $limit),
            'current_page' => $page
        ];
    }
    
    /**
     * Lấy liên hệ theo ID
     */
    public static function getById($id) {
        $conn = connectDB();
        $stmt = $conn->prepare("SELECT * FROM lienhe WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Cập nhật trạng thái đã đọc
     */
    public static function markAsRead($id) {
        $conn = connectDB();
        $stmt = $conn->prepare("UPDATE lienhe SET is_read = 1, status = 'read' WHERE id = ?");
        $stmt->execute([$id]);
    }
    
    /**
     * Cập nhật trạng thái và ưu tiên
     */
    public static function updateStatus($id, $status, $priority = null) {
        $conn = connectDB();
        if ($priority) {
            $stmt = $conn->prepare("UPDATE lienhe SET status = ?, priority = ?, updated_at = NOW() WHERE id = ?");
            $stmt->execute([$status, $priority, $id]);
        } else {
            $stmt = $conn->prepare("UPDATE lienhe SET status = ?, updated_at = NOW() WHERE id = ?");
            $stmt->execute([$status, $id]);
        }
    }
    
    /**
     * Phản hồi liên hệ
     */
    public static function reply($id, $reply_message, $replied_by) {
        $conn = connectDB();
        $stmt = $conn->prepare("UPDATE lienhe SET reply_message = ?, replied_by = ?, replied_at = NOW(), status = 'replied', updated_at = NOW() WHERE id = ?");
        $stmt->execute([$reply_message, $replied_by, $id]);
    }
    
    /**
     * Xóa liên hệ
     */
    public static function delete($id) {
        $conn = connectDB();
        $stmt = $conn->prepare("DELETE FROM lienhe WHERE id = ?");
        $stmt->execute([$id]);
    }
    
    /**
     * Thống kê liên hệ
     */
    public static function getStats() {
        $conn = connectDB();
        
        $stats = [];
        
        // Tổng số liên hệ
        $stmt = $conn->query("SELECT COUNT(*) as total FROM lienhe");
        $stats['total'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Theo trạng thái
        $stmt = $conn->query("SELECT status, COUNT(*) as count FROM lienhe GROUP BY status");
        $status_stats = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($status_stats as $stat) {
            $stats['status'][$stat['status']] = $stat['count'];
        }
        
        // Theo mức độ ưu tiên
        $stmt = $conn->query("SELECT priority, COUNT(*) as count FROM lienhe GROUP BY priority");
        $priority_stats = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($priority_stats as $stat) {
            $stats['priority'][$stat['priority']] = $stat['count'];
        }
        
        // Liên hệ chưa đọc
        $stmt = $conn->query("SELECT COUNT(*) as unread FROM lienhe WHERE is_read = 0");
        $stats['unread'] = $stmt->fetch(PDO::FETCH_ASSOC)['unread'];
        
        // Liên hệ hôm nay
        $stmt = $conn->query("SELECT COUNT(*) as today FROM lienhe WHERE DATE(created_at) = CURDATE()");
        $stats['today'] = $stmt->fetch(PDO::FETCH_ASSOC)['today'];
        
        // Liên hệ tuần này
        $stmt = $conn->query("SELECT COUNT(*) as week FROM lienhe WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
        $stats['week'] = $stmt->fetch(PDO::FETCH_ASSOC)['week'];
        
        return $stats;
    }
    
    /**
     * Lấy phản hồi theo email cho khách hàng
     */
    public static function getReplyByEmail($email, $contact_id = null) {
        $conn = connectDB();
        
        $whereClause = "WHERE email = :email AND reply_message IS NOT NULL";
        $params = [':email' => $email];
        
        if ($contact_id) {
            $whereClause .= " AND id = :contact_id";
            $params[':contact_id'] = $contact_id;
        }
        
        $sql = "SELECT id, name, email, phone, subject, message, 
                       reply_message, replied_at, status, priority, created_at 
                FROM lienhe 
                $whereClause 
                ORDER BY created_at DESC";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Lấy tất cả liên hệ của một email (bao gồm cả chưa phản hồi)
     */
    public static function getAllByEmail($email) {
        $conn = connectDB();
        
        $sql = "SELECT id, name, email, phone, subject, message, 
                       reply_message, replied_at, status, priority, created_at 
                FROM lienhe 
                WHERE email = :email 
                ORDER BY created_at DESC";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute([':email' => $email]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
