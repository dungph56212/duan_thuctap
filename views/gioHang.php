<?php require_once 'layout/header.php';  ?>
<?php require_once 'layout/menu.php';  ?>

<main>        <!-- breadcrumb area start -->
        <div class="breadcrumb-area" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 60px 0;">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumb-wrap">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb" style="background: transparent; margin-bottom: 0; padding: 0;">
                                    <li class="breadcrumb-item">
                                        <a href="<?=BASE_URL?>" style="color: #007bff; text-decoration: none;">
                                            <i class="fa fa-home"></i> Trang chủ
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="#" style="color: #6c757d; text-decoration: none;">Mua sắm</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page" style="color: #495057; font-weight: 600;">
                                        Giỏ hàng
                                    </li>
                                </ul>
                            </nav>
                            <h1 style="color: #212529; font-size: 2.5rem; font-weight: 700; margin-top: 20px; margin-bottom: 10px;">
                                <i class="fa fa-shopping-cart" style="color: #007bff; margin-right: 15px;"></i>
                                Giỏ hàng của bạn
                            </h1>
                            <p style="color: #6c757d; font-size: 1.1rem; margin-bottom: 0;">
                                Xem lại các sản phẩm đã chọn và tiến hành thanh toán
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb area end -->        <!-- cart main wrapper start -->
        <div class="cart-main-wrapper section-padding" style="background: #ffffff; padding: 80px 0;">
            <div class="container">
                <div class="section-bg-color" style="background: #ffffff; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); padding: 40px;">
                    <?php if (empty($chiTietGioHang)): ?>
                        <div class="empty-cart" style="text-align: center; padding: 60px 20px;">
                            <i class="fa fa-shopping-cart" style="font-size: 5rem; color: #6c757d; margin-bottom: 30px;"></i>
                            <h3 style="color: #495057; margin-bottom: 20px; font-weight: 600;">Giỏ hàng của bạn đang trống</h3>
                            <p style="color: #6c757d; font-size: 1.1rem; margin-bottom: 30px;">Hãy thêm một số sản phẩm vào giỏ hàng để tiếp tục mua sắm!</p>
                            <a href="<?= BASE_URL ?>" class="btn btn-primary" style="background: linear-gradient(135deg, #007bff, #0056b3); border: none; padding: 15px 30px; border-radius: 8px; font-weight: 600; text-decoration: none; color: white;">
                                <i class="fa fa-arrow-left" style="margin-right: 10px;"></i>
                                Tiếp tục mua sắm
                            </a>
                        </div>
                    <?php else: ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <h2 style="color: #495057; font-weight: 600; margin-bottom: 30px; font-size: 1.8rem;">
                                <i class="fa fa-list" style="color: #007bff; margin-right: 10px;"></i>
                                Danh sách sản phẩm
                            </h2>
                            <!-- Cart Table Area -->
                            <div class="cart-table table-responsive" style="background: #f8f9fa; border-radius: 12px; padding: 20px; margin-bottom: 30px;">
                                <table class="table table-bordered" style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                                    <thead style="background: linear-gradient(135deg, #007bff, #0056b3); color: white;">
                                        <tr>
                                            <th class="pro-thumbnail" style="border: none; padding: 20px; font-weight: 600; text-align: center;">
                                                <i class="fa fa-image" style="margin-right: 8px;"></i>Ảnh sản phẩm
                                            </th>
                                            <th class="pro-title" style="border: none; padding: 20px; font-weight: 600;">
                                                <i class="fa fa-tag" style="margin-right: 8px;"></i>Tên sản phẩm
                                            </th>
                                            <th class="pro-price" style="border: none; padding: 20px; font-weight: 600; text-align: center;">
                                                <i class="fa fa-money" style="margin-right: 8px;"></i>Giá tiền
                                            </th>
                                            <th class="pro-quantity" style="border: none; padding: 20px; font-weight: 600; text-align: center;">
                                                <i class="fa fa-sort-numeric-asc" style="margin-right: 8px;"></i>Số lượng
                                            </th>
                                            <th class="pro-subtotal" style="border: none; padding: 20px; font-weight: 600; text-align: center;">
                                                <i class="fa fa-calculator" style="margin-right: 8px;"></i>Tổng tiền
                                            </th>
                                            <th class="pro-remove" style="border: none; padding: 20px; font-weight: 600; text-align: center;">
                                                <i class="fa fa-cog" style="margin-right: 8px;"></i>Thao tác
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>                                        <?php 
                                        $tongGioHang = 0;
                                        foreach($chiTietGioHang as $key=>$sanPham ):
                                            ?>
                                        <tr style="transition: all 0.3s ease;">
                                            <td class="pro-thumbnail" style="border: 1px solid #e9ecef; padding: 20px; text-align: center;">
                                                <a href="#" style="display: block;">
                                                    <img class="img-fluid" src="<?= BASE_URL . $sanPham['hinh_anh'] ?>" alt="Product" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 2px solid #e9ecef; transition: all 0.3s ease;" />
                                                </a>
                                            </td>
                                            <td class="pro-title" style="border: 1px solid #e9ecef; padding: 20px; vertical-align: middle;">
                                                <a href="#" style="color: #495057; font-weight: 600; font-size: 1.1rem; text-decoration: none; transition: color 0.3s ease;">
                                                    <?= $sanPham['ten_san_pham'] ?>
                                                </a>
                                            </td>
                                            <td class="pro-price" style="border: 1px solid #e9ecef; padding: 20px; text-align: center; vertical-align: middle;">
                                                <span style="color: #007bff; font-weight: 600; font-size: 1.1rem;">
                                                    <?php  if ($sanPham['gia_khuyen_mai']) { ?>
                                                        <?=formatPrice($sanPham['gia_khuyen_mai']).'đ'?>
                                                   <?php } else { ?>
                                                    <?=formatPrice($sanPham['gia_san_pham']).'đ'?>
                                                 <?php }?>
                                                </span>
                                            </td>
                                            <td class="pro-quantity" style="border: 1px solid #e9ecef; padding: 20px; text-align: center; vertical-align: middle;">
                                                <div class="pro-qty" style="display: inline-flex; align-items: center; background: #f8f9fa; border-radius: 8px; padding: 5px;">
                                                    <input type="text" value="<?= $sanPham['so_luong'] ?>" style="width: 60px; height: 35px; border: 2px solid #e9ecef; border-radius: 6px; text-align: center; font-weight: 600; background: white; outline: none;">
                                                </div>
                                            </td>
                                            <td class="pro-subtotal" style="border: 1px solid #e9ecef; padding: 20px; text-align: center; vertical-align: middle;">
                                                <span style="color: #28a745; font-weight: 700; font-size: 1.2rem;">
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
                                                </span>
                                            </td>
                                            <td class="pro-remove" style="border: 1px solid #e9ecef; padding: 20px; text-align: center; vertical-align: middle;">
                                                <a href="#" style="color: #dc3545; font-size: 1.2rem; transition: all 0.3s ease; text-decoration: none; padding: 8px; border-radius: 6px; background: #f8f9fa;">
                                                    <i class="fa fa-trash-o"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>                                    </tbody>
                                </table>
                            </div>
                            <!-- Cart Update Option -->
                            <div class="cart-update-option d-block d-md-flex justify-content-between" style="background: #f8f9fa; border-radius: 12px; padding: 25px; margin-bottom: 30px;">
                                <div class="apply-coupon-wrapper">
                                    <h6 style="color: #495057; font-weight: 600; margin-bottom: 15px;">
                                        <i class="fa fa-gift" style="color: #007bff; margin-right: 8px;"></i>
                                        Mã giảm giá
                                    </h6>
                                    <form action="#" method="post" class="d-block d-md-flex align-items-center">
                                        <input type="text" placeholder="Nhập mã giảm giá" required style="border: 2px solid #e9ecef; border-radius: 8px; padding: 12px 15px; margin-right: 15px; background: white; outline: none; font-size: 14px; width: 250px; transition: all 0.3s ease;" />
                                        <button class="btn btn-sqr" type="submit" style="background: linear-gradient(135deg, #28a745, #20c997); color: white; border: none; padding: 12px 25px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 10px rgba(40, 167, 69, 0.3);">
                                            <i class="fa fa-check" style="margin-right: 8px;"></i>
                                            Áp dụng
                                        </button>
                                    </form>
                                </div>
                                <div class="cart-update">
                                    <button class="btn btn-secondary" style="background: #6c757d; border: none; padding: 12px 25px; border-radius: 8px; color: white; font-weight: 600;">
                                        <i class="fa fa-refresh" style="margin-right: 8px;"></i>
                                        Cập nhật giỏ hàng
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>                    <div class="row">
                        <div class="col-lg-5 ml-auto">
                            <!-- Cart Calculation Area -->
                            <div class="cart-calculator-wrapper" style="background: linear-gradient(135deg, #f8f9fa, #e9ecef); border-radius: 15px; padding: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); border: 2px solid #e9ecef;">
                                <div class="cart-calculate-items">
                                    <h6 style="color: #495057; font-weight: 700; margin-bottom: 25px; font-size: 1.4rem; text-align: center; border-bottom: 2px solid #007bff; padding-bottom: 15px;">
                                        <i class="fa fa-calculator" style="color: #007bff; margin-right: 10px;"></i>
                                        Tổng đơn hàng
                                    </h6>
                                    <div class="table-responsive">
                                        <table class="table" style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                                            <tr style="background: #f8f9fa;">
                                                <td style="border: none; padding: 15px 20px; color: #495057; font-weight: 600;">
                                                    <i class="fa fa-shopping-bag" style="color: #007bff; margin-right: 8px;"></i>
                                                    Tổng tiền sản phẩm
                                                </td>
                                                <td style="border: none; padding: 15px 20px; color: #007bff; font-weight: 700; font-size: 1.1rem; text-align: right;">
                                                    <?= formatPrice($tongGioHang) . 'đ' ?>
                                                </td>
                                            </tr>
                                            <tr style="background: #f8f9fa;">
                                                <td style="border: none; padding: 15px 20px; color: #495057; font-weight: 600;">
                                                    <i class="fa fa-truck" style="color: #28a745; margin-right: 8px;"></i>
                                                    Phí vận chuyển
                                                </td>
                                                <td style="border: none; padding: 15px 20px; color: #28a745; font-weight: 700; font-size: 1.1rem; text-align: right;">
                                                    30.000đ
                                                </td>
                                            </tr>
                                            <tr class="total" style="background: linear-gradient(135deg, #007bff, #0056b3); color: white;">
                                                <td style="border: none; padding: 20px; font-weight: 700; font-size: 1.2rem;">
                                                    <i class="fa fa-money" style="margin-right: 8px;"></i>
                                                    Tổng thanh toán
                                                </td>
                                                <td class="total-amount" style="border: none; padding: 20px; font-weight: 700; font-size: 1.3rem; text-align: right;">
                                                    <?= formatPrice($tongGioHang + 30000) . 'đ' ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <a href="<?= BASE_URL.'?act=thanh-toan'?>" class="btn btn-sqr d-block" style="background: linear-gradient(135deg, #28a745, #20c997); color: white; border: none; padding: 18px 20px; border-radius: 10px; font-weight: 700; font-size: 1.1rem; text-transform: uppercase; letter-spacing: 1px; text-decoration: none; text-align: center; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3); margin-top: 25px;">
                                    <i class="fa fa-credit-card" style="margin-right: 10px;"></i>
                                    Tiến hành đặt hàng
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- cart main wrapper end -->    </main>

