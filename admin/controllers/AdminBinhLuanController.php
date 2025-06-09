<?php

// Ensure required model classes are loaded
if (!class_exists('AdminBinhLuan')) {
    require_once './models/AdminBinhLuan.php';
}
if (!class_exists('AdminSanPham')) {
    require_once './models/AdminSanPham.php';
}
if (!class_exists('AdminTaiKhoan')) {
    require_once './models/AdminTaiKhoan.php';
}

class AdminBinhLuanController
{
    public $modelBinhLuan;
    public $modelSanPham;
    public $modelTaiKhoan;

    public function __construct()
    {
        $this->modelBinhLuan = new AdminBinhLuan();
        $this->modelSanPham = new AdminSanPham();
        $this->modelTaiKhoan = new AdminTaiKhoan();
    }    // Hiển thị danh sách tất cả bình luận
    public function danhSachBinhLuan()
    {
        try {
            // Debug: Kiểm tra kết nối database
            if (!$this->modelBinhLuan || !$this->modelBinhLuan->conn) {
                throw new Exception("Không thể kết nối đến database");
            }
            
            // Phân trang
            $limit = 20;
            $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $offset = ($currentPage - 1) * $limit;
            
            // Lấy dữ liệu với phân trang - kiểm tra từng bước
            $listBinhLuan = $this->modelBinhLuan->getAllComments($limit, $offset);
            if ($listBinhLuan === false) {
                throw new Exception("Lỗi khi lấy danh sách bình luận");
            }
            
            $totalComments = $this->modelBinhLuan->countAllComments();
            if ($totalComments === false) {
                $totalComments = 0;
            }
            
            $totalPages = ceil($totalComments / $limit);
              // Thống kê - kiểm tra từng method
            try {
                $thongKeBinhLuan = $this->modelBinhLuan->getThongKeBinhLuan();
                if ($thongKeBinhLuan === false || $thongKeBinhLuan === null) {
                    $thongKeBinhLuan = [
                        'tong_binh_luan' => 0,
                        'cho_duyet' => 0,
                        'da_duyet' => 0,
                        'bi_tu_choi' => 0
                    ];
                }
            } catch (Exception $e) {
                $thongKeBinhLuan = [
                    'tong_binh_luan' => 0,
                    'cho_duyet' => 0,
                    'da_duyet' => 0,
                    'bi_tu_choi' => 0
                ];
                error_log("Lỗi getThongKeBinhLuan: " . $e->getMessage());
            }
            
            try {
                $stats = $this->modelBinhLuan->getCommentStats();
                if ($stats === false || $stats === null) {
                    $stats = [];
                }
            } catch (Exception $e) {
                $stats = [];
                error_log("Lỗi getCommentStats: " . $e->getMessage());
            }
            
            require_once './views/binhluans/listBinhLuan.php';
        } catch (Exception $e) {
            $_SESSION['error'] = "Có lỗi xảy ra khi tải danh sách bình luận: " . $e->getMessage();
            error_log("AdminBinhLuanController::danhSachBinhLuan - " . $e->getMessage());
            header("Location: " . BASE_URL_ADMIN);
            exit();
        }
    }

    // Hiển thị chi tiết bình luận
    public function chiTietBinhLuan()
    {
        $id = $_GET['id_binh_luan'];
        $binhLuan = $this->modelBinhLuan->getDetailBinhLuan($id);
          if ($binhLuan) {
            $sanPham = $this->modelSanPham->getDetailSanPham($binhLuan['san_pham_id']);
            $taiKhoan = $this->modelTaiKhoan->getDetailTaiKhoan($binhLuan['tai_khoan_id']);            require_once './views/binhluans/detailBinhLuan.php';
        } else {
            header("Location: " . BASE_URL_ADMIN . '?act=binh-luan');
            exit();
        }
    }

    // Cập nhật trạng thái bình luận (duyệt/ẩn)
    public function updateTrangThaiBinhLuan()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_binh_luan = $_POST['id_binh_luan'];
            $trang_thai_moi = $_POST['trang_thai_moi'];
            $ly_do = $_POST['ly_do'] ?? '';
            
            $result = $this->modelBinhLuan->updateTrangThaiBinhLuan($id_binh_luan, $trang_thai_moi, $ly_do);
            
            if ($result) {
                $_SESSION['success'] = "Cập nhật trạng thái bình luận thành công!";
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra khi cập nhật trạng thái bình luận!";
            }
            
