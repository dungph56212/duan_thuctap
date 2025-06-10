<?php require_once 'views/layout/header.php'; ?>
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0"><i class="fas fa-gift"></i> Quản Lý Khuyến Mãi</h3>
        <div>
            <a href="?act=form-them-khuyen-mai" class="btn btn-primary"><i class="fas fa-plus"></i> Thêm khuyến mãi mới</a>
            <a href="?act=xuat-excel-khuyen-mai" class="btn btn-success ml-2"><i class="fas fa-file-excel"></i> Xuất báo cáo Excel</a>
        </div>
    </div>
    <!-- Thống kê nhanh -->
    <div class="row mb-4">
        <div class="col-md-3 mb-2">
            <div class="card text-white bg-info h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="mr-3"><i class="fas fa-gift fa-2x"></i></div>
                    <div>
                        <div class="h4 mb-0"><?= $stats['total'] ?? 0 ?></div>
                        <div>Tổng khuyến mãi</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card text-white bg-success h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="mr-3"><i class="fas fa-check-circle fa-2x"></i></div>
                    <div>
                        <div class="h4 mb-0"><?= $stats['active'] ?? 0 ?></div>
                        <div>Đang hoạt động</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card text-white bg-warning h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="mr-3"><i class="fas fa-exclamation-triangle fa-2x"></i></div>
                    <div>
                        <div class="h4 mb-0"><?= $stats['expiring'] ?? 0 ?></div>
                        <div>Sắp hết hạn</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card text-white bg-danger h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="mr-3"><i class="fas fa-times-circle fa-2x"></i></div>
                    <div>
                        <div class="h4 mb-0"><?= $stats['expired'] ?? 0 ?></div>
                        <div>Đã hết hạn</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bảng danh sách khuyến mãi -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-list"></i> Danh sách khuyến mãi</span>
            <form class="form-inline" method="get" action="">
                <input type="hidden" name="act" value="danh-sach-khuyen-mai">
                <input type="text" name="q" class="form-control form-control-sm mr-2" placeholder="Tìm kiếm..." value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
                <button class="btn btn-sm btn-outline-primary" type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>STT</th>
                        <th>Mã KM</th>
                        <th>Tên khuyến mãi</th>
                        <th>Phần trăm giảm</th>
                        <th>Giá giảm</th>
                        <th>Số lượng</th>
                        <th>Ngày bắt đầu</th>
                        <th>Ngày kết thúc</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($list)): $i = 1; foreach ($list as $km): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= htmlspecialchars($km['ma_khuyen_mai']) ?></td>
                            <td><?= htmlspecialchars($km['ten_khuyen_mai']) ?></td>
                            <td><?= $km['phan_tram_giam'] ?>%</td>
                            <td><?= number_format($km['gia_giam']) ?>đ</td>
                            <td><?= $km['so_luong'] ?></td>
                            <td><?= $km['ngay_bat_dau'] ?></td>
                            <td><?= $km['ngay_ket_thuc'] ?></td>
                            <td>
                                <?php
                                $now = date('Y-m-d H:i:s');
                                if (!$km['trang_thai']) {
                                    echo '<span class="badge badge-secondary">Ngừng</span>';
                                } elseif ($km['ngay_ket_thuc'] < $now) {
                                    echo '<span class="badge badge-danger">Hết hạn</span>';
                                } elseif (strtotime($km['ngay_ket_thuc']) - time() < 3*24*3600) {
                                    echo '<span class="badge badge-warning">Sắp hết hạn</span>';
                                } else {
                                    echo '<span class="badge badge-success">Hoạt động</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <a href="?act=form-sua-khuyen-mai&id=<?= $km['id'] ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                <a href="?act=xoa-khuyen-mai&id=<?= $km['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xóa khuyến mãi này?')"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; else: ?>
                        <tr><td colspan="10" class="text-center">Không có khuyến mãi nào.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once 'views/layout/footer.php'; ?> 