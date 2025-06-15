<?php
// controllers/ChatBotController.php
require_once __DIR__ . '/../models/ChatBot.php';

class ChatBotController {
    private $chatBotModel;

    public function __construct() {
        $this->chatBotModel = new ChatBot();
    }

    /**
     * Xử lý tin nhắn chat từ AJAX
     */
    public function sendMessage() {
        header('Content-Type: application/json');
        
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Method not allowed');
            }

            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($input['message']) || empty(trim($input['message']))) {
                throw new Exception('Message is required');
            }

            $message = trim($input['message']);
            $user_id = $_SESSION['user_id'] ?? 0; // 0 for guest users
            $session_id = $input['session_id'] ?? $this->chatBotModel->generateSessionId();

            // Validate message length
            if (strlen($message) > 500) {
                throw new Exception('Message is too long');
            }

            // Get bot response
            $bot_response = $this->chatBotModel->getResponse($message, $user_id);
            
            // Save to database
            if ($user_id > 0 || !empty($session_id)) {
                $this->chatBotModel->saveMessage($user_id, $message, $bot_response, $session_id);
            }

            echo json_encode([
                'success' => true,
                'response' => $bot_response,
                'session_id' => $session_id,
                'timestamp' => date('H:i')
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Lấy lịch sử chat
     */
    public function getChatHistory() {
        header('Content-Type: application/json');
        
        try {
            $user_id = $_SESSION['user_id'] ?? 0;
            $session_id = $_GET['session_id'] ?? null;
            
            if ($user_id == 0 && empty($session_id)) {
                echo json_encode([
                    'success' => true,
                    'history' => []
                ]);
                return;
            }

            $history = $this->chatBotModel->getChatHistory($user_id, $session_id, 20);
            
            // Format history for frontend
            $formatted_history = [];
            foreach ($history as $chat) {
                $formatted_history[] = [
                    'user_message' => $chat['user_message'],
                    'bot_response' => $chat['bot_response'],
                    'timestamp' => date('H:i', strtotime($chat['created_at']))
                ];
            }

            echo json_encode([
                'success' => true,
                'history' => $formatted_history
            ]);

        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Unable to load chat history'
            ]);
        }
    }

    /**
     * Clear chat history for current session
     */
    public function clearChat() {
        header('Content-Type: application/json');
        
        try {
            // For this simple implementation, we'll just return success
            // In a more complex system, you might want to mark messages as deleted
            echo json_encode([
                'success' => true,
                'message' => 'Chat cleared successfully'
            ]);

        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Unable to clear chat'
            ]);
        }
    }

    /**
     * Get chat statistics (for admin)
     */
    public function getStats() {
        // Only allow admin access
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            http_response_code(403);
            echo json_encode(['error' => 'Access denied']);
            return;
        }

        header('Content-Type: application/json');
        
        try {
            $stats = $this->chatBotModel->getChatStats();
            
            echo json_encode([
                'success' => true,
                'stats' => $stats
            ]);

        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Unable to load statistics'
            ]);
        }
    }

    /**
     * Test function to check if chatbot is working
     */
    public function test() {
        header('Content-Type: application/json');
        
        echo json_encode([
            'success' => true,
            'message' => 'ChatBot is working!',
            'timestamp' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Lấy sản phẩm bán chạy
     */
    public function getPopularProducts() {
        header('Content-Type: application/json');
        
        try {
            $products = $this->chatBotModel->getPopularProducts(5);
            
            echo json_encode([
                'success' => true,
                'products' => $products
            ]);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Không thể lấy danh sách sản phẩm'
            ]);
        }
    }
    
    /**
     * Lấy danh mục sản phẩm
     */
    public function getCategories() {
        header('Content-Type: application/json');
        
        try {
            $categories = $this->chatBotModel->getCategories();
            
            echo json_encode([
                'success' => true,
                'categories' => $categories
            ]);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Không thể lấy danh mục'
            ]);
        }
    }
    
    /**
     * Tìm kiếm sản phẩm
     */
    public function searchProducts() {
        header('Content-Type: application/json');
        
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            $query = $input['query'] ?? '';
            
            if (empty($query)) {
                throw new Exception('Từ khóa tìm kiếm không được để trống');
            }
            
            $result = $this->chatBotModel->searchProductInfo($query);
            
            echo json_encode([
                'success' => true,
                'result' => $result
            ]);
            
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
}
