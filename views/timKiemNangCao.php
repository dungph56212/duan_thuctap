<?php
// Tìm kiếm nâng cao đã bị xóa - Chuyển hướng về tìm kiếm cơ bản
header('Location: ' . BASE_URL . '?act=tim-kiem');
exit;
?>
                                            <option value="price_asc" <?= (isset($sortBy) && $sortBy == 'price_asc') ? 'selected' : '' ?>>Giá tăng dần</option>
                                            <option value="price_desc" <?= (isset($sortBy) && $sortBy == 'price_desc') ? 'selected' : '' ?>>Giá giảm dần</option>
                                            <option value="name_asc" <?= (isset($sortBy) && $sortBy == 'name_asc') ? 'selected' : '' ?>>Tên A-Z</option>
                                            <option value="name_desc" <?= (isset($sortBy) && $sortBy == 'name_desc') ? 'selected' : '' ?>>Tên Z-A</option>
                                            <option value="newest" <?= (isset($sortBy) && $sortBy == 'newest') ? 'selected' : '' ?>>Mới nhất</option>
                                            <option value="popular" <?= (isset($sortBy) && $sortBy == 'popular') ? 'selected' : '' ?>>Phổ biến</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Nút tìm kiếm -->
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button type="submit" class="btn btn-primary btn-block">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Results Section -->
    <div class="shop-main-wrapper section-padding">
        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3 order-2 order-lg-1">
                    <aside class="sidebar-wrapper">
                        <!-- Price Range Filter -->
                        <?php if (isset($priceRange) && $priceRange): ?>
                        <div class="sidebar-single">
                            <h4 class="sidebar-title">
                                <i class="fa fa-money"></i> Khoảng giá
                            </h4>
                            <div class="sidebar-body">
                                <div class="price-range-info">
                                    <p>Giá từ: <?= number_format($priceRange['min_price']) ?>đ</p>
                                    <p>Đến: <?= number_format($priceRange['max_price']) ?>đ</p>
                                </div>
                                <div class="quick-price-filters">
                                    <a href="<?= BASE_URL ?>?act=tim-kiem-nang-cao&keyword=<?= urlencode($keyword ?? '') ?>&max_price=100000" 
                                       class="btn btn-outline-secondary btn-sm">Dưới 100k</a>
                                    <a href="<?= BASE_URL ?>?act=tim-kiem-nang-cao&keyword=<?= urlencode($keyword ?? '') ?>&min_price=100000&max_price=300000" 
                                       class="btn btn-outline-secondary btn-sm">100k - 300k</a>
                                    <a href="<?= BASE_URL ?>?act=tim-kiem-nang-cao&keyword=<?= urlencode($keyword ?? '') ?>&min_price=300000" 
                                       class="btn btn-outline-secondary btn-sm">Trên 300k</a>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Categories -->
                        <?php if (!empty($listDanhMuc)): ?>
                        <div class="sidebar-single">
                            <h4 class="sidebar-title">
                                <i class="fa fa-list"></i> Danh mục
                            </h4>
                            <div class="sidebar-body">
                                <ul class="category-list">
                                    <?php foreach ($listDanhMuc as $danhMuc): ?>
                                        <li>
                                            <a href="<?= BASE_URL ?>?act=tim-kiem-nang-cao&keyword=<?= urlencode($keyword ?? '') ?>&category_id=<?= $danhMuc['id'] ?>" 
                                               class="category-link <?= (isset($categoryId) && $categoryId == $danhMuc['id']) ? 'active' : '' ?>">
                                                <i class="fa fa-folder-o"></i>
                                                <?= htmlspecialchars($danhMuc['ten_danh_muc']) ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <?php endif; ?>
                    </aside>
                </div>

                <!-- Main content -->
                <div class="col-lg-9 order-1 order-lg-2">
                    <!-- Results header -->
                    <div class="search-results-header">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h3 class="results-title">
                                    <?php if (!empty($keyword)): ?>
                                        Kết quả cho: "<?= htmlspecialchars($keyword) ?>"
                                    <?php else: ?>
                                        Tất cả sản phẩm
                                    <?php endif; ?>
                                </h3>
                                <p class="results-count">
                                    Tìm thấy <?= number_format($totalResults ?? 0) ?> sản phẩm
                                    <?php if (isset($totalPages) && $totalPages > 1): ?>
                                        - Trang <?= $page ?? 1 ?>/<?= $totalPages ?>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div class="col-md-6 text-right">
                                <div class="results-per-page">
                                    <label>Hiển thị:</label>
                                    <select onchange="changeLimit(this.value)" class="form-control form-control-sm d-inline-block" style="width: auto;">
                                        <option value="12" <?= (isset($limit) && $limit == 12) ? 'selected' : '' ?>>12</option>
                                        <option value="24" <?= (isset($limit) && $limit == 24) ? 'selected' : '' ?>>24</option>
                                        <option value="48" <?= (isset($limit) && $limit == 48) ? 'selected' : '' ?>>48</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Products grid -->
                    <?php if (!empty($searchResults)): ?>
                        <div class="search-results-grid">
                            <div class="row">
                                <?php foreach ($searchResults as $sanPham): ?>
                                    <div class="col-lg-4 col-md-6 col-sm-6">
                                        <div class="product-item">
                                            <div class="product-thumb">
                                                <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id'] ?>">
                                                    <img src="<?= BASE_URL . $sanPham['hinh_anh'] ?>" 
                                                         alt="<?= htmlspecialchars($sanPham['ten_san_pham']) ?>"
                                                         onerror="this.src='<?= BASE_URL ?>assets/img/no-image.jpg'">
                                                </a>
                                                <div class="product-action">
                                                    <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id'] ?>" 
                                                       class="action-btn" title="Xem chi tiết">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-category">
                                                    <span><?= htmlspecialchars($sanPham['ten_danh_muc'] ?? 'Chưa phân loại') ?></span>
                                                </div>
                                                <h3 class="product-title">
                                                    <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id'] ?>">
                                                        <?= htmlspecialchars($sanPham['ten_san_pham']) ?>
                                                    </a>
                                                </h3>
                                                <div class="product-author">
                                                    <i class="fa fa-user"></i>
                                                    <?= htmlspecialchars($sanPham['tac_gia']) ?>
                                                </div>
                                                <div class="product-price">
                                                    <span class="current-price"><?= number_format($sanPham['gia_khuyen_mai']) ?>đ</span>
                                                    <?php if ($sanPham['gia_san_pham'] > $sanPham['gia_khuyen_mai']): ?>
                                                        <span class="old-price"><?= number_format($sanPham['gia_san_pham']) ?>đ</span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="product-stats">
                                                    <span class="views">
                                                        <i class="fa fa-eye"></i> <?= number_format($sanPham['luot_xem']) ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <?php if (isset($totalPages) && $totalPages > 1): ?>
                            <div class="pagination-area">
                                <nav aria-label="Phân trang">
                                    <ul class="pagination justify-content-center">
                                        <?php if ($page > 1): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="<?= BASE_URL ?>?act=tim-kiem-nang-cao&keyword=<?= urlencode($keyword ?? '') ?>&page=<?= $page - 1 ?>&category_id=<?= $categoryId ?? '' ?>&min_price=<?= $minPrice ?? '' ?>&max_price=<?= $maxPrice ?? '' ?>&sort=<?= $sortBy ?? '' ?>">
                                                    <i class="fa fa-angle-left"></i>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                                            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                                <a class="page-link" href="<?= BASE_URL ?>?act=tim-kiem-nang-cao&keyword=<?= urlencode($keyword ?? '') ?>&page=<?= $i ?>&category_id=<?= $categoryId ?? '' ?>&min_price=<?= $minPrice ?? '' ?>&max_price=<?= $maxPrice ?? '' ?>&sort=<?= $sortBy ?? '' ?>">
                                                    <?= $i ?>
                                                </a>
                                            </li>
                                        <?php endfor; ?>

                                        <?php if ($page < $totalPages): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="<?= BASE_URL ?>?act=tim-kiem-nang-cao&keyword=<?= urlencode($keyword ?? '') ?>&page=<?= $page + 1 ?>&category_id=<?= $categoryId ?? '' ?>&min_price=<?= $minPrice ?? '' ?>&max_price=<?= $maxPrice ?? '' ?>&sort=<?= $sortBy ?? '' ?>">
                                                    <i class="fa fa-angle-right"></i>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </nav>
                            </div>
                        <?php endif; ?>

                    <?php else: ?>
                        <!-- No results -->
                        <div class="no-results">
                            <div class="text-center">
                                <i class="fa fa-search" style="font-size: 64px; color: #ddd; margin-bottom: 20px;"></i>
                                <h3>Không tìm thấy sản phẩm nào</h3>
                                <p>Vui lòng thử lại với từ khóa khác hoặc bỏ bớt điều kiện lọc</p>
                                <a href="<?= BASE_URL ?>" class="btn btn-primary">Về trang chủ</a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
function changeLimit(newLimit) {
    const url = new URL(window.location);
    url.searchParams.set('limit', newLimit);
    url.searchParams.set('page', '1'); // Reset về trang 1
    window.location.href = url.toString();
}

// Auto-submit form when filters change
document.querySelectorAll('.advanced-search-form select, .advanced-search-form input[type="number"]').forEach(element => {
    element.addEventListener('change', function() {
        // Optional: Auto-submit form when filters change
        // this.form.submit();
    });
});
</script>

<?php require_once 'layout/footer.php'; ?>
