<?php
class SanPham {
    public $conn; // khai báo phương thức của class sản phẩm
    public function __construct(){
        $this->conn = connectDB();
    }
    //VIẾT HÀM LẤT TOÀN BỘ DANH SÁCH SẢN PHẨM
    public function getAllProduct(){
        try{
            $sql = 'SELECT san_phams.*, danh_mucs.ten_danh_muc 
            FROM  san_phams
            INNER JOIN danh_mucs ON san_phams.danh_muc_id = danh_mucs.id
            ';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e){
            echo "Lỗi" . $e->getMessage();
        }
    }


    // Lấy dữ liệu của comment để render ra trang feedback
    public function getDataComment(){
        try{
            $sql = 'SELECT tai_khoans.ho_ten, tai_khoans.anh_dai_dien, binh_luans.noi_dung, binh_luans.ngay_dang FROM `binh_luans` JOIN tai_khoans ON binh_luans.tai_khoan_id = tai_khoans.id;
            ';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e){
            echo "Lỗi" . $e->getMessage();
        }
    }


    public function  getDetailSanPham($id){
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

    public function getBinhLuanFromSanPham($id){
        try {
            $sql = 'SELECT binh_luans.*, tai_khoans.ho_ten, tai_khoans.anh_dai_dien
            FROM binh_luans
            INNER JOIN tai_khoans ON binh_luans.tai_khoan_id = tai_khoans.id
            WHERE binh_luans.san_pham_id = :id
            ';
            $stmt = $this->conn->prepare($sql);
            $stmt ->execute([':id'=>$id]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "lỗi" .$e->getMessage();
        }
    }
    public function getListSanPhamDanhMuc($danh_muc_id){
        try{
            $sql = 'SELECT san_phams.*, danh_mucs.ten_danh_muc 
            FROM  san_phams
            INNER JOIN danh_mucs ON san_phams.danh_muc_id = danh_mucs.id
            WHERE san_phams.danh_muc_id = '. $danh_muc_id;
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e){
            echo "Lỗi" . $e->getMessage();
        }
    }

    // Inventory management methods
    public function decrementInventory($san_pham_id, $so_luong) {
        try {
            $sql = 'UPDATE san_phams SET so_luong = so_luong - :so_luong WHERE id = :san_pham_id AND so_luong >= :so_luong';
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute([
                ':san_pham_id' => $san_pham_id,
                ':so_luong' => $so_luong
            ]);
            return $stmt->rowCount() > 0; // Returns true if inventory was decremented
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
            return false;
        }
    }

    public function incrementInventory($san_pham_id, $so_luong) {
        try {
            $sql = 'UPDATE san_phams SET so_luong = so_luong + :so_luong WHERE id = :san_pham_id';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':san_pham_id' => $san_pham_id,
                ':so_luong' => $so_luong
            ]);
            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
            return false;
        }
    }

