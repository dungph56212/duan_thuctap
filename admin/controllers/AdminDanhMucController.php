<?php
class AdminDanhMucController{
    public $modelDanhMuc;
    public function __construct(){
        $this->modelDanhMuc = new AdminDanhMuc();
    }
    public function danhSachDanhMuc(){

        $listDanhMuc = $this->modelDanhMuc->getAllDanhMuc ();
      require_once './views/danhmuc/listDanhMuc.php';
    }
    public function formAddDanhMuc(){
    // dùng để hiển thị from nhập
    require_once './views/danhmuc/addDanhMuc.php';
    }
    public function postAddDanhMuc(){
        // Hàm này dùng để thêm dữ liệu
        //kiểm tra xem dữ liệu có phải được submit lên không
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
             //LẤY RA DỮ LIỆU 
             $ten_danh_muc = $_POST['ten_danh_muc'];
             $mo_ta = $_POST['mo_ta'];
            // var_dump($_POST);die;
             // tạo một mảng trống để chứa dữ liệu
             $errors = [];
             if(empty($ten_danh_muc)){
                $errors['ten_danh_muc'] = 'tên danh mục không được để trống';
             }

             //nếu không có lỗi thì tiến hành thêm danh mục
             if(empty($errors)){
                // nếu k có lỗi thì tiến hành thêm danh mục
                // var_dump('oke');
               $this->modelDanhMuc->insertDanhMuc($ten_danh_muc, $mo_ta);
               header("location: " . BASE_URL_ADMIN . '?act=danh-muc');
              exit();
             } else {
                //trả về form và lỗi
             require_once './views/danhmuc/addDanhMuc.php';

             }
        }
    }



    public function formEditDanhMuc(){
        // dùng để hiển thị from nhập
        // Lấy ra thông tin của danh mục cần sửa
        $id = $_GET['id_danh_muc'];
        $danhMuc = $this->modelDanhMuc->getDetailDanhMuc($id);
        // var_dump($danhMuc);
        // die();
        if( $danhMuc){
            require_once './views/danhmuc/editDanhMuc.php';
        } else {
            header("location: " . BASE_URL_ADMIN . '?act=danh-muc');
              exit();
        }
        
        }
        public function postEditDanhMuc(){
            // Hàm này dùng để thêm dữ liệu
            //kiểm tra xem dữ liệu có phải được submit lên không
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                 //LẤY RA DỮ LIỆU 
                 $id = $_POST['id'];
                 $ten_danh_muc = $_POST['ten_danh_muc'];
                 $mo_ta = $_POST['mo_ta'];
                // var_dump($_POST);die;
                 // tạo một mảng trống để chứa dữ liệu
                 $errors = [];
                 if(empty($ten_danh_muc)){
                    $errors['ten_danh_muc'] = 'tên danh mục không được để trống';
                 }
    
                 //nếu không có lỗi thì tiến hành sửa danh mục
                 if(empty($errors)){
                    // nếu k có lỗi thì tiến hành thêm danh mục
                    // var_dump('oke');
                   $this->modelDanhMuc->updateDanhMuc($id, $ten_danh_muc, $mo_ta);
                   header("location: " . BASE_URL_ADMIN . '?act=danh-muc');
                  exit();
                 } else {
                    //trả về form và lỗi
                    $danhMuc = ['id' => $id, 'ten_danh_muc' => $ten_danh_muc, 'mo_ta' => $mo_ta];
                 require_once './views/danhmuc/editDanhMuc.php';
    
                 }
            }
        }

        public function deleteDanhMuc(){
            $id = $_GET['id_danh_muc'];
            $danhMuc = $this->modelDanhMuc->getDetailDanhMuc($id);
            if( $danhMuc){
                $this->modelDanhMuc->destroyDanhMuc($id);
                header("location: " . BASE_URL_ADMIN . '?act=danh-muc');
                exit();
            }
        }
}