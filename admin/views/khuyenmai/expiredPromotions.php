<?php
require_once 'admin/models/KhuyenMai.php';
require_once 'admin/controllers/KhuyenMaiController.php';

$khuyenMaiModel = new KhuyenMai();
$controller = new KhuyenMaiController();

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Get expired promotions
$expiredPromotions = $khuyenMaiModel->getExpiredPromotions($limit, $offset);
$totalExpired = $khuyenMaiModel->getTotalExpiredPromotions();
$totalPages = ceil($totalExpired / $limit);

// Calculate statistics
$stats = [
    'total_expired' => $totalExpired,
    'expired_this_month' => $khuyenMaiModel->getExpiredThisMonth(),
    'total_value_lost' => $khuyenMaiModel->getExpiredPromotionsValue(),
    'most_expired_type' => $khuyenMaiModel->getMostExpiredPromotionType()
];
?>

<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Khuyến Mãi Đã Hết Hạn</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="admin/index.php">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="admin/index.php?act=listKhuyenMai">Khuyến mãi</a></li>
                        <li class="breadcrumb-item active">Đã hết hạn</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Statistics Cards -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3><?= number_format($stats['total_expired']) ?></h3>
                            <p>Tổng Số Đã Hết Hạn</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= number_format($stats['expired_this_month']) ?></h3>
                            <p>Hết Hạn Tháng Này</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-times"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?= number_format($stats['total_value_lost']) ?>đ</h3>
                            <p>Tổng Giá Trị Mất</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= $stats['most_expired_type'] ?></h3>
                            <p>Loại Hết Hạn Nhiều Nhất</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Table Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-history mr-1"></i>
                        Danh Sách Khuyến Mãi Đã Hết Hạn
                    </h3>
                    <div class="card-tools">
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="exportExpiredReport()">
                                <i class="fas fa-download"></i> Xuất Báo Cáo
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="cleanupExpired()">
                                <i class="fas fa-trash"></i> Dọn Dẹp
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filter Controls -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <select class="form-control" id="typeFilter" onchange="filterPromotions()">
                                <option value="">Tất cả loại</option>
                                <option value="percentage">Giảm theo %</option>
                                <option value="fixed">Giảm cố định</option>
                                <option value="free_shipping">Miễn phí ship</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" id="periodFilter" onchange="filterPromotions()">
                                <option value="">Tất cả thời gian</option>
                                <option value="this_week">Tuần này</option>
                                <option value="this_month">Tháng này</option>
                                <option value="last_month">Tháng trước</option>
                                <option value="this_quarter">Quý này</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control" id="searchInput" placeholder="Tìm kiếm khuyến mãi...">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" onclick="searchPromotions()">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-outline-info btn-block" onclick="resetFilters()">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                        </div>
                    </div>

                    <!-- Promotions Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="5%">
                                        <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                                    </th>
                                    <th width="15%">Tên Khuyến Mãi</th>
                                    <th width="10%">Mã</th>
                                    <th width="12%">Loại</th>
                                    <th width="10%">Giá Trị</th>
                                    <th width="12%">Ngày Hết Hạn</th>
                                    <th width="10%">Lượt Sử Dụng</th>
                                    <th width="10%">Doanh Thu</th>
                                    <th width="8%">Trạng Thái</th>
                                    <th width="8%">Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody id="promotionsTableBody">
                                <?php if (empty($expiredPromotions)): ?>
                                    <tr>
                                        <td colspan="10" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                                <p>Không có khuyến mãi đã hết hạn</p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($expiredPromotions as $promotion): ?>
                                        <tr data-id="<?= $promotion['id'] ?>">
                                            <td>
                                                <input type="checkbox" class="promotion-checkbox" value="<?= $promotion['id'] ?>">
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <strong><?= htmlspecialchars($promotion['ten_khuyen_mai']) ?></strong>
                                                        <br>
                                                        <small class="text-muted"><?= htmlspecialchars($promotion['mo_ta']) ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <code class="bg-light p-1"><?= htmlspecialchars($promotion['ma_khuyen_mai']) ?></code>
                                            </td>
                                            <td>
                                                <?php
                                                $typeLabels = [
                                                    'percentage' => ['Giảm %', 'badge-info'],
                                                    'fixed' => ['Giảm cố định', 'badge-success'],
                                                    'free_shipping' => ['Miễn phí ship', 'badge-warning']
                                                ];
                                                $typeData = $typeLabels[$promotion['loai_khuyen_mai']] ?? ['Khác', 'badge-secondary'];
                                                ?>
                                                <span class="badge <?= $typeData[1] ?>"><?= $typeData[0] ?></span>
                                            </td>
                                            <td>
                                                <?php if ($promotion['loai_khuyen_mai'] == 'percentage'): ?>
                                                    <strong class="text-info"><?= $promotion['gia_tri'] ?>%</strong>
                                                <?php elseif ($promotion['loai_khuyen_mai'] == 'fixed'): ?>
                                                    <strong class="text-success"><?= number_format($promotion['gia_tri']) ?>đ</strong>
                                                <?php else: ?>
                                                    <strong class="text-warning">Miễn phí</strong>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="text-danger">
                                                    <i class="fas fa-clock"></i>
                                                    <?= date('d/m/Y H:i', strtotime($promotion['ngay_ket_thuc'])) ?>
                                                </span>
                                                <br>
                                                <small class="text-muted">
                                                    <?php
                                                    $daysExpired = floor((time() - strtotime($promotion['ngay_ket_thuc'])) / (60 * 60 * 24));
                                                    echo $daysExpired . ' ngày trước';
                                                    ?>
                                                </small>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    <strong><?= number_format($promotion['luot_su_dung'] ?? 0) ?></strong>
                                                    <?php if (isset($promotion['gioi_han_su_dung']) && $promotion['gioi_han_su_dung'] > 0): ?>
                                                        <br>
                                                        <small class="text-muted">/ <?= number_format($promotion['gioi_han_su_dung']) ?></small>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <strong class="text-primary">
                                                    <?= number_format($promotion['doanh_thu'] ?? 0) ?>đ
                                                </strong>
                                            </td>
                                            <td>
                                                <span class="badge badge-secondary">
                                                    <i class="fas fa-times-circle"></i> Đã hết hạn
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-sm btn-outline-info" 
                                                            onclick="viewPromotionDetails(<?= $promotion['id'] ?>)"
                                                            title="Xem chi tiết">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-success" 
                                                            onclick="renewPromotion(<?= $promotion['id'] ?>)"
                                                            title="Gia hạn">
                                                        <i class="fas fa-redo"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                                            onclick="deletePromotion(<?= $promotion['id'] ?>)"
                                                            title="Xóa">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <?php if ($totalPages > 1): ?>
                        <div class="row mt-3">
                            <div class="col-sm-12 col-md-5">
                                <div class="dataTables_info">
                                    Hiển thị <?= min($limit, $totalExpired) ?> trên tổng số <?= number_format($totalExpired) ?> khuyến mãi
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_simple_numbers float-right">
                                    <ul class="pagination">
                                        <?php if ($page > 1): ?>
                                            <li class="paginate_button page-item previous">
                                                <a href="admin/index.php?act=khuyenMaiDaHetHan&page=<?= $page - 1 ?>" class="page-link">Trước</a>
                                            </li>
                                        <?php endif; ?>
                                        
                                        <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                                            <li class="paginate_button page-item <?= $i == $page ? 'active' : '' ?>">
                                                <a href="admin/index.php?act=khuyenMaiDaHetHan&page=<?= $i ?>" class="page-link"><?= $i ?></a>
                                            </li>
                                        <?php endfor; ?>
                                        
                                        <?php if ($page < $totalPages): ?>
                                            <li class="paginate_button page-item next">
                                                <a href="admin/index.php?act=khuyenMaiDaHetHan&page=<?= $page + 1 ?>" class="page-link">Sau</a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Renew Promotion Modal -->