    public function checkInventory($san_pham_id, $so_luong) {
        try {
            $sql = 'SELECT so_luong FROM san_phams WHERE id = :san_pham_id';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':san_pham_id' => $san_pham_id]);
            $result = $stmt->fetch();
            return $result ? $result['so_luong'] >= $so_luong : false;
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
            return false;
        }
    }

    public function getCurrentInventory($san_pham_id) {
        try {
            $sql = 'SELECT so_luong FROM san_phams WHERE id = :san_pham_id';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':san_pham_id' => $san_pham_id]);
            $result = $stmt->fetch();
            return $result ? $result['so_luong'] : 0;
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
            return 0;
        }
    }

    // Enhanced method to get products with various filters
    public function getAllProductWithFilters($filters = [])
    {
        try {
            $sql = 'SELECT san_phams.*, danh_mucs.ten_danh_muc 
                    FROM san_phams
                    INNER JOIN danh_mucs ON san_phams.danh_muc_id = danh_mucs.id
                    WHERE 1=1';
            
            $params = [];
            
            // Apply filters
            $sql = $this->buildFilterQuery($sql, $filters, $params);
            
            // Apply sorting
            $sql = $this->applySorting($sql, $filters['sort'] ?? 'default');
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return [];
        }
    }
    
    public function getListSanPhamDanhMucWithFilters($danh_muc_id, $filters = [])
    {
        try {
            $sql = 'SELECT san_phams.*, danh_mucs.ten_danh_muc 
                    FROM san_phams
                    INNER JOIN danh_mucs ON san_phams.danh_muc_id = danh_mucs.id
                    WHERE san_phams.danh_muc_id = :danh_muc_id';
            
            $params = [':danh_muc_id' => $danh_muc_id];
            
            // Apply filters
            $sql = $this->buildFilterQuery($sql, $filters, $params);
            
            // Apply sorting
            $sql = $this->applySorting($sql, $filters['sort'] ?? 'default');
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return [];
        }
    }
    
    private function buildFilterQuery($sql, $filters, &$params)
    {
        // Search filter
        if (!empty($filters['search'])) {
            $sql .= ' AND (san_phams.ten_san_pham LIKE :search OR san_phams.mo_ta LIKE :search OR san_phams.tac_gia LIKE :search)';
            $params[':search'] = '%' . $filters['search'] . '%';
        }
        
        // Price range filter
        if (isset($filters['min_price']) && $filters['min_price'] > 0) {
            $sql .= ' AND COALESCE(san_phams.gia_khuyen_mai, san_phams.gia_san_pham) >= :min_price';
            $params[':min_price'] = $filters['min_price'];
        }
        
        if (isset($filters['max_price']) && $filters['max_price'] > 0) {
            $sql .= ' AND COALESCE(san_phams.gia_khuyen_mai, san_phams.gia_san_pham) <= :max_price';
            $params[':max_price'] = $filters['max_price'];
        }
        
        // Author filter
        if (!empty($filters['author'])) {
            $sql .= ' AND san_phams.tac_gia LIKE :author';
            $params[':author'] = '%' . $filters['author'] . '%';
        }
        
        // Status filters
        if (!empty($filters['status'])) {
            switch ($filters['status']) {
                case 'sale':
                    $sql .= ' AND san_phams.gia_khuyen_mai IS NOT NULL AND san_phams.gia_khuyen_mai > 0';
                    break;
                case 'new':
                    $sql .= ' AND san_phams.ngay_nhap >= DATE_SUB(NOW(), INTERVAL 30 DAY)';
                    break;
                case 'available':
                    $sql .= ' AND san_phams.so_luong > 0';
                    break;
            }
        }
        
        // Stock status filter
        if (!empty($filters['stock_status'])) {
            switch ($filters['stock_status']) {
                case 'in_stock':
                    $sql .= ' AND san_phams.so_luong > 5';
                    break;
                case 'low_stock':
                    $sql .= ' AND san_phams.so_luong > 0 AND san_phams.so_luong <= 5';
                    break;
                case 'out_of_stock':
                    $sql .= ' AND san_phams.so_luong = 0';
                    break;
            }
        }
        
        return $sql;
    }
    
    private function applySorting($sql, $sort)
    {
        switch ($sort) {
            case 'name':
                $sql .= ' ORDER BY san_phams.ten_san_pham ASC';
                break;
            case 'price-low':
                $sql .= ' ORDER BY COALESCE(san_phams.gia_khuyen_mai, san_phams.gia_san_pham) ASC';
                break;
            case 'price-high':
                $sql .= ' ORDER BY COALESCE(san_phams.gia_khuyen_mai, san_phams.gia_san_pham) DESC';
                break;
            case 'newest':
                $sql .= ' ORDER BY san_phams.ngay_nhap DESC';
                break;
            case 'oldest':
                $sql .= ' ORDER BY san_phams.ngay_nhap ASC';
                break;
            default:
                $sql .= ' ORDER BY san_phams.id DESC';
                break;
        }
        return $sql;
    }
    
    public function getUniqueAuthors()
    {
        try {
            $sql = 'SELECT DISTINCT tac_gia FROM san_phams WHERE tac_gia IS NOT NULL AND tac_gia != "" ORDER BY tac_gia ASC';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return [];
        }
    }
    
    public function getPriceRange($danh_muc_id = null)
    {
        try {
            $sql = 'SELECT 
                        MIN(COALESCE(gia_khuyen_mai, gia_san_pham)) as min_price,
                        MAX(COALESCE(gia_khuyen_mai, gia_san_pham)) as max_price
                    FROM san_phams WHERE 1=1';
            
            $params = [];
            if ($danh_muc_id) {
                $sql .= ' AND danh_muc_id = :danh_muc_id';
                $params[':danh_muc_id'] = $danh_muc_id;
            }
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetch();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return ['min_price' => 0, 'max_price' => 1000000];
        }
    }
}
