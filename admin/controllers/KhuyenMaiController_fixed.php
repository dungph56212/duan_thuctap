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
     * Hiển thị khuyến mãi đang hoạt động
     */
    public function activeKhuyenMai() {
        $activePromotions = $this->model->getActivePromotions();
        require_once './views/khuyenmai/activeKhuyenMai.php';
    }
    
    /**
     * Hiển thị khuyến mãi sắp hết hạn
     */
    public function expiringKhuyenMai() {
        $expiringPromotions = $this->model->getExpiringPromotions();
        require_once './views/khuyenmai/expiringKhuyenMai.php';
    }
    
    /**
     * Hiển thị khuyến mãi đã hết hạn
     */
    public function expiredKhuyenMai() {
        $expiredPromotions = $this->model->getExpiredPromotions();
        require_once './views/khuyenmai/expiredKhuyenMai.php';
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
            require_once './views/khuyenmai/settingsKhuyenMai.php';
        } catch (Exception $e) {
            $this->errors[] = 'Có lỗi xảy ra: ' . $e->getMessage();
            require_once './views/khuyenmai/settingsKhuyenMai.php';
        }
    }
    
    /**
     * Xử lý cập nhật cài đặt khuyến mãi
     */
    public function postCaiDatKhuyenMai() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?act=cai-dat-khuyen-mai');
            exit();
        }
        
        try {
            $settings = [
                'max_promotions_per_user' => (int)($_POST['max_promotions_per_user'] ?? 5),
                'default_validity_days' => (int)($_POST['default_validity_days'] ?? 30),
                'auto_deactivate' => (int)($_POST['auto_deactivate'] ?? 1),
                'notify_expiring_days' => (int)($_POST['notify_expiring_days'] ?? 7),
                'email_notifications' => isset($_POST['email_notifications']) ? 1 : 0,
                'sms_notifications' => isset($_POST['sms_notifications']) ? 1 : 0,
                'min_order_amount' => (int)($_POST['min_order_amount'] ?? 0),
                'max_discount_percent' => (int)($_POST['max_discount_percent'] ?? 50),
                'max_discount_amount' => (int)($_POST['max_discount_amount'] ?? 1000000),
                'show_on_homepage' => isset($_POST['show_on_homepage']) ? 1 : 0,
                'show_countdown' => isset($_POST['show_countdown']) ? 1 : 0,
                'promotion_banner_text' => trim($_POST['promotion_banner_text'] ?? '')
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
        
        // Validate loại giảm giá
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
}
