<?php require_once 'layout/header.php'; ?>
<?php require_once 'layout/menu.php'; ?>

<main>
    <!-- breadcrumb area start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>?act=thong-tin-nguoi-dung">Tài khoản</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Quản lý địa chỉ</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->

    <!-- address management wrapper start -->
    <div class="my-account-wrapper section-padding">
        <div class="container">
            <div class="section-bg-color">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- My Account Page Start -->
                        <div class="myaccount-page-wrapper">
                            <!-- My Account Tab Menu Start -->
                            <div class="row">
                                <div class="col-lg-3 col-md-4">
                                    <div class="myaccount-tab-menu nav" role="tablist">
                                        <a href="<?= BASE_URL ?>?act=thong-tin-nguoi-dung"><i class="fa fa-dashboard"></i> Bảng điều khiển</a>
                                        <a href="<?= BASE_URL ?>?act=thong-tin-nguoi-dung"><i class="fa fa-cart-arrow-down"></i> Đơn hàng</a>
                                        <a href="<?= BASE_URL ?>?act=thong-tin-nguoi-dung"><i class="fa fa-user"></i> Thông tin tài khoản</a>
                                        <a href="<?= BASE_URL ?>?act=quan-ly-dia-chi" class="active"><i class="fa fa-map-marker"></i> Quản lý địa chỉ</a>
                                        <a href="<?= BASE_URL ?>?act=thong-tin-nguoi-dung"><i class="fa fa-key"></i> Đổi mật khẩu</a>
                                        <a href="<?= BASE_URL . '?act=logout' ?>"><i class="fa fa-sign-out"></i> Đăng xuất</a>
                                    </div>
                                </div>
                                <!-- My Account Tab Menu End -->

                                <!-- My Account Tab Content Start -->
                                <div class="col-lg-9 col-md-8">
                                    <div class="tab-content" id="myaccountContent">
                                        
                                        <!-- Success/Error Messages -->
                                        <?php if (isset($_SESSION['success'])): ?>
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <?= $_SESSION['success'] ?>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <?php unset($_SESSION['success']); ?>
                                        <?php endif; ?>

                                        <?php if (isset($_SESSION['error'])): ?>
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <?= $_SESSION['error'] ?>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <?php unset($_SESSION['error']); ?>
                                        <?php endif; ?>

                                        <!-- Address Management Content Start -->
                                        <div class="tab-pane fade show active" role="tabpanel">
                                            <div class="myaccount-content">
                                                <h5>Quản lý địa chỉ</h5>
                                                <div class="myaccount-table table-responsive">
                                                    
                                                    <!-- Add New Address Button -->
                                                    <div class="mb-4 text-center">
                                                        <a href="<?= BASE_URL ?>?act=them-dia-chi" class="btn btn-primary">
                                                            <i class="fa fa-plus"></i> Thêm địa chỉ mới
                                                        </a>
                                                    </div>

                                                    <?php if (empty($listDiaChi)): ?>
                                                        <div class="alert alert-info text-center">
                                                            <i class="fa fa-info-circle"></i> Bạn chưa có địa chỉ nào. 
                                                            <a href="<?= BASE_URL ?>?act=them-dia-chi" class="alert-link">Thêm địa chỉ đầu tiên</a>
                                                        </div>
                                                    <?php else: ?>
                                                        <!-- Address List -->
                                                        <div class="row">
                                                            <?php foreach ($listDiaChi as $diaChi): ?>
                                                                <div class="col-lg-6 col-md-12 mb-4">
                                                                    <div class="card address-card h-100 <?= $diaChi['is_default'] ? 'border-primary' : '' ?>">
                                                                        <div class="card-header d-flex justify-content-between align-items-center">
                                                                            <h6 class="mb-0">
                                                                                <i class="fa fa-user"></i> <?= htmlspecialchars($diaChi['ho_ten']) ?>
                                                                                <?php if ($diaChi['is_default']): ?>
                                                                                    <span class="badge badge-primary ml-2">Mặc định</span>
                                                                                <?php endif; ?>
                                                                            </h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <p class="card-text mb-2">
                                                                                <i class="fa fa-phone"></i> <strong>Số điện thoại:</strong> <?= htmlspecialchars($diaChi['so_dien_thoai']) ?>
                                                                            </p>
                                                                            <p class="card-text mb-0">
                                                                                <i class="fa fa-map-marker"></i> <strong>Địa chỉ:</strong><br>
                                                                                <span class="ml-3">
                                                                                    <?= htmlspecialchars($diaChi['dia_chi_chi_tiet']) ?>,<br>
                                                                                    <?= htmlspecialchars($diaChi['phuong_xa']) ?>, 
                                                                                    <?= htmlspecialchars($diaChi['quan_huyen']) ?>,<br>
                                                                                    <?= htmlspecialchars($diaChi['tinh_thanh']) ?>
                                                                                </span>
                                                                            </p>
                                                                        </div>
                                                                        <div class="card-footer bg-light">
                                                                            <div class="btn-group btn-group-sm w-100" role="group">
                                                                                <a href="<?= BASE_URL ?>?act=sua-dia-chi&id=<?= $diaChi['id'] ?>" 
                                                                                   class="btn btn-outline-primary">
                                                                                    <i class="fa fa-edit"></i> Sửa
                                                                                </a>
                                                                                <?php if (!$diaChi['is_default']): ?>
                                                                                    <a href="<?= BASE_URL ?>?act=dat-dia-chi-mac-dinh&id=<?= $diaChi['id'] ?>" 
                                                                                       class="btn btn-outline-success">
                                                                                        <i class="fa fa-star"></i> Đặt mặc định
                                                                                    </a>
                                                                                <?php endif; ?>
                                                                                <a href="<?= BASE_URL ?>?act=xoa-dia-chi&id=<?= $diaChi['id'] ?>" 
                                                                                   class="btn btn-outline-danger"
                                                                                   onclick="return confirm('Bạn có chắc muốn xóa địa chỉ này?')">
                                                                                    <i class="fa fa-trash"></i> Xóa
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Address Management Content End -->
                                    </div>
                                </div>
                                <!-- My Account Tab Content End -->
                            </div>
                        </div>
                        <!-- My Account Page End -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- address management wrapper end -->
