<?php
class AdminSanPham{
    public $conn;
    public function __construct(){
        $this->conn = connectDB();
    }
    public function getAllSanPham(){
        try {
            $sql = 'SELECT san_phams.*, danh_mucs.ten_danh_muc
            FROM san_phams
            INNER JOIN danh_mucs ON san_phams.danh_muc_id = danh_mucs.id';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "lỗi" . $e->getMessage();
        }
    }
    public function insertSanPham($ten_san_pham, $gia_san_pham, $gia_khuyen_mai, $so_luong, $ngay_nhap, $danh_muc_id, $trang_thai, $mo_ta,  $hinh_anh){
        try {
            $sql = 'INSERT INTO san_phams  (ten_san_pham, gia_san_pham, gia_khuyen_mai, so_luong, ngay_nhap, danh_muc_id, trang_thai, mo_ta, hinh_anh)
            VALUES (:ten_san_pham, :gia_san_pham, :gia_khuyen_mai, :so_luong, :ngay_nhap, :danh_muc_id, :trang_thai, :mo_ta, :hinh_anh)';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':ten_san_pham' => $ten_san_pham, 
                ':gia_san_pham' => $gia_san_pham, 
                ':gia_khuyen_mai' => $gia_khuyen_mai, 
                ':so_luong' => $so_luong, 
                ':ngay_nhap' => $ngay_nhap, 
                ':danh_muc_id' => $danh_muc_id, 
                ':trang_thai' => $trang_thai, 
                ':mo_ta' => $mo_ta, 
                ':hinh_anh' => $hinh_anh, 

            ]);
            //lấy id sp vừa thêm
            return $this->conn->lastInsertId();
        } catch (Exception $e) {
            echo "lỗi" . $e->getMessage();
            
        }
    }
    public function insertAlbumAnhSanPham($san_pham_id, $link_hinh_anh){
        try {
            $sql = 'INSERT INTO hinh_anh_san_phams  (san_pham_id, link_hinh_anh)
            VALUE (:san_pham_id, :link_hinh_anh)';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':san_pham_id' => $san_pham_id, 
                ':link_hinh_anh' => $link_hinh_anh, 
            ]);
            //lấy id sp vừa thêm
            return true;
        } catch (Exception $e) {
            echo "lỗi" . $e->getMessage();
            
        }
    }

    public function getDetailSanPham($id){
        try {
            $sql = ' SELECT san_phams.*, danh_mucs.ten_danh_muc
            FROM san_phams
            INNER JOIN danh_mucs ON san_phams.danh_muc_id = danh_mucs.id
            
             WHERE san_phams.id = :id';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id'=>$id]);
            return $stmt->fetch();
        } catch (Exception $e) {
            echo "lỗi" . $e->getMessage();
        }
    }

    public function getListAnhSanPham($id){
        try {
            $sql = 'SELECT * FROM hinh_anh_san_phams WHERE san_pham_id = :id';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id'=>$id]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "lỗi" . $e->getMessage();
        }
    }

    







    public function updateSanPham($san_pham_id, $ten_san_pham, $gia_san_pham, $gia_khuyen_mai, $so_luong, $ngay_nhap, $danh_muc_id, $trang_thai, $mo_ta,  $hinh_anh){
        try {
            $sql = 'UPDATE san_phams
            SET 
              ten_san_pham = :ten_san_pham,
              gia_san_pham = :gia_san_pham,
              gia_khuyen_mai = :gia_khuyen_mai,
              so_luong = :so_luong,
              ngay_nhap = :ngay_nhap,
              danh_muc_id = :danh_muc_id,
              trang_thai = :trang_thai,
              mo_ta = :mo_ta,
              hinh_anh = :hinh_anh
              WHERE id = :id';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':ten_san_pham' => $ten_san_pham, 
                ':gia_san_pham' => $gia_san_pham, 
                ':gia_khuyen_mai' => $gia_khuyen_mai, 
                ':so_luong' => $so_luong, 
                ':ngay_nhap' => $ngay_nhap, 
                ':danh_muc_id' => $danh_muc_id, 
                ':trang_thai' => $trang_thai, 
                ':mo_ta' => $mo_ta, 
                ':hinh_anh' => $hinh_anh, 
                ':id' => $san_pham_id

            ]);
            //lấy id sp vừa thêm
            return true;
        } catch (Exception $e) {
            echo "lỗi" . $e->getMessage();
            flush();
        }
    }


    // bình luận

public function getBinhLuanFromKhachHang($id){
    try {
   $sql = "SELECT binh_luans. *, san_phams.ten_san_pham FROM binh_luans INNER JOIN  san_phams ON binh_luans.san_pham_id = san_phams.id WHERE binh_luans.tai_khoan_id = :id";
   $stmt = $this->conn->prepare($sql);
   $stmt->execute(['id' => $id]);
   return $stmt->fetchAll();
} catch (Exception $e) {
   echo $e->getMessage();
} 
}

