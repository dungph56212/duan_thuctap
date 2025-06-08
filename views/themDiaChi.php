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
                                <li class="breadcrumb-item active" aria-current="page">Thêm địa chỉ mới</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->

    <!-- add address wrapper start -->
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

                                        <!-- Add Address Form Start -->
                                        <div class="tab-pane fade show active" role="tabpanel">
                                            <div class="myaccount-content">
                                                <div class="d-flex justify-content-between align-items-center mb-4">
                                                    <h5>Thêm địa chỉ mới</h5>
                                                    <a href="<?= BASE_URL ?>?act=quan-ly-dia-chi" class="btn btn-outline-secondary btn-sm">
                                                        <i class="fa fa-arrow-left"></i> Quay lại
                                                    </a>
                                                </div>

                                                <div class="billing-details">
                                                    <form action="<?= BASE_URL ?>?act=them-dia-chi" method="POST" id="addressForm">
                                                        <div class="row">
                                                            <!-- Personal Information -->
                                                            <div class="col-lg-12">
                                                                <h6 class="border-bottom pb-2 mb-4">
                                                                    <i class="fa fa-user text-primary"></i> Thông tin người nhận
                                                                </h6>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label for="ho_ten" class="required">Họ và tên</label>
                                                                    <input type="text" id="ho_ten" name="ho_ten" class="form-control" 
                                                                           placeholder="Nhập họ và tên" required
                                                                           value="<?= isset($_POST['ho_ten']) ? htmlspecialchars($_POST['ho_ten']) : '' ?>">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label for="so_dien_thoai" class="required">Số điện thoại</label>
                                                                    <input type="tel" id="so_dien_thoai" name="so_dien_thoai" class="form-control" 
                                                                           placeholder="Nhập số điện thoại" required pattern="[0-9]{10,11}"
                                                                           value="<?= isset($_POST['so_dien_thoai']) ? htmlspecialchars($_POST['so_dien_thoai']) : '' ?>">
                                                                </div>
                                                            </div>

                                                            <!-- Address Information -->
                                                            <div class="col-lg-12 mt-4">
                                                                <h6 class="border-bottom pb-2 mb-4">
                                                                    <i class="fa fa-map-marker text-primary"></i> Thông tin địa chỉ
                                                                </h6>
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <div class="single-input-item">
                                                                    <label for="tinh_thanh" class="required">Tỉnh/Thành phố</label>
                                                                    <select id="tinh_thanh" name="tinh_thanh" class="form-control" required>
                                                                        <option value="">Chọn Tỉnh/Thành phố</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <div class="single-input-item">
                                                                    <label for="quan_huyen" class="required">Quận/Huyện</label>
                                                                    <select id="quan_huyen" name="quan_huyen" class="form-control" required disabled>
                                                                        <option value="">Chọn Quận/Huyện</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <div class="single-input-item">
                                                                    <label for="phuong_xa" class="required">Phường/Xã</label>
                                                                    <select id="phuong_xa" name="phuong_xa" class="form-control" required disabled>
                                                                        <option value="">Chọn Phường/Xã</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-12">
                                                                <div class="single-input-item">
                                                                    <label for="dia_chi_chi_tiet" class="required">Địa chỉ chi tiết</label>
                                                                    <textarea id="dia_chi_chi_tiet" name="dia_chi_chi_tiet" class="form-control" 
                                                                              rows="3" placeholder="Số nhà, tên đường..." required><?= isset($_POST['dia_chi_chi_tiet']) ? htmlspecialchars($_POST['dia_chi_chi_tiet']) : '' ?></textarea>
                                                                </div>
                                                            </div>

                                                            <!-- Options -->
                                                            <div class="col-lg-12 mt-4">
                                                                <h6 class="border-bottom pb-2 mb-4">
                                                                    <i class="fa fa-cog text-primary"></i> Tùy chọn
                                                                </h6>
                                                            </div>

                                                            <div class="col-lg-12">
                                                                <div class="single-input-item">
                                                                    <div class="form-check">
                                                                        <input type="checkbox" id="is_default" name="is_default" 
                                                                               class="form-check-input" value="1"
                                                                               <?= isset($_POST['is_default']) ? 'checked' : '' ?>>
                                                                        <label for="is_default" class="form-check-label">
                                                                            Đặt làm địa chỉ mặc định
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Action Buttons -->
                                                            <div class="col-lg-12 mt-4">
                                                                <div class="single-input-item text-center">
                                                                    <button type="submit" class="btn btn-primary btn-lg mr-3" id="submitBtn">
                                                                        <i class="fa fa-plus"></i> Thêm địa chỉ
                                                                    </button>
                                                                    <a href="<?= BASE_URL ?>?act=quan-ly-dia-chi" class="btn btn-outline-secondary btn-lg">
                                                                        <i class="fa fa-times"></i> Hủy bỏ
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Add Address Form End -->
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
    <!-- add address wrapper end -->
