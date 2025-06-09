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
                    <h1>Quản lý bình luận</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Quản lý bình luận</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Thống kê nhanh -->
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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Danh sách bình luận</h3>
                            <div class="card-tools">
                                <a href="<?= BASE_URL_ADMIN . '?act=bao-cao-binh-luan' ?>" class="btn btn-info btn-sm">
                                    <i class="fas fa-chart-bar"></i> Báo cáo
                                </a>
                            </div>
                        </div>

                        <!-- Bộ lọc -->
                        <div class="card-body">
                            <form method="GET" action="<?= BASE_URL_ADMIN ?>">
                                <input type="hidden" name="act" value="filter-binh-luan">
                                <div class="row">
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
                                            <label>Từ ngày</label>
                                            <input type="date" name="tu_ngay" class="form-control" value="<?= $_GET['tu_ngay'] ?? '' ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Đến ngày</label>
                                            <input type="date" name="den_ngay" class="form-control" value="<?= $_GET['den_ngay'] ?? '' ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Tìm kiếm</label>
                                            <div class="input-group">
                                                <input type="text" name="keyword" class="form-control" placeholder="Tìm theo nội dung, sản phẩm, người dùng..." value="<?= $_GET['keyword'] ?? '' ?>">
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Danh sách bình luận -->
                        <div class="card-body">
                            <form id="bulk-action-form" method="POST">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <select name="bulk_action" class="form-control" style="max-width: 200px;">
                                                <option value="">Chọn thao tác</option>
                                                <option value="approve">Duyệt bình luận</option>
                                                <option value="hide">Ẩn bình luận</option>
                                                <option value="delete">Xóa bình luận</option>
                                            </select>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-primary" onclick="executeBulkAction()">
                                                    Thực hiện
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <button type="button" class="btn btn-secondary" onclick="selectAll()">
                                            Chọn tất cả
                                        </button>
                                        <button type="button" class="btn btn-secondary" onclick="deselectAll()">
                                            Bỏ chọn tất cả
                                        </button>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="select-all"></th>
                                                <th>ID</th>
                                                <th>Người dùng</th>
                                                <th>Sản phẩm</th>
                                                <th>Nội dung</th>
                                                <th>Trạng thái</th>
                                                <th>Ngày đăng</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($listBinhLuan as $key => $binhLuan): ?>
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" name="selected_comments[]" value="<?= $binhLuan['id'] ?>" class="comment-checkbox">
                                                    </td>
                                                    <td><?= $binhLuan['id'] ?></td>
                                                    <td>
                                                        <div>
                                                            <strong><?= htmlspecialchars($binhLuan['ho_ten'] ?? 'Khách') ?></strong>
                                                            <?php if (!empty($binhLuan['email'])): ?>
                                                                <br><small class="text-muted"><?= htmlspecialchars($binhLuan['email']) ?></small>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="<?= BASE_URL_ADMIN . '?act=chi-tiet-san-pham&id=' . $binhLuan['san_pham_id'] ?>" target="_blank">
                                                            <?= htmlspecialchars($binhLuan['ten_san_pham'] ?? 'Sản phẩm đã xóa') ?>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <div class="comment-content">
                                                            <?= nl2br(htmlspecialchars(mb_substr($binhLuan['noi_dung'], 0, 100))) ?>
                                                            <?php if (mb_strlen($binhLuan['noi_dung']) > 100): ?>
                                                                <span class="text-muted">...</span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $statusClass = '';
                                                        $statusText = '';
                                                        switch ($binhLuan['trang_thai']) {
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
                                                    </td>
                                                    <td>
                                                        <?= date('d/m/Y H:i', strtotime($binhLuan['ngay_dang'])) ?>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="<?= BASE_URL_ADMIN . '?act=chi-tiet-binh-luan&id=' . $binhLuan['id'] ?>" 
                                                               class="btn btn-info btn-sm" title="Chi tiết">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            
                                                            <?php if ($binhLuan['trang_thai'] == 0): ?>
                                                                <button type="button" class="btn btn-success btn-sm" 
                                                                        onclick="updateStatus(<?= $binhLuan['id'] ?>, 1)" title="Duyệt">
                                                                    <i class="fas fa-check"></i>
                                                                </button>
                                                            <?php endif; ?>
                                                            
                                                            <?php if ($binhLuan['trang_thai'] == 1): ?>
                                                                <button type="button" class="btn btn-warning btn-sm" 
                                                                        onclick="updateStatus(<?= $binhLuan['id'] ?>, 2)" title="Ẩn">
                                                                    <i class="fas fa-eye-slash"></i>
                                                                </button>
                                                            <?php endif; ?>
                                                            
                                                            <?php if ($binhLuan['trang_thai'] == 2): ?>
                                                                <button type="button" class="btn btn-success btn-sm" 
                                                                        onclick="updateStatus(<?= $binhLuan['id'] ?>, 1)" title="Hiện">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                            <?php endif; ?>
                                                            
                                                            <button type="button" class="btn btn-danger btn-sm" 
                                                                    onclick="deleteComment(<?= $binhLuan['id'] ?>)" title="Xóa">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </form>

                            <!-- Phân trang -->
                            <?php if ($totalPages > 1): ?>
                                <div class="d-flex justify-content-center">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination">
                                            <?php if ($currentPage > 1): ?>
                                                <li class="page-item">
                                                    <a class="page-link" href="<?= BASE_URL_ADMIN . '?act=' . $act . '&page=' . ($currentPage - 1) . '&' . http_build_query($_GET) ?>">
                                                        Trước
                                                    </a>
                                                </li>
                                            <?php endif; ?>

                                            <?php for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++): ?>
                                                <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                                                    <a class="page-link" href="<?= BASE_URL_ADMIN . '?act=' . $act . '&page=' . $i . '&' . http_build_query($_GET) ?>">
                                                        <?= $i ?>
                                                    </a>
                                                </li>
                                            <?php endfor; ?>

                                            <?php if ($currentPage < $totalPages): ?>
                                                <li class="page-item">
                                                    <a class="page-link" href="<?= BASE_URL_ADMIN . '?act=' . $act . '&page=' . ($currentPage + 1) . '&' . http_build_query($_GET) ?>">
                                                        Sau
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </nav>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
// Chọn/bỏ chọn tất cả
function selectAll() {
    document.querySelectorAll('.comment-checkbox').forEach(checkbox => checkbox.checked = true);
}

