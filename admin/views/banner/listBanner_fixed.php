<?php
// Đảm bảo layout admin được load
if (!defined('ADMIN_LAYOUT_LOADED')) {
    require_once __DIR__ . '/../../layout/header.php';
}
?>

<!-- Custom CSS cho Banner Management -->
<style>
.banner-stats-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 15px;
    color: white;
    transition: transform 0.3s ease;
}

.banner-stats-card:hover {
    transform: translateY(-5px);
}

.filter-card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border-radius: 15px;
}

.filter-card .card-header {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
    border-radius: 15px 15px 0 0;
    border: none;
}

.banner-table-card {
    border: none;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    border-radius: 15px;
    overflow: hidden;
}

.table th {
    border-top: none;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
    color: #6c757d;
    background-color: #f8f9fa;
}

.banner-preview {
    transition: all 0.3s ease;
    cursor: pointer;
    border-radius: 8px;
}

.banner-preview:hover {
    transform: scale(1.05);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.status-toggle {
    transform: scale(1.2);
}

.btn-group-vertical .btn {
    border-radius: 0.375rem !important;
    margin-bottom: 0.25rem;
    font-size: 0.75rem;
}

.empty-state {
    padding: 3rem 1rem;
    text-align: center;
}

.badge {
    font-size: 0.7em;
    font-weight: 500;
}

/* Responsive */
@media (max-width: 768px) {
    .btn-group-vertical .btn {
        font-size: 0.65rem;
        padding: 0.25rem 0.5rem;
    }
    
    .table-responsive {
        font-size: 0.85rem;
    }
}
</style>

<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0">
                    <i class="fas fa-image me-2"></i>Quản lý Banner Quảng Cáo
                </h3>
                <div>
                    <a href="?act=form-them-banner" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>Thêm Banner
                    </a>
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
            <?php if (isset($statistics) && is_array($statistics)): ?>
            <div class="row mb-4">
                <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                    <div class="card banner-stats-card text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Tổng Banner</h6>
                                    <h3 class="mb-0"><?= number_format($statistics['total_banners'] ?? 0) ?></h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-image fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Hoạt động</h6>
                                    <h3 class="mb-0"><?= number_format($statistics['active_banners'] ?? 0) ?></h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-check-circle fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Popup</h6>
                                    <h3 class="mb-0"><?= number_format($statistics['popup_banners'] ?? 0) ?></h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-window-restore fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Lượt Xem</h6>
                                    <h3 class="mb-0"><?= number_format($statistics['total_views'] ?? 0) ?></h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-eye fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                    <div class="card bg-secondary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Lượt Click</h6>
                                    <h3 class="mb-0"><?= number_format($statistics['total_clicks'] ?? 0) ?></h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-mouse-pointer fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                    <div class="card bg-dark text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">CTR (%)</h6>
                                    <h3 class="mb-0"><?= $statistics['click_through_rate'] ?? 0 ?>%</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-chart-line fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Bộ lọc nâng cao -->
            <div class="card filter-card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-filter me-2"></i>Bộ Lọc & Tìm Kiếm
                    </h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="" class="row g-3" id="filterForm">
                        <input type="hidden" name="act" value="danh-sach-banner">
                        
                        <div class="col-md-3">
                            <label class="form-label">
                                <i class="fas fa-search me-1"></i>Tìm kiếm
                            </label>
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Tên banner hoặc mô tả..." 
                                       value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                                <?php if (!empty($_GET['search'])): ?>
                                <button type="button" class="btn btn-outline-secondary" onclick="clearSearch()">
                                    <i class="fas fa-times"></i>
                                </button>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <label class="form-label">
                                <i class="fas fa-toggle-on me-1"></i>Trạng thái
                            </label>
                            <select name="status" class="form-select">
                                <option value="">Tất cả trạng thái</option>
                                <option value="1" <?= ($_GET['status'] ?? '') === '1' ? 'selected' : '' ?>>Hoạt động</option>
                                <option value="0" <?= ($_GET['status'] ?? '') === '0' ? 'selected' : '' ?>>Không hoạt động</option>
                            </select>
                        </div>
                        
                        <div class="col-md-2">
                            <label class="form-label">
                                <i class="fas fa-layer-group me-1"></i>Loại hiển thị
                            </label>
                            <select name="type" class="form-select">
                                <option value="">Tất cả loại</option>
                                <option value="popup" <?= ($_GET['type'] ?? '') === 'popup' ? 'selected' : '' ?>>Popup</option>
                                <option value="banner_top" <?= ($_GET['type'] ?? '') === 'banner_top' ? 'selected' : '' ?>>Banner Top</option>
                                <option value="banner_bottom" <?= ($_GET['type'] ?? '') === 'banner_bottom' ? 'selected' : '' ?>>Banner Bottom</option>
                                <option value="sidebar" <?= ($_GET['type'] ?? '') === 'sidebar' ? 'selected' : '' ?>>Sidebar</option>
                            </select>
                        </div>
                        
                        <div class="col-md-2">
                            <label class="form-label">
                                <i class="fas fa-calendar-alt me-1"></i>Từ ngày
                            </label>
                            <input type="date" name="date_from" class="form-control" 
                                   value="<?= htmlspecialchars($_GET['date_from'] ?? '') ?>">
                        </div>
                        
                        <div class="col-md-2">
                            <label class="form-label">
                                <i class="fas fa-calendar-check me-1"></i>Đến ngày
                            </label>
                            <input type="date" name="date_to" class="form-control" 
                                   value="<?= htmlspecialchars($_GET['date_to'] ?? '') ?>">
                        </div>
                        
                        <div class="col-md-1">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search me-1"></i>Lọc
                                </button>
                                <a href="?act=danh-sach-banner" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-refresh me-1"></i>Reset
                                </a>
                            </div>
                        </div>
                    </form>
                    
                    <!-- Quick Actions -->
                    <div class="mt-3 pt-3 border-top">
                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Hiển thị <?= count($list ?? []) ?> / <?= $totalRecords ?? 0 ?> banner
                                </small>
                            </div>
                            <div class="col-md-6 text-end">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-success" onclick="bulkAction('activate')">
                                        <i class="fas fa-check me-1"></i>Kích hoạt đã chọn
                                    </button>
                                    <button type="button" class="btn btn-outline-warning" onclick="bulkAction('deactivate')">
                                        <i class="fas fa-pause me-1"></i>Tạm dừng đã chọn
                                    </button>
                                    <button type="button" class="btn btn-outline-danger" onclick="bulkAction('delete')">
                                        <i class="fas fa-trash me-1"></i>Xóa đã chọn
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danh sách Banner -->
            <div class="card banner-table-card">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-list me-2"></i>Danh Sách Banner
                        </h5>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="selectAll">
                            <label class="form-check-label" for="selectAll">
                                Chọn tất cả
                            </label>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="bannerTable">
                            <thead>
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
                                                <span class="badge bg-light text-dark">#<?= $banner['id'] ?></span>
                                            </td>
                                            <td class="text-center">
                                                <?php if (!empty($banner['hinh_anh'])): ?>
                                                    <img src="<?= $banner['hinh_anh'] ?>" 
                                                         alt="<?= htmlspecialchars($banner['ten_banner']) ?>" 
                                                         class="img-thumbnail banner-preview" 
                                                         style="max-width: 80px; max-height: 50px; object-fit: cover;"
                                                         onclick="previewBanner('<?= $banner['hinh_anh'] ?>', '<?= htmlspecialchars($banner['ten_banner']) ?>')">
                                                <?php else: ?>
                                                    <div class="text-center text-muted p-2 border rounded">
                                                        <i class="fas fa-image"></i>
                                                        <br><small>Không có ảnh</small>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div>
                                                    <h6 class="mb-1"><?= htmlspecialchars($banner['ten_banner']) ?></h6>
                                                    <?php if (!empty($banner['mo_ta'])): ?>
                                                        <p class="text-muted mb-1 small">
                                                            <?= htmlspecialchars(substr($banner['mo_ta'], 0, 60)) ?>
                                                            <?= strlen($banner['mo_ta']) > 60 ? '...' : '' ?>
                                                        </p>
                                                    <?php endif; ?>
                                                    <?php if (!empty($banner['link_url'])): ?>
                                                        <div class="small">
                                                            <i class="fas fa-link text-primary me-1"></i>
                                                            <a href="<?= $banner['link_url'] ?>" target="_blank" class="text-decoration-none">
                                                                <?= substr($banner['link_url'], 0, 30) ?>...
                                                            </a>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="mb-2">
                                                    <?php
                                                    $typeConfig = [
                                                        'popup' => ['badge' => 'warning', 'icon' => 'fa-window-restore', 'text' => 'Popup'],
                                                        'banner_top' => ['badge' => 'info', 'icon' => 'fa-arrow-up', 'text' => 'Top'],
                                                        'banner_bottom' => ['badge' => 'secondary', 'icon' => 'fa-arrow-down', 'text' => 'Bottom'],
                                                        'sidebar' => ['badge' => 'primary', 'icon' => 'fa-sidebar', 'text' => 'Sidebar']
                                                    ];
                                                    $config = $typeConfig[$banner['loai_hien_thi']] ?? ['badge' => 'light', 'icon' => 'fa-question', 'text' => $banner['loai_hien_thi']];
                                                    ?>
                                                    <span class="badge bg-<?= $config['badge'] ?>">
                                                        <i class="fas <?= $config['icon'] ?> me-1"></i>
                                                        <?= $config['text'] ?>
                                                    </span>
                                                </div>
                                                <div class="text-center">
                                                    <span class="badge bg-light text-dark">
                                                        Thứ tự: <?= $banner['thu_tu'] ?>
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="small">
                                                    <div class="d-flex justify-content-between">
                                                        <span>Xem:</span>
                                                        <span class="badge bg-success"><?= number_format($banner['luot_xem']) ?></span>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span>Click:</span>
                                                        <span class="badge bg-primary"><?= number_format($banner['luot_click']) ?></span>
                                                    </div>
                                                    <?php if ($banner['luot_xem'] > 0): ?>
                                                        <div class="text-info mt-1">
                                                            CTR: <?= round(($banner['luot_click'] / $banner['luot_xem']) * 100, 2) ?>%
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="mb-2">
                                                    <div class="form-check form-switch d-flex justify-content-center">
                                                        <input class="form-check-input status-toggle" type="checkbox" 
                                                               data-id="<?= $banner['id'] ?>" 
                                                               <?= $banner['trang_thai'] ? 'checked' : '' ?>>
                                                    </div>
                                                </div>
                                                <div>
                                                    <span class="badge bg-<?= $banner['trang_thai'] ? 'success' : 'secondary' ?> small">
                                                        <i class="fas <?= $banner['trang_thai'] ? 'fa-check-circle' : 'fa-pause-circle' ?> me-1"></i>
                                                        <?= $banner['trang_thai'] ? 'Hoạt động' : 'Tạm dừng' ?>
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="small text-muted">
                                                    <div>
                                                        <i class="fas fa-calendar-plus me-1"></i>
                                                        <?= date('d/m/Y', strtotime($banner['created_at'])) ?>
                                                    </div>
                                                    <div class="mt-1">
                                                        <i class="fas fa-clock me-1"></i>
                                                        <?= date('H:i', strtotime($banner['created_at'])) ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group-vertical btn-group-sm w-100" role="group">
                                                    <a href="?act=form-sua-banner&id=<?= $banner['id'] ?>" 
                                                       class="btn btn-outline-primary btn-sm" title="Chỉnh sửa">
                                                        <i class="fas fa-edit me-1"></i>Sửa
                                                    </a>
                                                    <button type="button" class="btn btn-outline-info btn-sm" 
                                                            onclick="duplicateBanner(<?= $banner['id'] ?>)" title="Nhân bản">
                                                        <i class="fas fa-copy me-1"></i>Sao chép
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger btn-sm" 
                                                            onclick="deleteBanner(<?= $banner['id'] ?>)" title="Xóa">
                                                        <i class="fas fa-trash me-1"></i>Xóa
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center py-5">
                                            <div class="empty-state">
                                                <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                                <h5 class="text-muted">Chưa có banner nào</h5>
                                                <p class="text-muted">Hãy tạo banner đầu tiên để bắt đầu quảng cáo!</p>
                                                <a href="?act=form-them-banner" class="btn btn-primary">
                                                    <i class="fas fa-plus me-2"></i>Tạo Banner Đầu Tiên
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
                        <div class="d-flex justify-content-center mt-4">
                            <nav aria-label="Phân trang banner">
                                <ul class="pagination">
                                    <?php
                                    $currentPage = $page ?? 1;
                                    $queryParams = $_GET;
                                    unset($queryParams['page']);
                                    $baseUrl = '?' . http_build_query($queryParams);
                                    ?>
                                    
                                    <?php if ($currentPage > 1): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="<?= $baseUrl ?>&page=<?= $currentPage - 1 ?>">
                                                <i class="fas fa-chevron-left"></i>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++): ?>
                                        <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                                            <a class="page-link" href="<?= $baseUrl ?>&page=<?= $i ?>"><?= $i ?></a>
                                        </li>
                                    <?php endfor; ?>

                                    <?php if ($currentPage < $totalPages): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="<?= $baseUrl ?>&page=<?= $currentPage + 1 ?>">
                                                <i class="fas fa-chevron-right"></i>
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

