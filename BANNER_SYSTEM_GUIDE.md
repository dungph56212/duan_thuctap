# 🎯 HỆ THỐNG BANNER QUẢNG CÁO - HƯỚNG DẪN TOÀN DIỆN

## 📋 TỔNG QUAN

Hệ thống banner quảng cáo đã được nâng cấp toàn diện với các tính năng:

### ✨ TÍNH NĂNG CHÍNH

#### 🔧 **Quản lý Banner (Admin)**
- ✅ CRUD đầy đủ (Thêm/Sửa/Xóa/Xem)
- ✅ Upload hình ảnh với preview
- ✅ 4 loại hiển thị: Popup, Top, Bottom, Sidebar
- ✅ Lập lịch hiển thị (từ ngày - đến ngày)
- ✅ Thống kê lượt xem/click, CTR
- ✅ Bulk actions (kích hoạt/tạm dừng/xóa hàng loạt)
- ✅ Lọc và tìm kiếm nâng cao
- ✅ Real-time status toggle
- ✅ Sao chép banner

#### 🎨 **Hiển thị Banner (Client)**
- ✅ Banner popup với hiệu ứng đẹp
- ✅ Banner top/bottom cố định
- ✅ Banner sidebar nổi
- ✅ Responsive trên mọi thiết bị
- ✅ Tracking lượt xem/click tự động
- ✅ Hiển thị theo lịch trình
- ✅ Chỉ hiển thị 1 lần/session (tùy chọn)

#### 📞 **Hệ thống Liên hệ nâng cao**
- ✅ Form liên hệ chính
- ✅ Form kiểm tra phản hồi admin ngay dưới form chính
- ✅ Timeline hiển thị lịch sử liên hệ
- ✅ Hiển thị trạng thái phản hồi
- ✅ Giao diện timeline đẹp với animation
- ✅ Responsive hoàn toàn

---

## 🚀 CÁCH SỬ DỤNG

### 1. **Setup Ban Đầu**
```bash
# Truy cập link setup tự động
http://localhost/duan_thuctap/setup_banner_system.php
```

### 2. **Quản Lý Banner (Admin)**
```bash
# Vào admin panel
http://localhost/duan_thuctap/admin/?act=danh-sach-banner
```

#### Thêm Banner Mới:
1. Click "Thêm Banner"
2. Điền thông tin:
   - Tên banner (bắt buộc)
   - Mô tả
   - Upload hình ảnh (JPG/PNG/GIF/WEBP, max 5MB)
   - Link URL (tùy chọn)
   - Loại hiển thị (Popup/Top/Bottom/Sidebar)
   - Thứ tự hiển thị
   - Thời gian hiển thị (cho popup)
   - Lịch trình hiển thị

#### Quản Lý Banner:
- **Bật/Tắt**: Click switch trạng thái
- **Sửa**: Click nút "Sửa" 
- **Xóa**: Click nút "Xóa"
- **Sao chép**: Click nút "Sao chép"
- **Xem trước**: Click vào hình ảnh

#### Bulk Actions:
1. Chọn nhiều banner bằng checkbox
2. Click "Kích hoạt/Tạm dừng/Xóa đã chọn"

### 3. **Xem Banner Trên Client**
```bash
# Truy cập trang chủ để xem banner
http://localhost/duan_thuctap/
```

### 4. **Hệ thống Liên hệ**
```bash
# Trang liên hệ với form kiểm tra phản hồi
http://localhost/duan_thuctap/?act=lienhe
```

---

## 📁 CẤU TRÚC FILE

### **Controllers**
```
controllers/
├── BannerController.php          # API lấy banner cho client
└── LienHeController.php          # Xử lý liên hệ và phản hồi

admin/controllers/
└── BannerAdsController.php       # Quản lý banner admin
```

### **Models**
```
models/
└── LienHe.php                    # Model liên hệ

admin/models/
└── BannerAds.php                 # Model banner
```

### **Views**
```
views/
├── layout/
│   ├── header.php               # Tích hợp banner system JS
│   └── footer.php               # Enhanced banner JS
└── lienhe.php                   # Form liên hệ + kiểm tra phản hồi

admin/views/banner/
├── listBanner.php               # Danh sách banner (nâng cấp)
├── addBanner.php                # Thêm banner
└── editBanner.php               # Sửa banner
```

### **Database**
```
database/
└── banner_ads_table.sql         # Cấu trúc bảng banner
```

### **Assets**
```
assets/js/
└── banner-popup.js              # JavaScript banner system (cũ)

uploads/banners/                 # Thư mục lưu ảnh banner
```

---

## 🎛️ CẤU HÌNH

### **Loại Banner**
1. **Popup**: Hiển thị popup giữa màn hình
2. **Banner Top**: Hiển thị ở đầu trang
3. **Banner Bottom**: Hiển thị ở cuối trang  
4. **Sidebar**: Hiển thị bên cạnh (fixed position)

### **Tùy chọn Popup**
- **Thời gian hiển thị**: 1000ms - không giới hạn
- **Hiển thị 1 lần/session**: Có/Không
- **Auto close**: Tự động đóng sau thời gian quy định

