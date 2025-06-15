<?php
// Đảm bảo layout admin được load
if (!defined('ADMIN_LAYOUT_LOADED')) {
    require_once __DIR__ . '/../../views/layout/header.php';
}
?>

<!-- Custom CSS tương thích với AdminLTE -->
<style>
.banner-stats-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 10px;
    color: white;
    transition: transform 0.3s ease;
    box-shadow: 0 0 1rem rgba(102, 126, 234, 0.15);
}

.banner-stats-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 0.5rem 2rem rgba(102, 126, 234, 0.25);
}

.banner-stats-card .card-body {
    padding: 1.25rem;
}

.banner-stats-card h6 {
    opacity: 0.9;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.5rem;
}

.banner-stats-card h3 {
    font-weight: 700;
    font-size: 1.75rem;
    margin-bottom: 0;
}

.filter-card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border-radius: 10px;
}

.filter-card .card-header {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
    border-radius: 10px 10px 0 0;
    border: none;
    font-weight: 600;
}

.banner-table-card {
    border: none;
    box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    overflow: hidden;
}

.banner-table-card .card-header {
    background: #f4f6f9;
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
}

.table th {
    border-top: none;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.7rem;
    letter-spacing: 0.5px;
    color: #495057;
    background-color: #f8f9fa;
    padding: 1rem 0.75rem;
}

.table td {
    padding: 0.75rem;
    vertical-align: middle;
}

.banner-preview {
    transition: all 0.3s ease;
    cursor: pointer;
    border-radius: 8px;
    overflow: hidden;
}

.banner-preview:hover {
    transform: scale(1.05);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.status-toggle .custom-switch .custom-control-input:checked ~ .custom-control-label::before {
    background-color: #28a745;
    border-color: #28a745;
}

.btn-group-sm > .btn {
    font-size: 0.7rem;
    padding: 0.25rem 0.5rem;
    margin: 0.1rem;
    border-radius: 4px;
}

.empty-state {
    padding: 3rem 1rem;
    text-align: center;
}

.empty-state i {
    opacity: 0.5;
    margin-bottom: 1rem;
}

.badge {
    font-size: 0.7em;
    font-weight: 500;
}

.timeline-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
    margin-right: 0.5rem;
}

.timeline-dot.active {
    background-color: #28a745;
    animation: pulse 2s infinite;
}

.timeline-dot.inactive {
    background-color: #6c757d;
}

@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7); }
    70% { box-shadow: 0 0 0 10px rgba(40, 167, 69, 0); }
    100% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0); }
}

