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
                                <li class="breadcrumb-item active" aria-current="page">Thông tin tài khoản</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->

    <!-- my account wrapper start -->
    <div class="my-account-wrapper section-padding">
        <div class="container">
            <div class="section-bg-color">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- My Account Page Start -->
                        <div class="myaccount-page-wrapper">
                            <!-- My Account Tab Menu Start -->
                            <div class="row">
                                <div class="col-lg-3 col-md-4">                                    <div class="myaccount-tab-menu nav" role="tablist">
                                        <a href="#dashboad" class="active" data-bs-toggle="tab"><i class="fa fa-dashboard"></i>
                                            Bảng điều khiển</a>
                                        <a href="#orders" data-bs-toggle="tab"><i class="fa fa-cart-arrow-down"></i> Đơn hàng</a>
                                        <a href="#account-info" data-bs-toggle="tab"><i class="fa fa-user"></i> Thông tin tài khoản</a>
                                        <a href="<?= BASE_URL ?>?act=quan-ly-dia-chi"><i class="fa fa-map-marker"></i> Quản lý địa chỉ</a>
                                        <a href="#change-password" data-bs-toggle="tab"><i class="fa fa-key"></i> Đổi mật khẩu</a>
                                        <a href="<?= BASE_URL . '?act=logout' ?>"><i class="fa fa-sign-out"></i> Đăng xuất</a>
                                    </div>
                                </div>
                                <!-- My Account Tab Menu End -->                                <!-- My Account Tab Content Start -->
                                <div class="col-lg-9 col-md-8">
                                    <div class="tab-content" id="myaccountContent">
                                        
                                        <!-- Success/Error Messages -->
                                        <?php if (isset($_SESSION['success'])): ?>
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <?= $_SESSION['success'] ?>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                            <?php unset($_SESSION['success']); ?>
                                        <?php endif; ?>

                                        <?php if (isset($_SESSION['error'])): ?>
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <?= $_SESSION['error'] ?>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                            <?php unset($_SESSION['error']); ?>
                                        <?php endif; ?>

                                        <?php if (isset($_SESSION['errors'])): ?>
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <ul class="mb-0">
                                                    <?php foreach ($_SESSION['errors'] as $error): ?>
                                                        <li><?= $error ?></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                            <?php unset($_SESSION['errors']); ?>
                                        <?php endif; ?>
                                        
                                        <!-- Single Tab Content Start -->
                                        <div class="tab-pane fade show active" id="dashboad" role="tabpanel">
                                            <div class="myaccount-content">
                                                <h5>Bảng điều khiển</h5>
                                                <div class="welcome-text">
                                                    <p>Xin chào <strong><?= isset($_SESSION['user_client']) ? $_SESSION['user_client']['ho_ten'] : 'Khách hàng' ?></strong>! 
                                                    Từ bảng điều khiển tài khoản của bạn, bạn có thể xem các đơn hàng gần đây, 
                                                    quản lý địa chỉ giao hàng và thanh toán, và chỉnh sửa mật khẩu cũng như chi tiết tài khoản của bạn.</p>
                                                </div>
                                                
                                                <!-- Dashboard Statistics -->
                                                <div class="row mt-4">
                                                    <div class="col-md-4">
                                                        <div class="dashboard-stat-card">
                                                            <div class="card-body text-center">
                                                                <i class="fa fa-shopping-cart fa-2x text-primary mb-2"></i>
                                                                <h5>Tổng đơn hàng</h5>
                                                                <h3 class="text-primary"><?= isset($tongDonHang) ? $tongDonHang : 0 ?></h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="dashboard-stat-card">
                                                            <div class="card-body text-center">
                                                                <i class="fa fa-check-circle fa-2x text-success mb-2"></i>
                                                                <h5>Đã hoàn thành</h5>
                                                                <h3 class="text-success"><?= isset($donHangHoanThanh) ? $donHangHoanThanh : 0 ?></h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="dashboard-stat-card">
                                                            <div class="card-body text-center">
                                                                <i class="fa fa-clock-o fa-2x text-warning mb-2"></i>
                                                                <h5>Đang xử lý</h5>
                                                                <h3 class="text-warning"><?= isset($donHangDangXuLy) ? $donHangDangXuLy : 0 ?></h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Single Tab Content End -->

                                        <!-- Single Tab Content Start -->
                                        <div class="tab-pane fade" id="orders" role="tabpanel">
                                            <div class="myaccount-content">
                                                <h5>Đơn hàng của tôi</h5>
                                                <div class="myaccount-table table-responsive text-center">
                                                    <table class="table table-bordered">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th>Mã đơn hàng</th>
                                                                <th>Ngày đặt</th>
                                                                <th>Trạng thái</th>
                                                                <th>Tổng tiền</th>
                                                                <th>Hành động</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (isset($listDonHang) && !empty($listDonHang)): ?>
                                                                <?php foreach ($listDonHang as $donHang): ?>
                                                                    <tr>
                                                                        <td>#<?= $donHang['ma_don_hang'] ?></td>
                                                                        <td><?= date('d/m/Y', strtotime($donHang['ngay_dat'])) ?></td>
                                                                        <td>
                                                                            <span class="badge badge-<?= $donHang['trang_thai_id'] == 1 ? 'warning' : ($donHang['trang_thai_id'] == 2 ? 'success' : 'danger') ?>">
                                                                                <?= $donHang['ten_trang_thai'] ?>
                                                                            </span>
                                                                        </td>
                                                                        <td><?= number_format($donHang['tong_tien'], 0, ',', '.') ?>đ</td>
                                                                        <td>
                                                                            <a href="<?= BASE_URL . '?act=chi-tiet-mua-hang&id=' . $donHang['id'] ?>" class="btn btn-primary btn-sm">
                                                                                Xem chi tiết
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            <?php else: ?>
                                                                <tr>
                                                                    <td colspan="5">Chưa có đơn hàng nào</td>
                                                                </tr>
                                                            <?php endif; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Single Tab Content End -->

                                        <!-- Single Tab Content Start -->
                                        <div class="tab-pane fade" id="account-info" role="tabpanel">
                                            <div class="myaccount-content">
                                                <h5>Thông tin tài khoản</h5>
                                                <div class="account-details-form">
                                                    <form action="<?= BASE_URL . '?act=cap-nhat-thong-tin' ?>" method="post">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label for="ho_ten" class="required">Họ và tên</label>
                                                                    <input type="text" id="ho_ten" name="ho_ten" 
                                                                           value="<?= isset($_SESSION['user_client']) ? $_SESSION['user_client']['ho_ten'] : '' ?>" 
                                                                           required />
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label for="email" class="required">Email</label>
                                                                    <input type="email" id="email" name="email" 
                                                                           value="<?= isset($_SESSION['user_client']) ? $_SESSION['user_client']['email'] : '' ?>" 
                                                                           required />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label for="so_dien_thoai">Số điện thoại</label>                                                                    <input type="text" id="so_dien_thoai" name="so_dien_thoai" 
                                                                           value="<?= isset($_SESSION['user_client']['so_dien_thoai']) ? $_SESSION['user_client']['so_dien_thoai'] : '' ?>" />
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label for="ngay_sinh">Ngày sinh</label>                                                                    <input type="date" id="ngay_sinh" name="ngay_sinh" 
                                                                           value="<?= isset($_SESSION['user_client']['ngay_sinh']) ? $_SESSION['user_client']['ngay_sinh'] : '' ?>" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="single-input-item">
                                                            <label for="dia_chi">Địa chỉ</label>
                                                            <textarea id="dia_chi" name="dia_chi" rows="3" placeholder="Nhập địa chỉ của bạn"><?= isset($_SESSION['user_client']['dia_chi']) ? $_SESSION['user_client']['dia_chi'] : '' ?></textarea>
                                                        </div>
                                                        <div class="single-input-item">
                                                            <button class="btn btn-primary" type="submit">Cập nhật thông tin</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Single Tab Content End -->

                                        <!-- Single Tab Content Start -->
                                        <div class="tab-pane fade" id="change-password" role="tabpanel">
                                            <div class="myaccount-content">
                                                <h5>Đổi mật khẩu</h5>
                                                <div class="account-details-form">
                                                    <form action="<?= BASE_URL . '?act=doi-mat-khau' ?>" method="post">
                                                        <div class="single-input-item">
                                                            <label for="current-pwd" class="required">Mật khẩu hiện tại</label>
                                                            <input type="password" id="current-pwd" name="mat_khau_cu" required />
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label for="new-pwd" class="required">Mật khẩu mới</label>
                                                                    <input type="password" id="new-pwd" name="mat_khau_moi" required />
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label for="confirm-pwd" class="required">Xác nhận mật khẩu mới</label>
                                                                    <input type="password" id="confirm-pwd" name="xac_nhan_mat_khau" required />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="single-input-item">
                                                            <button class="btn btn-primary" type="submit">Đổi mật khẩu</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Single Tab Content End -->
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
    <!-- my account wrapper end -->
