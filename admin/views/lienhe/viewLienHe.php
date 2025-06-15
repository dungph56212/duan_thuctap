<?php
// admin/views/lienhe/viewLienHe.php
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
                    <h1 class="m-0">Chi Tiết Liên Hệ</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>?act=listLienHe">Liên Hệ</a></li>
                        <li class="breadcrumb-item active">Chi Tiết</li>
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
.contact-detail-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    margin-bottom: 20px;
    border: 1px solid #e3e6f0;
}

.contact-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 20px 25px;
    border-radius: 15px 15px 0 0;
}

.contact-body {
    padding: 25px;
}

.info-item {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
    padding: 12px 15px;
    background: #f8f9fa;
    border-radius: 10px;
    border-left: 3px solid #667eea;
}

.info-icon {
    width: 35px;
    height: 35px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    margin-right: 12px;
    font-size: 14px;
}

.info-content h6 {
    margin: 0 0 3px 0;
    color: #495057;
    font-weight: 600;
    font-size: 13px;
}

.info-content p {
    margin: 0;
    color: #6c757d;
    font-size: 14px;
}

.message-content {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
    border-left: 4px solid #667eea;
    margin-top: 15px;
}

.reply-section {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    padding: 25px;
    margin-bottom: 20px;
    border: 1px solid #e3e6f0;
}

.reply-form textarea {
    border: 2px solid #e9ecef;
    border-radius: 10px;
    padding: 12px;
    transition: border-color 0.3s ease;
    resize: vertical;
    min-height: 120px;
}

.reply-form textarea:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.status-update-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    padding: 25px;
}

.action-buttons {
    margin-bottom: 15px;
}

.action-buttons .btn {
    margin-right: 8px;
    margin-bottom: 8px;
    border-radius: 8px;
    padding: 8px 16px;
    font-size: 14px;
}