/* Responsive */
@media (max-width: 768px) {
    .banner-stats-card h3 {
        font-size: 1.5rem;
    }
    
    .btn-group-vertical .btn {
        font-size: 0.65rem;
        padding: 0.25rem 0.5rem;
    }
    
    .table-responsive {
        font-size: 0.85rem;
    }
    
    .filter-card .row > div {
        margin-bottom: 1rem;
    }
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .banner-table-card {
        background-color: #343a40;
        color: #fff;
    }
    
    .table th {
        background-color: #495057;
        color: #fff;
    }
}
</style>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                    <i class="fas fa-image mr-2"></i>Quản lý Banner Quảng Cáo
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Banner</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Action buttons -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <a href="?act=form-them-banner" class="btn btn-success">
                            <i class="fas fa-plus mr-2"></i>Thêm Banner Mới
                        </a>
                        <button type="button" class="btn btn-info" onclick="refreshData()">
                            <i class="fas fa-sync-alt mr-2"></i>Làm mới
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thông báo -->
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <i class="icon fas fa-ban"></i>
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <i class="icon fas fa-check"></i>
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <!-- Thống kê tổng quan -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="card banner-stats-card">
                    <div class="card-body">
                        <h6>Tổng Banner</h6>
                        <h3><?= $stats['total'] ?? 0 ?></h3>
                        <p class="mb-0"><i class="fas fa-image mr-1"></i>Tất cả banner</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card banner-stats-card" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                    <div class="card-body">
                        <h6>Đang Hoạt Động</h6>
                        <h3><?= $stats['active'] ?? 0 ?></h3>
                        <p class="mb-0"><i class="fas fa-check-circle mr-1"></i>Banner hiển thị</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card banner-stats-card" style="background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);">
                    <div class="card-body">
                        <h6>Tạm Dừng</h6>
                        <h3><?= $stats['inactive'] ?? 0 ?></h3>
                        <p class="mb-0"><i class="fas fa-pause-circle mr-1"></i>Banner ẩn</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card banner-stats-card" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);">
                    <div class="card-body">
                        <h6>Lượt Xem Hôm Nay</h6>
                        <h3><?= $stats['views_today'] ?? 0 ?></h3>
                        <p class="mb-0"><i class="fas fa-eye mr-1"></i>Views</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bộ lọc nâng cao -->
        <div class="card filter-card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-filter mr-2"></i>Bộ Lọc & Tìm Kiếm
                </h5>
            </div>
            <div class="card-body">
                <form method="GET" action="" class="row g-3" id="filterForm">
                    <input type="hidden" name="act" value="danh-sach-banner">
                    
                    <div class="col-md-3">
                        <label class="form-label">
                            <i class="fas fa-search mr-1"></i>Tìm kiếm
                        </label>
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Tên banner hoặc mô tả..." 
                                   value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                            <button type="button" class="btn btn-outline-secondary" onclick="clearSearch()" 
                                    <?= empty($_GET['search']) ? 'style="display:none"' : '' ?>>
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <label class="form-label">
                            <i class="fas fa-toggle-on mr-1"></i>Trạng thái
                        </label>
                        <select name="status" class="form-control">
                            <option value="">Tất cả trạng thái</option>
                            <option value="1" <?= ($_GET['status'] ?? '') === '1' ? 'selected' : '' ?>>
                                Hoạt động
                            </option>
                            <option value="0" <?= ($_GET['status'] ?? '') === '0' ? 'selected' : '' ?>>
                                Không hoạt động
                            </option>
                        </select>
                    </div>
                    
                    <div class="col-md-2">
                        <label class="form-label">
                            <i class="fas fa-layer-group mr-1"></i>Loại hiển thị
                        </label>
                        <select name="type" class="form-control">
                            <option value="">Tất cả loại</option>
                            <option value="popup" <?= ($_GET['type'] ?? '') === 'popup' ? 'selected' : '' ?>>
                                Popup
                            </option>
                            <option value="banner_top" <?= ($_GET['type'] ?? '') === 'banner_top' ? 'selected' : '' ?>>
                                Banner Top
                            </option>
                            <option value="banner_bottom" <?= ($_GET['type'] ?? '') === 'banner_bottom' ? 'selected' : '' ?>>
                                Banner Bottom
                            </option>
                            <option value="sidebar" <?= ($_GET['type'] ?? '') === 'sidebar' ? 'selected' : '' ?>>
                                Sidebar
                            </option>
                        </select>
                    </div>
                    
                    <div class="col-md-2">
                        <label class="form-label">
                            <i class="fas fa-calendar-alt mr-1"></i>Từ ngày
                        </label>
                        <input type="date" name="date_from" class="form-control" 
                               value="<?= htmlspecialchars($_GET['date_from'] ?? '') ?>">
                    </div>
                    
                    <div class="col-md-2">
                        <label class="form-label">
                            <i class="fas fa-calendar-check mr-1"></i>Đến ngày
                        </label>
                        <input type="date" name="date_to" class="form-control" 
                               value="<?= htmlspecialchars($_GET['date_to'] ?? '') ?>">
                    </div>
                    
                    <div class="col-md-1">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search mr-1"></i>Lọc
                            </button>
                            <a href="?act=danh-sach-banner" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-refresh mr-1"></i>Reset
                            </a>
                        </div>
                    </div>
                </form>
                
                <!-- Quick Actions -->
                <div class="mt-3 pt-3 border-top">
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted">
                                <i class="fas fa-info-circle mr-1"></i>
                                Hiển thị <?= count($list ?? []) ?> / <?= $totalRecords ?? 0 ?> banner
                            </small>
                        </div>
                        <div class="col-md-6 text-right">
                            <div class="btn-group btn-group-sm" role="group">
                                <button type="button" class="btn btn-outline-success" onclick="bulkAction('activate')">
                                    <i class="fas fa-check mr-1"></i>Kích hoạt đã chọn
                                </button>
                                <button type="button" class="btn btn-outline-warning" onclick="bulkAction('deactivate')">
                                    <i class="fas fa-pause mr-1"></i>Tạm dừng đã chọn
                                </button>
                                <button type="button" class="btn btn-outline-danger" onclick="bulkAction('delete')">
                                    <i class="fas fa-trash mr-1"></i>Xóa đã chọn
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Danh sách Banner -->
        <div class="card banner-table-card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list mr-2"></i>Danh Sách Banner
                    </h5>
                    <div class="d-flex gap-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="selectAll">
                            <label class="form-check-label" for="selectAll">
                                Chọn tất cả
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="bannerTable">
                        <thead class="thead-dark">
                            <tr>
                                <th width="40">
                                    <input type="checkbox" class="form-check-input" id="checkAll">
                                </th>
                                <th width="60">ID</th>
                                <th width="120">Hình ảnh</th>
                                <th>Thông tin Banner</th>
                                <th width="120">Loại & Thứ tự</th>
                                <th width="120">Hiệu suất</th>
                                <th width="100">Trạng thái</th>
                                <th width="120">Thời gian</th>
                                <th width="150">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($list)): ?>
                                <?php foreach ($list as $banner): ?>
                                    <tr class="banner-row" data-id="<?= $banner['id'] ?>">
                                        <td>
                                            <input type="checkbox" class="form-check-input banner-checkbox" 
                                                   value="<?= $banner['id'] ?>">
                                        </td>
                                        <td>
                                            <span class="badge badge-light">#<?= $banner['id'] ?></span>
                                        </td>
                                        <td>
                                            <?php if (!empty($banner['image_url'])): ?>
                                                <img src="<?= BASE_URL . $banner['image_url'] ?>" 
                                                     alt="Banner Preview" 
                                                     class="img-thumbnail banner-preview" 
                                                     style="width: 60px; height: 40px; object-fit: cover; cursor: pointer;"
                                                     onclick="showPreview('<?= BASE_URL . $banner['image_url'] ?>', '<?= htmlspecialchars($banner['title']) ?>')">
                                            <?php else: ?>
                                                <div class="bg-light d-flex align-items-center justify-content-center" 
                                                     style="width: 60px; height: 40px; border-radius: 4px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="banner-info">
                                                <strong><?= htmlspecialchars($banner['title']) ?></strong>
                                                <?php if (!empty($banner['description'])): ?>
                                                    <br><small class="text-muted"><?= htmlspecialchars(substr($banner['description'], 0, 50)) ?>...</small>
                                                <?php endif; ?>
                                                <?php if (!empty($banner['link_url'])): ?>
                                                    <br><small class="text-info">
                                                        <i class="fas fa-link"></i> 
                                                        <a href="<?= htmlspecialchars($banner['link_url']) ?>" target="_blank" class="text-info">
                                                            <?= htmlspecialchars(substr($banner['link_url'], 0, 30)) ?>...
                                                        </a>
                                                    </small>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                <span class="badge badge-<?= $banner['display_type'] === 'popup' ? 'info' : 'secondary' ?>">
                                                    <?= ucfirst($banner['display_type'] ?? 'banner') ?>
                                                </span>
                                                <br><small class="text-muted">Thứ tự: <?= $banner['sort_order'] ?? 0 ?></small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                <small class="d-block">
                                                    <i class="fas fa-eye text-primary"></i> 
                                                    <?= number_format($banner['views'] ?? 0) ?>
                                                </small>
                                                <small class="d-block">
                                                    <i class="fas fa-mouse-pointer text-success"></i> 
                                                    <?= number_format($banner['clicks'] ?? 0) ?>
                                                </small>
                                                <?php if (($banner['views'] ?? 0) > 0): ?>
                                                    <small class="text-muted">
                                                        CTR: <?= number_format((($banner['clicks'] ?? 0) / $banner['views']) * 100, 1) ?>%
                                                    </small>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                <span class="timeline-dot <?= $banner['is_active'] ? 'active' : 'inactive' ?>"></span>
                                                <div class="custom-control custom-switch status-toggle">
                                                    <input type="checkbox" class="custom-control-input" 
                                                           id="status_<?= $banner['id'] ?>" 
                                                           <?= $banner['is_active'] ? 'checked' : '' ?>
                                                           onchange="toggleStatus(<?= $banner['id'] ?>, this.checked)">
                                                    <label class="custom-control-label" for="status_<?= $banner['id'] ?>"></label>
                                                </div>
                                                <small class="d-block text-muted">
                                                    <?= $banner['is_active'] ? 'Hoạt động' : 'Tạm dừng' ?>
                                                </small>
                                            </div>
                                        </td>
                                        <td>
                                            <small class="d-block">
                                                <i class="fas fa-calendar-plus text-success"></i>
                                                <?= date('d/m/Y', strtotime($banner['created_at'])) ?>
                                            </small>
                                            <small class="d-block">
                                                <i class="fas fa-calendar-edit text-warning"></i>
                                                <?= date('d/m/Y', strtotime($banner['updated_at'])) ?>
                                            </small>
                                        </td>
                                        <td>
                                            <div class="btn-group-vertical" role="group">
                                                <a href="?act=form-sua-banner&id=<?= $banner['id'] ?>" 
                                                   class="btn btn-outline-primary btn-sm" title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-outline-info btn-sm" 
                                                        onclick="duplicateBanner(<?= $banner['id'] ?>)" title="Nhân bản">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                                <button type="button" class="btn btn-outline-success btn-sm" 
                                                        onclick="previewBanner(<?= $banner['id'] ?>)" title="Xem trước">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-outline-danger btn-sm" 
                                                        onclick="deleteBanner(<?= $banner['id'] ?>)" title="Xóa">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center empty-state">
                                        <i class="fas fa-image fa-4x text-muted mb-3"></i>
                                        <h5 class="text-muted">Chưa có banner nào</h5>
                                        <p class="text-muted">Hãy thêm banner đầu tiên cho website của bạn</p>
                                        <a href="?act=form-them-banner" class="btn btn-success">
                                            <i class="fas fa-plus mr-2"></i>Thêm Banner Đầu Tiên
                                        </a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <?php if (!empty($pagination)): ?>
            <div class="d-flex justify-content-center mt-4">
                <?= $pagination ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewModalLabel">Xem trước Banner</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img id="previewImage" src="" alt="Banner Preview" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