</main>

<style>
.my-account-wrapper {
    padding: 80px 0;
}

.section-bg-color {
    background-color: #f8f9fa;
    padding: 40px;
    border-radius: 10px;
}

.myaccount-tab-menu {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    padding: 20px 0;
}

.myaccount-tab-menu a {
    display: block;
    padding: 15px 25px;
    color: #333;
    text-decoration: none;
    border-bottom: 1px solid #eee;
    transition: all 0.3s ease;
}

.myaccount-tab-menu a:hover,
.myaccount-tab-menu a.active {
    background-color: #007bff;
    color: #fff;
    border-color: #007bff;
}

.myaccount-tab-menu a i {
    margin-right: 10px;
    width: 20px;
}

.tab-content {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    padding: 30px;
}

.myaccount-content h5 {
    margin-bottom: 20px;
    color: #333;
    font-weight: 600;
}

.dashboard-stat-card {
    background-color: #f8f9fa;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.dashboard-stat-card:hover {
    transform: translateY(-5px);
}

.single-input-item {
    margin-bottom: 20px;
}

.single-input-item label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #333;
}

.single-input-item label.required:after {
    content: ' *';
    color: #e74c3c;
}

.single-input-item input,
.single-input-item textarea {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
    transition: border-color 0.3s ease;
}

