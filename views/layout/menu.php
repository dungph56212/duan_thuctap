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
                                    <img src="assets/img/logo/lg.jpg" alt="Brand Logo">
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
                                            <li class="active"><a href="index.html">Trang chủ</i></a>
                                               
                                            </li>
                                           
                                            <li><a href="#">Sản phẩm <i class="fa fa-angle-down"></i></a>
                                                <ul class="dropdown">
                                                    <li><?=$danhMuc['ten_danh_muc'] ?></a></li>
                               
                                                </ul>
                                            </li>
                                            <li><a href="#">Giới thiệu</a></li>
                                            <li><a href="#">Liên hệ</a></li>
                                        </ul>
                                    </nav>
                                    <!-- main menu navbar end -->
                                </div>
                            </div>
                        </div>
                        <!-- main menu area end -->

                        <!-- mini cart area start -->
                        <div class="col-lg-4">
                            <div class="header-right d-flex align-items-center justify-content-xl-between justify-content-lg-end">
                                <div class="header-search-container">
                                    <button class="search-trigger d-xl-none d-lg-block"><i class="pe-7s-search"></i></button>
                                    <form class="header-search-box d-lg-none d-xl-block">
                                        <input type="text" placeholder="Nhập tên sản phẩm " class="header-search-field">
                                        <button class="header-search-btn"><i class="pe-7s-search"></i></button>
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
                                                <li><a href="<?= BASE_URL .'?act=register'?> ">Đăng kí</a></li>
                                             
                                          <?php  } else {?>
                                                <li>Xin Chào, <?= $_SESSION['user_client']['ho_ten'] ?></li>
                                                <li><a href="<?= BASE_URL .'?act=login'?> ">Tài khoản</a></li>
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