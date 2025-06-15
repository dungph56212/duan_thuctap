<?php
// Include header và sidebar
require_once __DIR__ . '/../../views/layout/header.php';
require_once __DIR__ . '/../../views/layout/sidebar.php';
?>

<!-- Custom CSS cho form thêm banner -->
<style>
.banner-form-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
    overflow: hidden;
}

.banner-form-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1.5rem;
}

.form-section {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    border-left: 4px solid #667eea;
}

.form-control, .form-select {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.btn-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-gradient:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    color: white;
}

.preview-container {
    border: 2px dashed #ddd;
    border-radius: 8px;
    padding: 2rem;
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

.popup-settings {
    transition: all 0.3s ease;
}

.popup-settings.hidden {
    display: none;
}
</style>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-plus mr-2"></i>Thêm Banner Quảng Cáo
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="?act=danh-sach-banner">Banner</a></li>
                        <li class="breadcrumb-item active">Thêm Banner</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Thông báo -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fas fa-ban"></i>
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-12">
                    <div class="card banner-form-card">
                        <div class="banner-form-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">
                                    <i class="fas fa-image mr-2"></i>Thông tin Banner
                                </h4>
                                <a href="?act=danh-sach-banner" class="btn btn-light btn-sm">
                                    <i class="fas fa-arrow-left mr-2"></i>Quay lại
                                </a>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <form method="POST" action="?act=them-banner" enctype="multipart/form-data" id="bannerForm">
                                <div class="row">
                                    <!-- Cột trái - Thông tin chính -->
                                    <div class="col-md-8">
                                        <div class="form-section">
                                            <h5><i class="fas fa-info-circle"></i> Thông tin cơ bản</h5>
                                            
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
                                                <label for="link_url" class="form-label">Link URL</label>
                                                <input type="text" class="form-control" id="link_url" name="link_url" 
                                                       value="<?= htmlspecialchars($_POST['link_url'] ?? '') ?>"
                                                       placeholder="https://example.com hoặc ?act=trang-nao-do">
                                                <small class="form-text text-muted">
                                                    URL đầy đủ hoặc link nội bộ (vd: ?act=khuyen-mai)
                                                </small>
                                            </div>
                                        </div>

                                        <div class="form-section">
                                            <h5><i class="fas fa-image"></i> Hình ảnh Banner</h5>
                                            
                                            <div class="mb-3">
                                                <label for="hinh_anh" class="form-label">Chọn hình ảnh <span class="text-danger">*</span></label>
                                                <input type="file" class="form-control" id="hinh_anh" name="hinh_anh" 
                                                       accept="image/*" required onchange="previewImage(this)">
                                                <small class="form-text text-muted">
                                                    Chấp nhận: JPG, PNG, GIF, WEBP. Kích thước tối đa: 5MB
                                                </small>
                                            </div>

                                            <div class="preview-container" id="imagePreview">
                                                <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                                <p class="text-muted">Chọn file để xem trước</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Cột phải - Cài đặt -->
                                    <div class="col-md-4">
                                        <div class="form-section">
                                            <h5><i class="fas fa-cogs"></i> Cài đặt hiển thị</h5>
                                            
                                            <div class="mb-3">
                                                <label for="loai_hien_thi" class="form-label">Loại hiển thị <span class="text-danger">*</span></label>
                                                <select class="form-select" id="loai_hien_thi" name="loai_hien_thi" required onchange="togglePopupSettings()">
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

                                            <div class="mb-3">
                                                <label for="trang_thai" class="form-label">Trạng thái</label>
                                                <select class="form-select" id="trang_thai" name="trang_thai">
                                                    <option value="1" <?= ($_POST['trang_thai'] ?? '1') === '1' ? 'selected' : '' ?>>Hoạt động</option>
                                                    <option value="0" <?= ($_POST['trang_thai'] ?? '') === '0' ? 'selected' : '' ?>>Không hoạt động</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-section popup-settings" id="popup_settings">
                                            <h5><i class="fas fa-window-restore"></i> Cài đặt Popup</h5>
                                            
                                            <div class="mb-3">
                                                <label for="thoi_gian_hien_thi" class="form-label">Thời gian hiển thị (ms)</label>
                                                <input type="number" class="form-control" id="thoi_gian_hien_thi" name="thoi_gian_hien_thi" 
                                                       value="<?= htmlspecialchars($_POST['thoi_gian_hien_thi'] ?? '5000') ?>" min="1000" step="500">
                                                <small class="form-text text-muted">1000ms = 1 giây</small>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="hien_thi_lan_duy_nhat" 
                                                       name="hien_thi_lan_duy_nhat" value="1" 
                                                       <?= ($_POST['hien_thi_lan_duy_nhat'] ?? '1') === '1' ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="hien_thi_lan_duy_nhat">
                                                    Chỉ hiển thị 1 lần/session
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-section">
                                            <h5><i class="fas fa-calendar"></i> Thời gian</h5>
                                            
                                            <div class="mb-3">
                                                <label for="ngay_bat_dau" class="form-label">Ngày bắt đầu</label>
                                                <input type="date" class="form-control" id="ngay_bat_dau" name="ngay_bat_dau" 
                                                       value="<?= htmlspecialchars($_POST['ngay_bat_dau'] ?? date('Y-m-d')) ?>">
                                            </div>

                                            <div class="mb-3">
                                                <label for="ngay_ket_thuc" class="form-label">Ngày kết thúc</label>
                                                <input type="date" class="form-control" id="ngay_ket_thuc" name="ngay_ket_thuc" 
                                                       value="<?= htmlspecialchars($_POST['ngay_ket_thuc'] ?? '') ?>">
                                                <small class="form-text text-muted">Để trống nếu không giới hạn</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-gradient btn-lg">
                                        <i class="fas fa-save mr-2"></i>Lưu Banner
                                    </button>
                                    <a href="?act=danh-sach-banner" class="btn btn-secondary btn-lg ml-2">
                                        <i class="fas fa-times mr-2"></i>Hủy
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- JavaScript -->
<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.innerHTML = `
                <img src="${e.target.result}" class="preview-image" alt="Preview">
                <p class="mt-2 text-success">
                    <i class="fas fa-check-circle"></i> Hình ảnh đã được chọn
                </p>
            `;
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

function togglePopupSettings() {
    const loaiHienThi = document.getElementById('loai_hien_thi').value;
    const popupSettings = document.getElementById('popup_settings');
    
    if (loaiHienThi === 'popup') {
        popupSettings.classList.remove('hidden');
    } else {
        popupSettings.classList.add('hidden');
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    togglePopupSettings();
});

// Form validation
document.getElementById('bannerForm').addEventListener('submit', function(e) {
    const tenBanner = document.getElementById('ten_banner').value.trim();
    const hinhAnh = document.getElementById('hinh_anh').files[0];
    
    if (!tenBanner) {
        e.preventDefault();
        alert('Vui lòng nhập tên banner!');
        document.getElementById('ten_banner').focus();
        return false;
    }
    
    if (!hinhAnh) {
        e.preventDefault();
        alert('Vui lòng chọn hình ảnh banner!');
        document.getElementById('hinh_anh').focus();
        return false;
    }
    
    // Check file size (5MB)
    if (hinhAnh.size > 5 * 1024 * 1024) {
        e.preventDefault();
        alert('Kích thước file không được vượt quá 5MB!');
        return false;
    }
    
    // Check file type
    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
    if (!allowedTypes.includes(hinhAnh.type)) {
        e.preventDefault();
        alert('Chỉ chấp nhận file ảnh JPG, PNG, GIF, WEBP!');
        return false;
    }
    
    return true;
});
</script>

<?php
// Include footer
require_once __DIR__ . '/../../views/layout/footer.php';
?>
