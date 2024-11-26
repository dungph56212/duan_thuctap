<?php
class AdminSanPhamController{
    public $modelSanPham;
    public $modelDanhMuc;
    public function __construct(){
        $this->modelSanPham = new AdminSanPham();
        $this->modelDanhMuc = new AdminDanhMuc();
    }
    public function danhSachSanPham(){

      // var_dump("AAAAAAAAAA");die;
        $listSanPham = $this->modelSanPham->getAllSanPham ();
      //   var_dump($listSanPham);die;
      require_once './views/sanpham/listSanPham.php';
    }
    public function formAddSanPham(){
    // dùng để hiển thị from nhập
    $listDanhMuc = $this->modelDanhMuc->getAllDanhMuc();
    
    require_once './views/sanpham/addSanPham.php';
    // xóa session sau khi load trang
    deleteSessionError();

    }
    public function postAddSanPham(){
        // Hàm này dùng để thêm dữ liệu
        //kiểm tra xem dữ liệu có phải được submit lên không
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
             //LẤY RA DỮ LIỆU 
             $ten_san_pham = $_POST['ten_san_pham'] ?? '';
             $gia_san_pham = $_POST['gia_san_pham'] ?? '';
             $gia_khuyen_mai = $_POST['gia_khuyen_mai'] ?? '';
             $so_luong = $_POST['so_luong'] ?? '';
             $ngay_nhap = $_POST['ngay_nhap'] ?? '';
             $danh_muc_id = $_POST['danh_muc_id'] ?? '';
             $trang_thai = $_POST['trang_thai'] ?? '';
             $mo_ta = $_POST['mo_ta'] ?? '';
             // hình ảnh
             $hinh_anh = $_FILES['hinh_anh'] ?? null;
             // lưu hình ảnh vào 
             $file_thumb = uploadFile($hinh_anh,'./uploads/');

             // mảng hình ảnh
             $img_array = $_FILES['img_array'];

            


             // tạo một mảng trống để chứa dữ liệu
             $errors = [];
             if(empty($ten_san_pham)){
                $errors['ten_san_pham'] = 'tên sản phẩm không được để trống';
             }
             if(empty($gia_san_pham)){
                $errors['gia_san_pham'] = 'giá sản phẩm không được để trống';
             }
             if(empty($gia_khuyen_mai)){
                $errors['gia_khuyen_mai'] = 'giá khuyến mãi không được để trống';
             }
             if(empty($so_luong)){
                $errors['so_luong'] = 'số lượng không được để trống';
             }
             if(empty($ngay_nhap)){
                $errors['ngay_nhap'] = 'ngày nhập không được để trống';
             }
             if(empty($danh_muc_id)){
                $errors['danh_muc_id'] = 'danh mục phải chọn';
             }
             if(empty($trang_thai)){
                $errors['trang_thai'] = 'trạng thái phải chọn';
             }
             if($hinh_anh['error'] !== 0){
                $errors['hinh_anh'] = 'Hình ảnh không được để trống';
             }
             $_SESSION['error'] = $errors;


             //nếu không có lỗi thì tiến hành thêm sp
             if(empty($errors)){
                // nếu k có lỗi thì tiến hành thêm sp
                // var_dump('oke');
               $san_pham_id = $this->modelSanPham->insertSanPham($ten_san_pham, 
                                                  $gia_san_pham, 
                                                  $gia_khuyen_mai, 
                                                  $so_luong, 
                                                   $ngay_nhap, 
                                                   $danh_muc_id, 
                                                   $trang_thai, 
                                                   $mo_ta,  
                                                   $file_thumb
                                                );
                                      // xử lý thêm abum ảnh sp img_array  
                                      if(!empty($img_array['name'])){
                                        foreach($img_array['name'] as $key=>$value){
                                            $file = [
                                                'name' => $img_array['name'][$key],
                                                'type' => $img_array['type'][$key],
                                                'tmp_name' => $img_array['tmp_name'][$key],
                                                'error' => $img_array['name'][$key],
                                                'size' => $img_array['name'][$key]
                                            ];
                                            $link_hinh_anh = uploadFile($file, './uploads/');
                                            $this->modelSanPham->insertAlbumAnhSanPham($san_pham_id, $link_hinh_anh);
                                        }
                                      }
               header("location: " . BASE_URL_ADMIN . '?act=san-pham');
              exit();
             } else {
                //trả về form và lỗi
             //đặt chỉ thị xóa session sau khi hiển thi form
             $_SESSION['flash'] = true;
             header("location: " . BASE_URL_ADMIN . '?act=form-them-san-pham');
              exit();
             }
        }
    }



    public function formEditSanPham(){
        // dùng để hiển thị from nhập
        // Lấy ra thông tin của sản phẩm cần sửa
        $id = $_GET['id_san_pham'];
        $sanPham = $this->modelSanPham->getDetailSanPham($id);
        $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);
        $listDanhMuc = $this->modelDanhMuc->getAllDanhMuc();
        // var_dump($sanPham);
        // die();
        if( $sanPham){
            require_once './views/sanpham/editSanPham.php';
            deleteSessionError();
        } else {
            header("location: " . BASE_URL_ADMIN . '?act=san-pham');
              exit();
        }
        
        }
   
        






        public function postEditSanPham(){
            // Hàm này dùng để thêm dữ liệu
            //kiểm tra xem dữ liệu có phải được submit lên không
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // var_dump(13);die;
                 //LẤY RA DỮ LIỆU 
                
                 // lấy dữ liệu cũ của sản phẩm 
                 $san_pham_id = $_POST['san_pham_id'] ?? '';
                 //truy vấn 
                 $sanPhamOld = $this->modelSanPham->getDetailSanPham($san_pham_id);
                 $old_file = $sanPhamOld['hinh_anh'] ;// lấy ảnh cũ để phục vu jcho sửa ảnh

                

                 $ten_san_pham = $_POST['ten_san_pham'] ?? '';
                 $gia_san_pham = $_POST['gia_san_pham'] ?? '';
                 $gia_khuyen_mai = $_POST['gia_khuyen_mai'] ?? '';
                 $so_luong = $_POST['so_luong'] ?? '';
                 $ngay_nhap = $_POST['ngay_nhap'] ?? '';
                 $danh_muc_id = $_POST['danh_muc_id'] ?? '';
                 $trang_thai = $_POST['trang_thai'] ?? '';
                 $mo_ta = $_POST['mo_ta'] ?? '';
                 // hình ảnh
                 $hinh_anh = $_FILES['hinh_anh'] ?? null;
              

    
                
    
                // var_dump($_POST);die;
                 // tạo một mảng trống để chứa dữ liệu
                 $errors = [];
                 if(empty($ten_san_pham)){
                    $errors['ten_san_pham'] = 'tên sản phẩm không được để trống';
                 }
                 if(empty($gia_san_pham)){
                    $errors['gia_san_pham'] = 'giá sản phẩm không được để trống';
                 }
                 if(empty($gia_khuyen_mai)){
                    $errors['gia_khuyen_mai'] = 'giá khuyến mãi không được để trống';
                 }
                 if(empty($so_luong)){
                    $errors['so_luong'] = 'số lượng không được để trống';
                 }
                 if(empty($ngay_nhap)){
                    $errors['ngay_nhap'] = 'ngày nhập không được để trống';
                 }
                 if(empty($danh_muc_id)){
                    $errors['danh_muc_id'] = 'danh mục phải chọn';
                 }
                 if(empty($trang_thai)){
                    $errors['trang_thai'] = 'trạng thái phải chọn';
                 }
                 $_SESSION['error'] = $errors;
                
                 // logic sửa ảnh
                 if (isset($hinh_anh) && $hinh_anh['error'] == UPLOAD_ERR_OK) {
                    # code... 
                    //UPLPAD FILE ẢNH MỚI LÊN
                    $new_file = uploadFile($hinh_anh, './uploads/');
                    if(!empty($old_file)) { // nếu có ảnh cũ thì xóa đi
                        deleteFile($old_file);
                    }
                 } else {
                    $new_file = $old_file;
                 }
                //  var_dump($errors);die;
                 //nếu không có lỗi thì tiến hành thêm sp
                 if(empty($errors)){
                    // nếu k có lỗi thì tiến hành thêm sp
                    // var_dump('oke');die;
                   $san_pham_id = $this->modelSanPham->updateSanPham(
                                                       $san_pham_id,
                                                      $ten_san_pham, 
                                                      $gia_san_pham, 
                                                      $gia_khuyen_mai, 
                                                      $so_luong, 
                                                       $ngay_nhap, 
                                                       $danh_muc_id, 
                                                       $trang_thai, 
                                                       $mo_ta,  
                                                       $new_file
                                                    );     
                                                                           
                   header("location: " . BASE_URL_ADMIN . '?act=san-pham');
                  exit();
                 } else {
                    //trả về form và lỗi
                 //đặt chỉ thị xóa session sau khi hiển thi form
                 $_SESSION['flash'] = true;
                 header("location: " . BASE_URL_ADMIN . '?act=form-sua-san-pham&id_san_pham' . $san_pham_id);
                  exit();
                 }
            }
        }
    
    //SỬA ALBUM ẢNH
    // sửa ảnh cũ
   //  +thêm ảnh mới
   //  +không thêm ảnh mới
    //không sửa ảnh cũ
    //xóa ảnh cũ
