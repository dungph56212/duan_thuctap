<?php
class DiaChi
{
    public $conn;
    
    public function __construct()
    {
        $this->conn = connectDB();
    }
    
    // Lấy tất cả địa chỉ của một người dùng
    public function getDiaChiByUserId($userId)
    {
        try {
            $sql = 'SELECT * FROM dia_chis WHERE tai_khoan_id = :tai_khoan_id ORDER BY is_default DESC, created_at DESC';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':tai_khoan_id' => $userId]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }
    
    // Thêm địa chỉ mới
    public function addDiaChi($tai_khoan_id, $ho_ten, $so_dien_thoai, $tinh_thanh, $quan_huyen, $phuong_xa, $dia_chi_chi_tiet, $is_default = 0)
    {
        try {
            // Nếu đây là địa chỉ mặc định, cập nhật các địa chỉ khác thành không mặc định
            if ($is_default == 1) {
                $this->updateDefaultStatus($tai_khoan_id, 0);
            }
            
            $sql = 'INSERT INTO dia_chis (tai_khoan_id, ho_ten, so_dien_thoai, tinh_thanh, quan_huyen, phuong_xa, dia_chi_chi_tiet, is_default, created_at) 
                    VALUES (:tai_khoan_id, :ho_ten, :so_dien_thoai, :tinh_thanh, :quan_huyen, :phuong_xa, :dia_chi_chi_tiet, :is_default, NOW())';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':tai_khoan_id' => $tai_khoan_id,
                ':ho_ten' => $ho_ten,
                ':so_dien_thoai' => $so_dien_thoai,
                ':tinh_thanh' => $tinh_thanh,
                ':quan_huyen' => $quan_huyen,
                ':phuong_xa' => $phuong_xa,
                ':dia_chi_chi_tiet' => $dia_chi_chi_tiet,
                ':is_default' => $is_default
            ]);
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }
    
    // Cập nhật địa chỉ
    public function updateDiaChi($id, $ho_ten, $so_dien_thoai, $tinh_thanh, $quan_huyen, $phuong_xa, $dia_chi_chi_tiet, $is_default = 0)
    {
        try {
            // Lấy thông tin địa chỉ hiện tại
            $currentAddress = $this->getDiaChiById($id);
            if (!$currentAddress) {
                return false;
            }
            
            // Nếu đây là địa chỉ mặc định, cập nhật các địa chỉ khác thành không mặc định
            if ($is_default == 1) {
                $this->updateDefaultStatus($currentAddress['tai_khoan_id'], 0);
            }
            
            $sql = 'UPDATE dia_chis SET 
                    ho_ten = :ho_ten, 
                    so_dien_thoai = :so_dien_thoai, 
                    tinh_thanh = :tinh_thanh, 
                    quan_huyen = :quan_huyen, 
                    phuong_xa = :phuong_xa, 
                    dia_chi_chi_tiet = :dia_chi_chi_tiet, 
                    is_default = :is_default,
                    updated_at = NOW()
                    WHERE id = :id';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':ho_ten' => $ho_ten,
                ':so_dien_thoai' => $so_dien_thoai,
                ':tinh_thanh' => $tinh_thanh,
                ':quan_huyen' => $quan_huyen,
                ':phuong_xa' => $phuong_xa,
                ':dia_chi_chi_tiet' => $dia_chi_chi_tiet,
                ':is_default' => $is_default,
                ':id' => $id
            ]);
            return true;
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }
    
    // Xóa địa chỉ
    public function deleteDiaChi($id)
    {
        try {
            $sql = 'DELETE FROM dia_chis WHERE id = :id';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            return true;
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }
    
    // Lấy địa chỉ theo ID
    public function getDiaChiById($id)
    {
        try {
            $sql = 'SELECT * FROM dia_chis WHERE id = :id';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }
    
    // Đặt địa chỉ mặc định
    public function setDefaultAddress($id, $tai_khoan_id)
    {
        try {
            // Đặt tất cả địa chỉ khác thành không mặc định
            $this->updateDefaultStatus($tai_khoan_id, 0);
            
            // Đặt địa chỉ này thành mặc định
            $sql = 'UPDATE dia_chis SET is_default = 1 WHERE id = :id AND tai_khoan_id = :tai_khoan_id';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':id' => $id,
                ':tai_khoan_id' => $tai_khoan_id
            ]);
            return true;
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }
    
    // Cập nhật trạng thái mặc định cho tất cả địa chỉ của user
    private function updateDefaultStatus($tai_khoan_id, $status)
    {
        try {
            $sql = 'UPDATE dia_chis SET is_default = :status WHERE tai_khoan_id = :tai_khoan_id';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':status' => $status,
                ':tai_khoan_id' => $tai_khoan_id
            ]);
            return true;
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }
    
    // Lấy địa chỉ mặc định của user
    public function getDefaultAddress($tai_khoan_id)
    {
        try {
            $sql = 'SELECT * FROM dia_chis WHERE tai_khoan_id = :tai_khoan_id AND is_default = 1';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':tai_khoan_id' => $tai_khoan_id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }
}
?>
