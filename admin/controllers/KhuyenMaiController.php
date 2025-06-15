<?php
require_once __DIR__ . '/../models/KhuyenMai.php';

class KhuyenMaiController {
    private $model;
    private $errors = [];
    private $successMessage = '';
    
    public function __construct() {
        $this->model = new KhuyenMai();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    /**
     * Hiển thị danh sách khuyến mãi với phân trang và lọc
     */
    public function danhSachKhuyenMai() {
        try {
            // Xử lý các tham số lọc và phân trang
            $page = max(1, (int)($_GET['page'] ?? 1));
            $limit = 10;
            $offset = ($page - 1) * $limit;
            
            $filters = [
                'status' => $_GET['status'] ?? '',
                'type' => $_GET['type'] ?? '',
                'search' => trim($_GET['search'] ?? ''),
                'date_from' => $_GET['date_from'] ?? '',
                'date_to' => $_GET['date_to'] ?? ''
            ];
              // Lấy dữ liệu với phân trang
            $result = $this->model->getAllKhuyenMaiWithPagination($limit, $offset, $filters);
            $list = $result['data'];
            $totalRecords = $result['total'];
            $totalPages = ceil($totalRecords / $limit);
            
            // Lấy thống kê
            $statistics = $this->model->getPromotionStatistics();
            
            // Lấy thông báo từ session
            $this->getSessionMessages();
            
            require './views/khuyenmai/listKhuyenMai.php';
        } catch (Exception $e) {
            $this->errors[] = 'Có lỗi xảy ra khi tải danh sách khuyến mãi: ' . $e->getMessage();
            
            // Provide default values when there's an error
            $list = [];
            $totalRecords = 0;
            $totalPages = 0;
            $statistics = [
                'total_promotions' => 0,
                'active_promotions' => 0,
                'upcoming_promotions' => 0,
                'expired_promotions' => 0,
                'total_usage' => 0,
                'total_discount_amount' => 0
            ];
            
            require './views/khuyenmai/listKhuyenMai.php';
        }
    }
    
    /**
     * Hiển thị form thêm khuyến mãi
     */
    public function formAddKhuyenMai() {
        $this->getSessionMessages();
        require './views/khuyenmai/addKhuyenMai.php';
    }
    
    /**
     * Xử lý thêm khuyến mãi mới
     */
    public function postAddKhuyenMai() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?act=form-them-khuyen-mai');
            exit();
        }
        
        try {
            // Validate dữ liệu đầu vào
            $validatedData = $this->validatePromotionData($_POST);
            
            if (!empty($this->errors)) {
                $this->setSessionMessage('errors', $this->errors);
                header('Location: ?act=form-them-khuyen-mai');
                exit();
            }
            
            // Kiểm tra mã khuyến mãi đã tồn tại
            if ($this->model->isPromotionCodeExists($validatedData['ma_khuyen_mai'])) {
                $this->setSessionMessage('errors', ['Mã khuyến mãi đã tồn tại trong hệ thống!']);
                header('Location: ?act=form-them-khuyen-mai');
                exit();
            }
            
            // Thêm khuyến mãi
            $result = $this->model->addKhuyenMai($validatedData);
            
            if ($result) {
                $this->setSessionMessage('success', 'Thêm khuyến mãi thành công!');
                
                // Gửi thông báo nếu có khách hàng đăng ký nhận thông tin khuyến mãi
                $this->notifySubscribedCustomers($validatedData);
            } else {
                $this->setSessionMessage('errors', ['Có lỗi xảy ra khi thêm khuyến mãi!']);
            }
            
        } catch (Exception $e) {
            $this->setSessionMessage('errors', ['Có lỗi hệ thống: ' . $e->getMessage()]);
        }
        