public function getDeltaiAnhSanPham($id){
    try {
        $sql = 'SELECT * FROM hinh_anh_san_phams WHERE id = :id';

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id'=>$id]);
        return $stmt->fetch();
    } catch (Exception $e) {
        echo "lỗi" . $e->getMessage();
    }
}
public function updateAnhSanPham($id, $new_file){
    try {
        $sql = 'UPDATE hinh_anh_san_phams
        SET 
          link_hinh_anh = :new_file
          WHERE id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':new_file' => $new_file, 
            ':id' => $id

        ]);
        //lấy id sp vừa thêm
        return true;
    } catch (Exception $e) {
        echo "lỗi" . $e->getMessage();
        flush();
    }
}

public function destroyAnhSanPham($id){
    try {
        $sql = 'DELETE FROM hinh_anh_san_phams WHERE id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':id' =>  $id
        ]);
        return true;
    } catch (Exception $e) {
        echo "lỗi" . $e->getMessage();
        
    }
}



public function destroySanPham($id){
    try {
        $sql = 'DELETE FROM san_phams WHERE id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':id' =>  $id
        ]);
        return true;
    } catch (Exception $e) {
        echo "lỗi" . $e->getMessage();
        
    }
}

public function updateTrangThaiBinhLuan($id, $trang_thai){
    try{
        $sql = 'UPDATE binh_luans SET
         trang_thai = :trang_thai

         WHERE id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':trang_thai' => $trang_thai,
            ':id' => $id
            
        ]);
        return true;
    }catch(Exception $e){
        echo "Lỗi" .$e->getMessage();
    }
}

