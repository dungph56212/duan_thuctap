<?php require_once 'layout/header.php'; ?>
<?php require_once 'layout/sidebar.php'; ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-exclamation-triangle text-warning"></i>
                        Khuyến mãi sắp hết hạn
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang chủ</a></li>
                        <li class="breadcrumb-item">Khuyến mãi</li>
                        <li class="breadcrumb-item active">Sắp hết hạn</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="callout callout-warning">
                <h5><i class="fas fa-info"></i> Thông báo:</h5>
                Danh sách các khuyến mãi sẽ hết hạn trong 7 ngày tới. Hãy xem xét gia hạn hoặc tạo chương trình mới.
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-clock"></i>
                        Khuyến mãi sắp hết hạn
                    </h3>
                    <div class="card-tools">
                        <span class="badge badge-warning"><?= count($expiringPromotions) ?> chương trình</span>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (empty($expiringPromotions)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-smile text-success" style="font-size: 3rem;"></i>
                            <h4 class="mt-3">Tuyệt vời!</h4>
                            <p class="text-muted">Hiện tại không có khuyến mãi nào sắp hết hạn.</p>
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
                                        <th>Số lượng còn lại</th>
                                        <th>Ngày hết hạn</th>
                                        <th>Số ngày còn lại</th>
                                        <th>Mức độ ưu tiên</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($expiringPromotions as $key => $khuyenMai): 
                                        $ngayHetHan = new DateTime($khuyenMai['ngay_ket_thuc']);
                                        $ngayHienTai = new DateTime();
                                        $soNgayConLai = $ngayHienTai->diff($ngayHetHan)->days;
                                        
                                        if ($soNgayConLai <= 1) {
                                            $urgencyClass = 'badge-danger';
                                            $urgencyText = 'Khẩn cấp';
                                        } elseif ($soNgayConLai <= 3) {
                                            $urgencyClass = 'badge-warning';
                                            $urgencyText = 'Cao';
                                        } else {
                                            $urgencyClass = 'badge-info';
                                            $urgencyText = 'Trung bình';
                                        }
                                    ?>
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
                                            <td><?= date('d/m/Y', strtotime($khuyenMai['ngay_ket_thuc'])) ?></td>
                                            <td>
                                                <span class="badge <?= $soNgayConLai <= 1 ? 'badge-danger' : ($soNgayConLai <= 3 ? 'badge-warning' : 'badge-info') ?>">
                                                    <?= $soNgayConLai ?> ngày
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge <?= $urgencyClass ?>"><?= $urgencyText ?></span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= BASE_URL_ADMIN ?>?act=form-sua-khuyen-mai&id_khuyen_mai=<?= $khuyenMai['id'] ?>" 
                                                       class="btn btn-warning btn-sm" title="Gia hạn">
                                                        <i class="fas fa-clock"></i>
                                                    </a>
                                                    <a href="<?= BASE_URL_ADMIN ?>?act=form-sua-khuyen-mai&id_khuyen_mai=<?= $khuyenMai['id'] ?>" 
                                                       class="btn btn-info btn-sm" title="Chỉnh sửa">
                                                        <i class="fas fa-edit"></i>
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
