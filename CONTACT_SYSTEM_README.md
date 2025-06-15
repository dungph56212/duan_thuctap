# 📞 Hệ Thống Liên Hệ Nâng Cao

## 🎯 Tổng Quan

Hệ thống liên hệ hoàn chỉnh với giao diện đẹp, tính năng mạnh mẽ và trải nghiệm người dùng tuyệt vời. Bao gồm cả phần khách hàng và quản trị viên.

## ✨ Tính Năng Chính

### 👤 Dành Cho Khách Hàng
- ✅ Form liên hệ đẹp với floating labels
- ✅ Validation dữ liệu real-time
- ✅ Tự động gửi email xác nhận
- ✅ Kiểm tra phản hồi bằng email
- ✅ Hiển thị lịch sử liên hệ với timeline
- ✅ Responsive design cho mọi thiết bị

### 🔧 Dành Cho Admin
- ✅ Dashboard với thống kê chi tiết
- ✅ Quản lý liên hệ với phân trang
- ✅ Bộ lọc và tìm kiếm nâng cao
- ✅ Phân loại theo trạng thái và ưu tiên
- ✅ Hệ thống phản hồi nhanh
- ✅ Bulk actions (thao tác hàng loạt)
- ✅ Gửi email thông báo tự động

## 🛠️ Cài Đặt

### Bước 1: Cập Nhật Cơ Sở Dữ Liệu
```
Truy cập: http://localhost/duan_thuctap/update_database.php
```
File này sẽ tự động:
- Thêm các cột cần thiết vào bảng `lienhe`
- Tạo indexes để tối ưu hiệu suất
- Thêm dữ liệu mẫu để test

### Bước 2: Kiểm Tra Hệ Thống
```
Truy cập: http://localhost/duan_thuctap/test_contact_system.php
```
File này sẽ kiểm tra:
- Cấu trúc bảng database
- Tính năng của Model và Controller
- Liên kết URLs
- Indexes và hiệu suất

### Bước 3: Xem Demo
```
Truy cập: http://localhost/duan_thuctap/demo_contact_system.html
```
Trang demo với đầy đủ thông tin và hướng dẫn sử dụng.

## 📂 Cấu Trúc File

```
duan_thuctap/
│
├── views/
│   └── lienhe.php                     # Trang liên hệ khách hàng
│
├── controllers/
│   └── LienHeController.php           # Controller xử lý logic
│
├── models/
│   └── LienHe.php                     # Model database
│
├── admin/
│   ├── controllers/
│   │   └── LienHeController.php       # Admin controller
│   │
│   └── views/lienhe/
│       ├── listLienHe.php            # Danh sách liên hệ
│       ├── viewLienHe.php            # Chi tiết liên hệ
│       └── statsLienHe.php           # Thống kê
│
├── update_database.php               # Script cập nhật DB
├── test_contact_system.php          # Test hệ thống
├── demo_contact_system.html         # Trang demo
└── update_lienhe_structure.sql      # SQL script
```

## 🎨 Giao Diện

### Trang Khách Hàng
- **Hero Section**: Banner gradient đẹp mắt
- **Contact Form**: Form với floating labels và validation
- **Contact Info**: Thông tin liên hệ với icons
- **Reply Checker**: Kiểm tra phản hồi với timeline
- **Responsive**: Hoạt động tốt trên mọi thiết bị

### Admin Panel
- **Dashboard**: Thống kê tổng quan với cards
- **Contact List**: Bảng dữ liệu với phân trang
- **Filters**: Lọc theo trạng thái, ưu tiên, ngày tháng
- **Quick Actions**: Phản hồi nhanh, đánh dấu đã đọc
- **Detail View**: Xem chi tiết và lịch sử liên hệ

## 📊 Database Schema

### Bảng `lienhe`
| Cột | Kiểu | Mô tả |
|-----|------|-------|
| `id` | INT | Primary key |
| `name` | VARCHAR(255) | Tên khách hàng |
| `email` | VARCHAR(255) | Email khách hàng |
| `phone` | VARCHAR(20) | Số điện thoại |
| `subject` | VARCHAR(500) | Chủ đề liên hệ |
| `message` | TEXT | Nội dung liên hệ |
| `status` | ENUM | pending, read, replied, closed |
| `priority` | ENUM | low, normal, high, urgent |
| `reply_message` | TEXT | Nội dung phản hồi |
| `replied_by` | INT | ID admin phản hồi |
| `replied_at` | DATETIME | Thời gian phản hồi |
| `ip_address` | VARCHAR(45) | IP address |
| `user_agent` | TEXT | Thông tin trình duyệt |
| `is_read` | TINYINT | Đã đọc chưa |
| `created_at` | DATETIME | Thời gian tạo |
| `updated_at` | DATETIME | Thời gian cập nhật |

