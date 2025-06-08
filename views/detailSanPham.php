<?php require_once 'layout/header.php';  ?>
<?php require_once 'layout/menu.php';  ?>

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
                                <li class="breadcrumb-item"><a href="shop.html">Sản phẩm</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Chi tiết sản phẩm</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->

    <!-- page main wrapper start -->
    <div class="shop-main-wrapper section-padding pb-0">
        <div class="container">
            <div class="row">
                <!-- product details wrapper start -->
                <div class="col-lg-12 order-1 order-lg-2">
                    <!-- product details inner end -->
                    <div class="product-details-inner">
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="product-large-slider">                    <?php foreach ($listAnhSanPham as $key => $anhSanPham):   ?>
                                        <div class="pro-large-img img-zoom">
                                            <img src="<?= getImageUrl($anhSanPham['link_hinh_anh']) ?>" alt="product-details" />
                                        </div>
                                    <?php endforeach ?>
                                </div>
                                <div class="pro-nav slick-row-10 slick-arrow-style">                    <?php foreach ($listAnhSanPham as $key => $anhSanPham):   ?>
                                        <div class="pro-nav-thumb">
                                            <img src="<?= getImageUrl($anhSanPham['link_hinh_anh']) ?>" alt="product-details" />
                                        </div>
                                    <?php endforeach ?>


                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="product-details-des">
                                    <div class="manufacturer-name">
                                        <a href="#l"><?= $sanPham['ten_danh_muc'] ?></a>
                                    </div>
                                    <h3 class="product-name"><?= $sanPham['ten_san_pham'] ?></h3>
                                    <div class="ratings d-flex">
                                        <div class="pro-review">
                                            <?php $countComment = count($listBinhLuan); ?>
                                            <span><?= $countComment . 'bình luận' ?></span>
                                        </div>
                                    </div>
                                    <div class="price-box">
                                        <?php if ($sanPham['gia_khuyen_mai']) { ?>

                                            <span class="price-regular"><?= formatPrice($sanPham['gia_khuyen_mai']) . 'đ'; ?></span>
                                            <span class="price-old"><del><?= formatPrice($sanPham['gia_san_pham']) . 'đ'; ?></del></span>
                                        <?php   } else { ?>
                                            <span class="price-regular"><?= formatPrice($sanPham['gia_san_pham']) . 'đ' ?></span>

                                        <?php } ?>
                                        <!-- <span class="price-regular">$70.00</span>
                                            <span class="price-old"><del>$90.00</del></span> -->
                                    </div>
                                      <!-- Enhanced inventory display -->
                                    <div class="availability">
                                        <?php if ($sanPham['so_luong'] > 0): ?>
                                            <?php if ($sanPham['so_luong'] > 10): ?>
                                                <i class="fa fa-check-circle" style="color: #28a745;"></i>
                                                <span style="color: #28a745; font-weight: bold;">Còn hàng (<?= $sanPham['so_luong'] ?> sản phẩm)</span>
                                            <?php elseif ($sanPham['so_luong'] > 5): ?>
                                                <i class="fa fa-exclamation-triangle" style="color: #ffc107;"></i>
                                                <span style="color: #ffc107; font-weight: bold;">Còn ít hàng (<?= $sanPham['so_luong'] ?> sản phẩm)</span>
                                            <?php else: ?>
                                                <i class="fa fa-exclamation-triangle" style="color: #dc3545;"></i>
                                                <span style="color: #dc3545; font-weight: bold;">Sắp hết hàng (<?= $sanPham['so_luong'] ?> sản phẩm)</span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <i class="fa fa-times-circle" style="color: #dc3545;"></i>
                                            <span style="color: #dc3545; font-weight: bold;">Hết hàng</span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <?php if ($sanPham['so_luong'] <= 5 && $sanPham['so_luong'] > 0): ?>
                                        <div class="stock-warning" style="background: #fff3cd; border: 1px solid #ffeaa7; padding: 10px; border-radius: 5px; margin: 10px 0;">
                                            <i class="fa fa-exclamation-triangle" style="color: #856404;"></i>
                                            <span style="color: #856404;">⚠️ Chỉ còn <?= $sanPham['so_luong'] ?> sản phẩm. Đặt hàng ngay để không bỏ lỡ!</span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <p class="pro-desc"><?= $sanPham['mo_ta'] ?></p>
                                    
                                    <?php if ($sanPham['so_luong'] > 0): ?>
                                        <form action="<?= BASE_URL . '?act=them-gio-hang' ?>" method="post" id="addToCartForm">
                                            <div class="quantity-cart-box d-flex align-items-center">
                                                <h6 class="option-title">Số lượng:</h6>
                                                <div class="quantity">
                                                    <input type="hidden" name="san_pham_id" value="<?= $sanPham['id'] ?>">
                                                    <div class="pro-qty">
                                                        <input type="number" value="1" name="so_luong" min="1" max="<?= $sanPham['so_luong'] ?>" id="quantityInput">
                                                    </div>
                                                </div>
                                                <div class="action_link">
                                                    <button type="submit" class="btn btn-cart2" id="addToCartBtn">Thêm giỏ hàng</button>
                                                </div>
                                            </div>
                                            <small style="color: #6c757d;">Tối đa <?= $sanPham['so_luong'] ?> sản phẩm có thể đặt hàng</small>
                                        </form>
                                        
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                const quantityInput = document.getElementById('quantityInput');
                                                const maxStock = <?= $sanPham['so_luong'] ?>;
                                                
                                                quantityInput.addEventListener('input', function() {
                                                    let value = parseInt(this.value);
                                                    if (value > maxStock) {
                                                        this.value = maxStock;
                                                        alert('Số lượng không được vượt quá số lượng tồn kho (' + maxStock + ')');
                                                    } else if (value < 1) {
                                                        this.value = 1;
                                                    }
                                                });
                                                
                                                document.getElementById('addToCartForm').addEventListener('submit', function(e) {
                                                    const quantity = parseInt(quantityInput.value);
                                                    if (quantity > maxStock) {
                                                        e.preventDefault();
                                                        alert('Số lượng không được vượt quá số lượng tồn kho (' + maxStock + ')');
                                                        return false;
                                                    }
                                                });
                                            });
                                        </script>
                                    <?php else: ?>
                                        <div class="out-of-stock" style="text-align: center; padding: 20px; background: #f8f9fa; border-radius: 5px; margin: 20px 0;">
                                            <h5 style="color: #dc3545; margin-bottom: 10px;">
                                                <i class="fa fa-times-circle"></i> Sản phẩm tạm hết hàng
                                            </h5>
                                            <p style="color: #6c757d; margin-bottom: 15px;">Sản phẩm này hiện đang hết hàng. Vui lòng quay lại sau hoặc liên hệ với chúng tôi để biết thêm thông tin.</p>
                                            <button class="btn btn-secondary" disabled>Hết hàng</button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- product details inner end -->

                    <!-- product details reviews start -->
                    <div class="product-details-reviews section-padding pb-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="product-review-info">
                                    <ul class="nav review-tab">

                                        <li>
                                            <a class="active" data-bs-toggle="tab" href="#tab_three">Bình luận (<?= $countComment ?>)</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content reviews-tab">

                                        <div class="tab-pane fade show active" id="tab_three">
                                            <?php foreach ($listBinhLuan as $binhLuan): ?>
                                                <div class="total-reviews">
                                                    <div class="rev-avatar">
                                                        <img src="<?= $binhLuan['anh_dai_dien'] ?>" alt="">
                                                    </div>
                                                    <div class="review-box">

                                                        <div class="post-author">
                                                            <p><span> <?= $binhLuan['ho_ten'] ?> - </span> <?= $binhLuan['ngay_dang'] ?></p>
                                                        </div>
                                                        <p><?= $binhLuan['noi_dung'] ?></p>
                                                    </div>
                                                </div>
                                            <?php endforeach ?>
                                            <form action="<?= BASE_URL . '?act=add_comment&id_san_pham=' . $sanPham['id'] ?>" method="POST" class="review-form">

                                                <div class="form-group row">
                                                    <div class="col">
                                                        <label class="col-form-label"><span class="text-danger">*</span>
                                                            Nội dung bình luận</label>
                                                        <textarea class="form-control" required  name="noi_dung"></textarea>

                                                        <div class="buttons">
                                                            <button class="btn btn-sqr" type="submit">Bình luận</button>
                                                        </div>
                                            </form> <!-- end of review-form -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- product details reviews end -->
                </div>
                <!-- product details wrapper end -->
            </div>
        </div>
    </div>
    <!-- page main wrapper end -->

    <!-- related products area start -->
    <section class="related-products section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- section title start -->
                    <div class="section-title text-center">
                        <h2 class="title">Sản phẩm liên quan</h2>
                        <p class="sub-title"></p>
                    </div>
                    <!-- section title start -->
                </div>
            </div>
            <!-- <div class="row"> -->
            <div class="col-12">
                <!-- product item start -->
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab1">
                        <div class="product-carousel-4 slick-row-10 slick-arrow-style">
                            <?php foreach ($listSanPhamCungDanhMuc as $key => $sanPham): ?>
                                <!-- product item start -->
                                <div class="product-item">
                                    <figure class="product-thumb">                                        <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $SanPham['id']; ?>">
                                            <img class="pri-img" src="<?= getImageUrl($sanPham['hinh_anh']) ?>" alt="product">
                                            <img class="sec-img" src="<?= getImageUrl($sanPham['hinh_anh']) ?>" alt="product">
                                        </a>
                                        <div class="product-badge">
                                            <?php
                                            $ngayNhap = new DateTime($sanPham['ngay_nhap']);
                                            $ngayHienTai = new DateTime();
                                            $tinhNgay = $ngayHienTai->diff($ngayNhap);
                                            if ($tinhNgay->days <= 7) {
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

                                            <!-- <div class="product-label new">
                                                        <span>Mới</span>
                                                    </div> -->
                                        </div>

                                        <div class="cart-hover">
                                            <button class="btn btn-cart">Xem chi tiết</button>
                                        </div>
                                    </figure>
                                    <div class="product-caption text-center">

                                        <h6 class="product-name">
                                            <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $SanPham['id']; ?>"><?= $sanPham['ten_san_pham'] ?></a>
                                        </h6>
                                        <div class="price-box">
                                            <?php if ($sanPham['gia_khuyen_mai']) { ?>

                                                <span class="price-regular"><?= formatPrice($sanPham['gia_khuyen_mai']) . 'đ'; ?></span>
                                                <span class="price-old"><del><?= formatPrice($sanPham['gia_san_pham']) . 'đ'; ?></del></span>
                                            <?php   } else { ?>
                                                <span class="price-regular"><?= formatPrice($sanPham['gia_san_pham']) . 'đ' ?></span>

                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- product item end -->

                            <?php endforeach  ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- product item end -->



        </div>
        <!-- </div> -->
    </section>
    <!-- related products area end -->


    <!-- Trang feedback -->
 <style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f5f5f5;
}

.box{
    height: 500px;
    overflow: auto;
}

.tuan {
    width: 60%; /* Giảm chiều rộng */
    margin: 10px auto; /* Giảm khoảng cách trên dưới */
    padding: 15px; /* Giảm padding bên trong */
    background-color: #ffffff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Giảm độ bóng */
    display: flex;
    align-items: center;
    gap: 10px; /* Giảm khoảng cách giữa các phần */
}

.img img {
    width: 60px; /* Giảm kích thước hình ảnh */
    height: 60px;
    border-radius: 50%;
    border: 2px solid #007bff;
    object-fit: cover;
}

.content {
    flex: 1;
}

.content h4 {
    margin: 3px 0;
    font-size: 14px; /* Giảm kích thước font tiêu đề */
    color: #333;
}

.content p {
    margin: 5px 0; /* Giảm khoảng cách giữa các đoạn văn */
    font-size: 12px; /* Giảm kích thước font nội dung */
    line-height: 1.3; /* Giảm khoảng cách giữa các dòng */
    color: #555;
    text-align: justify;
}

@media (max-width: 768px) {
    .tuan {
        flex-direction: column;
        text-align: center;
    }
    .img img {
        margin-bottom: 10px;
    }
}


</style>
<body>
   <div class="box">
   <?php
    foreach($dataComment as $index){
        // var_dump($dataComment);
        // exit;
    ?>
    <div class="tuan">
    <div class="img">
            <img src="https://tse3.mm.bing.net/th?id=OIP.njDZuvc46_VmiKUoWJ0z7wHaEK&pid=Api&P=0&h=220" alt="">
        </div>
        <div class="content">
            <h4><?php echo $index['ho_ten'] ?>
            <p><?php echo $index['noi_dung'] ?></p>
            <p><?php echo $index['ngay_dang'] ?></p>
            </h4>
        </div>
    </div>
    <?php
    }
    ?>
   </div>
</body>
</main>






<?php require_once 'layout/miniCart.php'; ?>

<?php require_once 'layout/footer.php'; ?>