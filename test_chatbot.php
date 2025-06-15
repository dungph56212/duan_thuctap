<?php
// File: test_chatbot.php
// Test chatbot functionality

session_start();
require_once 'commons/env.php';
require_once 'commons/function.php';
require_once 'models/ChatBot.php';
require_once 'controllers/ChatBotController.php';

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test ChatBot</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .test-section {
            margin-bottom: 30px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .test-section h3 {
            margin-top: 0;
            color: #333;
        }
        .btn {
            background: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;
        }
        .btn:hover {
            background: #0056b3;
        }
        .result {
            margin-top: 10px;
            padding: 10px;
            border-radius: 5px;
            font-family: monospace;
        }
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .chat-demo {
            border: 1px solid #ddd;
            height: 300px;
            overflow-y: auto;
            padding: 10px;
            margin: 10px 0;
            background: #f9f9f9;
        }
        .message {
            margin: 10px 0;
            padding: 8px 12px;
            border-radius: 15px;
        }
        .user-message {
            background: #007bff;
            color: white;
            text-align: right;
            margin-left: 100px;
        }
        .bot-message {
            background: #e9ecef;
            color: #333;
            margin-right: 100px;
        }
        input[type="text"] {
            width: 70%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-robot"></i> Test ChatBot System</h1>
        
        <!-- Database Test -->
        <div class="test-section">
            <h3>1. Kiểm tra Database</h3>
            <button class="btn" onclick="testDatabase()">Test Database Connection</button>
            <div id="db-result" class="result"></div>
        </div>

        <!-- Model Test -->
        <div class="test-section">
            <h3>2. Kiểm tra ChatBot Model</h3>
            <button class="btn" onclick="testModel()">Test Model Functions</button>
            <div id="model-result" class="result"></div>
        </div>

        <!-- API Test -->
        <div class="test-section">
            <h3>3. Kiểm tra API</h3>
            <button class="btn" onclick="testAPI()">Test API Endpoints</button>
            <div id="api-result" class="result"></div>
        </div>

        <!-- Interactive Chat Demo -->
        <div class="test-section">
            <h3>4. Demo Chat</h3>
            <div id="chat-demo" class="chat-demo"></div>
            <input type="text" id="chat-input" placeholder="Nhập tin nhắn...">
            <button class="btn" onclick="sendTestMessage()">Gửi</button>
            <button class="btn" onclick="clearChat()">Xóa Chat</button>
        </div>
    </div>

    <script>
        let sessionId = 'test_' + Date.now();

        async function testDatabase() {
            const result = document.getElementById('db-result');
            result.innerHTML = 'Đang kiểm tra...';
            
            try {
                // Test database connection
                const response = await fetch('?act=chatbot-test');
                const data = await response.json();
                
                if (data.success) {
                    result.innerHTML = `<div class="success">✅ Database kết nối thành công!<br>Timestamp: ${data.timestamp}</div>`;
                } else {
                    result.innerHTML = `<div class="error">❌ Lỗi database</div>`;
                }
            } catch (error) {
                result.innerHTML = `<div class="error">❌ Lỗi: ${error.message}</div>`;
            }
        }

        async function testModel() {
            const result = document.getElementById('model-result');
            result.innerHTML = 'Đang kiểm tra...';
            
            try {
                // Test với một số tin nhắn mẫu
                const testMessages = [
                    'Xin chào',
                    'Sản phẩm có gì?',
                    'Giá bao nhiều?',
                    'Giao hàng như thế nào?',
                    'Cảm ơn'
                ];
                
                let results = '<div class="success">✅ Model hoạt động tốt:<br>';
                
                for (const msg of testMessages) {
                    const response = await fetch('?act=chatbot-send-message', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            message: msg,
                            session_id: sessionId + '_test'
                        })
                    });
                    
                    const data = await response.json();
                    if (data.success) {
                        results += `<br><strong>${msg}</strong> → ${data.response.substring(0, 100)}...`;
                    }
                }
                
                results += '</div>';
                result.innerHTML = results;
            } catch (error) {
                result.innerHTML = `<div class="error">❌ Lỗi Model: ${error.message}</div>`;
            }
        }

        async function testAPI() {
            const result = document.getElementById('api-result');
            result.innerHTML = 'Đang kiểm tra API endpoints...';
            
            try {
                let results = '<div class="success">✅ API Test Results:<br>';
                
                // Test send message
                const sendResponse = await fetch('?act=chatbot-send-message', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        message: 'Hello API test',
                        session_id: sessionId + '_api'
                    })
                });
                const sendData = await sendResponse.json();
                results += `<br>✅ Send Message: ${sendData.success ? 'OK' : 'FAIL'}`;
                
                // Test get history
                const historyResponse = await fetch(`?act=chatbot-get-history&session_id=${sessionId}_api`);
                const historyData = await historyResponse.json();
                results += `<br>✅ Get History: ${historyData.success ? 'OK' : 'FAIL'}`;
                
                // Test clear chat
                const clearResponse = await fetch('?act=chatbot-clear-chat', { method: 'POST' });
                const clearData = await clearResponse.json();
                results += `<br>✅ Clear Chat: ${clearData.success ? 'OK' : 'FAIL'}`;
                
                results += '</div>';
                result.innerHTML = results;
            } catch (error) {
                result.innerHTML = `<div class="error">❌ Lỗi API: ${error.message}</div>`;
            }
        }

        async function sendTestMessage() {
            const input = document.getElementById('chat-input');
            const message = input.value.trim();
            
            if (!message) return;
            
            const chatDemo = document.getElementById('chat-demo');
            
            // Add user message
            chatDemo.innerHTML += `<div class="message user-message">${message}</div>`;
            
            try {
                const response = await fetch('?act=chatbot-send-message', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        message: message,
                        session_id: sessionId
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    chatDemo.innerHTML += `<div class="message bot-message">${data.response}</div>`;
                } else {
                    chatDemo.innerHTML += `<div class="message bot-message">Lỗi: ${data.error}</div>`;
                }
                
                chatDemo.scrollTop = chatDemo.scrollHeight;
                input.value = '';
            } catch (error) {
                chatDemo.innerHTML += `<div class="message bot-message">Lỗi kết nối: ${error.message}</div>`;
            }
        }

        function clearChat() {
            document.getElementById('chat-demo').innerHTML = '';
        }

        // Enter key to send message
        document.getElementById('chat-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendTestMessage();
            }
        });
    </script>
</body>
</html>
