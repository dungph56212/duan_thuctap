# Hướng dẫn tích hợp ChatBot AI

## 🤖 Tổng quan
Hệ thống ChatBot AI đã được tích hợp vào website với các tính năng:
- Chat bot AI thông minh với nhiều pattern nhận diện
- Lưu trữ lịch sử chat
- Giao diện đẹp và responsive
- Hỗ trợ cả người dùng đã đăng nhập và guest
- API endpoints hoàn chỉnh

## 📋 Cài đặt

### 1. Tạo Database Tables
Chạy lệnh sau để tạo các bảng cần thiết:

```bash
php setup_chatbot_database.php
```

Hoặc import trực tiếp file `chatbot_database.sql` vào database.

### 2. Kiểm tra kết nối
Mở trình duyệt và truy cập:
```
http://your-domain/test_chatbot.php
```

## 🚀 Cách sử dụng

### Cho người dùng cuối:
1. Vào bất kỳ trang nào của website
2. Nhấn vào biểu tượng chat ở góc phải màn hình
3. Gửi tin nhắn và nhận phản hồi từ bot

### Các câu hỏi mẫu bot có thể trả lời:
- "Xin chào" - Chào hỏi
- "Sản phẩm có gì?" - Hỏi về sản phẩm
- "Giá bao nhiều?" - Hỏi về giá cả
- "Giao hàng như thế nào?" - Hỏi về vận chuyển
- "Khuyến mãi" - Hỏi về ưu đãi
- "Liên hệ" - Thông tin liên hệ
- "Cảm ơn" - Cảm ơn

## 🔧 Cấu hình

### Thêm câu trả lời mới:
Chỉnh sửa file `models/ChatBot.php`, function `getResponse()`:

```php
$patterns = [
    // Thêm pattern mới
    '/(từ khóa|keyword)/' => [
        'Câu trả lời 1',
        'Câu trả lời 2',
        'Câu trả lời 3'
    ],
    // ...existing patterns
];
```

### Tích hợp OpenAI (tùy chọn):
1. Lấy API key từ OpenAI
2. Cập nhật trong file `models/ChatBot.php`:
```php
$apiKey = 'your-openai-api-key-here';
```
3. Gọi `getOpenAIResponse()` thay vì `getResponse()`

## 📁 Cấu trúc Files

```
├── chatbot_database.sql          # Database schema
├── models/ChatBot.php           # ChatBot model
├── controllers/ChatBotController.php  # ChatBot controller
├── views/chatbot_widget_new.php # ChatBot widget UI
├── setup_chatbot_database.php   # Database setup script
├── test_chatbot.php            # Test interface
```

## 🌐 API Endpoints

### 1. Gửi tin nhắn
```
POST /?act=chatbot-send-message
Body: {
    "message": "Xin chào",
    "session_id": "optional_session_id"
}
```

### 2. Lấy lịch sử chat
```
GET /?act=chatbot-get-history&session_id=session_id
```

### 3. Xóa chat
```
POST /?act=chatbot-clear-chat
```

### 4. Test API
```
GET /?act=chatbot-test
```

## 🎨 Tùy chỉnh giao diện

### Thay đổi màu sắc:
Chỉnh sửa trong file `views/chatbot_widget_new.php`:

```css
.chatbot-toggle {
    background: linear-gradient(135deg, #your-color1 0%, #your-color2 100%);
}
```

### Thay đổi vị trí:
```css
.chatbot-widget {
    bottom: 20px;  /* Khoảng cách từ đáy */
    right: 20px;   /* Khoảng cách từ bên phải */
}
```

## 📊 Monitoring & Analytics

### Xem thống kê (chỉ dành cho admin):
```
GET /?act=chatbot-stats
```

### Database cleanup:
Chạy định kỳ để xóa chat cũ:
```php
$chatBot = new ChatBot();
$chatBot->cleanupOldChats(30); // Xóa chats cũ hơn 30 ngày
```

## 🔒 Bảo mật

1. **Rate limiting**: Đã có giới hạn 10 tin nhắn/phút
2. **Input validation**: Giới hạn độ dài tin nhắn tối đa 500 ký tự
3. **XSS protection**: Tự động escape HTML trong tin nhắn
4. **Session management**: Sử dụng session_id cho guest users

## 🐛 Troubleshooting

### Bot không hiển thị:
1. Kiểm tra Font Awesome đã load chưa
2. Kiểm tra JavaScript console có lỗi không
3. Đảm bảo file `chatbot_widget_new.php` đã được include

### API không hoạt động:
1. Kiểm tra database connection
2. Kiểm tra routes trong `index.php`
3. Kiểm tra file `ChatBotController.php` và `ChatBot.php`

### Database lỗi:
1. Chạy lại `setup_chatbot_database.php`
2. Kiểm tra permissions database
3. Xem log lỗi trong PHP error log

## 📱 Responsive Design

ChatBot widget đã được tối ưu cho:
- Desktop: Full functionality
- Tablet: Responsive width
- Mobile: Optimized for small screens

## 🔄 Future Enhancements

Có thể mở rộng thêm:
1. **Machine Learning**: Tích hợp model ML cho phản hồi thông minh hơn
2. **Multi-language**: Hỗ trợ đa ngôn ngữ
3. **File upload**: Cho phép gửi hình ảnh
4. **Voice chat**: Tích hợp speech-to-text
5. **Admin panel**: Quản lý và training bot

## 📞 Hỗ trợ

Nếu có vấn đề, vui lòng:
1. Kiểm tra file `test_chatbot.php` trước
2. Xem PHP error logs
3. Kiểm tra JavaScript console
4. Liên hệ developer

---

**Chúc bạn sử dụng ChatBot AI thành công! 🎉**
