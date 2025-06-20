<!-- Start Header Area -->
<header class="header-area header-wide">
        <!-- main header start -->
        <div class="main-header d-none d-lg-block">
            <!-- header top start -->

            <!-- header middle area start -->
            <div class="header-main-area sticky">
                <div class="container">
                    <div class="row align-items-center position-relative">

                        <!-- start logo area -->
                        <div class="col-lg-2">
                            <div class="logo">
                                <a href="<?= BASE_URL ?> ?>">
                                    <img src="<?= BASE_URL ?>assets/img/logo/lg.png" alt="Brand Logo">
                                </a>
                            </div>
                        </div>
                        <!-- start logo area -->

                        <!-- main menu area start -->
                        <div class="col-lg-6 position-static">
                            <div class="main-menu-area">
                                <div class="main-menu">
                                    <!-- main menu navbar start -->
                                    <nav class="desktop-menu">
                                        <ul>
                                            <li class="active"><a href="<?= BASE_URL. '?act=/'?>">Trang chủ</i></a>
                                               
                                            </li>                                            <li class="active"><a href="<?= BASE_URL. '?act=productlist'?>">Sản phẩm</i></a>
                                            <li><a href="#">Giới thiệu</a></li>
                                            <li><a href="<?= BASE_URL . '?act=lienhe' ?>">Liên hệ</a></li>
                                        </ul>
                                    </nav>
                                    <!-- main menu navbar end -->
                                </div>
                            </div>
                        </div>
                        <!-- main menu area end -->

                        <!-- mini cart area start -->
                        <div class="col-lg-4">
                            <div class="header-right d-flex align-items-center justify-content-xl-between justify-content-lg-end">                                <div class="header-search-container">
                                    <button class="search-trigger d-xl-none d-lg-block"><i class="pe-7s-search"></i></button>
                                    <form class="header-search-box d-lg-none d-xl-block" action="<?= BASE_URL ?>?act=tim-kiem" method="GET">
                                        <input type="hidden" name="act" value="tim-kiem">
                                        <input type="text" name="keyword" placeholder="Nhập tên sản phẩm" class="header-search-field" value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>" required>
                                        <button type="submit" class="header-search-btn"><i class="pe-7s-search"></i></button>
                                    </form>
                                </div>
                                <div class="header-configure-area">
                                    <ul class="nav justify-content-end">
                                        <label for="">
                                            <?php if (isset($_SESSION['user_client'])) {
                                            //   echo $_SESSION['user_client'];
                                            } ?>
                                        </label>
                                        <li class="user-hover">
                                            <a href="#">
                                                <i class="pe-7s-user"></i>
                                            </a>
                                            <ul class="dropdown-list">
                                            <?php if (!isset($_SESSION['user_client'])) {?>
                                                <li><a href="<?= BASE_URL .'?act=login'?> ">Đăng nhập</a></li>
                                                <li><a href="<?= BASE_URL .'?act=register'?> ">Đăng ký</a></li>
                                             
                                          <?php  } else {?>                                                <li>Xin Chào, <?= $_SESSION['user_client']['ho_ten'] ?></li>
                                                <li><a href="<?= BASE_URL .'?act=thong-tin-nguoi-dung'?> ">Tài khoản</a></li>
                                                <li><a href="<?= BASE_URL .'?act=lich-su-mua-hang'?> ">Đơn hàng</a></li>
                                                <li><a onclick="return confirm('Bạn muốn đăng xuất??')" href="<?= BASE_URL .'?act=logout'?> ">Đăng Xuất</a></li>
                                                <?php }?>
                                            </ul>
                                        </li>
                                       
                                        <li>
                                            <a href="#" class="minicart-btn">
                                                <i class="pe-7s-shopbag"></i>
                                                <div class="notification">2</div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- mini cart area end -->

                    </div>
                </div>
            </div>
            <!-- header middle area end -->
        </div>
        <!-- main header start -->

        
        
    </header>
    <!-- end Header Area -->