.status-badge {
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.status-pending {
    background: #fee2e2;
    color: #dc2626;
}

.status-read {
    background: #dbeafe;
    color: #2563eb;
}

.status-replied {
    background: #d1fae5;
    color: #059669;
}

.status-closed {
    background: #f3e8ff;
    color: #7c3aed;
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

.reply-history {
    background: #e8f5e8;
    border: 1px solid #c3e6c3;
    border-radius: 10px;
    padding: 15px;
    margin-top: 15px;
}

.timeline {
    position: relative;
    padding-left: 25px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 12px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}

.timeline-item {
    position: relative;
    margin-bottom: 15px;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: -19px;
    top: 0;
    width: 6px;
    height: 6px;
    background: #667eea;
    border-radius: 50%;
}

.timeline-content {
    background: white;
    padding: 12px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.timeline-meta {
    font-size: 11px;
    color: #6c757d;
    margin-bottom: 5px;
}

@media (max-width: 768px) {
    .contact-body,
    .reply-section,
    .status-update-card {
        padding: 15px;
    }
    
    .action-buttons .btn {
        width: 100%;
        margin-right: 0;
        margin-bottom: 8px;
    }
    
    .info-item {
        flex-direction: column;
        text-align: center;
        padding: 10px;
    }
    
    .info-icon {
        margin-right: 0;
        margin-bottom: 8px;
    }

    .contact-header {
        padding: 15px 20px;
    }
}
</style>

            <!-- Contact Details -->
            
            <!-- Contact Details -->
            <div class="contact-detail-card">
                <div class="contact-header">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3 class="mb-2"><?= htmlspecialchars($lienhe['subject']) ?></h3>
                            <p class="mb-0 opacity-90">
                                <i class="fas fa-clock mr-2"></i>
                                Nhận lúc: <?= date('d/m/Y H:i:s', strtotime($lienhe['created_at'])) ?>
                            </p>
                        </div>
                        <div class="col-md-4 text-md-right">
                            <span class="status-badge status-<?= $lienhe['status'] ?> mr-2">
                                <?= ucfirst($lienhe['status']) ?>
                            </span>
                            <span class="priority-badge priority-<?= $lienhe['priority'] ?>">
                                <?= ucfirst($lienhe['priority']) ?>
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="contact-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="info-content">
                                    <h6>Họ và tên</h6>
                                    <p><?= htmlspecialchars($lienhe['name']) ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="info-content">
                                    <h6>Email</h6>
                                    <p><a href="mailto:<?= $lienhe['email'] ?>"><?= htmlspecialchars($lienhe['email']) ?></a></p>
                                </div>
                            </div>
                        </div>
                        
                        <?php if ($lienhe['phone']): ?>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <div class="info-content">
                                        <h6>Số điện thoại</h6>
                                        <p><a href="tel:<?= $lienhe['phone'] ?>"><?= htmlspecialchars($lienhe['phone']) ?></a></p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($lienhe['ip_address']): ?>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-globe"></i>
                                    </div>
                                    <div class="info-content">
                                        <h6>Địa chỉ IP</h6>
                                        <p><?= htmlspecialchars($lienhe['ip_address']) ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="message-content">
                        <h5 class="mb-3">
                            <i class="fas fa-comment-alt mr-2"></i>
                            Nội dung liên hệ
                        </h5>
                        <p class="mb-0"><?= nl2br(htmlspecialchars($lienhe['message'])) ?></p>
                    </div>
                    
                    <?php if ($lienhe['reply_message']): ?>
                        <div class="reply-history">
                            <h5 class="mb-3">
                                <i class="fas fa-reply mr-2"></i>
                                Phản hồi đã gửi
                            </h5>
                            <div class="timeline">
                                <div class="timeline-item">
                                    <div class="timeline-content">
                                        <div class="timeline-meta">
                                            <i class="fas fa-user-tie mr-1"></i>
                                            Admin phản hồi lúc <?= date('d/m/Y H:i:s', strtotime($lienhe['replied_at'])) ?>
                                        </div>
                                        <p class="mb-0"><?= nl2br(htmlspecialchars($lienhe['reply_message'])) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="row">
                <div class="col-md-4">
                    <div class="action-buttons">
                        <a href="index.php?ctl=lienhe" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-2"></i>Quay lại danh sách
                        </a>
                        
                        <a href="mailto:<?= $lienhe['email'] ?>?subject=Re: <?= urlencode($lienhe['subject']) ?>" 
                           class="btn btn-info">
                            <i class="fas fa-envelope mr-2"></i>Gửi Email
                        </a>
                        
                        <?php if ($lienhe['phone']): ?>
                            <a href="tel:<?= $lienhe['phone'] ?>" class="btn btn-success">
                                <i class="fas fa-phone mr-2"></i>Gọi điện
                            </a>
                        <?php endif; ?>
                        
                        <button type="button" class="btn btn-warning" 
                                onclick="openStatusModal(<?= $lienhe['id'] ?>, '<?= $lienhe['status'] ?>', '<?= $lienhe['priority'] ?>')">
                            <i class="fas fa-edit mr-2"></i>Cập nhật trạng thái
                        </button>
                        
                        <a href="index.php?ctl=lienhe&act=delete&id=<?= $lienhe['id'] ?>" 
                           class="btn btn-danger" 
                           onclick="return confirm('Bạn có chắc chắn muốn xóa liên hệ này?')">
                            <i class="fas fa-trash mr-2"></i>Xóa
                        </a>
                    </div>
                </div>
                
                <!-- Quick Reply Form -->
                <?php if ($lienhe['status'] !== 'replied' && $lienhe['status'] !== 'closed'): ?>
                    <div class="col-md-8">
                        <div class="reply-section">
                            <h5 class="mb-3">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Phản hồi nhanh
                            </h5>
                            
                            <form method="POST" action="index.php?ctl=lienhe&act=reply" class="reply-form">
                                <input type="hidden" name="id" value="<?= $lienhe['id'] ?>">
                                <input type="hidden" name="redirect" value="<?= $_SERVER['REQUEST_URI'] ?>">
                                
                                <div class="form-group">
                                    <label for="reply_message">Nội dung phản hồi *</label>
                                    <textarea name="reply_message" id="reply_message" class="form-control" rows="6" required
                                              placeholder="Nhập nội dung phản hồi sẽ được gửi qua email cho khách hàng..."></textarea>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Cập nhật trạng thái</label>
                                            <select name="new_status" class="form-control">
                                                <option value="replied">Đã phản hồi</option>
                                                <option value="closed">Đóng liên hệ</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <div>
                                                <button type="submit" class="btn btn-primary btn-lg">
                                                    <i class="fas fa-paper-plane mr-2"></i>
                                                    Gửi phản hồi
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
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
            
        </div>
    </section>
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
function openStatusModal(id, currentStatus, currentPriority) {
    document.getElementById('statusContactId').value = id;
    document.getElementById('statusSelect').value = currentStatus;
    document.getElementById('prioritySelect').value = currentPriority;
    $('#statusModal').modal('show');
}

// Auto-resize textarea
document.getElementById('reply_message').addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = this.scrollHeight + 'px';
});

// Copy email to clipboard
function copyEmail(email) {
    navigator.clipboard.writeText(email).then(function() {
        // Show toast notification
        const toast = document.createElement('div');
        toast.className = 'alert alert-success position-fixed';
        toast.style.top = '20px';
        toast.style.right = '20px';
        toast.style.zIndex = '9999';
        toast.innerHTML = '<i class="fas fa-check mr-2"></i>Đã sao chép email!';
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.remove();
        }, 3000);
    });
}
</script>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
