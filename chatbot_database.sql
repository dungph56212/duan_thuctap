-- Tạo bảng lưu trữ lịch sử chat
CREATE TABLE IF NOT EXISTS `chat_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT 0 COMMENT 'ID người dùng, 0 cho guest',
  `user_message` text NOT NULL COMMENT 'Tin nhắn của người dùng',
  `bot_response` text NOT NULL COMMENT 'Phản hồi của bot',
  `session_id` varchar(100) DEFAULT NULL COMMENT 'Session ID cho guest users',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_session_id` (`session_id`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tạo bảng cấu hình chatbot (tùy chọn)
CREATE TABLE IF NOT EXISTS `chatbot_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text,
  `description` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Thêm một số cấu hình mặc định
INSERT INTO `chatbot_settings` (`setting_key`, `setting_value`, `description`) VALUES
('chatbot_enabled', '1', 'Bật/tắt chatbot'),
('welcome_message', 'Xin chào! Tôi là trợ lý ảo của cửa hàng. Tôi có thể giúp gì cho bạn?', 'Tin nhắn chào mừng'),
('offline_message', 'Hiện tại hệ thống đang bảo trì. Vui lòng thử lại sau!', 'Tin nhắn khi chatbot offline'),
('max_message_length', '500', 'Độ dài tối đa của tin nhắn'),
('rate_limit_per_minute', '10', 'Giới hạn số tin nhắn per phút'),
('openai_api_key', '', 'OpenAI API Key (tùy chọn)'),
('bot_name', 'Trợ lý ảo', 'Tên của chatbot'),
('bot_avatar', '', 'URL avatar của bot');
