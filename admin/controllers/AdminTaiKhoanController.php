<?php
class AdminTaiKhoanController{
    public $modelTaiKhoan;
    public $modelDonHang;
    public $modelSanPham;

    public function __construct(){
        $this->modelTaiKhoan = new AdminTaiKhoan();
        $this->modelDonHang = new AdminDonHang();
        $this->modelSanPham = new AdminSanPham();
    }

    public function danhSachQuanTri(){
        $listQuanTri = $this->modelTaiKhoan->getAllTaiKhoan(1);
        
        require_once './views/taikhoan/quantri/listQuanTri.php';
    }

    public function formAddQuanTri(){
        require_once './views/taikhoan/quantri/addQuanTri.php';

        deleteSessionError();
    }

    public function postAddQuanTri(){
            // Hàm này dùng để thêm dữ liệu
            //kiểm tra xem dữ liệu có phải được submit lên không
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                 //LẤY RA DỮ LIỆU 
                 $ho_ten = $_POST['ho_ten'];
                 $email = $_POST['email'];
                // var_dump($_POST);die;
                 // tạo một mảng trống để chứa dữ liệu
                 $errors = [];
                 if(empty($ho_ten)){
                    $errors['ho_ten'] = 'tên không được để trống';
                 }
                 if(empty($email)){
                    
                    $errors['email'] = 'Email không được để trống';
                 }

                 if ($this->modelTaiKhoan->checkEmail($email)){
                    $errors['email'] = 'Email đã tồn tại';
                 }

                 $_SESSION['error'] = $errors;
    
                 //nếu không có lỗi thì tiến hành thêm danh mục
                 if(empty($errors)){
                    // nếu k có lỗi thì tiến hành thêm danh mục
                    // var_dump('oke');
                    // đặt password mặc định - 123@123ab
                    $password = password_hash('123123', PASSWORD_BCRYPT);

                    // khai báo chức vụ
                    $chuc_vu_id=1;
                    // var_dump($password);die;

                    // var_dump($_POST, $password, $chuc_vu_id);die;
                    $this->modelTaiKhoan->insertTaiKhoan($ho_ten, $email, $password, $chuc_vu_id);

                
                   header("location: " . BASE_URL_ADMIN . '?act=list-tai-khoan-quan-tri');
                  exit();
                 } else {
                    //trả về form và lỗi
                 $_SESSION['flash']= true;

                 header("location: " . BASE_URL_ADMIN . '?act=form-them-quan-tri');
                 exit();
                 }
            }
    }

    public function formEditQuanTri(){
        $id_quan_tri = $_GET['id_quan_tri'];
        $quanTri = $this->modelTaiKhoan->getDetailTaiKhoan($id_quan_tri);
        // var_dump($quanTri);die;
        require_once './views/taikhoan/quantri/editQuanTri.php';
        deleteSessionError();
       
    }

    public function postEditQuanTri()
    {
        // xử lí thêm dữ liệu
        // kiểm tra dữ liệu có đc submit lên không

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $quan_tri_id = $_POST['quan_tri_id'] ?? ' ';
         

            $ho_ten = $_POST['ho_ten'] ?? ' ';
            $email = $_POST['email'] ?? ' ';
            $so_dien_thoai = $_POST['so_dien_thoai'] ?? ' ';
            $trang_thai = $_POST['trang_thai'] ?? ' ';
    
  
            $errors = [];
            if (empty($ho_ten)) {
                $errors['ho_ten'] = 'Vui lòng nhập không bỏ trống ';
            }
            if (empty($email)) {
               
                $errors['email'] = 'Vui lòng nhập không bỏ trống ';
            }
            if (empty($trang_thai)) {
               
                $errors['trang_thai'] = 'Vui lòng nhập không bỏ trống ';
            }
        
           
            
            $_SESSION['error'] = $errors;
           
              
            if (empty($errors)) {
         $this->modelTaiKhoan->updateTaiKhoan($quan_tri_id,$ho_ten, $email, $so_dien_thoai, $trang_thai);

          
                header("Location:" . BASE_URL_ADMIN . '?act=list-tai-khoan-quan-tri');
                exit();
            } else {
                // require_once './views/sanpham/addSanPham.php';
                $_SESSION['flash']= true;
                header("Location:" . BASE_URL_ADMIN . '?act=form-sua-quan-tri&id_quan_tri=' . $quan_tri_id);
                exit();
            }
        }
    }

    public function resetPassword()
    {
        $tai_khoan_id = $_GET['id_quan_tri'] ?? null;
        if (!$tai_khoan_id) {
            echo "Thiếu id_quan_tri!";
            exit();
        }
        $tai_khoan = $this->modelTaiKhoan->getDetailTaiKhoan($tai_khoan_id);
        if (!$tai_khoan) {
            echo "Không tìm thấy tài khoản!";
            exit();
        }
        $password = password_hash('123123', PASSWORD_BCRYPT);
        $status = $this->modelTaiKhoan->resetPassword($tai_khoan_id, $password);
        if($status && $tai_khoan['chuc_vu_id'] == 1){
            header("Location:" . BASE_URL_ADMIN . '?act=list-tai-khoan-quan-tri');
            exit();
        }elseif ($status && $tai_khoan['chuc_vu_id'] == 2) {
            header("Location:" . BASE_URL_ADMIN . '?act=list-tai-khoan-khach-hang');
            exit();
        }
        else{
            echo "Sai";
        }
    }

    public function danhSachKhachHang()
    {
        $listKhachHang = $this->modelTaiKhoan->getAllTaiKhoan(2);
      
        require_once './views/taikhoan/khachhang/listKhachHang.php';
    }
    public function formEditKhachHang(){
        $id_khach_hang = $_GET['id_khach_hang'];
        $khachHang = $this->modelTaiKhoan->getDetailTaiKhoan($id_khach_hang);
        // var_dump($quanTri);
        // die();
        

        require_once './views/taikhoan/khachhang/editKhachHang.php';
        deleteSessionError();
    }
    public function postEditKhachHang()
    {
        // xử lí thêm dữ liệu
        // kiểm tra dữ liệu có đc submit lên không

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $khach_hang_id = $_POST['khach_hang_id'] ?? ' ';
         

            $ho_ten = $_POST['ho_ten'] ?? ' ';
            $email = $_POST['email'] ?? ' ';
            $so_dien_thoai = $_POST['so_dien_thoai'] ?? ' ';
            $ngay_sinh = $_POST['ngay_sinh'] ?? ' ';
            $gioi_tinh = $_POST['gioi_tinh'] ?? ' ';
            $dia_chi = $_POST['dia_chi'] ?? ' ';
            $trang_thai = $_POST['trang_thai'] ?? ' ';
    
  
            $errors = [];
            if (empty($ho_ten)) {
                $errors['ho_ten'] = 'Vui lòng nhập không bỏ trống ';
            }
            if (empty($email)) {
               
                $errors['email'] = 'Vui lòng nhập không bỏ trống ';
            }
            if (empty($ngay_sinh)) {
               
                $errors['ngay_sinh'] = 'Vui lòng nhập không bỏ trống ';
            }
            if (empty($gioi_tinh)) {
               
                $errors['gioi_tinh'] = 'Vui lòng nhập không bỏ trống ';
            }
            if (empty($trang_thai)) {
               
                $errors['trang_thai'] = 'Vui lòng nhập không bỏ trống ';
            }
        
           
            
            $_SESSION['error'] = $errors;
           
              
            if (empty($errors)) {
         $this->modelTaiKhoan->updateKhachHang($khach_hang_id,$ho_ten, $email, $so_dien_thoai, $ngay_sinh, $gioi_tinh, $dia_chi, $trang_thai);

          
                header("Location:" . BASE_URL_ADMIN . '?act=list-tai-khoan-khach-hang');
                exit();
            } else {
                // require_once './views/sanpham/addSanPham.php';
                $_SESSION['flash']= true;
                header("Location:" . BASE_URL_ADMIN . '?act=from-sua-khach-hang&id_khach_hang=' . $khach_hang_id);
                exit();
            }
        }
    }
    public function detailKhachHang(){
        $id_khach_hang = $_GET['id_khach_hang'];
        $khachHang = $this->modelTaiKhoan->getDetailTaiKhoan($id_khach_hang);
        $listDonHang = $this->modelDonHang->getDonHangFromKhachHang($id_khach_hang);
        $listBinhLuan = $this->modelSanPham->getBinhLuanFromKhachHang($id_khach_hang);
        require_once './views/taikhoan/khachhang/deltailKhachHang.php';
    }

    public function formLogin(){

        require_once './views/auth/formLogin.php';

        deleteSessionError();

        exit();
    }

    public function login(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // lấy email và pass từ form
            $email = $_POST['email'];    
            $password = $_POST['password'];
             
            $user = $this->modelTaiKhoan->checkLogin($email, $password);
            if($user == $email){
                 $_SESSION['user_admin'] = $user;
                 header("Location:" . BASE_URL_ADMIN );
                 exit();
            }else{
                $_SESSION['error']= $user;
                // var_dump($_SESSION['error']);
                // die();
                $_SESSION['flash']= true;  
                header("Location:" . BASE_URL_ADMIN . '?act=login-admin');
                exit();
                
            }
        }
    }

    public function logout(){
        if(isset($_SESSION['user_admin'])) {
            unset($_SESSION['user_admin']);
            header("Location:" . BASE_URL_ADMIN . '?act=login-admin');
            exit();
        }
    }

    public function formEditCaNhanQuanTri(){

        $email = $_SESSION['user_admin'];

        $thongTin = $this->modelTaiKhoan->getTaiKhoanformEmail($email);

        require_once './views/taikhoan/canhan/editCaNhan.php';
        deleteSessionError();
    }

    public function postEditCaNhanQuanTri()
    {
        // xử lí thêm dữ liệu
        // kiểm tra dữ liệu có đc submit lên không

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          
         

            $ho_ten = $_POST['ho_ten'] ?? ' ';
            $email = $_POST['email'] ?? ' ';
            $so_dien_thoai = $_POST['so_dien_thoai'] ?? ' ';
           
            $trang_thai = $_POST['trang_thai'] ?? ' ';
    
  
            $errors = [];
            if (empty($ho_ten)) {
                $errors['ho_ten'] = 'Vui lòng nhập không bỏ trống ';
            }
            if (empty($email)) {
               
                $errors['email'] = 'Vui lòng nhập không bỏ trống ';
            }
            if (empty($so_dien_thoai)) {
               
                $errors['so_dien_thoai'] = 'Vui lòng nhập không bỏ trống ';
            }
          
            if (empty($trang_thai)) {
               
                $errors['trang_thai'] = 'Vui lòng nhập không bỏ trống ';
            }
        
           
            
            $_SESSION['error'] = $errors;
           
              
            if (empty($errors)) {
         $this->modelTaiKhoan->updateThongTinCaNhan($ho_ten, $email, $so_dien_thoai, $trang_thai);

          
                header("Location:" . BASE_URL_ADMIN . '?act=form-sua-thong-tin-ca-nhan-quan-tri');
                exit();
            } else {
                // require_once './views/sanpham/addSanPham.php';
                $_SESSION['flash']= true;
                header("Location:" . BASE_URL_ADMIN . '?act=form-sua-thong-tin-ca-nhan-quan-tri' );
                exit();
            }
        }
    }

    public function postEditMatKhauCaNhan(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
      
          $old_pass= $_POST['old_pass'];
          $new_pass= $_POST['new_pass'];
          $confirm_pass= $_POST['confirm_pass'];
          // var_dump($old_pass);
          // die();
           
          $user = $this->modelTaiKhoan->getTaiKhoanformEmail($_SESSION['user_admin']);
          $checkPass = password_verify($old_pass, $user['mat_khau']);
          $errors = [];
          if(!$checkPass){
            $errors['old_pass'] = 'Mật khẩu không đúng';
          }
      
          if($new_pass !== $confirm_pass){
            $errors['confirm_pass'] = 'Xác nhận mật khẩu';
            
            }
            if(empty($old_pass)){
              $errors['old_pass'] = 'Vui lòng nhập mật khẩu';
            }
         if(empty($new_pass)){
            $errors['new_pass'] = 'Vui lòng nhập mật khẩu';
        }
        if(empty($confirm_pass)){
          $errors['confirm_pass'] = 'Vui lòng nhập mật khẩu';
      }
      $_SESSION['error'] = $errors;
      if(!$errors){
        $hashPass = password_hash($new_pass, PASSWORD_BCRYPT);
        $status =  $this -> modelTaiKhoan->resetPassword($user['id'],$hashPass);
        if($status){
          $_SESSION['success'] = 'Đổi mật khẩu thành công';
          $_SESSION['flash']= true;  
      
          header("Location:" . BASE_URL_ADMIN . '?act=form-sua-thong-tin-ca-nhan-quan-tri');
        }
      }else{
          // var_dump($_SESSION['error']);
          // die();
          $_SESSION['flash']= true;  
          header("Location:" . BASE_URL_ADMIN . '?act=form-sua-thong-tin-ca-nhan-quan-tri');
          exit();
          
      }
        }
          }
}