<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0">
                    <i class="fas fa-plus-circle me-2"></i>Thêm khuyến mãi mới
                </h3>
                <a href="?act=danh-sach-khuyen-mai" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Quay lại
                </a>
            </div>

            <!-- Thông báo lỗi -->
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

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Thông tin khuyến mãi</h5>
                        </div>
                        <div class="card-body">
                            <form action="?act=them-khuyen-mai" method="POST" id="promotionForm">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="ma_khuyen_mai" class="form-label">
                                                Mã khuyến mãi <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="ma_khuyen_mai" name="ma_khuyen_mai" 
                                                   value="<?= htmlspecialchars($_POST['ma_khuyen_mai'] ?? '') ?>" 
                                                   placeholder="VD: SALE20, NEWUSER..." maxlength="20" required>
                                            <div class="form-text">Chỉ chứa chữ cái viết hoa và số, độ dài 3-20 ký tự</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="ten_khuyen_mai" class="form-label">
                                                Tên khuyến mãi <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="ten_khuyen_mai" name="ten_khuyen_mai" 
                                                   value="<?= htmlspecialchars($_POST['ten_khuyen_mai'] ?? '') ?>" 
                                                   placeholder="Tên hiển thị của khuyến mãi" maxlength="255" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="mo_ta" class="form-label">Mô tả</label>
                                    <textarea class="form-control" id="mo_ta" name="mo_ta" rows="3" 
                                              placeholder="Mô tả chi tiết về khuyến mãi"><?= htmlspecialchars($_POST['mo_ta'] ?? '') ?></textarea>
                                </div>                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="phan_tram_giam" class="form-label">
                                                Phần trăm giảm (%)
                                            </label>
                                            <input type="number" class="form-control" id="phan_tram_giam" name="phan_tram_giam" 
                                                   value="<?= htmlspecialchars($_POST['phan_tram_giam'] ?? '') ?>" 
                                                   min="0" max="100" step="0.01" placeholder="0">
                                            <div class="form-text">Để 0 nếu muốn giảm theo số tiền cố định</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="gia_giam" class="form-label">
                                                Số tiền giảm (VNĐ)
                                            </label>
                                            <input type="number" class="form-control" id="gia_giam" name="gia_giam" 
                                                   value="<?= htmlspecialchars($_POST['gia_giam'] ?? '') ?>" 
                                                   min="0" step="1000" placeholder="0">
                                            <div class="form-text">Để 0 nếu muốn giảm theo phần trăm</div>
                                        </div></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="so_luong" class="form-label">
                                                Số lượng <span class="text-danger">*</span>
                                            </label>
                                            <input type="number" class="form-control" id="so_luong" name="so_luong" 
                                                   value="<?= htmlspecialchars($_POST['so_luong'] ?? '') ?>" 
                                                   min="1" placeholder="0" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">                                        <div class="mb-3">
                                            <label for="so_lan_su_dung" class="form-label">Số lần đã sử dụng</label>
                                            <input type="number" class="form-control" id="so_lan_su_dung" name="so_lan_su_dung" 
                                                   value="<?= htmlspecialchars($_POST['so_lan_su_dung'] ?? '0') ?>" 
                                                   min="0" placeholder="0">
                                            <div class="form-text">Số lần khuyến mãi đã được sử dụng (mặc định là 0)</div>                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="ngay_bat_dau" class="form-label">
                                                Ngày bắt đầu <span class="text-danger">*</span>
                                            </label>
                                            <input type="datetime-local" class="form-control" id="ngay_bat_dau" name="ngay_bat_dau" 
                                                   value="<?= htmlspecialchars($_POST['ngay_bat_dau'] ?? '') ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="ngay_ket_thuc" class="form-label">
                                                Ngày kết thúc <span class="text-danger">*</span>
                                            </label>
                                            <input type="datetime-local" class="form-control" id="ngay_ket_thuc" name="ngay_ket_thuc" 
                                                   value="<?= htmlspecialchars($_POST['ngay_ket_thuc'] ?? '') ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="trang_thai" class="form-label">Trạng thái</label>
                                            <select class="form-select" id="trang_thai" name="trang_thai">
                                                <option value="1" <?= ($_POST['trang_thai'] ?? 1) == 1 ? 'selected' : '' ?>>Hoạt động</option>
                                                <option value="0" <?= ($_POST['trang_thai'] ?? 1) == 0 ? 'selected' : '' ?>>Tạm ngưng</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="?act=danh-sach-khuyen-mai" class="btn btn-secondary">
                                        <i class="fas fa-times me-2"></i>Hủy
                                    </a>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save me-2"></i>Thêm khuyến mãi
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Hướng dẫn</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <h6><i class="fas fa-info-circle text-info me-2"></i>Mã khuyến mãi</h6>
                                <ul class="list-unstyled small">
                                    <li>• Chỉ chứa chữ cái viết hoa và số</li>
                                    <li>• Độ dài từ 3-20 ký tự</li>
                                    <li>• Không được trùng với mã đã có</li>
                                </ul>
                            </div>

                            <div class="mb-3">
                                <h6><i class="fas fa-percentage text-warning me-2"></i>Loại giảm giá</h6>
                                <ul class="list-unstyled small">
                                    <li>• <strong>Phần trăm:</strong> Giảm theo % giá trị đơn hàng</li>
                                    <li>• <strong>Số tiền:</strong> Giảm một số tiền cố định</li>
                                </ul>
                            </div>

                            <div class="mb-3">
                                <h6><i class="fas fa-users text-primary me-2"></i>Đối tượng áp dụng</h6>
                                <ul class="list-unstyled small">
                                    <li>• <strong>Tất cả:</strong> Mọi khách hàng</li>
                                    <li>• <strong>Khách mới:</strong> Lần đầu mua hàng</li>
                                    <li>• <strong>VIP:</strong> Khách hàng thân thiết</li>
                                </ul>
                            </div>

                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Lưu ý:</strong> Sau khi tạo, mã khuyến mãi không thể thay đổi. Hãy kiểm tra kỹ thông tin trước khi lưu.
                            </div>
                        </div>
                    </div>                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validate mã khuyến mãi
    document.getElementById('ma_khuyen_mai').addEventListener('input', function() {
        this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
    });
    
    // Validate số lượng và ngày
    document.getElementById('so_luong').addEventListener('input', function() {
        if (this.value < 1) this.value = 1;
    });
    
    document.getElementById('so_lan_su_dung').addEventListener('input', function() {
        if (this.value < 0) this.value = 0;
    });
    
    // Set default datetime values
    const now = new Date();
    const tomorrow = new Date(now.getTime() + 24 * 60 * 60 * 1000);
    const nextWeek = new Date(now.getTime() + 7 * 24 * 60 * 60 * 1000);
    
    if (!document.getElementById('ngay_bat_dau').value) {
        document.getElementById('ngay_bat_dau').value = tomorrow.toISOString().slice(0, 16);
    }
    if (!document.getElementById('ngay_ket_thuc').value) {
        document.getElementById('ngay_ket_thuc').value = nextWeek.toISOString().slice(0, 16);
    }
    
    // Form validation
    document.getElementById('promotionForm').addEventListener('submit', function(e) {
        const phanTramGiam = parseFloat(document.getElementById('phan_tram_giam').value) || 0;
        const giaGiam = parseFloat(document.getElementById('gia_giam').value) || 0;
        
        if (phanTramGiam <= 0 && giaGiam <= 0) {
            e.preventDefault();
            alert('Vui lòng nhập phần trăm giảm hoặc số tiền giảm!');
            return false;
        }
        
        if (phanTramGiam > 0 && phanTramGiam > 100) {
            e.preventDefault();
            alert('Phần trăm giảm không được quá 100%!');
            return false;
        }
        
        const ngayBatDau = new Date(document.getElementById('ngay_bat_dau').value);
        const ngayKetThuc = new Date(document.getElementById('ngay_ket_thuc').value);
        
        if (ngayKetThuc <= ngayBatDau) {
            e.preventDefault();
            alert('Ngày kết thúc phải sau ngày bắt đầu!');
            return false;
        }
    });
});
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
