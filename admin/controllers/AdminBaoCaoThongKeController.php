<?php
class AdminBaoCaoThongKeController{
    public $modelBaoCaoThongKe;
    public $modelSanPham;
    
    public function __construct(){
        $this->modelBaoCaoThongKe = new AdminBaoCaoThongKe();
        $this->modelSanPham = new AdminSanPham();
    }
    
    public function home(){
        // Get all statistics for dashboard
        $totalOrders = $this->modelBaoCaoThongKe->getTotalOrders();
        $totalRevenue = $this->modelBaoCaoThongKe->getTotalRevenue();
        $totalProducts = $this->modelBaoCaoThongKe->getTotalProducts();
        $totalCustomers = $this->modelBaoCaoThongKe->getTotalCustomers();
        
        // Get detailed statistics
        $ordersByStatus = $this->modelBaoCaoThongKe->getOrdersByStatus();
        $topSellingProducts = $this->modelBaoCaoThongKe->getTopSellingProducts(4);
        $revenueByMonth = $this->modelBaoCaoThongKe->getRevenueByMonth();
        $dailyRevenue = $this->modelBaoCaoThongKe->getDailyRevenueCurrentMonth();
        $recentOrders = $this->modelBaoCaoThongKe->getRecentOrders(5);
        $lowStockProducts = $this->modelBaoCaoThongKe->getLowStockProducts(10);
        
        // Enhanced inventory statistics
        $inventoryStats = $this->modelSanPham->getInventoryStats();
        $outOfStockProducts = $this->modelSanPham->getOutOfStockProducts();
        $criticalStockProducts = $this->modelSanPham->getLowStockProducts(5);
        
        // Get rates and percentages
        $visitorStats = $this->modelBaoCaoThongKe->getVisitorStats();
        $conversionStats = $this->modelBaoCaoThongKe->getConversionStats();
        $salesRate = $this->modelBaoCaoThongKe->getSalesRate();
        $registrationRate = $this->modelBaoCaoThongKe->getRegistrationRate();
        
        require_once './views/home.php';
    }      public function inventoryManagement(){
        // Dedicated inventory management page
        $inventoryStats = $this->modelSanPham->getInventoryStats();
        $lowStockProducts = $this->modelSanPham->getLowStockProducts();
        $outOfStockProducts = $this->modelSanPham->getOutOfStockProducts();
        $allProducts = $this->modelSanPham->getAllSanPham();
        
        // Ensure inventoryStats is an array with default values if null
        if (!$inventoryStats || !is_array($inventoryStats)) {
            $inventoryStats = [
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
        
        // Ensure arrays are not null
        $lowStockProducts = $lowStockProducts ?: [];
        $outOfStockProducts = $outOfStockProducts ?: [];
        $allProducts = $allProducts ?: [];
        
        require_once './views/tonkho/quanLyTonKho.php';
    }public function quickStockUpdate(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $san_pham_id = $_POST['san_pham_id'] ?? '';
            $so_luong_moi = $_POST['so_luong_moi'] ?? '';
            
            if(!empty($san_pham_id) && is_numeric($so_luong_moi) && $so_luong_moi >= 0){
                $user_id = $_SESSION['user_admin']['id'] ?? null;
                $result = $this->modelSanPham->updateStockWithHistory(
                    $san_pham_id, 
                    $so_luong_moi, 
                    'manual', 
                    $user_id, 
                    null, 
                    'Cập nhật thủ công từ trang quản lý tồn kho'
                );
                
                if($result){
                    $_SESSION['success'] = "Cập nhật số lượng tồn kho thành công!";
                } else {
                    $_SESSION['error'] = "Lỗi khi cập nhật số lượng tồn kho!";
                }
            } else {
                $_SESSION['error'] = "Dữ liệu không hợp lệ!";
            }
            
            header("location: " . BASE_URL_ADMIN . '?act=quan-ly-ton-kho');
            exit();
        }
    }
      public function bulkStockUpdate(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $updates = $_POST['updates'] ?? [];
            $successCount = 0;
            $errorCount = 0;
            $user_id = $_SESSION['user_admin']['id'] ?? null;
            
            if(!empty($updates) && is_array($updates)){
                foreach($updates as $update){
                    $san_pham_id = $update['san_pham_id'] ?? '';
                    $so_luong_moi = $update['so_luong_moi'] ?? '';
                    
                    if(!empty($san_pham_id) && is_numeric($so_luong_moi) && $so_luong_moi >= 0){
                        $result = $this->modelSanPham->updateStockWithHistory(
                            $san_pham_id, 
                            $so_luong_moi, 
                            'manual', 
                            $user_id, 
                            null, 
                            'Cập nhật hàng loạt từ trang quản lý tồn kho'
                        );
                        if($result){
                            $successCount++;
                        } else {
                            $errorCount++;
                        }
                    } else {
                        $errorCount++;
                    }
                }
                
                if($successCount > 0){
                    $_SESSION['success'] = "Cập nhật thành công $successCount sản phẩm!";
                }
                if($errorCount > 0){
                    $_SESSION['error'] = "Có $errorCount sản phẩm không thể cập nhật!";
                }
            } else {
                $_SESSION['error'] = "Không có dữ liệu để cập nhật!";
            }
            
            header("location: " . BASE_URL_ADMIN . '?act=quan-ly-ton-kho');
            exit();
        }
    }
    
