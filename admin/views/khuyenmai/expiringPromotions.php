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
                    <h1>Khuyến Mãi Sắp Hết Hạn</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN . '?act=danh-sach-khuyen-mai' ?>">Quản lý khuyến mãi</a></li>
                        <li class="breadcrumb-item active">Sắp hết hạn</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Cảnh báo quan trọng -->
            <?php if (!empty($list)): ?>
                <div class="alert alert-warning">
                    <h5><i class="icon fas fa-exclamation-triangle"></i> Cảnh báo!</h5>
                    Có <?= $totalRecords ?> khuyến mãi sắp hết hạn trong 7 ngày tới. Vui lòng kiểm tra và gia hạn hoặc tạo khuyến mãi mới.
                </div>
            <?php endif; ?>

            <!-- Thông báo -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (!empty($successMessage)): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= htmlspecialchars($successMessage) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Thống kê nhanh -->
            <div class="row mb-4">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= $totalRecords ?></h3>
                            <p>Sắp hết hạn</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?= count(array_filter($list, function($item) { return $item['days_until_expiry'] <= 1; })) ?></h3>
                            <p>Hết hạn trong 24h</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= count(array_filter($list, function($item) { return $item['days_until_expiry'] <= 3; })) ?></h3>
                            <p>Hết hạn trong 3 ngày</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-times"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3><?= array_sum(array_column($list, 'so_lan_da_su_dung')) ?></h3>
                            <p>Tổng lượt sử dụng</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hành động nhanh -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Hành động nhanh</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <button type="button" class="btn btn-success btn-block" onclick="extendAllExpiring()">
                                <i class="fas fa-calendar-plus"></i> Gia hạn tất cả
                            </button>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-warning btn-block" onclick="notifyCustomers()">
                                <i class="fas fa-bell"></i> Thông báo khách hàng
                            </button>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= BASE_URL_ADMIN . '?act=form-them-khuyen-mai' ?>" class="btn btn-primary btn-block">
                                <i class="fas fa-plus"></i> Tạo KM thay thế
                            </a>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-info btn-block" onclick="exportExpiringReport()">
                                <i class="fas fa-download"></i> Xuất báo cáo
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danh sách khuyến mãi sắp hết hạn -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Danh sách khuyến mãi sắp hết hạn (7 ngày tới)</h3>
                </div>
                <div class="card-body">
                    <?php if (empty($list)): ?>
                        <div class="text-center py-4">
                            <i class="fas fa-smile-beam fa-3x text-success mb-3"></i>
                            <h5 class="text-success">Tuyệt vời!</h5>
                            <p class="text-muted">Hiện tại không có khuyến mãi nào sắp hết hạn</p>
                            <a href="<?= BASE_URL_ADMIN . '?act=danh-sach-khuyen-mai' ?>" class="btn btn-primary">
                                <i class="fas fa-list"></i> Xem tất cả khuyến mãi
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">STT</th>
                                        <th>Mã KM</th>
                                        <th>Tên khuyến mãi</th>
                                        <th>Loại</th>
                                        <th>Giá trị</th>
                                        <th>Đã sử dụng</th>
                                        <th>Ngày hết hạn</th>
                                        <th>Còn lại</th>
                                        <th>Mức độ</th>
                                        <th style="width: 200px;">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($list as $index => $item): ?>
                                        <?php 
                                        $daysLeft = $item['days_until_expiry'];
                                        $urgencyClass = $daysLeft <= 1 ? 'table-danger' : ($daysLeft <= 3 ? 'table-warning' : '');
                                        $urgencyText = $daysLeft <= 1 ? 'Cực kỳ khẩn cấp' : ($daysLeft <= 3 ? 'Khẩn cấp' : 'Cần chú ý');
                                        $urgencyBadge = $daysLeft <= 1 ? 'badge-danger' : ($daysLeft <= 3 ? 'badge-warning' : 'badge-info');
                                        ?>
                                        <tr class="<?= $urgencyClass ?>">
                                            <td><?= $index + 1 + (($page - 1) * 10) ?></td>
                                            <td>
                                                <span class="badge badge-primary"><?= htmlspecialchars($item['ma_khuyen_mai']) ?></span>
                                            </td>
                                            <td>
                                                <strong><?= htmlspecialchars($item['ten_khuyen_mai']) ?></strong>
                                                <?php if (!empty($item['mo_ta'])): ?>
                                                    <br><small class="text-muted"><?= htmlspecialchars(substr($item['mo_ta'], 0, 50)) ?>...</small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($item['loai_khuyen_mai'] === 'percentage'): ?>
                                                    <span class="badge badge-info">Phần trăm</span>
                                                <?php else: ?>
                                                    <span class="badge badge-warning">Số tiền</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($item['loai_khuyen_mai'] === 'percentage'): ?>
                                                    <strong><?= number_format($item['gia_tri']) ?>%</strong>
                                                <?php else: ?>
                                                    <strong><?= number_format($item['gia_tri']) ?>đ</strong>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge badge-secondary">
                                                    <?= $item['so_lan_da_su_dung'] ?? 0 ?>
                                                </span>
                                            </td>
                                            <td>
                                                <strong class="text-danger">
                                                    <?= date('d/m/Y H:i', strtotime($item['ngay_ket_thuc'])) ?>
                                                </strong>
                                            </td>
                                            <td>
                                                <span class="badge <?= $urgencyBadge ?>">
                                                    <?= $daysLeft ?> ngày
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge <?= $urgencyBadge ?>">
                                                    <?= $urgencyText ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group-vertical" role="group">
                                                    <button type="button" class="btn btn-success btn-sm mb-1" 
                                                            onclick="extendPromotion(<?= $item['id'] ?>)" title="Gia hạn">
                                                        <i class="fas fa-calendar-plus"></i> Gia hạn
                                                    </button>
                                                    <a href="<?= BASE_URL_ADMIN . '?act=duplicate-promotion&id=' . $item['id'] ?>" 
                                                       class="btn btn-info btn-sm mb-1" title="Nhân bản">
                                                        <i class="fas fa-copy"></i> Nhân bản
                                                    </a>
                                                    <a href="<?= BASE_URL_ADMIN . '?act=form-sua-khuyen-mai&id=' . $item['id'] ?>" 
                                                       class="btn btn-warning btn-sm" title="Chỉnh sửa">
                                                        <i class="fas fa-edit"></i> Sửa
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Phân trang -->
                        <?php if ($totalPages > 1): ?>
                            <div class="d-flex justify-content-center">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination">
                                        <!-- Previous Page -->
                                        <?php if ($page > 1): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="?act=khuyen-mai-sap-het-han&page=<?= $page - 1 ?>">
                                                    <i class="fas fa-chevron-left"></i>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <!-- Page Numbers -->
                                        <?php
                                        $startPage = max(1, $page - 2);
                                        $endPage = min($totalPages, $page + 2);
                                        
                                        for ($i = $startPage; $i <= $endPage; $i++): ?>
                                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                                <a class="page-link" href="?act=khuyen-mai-sap-het-han&page=<?= $i ?>">
                                                    <?= $i ?>
                                                </a>
                                            </li>
                                        <?php endfor; ?>

                                        <!-- Next Page -->
                                        <?php if ($page < $totalPages): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="?act=khuyen-mai-sap-het-han&page=<?= $page + 1 ?>">
                                                    <i class="fas fa-chevron-right"></i>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </nav>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal gia hạn khuyến mãi -->
