<?php
class AdminDonHangController{
    public $modelDonHang;
    public function __construct(){
        $this->modelDonHang = new AdminDonHang();
    }
    public function danhSachDonHang(){

        $listDonHang = $this->modelDonHang->getAllDonHang ();
        // var_dump($listDonHang);die;
      require_once './views/donhang/listDonHang.php';
    }
   
    public function detailDonHang(){
        $don_hang_id = $_GET['id_don_hang'];
        // var_dump($don_hang_id);die;
        // lấy thông tin đơn hàng ở bảng đơn hàng
        $donHang = $this->modelDonHang->getDetailDonHang($don_hang_id);
        // var_dump($donHang);die;
        //lấy danh sách sản phẩm đã cài đặt của đơn hàng ở bảng chi_tiet_don_hangs
        $sanPhamDonHang = $this->modelDonHang->getListSpDonHang($don_hang_id);
         $listTrangThaiDonHang = $this->modelDonHang->getAllTrangThaiDonHang();
        
        require_once './views/donhang/detailDonHang.php';

    }  


    public function formEditDonHang(){

        $id = $_GET['id_don_hang'];
        $donHang = $this->modelDonHang->getDetailDonHang($id);
        $listTrangThaiDonHang = $this->modelDonHang->getAllTrangThaiDonHang($id);
        // var_dump($donHang);
        // die();
        if( $donHang){
            require_once './views/donhang/editDonHang.php';
            deleteSessionError();
        } else {
            header("location: " . BASE_URL_ADMIN . '?act=don-hang');
              exit();
        }
        
        }





        public function postEditDonHang(){
            // Hàm này dùng để thêm dữ liệu
            //kiểm tra xem dữ liệu có phải được submit lên không
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // var_dump(13);die;
                 //LẤY RA DỮ LIỆU 
                 $don_hang_id = $_POST['don_hang_id'] ?? '';
                 $ten_nguoi_nhan = $_POST['ten_nguoi_nhan'] ?? '';
                 $sdt_nguoi_nhan = $_POST['sdt_nguoi_nhan'] ?? '';
                 $email_nguoi_nhan = $_POST['email_nguoi_nhan'] ?? '';
                 $dia_chi_nguoi_nhan = $_POST['dia_chi_nguoi_nhan'] ?? '';
                 $ghi_chu = $_POST['ghi_chu'] ?? '';
                 $trang_thai_id = $_POST['trang_thai_id'] ?? '';

    
                // var_dump($_POST);die;
                 // tạo một mảng trống để chứa dữ liệu
                 $errors = [];
                 if(empty($ten_nguoi_nhan)){
                    $errors['ten_nguoi_nhan'] = 'tên người nhận không được để trống';
                 }
                 if(empty($sdt_nguoi_nhan)){
                    $errors['sdt_nguoi_nhan'] = 'số điện thoại không được để trống';
                 }
                 if(empty($email_nguoi_nhan)){
                    $errors['email_nguoi_nhan'] = 'Email người nhận không được để trống';
                 }
                 if(empty($dia_chi_nguoi_nhan)){
                    $errors['dia_chi_nguoi_nhan'] = 'Địa chỉ nhận không được để trống';
                 }
               //   if(empty($ghi_chu)){
               //    $errors['ghi_chu'] = 'Địa chỉ nhận không được để trống';
               // }

                 if(empty($trang_thai_id)){
                    $errors['trang_thai_id'] = 'Trạng thái đơn hàng';
                 }
         
                 $_SESSION['error'] = $errors;
                //  var_dump($errors);die;
                 //nếu không có lỗi thì tiến hành sửa
                 if(empty($errors)){
                    // nếu k có lỗi thì tiến hành thêm sp
                    // var_dump('oke');die;
                 $this->modelDonHang->updateDonHang($don_hang_id, $ten_nguoi_nhan, $sdt_nguoi_nhan, $email_nguoi_nhan, $dia_chi_nguoi_nhan, $ghi_chu, $trang_thai_id);     
                                                                           
                   header("location: " . BASE_URL_ADMIN . '?act=don-hang');
                  exit();
                 } else {
                    //trả về form và lỗi
                 //đặt chỉ thị xóa session sau khi hiển thi form
                 $_SESSION['flash'] = true;
                 header("location: " . BASE_URL_ADMIN . '?act=form-sua-don-hang&id_don_hang' . $don_hang_id);
                  exit();
                 }
            }
        }
      }
   
    
