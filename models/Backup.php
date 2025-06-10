<?php

class Backup {
    private $conn;
    private $table_name = "backup_logs";
    private $backup_dir;

    public function __construct($db) {
        $this->conn = $db;
        $this->backup_dir = dirname(__DIR__) . '/backups/';
        
        // Tạo thư mục backup nếu chưa tồn tại
        if (!file_exists($this->backup_dir)) {
            mkdir($this->backup_dir, 0755, true);
        }
    }

    // Tạo backup database
    public function createBackup() {
        try {
            $timestamp = date('Y-m-d_H-i-s');
            $filename = "backup_{$timestamp}.sql";
            $filepath = $this->backup_dir . $filename;
            
            // Lấy thông tin kết nối database
            $host = DB_HOST;
            $dbname = DB_NAME;
            $username = DB_USER;
            $password = DB_PASS;
            
            // Tạo lệnh mysqldump
            $command = sprintf(
                'mysqldump --host=%s --user=%s --password=%s %s > %s',
                escapeshellarg($host),
                escapeshellarg($username),
                escapeshellarg($password),
                escapeshellarg($dbname),
                escapeshellarg($filepath)
            );
            
            // Thực thi lệnh
            exec($command, $output, $return_var);
            
            if ($return_var !== 0) {
                throw new Exception("Lỗi khi tạo backup: " . implode("\n", $output));
            }
            
            // Ghi log backup
            $filesize = filesize($filepath);
            $this->logBackup($filename, $filepath, $filesize, 'success');
            
            return [
                'success' => true,
                'filename' => $filename,
                'filepath' => $filepath,
                'size' => $filesize
            ];
            
        } catch (Exception $e) {
            $this->logBackup($filename ?? 'unknown', $filepath ?? 'unknown', 0, 'failed');
            throw $e;
        }
    }

    // Ghi log backup
    private function logBackup($backup_name, $file_path, $size_bytes, $status) {
        $query = "INSERT INTO " . $this->table_name . " 
                 (backup_name, file_path, size_bytes, status) 
                 VALUES (:backup_name, :file_path, :size_bytes, :status)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":backup_name", $backup_name);
        $stmt->bindParam(":file_path", $file_path);
        $stmt->bindParam(":size_bytes", $size_bytes);
        $stmt->bindParam(":status", $status);
        
        return $stmt->execute();
    }

    // Lấy danh sách backup
    public function getBackupList($limit = 50, $offset = 0) {
        $query = "SELECT * FROM " . $this->table_name . " 
                 ORDER BY created_at DESC 
                 LIMIT :limit OFFSET :offset";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Xóa backup
    public function deleteBackup($id) {
        // Lấy thông tin backup
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        
        $backup = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$backup) {
            throw new Exception("Không tìm thấy backup");
        }
        
        // Xóa file backup
        if (file_exists($backup['file_path'])) {
            unlink($backup['file_path']);
        }
        
        // Xóa log backup
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        
        return $stmt->execute();
    }

    // Xóa các backup cũ
    public function deleteOldBackups($days) {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE created_at < DATE_SUB(NOW(), INTERVAL :days DAY)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":days", $days, PDO::PARAM_INT);
        $stmt->execute();
        
        $old_backups = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($old_backups as $backup) {
            if (file_exists($backup['file_path'])) {
                unlink($backup['file_path']);
            }
        }
        
        $query = "DELETE FROM " . $this->table_name . " 
                 WHERE created_at < DATE_SUB(NOW(), INTERVAL :days DAY)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":days", $days, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    // Khôi phục database từ backup
    public function restoreBackup($id) {
        // Lấy thông tin backup
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        
        $backup = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$backup) {
            throw new Exception("Không tìm thấy backup");
        }
        
        if (!file_exists($backup['file_path'])) {
            throw new Exception("File backup không tồn tại");
        }
        
        // Lấy thông tin kết nối database
        $host = DB_HOST;
        $dbname = DB_NAME;
        $username = DB_USER;
        $password = DB_PASS;
        
        // Tạo lệnh mysql restore
        $command = sprintf(
            'mysql --host=%s --user=%s --password=%s %s < %s',
            escapeshellarg($host),
            escapeshellarg($username),
            escapeshellarg($password),
            escapeshellarg($dbname),
            escapeshellarg($backup['file_path'])
        );
        
        // Thực thi lệnh
        exec($command, $output, $return_var);
        
        if ($return_var !== 0) {
            throw new Exception("Lỗi khi khôi phục backup: " . implode("\n", $output));
        }
        
        return true;
    }

    // Lấy thống kê backup
    public function getBackupStats() {
        $query = "SELECT 
                    COUNT(*) as total_backups,
                    SUM(CASE WHEN status = 'success' THEN 1 ELSE 0 END) as successful_backups,
                    SUM(CASE WHEN status = 'failed' THEN 1 ELSE 0 END) as failed_backups,
                    SUM(size_bytes) as total_size
                 FROM " . $this->table_name;
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy thống kê backup theo thời gian
    public function getBackupStatsByTime($days = 30) {
        $query = "SELECT 
                    DATE(created_at) as date,
                    COUNT(*) as total_backups,
                    SUM(CASE WHEN status = 'success' THEN 1 ELSE 0 END) as successful_backups,
                    SUM(CASE WHEN status = 'failed' THEN 1 ELSE 0 END) as failed_backups,
                    SUM(size_bytes) as total_size
                 FROM " . $this->table_name . "
                 WHERE created_at >= DATE_SUB(NOW(), INTERVAL :days DAY)
                 GROUP BY DATE(created_at)
                 ORDER BY date DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":days", $days, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 