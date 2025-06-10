<?php require_once 'views/layout/header.php'; ?>
<style>
.auth-bg {
    min-height: 100vh;
    background: linear-gradient(135deg, #e0e7ff 0%, #f8fafc 100%);
    display: flex;
    align-items: center;
    justify-content: center;
}
.auth-card {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.12);
    padding: 2.5rem 2rem 2rem 2rem;
    max-width: 420px;
    width: 100%;
    margin: 2rem 0;
    animation: fadeIn .7s;
}
@keyframes fadeIn { from { opacity: 0; transform: translateY(40px);} to { opacity: 1; transform: none;}}
.auth-card .icon {
    font-size: 3rem;
    color: #6366f1;
    margin-bottom: 1rem;
    display: flex;
    justify-content: center;
}
.auth-card h3 {
    font-weight: 700;
    color: #22223b;
}
.auth-card .form-control {
    border-radius: 10px;
    font-size: 1.08rem;
    padding: 0.75rem 1rem;
    margin-bottom: 1rem;
    border: 1.5px solid #e0e7ff;
    transition: border-color 0.2s;
}
.auth-card .form-control:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 2px #6366f133;
}
.auth-card .btn-main {
    background: linear-gradient(90deg, #6366f1 0%, #60a5fa 100%);
    color: #fff;
    border: none;
    border-radius: 24px;
    font-weight: 600;
    font-size: 1.1rem;
    padding: 0.7rem 0;
    margin-top: 0.5rem;
    transition: background 0.2s;
}
.auth-card .btn-main:hover {
    background: linear-gradient(90deg, #60a5fa 0%, #6366f1 100%);
}
.auth-card .auth-links {
    display: flex;
    justify-content: space-between;
    margin-top: 1.2rem;
    font-size: 0.98rem;
}
.auth-card .auth-links a {
    color: #6366f1;
    text-decoration: none;
    transition: color 0.2s;
}
.auth-card .auth-links a:hover {
    color: #22223b;
    text-decoration: underline;
}
.auth-card .alert {
    border-radius: 8px;
    margin-top: 1rem;
    font-size: 1rem;
}
</style>
<div class="auth-bg">
  <div class="auth-card">
    <div class="icon"><i class="fa fa-user-circle"></i></div>
    <h3 class="text-center mb-3">Đăng nhập</h3>
    <?php echo displayNotification(); ?>
    <form action="<?= BASE_URL . '?act=check-login'?>" method="post">
      <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
      <input type="email" class="form-control" placeholder="Email hoặc tên đăng nhập" name="email" value="<?= old('email') ?>" required />
      <?= displayFieldError('email') ?>
      <input type="password" class="form-control" placeholder="Nhập mật khẩu" name="password" required />
      <?= displayFieldError('password') ?>
      <button class="btn btn-main w-100" type="submit">Đăng nhập</button>
      <div class="auth-links">
        <a href="<?= BASE_URL ?>?act=forgot-password"><i class="fa fa-unlock-alt"></i> Quên mật khẩu?</a>
        <a href="<?= BASE_URL. '?act=register' ?>"><i class="fa fa-user-plus"></i> Đăng ký</a>
      </div>
    </form>
  </div>
</div>
<?php require_once 'views/layout/footer.php'; ?>

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