<?php
// admin/controllers/AdminBookManagerController.php
class AdminBookManagerController
{
    public $adminBookManager;

    public function __construct()
    {
        $this->adminBookManager = new AdminBookManager();
    }    // Dashboard quản lý sách
    public function dashboard()
    {
        $stats = $this->adminBookManager->getBookStats();
        $recentBooks = $this->adminBookManager->getRecentBooks(5);
        $popularBooks = $this->adminBookManager->getPopularBooks(5);
        $categories = $this->adminBookManager->getCategories();
        
        require_once './views/bookmanager/dashboard.php';
    }

    // Danh sách sách
    public function listBooks()
    {
        $books = $this->adminBookManager->getAllBooks();
        $categories = $this->adminBookManager->getCategories();
        
        require_once './views/bookmanager/list.php';
    }

    // Form thêm sách
    public function addBookForm()
    {
        $categories = $this->adminBookManager->getCategories();
        require_once './views/bookmanager/add.php';
    }    // Xử lý thêm sách
    public function addBook()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'ten_san_pham' => $_POST['ten_san_pham'],
                'gia_san_pham' => $_POST['gia_san_pham'],
                'gia_khuyen_mai' => $_POST['gia_khuyen_mai'] ?: null,
                'hinh_anh' => $_POST['hinh_anh'],
                'so_luong' => $_POST['so_luong'],
                'mo_ta' => $_POST['mo_ta'],
                'danh_muc_id' => $_POST['danh_muc_id'],
                'trang_thai' => $_POST['trang_thai']
            ];

            $result = $this->adminBookManager->addBook($data);
            
            if ($result) {
                $_SESSION['success'] = "Thêm sách thành công!";
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra khi thêm sách!";
            }
              header("Location: " . BASE_URL_ADMIN . "?act=danh-sach-sach");
            exit();
        }
    }

    // Form sửa sách
    public function editBookForm()
    {
        $id = $_GET['id'] ?? 0;
        $book = $this->adminBookManager->getBookById($id);
        $categories = $this->adminBookManager->getCategories();
        
        if (!$book) {
            $_SESSION['error'] = "Không tìm thấy sách!";
            header("Location: " . BASE_URL_ADMIN . "?act=danh-sach-sach");
            exit();
        }
        
        require_once './views/bookmanager/edit.php';
    }

    // Xử lý sửa sách
    public function editBook()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $data = [
                'ten_san_pham' => $_POST['ten_san_pham'],
                'gia_san_pham' => $_POST['gia_san_pham'],
                'gia_khuyen_mai' => $_POST['gia_khuyen_mai'] ?: null,
                'hinh_anh' => $_POST['hinh_anh'],
                'so_luong' => $_POST['so_luong'],
                'mo_ta' => $_POST['mo_ta'],
                'danh_muc_id' => $_POST['danh_muc_id'],
                'trang_thai' => $_POST['trang_thai']
            ];

            $result = $this->adminBookManager->updateBook($id, $data);
            
            if ($result) {
                $_SESSION['success'] = "Cập nhật sách thành công!";
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra khi cập nhật sách!";
            }
            
            header("Location: " . BASE_URL_ADMIN . "?act=danh-sach-sach");
            exit();
        }
    }

    // Xóa sách
    public function deleteBook()
    {
        $id = $_GET['id'] ?? 0;
        $result = $this->adminBookManager->deleteBook($id);
        
        if ($result) {
            $_SESSION['success'] = "Xóa sách thành công!";
        } else {
            $_SESSION['error'] = "Có lỗi xảy ra khi xóa sách!";
        }
        
        header("Location: " . BASE_URL_ADMIN . "?act=danh-sach-sach");
        exit();
    }

    // Thêm sách hàng loạt - Form
    public function bulkAddForm()
    {
        require_once './views/bookmanager/bulk_add.php';
    }

    // Xử lý thêm sách hàng loạt
    public function postBulkAdd()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $result = $this->adminBookManager->addSampleBooks();
            
            if ($result['success']) {
                $_SESSION['success'] = "Đã thêm {$result['count']} sách mẫu thành công!";
            } else {
                $_SESSION['error'] = "Có lỗi: " . $result['error'];
            }
            
            header("Location: " . BASE_URL_ADMIN . "?act=quan-ly-sach");
            exit();
        }
    }    // Quản lý danh mục - Form
    public function categoriesForm()
    {
        $categories = $this->adminBookManager->getCategoriesWithBookCount();
        require_once './views/bookmanager/categories.php';
    }

    // Thêm/Sửa/Xóa danh mục
    public function postCategories()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $action = $_POST['action'] ?? 'add';
            
            switch ($action) {
                case 'add':
                    $data = [
                        'ten_danh_muc' => $_POST['ten_danh_muc'],
                        'mo_ta' => $_POST['mo_ta']
                    ];
                    $result = $this->adminBookManager->addCategory($data);
                    if ($result) {
                        $_SESSION['success'] = "Thêm danh mục thành công!";
                    } else {
                        $_SESSION['error'] = "Có lỗi xảy ra khi thêm danh mục!";
                    }
                    break;
                    
                case 'edit':
                    $id = $_POST['category_id'];
                    $data = [
                        'ten_danh_muc' => $_POST['ten_danh_muc'],
                        'mo_ta' => $_POST['mo_ta']
                    ];
                    $result = $this->adminBookManager->updateCategory($id, $data);
                    if ($result) {
                        $_SESSION['success'] = "Cập nhật danh mục thành công!";
                    } else {
                        $_SESSION['error'] = "Có lỗi xảy ra khi cập nhật danh mục!";
                    }
                    break;
                    
                case 'delete':
                    $id = $_GET['category_id'] ?? $_POST['category_id'];
                    $result = $this->adminBookManager->deleteCategory($id);
                    if ($result) {
                        $_SESSION['success'] = "Xóa danh mục thành công!";
                    } else {
                        $_SESSION['error'] = "Không thể xóa danh mục! Có thể còn sản phẩm trong danh mục này.";
                    }
                    break;
                    
                case 'add_samples':
                    $added = $this->adminBookManager->addSampleCategories();
                    if ($added > 0) {
                        $_SESSION['success'] = "Đã thêm $added danh mục mẫu thành công!";
                    } else {
                        $_SESSION['error'] = "Không có danh mục mới nào được thêm. Có thể tất cả đã tồn tại.";
                    }
                    break;
            }
        }
        
        header("Location: " . BASE_URL_ADMIN . "?act=danh-muc-sach");
        exit();
    }

    // ChatBot Analytics
    public function chatbotAnalytics()
    {
        $stats = $this->adminBookManager->getChatbotStats();
        $recentChats = $this->adminBookManager->getRecentChats(20);
        $popularQueries = $this->adminBookManager->getPopularQueries();
        
        require_once './views/bookmanager/chatbot_analytics.php';
    }

    // Xóa lịch sử chat
    public function clearChatHistory()
    {
        $days = $_POST['days'] ?? 30;
        $result = $this->adminBookManager->clearChatHistory($days);
        
        if ($result !== false) {
            $_SESSION['success'] = "Đã xóa $result tin nhắn cũ hơn $days ngày!";
        } else {
            $_SESSION['error'] = "Có lỗi xảy ra khi xóa lịch sử chat!";
        }
          header("Location: " . BASE_URL_ADMIN . "?act=thong-ke-chatbot");
        exit();
    }
}
?>
