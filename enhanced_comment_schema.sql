-- Enhanced Comment Management Schema Updates
-- Run these SQL commands to update the binh_luans table for enhanced functionality

-- Add missing columns to binh_luans table
ALTER TABLE `binh_luans` 
ADD COLUMN `parent_id` INT NULL COMMENT 'ID of parent comment for replies',
ADD COLUMN `is_admin_reply` TINYINT(1) DEFAULT 0 COMMENT 'Whether this is an admin reply',
ADD COLUMN `ngay_cap_nhat` DATETIME NULL COMMENT 'Last update timestamp',
ADD COLUMN `ip_address` VARCHAR(45) NULL COMMENT 'User IP address for tracking',
ADD COLUMN `user_agent` TEXT NULL COMMENT 'User browser information';

-- Update ngay_dang to DATETIME for better precision
ALTER TABLE `binh_luans` 
MODIFY COLUMN `ngay_dang` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;

-- Add indexes for better performance
ALTER TABLE `binh_luans` 
ADD INDEX `idx_san_pham_id` (`san_pham_id`),
ADD INDEX `idx_tai_khoan_id` (`tai_khoan_id`),
ADD INDEX `idx_trang_thai` (`trang_thai`),
ADD INDEX `idx_parent_id` (`parent_id`),
ADD INDEX `idx_ngay_dang` (`ngay_dang`),
ADD INDEX `idx_is_admin_reply` (`is_admin_reply`);

-- Add foreign key constraints for data integrity
ALTER TABLE `binh_luans` 
ADD CONSTRAINT `fk_binh_luans_san_pham` 
    FOREIGN KEY (`san_pham_id`) REFERENCES `san_phams`(`id`) ON DELETE CASCADE,
ADD CONSTRAINT `fk_binh_luans_tai_khoan` 
    FOREIGN KEY (`tai_khoan_id`) REFERENCES `tai_khoans`(`id`) ON DELETE CASCADE,
ADD CONSTRAINT `fk_binh_luans_parent` 
    FOREIGN KEY (`parent_id`) REFERENCES `binh_luans`(`id`) ON DELETE CASCADE;

-- Update trang_thai values to be more descriptive
-- 1 = pending (chờ duyệt)
-- 2 = approved (đã duyệt)  
-- 3 = rejected (từ chối)
-- 4 = hidden (ẩn)

-- Create a view for approved comments with user info
CREATE OR REPLACE VIEW `view_approved_comments` AS
SELECT 
    bl.id,
    bl.san_pham_id,
    bl.tai_khoan_id,
    bl.noi_dung,
    bl.ngay_dang,
    bl.ngay_cap_nhat,
    bl.parent_id,
    bl.is_admin_reply,
    tk.ho_ten,
    tk.email,
    tk.anh_dai_dien,
    sp.ten_san_pham
FROM binh_luans bl
INNER JOIN tai_khoans tk ON bl.tai_khoan_id = tk.id
INNER JOIN san_phams sp ON bl.san_pham_id = sp.id
WHERE bl.trang_thai = 2
ORDER BY bl.ngay_dang DESC;

-- Create a procedure for getting comments with replies
DELIMITER //
CREATE PROCEDURE GetProductCommentsWithReplies(IN product_id INT)
BEGIN
    SELECT 
        bl.id,
        bl.san_pham_id,
        bl.tai_khoan_id,
        bl.noi_dung,
        bl.ngay_dang,
        bl.ngay_cap_nhat,
        bl.parent_id,
        bl.is_admin_reply,
        tk.ho_ten,
        tk.anh_dai_dien,
        (SELECT COUNT(*) FROM binh_luans replies 
         WHERE replies.parent_id = bl.id AND replies.trang_thai = 2) as reply_count
    FROM binh_luans bl
    INNER JOIN tai_khoans tk ON bl.tai_khoan_id = tk.id
    WHERE bl.san_pham_id = product_id 
    AND bl.trang_thai = 2
    AND bl.parent_id IS NULL
    ORDER BY bl.ngay_dang DESC;
END //
DELIMITER ;

-- Insert sample admin replies for testing (optional)
-- INSERT INTO binh_luans (san_pham_id, tai_khoan_id, noi_dung, ngay_dang, trang_thai, parent_id, is_admin_reply)
-- VALUES 
-- (1, 1, 'Cảm ơn bạn đã phản hồi! Chúng tôi rất vui khi sản phẩm được bạn đánh giá cao.', NOW(), 2, 1, 1);

-- Comment status reference:
-- 1: Pending approval (Chờ duyệt)
-- 2: Approved (Đã duyệt)
-- 3: Rejected (Từ chối)
-- 4: Hidden (Ẩn)
