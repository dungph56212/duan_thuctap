<?php
// admin/views/lienhe/statsLienHe.php
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/navbar.php';
require_once __DIR__ . '/../layout/sidebar.php';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Thống Kê Liên Hệ</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>?ctl=lienhe">Liên Hệ</a></li>
                        <li class="breadcrumb-item active">Thống Kê</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

<style>
.stats-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    margin-bottom: 30px;
    border: 1px solid #e3e6f0;
    transition: transform 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
}

.stats-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 20px 25px;
    border-radius: 15px 15px 0 0;
}

.stats-body {
    padding: 25px;
}

.chart-container {
    position: relative;
    height: 400px;
    width: 100%;
}

.stat-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px 20px;
    background: #f8f9fa;
    border-radius: 10px;
    margin-bottom: 15px;
    border-left: 4px solid #667eea;
}

.stat-label {
    font-weight: 600;
    color: #495057;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: bold;
    color: #667eea;
}

.priority-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.priority-item {
    text-align: center;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}

.priority-low {
    background: linear-gradient(135deg, #e5e7eb 0%, #f3f4f6 100%);
    color: #6b7280;
}

.priority-normal {
    background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%);
    color: #3b82f6;
}

.priority-high {
    background: linear-gradient(135deg, #fed7aa 0%, #fef3c7 100%);
    color: #ea580c;
}

.priority-urgent {
    background: linear-gradient(135deg, #fecaca 0%, #fee2e2 100%);
    color: #dc2626;
}

.daily-chart {
    background: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    border: 1px solid #e3e6f0;
}

@media (max-width: 768px) {
    .stats-body {
        padding: 15px;
    }
    
    .priority-stats {
        grid-template-columns: 1fr;
    }
    
    .chart-container {
        height: 300px;
    }
}
</style>

            <!-- Overview Statistics -->
            <div class="row">
                <div class="col-md-3">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3><?= $stats['total'] ?? 0 ?></h3>
                            <p>Tổng Liên Hệ</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= $stats['status']['pending'] ?? 0 ?></h3>
                            <p>Chờ Xử Lý</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= $stats['status']['replied'] ?? 0 ?></h3>
                            <p>Đã Phản Hồi</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-reply"></i>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= $stats['today'] ?? 0 ?></h3>
                            <p>Hôm Nay</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Statistics -->
            <div class="row">
                <!-- Status Statistics -->
                <div class="col-md-6">
                    <div class="stats-card">
                        <div class="stats-header">
                            <h4 class="mb-0">
                                <i class="fas fa-chart-pie mr-2"></i>
                                Thống Kê Theo Trạng Thái
                            </h4>
                        </div>
                        <div class="stats-body">
                            <div class="stat-item">
                                <span class="stat-label">Chờ xử lý</span>
                                <span class="stat-value text-warning"><?= $stats['status']['pending'] ?? 0 ?></span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Đã đọc</span>
                                <span class="stat-value text-info"><?= $stats['status']['read'] ?? 0 ?></span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Đã phản hồi</span>
                                <span class="stat-value text-success"><?= $stats['status']['replied'] ?? 0 ?></span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Đã đóng</span>
                                <span class="stat-value text-secondary"><?= $stats['status']['closed'] ?? 0 ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Priority Statistics -->
                <div class="col-md-6">
                    <div class="stats-card">
                        <div class="stats-header">
                            <h4 class="mb-0">
                                <i class="fas fa-flag mr-2"></i>
                                Thống Kê Theo Mức Độ Ưu Tiên
                            </h4>
                        </div>
                        <div class="stats-body">
                            <div class="priority-stats">
                                <div class="priority-item priority-low">
                                    <h3><?= $stats['priority']['low'] ?? 0 ?></h3>
                                    <p class="mb-0">Thấp</p>
                                </div>
                                <div class="priority-item priority-normal">
                                    <h3><?= $stats['priority']['normal'] ?? 0 ?></h3>
                                    <p class="mb-0">Bình thường</p>
                                </div>
                                <div class="priority-item priority-high">
                                    <h3><?= $stats['priority']['high'] ?? 0 ?></h3>
                                    <p class="mb-0">Cao</p>
                                </div>
                                <div class="priority-item priority-urgent">
                                    <h3><?= $stats['priority']['urgent'] ?? 0 ?></h3>
                                    <p class="mb-0">Khẩn cấp</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Daily Statistics Chart -->
            <div class="row">
                <div class="col-12">
                    <div class="daily-chart">
                        <h4 class="mb-4">
                            <i class="fas fa-chart-line mr-2"></i>
                            Biểu Đồ Liên Hệ 7 Ngày Gần Nhất
                        </h4>
                        <div class="chart-container">
                            <canvas id="dailyChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Time Statistics -->
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="info-box bg-gradient-info">
                        <span class="info-box-icon"><i class="fas fa-calendar-week"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Tuần Này</span>
                            <span class="info-box-number"><?= $stats['week'] ?? 0 ?></span>
                            <span class="info-box-more">liên hệ</span>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="info-box bg-gradient-warning">
                        <span class="info-box-icon"><i class="fas fa-envelope-open"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Chưa Đọc</span>
                            <span class="info-box-number"><?= $stats['unread'] ?? 0 ?></span>
                            <span class="info-box-more">liên hệ</span>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="info-box bg-gradient-success">
                        <span class="info-box-icon"><i class="fas fa-chart-line"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Tỷ Lệ Phản Hồi</span>
                            <span class="info-box-number">
                                <?php 
                                    $total = $stats['total'] ?? 1;
                                    $replied = $stats['status']['replied'] ?? 0;
                                    $percentage = $total > 0 ? round(($replied / $total) * 100, 1) : 0;
                                    echo $percentage;
                                ?>%
                            </span>
                            <span class="info-box-more">đã phản hồi</span>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Daily Statistics Chart
const ctx = document.getElementById('dailyChart').getContext('2d');
const dailyData = <?= json_encode($daily_stats ?? []) ?>;

// Prepare data for chart
const labels = [];
const data = [];
const today = new Date();

// Generate last 7 days
for (let i = 6; i >= 0; i--) {
    const date = new Date(today);
    date.setDate(date.getDate() - i);
    const dateStr = date.toISOString().split('T')[0];
    labels.push(date.toLocaleDateString('vi-VN'));
    
    // Find data for this date
    const dayData = dailyData.find(d => d.date === dateStr);
    data.push(dayData ? dayData.count : 0);
}

const dailyChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Số lượng liên hệ',
            data: data,
            borderColor: 'rgb(102, 126, 234)',
            backgroundColor: 'rgba(102, 126, 234, 0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: 'rgb(102, 126, 234)',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 6,
            pointHoverRadius: 8
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0,0,0,0.1)'
                },
                ticks: {
                    stepSize: 1
                }
            },
            x: {
                grid: {
                    color: 'rgba(0,0,0,0.1)'
                }
            }
        },
        elements: {
            point: {
                hoverBackgroundColor: 'rgb(102, 126, 234)'
            }
        }
    }
});

// Auto refresh every 5 minutes
setInterval(function() {
    location.reload();
}, 300000);
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
