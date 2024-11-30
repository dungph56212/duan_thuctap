<!-- offcanvas mini cart start -->
<div class="offcanvas-minicart-wrapper">
    <div class="minicart-inner">
        <div class="offcanvas-overlay"></div>
        <div class="minicart-inner-content">
            <div class="minicart-close">
                <i class="pe-7s-close"></i>
            </div>
            <div class="minicart-content-box">
                <div class="minicart-item-wrapper">
                    <ul>
                        <li class="minicart-item">
                            <div class="minicart-thumb">
                                <a href="?act=gio-hang">
                                    <img src="<?= BASE_URL . $sanPham['hinh_anh'] ?>" alt="product">
                                </a>
                            </div>
                            <div class="minicart-content">
                                <h3 class="product-name">
                                    <a href="product-details.html">Dozen White Botanical Linen Dinner Napkins</a>
                                </h3>
                                <p>
                                    <span class="cart-quantity">1 <strong>&times;</strong></span>
                                    <span class="cart-price">Sản phẩm 1</span>
                                </p>
                            </div>
                            <button class="minicart-remove"><i class="pe-7s-close"></i></button>
                        </li>
                        <li class="minicart-item">
                            <div class="minicart-thumb">
                                <a href="?act=gio-hang">
                                    <img src="<?= BASE_URL . $sanPham['hinh_anh'] ?>" alt="product">
                                </a>
                            </div>
                            <div class="minicart-content">
                                <h3 class="product-name">
                                    <a href="product-details.html">Dozen White Botanical Linen Dinner Napkins</a>
                                </h3>
                                <p>
                                    <span class="cart-quantity">1 <strong>&times;</strong></span>
                                    <span class="cart-price">$80.00</span>
                                </p>
                            </div>
                            <button class="minicart-remove"><i class="pe-7s-close"></i></button>
                        </li>
                    </ul>
                </div>

                <div class="minicart-pricing-box">
                    <ul>
                        <li>
                            <span>Giá tiền</span>
                            <span><strong><del><?= formatPrice($sanPham['gia_san_pham']) . 'đ'; ?></strong></span>
                        </li>
                        <li>
                            <span>Giá khuyến mãi</span>
                            <span><strong><?= formatPrice($sanPham['gia_khuyen_mai']) . 'đ'; ?></strong></span>
                        </li>
                        
                        <li class="total">
                            <span>Tổng tiền</span>
                            <span><strong>
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
                            </strong></span>
                        </li>
                    </ul>
                </div>

                <div class="minicart-button">
                    <a href="<?= BASE_URL . '?act=gio-hang' ?>"><i class="fa fa-shopping-cart"></i> Xem giỏ hàng</a>
                    <a href="cart.html"><i class="fa fa-share"></i>Thanh toán</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- offcanvas mini cart end -->