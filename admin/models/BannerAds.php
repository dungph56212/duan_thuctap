<?php
require_once __DIR__ . '/../../commons/function.php';

class BannerAds {
    private $conn;
    
    public function __construct() {
        $this->conn = connectDB();
    }
    
    /**
     * Lấy tất cả banner với phân trang và lọc
     */
    public function getAllBannersWithPagination($limit = 10, $offset = 0, $filters = []) {
        try {
            $whereConditions = [];
            $params = [];
            
            // Xây dựng điều kiện WHERE
            if (!empty($filters['status']) && $filters['status'] !== '') {
                $whereConditions[] = "trang_thai = :status";
                $params[':status'] = $filters['status'];
            }
            
            if (!empty($filters['type'])) {
                $whereConditions[] = "loai_hien_thi = :type";
                $params[':type'] = $filters['type'];
            }
            
            if (!empty($filters['search'])) {
                $whereConditions[] = "(ten_banner LIKE :search OR mo_ta LIKE :search)";
                $params[':search'] = '%' . $filters['search'] . '%';
            }
            
            if (!empty($filters['date_from'])) {
                $whereConditions[] = "ngay_bat_dau >= :date_from";
                $params[':date_from'] = $filters['date_from'];
            }
            
            if (!empty($filters['date_to'])) {
                $whereConditions[] = "ngay_ket_thuc <= :date_to";
                $params[':date_to'] = $filters['date_to'];
            }
            
            $whereClause = !empty($whereConditions) ? 'WHERE ' . implode(' AND ', $whereConditions) : '';
            
            // Đếm tổng số bản ghi
            $countSql = "SELECT COUNT(*) as total FROM banner_ads $whereClause";
            $countStmt = $this->conn->prepare($countSql);
            $countStmt->execute($params);
            $total = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            // Lấy dữ liệu với phân trang
            $sql = "SELECT *, 
                        CASE 
                            WHEN ngay_ket_thuc IS NOT NULL AND ngay_ket_thuc < NOW() THEN 'expired'
                            WHEN ngay_bat_dau IS NOT NULL AND ngay_bat_dau > NOW() THEN 'upcoming'
                            WHEN trang_thai = 1 THEN 'active'
                            ELSE 'inactive'
                        END as status_label
                    FROM banner_ads 
                    $whereClause 
                    ORDER BY thu_tu ASC, id DESC 
                    LIMIT :limit OFFSET :offset";
            
            $stmt = $this->conn->prepare($sql);
            
            // Bind parameters
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return ['data' => $data, 'total' => $total];
            
        } catch (Exception $e) {
            throw new Exception("Lỗi khi lấy danh sách banner: " . $e->getMessage());
        }
    }
    
