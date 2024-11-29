<?php

class HomeController
{

    public $modelSanPham;
    public $modelTaiKhoan;
    public $modelGioHang;
    public function __construct()
    {
        $this->modelSanPham = new SanPham();
        $this->modelTaiKhoan = new TaiKhoan();
        $this->modelGioHang = new GioHang();
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
            $_SESSION['user_client'] = $user;
            header("Location: " . BASE_URL);
            exit();
            
         }else{
            $_SESSION['error'] = $user;
            $_SESSION['flash'] = true;
            header("Location: " . BASE_URL. '?act=login');
            exit();

         }




            $user = $this->modelTaiKhoan->checkLogin($email, $password);
            var_dump($user);die;
            if ($user == $email) {
                $_SESSION['user_client'] = $user;
                header("Location: " . BASE_URL);
                exit();
            } else {
                $_SESSION['error'] = $user;
                $_SESSION['flash'] = true;
                header("Location: " . BASE_URL . '?act=login');
                exit();
            }
        }
    }
    
    
    public function addGioHang()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
                var_dump('Chưa đăng nhập');
                die;
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
            require_once './views/gioHang.php';
        } else {
            var_dump('Chưa đăng nhập');
            die;
        }
        
        require_once './views/thanhToan.php';
    }
    public function postThanhToan(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // var_dump($_POST);die;
        }
    }

}
