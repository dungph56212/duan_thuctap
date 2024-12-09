<?php
class AdminDonHang{
    public $conn;
    public function __construct(){
        $this->conn = connectDB();
    }
    public function getAllDonHang(){
        try {
            $sql = 'SELECT don_hangs.*, trang_thai_don_hangs.ten_trang_thai
            -- tai_khoans.ho_ten, tai_khoans.email, tai_khoans.so_dien_thoai
            FROM don_hangs
            INNER JOIN trang_thai_don_hangs ON don_hangs.trang_thai_id = trang_thai_don_hangs.id
            -- INNER JOIN tai_khoans ON don_hangs.tai_khoan_id = tai_khoans.id
            ';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "lỗi" . $e->getMessage();
        }
    }


    public function getAllTrangThaiDonHang(){
        try {
            $sql = 'SELECT * FROM trang_thai_don_hangs';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "lỗi" . $e->getMessage();
        }
    }










    public function getDetailDonHang($id){
        try {
            $sql = ' SELECT don_hangs.*, 
            trang_thai_don_hangs.ten_trang_thai, 
            tai_khoans.ho_ten, tai_khoans.email, tai_khoans.so_dien_thoai,
            phuong_thuc_thanh_toans.ten_phuong_thuc
            FROM don_hangs
            INNER JOIN trang_thai_don_hangs ON don_hangs.trang_thai_id = trang_thai_don_hangs.id
            INNER JOIN tai_khoans ON don_hangs.tai_khoan_id = tai_khoans.id
            INNER JOIN phuong_thuc_thanh_toans ON don_hangs.phuong_thuc_thanh_toan_id = phuong_thuc_thanh_toans.id
             WHERE don_hangs.id = :id';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id'=>$id]);
            return $stmt->fetch();
        } catch (Exception $e) {
            echo "lỗi" . $e->getMessage();
        }
    }

    public function getListSpDonHang($id){
        try {
            $sql = 'SELECT chi_tiet_don_hangs.*, san_phams.ten_san_pham
             FROM chi_tiet_don_hangs
            INNER JOIN san_phams ON chi_tiet_don_hangs.san_pham_id = san_phams.id
             
            WHERE chi_tiet_don_hangs.don_hang_id = :id';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id'=>$id]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "lỗi" . $e->getMessage();
        }
    }

    public function updateDonHang($id, $ten_nguoi_nhan, $sdt_nguoi_nhan, $email_nguoi_nhan, $dia_chi_nguoi_nhan, $ghi_chu, $trang_thai_id ){
        try {
            $sql = 'UPDATE don_hangs
            SET 
              ten_nguoi_nhan = :ten_nguoi_nhan,
              sdt_nguoi_nhan = :sdt_nguoi_nhan,
              email_nguoi_nhan = :email_nguoi_nhan,
              dia_chi_nguoi_nhan = :dia_chi_nguoi_nhan,
              ghi_chu = :ghi_chu,
              trang_thai_id = :trang_thai_id
              WHERE id = :id';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':ten_nguoi_nhan' => $ten_nguoi_nhan, 
                ':sdt_nguoi_nhan' => $sdt_nguoi_nhan, 
                ':email_nguoi_nhan' => $email_nguoi_nhan, 
                ':dia_chi_nguoi_nhan' => $dia_chi_nguoi_nhan, 
                ':ghi_chu' => $ghi_chu, 
                ':trang_thai_id' => $trang_thai_id,
                ':id' => $id,

            ]);
            return true;
        } catch (Exception $e) {
            echo "lỗi" . $e->getMessage();
        }
    }


public function getDonHangFromKhachHang($id){
    try {
   $sql = "SELECT don_hangs. *, trang_thai_don_hangs.ten_trang_thai FROM don_hangs INNER JOIN trang_thai_don_hangs ON don_hangs.trang_thai_id = trang_thai_don_hangs.id WHERE don_hangs.tai_khoan_id = :id";
   $stmt = $this->conn->prepare($sql);
   $stmt->execute(['id' => $id]);
   return $stmt->fetchAll();
} catch (Exception $e) {
   echo $e->getMessage();
} 
}

}