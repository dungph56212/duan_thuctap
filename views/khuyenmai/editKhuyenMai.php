<?php require_once 'views/layout/header.php'; ?>
<div class="container mt-5">
    <h3>Sửa khuyến mãi</h3>
    <form method="POST" action="?act=sua-khuyen-mai">
        <input type="hidden" name="id" value="<?= $km['id'] ?>">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Mã khuyến mãi</label>
                <input type="text" name="ma_khuyen_mai" class="form-control" value="<?= htmlspecialchars($km['ma_khuyen_mai']) ?>" required>
            </div>
            <div class="form-group col-md-6">
                <label>Tên khuyến mãi</label>
                <input type="text" name="ten_khuyen_mai" class="form-control" value="<?= htmlspecialchars($km['ten_khuyen_mai']) ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label>Mô tả</label>
            <textarea name="mo_ta" class="form-control"><?= htmlspecialchars($km['mo_ta']) ?></textarea>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label>Phần trăm giảm (%)</label>
                <input type="number" name="phan_tram_giam" class="form-control" min="0" max="100" value="<?= $km['phan_tram_giam'] ?>">
            </div>
            <div class="form-group col-md-4">
                <label>Giá giảm (VNĐ)</label>
                <input type="number" name="gia_giam" class="form-control" min="0" value="<?= $km['gia_giam'] ?>">
            </div>
            <div class="form-group col-md-4">
                <label>Số lượng</label>
                <input type="number" name="so_luong" class="form-control" min="1" value="<?= $km['so_luong'] ?>">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Số lần sử dụng / user</label>
                <input type="number" name="so_lan_su_dung" class="form-control" min="1" value="<?= $km['so_lan_su_dung'] ?>">
            </div>
            <div class="form-group col-md-3">
                <label>Ngày bắt đầu</label>
                <input type="datetime-local" name="ngay_bat_dau" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($km['ngay_bat_dau'])) ?>" required>
            </div>
            <div class="form-group col-md-3">
                <label>Ngày kết thúc</label>
                <input type="datetime-local" name="ngay_ket_thuc" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($km['ngay_ket_thuc'])) ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label>Trạng thái</label>
            <select name="trang_thai" class="form-control">
                <option value="1" <?= $km['trang_thai'] ? 'selected' : '' ?>>Hoạt động</option>
                <option value="0" <?= !$km['trang_thai'] ? 'selected' : '' ?>>Ngừng</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Cập nhật</button>
        <a href="?act=danh-sach-khuyen-mai" class="btn btn-secondary ml-2">Quay lại</a>
    </form>
</div>
<?php require_once 'views/layout/footer.php'; ?> 