<div class="modal fade" id="renewPromotionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Gia Hạn Khuyến Mãi</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="renewPromotionForm">
                <div class="modal-body">
                    <input type="hidden" id="renewPromotionId">
                    <div class="form-group">
                        <label>Tên khuyến mãi:</label>
                        <input type="text" class="form-control" id="renewPromotionName" readonly>
                    </div>
                    <div class="form-group">
                        <label>Ngày bắt đầu mới:</label>
                        <input type="datetime-local" class="form-control" id="renewStartDate" required>
                    </div>
                    <div class="form-group">
                        <label>Ngày kết thúc mới:</label>
                        <input type="datetime-local" class="form-control" id="renewEndDate" required>
                    </div>
                    <div class="form-group">
                        <label>Giới hạn sử dụng mới:</label>
                        <input type="number" class="form-control" id="renewUsageLimit" min="1">
                        <small class="form-text text-muted">Để trống nếu không giới hạn</small>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="resetUsageCount">
                        <label class="form-check-label" for="resetUsageCount">
                            Reset số lượt sử dụng về 0
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-success">Gia Hạn</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bulk Actions Modal -->
<div class="modal fade" id="bulkActionsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thao Tác Hàng Loạt</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Bạn đã chọn <span id="selectedCount">0</span> khuyến mãi. Chọn thao tác:</p>
                <div class="btn-group-vertical w-100">
                    <button type="button" class="btn btn-outline-success mb-2" onclick="bulkRenew()">
                        <i class="fas fa-redo"></i> Gia hạn tất cả
                    </button>
                    <button type="button" class="btn btn-outline-danger mb-2" onclick="bulkDelete()">
                        <i class="fas fa-trash"></i> Xóa tất cả
                    </button>
                    <button type="button" class="btn btn-outline-info" onclick="bulkExport()">
                        <i class="fas fa-download"></i> Xuất báo cáo
                    </button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<script>
