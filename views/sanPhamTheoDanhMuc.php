<?php require_once'layout/header.php'; ?>
<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/product-filter.css">
<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/product-filter-enhanced.css">
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
                        <!-- Filter Form -->
                        <form id="filter-form" method="GET" action="">
                            <input type="hidden" name="act" value="san-pham-theo-danh-muc">
                            <?php if(isset($_GET['danh_muc_id'])): ?>
                                <input type="hidden" name="danh_muc_id" value="<?= $_GET['danh_muc_id'] ?>">
                            <?php endif; ?>
                            
                            <!-- Category Filter -->
                            <div class="sidebar-single">
                                <h5 class="sidebar-title">Danh mục sản phẩm</h5>
                                <div class="sidebar-body">
                                    <ul class="shop-categories">
                                        <li>
                                            <a href="<?= BASE_URL . '?act=san-pham-theo-danh-muc' ?>" 
                                               class="<?= !isset($_GET['danh_muc_id']) ? 'active' : '' ?>">
                                                Tất cả sản phẩm
                                            </a>
                                        </li>
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

                            <!-- Quick Search -->
                            <div class="sidebar-single">
                                <h5 class="sidebar-title">Tìm kiếm nhanh</h5>
                                <div class="sidebar-body">
                                    <div class="search-box">
                                        <input type="text" 
                                               name="search" 
                                               class="form-control" 
                                               placeholder="Tìm sách theo tên, tác giả..."
                                               value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                                               onkeypress="if(event.key==='Enter') document.getElementById('filter-form').submit();">
                                        <i class="fa fa-search search-icon" onclick="document.getElementById('filter-form').submit();"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Price Range Filter -->
                            <div class="sidebar-single">
                                <h5 class="sidebar-title">Khoảng giá</h5>
                                <div class="sidebar-body">
                                    <div class="price-range-wrap">
                                        <div class="price-inputs">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label for="min_price">Từ:</label>
                                                    <input type="number" 
                                                           id="min_price" 
                                                           name="min_price" 
                                                           class="form-control form-control-sm" 
                                                           placeholder="0" 
                                                           value="<?= $_GET['min_price'] ?? '' ?>">
                                                </div>
                                                <div class="col-6">
                                                    <label for="max_price">Đến:</label>
                                                    <input type="number" 
                                                           id="max_price" 
                                                           name="max_price" 
                                                           class="form-control form-control-sm" 
                                                           placeholder="1,000,000" 
                                                           value="<?= $_GET['max_price'] ?? '' ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="price-buttons mt-3">
                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="setPriceRange(0, 100000)">
                                                Dưới 100k
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="setPriceRange(100000, 500000)">
                                                100k - 500k
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="setPriceRange(500000, 1000000)">
                                                500k - 1tr
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="setPriceRange(1000000, 999999999)">
                                                Trên 1tr
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sort Options -->
                            <div class="sidebar-single">
                                <h5 class="sidebar-title">Sắp xếp</h5>
                                <div class="sidebar-body">
                                    <select name="sort" class="form-control" onchange="document.getElementById('filter-form').submit();">
                                        <option value="default" <?= (!isset($_GET['sort']) || $_GET['sort'] == 'default') ? 'selected' : '' ?>>
                                            Mặc định
                                        </option>
                                        <option value="name" <?= (isset($_GET['sort']) && $_GET['sort'] == 'name') ? 'selected' : '' ?>>
                                            Tên A-Z
                                        </option>
                                        <option value="price-low" <?= (isset($_GET['sort']) && $_GET['sort'] == 'price-low') ? 'selected' : '' ?>>
                                            Giá thấp → cao
                                        </option>
                                        <option value="price-high" <?= (isset($_GET['sort']) && $_GET['sort'] == 'price-high') ? 'selected' : '' ?>>
                                            Giá cao → thấp
                                        </option>
                                        <option value="newest" <?= (isset($_GET['sort']) && $_GET['sort'] == 'newest') ? 'selected' : '' ?>>
                                            Mới nhất
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <!-- Status Filter -->
                            <div class="sidebar-single">
                                <h5 class="sidebar-title">Trạng thái</h5>
                                <div class="sidebar-body">
                                    <select name="status" class="form-control">
                                        <option value="">Tất cả</option>
                                        <option value="available" <?= (isset($_GET['status']) && $_GET['status'] == 'available') ? 'selected' : '' ?>>
                                            Còn hàng
                                        </option>
                                        <option value="sale" <?= (isset($_GET['status']) && $_GET['status'] == 'sale') ? 'selected' : '' ?>>
                                            Đang giảm giá
                                        </option>
                                        <option value="new" <?= (isset($_GET['status']) && $_GET['status'] == 'new') ? 'selected' : '' ?>>
                                            Sản phẩm mới
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <!-- Filter Actions -->
                            <div class="sidebar-single">
                                <div class="sidebar-body">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block mb-2">
                                        <i class="fa fa-filter"></i> Áp dụng bộ lọc
                                    </button>
                                    <a href="<?= BASE_URL . '?act=san-pham-theo-danh-muc' . (isset($_GET['danh_muc_id']) ? '&danh_muc_id=' . $_GET['danh_muc_id'] : '') ?>" 
                                       class="btn btn-outline-secondary btn-sm btn-block">
                                        <i class="fa fa-times"></i> Xóa bộ lọc
                                    </a>
                                </div>
                            </div>                        </form>
                    </aside>
                </div>
                <!-- sidebar area end -->

                <!-- shop main wrapper start -->
                <div class="col-lg-9 order-1 order-lg-2">
                    <div class="shop-product-wrapper">
                        <!-- shop product top wrap start -->
                        <div class="shop-top-bar">
                            <div class="row align-items-center mb-3">
                                <div class="col-lg-6 col-md-6 order-2 order-md-1">
                                    <div class="top-bar-left">
                                        <div class="product-view-mode">
                                            <a class="active" href="#" data-target="grid-view" data-bs-toggle="tooltip" title="Grid View">
                                                <i class="fa fa-th"></i>
                                            </a>
                                            <a href="#" data-target="list-view" data-bs-toggle="tooltip" title="List View">
                                                <i class="fa fa-list"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 order-1 order-md-2">
                                    <div class="top-bar-right">
                                        <div class="product-short">
                                            <p>Tìm thấy <strong><?= count($listSanPham) ?></strong> sản phẩm</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Active Filters Display -->
                            <?php 
                            $activeFilters = [];
                            if (!empty($_GET['search'])) $activeFilters[] = 'Tìm kiếm: "' . htmlspecialchars($_GET['search']) . '"';
                            if (!empty($_GET['min_price'])) $activeFilters[] = 'Giá từ: ' . number_format($_GET['min_price']) . 'đ';
                            if (!empty($_GET['max_price'])) $activeFilters[] = 'Giá đến: ' . number_format($_GET['max_price']) . 'đ';
                            if (!empty($_GET['status'])) {
                                $statusLabels = ['available' => 'Còn hàng', 'sale' => 'Đang giảm giá', 'new' => 'Sản phẩm mới'];
                                $activeFilters[] = 'Trạng thái: ' . $statusLabels[$_GET['status']];
                            }
                            if (!empty($_GET['sort']) && $_GET['sort'] != 'default') {
                                $sortLabels = ['name' => 'Tên A-Z', 'price-low' => 'Giá thấp → cao', 'price-high' => 'Giá cao → thấp', 'newest' => 'Mới nhất'];
                                $activeFilters[] = 'Sắp xếp: ' . $sortLabels[$_GET['sort']];
                            }
                            ?>
                            
                            <?php if (!empty($activeFilters)): ?>
                            <div class="active-filters mb-3">
                                <div class="filter-label">Bộ lọc đang áp dụng:</div>
                                <div class="filter-tags">
                                    <?php foreach ($activeFilters as $filter): ?>
                                        <span class="filter-tag"><?= $filter ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <!-- shop product top wrap end -->

                        <!-- product item list wrapper start -->
                        <div class="shop-product-wrap" id="grid-view">
                            <div class="row">
                                <?php if (!empty($listSanPham)): ?>
                                    <?php foreach ($listSanPham as $sanPham): ?>
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                            <!-- product single item start -->
                                            <div class="product-item">
                                                <figure class="product-thumb">
                                                    <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id']; ?>">
                                                        <img class="pri-img" 
                                                             src="<?= BASE_URL . $sanPham['hinh_anh'] ?>" 
                                                             alt="<?= $sanPham['ten_san_pham'] ?>">
                                                        <img class="sec-img" 
                                                             src="<?= BASE_URL . $sanPham['hinh_anh'] ?>" 
                                                             alt="<?= $sanPham['ten_san_pham'] ?>">
                                                    </a>
                                                    
                                                    <!-- Product Labels -->
                                                    <div class="product-badge">
                                                        <?php if ($sanPham['gia_khuyen_mai']): ?>
                                                            <?php 
                                                            $discount = round((($sanPham['gia_san_pham'] - $sanPham['gia_khuyen_mai']) / $sanPham['gia_san_pham']) * 100);
                                                            ?>
                                                            <div class="product-label discount" style="background-color: #ff6b6b;">
                                                                <span>-<?= $discount ?>%</span>
                                                            </div>
                                                        <?php endif; ?>
                                                        
                                                        <?php 
                                                        // Check if product is new (added within last 30 days)
                                                        $isNew = (strtotime($sanPham['ngay_nhap']) >= strtotime('-30 days'));
                                                        if ($isNew): 
                                                        ?>
                                                            <div class="product-label new" style="background-color: #51cf66;">
                                                                <span>Mới</span>
                                                            </div>
                                                        <?php endif; ?>
                                                        
                                                        <?php if ($sanPham['so_luong'] <= 0): ?>
                                                            <div class="product-label out-of-stock" style="background-color: #dc3545;">
                                                                <span>Hết hàng</span>
                                                            </div>
                                                        <?php elseif ($sanPham['so_luong'] <= 5): ?>
                                                            <div class="product-label low-stock" style="background-color: #ffc107;">
                                                                <span>Sắp hết</span>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    
                                                    <div class="cart-hover">
                                                        <button class="btn btn-cart">Xem chi tiết</button>
                                                    </div>
                                                </figure>
                                                <div class="product-caption text-center">
                                                    <h6 class="product-name">
                                                        <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id']; ?>">
                                                            <?= $sanPham['ten_san_pham'] ?>
                                                        </a>
                                                    </h6>
                                                    
                                                    <?php if (!empty($sanPham['tac_gia'])): ?>
                                                    <div class="product-author" style="font-size: 12px; color: #666; margin-bottom: 5px;">
                                                        Tác giả: <?= htmlspecialchars($sanPham['tac_gia']) ?>
                                                    </div>
                                                    <?php endif; ?>
                                                    
                                                    <div class="price-box">
                                                        <?php if ($sanPham['gia_khuyen_mai']): ?>
                                                            <span class="price-regular"><?= formatPrice($sanPham['gia_khuyen_mai']). 'đ'; ?></span>
                                                            <span class="price-old"><del><?= formatPrice($sanPham['gia_san_pham']). 'đ'; ?></del></span>
                                                        <?php else: ?>
                                                            <span class="price-regular"><?= formatPrice($sanPham['gia_san_pham']). 'đ' ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                    
                                                    <!-- Inventory info -->
                                                    <div class="inventory-info" style="margin-top: 5px; font-size: 12px;">
                                                        <?php if ($sanPham['so_luong'] > 0): ?>
                                                            <span class="text-success">Còn <?= $sanPham['so_luong'] ?> sản phẩm</span>
                                                        <?php else: ?>
                                                            <span class="text-danger">Hết hàng</span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- product single item end -->
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="col-12">
                                        <div class="text-center py-5">
                                            <i class="fa fa-search fa-3x text-muted mb-3"></i>
                                            <h4>Không tìm thấy sản phẩm</h4>
                                            <p>Không có sản phẩm nào phù hợp với bộ lọc của bạn</p>
                                            <a href="<?= BASE_URL . '?act=san-pham-theo-danh-muc' . (isset($_GET['danh_muc_id']) ? '&danh_muc_id=' . $_GET['danh_muc_id'] : '') ?>" 
                                               class="btn btn-primary">
                                                Xem tất cả sản phẩm
                                            </a>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <!-- product item list wrapper end -->
                    </div>
                </div>
                <!-- shop main wrapper end -->
            </div>        </div>
    </div>
    <!-- page main wrapper end -->
