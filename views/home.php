<?php require_once'layout/header.php';  ?>
 <?php require_once'layout/menu.php';  ?>
    
    <main>
        <!-- hero slider area start -->
        <section class="slider-area">
            <div class="hero-slider-active slick-arrow-style slick-arrow-style_hero slick-dot-style">
                <?php if (!empty($listBanners)): ?>
                    <?php foreach ($listBanners as $banner): ?>
                        <!-- single slider item start -->
                        <div class="hero-single-slide hero-overlay">
                            <div class="hero-slider-item bg-img" data-bg="<?= htmlspecialchars($banner['hinh_anh']) ?>">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="hero-content">
                                                <h1><?= htmlspecialchars($banner['ten_banner']) ?></h1>
                                                <?php if (!empty($banner['mo_ta'])): ?>
                                                    <p><?= htmlspecialchars($banner['mo_ta']) ?></p>
                                                <?php endif; ?>
                                                <?php if (!empty($banner['lien_ket'])): ?>
                                                    <a href="<?= htmlspecialchars($banner['lien_ket']) ?>" 
                                                       class="btn btn-hero" 
                                                       onclick="trackBannerView(<?= $banner['id'] ?>)">
                                                        Xem thêm
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- single slider item end -->
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Fallback nếu không có banner -->
                    <div class="hero-single-slide hero-overlay">
                        <div class="hero-slider-item bg-img" data-bg="assets/img/slider/Sliver_1.webp">
                            <div class="container">
                                <div class="row">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
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
            </div>        </div>
        <!-- service policy area end -->

        <!-- product categories area start -->
        <section class="product-categories-area section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <!-- section title start -->
                        <div class="section-title text-center">
                            <h2 class="title">Danh mục sản phẩm</h2>
                            <p class="sub-title">Khám phá các danh mục sách đa dạng</p>
                        </div>
                        <!-- section title end -->
                    </div>
                </div>                <div class="row">
                    <?php if (!empty($listDanhMuc)): ?>
                        <?php 
                        $categoryIcons = [
                            'pe-7s-culture',     // Văn học
                            'pe-7s-graph1',      // Kinh tế
                            'pe-7s-monitor',     // Công nghệ
                            'pe-7s-science',     // Khoa học
                            'pe-7s-map-2',       // Lịch sử, địa lý
                            'pe-7s-users',       // Tâm lý
                            'pe-7s-smile',       // Thiếu nhi
                            'pe-7s-study',       // Giáo dục
                            'pe-7s-plus',        // Y học
                            'pe-7s-bookmarks'    // Mặc định
                        ];
                        $categoryColors = [
                            '#4f46e5', '#f59e0b', '#10b981', '#ef4444', 
                            '#8b5cf6', '#06b6d4', '#f97316', '#84cc16',
                            '#ec4899', '#6b7280'
                        ];
                        ?>
                        <?php foreach($listDanhMuc as $key => $danhMuc): ?>
                            <?php 
                            $iconClass = $categoryIcons[$key % count($categoryIcons)];
                            $bgColor = $categoryColors[$key % count($categoryColors)];
                            ?>
                            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                <div class="category-card modern-category">
                                    <a href="<?= BASE_URL . '?act=san-pham-theo-danh-muc&danh_muc_id=' . $danhMuc['id']; ?>" class="category-link">
                                        <div class="category-icon" style="background: linear-gradient(135deg, <?= $bgColor ?>, <?= $bgColor ?>cc);">
                                            <i class="<?= $iconClass ?>"></i>
                                        </div>
                                        <div class="category-content">
                                            <h5 class="category-name"><?= $danhMuc['ten_danh_muc'] ?></h5>
                                            <?php if (!empty($danhMuc['mo_ta'])): ?>
                                                <p class="category-desc"><?= htmlspecialchars(substr($danhMuc['mo_ta'], 0, 60)) ?><?= strlen($danhMuc['mo_ta']) > 60 ? '...' : '' ?></p>
                                            <?php endif; ?>
                                            <div class="category-stats">
                                                <span class="product-count">
                                                    <i class="pe-7s-news-paper"></i> 
                                                    <?= $danhMuc['so_san_pham'] ?? 0 ?> sản phẩm
                                                </span>
                                            </div>
                                        </div>
                                        <div class="category-arrow">
                                            <i class="pe-7s-angle-right"></i>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="text-center">
                                <p>Chưa có danh mục sản phẩm nào.</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="row mt-4">
                    <div class="col-12 text-center">
                        <a href="<?= BASE_URL . '?act=san-pham-theo-danh-muc' ?>" class="btn btn-primary btn-modern">
                            Xem tất cả sản phẩm
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <!-- product categories area end -->

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
                                                        </div>
                                                   <?php
                                                    }
                                                    ?>

                                                    <!-- Inventory Status Display -->
                                                    <?php if ($sanPham['so_luong'] <= 0) { ?>
                                                        <div class="product-label out-of-stock" style="background-color: #dc3545;">
                                                            <span>Hết hàng</span>
                                                        </div>
                                                    <?php } elseif ($sanPham['so_luong'] <= 5) { ?>
                                                        <div class="product-label low-stock" style="background-color: #ffc107;">
                                                            <span>Sắp hết</span>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                
                                                <div class="cart-hover">
                                                    <button class="btn btn-cart">Xem chi tiết</button>
                                                </div>
                                            </figure>
                                            <div class="product-caption text-center">
                                                
                                                <h6 class="product-name">
                                                    <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id']; ?>"><?= $sanPham['ten_san_pham'] ?></a>
                                                </h6>
                                                <div class="price-box">
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
                </div>            </div>
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

<!-- Banner tracking script -->
<script>
function trackBannerView(bannerId) {
    // Track banner view
    fetch('?act=track-banner-view', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ banner_id: bannerId })
    }).catch(error => {
        console.log('Banner tracking error:', error);
    });
}
</script>

<?php require_once 'layout/miniCart.php'; ?>
   
 <?php require_once 'layout/footer.php'; ?>