// Initialize page
$(document).ready(function() {
    // Set up real-time updates
    setInterval(updatePromotionCounts, 300000); // Update every 5 minutes
});

function filterPromotions() {
    const type = $('#typeFilter').val();
    const period = $('#periodFilter').val();
    const search = $('#searchInput').val();
    
    // Reload page with filters
    let url = 'admin/index.php?act=khuyenMaiDaHetHan';
    const params = [];
    
    if (type) params.push('type=' + type);
    if (period) params.push('period=' + period);
    if (search) params.push('search=' + encodeURIComponent(search));
    
    if (params.length > 0) {
        url += '&' + params.join('&');
    }
    
    window.location.href = url;
}

function searchPromotions() {
    filterPromotions();
}

function resetFilters() {
    $('#typeFilter').val('');
    $('#periodFilter').val('');
    $('#searchInput').val('');
    window.location.href = 'admin/index.php?act=khuyenMaiDaHetHan';
}

function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.promotion-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
    
    updateSelectedCount();
}

function updateSelectedCount() {
    const selected = document.querySelectorAll('.promotion-checkbox:checked').length;
    document.getElementById('selectedCount').textContent = selected;
    
    // Show/hide bulk actions button
    if (selected > 0) {
        if (!document.getElementById('bulkActionsBtn')) {
            const bulkBtn = `<button type="button" id="bulkActionsBtn" class="btn btn-outline-primary btn-sm ml-2" data-toggle="modal" data-target="#bulkActionsModal">
                <i class="fas fa-tasks"></i> Thao tác hàng loạt (${selected})
            </button>`;
            $('.card-tools .btn-group').append(bulkBtn);
        } else {
            $('#bulkActionsBtn').html(`<i class="fas fa-tasks"></i> Thao tác hàng loạt (${selected})`);
        }
    } else {
        $('#bulkActionsBtn').remove();
    }
}

// Event listeners for checkboxes
$(document).on('change', '.promotion-checkbox', updateSelectedCount);

function renewPromotion(id) {
    // Get promotion details
    $.get('admin/index.php?act=getPromotionDetails&id=' + id, function(data) {
        const promotion = JSON.parse(data);
        $('#renewPromotionId').val(id);
        $('#renewPromotionName').val(promotion.ten_khuyen_mai);
        
        // Set default dates (extend by 30 days from now)
        const now = new Date();
        const startDate = new Date(now.getTime() + 24 * 60 * 60 * 1000); // Tomorrow
        const endDate = new Date(startDate.getTime() + 30 * 24 * 60 * 60 * 1000); // 30 days later
        
        $('#renewStartDate').val(startDate.toISOString().slice(0, 16));
        $('#renewEndDate').val(endDate.toISOString().slice(0, 16));
        
        $('#renewPromotionModal').modal('show');
    });
}

