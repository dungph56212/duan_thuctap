    <?php
require_once __DIR__ . '/../models/BannerAds.php';

class BannerAdsController {
    private $model;
    private $errors = [];
    private $successMessage = '';
    
    public function __construct() {
        $this->model = new BannerAds();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    /**
     * Hiển thị danh sách banner với phân trang và lọc
     */
    public function danhSachBanner() {
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
            $result = $this->model->getAllBannersWithPagination($limit, $offset, $filters);
            $list = $result['data'];
            $totalRecords = $result['total'];
            $totalPages = ceil($totalRecords / $limit);
            
            // Lấy thống kê
            $statistics = $this->model->getBannerStatistics();
            
            // Lấy thông báo từ session
            $this->getSessionMessages();
            
            require './views/banner/listBanner.php';
        } catch (Exception $e) {
            $this->errors[] = 'Có lỗi xảy ra khi tải danh sách banner: ' . $e->getMessage();
            
            // Provide default values when there's an error
            $list = [];
            $totalRecords = 0;
            $totalPages = 0;
            $statistics = [
                'total_banners' => 0,
                'active_banners' => 0,
                'popup_banners' => 0,
                'total_views' => 0,
                'total_clicks' => 0,
                'click_through_rate' => 0
            ];
            
            require './views/banner/listBanner.php';
        }
    }
    
    /**
     * Hiển thị form thêm banner
     */
    public function formAddBanner() {
        $this->getSessionMessages();
        require './views/banner/addBanner.php';
    }
    
