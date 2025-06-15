<?php require_once 'layout/header.php';  ?>
<?php require_once 'layout/menu.php';  ?>
<main>    <!-- breadcrumb area start -->
    <div class="breadcrumb-area" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 60px 0;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb" style="background: transparent; margin-bottom: 0; padding: 0;">
                                <li class="breadcrumb-item">
                                    <a href="<?= BASE_URL ?>" style="color: #007bff; text-decoration: none;">
                                        <i class="fa fa-home"></i> Trang chủ
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="#" style="color: #6c757d; text-decoration: none;">Mua sắm</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page" style="color: #495057; font-weight: 600;">
                                    Thanh toán
                                </li>
                            </ul>
                        </nav>
                        <h1 style="color: #212529; font-size: 2.5rem; font-weight: 700; margin-top: 20px; margin-bottom: 10px;">
                            <i class="fa fa-credit-card" style="color: #007bff; margin-right: 15px;"></i>
                            Thanh toán đơn hàng
                        </h1>
                        <p style="color: #6c757d; font-size: 1.1rem; margin-bottom: 0;">
                            Hoàn tất thông tin và thanh toán để nhận hàng
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->    <!-- checkout main wrapper start -->
    <div class="checkout-page-wrapper section-padding" style="background: #ffffff; padding: 80px 0;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Checkout Login Coupon Accordion Start -->
                    <div class="checkoutaccordion" id="checkOutAccordion" style="background: #ffffff; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); padding: 30px; margin-bottom: 40px;">
                        <div class="card" style="border: none; background: linear-gradient(135deg, #f8f9fa, #e9ecef); border-radius: 12px; padding: 20px;">
                            <h6 style="color: #495057; font-weight: 600; margin-bottom: 15px; font-size: 1.1rem;">
                                <i class="fa fa-gift" style="color: #007bff; margin-right: 10px;"></i>
                                Thêm mã giảm giá 
                                <span data-bs-toggle="collapse" data-bs-target="#couponaccordion" style="color: #007bff; cursor: pointer; text-decoration: underline; font-size: 14px;">
                                    Click để nhập mã giảm giá
                                </span>
                            </h6>                            <div id="couponaccordion" class="collapse" data-parent="#checkOutAccordion">
                                <div class="card-body" style="background: white; border-radius: 8px; padding: 20px; margin-top: 15px;">
                                    <div class="cart-update-option">
                                        <div class="apply-coupon-wrapper">
                                            <!-- Hiển thị mã giảm giá đã áp dụng -->
                                            <?php if (isset($_SESSION['ma_giam_gia'])): ?>
                                                <div class="applied-coupon" style="background: #d4edda; border: 1px solid #c3e6cb; border-radius: 8px; padding: 15px; margin-bottom: 15px;">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <strong style="color: #155724;">
                                                                <i class="fa fa-tag" style="margin-right: 5px;"></i>
                                                                <?= $_SESSION['ma_giam_gia']['ma_khuyen_mai'] ?>
                                                            </strong>
                                                            <div style="color: #155724; font-size: 13px; margin-top: 2px;">
                                                                <?= $_SESSION['ma_giam_gia']['ten_khuyen_mai'] ?>
                                                            </div>
                                                        </div>
                                                        <a href="<?= BASE_URL ?>?act=xoa-ma-giam-gia" 
                                                           style="color: #dc3545; text-decoration: none; font-size: 18px; padding: 5px;"
                                                           onclick="return confirm('Bạn có muốn hủy mã giảm giá này?')">
                                                            <i class="fa fa-times"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <form action="<?= BASE_URL ?>?act=ap-dung-ma-giam-gia" method="post" class="d-block d-md-flex align-items-center">
                                                    <input type="text" name="ma_giam_gia" placeholder="Nhập mã giảm giá" required style="border: 2px solid #e9ecef; border-radius: 8px; padding: 12px 15px; margin-right: 15px; background: white; outline: none; font-size: 14px; flex: 1; transition: all 0.3s ease;" />
                                                    <button class="btn btn-sqr" type="submit" style="background: linear-gradient(135deg, #28a745, #20c997); color: white; border: none; padding: 12px 25px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">
                                                        <i class="fa fa-check" style="margin-right: 8px;"></i>
                                                        Áp dụng mã
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Checkout Login Coupon Accordion End -->
                </div>
            </div>            <form action="<?= BASE_URL . '?act=xu-ly-thanh-toan' ?>" method="POST">
            <div class="row">
                <!-- Checkout Billing Details -->
                <div class="col-lg-6">
                    <div class="checkout-billing-details-wrap" style="background: #ffffff; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); padding: 40px; margin-bottom: 40px;">
                        <h5 class="checkout-title" style="color: #495057; font-weight: 700; margin-bottom: 30px; font-size: 1.5rem; border-bottom: 3px solid #007bff; padding-bottom: 15px;">
                            <i class="fa fa-user" style="color: #007bff; margin-right: 10px;"></i>
                            Thông tin người nhận
                        </h5>
                        <div class="billing-form-wrap">
                            <div class="single-input-item" style="margin-bottom: 25px;">
                                <label for="ten_nguoi_nhan" class="required" style="color: #495057; font-weight: 600; margin-bottom: 10px; display: block; font-size: 15px;">
                                    <i class="fa fa-user-circle" style="color: #007bff; margin-right: 8px;"></i>
                                    Tên người nhận
                                </label>
                                <input type="text" id="ten_nguoi_nhan" name="ten_nguoi_nhan" value="<?= $user['ho_ten'] ?>" placeholder="Nhập tên người nhận" required style="width: 100%; border: 2px solid #e9ecef; border-radius: 8px; padding: 15px; font-size: 14px; background: #f8f9fa; outline: none; transition: all 0.3s ease;" />
                            </div>

                            <div class="single-input-item" style="margin-bottom: 25px;">
                                <label for="email_nguoi_nhan" class="required" style="color: #495057; font-weight: 600; margin-bottom: 10px; display: block; font-size: 15px;">
                                    <i class="fa fa-envelope" style="color: #007bff; margin-right: 8px;"></i>
                                    Địa chỉ email
                                </label>
                                <input type="email" id="email_nguoi_nhan" name="email_nguoi_nhan" value="<?= $user['email'] ?>" placeholder="Nhập địa chỉ email" required style="width: 100%; border: 2px solid #e9ecef; border-radius: 8px; padding: 15px; font-size: 14px; background: #f8f9fa; outline: none; transition: all 0.3s ease;" />
                            </div>

                            <div class="single-input-item" style="margin-bottom: 25px;">
                                <label for="sdt_nguoi_nhan" class="required" style="color: #495057; font-weight: 600; margin-bottom: 10px; display: block; font-size: 15px;">
                                    <i class="fa fa-phone" style="color: #007bff; margin-right: 8px;"></i>
                                    Số điện thoại
                                </label>
                                <input type="tel" id="sdt_nguoi_nhan" name="sdt_nguoi_nhan" value="<?= $user['so_dien_thoai'] ?>" placeholder="Nhập số điện thoại" required style="width: 100%; border: 2px solid #e9ecef; border-radius: 8px; padding: 15px; font-size: 14px; background: #f8f9fa; outline: none; transition: all 0.3s ease;" />
                            </div>

                            <div class="single-input-item" style="margin-bottom: 25px;">
                                <label for="dia_chi_nguoi_nhan" class="required" style="color: #495057; font-weight: 600; margin-bottom: 10px; display: block; font-size: 15px;">
                                    <i class="fa fa-map-marker" style="color: #007bff; margin-right: 8px;"></i>
                                    Địa chỉ người nhận
                                </label>
                                <input type="text" id="dia_chi_nguoi_nhan" name="dia_chi_nguoi_nhan" value="<?= $user['dia_chi'] ?>" placeholder="Nhập địa chỉ người nhận" required style="width: 100%; border: 2px solid #e9ecef; border-radius: 8px; padding: 15px; font-size: 14px; background: #f8f9fa; outline: none; transition: all 0.3s ease;" />
                            </div>

                            <div class="single-input-item" style="margin-bottom: 25px;">
                                <label for="ghi_chu" style="color: #495057; font-weight: 600; margin-bottom: 10px; display: block; font-size: 15px;">
                                    <i class="fa fa-comment" style="color: #007bff; margin-right: 8px;"></i>
                                    Ghi chú (Tùy chọn)
                                </label>
                                <textarea name="ghi_chu" id="ghi_chu" cols="30" rows="4" placeholder="Nhập ghi chú đặc biệt cho đơn hàng của bạn..." style="width: 100%; border: 2px solid #e9ecef; border-radius: 8px; padding: 15px; font-size: 14px; background: #f8f9fa; outline: none; resize: vertical; transition: all 0.3s ease; line-height: 1.6;"></textarea>
                            </div>
                        </div>
                    </div>
                </div>                <!-- Order Summary Details -->
                <div class="col-lg-6">
                    <div class="order-summary-details" style="background: #ffffff; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); padding: 40px; margin-bottom: 40px;">
                        <h5 class="checkout-title" style="color: #495057; font-weight: 700; margin-bottom: 30px; font-size: 1.5rem; border-bottom: 3px solid #007bff; padding-bottom: 15px;">
                            <i class="fa fa-shopping-bag" style="color: #007bff; margin-right: 10px;"></i>
                            Thông tin sản phẩm
                        </h5>
                        <div class="order-summary-content">
                            <!-- Order Summary Table -->
                            <div class="order-summary-table table-responsive text-center" style="background: #f8f9fa; border-radius: 12px; padding: 20px; margin-bottom: 30px;">
                                <table class="table table-bordered" style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                                    <thead style="background: linear-gradient(135deg, #007bff, #0056b3); color: white;">
                                        <tr>
                                            <th style="border: none; padding: 20px; font-weight: 600;">
                                                <i class="fa fa-tag" style="margin-right: 8px;"></i>Sản phẩm
                                            </th>
                                            <th style="border: none; padding: 20px; font-weight: 600;">
                                                <i class="fa fa-calculator" style="margin-right: 8px;"></i>Tổng
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>                                        <?php
                                        $tongGioHang = 0;
                                        foreach ($chiTietGioHang as $key => $sanPham):
                                        ?>
                                            <tr style="transition: all 0.3s ease;">
                                                <td style="border: 1px solid #e9ecef; padding: 15px; text-align: left;">
                                                    <a href="" style="color: #495057; font-weight: 600; text-decoration: none; transition: color 0.3s ease;">
                                                        <i class="fa fa-book" style="color: #007bff; margin-right: 8px;"></i>
                                                        <?= $sanPham['ten_san_pham'] ?> 
                                                        <strong style="color: #007bff;"> × <?=$sanPham['so_luong']?></strong>
                                                    </a>
                                                </td>
                                                <td style="border: 1px solid #e9ecef; padding: 15px; color: #28a745; font-weight: 700; font-size: 1.1rem;">
                                                    <?php
                                                    $tongTien = 0;
                                                    if ($sanPham['gia_khuyen_mai']) {
                                                        $tongTien = $sanPham['gia_khuyen_mai'] * $sanPham['so_luong'];
                                                    }else{
                                                        $tongTien = $sanPham['gia_san_pham'] * $sanPham['so_luong'];
                                                    }
                                                    $tongGioHang += $tongTien;
                                                    echo formatPrice($tongTien) .'đ';
                                                     ?>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>                                    </tbody>
                                    <tfoot>
                                        <tr style="background: #f8f9fa;">
                                            <td style="border: 1px solid #e9ecef; padding: 15px; color: #495057; font-weight: 600;">
                                                <i class="fa fa-shopping-bag" style="color: #007bff; margin-right: 8px;"></i>
                                                Tổng tiền sản phẩm
                                            </td>
                                            <td style="border: 1px solid #e9ecef; padding: 15px;">
                                                <strong style="color: #007bff; font-size: 1.2rem;"><?=formatPrice($tongGioHang).'đ' ?></strong>
                                            </td>
                                        </tr>                                        <?php if (isset($_SESSION['ma_giam_gia'])): 
                                            $discount = 0;
                                            if ($_SESSION['ma_giam_gia']['phan_tram_giam'] > 0) {
                                                $discount = $tongGioHang * ($_SESSION['ma_giam_gia']['phan_tram_giam'] / 100);
                                            } else {
                                                $discount = $_SESSION['ma_giam_gia']['gia_giam'];
                                            }
                                            $discount = min($discount, $tongGioHang);
                                        ?>
                                        <tr style="background: #d4edda;">
                                            <td style="border: 1px solid #c3e6cb; padding: 15px; color: #155724; font-weight: 600;">
                                                <i class="fa fa-gift" style="color: #28a745; margin-right: 8px;"></i>
                                                Giảm giá (<?= $_SESSION['ma_giam_gia']['ma_khuyen_mai'] ?>)
                                            </td>
                                            <td style="border: 1px solid #c3e6cb; padding: 15px;">
                                                <strong style="color: #28a745; font-size: 1.2rem;">-<?= formatPrice($discount) . 'đ' ?></strong>
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <tr style="background: #f8f9fa;">
                                            <td style="border: 1px solid #e9ecef; padding: 15px; color: #495057; font-weight: 600;">
                                                <i class="fa fa-truck" style="color: #28a745; margin-right: 8px;"></i>
                                                Phí vận chuyển
                                            </td>
                                            <td class="d-flex justify-content-center" style="border: 1px solid #e9ecef; padding: 15px;">
                                                <strong style="color: #28a745; font-size: 1.2rem;">30.000đ</strong>
                                            </td>
                                        </tr>
                                        <tr style="background: linear-gradient(135deg, #007bff, #0056b3); color: white;">
                                            <td style="border: none; padding: 20px; font-weight: 700; font-size: 1.2rem;">
                                                <i class="fa fa-money" style="margin-right: 8px;"></i>
                                                Tổng đơn hàng
                                            </td>
                                            <?php 
                                            $finalTotal = $tongGioHang + 30000;
                                            if (isset($_SESSION['ma_giam_gia'])) {
                                                $finalTotal -= $discount;
                                            }
                                            ?>
                                            <input type="hidden" name="tong_tien" value="<?= $finalTotal ?>">
                                            <input type="hidden" name="ma_khuyen_mai_id" value="<?= isset($_SESSION['ma_giam_gia']) ? $_SESSION['ma_giam_gia']['id'] : '' ?>">
                                            <td style="border: none; padding: 20px;">
                                                <strong style="font-size: 1.4rem;"><?= formatPrice($finalTotal) . 'đ' ?></strong>
                                            </td>
                                        </tr>
                                    </tfoot>                                </table>
                            </div>
                            <!-- Order Payment Method -->
                            <div class="order-payment-method">
                                <h6 style="color: #495057; font-weight: 600; margin-bottom: 20px; font-size: 1.2rem;">
                                    <i class="fa fa-credit-card" style="color: #007bff; margin-right: 10px;"></i>
                                    Phương thức thanh toán
                                </h6>
                                
                                <div class="single-payment-method show" style="background: #f8f9fa; border-radius: 10px; padding: 20px; margin-bottom: 15px; border: 2px solid #e9ecef; transition: all 0.3s ease;">
                                    <div class="payment-method-name">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="cashon" name="phuong_thuc_thanh_toan_id" value="1" class="custom-control-input" checked />
                                            <label class="custom-control-label" for="cashon" style="color: #495057; font-weight: 600; cursor: pointer; font-size: 15px;">
                                                <i class="fa fa-money" style="color: #28a745; margin-right: 10px;"></i>
                                                Thanh toán khi nhận hàng (COD)
                                            </label>
                                        </div>
                                    </div>
                                    <div class="payment-method-details" data-method="cash" style="margin-top: 10px; padding: 15px; background: white; border-radius: 8px; border-left: 4px solid #28a745;">
                                        <p style="color: #6c757d; margin: 0; line-height: 1.6;">
                                            <i class="fa fa-info-circle" style="color: #17a2b8; margin-right: 8px;"></i>
                                            Khách hàng có thể thanh toán khi đã nhận hàng thành công (cần xác thực đơn hàng)
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="single-payment-method" style="background: #f8f9fa; border-radius: 10px; padding: 20px; margin-bottom: 20px; border: 2px solid #e9ecef; transition: all 0.3s ease;">
                                    <div class="payment-method-name">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="directbank" name="phuong_thuc_thanh_toan_id" value="2" class="custom-control-input" />
                                            <label class="custom-control-label" for="directbank" style="color: #495057; font-weight: 600; cursor: pointer; font-size: 15px;">
                                                <i class="fa fa-credit-card" style="color: #007bff; margin-right: 10px;"></i>
                                                Thanh toán online
                                            </label>
                                        </div>
                                    </div>
                                    <div class="payment-method-details" data-method="bank" style="margin-top: 10px; padding: 15px; background: white; border-radius: 8px; border-left: 4px solid #007bff;">
                                        <p style="color: #6c757d; margin: 0; line-height: 1.6;">
                                            <i class="fa fa-info-circle" style="color: #17a2b8; margin-right: 8px;"></i>
                                            Khách hàng cần thanh toán online qua chuyển khoản ngân hàng
                                        </p>
                                    </div>
                                </div>

                                <div class="summary-footer-area" style="background: linear-gradient(135deg, #f8f9fa, #e9ecef); border-radius: 12px; padding: 25px; border: 2px solid #e9ecef;">
                                    <div class="custom-control custom-checkbox mb-20" style="margin-bottom: 20px;">
                                        <input type="checkbox" class="custom-control-input" id="terms" required />                                        <label class="custom-control-label" for="terms" style="color: #495057; font-weight: 600; cursor: pointer; font-size: 15px; line-height: 1.6;">
                                            Tôi đã đọc và đồng ý với các <a href="#" style="color: #007bff; text-decoration: none;">điều khoản và điều kiện</a> của cửa hàng
                                        </label>
                                    </div>
                                    <button type="submit" class="btn btn-sqr" style="background: linear-gradient(135deg, #28a745, #20c997); color: white; border: none; padding: 18px 30px; border-radius: 10px; font-weight: 700; font-size: 1.1rem; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3); width: 100%;">
                                        <i class="fa fa-check-circle" style="margin-right: 10px;"></i>
                                        Tiến hành đặt hàng
                                    </button>
                                </div>
                            </div>
                      
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>    <!-- checkout main wrapper end -->
</main>

