<?php
require_once __DIR__ . '/../config/database.php';

class BannerController {
    private $conn;
    
    public function __construct() {
        $this->conn = connectDB();
    }
    
    /**
     * Lấy danh sách banner đang hoạt động
     */
    public function getActiveBanners() {
        try {            $sql = "SELECT * FROM banner_ads 
                    WHERE trang_thai = 'active' 
                    AND (ngay_bat_dau IS NULL OR ngay_bat_dau <= NOW())
                    AND (ngay_ket_thuc IS NULL OR ngay_ket_thuc >= NOW())
                    ORDER BY thu_tu ASC, id DESC";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $banners = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return [
                'success' => true,
                'banners' => $banners
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Lỗi khi lấy danh sách banner: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Tăng lượt xem banner
     */
    public function trackView($bannerId) {
        try {
            $sql = "UPDATE banner_ads SET luot_xem = luot_xem + 1 WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute([':id' => $bannerId]);
            
            return [
                'success' => $result
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Lỗi khi cập nhật lượt xem: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Tăng lượt click banner
     */
    public function trackClick($bannerId) {
        try {
            $sql = "UPDATE banner_ads SET luot_click = luot_click + 1 WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute([':id' => $bannerId]);
            
            return [
                'success' => $result
            ];
              } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Lỗi khi cập nhật lượt click: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Xử lý track banner view từ frontend
     */
    public function trackBannerView() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            $bannerId = (int)($input['banner_id'] ?? 0);
            
            if ($bannerId > 0) {
                $result = $this->trackView($bannerId);
            } else {
                $result = ['success' => false, 'message' => 'Banner ID không hợp lệ'];
            }
            
            header('Content-Type: application/json');
            echo json_encode($result);
            exit();
        }
    }
}

// Xử lý request
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    $controller = new BannerController();
    
    switch ($_GET['action']) {
        case 'getActiveBanners':
            $result = $controller->getActiveBanners();
            break;
        default:
            $result = ['success' => false, 'message' => 'Action không hợp lệ'];
    }
    
    header('Content-Type: application/json');
    echo json_encode($result);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $controller = new BannerController();
    
    switch ($_POST['action']) {
        case 'trackView':
            $bannerId = (int)($_POST['banner_id'] ?? 0);
            $result = $controller->trackView($bannerId);
            break;
            
        case 'trackClick':
            $bannerId = (int)($_POST['banner_id'] ?? 0);
            $result = $controller->trackClick($bannerId);
            break;
            
        default:
            $result = ['success' => false, 'message' => 'Action không hợp lệ'];
    }
    
    header('Content-Type: application/json');
    echo json_encode($result);
    exit();
}
?>
