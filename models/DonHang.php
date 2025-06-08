<?php 
 class DonHang
 {
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }
    public function addDonHang($tai_khoan_id, $ten_nguoi_nhan, $email_nguoi_nhan , $sdt_nguoi_nhan , $dia_chi_nguoi_nhan, $ghi_chu, $tong_tien, $phuong_thuc_thanh_toan_id, $ngay_dat , $ma_don_hang, $trang_thai_id)
        {
            try{
                $sql = 'INSERT INTO don_hangs (tai_khoan_id, ten_nguoi_nhan, email_nguoi_nhan , sdt_nguoi_nhan , dia_chi_nguoi_nhan, ghi_chu, tong_tien, phuong_thuc_thanh_toan_id, ngay_dat ,ma_don_hang ,trang_thai_id) 
                VALUES (:tai_khoan_id, :ten_nguoi_nhan, :email_nguoi_nhan , :sdt_nguoi_nhan , :dia_chi_nguoi_nhan, :ghi_chu, :tong_tien, :phuong_thuc_thanh_toan_id, :ngay_dat , :ma_don_hang , :trang_thai_id)';
                
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([':tai_khoan_id'=>$tai_khoan_id,
                ':ten_nguoi_nhan'=>$ten_nguoi_nhan,
                ':email_nguoi_nhan'=>$email_nguoi_nhan,
                ':sdt_nguoi_nhan'=>$sdt_nguoi_nhan,
                ':dia_chi_nguoi_nhan'=>$dia_chi_nguoi_nhan,
                ':ghi_chu'=>$ghi_chu,
                ':tong_tien'=>$tong_tien,
                ':phuong_thuc_thanh_toan_id'=>$phuong_thuc_thanh_toan_id,
                ':ngay_dat'=>$ngay_dat,
                ':ma_don_hang'=>$ma_don_hang,
                ':trang_thai_id'=>$trang_thai_id
            
            
            ]);
                return $this->conn->lastInsertId();
            } catch (Exception $e) {
                echo "Lỗi" . $e->getMessage();
            }
         }
         
         public function addChiTietDonHang($donHangId, $sanPhamId, $soLuong, $donGia, $thanhTien){
            try {
                $sql="INSERT INTO chi_tiet_don_hangs (don_hang_id,san_pham_id,don_gia,so_luong,thanh_tien)
                        VALUES (:don_hang_id,:san_pham_id,:don_gia,:so_luong,:thanh_tien)";

                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    ':don_hang_id'=>$donHangId,
                    ':san_pham_id'=>$sanPhamId,
                    ':don_gia'=>$donGia,
                    ':so_luong'=>$soLuong,
                    ':thanh_tien'=>$thanhTien
                ]);
                return true;

            } catch (Exception $e) {
                echo "Lỗi".$e->getMessage();            }
         }

         public function getTrangThaiDonHang(){
            try {
                $sql="SELECT * FROM trang_thai_don_hangs";

                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);

            } catch (Exception $e) {
                echo "Lỗi".$e->getMessage();
            }
         }

         public function getPhuongThucThanhToan(){
            try {
                $sql="SELECT * FROM phuong_thuc_thanh_toans";

                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);

            } catch (Exception $e) {
                echo "Lỗi".$e->getMessage();
            }
         }

         public function getDonHangById($donHangId){
            try {
                $sql="SELECT * FROM don_hangs WHERE id = :id";

                $stmt = $this->conn->prepare($sql);
                $stmt->execute([':id'=>$donHangId]);
                return $stmt->fetch(PDO::FETCH_ASSOC);

            } catch (Exception $e) {
                echo "Lỗi".$e->getMessage();
            }
         }

         public function getChiTietDonHangByDonHangId($donHangId){
            try {
                $sql="SELECT 
                    chi_tiet_don_hangs.*,
                    san_phams.ten_san_pham,
                    san_phams.hinh_anh
                 FROM 
                    chi_tiet_don_hangs
                JOIN
                    san_phams ON chi_tiet_don_hangs.san_pham_id = san_phams.id
                WHERE 
                    chi_tiet_don_hangs.don_hang_id = :don_hang_id";

                $stmt = $this->conn->prepare($sql);
                $stmt->execute([':don_hang_id'=>$donHangId]);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);

            } catch (Exception $e) {
                echo "Lỗi".$e->getMessage();
            }
         }

         public function updateTrangThaiDonHang($donHangId,$trangThaiID){
            try {
                $sql="UPDATE don_hangs SET trang_thai_id = :trang_thai_id WHERE id = :id";

                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    ':trang_thai_id'=>$trangThaiID,
                    ':id'=>$donHangId
                ]);
                return true;

            } catch (Exception $e) {
                echo "Lỗi".$e->getMessage();
            }
         }

         public function countDonHangByUser($tai_khoan_id){
            try {
                $sql = 'SELECT COUNT(*) FROM don_hangs WHERE tai_khoan_id = :tai_khoan_id';
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([':tai_khoan_id' => $tai_khoan_id]);
                return $stmt->fetchColumn();
            } catch (Exception $e) {
                echo "Lỗi: " . $e->getMessage();
                return 0;
            }
         }

         public function countDonHangByUserAndStatus($tai_khoan_id, $trang_thai_id){
            try {
                if(is_array($trang_thai_id)){
                    $placeholders = str_repeat('?,', count($trang_thai_id) - 1) . '?';
                    $sql = "SELECT COUNT(*) FROM don_hangs WHERE tai_khoan_id = ? AND trang_thai_id IN ($placeholders)";
                    $params = array_merge([$tai_khoan_id], $trang_thai_id);
                } else {
                    $sql = 'SELECT COUNT(*) FROM don_hangs WHERE tai_khoan_id = ? AND trang_thai_id = ?';
                    $params = [$tai_khoan_id, $trang_thai_id];
                }
                
                $stmt = $this->conn->prepare($sql);
                $stmt->execute($params);
                return $stmt->fetchColumn();
            } catch (Exception $e) {
                echo "Lỗi: " . $e->getMessage();
                return 0;
            }         }

         public function getDonHangFromUser($tai_khoan_id, $limit = null){
            try {
                $sql = 'SELECT don_hangs.*, trang_thai_don_hangs.ten_trang_thai 
                        FROM don_hangs 
                        LEFT JOIN trang_thai_don_hangs ON don_hangs.trang_thai_id = trang_thai_don_hangs.id
                        WHERE don_hangs.tai_khoan_id = :tai_khoan_id 
                        ORDER BY don_hangs.ngay_dat DESC';
                
                if($limit){
                    $sql .= " LIMIT $limit";
                }
                
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([':tai_khoan_id' => $tai_khoan_id]);
                return $stmt->fetchAll();
            } catch (Exception $e) {
                echo "Lỗi: " . $e->getMessage();
                return [];
            }
         }

         
 } 


?>