</main>

<!-- Custom CSS for Address Cards -->
<style>
.address-card {
    transition: all 0.3s ease;
    border: 1px solid #dee2e6;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.address-card:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    transform: translateY(-2px);
}

.address-card.border-primary {
    border-color: #007bff !important;
    box-shadow: 0 0 0 0.1rem rgba(0,123,255,0.25);
}

.badge {
    font-size: 0.75em;
}

.btn-group .btn {
    flex: 1;
    border-radius: 0;
}

.btn-group .btn:first-child {
    border-top-left-radius: 0.25rem;
    border-bottom-left-radius: 0.25rem;
}

.btn-group .btn:last-child {
    border-top-right-radius: 0.25rem;
    border-bottom-right-radius: 0.25rem;
}

.card-header h6 i {
    color: #007bff;
}

.card-body i {
    color: #6c757d;
    width: 15px;
    text-align: center;
}

.ml-3 {
    margin-left: 1rem;
}

.alert i {
    margin-right: 5px;
}

/* Custom styling for my account navigation */
.myaccount-tab-menu a {
    display: block;
    padding: 15px 20px;
    color: #333;
    text-decoration: none;
    border-bottom: 1px solid #eee;
    transition: all 0.3s ease;
}

.myaccount-tab-menu a:hover,
.myaccount-tab-menu a.active {
    background-color: #007bff;
    color: white;
    text-decoration: none;
}

.myaccount-tab-menu a i {
    margin-right: 10px;
    width: 20px;
    text-align: center;
}
</style>

<?php require_once 'layout/footer.php'; ?>