    /**
     * Xử lý thêm banner mới
     */
    public function postAddBanner() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?act=form-them-banner');
            exit();
        }
        
        try {
            // Validate dữ liệu đầu vào
            $validatedData = $this->validateBannerData($_POST, $_FILES);
            
            if (!empty($this->errors)) {
                $this->setSessionMessage('errors', $this->errors);
                header('Location: ?act=form-them-banner');
                exit();
            }
            
            // Kiểm tra tên banner đã tồn tại
            if ($this->model->isBannerNameExists($validatedData['ten_banner'])) {
                $this->setSessionMessage('errors', ['Tên banner đã tồn tại trong hệ thống!']);
                header('Location: ?act=form-them-banner');
                exit();
            }
            
            // Upload file hình ảnh
            $uploadResult = $this->uploadBannerImage($_FILES['hinh_anh']);
            if (!$uploadResult['success']) {
                $this->setSessionMessage('errors', [$uploadResult['message']]);
                header('Location: ?act=form-them-banner');
                exit();
            }
            
            $validatedData['hinh_anh'] = $uploadResult['file_path'];
            
            // Thêm banner
            $result = $this->model->addBanner($validatedData);
            
            if ($result) {
                $this->setSessionMessage('success', 'Thêm banner thành công!');
            } else {
                $this->setSessionMessage('errors', ['Có lỗi xảy ra khi thêm banner!']);
            }
            
        } catch (Exception $e) {
            $this->setSessionMessage('errors', ['Có lỗi hệ thống: ' . $e->getMessage()]);
        }
        
        header('Location: ?act=danh-sach-banner');
        exit();
    }
    
    /**
     * Hiển thị form sửa banner
     */
    public function formEditBanner() {
        try {
            $id = (int)($_GET['id'] ?? 0);
            
            if ($id <= 0) {
                $this->setSessionMessage('errors', ['ID banner không hợp lệ!']);
                header('Location: ?act=danh-sach-banner');
                exit();
            }
            
            $banner = $this->model->getBannerById($id);
            
            if (!$banner) {
                $this->setSessionMessage('errors', ['Không tìm thấy banner!']);
                header('Location: ?act=danh-sach-banner');
                exit();
            }
            
            $this->getSessionMessages();
            require './views/banner/editBanner.php';
            
        } catch (Exception $e) {
            $this->setSessionMessage('errors', ['Có lỗi xảy ra: ' . $e->getMessage()]);
            header('Location: ?act=danh-sach-banner');
            exit();
        }
    }
    
    /**
     * Xử lý cập nhật banner
     */
    public function postEditBanner() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?act=danh-sach-banner');
            exit();
        }
        
        try {
            $id = (int)($_GET['id'] ?? 0);
            
            if ($id <= 0) {
                $this->setSessionMessage('errors', ['ID banner không hợp lệ!']);
                header('Location: ?act=danh-sach-banner');
                exit();
            }
            
            // Kiểm tra banner tồn tại
            $existingBanner = $this->model->getBannerById($id);
            if (!$existingBanner) {
                $this->setSessionMessage('errors', ['Không tìm thấy banner!']);
                header('Location: ?act=danh-sach-banner');
                exit();
            }
            
            // Validate dữ liệu
            $validatedData = $this->validateBannerData($_POST, $_FILES, $id);
            
            if (!empty($this->errors)) {
                $this->setSessionMessage('errors', $this->errors);
                header('Location: ?act=form-sua-banner&id=' . $id);
                exit();
            }
            
            // Kiểm tra tên banner trùng (ngoại trừ chính nó)
            if ($this->model->isBannerNameExists($validatedData['ten_banner'], $id)) {
                $this->setSessionMessage('errors', ['Tên banner đã tồn tại trong hệ thống!']);
                header('Location: ?act=form-sua-banner&id=' . $id);
                exit();
            }
            
            // Xử lý upload hình ảnh mới (nếu có)
            if (!empty($_FILES['hinh_anh']['name'])) {
                $uploadResult = $this->uploadBannerImage($_FILES['hinh_anh']);
                if (!$uploadResult['success']) {
                    $this->setSessionMessage('errors', [$uploadResult['message']]);
                    header('Location: ?act=form-sua-banner&id=' . $id);
                    exit();
                }
                
                // Xóa file cũ
                if (!empty($existingBanner['hinh_anh']) && file_exists($existingBanner['hinh_anh'])) {
                    unlink($existingBanner['hinh_anh']);
                }
                
                $validatedData['hinh_anh'] = $uploadResult['file_path'];
            } else {
                // Giữ nguyên hình ảnh cũ
                $validatedData['hinh_anh'] = $existingBanner['hinh_anh'];
            }
            
            // Cập nhật banner
            $result = $this->model->updateBanner($id, $validatedData);
            
            if ($result) {
                $this->setSessionMessage('success', 'Cập nhật banner thành công!');
            } else {
                $this->setSessionMessage('errors', ['Có lỗi xảy ra khi cập nhật banner!']);
            }
            
        } catch (Exception $e) {
            $this->setSessionMessage('errors', ['Có lỗi hệ thống: ' . $e->getMessage()]);
        }
        
        header('Location: ?act=danh-sach-banner');
        exit();
    }
    
    /**
     * Xóa banner
     */
    public function deleteBanner() {
        try {
            $id = (int)($_GET['id'] ?? 0);
            
            if ($id <= 0) {
                $this->setSessionMessage('errors', ['ID banner không hợp lệ!']);
                header('Location: ?act=danh-sach-banner');
                exit();
            }
            
            // Lấy thông tin banner để xóa file
            $banner = $this->model->getBannerById($id);
            
            $result = $this->model->deleteBanner($id);
            
            if ($result) {
                // Xóa file hình ảnh
                if ($banner && !empty($banner['hinh_anh']) && file_exists($banner['hinh_anh'])) {
                    unlink($banner['hinh_anh']);
                }
                
                $this->setSessionMessage('success', 'Xóa banner thành công!');
            } else {
                $this->setSessionMessage('errors', ['Có lỗi xảy ra khi xóa banner!']);
            }
            
        } catch (Exception $e) {
            $this->setSessionMessage('errors', ['Có lỗi hệ thống: ' . $e->getMessage()]);
        }
        
        header('Location: ?act=danh-sach-banner');
        exit();
    }
    
    /**
     * Cập nhật trạng thái banner (AJAX)
     */
    public function updateBannerStatus() {
        try {
            $id = (int)($_POST['id'] ?? 0);
            $status = (int)($_POST['status'] ?? 0);
            
            if ($id <= 0) {
                echo json_encode(['success' => false, 'message' => 'ID không hợp lệ']);
                exit();
            }
            
            $result = $this->model->updateBannerStatus($id, $status);
            
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
     * Validate dữ liệu banner
     */
    private function validateBannerData($data, $files, $excludeId = null) {
        $this->errors = [];
        
        // Validate tên banner
        $tenBanner = trim($data['ten_banner'] ?? '');
        if (empty($tenBanner)) {
            $this->errors[] = 'Tên banner không được để trống!';
        } elseif (strlen($tenBanner) > 255) {
            $this->errors[] = 'Tên banner không được quá 255 ký tự!';
        }
        
        // Validate hình ảnh (khi thêm mới)
        if ($excludeId === null && empty($files['hinh_anh']['name'])) {
            $this->errors[] = 'Vui lòng chọn hình ảnh banner!';
        }
        
        // Validate URL
        $linkUrl = trim($data['link_url'] ?? '');
        if (!empty($linkUrl) && !filter_var($linkUrl, FILTER_VALIDATE_URL) && !preg_match('/^\?act=/', $linkUrl)) {
            $this->errors[] = 'Link URL không hợp lệ!';
        }
        
        // Validate thứ tự
        $thuTu = (int)($data['thu_tu'] ?? 0);
        if ($thuTu < 0) {
            $this->errors[] = 'Thứ tự không được âm!';
        }
        
        // Validate thời gian hiển thị
        $thoiGianHienThi = (int)($data['thoi_gian_hien_thi'] ?? 5000);
        if ($thoiGianHienThi < 1000) {
            $this->errors[] = 'Thời gian hiển thị tối thiểu là 1000ms (1 giây)!';
        }
        
        // Validate ngày
        $ngayBatDau = $data['ngay_bat_dau'] ?? '';
        $ngayKetThuc = $data['ngay_ket_thuc'] ?? '';
        
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
                'ten_banner' => $tenBanner,
                'mo_ta' => trim($data['mo_ta'] ?? ''),
                'link_url' => $linkUrl,
                'thu_tu' => $thuTu,
                'trang_thai' => (int)($data['trang_thai'] ?? 1),
                'loai_hien_thi' => $data['loai_hien_thi'] ?? 'popup',
                'thoi_gian_hien_thi' => $thoiGianHienThi,
                'hien_thi_lan_duy_nhat' => (int)($data['hien_thi_lan_duy_nhat'] ?? 1),
                'ngay_bat_dau' => !empty($ngayBatDau) ? $ngayBatDau : null,
                'ngay_ket_thuc' => !empty($ngayKetThuc) ? $ngayKetThuc : null
            ];
        }
        
        return [];
    }
    
    /**
     * Upload hình ảnh banner
     */
    private function uploadBannerImage($file) {
        if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'message' => 'Lỗi khi upload file!'];
        }
        
        // Kiểm tra loại file
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($file['type'], $allowedTypes)) {
            return ['success' => false, 'message' => 'Chỉ cho phép upload file hình ảnh (JPG, PNG, GIF, WEBP)!'];
        }
        
        // Kiểm tra kích thước file (max 5MB)
        $maxSize = 5 * 1024 * 1024; // 5MB
        if ($file['size'] > $maxSize) {
            return ['success' => false, 'message' => 'Kích thước file không được vượt quá 5MB!'];
        }
        
        // Tạo tên file unique
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = 'banner_' . time() . '_' . uniqid() . '.' . $extension;
        
        // Đường dẫn upload
        $uploadDir = 'uploads/banners/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $uploadPath = $uploadDir . $fileName;
        
        // Move file
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            return ['success' => true, 'file_path' => $uploadPath];
        }
        
        return ['success' => false, 'message' => 'Lỗi khi lưu file!'];
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
    
    // Getter methods cho views
    public function getErrors() {
        return $this->errors;
    }
    
    public function getSuccessMessage() {
        return $this->successMessage;
    }
}
?>
