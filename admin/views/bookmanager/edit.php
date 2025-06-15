<?php include './views/layout/header.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Sửa thông tin sách</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN . '?act=danh-sach-sach' ?>">Danh sách sách</a></li>
                        <li class="breadcrumb-item active">Sửa sách</li>
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
                            <h3 class="card-title">Thông tin sách: <?= htmlspecialchars($book['ten_san_pham']) ?></h3>
                            <div class="card-tools">
                                <a href="<?= BASE_URL_ADMIN . '?act=danh-sach-sach' ?>" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Quay lại
                                </a>
                            </div>
                        </div>

                        <form action="<?= BASE_URL_ADMIN . '?act=sua-sach' ?>" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= $book['id'] ?>">
                            
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="ten_san_pham">Tên sách <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="ten_san_pham" name="ten_san_pham" 
                                                   value="<?= htmlspecialchars($book['ten_san_pham']) ?>" 
                                                   placeholder="Nhập tên sách..." required>
                                        </div>

                                        <div class="form-group">
                                            <label for="mo_ta">Mô tả</label>
                                            <textarea class="form-control" id="mo_ta" name="mo_ta" rows="4" 
                                                      placeholder="Nhập mô tả sách..."><?= htmlspecialchars($book['mo_ta']) ?></textarea>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="gia_san_pham">Giá gốc <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" id="gia_san_pham" name="gia_san_pham" 
                                                           value="<?= $book['gia_san_pham'] ?>"
                                                           min="0" step="1000" placeholder="0" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="gia_khuyen_mai">Giá khuyến mãi</label>
                                                    <input type="number" class="form-control" id="gia_khuyen_mai" name="gia_khuyen_mai" 
                                                           value="<?= $book['gia_khuyen_mai'] ?>"
                                                           min="0" step="1000" placeholder="0 (để trống nếu không có KM)">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="so_luong">Số lượng <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" id="so_luong" name="so_luong" 
                                                           value="<?= $book['so_luong'] ?>"
                                                           min="0" placeholder="0" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="danh_muc_id">Danh mục <span class="text-danger">*</span></label>
                                                    <select class="form-control" id="danh_muc_id" name="danh_muc_id" required>
                                                        <option value="">-- Chọn danh mục --</option>
                                                        <?php foreach ($categories as $category): ?>
                                                            <option value="<?= $category['id'] ?>" 
                                                                    <?= $category['id'] == $book['danh_muc_id'] ? 'selected' : '' ?>>
                                                                <?= htmlspecialchars($category['ten_danh_muc']) ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="hinh_anh">Hình ảnh</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="hinh_anh" name="hinh_anh" accept="image/*">
                                                <label class="custom-file-label" for="hinh_anh">Chọn hình ảnh mới...</label>
                                            </div>
                                            <input type="hidden" name="hinh_anh_cu" value="<?= $book['hinh_anh'] ?>">
                                            
                                            <div class="mt-2">
                                                <!-- Current image -->
                                                <?php if ($book['hinh_anh']): ?>
                                                    <div id="currentImage" class="text-center">
                                                        <p><small class="text-muted">Hình ảnh hiện tại:</small></p>
                                                        <img src="<?= BASE_URL . $book['hinh_anh'] ?>" 
                                                             alt="<?= htmlspecialchars($book['ten_san_pham']) ?>" 
                                                             style="max-width: 200px; max-height: 250px; object-fit: cover;">
                                                    </div>
                                                <?php endif; ?>
                                                
                                                <!-- New image preview -->
                                                <div id="imagePreview" class="text-center" style="display: none;">
                                                    <p><small class="text-success">Hình ảnh mới:</small></p>
                                                    <img id="previewImg" src="" alt="Preview" style="max-width: 200px; max-height: 250px; object-fit: cover;">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="trang_thai">Trạng thái</label>
                                            <select class="form-control" id="trang_thai" name="trang_thai">
                                                <option value="1" <?= $book['trang_thai'] == 1 ? 'selected' : '' ?>>Hoạt động</option>
                                                <option value="2" <?= $book['trang_thai'] == 2 ? 'selected' : '' ?>>Không hoạt động</option>
                                            </select>
                                        </div>

                                        <!-- Book info -->
                                        <div class="bg-light p-3 rounded">
                                            <h6><i class="fas fa-info-circle text-info"></i> Thông tin thêm</h6>
                                            <small class="text-muted">
                                                <strong>ID:</strong> <?= $book['id'] ?><br>
                                                <strong>Ngày tạo:</strong> <?= date('d/m/Y H:i', strtotime($book['ngay_nhap'])) ?><br>
                                                <strong>Lượt xem:</strong> <?= $book['luot_xem'] ?? 0 ?><br>
                                                <?php if ($book['ngay_sua']): ?>
                                                    <strong>Sửa lần cuối:</strong> <?= date('d/m/Y H:i', strtotime($book['ngay_sua'])) ?>
                                                <?php endif; ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Cập nhật sách
                                </button>
                                <button type="reset" class="btn btn-secondary ml-2">
                                    <i class="fas fa-undo"></i> Đặt lại
                                </button>
                                <a href="<?= BASE_URL_ADMIN . '?act=danh-sach-sach' ?>" class="btn btn-default ml-2">
                                    <i class="fas fa-times"></i> Hủy
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
// Preview image when selected
document.getElementById('hinh_anh').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    const currentImage = document.getElementById('currentImage');
    const label = document.querySelector('.custom-file-label');
    
    if (file) {
        label.textContent = file.name;
        
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
            if (currentImage) {
                currentImage.style.display = 'none';
            }
        };
        reader.readAsDataURL(file);
    } else {
        label.textContent = 'Chọn hình ảnh mới...';
        preview.style.display = 'none';
        if (currentImage) {
            currentImage.style.display = 'block';
        }
    }
});

// Validate promotion price
document.getElementById('gia_khuyen_mai').addEventListener('input', function() {
    const originalPrice = parseInt(document.getElementById('gia_san_pham').value) || 0;
    const promoPrice = parseInt(this.value) || 0;
    
    if (promoPrice > 0 && promoPrice >= originalPrice) {
        this.setCustomValidity('Giá khuyến mãi phải nhỏ hơn giá gốc');
    } else {
        this.setCustomValidity('');
    }
});

document.getElementById('gia_san_pham').addEventListener('input', function() {
    const promoPrice = parseInt(document.getElementById('gia_khuyen_mai').value) || 0;
    const originalPrice = parseInt(this.value) || 0;
    
    if (promoPrice > 0 && promoPrice >= originalPrice) {
        document.getElementById('gia_khuyen_mai').setCustomValidity('Giá khuyến mãi phải nhỏ hơn giá gốc');
    } else {
        document.getElementById('gia_khuyen_mai').setCustomValidity('');
    }
});
</script>

<?php include './views/layout/footer.php'; ?>
