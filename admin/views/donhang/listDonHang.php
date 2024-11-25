<?php require './views/layout/header.php' ?>
<?php require './views/layout/navbar.php' ?>
<?php require './views/layout/sidebar.php' ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Quản lý danh sách đơn hàng</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">


            <div class="card">
              <div class="card-header">

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                   <th>STT</th>
                   <th>Mã đơn hàng</th>
                   <th>Tên người nhận</th>
                   <th>Số điện thoại</th>
                   <th>Ngày đặt</th>
                   <th>Tổng tiền</th>
                   <th>Trạng thái</th>
                   <th>Thao tác</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php foreach($listDonHang as $key=>$donHang): ?>
                  <tr>
                  <td><?= $key+1 ?></td>
                  <td><?=$donHang['ma_don_hang'] ?></td>
                  <td><?=$donHang['ten_nguoi_nhan'] ?></td>
                  <td><?=$donHang['sdt_nguoi_nhan'] ?></td>
                  <td><?=$donHang['ngay_dat'] ?></td>
                  <td><?=$donHang['tong_tien'] ?></td>
                  <td><?=$donHang['ten_trang_thai'] ?></td>

                  <!-- Toán tử ba ngôi -->
                  <td><?=$donHang['ten_trang_thai'] ==1 ? 'còn bán' : 'dừng bán'  ?></td> 
                  <td >
                    <div class="btn-group">
                    <a href="<?= BASE_URL_ADMIN . '?act=chi-tiet-don-hang&id_don_hang=' . $donHang['id'] ?>"> 
                      <button class="btn btn-primary"><i class="far fa-eye"></i></button>
                    </a>
                    <a href="<?= BASE_URL_ADMIN . '?act=form-sua-don_hang&id_don_hang=' . $donHang['id'] ?>"> 
                      <button class="btn btn-warning"><i class="fas fa-cogs"></i></button>
                    </a>

                    </div>
                  </td>
                  </tr>
                  <?php endforeach ?>
                
                  </tbody>
                  <tfoot>
                  <tr>
                   <th>STT</th>
                   <th>Mã đơn hàng</th>
                   <th>Tên người nhận</th>
                   <th>Số điện thoại</th>
                   <th>Ngày đặt</th>
                   <th>Tổng tiền</th>
                   <th>Trạng thái</th>
                   <th>Thao tác</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
   <!-- footer -->
    <?php require './views/layout/footer.php'; ?>
    <!-- end footer -->

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
<!-- Code injected by live-server -->

</body>
</html>
