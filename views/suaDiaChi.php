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
                                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>?act=quan-ly-dia-chi">Quản lý địa chỉ</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Sửa địa chỉ</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->

    <!-- edit address wrapper start -->
    <div class="my-account-wrapper section-padding">
        <div class="container">
            <div class="section-bg-color">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Edit Address Page Start -->
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
                                        
                                        <!-- Error Messages -->
                                        <?php if (isset($_SESSION['errors'])): ?>
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Có lỗi xảy ra:</strong>
                                                <ul class="mb-0">
                                                    <?php foreach ($_SESSION['errors'] as $error): ?>
                                                        <li><?= $error ?></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                            </div>
                                            <?php unset($_SESSION['errors']); ?>
                                        <?php endif; ?>

                                        <!-- Edit Address Form Start -->
                                        <div class="tab-pane fade show active" role="tabpanel">
                                            <div class="myaccount-content">
                                                <h5>Sửa địa chỉ</h5>
                                                <div class="account-details-form">
                                                    <form action="<?= BASE_URL ?>?act=sua-dia-chi&id=<?= $diaChi['id'] ?>" method="post">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label for="ho_ten" class="required">Họ và tên</label>
                                                                    <input type="text" id="ho_ten" name="ho_ten" 
                                                                           value="<?= isset($_POST['ho_ten']) ? htmlspecialchars($_POST['ho_ten']) : htmlspecialchars($diaChi['ho_ten']) ?>" 
                                                                           placeholder="Nhập họ và tên" required />
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label for="so_dien_thoai" class="required">Số điện thoại</label>
                                                                    <input type="tel" id="so_dien_thoai" name="so_dien_thoai" 
                                                                           value="<?= isset($_POST['so_dien_thoai']) ? htmlspecialchars($_POST['so_dien_thoai']) : htmlspecialchars($diaChi['so_dien_thoai']) ?>" 
                                                                           placeholder="Nhập số điện thoại" required />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="single-input-item">
                                                                    <label for="tinh_thanh" class="required">Tỉnh/Thành phố</label>
                                                                    <select id="tinh_thanh" name="tinh_thanh" class="form-control" required>
                                                                        <option value="">Chọn Tỉnh/Thành phố</option>
                                                                        <?php 
                                                                        $currentProvince = isset($_POST['tinh_thanh']) ? $_POST['tinh_thanh'] : $diaChi['tinh_thanh'];
                                                                        $provinces = [
                                                                            'Hà Nội', 'TP. Hồ Chí Minh', 'Đà Nẵng', 'Hải Phòng', 'Cần Thơ',
                                                                            'An Giang', 'Bà Rịa - Vũng Tàu', 'Bắc Giang', 'Bắc Kạn', 'Bạc Liêu',
                                                                            'Bắc Ninh', 'Bến Tre', 'Bình Định', 'Bình Dương', 'Bình Phước',
                                                                            'Bình Thuận', 'Cà Mau', 'Cao Bằng', 'Đắk Lắk', 'Đắk Nông',
                                                                            'Điện Biên', 'Đồng Nai', 'Đồng Tháp', 'Gia Lai', 'Hà Giang',
                                                                            'Hà Nam', 'Hà Tĩnh', 'Hải Dương', 'Hậu Giang', 'Hòa Bình',
                                                                            'Hưng Yên', 'Khánh Hòa', 'Kiên Giang', 'Kon Tum', 'Lai Châu',
                                                                            'Lâm Đồng', 'Lạng Sơn', 'Lào Cai', 'Long An', 'Nam Định',
                                                                            'Nghệ An', 'Ninh Bình', 'Ninh Thuận', 'Phú Thọ', 'Phú Yên',
                                                                            'Quảng Bình', 'Quảng Nam', 'Quảng Ngãi', 'Quảng Ninh', 'Quảng Trị',
                                                                            'Sóc Trăng', 'Sơn La', 'Tây Ninh', 'Thái Bình', 'Thái Nguyên',
                                                                            'Thanh Hóa', 'Thừa Thiên Huế', 'Tiền Giang', 'Trà Vinh', 'Tuyên Quang',
                                                                            'Vĩnh Long', 'Vĩnh Phúc', 'Yên Bái'
                                                                        ];
                                                                        foreach ($provinces as $province): ?>
                                                                            <option value="<?= $province ?>" <?= ($currentProvince == $province) ? 'selected' : '' ?>>
                                                                                <?= $province ?>
                                                                            </option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                            </div>                                                            <div class="col-lg-4">
                                                                <div class="single-input-item">
                                                                    <label for="quan_huyen" class="required">Quận/Huyện</label>
                                                                    <select id="quan_huyen" name="quan_huyen" class="form-control" required>
                                                                        <option value="">Chọn Quận/Huyện</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="single-input-item">
                                                                    <label for="phuong_xa" class="required">Phường/Xã</label>
                                                                    <select id="phuong_xa" name="phuong_xa" class="form-control" required>
                                                                        <option value="">Chọn Phường/Xã</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="single-input-item">
                                                            <label for="dia_chi_chi_tiet" class="required">Địa chỉ chi tiết</label>
                                                            <textarea id="dia_chi_chi_tiet" name="dia_chi_chi_tiet" rows="3" 
                                                                      placeholder="Nhập địa chỉ chi tiết (số nhà, tên đường...)" required><?= isset($_POST['dia_chi_chi_tiet']) ? htmlspecialchars($_POST['dia_chi_chi_tiet']) : htmlspecialchars($diaChi['dia_chi_chi_tiet']) ?></textarea>
                                                        </div>

                                                        <div class="single-input-item">
                                                            <div class="form-check">
                                                                <?php 
                                                                $isDefault = isset($_POST['is_default']) ? $_POST['is_default'] : $diaChi['is_default'];
                                                                ?>
                                                                <input class="form-check-input" type="checkbox" id="is_default" name="is_default" value="1"
                                                                       <?= ($isDefault) ? 'checked' : '' ?>>
                                                                <label class="form-check-label" for="is_default">
                                                                    Đặt làm địa chỉ mặc định
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="single-input-item">
                                                            <button class="btn btn-primary" type="submit">
                                                                <i class="fa fa-save"></i> Cập nhật địa chỉ
                                                            </button>
                                                            <a href="<?= BASE_URL ?>?act=quan-ly-dia-chi" class="btn btn-secondary ms-2">
                                                                <i class="fa fa-times"></i> Hủy
                                                            </a>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Edit Address Form End -->
                                    </div>
                                </div>
                                <!-- My Account Tab Content End -->
                            </div>
                        </div>
                        <!-- Edit Address Page End -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- edit address wrapper end -->