function deselectAll() {
    document.querySelectorAll('.comment-checkbox').forEach(checkbox => checkbox.checked = false);
}

// Xử lý checkbox select all
document.getElementById('select-all').addEventListener('change', function() {
    document.querySelectorAll('.comment-checkbox').forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// Cập nhật trạng thái bình luận
function updateStatus(id, status) {
    if (confirm('Bạn có chắc chắn muốn thực hiện thao tác này?')) {
        fetch('<?= BASE_URL_ADMIN ?>?act=cap-nhat-trang-thai-binh-luan', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${id}&trang_thai=${status}`
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
            alert('Có lỗi xảy ra khi thực hiện thao tác');
        });
    }
}

// Xóa bình luận
function deleteComment(id) {
    if (confirm('Bạn có chắc chắn muốn xóa bình luận này? Thao tác này không thể hoàn tác.')) {
        fetch('<?= BASE_URL_ADMIN ?>?act=xoa-binh-luan', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${id}`
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
            alert('Có lỗi xảy ra khi xóa bình luận');
        });
    }
}

// Thực hiện thao tác hàng loạt
function executeBulkAction() {
    const selectedComments = document.querySelectorAll('.comment-checkbox:checked');
    const bulkAction = document.querySelector('select[name="bulk_action"]').value;
    
    if (selectedComments.length === 0) {
        alert('Vui lòng chọn ít nhất một bình luận');
        return;
    }
    
    if (!bulkAction) {
        alert('Vui lòng chọn thao tác');
        return;
    }
    
    const commentIds = Array.from(selectedComments).map(cb => cb.value);
    let confirmMessage = '';
    
    switch (bulkAction) {
        case 'approve':
            confirmMessage = 'Bạn có chắc chắn muốn duyệt các bình luận đã chọn?';
            break;
        case 'hide':
            confirmMessage = 'Bạn có chắc chắn muốn ẩn các bình luận đã chọn?';
            break;
        case 'delete':
            confirmMessage = 'Bạn có chắc chắn muốn xóa các bình luận đã chọn? Thao tác này không thể hoàn tác.';
            break;
    }
    
    if (confirm(confirmMessage)) {
        fetch('<?= BASE_URL_ADMIN ?>?act=duyet-hang-loat-binh-luan', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=${bulkAction}&ids=${commentIds.join(',')}`
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
            alert('Có lỗi xảy ra khi thực hiện thao tác');
        });
    }
}
</script>

<?php require_once "./views/layout/footer.php" ?>
