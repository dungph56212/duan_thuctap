<?php
// admin/models/AdminBookManager.php
class AdminBookManager
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Lấy thống kê sách
    public function getBookStats()
    {
        try {
            $stats = [];
            
            // Tổng số sách
            $stmt = $this->conn->query("SELECT COUNT(*) as total FROM san_phams");
            $stats['total_books'] = $stmt->fetchColumn();
            
            // Sách còn hàng
            $stmt = $this->conn->query("SELECT COUNT(*) as in_stock FROM san_phams WHERE so_luong > 0");
            $stats['in_stock'] = $stmt->fetchColumn();
            
            // Sách hết hàng
            $stmt = $this->conn->query("SELECT COUNT(*) as out_stock FROM san_phams WHERE so_luong = 0");
            $stats['out_stock'] = $stmt->fetchColumn();
            
            // Tổng số lượng
            $stmt = $this->conn->query("SELECT SUM(so_luong) as total_quantity FROM san_phams");
            $stats['total_quantity'] = $stmt->fetchColumn() ?: 0;
            
            // Tổng giá trị kho
            $stmt = $this->conn->query("SELECT SUM(gia_san_pham * so_luong) as total_value FROM san_phams");
            $stats['total_value'] = $stmt->fetchColumn() ?: 0;
            
            // Sách mới trong tuần
            $stmt = $this->conn->query("SELECT COUNT(*) as new_this_week FROM san_phams WHERE ngay_nhap >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
            $stats['new_this_week'] = $stmt->fetchColumn();
            
            // Danh mục có nhiều sách nhất
            $stmt = $this->conn->query("
                SELECT dm.ten_danh_muc, COUNT(sp.id) as count 
                FROM danh_mucs dm 
                LEFT JOIN san_phams sp ON dm.id = sp.danh_muc_id 
                GROUP BY dm.id 
                ORDER BY count DESC 
                LIMIT 1
            ");
            $topCategory = $stmt->fetch();
            $stats['top_category'] = $topCategory ? $topCategory['ten_danh_muc'] . ' (' . $topCategory['count'] . ')' : 'Chưa có';
            
            return $stats;
        } catch (Exception $e) {
            return [];
        }
    }

    // Lấy sách mới nhất
    public function getRecentBooks($limit = 5)
    {
        try {
            $stmt = $this->conn->prepare("
                SELECT sp.*, dm.ten_danh_muc 
                FROM san_phams sp 
                LEFT JOIN danh_mucs dm ON sp.danh_muc_id = dm.id 
                ORDER BY sp.ngay_nhap DESC 
                LIMIT :limit
            ");
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }

    // Lấy sách bán chạy
    public function getPopularBooks($limit = 5)
    {
        try {
            $stmt = $this->conn->prepare("
                SELECT sp.*, dm.ten_danh_muc 
                FROM san_phams sp 
                LEFT JOIN danh_mucs dm ON sp.danh_muc_id = dm.id 
                ORDER BY sp.luot_xem DESC 
                LIMIT :limit
            ");
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }

    // Lấy tất cả sách
    public function getAllBooks()
    {
        try {
            $stmt = $this->conn->query("
                SELECT sp.*, dm.ten_danh_muc 
                FROM san_phams sp 
                LEFT JOIN danh_mucs dm ON sp.danh_muc_id = dm.id 
                ORDER BY sp.id DESC
            ");
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }

    // Lấy danh mục
    public function getCategories()
    {
        try {
            $stmt = $this->conn->query("
                SELECT dm.*, COUNT(sp.id) as book_count 
                FROM danh_mucs dm 
                LEFT JOIN san_phams sp ON dm.id = sp.danh_muc_id 
                GROUP BY dm.id 
                ORDER BY dm.ten_danh_muc
            ");
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }

    // Lấy sách theo ID
    public function getBookById($id)
    {
        try {
            $stmt = $this->conn->prepare("
                SELECT sp.*, dm.ten_danh_muc 
                FROM san_phams sp 
                LEFT JOIN danh_mucs dm ON sp.danh_muc_id = dm.id 
                WHERE sp.id = :id
            ");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch();
        } catch (Exception $e) {
            return false;
        }
    }

    // Thêm sách
    public function addBook($data)
    {
        try {
            $stmt = $this->conn->prepare("
                INSERT INTO san_phams (
                    ten_san_pham, gia_san_pham, gia_khuyen_mai, hinh_anh, 
                    so_luong, luot_xem, ngay_nhap, mo_ta, danh_muc_id, trang_thai
                ) VALUES (
                    :ten_san_pham, :gia_san_pham, :gia_khuyen_mai, :hinh_anh,
                    :so_luong, 0, NOW(), :mo_ta, :danh_muc_id, :trang_thai
                )
            ");
            return $stmt->execute([
                ':ten_san_pham' => $data['ten_san_pham'],
                ':gia_san_pham' => $data['gia_san_pham'],
                ':gia_khuyen_mai' => $data['gia_khuyen_mai'],
                ':hinh_anh' => $data['hinh_anh'],
                ':so_luong' => $data['so_luong'],
                ':mo_ta' => $data['mo_ta'],
                ':danh_muc_id' => $data['danh_muc_id'],
                ':trang_thai' => $data['trang_thai']
            ]);
        } catch (Exception $e) {
            return false;
        }
    }

    // Cập nhật sách
    public function updateBook($id, $data)
    {
        try {
            $stmt = $this->conn->prepare("
                UPDATE san_phams SET 
                    ten_san_pham = :ten_san_pham,
                    gia_san_pham = :gia_san_pham,
                    gia_khuyen_mai = :gia_khuyen_mai,
                    hinh_anh = :hinh_anh,
                    so_luong = :so_luong,
                    mo_ta = :mo_ta,
                    danh_muc_id = :danh_muc_id,
                    trang_thai = :trang_thai
                WHERE id = :id
            ");
            return $stmt->execute([
                ':id' => $id,
                ':ten_san_pham' => $data['ten_san_pham'],
                ':gia_san_pham' => $data['gia_san_pham'],
                ':gia_khuyen_mai' => $data['gia_khuyen_mai'],
                ':hinh_anh' => $data['hinh_anh'],
                ':so_luong' => $data['so_luong'],
                ':mo_ta' => $data['mo_ta'],
                ':danh_muc_id' => $data['danh_muc_id'],
                ':trang_thai' => $data['trang_thai']
            ]);
        } catch (Exception $e) {
            return false;
        }
    }

    // Xóa sách
    public function deleteBook($id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM san_phams WHERE id = :id");
            return $stmt->execute([':id' => $id]);
        } catch (Exception $e) {
            return false;
        }
    }

    // Thêm sách mẫu hàng loạt
    public function addSampleBooks()
    {
        try {
            $sampleBooks = [
                [
                    'ten_san_pham' => 'Đắc Nhân Tâm',
                    'gia_san_pham' => 89000,
                    'gia_khuyen_mai' => 69000,
                    'hinh_anh' => 'dac-nhan-tam.jpg',
                    'so_luong' => 50,
                    'mo_ta' => 'Cuốn sách kinh điển về nghệ thuật giao tiếp và ứng xử của Dale Carnegie.',
                    'danh_muc_id' => 1,
                    'trang_thai' => 1
                ],
                [
                    'ten_san_pham' => 'Nhà Giả Kim',
                    'gia_san_pham' => 79000,
                    'gia_khuyen_mai' => 59000,
                    'hinh_anh' => 'nha-gia-kim.jpg',
                    'so_luong' => 30,
                    'mo_ta' => 'Tiểu thuyết nổi tiếng của Paulo Coelho về hành trình tìm kiếm kho báu.',
                    'danh_muc_id' => 1,
                    'trang_thai' => 1
                ],
                [
                    'ten_san_pham' => 'Tôi Thấy Hoa Vàng Trên Cỏ Xanh',
                    'gia_san_pham' => 65000,
                    'gia_khuyen_mai' => 45000,
                    'hinh_anh' => 'hoa-vang-co-xanh.jpg',
                    'so_luong' => 40,
                    'mo_ta' => 'Tiểu thuyết của Nguyễn Nhật Ánh về tuổi thơ dữ dội.',
                    'danh_muc_id' => 1,
                    'trang_thai' => 1
                ],
                [
                    'ten_san_pham' => 'One Piece - Tập 1',
                    'gia_san_pham' => 25000,
                    'gia_khuyen_mai' => 22000,
                    'hinh_anh' => 'one-piece-tap-1.jpg',
                    'so_luong' => 200,
                    'mo_ta' => 'Manga nổi tiếng của Eiichiro Oda về băng hải tặc Mũ Rơm.',
                    'danh_muc_id' => 3,
                    'trang_thai' => 1
                ],
                [
                    'ten_san_pham' => 'Lập Trình Web với PHP',
                    'gia_san_pham' => 299000,
                    'gia_khuyen_mai' => 249000,
                    'hinh_anh' => 'lap-trinh-php.jpg',
                    'so_luong' => 15,
                    'mo_ta' => 'Sách hướng dẫn lập trình web từ cơ bản đến nâng cao.',
                    'danh_muc_id' => 4,
                    'trang_thai' => 1
                ]
            ];

            $stmt = $this->conn->prepare("
                INSERT INTO san_phams (
                    ten_san_pham, gia_san_pham, gia_khuyen_mai, hinh_anh,
                    so_luong, luot_xem, ngay_nhap, mo_ta, danh_muc_id, trang_thai
                ) VALUES (
                    :ten_san_pham, :gia_san_pham, :gia_khuyen_mai, :hinh_anh,
                    :so_luong, 0, NOW(), :mo_ta, :danh_muc_id, :trang_thai
                )
            ");

            $count = 0;
            foreach ($sampleBooks as $book) {
                try {
                    $stmt->execute([
                        ':ten_san_pham' => $book['ten_san_pham'],
                        ':gia_san_pham' => $book['gia_san_pham'],
                        ':gia_khuyen_mai' => $book['gia_khuyen_mai'],
                        ':hinh_anh' => $book['hinh_anh'],
                        ':so_luong' => $book['so_luong'],
                        ':mo_ta' => $book['mo_ta'],
                        ':danh_muc_id' => $book['danh_muc_id'],
                        ':trang_thai' => $book['trang_thai']
                    ]);
                    $count++;
                } catch (Exception $e) {
                    // Skip duplicate entries
                }
            }

            return ['success' => true, 'count' => $count];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    // Thêm danh mục
    public function addCategory($data)
    {
        try {
            $sql = "INSERT INTO danh_mucs (ten_danh_muc, mo_ta, trang_thai, ngay_tao) VALUES (?, ?, 1, NOW())";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                $data['ten_danh_muc'],
                $data['mo_ta'] ?? ''
            ]);
        } catch (Exception $e) {
            error_log("Error adding category: " . $e->getMessage());
            return false;
        }
    }

    // Cập nhật danh mục
    public function updateCategory($id, $data)
    {
        try {
            $sql = "UPDATE danh_mucs SET ten_danh_muc = ?, mo_ta = ?, ngay_sua = NOW() WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                $data['ten_danh_muc'],
                $data['mo_ta'] ?? '',
                $id
            ]);
        } catch (Exception $e) {
            error_log("Error updating category: " . $e->getMessage());
            return false;
        }
    }

    // Xóa danh mục (chỉ khi không có sản phẩm)
    public function deleteCategory($id)
    {
        try {
            // Kiểm tra xem có sản phẩm nào thuộc danh mục này không
            $stmt = $this->conn->prepare("SELECT COUNT(*) FROM san_phams WHERE danh_muc_id = ?");
            $stmt->execute([$id]);
            $count = $stmt->fetchColumn();
            
            if ($count > 0) {
                return false; // Không thể xóa vì còn sản phẩm
            }
            
            $sql = "DELETE FROM danh_mucs WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$id]);
        } catch (Exception $e) {
            error_log("Error deleting category: " . $e->getMessage());
            return false;
        }
    }

    // Thêm danh mục mẫu
    public function addSampleCategories()
    {
        $sampleCategories = [
            ['ten_danh_muc' => 'Văn học Việt Nam', 'mo_ta' => 'Tác phẩm văn học của các tác giả Việt Nam'],
            ['ten_danh_muc' => 'Văn học nước ngoài', 'mo_ta' => 'Tác phẩm văn học được dịch từ nước ngoài'],
            ['ten_danh_muc' => 'Kinh tế - Quản lý', 'mo_ta' => 'Sách về kinh tế, quản lý, đầu tư'],
            ['ten_danh_muc' => 'Công nghệ thông tin', 'mo_ta' => 'Sách về lập trình, công nghệ, kỹ thuật'],
            ['ten_danh_muc' => 'Khoa học tự nhiên', 'mo_ta' => 'Sách về toán, lý, hóa, sinh học'],
            ['ten_danh_muc' => 'Lịch sử - Địa lý', 'mo_ta' => 'Sách về lịch sử và địa lý'],
            ['ten_danh_muc' => 'Tâm lý - Kỹ năng sống', 'mo_ta' => 'Sách về tâm lý học và phát triển bản thân'],
            ['ten_danh_muc' => 'Thiếu nhi', 'mo_ta' => 'Sách dành cho trẻ em và thiếu niên'],
            ['ten_danh_muc' => 'Sách giáo khoa', 'mo_ta' => 'Sách giáo khoa và tham khảo'],
            ['ten_danh_muc' => 'Y học - Sức khỏe', 'mo_ta' => 'Sách về y học và chăm sóc sức khỏe']
        ];

        $added = 0;
        foreach ($sampleCategories as $category) {
            // Kiểm tra xem danh mục đã tồn tại chưa
            $stmt = $this->conn->prepare("SELECT COUNT(*) FROM danh_mucs WHERE ten_danh_muc = ?");
            $stmt->execute([$category['ten_danh_muc']]);
            
            if ($stmt->fetchColumn() == 0) {
                if ($this->addCategory($category)) {
                    $added++;
                }
            }
        }

        return $added;
    }

    // Lấy danh mục với số lượng sản phẩm
    public function getCategoriesWithBookCount()
    {
        try {
            $sql = "
                SELECT dm.*, COUNT(sp.id) as so_san_pham
                FROM danh_mucs dm
                LEFT JOIN san_phams sp ON dm.id = sp.danh_muc_id
                GROUP BY dm.id
                ORDER BY dm.ten_danh_muc ASC
            ";
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            error_log("Error getting categories with book count: " . $e->getMessage());
            return [];
        }
    }    // Lấy thống kê chatbot
    public function getChatbotStats()
    {
        try {
            $stats = [];
            
            // Tổng số tin nhắn
            $stmt = $this->conn->query("SELECT COUNT(*) as total FROM chat_history");
            $stats['total_messages'] = (int)$stmt->fetchColumn() ?: 0;
            
            // Số người dùng unique
            $stmt = $this->conn->query("SELECT COUNT(DISTINCT user_id) as total FROM chat_history WHERE user_id IS NOT NULL");
            $stats['unique_users'] = (int)$stmt->fetchColumn() ?: 0;
            
            // Tin nhắn hôm nay
            $stmt = $this->conn->query("SELECT COUNT(*) as today FROM chat_history WHERE DATE(created_at) = CURDATE()");
            $stats['today_messages'] = (int)$stmt->fetchColumn() ?: 0;
            
            // Thời gian phản hồi trung bình (giả lập)
            $stats['avg_response_time'] = rand(300, 600);
            
            // Hoạt động 7 ngày qua
            $stmt = $this->conn->query("
                SELECT DATE(created_at) as date, COUNT(*) as count 
                FROM chat_history 
                WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY) 
                GROUP BY DATE(created_at) 
                ORDER BY date DESC
            ");
            $dailyActivity = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Đảm bảo có đủ 7 ngày
            $stats['daily_activity'] = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = date('Y-m-d', strtotime("-$i days"));
                $found = false;
                foreach ($dailyActivity as $activity) {
                    if ($activity['date'] === $date) {
                        $stats['daily_activity'][] = [
                            'date' => date('d/m', strtotime($date)),
                            'count' => (int)$activity['count']
                        ];
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $stats['daily_activity'][] = [
                        'date' => date('d/m', strtotime($date)),
                        'count' => 0
                    ];
                }
            }
            
            return $stats;
        } catch (Exception $e) {
            error_log("AdminBookManager getChatbotStats error: " . $e->getMessage());
            return [
                'total_messages' => 0,
                'unique_users' => 0,
                'today_messages' => 0,
                'avg_response_time' => 0,
                'daily_activity' => []
            ];
        }
    }// Lấy chat gần đây
    public function getRecentChats($limit = 20)
    {
        try {
            $stmt = $this->conn->prepare("
                SELECT 
                    user_id,
                    user_message as message,
                    bot_response,
                    created_at,
                    'user' as message_type,
                    NULL as response_time
                FROM chat_history 
                ORDER BY created_at DESC 
                LIMIT :limit
            ");
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            
            $results = [];
            $chats = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Tạo format dữ liệu cho hiển thị
            foreach ($chats as $chat) {
                // Thêm tin nhắn user
                $results[] = [
                    'user_id' => $chat['user_id'],
                    'message' => $chat['message'],
                    'message_type' => 'user',
                    'created_at' => $chat['created_at'],
                    'response_time' => null
                ];
                
                // Thêm phản hồi bot nếu có
                if (!empty($chat['bot_response'])) {
                    $results[] = [
                        'user_id' => $chat['user_id'],
                        'message' => $chat['bot_response'],
                        'message_type' => 'bot',
                        'created_at' => $chat['created_at'],
                        'response_time' => rand(200, 800) // Simulate response time
                    ];
                }
            }
            
            // Sắp xếp lại theo thời gian và giới hạn số lượng
            usort($results, function($a, $b) {
                return strtotime($b['created_at']) - strtotime($a['created_at']);
            });
            
            return array_slice($results, 0, $limit);
            
        } catch (Exception $e) {
            error_log("AdminBookManager getRecentChats error: " . $e->getMessage());
            return [];
        }
    }    // Lấy câu hỏi phổ biến
    public function getPopularQueries()
    {
        try {
            $stmt = $this->conn->query("
                SELECT 
                    user_message as message, 
                    COUNT(*) as count,
                    ROUND((COUNT(*) * 100.0) / (SELECT COUNT(*) FROM chat_history WHERE user_message IS NOT NULL), 2) as percentage
                FROM chat_history 
                WHERE user_message IS NOT NULL AND user_message != ''
                GROUP BY LOWER(user_message) 
                ORDER BY count DESC 
                LIMIT 10
            ");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Đảm bảo tất cả có đủ key cần thiết
            return array_map(function($item) {
                return [
                    'message' => $item['message'] ?? 'N/A',
                    'count' => (int)($item['count'] ?? 0),
                    'percentage' => (float)($item['percentage'] ?? 0)
                ];
            }, $results);
            
        } catch (Exception $e) {
            error_log("AdminBookManager getPopularQueries error: " . $e->getMessage());
            return [];
        }
    }

    // Xóa lịch sử chat
    public function clearChatHistory($days)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM chat_history WHERE created_at < DATE_SUB(NOW(), INTERVAL :days DAY)");
            $stmt->execute([':days' => $days]);
            return $stmt->rowCount();
        } catch (Exception $e) {
            return false;
        }
    }
}
?>
