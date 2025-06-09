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
                    <h1>Chi tiết bình luận</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN . '?act=binh-luan' ?>">Quản lý bình luận</a></li>
                        <li class="breadcrumb-item active">Chi tiết bình luận</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Thông tin bình luận -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Thông tin bình luận</h3>
                            <div class="card-tools">
                                <a href="<?= BASE_URL_ADMIN . '?act=binh-luan' ?>" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-arrow-left"></i> Quay lại
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>ID:</strong> <?= $binhLuan['id'] ?>
                                </div>
                                <div class="col-md-6">
                                    <strong>Ngày đăng:</strong> <?= date('d/m/Y H:i:s', strtotime($binhLuan['ngay_dang'])) ?>
                                </div>
                            </div>
                            <hr>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Người dùng:</strong> <?= htmlspecialchars($binhLuan['ho_ten'] ?? 'Khách') ?>
                                </div>
                                <div class="col-md-6">
                                    <strong>Email:</strong> <?= htmlspecialchars($binhLuan['email'] ?? 'Không có') ?>
                                </div>
                            </div>
                            
                            <?php if (!empty($binhLuan['so_dien_thoai'])): ?>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <strong>Số điện thoại:</strong> <?= htmlspecialchars($binhLuan['so_dien_thoai']) ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <hr>
                            
                            <div class="row">
                                <div class="col-12">
                                    <strong>Sản phẩm:</strong> 
                                    <a href="<?= BASE_URL_ADMIN . '?act=chi-tiet-san-pham&id=' . $binhLuan['san_pham_id'] ?>" target="_blank">
                                        <?= htmlspecialchars($binhLuan['ten_san_pham'] ?? 'Sản phẩm đã xóa') ?>
                                    </a>
                                </div>
                            </div>
                            
                            <hr>
                            
                            <div class="row">
                                <div class="col-12">
                                    <strong>Trạng thái:</strong>
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
                                </div>
                            </div>
                            
                            <hr>
                            
                            <div class="row">
                                <div class="col-12">
                                    <strong>Nội dung bình luận:</strong>
                                    <div class="mt-2 p-3 bg-light rounded">
                                        <?= nl2br(htmlspecialchars($binhLuan['noi_dung'])) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Các reply -->
                    <?php if (!empty($replies)): ?>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Phản hồi (<?= count($replies) ?>)</h3>
                            </div>
                            <div class="card-body">
                                <?php foreach ($replies as $reply): ?>
                                    <div class="media mb-3">
                                        <div class="media-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <strong><?= htmlspecialchars($reply['ho_ten'] ?? 'Admin') ?></strong>
                                                    <?php if ($reply['is_admin_reply'] ?? false): ?>
                                                        <span class="badge badge-primary">Admin</span>
                                                    <?php endif; ?>
                                                </div>
                                                <small class="text-muted"><?= date('d/m/Y H:i', strtotime($reply['ngay_dang'])) ?></small>
                                            </div>
                                            <div class="mt-2">
                                                <?= nl2br(htmlspecialchars($reply['noi_dung'])) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Form trả lời -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Trả lời bình luận</h3>
                        </div>
                        <div class="card-body">
                            <form id="reply-form">
                                <input type="hidden" name="parent_id" value="<?= $binhLuan['id'] ?>">
                                <div class="form-group">
                                    <label for="noi_dung">Nội dung phản hồi</label>
                                    <textarea name="noi_dung" id="noi_dung" class="form-control" rows="4" 
                                              placeholder="Nhập nội dung phản hồi..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-reply"></i> Gửi phản hồi
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Thao tác -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Thao tác</h3>
                        </div>
                        <div class="card-body">
                            <div class="btn-group-vertical w-100">
                                <?php if ($binhLuan['trang_thai'] == 0): ?>
                                    <button type="button" class="btn btn-success mb-2" onclick="updateStatus(1)">
                                        <i class="fas fa-check"></i> Duyệt bình luận
                                    </button>
                                    <button type="button" class="btn btn-warning mb-2" onclick="updateStatus(2)">
                                        <i class="fas fa-eye-slash"></i> Ẩn bình luận
                                    </button>
                                <?php elseif ($binhLuan['trang_thai'] == 1): ?>
                                    <button type="button" class="btn btn-warning mb-2" onclick="updateStatus(2)">
                                        <i class="fas fa-eye-slash"></i> Ẩn bình luận
                                    </button>
                                <?php elseif ($binhLuan['trang_thai'] == 2): ?>
                                    <button type="button" class="btn btn-success mb-2" onclick="updateStatus(1)">
                                        <i class="fas fa-eye"></i> Hiện bình luận
                                    </button>
                                <?php endif; ?>
                                
                                <button type="button" class="btn btn-danger mb-2" onclick="deleteComment()">
                                    <i class="fas fa-trash"></i> Xóa bình luận
                                </button>
                                
                                <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id=' . $binhLuan['san_pham_id'] ?>" 
                                   target="_blank" class="btn btn-info mb-2">
                                    <i class="fas fa-external-link-alt"></i> Xem sản phẩm
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Thông tin sản phẩm -->
                    <?php if (!empty($binhLuan['hinh_anh'])): ?>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Sản phẩm</h3>
                            </div>
                            <div class="card-body text-center">
                                <img src="<?= BASE_URL . $binhLuan['hinh_anh'] ?>" 
                                     alt="<?= htmlspecialchars($binhLuan['ten_san_pham']) ?>" 
                                     class="img-fluid rounded" style="max-height: 200px;">
                                <h5 class="mt-2"><?= htmlspecialchars($binhLuan['ten_san_pham']) ?></h5>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Thống kê người dùng -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Thông tin người dùng</h3>
                        </div>
                        <div class="card-body">
                            <p><strong>Tổng bình luận:</strong> <?= $userStats['total_comments'] ?? 0 ?></p>
                            <p><strong>Bình luận được duyệt:</strong> <?= $userStats['approved_comments'] ?? 0 ?></p>
                            <p><strong>Bình luận bị ẩn:</strong> <?= $userStats['hidden_comments'] ?? 0 ?></p>
                            <p><strong>Ngày tham gia:</strong> <?= date('d/m/Y', strtotime($userStats['created_at'] ?? $binhLuan['ngay_dang'])) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
