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
                    <h1>Khuyến Mãi Đang Hoạt Động</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN . '?act=danh-sach-khuyen-mai' ?>">Quản lý khuyến mãi</a></li>
                        <li class="breadcrumb-item active">Đang hoạt động</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
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
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= $totalRecords ?></h3>
                            <p>Khuyến mãi đang hoạt động</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-play-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= array_sum(array_column($list, 'so_lan_da_su_dung')) ?></h3>
                            <p>Lượt sử dụng hôm nay</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= count(array_filter($list, function($item) { return $item['so_luong'] <= 10; })) ?></h3>
                            <p>Sắp hết số lượng</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?= count(array_filter($list, function($item) { return strtotime($item['ngay_ket_thuc']) <= strtotime('+7 days'); })) ?></h3>
                            <p>Sắp hết hạn</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bộ lọc -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Bộ lọc & Tìm kiếm</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form method="GET" action="">
                        <input type="hidden" name="act" value="khuyen-mai-dang-hoat-dong">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tìm kiếm</label>
                                    <input type="text" class="form-control" name="search" 
                                           value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" 
                                           placeholder="Mã hoặc tên khuyến mãi...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div class="input-group">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i> Tìm kiếm
                                        </button>
                                        <a href="<?= BASE_URL_ADMIN . '?act=khuyen-mai-dang-hoat-dong' ?>" class="btn btn-secondary ml-2">
                                            <i class="fas fa-refresh"></i> Reset
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Danh sách khuyến mãi -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Danh sách khuyến mãi đang hoạt động</h3>
                    <div class="card-tools">
                        <a href="<?= BASE_URL_ADMIN . '?act=form-them-khuyen-mai' ?>" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Thêm khuyến mãi
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (empty($list)): ?>
                        <div class="text-center py-4">
                            <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Không có khuyến mãi đang hoạt động</h5>
                            <p class="text-muted">Tạo khuyến mãi mới để thu hút khách hàng</p>
                            <a href="<?= BASE_URL_ADMIN . '?act=form-them-khuyen-mai' ?>" class="btn btn-success">
                                <i class="fas fa-plus"></i> Thêm khuyến mãi đầu tiên
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
                                        <th>Số lượng</th>
                                        <th>Đã sử dụng</th>
                                        <th>Ngày hết hạn</th>
                                        <th>Trạng thái</th>
                                        <th style="width: 150px;">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($list as $index => $item): ?>
                                        <tr>
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
                                                    <?= number_format($item['gia_tri']) ?>%
                                                <?php else: ?>
                                                    <?= number_format($item['gia_tri']) ?>đ
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="<?= $item['so_luong'] <= 10 ? 'text-danger' : 'text-success' ?>">
                                                    <?= number_format($item['so_luong']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-secondary">
                                                    <?= $item['so_lan_da_su_dung'] ?? 0 ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php 
                                                $daysLeft = ceil((strtotime($item['ngay_ket_thuc']) - time()) / 86400);
                                                $textClass = $daysLeft <= 3 ? 'text-danger' : ($daysLeft <= 7 ? 'text-warning' : 'text-success');
                                                ?>
                                                <span class="<?= $textClass ?>">
                                                    <?= date('d/m/Y', strtotime($item['ngay_ket_thuc'])) ?>
                                                    <br><small>(<?= $daysLeft ?> ngày)</small>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-success">Đang hoạt động</span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= BASE_URL_ADMIN . '?act=form-sua-khuyen-mai&id=' . $item['id'] ?>" 
                                                       class="btn btn-warning btn-sm" title="Chỉnh sửa">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-info btn-sm" 
                                                            onclick="viewDetails(<?= $item['id'] ?>)" title="Xem chi tiết">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-secondary btn-sm" 
                                                            onclick="toggleStatus(<?= $item['id'] ?>, 0)" title="Vô hiệu hóa">
                                                        <i class="fas fa-pause"></i>
                                                    </button>
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
                                                <a class="page-link" href="?act=khuyen-mai-dang-hoat-dong&page=<?= $page - 1 ?><?= !empty($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '' ?>">
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
                                                <a class="page-link" href="?act=khuyen-mai-dang-hoat-dong&page=<?= $i ?><?= !empty($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '' ?>">
                                                    <?= $i ?>
                                                </a>
                                            </li>
                                        <?php endfor; ?>

                                        <!-- Next Page -->
                                        <?php if ($page < $totalPages): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="?act=khuyen-mai-dang-hoat-dong&page=<?= $page + 1 ?><?= !empty($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '' ?>">
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

<!-- Chi tiết khuyến mãi Modal -->
<div class="modal fade" id="promotionDetailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chi tiết khuyến mãi</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="promotionDetailContent">
                <!-- Nội dung sẽ được load bằng AJAX -->
            </div>
        </div>
    </div>
</div>

<?php require './views/layout/footer.php' ?>

<script>
// Toggle trạng thái khuyến mãi
function toggleStatus(id, status) {
    if (confirm('Bạn có chắc chắn muốn thay đổi trạng thái khuyến mãi này?')) {
        $.ajax({
            url: '<?= BASE_URL_ADMIN ?>?act=toggle-promotion-status',
            type: 'POST',
            data: { id: id, status: status },
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
                toastr.error('Có lỗi xảy ra khi cập nhật trạng thái!');
            }
        });
    }
}

// Xem chi tiết khuyến mãi
function viewDetails(id) {
    $('#promotionDetailContent').html('<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Đang tải...</div>');
    $('#promotionDetailModal').modal('show');
    
    $.ajax({
        url: '<?= BASE_URL_ADMIN ?>?act=get-promotion-detail&id=' + id,
        type: 'GET',
        success: function(response) {
            $('#promotionDetailContent').html(response);
        },
        error: function() {
            $('#promotionDetailContent').html('<div class="alert alert-danger">Có lỗi xảy ra khi tải chi tiết khuyến mãi!</div>');
        }
    });
}

// Tự động refresh trang mỗi 5 phút để cập nhật trạng thái
setInterval(function() {
    location.reload();
}, 300000);
</script>
