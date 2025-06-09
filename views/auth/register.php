<?php require_once 'views/layout/header.php';  ?>
<?php require_once 'views/layout/menu.php';  ?>
<!-- login register wrapper start -->
<div class="login-register-wrapper section-padding">
    <div class="container">
        <div class="member-area-from-wrap">
            <div class="row justify-content-center">
                <!-- Register Content Start -->
                <div class="col-lg-8">
                    <div class="login-reg-form-wrap sign-up-form">
                        <h5 class="text-center">Đăng ký tài khoản</h5>
                        
                        <!-- Display notifications -->
                        <?php echo displayNotification(); ?>
                          <form action="<?= BASE_URL . '?act=register' ?>" method="post">
                            <!-- CSRF Token -->
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="single-input-item">
                                        <input type="text" 
                                               name="ho_ten" 
                                               placeholder="Nhập họ tên của bạn..." 
                                               value="<?= old('ho_ten') ?>" 
                                               required />
                                        <?= displayFieldError('ho_ten') ?>
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="single-input-item">
                                        <input type="email" 
                                               name="email" 
                                               placeholder="Nhập email..." 
                                               value="<?= old('email') ?>" 
                                               required />
                                        <?= displayFieldError('email') ?>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="single-input-item">
                                        <input type="password" 
                                               name="mat_khau" 
                                               placeholder="Nhập mật khẩu..." 
                                               required />
                                        <?= displayFieldError('mat_khau') ?>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="single-input-item">
                                        <input type="password" 
                                               name="xac_nhan_mat_khau" 
                                               placeholder="Xác nhận mật khẩu..." 
                                               required />
                                        <?= displayFieldError('xac_nhan_mat_khau') ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="single-input-item">
                                <div class="login-reg-form-meta">
                                    <div class="remember-meta">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="subnewsletter">
                                            <label class="custom-control-label" for="subnewsletter">
                                                Đăng ký bản tin của chúng tôi
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="single-input-item">
                                <button class="btn btn-sqr" type="submit">Đăng ký</button>
                            </div>
                            
                            <div class="text-center mt-3">
                                <p>Đã có tài khoản? <a href="<?= BASE_URL.'?act=login'?>">Đăng nhập ngay</a></p>
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