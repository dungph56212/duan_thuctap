-- Tạo bảng banner quảng cáo
CREATE TABLE IF NOT EXISTS `banner_ads` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `ten_banner` varchar(255) NOT NULL COMMENT 'Tên banner',
    `mo_ta` text COMMENT 'Mô tả banner',
    `hinh_anh` varchar(500) NOT NULL COMMENT 'Đường dẫn hình ảnh',
    `link_url` varchar(500) COMMENT 'Link khi click vào banner',
    `thu_tu` int(11) DEFAULT 0 COMMENT 'Thứ tự hiển thị',
    `trang_thai` tinyint(1) DEFAULT 1 COMMENT '1: Hoạt động, 0: Không hoạt động',
    `loai_hien_thi` enum('popup','banner_top','banner_bottom','sidebar') DEFAULT 'popup' COMMENT 'Loại hiển thị',
    `thoi_gian_hien_thi` int(11) DEFAULT 5000 COMMENT 'Thời gian hiển thị popup (ms)',
    `hien_thi_lan_duy_nhat` tinyint(1) DEFAULT 1 COMMENT '1: Chỉ hiển thị 1 lần/session, 0: Hiển thị mỗi lần tải trang',
    `ngay_bat_dau` datetime DEFAULT NULL COMMENT 'Ngày bắt đầu hiển thị',
    `ngay_ket_thuc` datetime DEFAULT NULL COMMENT 'Ngày kết thúc hiển thị',
    `luot_xem` int(11) DEFAULT 0 COMMENT 'Số lượt xem',
    `luot_click` int(11) DEFAULT 0 COMMENT 'Số lượt click',
    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_trang_thai` (`trang_thai`),
    KEY `idx_loai_hien_thi` (`loai_hien_thi`),
    KEY `idx_thu_tu` (`thu_tu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Thêm dữ liệu mẫu
INSERT INTO `banner_ads` (`ten_banner`, `mo_ta`, `hinh_anh`, `link_url`, `thu_tu`, `trang_thai`, `loai_hien_thi`, `thoi_gian_hien_thi`, `hien_thi_lan_duy_nhat`, `ngay_bat_dau`, `ngay_ket_thuc`) VALUES
('Banner Khuyến Mãi Shopee', 'Banner quảng cáo khuyến mãi đặc biệt', 'uploads/banner_shopee_popup.jpg', 'https://shopee.vn', 1, 1, 'popup', 8000, 1, NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY)),
('Banner Sale Cuối Năm', 'Quảng cáo sale cuối năm', 'uploads/banner_sale.jpg', '?act=khuyen-mai', 2, 1, 'popup', 6000, 1, NOW(), DATE_ADD(NOW(), INTERVAL 15 DAY));
