<?php

class HomeController
{

    public $modelSanPham;
    public $modelTaiKhoan;
    public $modelGioHang;
    public $modelDonHang;
    public $commentModel;
    public function __construct()
    {
        $this->modelSanPham = new SanPham();
        $this->modelTaiKhoan = new TaiKhoan();
        $this->modelGioHang = new GioHang();
        $this->modelDonHang = new DonHang();
        $this->commentModel = new commentModel();
    }


    public function home()
    {
        // echo "Dự án 1 team 9";
        // $listSanPham = $this->modelSanPham->getAllSanPham();
        $listSanPham = $this->modelSanPham->getAllProduct();
        // var_dump($listSanPham);die;
        require_once './views/home.php';
    }
    public function trangchu()
    {
        echo "Đây là trang chủ của tôi";
    }
    public function danhSachSanPham()
    {
        // echo "Đây là danh sách sản phẩm";
        $listProduct = $this->modelSanPham->getAllProduct();
        // var_dump($listProduct);die();
        require_once './views/listProduct.php';
    }
    public function chiTietSanPham()
    {
        $id = $_GET['id_san_pham'];
        $sanPham = $this->modelSanPham->getDetailSanPham($id);
        // var_dump($sanPham['hinh_anh']);die;
        $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);
        // var_dump($listAnhSanPham);die;
        // exit;
        $listBinhLuan = $this->modelSanPham->getBinhLuanFromSanPham($id);
        $listSanPhamCungDanhMuc = $this->modelSanPham->getListSanPhamDanhMuc($sanPham['danh_muc_id']);
        $dataComment = $this->modelSanPham->getDataComment();
        if ($sanPham) {
            require_once './views/detailSanPham.php';
        } else {
            header("Location: " . BASE_URL);
            exit();
        }
    }

    public function formLogin()
    {
        require_once './views/auth/formLogin.php';
        deleteSessionError();
        exit();
    }

    public function postLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
         $user = $this->modelTaiKhoan->checkLogin($email, $password);
         if ($user == $email) {
            // $_SESSION['user_client'] = $user;
            header("Location: " . BASE_URL);
            exit();
            
         }else{
            $_SESSION['error'] = $user;
            $_SESSION['flash'] = true;
            header("Location: " . BASE_URL. '?act=login');
            exit();

         }




            // $user = $this->modelTaiKhoan->checkLogin($email, $password);
            // var_dump($user);die;
            // if ($user == $email) {
            //     $_SESSION['user_client'] = $user;
            //     header("Location: " . BASE_URL);
            //     exit();
            // } else {
            //     $_SESSION['error'] = $user;
            //     $_SESSION['flash'] = true;
            //     header("Location: " . BASE_URL . '?act=login');
            //     exit();
            // }
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
                }

                $san_pham_id = $_POST['san_pham_id'];
                $so_luong = $_POST['so_luong'];

                $checkSanPham = false;
                foreach ($chiTietGioHang as $detail) {
                    if ($detail['san_pham_id'] == $san_pham_id) {
                        $newSoLuong = $detail['so_luong'] + $so_luong;
                        $this->modelGioHang->updateSoLuong($gioHang['id'], $san_pham_id, $newSoLuong);
                        $checkSanPham = true;
                        break;
                    }
                }
                if (!$checkSanPham) {
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
    }
    public function postThanhToan(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // var_dump($_POST);die;
            $ten_nguoi_nhan= $_POST['ten_nguoi_nhan'];
            $email_nguoi_nhan= $_POST['email_nguoi_nhan'];
            $sdt_nguoi_nhan= $_POST['sdt_nguoi_nhan'];
            $dia_chi_nguoi_nhan= $_POST['dia_chi_nguoi_nhan'];
            $ghi_chu= $_POST['ghi_chu'];
            $tong_tien= $_POST['tong_tien'];
            $phuong_thuc_thanh_toan_id = $_POST['phuong_thuc_thanh_toan_id'];

            $ngay_dat = date('Y-m-d');
            // var_dump($ngay_dat);die;
            $trang_thai_id = 1;
            $user = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']['email']);
            $tai_khoan_id = $_SESSION['user_client']['id'];

            $ma_don_hang = 'DH' . rand(1000,9999);

            $this->modelDonHang->addDonHang($tai_khoan_id, $ten_nguoi_nhan, $email_nguoi_nhan , $sdt_nguoi_nhan , $dia_chi_nguoi_nhan, $ghi_chu, $tong_tien, $phuong_thuc_thanh_toan_id, $ngay_dat , $ma_don_hang , $trang_thai_id);
            var_dump('Thêm thành công');die;


        }
    }
    public function registers()
    {
        // var_dump(123);die;
        if (empty($_POST['email'])) {
            require_once './views/auth/register.php';
            die;
        }
        $errors = [];
        $email = $_POST['email'];
        // var_dump($email);die;
        // Kiểm tra email có tồn tại không
        if ($this->modelTaiKhoan->checkEmailExist($email)) {
            $errors['email'] = "Email đã tồn tại.";
            $_SESSION['errors'] = $errors;
            // var_dump($errors);
            require_once './views/auth/register.php';
            die;
        }
        // die;
        $ho_ten = $_POST['ho_ten'];
        $mat_khau = ($_POST['mat_khau']);
        // var_dump($mat_khau)
        $xac_nhan_mat_khau = ($_POST['xac_nhan_mat_khau']);
        
        if($mat_khau != $xac_nhan_mat_khau){
            $errors['xac_nhan_mat_khau'] = "Nhập lại mật khẩu không trùng khớp.";
            $_SESSION['errors'] = $errors;
            require_once './views/auth/register.php';
            die;
        }
        if($this->modelTaiKhoan->register($ho_ten, $email, password_hash($mat_khau, PASSWORD_DEFAULT))){
            // var_dump(123);die;
            header("location: " . BASE_URL . '?act=login');
            die();
        }else{
            header("location: " . BASE_URL . '?act=register');
            die();
        }

        // $ma_xac_thuc =
        // // var_dump($ma_xac_thuc);die;
        // if ($ma_xac_thuc) {
        //     $subject = 'Đăng Ký Tại PawPaw';
        //     $content = 'Vui lòng không chia sẽ mã này với bất kỳ ai. Mã xác thực của bạn là: ' . $ma_xac_thuc;
        //     sendMail($email, $subject, $content);

        //     // Chuyển đến view yêu cầu mã xác thực
        //     require_once './views/auth/comfirm_register.php';
        //     die;
        // } else {
        //     $_SESSION['errors']['email'] = "Email đã tồn tại.";
        //     require_once './views/auth/register.php';
        //     die;
        // }
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
        $san_pham_id = $_GET['id_san_pham'];
        $tai_khoan_id = $_SESSION['user_client']['id'];
        $noi_dung = $_POST['noi_dung'];
        // var_dump($noi_dung);
        $this->commentModel->add_comment($san_pham_id, $tai_khoan_id, $noi_dung);
        header('location: ' . BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $san_pham_id);
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

}
