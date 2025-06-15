<?php include './views/layout/header.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Thống kê Chatbot AI</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN . '?act=quan-ly-sach' ?>">Quản lý sách</a></li>
                        <li class="breadcrumb-item active">Thống kê Chatbot</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">            <!-- Statistics Cards -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= isset($stats['total_messages']) ? (int)$stats['total_messages'] : 0 ?></h3>
                            <p>Tổng tin nhắn</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-comments"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= isset($stats['today_messages']) ? (int)$stats['today_messages'] : 0 ?></h3>
                            <p>Tin nhắn hôm nay</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-comment-dots"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= isset($stats['unique_users']) ? (int)$stats['unique_users'] : 0 ?></h3>
                            <p>Người dùng</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?= isset($stats['avg_response_time']) ? (int)$stats['avg_response_time'] : 0 ?>ms</h3>
                            <p>Thời gian phản hồi TB</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Popular Queries -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Câu hỏi phổ biến</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Câu hỏi</th>
                                            <th>Số lần</th>
                                            <th>%</th>
                                        </tr>
                                    </thead>                                    <tbody>
                                        <?php if (!empty($popularQueries) && is_array($popularQueries)): ?>
                                            <?php foreach (array_slice($popularQueries, 0, 10) as $query): ?>
                                                <?php if (is_array($query)): ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars(substr($query['message'] ?? 'N/A', 0, 50)) ?>...</td>
                                                        <td><span class="badge badge-primary"><?= isset($query['count']) ? (int)$query['count'] : 0 ?></span></td>
                                                        <td><?= isset($query['percentage']) ? number_format((float)$query['percentage'], 1) : 0 ?>%</td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="3" class="text-center text-muted py-4">
                                                    <i class="fas fa-robot fa-2x mb-2"></i><br>
                                                    Chưa có dữ liệu câu hỏi
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chat Activity Chart -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Hoạt động chat 7 ngày qua</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="chatActivityChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Recent Chats -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Tin nhắn gần đây</h3>
                            <div class="card-tools">
                                <button class="btn btn-sm btn-warning" onclick="clearOldChats()">
                                    <i class="fas fa-broom"></i> Dọn dẹp tin nhắn cũ
                                </button>
                            </div>
                        </div>                        <div class="card-body p-0" style="max-height: 500px; overflow-y: auto;">
                            <?php if (!empty($recentChats) && is_array($recentChats)): ?>
                                <?php foreach ($recentChats as $chat): ?>
                                    <?php if (is_array($chat)): ?>
                                        <div class="border-bottom p-3">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <strong>
                                                        <?= (isset($chat['user_id']) && !empty($chat['user_id'])) ? 'User #' . htmlspecialchars($chat['user_id']) : 'Khách' ?>
                                                    </strong>
                                                    <span class="text-muted ml-2">
                                                        <?= isset($chat['created_at']) ? date('d/m/Y H:i', strtotime($chat['created_at'])) : date('d/m/Y H:i') ?>
                                                    </span>
                                                </div>
                                                <span class="badge badge-<?= (isset($chat['message_type']) && $chat['message_type'] == 'user') ? 'primary' : 'success' ?>">
                                                    <?= (isset($chat['message_type']) && $chat['message_type'] == 'user') ? 'Người dùng' : 'Bot' ?>
                                                </span>
                                            </div>
                                            <div class="mt-2">
                                                <p class="mb-1"><?= htmlspecialchars($chat['message'] ?? $chat['tin_nhan'] ?? 'Không có nội dung') ?></p>
                                                <?php if (isset($chat['response_time']) && !empty($chat['response_time'])): ?>
                                                    <small class="text-muted">
                                                        <i class="fas fa-clock"></i> <?= htmlspecialchars($chat['response_time']) ?>ms
                                                    </small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="text-center p-4">
                                    <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Chưa có tin nhắn nào</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Settings & Actions -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Quản lý Chatbot</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="<?= BASE_URL ?>test_enhanced_chatbot.php" target="_blank" class="btn btn-primary mb-2">
                                    <i class="fas fa-play"></i> Test Chatbot
                                </a>
                                
                                <a href="<?= BASE_URL ?>simple_chatbot_test.php" target="_blank" class="btn btn-info mb-2">
                                    <i class="fas fa-robot"></i> Test đơn giản
                                </a>

                                <a href="<?= BASE_URL ?>check_chatbot_errors.php" target="_blank" class="btn btn-warning mb-2">
                                    <i class="fas fa-bug"></i> Kiểm tra lỗi
                                </a>

                                <button class="btn btn-danger mb-2" onclick="clearAllChats()" 
                                        <?= empty($recentChats) ? 'disabled' : '' ?>>
                                    <i class="fas fa-trash"></i> Xóa tất cả tin nhắn
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Cấu hình nâng cao</h3>
                        </div>
                        <div class="card-body">
                            <form id="chatbotSettings">
                                <div class="form-group">
                                    <label for="response_delay">Độ trễ phản hồi (ms):</label>
                                    <input type="number" class="form-control" id="response_delay" 
                                           value="500" min="0" max="5000">
                                </div>

                                <div class="form-group">
                                    <label for="max_response_length">Độ dài phản hồi tối đa:</label>
                                    <input type="number" class="form-control" id="max_response_length" 
                                           value="200" min="50" max="500">
                                </div>

                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="enable_suggestions" checked>
                                    <label class="custom-control-label" for="enable_suggestions">
                                        Gợi ý nhanh
                                    </label>
                                </div>

                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="enable_product_search" checked>
                                    <label class="custom-control-label" for="enable_product_search">
                                        Tìm kiếm sản phẩm
                                    </label>
                                </div>

                                <button type="submit" class="btn btn-success btn-sm mt-2">
                                    <i class="fas fa-save"></i> Lưu cấu hình
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Clear Chats Modal -->
<div class="modal fade" id="clearChatsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Dọn dẹp tin nhắn</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="<?= BASE_URL_ADMIN ?>?act=clear-chat-history" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="clear_days">Xóa tin nhắn cũ hơn:</label>
                        <select class="form-control" id="clear_days" name="days">
                            <option value="7">7 ngày</option>
                            <option value="30" selected>30 ngày</option>
                            <option value="90">90 ngày</option>
                            <option value="365">1 năm</option>
                            <option value="0">Tất cả tin nhắn</option>
                        </select>
                    </div>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Cảnh báo:</strong> Thao tác này không thể hoàn tác!
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger">Xóa tin nhắn</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Chat activity chart
try {
    const ctx = document.getElementById('chatActivityChart').getContext('2d');
    const chartData = <?= json_encode($stats['daily_activity'] ?? []) ?>;

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: Array.isArray(chartData) ? chartData.map(item => item.date || '') : [],
            datasets: [{
                label: 'Tin nhắn',
                data: Array.isArray(chartData) ? chartData.map(item => parseInt(item.count) || 0) : [],
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
} catch (error) {
    console.error('Chart initialization failed:', error);
}

function clearOldChats() {
    $('#clearChatsModal').modal('show');
}

function clearAllChats() {
    if (confirm('Bạn có chắc chắn muốn xóa TẤT CẢ tin nhắn? Thao tác này không thể hoàn tác!')) {
        window.location.href = '<?= BASE_URL_ADMIN ?>?act=clear-chat-history&days=0';
    }
}

// Settings form
document.getElementById('chatbotSettings').addEventListener('submit', function(e) {
    e.preventDefault();
    
    try {
        // Save settings to localStorage for now
        const settings = {
            response_delay: document.getElementById('response_delay').value || '500',
            max_response_length: document.getElementById('max_response_length').value || '200',
            enable_suggestions: document.getElementById('enable_suggestions').checked,
            enable_product_search: document.getElementById('enable_product_search').checked
        };
        
        localStorage.setItem('chatbot_settings', JSON.stringify(settings));
        
        // Show success message
        const btn = this.querySelector('button[type="submit"]');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check"></i> Đã lưu!';
        btn.classList.replace('btn-success', 'btn-primary');
        
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.classList.replace('btn-primary', 'btn-success');
        }, 2000);
    } catch (error) {
        console.error('Settings save failed:', error);
    }
});

// Load saved settings
window.addEventListener('load', function() {
    try {
        const savedSettings = localStorage.getItem('chatbot_settings');
        if (savedSettings) {
            const settings = JSON.parse(savedSettings);
            document.getElementById('response_delay').value = settings.response_delay || '500';
            document.getElementById('max_response_length').value = settings.max_response_length || '200';
            document.getElementById('enable_suggestions').checked = settings.enable_suggestions !== false;
            document.getElementById('enable_product_search').checked = settings.enable_product_search !== false;
        }
    } catch (error) {
        console.error('Settings load failed:', error);
    }
});
</script>

<?php include './views/layout/footer.php'; ?>
