<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sản phẩm</title>
</head>
    <?php require_once './views/layout/header.php' ?> 
    <?php require_once './views/layout/menu.php' ?>
<body>
    
        <div id="header" class="header-default">
            <div class="px_15 lg-px_40">
                <div class="row wrapper-header align-items-center">
                    <div class="col-md-4 col-3 tf-lg-hidden">
                        <a href="#mobileMenu" data-bs-toggle="offcanvas" aria-controls="offcanvasLeft"></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="tf-page-title">
        <div class="section-title text-center">
                            <h2 class="title">Danh sách sản phẩm</h2>
                        </div>
        </div>

        <section class="flat-spacing-1">
        <div class="shop-main-wrapper section-padding">
            <div class="container">
                <div class="row">
                    <!-- sidebar area start -->
                    <div class="col-lg-3 order-2 order-lg-1">
                        <aside class="sidebar-wrapper">
                            <!-- single sidebar start -->
                            <div class="sidebar-single">
                                <h5 class="sidebar-title">Danh mục sản phẩm</h5>
                                <div class="sidebar-body">
                                    <?php foreach($listCates as $listCate){ ?>
                                    <ul class="shop-categories">
                                        <li><a href="#"><?= $listCate['ten_danh_muc'] ?> </li>
                                    </ul>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="sidebar-banner">
                                <div class="img-container">
                                    <a href="#">
                                        <img src="assets/img/banner/sidebar-banner.jpg" alt="">
                                    </a>
                                </div>
                            </div>
                            <!-- single sidebar end -->
                        </aside>
                    </div>
                    <!-- sidebar area end -->

                    <!-- shop main wrapper start -->
                    <div class="col-lg-9 order-1 order-lg-2">
                        <div class="shop-product-wrapper">
                            <!-- shop product top wrap start -->
                            <div class="shop-top-bar">
                                <div class="row align-items-center">
                                    <div class="col-lg-7 col-md-6 order-2 order-md-1">

                                    </div>
                                    <div class="col-lg-5 col-md-6 order-1 order-md-2">
                                        <div class="top-bar-right">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- shop product top wrap start -->

                            <!-- product item list wrapper start -->
                            <div class="shop-product-wrap grid-view row mbn-30">
                                <!-- product single item start -->
                                <?php foreach($products as $product){ ?>
                                <div class="col-md-4 col-sm-6">
                                    <!-- product grid start -->
                                    <div class="product-item">
                                        <figure class="product-thumb">
                                            <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $product['id'] ?>">
                                                <img class="" src="<?= $product['hinh_anh'] ?>" alt="product">
                                            </a>
                                            <div class="product-badge">
                                                <div class="product-label new">
                                                    <span>new</span>
                                                </div>
                                                <div class="product-label discount">
                                                    <span>10%</span>
                                                </div>
                                            </div>
                                            <div class="button-group">
                                                <a href="wishlist.html" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to wishlist"><i class="pe-7s-like"></i></a>
                                                <a href="compare.html" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Compare"><i class="pe-7s-refresh-2"></i></a>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#quick_view"><span data-bs-toggle="tooltip" data-bs-placement="left" title="Quick View"><i class="pe-7s-search"></i></span></a>
                                            </div>
                                            <div class="cart-hover">
                                                <button class="btn btn-cart">add to cart</button>
                                            </div>
                                        </figure>
                                        <div class="product-caption text-center">
                                            <div class="product-identity">
                                                <p class="manufacturer-name"><a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $product['id'] ?>">Platinum</a></p>
                                            </div>
                                            <h6 class="product-name">
                                                <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $product['id'] ?>"><?= $product['ten_san_pham'] ?></a>
                                            </h6>
                                            <div class="price-box">
                                                <span class="price-regular"> <?= $product['gia_san_pham'] ?></span>
                                                <span class="price-old"><del><?= $product['gia_khuyen_mai'] ?></del></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <!-- product grid end -->
                                    <?php } ?>

                                    <!-- product list item end -->
        </section>
</body>
    <?php require_once './views/layout/footer.php' ?>
</html>
