<?php require './views/layout/header.php' ?>
<?php require './views/layout/navbar.php' ?>
<?php require './views/layout/sidebar.php' ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-4">
            <h1>Quản lý danh sách sản phẩm</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

<!-- Default box -->
<div class="card card-solid">
  <div class="card-body">
    <div class="row">
      <div class="col-12 col-sm-4">
        <h3 class="d-inline-block">
        <div class="col-12">
          
          <img style="width: 390px; height: 500px" src="<?= getImageUrl($sanPham['hinh_anh']) ?>" class="product-image" alt="Product Image">
        </div>
        <div class="col-12 product-image-thumbs">
          <?php foreach($listAnhSanPham as $key=>$anhSP): ?>
          <div class="product-image-thumb" ><img src="<?= BASE_URL . $anhSP['link_hinh_anh']; ?>" alt="Product Image"></div>
       <?php endforeach ?>
        </div>
      </div>
      <div class="col-12 col-sm-6">
        <h3 class="my-3">Tên sản phẩm: <?= $sanPham['ten_san_pham']?></p>
       <hr>

        <h4 class="mt-3">Giá tiền: <small><?= $sanPham['gia_san_pham']?></small></h4>
        <h4 class="mt-3">Giá khuyến mãi: <small><?= $sanPham['gia_khuyen_mai']?></small></h4>
        <h4 class="mt-3">Số lượng: <small><?= $sanPham['so_luong']?></small></h4>
        <h4 class="mt-3">Lượt xem: <small><?= $sanPham['luot_xem']?></small></h4>
        <h4 class="mt-3">Giá tiền: <small><?= $sanPham['gia_san_pham']?></small></h4>
        <h4 class="mt-3">Ngày nhập: <small><?= $sanPham['ngay_nhap']?></small></h4>
        <h4 class="mt-3">Danh mục: <small><?= $sanPham['ten_danh_muc']?></small></h4>
        <h4 class="mt-3">Trạng thái: <small><?= $sanPham['trang_thai'] == 1 ? 'còn bán' : 'Dừng bán' ?></small></h4>
        <h4 class="mt-3">Mô tả: <small><?= $sanPham['mo_ta']?></small></h4>







      </div>
    </div>
    <!-- <div class="row mt-4">
      <nav class="w-100">
        <div class="nav nav-tabs" id="product-tab" role="tablist">
          <a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab" href="#binh-luan" role="tab" aria-controls="product-desc" aria-selected="true">bình luận của sản phẩm</a>
        </div>
      </nav>
      <div class="tab-content p-3" id="nav-tabContent">
        <div class="tab-pane fade show active" id="binh-luan" role="tabpanel" aria-labelledby="product-desc-tab"> 
          <div class="container-fluid ">

          
          
          </div>
      </div>
      </div>
    </div> -->
    <ul class="nav nav-tabs row mt-4" id="myTab" role="tablist" >
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Bình luận của sản phẩm</button>
  </li>
 
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
  <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Tên người bình luận</th>
                <th>Nội dung</th>
                <th>Ngày đăng</th>
                <th>Thao tác</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                  <div class="btn-group">
                    <a href="#"><button class="btn btn-warning">Ẩn</button></a>
                    <a href="#"><button class="btn btn-danger">Xóa</button></a>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
  </div>
 
</div>

  </div>
  <!-- /.card-body -->
</div>
<!-- /.card -->

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
 <!-- "" -->
 <script>
    const thumbs = document.querySelectorAll('.product-image-thumb');

    // Lấy ảnh chính
    const mainImage = document.querySelector('.product-image');

    // Gán sự kiện click cho mỗi thumbnail
    thumbs.forEach((thumb, index) => {
        thumb.addEventListener('click', () => {
            // Xóa lớp active khỏi tất cả thumbnail
            thumbs.forEach(t => t.classList.remove('active'));

            // Thêm lớp active cho thumbnail hiện tại
            thumb.classList.add('active');

            // Thay đổi ảnh chính
            mainImage.src = thumb.querySelector('img').src;
        });
    });
</script>

</body>
</html>
