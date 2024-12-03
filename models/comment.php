<?php 
    class commentModel{
        public $conn;

        public function __construct(){
            $this->conn = connectDB();
        }

        public function add_comment($san_pham_id, $tai_khoan_id, $noi_dung){
            try {
                $trang_thai = 1;
                $ngay_dang = date('Y-m-d H:i:s');
                $sql = 'INSERT INTO binh_luans (san_pham_id, tai_khoan_id, noi_dung, ngay_dang, trang_thai)
                VALUE (:san_pham_id, :tai_khoan_id, :noi_dung, :ngay_dang, :trang_thai)';
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    ':san_pham_id' => $san_pham_id,
                    ':tai_khoan_id' => $tai_khoan_id,
                    ':noi_dung' => $noi_dung,
                    ':ngay_dang' => $ngay_dang,
                    ':trang_thai' => $trang_thai,
                ]);
                return true;
            } catch (PDOException $th) {
                echo "lôi: " . $th->getMessage();
            }
        }
    }
?>