        header('Location: ?act=danh-sach-khuyen-mai');
        exit();
    }
    
    /**
     * Hiển thị form sửa khuyến mãi
     */
    public function formEditKhuyenMai() {
        try {
            $id = (int)($_GET['id'] ?? 0);
            
            if ($id <= 0) {
                $this->setSessionMessage('errors', ['ID khuyến mãi không hợp lệ!']);
                header('Location: ?act=danh-sach-khuyen-mai');
                exit();
            }
              $khuyenMai = $this->model->getKhuyenMaiById($id);
            
            if (!$khuyenMai) {
                $this->setSessionMessage('errors', ['Không tìm thấy khuyến mãi!']);
                header('Location: ?act=danh-sach-khuyen-mai');
                exit();
            }
            
            $this->getSessionMessages();
            require './views/khuyenmai/editKhuyenMai.php';
            
        } catch (Exception $e) {
            $this->setSessionMessage('errors', ['Có lỗi xảy ra: ' . $e->getMessage()]);
            header('Location: ?act=danh-sach-khuyen-mai');
            exit();
        }
    }
    
    /**
     * Xử lý cập nhật khuyến mãi
     */
    public function postEditKhuyenMai() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?act=danh-sach-khuyen-mai');
            exit();
        }
          try {
            $id = (int)($_GET['id'] ?? 0);
            
            if ($id <= 0) {
                $this->setSessionMessage('errors', ['ID khuyến mãi không hợp lệ!']);
                header('Location: ?act=danh-sach-khuyen-mai');
                exit();
            }
            
            // Kiểm tra khuyến mãi tồn tại
            $existingPromotion = $this->model->getKhuyenMaiById($id);
            if (!$existingPromotion) {
                $this->setSessionMessage('errors', ['Không tìm thấy khuyến mãi!']);
                header('Location: ?act=danh-sach-khuyen-mai');
                exit();
            }
            
            // Validate dữ liệu
            $validatedData = $this->validatePromotionData($_POST, $id);
            
            if (!empty($this->errors)) {
                $this->setSessionMessage('errors', $this->errors);
                header('Location: ?act=form-sua-khuyen-mai&id=' . $id);
                exit();
            }
            
            // Kiểm tra mã khuyến mãi trùng (ngoại trừ chính nó)
            if ($this->model->isPromotionCodeExists($validatedData['ma_khuyen_mai'], $id)) {
                $this->setSessionMessage('errors', ['Mã khuyến mãi đã tồn tại trong hệ thống!']);
                header('Location: ?act=form-sua-khuyen-mai&id=' . $id);
                exit();
            }
              // Cập nhật khuyến mãi
            $result = $this->model->updateKhuyenMai($id, $validatedData);
            
            if ($result) {
                $this->setSessionMessage('success', 'Cập nhật khuyến mãi thành công!');
            } else {
                $this->setSessionMessage('errors', ['Có lỗi xảy ra khi cập nhật khuyến mãi!']);
            }
            
        } catch (Exception $e) {
            $this->setSessionMessage('errors', ['Có lỗi hệ thống: ' . $e->getMessage()]);
        }
        
        header('Location: ?act=danh-sach-khuyen-mai');
        exit();
    }
    
    /**
     * Xóa khuyến mãi (soft delete)
     */
    public function deleteKhuyenMai() {
        try {
            $id = (int)($_GET['id'] ?? 0);
            
            if ($id <= 0) {
                $this->setSessionMessage('errors', ['ID khuyến mãi không hợp lệ!']);
                header('Location: ?act=danh-sach-khuyen-mai');
                exit();
            }
            
            // Kiểm tra khuyến mãi có đang được sử dụng không
            if ($this->model->isPromotionInUse($id)) {
                $this->setSessionMessage('errors', ['Không thể xóa khuyến mãi đang được sử dụng!']);
                header('Location: ?act=danh-sach-khuyen-mai');
                exit();
            }
            
            $result = $this->model->deleteKhuyenMai($id);
            
            if ($result) {
                $this->setSessionMessage('success', 'Xóa khuyến mãi thành công!');
            } else {
                $this->setSessionMessage('errors', ['Có lỗi xảy ra khi xóa khuyến mãi!']);
            }
            
        } catch (Exception $e) {
            $this->setSessionMessage('errors', ['Có lỗi hệ thống: ' . $e->getMessage()]);
        }
        
        header('Location: ?act=danh-sach-khuyen-mai');
        exit();
    }
    
    /**
     * Cập nhật trạng thái khuyến mãi
     */
    public function updatePromotionStatus() {
        try {
            $id = (int)($_POST['id'] ?? 0);
            $status = (int)($_POST['status'] ?? 0);
            
            if ($id <= 0) {
                echo json_encode(['success' => false, 'message' => 'ID không hợp lệ']);
                exit();
            }
            
            $result = $this->model->updatePromotionStatus($id, $status);
            
            echo json_encode([
                'success' => $result,
                'message' => $result ? 'Cập nhật trạng thái thành công!' : 'Có lỗi xảy ra!'
            ]);
            
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Lỗi hệ thống: ' . $e->getMessage()]);
        }
        exit();
    }
    
    /**
     * Nhân bản khuyến mãi
     */
    public function duplicatePromotion() {
        try {
            $id = (int)($_GET['id'] ?? 0);
            
            if ($id <= 0) {
                $this->setSessionMessage('errors', ['ID khuyến mãi không hợp lệ!']);
                header('Location: ?act=danh-sach-khuyen-mai');
                exit();
            }
            
            $result = $this->model->duplicatePromotion($id);
            
            if ($result) {
                $this->setSessionMessage('success', 'Nhân bản khuyến mãi thành công!');
            } else {
                $this->setSessionMessage('errors', ['Có lỗi xảy ra khi nhân bản khuyến mãi!']);
            }
            
        } catch (Exception $e) {
            $this->setSessionMessage('errors', ['Có lỗi hệ thống: ' . $e->getMessage()]);
        }
        
        header('Location: ?act=danh-sach-khuyen-mai');
        exit();
    }
    
    /**
     * Xuất báo cáo khuyến mãi
     */
    
    /**
     * Validate dữ liệu khuyến mãi
     */
    private function validatePromotionData($data, $excludeId = null) {
        $this->errors = [];
        
        // Validate mã khuyến mãi
        $maKhuyenMai = trim($data['ma_khuyen_mai'] ?? '');
        if (empty($maKhuyenMai)) {
            $this->errors[] = 'Mã khuyến mãi không được để trống!';
        } elseif (strlen($maKhuyenMai) < 3 || strlen($maKhuyenMai) > 20) {
            $this->errors[] = 'Mã khuyến mãi phải từ 3-20 ký tự!';
        } elseif (!preg_match('/^[A-Z0-9]+$/', $maKhuyenMai)) {
            $this->errors[] = 'Mã khuyến mãi chỉ được chứa chữ cái viết hoa và số!';
        }
        
        // Validate tên khuyến mãi
        $tenKhuyenMai = trim($data['ten_khuyen_mai'] ?? '');
        if (empty($tenKhuyenMai)) {
            $this->errors[] = 'Tên khuyến mãi không được để trống!';
        } elseif (strlen($tenKhuyenMai) > 255) {
            $this->errors[] = 'Tên khuyến mãi không được quá 255 ký tự!';
        }
          // Validate loại giảm giá - remove loai_giam validation since it doesn't exist in DB
        $phanTramGiam = (float)($data['phan_tram_giam'] ?? 0);
        $giaGiam = (float)($data['gia_giam'] ?? 0);
        
        // Ensure we have either percentage or fixed amount
        if ($phanTramGiam <= 0 && $giaGiam <= 0) {
            $this->errors[] = 'Phải có phần trăm giảm hoặc số tiền giảm!';
        }
        
        if ($phanTramGiam > 0 && $phanTramGiam > 100) {
            $this->errors[] = 'Phần trăm giảm không được quá 100%!';
        }
          // Validate số lượng và số lần sử dụng
        $soLuong = (int)($data['so_luong'] ?? 0);
        $soLanSuDung = (int)($data['so_lan_su_dung'] ?? 0);
        
        if ($soLuong <= 0) {
            $this->errors[] = 'Số lượng phải lớn hơn 0!';
        }
        
        if ($soLanSuDung < 0) {
            $this->errors[] = 'Số lần sử dụng không được âm!';
        }
        
        // Validate ngày
        $ngayBatDau = $data['ngay_bat_dau'] ?? '';
        $ngayKetThuc = $data['ngay_ket_thuc'] ?? '';
        
        if (empty($ngayBatDau)) {
            $this->errors[] = 'Ngày bắt đầu không được để trống!';
        }
        
        if (empty($ngayKetThuc)) {
            $this->errors[] = 'Ngày kết thúc không được để trống!';
        }
          if (!empty($ngayBatDau) && !empty($ngayKetThuc)) {
            $startDate = new DateTime($ngayBatDau);
            $endDate = new DateTime($ngayKetThuc);
            
            if ($startDate >= $endDate) {
                $this->errors[] = 'Ngày kết thúc phải sau ngày bắt đầu!';
            }
        }
        
        // Return validated data nếu không có lỗi
        if (empty($this->errors)) {
            return [
                'ma_khuyen_mai' => $maKhuyenMai,
                'ten_khuyen_mai' => $tenKhuyenMai,
                'mo_ta' => trim($data['mo_ta'] ?? ''),
                'phan_tram_giam' => $phanTramGiam,
                'gia_giam' => $giaGiam,
                'so_luong' => $soLuong,
                'so_lan_su_dung' => $soLanSuDung,
                'ngay_bat_dau' => $ngayBatDau,
                'ngay_ket_thuc' => $ngayKetThuc,
                'trang_thai' => (int)($data['trang_thai'] ?? 1)
            ];
        }
        
        return [];
    }
    
    /**
     * Set session message
     */
    private function setSessionMessage($type, $message) {
        $_SESSION[$type] = $message;
    }
    
    /**
     * Get session messages
     */
    private function getSessionMessages() {
        if (isset($_SESSION['errors'])) {
            $this->errors = $_SESSION['errors'];
            unset($_SESSION['errors']);
        }
        
        if (isset($_SESSION['success'])) {
            $this->successMessage = $_SESSION['success'];
            unset($_SESSION['success']);
        }
    }
    
    /**
     * Gửi thông báo khuyến mãi cho khách hàng đăng ký
     */
    private function notifySubscribedCustomers($promotionData) {
        // TODO: Implement notification system
        // Có thể gửi email hoặc thông báo push
    }
  
    
    // Getter methods cho views
    public function getErrors() {
        return $this->errors;
    }
    
    public function getSuccessMessage() {
        return $this->successMessage;
    }
    
    /**
     * Hiển thị danh sách khuyến mãi đang hoạt động
     */
    public function khuyenMaiDangHoatDong() {
        try {
            $page = max(1, (int)($_GET['page'] ?? 1));
            $limit = 10;
            $offset = ($page - 1) * $limit;
            
            $filters = [
                'type' => 'active',
                'search' => trim($_GET['search'] ?? '')
            ];
            
            $result = $this->model->getAllKhuyenMaiWithPagination($limit, $offset, $filters);
            $list = $result['data'];
            $totalRecords = $result['total'];
            $totalPages = ceil($totalRecords / $limit);
            
            $this->getSessionMessages();
            require './views/khuyenmai/activePromotions.php';
        } catch (Exception $e) {
            $this->errors[] = 'Có lỗi xảy ra: ' . $e->getMessage();
            require './views/khuyenmai/activePromotions.php';
        }
    }
    
    /**
     * Hiển thị danh sách khuyến mãi sắp hết hạn
     */
    public function khuyenMaiSapHetHan() {
        try {
            $page = max(1, (int)($_GET['page'] ?? 1));
            $limit = 10;
            $offset = ($page - 1) * $limit;
            
            // Lấy khuyến mãi sắp hết hạn trong 7 ngày tới
            $result = $this->model->getExpiringPromotions($limit, $offset, 7);
            $list = $result['data'];
            $totalRecords = $result['total'];
            $totalPages = ceil($totalRecords / $limit);
            
            $this->getSessionMessages();
            require './views/khuyenmai/expiringPromotions.php';
        } catch (Exception $e) {
            $this->errors[] = 'Có lỗi xảy ra: ' . $e->getMessage();
            require './views/khuyenmai/expiringPromotions.php';
        }
    }
    
    /**
     * Hiển thị danh sách khuyến mãi đã hết hạn
     */
    public function khuyenMaiDaHetHan() {
        try {
            $page = max(1, (int)($_GET['page'] ?? 1));
            $limit = 10;
            $offset = ($page - 1) * $limit;
            
            $filters = [
                'type' => 'expired',
                'search' => trim($_GET['search'] ?? '')
            ];
            
            $result = $this->model->getAllKhuyenMaiWithPagination($limit, $offset, $filters);
            $list = $result['data'];
            $totalRecords = $result['total'];
            $totalPages = ceil($totalRecords / $limit);
            
            $this->getSessionMessages();
            require './views/khuyenmai/expiredPromotions.php';
        } catch (Exception $e) {
            $this->errors[] = 'Có lỗi xảy ra: ' . $e->getMessage();
            require './views/khuyenmai/expiredPromotions.php';
        }
    }
      /**
     * Hiển thị báo cáo thống kê khuyến mãi
     */
    public function baoCaoKhuyenMai() {
        // Get statistics
        $stats = $this->model->getPromotionStatistics();
        
        // Get all promotions for detailed report
        $allPromotions = $this->model->getAllKhuyenMai();
        
        // Get top performing promotions
        $topPromotions = $this->model->getTopPromotions(5);
        
        // Get chart data
        $chartData = $this->model->getMonthlyPromotionData();
        
        require_once './views/khuyenmai/reportKhuyenMai.php';
    }
    
    /**
     * Hiển thị trang cài đặt khuyến mãi
     */
    public function caiDatKhuyenMai() {
        try {
            $settings = $this->model->getPromotionSettings();
            $this->getSessionMessages();
            require './views/khuyenmai/settings.php';
        } catch (Exception $e) {
            $this->errors[] = 'Có lỗi xảy ra: ' . $e->getMessage();
            require './views/khuyenmai/settings.php';
        }
    }
    
    /**
     * Lưu cài đặt khuyến mãi
     */
    public function postCaiDatKhuyenMai() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?act=cai-dat-khuyen-mai');
            exit();
        }
        
        try {
            $settings = [
                'auto_deactivate_expired' => isset($_POST['auto_deactivate_expired']) ? 1 : 0,
                'notification_before_expiry' => (int)($_POST['notification_before_expiry'] ?? 7),
                'max_usage_per_customer' => (int)($_POST['max_usage_per_customer'] ?? 1),
                'allow_stacking' => isset($_POST['allow_stacking']) ? 1 : 0,
                'email_notifications' => isset($_POST['email_notifications']) ? 1 : 0
            ];
            
            $result = $this->model->updatePromotionSettings($settings);
            
            if ($result) {
                $this->setSessionMessage('success', 'Cập nhật cài đặt thành công!');
            } else {
                $this->setSessionMessage('errors', ['Có lỗi xảy ra khi cập nhật cài đặt!']);
            }
            
        } catch (Exception $e) {
            $this->setSessionMessage('errors', ['Có lỗi hệ thống: ' . $e->getMessage()]);
        }
        
        header('Location: ?act=cai-dat-khuyen-mai');
        exit();
    }
    
    /**
     * Kích hoạt/Vô hiệu hóa khuyến mãi (AJAX)
     */
    public function togglePromotionStatus() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ']);
            exit();
        }
        
        try {
            $id = (int)($_POST['id'] ?? 0);
            $status = (int)($_POST['status'] ?? 0);
            
            if ($id <= 0) {
                throw new Exception('ID khuyến mãi không hợp lệ');
            }
            
            $result = $this->model->updatePromotionStatus($id, $status);
            
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => $status ? 'Kích hoạt khuyến mãi thành công!' : 'Vô hiệu hóa khuyến mãi thành công!'
                ]);
            } else {
                throw new Exception('Không thể cập nhật trạng thái khuyến mãi');
            }
            
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit();    }
    
    /**
     * Xuất báo cáo khuyến mãi
     */
    public function exportPromotionReport() {
        try {
            $type = $_GET['type'] ?? 'excel';
            $dateFrom = $_GET['date_from'] ?? date('Y-m-01');
            $dateTo = $_GET['date_to'] ?? date('Y-m-t');
            
            $promotions = $this->model->getPromotionsForExport($dateFrom, $dateTo);
            
            if ($type === 'excel') {
                $this->exportToExcel($promotions, $dateFrom, $dateTo);
            } elseif ($type === 'pdf') {
                $this->exportToPDF($promotions, $dateFrom, $dateTo);
            }
            
        } catch (Exception $e) {
            $this->setSessionMessage('errors', ['Có lỗi xảy ra khi xuất báo cáo: ' . $e->getMessage()]);
            header('Location: ?act=danh-sach-khuyen-mai');
            exit();
        }
    }
    
    /**
     * Xuất báo cáo Excel
     */
    private function exportToExcel($promotions, $dateFrom, $dateTo) {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="bao_cao_khuyen_mai_' . date('dmY') . '.xls"');
        
        echo "<table border='1'>";
        echo "<tr>";
        echo "<th>Mã khuyến mãi</th>";
        echo "<th>Tên khuyến mãi</th>";
        echo "<th>Loại</th>";
        echo "<th>Giá trị</th>";
        echo "<th>Số lần sử dụng</th>";
        echo "<th>Ngày bắt đầu</th>";
        echo "<th>Ngày kết thúc</th>";
        echo "<th>Trạng thái</th>";
        echo "</tr>";
        
        foreach ($promotions as $promotion) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($promotion['ma_khuyen_mai']) . "</td>";
            echo "<td>" . htmlspecialchars($promotion['ten_khuyen_mai']) . "</td>";
            echo "<td>" . ($promotion['loai_khuyen_mai'] === 'percentage' ? 'Phần trăm' : 'Số tiền') . "</td>";
            echo "<td>" . number_format($promotion['gia_tri']) . "</td>";
            echo "<td>" . ($promotion['so_lan_da_su_dung'] ?? 0) . "</td>";
            echo "<td>" . date('d/m/Y', strtotime($promotion['ngay_bat_dau'])) . "</td>";
            echo "<td>" . date('d/m/Y', strtotime($promotion['ngay_ket_thuc'])) . "</td>";
            echo "<td>" . ($promotion['trang_thai'] ? 'Hoạt động' : 'Không hoạt động') . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
        exit();
    }
    
    /**
     * Xuất báo cáo PDF
     */
    private function exportToPDF($promotions, $dateFrom, $dateTo) {
        // TODO: Implement PDF export with actual PDF library
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="bao_cao_khuyen_mai_' . date('dmY') . '.pdf"');
        
        // For now, create a simple HTML that can be printed to PDF
        echo "<!DOCTYPE html>";
        echo "<html><head><meta charset='UTF-8'>";
        echo "<title>Báo cáo khuyến mãi từ " . date('d/m/Y', strtotime($dateFrom)) . " đến " . date('d/m/Y', strtotime($dateTo)) . "</title>";
        echo "<style>body{font-family:Arial,sans-serif;} table{width:100%;border-collapse:collapse;} th,td{border:1px solid #ddd;padding:8px;text-align:left;} th{background-color:#f2f2f2;}</style>";
        echo "</head><body>";
        echo "<h1>Báo cáo khuyến mãi</h1>";
        echo "<p>Từ ngày: " . date('d/m/Y', strtotime($dateFrom)) . " - Đến ngày: " . date('d/m/Y', strtotime($dateTo)) . "</p>";
        
        echo "<table>";
        echo "<tr><th>Mã khuyến mãi</th><th>Tên khuyến mãi</th><th>Loại</th><th>Giá trị</th><th>Số lần sử dụng</th><th>Ngày bắt đầu</th><th>Ngày kết thúc</th><th>Trạng thái</th></tr>";
        
        foreach ($promotions as $promotion) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($promotion['ma_khuyen_mai']) . "</td>";
            echo "<td>" . htmlspecialchars($promotion['ten_khuyen_mai']) . "</td>";
            echo "<td>" . ($promotion['loai_khuyen_mai'] === 'percentage' ? 'Phần trăm' : 'Số tiền') . "</td>";
            echo "<td>" . number_format($promotion['gia_tri']) . "</td>";
            echo "<td>" . ($promotion['so_lan_da_su_dung'] ?? 0) . "</td>";
            echo "<td>" . date('d/m/Y', strtotime($promotion['ngay_bat_dau'])) . "</td>";
            echo "<td>" . date('d/m/Y', strtotime($promotion['ngay_ket_thuc'])) . "</td>";
            echo "<td>" . ($promotion['trang_thai'] ? 'Hoạt động' : 'Không hoạt động') . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
        echo "</body></html>";
        exit();
    }

    /**
     * Lấy số lượng khuyến mãi theo trạng thái (AJAX)
     */
    public function getPromotionCounts() {
        header('Content-Type: application/json');
        
        try {
            $counts = $this->model->getPromotionCounts();
            echo json_encode(['success' => true, 'data' => $counts]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit();
    }}