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
    color: #6c757d;
}

.empty-state i {
    opacity: 0.5;
    margin-bottom: 1rem;
    font-size: 3rem;
}

.badge {
    font-size: 0.65em;
    font-weight: 500;
    padding: 0.35em 0.65em;
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

/* Modal styles */
.modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-bottom: none;
}

.modal-header .close {
    color: white;
    opacity: 0.8;
}

.modal-header .close:hover {
    opacity: 1;
}

/* Responsive */
@media (max-width: 768px) {
    .banner-stats-card h3 {
        font-size: 1.5rem;
    }
    
    .btn-group-sm > .btn {
        font-size: 0.6rem;
        padding: 0.2rem 0.4rem;
    }
    
    .table-responsive {
        font-size: 0.85rem;
    }
    
    .col-lg-3, .col-md-6 {
        margin-bottom: 1rem;
    }
}

/* Loading spinner */
.loading-spinner {
    display: inline-block;
    width: 1rem;
    height: 1rem;
    border: 2px solid #f3f3f3;
    border-top: 2px solid #007bff;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Bulk actions */
.bulk-actions {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
    border-left: 4px solid #007bff;
}

.bulk-actions.hidden {
    display: none;
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
                    <div>
                        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#settingsModal">
                            <i class="fas fa-cog mr-2"></i>Cài đặt
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

        <!-- Bộ lọc -->
        <div class="card filter-card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-filter mr-2"></i>Bộ Lọc & Tìm Kiếm
                </h5>
            </div>
            <div class="card-body">
                <form method="GET" id="filterForm">
                    <input type="hidden" name="act" value="banner">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tìm kiếm</label>
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Tên banner..." 
                                       value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Trạng thái</label>
                                <select name="status" class="form-control">
                                    <option value="">Tất cả</option>
                                    <option value="1" <?= ($_GET['status'] ?? '') === '1' ? 'selected' : '' ?>>Hoạt động</option>
                                    <option value="0" <?= ($_GET['status'] ?? '') === '0' ? 'selected' : '' ?>>Tạm dừng</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Vị trí</label>
                                <select name="position" class="form-control">
                                    <option value="">Tất cả</option>
                                    <option value="top" <?= ($_GET['position'] ?? '') === 'top' ? 'selected' : '' ?>>Top</option>
                                    <option value="popup" <?= ($_GET['position'] ?? '') === 'popup' ? 'selected' : '' ?>>Popup</option>
                                    <option value="sidebar" <?= ($_GET['position'] ?? '') === 'sidebar' ? 'selected' : '' ?>>Sidebar</option>
                                    <option value="bottom" <?= ($_GET['position'] ?? '') === 'bottom' ? 'selected' : '' ?>>Bottom</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Loại</label>
                                <select name="type" class="form-control">
                                    <option value="">Tất cả</option>
                                    <option value="image" <?= ($_GET['type'] ?? '') === 'image' ? 'selected' : '' ?>>Hình ảnh</option>
                                    <option value="html" <?= ($_GET['type'] ?? '') === 'html' ? 'selected' : '' ?>>HTML</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <div class="d-flex">
                                    <button type="submit" class="btn btn-primary mr-2">
                                        <i class="fas fa-search mr-1"></i>Lọc
                                    </button>
                                    <a href="?act=banner" class="btn btn-secondary">
                                        <i class="fas fa-times mr-1"></i>Xóa
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Bulk Actions (ẩn khi chưa chọn) -->
        <div class="bulk-actions hidden" id="bulkActions">
            <div class="d-flex justify-content-between align-items-center">
                <span><strong id="selectedCount">0</strong> banner được chọn</span>
                <div>
                    <button type="button" class="btn btn-success btn-sm" onclick="bulkActivate()">
                        <i class="fas fa-check mr-1"></i>Kích hoạt
                    </button>
                    <button type="button" class="btn btn-warning btn-sm" onclick="bulkDeactivate()">
                        <i class="fas fa-pause mr-1"></i>Tạm dừng
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="bulkDelete()">
                        <i class="fas fa-trash mr-1"></i>Xóa
                    </button>
                </div>
            </div>
        </div>

        <!-- Bảng danh sách banner -->
        <div class="card banner-table-card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-list mr-2"></i>Danh Sách Banner
                    <span class="badge badge-info ml-2"><?= count($listBanner ?? []) ?> banner</span>
                </h5>
            </div>
            <div class="card-body p-0">
                <?php if (empty($listBanner)): ?>
                    <div class="empty-state">
                        <i class="fas fa-image"></i>
                        <h5>Chưa có banner nào</h5>
                        <p class="text-muted">Hãy thêm banner đầu tiên để bắt đầu quảng cáo</p>
                        <a href="?act=form-them-banner" class="btn btn-success">
                            <i class="fas fa-plus mr-2"></i>Thêm Banner Đầu Tiên
                        </a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th width="30">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="selectAll">
                                            <label class="custom-control-label" for="selectAll"></label>
                                        </div>
                                    </th>
                                    <th width="80">Hình ảnh</th>
                                    <th>Tên Banner</th>
                                    <th>Vị trí</th>
                                    <th>Loại</th>
                                    <th>Trạng thái</th>
                                    <th>Ưu tiên</th>
                                    <th>Lượt xem</th>
                                    <th>Ngày tạo</th>
                                    <th width="150">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($listBanner as $index => $banner): ?>
                                    <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input banner-checkbox" 
                                                       id="banner_<?= $banner['id'] ?>" 
                                                       value="<?= $banner['id'] ?>">
                                                <label class="custom-control-label" for="banner_<?= $banner['id'] ?>"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if ($banner['type'] === 'image' && !empty($banner['image_url'])): ?>
                                                <img src="<?= htmlspecialchars($banner['image_url']) ?>" 
                                                     class="banner-preview" 
                                                     style="width: 60px; height: 40px; object-fit: cover;"
                                                     onclick="previewBanner(<?= $banner['id'] ?>)"
                                                     alt="Banner">
                                            <?php else: ?>
                                                <div class="bg-light d-flex align-items-center justify-content-center" 
                                                     style="width: 60px; height: 40px; border-radius: 4px;">
                                                    <i class="fas fa-code text-muted"></i>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <strong><?= htmlspecialchars($banner['title']) ?></strong>
                                            <?php if (!empty($banner['description'])): ?>
                                                <br><small class="text-muted"><?= htmlspecialchars(substr($banner['description'], 0, 50)) ?>...</small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge badge-<?= getBadgeColor($banner['position']) ?>">
                                                <?= htmlspecialchars(ucfirst($banner['position'])) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-<?= $banner['type'] === 'image' ? 'primary' : 'info' ?>">
                                                <?= htmlspecialchars(strtoupper($banner['type'])) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="status-toggle">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" 
                                                           id="status_<?= $banner['id'] ?>"
                                                           <?= $banner['is_active'] ? 'checked' : '' ?>
                                                           onchange="toggleStatus(<?= $banner['id'] ?>, this.checked)">
                                                    <label class="custom-control-label" for="status_<?= $banner['id'] ?>">
                                                        <span class="timeline-dot <?= $banner['is_active'] ? 'active' : 'inactive' ?>"></span>
                                                        <?= $banner['is_active'] ? 'Hoạt động' : 'Tạm dừng' ?>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-dark"><?= $banner['sort_order'] ?? 0 ?></span>
                                        </td>
                                        <td>
                                            <i class="fas fa-eye mr-1"></i>
                                            <span class="font-weight-bold"><?= number_format($banner['view_count'] ?? 0) ?></span>
                                        </td>
                                        <td>
                                            <small>
                                                <?= date('d/m/Y', strtotime($banner['created_at'])) ?><br>
                                                <span class="text-muted"><?= date('H:i', strtotime($banner['created_at'])) ?></span>
                                            </small>
                                        </td>
                                        <td>
                                            <div class="btn-group-sm">
                                                <button type="button" class="btn btn-info btn-sm" 
                                                        onclick="previewBanner(<?= $banner['id'] ?>)" 
                                                        title="Xem trước">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <a href="?act=form-sua-banner&id=<?= $banner['id'] ?>" 
                                                   class="btn btn-warning btn-sm" title="Sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-secondary btn-sm" 
                                                        onclick="duplicateBanner(<?= $banner['id'] ?>)" 
                                                        title="Nhân bản">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm" 
                                                        onclick="deleteBanner(<?= $banner['id'] ?>)" 
                                                        title="Xóa">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Pagination -->
            <?php if (!empty($listBanner) && $totalPages > 1): ?>
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">
                                Hiển thị <?= ($currentPage - 1) * $limit + 1 ?> - 
                                <?= min($currentPage * $limit, $totalBanners) ?> 
                                trong tổng số <?= $totalBanners ?> banner
                            </small>
                        </div>
                        <nav>
                            <ul class="pagination pagination-sm mb-0">
                                <?php if ($currentPage > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?act=banner&page=1<?= $queryString ?>">Đầu</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="?act=banner&page=<?= $currentPage - 1 ?><?= $queryString ?>">‹</a>
                                    </li>
                                <?php endif; ?>
                                
                                <?php for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++): ?>
                                    <li class="page-item <?= $i === $currentPage ? 'active' : '' ?>">
                                        <a class="page-link" href="?act=banner&page=<?= $i ?><?= $queryString ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>
                                
                                <?php if ($currentPage < $totalPages): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?act=banner&page=<?= $currentPage + 1 ?><?= $queryString ?>">›</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="?act=banner&page=<?= $totalPages ?><?= $queryString ?>">Cuối</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-eye mr-2"></i>Xem Trước Banner
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="previewContent">
                <div class="text-center">
                    <div class="loading-spinner"></div>
                    <p class="mt-2">Đang tải...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Settings Modal -->
<div class="modal fade" id="settingsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-cog mr-2"></i>Cài Đặt Banner
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="settingsForm">
                    <div class="form-group">
                        <label>Tự động ẩn popup sau (giây)</label>
                        <input type="number" class="form-control" name="popup_auto_hide" value="10" min="0">
                        <small class="form-text text-muted">0 = không tự động ẩn</small>
                    </div>
                    <div class="form-group">
                        <label>Thời gian hiệu ứng (ms)</label>
                        <input type="number" class="form-control" name="animation_duration" value="500" min="100">
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="show_close_button" checked>
                        <label class="custom-control-label" for="show_close_button">Hiển thị nút đóng</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" onclick="saveSettings()">Lưu cài đặt</button>
            </div>
        </div>
    </div>
</div>

<script>
// Hàm helper cho badge color
<?php 
function getBadgeColor($position) {
    switch ($position) {
        case 'top': return 'primary';
        case 'popup': return 'warning';
        case 'sidebar': return 'info';
        case 'bottom': return 'secondary';
        default: return 'light';
    }
}
?>

// Global variables
let selectedBanners = [];

// Document ready
$(document).ready(function() {
    // Initialize tooltips
    $('[title]').tooltip();
    
    // Select all checkbox
    $('#selectAll').change(function() {
        const isChecked = $(this).is(':checked');
        $('.banner-checkbox').prop('checked', isChecked);
        updateBulkActions();
    });
    
    // Individual checkbox
    $('.banner-checkbox').change(function() {
        updateBulkActions();
        
        // Update select all checkbox
        const totalCheckboxes = $('.banner-checkbox').length;
        const checkedCheckboxes = $('.banner-checkbox:checked').length;
        $('#selectAll').prop('checked', totalCheckboxes === checkedCheckboxes);
    });
});

// Update bulk actions visibility
function updateBulkActions() {
    selectedBanners = [];
    $('.banner-checkbox:checked').each(function() {
        selectedBanners.push($(this).val());
    });
    
    const $bulkActions = $('#bulkActions');
    const $selectedCount = $('#selectedCount');
    
    if (selectedBanners.length > 0) {
        $bulkActions.removeClass('hidden');
        $selectedCount.text(selectedBanners.length);
    } else {
        $bulkActions.addClass('hidden');
    }
}

// Toggle banner status
function toggleStatus(bannerId, isActive) {
    const status = isActive ? 1 : 0;
    
    $.ajax({
        url: '?act=ajax-toggle-banner-status',
        method: 'POST',
        data: {
            id: bannerId,
            status: status
        },
        success: function(response) {
            if (response.success) {
                // Update timeline dot
                const $dot = $(`#status_${bannerId}`).siblings('label').find('.timeline-dot');
                const $label = $(`#status_${bannerId}`).siblings('label');
                
                if (isActive) {
                    $dot.removeClass('inactive').addClass('active');
                    $label.html($dot[0].outerHTML + 'Hoạt động');
                } else {
                    $dot.removeClass('active').addClass('inactive');
                    $label.html($dot[0].outerHTML + 'Tạm dừng');
                }
                
                showToast('success', 'Cập nhật trạng thái thành công!');
            } else {
                // Revert checkbox
                $(`#status_${bannerId}`).prop('checked', !isActive);
                showToast('error', response.message || 'Có lỗi xảy ra');
            }
        },
        error: function() {
            // Revert checkbox
            $(`#status_${bannerId}`).prop('checked', !isActive);
            showToast('error', 'Lỗi kết nối server');
        }
    });
}

// Preview banner
function previewBanner(bannerId) {
    $('#previewModal').modal('show');
    $('#previewContent').html(`
        <div class="text-center">
            <div class="loading-spinner"></div>
            <p class="mt-2">Đang tải...</p>
        </div>
    `);
    
    $.ajax({
        url: '?act=ajax-preview-banner',
        method: 'GET',
        data: { id: bannerId },
        success: function(response) {
            if (response.success) {
                $('#previewContent').html(response.html);
            } else {
                $('#previewContent').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        ${response.message || 'Không thể tải banner'}
                    </div>
                `);
            }
        },
        error: function() {
            $('#previewContent').html(`
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Lỗi kết nối server
                </div>
            `);
        }
    });
}

// Delete banner
function deleteBanner(bannerId) {
    if (confirm('Bạn có chắc chắn muốn xóa banner này?')) {
        $.ajax({
            url: '?act=ajax-delete-banner',
            method: 'POST',
            data: { id: bannerId },
            success: function(response) {
                if (response.success) {
                    $(`tr:has(#banner_${bannerId})`).fadeOut(500, function() {
                        $(this).remove();
                        updateBulkActions();
                    });
                    showToast('success', 'Xóa banner thành công!');
                } else {
                    showToast('error', response.message || 'Có lỗi xảy ra');
                }
            },
            error: function() {
                showToast('error', 'Lỗi kết nối server');
            }
        });
    }
}

