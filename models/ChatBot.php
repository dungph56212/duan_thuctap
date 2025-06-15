<?php
// models/ChatBot.php

class ChatBot {
    public $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    /**
     * Lưu tin nhắn vào database
     */
    public function saveMessage($user_id, $message, $response, $session_id = null) {
        try {
            $sql = "INSERT INTO chat_history (user_id, user_message, bot_response, session_id, created_at) 
                    VALUES (:user_id, :user_message, :bot_response, :session_id, NOW())";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':user_id' => $user_id,
                ':user_message' => $message,
                ':bot_response' => $response,
                ':session_id' => $session_id
            ]);
            
            return $this->conn->lastInsertId();
        } catch (Exception $e) {
            error_log("ChatBot saveMessage error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Lấy lịch sử chat của user
     */
    public function getChatHistory($user_id, $session_id = null, $limit = 50) {
        try {
            $sql = "SELECT * FROM chat_history 
                    WHERE user_id = :user_id";
            
            $params = [':user_id' => $user_id];
            
            if ($session_id) {
                $sql .= " AND session_id = :session_id";
                $params[':session_id'] = $session_id;
            }
            
            $sql .= " ORDER BY created_at ASC LIMIT :limit";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            if ($session_id) {
                $stmt->bindValue(':session_id', $session_id, PDO::PARAM_STR);
            }
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll();
        } catch (Exception $e) {
            error_log("ChatBot getChatHistory error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Tạo session ID mới
     */
    public function generateSessionId() {
        return 'chat_' . time() . '_' . rand(1000, 9999);
    }    /**
     * Bot AI nâng cao với tích hợp database và nhiều pattern hơn
     */
    public function getResponse($message, $user_id = null) {
        $message = strtolower(trim($message));
        
        // Kiểm tra xem có tìm kiếm sản phẩm cụ thể không
        if ($productInfo = $this->searchProductInfo($message)) {
            return $productInfo;
        }
        
        // Các pattern và response nâng cao
        $patterns = [
            // Chào hỏi
            '/^(xin chào|chào|hello|hi|hey|xin chao)/' => [
                'Xin chào! Tôi là trợ lý ảo của cửa hàng sách. Tôi có thể giúp gì cho bạn? 📚',
                'Chào bạn! Cần tôi hỗ trợ tìm sách hoặc thông tin gì không? 😊',
                'Hello! Tôi sẵn sàng giúp bạn tìm kiếm sách và thông tin cần thiết!'
            ],
            
            // Hỏi về sản phẩm/sách
            '/(sản phẩm|product|hàng hóa|sách|book|truyện|tiểu thuyết)/' => [
                'Cửa hàng chúng tôi có rất nhiều loại sách: tiểu thuyết, sách giáo khoa, truyện tranh, sách chuyên ngành... Bạn đang tìm loại sách nào?',
                'Bạn có thể cho tôi biết tên sách hoặc thể loại bạn quan tâm để tôi tìm giúp bạn!',
                'Chúng tôi có đầy đủ các thể loại sách từ văn học đến khoa học. Bạn muốn tìm sách gì cụ thể không?'
            ],
            
            // Hỏi về giá
            '/(giá|price|cost|tiền|bao nhiêu|giá cả)/' => [
                'Giá sách của chúng tôi rất cạnh tranh từ 50k-500k tùy loại. Bạn có thể cho tôi biết tên sách để tôi báo giá chính xác?',
                'Chúng tôi có nhiều mức giá khác nhau. Sách giáo khoa từ 30k, tiểu thuyết từ 80k, sách chuyên ngành từ 150k.',
                'Để biết giá chính xác, bạn có thể cho tôi biết tên sách cụ thể nhé!'
            ],
            
            // Hỏi về giao hàng
            '/(giao hàng|ship|delivery|vận chuyển|nhận hàng)/' => [
                'Chúng tôi hỗ trợ giao hàng toàn quốc trong 1-3 ngày. Nội thành Hà Nội/HCM giao trong ngày!',
                'Phí ship: 30k nội thành, 50k ngoại thành. Miễn phí ship cho đơn hàng từ 300k trở lên!',
                'Bạn có thể chọn giao hàng nhanh (1 ngày) hoặc tiêu chuẩn (2-3 ngày) tùy nhu cầu.'
            ],
            
            // Hỏi về thanh toán
            '/(thanh toán|payment|pay|trả tiền|atm|visa)/' => [
                'Chúng tôi nhận thanh toán: COD (tiền mặt), chuyển khoản, thẻ ATM/Visa, ví điện tử (Momo, ZaloPay).',
                'Thanh toán online được giảm 2% so với COD. Bạn có thể chọn hình thức thuận tiện nhất!',
                'Hỗ trợ trả góp qua thẻ tín dụng cho đơn hàng từ 1 triệu trở lên.'
            ],
            
            // Hỏi về khuyến mãi
            '/(khuyến mãi|giảm giá|discount|sale|promotion|ưu đãi)/' => [
                '🎉 Hiện tại đang có khuyến mãi mua 3 tặng 1, giảm 20% cho sinh viên, miễn ship đơn từ 300k!',
                'Chương trình "Tháng sách hay" giảm 30% tất cả sách văn học. Áp dụng đến hết tháng này!',
                'Đăng ký thành viên VIP để nhận ưu đãi độc quyền và tích điểm đổi quà!'
            ],
            
            // Hỏi về liên hệ
            '/(liên hệ|contact|hỗ trợ|support|hotline|địa chỉ)/' => [
                '📞 Hotline: 1900-123-456 (24/7)\n📧 Email: support@sachviet.com\n🏪 Địa chỉ: 123 Nguyễn Huệ, Q1, TP.HCM',
                'Bạn có thể chat trực tiếp với tôi hoặc gọi hotline để được hỗ trợ nhanh chóng nhất!',
                'Cửa hàng mở cửa từ 8h-22h hàng ngày. Chúng tôi luôn sẵn sàng hỗ trợ bạn!'
            ],
            
            // Hỏi về danh mục sách
            '/(thể loại|danh mục|loại sách|category|genre)/' => [
                '📚 Chúng tôi có các thể loại: Văn học, Kinh tế, Khoa học, Giáo dục, Thiếu nhi, Truyện tranh, Sách ngoại ngữ...',
                'Bạn quan tâm thể loại nào? Tôi có thể gợi ý những cuốn hay trong từng lĩnh vực!',
                'Sách bán chạy nhất hiện tại: Tiểu thuyết tình cảm, Sách kỹ năng sống, Truyện tranh Nhật Bản.'
            ],
            
            // Hỏi về tác giả
            '/(tác giả|author|nhà văn|người viết)/' => [
                'Chúng tôi có sách của nhiều tác giả nổi tiếng: Nguyễn Nhật Ánh, Tô Hoài, Paulo Coelho, Haruki Murakami...',
                'Bạn đang tìm sách của tác giả nào cụ thể? Tôi có thể giới thiệu những tác phẩm hay nhất!',
                'Có thể tìm sách theo tên tác giả bằng chức năng tìm kiếm trên website.'
            ],
            
            // Hỏi về sách mới
            '/(mới|new|ra mắt|xuất bản|latest)/' => [
                '🆕 Sách mới nhất: "Cà phê cùng Tony" - Kỹ năng lãnh đạo, "Thế giới phẳng" - Kinh tế toàn cầu...',
                'Mỗi tuần chúng tôi cập nhật 20-30 đầu sách mới. Theo dõi fanpage để không bỏ lỡ!',
                'Bạn có thể đăng ký nhận thông báo khi có sách mới theo thể loại yêu thích.'
            ],
            
            // Hỏi về tình trạng sách
            '/(còn hàng|hết hàng|availability|stock|kho)/' => [
                'Hầu hết sách đều còn hàng. Bạn có thể cho tôi tên sách để kiểm tra tình trạng cụ thể?',
                'Sách hết hàng sẽ được đặt trước và giao trong 3-5 ngày khi có hàng mới.',
                'Chúng tôi cập nhật tình trạng kho hàng real-time trên website.'
            ],
            
            // Hỏi về đổi trả
            '/(đổi|trả|return|exchange|bảo hành)/' => [
                '📝 Chính sách đổi trả: 7 ngày không lý do, sách còn nguyên tem và không hư hỏng.',
                'Miễn phí đổi trả nếu sách bị lỗi in ấn hoặc thiếu trang.',
                'Sách điện tử không hỗ trợ đổi trả sau khi đã tải về.'
            ],
            
            // Cảm ơn
            '/(cảm ơn|thank|thanks|cám ơn|tks)/' => [
                'Rất vui được hỗ trợ bạn! Chúc bạn tìm được những cuốn sách tuyệt vời! 📖✨',
                'Không có gì! Hãy ghé thăm cửa hàng và chat với tôi bất cứ khi nào nhé! 😊',
                'Cảm ơn bạn đã tin tưởng! Hy vọng bạn có những trải nghiệm đọc sách thú vị!'
            ],
            
            // Tạm biệt
            '/(tạm biệt|bye|goodbye|chào tạm biệt|bb)/' => [
                'Tạm biệt! Hẹn gặp lại bạn sớm! Chúc bạn có một ngày tuyệt vời! 👋',
                'Bye bye! Đừng quên ghé thăm cửa hàng sách nhé! 📚💕',
                'Chúc bạn một ngày tốt lành! Hẹn gặp lại trong những chuyến phiêu lưu sách tiếp theo!'
            ],
            
            // Hỏi về website/app
            '/(website|app|ứng dụng|trang web|online)/' => [
                '💻 Website: www.sachviet.com - Giao diện thân thiện, tìm kiếm nhanh chóng!',
                '📱 App mobile: "SachViet" trên App Store và Google Play với nhiều tính năng độc quyền!',
                'Mua sách online được tích điểm, đọc thử miễn phí và nhận thông báo sách mới.'
            ]
        ];
        
        // Tìm pattern phù hợp
        foreach ($patterns as $pattern => $responses) {
            if (preg_match($pattern, $message)) {
                return $responses[array_rand($responses)];
            }
        }
        
        // Nếu không tìm thấy pattern, thử tìm kiếm thông minh hơn
        $smartResponse = $this->getSmartResponse($message);
        if ($smartResponse) {
            return $smartResponse;
        }
        
        // Nếu không tìm thấy pattern phù hợp, trả về câu trả lời mặc định
        $defaultResponses = [
            'Xin lỗi, tôi chưa hiểu rõ câu hỏi của bạn. Bạn có thể hỏi về: sách, giá cả, giao hàng, khuyến mãi, hoặc liên hệ? 🤔',
            'Tôi có thể giúp bạn tìm sách, kiểm tra giá, thông tin giao hàng và khuyến mãi. Bạn cần hỗ trợ gì cụ thể?',
            'Câu hỏi hay đấy! Tôi đang học hỏi thêm. Hiện tại tôi có thể tư vấn về sách, giá cả, và dịch vụ. Bạn thử hỏi nhé! 😊',
            'Hmm, chưa rõ lắm. Bạn có thể hỏi kiểu như: "Có sách gì hay?", "Giá sách bao nhiêu?", "Giao hàng thế nào?" nhé!'
        ];
        
        return $defaultResponses[array_rand($defaultResponses)];
    }

    /**
     * Tích hợp OpenAI API (nếu có API key)
     */
    public function getOpenAIResponse($message, $user_id = null) {
        // Bạn cần có OpenAI API key để sử dụng tính năng này
        $apiKey = ''; // Thêm API key của bạn vào đây
        
        if (empty($apiKey)) {
            return $this->getResponse($message, $user_id);
        }
        
        try {
            $url = 'https://api.openai.com/v1/chat/completions';
            
            $data = [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Bạn là trợ lý ảo của một cửa hàng bán hàng online. Hãy trả lời một cách thân thiện và hữu ích bằng tiếng Việt.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $message
                    ]
                ],
                'max_tokens' => 150,
                'temperature' => 0.7
            ];
            
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $apiKey
            ]);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            if ($httpCode === 200) {
                $result = json_decode($response, true);
                if (isset($result['choices'][0]['message']['content'])) {
                    return trim($result['choices'][0]['message']['content']);
                }
            }
            
            // Fallback nếu API fails
            return $this->getResponse($message, $user_id);
            
        } catch (Exception $e) {
            error_log("OpenAI API error: " . $e->getMessage());
            return $this->getResponse($message, $user_id);
        }
    }

    /**
     * Xóa lịch sử chat cũ (để cleanup database)
     */
    public function cleanupOldChats($days = 30) {
        try {
            $sql = "DELETE FROM chat_history WHERE created_at < DATE_SUB(NOW(), INTERVAL :days DAY)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':days' => $days]);
            
            return $stmt->rowCount();
        } catch (Exception $e) {
            error_log("ChatBot cleanup error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Lấy thống kê chat bot cho admin
     */
    public function getChatStats() {
        try {
            $stats = [];
            
            // Tổng số tin nhắn
            $sql = "SELECT COUNT(*) as total_messages FROM chat_history";
            $stmt = $this->conn->query($sql);
            $stats['total_messages'] = $stmt->fetchColumn();
            
            // Số người dùng đã chat
            $sql = "SELECT COUNT(DISTINCT user_id) as total_users FROM chat_history";
            $stmt = $this->conn->query($sql);
            $stats['total_users'] = $stmt->fetchColumn();
            
            // Tin nhắn hôm nay
            $sql = "SELECT COUNT(*) as today_messages FROM chat_history WHERE DATE(created_at) = CURDATE()";
            $stmt = $this->conn->query($sql);
            $stats['today_messages'] = $stmt->fetchColumn();
            
            // Tin nhắn tuần này
            $sql = "SELECT COUNT(*) as week_messages FROM chat_history WHERE YEARWEEK(created_at) = YEARWEEK(NOW())";
            $stmt = $this->conn->query($sql);
            $stats['week_messages'] = $stmt->fetchColumn();
            
            return $stats;
        } catch (Exception $e) {
            error_log("ChatBot stats error: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Tìm kiếm thông tin sản phẩm từ database
     */
    public function searchProductInfo($message) {
        try {
            // Tìm kiếm sản phẩm theo tên
            $sql = "SELECT san_phams.*, danh_mucs.ten_danh_muc 
                    FROM san_phams 
                    INNER JOIN danh_mucs ON san_phams.danh_muc_id = danh_mucs.id 
                    WHERE LOWER(san_phams.ten_san_pham) LIKE :search 
                    OR LOWER(danh_mucs.ten_danh_muc) LIKE :search
                    ORDER BY san_phams.luot_xem DESC 
                    LIMIT 3";
            
            $stmt = $this->conn->prepare($sql);
            $search = '%' . $message . '%';
            $stmt->execute([':search' => $search]);
            $products = $stmt->fetchAll();
            
            if (!empty($products)) {
                $response = "🔍 Tôi tìm thấy những sản phẩm này cho bạn:\n\n";
                foreach ($products as $product) {
                    $price = $product['gia_khuyen_mai'] ? 
                        number_format($product['gia_khuyen_mai']) . 'đ (Giảm từ ' . number_format($product['gia_san_pham']) . 'đ)' : 
                        number_format($product['gia_san_pham']) . 'đ';
                    
                    $response .= "📚 " . $product['ten_san_pham'] . "\n";
                    $response .= "💰 Giá: " . $price . "\n";
                    $response .= "📁 Thể loại: " . $product['ten_danh_muc'] . "\n";
                    $response .= "👀 Lượt xem: " . number_format($product['luot_xem']) . "\n\n";
                }
                $response .= "Bạn có muốn biết thêm thông tin về sản phẩm nào không? 😊";
                return $response;
            }
            
            // Nếu không tìm thấy sản phẩm cụ thể, thử tìm theo danh mục
            $categories = $this->searchByCategory($message);
            if ($categories) {
                return $categories;
            }
            
            return null;
        } catch (Exception $e) {
            error_log("ChatBot searchProductInfo error: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Tìm kiếm theo danh mục
     */
    private function searchByCategory($message) {
        try {
            $sql = "SELECT COUNT(*) as total, danh_mucs.ten_danh_muc 
                    FROM san_phams 
                    INNER JOIN danh_mucs ON san_phams.danh_muc_id = danh_mucs.id 
                    WHERE LOWER(danh_mucs.ten_danh_muc) LIKE :search 
                    GROUP BY danh_mucs.id, danh_mucs.ten_danh_muc";
            
            $stmt = $this->conn->prepare($sql);
            $search = '%' . $message . '%';
            $stmt->execute([':search' => $search]);
            $categories = $stmt->fetchAll();
            
            if (!empty($categories)) {
                $response = "📚 Tôi tìm thấy các danh mục phù hợp:\n\n";
                foreach ($categories as $cat) {
                    $response .= "📁 " . $cat['ten_danh_muc'] . " (" . $cat['total'] . " sản phẩm)\n";
                }
                $response .= "\nBạn có muốn xem sản phẩm trong danh mục nào không?";
                return $response;
            }
            
            return null;
        } catch (Exception $e) {
            error_log("ChatBot searchByCategory error: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Trả lời thông minh dựa trên từ khóa
     */
    public function getSmartResponse($message) {
        // Kiểm tra các từ khóa thường gặp
        $keywords = [
            'tìm' => 'Bạn đang tìm gì? Tôi có thể giúp bạn tìm sách theo tên, tác giả, hoặc thể loại.',
            'có' => 'Bạn muốn hỏi chúng tôi có gì đó không? Hãy nói cụ thể hơn nhé!',
            'bao nhiêu' => 'Bạn muốn hỏi về giá cả? Cho tôi biết tên sản phẩm để báo giá chính xác.',
            'khi nào' => 'Bạn muốn biết thời gian giao hàng? Thông thường là 1-3 ngày làm việc.',
            'ở đâu' => 'Cửa hàng tại 123 Nguyễn Huệ, Q1, TP.HCM. Hoặc bạn có thể mua online!',
            'làm sao' => 'Bạn cần hướng dẫn gì? Đặt hàng, thanh toán, hay sử dụng website?',
            'tại sao' => 'Bạn có thắc mắc gì về sản phẩm hoặc dịch vụ? Tôi sẽ giải thích chi tiết!',
            'nên' => 'Bạn cần tư vấn? Tôi có thể gợi ý sách phù hợp với sở thích của bạn!',
            'top' => 'Bạn muốn biết sách bán chạy? Hiện tại có: "Đắc Nhân Tâm", "Nhà Giả Kim", "Tôi Thấy Hoa Vàng Trên Cỏ Xanh"...',
            'mua' => 'Để mua sách, bạn có thể đặt hàng online hoặc đến cửa hàng trực tiếp. Cần hỗ trợ gì không?'
        ];
        
        foreach ($keywords as $keyword => $response) {
            if (strpos($message, $keyword) !== false) {
                return $response;
            }
        }
        
        // Kiểm tra số lượng từ trong tin nhắn
        $wordCount = str_word_count($message);
        if ($wordCount >= 5) {
            return 'Tôi hiểu bạn đang cần tư vấn chi tiết. Bạn có thể gọi hotline 1900-123-456 để được hỗ trợ trực tiếp nhé!';
        }
        
        return null;
    }
    
    /**
     * Lấy sản phẩm bán chạy
     */
    public function getPopularProducts($limit = 5) {
        try {
            $sql = "SELECT san_phams.*, danh_mucs.ten_danh_muc 
                    FROM san_phams 
                    INNER JOIN danh_mucs ON san_phams.danh_muc_id = danh_mucs.id 
                    ORDER BY san_phams.luot_xem DESC 
                    LIMIT :limit";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            error_log("ChatBot getPopularProducts error: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Lấy danh mục sản phẩm
     */
    public function getCategories() {
        try {
            $sql = "SELECT danh_mucs.*, COUNT(san_phams.id) as product_count 
                    FROM danh_mucs 
                    LEFT JOIN san_phams ON danh_mucs.id = san_phams.danh_muc_id 
                    GROUP BY danh_mucs.id 
                    ORDER BY product_count DESC";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            error_log("ChatBot getCategories error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Lấy danh sách chat gần đây cho admin
     */
    public function getRecentChats($limit = 20) {
        try {
            $sql = "SELECT 
                        user_id,
                        user_message as message,
                        bot_response,
                        created_at,
                        'user' as message_type,
                        NULL as response_time
                    FROM chat_history 
                    ORDER BY created_at DESC 
                    LIMIT :limit";
            
            $stmt = $this->conn->prepare($sql);
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
            
            // Sắp xếp lại theo thời gian
            usort($results, function($a, $b) {
                return strtotime($b['created_at']) - strtotime($a['created_at']);
            });
            
            return array_slice($results, 0, $limit);
            
        } catch (Exception $e) {
            error_log("ChatBot getRecentChats error: " . $e->getMessage());
            return [];
        }
    }
}