// Cập nhật trạng thái bình luận
function updateStatus(status) {
    let message = '';
    switch (status) {
        case 1:
            message = 'Bạn có chắc chắn muốn duyệt bình luận này?';
            break;
        case 2:
            message = 'Bạn có chắc chắn muốn ẩn bình luận này?';
            break;
    }
    
    if (confirm(message)) {
        fetch('<?= BASE_URL_ADMIN ?>?act=cap-nhat-trang-thai-binh-luan', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=<?= $binhLuan['id'] ?>&trang_thai=${status}`
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
function deleteComment() {
    if (confirm('Bạn có chắc chắn muốn xóa bình luận này? Thao tác này không thể hoàn tác.')) {
        fetch('<?= BASE_URL_ADMIN ?>?act=xoa-binh-luan', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=<?= $binhLuan['id'] ?>`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = '<?= BASE_URL_ADMIN ?>?act=binh-luan';
            } else {
                alert('Có lỗi xảy ra: ' + data.message);
            }
        })
        .catch(error => {
            alert('Có lỗi xảy ra khi xóa bình luận');
        });
    }
}

// Xử lý form trả lời
document.getElementById('reply-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('<?= BASE_URL_ADMIN ?>?act=tra-loi-binh-luan', {
        method: 'POST',
        body: formData
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
        alert('Có lỗi xảy ra khi gửi phản hồi');
    });
});
</script>

<?php require_once "./views/layout/footer.php" ?>