<?php
// admin/views/lienhe/listLienHe.php
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/navbar.php';
require_once __DIR__ . '/../layout/sidebar.php';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Quản Lý Liên Hệ</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Liên Hệ</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

<style>
.contact-stats {
    margin-bottom: 30px;
}

.stat-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 15px;
    padding: 25px;
    color: white;
    text-align: center;
    transition: transform 0.3s ease;
    height: 100%;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.2);
}

.stat-card.pending {
    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
}

.stat-card.read {
    background: linear-gradient(135deg, #4834d4 0%, #686de0 100%);
}

.stat-card.replied {
    background: linear-gradient(135deg, #00d2d3 0%, #54a0ff 100%);
}

.stat-card.closed {
    background: linear-gradient(135deg, #5f27cd 0%, #341f97 100%);
}

.stat-number {
    font-size: 2.5rem;
    font-weight: bold;
    margin-bottom: 10px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.stat-label {
    font-size: 1rem;
    opacity: 0.9;
}

.filters-card {
    background: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    margin-bottom: 30px;
    border: 1px solid #e3e6f0;
}

.table-responsive {
    background: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    border: 1px solid #e3e6f0;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
    background: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
    font-size: 14px;
}

.table td {
    vertical-align: middle;
    padding: 15px 10px;
    border-bottom: 1px solid #e3e6f0;
}

.status-badge {
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-pending {
    background: #fee2e2;
    color: #dc2626;
    border: 1px solid #fecaca;
}

.status-read {
    background: #dbeafe;
    color: #2563eb;
    border: 1px solid #bfdbfe;
}

.status-replied {
    background: #d1fae5;
    color: #059669;
    border: 1px solid #a7f3d0;
}

.status-closed {
    background: #f3e8ff;
    color: #7c3aed;
    border: 1px solid #e9d5ff;
}

.priority-badge {
    padding: 4px 12px;
    border-radius: 15px;
    font-size: 11px;
    font-weight: 600;
}

.priority-low {
    background: #e5e7eb;
    color: #6b7280;
}

.priority-normal {
    background: #dbeafe;
    color: #3b82f6;
}

.priority-high {
    background: #fed7aa;
    color: #ea580c;
}

.priority-urgent {
    background: #fecaca;
    color: #dc2626;
}

.action-buttons .btn {
    margin-right: 5px;
    margin-bottom: 5px;
    border-radius: 8px;
}

.bulk-actions {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    display: none;
    border: 1px solid #dee2e6;
}

.contact-row {
    transition: all 0.3s ease;
}

.contact-row:hover {
    background: #f8f9fa;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.unread-row {
    background: linear-gradient(90deg, #fff3cd 0%, #ffffff 10%);
    border-left: 4px solid #ffc107;
}

.contact-meta {
    font-size: 12px;
    color: #6c757d;
    margin-top: 3px;
}

.message-preview {
    max-width: 300px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    font-size: 14px;
    color: #6c757d;
}

@media (max-width: 768px) {
    .stat-card {
        margin-bottom: 20px;
    }
    
    .table-responsive {
        padding: 15px;
    }
    
    .action-buttons .btn {
        width: 100%;
        margin-bottom: 5px;
    }

    .filters-card {
        padding: 15px;
    }
}
</style>

            <!-- Statistics Cards -->
            <div class="contact-stats">
                <div class="row">
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <div class="stat-card">
                            <div class="stat-number"><?= $stats['total'] ?? 0 ?></div>
                            <div class="stat-label">Tổng số</div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <div class="stat-card pending">
                            <div class="stat-number"><?= $stats['status']['pending'] ?? 0 ?></div>
                            <div class="stat-label">Chờ xử lý</div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <div class="stat-card read">
                            <div class="stat-number"><?= $stats['status']['read'] ?? 0 ?></div>
                            <div class="stat-label">Đã đọc</div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <div class="stat-card replied">
                            <div class="stat-number"><?= $stats['status']['replied'] ?? 0 ?></div>
                            <div class="stat-label">Đã phản hồi</div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <div class="stat-card closed">
                            <div class="stat-number"><?= $stats['status']['closed'] ?? 0 ?></div>
                            <div class="stat-label">Đã đóng</div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <div class="stat-card pending">
                            <div class="stat-number"><?= $stats['unread'] ?? 0 ?></div>
                            <div class="stat-label">Chưa đọc</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="filters-card">
                <form method="GET" action="index.php">
                    <input type="hidden" name="ctl" value="lienhe">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Trạng thái</label>
                            <select name="status" class="form-control">
                                <option value="">Tất cả</option>
                                <option value="pending" <?= ($_GET['status'] ?? '') == 'pending' ? 'selected' : '' ?>>Chờ xử lý</option>
                                <option value="read" <?= ($_GET['status'] ?? '') == 'read' ? 'selected' : '' ?>>Đã đọc</option>
                                <option value="replied" <?= ($_GET['status'] ?? '') == 'replied' ? 'selected' : '' ?>>Đã phản hồi</option>
                                <option value="closed" <?= ($_GET['status'] ?? '') == 'closed' ? 'selected' : '' ?>>Đã đóng</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Mức độ ưu tiên</label>
                            <select name="priority" class="form-control">
                                <option value="">Tất cả</option>
                                <option value="low" <?= ($_GET['priority'] ?? '') == 'low' ? 'selected' : '' ?>>Thấp</option>
                                <option value="normal" <?= ($_GET['priority'] ?? '') == 'normal' ? 'selected' : '' ?>>Bình thường</option>
                                <option value="high" <?= ($_GET['priority'] ?? '') == 'high' ? 'selected' : '' ?>>Cao</option>
                                <option value="urgent" <?= ($_GET['priority'] ?? '') == 'urgent' ? 'selected' : '' ?>>Khẩn cấp</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Từ ngày</label>
                            <input type="date" name="date_from" class="form-control" value="<?= $_GET['date_from'] ?? '' ?>">
                        </div>
                        <div class="col-md-2">
                            <label>Đến ngày</label>
                            <input type="date" name="date_to" class="form-control" value="<?= $_GET['date_to'] ?? '' ?>">
                        </div>
                        <div class="col-md-2">
                            <label>Tìm kiếm</label>
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Tên, email..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Success Message -->
            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle mr-2"></i>
                    <?= $_SESSION['success_message'] ?>
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>

            <!-- Bulk Actions -->
            <div class="bulk-actions" id="bulkActions">
                <form method="POST" action="index.php?ctl=lienhe&act=bulk" id="bulkForm">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <span class="selected-count">0 mục được chọn</span>
                        </div>
                        <div class="col-md-6">
                            <select name="bulk_action" class="form-control">
                                <option value="">Chọn hành động</option>
                                <option value="mark_read">Đánh dấu đã đọc</option>
                                <option value="mark_replied">Đánh dấu đã phản hồi</option>
                                <option value="mark_closed">Đóng liên hệ</option>
                                <option value="delete">Xóa</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary" onclick="return confirm('Bạn có chắc chắn?')">
                                Thực hiện
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="clearSelection()">
                                Bỏ chọn
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Contact List -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="50">
                                <input type="checkbox" class="select-all-checkbox" id="selectAll">
                            </th>
                            <th>Thông tin liên hệ</th>
                            <th>Chủ đề</th>
                            <th>Nội dung</th>
                            <th>Trạng thái</th>
                            <th>Ưu tiên</th>
                            <th>Thời gian</th>
                            <th width="200">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($ds_lienhe)): ?>
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Không có liên hệ nào.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($ds_lienhe as $lienhe): ?>
                                <tr class="contact-row <?= !$lienhe['is_read'] ? 'unread-row' : '' ?>">
                                    <td>
                                        <input type="checkbox" class="contact-checkbox" value="<?= $lienhe['id'] ?>">
                                    </td>
                                    <td>
                                        <div>
                                            <strong><?= htmlspecialchars($lienhe['name']) ?></strong>
                                            <?php if (!$lienhe['is_read']): ?>
                                                <span class="badge badge-warning badge-sm ml-1">Mới</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="contact-meta">
                                            <i class="fas fa-envelope mr-1"></i><?= htmlspecialchars($lienhe['email']) ?>
                                        </div>
                                        <?php if ($lienhe['phone']): ?>
                                            <div class="contact-meta">
                                                <i class="fas fa-phone mr-1"></i><?= htmlspecialchars($lienhe['phone']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong><?= htmlspecialchars($lienhe['subject']) ?></strong>
                                    </td>
                                    <td>
                                        <div class="message-preview" title="<?= htmlspecialchars($lienhe['message']) ?>">
                                            <?= htmlspecialchars(substr($lienhe['message'], 0, 100)) ?><?= strlen($lienhe['message']) > 100 ? '...' : '' ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?= $lienhe['status'] ?>">
                                            <?= ucfirst($lienhe['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="priority-badge priority-<?= $lienhe['priority'] ?>">
                                            <?= ucfirst($lienhe['priority']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div><?= date('d/m/Y', strtotime($lienhe['created_at'])) ?></div>
                                        <div class="contact-meta"><?= date('H:i', strtotime($lienhe['created_at'])) ?></div>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="index.php?ctl=lienhe&act=view&id=<?= $lienhe['id'] ?>" 
                                               class="btn btn-info btn-sm" title="Xem chi tiết">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            <?php if ($lienhe['status'] !== 'replied'): ?>
                                                <button type="button" class="btn btn-success btn-sm" 
                                                        onclick="openReplyModal(<?= $lienhe['id'] ?>, '<?= htmlspecialchars($lienhe['name']) ?>')" 
                                                        title="Phản hồi">
                                                    <i class="fas fa-reply"></i>
                                                </button>
                                            <?php endif; ?>
                                            
                                            <button type="button" class="btn btn-warning btn-sm" 
                                                    onclick="openStatusModal(<?= $lienhe['id'] ?>, '<?= $lienhe['status'] ?>', '<?= $lienhe['priority'] ?>')" 
                                                    title="Cập nhật">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            
                                            <a href="index.php?ctl=lienhe&act=delete&id=<?= $lienhe['id'] ?>" 
                                               class="btn btn-danger btn-sm" 
                                               onclick="return confirm('Bạn có chắc chắn muốn xóa?')" 
                                               title="Xóa">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>

                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                    <nav class="mt-4">
                        <ul class="pagination justify-content-center">
                            <?php
                            $query_params = $_GET;
                            unset($query_params['page']);
                            $base_url = 'index.php?' . http_build_query($query_params);
                            ?>
                            
                            <?php if ($current_page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?= $base_url ?>&page=<?= $current_page - 1 ?>">Trước</a>
                                </li>
                            <?php endif; ?>
                            
                            <?php for ($i = max(1, $current_page - 2); $i <= min($total_pages, $current_page + 2); $i++): ?>
                                <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                                    <a class="page-link" href="<?= $base_url ?>&page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php if ($current_page < $total_pages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?= $base_url ?>&page=<?= $current_page + 1 ?>">Sau</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                        
                        <div class="text-center text-muted">
                            Hiển thị <?= ($current_page - 1) * 10 + 1 ?> - <?= min($current_page * 10, $total_records) ?> 
                            trong tổng số <?= $total_records ?> liên hệ
                        </div>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>

<!-- Reply Modal -->
<div class="modal fade" id="replyModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Phản hồi liên hệ</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form method="POST" action="index.php?ctl=lienhe&act=reply">
                <div class="modal-body">
                    <input type="hidden" name="id" id="replyContactId">
                    <input type="hidden" name="redirect" value="<?= $_SERVER['REQUEST_URI'] ?>">
                    
                    <div class="form-group">
                        <label>Khách hàng:</label>
                        <div id="replyCustomerName" class="font-weight-bold"></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="reply_message">Nội dung phản hồi *</label>
                        <textarea name="reply_message" id="reply_message" class="form-control" rows="8" required
                                  placeholder="Nhập nội dung phản hồi cho khách hàng..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-paper-plane mr-1"></i>Gửi phản hồi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cập nhật trạng thái</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form method="POST" action="index.php?ctl=lienhe&act=updateStatus">
                <div class="modal-body">
                    <input type="hidden" name="id" id="statusContactId">
                    <input type="hidden" name="redirect" value="<?= $_SERVER['REQUEST_URI'] ?>">
                    
                    <div class="form-group">
                        <label>Trạng thái</label>
                        <select name="status" id="statusSelect" class="form-control">
                            <option value="pending">Chờ xử lý</option>
                            <option value="read">Đã đọc</option>
                            <option value="replied">Đã phản hồi</option>
                            <option value="closed">Đã đóng</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Mức độ ưu tiên</label>
                        <select name="priority" id="prioritySelect" class="form-control">
                            <option value="low">Thấp</option>
                            <option value="normal">Bình thường</option>
                            <option value="high">Cao</option>
                            <option value="urgent">Khẩn cấp</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Bulk selection
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.contact-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
    updateBulkActions();
});

document.querySelectorAll('.contact-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', updateBulkActions);
});

function updateBulkActions() {
    const checked = document.querySelectorAll('.contact-checkbox:checked');
    const bulkActions = document.getElementById('bulkActions');
    const selectedCount = document.querySelector('.selected-count');
    
    if (checked.length > 0) {
        bulkActions.style.display = 'block';
        selectedCount.textContent = checked.length + ' mục được chọn';
        
        // Update hidden inputs for bulk form
        const existingInputs = document.querySelectorAll('#bulkForm input[name="selected_ids[]"]');
        existingInputs.forEach(input => input.remove());
        
        checked.forEach(checkbox => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'selected_ids[]';
            input.value = checkbox.value;
            document.getElementById('bulkForm').appendChild(input);
        });
    } else {
        bulkActions.style.display = 'none';
    }
}

function clearSelection() {
    document.getElementById('selectAll').checked = false;
    document.querySelectorAll('.contact-checkbox').forEach(checkbox => {
        checkbox.checked = false;
    });
    updateBulkActions();
}

// Modal functions
function openReplyModal(id, customerName) {
    document.getElementById('replyContactId').value = id;
    document.getElementById('replyCustomerName').textContent = customerName;
    document.getElementById('reply_message').value = '';
    $('#replyModal').modal('show');
}

function openStatusModal(id, currentStatus, currentPriority) {
    document.getElementById('statusContactId').value = id;
    document.getElementById('statusSelect').value = currentStatus;
    document.getElementById('prioritySelect').value = currentPriority;
    $('#statusModal').modal('show');
}

// Auto refresh unread count every 30 seconds
setInterval(function() {
    fetch('index.php?ctl=lienhe&act=getUnreadCount')
        .then(response => response.json())
        .then(data => {
            // Update unread count in stats if needed
        })        .catch(error => console.error('Error:', error));
}, 30000);
</script>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
