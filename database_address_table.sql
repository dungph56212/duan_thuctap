-- Script tạo bảng dia_chis để quản lý địa chỉ người dùng
-- Chạy script này trong database du-an-1-wd19314

CREATE TABLE IF NOT EXISTS `dia_chis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tai_khoan_id` int(11) NOT NULL,
  `ho_ten` varchar(255) NOT NULL,
  `so_dien_thoai` varchar(20) NOT NULL,
  `tinh_thanh` varchar(100) NOT NULL,
  `quan_huyen` varchar(100) NOT NULL,
  `phuong_xa` varchar(100) NOT NULL,
  `dia_chi_chi_tiet` text NOT NULL,
  `is_default` tinyint(1) DEFAULT 0 COMMENT '0: không mặc định, 1: mặc định',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_dia_chis_tai_khoan` (`tai_khoan_id`),
  CONSTRAINT `fk_dia_chis_tai_khoan` FOREIGN KEY (`tai_khoan_id`) REFERENCES `tai_khoans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Bảng quản lý địa chỉ người dùng';

-- Thêm index để tối ưu hiệu suất
CREATE INDEX `idx_tai_khoan_default` ON `dia_chis` (`tai_khoan_id`, `is_default`);
