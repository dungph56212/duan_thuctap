<?php require_once 'views/layout/header.php';  ?>
<?php require_once 'views/layout/menu.php';  ?>

<main>
        <!-- breadcrumb area start -->
        <div class="breadcrumb-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumb-wrap">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-home"></i></a></li>
                                    <li class="breadcrumb-item active" aria-current="page">login-Register</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb area end -->

        <!-- login register wrapper start -->
        <div class="login-register-wrapper section-padding">
            <div class="container" style="max-width:40vw">
                <div class="member-area-from-wrap">
                    <div class="row">
                        <!-- Login Content Start -->                        <div class="col-lg-12">
                            <div class="login-reg-form-wrap">
                                <h5 class="text-center">Đăng nhập</h5>
                                
                                <!-- Display notifications -->
                                <?php echo displayNotification(); ?>
                                
                                <p class="login-box-msg text-center">Vui lòng đăng nhập</p>                                  <form action="<?= BASE_URL . '?act=check-login'?>" method="post">
                                    <!-- CSRF Token -->
                                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                                    
                                    <div class="single-input-item">
                                        <input type="email" 
                                               placeholder="Email hoặc tên đăng nhập" 
                                               name="email" 
                                               value="<?= old('email') ?>"
                                               required />
                                        <?= displayFieldError('email') ?>
                                    </div>
                                    <div class="single-input-item">
                                        <input type="password" 
                                               placeholder="Nhập mật khẩu" 
                                               name="password" 
                                               required />
                                        <?= displayFieldError('password') ?>
                                    </div>
                                    <div class="single-input-item">
                                        <div class="login-reg-form-meta d-flex align-items-center justify-content-between">
                                            <a href="#" class="forget-pwd">Quên mật khẩu</a>
                                            <a href="<?= BASE_URL. '?act=register' ?>" class="forget-pwd">Đăng ký tài khoản</a> 
                                        </div>
                                    </div>
                                    <div class="single-input-item">
                                        <button class="btn btn-sqr" type="submit">Đăng nhập</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
        <!-- login register wrapper end -->

    </main>


<!-- offcanvas mini cart start -->
<div class="offcanvas-minicart-wrapper">
    <div class="minicart-inner">
        <div class="offcanvas-overlay"></div>
        <div class="minicart-inner-content">
            <div class="minicart-close">
                <i class="pe-7s-close"></i>
            </div>
            <div class="minicart-content-box">
                <div class="minicart-item-wrapper">
                    <ul>
                        <li class="minicart-item">
                            <div class="minicart-thumb">
                                <a href="product-details.html">
                                    <img src="<?= BASE_URL ?>assets/img/cart/cart-1.jpg" alt="product">
                                </a>
                            </div>
                            <div class="minicart-content">
                                <h3 class="product-name">
                                    <a href="product-details.html">Dozen White Botanical Linen Dinner Napkins</a>
                                </h3>
                                <p>
                                    <span class="cart-quantity">1 <strong>&times;</strong></span>
                                    <span class="cart-price">$100.00</span>
                                </p>
                            </div>
                            <button class="minicart-remove"><i class="pe-7s-close"></i></button>
                        </li>
                        <li class="minicart-item">
                            <div class="minicart-thumb">
                                <a href="product-details.html">
                                    <img src="<?= BASE_URL ?>assets/img/cart/cart-2.jpg" alt="product">
                                </a>
                            </div>
                            <div class="minicart-content">
                                <h3 class="product-name">
                                    <a href="product-details.html">Dozen White Botanical Linen Dinner Napkins</a>
                                </h3>
                                <p>
                                    <span class="cart-quantity">1 <strong>&times;</strong></span>
                                    <span class="cart-price">$80.00</span>
                                </p>
                            </div>
                            <button class="minicart-remove"><i class="pe-7s-close"></i></button>
                        </li>
                    </ul>
                </div>

                <div class="minicart-pricing-box">
                    <ul>
                        <li>
                            <span>sub-total</span>
                            <span><strong>$300.00</strong></span>
                        </li>
                        <li>
                            <span>Eco Tax (-2.00)</span>
                            <span><strong>$10.00</strong></span>
                        </li>
                        <li>
                            <span>VAT (20%)</span>
                            <span><strong>$60.00</strong></span>
                        </li>
                        <li class="total">
                            <span>total</span>
                            <span><strong>$370.00</strong></span>
                        </li>
                    </ul>
                </div>

                <div class="minicart-button">
                    <a href="cart.html"><i class="fa fa-shopping-cart"></i> View Cart</a>
                    <a href="cart.html"><i class="fa fa-share"></i> Checkout</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- offcanvas mini cart end -->
<?php require_once 'views/layout/footer.php' ?>