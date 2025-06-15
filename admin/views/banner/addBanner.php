<?php require './views/layout/header.php' ?>
<?php require './views/layout/navbar.php' ?>
<?php require './views/layout/sidebar.php' ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

<div class="container-fluid px-4">
    <!-- Custom CSS cho form thêm banner -->
    <style>
    .banner-form-container {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .banner-form-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 10px 10px 0 0;
        margin: -2rem -2rem 2rem -2rem;
    }

    .banner-form-header h3 {
        margin: 0;
        font-weight: 600;
    }

    .form-section {
        background: white;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        border-left: 4px solid #667eea;
    }

    .form-section h5 {
        color: #495057;
        font-weight: 600;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
    }

    .form-section h5 i {
        margin-right: 0.5rem;
        color: #667eea;
    }

    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .form-select {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
    }

    .text-danger {
        color: #e74c3c !important;
    }

    .preview-container {
        border: 2px dashed #ddd;
        border-radius: 8px;
        padding: 1rem;
        text-align: center;
        background: #f8f9fa;
        transition: all 0.3s ease;
    }

    .preview-container:hover {
        border-color: #667eea;
        background: #f0f3ff;
    }

    .preview-image {
        max-width: 100%;
        max-height: 200px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 8px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-secondary {
        background: #6c757d;
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background: #5a6268;
        transform: translateY(-1px);
    }

    .alert {
        border: none;
        border-radius: 10px;
        border-left: 4px solid #e74c3c;
    }

    .alert-danger {
        background: linear-gradient(135deg, #fff5f5 0%, #fed7d7 100%);
        color: #c53030;
    }

    .form-text {
        font-size: 0.85rem;
        color: #6c757d;
        margin-top: 0.25rem;
    }

    .form-check-input:checked {
        background-color: #667eea;
        border-color: #667eea;
    }

    .form-check-label {
        font-weight: 500;
        color: #495057;
    }

    .card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
    }

    .card-header {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        border: none;
        font-weight: 600;
    }

    .settings-section {
        background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
        border-radius: 10px;
        padding: 1.5rem;
        border-left: 4px solid #f5576c;
    }

    .settings-section .form-label {
        color: #8b4513;
    }

    .input-group-text {
        background: #667eea;
        color: white;
        border: none;
        font-weight: 600;
    }

    .popup-settings {
        display: block;
        transition: all 0.3s ease;
    }

    .popup-settings.hidden {
        display: none;
    }

    /* Animation cho form */
    .form-section {
        animation: slideInUp 0.5s ease-out;
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .banner-form-container {
            padding: 1rem;
        }
        
        .banner-form-header {
            margin: -1rem -1rem 1rem -1rem;
            padding: 1rem;
        }
        
        .form-section {
            padding: 1rem;
        }
    }
    </style>

    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0">
                    <i class="fas fa-plus me-2"></i>Thêm Banner Quảng Cáo
                </h3>
                <a href="?act=danh-sach-banner" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Quay lại
                </a>
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

            <div class="card banner-form-container">
                <div class="card-header banner-form-header">
                    <h3 class="mb-0">
                        <i class="fas fa-plus me-2"></i>Thêm Banner Quảng Cáo
                    </h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="?act=them-banner" enctype="multipart/form-data" id="bannerForm">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="ten_banner" class="form-label">Tên Banner <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="ten_banner" name="ten_banner" 
                                           value="<?= htmlspecialchars($_POST['ten_banner'] ?? '') ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="mo_ta" class="form-label">Mô tả</label>
                                    <textarea class="form-control" id="mo_ta" name="mo_ta" rows="3"
                                              placeholder="Mô tả về banner..."><?= htmlspecialchars($_POST['mo_ta'] ?? '') ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="hinh_anh" class="form-label">Hình ảnh Banner <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="hinh_anh" name="hinh_anh" 
                                           accept="image/*" required onchange="previewImage(this)">
                                    <small class="form-text text-muted">
                                        Chấp nhận: JPG, PNG, GIF, WEBP. Kích thước tối đa: 5MB
                                    </small>
                                    <div id="imagePreview" class="mt-2 preview-container"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="link_url" class="form-label">Link URL</label>
                                    <input type="text" class="form-control" id="link_url" name="link_url" 
                                           value="<?= htmlspecialchars($_POST['link_url'] ?? '') ?>"
                                           placeholder="https://example.com hoặc ?act=trang-nao-do">
                                    <small class="form-text text-muted">
                                        URL đầy đủ hoặc link nội bộ (vd: ?act=khuyen-mai)
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="loai_hien_thi" class="form-label">Loại hiển thị <span class="text-danger">*</span></label>
                                    <select class="form-select" id="loai_hien_thi" name="loai_hien_thi" required>
                                        <option value="popup" <?= ($_POST['loai_hien_thi'] ?? 'popup') === 'popup' ? 'selected' : '' ?>>Popup</option>
                                        <option value="banner_top" <?= ($_POST['loai_hien_thi'] ?? '') === 'banner_top' ? 'selected' : '' ?>>Banner Top</option>
                                        <option value="banner_bottom" <?= ($_POST['loai_hien_thi'] ?? '') === 'banner_bottom' ? 'selected' : '' ?>>Banner Bottom</option>
                                        <option value="sidebar" <?= ($_POST['loai_hien_thi'] ?? '') === 'sidebar' ? 'selected' : '' ?>>Sidebar</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="thu_tu" class="form-label">Thứ tự hiển thị</label>
                                    <input type="number" class="form-control" id="thu_tu" name="thu_tu" 
                                           value="<?= htmlspecialchars($_POST['thu_tu'] ?? '0') ?>" min="0">
                                </div>

                                <div class="mb-3 popup-settings" id="popup_settings">
                                    <label for="thoi_gian_hien_thi" class="form-label">Thời gian hiển thị (ms)</label>
                                    <input type="number" class="form-control" id="thoi_gian_hien_thi" name="thoi_gian_hien_thi" 
                                           value="<?= htmlspecialchars($_POST['thoi_gian_hien_thi'] ?? '5000') ?>" min="1000" step="500">
                                    <small class="form-text text-muted">Thời gian hiển thị popup (1000ms = 1 giây)</small>
                                </div>

                                <div class="mb-3" id="popup_unique">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="hien_thi_lan_duy_nhat" 
                                               name="hien_thi_lan_duy_nhat" value="1" 
                                               <?= ($_POST['hien_thi_lan_duy_nhat'] ?? '1') === '1' ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="hien_thi_lan_duy_nhat">
                                            Chỉ hiển thị 1 lần/session
                                        </label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="trang_thai" class="form-label">Trạng thái</label>
                                    <select class="form-select" id="trang_thai" name="trang_thai">
                                        <option value="1" <?= ($_POST['trang_thai'] ?? '1') === '1' ? 'selected' : '' ?>>Hoạt động</option>
                                        <option value="0" <?= ($_POST['trang_thai'] ?? '') === '0' ? 'selected' : '' ?>>Không hoạt động</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="ngay_bat_dau" class="form-label">Ngày bắt đầu</label>
                                    <input type="datetime-local" class="form-control" id="ngay_bat_dau" name="ngay_bat_dau" 
                                           value="<?= htmlspecialchars($_POST['ngay_bat_dau'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="ngay_ket_thuc" class="form-label">Ngày kết thúc</label>
                                    <input type="datetime-local" class="form-control" id="ngay_ket_thuc" name="ngay_ket_thuc" 
                                           value="<?= htmlspecialchars($_POST['ngay_ket_thuc'] ?? '') ?>">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-secondary" onclick="history.back()">
                                <i class="fas fa-times me-2"></i>Hủy
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Lưu Banner
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Preview hình ảnh
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Kiểm tra loại file
        if (!file.type.startsWith('image/')) {
            alert('Vui lòng chọn file hình ảnh!');
            input.value = '';
            return;
        }
        
        // Kiểm tra kích thước file (5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert('Kích thước file không được vượt quá 5MB!');
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'img-thumbnail preview-image';
            img.style.maxWidth = '300px';
            img.style.maxHeight = '200px';
            preview.appendChild(img);
        };
        reader.readAsDataURL(file);
    }
}

