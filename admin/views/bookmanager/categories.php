<?php include './views/layout/header.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Quản lý danh mục sách</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN . '?act=quan-ly-sach' ?>">Quản lý sách</a></li>
                        <li class="breadcrumb-item active">Danh mục</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Thêm danh mục mới</h3>
                        </div>
                        <form action="<?= BASE_URL_ADMIN . '?act=post-danh-muc-sach' ?>" method="POST">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="ten_danh_muc">Tên danh mục <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="ten_danh_muc" name="ten_danh_muc" 
                                           placeholder="VD: Văn học, Kinh tế, Công nghệ..." required>
                                </div>

                                <div class="form-group">
                                    <label for="mo_ta">Mô tả</label>
                                    <textarea class="form-control" id="mo_ta" name="mo_ta" rows="3" 
                                              placeholder="Mô tả ngắn về danh mục..."></textarea>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Thêm danh mục
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Thêm danh mục mẫu</h3>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Thêm nhanh các danh mục phổ biến:</p>
                            <div class="d-grid gap-2">
                                <button class="btn btn-outline-primary btn-sm mb-2" onclick="addSampleCategories()">
                                    <i class="fas fa-magic"></i> Thêm danh mục mẫu
                                </button>
                            </div>
                            <small class="text-muted">
                                Sẽ thêm: Văn học, Kinh tế, Công nghệ, Khoa học, Lịch sử, Tâm lý, Thiếu nhi, Giáo dục
                            </small>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Danh sách danh mục hiện có</h3>
                            <div class="card-tools">
                                <span class="badge badge-info">Tổng: <?= count($categories) ?> danh mục</span>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <?php if (empty($categories)): ?>
                                <div class="text-center p-4">
                                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Chưa có danh mục nào. Hãy thêm danh mục đầu tiên!</p>
                                </div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Tên danh mục</th>
                                                <th>Mô tả</th>
                                                <th>Số sách</th>
                                                <th>Trạng thái</th>
                                                <th>Ngày tạo</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($categories as $category): ?>
                                                <tr>
                                                    <td><?= $category['id'] ?></td>
                                                    <td>
                                                        <strong><?= htmlspecialchars($category['ten_danh_muc']) ?></strong>
                                                    </td>
                                                    <td>
                                                        <?php if ($category['mo_ta']): ?>
                                                            <?= htmlspecialchars(substr($category['mo_ta'], 0, 50)) ?>
                                                            <?= strlen($category['mo_ta']) > 50 ? '...' : '' ?>
                                                        <?php else: ?>
                                                            <span class="text-muted">Chưa có mô tả</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-primary">
                                                            <?= $category['so_san_pham'] ?? 0 ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <?php if ($category['trang_thai'] == 1): ?>
                                                            <span class="badge badge-success">Hoạt động</span>
                                                        <?php else: ?>
                                                            <span class="badge badge-secondary">Không hoạt động</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?= date('d/m/Y', strtotime($category['ngay_tao'])) ?>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <button class="btn btn-sm btn-info" 
                                                                    onclick="editCategory(<?= $category['id'] ?>, '<?= addslashes($category['ten_danh_muc']) ?>', '<?= addslashes($category['mo_ta']) ?>')"
                                                                    title="Sửa">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <a href="<?= BASE_URL_ADMIN . '?act=danh-sach-sach&danh_muc=' . $category['id'] ?>" 
                                                               class="btn btn-sm btn-success" title="Xem sách">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <?php if (($category['so_san_pham'] ?? 0) == 0): ?>
                                                                <button class="btn btn-sm btn-danger" 
                                                                        onclick="deleteCategory(<?= $category['id'] ?>)"
                                                                        title="Xóa">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sửa danh mục</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="editCategoryForm" action="<?= BASE_URL_ADMIN . '?act=post-danh-muc-sach' ?>" method="POST">
                <input type="hidden" id="edit_category_id" name="category_id">
                <input type="hidden" name="action" value="edit">
                
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_ten_danh_muc">Tên danh mục <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_ten_danh_muc" name="ten_danh_muc" required>
                    </div>

                    <div class="form-group">
                        <label for="edit_mo_ta">Mô tả</label>
                        <textarea class="form-control" id="edit_mo_ta" name="mo_ta" rows="3"></textarea>
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
function editCategory(id, name, description) {
    document.getElementById('edit_category_id').value = id;
    document.getElementById('edit_ten_danh_muc').value = name;
    document.getElementById('edit_mo_ta').value = description;
    $('#editCategoryModal').modal('show');
}

function deleteCategory(id) {
    if (confirm('Bạn có chắc chắn muốn xóa danh mục này? Thao tác này không thể hoàn tác!')) {
        window.location.href = '<?= BASE_URL_ADMIN ?>?act=post-danh-muc-sach&action=delete&category_id=' + id;
    }
}

function addSampleCategories() {
    if (confirm('Bạn có muốn thêm các danh mục mẫu? Điều này sẽ thêm khoảng 8-10 danh mục phổ biến.')) {
        // Create a form to submit
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= BASE_URL_ADMIN ?>?act=post-danh-muc-sach';
        
        const actionInput = document.createElement('input');
        actionInput.type = 'hidden';
        actionInput.name = 'action';
        actionInput.value = 'add_samples';
        
        form.appendChild(actionInput);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>

<?php include './views/layout/footer.php'; ?>
