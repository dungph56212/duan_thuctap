-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 16, 2024 at 12:48 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `du-an-1-wd19314`
--

-- --------------------------------------------------------

--
-- Table structure for table `binh_luans`
--

CREATE TABLE `binh_luans` (
  `id` int NOT NULL,
  `san_pham_id` int NOT NULL,
  `tai_khoan_id` int NOT NULL,
  `noi_dung` text NOT NULL,
  `ngay_dang` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `trang_thai` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `binh_luans`
--

INSERT INTO `binh_luans` (`id`, `san_pham_id`, `tai_khoan_id`, `noi_dung`, `ngay_dang`, `trang_thai`) VALUES
(1, 37, 7, 'Sản phẩm 10 đỉm, không còn gì để chê, ... 5 sao', '2024-07-27 17:00:00', 1),
(2, 38, 7, 'Sản phẩm 10 đỉm, không còn gì để chê, ... 10 sao', '2024-07-27 17:00:00', 1),
(3, 42, 5, 'Vải xịn, chất lượng hợp giá tiền', '2024-07-28 17:00:00', 1),
(4, 40, 5, 'Màu tươi, sản phẩm tốt, giá phù hợp', '2024-07-28 17:00:00', 1),
(5, 37, 2, '', '2024-08-01 04:14:16', 2),
(6, 37, 2, 'sanphamokokok', '2024-08-01 04:14:25', 1),
(7, 43, 2, 'sanphamokokokok', '2024-08-01 04:14:48', 1),
(8, 40, 7, 'Quần đẹp, vãi co dãn, dáng skinny', '2024-08-01 04:24:34', 1),
(9, 47, 2, 'Áo form đẹp, mà giá hơi chat,..', '2024-08-01 04:26:52', 1),
(10, 42, 7, 'Siêu phẩm đây rồi,quá tuyệt vời cho 1 sản phẩm giá tầm chung', '2024-08-01 07:51:42', 1),
(11, 42, 1, 'tầm giá này tôi có thể mua 2 chiếc như này, ', '2024-07-31 17:00:00', 1),
(13, 42, 1, 'áo siêu đẹpppppppp', '2024-08-01 08:06:50', 1),
(14, 47, 7, '', '2024-08-01 11:40:45', 1),
(15, 39, 5, '', '2024-08-02 05:52:03', 1),
(16, 37, 1, 'Với tầm giá tôi có thể mua áo phông gucci rồi', '2024-08-07 02:12:30', 1),
(17, 45, 7, 'Áo ok ok ok okok ok o ko', '2024-08-10 02:20:02', 1),
(18, 37, 7, 'okk', '2024-08-11 03:36:17', 1),
(19, 60, 2, 'váy ổn, tôn da, sang chảnh', '2024-08-30 00:16:41', 1),
(20, 60, 2, 'váy ổn, tôn da, sang chảnh', '2024-08-30 00:16:41', 1),
(21, 60, 2, 'ổn', '2024-08-30 00:16:59', 1),
(22, 50, 7, 'sản phẩm rất đẹp, vải xin vlon luonnn ', '2024-09-09 11:56:20', 1),
(23, 55, 7, 'a di ngon mô tô', '2024-09-25 04:11:02', 1),
(24, 59, 48, 'fdsdgfhgjkjk', '2024-10-24 21:06:10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `chi_tiet_don_hangs`
--

CREATE TABLE `chi_tiet_don_hangs` (
  `id` int NOT NULL,
  `don_hang_id` int NOT NULL,
  `san_pham_id` int NOT NULL,
  `don_gia` decimal(10,2) NOT NULL,
  `so_luong` int NOT NULL,
  `thanh_tien` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `chi_tiet_don_hangs`
--

INSERT INTO `chi_tiet_don_hangs` (`id`, `don_hang_id`, `san_pham_id`, `don_gia`, `so_luong`, `thanh_tien`) VALUES
(1, 1, 37, '269000.00', 1, '269000.00'),
(2, 1, 26, '250000.00', 2, '250000.00'),
(3, 2, 38, '230000.00', 1, '230000.00'),
(4, 2, 6, '157000.00', 2, '157000.00'),
(8, 23, 45, '297000.00', 1, '327000.00'),
(19, 59, 47, '288000.00', 1, '318000.00'),
(20, 60, 47, '288000.00', 1, '318000.00'),
(21, 61, 43, '285600.00', 1, '315600.00'),
(22, 62, 45, '297000.00', 2, '327000.00'),
(23, 63, 39, '233000.00', 2, '263000.00'),
(24, 64, 48, '321000.00', 3, '351000.00'),
(25, 65, 37, '333000.00', 1, '363000.00'),
(26, 66, 44, '273000.00', 1, '303000.00'),
(27, 67, 40, '330000.00', 1, '360000.00'),
(28, 68, 43, '285600.00', 2, '315600.00'),
(29, 69, 44, '273000.00', 2, '303000.00'),
(30, 70, 48, '321000.00', 2, '351000.00'),
(31, 71, 46, '269000.00', 1, '299000.00'),
(32, 72, 40, '330000.00', 2, '360000.00'),
(33, 73, 37, '333000.00', 1, '363000.00'),
(34, 74, 49, '369000.00', 1, '399000.00'),
(35, 75, 60, '295000.00', 2, '325000.00'),
(36, 76, 60, '295000.00', 2, '325000.00'),
(37, 77, 55, '1392000.00', 2, '1422000.00'),
(38, 78, 65, '321000.00', 2, '351000.00'),
(39, 79, 59, '275000.00', 10, '325000.00'),
(40, 80, 66, '185000.00', 8, '235000.00'),
(41, 81, 59, '275000.00', 3, '325000.00'),
(42, 82, 51, '1272000.00', 5, '1322000.00'),
(43, 83, 59, '275000.00', 3, '325000.00'),
(44, 84, 59, '275000.00', 1, '325000.00'),
(45, 85, 56, '385000.00', 2, '435000.00');

-- --------------------------------------------------------

--
-- Table structure for table `chi_tiet_gio_hangs`
--

CREATE TABLE `chi_tiet_gio_hangs` (
  `id` int NOT NULL,
  `gio_hang_id` int NOT NULL,
  `san_pham_id` int NOT NULL,
  `so_luong` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `chi_tiet_gio_hangs`
--

INSERT INTO `chi_tiet_gio_hangs` (`id`, `gio_hang_id`, `san_pham_id`, `so_luong`) VALUES
(59, 91, 59, 13),
(60, 91, 50, 5),
(61, 91, 54, 5),
(62, 91, 60, 5),
(63, 91, 70, 1),
(64, 91, 63, 1),
(65, 91, 66, 4),
(66, 91, 55, 12),
(67, 92, 59, 3),
(68, 91, 51, 1),
(69, 93, 59, 1),
(70, 93, 56, 2);

-- --------------------------------------------------------

--
-- Table structure for table `chuc_vus`
--

CREATE TABLE `chuc_vus` (
  `id` int NOT NULL,
  `ten_chuc_vu` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `chuc_vus`
--

INSERT INTO `chuc_vus` (`id`, `ten_chuc_vu`) VALUES
(1, 'Admin'),
(2, 'Cumtomer');

-- --------------------------------------------------------

--
-- Table structure for table `danh_mucs`
--

CREATE TABLE `danh_mucs` (
  `id` int NOT NULL,
  `ten_danh_muc` varchar(255) NOT NULL,
  `parent_id` int DEFAULT NULL,
  `mo_ta` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `danh_mucs`
--

INSERT INTO `danh_mucs` (`id`, `ten_danh_muc`, `parent_id`, `mo_ta`) VALUES
(21, 'Váy Công sở ', 42, ''),
(22, 'váy Đi Chơi', 42, ''),
(33, 'Set Vòng Cổ, Hoa Tai', 44, ''),
(34, 'Vòng Tay', 44, ''),
(35, 'Nhẫn', 44, ''),
(36, 'Túi Đeo Chéo', 45, ''),
(37, 'Túi Mini', 45, ''),
(38, 'Túi Đeo Vai', 45, ''),
(39, 'Túi Đeo Vai', 45, ''),
(40, 'Ví', 45, ''),
(42, 'Váy', NULL, NULL),
(43, 'Phụ Kiện', NULL, NULL),
(44, 'Trang Sức', NULL, NULL),
(45, 'Túi Xách', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `don_hangs`
--

CREATE TABLE `don_hangs` (
  `id` int NOT NULL,
  `ma_don_hang` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tai_khoan_id` int NOT NULL,
  `ten_nguoi_nhan` varchar(255) NOT NULL,
  `email_nguoi_nhan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `sdt_nguoi_nhan` varchar(15) NOT NULL,
  `dia_chi_nguoi_nhan` text NOT NULL,
  `ngay_dat` date NOT NULL,
  `tong_tien` decimal(10,2) NOT NULL,
  `ghi_chu` text,
  `phuong_thuc_thanh_toan_id` int NOT NULL,
  `trang_thai_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `don_hangs`
--

INSERT INTO `don_hangs` (`id`, `ma_don_hang`, `tai_khoan_id`, `ten_nguoi_nhan`, `email_nguoi_nhan`, `sdt_nguoi_nhan`, `dia_chi_nguoi_nhan`, `ngay_dat`, `tong_tien`, `ghi_chu`, `phuong_thuc_thanh_toan_id`, `trang_thai_id`) VALUES
(78, 'HL-7360', 7, 'Cô Giáo Hương', 'huong2005@gmail.com', '09867847567', 'Số 1, Ba Đình', '2024-08-30', '351000.00', '', 1, 9),
(79, 'HL-7401', 7, 'Vũ Hải Lam', 'vuhailam2112@gmaiil.com', '0966701154', 'Mai Dịch, Cầu Giấy, Hà Nội', '2024-09-12', '325000.00', '', 1, 6),
(80, 'HL-4722', 7, 'Trần Hà Linh', 'linhha2003@gmail.com', '09867847567', 'Tiểu Khu Tiền Tiến, Thị trấn Mộc Châu, Huyện Mộc Châu, Tỉnh Sơn La', '2024-09-13', '235000.00', 'Ship hỏa tốc giúp tôi', 1, 8),
(81, 'HL-6036', 45, 'Tiến bịp', 'long9ngon@gmail.com', '09867847567', 'Doãn Kế Thiện, Phường Mai Dịch, Quận Cầu Giấy, Thành phố Hà Nội', '2024-09-30', '325000.00', '', 2, 1),
(82, 'HL-4654', 7, 'Lam Đá', 'long9ngon@gmail.com', '0966701154', 'Mai Dịch, Cầu Giấy, Hà Nội, Xã Danh Thắng, Huyện Hiệp Hòa, Tỉnh Bắc Giang', '2024-10-01', '1322000.00', 'dsđfs', 2, 1),
(83, 'HL-3250', 48, 'tỷyfgjhj', 'fygjhkjn@gmail.com', '01455', '105/233, Phường Mai Dịch, Quận Cầu Giấy, Thành phố Hà Nội', '2024-10-25', '325000.00', '', 1, 1),
(84, 'HL-973', 48, 'Cô Giáo Hương', 'huong2005@gmail.com', '09867847567', ', Thị trấn Đức Thọ, Huyện Đức Thọ, Tỉnh Hà Tĩnh', '2024-10-29', '325000.00', '', 1, 1),
(85, 'HL-7144', 48, 'Lam Đá', 'huong2005@gmail.com', '09867847567', ', Xã Vân Nam, Huyện Phúc Thọ, Thành phố Hà Nội', '2024-10-29', '435000.00', '', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `gio_hangs`
--

CREATE TABLE `gio_hangs` (
  `id` int NOT NULL,
  `tai_khoan_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `gio_hangs`
--

INSERT INTO `gio_hangs` (`id`, `tai_khoan_id`) VALUES
(91, 7),
(92, 45),
(93, 48);

-- --------------------------------------------------------

--
-- Table structure for table `hinh_anh_san_phams`
--

CREATE TABLE `hinh_anh_san_phams` (
  `id` int NOT NULL,
  `san_pham_id` int NOT NULL,
  `link_hinh_anh` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `hinh_anh_san_phams`
--

INSERT INTO `hinh_anh_san_phams` (`id`, `san_pham_id`, `link_hinh_anh`) VALUES
(48, 37, './uploads/1721815606ao-t-shift_nam_1.1.jpg'),
(49, 37, './uploads/1721815606ao-t-shift_nam_1.2.jpg'),
(50, 37, './uploads/1721815606ao-t-shift_nam_1.3.webp'),
(51, 37, './uploads/1721815606ao-t-shift_nam_1.4.jpg'),
(52, 38, './uploads/1721815733ao_nam_1.1.webp'),
(53, 38, './uploads/1721815733ao_nam_1.2.webp'),
(54, 38, './uploads/1721815733ao_nam_1.3.webp'),
(55, 38, './uploads/1721815733ao_nam_1.4.webp'),
(56, 39, './uploads/1721815832ao_nam_2.1.webp'),
(57, 39, './uploads/1721815832ao_nam_2.2.webp'),
(58, 39, './uploads/1721815832ao_nam_2.3.webp'),
(59, 39, './uploads/1721815832ao_nam_2.4.webp'),
(60, 40, './uploads/1721816951quan-jeans_nam_1.1.webp'),
(61, 40, './uploads/1721816951quan-jeans_nam_1.2.webp'),
(62, 40, './uploads/1721816951quan-jeans_nam_1.3.webp'),
(63, 40, './uploads/1721816951quan-jeans_nam_1.4.webp'),
(64, 41, './uploads/1721824798ao-t-shift_nam_2.1.jpg'),
(65, 41, './uploads/1721824798ao-t-shift_nam_2.2.jpg'),
(66, 41, './uploads/1721824798ao-t-shift_nam_2.3.jpg'),
(67, 41, './uploads/1721824798ao-t-shift_nam_2.4.jpg'),
(68, 42, './uploads/1721864942ao-t-shift_nam_3.1.jpg'),
(69, 42, './uploads/1721864942ao-t-shift_nam_3.2.jpg'),
(70, 42, './uploads/1721864942ao-t-shift_nam_3.3.jpg'),
(71, 42, './uploads/1721864942ao-t-shift_nam_3.4.jpg'),
(72, 43, './uploads/1721922186quan-jeans_nam_2.1.jpg'),
(73, 43, './uploads/1721922186quan-jeans_nam_2.2.jpg'),
(74, 43, './uploads/1721922186quan-jeans_nam_2.3.jpg'),
(75, 43, './uploads/1721922186quan-jeans_nam_2.4.jpg'),
(76, 44, './uploads/1721923070ao-t-shift_nam_1.2.jpg'),
(77, 44, './uploads/1721923070ao-t-shift_nam_1.3.jpg'),
(78, 44, './uploads/1721923070ao-t-shift_nam_1.4.jpg'),
(79, 44, './uploads/1721923070ao-t-shift_nam_1.jpg'),
(80, 45, './uploads/1721923565ao-t-shift_nam_2.1.jpg'),
(81, 45, './uploads/1721923565ao-t-shift_nam_2.2.jpg'),
(82, 45, './uploads/1721923565ao-t-shift_nam_2.3.webp'),
(83, 45, './uploads/1721923565ao-t-shift_nam_2.4.webp'),
(84, 46, './uploads/1721990714ao-polo_nam_4.1.jpg'),
(85, 46, './uploads/1721990714ao-polo_nam_4.2.jpg'),
(86, 46, './uploads/1721990714ao-polo_nam_4.3.jpg'),
(87, 46, './uploads/1721990714ao-polo_nam_4.4.jpg'),
(88, 47, './uploads/1722257755ao_khoac_1.1.jpg'),
(89, 47, './uploads/1722257755ao_khoac_1.2.jpg'),
(90, 47, './uploads/1722257755ao_khoac_1.3.jpg'),
(91, 47, './uploads/1722257755ao_khoac_1.4.jpg'),
(92, 48, './uploads/1722863139quan-jeans_nam_3.1.jpg'),
(93, 48, './uploads/1722863139quan-jeans_nam_3.2.jpg'),
(94, 48, './uploads/1722863139quan-jeans_nam_3.3.jpg'),
(95, 49, './uploads/1723826593quan-jeans_nam_4.1.webp'),
(96, 49, './uploads/1723826593quan-jeans_nam_4.2.webp'),
(97, 49, './uploads/1723826593quan-jeans_nam_4.3.webp'),
(98, 50, './uploads/1723988491ngo09227_5674d3e09fdd4d36aace901d4b5ab92a.webp'),
(99, 50, './uploads/1723988491ngo09258_bcd3f3dc70364c299c61b29bdd998d3f.webp'),
(100, 50, './uploads/1723988491ngo09259_0146d01111324b60bacac4a72a89a2f0.webp'),
(101, 50, './uploads/1723988491ngo09289_c263c79b4e304b25a7a21b8115b2c0e8.webp'),
(102, 50, './uploads/1723988491ngo09295_c70aa7293da549609150be18d397eb66.webp'),
(103, 51, './uploads/1723988953ngo09336_f719630c4ae14b099038934ced09cb1c.webp'),
(104, 51, './uploads/1723988953ngo09347_a9e09c8637894c069da69a81e35345f1.webp'),
(105, 51, './uploads/1723988953ngo09356_2a7b36241c4540ee8043870559e5bb25.webp'),
(106, 51, './uploads/1723988953ngo09387_74ebdd7e9f1e4deaa1a93480b02a172f.webp'),
(107, 51, './uploads/1723988953ngo09395_86dcf6435a0b475e8f875061d432cd1a.webp'),
(108, 52, './uploads/1723989296ngo01903_bc3df6801505449bb2e2f66cbf45a525.webp'),
(109, 52, './uploads/1723989296ngo01918_6cf39543ad47465b93688a0895e3a12d.webp'),
(110, 52, './uploads/1723989296ngo01954_b6a528ce51f84b91a017439d4b3ac141.webp'),
(111, 52, './uploads/1723989296ngo01968_6f5ceeeed9fa4ac3871074e9649e2d4b.webp'),
(112, 53, './uploads/1723989296ngo01903_bc3df6801505449bb2e2f66cbf45a525.webp'),
(113, 53, './uploads/1723989296ngo01918_6cf39543ad47465b93688a0895e3a12d.webp'),
(114, 53, './uploads/1723989296ngo01954_b6a528ce51f84b91a017439d4b3ac141.webp'),
(115, 53, './uploads/1723989296ngo01968_6f5ceeeed9fa4ac3871074e9649e2d4b.webp'),
(116, 54, './uploads/1723989417ngo01903_bc3df6801505449bb2e2f66cbf45a525.webp'),
(117, 54, './uploads/1723989417ngo01918_6cf39543ad47465b93688a0895e3a12d.webp'),
(118, 54, './uploads/1723989417ngo01954_b6a528ce51f84b91a017439d4b3ac141.webp'),
(119, 54, './uploads/1723989417ngo01968_6f5ceeeed9fa4ac3871074e9649e2d4b.webp'),
(120, 55, './uploads/1723989712ngo09540_a694a29e77274774ad8870f539cdf457.jpg'),
(121, 55, './uploads/1723989712ngo09563_6b8224457d7c423a8bb8a22a59a4aa05.webp'),
(122, 55, './uploads/1723989712ngo09576_6ab76a81adf948f3bef1a8b469896ada.webp'),
(123, 56, './uploads/1723990072a0103q-2-1152x1536.jpg'),
(124, 56, './uploads/1723990072a0103q-3-1152x1536.jpg'),
(125, 56, './uploads/1723990072a0103q-4-1152x1536.jpg'),
(126, 56, './uploads/1723990072a0103q-5-1152x1536.jpg'),
(127, 57, './uploads/1723990385a0103q-6-1152x1536.jpg'),
(128, 57, './uploads/1723990385a0103q-7-1152x1536.jpg'),
(129, 57, './uploads/1723990385a0103q-9-1152x1536.jpg'),
(130, 58, './uploads/1723990385a0103q-6-1152x1536.jpg'),
(131, 58, './uploads/1723990385a0103q-7-1152x1536.jpg'),
(132, 58, './uploads/1723990385a0103q-9-1152x1536.jpg'),
(133, 59, './uploads/1724056602a0405db-2-web.jpg'),
(134, 59, './uploads/1724056602a0405db-3-web.jpg'),
(135, 59, './uploads/1724056602a0405db-4-web.jpg'),
(136, 59, './uploads/1724056602a0405db-5-web.jpg'),
(137, 60, './uploads/1724060779a0403db-2-web.jpg'),
(138, 60, './uploads/1724060779a0403db-3-web.jpg'),
(139, 60, './uploads/1724060779a0403db-4-web.jpg'),
(140, 61, './uploads/1724060944A0303S-4-web.jpg'),
(141, 61, './uploads/1724060944A0303S-5-web.jpg'),
(142, 61, './uploads/1724060944A0303S-6-web.jpg'),
(143, 62, './uploads/1724061113a0109t-2.jpg'),
(144, 62, './uploads/1724061113a0109t-3.jpg'),
(145, 62, './uploads/1724061113a0109t-5.jpg'),
(146, 63, './uploads/1724061258a0112t-web-2.jpg'),
(147, 63, './uploads/1724061258a0112t-web-3.jpg'),
(148, 64, './uploads/1724061453A0402Q-3.jpg'),
(149, 64, './uploads/1724061453A0402Q-4.jpg'),
(150, 64, './uploads/1724061453A0402Q-6.jpg'),
(151, 65, './uploads/1724061622a0405db-2.jpg'),
(152, 65, './uploads/1724061622a0405db-3.jpg'),
(153, 65, './uploads/1724061622a0405db-7.jpg'),
(154, 66, './uploads/1724061791a0402db-3.jpg'),
(155, 66, './uploads/1724061791a0402db-4.jpg'),
(156, 66, './uploads/1724061791a0402db-5.jpg'),
(157, 66, './uploads/1724061791a0402db-6.jpg'),
(158, 67, './uploads/1724062003A0110T-3.jpg'),
(159, 67, './uploads/1724062003A0110T-7.jpg'),
(160, 67, './uploads/1724062003A0110T-8.jpg'),
(161, 68, './uploads/1724062163ngo08032_51e9693b7fea4427a364f98744d24fd7_master.webp'),
(162, 68, './uploads/1724062163ngo08046_d2fcb49f6bc347578f22f2936f966721_master.jpg'),
(163, 68, './uploads/1724062163ngo08055_04dc1fb1979d4db98e5f86f0ac7c245f_master.webp'),
(164, 69, './uploads/1724062163ngo08032_51e9693b7fea4427a364f98744d24fd7_master.webp'),
(165, 69, './uploads/1724062163ngo08046_d2fcb49f6bc347578f22f2936f966721_master.jpg'),
(166, 69, './uploads/1724062163ngo08055_04dc1fb1979d4db98e5f86f0ac7c245f_master.webp'),
(167, 70, './uploads/1724062379ndino304mo1_1716438436.png'),
(168, 70, './uploads/1724062379ndino304mo7_1716438425.png'),
(169, 70, './uploads/1724062379ndino3042_1716438425.jpg'),
(170, 70, './uploads/1724062432ndino3044_1716438425.jpg'),
(171, 71, './uploads/1724062802btptb3503_1716551064.jpg'),
(172, 71, './uploads/1724062802btptb35012_1715669805.png'),
(173, 71, './uploads/1724062802dcptb3502_1716551136.jpg'),
(174, 71, './uploads/1724062802dcptb35012_1715669658.png'),
(175, 72, './uploads/1724062924mdptb3741_1715658302.png'),
(176, 72, './uploads/1724062924mdptb3742_1715915149.jpg'),
(177, 72, './uploads/1724062924ptb374_1715915113 (1).png'),
(178, 73, './uploads/1724063219llf3001_1715938915.jpg'),
(179, 73, './uploads/1724063219llf3002_1715938915.jpg'),
(180, 73, './uploads/1724063219llf3006_1715938916.png'),
(181, 73, './uploads/1724063219lptb3621-b_1716197532.jpg'),
(182, 74, './uploads/1725555293el202-2.jpg'),
(183, 74, './uploads/1725555293el202-4.jpg'),
(184, 74, './uploads/1725555293el202-20.jpg'),
(185, 74, './uploads/1725555293tui-xach-nu-monogram-canvas-elly-el202-1.jpg'),
(186, 75, './uploads/1725555697day-lung-nu-cao-cap-da-that-elly-ed55-20.jpg'),
(187, 75, './uploads/1725555697day-lung-nu-cao-cap-da-that-elly-ed55-22.jpg'),
(188, 75, './uploads/1725555697day-lung-nu-cao-cap-da-that-elly-ed55-23.jpg'),
(189, 75, './uploads/1725555697day-lung-nu-cao-cap-da-that-elly-ed55-25.jpg'),
(190, 75, './uploads/1725555826day-lung-nu-cao-cap-da-that-elly-ed55-26.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `phuong_thuc_thanh_toans`
--

CREATE TABLE `phuong_thuc_thanh_toans` (
  `id` int NOT NULL,
  `ten_phuong_thuc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `phuong_thuc_thanh_toans`
--

INSERT INTO `phuong_thuc_thanh_toans` (`id`, `ten_phuong_thuc`) VALUES
(1, 'COD(Thanh Toán Khi Nhận Hàng)'),
(2, 'Thanh Toán VNPay'),
(3, 'Thẻ tín dụng\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `san_phams`
--

CREATE TABLE `san_phams` (
  `id` int NOT NULL,
  `ten_san_pham` varchar(255) NOT NULL,
  `gia_san_pham` decimal(10,2) NOT NULL,
  `gia_khuyen_mai` decimal(10,2) DEFAULT NULL,
  `hinh_anh` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `so_luong` int NOT NULL,
  `luot_xem` int DEFAULT '0',
  `ngay_nhap` date NOT NULL,
  `mo_ta` text,
  `danh_muc_id` int NOT NULL,
  `trang_thai` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `san_phams`
--

INSERT INTO `san_phams` (`id`, `ten_san_pham`, `gia_san_pham`, `gia_khuyen_mai`, `hinh_anh`, `so_luong`, `luot_xem`, `ngay_nhap`, `mo_ta`, `danh_muc_id`, `trang_thai`) VALUES
(50, 'Douceur Set 1', '2545000.00', '1214000.00', './uploads/1723988491ngo09289_c263c79b4e304b25a7a21b8115b2c0e8.webp', 12, 0, '2024-08-18', 'Màu sắc Đầm : Hoạ tiết', 21, 1),
(51, 'Douceur Set 2', '2545000.00', '1272000.00', './uploads/1723988953ngo09356_2a7b36241c4540ee8043870559e5bb25.webp', 8, 0, '2024-08-18', 'Màu sắc Đầm : Hoạ tiết', 21, 2),
(54, 'Meline Set 1', '2685000.00', '1342500.00', './uploads/1723989417ngo01903_bc3df6801505449bb2e2f66cbf45a525.webp', 6, 0, '2024-08-18', 'Màu sắc Áo : Hồng\r\nMàu sắc Juyp : Hồng', 21, 1),
(55, 'Douceur Set 3', '2785000.00', '1392000.00', './uploads/1723989712ngo09540_a694a29e77274774ad8870f539cdf457.jpg', 12, 0, '2024-08-18', 'Màu sắc Áo : Hồng\r\nMàu sắc Juyp : Hồng', 21, 1),
(56, 'Quần ống loe công sở', '425000.00', '385000.00', './uploads/1723990072a0103q-1-1152x1536.jpg', 10, 0, '2024-08-18', 'quần ống loe công sở thiết kế xếp ly cho nàng tự tin với phong cách cá tính, trẻ trung. Quần chất vải mềm mịn, tone màu sáng, dễ phối đồ công sở', 17, 1),
(58, 'Set quần ống loe và áo blazer ', '675000.00', '499000.00', './uploads/17240820911723990385a0103q-8-1152x1536.jpg', 8, 0, '2024-08-18', 'Set đồ công sở thiết kế xếp ly cho nàng tự tin với phong cách cá tính, trẻ trung. Quần chất vải mềm mịn áo tone màu sáng', 17, 1),
(59, 'Đầm body dáng dài', '350000.00', '275000.00', './uploads/1724056602a0405db-1-web.jpg', 8, 10, '2024-08-19', 'Đầm body dáng dài hai dây hở lưng Andora váy nữ tôn dáng đan dây, quyến rũ chất thun cotton co dãn tốt A0405DB.', 25, 1),
(60, 'Đầm ôm body hở vai thiết kế rút dây', '330000.00', '295000.00', './uploads/1724060779a0403db-1-web.jpg', 21, 0, '2024-08-19', 'Đầm ôm body dây rút lệch vai Andora kiểu váy tay dài hở vai bên rút dây bên nhún eo thiết kế vạt xéo màu tôn da mặc đi chơi, đám cưới, dự tiệc, dạo phố siêu sang chảnh A0403DB.', 25, 1),
(61, 'Chân váy xếp ly Andora tennis', '360000.00', '320000.00', './uploads/1724060944A0303S-1-web.jpg', 21, 0, '2024-08-19', 'Chân váy xếp ly Andora tennis lưng cao dày dặn 2 lớp, có lót quần, kiểu tennis skirt xếp li chất tuyết mưa cao cấp siêu tôn dáng sexy, quyến rũ, mặc đi chơi, dạo phố siêu xinh và sang chảnh A0304S đủ màu Trắng/Đen/Xám.', 22, 1),
(62, 'Áo ống quây ngực (không đệm)', '135000.00', '99000.00', './uploads/1724061113a0109t-1.jpg', 10, 0, '2024-08-19', 'Áo ống quây ngực Andora không đệm thun trơn, kiểu áo croptop ôm body không dây màu trắng đen vải siêu mát A0109T.', 19, 1),
(63, 'Áo thun croptop nữ ôm body hai dây', '156000.00', '108000.00', './uploads/1724061258a0112t-web-1.jpg', 12, 0, '2024-08-19', 'Áo thun croptop nữ ôm body hai dây bản lớn Andora chất vải thun gân cotton, kiểu áo crt cổ vuông đủ màu TRẮNG/ĐEN A0112T.', 19, 1),
(64, 'Set quần loe với áo trễ vai', '675000.00', '475000.00', './uploads/1724061453A0402Q-1.jpg', 6, 0, '2024-08-19', 'Quần ống loe cạp cao Andora nữ legging công sở ống bass form dài tôn dáng sành điệu mặc đi học, đi làm màu đen A0102Q.', 17, 1),
(65, 'Đầm đuôi cá maxi 2 dây ôm body', '420000.00', '321000.00', './uploads/1724061622a0405db-1.jpg', 21, 0, '2024-08-19', 'Đầm đuôi cá maxi ôm body Andora váy 2 dây tôn dáng, quyến rũ chất thun co dãn tốt mặc đi chơi, dự tiệc, đi biển A0404DB.', 25, 1),
(66, ' Đầm ôm body dây rút tôn dáng ', '235000.00', '185000.00', './uploads/1724061791a0402db-1.jpg', 12, 0, '2024-08-19', 'Đầm body rút dây hai bên hông Andora siêu tôn dáng sexy, quyến rũ, mặc đi chơi, dự tiệc siêu xinh và sang chảnh A0402DB.', 25, 1),
(67, 'Áo croptop ba lỗ nữ ôm body', '142000.00', '112000.00', './uploads/1724062003A0110T-1.jpg', 8, 0, '2024-08-19', 'Áo croptop ba lỗ nữ Andora ôm body chất thun gân, kiểu áo crt cổ tròn sát nách màu trắng đen vải mềm mát A0110T.', 19, 1),
(68, 'Ethereal Set 6', '333000.00', '299000.00', './uploads/1724062163ngo08048_3f3b75ec88044ea48255da6d3ac47646_master.webp', 21, 0, '2024-08-19', 'Màu sắc Áo: Xanh\r\nMàu sắc Quần: Xanh', 17, 1),
(69, 'Ethereal Set 6', '333000.00', '299000.00', './uploads/1724062163ngo08048_3f3b75ec88044ea48255da6d3ac47646_master.webp', 21, 0, '2024-08-19', 'Màu sắc Áo: Xanh\r\nMàu sắc Quần: Xanh', 17, 1),
(70, 'Nhẫn cầu hôn Vàng 14K đá Moissanite', '6693000.00', '6012000.00', './uploads/1724062379ndino304mo6_1716438523.png', 6, 0, '2024-08-19', 'Thiết kế nhẫn tinh xảo với bệ chấu như một chiếc vương miện được đính đá Moissanite, viền đai nhẫn nạm dải đá lấp lánh càng tôn thêm vẻ sang trọng, quý phái.', 35, 1),
(71, ' Bộ trang sức Vàng 14K đá CZ', '6976000.00', '6372000.00', './uploads/1724062802ptb350_1716549457.png', 1, 0, '2024-08-19', 'Thiết kế tiện dụng, vừa phù hợp đeo kết hợp với các trang phục trong dịp trọng đại như chụp ảnh cưới, áo dài hoặc váy cưới, vừa đeo hàng ngày khi đi làm, đi chơi.', 33, 1),
(72, 'Bộ trang sức Bạc14K đá CZ', '5982000.00', '5312000.00', './uploads/1724062924ptb374_1715915113.png', 10, 0, '2024-08-19', 'Thiết kế tiện dụng, vừa phù hợp đeo kết hợp với các trang phục trong dịp trọng đại như chụp ảnh cưới, áo dài hoặc váy cưới, vừa đeo hàng ngày khi đi làm, đi chơi.', 33, 1),
(73, 'Lắc tay Vàng 14K đá CZ', '5164000.00', '4556000.00', './uploads/1724063219lptb3628_1716197526.jpg', 8, 0, '2024-08-19', 'Thiết kế lắc tay với điểm nhấn nổi bật là đôi mèo cách điệu gắn đá lấp lánh, mang phong cách nhẹ nhàng, nữ tính.', 34, 1),
(74, 'Túi xách nữ thời trang ELLY', '799000.00', '362000.00', './uploads/1725555293el202-1.jpg', 12, 0, '2024-09-05', '– Kích thước: 19 x 14,5 x 4 cm (Chiều ngang x chiều dọc x độ dày). Công năng sử dụng: Đựng điện thoại, thẻ cá nhân, sạc dự phòng, thỏi son, đồ dùng cá nhân…', 36, 1),
(75, 'Dây lưng nữ cao cấp da thật ELLY', '424000.00', '362000.00', './uploads/1725555697ED55.jpg', 6, 0, '2024-09-06', '– Kích thước: 2 x 107 (± 5) cm (Bản rộng x chiều dài), Da bò cao cấp, Khóa xỏ kim.', 28, 1);

-- --------------------------------------------------------

--
-- Table structure for table `san_pham_ua_thichs`
--

CREATE TABLE `san_pham_ua_thichs` (
  `id` int NOT NULL,
  `tai_khoan_id` int NOT NULL,
  `san_pham_id` int NOT NULL,
  `ngay_them` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `san_pham_ua_thichs`
--

INSERT INTO `san_pham_ua_thichs` (`id`, `tai_khoan_id`, `san_pham_id`, `ngay_them`) VALUES
(1, 7, 50, '2024-09-22 16:28:48'),
(2, 7, 54, '2024-09-22 16:46:57'),
(3, 7, 55, '2024-09-23 15:00:19');

-- --------------------------------------------------------

--
-- Table structure for table `tai_khoans`
--

CREATE TABLE `tai_khoans` (
  `id` int NOT NULL,
  `ho_ten` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `anh_dai_dien` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `ngay_sinh` date DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `so_dien_thoai` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `gioi_tinh` tinyint(1) NOT NULL DEFAULT '1',
  `dia_chi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `mat_khau` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `ma_xac_thuc` varchar(10) NOT NULL,
  `so_lan_xac_thuc` tinyint NOT NULL DEFAULT '0',
  `thoi_gian_tao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `chuc_vu_id` int NOT NULL,
  `trang_thai` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tai_khoans`
--

INSERT INTO `tai_khoans` (`id`, `ho_ten`, `anh_dai_dien`, `ngay_sinh`, `email`, `so_dien_thoai`, `gioi_tinh`, `dia_chi`, `mat_khau`, `ma_xac_thuc`, `so_lan_xac_thuc`, `thoi_gian_tao`, `chuc_vu_id`, `trang_thai`) VALUES
(1, 'Vũ Hải Anh', NULL, '2005-12-21', 'haiLam@123gmail.com', '123445555', 1, 'Mai Dịch, Cầu Giấy', '123456', '', 0, '2024-09-25 16:31:20', 3, 1),
(2, 'Vũ Hải Lam 1234', NULL, '2024-07-18', 'vuhailam2112@gmail.com', '0966701154', 1, 'Cầu Giấy, Hà Nội', '123456', '', 0, '2024-09-25 16:31:20', 1, 1),
(3, 'Trương Thị Bình12345', NULL, NULL, 'binhtruong1983@gmail.com', '', 1, NULL, '123456', '', 0, '2024-09-25 16:31:20', 2, 1),
(5, 'Lam Hoa Hồng', NULL, NULL, 'lamhoahong123@gmail.com', '124578', 1, NULL, '123456', '', 0, '2024-09-25 16:31:20', 3, 1),
(7, 'Trần hà Linh', './uploads/172786247225083951-25000022-tran-ha-linh.png', '2005-12-21', 'linhha2003@gmail.com', '0966701154', 2, 'Hồ Chí Minh', '123456', '', 0, '2024-09-25 16:31:20', 3, 1),
(8, 'Điêu Tiến Quyết', NULL, '2024-08-15', 'quyet12@gmail.com', NULL, 1, 'hà nội', '123456', '', 0, '2024-09-25 16:31:20', 3, 1),
(9, 'dũng', NULL, NULL, 'dung@gmai.com', NULL, 1, NULL, '123456', '', 0, '2024-09-25 16:31:20', 3, 2),
(10, 'lHuấn Hoa Hồng', NULL, NULL, 'huan@gmail.com', NULL, 1, NULL, '123456', '', 0, '2024-09-25 16:31:20', 3, 1),
(14, 'lam', NULL, NULL, 'lam@gmail.com', NULL, 1, NULL, '$2y$10$HkmXIgIB/Q6v8/LytJ58DOp4MtdYfiDxVUxqnGeo5jjeWD4OAVMhq', '', 0, '2024-09-25 16:31:20', 1, 1),
(15, 'Ng Ngọc', NULL, NULL, 'ngoc@gmail.com', NULL, 1, NULL, '123456', '', 0, '2024-09-25 16:31:20', 3, 2),
(17, 'Tiến', NULL, NULL, 'tien@gmail.com', NULL, 1, NULL, '10ae8202b78142ee114718d2244d37dd', '', 0, '2024-09-25 16:31:20', 2, 1),
(20, 'Hải Lam', NULL, NULL, 'vu@gmail.com', NULL, 1, NULL, '123456', '396472', 0, '2024-09-25 16:51:49', 3, 1),
(23, NULL, NULL, NULL, 'dsga@gmail.com', NULL, 1, NULL, NULL, '949823', 0, '2024-09-25 17:16:30', 2, 1),
(38, NULL, NULL, NULL, 'vuhai', NULL, 1, NULL, '123456', '865860', 0, '2024-09-25 17:37:49', 2, 2),
(45, 'Tiến Bịp', './uploads/1727714638z5821468661771_0dd4b31b353c5b1d62dd44b416a343ae.jpg', '2006-06-19', 'vuhailam211220@gmail.com', '142536032', 2, NULL, '123456', '544208', 1, '2024-09-26 17:36:42', 3, 1),
(46, NULL, NULL, NULL, 'vuhailam21122005@gmail.com', NULL, 1, NULL, '123456', '422179', 0, '2024-09-29 10:46:57', 3, 1),
(47, NULL, NULL, NULL, 'vuhailam211220055@gmail.com', NULL, 1, NULL, '123456', '850014', 1, '2024-09-29 10:48:09', 3, 1),
(48, NULL, NULL, NULL, 'tiendung08102005@gmail.com', NULL, 1, NULL, '123456', '456760', 1, '2024-10-25 04:02:02', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `trang_thai_don_hangs`
--

CREATE TABLE `trang_thai_don_hangs` (
  `id` int NOT NULL,
  `ten_trang_thai` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `trang_thai_don_hangs`
--

INSERT INTO `trang_thai_don_hangs` (`id`, `ten_trang_thai`) VALUES
(1, 'Chưa Xác Nhận'),
(2, 'Đã Xác Nhận'),
(3, 'Chưa Thanh Toán'),
(4, 'Đã Thanh Toán'),
(5, 'Đang Chuẩn Bị Hàng'),
(6, 'Đang Giao'),
(7, 'Đã Giao'),
(8, 'Đã Nhận'),
(9, 'Thành Công'),
(10, 'Hoàn Hàng'),
(11, 'Hủy Đơn');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `binh_luans`
--
ALTER TABLE `binh_luans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chi_tiet_don_hangs`
--
ALTER TABLE `chi_tiet_don_hangs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chi_tiet_gio_hangs`
--
ALTER TABLE `chi_tiet_gio_hangs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chuc_vus`
--
ALTER TABLE `chuc_vus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `danh_mucs`
--
ALTER TABLE `danh_mucs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `DanhMuc_Con` (`parent_id`);

--
-- Indexes for table `don_hangs`
--
ALTER TABLE `don_hangs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gio_hangs`
--
ALTER TABLE `gio_hangs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hinh_anh_san_phams`
--
ALTER TABLE `hinh_anh_san_phams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phuong_thuc_thanh_toans`
--
ALTER TABLE `phuong_thuc_thanh_toans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `san_phams`
--
ALTER TABLE `san_phams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `san_pham_ua_thichs`
--
ALTER TABLE `san_pham_ua_thichs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tai_khoans`
--
ALTER TABLE `tai_khoans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `trang_thai_don_hangs`
--
ALTER TABLE `trang_thai_don_hangs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `binh_luans`
--
ALTER TABLE `binh_luans`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `chi_tiet_don_hangs`
--
ALTER TABLE `chi_tiet_don_hangs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `chi_tiet_gio_hangs`
--
ALTER TABLE `chi_tiet_gio_hangs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `chuc_vus`
--
ALTER TABLE `chuc_vus`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `danh_mucs`
--
ALTER TABLE `danh_mucs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `don_hangs`
--
ALTER TABLE `don_hangs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `gio_hangs`
--
ALTER TABLE `gio_hangs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `hinh_anh_san_phams`
--
ALTER TABLE `hinh_anh_san_phams`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;

--
-- AUTO_INCREMENT for table `phuong_thuc_thanh_toans`
--
ALTER TABLE `phuong_thuc_thanh_toans`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `san_phams`
--
ALTER TABLE `san_phams`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `san_pham_ua_thichs`
--
ALTER TABLE `san_pham_ua_thichs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tai_khoans`
--
ALTER TABLE `tai_khoans`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `trang_thai_don_hangs`
--
ALTER TABLE `trang_thai_don_hangs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `danh_mucs`
--
ALTER TABLE `danh_mucs`
  ADD CONSTRAINT `DanhMuc_Con` FOREIGN KEY (`parent_id`) REFERENCES `danh_mucs` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
