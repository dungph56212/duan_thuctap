<?php
require_once './commons/Security.php';
require_once './controllers/BannerController.php';

class HomeController
{    public $modelSanPham;
    public $modelTaiKhoan;
    public $modelGioHang;
    public $modelDonHang;
    public $commentModel;
    public $modelDiaChi;    public $modelDanhMuc;
    public $modelKhuyenMai;
    public $bannerController;
    public function __construct()
    {
        $this->modelSanPham = new SanPham();
        $this->modelTaiKhoan = new TaiKhoan();
        $this->modelGioHang = new GioHang();
        $this->modelDonHang = new DonHang();
        $this->commentModel = new commentModel();
        $this->modelDiaChi = new DiaChi();
        $this->modelDanhMuc = new DanhMuc();
        $this->modelKhuyenMai = new KhuyenMai();
        $this->bannerController = new BannerController();
    }    public function home()
    {
        // echo "Dự án 1 team 9";
        // $listSanPham = $this->modelSanPham->getAllSanPham();
        $listSanPham = $this->modelSanPham->getAllProduct();
        $listDanhMuc = $this->modelDanhMuc->getAllDanhMuc();
        
        // Lấy danh sách banner đang hoạt động
        $bannerResult = $this->bannerController->getActiveBanners();
        $listBanners = [];
        if ($bannerResult['success']) {
            $listBanners = $bannerResult['banners'];
        }
        
        // var_dump($listSanPham);die;
        require_once './views/home.php';
    }

    public function sanPhamTheoDanhMuc()
    {
        $danh_muc_id = $_GET['danh_muc_id'] ?? null;
        if ($danh_muc_id) {
            $listSanPham = $this->modelSanPham->getListSanPhamDanhMuc($danh_muc_id);
            $danhMuc = $this->modelDanhMuc->getDetailDanhMuc($danh_muc_id);
            $listDanhMuc = $this->modelDanhMuc->getAllDanhMuc();
        } else {
            $listSanPham = $this->modelSanPham->getAllProduct();
            $danhMuc = null;
            $listDanhMuc = $this->modelDanhMuc->getAllDanhMuc();
        }
        require_once './views/sanPhamTheoDanhMuc.php';
    }
    public function chiTietSanPham()
    {
        $id = $_GET['id_san_pham'];
        $sanPham = $this->modelSanPham->getDetailSanPham($id);
        
        if (!$sanPham) {
            header("Location: " . BASE_URL);
            exit();
        }

        $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);
        
        // Use enhanced comment model to get approved comments with admin replies
        $listBinhLuan = $this->commentModel->get_approved_comments_by_product($id);
        
        $listSanPhamCungDanhMuc = $this->modelSanPham->getListSanPhamDanhMuc($sanPham['danh_muc_id']);
        