</main>

<!-- Custom CSS -->
<style>
.required::after {
    content: " *";
    color: red;
}

.form-check {
    margin-top: 10px;
}

.form-check-input {
    margin-right: 8px;
}

.btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
}

.btn-secondary:hover {
    background-color: #5a6268;
    border-color: #545b62;
}
</style>

<!-- Vietnamese Provinces API Script -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$(document).ready(function() {
    // Lấy tỉnh thành
    $.getJSON('https://provinces.open-api.vn/api/p/', function(provinces) {
        provinces.forEach(function(province) {
            const selected = province.name === '<?= isset($_POST['tinh_thanh']) ? $_POST['tinh_thanh'] : $diaChi['tinh_thanh'] ?>' ? 'selected' : '';
            $("#tinh_thanh").append(`<option value="${province.name}" ${selected}>${province.name}</option>`);
        });
        
        // Trigger change event if there's a selected province
        if ($("#tinh_thanh").val()) {
            $("#tinh_thanh").trigger('change');
        }
    });

    // Xử lý khi chọn tỉnh
    $("#tinh_thanh").change(function() {
        const provinceName = $(this).val();
        
        // Tìm province code từ tên
        $.getJSON('https://provinces.open-api.vn/api/p/', function(provinces) {
            const selectedProvince = provinces.find(p => p.name === provinceName);
            if (selectedProvince) {
                // Lấy quận/huyện
                $.getJSON(`https://provinces.open-api.vn/api/p/${selectedProvince.code}?depth=2`, function(provinceData) {
                    $("#quan_huyen").html('<option value="">Chọn Quận/Huyện</option>');
                    provinceData.districts.forEach(function(district) {
                        const selected = district.name === '<?= isset($_POST['quan_huyen']) ? $_POST['quan_huyen'] : $diaChi['quan_huyen'] ?>' ? 'selected' : '';
                        $("#quan_huyen").append(`<option value="${district.name}" ${selected}>${district.name}</option>`);
                    });
                    $("#phuong_xa").html('<option value="">Chọn Phường/Xã</option>');
                    
                    // Trigger change event if there's a selected district
                    if ($("#quan_huyen").val()) {
                        $("#quan_huyen").trigger('change');
                    }
                });
            }
        });
    });

    // Xử lý khi chọn quận
    $("#quan_huyen").change(function() {
        const districtName = $(this).val();
        const provinceName = $("#tinh_thanh").val();
        
        // Tìm district code từ tên
        $.getJSON('https://provinces.open-api.vn/api/p/', function(provinces) {
            const selectedProvince = provinces.find(p => p.name === provinceName);
            if (selectedProvince) {
                $.getJSON(`https://provinces.open-api.vn/api/p/${selectedProvince.code}?depth=2`, function(provinceData) {
                    const selectedDistrict = provinceData.districts.find(d => d.name === districtName);
                    if (selectedDistrict) {
                        // Lấy phường/xã
                        $.getJSON(`https://provinces.open-api.vn/api/d/${selectedDistrict.code}?depth=2`, function(districtData) {
                            $("#phuong_xa").html('<option value="">Chọn Phường/Xã</option>');
                            districtData.wards.forEach(function(ward) {
                                const selected = ward.name === '<?= isset($_POST['phuong_xa']) ? $_POST['phuong_xa'] : $diaChi['phuong_xa'] ?>' ? 'selected' : '';
                                $("#phuong_xa").append(`<option value="${ward.name}" ${selected}>${ward.name}</option>`);
                            });
                        });
                    }
                });
            }
        });
    });
});
</script>

