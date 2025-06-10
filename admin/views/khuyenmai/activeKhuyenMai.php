<?php require_once 'layout/header.php'; ?>
<?php require_once 'layout/sidebar.php'; ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-play-circle text-success"></i>
                        Khuyến mãi đang hoạt động
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang chủ</a></li>
                        <li class="breadcrumb-item">Khuyến mãi</li>
                        <li class="breadcrumb-item active">Đang hoạt động</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= count($activePromotions) ?></h3>
                            <p>Khuyến mãi hoạt động</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-play-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= array_sum(array_column($activePromotions, 'so_lan_su_dung')) ?></h3>
                            <p>Tổng lượt sử dụng</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= array_sum(array_column($activePromotions, 'so_luong')) ?></h3>
                            <p>Tổng số lượng còn lại</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-box"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3><?= count(array_filter($activePromotions, function($p) { return $p['so_luong'] <= 10; })) ?></h3>
                            <p>Sắp hết hạn sử dụng</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list"></i>
                        Danh sách khuyến mãi đang hoạt động
                    </h3>
                    <div class="card-tools">
                        <a href="<?= BASE_URL_ADMIN ?>?act=form-them-khuyen-mai" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Thêm khuyến mãi
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Mã khuyến mãi</th>
                                    <th>Tên chương trình</th>
                                    <th>Loại giảm giá</th>
                                    <th>Số lượng còn lại</th>
                                    <th>Đã sử dụng</th>
                                    <th>Ngày bắt đầu</th>
                                    <th>Ngày kết thúc</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($activePromotions as $key => $khuyenMai): ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td>
                                            <span class="badge badge-primary"><?= $khuyenMai['ma_khuyen_mai'] ?></span>
                                        </td>
                                        <td><?= $khuyenMai['ten_khuyen_mai'] ?></td>
                                        <td>
                                            <?php if ($khuyenMai['phan_tram_giam'] > 0): ?>
                                                <span class="badge badge-success"><?= $khuyenMai['phan_tram_giam'] ?>%</span>
                                            <?php else: ?>
                                                <span class="badge badge-info"><?= number_format($khuyenMai['gia_giam']) ?>đ</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge <?= $khuyenMai['so_luong'] <= 10 ? 'badge-warning' : 'badge-success' ?>">
                                                <?= $khuyenMai['so_luong'] ?>
                                            </span>
                                        </td>
                                        <td><?= $khuyenMai['so_lan_su_dung'] ?></td>
                                        <td><?= date('d/m/Y', strtotime($khuyenMai['ngay_bat_dau'])) ?></td>
                                        <td><?= date('d/m/Y', strtotime($khuyenMai['ngay_ket_thuc'])) ?></td>
                                        <td>
                                            <span class="badge badge-success">
                                                <i class="fas fa-check-circle"></i> Đang hoạt động
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="<?= BASE_URL_ADMIN ?>?act=form-sua-khuyen-mai&id_khuyen_mai=<?= $khuyenMai['id'] ?>" 
                                                   class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="<?= BASE_URL_ADMIN ?>?act=xoa-khuyen-mai&id_khuyen_mai=<?= $khuyenMai['id'] ?>" 
                                                   class="btn btn-danger btn-sm"
                                                   onclick="return confirm('Bạn có muốn xóa khuyến mãi này?')">
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
    </section>
</div>

<?php require_once 'layout/footer.php'; ?>
