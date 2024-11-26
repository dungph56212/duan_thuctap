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


//     public function formEditSanPham(){
//         // dùng để hiển thị from nhập
//         // Lấy ra thông tin của sản phẩm cần sửa
//         $id = $_GET['id_san_pham'];
//         $sanPham = $this->modelSanPham->getDetailSanPham($id);
//         $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);
//         $listDanhMuc = $this->modelDanhMuc->getAllDanhMuc();
//         // var_dump($sanPham);
//         // die();
//         if( $sanPham){
//             require_once './views/sanpham/editSanPham.php';
//             deleteSessionError();
//         } else {
//             header("location: " . BASE_URL_ADMIN . '?act=san-pham');
//               exit();
//         }
        
//         }
   
        






//         public function postEditSanPham(){
//             // Hàm này dùng để thêm dữ liệu
//             //kiểm tra xem dữ liệu có phải được submit lên không
//             if($_SERVER['REQUEST_METHOD'] == 'POST'){
//                 // var_dump(13);die;
//                  //LẤY RA DỮ LIỆU 
                
//                  // lấy dữ liệu cũ của sản phẩm 
//                  $san_pham_id = $_POST['san_pham_id'] ?? '';
//                  //truy vấn 
//                  $sanPhamOld = $this->modelSanPham->getDetailSanPham($san_pham_id);
//                  $old_file = $sanPhamOld['hinh_anh'] ;// lấy ảnh cũ để phục vu jcho sửa ảnh

                

//                  $ten_san_pham = $_POST['ten_san_pham'] ?? '';
//                  $gia_san_pham = $_POST['gia_san_pham'] ?? '';
//                  $gia_khuyen_mai = $_POST['gia_khuyen_mai'] ?? '';
//                  $so_luong = $_POST['so_luong'] ?? '';
//                  $ngay_nhap = $_POST['ngay_nhap'] ?? '';
//                  $danh_muc_id = $_POST['danh_muc_id'] ?? '';
//                  $trang_thai = $_POST['trang_thai'] ?? '';
//                  $mo_ta = $_POST['mo_ta'] ?? '';
//                  // hình ảnh
//                  $hinh_anh = $_FILES['hinh_anh'] ?? null;
              

    
                
    
//                 // var_dump($_POST);die;
//                  // tạo một mảng trống để chứa dữ liệu
//                  $errors = [];
//                  if(empty($ten_san_pham)){
//                     $errors['ten_san_pham'] = 'tên sản phẩm không được để trống';
//                  }
//                  if(empty($gia_san_pham)){
//                     $errors['gia_san_pham'] = 'giá sản phẩm không được để trống';
//                  }
//                  if(empty($gia_khuyen_mai)){
//                     $errors['gia_khuyen_mai'] = 'giá khuyến mãi không được để trống';
//                  }
//                  if(empty($so_luong)){
//                     $errors['so_luong'] = 'số lượng không được để trống';
//                  }
//                  if(empty($ngay_nhap)){
//                     $errors['ngay_nhap'] = 'ngày nhập không được để trống';
//                  }
//                  if(empty($danh_muc_id)){
//                     $errors['danh_muc_id'] = 'danh mục phải chọn';
//                  }
//                  if(empty($trang_thai)){
//                     $errors['trang_thai'] = 'trạng thái phải chọn';
//                  }
//                  $_SESSION['error'] = $errors;
                
//                  // logic sửa ảnh
//                  if (isset($hinh_anh) && $hinh_anh['error'] == UPLOAD_ERR_OK) {
//                     # code... 
//                     //UPLPAD FILE ẢNH MỚI LÊN
//                     $new_file = uploadFile($hinh_anh, './uploads/');
//                     if(!empty($old_file)) { // nếu có ảnh cũ thì xóa đi
//                         deleteFile($old_file);
//                     }
//                  } else {
//                     $new_file = $old_file;
//                  }
//                 //  var_dump($errors);die;
//                  //nếu không có lỗi thì tiến hành thêm sp
//                  if(empty($errors)){
//                     // nếu k có lỗi thì tiến hành thêm sp
//                     // var_dump('oke');die;
//                    $san_pham_id = $this->modelSanPham->updateSanPham(
//                                                        $san_pham_id,
//                                                       $ten_san_pham, 
//                                                       $gia_san_pham, 
//                                                       $gia_khuyen_mai, 
//                                                       $so_luong, 
//                                                        $ngay_nhap, 
//                                                        $danh_muc_id, 
//                                                        $trang_thai, 
//                                                        $mo_ta,  
//                                                        $new_file
//                                                     );     
                                                                           
//                    header("location: " . BASE_URL_ADMIN . '?act=san-pham');
//                   exit();
//                  } else {
//                     //trả về form và lỗi
//                  //đặt chỉ thị xóa session sau khi hiển thi form
//                  $_SESSION['flash'] = true;
//                  header("location: " . BASE_URL_ADMIN . '?act=form-sua-san-pham&id_san_pham' . $san_pham_id);
//                   exit();
//                  }
//             }
//         }
    
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
}