///
public function postEditAnhSanPham(){
   if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $san_pham_id = $_GET['id_san_pham'] ?? '';
      // var_dump($san_pham_id);die;
      // lấy danh sách ảnh sản phẩm hiện tại của sp
      $listAnhSanPhamCurrent = $this->modelSanPham->getListAnhSanPham($san_pham_id);
       // xử lý các ảnh được gửi từ form
       $img_array = $_FILES['img_array'];
       $img_delete = isset($_POST['img_delete']) ? explode(',', $_POST['img_delete']) : [];
       $current_img_ids = $_POST['current_img_ids'] ?? [];

    //     public function deleteDanhMuc(){
    //         $id = $_GET['id_danh_muc'];
    //         $danhMuc = $this->modelDanhMuc->getDetailDanhMuc($id);
    //         if( $danhMuc){
    //             $this->modelDanhMuc->destroyDanhMuc($id);
    //             header("location: " . BASE_URL_ADMIN . '?act=danh-muc');
    //             edit();
    //         }
    //     }
    $upload_file = [];
       //Upload ảnh với hoặc thêm ảnh cũ
       foreach($img_array['name'] as $key =>$value){
         if($img_array['error'][$key] == UPLOAD_ERR_OK){
            $new_file = uploadFileAlbum($img_array, './uploads/', $key);
            if($new_file){
               $upload_file[] = [
                  'id' => $current_img_ids[$key] ?? null,
                  'file' => $new_file
               ];
            }
         }
       }
       // lưu hình ảnh mới vào db và xóa ảnh cũ
       foreach ($upload_file as $file_info) {
         # code...
         if($file_info['id']){
             $old_file = $this->modelSanPham->getDeltaiAnhSanPham($file_info['id']) ['link_hinh_anh'];
             //cập nhật ảnh cũ
             $this->modelSanPham->updateAnhSanPham($file_info['id'], $file_info['file']);
             //xóa ảnh cũ
             deleteFile($old_file);
         } else{
            // thêm ảnh mới
            $this->modelSanPham->insertAlBumAnhSanPham($san_pham_id, $file_info['file']);
         }
       }

       //xử lý xóa ảnh
       foreach ($listAnhSanPhamCurrent as $anhSP) {
         # code...
         $anh_id = $anhSP['id'];
         if(in_array($anh_id, $img_delete)){
          // xóa ảnh trong db
          $this->modelSanPham->destroyAnhSanPham($anh_id);
          //xóa file
          deleteFile($anhSP['link_hinh_anh']);
         }
}
header("location: " . BASE_URL_ADMIN . '?act=form-sua-san-pham&id_san_pham' . $san_pham_id);
exit();
}
}