<!-- Banner Preview Modal -->
<div class="modal fade" id="bannerPreviewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xem trước Banner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="previewImage" src="" alt="" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>

<script>
// Enhanced Banner Management JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Select all functionality
    const selectAllCheckbox = document.getElementById('checkAll');
    const bannerCheckboxes = document.querySelectorAll('.banner-checkbox');
    
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            bannerCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkActionButtons();
        });
    }
    
    bannerCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkActionButtons);
    });
    
    function updateBulkActionButtons() {
        const checkedBoxes = document.querySelectorAll('.banner-checkbox:checked');
        const bulkActionButtons = document.querySelectorAll('[onclick*="bulkAction"]');
        
        bulkActionButtons.forEach(button => {
            button.disabled = checkedBoxes.length === 0;
        });
    }
    
    // Status toggle
    document.querySelectorAll('.status-toggle').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const bannerId = this.dataset.id;
            const newStatus = this.checked ? 1 : 0;
            
            updateBannerStatus(bannerId, newStatus, this);
        });
    });
    
    updateBulkActionButtons();
});

// Clear search function
function clearSearch() {
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        searchInput.value = '';
        document.getElementById('filterForm').submit();
    }
}

// Preview banner function
function previewBanner(imagePath, bannerName) {
    const modal = new bootstrap.Modal(document.getElementById('bannerPreviewModal'));
    const previewImage = document.getElementById('previewImage');
    const modalTitle = document.querySelector('#bannerPreviewModal .modal-title');
    
    previewImage.src = imagePath;
    previewImage.alt = bannerName;
    modalTitle.textContent = 'Xem trước: ' + bannerName;
    
    modal.show();
}