</main>

<script>
function setPriceRange(min, max) {
    document.getElementById('min_price').value = min > 0 ? min : '';
    document.getElementById('max_price').value = max < 999999999 ? max : '';
}

// Auto-submit form when search input changes (with debounce)
let searchTimeout;
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                document.getElementById('filter-form').submit();
            }, 800); // 800ms debounce for better UX
        });
    }
    
    // Initialize tooltips if Bootstrap is available
    if (typeof bootstrap !== 'undefined') {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
    
    // Auto-submit when other filters change
    const filterSelects = document.querySelectorAll('select[name="status"]');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            document.getElementById('filter-form').submit();
        });
    });
});
</script>

<?php require_once 'layout/miniCart.php'; ?>
<?php require_once 'layout/footer.php'; ?>
                                                    </div>
                                                </figure>
                                                <div class="product-caption text-center">
                                                    <h6 class="product-name">
                                                        <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id']; ?>">
                                                            <?= $sanPham['ten_san_pham'] ?>
                                                        </a>
                                                    </h6>
                                                    
                                                    <?php if (!empty($sanPham['tac_gia'])): ?>
                                                    <div class="product-author" style="font-size: 12px; color: #666; margin-bottom: 5px;">
                                                        Tác giả: <?= htmlspecialchars($sanPham['tac_gia']) ?>
                                                    </div>
                                                    <?php endif; ?>
                                                    
                                                    <div class="price-box">
                                                        <?php if ($sanPham['gia_khuyen_mai']): ?>
                                                            <span class="price-regular"><?= formatPrice($sanPham['gia_khuyen_mai']). 'đ'; ?></span>
                                                            <span class="price-old"><del><?= formatPrice($sanPham['gia_san_pham']). 'đ'; ?></del></span>
                                                        <?php else: ?>
                                                            <span class="price-regular"><?= formatPrice($sanPham['gia_san_pham']). 'đ' ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                    
                                                    <!-- Inventory info -->
                                                    <div class="inventory-info" style="margin-top: 5px; font-size: 12px;">
                                                        <?php if ($sanPham['so_luong'] > 0): ?>
                                                            <span class="text-success">Còn <?= $sanPham['so_luong'] ?> sản phẩm</span>
                                                        <?php else: ?>
                                                            <span class="text-danger">Hết hàng</span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- product single item end -->
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="col-12">
                                        <div class="text-center py-5">
                                            <i class="fa fa-search fa-3x text-muted mb-3"></i>
                                            <h4>Không tìm thấy sản phẩm</h4>
                                            <p>Không có sản phẩm nào phù hợp với bộ lọc của bạn</p>
                                            <a href="<?= BASE_URL . '?act=san-pham-theo-danh-muc' . (isset($_GET['danh_muc_id']) ? '&danh_muc_id=' . $_GET['danh_muc_id'] : '') ?>" 
                                               class="btn btn-primary">
                                                Xem tất cả sản phẩm
                                            </a>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <!-- product item list wrapper end -->
                    </div>
                </div>
                <!-- shop main wrapper end -->
                                    </div>
                                    <div class="col-lg-3 col-md-6 mb-3">
                                        <select id="quick-filter" class="form-control">
                                            <option value="">Lọc nhanh</option>
                                            <option value="available">Còn hàng</option>
                                            <option value="sale">Đang giảm giá</option>
                                            <option value="new">Sách mới</option>
                                            <option value="under-100k">Dưới 100k</option>
                                            <option value="100k-500k">100k - 500k</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-md-6 mb-3">
                                        <button type="button" id="clear-filters" class="btn btn-outline-secondary w-100">
                                            <i class="fa fa-refresh"></i> Xóa lọc
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Active Filters Display -->
                                <div id="active-filters" class="active-filters mt-2" style="display: none;">
                                    <span class="filter-label">Bộ lọc đang áp dụng:</span>
                                    <div id="filter-tags" class="filter-tags"></div>
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
                    </div>                </div>
                <!-- shop main wrapper end -->
            </div>
        </div>
    </div>
    <!-- page main wrapper end -->
