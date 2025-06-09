<?php require_once 'layout/header.php';  ?>
<?php require_once 'layout/menu.php';  ?>

<main>    <!-- breadcrumb area start -->
    <div class="breadcrumb-area" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 60px 0;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb" style="background: transparent; margin-bottom: 0; padding: 0;">
                                <li class="breadcrumb-item">
                                    <a href="<?= BASE_URL ?>" style="color: #007bff; text-decoration: none;">
                                        <i class="fa fa-home"></i> Trang chủ
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="#" style="color: #6c757d; text-decoration: none;">Sản phẩm</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page" style="color: #495057; font-weight: 600;">
                                    Chi tiết sản phẩm
                                </li>
                            </ul>
                        </nav>
                        <h1 style="color: #212529; font-size: 2.5rem; font-weight: 700; margin-top: 20px; margin-bottom: 10px;">
                            <?= $sanPham['ten_san_pham'] ?>
                        </h1>
                        <p style="color: #6c757d; font-size: 1.1rem; margin-bottom: 0;">
                            Khám phá chi tiết và đặt hàng ngay hôm nay
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->    <!-- page main wrapper start -->
    <div class="shop-main-wrapper section-padding" style="background: #ffffff; padding: 80px 0;">
        <div class="container">
            <div class="row">
                <!-- product details wrapper start -->
                <div class="col-lg-12 order-1 order-lg-2">
                    <!-- product details inner end -->
                    <div class="product-details-inner" style="background: #ffffff; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); padding: 40px; margin-bottom: 40px;">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="product-image-section" style="position: relative;">
                                    <div class="product-large-slider" style="border-radius: 12px; overflow: hidden; margin-bottom: 20px;">
                                        <?php foreach ($listAnhSanPham as $key => $anhSanPham):   ?>
                                            <div class="pro-large-img img-zoom" style="position: relative; overflow: hidden; border-radius: 12px;">
                                                <img src="<?= BASE_URL . $anhSanPham['link_hinh_anh'] ?>" 
                                                     alt="product-details" 
                                                     style="width: 100%; height: 400px; object-fit: cover; transition: transform 0.3s ease;" />
                                                <div class="image-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(45deg, rgba(0,123,255,0.1), rgba(0,123,255,0.05)); opacity: 0; transition: opacity 0.3s ease;"></div>
                                            </div>
                                        <?php endforeach ?>
                                    </div>
                                    <div class="pro-nav slick-row-10 slick-arrow-style" style="margin-top: 15px;">
                                        <?php foreach ($listAnhSanPham as $key => $anhSanPham):   ?>
                                            <div class="pro-nav-thumb" style="margin: 0 8px;">
                                                <img src="<?= BASE_URL . $anhSanPham['link_hinh_anh'] ?>" 
                                                     alt="product-details" 
                                                     style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 2px solid #e9ecef; cursor: pointer; transition: all 0.3s ease;" />
                                            </div>
                                        <?php endforeach ?>
                                    </div>
                                </div>
                            </div>                            <div class="col-lg-6">
                                <div class="product-details-des" style="padding-left: 30px;">
                                    <div class="manufacturer-name" style="margin-bottom: 15px;">
                                        <span style="background: linear-gradient(135deg, #007bff, #0056b3); color: white; padding: 8px 16px; border-radius: 20px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">
                                            <?= $sanPham['ten_danh_muc'] ?>
                                        </span>
                                    </div>
                                    <h2 class="product-name" style="color: #212529; font-size: 2.2rem; font-weight: 700; margin-bottom: 20px; line-height: 1.3;">
                                        <?= $sanPham['ten_san_pham'] ?>
                                    </h2>
                                    <div class="ratings d-flex align-items-center" style="margin-bottom: 25px;">
                                        <div class="stars" style="color: #ffc107; margin-right: 15px;">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                        </div>
                                        <div class="pro-review">
                                            <?php $countComment = count($listBinhLuan); ?>
                                            <span style="color: #6c757d; font-size: 14px;">
                                                <i class="fa fa-comment-o"></i> <?= $countComment ?> đánh giá
                                            </span>
                                        </div>
                                    </div>
                                    <div class="price-box" style="margin-bottom: 30px; padding: 20px; background: linear-gradient(135deg, #f8f9fa, #e9ecef); border-radius: 12px; border-left: 4px solid #007bff;">
                                        <?php if ($sanPham['gia_khuyen_mai']) { ?>
                                            <div class="price-container d-flex align-items-center">
                                                <span class="price-regular" style="color: #007bff; font-size: 2.2rem; font-weight: 700; margin-right: 15px;">
                                                    <?= formatPrice($sanPham['gia_khuyen_mai']) . 'đ'; ?>
                                                </span>
                                                <span class="price-old" style="color: #6c757d; font-size: 1.3rem; text-decoration: line-through;">
                                                    <?= formatPrice($sanPham['gia_san_pham']) . 'đ'; ?>
                                                </span>
                                                <span class="discount-badge" style="background: linear-gradient(135deg, #dc3545, #c82333); color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; margin-left: 15px;">
                                                    -<?= round((($sanPham['gia_san_pham'] - $sanPham['gia_khuyen_mai']) / $sanPham['gia_san_pham']) * 100) ?>%
                                                </span>
                                            </div>
                                        <?php } else { ?>
                                            <span class="price-regular" style="color: #007bff; font-size: 2.2rem; font-weight: 700;">
                                                <?= formatPrice($sanPham['gia_san_pham']) . 'đ' ?>
                                            </span>
                                        <?php } ?>
                                    </div>                                    <!-- Enhanced inventory display -->
                                    <div class="availability" style="margin-bottom: 25px; padding: 15px; background: #f8f9fa; border-radius: 10px; border-left: 4px solid #007bff;">
                                        <?php if ($sanPham['so_luong'] > 0): ?>
                                            <?php if ($sanPham['so_luong'] > 10): ?>
                                                <i class="fa fa-check-circle" style="color: #28a745; font-size: 1.2rem; margin-right: 10px;"></i>
                                                <span style="color: #28a745; font-weight: 600; font-size: 1.1rem;">Còn hàng (<?= $sanPham['so_luong'] ?> sản phẩm)</span>
                                            <?php elseif ($sanPham['so_luong'] > 5): ?>
                                                <i class="fa fa-exclamation-triangle" style="color: #ffc107; font-size: 1.2rem; margin-right: 10px;"></i>
                                                <span style="color: #ffc107; font-weight: 600; font-size: 1.1rem;">Còn ít hàng (<?= $sanPham['so_luong'] ?> sản phẩm)</span>
                                            <?php else: ?>
                                                <i class="fa fa-exclamation-triangle" style="color: #dc3545; font-size: 1.2rem; margin-right: 10px;"></i>
                                                <span style="color: #dc3545; font-weight: 600; font-size: 1.1rem;">Sắp hết hàng (<?= $sanPham['so_luong'] ?> sản phẩm)</span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <i class="fa fa-times-circle" style="color: #dc3545; font-size: 1.2rem; margin-right: 10px;"></i>
                                            <span style="color: #dc3545; font-weight: 600; font-size: 1.1rem;">Hết hàng</span>
                                        <?php endif; ?>
                                    </div>                                    
                                    <?php if ($sanPham['so_luong'] <= 5 && $sanPham['so_luong'] > 0): ?>
                                        <div class="stock-warning" style="background: linear-gradient(135deg, #fff3cd, #ffeaa7); border: 1px solid #ffc107; padding: 15px; border-radius: 10px; margin: 15px 0; box-shadow: 0 2px 10px rgba(255, 193, 7, 0.2);">
                                            <i class="fa fa-exclamation-triangle" style="color: #856404; font-size: 1.1rem; margin-right: 10px;"></i>
                                            <span style="color: #856404; font-weight: 600;">⚠️ Chỉ còn <?= $sanPham['so_luong'] ?> sản phẩm. Đặt hàng ngay để không bỏ lỡ!</span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="product-description" style="margin-bottom: 30px; padding: 20px; background: #f8f9fa; border-radius: 10px;">
                                        <h6 style="color: #495057; font-weight: 600; margin-bottom: 15px; font-size: 1.1rem;">Mô tả sản phẩm:</h6>
                                        <p style="color: #6c757d; line-height: 1.6; margin: 0;"><?= $sanPham['mo_ta'] ?></p>
                                    </div>
                                      <?php if ($sanPham['so_luong'] > 0): ?>
                                        <form action="<?= BASE_URL . '?act=them-gio-hang' ?>" method="post" id="addToCartForm" style="background: #ffffff; padding: 25px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); border: 1px solid #e9ecef;">
                                            <div class="quantity-cart-box">
                                                <div class="quantity-section" style="margin-bottom: 20px;">
                                                    <h6 class="option-title" style="color: #495057; font-weight: 600; margin-bottom: 15px; font-size: 1.1rem;">
                                                        <i class="fa fa-shopping-cart" style="color: #007bff; margin-right: 8px;"></i>
                                                        Số lượng:
                                                    </h6>
                                                    <div class="quantity-controls d-flex align-items-center" style="background: #f8f9fa; border-radius: 8px; padding: 8px; width: fit-content;">
                                                        <input type="hidden" name="san_pham_id" value="<?= $sanPham['id'] ?>">
                                                        <button type="button" class="qty-btn minus" style="background: #007bff; color: white; border: none; width: 35px; height: 35px; border-radius: 6px; cursor: pointer; font-size: 18px; font-weight: bold; transition: all 0.3s ease;">-</button>
                                                        <input type="number" value="1" name="so_luong" min="1" max="<?= $sanPham['so_luong'] ?>" id="quantityInput" style="width: 80px; height: 35px; border: 2px solid #e9ecef; border-radius: 6px; text-align: center; font-size: 16px; font-weight: 600; margin: 0 10px; outline: none; transition: border-color 0.3s ease;">
                                                        <button type="button" class="qty-btn plus" style="background: #007bff; color: white; border: none; width: 35px; height: 35px; border-radius: 6px; cursor: pointer; font-size: 18px; font-weight: bold; transition: all 0.3s ease;">+</button>
                                                    </div>
                                                    <small style="color: #6c757d; font-size: 13px; margin-top: 8px; display: block;">
                                                        <i class="fa fa-info-circle" style="margin-right: 5px;"></i>
                                                        Tối đa <?= $sanPham['so_luong'] ?> sản phẩm có thể đặt hàng
                                                    </small>
                                                </div>
                                                <div class="action-section">
                                                    <button type="submit" class="btn btn-cart2" id="addToCartBtn" style="background: linear-gradient(135deg, #007bff, #0056b3); color: white; border: none; padding: 15px 40px; border-radius: 8px; font-size: 16px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3); width: 100%;">
                                                        <i class="fa fa-cart-plus" style="margin-right: 10px;"></i>
                                                        Thêm vào giỏ hàng
                                                    </button>
                                                </div>
                                            </div>
                                        </form>                                        
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                const quantityInput = document.getElementById('quantityInput');
                                                const maxStock = <?= $sanPham['so_luong'] ?>;
                                                const minusBtn = document.querySelector('.qty-btn.minus');
                                                const plusBtn = document.querySelector('.qty-btn.plus');
                                                const addToCartBtn = document.getElementById('addToCartBtn');
                                                
                                                // Quantity control buttons
                                                minusBtn.addEventListener('click', function() {
                                                    let value = parseInt(quantityInput.value);
                                                    if (value > 1) {
                                                        quantityInput.value = value - 1;
                                                    }
                                                });
                                                
                                                plusBtn.addEventListener('click', function() {
                                                    let value = parseInt(quantityInput.value);
                                                    if (value < maxStock) {
                                                        quantityInput.value = value + 1;
                                                    }
                                                });
                                                
                                                // Button hover effects
                                                [minusBtn, plusBtn].forEach(btn => {
                                                    btn.addEventListener('mouseenter', function() {
                                                        this.style.background = '#0056b3';
                                                        this.style.transform = 'scale(1.05)';
                                                    });
                                                    btn.addEventListener('mouseleave', function() {
                                                        this.style.background = '#007bff';
                                                        this.style.transform = 'scale(1)';
                                                    });
                                                });
                                                
                                                // Add to cart button hover effect
                                                addToCartBtn.addEventListener('mouseenter', function() {
                                                    this.style.background = 'linear-gradient(135deg, #0056b3, #004494)';
                                                    this.style.transform = 'translateY(-2px)';
                                                    this.style.boxShadow = '0 8px 25px rgba(0, 123, 255, 0.4)';
                                                });
                                                addToCartBtn.addEventListener('mouseleave', function() {
                                                    this.style.background = 'linear-gradient(135deg, #007bff, #0056b3)';
                                                    this.style.transform = 'translateY(0)';
                                                    this.style.boxShadow = '0 4px 15px rgba(0, 123, 255, 0.3)';
                                                });
                                                
                                                // Input focus effect
                                                quantityInput.addEventListener('focus', function() {
                                                    this.style.borderColor = '#007bff';
                                                    this.style.boxShadow = '0 0 0 3px rgba(0, 123, 255, 0.1)';
                                                });
                                                quantityInput.addEventListener('blur', function() {
                                                    this.style.borderColor = '#e9ecef';
                                                    this.style.boxShadow = 'none';
                                                });
                                                
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
                                        </script>                                    <?php else: ?>
                                        <div class="out-of-stock" style="text-align: center; padding: 30px; background: linear-gradient(135deg, #f8f9fa, #e9ecef); border-radius: 12px; margin: 20px 0; border: 2px solid #dee2e6;">
                                            <div style="margin-bottom: 20px;">
                                                <i class="fa fa-times-circle" style="font-size: 3rem; color: #dc3545; margin-bottom: 15px;"></i>
                                            </div>
                                            <h5 style="color: #dc3545; margin-bottom: 15px; font-weight: 700; font-size: 1.4rem;">
                                                Sản phẩm tạm hết hàng
                                            </h5>
                                            <p style="color: #6c757d; margin-bottom: 20px; font-size: 1.1rem; line-height: 1.6;">
                                                Sản phẩm này hiện đang hết hàng. Vui lòng quay lại sau hoặc liên hệ với chúng tôi để biết thêm thông tin.
                                            </p>
                                            <button class="btn btn-secondary" disabled style="background: #6c757d; border: none; padding: 12px 30px; border-radius: 8px; font-weight: 600; cursor: not-allowed;">
                                                <i class="fa fa-ban" style="margin-right: 8px;"></i>
                                                Hết hàng
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- product details inner end -->                    <!-- product details reviews start -->
                    <div class="product-details-reviews section-padding pb-0" style="background: #ffffff; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); padding: 40px; margin-top: 40px;">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="product-review-info">
                                    <ul class="nav review-tab" style="border-bottom: 2px solid #e9ecef; margin-bottom: 30px;">
                                        <li>
                                            <a class="active" data-bs-toggle="tab" href="#tab_three" style="padding: 15px 25px; color: #007bff; font-weight: 600; font-size: 1.1rem; text-decoration: none; border-bottom: 3px solid #007bff; background: linear-gradient(135deg, rgba(0, 123, 255, 0.1), rgba(0, 123, 255, 0.05)); border-radius: 8px 8px 0 0;">
                                                <i class="fa fa-comments" style="margin-right: 8px;"></i>
                                                Bình luận (<?= $countComment ?>)
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content reviews-tab">                                        <div class="tab-pane fade show active" id="tab_three">
                                            <!-- Success/Error Messages -->
                                            <?php if (isset($_SESSION['success'])): ?>
                                                <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-bottom: 20px;">
                                                    <i class="fa fa-check-circle" style="margin-right: 8px;"></i>
                                                    <?= $_SESSION['success'] ?>
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                                <?php unset($_SESSION['success']); ?>
                                            <?php endif; ?>

                                            <?php if (isset($_SESSION['error'])): ?>
                                                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-bottom: 20px;">
                                                    <i class="fa fa-exclamation-circle" style="margin-right: 8px;"></i>
                                                    <?= $_SESSION['error'] ?>
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                                <?php unset($_SESSION['error']); ?>
                                            <?php endif; ?>

                                            <?php if (isset($_SESSION['comment_errors'])): ?>
                                                <div class="alert alert-warning alert-dismissible fade show" role="alert" style="margin-bottom: 20px;">
                                                    <i class="fa fa-exclamation-triangle" style="margin-right: 8px;"></i>
                                                    <ul style="margin: 0; padding-left: 20px;">
                                                        <?php foreach ($_SESSION['comment_errors'] as $error): ?>
                                                            <li><?= $error ?></li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                                <?php unset($_SESSION['comment_errors']); ?>
                                            <?php endif; ?>

                                            <div class="comments-section" style="margin-bottom: 40px;">
                                                <?php if (empty($listBinhLuan)): ?>
                                                    <div class="no-comments" style="text-align: center; padding: 40px; background: #f8f9fa; border-radius: 10px; margin-bottom: 30px;">
                                                        <i class="fa fa-comment-o" style="font-size: 3rem; color: #6c757d; margin-bottom: 15px;"></i>
                                                        <h5 style="color: #6c757d; margin-bottom: 10px;">Chưa có bình luận nào</h5>
                                                        <p style="color: #6c757d;">Hãy là người đầu tiên bình luận về sản phẩm này!</p>
                                                    </div>
                                                <?php else: ?>
                                                    <?php foreach ($listBinhLuan as $binhLuan): ?>
                                                        <div class="comment-item" id="comment-<?= $binhLuan['id'] ?>" style="background: #f8f9fa; border-radius: 12px; padding: 20px; margin-bottom: 20px; border-left: 4px solid #007bff; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                                                            <div class="comment-header" style="display: flex; align-items: center; margin-bottom: 15px;">
                                                                <div class="comment-avatar" style="margin-right: 15px;">
                                                                    <img src="<?= $binhLuan['anh_dai_dien'] ?: 'assets/img/default-avatar.png' ?>" alt="" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; border: 2px solid #007bff;">
                                                                </div>
                                                                <div class="comment-info" style="flex: 1;">
                                                                    <h6 style="color: #495057; font-weight: 600; margin: 0; font-size: 1rem;">
                                                                        <i class="fa fa-user" style="color: #007bff; margin-right: 8px;"></i>
                                                                        <?= htmlspecialchars($binhLuan['ho_ten']) ?>
                                                                    </h6>
                                                                    <small style="color: #6c757d; font-size: 12px;">
                                                                        <i class="fa fa-calendar" style="margin-right: 5px;"></i>
                                                                        <?= date('d/m/Y H:i', strtotime($binhLuan['ngay_dang'])) ?>
                                                                    </small>
                                                                </div>
                                                                <?php if (isset($_SESSION['user_client']) && $_SESSION['user_client']['id'] == $binhLuan['tai_khoan_id']): ?>
                                                                    <div class="comment-actions" style="display: flex; gap: 10px;">
                                                                        <button class="btn btn-sm btn-outline-primary edit-comment-btn" 
                                                                                data-comment-id="<?= $binhLuan['id'] ?>"
                                                                                data-comment-content="<?= htmlspecialchars($binhLuan['noi_dung']) ?>"
                                                                                style="font-size: 12px; padding: 4px 8px;">
                                                                            <i class="fa fa-edit"></i> Sửa
                                                                        </button>
                                                                        <button class="btn btn-sm btn-outline-danger delete-comment-btn" 
                                                                                data-comment-id="<?= $binhLuan['id'] ?>"
                                                                                style="font-size: 12px; padding: 4px 8px;">
                                                                            <i class="fa fa-trash"></i> Xóa
                                                                        </button>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                            
                                                            <div class="comment-content">
                                                                <p class="comment-text" style="color: #495057; line-height: 1.6; margin: 0; font-size: 14px;"><?= nl2br(htmlspecialchars($binhLuan['noi_dung'])) ?></p>
                                                                
                                                                <!-- Edit form (hidden by default) -->
                                                                <div class="edit-comment-form" style="display: none; margin-top: 15px;">
                                                                    <textarea class="form-control edit-comment-textarea" rows="3" style="border: 2px solid #007bff; border-radius: 8px; padding: 10px; font-size: 14px;"><?= htmlspecialchars($binhLuan['noi_dung']) ?></textarea>
                                                                    <div style="margin-top: 10px; display: flex; gap: 10px;">
                                                                        <button class="btn btn-sm btn-primary save-edit-btn" data-comment-id="<?= $binhLuan['id'] ?>">
                                                                            <i class="fa fa-save"></i> Lưu
                                                                        </button>
                                                                        <button class="btn btn-sm btn-secondary cancel-edit-btn">
                                                                            <i class="fa fa-times"></i> Hủy
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Admin Reply -->
                                                            <?php if (!empty($binhLuan['admin_reply'])): ?>
                                                                <div class="admin-reply" style="margin-top: 15px; padding: 15px; background: #e3f2fd; border-radius: 8px; border-left: 4px solid #2196f3;">
                                                                    <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                                                        <i class="fa fa-shield" style="color: #2196f3; margin-right: 8px;"></i>
                                                                        <strong style="color: #1976d2; font-size: 14px;">Phản hồi từ Admin</strong>
                                                                        <small style="color: #666; margin-left: 10px; font-size: 12px;">
                                                                            <?= date('d/m/Y H:i', strtotime($binhLuan['admin_reply_date'])) ?>
                                                                        </small>
                                                                    </div>
                                                                    <p style="color: #1565c0; margin: 0; font-size: 14px; line-height: 1.5;">
                                                                        <?= nl2br(htmlspecialchars($binhLuan['admin_reply'])) ?>
                                                                    </p>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php endforeach ?>
                                                <?php endif; ?>
                                            </div>                                            <div class="comment-form-section">
                                                <h5 style="color: #495057; font-weight: 600; margin-bottom: 20px; font-size: 1.3rem;">
                                                    <i class="fa fa-edit" style="color: #007bff; margin-right: 10px;"></i>
                                                    Viết bình luận của bạn
                                                </h5>
                                                
                                                <?php if (isset($_SESSION['user_client'])): ?>
                                                    <form action="<?= BASE_URL . '?act=add_comment&id_san_pham=' . $sanPham['id'] ?>" 
                                                          method="POST" 
                                                          class="review-form" 
                                                          id="commentForm"
                                                          style="background: #ffffff; padding: 25px; border-radius: 12px; border: 2px solid #e9ecef; box-shadow: 0 2px 15px rgba(0,0,0,0.05);">
                                                        
                                                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                                        
                                                        <div class="form-group row">
                                                            <div class="col">
                                                                <label class="col-form-label" style="color: #495057; font-weight: 600; margin-bottom: 10px; font-size: 15px;">
                                                                    <span class="text-danger">*</span>
                                                                    Nội dung bình luận
                                                                </label>
                                                                <textarea class="form-control" 
                                                                          required 
                                                                          name="noi_dung" 
                                                                          id="comment-content"
                                                                          rows="4" 
                                                                          minlength="10"
                                                                          maxlength="1000"
                                                                          placeholder="Chia sẻ cảm nhận của bạn về sản phẩm này... (tối thiểu 10 ký tự, tối đa 1000 ký tự)" 
                                                                          style="border: 2px solid #e9ecef; border-radius: 8px; padding: 15px; font-size: 14px; line-height: 1.6; resize: vertical; transition: all 0.3s ease; background: #f8f9fa;"><?= isset($_SESSION['comment_data']['noi_dung']) ? htmlspecialchars($_SESSION['comment_data']['noi_dung']) : '' ?></textarea>
                                                                
                                                                <div class="form-text" style="margin-top: 5px;">
                                                                    <small class="text-muted">
                                                                        <span id="char-count">0</span>/1000 ký tự
                                                                    </small>
                                                                </div>
                                                                
                                                                <div class="buttons" style="margin-top: 20px;">
                                                                    <button class="btn btn-sqr" 
                                                                            type="submit" 
                                                                            id="submit-comment"
                                                                            style="background: linear-gradient(135deg, #007bff, #0056b3); color: white; border: none; padding: 12px 30px; border-radius: 8px; font-weight: 600; font-size: 15px; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);">
                                                                        <i class="fa fa-paper-plane" style="margin-right: 8px;"></i>
                                                                        <span class="btn-text">Gửi bình luận</span>
                                                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <?php unset($_SESSION['comment_data']); ?>
                                                <?php else: ?>
                                                    <div class="login-prompt" style="background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 12px; padding: 20px; text-align: center;">
                                                        <i class="fa fa-lock" style="font-size: 2rem; color: #f39c12; margin-bottom: 15px;"></i>
                                                        <h6 style="color: #856404; margin-bottom: 10px;">Cần đăng nhập để bình luận</h6>
                                                        <p style="color: #856404; margin-bottom: 15px;">
                                                            Vui lòng đăng nhập để có thể chia sẻ cảm nhận của bạn về sản phẩm này.
                                                        </p>
                                                        <a href="<?= BASE_URL . '?act=login' ?>" 
                                                           class="btn btn-warning" 
                                                           style="color: white; text-decoration: none; padding: 10px 25px; border-radius: 8px; font-weight: 600;">
                                                            <i class="fa fa-sign-in" style="margin-right: 8px;"></i>
                                                            Đăng nhập ngay
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                                
                                                <style>
                                                    .form-control:focus {
                                                        border-color: #007bff !important;
                                                        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1) !important;
                                                        background: #ffffff !important;
                                                    }
                                                    .btn-sqr:hover {
                                                        background: linear-gradient(135deg, #0056b3, #004494) !important;
                                                        transform: translateY(-2px);
                                                        box-shadow: 0 8px 25px rgba(0, 123, 255, 0.4) !important;
                                                    }
                                                    .btn-sqr:disabled {
                                                        opacity: 0.6;
                                                        cursor: not-allowed;
                                                        transform: none;
                                                    }
                                                    .comment-item {
                                                        transition: all 0.3s ease;
                                                    }
                                                    .comment-item:hover {
                                                        box-shadow: 0 4px 20px rgba(0,0,0,0.1) !important;
                                                    }
                                                    .edit-comment-form .form-control:focus {
                                                        border-color: #007bff;
                                                        box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
                                                    }
                                                    .admin-reply {
                                                        animation: fadeIn 0.5s ease-in-out;
                                                    }
                                                    @keyframes fadeIn {
                                                        from { opacity: 0; transform: translateY(10px); }
                                                        to { opacity: 1; transform: translateY(0); }
                                                    }
                                                </style>
                                            </div>
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
                                    <figure class="product-thumb">
                                        <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $SanPham['id']; ?>">
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
        <!-- </div> -->    </section>
    <!-- related products area end -->

    <!-- Enhanced Comment Management JavaScript -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Character counter for comment textarea
        const commentTextarea = document.getElementById('comment-content');
        const charCount = document.getElementById('char-count');
        const submitBtn = document.getElementById('submit-comment');

        if (commentTextarea) {
            function updateCharCount() {
                const count = commentTextarea.value.length;
                charCount.textContent = count;
                
                if (count < 10) {
                    charCount.style.color = '#dc3545';
                    charCount.parentElement.style.color = '#dc3545';
                } else if (count > 900) {
                    charCount.style.color = '#fd7e14';
                    charCount.parentElement.style.color = '#fd7e14';
                } else {
                    charCount.style.color = '#28a745';
                    charCount.parentElement.style.color = '#6c757d';
                }
            }

            commentTextarea.addEventListener('input', updateCharCount);
            updateCharCount(); // Initial count

            // Form submission with loading state
            const commentForm = document.getElementById('commentForm');
            if (commentForm) {
                commentForm.addEventListener('submit', function(e) {
                    const content = commentTextarea.value.trim();
                    if (content.length < 10) {
                        e.preventDefault();
                        alert('Bình luận phải có ít nhất 10 ký tự');
                        return;
                    }
                    
                    // Show loading state
                    submitBtn.disabled = true;
                    submitBtn.querySelector('.btn-text').style.display = 'none';
                    submitBtn.querySelector('.spinner-border').style.display = 'inline-block';
                });
            }
        }

        // Edit comment functionality
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('edit-comment-btn') || e.target.parentElement.classList.contains('edit-comment-btn')) {
                const btn = e.target.classList.contains('edit-comment-btn') ? e.target : e.target.parentElement;
                const commentId = btn.getAttribute('data-comment-id');
                const commentItem = document.getElementById('comment-' + commentId);
                const commentText = commentItem.querySelector('.comment-text');
                const editForm = commentItem.querySelector('.edit-comment-form');
                const textarea = editForm.querySelector('.edit-comment-textarea');
                
                commentText.style.display = 'none';
                editForm.style.display = 'block';
                textarea.focus();
                
                btn.style.display = 'none';
                commentItem.querySelector('.delete-comment-btn').style.display = 'none';
            }

            if (e.target.classList.contains('cancel-edit-btn')) {
                const commentItem = e.target.closest('.comment-item');
                const commentText = commentItem.querySelector('.comment-text');
                const editForm = commentItem.querySelector('.edit-comment-form');
                const editBtn = commentItem.querySelector('.edit-comment-btn');
                const deleteBtn = commentItem.querySelector('.delete-comment-btn');
                
                commentText.style.display = 'block';
                editForm.style.display = 'none';
                editBtn.style.display = 'inline-block';
                deleteBtn.style.display = 'inline-block';
            }

            if (e.target.classList.contains('save-edit-btn')) {
                const btn = e.target;
                const commentId = btn.getAttribute('data-comment-id');
                const commentItem = document.getElementById('comment-' + commentId);
                const textarea = commentItem.querySelector('.edit-comment-textarea');
                const newContent = textarea.value.trim();
                
                if (newContent.length < 10) {
                    alert('Bình luận phải có ít nhất 10 ký tự');
                    return;
                }

                // Show loading
                btn.disabled = true;
                btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Đang lưu...';

                // AJAX request to update comment
                fetch('<?= BASE_URL ?>?act=edit_comment', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'comment_id=' + encodeURIComponent(commentId) + 
                          '&noi_dung=' + encodeURIComponent(newContent) +
                          '&csrf_token=' + encodeURIComponent('<?= $_SESSION['csrf_token'] ?>')
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update comment text
                        const commentText = commentItem.querySelector('.comment-text');
                        commentText.innerHTML = newContent.replace(/\n/g, '<br>');
                        
                        // Hide edit form
                        const editForm = commentItem.querySelector('.edit-comment-form');
                        const editBtn = commentItem.querySelector('.edit-comment-btn');
                        const deleteBtn = commentItem.querySelector('.delete-comment-btn');
                        
                        commentText.style.display = 'block';
                        editForm.style.display = 'none';
                        editBtn.style.display = 'inline-block';
                        deleteBtn.style.display = 'inline-block';
                        
                        showMessage('success', data.message);
                    } else {
                        showMessage('error', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showMessage('error', 'Có lỗi xảy ra khi cập nhật bình luận');
                })
                .finally(() => {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fa fa-save"></i> Lưu';
                });
            }

            if (e.target.classList.contains('delete-comment-btn') || e.target.parentElement.classList.contains('delete-comment-btn')) {
                const btn = e.target.classList.contains('delete-comment-btn') ? e.target : e.target.parentElement;
                const commentId = btn.getAttribute('data-comment-id');
                
                if (confirm('Bạn có chắc chắn muốn xóa bình luận này?')) {
                    btn.disabled = true;
                    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Đang xóa...';

                    fetch('<?= BASE_URL ?>?act=delete_comment', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'comment_id=' + encodeURIComponent(commentId) +
                              '&csrf_token=' + encodeURIComponent('<?= $_SESSION['csrf_token'] ?>')
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Remove comment with animation
                            const commentItem = document.getElementById('comment-' + commentId);
                            commentItem.style.transition = 'all 0.5s ease';
                            commentItem.style.opacity = '0';
                            commentItem.style.transform = 'translateX(-100%)';
                            
                            setTimeout(() => {
                                commentItem.remove();
                                showMessage('success', data.message);
                                
                                // Check if no comments left
                                const remainingComments = document.querySelectorAll('.comment-item');
                                if (remainingComments.length === 0) {
                                    location.reload(); // Reload to show "no comments" message
                                }
                            }, 500);
                        } else {
                            showMessage('error', data.message);
                            btn.disabled = false;
                            btn.innerHTML = '<i class="fa fa-trash"></i> Xóa';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showMessage('error', 'Có lỗi xảy ra khi xóa bình luận');
                        btn.disabled = false;
                        btn.innerHTML = '<i class="fa fa-trash"></i> Xóa';
                    });
                }
            }
        });

        // Show message function
        function showMessage(type, message) {
            // Remove existing alerts
            const existingAlerts = document.querySelectorAll('.alert');
            existingAlerts.forEach(alert => alert.remove());

            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
            
            const alertHtml = `
                <div class="alert ${alertClass} alert-dismissible fade show" role="alert" style="margin-bottom: 20px;">
                    <i class="fa ${iconClass}" style="margin-right: 8px;"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            
            const commentsSection = document.querySelector('.comments-section');
            if (commentsSection) {
                commentsSection.insertAdjacentHTML('beforebegin', alertHtml);
                
                // Auto dismiss after 5 seconds
                setTimeout(() => {
                    const alert = document.querySelector('.alert');
                    if (alert) {
                        alert.classList.remove('show');
                        setTimeout(() => alert.remove(), 150);
                    }
                }, 5000);
            }
        }

        // Auto-dismiss alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                if (alert.classList.contains('show')) {
                    alert.classList.remove('show');
                    setTimeout(() => alert.remove(), 150);
                }
            });
        }, 5000);
    });
    </script>

</main>






<?php require_once 'layout/miniCart.php'; ?>

<?php require_once 'layout/footer.php'; ?>