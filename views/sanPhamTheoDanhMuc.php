<?php require_once'layout/header.php'; ?>
<?php require_once'layout/menu.php'; ?>

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
                                <li class="breadcrumb-item active" aria-current="page">
                                    <?= $danhMuc ? $danhMuc['ten_danh_muc'] : 'Tất cả sản phẩm' ?>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->

    <!-- page main wrapper start -->
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
                                <ul class="shop-categories">
                                    <li><a href="<?= BASE_URL . '?act=san-pham-theo-danh-muc' ?>">Tất cả sản phẩm</a></li>
                                    <?php foreach($listDanhMuc as $category): ?>
                                        <li>
                                            <a href="<?= BASE_URL . '?act=san-pham-theo-danh-muc&danh_muc_id=' . $category['id'] ?>"
                                               class="<?= (isset($_GET['danh_muc_id']) && $_GET['danh_muc_id'] == $category['id']) ? 'active' : '' ?>">
                                                <?= $category['ten_danh_muc'] ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
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
                                    <div class="top-bar-left">
                                        <div class="product-view-mode">
                                            <a class="active" href="#" data-target="grid-view" data-bs-toggle="tooltip" title="Grid View"><i class="fa fa-th"></i></a>
                                            <a href="#" data-target="list-view" data-bs-toggle="tooltip" title="List View"><i class="fa fa-list"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-6 order-1 order-md-2">
                                    <div class="top-bar-right">
                                        <div class="product-short">
                                            <p>Tìm thấy <?= count($listSanPham) ?> sản phẩm</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- shop product top wrap end -->

                        <!-- product item list wrapper start -->
                        <div class="shop-product-wrap grid-view row mbn-30">
                            <?php if (!empty($listSanPham)): ?>
                                <?php foreach($listSanPham as $key => $sanPham): ?>
                                    <!-- product single item start -->
                                    <div class="col-md-4 col-sm-6">
                                        <div class="product-item modern-card">
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
                                                    if ($tinhNgay->days <= 7) {
                                                    ?>     
                                                        <div class="product-label new"> 
                                                            <span>Mới</span>
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
                                                    <?php } else {?>
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
                                    </div>
                                    <!-- product single item end -->
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="col-12">
                                    <div class="text-center py-5">
                                        <h4>Không có sản phẩm nào trong danh mục này</h4>
                                        <p>Vui lòng chọn danh mục khác hoặc quay lại trang chủ</p>
                                        <a href="<?= BASE_URL ?>" class="btn btn-primary">Về trang chủ</a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <!-- product item list wrapper end -->
                    </div>
                </div>
                <!-- shop main wrapper end -->
            </div>
        </div>
    </div>
    <!-- page main wrapper end -->
</main>

<?php require_once 'layout/miniCart.php'; ?>
<?php require_once 'layout/footer.php'; ?>