<style>
    .single-input-item input:focus,
    .single-input-item textarea:focus {
        border-color: #007bff !important;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1) !important;
        background: #ffffff !important;
    }
    
    .single-payment-method:hover {
        border-color: #007bff !important;
        background: #ffffff !important;
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(0, 123, 255, 0.1) !important;
    }
    
    .single-payment-method.active {
        border-color: #007bff !important;
        background: #ffffff !important;
        box-shadow: 0 5px 20px rgba(0, 123, 255, 0.2) !important;
    }
    
    .btn:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4) !important;
    }
    
    .custom-control-label:hover {
        color: #007bff !important;
    }
    
    tr:hover {
        background: rgba(0, 123, 255, 0.02) !important;
    }
    
    .apply-coupon-wrapper input:focus {
        border-color: #007bff !important;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1) !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Payment method selection
        const paymentRadios = document.querySelectorAll('input[name="phuong_thuc_thanh_toan_id"]');
        const paymentMethods = document.querySelectorAll('.single-payment-method');
        
        paymentRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                paymentMethods.forEach(method => {
                    method.classList.remove('active');
                });
                this.closest('.single-payment-method').classList.add('active');
            });
        });
        
        // Form validation
        const form = document.querySelector('form');
        const submitBtn = document.querySelector('button[type="submit"]');
        
        form.addEventListener('submit', function(e) {
            const termsCheckbox = document.getElementById('terms');
            if (!termsCheckbox.checked) {
                e.preventDefault();
                alert('Vui lòng đồng ý với các điều khoản và điều kiện để tiếp tục!');
                return false;
            }
            
            // Add loading state to submit button
            submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin" style="margin-right: 10px;"></i>Đang xử lý...';
            submitBtn.disabled = true;
        });
        
        // Input animations
        const inputs = document.querySelectorAll('input, textarea');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
                this.parentElement.style.transition = 'all 0.3s ease';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
        
        // Phone number formatting
        const phoneInput = document.getElementById('sdt_nguoi_nhan');
        phoneInput.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            if (value.length > 10) {
                value = value.slice(0, 10);
            }
            this.value = value;
        });
        
        // Email validation
        const emailInput = document.getElementById('email_nguoi_nhan');
        emailInput.addEventListener('blur', function() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (this.value && !emailRegex.test(this.value)) {
                this.style.borderColor = '#dc3545';
                this.style.boxShadow = '0 0 0 3px rgba(220, 53, 69, 0.1)';
            } else {
                this.style.borderColor = '#28a745';
                this.style.boxShadow = '0 0 0 3px rgba(40, 167, 69, 0.1)';
            }
        });
        
        // Initialize first payment method as active
        if (paymentMethods.length > 0) {
            paymentMethods[0].classList.add('active');
        }
    });
</script>

<!-- cart main wrapper end -->







<?php require_once 'layout/miniCart.php'; ?>
<?php require_once 'layout/footer.php'; ?>