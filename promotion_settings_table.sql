-- Create promotion_settings table for storing system settings
CREATE TABLE IF NOT EXISTS `promotion_settings` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `setting_key` varchar(100) NOT NULL,
    `setting_value` text DEFAULT NULL,
    `setting_type` enum('string','number','boolean','json') DEFAULT 'string',
    `description` text DEFAULT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique_setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- Insert default settings
INSERT INTO `promotion_settings` (`setting_key`, `setting_value`, `setting_type`, `description`) VALUES
('auto_deactivate_expired', '1', 'boolean', 'Tự động vô hiệu hóa khuyến mãi hết hạn'),
('expiry_warning_days', '7', 'number', 'Số ngày cảnh báo trước khi hết hạn'),
('allow_stacking', '0', 'boolean', 'Cho phép chồng khuyến mãi'),
('max_discount_per_order', '0', 'number', 'Giảm giá tối đa mỗi đơn hàng (0 = không giới hạn)'),
('code_prefix', 'KM', 'string', 'Tiền tố mã khuyến mãi'),
('code_length', '8', 'number', 'Độ dài mã khuyến mãi'),
('code_format', 'alphanumeric', 'string', 'Định dạng mã khuyến mãi'),
('default_usage_limit', '100', 'number', 'Giới hạn sử dụng mặc định'),
('max_usage_per_customer', '1', 'number', 'Tối đa mỗi khách hàng'),
('min_order_amount', '0', 'number', 'Giá trị đơn hàng tối thiểu'),
('require_login', '1', 'boolean', 'Yêu cầu đăng nhập để sử dụng khuyến mãi'),
('notify_on_expiry', '1', 'boolean', 'Thông báo khi sắp hết hạn'),
('notify_on_usage', '0', 'boolean', 'Thông báo khi được sử dụng'),
('notification_email', '', 'string', 'Email nhận thông báo'),
('track_analytics', '1', 'boolean', 'Theo dõi phân tích'),
('auto_report_frequency', 'never', 'string', 'Tần suất báo cáo tự động');

-- Add indexes for better performance
CREATE INDEX `idx_setting_key` ON `promotion_settings` (`setting_key`);
CREATE INDEX `idx_setting_type` ON `promotion_settings` (`setting_type`);