            header("Location: " . BASE_URL_ADMIN . '?act=binh-luan');
            exit();
        }
    }

    // Duyệt hàng loạt bình luận
    public function duyetHangLoatBinhLuan()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['selected_comments'])) {
            $selectedComments = $_POST['selected_comments'];
            $action = $_POST['bulk_action'];
            
            $successCount = 0;
            $errorCount = 0;
            
            foreach ($selectedComments as $commentId) {
                $trangThai = ($action === 'approve') ? 1 : 2; // 1: duyệt, 2: ẩn
                $result = $this->modelBinhLuan->updateTrangThaiBinhLuan($commentId, $trangThai);
                
                if ($result) {
                    $successCount++;
                } else {
                    $errorCount++;
                }
            }
            
            if ($successCount > 0) {
                $_SESSION['success'] = "Đã cập nhật thành công $successCount bình luận!";
            }
            if ($errorCount > 0) {
                $_SESSION['error'] = "Có $errorCount bình luận không thể cập nhật!";
            }
        }
        
        header("Location: " . BASE_URL_ADMIN . '?act=list-binh-luan');
        exit();
    }

    // Xóa bình luận
    public function xoaBinhLuan()
    {
        $id = $_GET['id_binh_luan'];
        $binhLuan = $this->modelBinhLuan->getDetailBinhLuan($id);
        
        if ($binhLuan) {
            $result = $this->modelBinhLuan->deleteBinhLuan($id);
            
            if ($result) {
                $_SESSION['success'] = "Xóa bình luận thành công!";
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra khi xóa bình luận!";
            }
        } else {
            $_SESSION['error'] = "Bình luận không tồn tại!";
        }
        
        header("Location: " . BASE_URL_ADMIN . '?act=list-binh-luan');
        exit();
    }    // Lọc bình luận theo trạng thái
    public function filterBinhLuan()
    {
        try {
            $trangThai = $_GET['trang_thai'] ?? 'all';
            $sanPhamId = $_GET['san_pham_id'] ?? '';
            $tuNgay = $_GET['tu_ngay'] ?? '';
            $denNgay = $_GET['den_ngay'] ?? '';
            
            // Phân trang
            $limit = 20;
            $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $offset = ($currentPage - 1) * $limit;
            
            // Lấy dữ liệu với phân trang
            $listBinhLuan = $this->modelBinhLuan->filterBinhLuan($trangThai, $sanPhamId, $tuNgay, $denNgay, $limit, $offset);
            $totalComments = $this->modelBinhLuan->countFilteredBinhLuan($trangThai, $sanPhamId, $tuNgay, $denNgay);
            $totalPages = ceil($totalComments / $limit);
              // Thống kê và dữ liệu khác
            try {
                $thongKeBinhLuan = $this->modelBinhLuan->getThongKeBinhLuan();
                if ($thongKeBinhLuan === false || $thongKeBinhLuan === null) {
                    $thongKeBinhLuan = [
                        'tong_binh_luan' => 0,
                        'cho_duyet' => 0,
                        'da_duyet' => 0,
                        'bi_tu_choi' => 0
                    ];
                }
            } catch (Exception $e) {
                $thongKeBinhLuan = [
                    'tong_binh_luan' => 0,
                    'cho_duyet' => 0,
                    'da_duyet' => 0,
                    'bi_tu_choi' => 0
                ];
            }
            
            try {
                $stats = $this->modelBinhLuan->getCommentStats();
                if ($stats === false || $stats === null) {
                    $stats = [];
                }
            } catch (Exception $e) {
                $stats = [];
            }
            
            try {
                $listSanPham = $this->modelSanPham->getAllSanPham();
                if ($listSanPham === false || $listSanPham === null) {
                    $listSanPham = [];
                }
            } catch (Exception $e) {
                $listSanPham = [];
            }
            
            require_once './views/binhluans/listBinhLuan.php';
        } catch (Exception $e) {
            $_SESSION['error'] = "Có lỗi xảy ra khi lọc bình luận: " . $e->getMessage();
            header("Location: " . BASE_URL_ADMIN . '?act=binh-luan');
            exit();
        }
    }

    // Trả lời bình luận
    public function traLoiBinhLuan()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_binh_luan = $_POST['id_binh_luan'];
            $noi_dung_tra_loi = $_POST['noi_dung_tra_loi'];
            $admin_id = $_SESSION['user_admin']['id'];
            
            $result = $this->modelBinhLuan->themTraLoiBinhLuan($id_binh_luan, $noi_dung_tra_loi, $admin_id);
            
            if ($result) {
                $_SESSION['success'] = "Trả lời bình luận thành công!";
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra khi trả lời bình luận!";
            }
            
            header("Location: " . BASE_URL_ADMIN . '?act=chi-tiet-binh-luan&id_binh_luan=' . $id_binh_luan);
            exit();
        }
    }    // Báo cáo thống kê bình luận
    public function baoCaoBinhLuan()
    {
        $thongKeTheoThang = $this->modelBinhLuan->getThongKeBinhLuanTheoThang();
        $thongKeTheoSanPham = $this->modelBinhLuan->getThongKeBinhLuanTheoSanPham();
        $topKhachHangBinhLuan = $this->modelBinhLuan->getTopKhachHangBinhLuan();        $thongKeTongQuan = $this->modelBinhLuan->getThongKeBinhLuan();
        
        require_once './views/binhluans/baoCaoBinhLuan.php';
    }

    // Lấy số lượng bình luận chờ duyệt cho notification badge
    public function getPendingCommentsCount()
    {
        header('Content-Type: application/json');
        
        try {
            $count = $this->modelBinhLuan->countBinhLuanByStatus('pending');
            echo json_encode([
                'success' => true,
                'count' => $count
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Lỗi khi lấy số lượng bình luận chờ duyệt'
            ]);
        }
        exit();
    }
}