        // Generate CSRF token for forms
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        require_once './views/detailSanPham.php';
    }public function formLogin()
    {
        Security::generateCSRFToken();
        require_once './views/auth/formLogin.php';
        deleteSessionError();
        exit();
    }    public function postLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // CSRF Token validation
            if (!isset($_POST['csrf_token']) || !Security::validateCSRFToken($_POST['csrf_token'])) {
                $_SESSION['error'] = "Token bảo mật không hợp lệ. Vui lòng thử lại.";
                $_SESSION['flash'] = true;
                header("Location: " . BASE_URL . '?act=login');
                exit();
            }
            
            // Validate input
            $email = Security::sanitizeInput(trim($_POST['email'] ?? ''));
            $password = $_POST['password'] ?? '';
            
            // Basic validation
            if (empty($email) || empty($password)) {
                $_SESSION['error'] = "Vui lòng nhập đầy đủ email và mật khẩu";
                $_SESSION['flash'] = true;
                header("Location: " . BASE_URL . '?act=login');
                exit();
            }
            
            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Email không hợp lệ";
                $_SESSION['flash'] = true;
                header("Location: " . BASE_URL . '?act=login');
                exit();
            }
            
            // Check rate limiting
            if (Security::isRateLimited($email)) {
                $remainingTime = Security::getRemainingLockoutTime($email);
                $minutes = ceil($remainingTime / 60);
                $_SESSION['error'] = "Bạn đã thử đăng nhập quá nhiều lần. Vui lòng thử lại sau {$minutes} phút.";
                $_SESSION['flash'] = true;
                header("Location: " . BASE_URL . '?act=login');
                exit();
            }
            
            $result = $this->modelTaiKhoan->checkLogin($email, $password);
            
            if ($result == $email) {
                // Login successful - clear failed attempts and set success message
                Security::clearLoginAttempts($email);
                $_SESSION['success'] = "Đăng nhập thành công! Chào mừng bạn trở lại.";
                $_SESSION['flash'] = true;
                header("Location: " . BASE_URL);
                exit();
            } else {
                // Login failed - record attempt and display error
                Security::recordLoginAttempt($email);
                $_SESSION['error'] = $result;
                $_SESSION['flash'] = true;
                header("Location: " . BASE_URL . '?act=login');
                exit();
            }
        }
    }
    
    
    public function addGioHang()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // var_dump($_SESSION['user_client']['email']);die;
            if (isset($_SESSION['user_client']['id'])) {
                // var_dump($_SESSION['user_client']['email']);die;
                $mail = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']['email']);
                // lấy dữ liệu giỏ hàng của người dung
                // var_dump($mail);die;
                $gioHang = $this->modelGioHang->getGioHangFromUser($mail['id']);
                // var_dump($gioHang);die;
                if (!$gioHang) {
                    $gioHangId = $this->modelGioHang->addGioHang($mail['id']);
                    $gioHang = ['id' => $gioHangId];
                    $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
                } else {

                    $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
                }                $san_pham_id = $_POST['san_pham_id'];
                $so_luong = $_POST['so_luong'];

                // Check current inventory
                $currentInventory = $this->modelSanPham->getCurrentInventory($san_pham_id);
                
                $checkSanPham = false;
                $currentCartQuantity = 0;
                
                // Check if product already exists in cart
                foreach ($chiTietGioHang as $detail) {
                    if ($detail['san_pham_id'] == $san_pham_id) {
                        $currentCartQuantity = $detail['so_luong'];
                        $newSoLuong = $detail['so_luong'] + $so_luong;
                        
                        // Check if new total quantity exceeds inventory
                        if($newSoLuong > $currentInventory) {
                            $availableToAdd = $currentInventory - $currentCartQuantity;
                            $sanPham = $this->modelSanPham->getDetailSanPham($san_pham_id);
                            echo "<script>
                                alert('Không đủ hàng trong kho!\\nSản phẩm: {$sanPham['ten_san_pham']}\\nSố lượng tồn kho: {$currentInventory}\\nSố lượng trong giỏ: {$currentCartQuantity}\\nCó thể thêm tối đa: {$availableToAdd}');
                                window.history.back();
                            </script>";
                            exit;
                        }
                        
                        $this->modelGioHang->updateSoLuong($gioHang['id'], $san_pham_id, $newSoLuong);
                        $checkSanPham = true;
                        break;
                    }
                }
                
                if (!$checkSanPham) {
                    // Check if requested quantity exceeds inventory for new items
                    if($so_luong > $currentInventory) {
                        $sanPham = $this->modelSanPham->getDetailSanPham($san_pham_id);
                        echo "<script>
                            alert('Không đủ hàng trong kho!\\nSản phẩm: {$sanPham['ten_san_pham']}\\nSố lượng yêu cầu: {$so_luong}\\nSố lượng tồn kho: {$currentInventory}');
                            window.history.back();
                        </script>";
                        exit;
                    }
                    $this->modelGioHang->addDetailGioHang($gioHang['id'], $san_pham_id, $so_luong);
                }
                header("Location:" . BASE_URL . '?act=gio-hang');
                // var_dump('Thêm giỏ hàng thành công');die;
            } else {
                header("Location:" . BASE_URL . '?act=login');
            }
        }
    }
    public function gioHang()
    {
        // if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // var_dump(1230);die;
            if (isset($_SESSION['user_client']['id'])) {
                $mail = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']['email']);
                // lấy dữ liệu giỏ hàng của người dung
                $gioHang = $this->modelGioHang->getGioHangFromUser($mail['id']);
                if (!$gioHang) {
                    $gioHangId = $this->modelGioHang->addGioHang($mail['id']);
                    $gioHang = ['id' => $gioHangId];
                    $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
                } else {

                    $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
                }
                require_once './views/gioHang.php';
            } else {
               header("Location: ".BASE_URL . '?act=login');
            }
        // }
    }
    public function thanhToan(){
        if (isset($_SESSION['user_client']['id'])) {
            $user = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']['email']);
            // lấy dữ liệu giỏ hàng của người dung
            $gioHang = $this->modelGioHang->getGioHangFromUser($user['id']);
            if (!$gioHang) {
                $gioHangId = $this->modelGioHang->addGioHang($user['id']);
                $gioHang = ['id' => $gioHangId];
                $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
            } else {

                $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
            }
            // require_once './views/gioHang.php';
        } else {
            var_dump('Chưa đăng nhập');
            die;
        }
        
        require_once './views/thanhToan.php';
    }    public function postThanhToan(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // var_dump($_POST);die;
            $ten_nguoi_nhan= $_POST['ten_nguoi_nhan'];
            $email_nguoi_nhan= $_POST['email_nguoi_nhan'];
            $sdt_nguoi_nhan= $_POST['sdt_nguoi_nhan'];
            $dia_chi_nguoi_nhan= $_POST['dia_chi_nguoi_nhan'];
            $ghi_chu= $_POST['ghi_chu'];
            $tong_tien= $_POST['tong_tien'];
            $phuong_thuc_thanh_toan_id = $_POST['phuong_thuc_thanh_toan_id'];
            $ma_khuyen_mai_id = $_POST['ma_khuyen_mai_id'] ?? null;

            $ngay_dat = date('Y-m-d');
            // var_dump($ngay_dat);die;
            $trang_thai_id = 1;
            $user = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']['email']);
            $tai_khoan_id = $_SESSION['user_client']['id'];

            $ma_don_hang = 'DH' . rand(1000,9999);

            $donHang =$this->modelDonHang->addDonHang($tai_khoan_id, $ten_nguoi_nhan, $email_nguoi_nhan , $sdt_nguoi_nhan , $dia_chi_nguoi_nhan, $ghi_chu, $tong_tien, $phuong_thuc_thanh_toan_id, $ngay_dat , $ma_don_hang , $trang_thai_id);
            // var_dump('Thêm thành công');die;

            $gioHang = $this->modelGioHang->getGioHangFromUser($tai_khoan_id);            if($donHang){
                $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
                
                // Check inventory availability before processing order
                $inventoryCheck = true;
                $insufficientItems = [];
                
                foreach($chiTietGioHang as $item){
                    if(!$this->modelSanPham->checkInventory($item['san_pham_id'], $item['so_luong'])){
                        $inventoryCheck = false;
                        $currentStock = $this->modelSanPham->getCurrentInventory($item['san_pham_id']);
                        $insufficientItems[] = [
                            'name' => $item['ten_san_pham'],
                            'requested' => $item['so_luong'],
                            'available' => $currentStock
                        ];
                    }
                }
                
                if(!$inventoryCheck){
                    // Remove the order that was just created since inventory is insufficient
                    $this->modelDonHang->updateTrangThaiDonHang($donHang, 12); // Set to cancelled status
                    
                    // Display inventory error message
                    $errorMessage = "Không đủ hàng trong kho. Chi tiết:\n";
                    foreach($insufficientItems as $item){
                        $errorMessage .= "- {$item['name']}: Yêu cầu {$item['requested']}, còn lại {$item['available']}\n";
                    }
                    echo "<script>alert('" . addslashes($errorMessage) . "'); window.location.href='" . BASE_URL . "?act=gio-hang';</script>";
                    exit;
                }
                
                // Process order and decrement inventory
                foreach($chiTietGioHang as $item){
                    $donGia= $item['gia_khuyen_mai'] ?? $item['gia_san_pham'];
                    
                    // Add order detail
                    $this->modelDonHang->addChiTietDonHang(
                        $donHang,
                        $item['san_pham_id'],
                        $item['so_luong'], 
                        $donGia,
                        $donGia * $item['so_luong']
                    );
                      // Decrement inventory
                    $this->modelSanPham->decrementInventory($item['san_pham_id'], $item['so_luong']);
                }
                
                // Record promotion usage if discount was applied
                if ($ma_khuyen_mai_id && isset($_SESSION['ma_giam_gia'])) {
                    $this->modelKhuyenMai->updateUsageCount($ma_khuyen_mai_id);
                }
                
                // Clear cart and discount session
                $this->modelGioHang->clearDetailGioHang($gioHang['id']);
                $this->modelGioHang->clearGioHang($tai_khoan_id);
                
                // Clear discount session
                if (isset($_SESSION['ma_giam_gia'])) {
                    unset($_SESSION['ma_giam_gia']);
                }
                if (isset($_SESSION['discount_amount'])) {
                    unset($_SESSION['discount_amount']);
                }
                
                header("Location: ".BASE_URL . '?act=lich-su-mua-hang');
                exit;
            }else{
                var_dump('Lỗi đặt hàng');
                die;
            }
        }
    }

    public function lichSuMuaHang(){
        if(isset($_SESSION['user_client']['id'])){
            // lấy ra thông tin tài khoản đăng nhập
            $user = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']['email']);
            $tai_khoan_id = $_SESSION['user_client']['id'];
            // lấy ra danh sách trạng thái đơn hàng
            $arrTrangThaiDonHang = $this->modelDonHang->getTrangThaiDonHang();
            $trangThaiDonHang= array_column($arrTrangThaiDonHang, 'ten_trang_thai', 'id');
            // echo "<pre>" ;print_r($trangThaiDonHang);die;
            // lấy ra danh sách phương thức thanh toán
            $arrPhuongThucThanhToan = $this->modelDonHang->getPhuongThucThanhToan();
            $phuongThucThanhToan= array_column($arrPhuongThucThanhToan, 'ten_phuong_thuc', 'id');
            // echo "<pre>" ;print_r($phuongThucThanhToan);die;
            // lấy ra danh sách tất cả đơn hàng của tài khoản
            $donHangs = $this->modelDonHang->getDonHangFromUser($tai_khoan_id);
            // echo  "<pre>";
            // print_r($donHang);
            // die;
            require_once './views/lichSuMuaHang.php';
        }else{
            var_dump('Chưa đăng nhập');
            die;
        }
    }

    public function chiTietMuaHang(){
        if(isset($_SESSION['user_client']['id'])){
            // lấy ra thông tin tài khoản đăng nhập
            $user = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']['email']);
            $tai_khoan_id = $_SESSION['user_client']['id'];

            // lấy id đơn truyền từ url
            $donHangId = $_GET['id'];

            // lấy ra danh sách trạng thái đơn hàng
            $arrTrangThaiDonHang = $this->modelDonHang->getTrangThaiDonHang();
            $trangThaiDonHang= array_column($arrTrangThaiDonHang, 'ten_trang_thai', 'id');
            
            // lấy ra danh sách phương thức thanh toán
            $arrPhuongThucThanhToan = $this->modelDonHang->getPhuongThucThanhToan();
            $phuongThucThanhToan= array_column($arrPhuongThucThanhToan, 'ten_phuong_thuc', 'id');

            // lấy ra thông tin đơn hàng theo id
            $donHang = $this->modelDonHang->getDonHangById($donHangId);

            // lấy thông tin sản phẩm đơn hàng trong bảng chi tiết đơn hàng
            $chiTietDonHang = $this->modelDonHang->getChiTietDonHangByDonHangId($donHangId);

            // echo  "<pre>";
            // print_r($donHang);
            // print_r($chiTietDonHang);

            if($donHang['tai_khoan_id'] != $tai_khoan_id){
                echo "Không có quyền xem đơn hàng này";
                exit;
            }
            
            require_once "./views/chiTietMuaHang.php";

        }else{
            var_dump('Chưa đăng nhập');
            die;
        }
    }

    public function huyDonHang(){
        if(isset($_SESSION['user_client']['id'])){
            // lấy ra thông tin tài khoản đăng nhập
            $user = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']['email']);
            $tai_khoan_id = $_SESSION['user_client']['id'];

            // lấy id đơn truyền từ url
            $donHangId = $_GET['id'];

            // kiểm tra đơn hàng
            $donHang = $this->modelDonHang->getDonHangById($donHangId);

            if($donHang['tai_khoan_id'] != $tai_khoan_id){
                echo "Không có quyền hủy đơn hàng";
                exit;
            }            if($donHang['trang_thai_id'] != 1){
                echo "Chỉ đơn hàng ở trạng thái chưa xác nhận mới có thể hủy đơn hàng";
                exit;
            }
            
            // Get order details to restore inventory
            $chiTietDonHang = $this->modelDonHang->getChiTietDonHangByDonHangId($donHangId);
            
            // Restore inventory for each product
            foreach($chiTietDonHang as $item){
                $this->modelSanPham->incrementInventory($item['san_pham_id'], $item['so_luong']);
            }
            
            // hủy đơn hàng
            $this->modelDonHang->updateTrangThaiDonHang($donHangId, 11);
            header("Location: ".BASE_URL . '?act=lich-su-mua-hang');
            exit;
        }else{
            var_dump('Chưa đăng nhập');
            die;
        }
    }    public function registers()
    {
        // If GET request, show the registration form
        if ($_SERVER['REQUEST_METHOD'] == 'GET' || empty($_POST['email'])) {
            Security::generateCSRFToken();
            require_once './views/auth/register.php';
            deleteSessionError();
            exit();
        }
        
        // Handle POST request - registration process
        // CSRF Token validation
        if (!isset($_POST['csrf_token']) || !Security::validateCSRFToken($_POST['csrf_token'])) {
            $_SESSION['error'] = "Token bảo mật không hợp lệ. Vui lòng thử lại.";
            $_SESSION['flash'] = true;
            require_once './views/auth/register.php';
            exit();
        }
        
        $errors = [];
        
        // Get and sanitize input data
        $ho_ten = Security::sanitizeInput(trim($_POST['ho_ten'] ?? ''));
        $email = Security::sanitizeInput(trim($_POST['email'] ?? ''));
        $mat_khau = $_POST['mat_khau'] ?? '';
        $xac_nhan_mat_khau = $_POST['xac_nhan_mat_khau'] ?? '';
        
        // Validate required fields
        if (empty($ho_ten)) {
            $errors['ho_ten'] = "Họ tên không được để trống";
        } elseif (strlen($ho_ten) < 2) {
            $errors['ho_ten'] = "Họ tên phải có ít nhất 2 ký tự";
        } elseif (strlen($ho_ten) > 100) {
            $errors['ho_ten'] = "Họ tên không được quá 100 ký tự";
        }
        
        if (empty($email)) {
            $errors['email'] = "Email không được để trống";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Email không hợp lệ";
        } elseif (strlen($email) > 255) {
            $errors['email'] = "Email không được quá 255 ký tự";
        }
        
        if (empty($mat_khau)) {
            $errors['mat_khau'] = "Mật khẩu không được để trống";
        } else {
            // Validate password strength using Security class
            $passwordErrors = Security::validatePasswordStrength($mat_khau);
            if (!empty($passwordErrors)) {
                $errors['mat_khau'] = implode('. ', $passwordErrors);
            }
        }
        
        if (empty($xac_nhan_mat_khau)) {
            $errors['xac_nhan_mat_khau'] = "Vui lòng xác nhận mật khẩu";
        } elseif ($mat_khau != $xac_nhan_mat_khau) {
            $errors['xac_nhan_mat_khau'] = "Nhập lại mật khẩu không trùng khớp";
        }
        
        // Check if email already exists
        if (empty($errors['email']) && $this->modelTaiKhoan->checkEmailExist($email)) {
            $errors['email'] = "Email đã tồn tại";
        }
        
        // If there are validation errors, show the form with errors
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_data'] = [
                'ho_ten' => $ho_ten,
                'email' => $email
            ];
            require_once './views/auth/register.php';
            exit();
        }
        
        // Hash password using Argon2ID for better security
        $hashedPassword = Security::hashPassword($mat_khau);
        
        // Attempt to register the user
        if ($this->modelTaiKhoan->register($ho_ten, $email, $hashedPassword)) {
            $_SESSION['success'] = "Đăng ký thành công! Vui lòng đăng nhập để tiếp tục.";
            $_SESSION['flash'] = true;
            header("Location: " . BASE_URL . '?act=login');
            exit();
        } else {
            $_SESSION['error'] = "Có lỗi xảy ra trong quá trình đăng ký. Vui lòng thử lại.";
            $_SESSION['flash'] = true;
            header("Location: " . BASE_URL . '?act=register');
            exit();
        }
    }



    // public function comfirm_registers()
    // {
        
    //     $ma_xac_thuc = isset($_POST['ma_xac_thuc']) ? $_POST['ma_xac_thuc'] : null;
    //     if ($this->modelTaiKhoan->comfirm_register($ma_xac_thuc)) {
    //         header('location: ' . BASE_URL);
    //         exit();
    //         // Bạn có thể chuyển hướng hoặc cập nhật trạng thái tài khoản tại đây
    //     } else {
    //         $errors = [];
    //         $errors['ma_xac_thuc'] = 'Nhập Sai Mã Xác Thực!!';
    //         $_SESSION['errors'] = $errors;
    //         require_once './views/auth/comfirm_register.php';
    //         exit();
    //     }
    // }
    public function logins()
    {
        // var_dump(123);die;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $mat_khau = $_POST['mat_khau'];
            // var_dump($_POST);die;
            $accounts = $this->modelTaiKhoan->login($email, md5($mat_khau));
            // var_dump($accounts);die;
            foreach ($accounts as $account) {
                if ($email === $account['email'] && ($mat_khau) === $account['mat_khau']) {
                    $_SESSION['user'] = [
                        'id' => $account['id'],
                        'ho_ten' => $account['ho_ten'],
                        'email' => $account['email'],
                        'chuc_vu_id' => $account['chuc_vu_id'],
                        'trang_thai' => $account['trang_thai'],
                    ];
                    if ($_SESSION['user']['chuc_vu_id'] == 3 && $_SESSION['user']['trang_thai'] == 1) {
                        header('location: ' . BASE_URL );
                        exit();
                    } else if ($_SESSION['user']['chuc_vu_id'] == 1 && $_SESSION['user']['trang_thai'] == 1) {
                        header('location: ' . BASE_URL_ADMIN);
                        exit();
                    }
                }
            }
        }
    }
    public function add_comment() {
        if (!isset($_SESSION['user_client'])) {
            header('location: ' . BASE_URL . '?act=login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('location: ' . BASE_URL);
            exit();
        }

        $san_pham_id = $_GET['id_san_pham'] ?? null;
        $tai_khoan_id = $_SESSION['user_client']['id'];
        $noi_dung = $_POST['noi_dung'] ?? '';
        $csrf_token = $_POST['csrf_token'] ?? '';

        // CSRF Protection
        if (!isset($_SESSION['csrf_token']) || $csrf_token !== $_SESSION['csrf_token']) {
            $_SESSION['error'] = "Token bảo mật không hợp lệ. Vui lòng thử lại.";
            header('location: ' . BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $san_pham_id);
            exit();
        }

        // Validate input
        $errors = $this->commentModel->validate_comment($noi_dung);
        
        if (!$san_pham_id) {
            $errors[] = "Sản phẩm không tồn tại";
        }

        // Check if user can comment (rate limiting)
        if (!$this->commentModel->can_user_comment($tai_khoan_id, $san_pham_id)) {
            $errors[] = "Bạn đã bình luận quá nhiều lần cho sản phẩm này. Vui lòng thử lại sau.";
        }

        if (!empty($errors)) {
            $_SESSION['comment_errors'] = $errors;
            $_SESSION['comment_data'] = ['noi_dung' => $noi_dung];
            header('location: ' . BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $san_pham_id);
            exit();
        }

        $result = $this->commentModel->add_comment($san_pham_id, $tai_khoan_id, $noi_dung);
        
        if ($result) {
            $_SESSION['success'] = "Bình luận của bạn đã được gửi và đang chờ duyệt.";
        } else {
            $_SESSION['error'] = "Có lỗi xảy ra khi gửi bình luận. Vui lòng thử lại.";
        }

        // Regenerate CSRF token
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        
        header('location: ' . BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $san_pham_id);
        exit();
    }

    public function edit_comment() {
        if (!isset($_SESSION['user_client'])) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập']);
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ']);
            exit();
        }

        $comment_id = $_POST['comment_id'] ?? null;
        $noi_dung = $_POST['noi_dung'] ?? '';
        $tai_khoan_id = $_SESSION['user_client']['id'];
        $csrf_token = $_POST['csrf_token'] ?? '';

        // CSRF Protection
        if (!isset($_SESSION['csrf_token']) || $csrf_token !== $_SESSION['csrf_token']) {
            echo json_encode(['success' => false, 'message' => 'Token bảo mật không hợp lệ']);
            exit();
        }

        // Validate input
        $errors = $this->commentModel->validate_comment($noi_dung);
        
        if (!$comment_id) {
            $errors[] = "Bình luận không tồn tại";
        }

        if (!empty($errors)) {
            echo json_encode(['success' => false, 'message' => implode(', ', $errors)]);
            exit();
        }

        $result = $this->commentModel->update_comment($comment_id, $noi_dung, $tai_khoan_id);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Cập nhật bình luận thành công']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Không thể cập nhật bình luận']);
        }
        exit();
    }

    public function delete_comment() {
        if (!isset($_SESSION['user_client'])) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập']);
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ']);
            exit();
        }

        $comment_id = $_POST['comment_id'] ?? null;
        $tai_khoan_id = $_SESSION['user_client']['id'];
        $csrf_token = $_POST['csrf_token'] ?? '';

        // CSRF Protection
        if (!isset($_SESSION['csrf_token']) || $csrf_token !== $_SESSION['csrf_token']) {
            echo json_encode(['success' => false, 'message' => 'Token bảo mật không hợp lệ']);
            exit();
        }

        if (!$comment_id) {
            echo json_encode(['success' => false, 'message' => 'Bình luận không tồn tại']);
            exit();
        }

        $result = $this->commentModel->delete_comment($comment_id, $tai_khoan_id);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Xóa bình luận thành công']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Không thể xóa bình luận']);
        }
        exit();
    }

    public function logout()
    {
        if (isset($_SESSION['user_client'])){
            unset($_SESSION['user_client']);
            session_destroy();
            header("location: " . BASE_URL );
            exit();
        }
        
    }

    public function thongTinNguoiDung(){
        if(isset($_SESSION['user_client']['id'])){
            // Lấy thông tin tài khoản đăng nhập
            $user = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']['email']);
            $tai_khoan_id = $_SESSION['user_client']['id'];
            
            // Lấy thống kê đơn hàng
            $tongDonHang = $this->modelDonHang->countDonHangByUser($tai_khoan_id);
            $donHangHoanThanh = $this->modelDonHang->countDonHangByUserAndStatus($tai_khoan_id, 10);
            $donHangDangXuLy = $this->modelDonHang->countDonHangByUserAndStatus($tai_khoan_id, [1,2,3,4,5,6,7,8,9]);
            
            // Lấy danh sách đơn hàng gần đây
            $listDonHang = $this->modelDonHang->getDonHangFromUser($tai_khoan_id, 10);
            
            // Lấy trạng thái đơn hàng
            $arrTrangThaiDonHang = $this->modelDonHang->getTrangThaiDonHang();
            $trangThaiDonHang = array_column($arrTrangThaiDonHang, 'ten_trang_thai', 'id');
            
            require_once './views/thongTinNguoiDung.php';
        } else {
            header("Location: " . BASE_URL . '?act=login');
            exit();
        }
    }

    public function capNhatThongTin(){
        if(isset($_SESSION['user_client']['id']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
            $tai_khoan_id = $_SESSION['user_client']['id'];
            $ho_ten = $_POST['ho_ten'] ?? '';
            $email = $_POST['email'] ?? '';
            $so_dien_thoai = $_POST['so_dien_thoai'] ?? '';
            $ngay_sinh = $_POST['ngay_sinh'] ?? '';
            $dia_chi = $_POST['dia_chi'] ?? '';

            $errors = [];
            
            // Validate dữ liệu
            if(empty($ho_ten)){
                $errors['ho_ten'] = 'Họ tên không được để trống';
            }
            if(empty($email)){
                $errors['email'] = 'Email không được để trống';
            }
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errors['email'] = 'Email không hợp lệ';
            }

            // Kiểm tra email đã tồn tại (trừ email hiện tại)
            $currentUser = $this->modelTaiKhoan->getTaiKhoanById($tai_khoan_id);
            if($email != $currentUser['email'] && $this->modelTaiKhoan->checkEmailExist($email)){
                $errors['email'] = 'Email đã được sử dụng';
            }

            if(empty($errors)){
                $result = $this->modelTaiKhoan->updateThongTinTaiKhoan($tai_khoan_id, $ho_ten, $email, $so_dien_thoai, $ngay_sinh, $dia_chi);
                if($result){
                    // Cập nhật session
                    $_SESSION['user_client']['ho_ten'] = $ho_ten;
                    $_SESSION['user_client']['email'] = $email;
                    $_SESSION['user_client']['so_dien_thoai'] = $so_dien_thoai;
                    $_SESSION['user_client']['ngay_sinh'] = $ngay_sinh;
                    $_SESSION['user_client']['dia_chi'] = $dia_chi;
                    
                    $_SESSION['success'] = 'Cập nhật thông tin thành công!';
                } else {
                    $_SESSION['error'] = 'Có lỗi xảy ra khi cập nhật thông tin!';
                }
            } else {
                $_SESSION['errors'] = $errors;
            }

            header("Location: " . BASE_URL . '?act=thong-tin-nguoi-dung');
            exit();
        } else {
            header("Location: " . BASE_URL . '?act=login');
            exit();
        }
    }

    public function doiMatKhau(){
        if(isset($_SESSION['user_client']['id']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
            $tai_khoan_id = $_SESSION['user_client']['id'];
            $mat_khau_cu = $_POST['mat_khau_cu'] ?? '';
            $mat_khau_moi = $_POST['mat_khau_moi'] ?? '';
            $xac_nhan_mat_khau = $_POST['xac_nhan_mat_khau'] ?? '';

            $errors = [];
            
            // Validate dữ liệu
            if(empty($mat_khau_cu)){
                $errors['mat_khau_cu'] = 'Mật khẩu hiện tại không được để trống';
            }
            if(empty($mat_khau_moi)){
                $errors['mat_khau_moi'] = 'Mật khẩu mới không được để trống';
            }
            if(strlen($mat_khau_moi) < 6){
                $errors['mat_khau_moi'] = 'Mật khẩu mới phải có ít nhất 6 ký tự';
            }
            if($mat_khau_moi != $xac_nhan_mat_khau){
                $errors['xac_nhan_mat_khau'] = 'Xác nhận mật khẩu không khớp';
            }

            // Kiểm tra mật khẩu cũ
            $currentUser = $this->modelTaiKhoan->getTaiKhoanById($tai_khoan_id);
            if(!password_verify($mat_khau_cu, $currentUser['mat_khau'])){
                $errors['mat_khau_cu'] = 'Mật khẩu hiện tại không đúng';
            }

            if(empty($errors)){
                $hashPassword = password_hash($mat_khau_moi, PASSWORD_DEFAULT);
                $result = $this->modelTaiKhoan->updateMatKhau($tai_khoan_id, $hashPassword);
                if($result){
                    $_SESSION['success'] = 'Đổi mật khẩu thành công!';
                } else {
                    $_SESSION['error'] = 'Có lỗi xảy ra khi đổi mật khẩu!';
                }
            } else {
                $_SESSION['errors'] = $errors;
            }

            header("Location: " . BASE_URL . '?act=thong-tin-nguoi-dung');
            exit();
        } else {
            header("Location: " . BASE_URL . '?act=login');
            exit();
        }
    }

    // Quản lý địa chỉ
    public function quanLyDiaChi()
    {
        if (isset($_SESSION['user_client'])) {
            $userId = $_SESSION['user_client']['id'];
            $listDiaChi = $this->modelDiaChi->getDiaChiByUserId($userId);
            require_once './views/quanLyDiaChi.php';
        } else {
            header("Location: " . BASE_URL . '?act=login');
            exit();
        }
    }

    // Thêm địa chỉ mới
    public function themDiaChi()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_SESSION['user_client'])) {
                $tai_khoan_id = $_SESSION['user_client']['id'];
                $ho_ten = $_POST['ho_ten'];
                $so_dien_thoai = $_POST['so_dien_thoai'];
                $tinh_thanh = $_POST['tinh_thanh'];
                $quan_huyen = $_POST['quan_huyen'];
                $phuong_xa = $_POST['phuong_xa'];
                $dia_chi_chi_tiet = $_POST['dia_chi_chi_tiet'];
                $is_default = isset($_POST['is_default']) ? 1 : 0;

                // Validation
                $errors = [];
                if (empty($ho_ten)) {
                    $errors['ho_ten'] = 'Họ tên không được để trống';
                }
                if (empty($so_dien_thoai)) {
                    $errors['so_dien_thoai'] = 'Số điện thoại không được để trống';
                }
                if (empty($tinh_thanh)) {
                    $errors['tinh_thanh'] = 'Tỉnh/thành không được để trống';
                }
                if (empty($quan_huyen)) {
                    $errors['quan_huyen'] = 'Quận/huyện không được để trống';
                }
                if (empty($phuong_xa)) {
                    $errors['phuong_xa'] = 'Phường/xã không được để trống';
                }
                if (empty($dia_chi_chi_tiet)) {
                    $errors['dia_chi_chi_tiet'] = 'Địa chỉ chi tiết không được để trống';
                }

                if (empty($errors)) {
                    $result = $this->modelDiaChi->addDiaChi(
                        $tai_khoan_id, 
                        $ho_ten, 
                        $so_dien_thoai, 
                        $tinh_thanh, 
                        $quan_huyen, 
                        $phuong_xa, 
                        $dia_chi_chi_tiet, 
                        $is_default
                    );

                    if ($result) {
                        $_SESSION['success'] = 'Thêm địa chỉ thành công!';
                    } else {
                        $_SESSION['error'] = 'Có lỗi xảy ra khi thêm địa chỉ!';
                    }
                } else {
                    $_SESSION['errors'] = $errors;
                }

                header("Location: " . BASE_URL . '?act=quan-ly-dia-chi');
                exit();
            }
        }
        
        require_once './views/themDiaChi.php';
    }

    // Sửa địa chỉ
    public function suaDiaChi()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $diaChi = $this->modelDiaChi->getDiaChiById($id);
            
            if (!$diaChi || $diaChi['tai_khoan_id'] != $_SESSION['user_client']['id']) {
                $_SESSION['error'] = 'Không tìm thấy địa chỉ!';
                header("Location: " . BASE_URL . '?act=quan-ly-dia-chi');
                exit();
            }

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $ho_ten = $_POST['ho_ten'];
                $so_dien_thoai = $_POST['so_dien_thoai'];
                $tinh_thanh = $_POST['tinh_thanh'];
                $quan_huyen = $_POST['quan_huyen'];
                $phuong_xa = $_POST['phuong_xa'];
                $dia_chi_chi_tiet = $_POST['dia_chi_chi_tiet'];
                $is_default = isset($_POST['is_default']) ? 1 : 0;

                // Validation
                $errors = [];
                if (empty($ho_ten)) {
                    $errors['ho_ten'] = 'Họ tên không được để trống';
                }
                if (empty($so_dien_thoai)) {
                    $errors['so_dien_thoai'] = 'Số điện thoại không được để trống';
                }
                if (empty($tinh_thanh)) {
                    $errors['tinh_thanh'] = 'Tỉnh/thành không được để trống';
                }
                if (empty($quan_huyen)) {
                    $errors['quan_huyen'] = 'Quận/huyện không được để trống';
                }
                if (empty($phuong_xa)) {
                    $errors['phuong_xa'] = 'Phường/xã không được để trống';
                }
                if (empty($dia_chi_chi_tiet)) {
                    $errors['dia_chi_chi_tiet'] = 'Địa chỉ chi tiết không được để trống';
                }

                if (empty($errors)) {
                    $result = $this->modelDiaChi->updateDiaChi(
                        $id, 
                        $ho_ten, 
                        $so_dien_thoai, 
                        $tinh_thanh, 
                        $quan_huyen, 
                        $phuong_xa, 
                        $dia_chi_chi_tiet, 
                        $is_default
                    );

                    if ($result) {
                        $_SESSION['success'] = 'Cập nhật địa chỉ thành công!';
                    } else {
                        $_SESSION['error'] = 'Có lỗi xảy ra khi cập nhật địa chỉ!';
                    }
                } else {
                    $_SESSION['errors'] = $errors;
                }

                header("Location: " . BASE_URL . '?act=quan-ly-dia-chi');
                exit();
            }

            require_once './views/suaDiaChi.php';
        }
    }

    // Xóa địa chỉ
    public function xoaDiaChi()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $diaChi = $this->modelDiaChi->getDiaChiById($id);
            
            if (!$diaChi || $diaChi['tai_khoan_id'] != $_SESSION['user_client']['id']) {
                $_SESSION['error'] = 'Không tìm thấy địa chỉ!';
            } else {
                $result = $this->modelDiaChi->deleteDiaChi($id);
                if ($result) {
                    $_SESSION['success'] = 'Xóa địa chỉ thành công!';
                } else {
                    $_SESSION['error'] = 'Có lỗi xảy ra khi xóa địa chỉ!';
                }
            }
        }

        header("Location: " . BASE_URL . '?act=quan-ly-dia-chi');
        exit();
    }

    // Đặt địa chỉ mặc định
    public function datDiaChiMacDinh()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $userId = $_SESSION['user_client']['id'];
            
            $result = $this->modelDiaChi->setDefaultAddress($id, $userId);
            if ($result) {
                $_SESSION['success'] = 'Đặt địa chỉ mặc định thành công!';
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra!';
            }
        }

        header("Location: " . BASE_URL . '?act=quan-ly-dia-chi');
        exit();
    }
    
    /**
     * Áp dụng mã giảm giá
     */
    public function apDungMaGiamGia() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_SESSION['user_client']['id'])) {
                $_SESSION['error'] = 'Vui lòng đăng nhập để sử dụng mã giảm giá!';
                header("Location: " . BASE_URL . '?act=login');
                exit();
            }
            
            $maGiamGia = trim($_POST['ma_giam_gia'] ?? '');
            
            if (empty($maGiamGia)) {
                $_SESSION['error'] = 'Vui lòng nhập mã giảm giá!';
                header("Location: " . BASE_URL . '?act=gio-hang');
                exit();
            }
            
            // Kiểm tra mã giảm giá có hợp lệ không
            $khuyenMai = $this->modelKhuyenMai->getKhuyenMaiByCode($maGiamGia);
            
            if (!$khuyenMai) {
                $_SESSION['error'] = 'Mã giảm giá không tồn tại!';
                header("Location: " . BASE_URL . '?act=gio-hang');
                exit();
            }
            
            // Kiểm tra trạng thái khuyến mãi
            if ($khuyenMai['trang_thai'] != 1) {
                $_SESSION['error'] = 'Mã giảm giá đã hết hiệu lực!';
                header("Location: " . BASE_URL . '?act=gio-hang');
                exit();
            }
            
            // Kiểm tra thời gian hiệu lực
            $currentDate = date('Y-m-d H:i:s');
            if ($currentDate < $khuyenMai['ngay_bat_dau']) {
                $_SESSION['error'] = 'Mã giảm giá chưa có hiệu lực!';
                header("Location: " . BASE_URL . '?act=gio-hang');
                exit();
            }
            
            if ($currentDate > $khuyenMai['ngay_ket_thuc']) {
                $_SESSION['error'] = 'Mã giảm giá đã hết hạn!';
                header("Location: " . BASE_URL . '?act=gio-hang');
                exit();
            }
            
            // Kiểm tra số lượng còn lại
            if ($khuyenMai['so_luong'] <= $khuyenMai['so_lan_su_dung']) {
                $_SESSION['error'] = 'Mã giảm giá đã hết lượt sử dụng!';
                header("Location: " . BASE_URL . '?act=gio-hang');
                exit();
            }
            
            // Lưu mã giảm giá vào session
            $_SESSION['ma_giam_gia'] = $khuyenMai;
            $_SESSION['success'] = 'Áp dụng mã giảm giá thành công!';
            
        }
        
        header("Location: " . BASE_URL . '?act=gio-hang');
        exit();
    }
    
    /**
     * Xóa mã giảm giá
     */
    public function xoaMaGiamGia() {
        if (isset($_SESSION['ma_giam_gia'])) {
            unset($_SESSION['ma_giam_gia']);
            $_SESSION['success'] = 'Đã hủy mã giảm giá!';
        }
        
        header("Location: " . BASE_URL . '?act=gio-hang');
        exit();
    }
}