$(document).ready(function() {
    // Select all checkbox functionality
    $('#selectAll, #checkAll').change(function() {
        const isChecked = $(this).prop('checked');
        $('.banner-checkbox').prop('checked', isChecked);
        updateBulkActionButtons();
    });

    // Individual checkbox change
    $('.banner-checkbox').change(function() {
        updateBulkActionButtons();
        const totalCheckboxes = $('.banner-checkbox').length;
        const checkedCheckboxes = $('.banner-checkbox:checked').length;
        $('#selectAll, #checkAll').prop('checked', totalCheckboxes === checkedCheckboxes);
    });

    // Update bulk action buttons state
    function updateBulkActionButtons() {
        const hasChecked = $('.banner-checkbox:checked').length > 0;
        $('.btn-group [onclick*="bulkAction"]').prop('disabled', !hasChecked);
    }

    // Initialize
    updateBulkActionButtons();
});

// Show preview modal
function showPreview(imageUrl, title) {
    $('#previewImage').attr('src', imageUrl);
    $('#previewModalLabel').text('Xem trước: ' + title);
    $('#previewModal').modal('show');
}

// Toggle banner status
function toggleStatus(id, isActive) {
    $.ajax({
        url: '?act=toggle-banner-status',
        method: 'POST',
        data: {
            id: id,
            is_active: isActive ? 1 : 0
        },
        success: function(response) {
            if (response.success) {
                toastr.success('Cập nhật trạng thái thành công!');
                // Update timeline dot
                const dot = $(`tr[data-id="${id}"] .timeline-dot`);
                if (isActive) {
                    dot.removeClass('inactive').addClass('active');
                } else {
                    dot.removeClass('active').addClass('inactive');
                }
            } else {
                toastr.error(response.message || 'Có lỗi xảy ra!');
                // Revert checkbox
                $(`#status_${id}`).prop('checked', !isActive);
            }
        },
        error: function() {
            toastr.error('Có lỗi xảy ra!');
            $(`#status_${id}`).prop('checked', !isActive);
        }
    });
}

