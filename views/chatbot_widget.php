<!-- Chat Bot Widget -->
<div id="chatbot-widget" class="chatbot-widget">
    <!-- Chat Toggle Button -->
    <div id="chatbot-toggle" class="chatbot-toggle">
        <i class="fa fa-comments"></i>
        <span class="chat-notification" id="chat-notification" style="display: none;">1</span>
    </div>

    <!-- Chat Window -->
    <div id="chatbot-window" class="chatbot-window" style="display: none;">
        <!-- Chat Header -->
        <div class="chatbot-header">
            <div class="chatbot-header-left">
                <div class="bot-avatar">
                    <i class="fa fa-robot"></i>
                </div>
                <div class="bot-info">
                    <h4>Trợ lý ảo</h4>
                    <span class="bot-status online">Đang hoạt động</span>
                </div>
            </div>
            <div class="chatbot-header-right">
                <button id="chatbot-minimize" class="btn-icon" title="Thu nhỏ">
                    <i class="fa fa-minus"></i>
                </button>
                <button id="chatbot-close" class="btn-icon" title="Đóng">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>

        <!-- Chat Messages -->
        <div id="chatbot-messages" class="chatbot-messages">
            <!-- Welcome message -->
            <div class="message bot-message">
                <div class="message-avatar">
                    <i class="fa fa-robot"></i>
                </div>
                <div class="message-content">
                    <div class="message-bubble">
                        Xin chào! Tôi là trợ lý ảo của cửa hàng. Tôi có thể giúp gì cho bạn? 😊
                    </div>
                    <div class="message-time" id="welcome-time"></div>
                </div>
            </div>
        </div>        <!-- Chat Input -->
        <div class="chatbot-input">
            <!-- Quick Suggestions -->
            <div id="quick-suggestions" class="quick-suggestions" style="display: block;">
                <div class="suggestion-title">💡 Gợi ý câu hỏi:</div>
                <div class="suggestion-items">
                    <button class="suggestion-btn" data-text="Có sách gì hay không?">📚 Sách hay</button>
                    <button class="suggestion-btn" data-text="Giá sách bao nhiêu?">💰 Giá cả</button>
                    <button class="suggestion-btn" data-text="Giao hàng như thế nào?">🚚 Giao hàng</button>
                    <button class="suggestion-btn" data-text="Có khuyến mãi gì không?">🎉 Khuyến mãi</button>
                    <button class="suggestion-btn" data-text="Tìm sách tiểu thuyết">🔍 Tìm sách</button>
                </div>
            </div>
            
            <div class="input-group">
                <input type="text" id="chatbot-message-input" class="form-control" 
                       placeholder="Nhập tin nhắn của bạn..." maxlength="500">
                <div class="input-group-append">
                    <button id="chatbot-send" class="btn btn-primary" type="button">
                        <i class="fa fa-paper-plane"></i>
                    </button>
                </div>
            </div>
            <div class="chat-actions">
                <button id="chatbot-clear" class="btn-text" title="Xóa cuộc trò chuyện">
                    <i class="fa fa-trash"></i> Xóa chat
                </button>
                <button id="chatbot-popular" class="btn-text" title="Sách bán chạy">
                    <i class="fa fa-fire"></i> Top sách
                </button>
            </div>
        </div>

        <!-- Typing Indicator -->
        <div id="typing-indicator" class="typing-indicator" style="display: none;">
            <div class="message bot-message">
                <div class="message-avatar">
                    <i class="fa fa-robot"></i>
                </div>
                <div class="message-content">
                    <div class="typing-dots">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chat Bot Styles -->
<style>
.chatbot-widget {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 10000;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.chatbot-toggle {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 24px;
    cursor: pointer;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    transition: all 0.3s ease;
    position: relative;
}

.chatbot-toggle:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 25px rgba(0,0,0,0.2);
}

.chat-notification {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #ff4757;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    font-size: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}

.chatbot-window {
    position: absolute;
    bottom: 80px;
    right: 0;
    width: 350px;
    height: 500px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.15);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    animation: chatSlideUp 0.3s ease-out;
}

@keyframes chatSlideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.chatbot-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 15px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.chatbot-header-left {
    display: flex;
    align-items: center;
}

.bot-avatar {
    width: 40px;
    height: 40px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
    font-size: 18px;
}

.bot-info h4 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
}

.bot-status {
    font-size: 12px;
    opacity: 0.9;
}

.bot-status.online:before {
    content: '●';
    color: #2ed573;
    margin-right: 5px;
}

.chatbot-header-right {
    display: flex;
    gap: 5px;
}

.btn-icon {
    background: none;
    border: none;
    color: white;
    padding: 8px;
    border-radius: 4px;
    cursor: pointer;
    transition: background 0.2s;
}