<div class="modal fade" id="extendPromotionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gia hạn khuyến mãi</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="extendPromotionForm">
                <div class="modal-body">
                    <input type="hidden" id="promotion_id" name="promotion_id">
                    <div class="form-group">
                        <label>Ngày kết thúc mới</label>
                        <input type="datetime-local" class="form-control" name="new_end_date" required>
                    </div>
                    <div class="form-group">
                        <label>Lý do gia hạn</label>
                        <textarea class="form-control" name="reason" rows="3" placeholder="Nhập lý do gia hạn khuyến mãi..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-success">Gia hạn</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require './views/layout/footer.php' ?>

<script>
// Gia hạn khuyến mãi
function extendPromotion(id) {
    $('#promotion_id').val(id);
    $('#extendPromotionModal').modal('show');
}

// Xử lý form gia hạn
$('#extendPromotionForm').on('submit', function(e) {
    e.preventDefault();
    
    $.ajax({
        url: '<?= BASE_URL_ADMIN ?>?act=extend-promotion',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                toastr.success(response.message);
                $('#extendPromotionModal').modal('hide');
                setTimeout(() => location.reload(), 1000);
            } else {
                toastr.error(response.message);
            }
        },
        error: function() {
            toastr.error('Có lỗi xảy ra khi gia hạn khuyến mãi!');
        }
    });
});

// Gia hạn tất cả khuyến mãi sắp hết hạn
function extendAllExpiring() {
    if (confirm('Bạn có chắc chắn muốn gia hạn tất cả khuyến mãi sắp hết hạn thêm 30 ngày?')) {
        $.ajax({
            url: '<?= BASE_URL_ADMIN ?>?act=extend-all-expiring',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    setTimeout(() => location.reload(), 1000);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function() {
                toastr.error('Có lỗi xảy ra khi gia hạn khuyến mãi!');
            }
        });
    }
}

// Thông báo khách hàng
function notifyCustomers() {
    if (confirm('Gửi thông báo về các khuyến mãi sắp hết hạn đến tất cả khách hàng?')) {
        $.ajax({
            url: '<?= BASE_URL_ADMIN ?>?act=notify-expiring-promotions',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function() {
                toastr.error('Có lỗi xảy ra khi gửi thông báo!');
            }
        });
    }
}

// Xuất báo cáo
function exportExpiringReport() {
    window.open('<?= BASE_URL_ADMIN ?>?act=export-expiring-report&type=excel', '_blank');
}

// Tự động cập nhật countdown mỗi phút
setInterval(function() {
    $('tbody tr').each(function() {
        // Logic cập nhật thời gian còn lại
        location.reload();
    });
}, 60000);
</script>
