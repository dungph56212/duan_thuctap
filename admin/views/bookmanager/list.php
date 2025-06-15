<?php include './views/layout/header.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Quản lý sách</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Danh sách sách</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Danh sách sách</h3>
                            <div class="card-tools">
                                <a href="<?= BASE_URL_ADMIN . '?act=form-them-sach' ?>" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Thêm sách mới
                                </a>
                                <a href="<?= BASE_URL_ADMIN . '?act=them-sach-hang-loat' ?>" class="btn btn-info">
                                    <i class="fas fa-upload"></i> Thêm hàng loạt
                                </a>
                            </div>
                        </div>

                        <?php if (isset($_SESSION['success'])): ?>
                            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                                <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                                <button type="button" class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                                <button type="button" class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>

                        <div class="card-body">
                            <!-- Filter -->
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <select class="form-control" id="categoryFilter">
                                        <option value="">Tất cả danh mục</option>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['ten_danh_muc']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control" id="statusFilter">
                                        <option value="">Tất cả trạng thái</option>
                                        <option value="1">Hoạt động</option>
                                        <option value="2">Không hoạt động</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="searchBox" placeholder="Tìm kiếm tên sách...">
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-primary" onclick="filterBooks()">
                                        <i class="fas fa-search"></i> Lọc
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="booksTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Hình ảnh</th>
                                            <th>Tên sách</th>
                                            <th>Danh mục</th>
                                            <th>Giá gốc</th>
                                            <th>Giá KM</th>
                                            <th>Số lượng</th>
                                            <th>Trạng thái</th>
                                            <th>Ngày tạo</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($books as $book): ?>
                                            <tr>
                                                <td><?= $book['id'] ?></td>
                                                <td>
                                                    <?php if ($book['hinh_anh']): ?>
                                                        <img src="<?= BASE_URL . $book['hinh_anh'] ?>" 
                                                             alt="<?= htmlspecialchars($book['ten_san_pham']) ?>" 
                                                             style="width: 50px; height: 60px; object-fit: cover;">
                                                    <?php else: ?>
                                                        <div class="bg-light d-flex align-items-center justify-content-center" 
                                                             style="width: 50px; height: 60px;">
                                                            <i class="fas fa-book text-muted"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <strong><?= htmlspecialchars($book['ten_san_pham']) ?></strong>
                                                    <?php if (strlen($book['mo_ta']) > 0): ?>
                                                        <br><small class="text-muted">
                                                            <?= htmlspecialchars(substr($book['mo_ta'], 0, 80)) ?>...
                                                        </small>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= htmlspecialchars($book['ten_danh_muc'] ?? 'Chưa phân loại') ?></td>
                                                <td><?= number_format($book['gia_san_pham']) ?>đ</td>
                                                <td>
                                                    <?php if ($book['gia_khuyen_mai']): ?>
                                                        <span class="text-danger">
                                                            <?= number_format($book['gia_khuyen_mai']) ?>đ
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span class="badge badge-<?= $book['so_luong'] > 10 ? 'success' : ($book['so_luong'] > 0 ? 'warning' : 'danger') ?>">
                                                        <?= $book['so_luong'] ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php if ($book['trang_thai'] == 1): ?>
                                                        <span class="badge badge-success">Hoạt động</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-danger">Không hoạt động</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= date('d/m/Y', strtotime($book['ngay_nhap'])) ?></td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="<?= BASE_URL_ADMIN . '?act=form-sua-sach&id=' . $book['id'] ?>" 
                                                           class="btn btn-sm btn-warning" title="Sửa">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="<?= BASE_URL_ADMIN . '?act=xoa-sach&id=' . $book['id'] ?>" 
                                                           class="btn btn-sm btn-danger" title="Xóa"
                                                           onclick="return confirm('Bạn có chắc chắn muốn xóa sách này?')">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
.table th, .table td {
    vertical-align: middle;
}
.btn-group .btn {
    margin-right: 2px;
}
</style>

<script>
function filterBooks() {
    const category = document.getElementById('categoryFilter').value;
    const status = document.getElementById('statusFilter').value;
    const search = document.getElementById('searchBox').value.toLowerCase();
    
    const table = document.getElementById('booksTable');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    
    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const categoryCell = row.cells[3].textContent;
        const statusCell = row.cells[7].textContent;
        const nameCell = row.cells[2].textContent.toLowerCase();
        
        let showRow = true;
        
        if (category && !categoryCell.includes(category)) {
            showRow = false;
        }
        
        if (status && !statusCell.includes(status == '1' ? 'Hoạt động' : 'Không hoạt động')) {
            showRow = false;
        }
        
        if (search && !nameCell.includes(search)) {
            showRow = false;
        }
        
        row.style.display = showRow ? '' : 'none';
    }
}

// Lọc real-time khi gõ
document.getElementById('searchBox').addEventListener('keyup', filterBooks);
document.getElementById('categoryFilter').addEventListener('change', filterBooks);
document.getElementById('statusFilter').addEventListener('change', filterBooks);
</script>

<?php include './views/layout/footer.php'; ?>