.btn-icon:hover {
    background: rgba(255,255,255,0.1);
}

.chatbot-messages {
    flex: 1;
    padding: 20px 15px;
    overflow-y: auto;
    background: #f8f9fa;
}

.message {
    display: flex;
    margin-bottom: 15px;
    animation: messageSlideIn 0.3s ease-out;
}

@keyframes messageSlideIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.user-message {
    justify-content: flex-end;
}

.user-message .message-content {
    order: -1;
}

.bot-message .message-avatar {
    width: 32px;
    height: 32px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 14px;
    flex-shrink: 0;
    margin-right: 10px;
}

.user-message .message-avatar {
    width: 32px;
    height: 32px;
    background: #007bff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 14px;
    flex-shrink: 0;
    margin-left: 10px;
}

.message-content {
    max-width: 80%;
}

.message-bubble {
    padding: 12px 16px;
    border-radius: 18px;
    word-wrap: break-word;
    line-height: 1.4;
}

.bot-message .message-bubble {
    background: white;
    color: #333;
    border-bottom-left-radius: 4px;
    box-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

.user-message .message-bubble {
    background: #007bff;
    color: white;
    border-bottom-right-radius: 4px;
}

.message-time {
    font-size: 11px;
    color: #999;
    margin-top: 5px;
    text-align: center;
}

.user-message .message-time {
    text-align: right;
}

.chatbot-input {
    padding: 15px;
    border-top: 1px solid #eee;
    background: white;
}

.input-group {
    display: flex;
}

.input-group .form-control {
    flex: 1;
    border: 1px solid #ddd;
    border-radius: 20px;
    padding: 10px 15px;
    font-size: 14px;
    outline: none;
    border-right: none;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}

.input-group .form-control:focus {
    border-color: #667eea;
    box-shadow: none;
}

.input-group-append .btn {
    border-radius: 20px;
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
    padding: 10px 15px;
    background: #667eea;
    border-color: #667eea;
}

.input-group-append .btn:hover {
    background: #5a6fd8;
    border-color: #5a6fd8;
}

.chat-actions {
    text-align: center;
    margin-top: 10px;
}

.btn-text {
    background: none;
    border: none;
    color: #999;
    font-size: 12px;
    cursor: pointer;
    padding: 5px;
    transition: color 0.2s;
}

.btn-text:hover {
    color: #667eea;
}

.typing-indicator {
    padding: 0 15px;
}

.typing-dots {
    display: flex;
    align-items: center;
    padding: 12px 16px;
    background: white;
    border-radius: 18px;
    border-bottom-left-radius: 4px;
    box-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

.typing-dots span {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #ccc;
    margin-right: 4px;
    animation: typingDots 1.4s infinite;
}

.typing-dots span:nth-child(2) {
    animation-delay: 0.2s;
}

.typing-dots span:nth-child(3) {
    animation-delay: 0.4s;
    margin-right: 0;
}

@keyframes typingDots {
    0%, 60%, 100% {
        transform: translateY(0);
        opacity: 0.4;
    }
    30% {
        transform: translateY(-10px);
        opacity: 1;
    }
}

/* Quick Suggestions Styles */
.quick-suggestions {
    margin-bottom: 10px;
    padding: 10px;
    background: #f8f9ff;
    border-radius: 10px;
    border: 1px solid #e1e8ff;
}

.suggestion-title {
    font-size: 12px;
    color: #666;
    margin-bottom: 8px;
    font-weight: 500;
}

.suggestion-items {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
}

.suggestion-btn {
    background: white;
    border: 1px solid #ddd;
    border-radius: 15px;
    padding: 5px 10px;
    font-size: 11px;
    cursor: pointer;
    transition: all 0.2s;
    color: #555;
}

.suggestion-btn:hover {
    background: #667eea;
    color: white;
    border-color: #667eea;
    transform: translateY(-1px);
}

.suggestion-btn:active {
    transform: translateY(0);
}

/* Responsive */
@media (max-width: 768px) {
    .chatbot-window {
        width: 300px;
        height: 450px;
    }
    
    .chatbot-widget {
        bottom: 15px;
        right: 15px;
    }
}

@media (max-width: 480px) {
    .chatbot-window {
        width: calc(100vw - 30px);
        height: 400px;
        right: -10px;
    }
}

/* Scrollbar styling */
.chatbot-messages::-webkit-scrollbar {
    width: 4px;
}

.chatbot-messages::-webkit-scrollbar-track {
    background: transparent;
}

.chatbot-messages::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 2px;
}

.chatbot-messages::-webkit-scrollbar-thumb:hover {
    background: #999;
}
</style>

<!-- Chat Bot JavaScript -->
<script>
class ChatBot {
    constructor() {
        this.isOpen = false;
        this.sessionId = this.generateSessionId();
        this.isTyping = false;
        this.init();
        this.setWelcomeTime();
    }    init() {
        // Event listeners
        document.getElementById('chatbot-toggle').addEventListener('click', () => this.toggleChat());
        document.getElementById('chatbot-close').addEventListener('click', () => this.closeChat());
        document.getElementById('chatbot-minimize').addEventListener('click', () => this.minimizeChat());
        document.getElementById('chatbot-send').addEventListener('click', () => this.sendMessage());
        document.getElementById('chatbot-clear').addEventListener('click', () => this.clearChat());
        document.getElementById('chatbot-popular').addEventListener('click', () => this.showPopularProducts());
        
        // Suggestion buttons
        document.querySelectorAll('.suggestion-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const text = btn.getAttribute('data-text');
                document.getElementById('chatbot-message-input').value = text;
                this.sendMessage();
                this.hideSuggestions();
            });
        });
        
        // Enter key to send message
        document.getElementById('chatbot-message-input').addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                this.sendMessage();
            }
        });

        // Auto-resize input and hide suggestions when typing
        document.getElementById('chatbot-message-input').addEventListener('input', (e) => {
            this.updateCharCount(e.target.value.length);
            if (e.target.value.length > 0) {
                this.hideSuggestions();
            } else {
                this.showSuggestions();
            }
        });

        // Load chat history if user is logged in
        this.loadChatHistory();
    }

    generateSessionId() {
        return 'chat_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
    }

    setWelcomeTime() {
        const now = new Date();
        const time = now.getHours().toString().padStart(2, '0') + ':' + 
                    now.getMinutes().toString().padStart(2, '0');
        document.getElementById('welcome-time').textContent = time;
    }

    toggleChat() {
        if (this.isOpen) {
            this.closeChat();
        } else {
            this.openChat();
        }
    }

    openChat() {
        document.getElementById('chatbot-window').style.display = 'flex';
        document.getElementById('chat-notification').style.display = 'none';
        this.isOpen = true;
        this.focusInput();
        this.scrollToBottom();
    }

    closeChat() {
        document.getElementById('chatbot-window').style.display = 'none';
        this.isOpen = false;
    }

    minimizeChat() {
        this.closeChat();
    }

    focusInput() {
        setTimeout(() => {
            document.getElementById('chatbot-message-input').focus();
        }, 100);
    }

    scrollToBottom() {
        const messagesContainer = document.getElementById('chatbot-messages');
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    async sendMessage() {
        const input = document.getElementById('chatbot-message-input');
        const message = input.value.trim();

        if (!message) return;

        // Add user message to chat
        this.addMessage(message, 'user');
        input.value = '';

        // Show typing indicator
        this.showTyping();

        try {
            const response = await fetch('<?= BASE_URL ?>?act=chatbot-send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    message: message,
                    session_id: this.sessionId
                })
            });

            const data = await response.json();

            if (data.success) {
                // Hide typing and add bot response
                this.hideTyping();
                this.addMessage(data.response, 'bot', data.timestamp);
                
                // Update session ID if provided
                if (data.session_id) {
                    this.sessionId = data.session_id;
                }
            } else {
                this.hideTyping();
                this.addMessage('Xin lỗi, có lỗi xảy ra. Vui lòng thử lại sau.', 'bot');
            }
        } catch (error) {
            console.error('Chat error:', error);
            this.hideTyping();
            this.addMessage('Không thể kết nối. Vui lòng kiểm tra kết nối internet.', 'bot');
        }
    }    addMessage(message, sender, timestamp = null) {
        const messagesContainer = document.getElementById('chatbot-messages');
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${sender}-message`;

        const now = new Date();
        const time = timestamp || (now.getHours().toString().padStart(2, '0') + ':' + 
                     now.getMinutes().toString().padStart(2, '0'));

        const avatarIcon = sender === 'bot' ? 'fa-robot' : 'fa-user';

        // Enhanced message formatting for bot messages
        const formattedMessage = sender === 'bot' ? 
            this.enhanceMessage(message).replace(/\n/g, '<br>') : 
            this.escapeHtml(message);

        messageDiv.innerHTML = `
            <div class="message-avatar">
                <i class="fa ${avatarIcon}"></i>
            </div>
            <div class="message-content">
                <div class="message-bubble">
                    ${formattedMessage}
                </div>
                <div class="message-time">${time}</div>
            </div>
        `;

        messagesContainer.appendChild(messageDiv);
        this.scrollToBottom();
    }

    showTyping() {
        if (this.isTyping) return;
        
        this.isTyping = true;
        document.getElementById('typing-indicator').style.display = 'block';
        this.scrollToBottom();
    }

    hideTyping() {
        this.isTyping = false;
        document.getElementById('typing-indicator').style.display = 'none';
    }

    async clearChat() {
        if (confirm('Bạn có chắc muốn xóa cuộc trò chuyện này?')) {
            const messagesContainer = document.getElementById('chatbot-messages');
            
            // Remove all messages except welcome message
            const messages = messagesContainer.querySelectorAll('.message');
            messages.forEach((message, index) => {
                if (index > 0) { // Keep first message (welcome)
                    message.remove();
                }
            });

            // Generate new session ID
            this.sessionId = this.generateSessionId();

            try {
                await fetch('<?= BASE_URL ?>?act=chatbot-clear', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                });
            } catch (error) {
                console.error('Clear chat error:', error);
            }
        }
    }

    async loadChatHistory() {
        try {
            const response = await fetch(`<?= BASE_URL ?>?act=chatbot-history&session_id=${this.sessionId}`);
            const data = await response.json();

            if (data.success && data.history.length > 0) {
                // Clear welcome message first
                const messagesContainer = document.getElementById('chatbot-messages');
                messagesContainer.innerHTML = '';

                // Add history messages
                data.history.forEach(chat => {
                    this.addMessage(chat.user_message, 'user', chat.timestamp);
                    this.addMessage(chat.bot_response, 'bot', chat.timestamp);
                });
            }
        } catch (error) {
            console.error('Load history error:', error);
        }
    }

    updateCharCount(length) {
        // You can add character count display here if needed
        const maxLength = 500;
        if (length > maxLength * 0.9) {
            // Show warning when approaching limit
            console.log(`${length}/${maxLength} characters`);
        }
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    showSuggestions() {
        const suggestions = document.getElementById('quick-suggestions');
        if (suggestions) {
            suggestions.style.display = 'block';
        }
    }
    
    hideSuggestions() {
        const suggestions = document.getElementById('quick-suggestions');
        if (suggestions) {
            suggestions.style.display = 'none';
        }
    }
    
    async showPopularProducts() {
        try {
            this.showTyping();
            
            const response = await fetch('<?= BASE_URL ?>?act=chatbot-popular-products');
            const data = await response.json();
            
            this.hideTyping();
            
            if (data.success && data.products.length > 0) {
                let message = "🔥 Top sách bán chạy nhất:\n\n";
                data.products.forEach((product, index) => {
                    const price = product.gia_khuyen_mai ? 
                        `${this.formatPrice(product.gia_khuyen_mai)} (Giảm từ ${this.formatPrice(product.gia_san_pham)})` : 
                        this.formatPrice(product.gia_san_pham);
                    
                    message += `${index + 1}. 📚 ${product.ten_san_pham}\n`;
                    message += `   💰 Giá: ${price}\n`;
                    message += `   📁 Thể loại: ${product.ten_danh_muc}\n`;
                    message += `   👀 Lượt xem: ${this.formatNumber(product.luot_xem)}\n\n`;
                });
                
                this.addMessage(message, 'bot');
            } else {
                this.addMessage('Xin lỗi, không thể lấy danh sách sản phẩm bán chạy lúc này.', 'bot');
            }
        } catch (error) {
            this.hideTyping();
            this.addMessage('Có lỗi xảy ra khi lấy danh sách sản phẩm.', 'bot');
            console.error('Error fetching popular products:', error);
        }
    }
    
    formatPrice(price) {
        return new Intl.NumberFormat('vi-VN').format(price) + 'đ';
    }
    
    formatNumber(num) {
        return new Intl.NumberFormat('vi-VN').format(num);
    }
    
    enhanceMessage(message) {
        // Add links for products if message contains product info
        message = message.replace(/📚 ([^\n]+)/g, '<strong>📚 $1</strong>');
        message = message.replace(/💰 ([^\n]+)/g, '<span style="color: #e74c3c;">💰 $1</span>');
        message = message.replace(/📁 ([^\n]+)/g, '<em>📁 $1</em>');
        message = message.replace(/👀 ([^\n]+)/g, '<small style="color: #666;">👀 $1</small>');
        
        return message;
    }

    // Show notification badge
    showNotification() {
        if (!this.isOpen) {
            document.getElementById('chat-notification').style.display = 'block';
        }
    }
}

// Initialize chatbot when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.chatBot = new ChatBot();
    
    // Optional: Show notification after some time if chat hasn't been opened
    setTimeout(() => {
        if (!window.chatBot.isOpen) {
            window.chatBot.showNotification();
        }
    }, 30000); // Show after 30 seconds
});
</script>