## 🔗 URLs Chính

### Client Side
- **Trang liên hệ**: `index.php?act=lienhe`
- **Kiểm tra phản hồi**: `index.php?act=lienhe&lookup=1&email=...`

### Admin Side
- **Dashboard**: `admin/index.php?ctl=lienhe`
- **Danh sách**: `admin/index.php?ctl=lienhe&act=list`
- **Chi tiết**: `admin/index.php?ctl=lienhe&act=view&id=...`
- **Thống kê**: `admin/index.php?ctl=lienhe&act=stats`

## 🎛️ Tính Năng Nâng Cao

### Email System
- **Auto-notification**: Thông báo admin khi có liên hệ mới
- **Customer confirmation**: Email xác nhận cho khách hàng
- **HTML templates**: Email template đẹp với CSS

### Security Features
- **Input validation**: Kiểm tra dữ liệu đầu vào
- **SQL injection protection**: Sử dụng prepared statements
- **XSS protection**: Escape output data
- **CSRF protection**: Token validation

### Performance
- **Database indexing**: Indexes cho tìm kiếm nhanh
- **Pagination**: Phân trang cho dữ liệu lớn
- **Caching**: Cache thống kê và dữ liệu
- **Optimized queries**: Truy vấn tối ưu

## 🎯 Hướng Dẫn Sử Dụng

### Cho Khách Hàng
1. **Gửi liên hệ**:
   - Truy cập trang liên hệ
   - Điền đầy đủ thông tin
   - Chọn chủ đề phù hợp
   - Nhấn "Gửi tin nhắn"

2. **Kiểm tra phản hồi**:
   - Scroll xuống phần "Kiểm tra phản hồi"
   - Nhập email đã sử dụng
   - Có thể nhập mã liên hệ (tùy chọn)
   - Xem kết quả với timeline đẹp

### Cho Admin
1. **Xem tổng quan**:
   - Đăng nhập admin panel
   - Truy cập quản lý liên hệ
   - Xem dashboard với thống kê

2. **Quản lý liên hệ**:
   - Sử dụng bộ lọc để tìm liên hệ
   - Click vào liên hệ để xem chi tiết
   - Phản hồi trực tiếp từ giao diện
   - Cập nhật trạng thái và ưu tiên

## 🔧 Customization

### Thay Đổi Email Templates
Chỉnh sửa trong `controllers/LienHeController.php`:
```php
private function sendAdminNotification($name, $email, ...)
private function sendCustomerConfirmation($name, $email, ...)
```

### Thay Đổi Màu Sắc
Chỉnh sửa CSS trong `views/lienhe.php`:
```css
/* Gradient chính */
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);

/* Màu accent */
border-color: #667eea;
```

### Thêm Trường Mới
1. Cập nhật database schema
2. Chỉnh sửa Model `LienHe.php`
3. Cập nhật form trong `views/lienhe.php`
4. Chỉnh sửa admin views

## 🚀 Production Deployment

### Bước 1: Cấu Hình Email
```php
// Trong LienHeController.php
$to = 'your-admin@domain.com';  // Email admin thực tế
$from = 'noreply@yourdomain.com';  // Email gửi đi
```

### Bước 2: Bảo Mật
- Xóa file `update_database.php` sau khi cài đặt
- Xóa file `test_contact_system.php` sau khi test
- Thiết lập HTTPS cho production
- Cấu hình rate limiting

### Bước 3: Backup
- Backup database thường xuyên
- Monitor log files
- Thiết lập email alerts

## 📞 Hỗ Trợ

Nếu cần hỗ trợ:
1. Kiểm tra file `test_contact_system.php` để debug
2. Xem log errors trong browser console
3. Kiểm tra database connection
4. Verify email configuration

## 📝 Changelog

### v2.0.0 (Current)
- ✅ Hoàn thiện giao diện client
- ✅ Thêm hệ thống kiểm tra phản hồi
- ✅ Cải thiện admin dashboard
- ✅ Thêm timeline và animations
- ✅ Responsive design
- ✅ Security enhancements

### v1.0.0
- ✅ Basic contact form
- ✅ Admin management
- ✅ Database structure
- ✅ Email notifications

---

**🎉 Chúc bạn sử dụng hệ thống thành công!** 

*Được phát triển với ❤️ và ☕*