$('#renewPromotionForm').on('submit', function(e) {
    e.preventDefault();
    
    const formData = {
        id: $('#renewPromotionId').val(),
        start_date: $('#renewStartDate').val(),
        end_date: $('#renewEndDate').val(),
        usage_limit: $('#renewUsageLimit').val(),
        reset_usage: $('#resetUsageCount').is(':checked')
    };
    
    $.post('admin/index.php?act=renewPromotion', formData, function(response) {
        const result = JSON.parse(response);
        if (result.success) {
            toastr.success('Gia hạn khuyến mãi thành công!');
            $('#renewPromotionModal').modal('hide');
            location.reload();
        } else {
            toastr.error(result.message || 'Có lỗi xảy ra!');
        }
    });
});

function viewPromotionDetails(id) {
    window.open('admin/index.php?act=viewPromotionDetails&id=' + id, '_blank');
}

function deletePromotion(id) {
    if (confirm('Bạn có chắc chắn muốn xóa khuyến mãi này?')) {
        $.post('admin/index.php?act=deletePromotion', {id: id}, function(response) {
            const result = JSON.parse(response);
            if (result.success) {
                toastr.success('Xóa khuyến mãi thành công!');
                location.reload();
            } else {
                toastr.error(result.message || 'Có lỗi xảy ra!');
            }
        });
    }
}

function exportExpiredReport() {
    window.open('admin/index.php?act=exportExpiredPromotionsReport', '_blank');
}

function cleanupExpired() {
    if (confirm('Bạn có chắc chắn muốn xóa tất cả khuyến mãi đã hết hạn? Thao tác này không thể hoàn tác!')) {
        $.post('admin/index.php?act=cleanupExpiredPromotions', function(response) {
            const result = JSON.parse(response);
            if (result.success) {
                toastr.success('Dọn dẹp thành công! Đã xóa ' + result.count + ' khuyến mãi.');
                location.reload();
            } else {
                toastr.error(result.message || 'Có lỗi xảy ra!');
            }
        });
    }
}

function bulkRenew() {
    const selected = Array.from(document.querySelectorAll('.promotion-checkbox:checked')).map(cb => cb.value);
    if (selected.length === 0) return;
    
    $('#bulkActionsModal').modal('hide');
    
    // Show bulk renew form (simplified)
    const startDate = prompt('Ngày bắt đầu mới (YYYY-MM-DD):');
    const endDate = prompt('Ngày kết thúc mới (YYYY-MM-DD):');
    
    if (startDate && endDate) {
        $.post('admin/index.php?act=bulkRenewPromotions', {
            ids: selected,
            start_date: startDate,
            end_date: endDate
        }, function(response) {
            const result = JSON.parse(response);
            if (result.success) {
                toastr.success('Gia hạn thành công ' + result.count + ' khuyến mãi!');
                location.reload();
            } else {
                toastr.error(result.message || 'Có lỗi xảy ra!');
            }
        });
    }
}

function bulkDelete() {
    const selected = Array.from(document.querySelectorAll('.promotion-checkbox:checked')).map(cb => cb.value);
    if (selected.length === 0) return;
    
    if (confirm(`Bạn có chắc chắn muốn xóa ${selected.length} khuyến mãi đã chọn?`)) {
        $.post('admin/index.php?act=bulkDeletePromotions', {ids: selected}, function(response) {
            const result = JSON.parse(response);
            if (result.success) {
                toastr.success('Xóa thành công ' + result.count + ' khuyến mãi!');
                location.reload();
            } else {
                toastr.error(result.message || 'Có lỗi xảy ra!');
            }
        });
    }
}

function bulkExport() {
    const selected = Array.from(document.querySelectorAll('.promotion-checkbox:checked')).map(cb => cb.value);
    if (selected.length === 0) return;
    
    const params = new URLSearchParams({
        act: 'exportSelectedPromotions',
        ids: selected.join(',')
    });
    
    window.open('admin/index.php?' + params.toString(), '_blank');
}

function updatePromotionCounts() {
    $.get('admin/index.php?act=getPromotionCounts', function(data) {
        const counts = JSON.parse(data);
        // Update any badge counts if needed
    });
}
</script>