.single-input-item input:focus,
.single-input-item textarea:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 2px rgba(0,123,255,0.25);
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    padding: 12px 30px;
    border-radius: 5px;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
    transform: translateY(-1px);
}

.table {
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.table thead th {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 15px;
    font-weight: 500;
}

.table tbody td {
    padding: 15px;
    vertical-align: middle;
}

.badge {
    padding: 5px 10px;
    border-radius: 15px;
    font-size: 12px;
}

.badge-warning {
    background-color: #ffc107;
    color: #212529;
}

.badge-success {
    background-color: #28a745;
    color: #fff;
}

.badge-danger {
    background-color: #dc3545;
    color: #fff;
}

.welcome-text {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    border-left: 4px solid #007bff;
}

@media (max-width: 768px) {
    .my-account-wrapper {
        padding: 40px 0;
    }
    
    .section-bg-color {
        padding: 20px;
    }
    
    .myaccount-tab-menu {
        margin-bottom: 20px;
    }
    
    .dashboard-stat-card {
        margin-bottom: 15px;
    }
}
</style>

<script>
// Tab switching functionality
document.addEventListener('DOMContentLoaded', function() {
    // Bootstrap tab functionality
    const tabLinks = document.querySelectorAll('.myaccount-tab-menu a[data-bs-toggle="tab"]');
    tabLinks.forEach(function(tabLink) {
        tabLink.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all tabs
            tabLinks.forEach(link => link.classList.remove('active'));
            document.querySelectorAll('.tab-pane').forEach(pane => {
                pane.classList.remove('show', 'active');
            });
            
            // Add active class to clicked tab
            this.classList.add('active');
            
            // Show corresponding tab content
            const targetId = this.getAttribute('href').substring(1);
            const targetPane = document.getElementById(targetId);
            if (targetPane) {
                targetPane.classList.add('show', 'active');
            }
        });
    });
    
    // Form validation
    const passwordForm = document.querySelector('form[action*="doi-mat-khau"]');
    if (passwordForm) {
        passwordForm.addEventListener('submit', function(e) {
            const newPassword = document.getElementById('new-pwd').value;
            const confirmPassword = document.getElementById('confirm-pwd').value;
            
            if (newPassword !== confirmPassword) {
                e.preventDefault();
                alert('Mật khẩu mới và xác nhận mật khẩu không khớp!');
            }
            
            if (newPassword.length < 6) {
                e.preventDefault();
                alert('Mật khẩu mới phải có ít nhất 6 ký tự!');
            }
        });
    }
});
</script>

<?php require_once 'layout/miniCart.php'; ?>
<?php require_once 'layout/footer.php'; ?>