</main>

<!-- Custom CSS for form styling -->
<style>
.single-input-item {
    margin-bottom: 20px;
}

.single-input-item label.required::after {
    content: " *";
    color: #e74c3c;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.address-card {
    transition: all 0.3s ease;
}

.address-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.billing-details h6 {
    color: #2c3e50;
    font-weight: 600;
}

.btn-loading {
    pointer-events: none;
    opacity: 0.65;
}

.btn-loading::after {
    content: "";
    display: inline-block;
    width: 1rem;
    height: 1rem;
    margin-left: 0.5rem;
    border: 2px solid transparent;
    border-top-color: currentColor;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.alert {
    border-radius: 0.5rem;
}

@media (max-width: 768px) {
    .myaccount-tab-menu {
        margin-bottom: 30px;
    }
    
    .single-input-item {
        margin-bottom: 15px;
    }
}
</style>

<!-- Vietnamese Provinces API Integration -->
<script>
// Initialize address form functionality
function initializeAddressForm() {
    console.log('Initializing address form...');
    
    // Check if jQuery is available, wait a bit if needed
    function checkJQuery(attempts = 0) {
        if (typeof jQuery !== 'undefined' && typeof $ !== 'undefined') {
            initializeWithJQuery();
        } else if (attempts < 10) {
            // Wait and try again
            setTimeout(() => checkJQuery(attempts + 1), 100);
        } else {
            console.log('jQuery not available after waiting, using vanilla JS');
            initializeWithVanillaJS();
        }
    }
    
    checkJQuery();
}

function initializeWithJQuery() {
    $(document).ready(function() {
        console.log('Address form script loaded with jQuery');
        
        // Load provinces on page load
        loadProvinces();
        
        // Province change event
        $('#tinh_thanh').on('change', function() {
            const provinceId = $(this).val();
            console.log('Province selected:', provinceId);
            if (provinceId) {
                loadDistricts(provinceId);
                // Reset and disable ward select
                $('#phuong_xa').html('<option value="">Chọn Phường/Xã</option>').prop('disabled', true);
            } else {
                // Reset both district and ward selects
                $('#quan_huyen').html('<option value="">Chọn Quận/Huyện</option>').prop('disabled', true);
                $('#phuong_xa').html('<option value="">Chọn Phường/Xã</option>').prop('disabled', true);
            }
        });
        
        // District change event
        $('#quan_huyen').on('change', function() {
            const districtId = $(this).val();
            console.log('District selected:', districtId);
            if (districtId) {
                loadWards(districtId);
            } else {
                $('#phuong_xa').html('<option value="">Chọn Phường/Xã</option>').prop('disabled', true);
            }
        });
        
        // Form validation and submission
        $('#addressForm').on('submit', function(e) {
            e.preventDefault();
            
            // Show loading state
            const submitBtn = $('#submitBtn');
            submitBtn.addClass('btn-loading').prop('disabled', true);
            
            // Validate form
            if (validateForm()) {
                // Submit form
                this.submit();
            } else {
                // Remove loading state
                submitBtn.removeClass('btn-loading').prop('disabled', false);
            }
        });
        
        // Load provinces function
        function loadProvinces() {
            console.log('Loading provinces...');
            $.ajax({
                url: 'https://provinces.open-api.vn/api/p/',
                type: 'GET',
                dataType: 'json',
                timeout: 10000,
                success: function(data) {
                    console.log('Provinces loaded:', data.length);
                    let options = '<option value="">Chọn Tỉnh/Thành phố</option>';
                    data.forEach(function(province) {
                        options += '<option value="' + province.code + '">' + province.name + '</option>';
                    });
                    $('#tinh_thanh').html(options);
                },
                error: function(xhr, status, error) {
                    console.error('Error loading provinces:', error);
                    showAlert('Không thể tải danh sách tỉnh/thành phố. Vui lòng thử lại!', 'danger');
                    // Fallback: Add some manual options
                    $('#tinh_thanh').html(`
                        <option value="">Chọn Tỉnh/Thành phố</option>
                        <option value="01">Hà Nội</option>
                        <option value="79">Thành phố Hồ Chí Minh</option>
                        <option value="48">Đà Nẵng</option>
                        <option value="92">Cần Thơ</option>
                    `);
                }
            });
        }
        
        // Load districts function
        function loadDistricts(provinceId) {
            console.log('Loading districts for province:', provinceId);
            $('#quan_huyen').html('<option value="">Đang tải...</option>').prop('disabled', true);
            
            $.ajax({
                url: 'https://provinces.open-api.vn/api/p/' + provinceId + '?depth=2',
                type: 'GET',
                dataType: 'json',
                timeout: 10000,
                success: function(data) {
                    console.log('Districts loaded:', data.districts.length);
                    let options = '<option value="">Chọn Quận/Huyện</option>';
                    data.districts.forEach(function(district) {
                        options += '<option value="' + district.code + '">' + district.name + '</option>';
                    });
                    $('#quan_huyen').html(options).prop('disabled', false);
                },
                error: function(xhr, status, error) {
                    console.error('Error loading districts:', error);
                    $('#quan_huyen').html('<option value="">Chọn Quận/Huyện</option>').prop('disabled', true);
                    showAlert('Không thể tải danh sách quận/huyện. Vui lòng thử lại!', 'danger');
                }
            });
        }
        
        // Load wards function
        function loadWards(districtId) {
            console.log('Loading wards for district:', districtId);
            $('#phuong_xa').html('<option value="">Đang tải...</option>').prop('disabled', true);
            
            $.ajax({
                url: 'https://provinces.open-api.vn/api/d/' + districtId + '?depth=2',
                type: 'GET',
                dataType: 'json',
                timeout: 10000,
                success: function(data) {
                    console.log('Wards loaded:', data.wards.length);
                    let options = '<option value="">Chọn Phường/Xã</option>';
                    data.wards.forEach(function(ward) {
                        options += '<option value="' + ward.code + '">' + ward.name + '</option>';
                    });
                    $('#phuong_xa').html(options).prop('disabled', false);
                },
                error: function(xhr, status, error) {
                    console.error('Error loading wards:', error);
                    $('#phuong_xa').html('<option value="">Chọn Phường/Xã</option>').prop('disabled', true);
                    showAlert('Không thể tải danh sách phường/xã. Vui lòng thử lại!', 'danger');
                }
            });
        }
        
        // Form validation function
        function validateForm() {
            let isValid = true;
            
            // Validate required fields
            const requiredFields = ['ho_ten', 'so_dien_thoai', 'tinh_thanh', 'quan_huyen', 'phuong_xa', 'dia_chi_chi_tiet'];
            
            requiredFields.forEach(function(fieldName) {
                const field = $('#' + fieldName);
                const value = field.val() ? field.val().trim() : '';
                
                if (!value) {
                    field.addClass('is-invalid');
                    isValid = false;
                } else {
                    field.removeClass('is-invalid');
                }
            });
            
            // Validate phone number
            const phoneRegex = /^[0-9]{10,11}$/;
            const phone = $('#so_dien_thoai').val() ? $('#so_dien_thoai').val().trim() : '';
            if (phone && !phoneRegex.test(phone)) {
                $('#so_dien_thoai').addClass('is-invalid');
                showAlert('Số điện thoại không hợp lệ. Vui lòng nhập 10-11 chữ số!', 'danger');
                isValid = false;
            }
            
            if (!isValid) {
                showAlert('Vui lòng điền đầy đủ thông tin bắt buộc!', 'danger');
            }
            
            return isValid;
        }
        
        // Show alert function
        function showAlert(message, type) {
            type = type || 'info';
            const alertHtml = '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
                message +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                '<span aria-hidden="true">&times;</span>' +
                '</button>' +
                '</div>';
            
            // Remove existing alerts
            $('.alert').remove();
            
            // Add new alert at the top of the form
            $('.myaccount-content').prepend(alertHtml);
            
            // Auto dismiss after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut();
            }, 5000);
            
            // Scroll to top to show alert
            $('html, body').animate({
                scrollTop: $('.alert').offset().top - 100
            }, 500);
        }
          });
    });
}