</main>

<style>
/* Product Filter Styles */
.search-box {
    position: relative;
}

.search-box input {
    padding-right: 40px;
    border: 1px solid #ddd;
    border-radius: 6px;
}

.search-icon {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #666;
}

.advanced-filter-bar {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}

.filter-tags {
    display: inline-flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-left: 10px;
}

.filter-tag {
    background: #007bff;
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.filter-tag .remove {
    cursor: pointer;
    font-weight: bold;
}

.filter-label {
    font-weight: 600;
    color: #495057;
}

.sidebar-single {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
}

.sidebar-title {
    color: #2d3748;
    font-weight: 600;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 2px solid #e9ecef;
}

.form-check {
    margin-bottom: 8px;
}

.form-check-label {
    font-size: 14px;
    color: #4a5568;
    cursor: pointer;
}

.price-buttons .btn {
    font-size: 12px;
    padding: 6px 12px;
}

.product-item.hidden {
    display: none !important;
}

/* Animation for filter changes */
.product-item {
    transition: all 0.3s ease;
}

.shop-product-wrap {
    min-height: 400px;
}
</style>

<script>
function setPriceRange(min, max) {
    document.getElementById('min_price').value = min > 0 ? min : '';
    document.getElementById('max_price').value = max < 999999999 ? max : '';
}

// Auto-submit form when search input changes (with debounce)
let searchTimeout;
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                document.getElementById('filter-form').submit();
            }, 800); // 800ms debounce for better UX
        });
    }
    
    // Initialize tooltips if Bootstrap is available
    if (typeof bootstrap !== 'undefined') {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
    
    // Auto-submit when other filters change
    const filterSelects = document.querySelectorAll('select[name="status"]');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            document.getElementById('filter-form').submit();
        });
    });
});

// View mode toggle (if needed for future enhancement)
function toggleViewMode(mode) {
    const gridView = document.getElementById('grid-view');
    const viewModeLinks = document.querySelectorAll('.product-view-mode a');
    
    viewModeLinks.forEach(link => link.classList.remove('active'));
    event.target.classList.add('active');
    
    if (mode === 'list') {
        gridView.classList.add('list-view');
    } else {
        gridView.classList.remove('list-view');
    }
}
</script>

<?php require_once 'layout/miniCart.php'; ?>
<?php require_once 'layout/footer.php'; ?>
