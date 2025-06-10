<?php require './views/layout/header.php' ?>
<?php require './views/layout/navbar.php' ?>
<?php require './views/layout/sidebar.php' ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Báo cáo khuyến mãi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="?act=">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Báo cáo khuyến mãi</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            
            <!-- Filter Section -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Bộ lọc báo cáo</h3>
                </div>
                <div class="card-body">
                    <form method="GET" action="">
                        <input type="hidden" name="act" value="bao-cao-khuyen-mai">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Từ ngày</label>
                                    <input type="date" class="form-control" name="date_from" 
                                           value="<?= $_GET['date_from'] ?? date('Y-m-01') ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Đến ngày</label>
                                    <input type="date" class="form-control" name="date_to" 
                                           value="<?= $_GET['date_to'] ?? date('Y-m-t') ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Trạng thái</label>
                                    <select class="form-control" name="status">
                                        <option value="">Tất cả</option>
                                        <option value="1" <?= ($_GET['status'] ?? '') === '1' ? 'selected' : '' ?>>Hoạt động</option>
                                        <option value="0" <?= ($_GET['status'] ?? '') === '0' ? 'selected' : '' ?>>Không hoạt động</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div>
                                        <button type="submit" class="btn btn-primary">Lọc</button>
                                        <a href="?act=bao-cao-khuyen-mai" class="btn btn-secondary">Reset</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= $reports['total_promotions'] ?? 0 ?></h3>
                            <p>Tổng khuyến mãi</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-tags"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= $reports['active_promotions'] ?? 0 ?></h3>
                            <p>Đang hoạt động</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= $reports['total_usage'] ?? 0 ?></h3>
                            <p>Lượt sử dụng</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?= number_format($reports['total_revenue'] ?? 0) ?> đ</h3>
                            <p>Doanh thu tiết kiệm</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Thống kê sử dụng theo tháng</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="usageChart" style="height: 300px;"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Phân bố theo loại khuyến mãi</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="typeChart" style="height: 300px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Export Section -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Xuất báo cáo</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="?act=export-promotion-report&type=excel&date_from=<?= $_GET['date_from'] ?? date('Y-m-01') ?>&date_to=<?= $_GET['date_to'] ?? date('Y-m-t') ?>&status=<?= $_GET['status'] ?? '' ?>" 
                               class="btn btn-success">
                                <i class="fas fa-file-excel"></i> Xuất Excel
                            </a>
                            <a href="?act=export-promotion-report&type=pdf&date_from=<?= $_GET['date_from'] ?? date('Y-m-01') ?>&date_to=<?= $_GET['date_to'] ?? date('Y-m-t') ?>&status=<?= $_GET['status'] ?? '' ?>" 
                               class="btn btn-danger">
                                <i class="fas fa-file-pdf"></i> Xuất PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Reports Table -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Chi tiết khuyến mãi</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="promotionReportsTable">
                        <thead>
                            <tr>
                                <th>Mã KM</th>
                                <th>Tên khuyến mãi</th>
                                <th>Loại</th>
                                <th>Giá trị</th>
                                <th>Lượt sử dụng</th>
                                <th>Doanh thu tiết kiệm</th>
                                <th>Hiệu quả</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($promotionDetails)): ?>
                                <?php foreach ($promotionDetails as $detail): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($detail['ma_khuyen_mai']) ?></td>
                                        <td><?= htmlspecialchars($detail['ten_khuyen_mai']) ?></td>
                                        <td>
                                            <?= $detail['loai_khuyen_mai'] === 'percentage' ? 'Phần trăm' : 'Số tiền' ?>
                                        </td>
                                        <td>
                                            <?= $detail['loai_khuyen_mai'] === 'percentage' 
                                                ? $detail['gia_tri'] . '%' 
                                                : number_format($detail['gia_tri']) . ' đ' ?>
                                        </td>
                                        <td><?= $detail['so_lan_da_su_dung'] ?? 0 ?></td>
                                        <td><?= number_format($detail['tiet_kiem'] ?? 0) ?> đ</td>
                                        <td>
                                            <?php 
                                            $efficiency = ($detail['so_lan_da_su_dung'] ?? 0) / max(1, $detail['so_lan_su_dung'] ?? 1) * 100;
                                            $badgeClass = $efficiency >= 70 ? 'success' : ($efficiency >= 40 ? 'warning' : 'danger');
                                            ?>
                                            <span class="badge badge-<?= $badgeClass ?>"><?= number_format($efficiency, 1) ?>%</span>
                                        </td>
                                        <td>
                                            <?php if ($detail['trang_thai']): ?>
                                                <span class="badge badge-success">Hoạt động</span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary">Không hoạt động</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center">Không có dữ liệu</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
</div>

<!-- Chart.js for charts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Usage Chart
const usageCtx = document.getElementById('usageChart').getContext('2d');
const usageChart = new Chart(usageCtx, {
    type: 'line',
    data: {
        labels: <?= json_encode($usageStats['labels'] ?? []) ?>,
        datasets: [{
            label: 'Lượt sử dụng',
            data: <?= json_encode($usageStats['data'] ?? []) ?>,
            borderColor: 'rgb(54, 162, 235)',
            backgroundColor: 'rgba(54, 162, 235, 0.1)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Type Chart
const typeCtx = document.getElementById('typeChart').getContext('2d');
const typeChart = new Chart(typeCtx, {
    type: 'doughnut',
    data: {
        labels: <?= json_encode($typeStats['labels'] ?? ['Phần trăm', 'Số tiền']) ?>,
        datasets: [{
            data: <?= json_encode($typeStats['data'] ?? [0, 0]) ?>,
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});
</script>

<?php require './views/layout/footer.php' ?>
