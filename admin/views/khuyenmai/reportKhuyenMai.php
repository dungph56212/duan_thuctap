<?php require_once 'layout/header.php'; ?>
<?php require_once 'layout/sidebar.php'; ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-chart-bar text-primary"></i>
                        Báo cáo khuyến mãi
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang chủ</a></li>
                        <li class="breadcrumb-item">Khuyến mãi</li>
                        <li class="breadcrumb-item active">Báo cáo</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- Summary Cards -->
            <div class="row mb-4">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= $stats['total_promotions'] ?></h3>
                            <p>Tổng số khuyến mãi</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-gift"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= $stats['active_promotions'] ?></h3>
                            <p>Đang hoạt động</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-play-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= $stats['total_usage'] ?></h3>
                            <p>Tổng lượt sử dụng</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?= number_format($stats['total_discount_amount']) ?>đ</h3>
                            <p>Tổng tiền giảm giá</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Performance Chart -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-line"></i>
                                Hiệu suất khuyến mãi theo tháng
                            </h3>
                        </div>
                        <div class="card-body">
                            <canvas id="performanceChart" height="100"></canvas>
                        </div>
                    </div>
                </div>
                
                <!-- Top Promotions -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-trophy"></i>
                                Top khuyến mãi hiệu quả
                            </h3>
                        </div>
                        <div class="card-body">
                            <?php foreach ($topPromotions as $index => $promotion): ?>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <div class="badge badge-primary"><?= $promotion['ma_khuyen_mai'] ?></div>
                                        <div class="text-sm text-muted"><?= $promotion['ten_khuyen_mai'] ?></div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-bold"><?= $promotion['so_lan_su_dung'] ?> lượt</div>
                                        <div class="text-sm text-success">
                                            <?php 
                                            $total = $promotion['so_luong'] + $promotion['so_lan_su_dung'];
                                            $rate = $total > 0 ? ($promotion['so_lan_su_dung'] / $total) * 100 : 0;
                                            echo number_format($rate, 1) . '%';
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($index < count($topPromotions) - 1): ?>
                                    <hr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Report Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-table"></i>
                                Báo cáo chi tiết
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Mã KM</th>
                                            <th>Tên chương trình</th>
                                            <th>Loại giảm giá</th>
                                            <th>Tổng phát hành</th>
                                            <th>Đã sử dụng</th>
                                            <th>Còn lại</th>
                                            <th>Tỷ lệ sử dụng</th>
                                            <th>Tổng tiền giảm</th>
                                            <th>Trạng thái</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($allPromotions as $promotion): 
                                            $totalQuantity = $promotion['so_luong'] + $promotion['so_lan_su_dung'];
                                            $usageRate = $totalQuantity > 0 ? ($promotion['so_lan_su_dung'] / $totalQuantity) * 100 : 0;
                                            
                                            // Calculate total discount amount
                                            $discountAmount = 0;
                                            if ($promotion['phan_tram_giam'] > 0) {
                                                $discountAmount = $promotion['so_lan_su_dung'] * 50000; // Estimate
                                            } else {
                                                $discountAmount = $promotion['so_lan_su_dung'] * $promotion['gia_giam'];
                                            }
                                            
                                            // Determine status
                                            $now = new DateTime();
                                            $endDate = new DateTime($promotion['ngay_ket_thuc']);
                                            $startDate = new DateTime($promotion['ngay_bat_dau']);
                                            
                                            if ($promotion['trang_thai'] == 0) {
                                                $status = '<span class="badge badge-secondary">Tạm dừng</span>';
                                            } elseif ($endDate < $now) {
                                                $status = '<span class="badge badge-danger">Hết hạn</span>';
                                            } elseif ($startDate > $now) {
                                                $status = '<span class="badge badge-info">Sắp diễn ra</span>';
                                            } elseif ($promotion['so_luong'] == 0) {
                                                $status = '<span class="badge badge-warning">Hết số lượng</span>';
                                            } else {
                                                $status = '<span class="badge badge-success">Hoạt động</span>';
                                            }
                                        ?>
                                            <tr>
                                                <td>
                                                    <span class="badge badge-primary"><?= $promotion['ma_khuyen_mai'] ?></span>
                                                </td>
                                                <td><?= $promotion['ten_khuyen_mai'] ?></td>
                                                <td>
                                                    <?php if ($promotion['phan_tram_giam'] > 0): ?>
                                                        <span class="badge badge-success"><?= $promotion['phan_tram_giam'] ?>%</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-info"><?= number_format($promotion['gia_giam']) ?>đ</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= $totalQuantity ?></td>
                                                <td><?= $promotion['so_lan_su_dung'] ?></td>
                                                <td><?= $promotion['so_luong'] ?></td>
                                                <td>
                                                    <div class="progress progress-sm">
                                                        <div class="progress-bar <?= $usageRate >= 50 ? 'bg-success' : ($usageRate >= 20 ? 'bg-warning' : 'bg-danger') ?>" 
                                                             style="width: <?= $usageRate ?>%"></div>
                                                    </div>
                                                    <small><?= number_format($usageRate, 1) ?>%</small>
                                                </td>
                                                <td><?= number_format($discountAmount) ?>đ</td>
                                                <td><?= $status ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Performance Chart
    const ctx = document.getElementById('performanceChart').getContext('2d');
    const chartData = <?= json_encode($chartData) ?>;
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Số lượng sử dụng',
                data: chartData.usage,
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.1
            }, {
                label: 'Tiền giảm giá',
                data: chartData.amount,
                borderColor: 'rgb(255, 99, 132)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                tension: 0.1,
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Tháng'
                    }
                },
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Số lượng sử dụng'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Tiền giảm giá (VNĐ)'
                    },
                    grid: {
                        drawOnChartArea: false,
                    },
                }
            }
        }
    });
});
</script>

<?php require_once 'layout/footer.php'; ?>