// Duplicate banner
function duplicateBanner(bannerId) {
    $.ajax({
        url: '?act=ajax-duplicate-banner',
        method: 'POST',
        data: { id: bannerId },
        success: function(response) {
            if (response.success) {
                showToast('success', 'Nhân bản banner thành công!');
                setTimeout(() => location.reload(), 1500);
            } else {
                showToast('error', response.message || 'Có lỗi xảy ra');
            }
        },
        error: function() {
            showToast('error', 'Lỗi kết nối server');
        }
    });
}

// Bulk actions
function bulkActivate() {
    if (selectedBanners.length === 0) return;
    
    if (confirm(`Bạn có muốn kích hoạt ${selectedBanners.length} banner đã chọn?`)) {
        bulkAction('activate');
    }
}

function bulkDeactivate() {
    if (selectedBanners.length === 0) return;
    
    if (confirm(`Bạn có muốn tạm dừng ${selectedBanners.length} banner đã chọn?`)) {
        bulkAction('deactivate');
    }
}

function bulkDelete() {
    if (selectedBanners.length === 0) return;
    
    if (confirm(`Bạn có chắc chắn muốn xóa ${selectedBanners.length} banner đã chọn?`)) {
        bulkAction('delete');
    }
}

function bulkAction(action) {
    $.ajax({
        url: '?act=ajax-bulk-banner-action',
        method: 'POST',
        data: {
            action: action,
            ids: selectedBanners
        },
        success: function(response) {
            if (response.success) {
                showToast('success', response.message);
                setTimeout(() => location.reload(), 1500);
            } else {
                showToast('error', response.message || 'Có lỗi xảy ra');
            }
        },
        error: function() {
            showToast('error', 'Lỗi kết nối server');
        }
    });
}

// Refresh data
function refreshData() {
    location.reload();
}

// Save settings
function saveSettings() {
    const formData = $('#settingsForm').serialize();
    
    $.ajax({
        url: '?act=ajax-save-banner-settings',
        method: 'POST',
        data: formData,
        success: function(response) {
            if (response.success) {
                $('#settingsModal').modal('hide');
                showToast('success', 'Lưu cài đặt thành công!');
            } else {
                showToast('error', response.message || 'Có lỗi xảy ra');
            }
        },
        error: function() {
            showToast('error', 'Lỗi kết nối server');
        }
    });
}

// Toast notification function
function showToast(type, message) {
    // Use AdminLTE toastr if available
    if (typeof toastr !== 'undefined') {
        toastr[type](message);
    } else {
        // Fallback alert
        alert(message);
    }
}
</script>

<?php
// Load footer if not already loaded
if (!defined('ADMIN_LAYOUT_FOOTER_LOADED')) {
    require_once __DIR__ . '/../../views/layout/footer.php';
}
?>
