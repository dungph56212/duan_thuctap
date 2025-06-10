<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= BASE_URL  ?>" class="brand-link" >
      <!-- <img src="./assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
      <span class="brand-text font-weight-light">

      <img style="height: 50px; width: 200px;" src="../assets/img/logo/lg.png" alt="Brand Logo">

      </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->


      <!-- SidebarSearch Form -->
 

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item">
            <a href="<?= BASE_URL_ADMIN ?>" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
              Trang chủ

              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= BASE_URL_ADMIN . '?act=danh-muc' ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Danh mục sản phẩm
 
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= BASE_URL_ADMIN . '?act=san-pham' ?>" class="nav-link">
              <i  class="fas fa-book"></> </i>
              <p>
                 Sản phẩm
 
              </p>
            </a>
          </li>          <li class="nav-item">
          <a href="<?= BASE_URL_ADMIN . '?act=don-hang' ?>" class="nav-link">
            <i class="fas fa-file-invoice-dollar"></i>
              <p>
              
               Đơn hàng
 
              </p>
            </a>
          </li>          <!-- Comment Management Section -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-comments"></i>
              <p>Quản lý bình luận</p>
              <i class="fas fa-angle-left right"></i>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= BASE_URL_ADMIN . '?act=binh-luan' ?>" class="nav-link">
                  <i class="fas fa-list"></i>
                  <p>Danh sách bình luận</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= BASE_URL_ADMIN . '?act=filter-binh-luan&trang_thai=pending' ?>" class="nav-link">
                  <i class="fas fa-clock"></i>
                  <p>Bình luận chờ duyệt</p>
                  <span id="pending-comments-badge" class="badge badge-warning right" style="display: none;">0</span>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= BASE_URL_ADMIN . '?act=filter-binh-luan&trang_thai=approved' ?>" class="nav-link">
                  <i class="fas fa-check-circle"></i>
                  <p>Bình luận đã duyệt</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= BASE_URL_ADMIN . '?act=filter-binh-luan&trang_thai=rejected' ?>" class="nav-link">
                  <i class="fas fa-times-circle"></i>
                  <p>Bình luận bị từ chối</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= BASE_URL_ADMIN . '?act=bao-cao-binh-luan' ?>" class="nav-link">
                  <i class="fas fa-chart-bar"></i>
                  <p>Báo cáo thống kê</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-boxes"></i>
              <p>Quản lý tồn kho</p>
              <i class="fas fa-angle-left right"></i>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= BASE_URL_ADMIN . '?act=quan-ly-ton-kho' ?>" class="nav-link">
                  <i class="fas fa-warehouse"></i>
                  <p>Tổng quan tồn kho</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= BASE_URL_ADMIN . '?act=lich-su-ton-kho' ?>" class="nav-link">
                  <i class="fas fa-history"></i>
                  <p>Lịch sử tồn kho</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= BASE_URL_ADMIN . '?act=canh-bao-ton-kho' ?>" class="nav-link">
                  <i class="fas fa-bell"></i>
                  <p>Cảnh báo tồn kho</p>
                  <span id="alert-badge" class="badge badge-danger right" style="display: none;">0</span>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>Quản lý tài khoản</p>
              <i class="fas fa-angle-left right"></i>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= BASE_URL_ADMIN . '?act=list-tai-khoan-quan-tri' ?>" class="nav-link">
                  <i class="nav-icon far fa-user"></i>
                  <p>Tài khoản quản trị</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="<?= BASE_URL_ADMIN . '?act=list-tai-khoan-khach-hang' ?>" class="nav-link">
                  <i class="nav-icon far fa-user"></i>
                  <p>Tài khoản khách hàng</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="<?= BASE_URL_ADMIN . '?act=form-sua-thong-tin-ca-nhan-quan-tri' ?>" class="nav-link">
                  <i class="nav-icon far fa-user"></i>
                  <p>Tài khoản cá nhân</p>
                </a>
              </li>
            </ul>
            
          </li>          <!-- Promotion Management Section -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-tags"></i>
              <p>Quản lý khuyến mãi</p>
              <i class="fas fa-angle-left right"></i>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= BASE_URL_ADMIN . '?act=danh-sach-khuyen-mai' ?>" class="nav-link">
                  <i class="fas fa-list"></i>
                  <p>Danh sách khuyến mãi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= BASE_URL_ADMIN . '?act=form-them-khuyen-mai' ?>" class="nav-link">
                  <i class="fas fa-plus-circle"></i>
                  <p>Thêm khuyến mãi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= BASE_URL_ADMIN . '?act=khuyen-mai-dang-hoat-dong' ?>" class="nav-link">
                  <i class="fas fa-play-circle text-success"></i>
                  <p>Đang hoạt động</p>
                  <span id="active-promotions-badge" class="badge badge-success right" style="display: none;">0</span>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= BASE_URL_ADMIN . '?act=khuyen-mai-sap-het-han' ?>" class="nav-link">
                  <i class="fas fa-clock text-warning"></i>
                  <p>Sắp hết hạn</p>
                  <span id="expiring-promotions-badge" class="badge badge-warning right" style="display: none;">0</span>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= BASE_URL_ADMIN . '?act=khuyen-mai-da-het-han' ?>" class="nav-link">
                  <i class="fas fa-stop-circle text-danger"></i>
                  <p>Đã hết hạn</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= BASE_URL_ADMIN . '?act=bao-cao-khuyen-mai' ?>" class="nav-link">
                  <i class="fas fa-chart-bar"></i>
                  <p>Báo cáo thống kê</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= BASE_URL_ADMIN . '?act=cai-dat-khuyen-mai' ?>" class="nav-link">
                  <i class="fas fa-cogs"></i>
                  <p>Cài đặt</p>
                </a>
              </li>
            </ul>
          </li>
         </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>