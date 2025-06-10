<?php
class KhuyenMai {
    private $conn;
    
    public function __construct() {
        $this->conn = connectDB();
    }
    
    /**
     * Lấy tất cả khuyến mãi với phân trang và lọc
     */
    public function getAllKhuyenMaiWithPagination($limit = 10, $offset = 0, $filters = []) {
        try {
            $whereConditions = [];
            $params = [];
            
            // Xây dựng điều kiện WHERE
            if (!empty($filters['status']) && $filters['status'] !== '') {
                $whereConditions[] = "trang_thai = :status";
                $params[':status'] = $filters['status'];
            }
            
            if (!empty($filters['search'])) {
                $whereConditions[] = "(ma_khuyen_mai LIKE :search OR ten_khuyen_mai LIKE :search)";
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
            
            if (!empty($filters['type'])) {
                if ($filters['type'] === 'active') {
                    $whereConditions[] = "trang_thai = 1 AND ngay_bat_dau <= NOW() AND ngay_ket_thuc >= NOW()";
                } elseif ($filters['type'] === 'expired') {
                    $whereConditions[] = "ngay_ket_thuc < NOW()";
                } elseif ($filters['type'] === 'upcoming') {
                    $whereConditions[] = "ngay_bat_dau > NOW()";
                }
            }
            
            $whereClause = !empty($whereConditions) ? 'WHERE ' . implode(' AND ', $whereConditions) : '';
            
            // Đếm tổng số bản ghi
            $countSql = "SELECT COUNT(*) as total FROM khuyen_mai $whereClause";
            $countStmt = $this->conn->prepare($countSql);
            $countStmt->execute($params);
            $total = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            // Lấy dữ liệu với phân trang
            $sql = "SELECT *, 
                        CASE 
                            WHEN ngay_ket_thuc < NOW() THEN 'expired'
                            WHEN ngay_bat_dau > NOW() THEN 'upcoming'                        WHEN trang_thai = 1 AND ngay_bat_dau <= NOW() AND ngay_ket_thuc >= NOW() THEN 'active'
                            ELSE 'inactive'
                        END as status_label,
                        (SELECT COUNT(*) FROM don_hangs WHERE ma_khuyen_mai = khuyen_mai.ma_khuyen_mai) as so_lan_da_su_dung                    FROM khuyen_mai 
                    $whereClause 
                    ORDER BY id DESC 
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
            throw new Exception("Lỗi khi lấy danh sách khuyến mãi: " . $e->getMessage());
        }
    }
    
    /**
     * Lấy tất cả khuyến mãi (legacy method)
     */
    public function getAllKhuyenMai() {
        $sql = "SELECT *, 
                    CASE 
                        WHEN ngay_ket_thuc < NOW() THEN 'expired'
                        WHEN ngay_bat_dau > NOW() THEN 'upcoming'
                        WHEN trang_thai = 1 AND ngay_bat_dau <= NOW() AND ngay_ket_thuc >= NOW() THEN 'active'
                        ELSE 'inactive'
                    END as status_label
                FROM khuyen_mai ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Lấy khuyến mãi theo ID
     */
    public function getKhuyenMaiById($id) {
        $sql = "SELECT * FROM khuyen_mai WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
      /**
     * Thêm khuyến mãi mới
     */
    public function addKhuyenMai($data) {
        try {
            $sql = "INSERT INTO khuyen_mai (ma_khuyen_mai, ten_khuyen_mai, mo_ta, phan_tram_giam, gia_giam, so_luong, so_lan_su_dung, ngay_bat_dau, ngay_ket_thuc, trang_thai) VALUES (:ma_khuyen_mai, :ten_khuyen_mai, :mo_ta, :phan_tram_giam, :gia_giam, :so_luong, :so_lan_su_dung, :ngay_bat_dau, :ngay_ket_thuc, :trang_thai)";
            
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute($data);
            
        } catch (Exception $e) {
            throw new Exception("Lỗi khi thêm khuyến mãi: " . $e->getMessage());
        }
    }
      /**
     * Cập nhật khuyến mãi
     */
    public function updateKhuyenMai($id, $data) {
        try {
            $sql = "UPDATE khuyen_mai SET ma_khuyen_mai=:ma_khuyen_mai, ten_khuyen_mai=:ten_khuyen_mai, mo_ta=:mo_ta, phan_tram_giam=:phan_tram_giam, gia_giam=:gia_giam, so_luong=:so_luong, so_lan_su_dung=:so_lan_su_dung, ngay_bat_dau=:ngay_bat_dau, ngay_ket_thuc=:ngay_ket_thuc, trang_thai=:trang_thai WHERE id=:id";
            
            $data['id'] = $id;
            
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute($data);
            
        } catch (Exception $e) {
            throw new Exception("Lỗi khi cập nhật khuyến mãi: " . $e->getMessage());
        }
    }
      /**
     * Xóa khuyến mãi
     */
    public function deleteKhuyenMai($id) {
        try {
            $sql = "DELETE FROM khuyen_mai WHERE id = :id";
            
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([':id' => $id]);
            
        } catch (Exception $e) {
            throw new Exception("Lỗi khi xóa khuyến mãi: " . $e->getMessage());
        }
    }
    
    /**
     * Kiểm tra mã khuyến mãi đã tồn tại
     */
    public function isPromotionCodeExists($code, $excludeId = null) {
        try {
            $sql = "SELECT COUNT(*) as count FROM khuyen_mai WHERE ma_khuyen_mai = :code";
            $params = [':code' => $code];
            
            if ($excludeId) {
                $sql .= " AND id != :exclude_id";
                $params[':exclude_id'] = $excludeId;
            }
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            
            return $stmt->fetch(PDO::FETCH_ASSOC)['count'] > 0;
            
        } catch (Exception $e) {
            throw new Exception("Lỗi khi kiểm tra mã khuyến mãi: " . $e->getMessage());
        }
    }
    
    /**
     * Kiểm tra khuyến mãi có đang được sử dụng không
     */
    public function isPromotionInUse($id) {
        try {
            $sql = "SELECT COUNT(*) as count FROM don_hangs dh 
                    JOIN khuyen_mai km ON dh.ma_khuyen_mai = km.ma_khuyen_mai 
                    WHERE km.id = :id";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            return $stmt->fetch(PDO::FETCH_ASSOC)['count'] > 0;
            
        } catch (Exception $e) {
            return false; // Nếu có lỗi, cho phép xóa
        }
    }
    
    /**
     * Cập nhật trạng thái khuyến mãi
     */
    public function updatePromotionStatus($id, $status) {
        try {
            $sql = "UPDATE khuyen_mai SET trang_thai = :status WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([':status' => $status, ':id' => $id]);
            
        } catch (Exception $e) {
            throw new Exception("Lỗi khi cập nhật trạng thái: " . $e->getMessage());
        }
    }
    
    /**
     * Nhân bản khuyến mãi
     */
    public function duplicatePromotion($id) {
        try {
            // Lấy thông tin khuyến mãi gốc
            $original = $this->getKhuyenMaiById($id);
            if (!$original) {
                throw new Exception("Không tìm thấy khuyến mãi gốc");
            }
            
            // Tạo mã mới
            $newCode = $original['ma_khuyen_mai'] . '_COPY_' . date('YmdHis');
              // Tạo dữ liệu mới
            $newData = [
                'ma_khuyen_mai' => $newCode,
                'ten_khuyen_mai' => $original['ten_khuyen_mai'] . ' (Bản sao)',
                'mo_ta' => $original['mo_ta'],
                'loai_giam' => $original['loai_giam'] ?? 1,
                'phan_tram_giam' => $original['phan_tram_giam'] ?? 0,
                'gia_giam' => $original['gia_giam'] ?? 0,
                'so_luong' => $original['so_luong'],
                'so_lan_su_dung_toi_da' => $original['so_lan_su_dung_toi_da'] ?? 1,
                'gia_tri_don_hang_toi_thieu' => $original['gia_tri_don_hang_toi_thieu'] ?? 0,
                'gia_tri_giam_toi_da' => $original['gia_tri_giam_toi_da'] ?? 0,
                'ngay_bat_dau' => date('Y-m-d'),
                'ngay_ket_thuc' => date('Y-m-d', strtotime('+30 days')),
                'ap_dung_cho' => $original['ap_dung_cho'] ?? 'all',
                'trang_thai' => 0 // Tạo ở trạng thái tạm ngưng
            ];
            
            return $this->addKhuyenMai($newData);
            
        } catch (Exception $e) {
            throw new Exception("Lỗi khi nhân bản khuyến mãi: " . $e->getMessage());
        }
    }
    
    /**
     * Lấy thống kê khuyến mãi
     */
    public function getPromotionStatistics() {
        try {
            $sql = "SELECT 
                        COUNT(*) as total_promotions,
                        SUM(CASE WHEN trang_thai = 1 AND ngay_bat_dau <= NOW() AND ngay_ket_thuc >= NOW() THEN 1 ELSE 0 END) as active_promotions,
                        SUM(so_lan_su_dung) as total_usage,
                        SUM(CASE 
                            WHEN phan_tram_giam > 0 THEN so_lan_su_dung * 50000 
                            ELSE so_lan_su_dung * gia_giam 
                        END) as total_discount_amount
                    FROM khuyen_mai";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            return [
                'total_promotions' => 0,
                'active_promotions' => 0,
                'total_usage' => 0,
                'total_discount_amount' => 0
            ];
        }
    }
    
    /**
     * Lấy top khuyến mãi hiệu quả nhất
     */
    public function getTopPromotions($limit = 5) {
        try {
            $sql = "SELECT * FROM khuyen_mai 
                    WHERE so_lan_su_dung > 0 
                    ORDER BY so_lan_su_dung DESC 
                    LIMIT ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$limit]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }
    
    /**
     * Lấy dữ liệu biểu đồ theo tháng
     */
    public function getMonthlyPromotionData() {
        try {
            $sql = "SELECT 
                        DATE_FORMAT(ngay_bat_dau, '%Y-%m') as month,
                        COUNT(*) as promotions_created,
                        SUM(so_lan_su_dung) as total_usage,
                        SUM(CASE 
                            WHEN phan_tram_giam > 0 THEN so_lan_su_dung * 50000 
                            ELSE so_lan_su_dung * gia_giam 
                        END) as total_amount
                    FROM khuyen_mai 
                    WHERE ngay_bat_dau >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
                    GROUP BY DATE_FORMAT(ngay_bat_dau, '%Y-%m')
                    ORDER BY month ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            
            // Format data for chart
            $labels = [];
            $usage = [];
            $amount = [];
            
            foreach ($data as $row) {
                $labels[] = date('m/Y', strtotime($row['month'] . '-01'));
                $usage[] = $row['total_usage'];
                $amount[] = $row['total_amount'];
            }
            
            return [
                'labels' => $labels,
                'usage' => $usage,
                'amount' => $amount
            ];
        } catch (PDOException $e) {
            return [
                'labels' => [],
                'usage' => [],
                'amount' => []
            ];
        }
    }
    
    /**
     * Lấy dữ liệu báo cáo
     */
    public function getPromotionReportData($filters = []) {
        try {
            $whereConditions = [];
            $params = [];
            
            if (!empty($filters['status'])) {
                $whereConditions[] = "km.trang_thai = :status";
                $params[':status'] = $filters['status'];
            }
            
            if (!empty($filters['date_from'])) {
                $whereConditions[] = "km.ngay_bat_dau >= :date_from";
                $params[':date_from'] = $filters['date_from'];
            }
            
            if (!empty($filters['date_to'])) {
                $whereConditions[] = "km.ngay_ket_thuc <= :date_to";
                $params[':date_to'] = $filters['date_to'];
            }
            
            $whereClause = !empty($whereConditions) ? 'WHERE ' . implode(' AND ', $whereConditions) : '';
            
            $sql = "SELECT                        km.*,
                        COUNT(dh.id) as so_don_hang_su_dung,
                        COALESCE(SUM(dh.tong_tien), 0) as tong_gia_tri_don_hang,
                        COALESCE(SUM(dh.gia_tri_giam), 0) as tong_gia_tri_giam
                    FROM khuyen_mai km
                    LEFT JOIN don_hangs dh ON km.ma_khuyen_mai = dh.ma_khuyen_mai
                    $whereClause                    GROUP BY km.id
                    ORDER BY km.id DESC";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (Exception $e) {
            throw new Exception("Lỗi khi lấy dữ liệu báo cáo: " . $e->getMessage());
        }
    }
    
    /**
     * Kiểm tra và áp dụng mã khuyến mãi
     */
    public function checkMaKhuyenMai($ma, $giaTriDonHang = 0) {
        try {
            $sql = "SELECT * FROM khuyen_mai 
                    WHERE ma_khuyen_mai = :ma 
                    AND trang_thai = 1 
                    AND so_luong > 0 
                    AND ngay_bat_dau <= NOW() 
                    AND ngay_ket_thuc >= NOW()
                    AND gia_tri_don_hang_toi_thieu <= :gia_tri_don_hang";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':ma' => $ma, 
                ':gia_tri_don_hang' => $giaTriDonHang
            ]);
            
            $promotion = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($promotion) {
                // Kiểm tra số lần sử dụng tối đa
                $usageCount = $this->getPromotionUsageCount($ma);
                if ($usageCount >= $promotion['so_lan_su_dung_toi_da']) {
                    return false;
                }
                
                // Tính toán giá trị giảm
                if ($promotion['loai_giam'] == 1) { // Giảm theo phần trăm
                    $giaTriGiam = ($giaTriDonHang * $promotion['phan_tram_giam']) / 100;
                    if ($promotion['gia_tri_giam_toi_da'] > 0) {
                        $giaTriGiam = min($giaTriGiam, $promotion['gia_tri_giam_toi_da']);
                    }
                } else { // Giảm theo số tiền cố định
                    $giaTriGiam = $promotion['gia_giam'];
                }
                
                $promotion['gia_tri_giam_thuc_te'] = $giaTriGiam;
                return $promotion;
            }
            
            return false;
            
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Lấy số lần sử dụng của mã khuyến mãi
     */
    public function getPromotionUsageCount($ma) {
        try {
            $sql = "SELECT COUNT(*) as count FROM don_hangs WHERE ma_khuyen_mai = :ma";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':ma' => $ma]);
            
            return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
            
        } catch (Exception $e) {
            return 0;
        }
    }
    
