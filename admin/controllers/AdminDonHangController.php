<?php
class AdminDonHangController{
    public $modelDonHang;
    public $modelSanPham;
    public function __construct(){
        $this->modelDonHang = new AdminDonHang();
        $this->modelSanPham = new SanPham();
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
      //   var_dump($donHang);die;  
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
                //  var_dump($errors);die;                 //nếu không có lỗi thì tiến hành sửa
                 if(empty($errors)){
                    // Get current order status before updating
                    $currentOrder = $this->modelDonHang->getDetailDonHang($don_hang_id);
                    $oldStatus = $currentOrder['trang_thai_id'];
                    $newStatus = $trang_thai_id;
                    
                    // Handle inventory when order status changes to cancelled (11)
                    if($newStatus == 11 && $oldStatus != 11) {
                        // Restore inventory when order is cancelled
                        $chiTietDonHang = $this->modelDonHang->getListSpDonHang($don_hang_id);
                        foreach($chiTietDonHang as $item){
                            $this->modelSanPham->incrementInventory($item['san_pham_id'], $item['so_luong']);
                        }
                    }
                    // Handle inventory when cancelled order is reactivated
                    elseif($oldStatus == 11 && $newStatus != 11) {
                        // Decrement inventory when cancelled order is reactivated
                        $chiTietDonHang = $this->modelDonHang->getListSpDonHang($don_hang_id);
                        $inventoryCheck = true;
                        $insufficientItems = [];
                        
                        // Check if there's enough inventory
                        foreach($chiTietDonHang as $item){
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
                            $_SESSION['error']['inventory'] = "Không đủ hàng trong kho để kích hoạt lại đơn hàng:";
                            foreach($insufficientItems as $item){
                                $_SESSION['error']['inventory'] .= "\n- {$item['name']}: Yêu cầu {$item['requested']}, còn lại {$item['available']}";
                            }
                            $_SESSION['flash'] = true;
                            header("location: " . BASE_URL_ADMIN . '?act=form-sua-don-hang&id_don_hang=' . $don_hang_id);
                            exit();
                        }
                        
                        // Decrement inventory
                        foreach($chiTietDonHang as $item){
                            $this->modelSanPham->decrementInventory($item['san_pham_id'], $item['so_luong']);
                        }
                    }
                    
                    // Update order
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
   
    