// Bulk actions
function bulkAction(action) {
    const selectedIds = $('.banner-checkbox:checked').map(function() {
        return $(this).val();
    }).get();

    if (selectedIds.length === 0) {
        toastr.warning('Vui lòng chọn ít nhất một banner!');
        return;
    }

    let confirmMessage = '';
    switch (action) {
        case 'activate':
            confirmMessage = `Bạn có chắc muốn kích hoạt ${selectedIds.length} banner đã chọn?`;
            break;
        case 'deactivate':
            confirmMessage = `Bạn có chắc muốn tạm dừng ${selectedIds.length} banner đã chọn?`;
            break;
        case 'delete':
            confirmMessage = `Bạn có chắc muốn xóa ${selectedIds.length} banner đã chọn? Hành động này không thể hoàn tác!`;
            break;
    }

    if (confirm(confirmMessage)) {
        $.ajax({
            url: '?act=bulk-banner-action',
            method: 'POST',
            data: {
                action: action,
                ids: selectedIds
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message || 'Thực hiện thành công!');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    toastr.error(response.message || 'Có lỗi xảy ra!');
                }
            },
            error: function() {
                toastr.error('Có lỗi xảy ra!');
            }
        });
    }
}

// Delete single banner
function deleteBanner(id) {
    if (confirm('Bạn có chắc muốn xóa banner này?')) {
        $.ajax({
            url: '?act=xoa-banner',
            method: 'POST',
            data: { id: id },
            success: function(response) {
                if (response.success) {
                    toastr.success('Xóa banner thành công!');
                    $(`tr[data-id="${id}"]`).fadeOut();
                } else {
                    toastr.error(response.message || 'Có lỗi xảy ra!');
                }
            },
            error: function() {
                toastr.error('Có lỗi xảy ra!');
            }
        });
    }
}

// Duplicate banner
function duplicateBanner(id) {
    $.ajax({
        url: '?act=duplicate-banner',
        method: 'POST',
        data: { id: id },
        success: function(response) {
            if (response.success) {
                toastr.success('Nhân bản banner thành công!');
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                toastr.error(response.message || 'Có lỗi xảy ra!');
            }
        },
        error: function() {
            toastr.error('Có lỗi xảy ra!');
        }
    });
}

// Preview banner
function previewBanner(id) {
    window.open(`?act=preview-banner&id=${id}`, '_blank');
}

// Clear search
function clearSearch() {
    $('input[name="search"]').val('');
    $('#filterForm').submit();
}

// Refresh data
function refreshData() {
    location.reload();
}
</script>

<?php
// Footer
if (!defined('ADMIN_LAYOUT_LOADED')) {
    require_once __DIR__ . '/../../views/layout/footer.php';
}
?>
