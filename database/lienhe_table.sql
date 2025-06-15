-- Contact Management Database Table
-- Run this SQL to create the contact table and sample data

CREATE TABLE IF NOT EXISTS `lienhe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT 'Tên người liên hệ',
  `email` varchar(255) NOT NULL COMMENT 'Email người liên hệ',
  `phone` varchar(20) NULL COMMENT 'Số điện thoại',
  `subject` varchar(500) NULL COMMENT 'Tiêu đề liên hệ',
  `message` text NOT NULL COMMENT 'Nội dung liên hệ',
  `status` enum('pending','read','replied','closed') NOT NULL DEFAULT 'pending' COMMENT 'Trạng thái xử lý',
  `priority` enum('low','normal','high','urgent') NOT NULL DEFAULT 'normal' COMMENT 'Mức độ ưu tiên',
  `reply_message` text NULL COMMENT 'Nội dung phản hồi',
  `replied_by` int(11) NULL COMMENT 'ID admin phản hồi',
  `replied_at` datetime NULL COMMENT 'Thời gian phản hồi',
  `ip_address` varchar(45) NULL COMMENT 'Địa chỉ IP người gửi',
  `user_agent` text NULL COMMENT 'Thông tin trình duyệt',
  `is_read` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Đã đọc chưa',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Thời gian tạo',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Thời gian cập nhật',
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_priority` (`priority`),
  KEY `idx_is_read` (`is_read`),
  KEY `idx_created_at` (`created_at`),
  KEY `idx_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Bảng quản lý liên hệ từ khách hàng';

-- Insert sample data
INSERT INTO `lienhe` (`name`, `email`, `phone`, `subject`, `message`, `status`, `priority`, `ip_address`, `created_at`) VALUES
('Nguyễn Văn An', 'an.nguyen@email.com', '0901234567', 'Hỏi về sản phẩm', 'Tôi muốn tìm hiểu về sản phẩm XYZ có sẵn không?', 'pending', 'normal', '192.168.1.100', '2024-01-15 10:30:00'),
('Trần Thị Bình', 'binh.tran@email.com', '0987654321', 'Khiếu nại đơn hàng', 'Đơn hàng #12345 của tôi bị chậm trễ, xin hỗ trợ.', 'read', 'high', '192.168.1.101', '2024-01-14 14:20:00'),
('Lê Văn Cường', 'cuong.le@email.com', '0912345678', 'Yêu cầu báo giá', 'Có thể gửi báo giá cho số lượng lớn không?', 'replied', 'normal', '192.168.1.102', '2024-01-13 09:15:00'),
('Phạm Thị Dung', 'dung.pham@email.com', '0923456789', 'Hỗ trợ kỹ thuật', 'Sản phẩm bị lỗi sau khi mua 1 tuần.', 'pending', 'urgent', '192.168.1.103', '2024-01-12 16:45:00'),
('Hoàng Văn Em', 'em.hoang@email.com', '0934567890', 'Góp ý cải thiện', 'Website rất tốt nhưng cần cải thiện tốc độ tải.', 'closed', 'low', '192.168.1.104', '2024-01-11 11:30:00');
