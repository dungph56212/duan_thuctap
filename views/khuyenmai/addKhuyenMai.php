<?php require_once 'views/layout/header.php'; ?>
<div class="container mt-5">
    <h3>Thêm khuyến mãi mới</h3>
    <form method="POST" action="?act=them-khuyen-mai">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Mã khuyến mãi</label>
                <input type="text" name="ma_khuyen_mai" class="form-control" required>
            </div>
            <div class="form-group col-md-6">
                <label>Tên khuyến mãi</label>
                <input type="text" name="ten_khuyen_mai" class="form-control" required>
            </div>
        </div>
        <div class="form-group">
            <label>Mô tả</label>
            <textarea name="mo_ta" class="form-control"></textarea>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label>Phần trăm giảm (%)</label>
                <input type="number" name="phan_tram_giam" class="form-control" min="0" max="100" value="0">
            </div>
            <div class="form-group col-md-4">
                <label>Giá giảm (VNĐ)</label>
                <input type="number" name="gia_giam" class="form-control" min="0" value="0">
            </div>
            <div class="form-group col-md-4">
                <label>Số lượng</label>
                <input type="number" name="so_luong" class="form-control" min="1" value="1">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Số lần sử dụng / user</label>
                <input type="number" name="so_lan_su_dung" class="form-control" min="1" value="1">
            </div>
            <div class="form-group col-md-3">
                <label>Ngày bắt đầu</label>
                <input type="datetime-local" name="ngay_bat_dau" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
                <label>Ngày kết thúc</label>
                <input type="datetime-local" name="ngay_ket_thuc" class="form-control" required>
            </div>
        </div>
        <div class="form-group">
            <label>Trạng thái</label>
            <select name="trang_thai" class="form-control">
                <option value="1">Hoạt động</option>
                <option value="0">Ngừng</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Thêm khuyến mãi</button>
        <a href="?act=danh-sach-khuyen-mai" class="btn btn-secondary ml-2">Quay lại</a>
    </form>
</div>
<?php require_once 'views/layout/footer.php'; ?> 