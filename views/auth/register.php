<?php require_once 'views/layout/header.php';  ?>
<?php require_once 'views/layout/menu.php';  ?>
<!-- login register wrapper start -->
<div class="login-register-wrapper section-padding">
    <div class="container">
        <div class="member-area-from-wrap">
            <div class="row">
                <!-- Login Content Start -->
                <!-- <div class="col-lg-6">
                            <div class="login-reg-form-wrap">
                                <h5>Sign In</h5>
                                <form action="#" method="post">
                                    <div class="single-input-item">
                                        <input type="email" placeholder="Email or Username" required />
                                    </div>
                                    <div class="single-input-item">
                                        <input type="password" placeholder="Enter your Password" required />
                                    </div>
                                    <div class="single-input-item">
                                        <div class="login-reg-form-meta d-flex align-items-center justify-content-between">
                                            <div class="remember-meta">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="rememberMe">
                                                    <label class="custom-control-label" for="rememberMe">Remember Me</label>
                                                </div>
                                            </div>
                                            <a href="#" class="forget-pwd">Forget Password?</a>
                                        </div>
                                    </div>
                                    <div class="single-input-item">
                                        <button class="btn btn-sqr">Login</button>
                                    </div>
                                </form>
                            </div>
                        </div> -->
                <!-- Login Content End -->

                <!-- Register Content Start -->
                <div class="col-lg-6">
                    <div class="login-reg-form-wrap sign-up-form">
                        <h5 class="text-center">Đăng kí</h5>
                        <form action="<?= BASE_URL . '?act=register' ?>" method="post">
                            <div class="col-md-12">
                                <div class="single-input-item">
                                    <input type="text" name="ho_ten" placeholder="Nhập tên của bạn...." value="" />
                                </div>
                                <div class="single-input-item">
                                    <input type="email" name="email" placeholder="Nhập email...." value="" />
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="single-input-item">
                                            <input type="password" name="mat_khau" placeholder="Nhập mật khẩu..." value="" />
                                            <?php if (isset($errors['email'])): ?>
                                                <span class="text-danger"><?= $errors['email'] ?></span><?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="single-input-item">
                                            <input type="password" name="xac_nhan_mat_khau" placeholder="Confirm Passwwork" value="" />
                                        </div>
                                    </div>
                                    <?php if (isset($errors['password'])): ?>
                                            <span class="text-danger"><?= $errors['password'] ?></span>
                                        <?php endif; ?>

                                </div>
                            </div>
                            <div class="single-input-item">
                                <div class="login-reg-form-meta">
                                    <div class="remember-meta">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="subnewsletter">
                                            <label class="custom-control-label" for="subnewsletter">Đăng kí bản tin của chúng tôi</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="single-input-item">
                                <button class="btn btn-sqr"><a href="<?= BASE_URL.'?act=login'?>">Đăng kí</a> </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Register Content End -->
            </div>
        </div>
    </div>
</div>
<!-- login register wrapper end -->



<?php require_once 'views/layout/footer.php' ?>