//     //SỬA ALBUM ẢNH
//     // sửa ảnh cũ
//    //  +thêm ảnh mới
//    //  +không thêm ảnh mới
//     //không sửa ảnh cũ
//     //xóa ảnh cũ
// ///
// public function postEditAnhSanPham(){
//    if($_SERVER['REQUEST_METHOD'] == 'POST'){
//       $san_pham_id = $_GET['id_san_pham'] ?? '';
//       // var_dump($san_pham_id);die;
//       // lấy danh sách ảnh sản phẩm hiện tại của sp
//       $listAnhSanPhamCurrent = $this->modelSanPham->getListAnhSanPham($san_pham_id);
//        // xử lý các ảnh được gửi từ form
//        $img_array = $_FILES['img_array'];
//        $img_delete = isset($_POST['img_delete']) ? explode(',', $_POST['img_delete']) : [];
//        $current_img_ids = $_POST['current_img_ids'] ?? [];

//        //khai báo mảng để lưu ảnh thêm mới hoặc thay thế
//        $upload_file = [];
//        //Upload ảnh với hoặc thêm ảnh cũ
//        foreach($img_array['name'] as $key =>$value){
//          if($img_array['error'][$key] == UPLOAD_ERR_OK){
//             $new_file = uploadFileAlbum($img_array, './uploads/', $key);
//             if($new_file){
//                $upload_file[] = [
//                   'id' => $current_img_ids[$key] ?? null,
//                   'file' => $new_file
//                ];
//             }
//          }
//        }
//        // lưu hình ảnh mới vào db và xóa ảnh cũ
//        foreach ($upload_file as $file_info) {
//          # code...
//          if($file_info['id']){
//              $old_file = $this->modelSanPham->getDeltaiAnhSanPham($file_info['id']) ['link_hinh_anh'];
//              //cập nhật ảnh cũ
//              $this->modelSanPham->updateAnhSanPham($file_info['id'], $file_info['file']);
//              //xóa ảnh cũ
//              deleteFile($old_file);
//          } else{
//             // thêm ảnh mới
//             $this->modelSanPham->insertAlBumAnhSanPham($san_pham_id, $file_info['file']);
//          }
//        }

//        //xử lý xóa ảnh
//        foreach ($listAnhSanPhamCurrent as $anhSP) {
//          # code...
//          $anh_id = $anhSP['id'];
//          if(in_array($anh_id, $img_delete)){
//           // xóa ảnh trong db
//           $this->modelSanPham->destroyAnhSanPham($anh_id);
//           //xóa file
//           deleteFile($anhSP['link_hinh_anh']);
//          }
// }
// header("location: " . BASE_URL_ADMIN . '?act=form-sua-san-pham&id_san_pham' . $san_pham_id);
// exit();
// }
// }

//         public function deleteSanPham(){
//             $id = $_GET['id_san_pham'];
//             $sanPham = $this->modelSanPham->getDetailSanPham($id);
//             $listAnhSanPham = $this->modelSanPham->getlistAnhSanPham($id);
//             if( $sanPham){
//                deleteFile($sanPham['hinh_anh']);
//                 $this->modelSanPham->destroySanPham($id);
//                }
//                if($listAnhSanPham ){
//                   foreach($listAnhSanPham as $key =>$anhSP){
//                      deleteFile($anhSP['link_hinh_anh']);
//                      $this->modelSanPham->destroyAnhSanPham($anhSP['id']);

//                   }
//                }
//                 header("location: " . BASE_URL_ADMIN . '?act=san-pham');
//                 edit();
            
//         }


//         public function detailSanPham(){
//          $id = $_GET['id_san_pham'];
//          $sanPham = $this->modelSanPham->getDetailSanPham($id);
//          // var_dump($sanPham['hinh_anh']);die;
//          $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);
//          if( $sanPham){
//              require_once './views/sanpham/detailSanPham.php';
//          } else {
//              header("location: " . BASE_URL_ADMIN . '?act=san-pham');
//                exit();
//          }
         
//          }
