<?php require './views/layout/header.php' ?>
<?php require './views/layout/navbar.php' ?>
<?php require './views/layout/sidebar.php' ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0">
                    <i class="fas fa-edit me-2"></i>Sửa Banner Quảng Cáo
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

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Thông tin Banner</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="?act=sua-banner&id=<?= $banner['id'] ?>" enctype="multipart/form-data" id="bannerForm">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="ten_banner" class="form-label">Tên Banner <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="ten_banner" name="ten_banner" 
                                           value="<?= htmlspecialchars($_POST['ten_banner'] ?? $banner['ten_banner']) ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="mo_ta" class="form-label">Mô tả</label>
                                    <textarea class="form-control" id="mo_ta" name="mo_ta" rows="3"
                                              placeholder="Mô tả về banner..."><?= htmlspecialchars($_POST['mo_ta'] ?? $banner['mo_ta']) ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="hinh_anh" class="form-label">Hình ảnh Banner</label>
                                    
                                    <!-- Hiển thị ảnh hiện tại -->
                                    <?php if (!empty($banner['hinh_anh'])): ?>
                                        <div class="mb-2">
                                            <label class="form-label">Ảnh hiện tại:</label>
                                            <div>
                                                <img src="<?= $banner['hinh_anh'] ?>" alt="<?= htmlspecialchars($banner['ten_banner']) ?>" 
                                                     class="img-thumbnail" style="max-width: 300px; max-height: 200px; object-fit: cover;">
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <input type="file" class="form-control" id="hinh_anh" name="hinh_anh" 
                                           accept="image/*" onchange="previewImage(this)">
                                    <small class="form-text text-muted">
                                        Chấp nhận: JPG, PNG, GIF, WEBP. Kích thước tối đa: 5MB. Để trống nếu không muốn thay đổi.
                                    </small>
                                    <div id="imagePreview" class="mt-2"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="link_url" class="form-label">Link URL</label>
                                    <input type="text" class="form-control" id="link_url" name="link_url" 
                                           value="<?= htmlspecialchars($_POST['link_url'] ?? $banner['link_url']) ?>"
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
                                        <option value="popup" <?= ($_POST['loai_hien_thi'] ?? $banner['loai_hien_thi']) === 'popup' ? 'selected' : '' ?>>Popup</option>
                                        <option value="banner_top" <?= ($_POST['loai_hien_thi'] ?? $banner['loai_hien_thi']) === 'banner_top' ? 'selected' : '' ?>>Banner Top</option>
                                        <option value="banner_bottom" <?= ($_POST['loai_hien_thi'] ?? $banner['loai_hien_thi']) === 'banner_bottom' ? 'selected' : '' ?>>Banner Bottom</option>
                                        <option value="sidebar" <?= ($_POST['loai_hien_thi'] ?? $banner['loai_hien_thi']) === 'sidebar' ? 'selected' : '' ?>>Sidebar</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="thu_tu" class="form-label">Thứ tự hiển thị</label>
                                    <input type="number" class="form-control" id="thu_tu" name="thu_tu" 
                                           value="<?= htmlspecialchars($_POST['thu_tu'] ?? $banner['thu_tu']) ?>" min="0">
                                </div>

                                <div class="mb-3" id="popup_settings">
                                    <label for="thoi_gian_hien_thi" class="form-label">Thời gian hiển thị (ms)</label>
                                    <input type="number" class="form-control" id="thoi_gian_hien_thi" name="thoi_gian_hien_thi" 
                                           value="<?= htmlspecialchars($_POST['thoi_gian_hien_thi'] ?? $banner['thoi_gian_hien_thi']) ?>" min="1000" step="500">
                                    <small class="form-text text-muted">Thời gian hiển thị popup (1000ms = 1 giây)</small>
                                </div>

                                <div class="mb-3" id="popup_unique">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="hien_thi_lan_duy_nhat" 
                                               name="hien_thi_lan_duy_nhat" value="1" 
                                               <?= ($_POST['hien_thi_lan_duy_nhat'] ?? $banner['hien_thi_lan_duy_nhat']) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="hien_thi_lan_duy_nhat">
                                            Chỉ hiển thị 1 lần/session
                                        </label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="trang_thai" class="form-label">Trạng thái</label>
                                    <select class="form-select" id="trang_thai" name="trang_thai">
                                        <option value="1" <?= ($_POST['trang_thai'] ?? $banner['trang_thai']) == '1' ? 'selected' : '' ?>>Hoạt động</option>
                                        <option value="0" <?= ($_POST['trang_thai'] ?? $banner['trang_thai']) == '0' ? 'selected' : '' ?>>Không hoạt động</option>
                                    </select>
                                </div>

                                <!-- Thống kê -->
                                <div class="mb-3">
                                    <label class="form-label">Thống kê</label>
                                    <div class="card border-info">
                                        <div class="card-body p-2">
                                            <small>
                                                <i class="fas fa-eye text-info"></i> Lượt xem: <strong><?= number_format($banner['luot_xem']) ?></strong><br>
                                                <i class="fas fa-mouse-pointer text-primary"></i> Lượt click: <strong><?= number_format($banner['luot_click']) ?></strong><br>
                                                <i class="fas fa-chart-line text-success"></i> CTR: <strong>
                                                    <?= $banner['luot_xem'] > 0 ? round(($banner['luot_click'] / $banner['luot_xem']) * 100, 2) : 0 ?>%
                                                </strong>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="ngay_bat_dau" class="form-label">Ngày bắt đầu</label>
                                    <input type="datetime-local" class="form-control" id="ngay_bat_dau" name="ngay_bat_dau" 
                                           value="<?= htmlspecialchars($_POST['ngay_bat_dau'] ?? ($banner['ngay_bat_dau'] ? date('Y-m-d\TH:i', strtotime($banner['ngay_bat_dau'])) : '')) ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="ngay_ket_thuc" class="form-label">Ngày kết thúc</label>
                                    <input type="datetime-local" class="form-control" id="ngay_ket_thuc" name="ngay_ket_thuc" 
                                           value="<?= htmlspecialchars($_POST['ngay_ket_thuc'] ?? ($banner['ngay_ket_thuc'] ? date('Y-m-d\TH:i', strtotime($banner['ngay_ket_thuc'])) : '')) ?>">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-secondary" onclick="history.back()">
                                <i class="fas fa-times me-2"></i>Hủy
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Cập nhật Banner
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
            const div = document.createElement('div');
            div.className = 'mt-2';
            div.innerHTML = `
                <label class="form-label">Ảnh mới:</label>
                <div>
                    <img src="${e.target.result}" class="img-thumbnail" style="max-width: 300px; max-height: 200px; object-fit: cover;">
                </div>
            `;
            preview.appendChild(div);
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
