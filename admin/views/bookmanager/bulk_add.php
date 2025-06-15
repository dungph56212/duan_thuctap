<?php include './views/layout/header.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Thêm sách hàng loạt</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN . '?act=danh-sach-sach' ?>">Danh sách sách</a></li>
                        <li class="breadcrumb-item active">Thêm hàng loạt</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Thêm sách mẫu</h3>
                        </div>

                        <div class="card-body">
                            <div class="alert alert-info">
                                <h5><i class="icon fas fa-info"></i> Thông tin!</h5>
                                Chức năng này sẽ thêm một số sách mẫu vào hệ thống để bạn có thể test chatbot và các chức năng khác.
                                Dữ liệu mẫu bao gồm các thể loại sách phổ biến như văn học, kinh tế, công nghệ, v.v.
                            </div>

                            <form action="<?= BASE_URL_ADMIN . '?act=post-them-sach-hang-loat' ?>" method="POST">
                                <div class="form-group">
                                    <label>Các sách mẫu sẽ được thêm vào:</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul class="list-unstyled">
                                                <li><i class="fas fa-check text-success"></i> Văn học Việt Nam</li>
                                                <li><i class="fas fa-check text-success"></i> Văn học nước ngoài</li>
                                                <li><i class="fas fa-check text-success"></i> Kinh tế - Quản lý</li>
                                                <li><i class="fas fa-check text-success"></i> Công nghệ thông tin</li>
                                                <li><i class="fas fa-check text-success"></i> Khoa học tự nhiên</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul class="list-unstyled">
                                                <li><i class="fas fa-check text-success"></i> Lịch sử - Địa lý</li>
                                                <li><i class="fas fa-check text-success"></i> Tâm lý - Kỹ năng sống</li>
                                                <li><i class="fas fa-check text-success"></i> Thiếu nhi</li>
                                                <li><i class="fas fa-check text-success"></i> Sách giáo khoa</li>
                                                <li><i class="fas fa-check text-success"></i> Và nhiều thể loại khác...</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sample_count">Số lượng sách mỗi danh mục:</label>
                                            <select class="form-control" name="sample_count" id="sample_count">
                                                <option value="5">5 sách/danh mục (tổng ~40-50 sách)</option>
                                                <option value="10" selected>10 sách/danh mục (tổng ~80-100 sách)</option>
                                                <option value="15">15 sách/danh mục (tổng ~120-150 sách)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="with_images">Bao gồm hình ảnh:</label>
                                            <select class="form-control" name="with_images" id="with_images">
                                                <option value="1" selected>Có hình ảnh mẫu</option>
                                                <option value="0">Không có hình ảnh</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="confirm_add" name="confirm_add" required>
                                        <label class="custom-control-label" for="confirm_add">
                                            Tôi hiểu rằng việc này sẽ thêm nhiều sách mẫu vào database và có thể ghi đè dữ liệu hiện có
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-plus-circle"></i> Thêm sách mẫu
                                </button>
                                <a href="<?= BASE_URL_ADMIN . '?act=danh-sach-sach' ?>" class="btn btn-secondary btn-lg ml-2">
                                    <i class="fas fa-times"></i> Hủy
                                </a>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Import từ file CSV</h3>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-warning">
                                <small><i class="fas fa-exclamation-triangle"></i> Tính năng này đang phát triển</small>
                            </div>
                            
                            <form action="#" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="csv_file">File CSV:</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="csv_file" name="csv_file" accept=".csv" disabled>
                                        <label class="custom-file-label" for="csv_file">Chọn file CSV...</label>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-info" disabled>
                                    <i class="fas fa-upload"></i> Import CSV
                                </button>
                            </form>

                            <hr>

                            <div class="text-center">
                                <a href="#" class="btn btn-outline-info btn-sm" disabled>
                                    <i class="fas fa-download"></i> Tải mẫu CSV
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Lưu ý quan trọng</h3>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li><i class="fas fa-info-circle text-info"></i> Dữ liệu mẫu giúp test chatbot</li>
                                <li><i class="fas fa-database text-primary"></i> Sẽ tạo danh mục nếu chưa có</li>
                                <li><i class="fas fa-images text-success"></i> Hình ảnh từ placeholder</li>
                                <li><i class="fas fa-clock text-warning"></i> Quá trình có thể mất 1-2 phút</li>
                                <li><i class="fas fa-trash text-danger"></i> Có thể xóa sau nếu không cần</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
// Custom file input label
document.getElementById('csv_file').addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name || 'Chọn file CSV...';
    document.querySelector('.custom-file-label').textContent = fileName;
});

// Loading state
document.querySelector('form').addEventListener('submit', function(e) {
    const btn = this.querySelector('button[type="submit"]');
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang thêm...';
    btn.disabled = true;
});
</script>

<?php include './views/layout/footer.php'; ?>
