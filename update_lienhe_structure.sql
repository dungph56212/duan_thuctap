-- Script cập nhật cấu trúc bảng lienhe
-- Chạy script này trong phpMyAdmin để thêm các cột cần thiết

-- Thêm cột phone (số điện thoại)
ALTER TABLE `lienhe` 
ADD COLUMN `phone` varchar(20) NULL COMMENT 'Số điện thoại' AFTER `email`;

-- Thêm cột subject (chủ đề)
ALTER TABLE `lienhe` 
ADD COLUMN `subject` varchar(500) NULL COMMENT 'Tiêu đề liên hệ' AFTER `phone`;

-- Thêm cột status (trạng thái)
ALTER TABLE `lienhe` 
ADD COLUMN `status` enum('pending','read','replied','closed') NOT NULL DEFAULT 'pending' COMMENT 'Trạng thái xử lý' AFTER `message`;

-- Thêm cột priority (mức độ ưu tiên)
ALTER TABLE `lienhe` 
ADD COLUMN `priority` enum('low','normal','high','urgent') NOT NULL DEFAULT 'normal' COMMENT 'Mức độ ưu tiên' AFTER `status`;

-- Thêm cột reply_message (nội dung phản hồi)
ALTER TABLE `lienhe` 
ADD COLUMN `reply_message` text NULL COMMENT 'Nội dung phản hồi' AFTER `priority`;

-- Thêm cột replied_by (ID admin phản hồi)
ALTER TABLE `lienhe` 
ADD COLUMN `replied_by` int(11) NULL COMMENT 'ID admin phản hồi' AFTER `reply_message`;

-- Thêm cột replied_at (thời gian phản hồi)
ALTER TABLE `lienhe` 
ADD COLUMN `replied_at` datetime NULL COMMENT 'Thời gian phản hồi' AFTER `replied_by`;

-- Thêm cột ip_address (địa chỉ IP)
ALTER TABLE `lienhe` 
ADD COLUMN `ip_address` varchar(45) NULL COMMENT 'Địa chỉ IP người gửi' AFTER `replied_at`;

-- Thêm cột user_agent (thông tin trình duyệt)
ALTER TABLE `lienhe` 
ADD COLUMN `user_agent` text NULL COMMENT 'Thông tin trình duyệt' AFTER `ip_address`;

-- Thêm cột is_read (đã đọc chưa)
ALTER TABLE `lienhe` 
ADD COLUMN `is_read` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Đã đọc chưa' AFTER `user_agent`;

-- Thêm cột updated_at (thời gian cập nhật)
ALTER TABLE `lienhe` 
ADD COLUMN `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Thời gian cập nhật' AFTER `created_at`;

-- Thêm indexes để tối ưu hiệu suất
ALTER TABLE `lienhe` ADD INDEX `idx_status` (`status`);
ALTER TABLE `lienhe` ADD INDEX `idx_priority` (`priority`);
ALTER TABLE `lienhe` ADD INDEX `idx_is_read` (`is_read`);
ALTER TABLE `lienhe` ADD INDEX `idx_created_at` (`created_at`);
ALTER TABLE `lienhe` ADD INDEX `idx_email` (`email`);

-- Thêm dữ liệu mẫu để test
INSERT INTO `lienhe` (`name`, `email`, `phone`, `subject`, `message`, `status`, `priority`, `ip_address`) VALUES
('Nguyễn Văn An', 'an.nguyen@email.com', '0901234567', 'Hỏi về sản phẩm', 'Tôi muốn tìm hiểu về sản phẩm XYZ có sẵn không?', 'pending', 'normal', '192.168.1.100'),
('Trần Thị Bình', 'binh.tran@email.com', '0987654321', 'Khiếu nại đơn hàng', 'Đơn hàng #12345 của tôi bị chậm trễ, xin hỗ trợ.', 'read', 'high', '192.168.1.101'),
('Lê Văn Cường', 'cuong.le@email.com', '0912345678', 'Yêu cầu báo giá', 'Có thể gửi báo giá cho số lượng lớn không?', 'replied', 'normal', '192.168.1.102'),
('Phạm Thị Dung', 'dung.pham@email.com', '0923456789', 'Hỗ trợ kỹ thuật', 'Sản phẩm bị lỗi sau khi mua 1 tuần.', 'pending', 'urgent', '192.168.1.103'),
('Hoàng Văn Em', 'em.hoang@email.com', '0934567890', 'Góp ý cải thiện', 'Website rất tốt nhưng cần cải thiện tốc độ tải.', 'closed', 'low', '192.168.1.104');

-- Cập nhật phản hồi cho một bản ghi mẫu
UPDATE `lienhe` 
SET `reply_message` = 'Cảm ơn anh đã liên hệ. Chúng tôi sẽ gửi báo giá chi tiết qua email trong ngày hôm nay.',
    `replied_by` = 1,
    `replied_at` = NOW()
WHERE `email` = 'cuong.le@email.com';
