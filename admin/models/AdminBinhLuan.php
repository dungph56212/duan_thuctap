<?php

require_once __DIR__ . '/../../commons/env.php';

class AdminBinhLuan {
    public $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    /**
     * Lấy danh sách tất cả bình luận với thông tin sản phẩm và người dùng
     */
    public function getAllComments($limit = 20, $offset = 0) {
        try {
            $sql = "SELECT bl.*, sp.ten_san_pham, tk.ho_ten, tk.email 
                    FROM binh_luans bl 
                    LEFT JOIN san_phams sp ON bl.san_pham_id = sp.id 
                    LEFT JOIN tai_khoans tk ON bl.tai_khoan_id = tk.id 
                    ORDER BY bl.ngay_dang DESC 
                    LIMIT :limit OFFSET :offset";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Đếm tổng số bình luận
     */
    public function countAllComments() {
        try {
            $sql = "SELECT COUNT(*) as total FROM binh_luans";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            
            $result = $stmt->fetch();
            return $result['total'];
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * Lấy bình luận theo ID
     */
    public function getCommentById($id) {
        try {
            $sql = "SELECT bl.*, sp.ten_san_pham, sp.hinh_anh, tk.ho_ten, tk.email, tk.so_dien_thoai 
                    FROM binh_luans bl 
                    LEFT JOIN san_phams sp ON bl.san_pham_id = sp.id 
                    LEFT JOIN tai_khoans tk ON bl.tai_khoan_id = tk.id 
                    WHERE bl.id = :id";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            return $stmt->fetch();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Cập nhật trạng thái bình luận
     */
    public function updateCommentStatus($id, $status) {
        try {
            $sql = "UPDATE binh_luans SET trang_thai = :trang_thai WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':trang_thai', $status);
            $stmt->bindParam(':id', $id);
            
            return $stmt->execute();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Cập nhật trạng thái hàng loạt
     */
    public function bulkUpdateStatus($ids, $status) {
        try {
            if (empty($ids)) return false;
            
            $placeholders = str_repeat('?,', count($ids) - 1) . '?';
            $sql = "UPDATE binh_luans SET trang_thai = ? WHERE id IN ($placeholders)";
            
            $stmt = $this->conn->prepare($sql);
            $params = array_merge([$status], $ids);
            
            return $stmt->execute($params);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Xóa bình luận
     */
    public function deleteComment($id) {
        try {
            // Xóa các reply trước
            $sql = "DELETE FROM binh_luans WHERE parent_id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            // Xóa bình luận chính
            $sql = "DELETE FROM binh_luans WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            
            return $stmt->execute();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Xóa hàng loạt bình luận
     */
    public function bulkDeleteComments($ids) {
        try {
            if (empty($ids)) return false;
            
            // Xóa các reply trước
            $placeholders = str_repeat('?,', count($ids) - 1) . '?';
            $sql = "DELETE FROM binh_luans WHERE parent_id IN ($placeholders)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($ids);
            
            // Xóa bình luận chính
            $sql = "DELETE FROM binh_luans WHERE id IN ($placeholders)";
            $stmt = $this->conn->prepare($sql);
            
            return $stmt->execute($ids);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Lọc bình luận theo tiêu chí
     */
    public function filterComments($filters = [], $limit = 20, $offset = 0) {
        try {
            $where = [];
            $params = [];
            
            $sql = "SELECT bl.*, sp.ten_san_pham, tk.ho_ten, tk.email 
                    FROM binh_luans bl 
                    LEFT JOIN san_phams sp ON bl.san_pham_id = sp.id 
                    LEFT JOIN tai_khoans tk ON bl.tai_khoan_id = tk.id";
            
            if (!empty($filters['trang_thai'])) {
                $where[] = "bl.trang_thai = :trang_thai";
                $params[':trang_thai'] = $filters['trang_thai'];
            }
            
            if (!empty($filters['san_pham_id'])) {
                $where[] = "bl.san_pham_id = :san_pham_id";
                $params[':san_pham_id'] = $filters['san_pham_id'];
            }
            
            if (!empty($filters['tu_ngay'])) {
                $where[] = "DATE(bl.ngay_dang) >= :tu_ngay";
                $params[':tu_ngay'] = $filters['tu_ngay'];
            }
            
            if (!empty($filters['den_ngay'])) {
                $where[] = "DATE(bl.ngay_dang) <= :den_ngay";
                $params[':den_ngay'] = $filters['den_ngay'];
            }
            
            if (!empty($filters['keyword'])) {
                $where[] = "(bl.noi_dung LIKE :keyword OR sp.ten_san_pham LIKE :keyword OR tk.ho_ten LIKE :keyword)";
                $params[':keyword'] = '%' . $filters['keyword'] . '%';
            }
            
            if (!empty($where)) {
                $sql .= " WHERE " . implode(" AND ", $where);
            }
            
            $sql .= " ORDER BY bl.ngay_dang DESC LIMIT :limit OFFSET :offset";
            
            $stmt = $this->conn->prepare($sql);
            
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Đếm bình luận theo bộ lọc
     */
    public function countFilteredComments($filters = []) {
        try {
            $where = [];
            $params = [];
            
            $sql = "SELECT COUNT(*) as total 
                    FROM binh_luans bl 
                    LEFT JOIN san_phams sp ON bl.san_pham_id = sp.id 
                    LEFT JOIN tai_khoans tk ON bl.tai_khoan_id = tk.id";
            
            if (!empty($filters['trang_thai'])) {
                $where[] = "bl.trang_thai = :trang_thai";
                $params[':trang_thai'] = $filters['trang_thai'];
            }
            
            if (!empty($filters['san_pham_id'])) {
                $where[] = "bl.san_pham_id = :san_pham_id";
                $params[':san_pham_id'] = $filters['san_pham_id'];
            }
            
            if (!empty($filters['tu_ngay'])) {
                $where[] = "DATE(bl.ngay_dang) >= :tu_ngay";
                $params[':tu_ngay'] = $filters['tu_ngay'];
            }
            
            if (!empty($filters['den_ngay'])) {
                $where[] = "DATE(bl.ngay_dang) <= :den_ngay";
                $params[':den_ngay'] = $filters['den_ngay'];
            }
            
            if (!empty($filters['keyword'])) {
                $where[] = "(bl.noi_dung LIKE :keyword OR sp.ten_san_pham LIKE :keyword OR tk.ho_ten LIKE :keyword)";
                $params[':keyword'] = '%' . $filters['keyword'] . '%';
            }
            
            if (!empty($where)) {
                $sql .= " WHERE " . implode(" AND ", $where);
            }
            
            $stmt = $this->conn->prepare($sql);
            
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            
            $stmt->execute();
            $result = $stmt->fetch();
            return $result['total'];
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * Thêm reply cho bình luận
     */
    public function addReply($parent_id, $noi_dung, $admin_id) {
        try {
            $sql = "INSERT INTO binh_luans (san_pham_id, tai_khoan_id, noi_dung, trang_thai, ngay_dang, parent_id, is_admin_reply) 
                    SELECT san_pham_id, :admin_id, :noi_dung, 1, NOW(), :parent_id, 1 
                    FROM binh_luans WHERE id = :parent_id_check";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':admin_id', $admin_id);
            $stmt->bindParam(':noi_dung', $noi_dung);
            $stmt->bindParam(':parent_id', $parent_id);
            $stmt->bindParam(':parent_id_check', $parent_id);
            
            return $stmt->execute();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Lấy các reply của bình luận
     */
    public function getReplies($parent_id) {
        try {
            $sql = "SELECT bl.*, tk.ho_ten, tk.email 
                    FROM binh_luans bl 
                    LEFT JOIN tai_khoans tk ON bl.tai_khoan_id = tk.id 
                    WHERE bl.parent_id = :parent_id 
                    ORDER BY bl.ngay_dang ASC";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':parent_id', $parent_id);
            $stmt->execute();
            
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * Thống kê bình luận
     */
    public function getCommentStats() {
        try {
            $stats = [];
            
            // Tổng số bình luận
            $sql = "SELECT COUNT(*) as total FROM binh_luans WHERE parent_id IS NULL";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $stats['total'] = $stmt->fetch()['total'];
            
            // Bình luận chờ duyệt
            $sql = "SELECT COUNT(*) as pending FROM binh_luans WHERE trang_thai = 0 AND parent_id IS NULL";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $stats['pending'] = $stmt->fetch()['pending'];
            
            // Bình luận đã duyệt
            $sql = "SELECT COUNT(*) as approved FROM binh_luans WHERE trang_thai = 1 AND parent_id IS NULL";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $stats['approved'] = $stmt->fetch()['approved'];
            
            // Bình luận bị ẩn
            $sql = "SELECT COUNT(*) as hidden FROM binh_luans WHERE trang_thai = 2 AND parent_id IS NULL";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $stats['hidden'] = $stmt->fetch()['hidden'];
            
            // Bình luận hôm nay
            $sql = "SELECT COUNT(*) as today FROM binh_luans WHERE DATE(ngay_dang) = CURDATE() AND parent_id IS NULL";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $stats['today'] = $stmt->fetch()['today'];
            
            // Bình luận tuần này
            $sql = "SELECT COUNT(*) as this_week FROM binh_luans WHERE WEEK(ngay_dang) = WEEK(NOW()) AND YEAR(ngay_dang) = YEAR(NOW()) AND parent_id IS NULL";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $stats['this_week'] = $stmt->fetch()['this_week'];
            
            return $stats;
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * Lấy top sản phẩm có nhiều bình luận nhất
     */
    public function getTopCommentedProducts($limit = 10) {
        try {
            $sql = "SELECT sp.id, sp.ten_san_pham, sp.hinh_anh, COUNT(bl.id) as so_binh_luan 
                    FROM san_phams sp 
                    LEFT JOIN binh_luans bl ON sp.id = bl.san_pham_id AND bl.parent_id IS NULL 
                    GROUP BY sp.id 
                    ORDER BY so_binh_luan DESC 
                    LIMIT :limit";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * Lấy bình luận gần đây
     */
    public function getRecentComments($limit = 10) {
        try {
            $sql = "SELECT bl.*, sp.ten_san_pham, tk.ho_ten 
                    FROM binh_luans bl 
                    LEFT JOIN san_phams sp ON bl.san_pham_id = sp.id 
                    LEFT JOIN tai_khoans tk ON bl.tai_khoan_id = tk.id 
                    WHERE bl.parent_id IS NULL 
                    ORDER BY bl.ngay_dang DESC 
                    LIMIT :limit";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * Lấy thống kê bình luận theo tháng
     */
    public function getMonthlyStats($year = null) {
        try {
            if (!$year) {
                $year = date('Y');
            }
            
            $sql = "SELECT 
                        MONTH(ngay_dang) as thang,
                        COUNT(*) as so_luong 
                    FROM binh_luans 
                    WHERE YEAR(ngay_dang) = :year AND parent_id IS NULL 
                    GROUP BY MONTH(ngay_dang) 
                    ORDER BY thang";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':year', $year);
            $stmt->execute();
            
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * Tìm kiếm bình luận
     */
    public function searchComments($keyword, $limit = 20, $offset = 0) {
        try {
            $sql = "SELECT bl.*, sp.ten_san_pham, tk.ho_ten, tk.email 
                    FROM binh_luans bl 
                    LEFT JOIN san_phams sp ON bl.san_pham_id = sp.id 
                    LEFT JOIN tai_khoans tk ON bl.tai_khoan_id = tk.id 
                    WHERE bl.noi_dung LIKE :keyword 
                       OR sp.ten_san_pham LIKE :keyword 
                       OR tk.ho_ten LIKE :keyword 
                       OR tk.email LIKE :keyword 
                    ORDER BY bl.ngay_dang DESC 
                    LIMIT :limit OFFSET :offset";
            
            $stmt = $this->conn->prepare($sql);
            $keywordParam = '%' . $keyword . '%';
            $stmt->bindParam(':keyword', $keywordParam);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * Lấy tất cả bình luận (alias cho getAllComments)
     */
    public function getAllBinhLuan() {
        return $this->getAllComments();
    }

    /**
     * Lấy chi tiết bình luận (alias cho getCommentById)
     */
    public function getDetailBinhLuan($id) {
        return $this->getCommentById($id);
    }

    /**
     * Cập nhật trạng thái bình luận (alias cho updateCommentStatus)
     */
    public function updateTrangThaiBinhLuan($id, $status, $ly_do = '') {
        return $this->updateCommentStatus($id, $status);
    }

    /**
     * Xóa bình luận (alias cho deleteComment)
     */
    public function deleteBinhLuan($id) {
        return $this->deleteComment($id);
    }    /**
     * Lọc bình luận (alias cho filterComments)
     */
    public function filterBinhLuan($trangThai, $sanPhamId = '', $tuNgay = '', $denNgay = '', $limit = 20, $offset = 0) {
        $filters = [];
        
        if ($trangThai !== 'all') {
            $statusMap = [
                'pending' => 0,
                'approved' => 1, 
                'rejected' => 2
            ];
            $filters['trang_thai'] = $statusMap[$trangThai] ?? $trangThai;
        }
        
        if (!empty($sanPhamId)) {
            $filters['san_pham_id'] = $sanPhamId;
        }
        
        if (!empty($tuNgay)) {
            $filters['tu_ngay'] = $tuNgay;
        }
        
        if (!empty($denNgay)) {
            $filters['den_ngay'] = $denNgay;
        }        return $this->filterComments($filters, $limit, $offset);
    }

    /**
     * Đếm tổng số bình luận được lọc (wrapper method with same signature as filterBinhLuan)
     */
    public function countFilteredBinhLuan($trangThai, $sanPhamId = '', $tuNgay = '', $denNgay = '') {
        $filters = [];
        
        if ($trangThai !== 'all') {
            $statusMap = [
                'pending' => 0,
                'approved' => 1, 
                'rejected' => 2
            ];
            $filters['trang_thai'] = $statusMap[$trangThai] ?? $trangThai;
        }
        
        if (!empty($sanPhamId)) {
            $filters['san_pham_id'] = $sanPhamId;
        }
        
        if (!empty($tuNgay)) {
            $filters['tu_ngay'] = $tuNgay;
        }
        
        if (!empty($denNgay)) {
            $filters['den_ngay'] = $denNgay;
        }
          return $this->countFilteredComments($filters);
    }

    /**
     * Thêm trả lời bình luận (alias cho addReply)
     */
    public function themTraLoiBinhLuan($parent_id, $noi_dung, $admin_id) {
        return $this->addReply($parent_id, $noi_dung, $admin_id);
    }

    /**
     * Đếm bình luận theo trạng thái
     */
    public function countBinhLuanByStatus($status) {
        try {
            $statusMap = [
                'pending' => 0,
                'approved' => 1,
                'rejected' => 2
            ];
            
            $statusValue = $statusMap[$status] ?? $status;
            
            $sql = "SELECT COUNT(*) as total FROM binh_luans WHERE trang_thai = :status";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':status', $statusValue);
            $stmt->execute();
            
            $result = $stmt->fetch();
            return $result['total'];
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * Lấy thống kê tổng quan bình luận
     */
    public function getThongKeBinhLuan() {
        try {
            $sql = "SELECT 
                        COUNT(*) as tong_binh_luan,
                        SUM(CASE WHEN trang_thai = 0 THEN 1 ELSE 0 END) as cho_duyet,
                        SUM(CASE WHEN trang_thai = 1 THEN 1 ELSE 0 END) as da_duyet,
                        SUM(CASE WHEN trang_thai = 2 THEN 1 ELSE 0 END) as bi_tu_choi
                    FROM binh_luans";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetch();
        } catch (Exception $e) {
            return [
                'tong_binh_luan' => 0,
                'cho_duyet' => 0,
                'da_duyet' => 0,
                'bi_tu_choi' => 0
            ];
        }
    }

    /**
     * Lấy thống kê bình luận theo tháng
     */
    public function getThongKeBinhLuanTheoThang() {
        try {
            $sql = "SELECT 
                        MONTH(ngay_dang) as thang,
                        YEAR(ngay_dang) as nam,
                        COUNT(*) as so_luong
                    FROM binh_luans 
                    WHERE YEAR(ngay_dang) = YEAR(CURDATE())
                    GROUP BY YEAR(ngay_dang), MONTH(ngay_dang)
                    ORDER BY nam DESC, thang DESC
                    LIMIT 12";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * Lấy thống kê bình luận theo sản phẩm
     */
    public function getThongKeBinhLuanTheoSanPham() {
        try {
            $sql = "SELECT 
                        sp.ten_san_pham,
                        COUNT(bl.id) as so_luong_binh_luan,
                        AVG(bl.sao_danh_gia) as danh_gia_trung_binh
                    FROM binh_luans bl
                    LEFT JOIN san_phams sp ON bl.san_pham_id = sp.id
                    GROUP BY bl.san_pham_id, sp.ten_san_pham
                    ORDER BY so_luong_binh_luan DESC
                    LIMIT 10";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * Lấy top khách hàng bình luận nhiều nhất
     */
    public function getTopKhachHangBinhLuan() {
        try {
            $sql = "SELECT 
                        tk.ho_ten,
                        tk.email,
                        COUNT(bl.id) as so_luong_binh_luan
                    FROM binh_luans bl
                    LEFT JOIN tai_khoans tk ON bl.tai_khoan_id = tk.id
                    WHERE tk.chuc_vu_id = 2
                    GROUP BY bl.tai_khoan_id, tk.ho_ten, tk.email
                    ORDER BY so_luong_binh_luan DESC
                    LIMIT 10";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }
}
