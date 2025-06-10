<?php require_once 'layout/header.php'; ?>
<?php require_once 'layout/sidebar.php'; ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-times-circle text-danger"></i>
                        Khuyến mãi đã hết hạn
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang chủ</a></li>
                        <li class="breadcrumb-item">Khuyến mãi</li>
                        <li class="breadcrumb-item active">Đã hết hạn</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-archive"></i>
                        Danh sách khuyến mãi đã hết hạn
                    </h3>
                    <div class="card-tools">
                        <span class="badge badge-danger"><?= count($expiredPromotions) ?> chương trình</span>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (empty($expiredPromotions)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-smile text-success" style="font-size: 3rem;"></i>
                            <h4 class="mt-3">Tuyệt vời!</h4>
                            <p class="text-muted">Hiện tại không có khuyến mãi nào đã hết hạn.</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Mã khuyến mãi</th>
                                        <th>Tên chương trình</th>
                                        <th>Loại giảm giá</th>
                                        <th>Đã sử dụng</th>
                                        <th>Số lượng còn lại</th>
                                        <th>Ngày hết hạn</th>
                                        <th>Hiệu suất</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($expiredPromotions as $key => $khuyenMai): 
                                        $totalQuantity = $khuyenMai['so_luong'] + $khuyenMai['so_lan_su_dung'];
                                        $usageRate = $totalQuantity > 0 ? ($khuyenMai['so_lan_su_dung'] / $totalQuantity) * 100 : 0;
                                        
                                        if ($usageRate >= 80) {
                                            $performanceClass = 'badge-success';
                                            $performanceText = 'Xuất sắc';
                                        } elseif ($usageRate >= 50) {
                                            $performanceClass = 'badge-info';
                                            $performanceText = 'Tốt';
                                        } elseif ($usageRate >= 20) {
                                            $performanceClass = 'badge-warning';
                                            $performanceText = 'Trung bình';
                                        } else {
                                            $performanceClass = 'badge-danger';
                                            $performanceText = 'Kém';
                                        }
                                    ?>
                                        <tr>
                                            <td><?= $key + 1 ?></td>
                                            <td>
                                                <span class="badge badge-secondary"><?= $khuyenMai['ma_khuyen_mai'] ?></span>
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
                                                <span class="badge badge-primary"><?= $khuyenMai['so_lan_su_dung'] ?></span>
                                            </td>
                                            <td>
                                                <span class="badge badge-secondary"><?= $khuyenMai['so_luong'] ?></span>
                                            </td>
                                            <td><?= date('d/m/Y', strtotime($khuyenMai['ngay_ket_thuc'])) ?></td>
                                            <td>
                                                <span class="badge <?= $performanceClass ?>"><?= $performanceText ?></span>
                                                <br>
                                                <small class="text-muted"><?= number_format($usageRate, 1) ?>%</small>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= BASE_URL_ADMIN ?>?act=form-sua-khuyen-mai&id_khuyen_mai=<?= $khuyenMai['id'] ?>" 
                                                       class="btn btn-warning btn-sm" title="Tái kích hoạt">
                                                        <i class="fas fa-redo"></i>
                                                    </a>
                                                    <a href="<?= BASE_URL_ADMIN ?>?act=xoa-khuyen-mai&id_khuyen_mai=<?= $khuyenMai['id'] ?>" 
                                                       class="btn btn-danger btn-sm"
                                                       onclick="return confirm('Bạn có muốn xóa vĩnh viễn khuyến mãi này?')" 
                                                       title="Xóa vĩnh viễn">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div>

<?php require_once 'layout/footer.php'; ?>
