<?php 

class HomeController
{

    public $modelSanPham;
    public $modelTaiKhoan;
    public function __construct(){
      $this->modelSanPham = new SanPham();
      $this->modelTaiKhoan = new TaiKhoan();
    }


    public function home() {
        // echo "Dự án 1 team 9";
        // $listSanPham = $this->modelSanPham->getAllSanPham();
        $listSanPham = $this->modelSanPham->getAllProduct();
        // var_dump($listSanPham);die;
        require_once './views/home.php';
    }
    public function trangchu(){
        echo "Đây là trang chủ của tôi";
    }
    public function danhSachSanPham(){
        // echo "Đây là danh sách sản phẩm";
        $listProduct = $this->modelSanPham->getAllProduct();
        // var_dump($listProduct);die();
        require_once './views/listProduct.php';
    }
    public function chiTietSanPham(){
        $id = $_GET['id_san_pham'];
        $sanPham = $this->modelSanPham->getDetailSanPham($id);
        // var_dump($sanPham['hinh_anh']);die;
        $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);
        $listBinhLuan = $this->modelSanPham->getBinhLuanFromSanPham($id);
        $listSanPhamCungDanhMuc = $this->modelSanPham->getListSanPhamDanhMuc($sanPham['danh_muc_id']);
        if( $sanPham){
            require_once './views/detailSanPham.php';
        } else {
            header("location: ".BASE_URL );
              exit();
        }

    }
    public function formLogin(){
        require_once './views/auth/formLogin.php';
        deleteSessionError();
        exit();

    }
    public function postlogin(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST')  {
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




        }
    }
}