<style>
    .pro-thumbnail img:hover {
        transform: scale(1.05);
        border-color: #007bff !important;
    }
    
    .pro-title a:hover {
        color: #007bff !important;
    }
    
    .pro-remove a:hover {
        background: #dc3545 !important;
        color: white !important;
        transform: scale(1.1);
    }
    
    .apply-coupon-wrapper input:focus {
        border-color: #007bff !important;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1) !important;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 123, 255, 0.4) !important;
    }
    
    tr:hover {
        background: rgba(0, 123, 255, 0.02) !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add hover effects for buttons
        const buttons = document.querySelectorAll('.btn');
        buttons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                if (this.style.background.includes('28a745')) {
                    this.style.background = 'linear-gradient(135deg, #20c997, #17a2b8)';
                } else if (this.style.background.includes('007bff')) {
                    this.style.background = 'linear-gradient(135deg, #0056b3, #004494)';
                }
            });
            
            button.addEventListener('mouseleave', function() {
                if (this.textContent.includes('Tiến hành')) {
                    this.style.background = 'linear-gradient(135deg, #28a745, #20c997)';
                } else if (this.textContent.includes('Áp dụng')) {
                    this.style.background = 'linear-gradient(135deg, #28a745, #20c997)';
                }
            });
        });
        
        // Quantity input validation
        const qtyInputs = document.querySelectorAll('.pro-qty input');
        qtyInputs.forEach(input => {
            input.addEventListener('input', function() {
                let value = parseInt(this.value);
                if (value < 1) {
                    this.value = 1;
                } else if (value > 99) {
                    this.value = 99;
                }
            });
            
            input.addEventListener('focus', function() {
                this.style.borderColor = '#007bff';
                this.style.boxShadow = '0 0 0 3px rgba(0, 123, 255, 0.1)';
            });
            
            input.addEventListener('blur', function() {
                this.style.borderColor = '#e9ecef';
                this.style.boxShadow = 'none';
            });
        });
    });
</script>
<?php require_once 'layout/miniCart.php'; ?>
<?php require_once 'layout/footer.php'; ?>