<!-- Custom CSS for Edit Address Page -->
<style>
/* Custom styling for my account navigation */
.myaccount-tab-menu a {
    display: block;
    padding: 15px 20px;
    color: #333;
    text-decoration: none;
    border-bottom: 1px solid #eee;
    transition: all 0.3s ease;
    border-radius: 0;
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

/* Form styling */
.single-input-item {
    margin-bottom: 25px;
}

.single-input-item label {
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
    display: block;
}

.single-input-item input,
.single-input-item select {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid #e1e8ed;
    border-radius: 5px;
    font-size: 14px;
    transition: border-color 0.3s ease;
    background-color: #fff;
}

.single-input-item input:focus,
.single-input-item select:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
}

.single-input-item input.is-invalid,
.single-input-item select.is-invalid {
    border-color: #dc3545;
}

.single-input-item .invalid-feedback {
    display: block;
    color: #dc3545;
    font-size: 12px;
    margin-top: 5px;
}

/* Button styling */
.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    padding: 12px 30px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
    padding: 12px 30px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    background-color: #545b62;
    border-color: #545b62;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

/* Card styling */
.myaccount-content {
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0,0,0,0.08);
}

.myaccount-content h5 {
    color: #333;
    font-weight: 700;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f8f9fa;
}

/* Alert styling */
.alert {
    border-radius: 8px;
    border: none;
    padding: 15px 20px;
    margin-bottom: 25px;
    font-weight: 500;
}

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
}

/* Loading animation for select fields */
.loading-select {
    background-image: url('data:image/svg+xml;charset=utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%23007bff"><circle cx="12" cy="12" r="10" stroke="%23007bff" stroke-width="2" fill="none" stroke-dasharray="31.416" stroke-dashoffset="31.416"><animate attributeName="stroke-dasharray" dur="2s" values="0 31.416;15.708 15.708;0 31.416" repeatCount="indefinite"/><animate attributeName="stroke-dashoffset" dur="2s" values="0;-15.708;-31.416" repeatCount="indefinite"/></circle></svg>');
    background-repeat: no-repeat;
    background-position: right 10px center;
    background-size: 20px;
}

/* Responsive design */
@media (max-width: 768px) {
    .myaccount-tab-menu {
        margin-bottom: 30px;
    }
    
    .myaccount-content {
        padding: 20px;
    }
    
    .btn-primary,
    .btn-secondary {
        width: 100%;
        margin-bottom: 10px;
    }
}

/* Animation for form */
.single-input-item {
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInUp 0.5s ease forwards;
}

.single-input-item:nth-child(1) { animation-delay: 0.1s; }
.single-input-item:nth-child(2) { animation-delay: 0.2s; }
.single-input-item:nth-child(3) { animation-delay: 0.3s; }
.single-input-item:nth-child(4) { animation-delay: 0.4s; }
.single-input-item:nth-child(5) { animation-delay: 0.5s; }
.single-input-item:nth-child(6) { animation-delay: 0.6s; }

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<?php require_once 'layout/footer.php'; ?>
