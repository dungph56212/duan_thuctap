
 <?php require_once'layout/header.php';  ?>
 <?php require_once'layout/menu.php';  ?>
    


    <main>
        <!-- hero slider area start -->
        <section class="slider-area">
            <div class="hero-slider-active slick-arrow-style slick-arrow-style_hero slick-dot-style">
                <!-- single slider item start -->
                <div class="hero-single-slide hero-overlay">
                    <div class="hero-slider-item bg-img" data-bg="assets/img/slider/Sliver_1.webp">
                        <div class="container">
                            <div class="row">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hero-single-slide hero-overlay">
                    <div class="hero-slider-item bg-img" data-bg="assets/img/slider/Sliver_2.webp">
                        <div class="container">
                            <div class="row">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hero-single-slide hero-overlay">
                    <div class="hero-slider-item bg-img" data-bg="assets/img/slider/Sliver_3.webp">
                        <div class="container">
                            <div class="row">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <!-- single slider item start -->


            </div>
        </section>
        <!-- hero slider area end -->

       

        <!-- service policy area start -->
        <div class="service-policy section-padding">
            <div class="container">
                <div class="row mtn-30">
                    <div class="col-sm-6 col-lg-3">
                        <div class="policy-item">
                            <div class="policy-icon">
                                <i class="pe-7s-plane"></i>
                            </div>
                            <div class="policy-content">
                                <h6>Giao hàng</h6>
                                <p>Miễn phí giao hàng</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="policy-item">
                            <div class="policy-icon">
                                <i class="pe-7s-help2"></i>
                            </div>
                            <div class="policy-content">
                                <h6>Hỗ trợ</h6>
                                <p>Hỗ trợ 24/7</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="policy-item">
                            <div class="policy-icon">
                                <i class="pe-7s-back"></i>
                            </div>
                            <div class="policy-content">
                                <h6>Hoàn tiền</h6>
                                <p>Hoàn tiền trong 30 ngày</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="policy-item">
                            <div class="policy-icon">
                                <i class="pe-7s-credit"></i>
                            </div>
                            <div class="policy-content">
                                <h6>Thanh toán</h6>
                                <p>Bảo mật thanh toán</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- service policy area end -->

        <!-- banner statistics area start -->
        <div class="banner-statistics-area">
            <div class="container">
                <div class="row row-20 mtn-20">
                    <div class="col-sm-6">
                        <figure class="banner-statistics mt-20">
                            <a href="#">
                                <img style="height: 20%;" src="<?= BASE_URL ?>assets/img/banner/bn1.webp" alt="product banner">
                            </a>

                        </figure>
                    </div>
                    <div class="col-sm-6">
                        <figure class="banner-statistics mt-20">
                            <a href="#">
                                <img src="<?= BASE_URL ?>assets/img/banner/bn2.webp" alt="product banner">
                            </a>

                        </figure>
                    </div>
    
                   
                </div>
            </div>
        </div>
        <!-- banner statistics area end -->

        <!-- product area start -->
        <section class="product-area section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <!-- section title start -->
                        <div class="section-title text-center">
                            <h2 class="title">Sản phẩm của chúng tôi</h2>
                            <p class="sub-title">Sản phẩm được cập nhập</p>
                        </div>
                        <!-- section title start -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="product-container">
                            <!-- product tab menu start -->

                            <!-- product tab content start -->
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="tab1">
                                    <div class="product-carousel-4 slick-row-10 slick-arrow-style">
                                        <?php foreach($listSanPham as $key => $sanPham): ?>
                                        <!-- product item start -->
                                        <div class="product-item">
                                            <figure class="product-thumb">
                                                <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id']; ?>">
                                                    <img class="pri-img" src="<?= BASE_URL . $sanPham['hinh_anh'] ?>" alt="product">
                                                    <img class="sec-img" src="<?= BASE_URL . $sanPham['hinh_anh'] ?>" alt="product">
                                                </a>
                                                <div class="product-badge">
                                                    <?php 
                                                    $ngayNhap = new DateTime($sanPham['ngay_nhap']);
                                                     $ngayHienTai = new DateTime();
                                                     $tinhNgay = $ngayHienTai->diff($ngayNhap);
                                                     if ($tinhNgay->days <=7) {
                                                    ?>     
                                                        <div class="product-label new"> 
                                                        <span> Mới</span>

                                                
                                                        </div>
                                                    <?php
                                                     }

                                                    ?>


                                                    <?php if ($sanPham['gia_khuyen_mai']) { ?>
                                                        
                                                        <div class="product-label discount">
                                                            <span>Giảm Giá</span>
                                                        </div>                                                   <?php
                                                    }
                                                    ?>

                                                    <!-- Inventory Status Labels -->
                                                    <?php if ($sanPham['so_luong'] <= 0) { ?>
                                                        <div class="product-label out-of-stock" style="background-color: #dc3545;">
                                                            <span>Hết hàng</span>
                                                        </div>
                                                    <?php } elseif ($sanPham['so_luong'] <= 5) { ?>
                                                        <div class="product-label low-stock" style="background-color: #ffc107;">
                                                            <span>Sắp hết</span>
                                                        </div>
                                                    <?php } ?>

                                                    <!-- <div class="product-label new">
                                                        <span>Mới</span>
                                                    </div> -->
                                                </div>
                                                
                                                <div class="cart-hover">
                                                    <button class="btn btn-cart">Xem chi tiết</button>
                                                </div>
                                            </figure>                                            <div class="product-caption text-center">
                                                
                                                <h6 class="product-name">
                                                    <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id']; ?>"><?= $sanPham['ten_san_pham'] ?></a>
                                                </h6>                                                <div class="price-box">
                                                    <?php if ($sanPham['gia_khuyen_mai']) { ?>
                                                    
                                                        <span class="price-regular"><?= formatPrice($sanPham['gia_khuyen_mai']). 'đ'; ?></span>
                                                        <span class="price-old"><del><?= formatPrice($sanPham['gia_san_pham']). 'đ'; ?></del></span>
                                                 <?php   } else {?>
                                                    <span class="price-regular"><?= formatPrice($sanPham['gia_san_pham']). 'đ' ?></span>

                                                    <?php }?>
                                                </div>
                                                
                                                <!-- Inventory quantity display -->
                                                <div class="inventory-info" style="margin-top: 5px; font-size: 12px;">
                                                    <?php if ($sanPham['so_luong'] > 0) { ?>
                                                        <span class="text-success">Còn <?= $sanPham['so_luong'] ?> sản phẩm</span>
                                                    <?php } else { ?>
                                                        <span class="text-danger">Hết hàng</span>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- product item end -->

                                        <?php endforeach  ?>
                                    </div>
                                </div>
                               
                            </div>
                            <!-- product tab content end -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- product area end -->

        <!-- product banner statistics area start -->
        
        <!-- product banner statistics area end -->

        <!-- featured product area start -->
       
        <!-- featured product area end -->

        <!-- testimonial area start -->
        
        <!-- testimonial area end -->

        <!-- group product start -->
       
        <!-- group product end -->

        <!-- latest blog area start -->
       
        <!-- latest blog area end -->

        <!-- brand logo area start -->
       
        <!-- brand logo area end -->
    </main>

<?php require_once 'layout/miniCart.php'; ?>
   
 <?php require_once 'layout/footer.php'; ?>
    