public function getDetailBinhLuan($id){
    try {
        $sql = "SELECT * FROM binh_luans WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    } catch (Exception $e) {    
        echo "Lỗi". $e->getMessage();
    }
}
    // Low stock management methods
    public function getLowStockProducts($threshold = 10) {
        try {
            $sql = 'SELECT san_phams.*, danh_mucs.ten_danh_muc
                    FROM san_phams
                    INNER JOIN danh_mucs ON san_phams.danh_muc_id = danh_mucs.id
                    WHERE san_phams.so_luong <= :threshold AND san_phams.trang_thai = 1
                    ORDER BY san_phams.so_luong ASC';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':threshold' => $threshold]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
            return [];
        }
    }

    public function getOutOfStockProducts() {
        try {
            $sql = 'SELECT san_phams.*, danh_mucs.ten_danh_muc
                    FROM san_phams
                    INNER JOIN danh_mucs ON san_phams.danh_muc_id = danh_mucs.id
                    WHERE san_phams.so_luong = 0 AND san_phams.trang_thai = 1
                    ORDER BY san_phams.ngay_nhap DESC';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
            return [];
        }
    }    public function getInventoryStats() {
        try {
            $sql = 'SELECT 
                        COUNT(*) as total_products,
                        SUM(CASE WHEN so_luong = 0 THEN 1 ELSE 0 END) as out_of_stock,
                        SUM(CASE WHEN so_luong > 0 THEN 1 ELSE 0 END) as in_stock,
                        SUM(CASE WHEN so_luong <= 5 AND so_luong > 0 THEN 1 ELSE 0 END) as low_stock,
                        SUM(CASE WHEN so_luong > 5 AND so_luong <= 10 THEN 1 ELSE 0 END) as medium_stock,
                        SUM(CASE WHEN so_luong > 10 THEN 1 ELSE 0 END) as high_stock,
                        SUM(so_luong) as total_inventory,
                        SUM(CASE WHEN so_luong = 0 THEN 1 ELSE 0 END) as out_of_stock_count,
                        SUM(CASE WHEN so_luong <= 5 AND so_luong > 0 THEN 1 ELSE 0 END) as low_stock_count
                    FROM san_phams 
                    WHERE trang_thai = 1';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetch();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
            return [
                'total_products' => 0,
                'out_of_stock' => 0,
                'in_stock' => 0,
                'low_stock' => 0,
                'medium_stock' => 0,
                'high_stock' => 0,
                'total_inventory' => 0,
                'out_of_stock_count' => 0,
                'low_stock_count' => 0
            ];
        }
    }

    public function updateStockThreshold($product_id, $new_stock) {
        try {
            $sql = 'UPDATE san_phams SET so_luong = :so_luong WHERE id = :id';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':so_luong' => $new_stock,
                ':id' => $product_id
            ]);
            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
            return false;
        }
    }

    public function logInventoryChange($san_pham_id, $old_quantity, $new_quantity, $change_type, $user_id = null, $order_id = null, $note = '') {
        try {
            $sql = 'INSERT INTO inventory_history 
                    (san_pham_id, old_quantity, new_quantity, change_quantity, change_type, user_id, order_id, note, created_at) 
                    VALUES (:san_pham_id, :old_quantity, :new_quantity, :change_quantity, :change_type, :user_id, :order_id, :note, NOW())';
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':san_pham_id' => $san_pham_id,
                ':old_quantity' => $old_quantity,
                ':new_quantity' => $new_quantity,
                ':change_quantity' => $new_quantity - $old_quantity,
                ':change_type' => $change_type, // 'manual', 'order', 'cancel', 'adjustment'
                ':user_id' => $user_id,
                ':order_id' => $order_id,
                ':note' => $note
            ]);
            return true;
        } catch (Exception $e) {
            // Log error but don't fail the main operation
            error_log("Inventory history logging failed: " . $e->getMessage());
            return false;
        }
    }
    
    public function getInventoryHistory($san_pham_id = null, $limit = 50) {
        try {
            $sql = 'SELECT ih.*, sp.ten_san_pham, tk.ho_ten as user_name, dh.ma_don_hang
                    FROM inventory_history ih
                    LEFT JOIN san_phams sp ON ih.san_pham_id = sp.id
                    LEFT JOIN tai_khoans tk ON ih.user_id = tk.id
                    LEFT JOIN don_hangs dh ON ih.order_id = dh.id';
            
            if ($san_pham_id) {
                $sql .= ' WHERE ih.san_pham_id = :san_pham_id';
            }
            
            $sql .= ' ORDER BY ih.created_at DESC LIMIT :limit';
            
            $stmt = $this->conn->prepare($sql);
            if ($san_pham_id) {
                $stmt->bindParam(':san_pham_id', $san_pham_id, PDO::PARAM_INT);
            }
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }
    
    public function createInventoryAlert($san_pham_id, $alert_type, $message) {
        try {
            $sql = 'INSERT INTO inventory_alerts (san_pham_id, alert_type, message, is_read, created_at) 
                    VALUES (:san_pham_id, :alert_type, :message, 0, NOW())';
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':san_pham_id' => $san_pham_id,
                ':alert_type' => $alert_type, // 'low_stock', 'out_of_stock', 'overstocked'
                ':message' => $message
            ]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    
    public function getUnreadAlerts($limit = 20) {
        try {
            $sql = 'SELECT ia.*, sp.ten_san_pham, sp.so_luong, sp.hinh_anh
                    FROM inventory_alerts ia
                    JOIN san_phams sp ON ia.san_pham_id = sp.id
                    WHERE ia.is_read = 0
                    ORDER BY ia.created_at DESC
                    LIMIT :limit';
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }
    
    public function markAlertAsRead($alert_id) {
        try {
            $sql = 'UPDATE inventory_alerts SET is_read = 1 WHERE id = :id';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $alert_id]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    
    public function checkAndCreateStockAlerts() {
        try {
            // Get products that need alerts
            $lowStockProducts = $this->getLowStockProducts();
            $outOfStockProducts = $this->getOutOfStockProducts();
            
            // Create alerts for low stock products
            foreach ($lowStockProducts as $product) {
                // Check if alert already exists for this product in last 24 hours
                $existingAlert = $this->conn->prepare(
                    'SELECT id FROM inventory_alerts 
                     WHERE san_pham_id = :id AND alert_type = "low_stock" 
                     AND created_at > DATE_SUB(NOW(), INTERVAL 24 HOUR)'
                );
                $existingAlert->execute([':id' => $product['id']]);
                
                if (!$existingAlert->fetch()) {
                    $message = "Sản phẩm '{$product['ten_san_pham']}' sắp hết hàng (còn {$product['so_luong']} sản phẩm)";
                    $this->createInventoryAlert($product['id'], 'low_stock', $message);
                }
            }
            
            // Create alerts for out of stock products
            foreach ($outOfStockProducts as $product) {
                $existingAlert = $this->conn->prepare(
                    'SELECT id FROM inventory_alerts 
                     WHERE san_pham_id = :id AND alert_type = "out_of_stock" 
                     AND created_at > DATE_SUB(NOW(), INTERVAL 24 HOUR)'
                );
                $existingAlert->execute([':id' => $product['id']]);
                
                if (!$existingAlert->fetch()) {
                    $message = "Sản phẩm '{$product['ten_san_pham']}' đã hết hàng!";
                    $this->createInventoryAlert($product['id'], 'out_of_stock', $message);
                }
            }
            
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    
    public function updateStockWithHistory($san_pham_id, $new_quantity, $change_type = 'manual', $user_id = null, $order_id = null, $note = '') {
        try {
            // Get current quantity first
            $currentProduct = $this->getDetailSanPham($san_pham_id);
            if (!$currentProduct) {
                return false;
            }
            
            $old_quantity = $currentProduct['so_luong'];
            
            // Update the stock
            $result = $this->updateStockThreshold($san_pham_id, $new_quantity);
            
            if ($result) {
                // Log the change
                $this->logInventoryChange($san_pham_id, $old_quantity, $new_quantity, $change_type, $user_id, $order_id, $note);
                
                // Check and create alerts if needed
                $this->checkAndCreateStockAlerts();
                
                return true;
            }
            
            return false;
        } catch (Exception $e) {
            return false;
        }
    }
}