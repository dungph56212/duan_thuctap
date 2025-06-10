<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0">
                    <i class="fas fa-tags me-2"></i>Quản lý khuyến mãi
                </h3>
                <div>
                    <a href="?act=form-them-khuyen-mai" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>Thêm khuyến mãi
                    </a>
                    <div class="btn-group ms-2">
                        <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fas fa-download me-2"></i>Xuất báo cáo
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="?act=export-promotion-report&type=excel">
                                <i class="fas fa-file-excel me-2"></i>Excel
                            </a></li>
                            <li><a class="dropdown-item" href="?act=export-promotion-report&type=pdf">
                                <i class="fas fa-file-pdf me-2"></i>PDF
                            </a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Thông báo -->
            <?php if (!empty($this->getErrors())): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <ul class="mb-0">
                        <?php foreach ($this->getErrors() as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (!empty($this->getSuccessMessage())): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= htmlspecialchars($this->getSuccessMessage()) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Thống kê tổng quan -->
            <?php if (isset($statistics)): ?>
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Tổng khuyến mãi</h6>
                                    <h3 class="mb-0"><?= number_format($statistics['total_promotions']) ?></h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-tags fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Đang hoạt động</h6>
                                    <h3 class="mb-0"><?= number_format($statistics['active_promotions']) ?></h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-play-circle fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-dark">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Sắp diễn ra</h6>
                                    <h3 class="mb-0"><?= number_format($statistics['upcoming_promotions']) ?></h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-clock fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Đã hết hạn</h6>
                                    <h3 class="mb-0"><?= number_format($statistics['expired_promotions']) ?></h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-times-circle fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Bộ lọc -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="" class="row g-3">
                        <input type="hidden" name="act" value="danh-sach-khuyen-mai">
                        
                        <div class="col-md-3">
                            <label class="form-label">Tìm kiếm</label>
                            <input type="text" class="form-control" name="search" 
                                   value="<?= htmlspecialchars($filters['search'] ?? '') ?>" 
                                   placeholder="Mã hoặc tên khuyến mãi...">
                        </div>
                        
                        <div class="col-md-2">
                            <label class="form-label">Trạng thái</label>
                            <select name="status" class="form-select">
                                <option value="">Tất cả</option>
                                <option value="1" <?= ($filters['status'] ?? '') == '1' ? 'selected' : '' ?>>Hoạt động</option>
                                <option value="0" <?= ($filters['status'] ?? '') == '0' ? 'selected' : '' ?>>Ngừng hoạt động</option>
                            </select>
                        </div>
                        
                        <div class="col-md-2">
                            <label class="form-label">Loại</label>
                            <select name="type" class="form-select">
                                <option value="">Tất cả</option>
                                <option value="active" <?= ($filters['type'] ?? '') == 'active' ? 'selected' : '' ?>>Đang áp dụng</option>
                                <option value="upcoming" <?= ($filters['type'] ?? '') == 'upcoming' ? 'selected' : '' ?>>Sắp diễn ra</option>
                                <option value="expired" <?= ($filters['type'] ?? '') == 'expired' ? 'selected' : '' ?>>Đã hết hạn</option>
                            </select>
                        </div>
                        
                        <div class="col-md-2">
                            <label class="form-label">Từ ngày</label>
                            <input type="date" class="form-control" name="date_from" 
                                   value="<?= htmlspecialchars($filters['date_from'] ?? '') ?>">
                        </div>
                        
                        <div class="col-md-2">
                            <label class="form-label">Đến ngày</label>
                            <input type="date" class="form-control" name="date_to" 
                                   value="<?= htmlspecialchars($filters['date_to'] ?? '') ?>">
                        </div>
                        
                        <div class="col-md-1 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Bảng danh sách -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>STT</th>
                                    <th>Mã khuyến mãi</th>
                                    <th>Tên khuyến mãi</th>
                                    <th>Loại giảm</th>
                                    <th>Giá trị</th>
                                    <th>Số lượng</th>
                                    <th>Đã sử dụng</th>
                                    <th>Thời gian</th>
                                    <th>Trạng thái</th>
                                    <th width="150">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($list)): 
                                    $startNumber = ($page - 1) * $limit + 1;
                                    foreach ($list as $index => $km): ?>
                                    <tr>
                                        <td><?= $startNumber + $index ?></td>
                                        <td>
                                            <span class="badge bg-secondary fs-6"><?= htmlspecialchars($km['ma_khuyen_mai']) ?></span>
                                        </td>
                                        <td>
                                            <div>
                                                <strong><?= htmlspecialchars($km['ten_khuyen_mai']) ?></strong>
                                                <?php if (!empty($km['mo_ta'])): ?>
                                                    <br><small class="text-muted"><?= htmlspecialchars(substr($km['mo_ta'], 0, 50)) ?>...</small>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if (($km['loai_giam'] ?? 1) == 1): ?>
                                                <span class="badge bg-info">Phần trăm</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning">Số tiền</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (($km['loai_giam'] ?? 1) == 1): ?>
                                                <strong class="text-primary"><?= $km['phan_tram_giam'] ?>%</strong>
                                            <?php else: ?>
                                                <strong class="text-success"><?= number_format($km['gia_giam']) ?>đ</strong>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark"><?= number_format($km['so_luong']) ?></span>
                                        </td>
                                        <td>
                                            <span class="text-primary"><?= number_format($km['so_lan_da_su_dung'] ?? 0) ?></span>
                                        </td>
                                        <td>
                                            <small>
                                                <strong>Bắt đầu:</strong> <?= date('d/m/Y', strtotime($km['ngay_bat_dau'])) ?><br>
                                                <strong>Kết thúc:</strong> <?= date('d/m/Y', strtotime($km['ngay_ket_thuc'])) ?>
                                            </small>
                                        </td>
                                        <td>
                                            <?php
                                            $statusLabel = $km['status_label'] ?? 'inactive';
                                            $statusText = '';
                                            $statusClass = '';
                                            
                                            switch ($statusLabel) {
                                                case 'active':
                                                    $statusText = 'Đang áp dụng';
                                                    $statusClass = 'bg-success';
                                                    break;
                                                case 'upcoming':
                                                    $statusText = 'Sắp diễn ra';
                                                    $statusClass = 'bg-warning';
                                                    break;
                                                case 'expired':
                                                    $statusText = 'Đã hết hạn';
                                                    $statusClass = 'bg-danger';
                                                    break;
                                                default:
                                                    $statusText = 'Ngừng hoạt động';
                                                    $statusClass = 'bg-secondary';
                                            }
                                            ?>
                                            <span class="badge <?= $statusClass ?>"><?= $statusText ?></span>
                                        </td>
                                        <td>
                                            <div class="btn-group-vertical btn-group-sm" role="group">
                                                <a href="?act=form-sua-khuyen-mai&id=<?= $km['id'] ?>" 
                                                   class="btn btn-outline-warning btn-sm" title="Sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="?act=duplicate-promotion&id=<?= $km['id'] ?>" 
                                                   class="btn btn-outline-info btn-sm" title="Nhân bản">
                                                    <i class="fas fa-copy"></i>
                                                </a>
                                                <button type="button" class="btn btn-outline-danger btn-sm" 
                                                        onclick="confirmDelete(<?= $km['id'] ?>)" title="Xóa">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; else: ?>
                                    <tr>
                                        <td colspan="10" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                                <h5>Không có khuyến mãi nào</h5>
                                                <p>Hãy thêm khuyến mãi đầu tiên của bạn!</p>
                                                <a href="?act=form-them-khuyen-mai" class="btn btn-primary">
                                                    <i class="fas fa-plus me-2"></i>Thêm khuyến mãi
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Phân trang -->
                    <?php if ($totalPages > 1): ?>
                    <nav aria-label="Pagination" class="mt-4">
                        <ul class="pagination justify-content-center">
                            <!-- Previous -->
                            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                                <a class="page-link" href="?act=danh-sach-khuyen-mai&page=<?= $page - 1 ?>&<?= http_build_query($filters) ?>">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>

                            <!-- Page numbers -->
                            <?php
                            $startPage = max(1, $page - 2);
                            $endPage = min($totalPages, $page + 2);
                            
                            if ($startPage > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?act=danh-sach-khuyen-mai&page=1&<?= http_build_query($filters) ?>">1</a>
                                </li>
                                <?php if ($startPage > 2): ?>
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                    <a class="page-link" href="?act=danh-sach-khuyen-mai&page=<?= $i ?>&<?= http_build_query($filters) ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($endPage < $totalPages): ?>
                                <?php if ($endPage < $totalPages - 1): ?>
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                <?php endif; ?>
                                <li class="page-item">
                                    <a class="page-link" href="?act=danh-sach-khuyen-mai&page=<?= $totalPages ?>&<?= http_build_query($filters) ?>"><?= $totalPages ?></a>
                                </li>
                            <?php endif; ?>

                            <!-- Next -->
                            <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                                <a class="page-link" href="?act=danh-sach-khuyen-mai&page=<?= $page + 1 ?>&<?= http_build_query($filters) ?>">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>

                    <!-- Thông tin phân trang -->
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <small class="text-muted">
                                Hiển thị <?= ($page - 1) * $limit + 1 ?> - <?= min($page * $limit, $totalRecords) ?> 
                                trong tổng số <?= number_format($totalRecords) ?> khuyến mãi
                            </small>
                        </div>
                        <div class="col-md-6 text-end">
                            <small class="text-muted">Trang <?= $page ?> / <?= $totalPages ?></small>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
function confirmDelete(id) {
    if (confirm('Bạn có chắc chắn muốn xóa khuyến mãi này?')) {
        window.location.href = '?act=xoa-khuyen-mai&id=' + id;
    }
}

function toggleStatus(id, currentStatus) {
    const newStatus = currentStatus ? 0 : 1;
    const actionText = newStatus ? 'kích hoạt' : 'tạm ngưng';
    
    if (confirm(`Bạn có chắc chắn muốn ${actionText} khuyến mãi này?`)) {
        fetch('?act=update-promotion-status', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${id}&status=${newStatus}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Có lỗi xảy ra: ' + data.message);
            }
        })
        .catch(error => {
            alert('Có lỗi xảy ra khi cập nhật trạng thái');
        });
    }
}

// Auto hide alerts
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>