    /**
     * Sử dụng mã khuyến mãi (giảm số lượng)
     */
    public function usePromotion($ma) {
        try {
            $sql = "UPDATE khuyen_mai SET so_luong = so_luong - 1 WHERE ma_khuyen_mai = :ma AND so_luong > 0";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([':ma' => $ma]);
            
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Hoàn lại mã khuyến mãi khi hủy đơn hàng
     */
    public function restorePromotion($ma) {
        try {        $sql = "UPDATE khuyen_mai SET so_luong = so_luong + 1 WHERE ma_khuyen_mai = :ma";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([':ma' => $ma]);
            
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Lấy khuyến mãi đang hoạt động
     */
    public function getActivePromotions() {
        try {
            $sql = "SELECT * FROM khuyen_mai 
                    WHERE trang_thai = 1 
                    AND ngay_bat_dau <= NOW() 
                    AND ngay_ket_thuc >= NOW() 
                    AND so_luong > 0
                    ORDER BY ngay_ket_thuc ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }
    
    /**
     * Lấy khuyến mãi sắp hết hạn (trong 7 ngày tới)
     */
    public function getExpiringPromotions($days = 7) {
        try {
            $sql = "SELECT * FROM khuyen_mai 
                    WHERE trang_thai = 1 
                    AND ngay_bat_dau <= NOW() 
                    AND ngay_ket_thuc >= NOW() 
                    AND ngay_ket_thuc <= DATE_ADD(NOW(), INTERVAL ? DAY)
                    ORDER BY ngay_ket_thuc ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$days]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }
    
    /**
     * Lấy khuyến mãi đã hết hạn
     */
    public function getExpiredPromotions() {
        try {
            $sql = "SELECT * FROM khuyen_mai 
                    WHERE ngay_ket_thuc < NOW() 
                    ORDER BY ngay_ket_thuc DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }
    
    /**
     * Cập nhật cài đặt khuyến mãi
     */
    public function updatePromotionSettings($settings) {
        try {
            // Kiểm tra xem đã có cài đặt chưa
            $checkSql = "SELECT COUNT(*) as count FROM promotion_settings";
            $checkStmt = $this->conn->prepare($checkSql);
            $checkStmt->execute();
            $exists = $checkStmt->fetch(PDO::FETCH_ASSOC)['count'] > 0;
            
            if ($exists) {
                $sql = "UPDATE promotion_settings SET 
                            auto_deactivate_expired = :auto_deactivate_expired,
                            notification_before_expiry = :notification_before_expiry,
                            max_usage_per_customer = :max_usage_per_customer,
                            allow_stacking = :allow_stacking,
                            email_notifications = :email_notifications,
                            updated_at = NOW()";
            } else {
                $sql = "INSERT INTO promotion_settings 
                        (auto_deactivate_expired, notification_before_expiry, max_usage_per_customer, allow_stacking, email_notifications, created_at, updated_at) 
                        VALUES (:auto_deactivate_expired, :notification_before_expiry, :max_usage_per_customer, :allow_stacking, :email_notifications, NOW(), NOW())";
            }
            
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute($settings);
              } catch (Exception $e) {
            throw new Exception("Lỗi khi cập nhật cài đặt: " . $e->getMessage());
        }
    }
    
    /**
     * Lấy số lượng khuyến mãi theo trạng thái
     */
    public function getPromotionCounts() {
        try {
            $sql = "SELECT 
                        COUNT(*) as total,
                        SUM(CASE WHEN trang_thai = 1 AND ngay_bat_dau <= NOW() AND ngay_ket_thuc >= NOW() THEN 1 ELSE 0 END) as active,
                        SUM(CASE WHEN trang_thai = 1 AND ngay_ket_thuc BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 7 DAY) THEN 1 ELSE 0 END) as expiring,
                        SUM(CASE WHEN ngay_ket_thuc < NOW() THEN 1 ELSE 0 END) as expired,
                        SUM(CASE WHEN ngay_bat_dau > NOW() THEN 1 ELSE 0 END) as upcoming
                    FROM khuyen_mai";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (Exception $e) {
            throw new Exception("Lỗi khi lấy số lượng: " . $e->getMessage());
        }
    }
    
    /**
     * Lấy khuyến mãi để xuất báo cáo
     */
    public function getPromotionsForExport($dateFrom, $dateTo) {
        try {
            $sql = "SELECT km.*, 
                        (SELECT COUNT(*) FROM don_hang WHERE ma_khuyen_mai = km.ma_khuyen_mai) as so_lan_da_su_dung
                    FROM khuyen_mai km
                    WHERE km.created_at BETWEEN :date_from AND :date_to
                    ORDER BY km.created_at DESC";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':date_from' => $dateFrom . ' 00:00:00',
                ':date_to' => $dateTo . ' 23:59:59'
            ]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (Exception $e) {
            throw new Exception("Lỗi khi lấy dữ liệu xuất báo cáo: " . $e->getMessage());
        }
    }
    
    /**
     * Lấy cài đặt khuyến mãi
     */
    public function getPromotionSettings() {
        try {
            $sql = "SELECT * FROM promotion_settings LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $settings = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Nếu chưa có cài đặt, trả về giá trị mặc định
            if (!$settings) {
                return [
                    'auto_deactivate_expired' => 1,
                    'notification_before_expiry' => 7,
                    'max_usage_per_customer' => 1,
                    'allow_stacking' => 0,
                    'email_notifications' => 1
                ];
            }
            
            return $settings;
        } catch (Exception $e) {
            // Trả về giá trị mặc định nếu có lỗi
            return [
                'auto_deactivate_expired' => 1,
                'notification_before_expiry' => 7,
                'max_usage_per_customer' => 1,
                'allow_stacking' => 0,
                'email_notifications' => 1
            ];
        }
    }
}