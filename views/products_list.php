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
            <div class="container-full">
                <div class="heading text-center">Danh sách sản phẩm</div>
            </div>
        </div>

        <section class="flat-spacing-1">
            <div class="container">
                <div class="tf-shop-control grid-3 align-items-center">
                    <div class="tf-control-filter">
                        <!-- <a href="#filterShop" data-bs-toggle="offcanvas" aria-controls="offcanvasLeft" class="tf-btn-filter"><span class="icon icon-filter"></span><span class="text">Filter</span></a> -->
                    </div>

                </div>
                <div class="tf-row-flex">
                    <aside class="tf-shop-sidebar wrap-sidebar-mobile">
                    <div class="widget-facet wd-categories">
                        <div class="widget-facet wd-categories">
                            <div class="facet-title" data-bs-target="#categories" data-bs-toggle="collapse" aria-expanded="true" aria-controls="categories">
                                <span>Product categories</span>
                                <span class="icon icon-arrow-up"></span>
                            </div>
                            <div id="categories" class="collapse show">
                                <ul class="list-categoris current-scrollbar mb_36">
                                    <li class="cate-item current"><a href="#"><span>Fashion</span>&nbsp;<span>(31)</span></a></li>
                                    <li class="cate-item"><a href="#"><span>Men</span>&nbsp;<span>(9)</span></a></li>
                                    <li class="cate-item"><a href="#"><span>Women</span>&nbsp;<span>(23)</span></a></li>
                                    <li class="cate-item"><a href="#"><span>Denim</span>&nbsp;<span>(20)</span></a></li>
                                    <li class="cate-item"><a href="#"><span>Dress</span>&nbsp;<span>(23)</span></a></li>
                                </ul>
                            </div>
                        </div>

                        </div>
                        <div class="widget-facet">
                        <div class="widget-facet">
                            <div class="facet-title" data-bs-target="#sale-products" data-bs-toggle="collapse" aria-expanded="true" aria-controls="sale-products">
                                <span>Sale products</span>
                                <span class="icon icon-arrow-up"></span>
                            </div>
                            <div id="sale-products" class="collapse show">
                                <div class="widget-featured-products mb_36">
                                    <div class="featured-product-item">
                                        <a href="product-detail.html" class="card-product-wrapper">
                                            <img class="img-product ls-is-cached lazyloaded" data-src="images/products/img-feature-1.png" alt="image-feature" src="images/products/img-feature-1.png">
                                        </a>
                                        <div class="card-product-info">
                                            <a href="#" class="title link">Jersey thong body</a>
                                            <span class="price">$105.95</span>
                                        </div>
                                    </div>
                                    <div class="featured-product-item">
                                        <a href="product-detail.html" class="card-product-wrapper">
                                            <img class="img-product ls-is-cached lazyloaded" data-src="images/products/img-feature-2.png" alt="image-feature" src="images/products/img-feature-2.png">
                                        </a>
                                        <div class="card-product-info">
                                            <a href="#" class="title link">Lace-trimmed Satin Camisole Top</a>
                                            <span class="price">€24,95</span>
                                        </div>
                                    </div>
                                    <div class="featured-product-item">
                                        <a href="product-detail.html" class="card-product-wrapper">
                                            <img class="img-product ls-is-cached lazyloaded" data-src="images/products/img-feature-3.png" alt="image-feature" src="images/products/img-feature-3.png">
                                        </a>
                                        <div class="card-product-info">
                                            <a href="#" class="title link">Linen-blend Tank Top</a>
                                            <span class="price">$16.95</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        </div>
                        <div class="widget-facet">
                            <div class="facet-title" data-bs-target="#shipping" data-bs-toggle="collapse" aria-expanded="true" aria-controls="shipping">
                                <span>Shipping &amp; Delivery</span>
                                <span class="icon icon-arrow-up"></span>
                            </div>
                       
                        </div>


                    </aside>
                    <div class="tf-shop-content">
                        <div class="grid-layout wrapper-shop" data-grid="grid-3">
                            <?php foreach ($Z as $product): ?>
                                <div class="card-product">
                                    <div class="card-product-wrapper">
                                        <a href="?act=product_description&product_id=<?php echo $product['id']; ?>" class="product-img"> 
                                            <img class="img-product" src="<?php echo $product['hinh_anh']; ?>" alt="<?php echo $product['ten_san_pham']; ?>"> 
                                            <img class="img-hover" src="<?php echo $product['hinh_anh']; ?>" alt="<?php echo $product['ten_san_pham']; ?>"> 
                                        </a>
                                        <div class="list-product-btn absolute-2">
                                            <a href="#quick_add" data-bs-toggle="modal" class="box-icon bg_white quick-add tf-btn-loading">
                                                <span class="icon icon-bag"></span>
                                                <span class="tooltip">Quick Add</span>
                                            </a>
                                            <a href="?act=addtowishlist&product_id=<?php echo $product['id']; ?>" class="box-icon bg_white wishlist btn-icon-action"> 
                                                <span class="icon icon-heart"></span> 
                                                <span class="tooltip">Add to Wishlist</span> 
                                                <span class="icon icon-delete"></span> 
                                            </a>
                                            <a href="#compare" data-bs-toggle="offcanvas" aria-controls="offcanvasLeft" class="box-icon bg_white compare btn-icon-action">
                                                <span class="icon icon-compare"></span>
                                                <span class="tooltip">Add to Compare</span>
                                                <span class="icon icon-check"></span>
                                            </a>
                                            <a href="#quick_view" data-bs-toggle="modal" class="box-icon bg_white quickview tf-btn-loading">
                                                <span class="icon icon-view"></span>
                                                <span class="tooltip">Quick View</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-product-info">
                                        <a href="product-detail.php?id=<?php echo $product['id']; ?>" class="title link"><?php echo $product['ten_san_pham']; ?></a>
                                        <span class="price"><?php echo number_format($product['gia_san_pham'], 2); ?> VND</span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <!-- pagination -->
                        <ul class="tf-pagination-wrap tf-pagination-list">
                            <li class="active">
                                <a href="#" class="pagination-link">1</a>
                            </li>
                            <li>
                                <a href="#" class="pagination-link animate-hover-btn">2</a>
                            </li>
                            <li>
                                <a href="#" class="pagination-link animate-hover-btn">3</a>
                            </li>
                            <li>
                                <a href="#" class="pagination-link animate-hover-btn">4</a>
                            </li>
                            <li>
                                <a href="#" class="pagination-link animate-hover-btn">
                                    <span class="icon icon-arrow-right"></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                
            </div>
        </section>
</body>
    <?php require_once './views/layout/footer.php' ?>
</html>