public function deleteSanPham(){
   $id = $_GET['id_san_pham'];
   $sanPham = $this->modelSanPham->getDetailSanPham($id);
   $listAnhSanPham = $this->modelSanPham->getlistAnhSanPham($id);
   if( $sanPham){
      deleteFile($sanPham['hinh_anh']);
       $this->modelSanPham->destroySanPham($id);
      }
      if($listAnhSanPham ){
         foreach($listAnhSanPham as $key =>$anhSP){
            deleteFile($anhSP['link_hinh_anh']);
            $this->modelSanPham->destroyAnhSanPham($anhSP['id']);

<<<<<<< HEAD
                  }
               }
                header("location: " . BASE_URL_ADMIN . '?act=san-pham');
                exit();
            
=======
         }
      }
       header("location: " . BASE_URL_ADMIN . '?act=san-pham');
       exit();
   
}


public function detailSanPham(){
$id = $_GET['id_san_pham'];
$sanPham = $this->modelSanPham->getDetailSanPham($id);
// var_dump($sanPham['hinh_anh']);die;
$listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);
if( $sanPham){
    require_once './views/sanpham/detailSanPham.php';
} else {
    header("location: " . BASE_URL_ADMIN . '?act=san-pham');
      exit();
}

}

      public function updateTrangThaiBinhLuan(){
      $id_binh_luan = $_POST['id_binh_luan'];
      $name_view = $_POST['name_view'];

      
      $binhLuan = $this-> modelSanPham-> getDetailBinhLuan($id_binh_luan);
      if($binhLuan){
        $trang_thai_update ='';
        if($binhLuan['trang_thai'] == 1){
          $trang_thai_update = 2;
        }else{
          $trang_thai_update = 1;
        } 

       $status= $this-> modelSanPham-> updateTrangThaiBinhLuan($id_binh_luan, $trang_thai_update);
       if($status){

          if($name_view == 'detail_khach')
        {
          header("Location:" . BASE_URL_ADMIN . '?act=chi-tiet-khach-hang&id_khach_hang=' . $binhLuan['tai_khoan_id']);
        } else{
          header("Location:" . BASE_URL_ADMIN . '?act=chi-tiet-san-pham&id_san_pham='.$binhLuan['san_pham_id']);
>>>>>>> f6465fcccbbaac5321d0f281d8fc1b4cda4069ff
        }
       }
      }
  }
       //khai báo mảng để lưu ảnh thêm mới hoặc thay thế
       

       
}