function initializeWithVanillaJS() {
    console.log('Initializing with vanilla JavaScript');
    
    // Load provinces function with vanilla JS
    function loadProvinces() {
        console.log('Loading provinces with vanilla JS...');
        fetch('https://provinces.open-api.vn/api/p/')
            .then(response => response.json())
            .then(data => {
                console.log('Provinces loaded:', data.length);
                const select = document.getElementById('tinh_thanh');
                let options = '<option value="">Chọn Tỉnh/Thành phố</option>';
                data.forEach(province => {
                    options += `<option value="${province.code}">${province.name}</option>`;
                });
                select.innerHTML = options;
            })
            .catch(error => {
                console.error('Error loading provinces:', error);
                // Add fallback options
                const select = document.getElementById('tinh_thanh');
                select.innerHTML = `
                    <option value="">Chọn Tỉnh/Thành phố</option>
                    <option value="01">Hà Nội</option>
                    <option value="79">Thành phố Hồ Chí Minh</option>
                    <option value="48">Đà Nẵng</option>
                    <option value="92">Cần Thơ</option>
                `;
            });
    }
    
    // Load districts function
    function loadDistricts(provinceId) {
        console.log('Loading districts for province:', provinceId);
        const districtSelect = document.getElementById('quan_huyen');
        districtSelect.innerHTML = '<option value="">Đang tải...</option>';
        districtSelect.disabled = true;
        
        fetch(`https://provinces.open-api.vn/api/p/${provinceId}?depth=2`)
            .then(response => response.json())
            .then(data => {
                console.log('Districts loaded:', data.districts.length);
                let options = '<option value="">Chọn Quận/Huyện</option>';
                data.districts.forEach(district => {
                    options += `<option value="${district.code}">${district.name}</option>`;
                });
                districtSelect.innerHTML = options;
                districtSelect.disabled = false;
            })
            .catch(error => {
                console.error('Error loading districts:', error);
                districtSelect.innerHTML = '<option value="">Chọn Quận/Huyện</option>';
                districtSelect.disabled = true;
            });
    }
    
    // Load wards function
    function loadWards(districtId) {
        console.log('Loading wards for district:', districtId);
        const wardSelect = document.getElementById('phuong_xa');
        wardSelect.innerHTML = '<option value="">Đang tải...</option>';
        wardSelect.disabled = true;
        
        fetch(`https://provinces.open-api.vn/api/d/${districtId}?depth=2`)
            .then(response => response.json())
            .then(data => {
                console.log('Wards loaded:', data.wards.length);
                let options = '<option value="">Chọn Phường/Xã</option>';
                data.wards.forEach(ward => {
                    options += `<option value="${ward.code}">${ward.name}</option>`;
                });
                wardSelect.innerHTML = options;
                wardSelect.disabled = false;
            })
            .catch(error => {
                console.error('Error loading wards:', error);
                wardSelect.innerHTML = '<option value="">Chọn Phường/Xã</option>';
                wardSelect.disabled = true;
            });
    }
    
    // Initialize
    loadProvinces();
    
    // Add event listeners
    document.getElementById('tinh_thanh').addEventListener('change', function() {
        const provinceId = this.value;
        console.log('Province selected:', provinceId);
        if (provinceId) {
            loadDistricts(provinceId);
            // Reset ward select
            document.getElementById('phuong_xa').innerHTML = '<option value="">Chọn Phường/Xã</option>';
            document.getElementById('phuong_xa').disabled = true;
        } else {
            // Reset both district and ward selects
            document.getElementById('quan_huyen').innerHTML = '<option value="">Chọn Quận/Huyện</option>';
            document.getElementById('quan_huyen').disabled = true;
            document.getElementById('phuong_xa').innerHTML = '<option value="">Chọn Phường/Xã</option>';
            document.getElementById('phuong_xa').disabled = true;
        }
    });
    
    document.getElementById('quan_huyen').addEventListener('change', function() {
        const districtId = this.value;
        console.log('District selected:', districtId);
        if (districtId) {
            loadWards(districtId);
        } else {
            document.getElementById('phuong_xa').innerHTML = '<option value="">Chọn Phường/Xã</option>';
            document.getElementById('phuong_xa').disabled = true;
        }
    });
}

// Wait for DOM to be ready and scripts to load
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeAddressForm);
} else {
    initializeAddressForm();
}
</script>