    /**
     * Lấy banner theo ID
     */
    public function getBannerById($id) {
        $sql = "SELECT * FROM banner_ads WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Thêm banner mới
     */
    public function addBanner($data) {
        try {
            $sql = "INSERT INTO banner_ads (ten_banner, mo_ta, hinh_anh, link_url, thu_tu, trang_thai, loai_hien_thi, thoi_gian_hien_thi, hien_thi_lan_duy_nhat, ngay_bat_dau, ngay_ket_thuc) 
                    VALUES (:ten_banner, :mo_ta, :hinh_anh, :link_url, :thu_tu, :trang_thai, :loai_hien_thi, :thoi_gian_hien_thi, :hien_thi_lan_duy_nhat, :ngay_bat_dau, :ngay_ket_thuc)";
            
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':ten_banner' => $data['ten_banner'],
                ':mo_ta' => $data['mo_ta'],
                ':hinh_anh' => $data['hinh_anh'],
                ':link_url' => $data['link_url'],
                ':thu_tu' => $data['thu_tu'],
                ':trang_thai' => $data['trang_thai'],
                ':loai_hien_thi' => $data['loai_hien_thi'],
                ':thoi_gian_hien_thi' => $data['thoi_gian_hien_thi'],
                ':hien_thi_lan_duy_nhat' => $data['hien_thi_lan_duy_nhat'],
                ':ngay_bat_dau' => $data['ngay_bat_dau'],
                ':ngay_ket_thuc' => $data['ngay_ket_thuc']
            ]);
        } catch (Exception $e) {
            throw new Exception("Lỗi khi thêm banner: " . $e->getMessage());
        }
    }
    
    /**
     * Cập nhật banner
     */
    public function updateBanner($id, $data) {
        try {
            $sql = "UPDATE banner_ads SET 
                        ten_banner = :ten_banner,
                        mo_ta = :mo_ta,
                        hinh_anh = :hinh_anh,
                        link_url = :link_url,
                        thu_tu = :thu_tu,
                        trang_thai = :trang_thai,
                        loai_hien_thi = :loai_hien_thi,
                        thoi_gian_hien_thi = :thoi_gian_hien_thi,
                        hien_thi_lan_duy_nhat = :hien_thi_lan_duy_nhat,
                        ngay_bat_dau = :ngay_bat_dau,
                        ngay_ket_thuc = :ngay_ket_thuc,
                        updated_at = NOW()
                    WHERE id = :id";
                    
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':id' => $id,
                ':ten_banner' => $data['ten_banner'],
                ':mo_ta' => $data['mo_ta'],
                ':hinh_anh' => $data['hinh_anh'],
                ':link_url' => $data['link_url'],
                ':thu_tu' => $data['thu_tu'],
                ':trang_thai' => $data['trang_thai'],
                ':loai_hien_thi' => $data['loai_hien_thi'],
                ':thoi_gian_hien_thi' => $data['thoi_gian_hien_thi'],
                ':hien_thi_lan_duy_nhat' => $data['hien_thi_lan_duy_nhat'],
                ':ngay_bat_dau' => $data['ngay_bat_dau'],
                ':ngay_ket_thuc' => $data['ngay_ket_thuc']
            ]);
        } catch (Exception $e) {
            throw new Exception("Lỗi khi cập nhật banner: " . $e->getMessage());
        }
    }
    
    /**
     * Xóa banner
     */
    public function deleteBanner($id) {
        try {
            $sql = "DELETE FROM banner_ads WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (Exception $e) {
            throw new Exception("Lỗi khi xóa banner: " . $e->getMessage());
        }
    }
    
    /**
     * Cập nhật trạng thái banner
     */
    public function updateBannerStatus($id, $status) {
        try {
            $sql = "UPDATE banner_ads SET trang_thai = :status, updated_at = NOW() WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([':id' => $id, ':status' => $status]);
        } catch (Exception $e) {
            throw new Exception("Lỗi khi cập nhật trạng thái banner: " . $e->getMessage());
        }
    }
    
    /**
     * Lấy banner hiển thị cho client (popup)
     */
    public function getActiveBannersForClient($type = 'popup') {
        try {
            $sql = "SELECT * FROM banner_ads 
                    WHERE trang_thai = 1 
                    AND loai_hien_thi = :type
                    AND (ngay_bat_dau IS NULL OR ngay_bat_dau <= NOW())
                    AND (ngay_ket_thuc IS NULL OR ngay_ket_thuc >= NOW())
                    ORDER BY thu_tu ASC, id DESC";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':type' => $type]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Lỗi khi lấy banner hiển thị: " . $e->getMessage());
        }
    }
    
    /**
     * Tăng số lượt xem banner
     */
    public function increaseBannerView($id) {
        try {
            $sql = "UPDATE banner_ads SET luot_xem = luot_xem + 1 WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Tăng số lượt click banner
     */
    public function increaseBannerClick($id) {
        try {
            $sql = "UPDATE banner_ads SET luot_click = luot_click + 1 WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Lấy thống kê banner
     */
    public function getBannerStatistics() {
        try {
            $sql = "SELECT 
                        COUNT(*) as total_banners,
                        SUM(CASE WHEN trang_thai = 1 THEN 1 ELSE 0 END) as active_banners,
                        SUM(CASE WHEN loai_hien_thi = 'popup' THEN 1 ELSE 0 END) as popup_banners,
                        SUM(luot_xem) as total_views,
                        SUM(luot_click) as total_clicks,
                        CASE 
                            WHEN SUM(luot_xem) > 0 THEN ROUND((SUM(luot_click) / SUM(luot_xem)) * 100, 2)
                            ELSE 0 
                        END as click_through_rate
                    FROM banner_ads";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Ensure all values are not null
            return [
                'total_banners' => (int)($result['total_banners'] ?? 0),
                'active_banners' => (int)($result['active_banners'] ?? 0),
                'popup_banners' => (int)($result['popup_banners'] ?? 0),
                'total_views' => (int)($result['total_views'] ?? 0),
                'total_clicks' => (int)($result['total_clicks'] ?? 0),
                'click_through_rate' => (float)($result['click_through_rate'] ?? 0)
            ];
        } catch (PDOException $e) {
            return [
                'total_banners' => 0,
                'active_banners' => 0,
                'popup_banners' => 0,
                'total_views' => 0,
                'total_clicks' => 0,
                'click_through_rate' => 0
            ];
        }
    }
    
    /**
     * Kiểm tra tên banner đã tồn tại
     */
    public function isBannerNameExists($tenBanner, $excludeId = null) {
        try {
            $sql = "SELECT COUNT(*) as count FROM banner_ads WHERE ten_banner = :ten_banner";
            $params = [':ten_banner' => $tenBanner];
            
            if ($excludeId) {
                $sql .= " AND id != :exclude_id";
                $params[':exclude_id'] = $excludeId;
            }
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $result['count'] > 0;
        } catch (Exception $e) {
            return false;
        }
    }
}
?>
