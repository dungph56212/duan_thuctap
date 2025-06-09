<?php require_once "./views/layout/header.php"; ?>
<!-- header -->
<?php require_once "./views/layout/navbar.php"; ?>
<!-- navbar -->
<?php require_once "./views/layout/sidebar.php"; ?>
<!-- sidebar -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Báo cáo bình luận</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN . '?act=binh-luan' ?>">Quản lý bình luận</a></li>
                        <li class="breadcrumb-item active">Báo cáo bình luận</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Thống kê tổng quan -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= number_format($stats['total'] ?? 0) ?></h3>
                            <p>Tổng bình luận</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-comments"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= number_format($stats['pending'] ?? 0) ?></h3>
                            <p>Chờ duyệt</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= number_format($stats['approved'] ?? 0) ?></h3>
                            <p>Đã duyệt</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?= number_format($stats['hidden'] ?? 0) ?></h3>
                            <p>Đã ẩn</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-eye-slash"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Thống kê theo thời gian -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Thống kê hôm nay & tuần này</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 text-center">
                                    <div class="border-right">
                                        <h4 class="text-primary"><?= number_format($stats['today'] ?? 0) ?></h4>
                                        <p class="text-muted">Bình luận hôm nay</p>
                                    </div>
                                </div>
                                <div class="col-6 text-center">
                                    <h4 class="text-success"><?= number_format($stats['this_week'] ?? 0) ?></h4>
                                    <p class="text-muted">Bình luận tuần này</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Biểu đồ thống kê theo tháng -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Thống kê theo tháng (<?= date('Y') ?>)</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="monthlyChart" style="height: 250px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Top sản phẩm có nhiều bình luận -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Top sản phẩm có nhiều bình luận nhất</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Sản phẩm</th>
                                            <th>Số bình luận</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($topProducts)): ?>
                                            <?php foreach ($topProducts as $index => $product): ?>
                                                <tr>
                                                    <td><?= $index + 1 ?></td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <?php if (!empty($product['hinh_anh'])): ?>
                                                                <img src="<?= BASE_URL . $product['hinh_anh'] ?>" 
                                                                     alt="<?= htmlspecialchars($product['ten_san_pham']) ?>" 
                                                                     class="img-circle mr-2" style="width: 30px; height: 30px;">
                                                            <?php endif; ?>
                                                            <a href="<?= BASE_URL_ADMIN . '?act=chi-tiet-san-pham&id=' . $product['id'] ?>" 
                                                               target="_blank">
                                                                <?= htmlspecialchars($product['ten_san_pham']) ?>
                                                            </a>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-primary"><?= number_format($product['so_binh_luan']) ?></span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="3" class="text-center">Chưa có dữ liệu</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bình luận gần đây -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Bình luận gần đây</h3>
                        </div>
                        <div class="card-body">
                            <div class="timeline">
                                <?php if (!empty($recentComments)): ?>
                                    <?php foreach ($recentComments as $comment): ?>
                                        <div class="time-label">
                                            <span class="bg-info"><?= date('d/m/Y', strtotime($comment['ngay_dang'])) ?></span>
                                        </div>
                                        <div>
                                            <i class="fas fa-comment bg-blue"></i>
                                            <div class="timeline-item">
                                                <span class="time">
                                                    <i class="fas fa-clock"></i> <?= date('H:i', strtotime($comment['ngay_dang'])) ?>
                                                </span>
                                                <h3 class="timeline-header">
                                                    <a href="<?= BASE_URL_ADMIN . '?act=chi-tiet-binh-luan&id=' . $comment['id'] ?>">
                                                        <?= htmlspecialchars($comment['ho_ten'] ?? 'Khách') ?>
                                                    </a>
                                                    đã bình luận về
                                                    <a href="<?= BASE_URL_ADMIN . '?act=chi-tiet-san-pham&id=' . $comment['san_pham_id'] ?>" target="_blank">
                                                        <?= htmlspecialchars($comment['ten_san_pham']) ?>
                                                    </a>
                                                </h3>
                                                <div class="timeline-body">
                                                    <?= nl2br(htmlspecialchars(mb_substr($comment['noi_dung'], 0, 150))) ?>
                                                    <?php if (mb_strlen($comment['noi_dung']) > 150): ?>
                                                        <span class="text-muted">...</span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="timeline-footer">
                                                    <?php
                                                    $statusClass = '';
                                                    $statusText = '';
                                                    switch ($comment['trang_thai']) {
                                                        case 0:
                                                            $statusClass = 'badge-warning';
                                                            $statusText = 'Chờ duyệt';
                                                            break;
                                                        case 1:
                                                            $statusClass = 'badge-success';
                                                            $statusText = 'Đã duyệt';
                                                            break;
                                                        case 2:
                                                            $statusClass = 'badge-danger';
                                                            $statusText = 'Đã ẩn';
                                                            break;
                                                    }
                                                    ?>
                                                    <span class="badge <?= $statusClass ?>"><?= $statusText ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="text-center">
                                        <p class="text-muted">Chưa có bình luận nào</p>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <i class="fas fa-clock bg-gray"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bộ lọc báo cáo chi tiết -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Báo cáo chi tiết</h3>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="<?= BASE_URL_ADMIN ?>">
                                <input type="hidden" name="act" value="bao-cao-binh-luan">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Từ ngày</label>
                                            <input type="date" name="tu_ngay" class="form-control" 
                                                   value="<?= $_GET['tu_ngay'] ?? date('Y-m-01') ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Đến ngày</label>
                                            <input type="date" name="den_ngay" class="form-control" 
                                                   value="<?= $_GET['den_ngay'] ?? date('Y-m-d') ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Trạng thái</label>
                                            <select name="trang_thai" class="form-control">
                                                <option value="">Tất cả</option>
                                                <option value="0" <?= (isset($_GET['trang_thai']) && $_GET['trang_thai'] == '0') ? 'selected' : '' ?>>Chờ duyệt</option>
                                                <option value="1" <?= (isset($_GET['trang_thai']) && $_GET['trang_thai'] == '1') ? 'selected' : '' ?>>Đã duyệt</option>
                                                <option value="2" <?= (isset($_GET['trang_thai']) && $_GET['trang_thai'] == '2') ? 'selected' : '' ?>>Đã ẩn</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <div>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-chart-bar"></i> Tạo báo cáo
                                                </button>
                                                <button type="button" class="btn btn-success" onclick="exportReport()">
                                                    <i class="fas fa-file-excel"></i> Xuất Excel
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <!-- Hiển thị báo cáo chi tiết nếu có -->
                            <?php if (isset($detailReport) && !empty($detailReport)): ?>
                                <hr>
                                <h5>Kết quả báo cáo từ <?= date('d/m/Y', strtotime($_GET['tu_ngay'])) ?> đến <?= date('d/m/Y', strtotime($_GET['den_ngay'])) ?></h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Ngày</th>
                                                <th>Tổng bình luận</th>
                                                <th>Chờ duyệt</th>
                                                <th>Đã duyệt</th>
                                                <th>Đã ẩn</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($detailReport as $row): ?>
                                                <tr>
                                                    <td><?= date('d/m/Y', strtotime($row['ngay'])) ?></td>
                                                    <td><?= number_format($row['tong']) ?></td>
                                                    <td><?= number_format($row['cho_duyet']) ?></td>
                                                    <td><?= number_format($row['da_duyet']) ?></td>
                                                    <td><?= number_format($row['da_an']) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Biểu đồ thống kê theo tháng
document.addEventListener('DOMContentLoaded', function() {
    const monthlyData = <?= json_encode($monthlyStats ?? []) ?>;
    const ctx = document.getElementById('monthlyChart').getContext('2d');
    
    // Tạo dữ liệu cho 12 tháng
    const labels = ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'];
    const data = new Array(12).fill(0);
    
    // Điền dữ liệu thực tế
    monthlyData.forEach(item => {
        data[item.thang - 1] = item.so_luong;
    });
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Số bình luận',
                data: data,
                borderColor: 'rgb(54, 162, 235)',
                backgroundColor: 'rgba(54, 162, 235, 0.1)',
                tension: 0.1,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});

// Xuất báo cáo Excel
function exportReport() {
    const params = new URLSearchParams();
    params.append('act', 'xuat-bao-cao-binh-luan');
    params.append('tu_ngay', document.querySelector('input[name="tu_ngay"]').value);
    params.append('den_ngay', document.querySelector('input[name="den_ngay"]').value);    params.append('trang_thai', document.querySelector('select[name="trang_thai"]').value);
    
    window.open('<?= BASE_URL_ADMIN ?>?' + params.toString());
}
</script>

<?php require_once "./views/layout/footer.php" ?>