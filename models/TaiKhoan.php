<?php
class TaiKhoan
{
  public $conn;
  public function __construct()
  {
    $this->conn = connectDB();
  }
  public function checkLogin($email, $mat_khau)
  {
    try {
      $sql = "SELECT * FROM tai_khoans WHERE email = :email";
      $stmt = $this->conn->prepare($sql);
      $stmt->execute(['email' => $email]);
      $user = $stmt->fetch();
      // var_dump($user);die;
      if ($user && password_verify($mat_khau, $user['mat_khau'])) {
        if ($user['chuc_vu_id'] == 2) {          if ($user['trang_thai'] == 1) {
            $_SESSION['user_client'] = [
              'id' => $user['id'],
              'email' => $user['email'],
              'ho_ten' => $user['ho_ten'],
              'so_dien_thoai' => $user['so_dien_thoai'],
              'ngay_sinh' => $user['ngay_sinh'],
              'dia_chi' => $user['dia_chi']
            ];
            // var_dump($_SESSION['user_client']['id']);die;
            header("location: " . BASE_URL);
            return $user['email'];
          } else {
            return "Tài khoản bị cấm";
          }
        } else {
          return "Tài khoản không có quyền truy cập";
        }
      }  else {
        return "Bạn nhập sai thông tin mật khẩu hoặc tài khoản";
      }
    } catch (\Exception $e) {
      echo "lỗi" . $e->getMessage();
      return false;
    }
  }
  public function getTaiKhoanFromEmail($email)
  {
    try {
      $sql = 'SELECT * FROM tai_khoans WHERE email = :email';
      $stmt = $this->conn->prepare($sql);
      $stmt->execute([
        ':email' => $email]);
      return $stmt->fetch();
    } catch (Exception $e) {
      echo "lỗi" . $e->getMessage();
      flush();
    }
  }

  public function register($ho_ten, $email, $mat_khau) {
    try {
        $chuc_vu_id = 2;
        $trang_thai = 1;
        $sql = 'INSERT INTO tai_khoans (ho_ten, email, mat_khau, trang_thai, chuc_vu_id)
                VALUE (:ho_ten, :email, :mat_khau , :trang_thai, :chuc_vu_id)';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':ho_ten' => $ho_ten,
            ':email' => $email,
            ':mat_khau' => $mat_khau,
            ':trang_thai' => $trang_thai,
            ':chuc_vu_id' => $chuc_vu_id
        ]);
        return true;
    } catch (PDOException $th) {
        echo "Lỗi: " . $th->getMessage();
        flush();
    }
}

public function checkEmailExist($email) {
    try {
        // Truy vấn để kiểm tra email đã tồn tại trong cơ sở dữ liệu chưa
        $sql = "SELECT COUNT(*) FROM tai_khoans WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':email' => $email]);
        
        // Lấy số lượng kết quả
        $count = $stmt->fetchColumn();
        // var_dump($count);die;
        // Nếu số lượng kết quả > 0, tức là email đã tồn tại
        return $count > 0;
        
    } catch (PDOException $th) {
        // Xử lý lỗi PDOException nếu có
        echo "Lỗi: " . $th->getMessage();
        return false; 
    }
}

// public function comfirm_register($ma_xac_thuc) {
//     try {
//             // Kiểm tra mã xác thực
//             $sql = "SELECT * FROM tai_khoans WHERE ma_xac_thuc = :ma_xac_thuc";
//             $stmt = $this->conn->prepare($sql);
//             $stmt->execute([':ma_xac_thuc' => $ma_xac_thuc]);
//             $user = $stmt->fetch();
//             if ($user) {
//                 // Cập nhật trạng thái người dùng đã xác thực
//                 $updateSql = "UPDATE tai_khoans SET trang_thai = 1, so_lan_xac_thuc = 1 WHERE ma_xac_thuc = :ma_xac_thuc";
//                 $updateStmt = $this->conn->prepare($updateSql);
//                 $updateStmt->execute([':ma_xac_thuc' => $ma_xac_thuc]);
    
//                 return true;
//             }
    
//             return false;
//     }  catch (PDOException $th) {
//         echo "Lỗi: " . $th->getMessage();
//     }
// }

public function login($email, $mat_khau){
    try { $sql = 'SELECT * FROM tai_khoans WHERE email = :email AND mat_khau = :mat_khau';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':email' => $email,
            ':mat_khau' => $mat_khau,
        ]);
        return $stmt->fetchAll();
    } catch (PDOException $th) {
        echo "Lỗi: " . $th->getMessage();
    }
}

public function getTaiKhoanById($id){
    try {
        $sql = 'SELECT * FROM tai_khoans WHERE id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    } catch (PDOException $th) {
        echo "Lỗi: " . $th->getMessage();
        return false;
    }
}

public function updateThongTinTaiKhoan($id, $ho_ten, $email, $so_dien_thoai, $ngay_sinh, $dia_chi){
    try {
        $sql = 'UPDATE tai_khoans SET 
                ho_ten = :ho_ten, 
                email = :email, 
                so_dien_thoai = :so_dien_thoai, 
                ngay_sinh = :ngay_sinh, 
                dia_chi = :dia_chi 
                WHERE id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':ho_ten' => $ho_ten,
            ':email' => $email,
            ':so_dien_thoai' => $so_dien_thoai,
            ':ngay_sinh' => $ngay_sinh,
            ':dia_chi' => $dia_chi,
            ':id' => $id
        ]);
        return true;
    } catch (PDOException $th) {
        echo "Lỗi: " . $th->getMessage();
        return false;
    }
}

public function updateMatKhau($id, $mat_khau){
    try {
        $sql = 'UPDATE tai_khoans SET mat_khau = :mat_khau WHERE id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':mat_khau' => $mat_khau,
            ':id' => $id
        ]);
        return true;
    } catch (PDOException $th) {
        echo "Lỗi: " . $th->getMessage();
        return false;
    }
}


}