### **Lập lịch**
- **Ngày bắt đầu**: Ngày bắt đầu hiển thị
- **Ngày kết thúc**: Ngày kết thúc hiển thị
- **Để trống**: Hiển thị vô thời hạn

---

## 📊 THỐNG KÊ & BÁO CÁO

### **Chỉ số hiệu suất**
- **Lượt xem**: Số lần banner được hiển thị
- **Lượt click**: Số lần banner được click
- **CTR**: Click Through Rate (%)
- **Trạng thái**: Active/Inactive/Expired/Upcoming

### **Báo cáo tổng quan**
- Tổng số banner
- Banner đang hoạt động
- Banner popup
- Tổng lượt xem/click
- CTR trung bình

---

## 🔧 API ENDPOINTS

### **Public API (Client)**
```php
GET /controllers/BannerController.php?action=getActiveBanners
// Lấy danh sách banner active

POST /controllers/BannerController.php
// body: action=trackView&banner_id=1
// Track lượt xem

POST /controllers/BannerController.php  
// body: action=trackClick&banner_id=1
// Track lượt click
```

### **Admin API**
```php
POST /admin/?act=update-banner-status
// body: id=1&status=1
// Cập nhật trạng thái banner

POST /admin/?act=duplicate-banner
// body: id=1
// Sao chép banner

POST /admin/?act=bulk-activate-banners
// body: banner_ids[]=1&banner_ids[]=2
// Kích hoạt hàng loạt
```

---

## 🎨 GIAO DIỆN & UX

### **Admin Panel**
- ✅ Giao diện Bootstrap 5 hiện đại
- ✅ Table responsive với preview ảnh
- ✅ Status toggle real-time
- ✅ Modal preview banner
- ✅ Notification toast
- ✅ Loading states
- ✅ Bulk selection
- ✅ Advanced filters

### **Client Side**
- ✅ Banner popup với animation smooth
- ✅ Close button đẹp
- ✅ Click tracking tự động
- ✅ Responsive design
- ✅ ESC key để đóng popup
- ✅ Click overlay để đóng

### **Contact Form**
- ✅ Form liên hệ chính với floating labels
- ✅ Form kiểm tra phản hồi admin ngay dưới
- ✅ Timeline hiển thị lịch sử
- ✅ Status badges đẹp
- ✅ Animation entrance effects
- ✅ Mobile responsive

---

## 🛠️ TROUBLESHOOTING

### **Lỗi thường gặp**

1. **Banner không hiển thị**
   - ✅ Kiểm tra trạng thái banner (active)
   - ✅ Kiểm tra lịch trình hiển thị
   - ✅ Kiểm tra đường dẫn ảnh
   - ✅ Xem console browser có lỗi JS không

2. **Không upload được ảnh**
   - ✅ Kiểm tra quyền thư mục uploads/banners/
   - ✅ Kiểm tra kích thước file (max 5MB)
   - ✅ Kiểm tra định dạng file (JPG/PNG/GIF/WEBP)

3. **Tracking không hoạt động**
   - ✅ Kiểm tra API endpoint
   - ✅ Kiểm tra database connection
   - ✅ Xem network tab trong dev tools

### **Debug**
```php
// Bật debug mode
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Test API
http://localhost/duan_thuctap/test_banner_system.php
```

---

## 📈 NÂNG CẤP TƯƠNG LAI

### **Có thể thêm**
- 🔄 A/B Testing banner
- 📱 Push notification integration  
- 🎯 Targeting theo user behavior
- 📊 Google Analytics integration
- 🌐 Multi-language support
- 📅 Campaign scheduling
- 🖼️ Video banner support
- 🎨 Banner templates
- 📧 Email banner support

---

## 👥 HƯỚNG DẪN SỬ DỤNG CHO USER

### **Khách hàng:**
1. Truy cập website
2. Xem banner popup (nếu có)
3. Click banner để chuyển đến trang liên quan
4. Banner chỉ hiển thị 1 lần/session

### **Admin:**
1. Đăng nhập admin panel
2. Vào "Quản lý Banner"
3. Thêm/sửa/xóa banner
4. Theo dõi thống kê hiệu suất
5. Bật/tắt banner theo nhu cầu

### **Liên hệ & Phản hồi:**
1. Khách hàng gửi liên hệ qua form
2. Admin phản hồi trong panel
3. Khách hàng kiểm tra phản hồi bằng email
4. Timeline hiển thị lịch sử đầy đủ

---

## 🎉 KẾT LUẬN

Hệ thống banner và liên hệ đã được hoàn thiện với:

✅ **Quản lý banner chuyên nghiệp**
✅ **Hiển thị banner đa dạng và đẹp**  
✅ **Tracking hiệu suất chi tiết**
✅ **Hệ thống liên hệ và phản hồi hoàn chỉnh**
✅ **Giao diện responsive và hiện đại**
✅ **API đầy đủ cho tích hợp**

🚀 **Sẵn sàng sử dụng ngay!**