    public function exportInventoryReport(){
        // Get inventory data
        $inventoryStats = $this->modelSanPham->getInventoryStats();
        $lowStockProducts = $this->modelSanPham->getLowStockProducts();
        $outOfStockProducts = $this->modelSanPham->getOutOfStockProducts();
        $allProducts = $this->modelSanPham->getAllSanPham();
        
        // Set headers for CSV download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="inventory_report_' . date('Y-m-d_H-i-s') . '.csv"');
        
        // Open output stream
        $output = fopen('php://output', 'w');
        
        // Add BOM for UTF-8
        fwrite($output, "\xEF\xBB\xBF");
        
        // CSV headers
        fputcsv($output, ['STT', 'Tên sản phẩm', 'Danh mục', 'Giá', 'Số lượng', 'Trạng thái', 'Ngày cập nhật']);
        
        // Add data rows
        foreach($allProducts as $key => $product){
            $status = '';
            if($product['so_luong'] == 0){
                $status = 'Hết hàng';
            } elseif($product['so_luong'] <= 5){
                $status = 'Sắp hết';
            } else {
                $status = 'Còn hàng';
            }
            
            fputcsv($output, [
                $key + 1,
                $product['ten_san_pham'],
                $product['ten_danh_muc'],
                number_format($product['gia_khuyen_mai'] ?: $product['gia_san_pham']),
                $product['so_luong'],
                $status,
                date('d/m/Y H:i:s')
            ]);
        }
        
        fclose($output);
        exit();
    }
    
    public function inventoryHistory(){
        $san_pham_id = $_GET['san_pham_id'] ?? null;
        $limit = $_GET['limit'] ?? 50;
        
        $inventoryHistory = $this->modelSanPham->getInventoryHistory($san_pham_id, $limit);
        $allProducts = $this->modelSanPham->getAllSanPham();
        
        require_once './views/tonkho/lichSuTonKho.php';
    }
    
    public function inventoryAlerts(){
        $unreadAlerts = $this->modelSanPham->getUnreadAlerts();
        $allAlerts = $this->modelSanPham->getUnreadAlerts(100); // Get more for the full list
        
        require_once './views/tonkho/canhBaoTonKho.php';
    }
    
    public function markAlertRead(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $alert_id = $_POST['alert_id'] ?? '';
            
            if(!empty($alert_id)){
                $result = $this->modelSanPham->markAlertAsRead($alert_id);
                
                if($result){
                    echo json_encode(['success' => true, 'message' => 'Đã đánh dấu đã đọc']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Lỗi khi cập nhật']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
            }
            exit();
        }
    }
    
    public function getAjaxAlerts(){
        $alerts = $this->modelSanPham->getUnreadAlerts(10);
        $count = count($alerts);
        
        echo json_encode([
            'success' => true,
            'count' => $count,
            'alerts' => $alerts
        ]);
        exit();
    }
}