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
                            </div>
                        </form>
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
                                                            <div class="product-label discount">
                                                                <span>-<?= $discount ?>%</span>
                                                            </div>
                                                        <?php endif; ?>
                                                        
                                                        <?php 
                                                        // Check if product is new (added within last 30 days)
                                                        $isNew = (strtotime($sanPham['ngay_nhap']) >= strtotime('-30 days'));
                                                        if ($isNew): 
                                                        ?>
                                                            <div class="product-label new">
                                                                <span>Mới</span>
                                                            </div>
                                                        <?php endif; ?>
                                                        
                                                        <?php if ($sanPham['so_luong'] <= 0): ?>
                                                            <div class="product-label out-of-stock">
                                                                <span>Hết hàng</span>
                                                            </div>
                                                        <?php elseif ($sanPham['so_luong'] <= 5): ?>
                                                            <div class="product-label low-stock">
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
                                                    <div class="product-author">
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
                                                    <div class="inventory-info">
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
        </div>
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
    const statusSelect = document.querySelector('select[name="status"]');
    if (statusSelect) {
        statusSelect.addEventListener('change', function() {
            document.getElementById('filter-form').submit();
        });
    }
    
    // Add loading effect to form submit
    const form = document.getElementById('filter-form');
    if (form) {
        form.addEventListener('submit', function() {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Đang lọc...';
                submitBtn.disabled = true;
            }
        });
    }
});
</script>

<?php require_once 'layout/miniCart.php'; ?>
<?php require_once 'layout/footer.php'; ?>
