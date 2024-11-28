<?php require './views/layout/header.php'; ?>
<!-- Navbar -->
<?php include './views/layout/navbar.php'; ?>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<?php include './views/layout/sidebar.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1> Quản lí tải khoản cá nhân </h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      <div class="row">
        <!-- left column -->
        
          <div class="col-md-3">
            <div class="text-center">
              <img src="<?= BASE_URL_ADMIN . $thongTin['anh_dai_dien']?>" style="width: 100px;" class="avatar img-circle" alt="avatar" onerror="this.onerror=null;this.src='https://t4.ftcdn.net/jpg/02/29/75/83/360_F_229758328_7x8jwCwjtBMmC6rgFzLFhZoEpLobB6L8.jpg '">
              <h6 class="mt-2">Họ tên : <?= $thongTin['ho_ten'] ?></h6>
              <h6 class="mt-2">Chức vụ: <?= $thongTin['chuc_vu_id'] ?></h6>


            </div>
          </div>

          <!-- edit form column -->
          <div class="col-md-9 personal-info">
            <form action="<?= BASE_URL_ADMIN . '?act=sua-thong-tin-ca-nhan-quan-tri' ?>" method="post">
            <hr>
            <h3>Thông tin cá nhân</h3>
            

            <div class="card-body">
                <div class="form-group">
                    <label >Họ tên</label>
                    <input type="text" class="form-control" name="ho_ten" value="<?= $thongTin['ho_ten'] ?>" placeholder=" Nhập họ tên">
                    <?php if(isset($_SESSION['error']['ho_ten'])) {?>
                    <p class="text-danger"><?= $_SESSION['error']['ho_ten'] ?></p>
                  <?php  } ?>
                  </div>
                  <div class="form-group">
                    <label >Email</label>
                    <input type="email" class="form-control" name="email" value="<?= $thongTin['email'] ?>" placeholder=" Nhập email">
                    <?php if(isset($_SESSION['error']['email'])) {?>
                    <p class="text-danger"><?= $_SESSION['error']['email'] ?></p>
                  <?php  } ?>
                  </div>

                  <div class="form-group">
                    <label >Số điện thoại</label>
                    <input type="text" class="form-control" name="so_dien_thoai" value="<?= $thongTin['so_dien_thoai'] ?>" placeholder=" Nhập số điện thoại">
                    <?php if(isset($_SESSION['error']['so_dien_thoai'])) {?>
                    <p class="text-danger"><?= $_SESSION['error']['so_dien_thoai'] ?></p>
                  <?php  } ?>
                  </div>
                  <div class="form-group">
                    <label >Ngày sinh</label>
                    <input type="date" class="form-control" name="ngay_sinh" value="<?= $khachthongTinHang['ngay_sinh'] ?>" placeholder=" Nhập ngày sinh">
                    <?php if(isset($_SESSION['error']['ngay_sinh'])) {?>
                    <p class="text-danger"><?= $_SESSION['error']['ngay_sinh'] ?></p>
                  <?php  } ?>
                  </div>
                  <div class="form-group">
                    <label >Giới tính</label>
                    <select id="inputStatus" name="gioi_tinh" class="form-control custom-select">
                <option <?= $thongTin['gioi_tinh'] == 1 ?' selected' : '' ?> value="1">Nam</option>
                <option <?= $thongTin['gioi_tinh'] !==1 ?' selected' : '' ?> value="2">Nữ</option>
                </select>
                  </div>
                  <div class="form-group">
                    <label >Địa chỉ</label>
                    <input type="text" class="form-control" name="dia_chi" value="<?= $thongTin['dia_chi'] ?>" placeholder=" Nhập địa chỉ">
                    <?php if(isset($_SESSION['error']['dia_chi'])) {?>
                    <p class="text-danger"><?= $_SESSION['error']['dia_chi'] ?></p>
                  <?php  } ?>
                  </div>
                  <div class="form-group">
                <label for="inputStatus">Trang thái tài khoản</label>
                <select id="inputStatus" name="trang_thai" class="form-control custom-select">
                <option <?= $thongTin['trang_thai'] == 1 ?' selected' : '' ?> value="1">Active</option>
                <option <?= $thongTin['trang_thai'] !==1 ?' selected' : '' ?> value="2">Inactive</option>
                </select>
                
              </div>    

                </div>
            <div class="form-group">
              <label class="col-md-3 control-label"></label>
              <div class="col-md-12">
                <input type="submit" class="btn btn-primary" value="Save Changes">

              </div>

            </div>
</form>
        <hr>
       
        <h3>Đổi mật khẩu</h3> 
        <?php if(isset( $_SESSION['success'] )) {?>
          <div class="alert alert-info alert-dismissable">
          <a class="panel-close close" data-dismiss="alert">×</a> 
          <i class="fa fa-coffee"></i>
          <?=  $_SESSION['success']  ;?>
        </div>
                  <?php  } ?>
        
        <form action="<?= BASE_URL_ADMIN . '?act=sua-mat-khau-ca-nhan-quan-tri' ?>" method="post">
          <div class="form-group">
            <label class="col-md-3 control-label">Mật khẩu cũ:</label>
            <div class="col-md-12">
              <input class="form-control" type="password" name="old_pass" value="">
              <?php if(isset($_SESSION['error']['old_pass'])) {?>
                    <p class="text-danger"><?= $_SESSION['error']['old_pass'] ?></p>
                  <?php  } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label">Mật khẩu mới:</label>
            <div class="col-md-12">
              <input class="form-control" type="password" name="new_pass" value="">
              <?php if(isset($_SESSION['error']['new_pass'])) {?>
                    <p class="text-danger"><?= $_SESSION['error']['new_pass'] ?></p>
                  <?php  } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label">Nhập lại mật khẩu:</label>
            <div class="col-md-12">
              <input class="form-control" type="password" name="confirm_pass" value="">
              <?php if(isset($_SESSION['error']['confirm_pass'])) {?>
                    <p class="text-danger"><?= $_SESSION['error']['confirm_pass'] ?></p>
                  <?php  } ?>
            </div>  
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label"></label>
            <div class="col-md-12">
              <input type="submit" class="btn btn-primary" value="Save Changes">

            </div>
          </div>
        </form>

      </div>
    </div>
</div>
<hr>
<!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include './views/layout/footer.php' ?>


</body>

</html>