// Update banner status
function updateBannerStatus(bannerId, status, toggleElement) {
    const originalChecked = toggleElement.checked;
    
    // Show loading
    toggleElement.disabled = true;
    
    fetch('?act=update-banner-status', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `id=${bannerId}&status=${status}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Success notification
            showNotification(data.message, 'success');
            
            // Update status badge
            const row = toggleElement.closest('tr');
            const statusBadge = row.querySelector('.badge');
            if (status == 1) {
                statusBadge.className = 'badge bg-success small';
                statusBadge.innerHTML = '<i class="fas fa-check-circle me-1"></i>Hoạt động';
            } else {
                statusBadge.className = 'badge bg-secondary small';
                statusBadge.innerHTML = '<i class="fas fa-pause-circle me-1"></i>Tạm dừng';
            }
        } else {
            // Revert checkbox state
            toggleElement.checked = !originalChecked;
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        // Revert checkbox state
        toggleElement.checked = !originalChecked;
        showNotification('Có lỗi xảy ra khi cập nhật trạng thái', 'error');
        console.error('Error:', error);
    })
    .finally(() => {
        toggleElement.disabled = false;
    });
}

// Delete banner function
function deleteBanner(bannerId) {
    if (confirm('Bạn có chắc chắn muốn xóa banner này không?\nHành động này không thể hoàn tác!')) {
        window.location.href = `?act=xoa-banner&id=${bannerId}`;
    }
}

// Duplicate banner function
function duplicateBanner(bannerId) {
    if (confirm('Bạn có muốn tạo bản sao của banner này không?')) {
        // Implementation for duplicate banner
        showNotification('Chức năng sao chép banner đang được phát triển', 'info');
    }
}

// Bulk actions
function bulkAction(action) {
    const checkedBoxes = document.querySelectorAll('.banner-checkbox:checked');
    const selectedIds = Array.from(checkedBoxes).map(cb => cb.value);
    
    if (selectedIds.length === 0) {
        showNotification('Vui lòng chọn ít nhất một banner', 'warning');
        return;
    }
    
    let confirmMessage = '';
    
    switch (action) {
        case 'activate':
            confirmMessage = `Bạn có muốn kích hoạt ${selectedIds.length} banner đã chọn không?`;
            break;
        case 'deactivate':
            confirmMessage = `Bạn có muốn tạm dừng ${selectedIds.length} banner đã chọn không?`;
            break;
        case 'delete':
            confirmMessage = `Bạn có chắc chắn muốn xóa ${selectedIds.length} banner đã chọn không?\nHành động này không thể hoàn tác!`;
            break;
    }
    
    if (confirm(confirmMessage)) {
        showNotification(`Đang thực hiện ${action} cho ${selectedIds.length} banner...`, 'info');
        // Implementation for bulk actions
    }
}

// Notification function
function showNotification(message, type = 'info') {
    const alertClass = type === 'error' ? 'danger' : type;
    const iconClass = {
        'success': 'fa-check-circle',
        'error': 'fa-exclamation-triangle',
        'warning': 'fa-exclamation-circle',
        'info': 'fa-info-circle'
    }[type] || 'fa-info-circle';
    
    const notification = document.createElement('div');
    notification.className = `alert alert-${alertClass} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 1055; min-width: 300px;';
    notification.innerHTML = `
        <i class="fas ${iconClass} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}
</script>

<?php
// Đảm bảo layout admin được đóng
if (!defined('ADMIN_LAYOUT_LOADED')) {
    require_once __DIR__ . '/../../layout/footer.php';
}
?>