// Hiển thị/ẩn cài đặt popup
document.addEventListener('DOMContentLoaded', function() {
    const loaiHienThi = document.getElementById('loai_hien_thi');
    const popupSettings = document.getElementById('popup_settings');
    const popupUnique = document.getElementById('popup_unique');
    
    function togglePopupSettings() {
        if (loaiHienThi.value === 'popup') {
            popupSettings.style.display = 'block';
            popupUnique.style.display = 'block';
        } else {
            popupSettings.style.display = 'none';
            popupUnique.style.display = 'none';
        }
    }
    
    loaiHienThi.addEventListener('change', togglePopupSettings);
    togglePopupSettings(); // Gọi lần đầu
});

// Validate form trước khi submit
document.getElementById('bannerForm').addEventListener('submit', function(e) {
    const ngayBatDau = document.getElementById('ngay_bat_dau').value;
    const ngayKetThuc = document.getElementById('ngay_ket_thuc').value;
    
    if (ngayBatDau && ngayKetThuc) {
        if (new Date(ngayBatDau) >= new Date(ngayKetThuc)) {
            e.preventDefault();
            alert('Ngày kết thúc phải sau ngày bắt đầu!');
            return false;
        }
    }
});
</script>

</div>
<!-- /.content-wrapper -->

<?php require './views/layout/footer.php' ?>
