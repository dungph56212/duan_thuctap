<!-- Header -->
<?php include './views/layout/header.php'; ?>

<!-- Navbar -->
<?php include './views/layout/navbar.php'; ?>

<!-- Main Sidebar Container -->
<?php include './views/layout/sidebar.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Quản Lý Tồn Kho</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Home</a></li>
            <li class="breadcrumb-item active">Quản Lý Tồn Kho</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Quick Actions -->
      <div class="row mb-4">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-bolt"></i>
                Thao Tác Nhanh
              </h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-3">
                  <a href="<?= BASE_URL_ADMIN . '?act=lich-su-ton-kho' ?>" class="btn btn-info btn-block">
                    <i class="fas fa-history"></i> Xem Lịch Sử Tồn Kho
                  </a>
                </div>
                <div class="col-md-3">
                  <a href="<?= BASE_URL_ADMIN . '?act=canh-bao-ton-kho' ?>" class="btn btn-warning btn-block">
                    <i class="fas fa-bell"></i> Xem Cảnh Báo Tồn Kho
                  </a>
                </div>
                <div class="col-md-3">
                  <a href="<?= BASE_URL_ADMIN . '?act=xuat-bao-cao-ton-kho' ?>" class="btn btn-success btn-block">
                    <i class="fas fa-file-excel"></i> Xuất Báo Cáo Excel
                  </a>
                </div>
                <div class="col-md-3">
                  <a href="<?= BASE_URL_ADMIN . '?act=san-pham' ?>" class="btn btn-primary btn-block">
                    <i class="fas fa-plus"></i> Thêm Sản Phẩm Mới
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
        <!-- Info cards -->
      <div class="row">
        <div class="col-lg-3 col-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h3><?= isset($inventoryStats['total_products']) ? $inventoryStats['total_products'] : 0 ?></h3>
              <p>Tổng Sản Phẩm</p>
            </div>
            <div class="icon">
              <i class="fas fa-boxes"></i>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box bg-success">
            <div class="inner">
              <h3><?= isset($inventoryStats['in_stock']) ? $inventoryStats['in_stock'] : 0 ?></h3>
              <p>Còn Hàng</p>
            </div>
            <div class="icon">
              <i class="fas fa-check-circle"></i>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box bg-warning">
            <div class="inner">
              <h3><?= isset($lowStockProducts) ? count($lowStockProducts) : 0 ?></h3>
              <p>Sắp Hết Hàng</p>
            </div>
            <div class="icon">
              <i class="fas fa-exclamation-triangle"></i>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box bg-danger">
            <div class="inner">
              <h3><?= isset($outOfStockProducts) ? count($outOfStockProducts) : 0 ?></h3>
              <p>Hết Hàng</p>
            </div>
            <div class="icon">
              <i class="fas fa-times-circle"></i>
            </div>
          </div>
        </div>
      </div>

      <!-- Out of Stock Products -->
      <?php if (!empty($outOfStockProducts)): ?>
      <div class="row">
        <div class="col-12">
          <div class="card card-danger">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-times-circle"></i>
                Sản Phẩm Hết Hàng
              </h3>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>STT</th>
                      <th>Hình Ảnh</th>
                      <th>Tên Sản Phẩm</th>
                      <th>Danh Mục</th>
                      <th>Giá</th>
                      <th>Tồn Kho</th>
                      <th>Thao Tác</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($outOfStockProducts as $key => $sanPham): ?>
                      <tr>
                        <td><?= $key + 1 ?></td>
                        <td>
                          <img src="<?= BASE_URL . $sanPham['hinh_anh'] ?>" 
                               style="width: 50px; height: 50px; object-fit: cover;" 
                               alt="<?= $sanPham['ten_san_pham'] ?>">
                        </td>
                        <td><?= $sanPham['ten_san_pham'] ?></td>
                        <td><?= $sanPham['ten_danh_muc'] ?></td>
                        <td><?= number_format($sanPham['gia_khuyen_mai'] ?: $sanPham['gia_san_pham']) ?>đ</td>
                        <td>
                          <span class="badge badge-danger">
                            <i class="fas fa-times"></i> <?= $sanPham['so_luong'] ?>
                          </span>
                        </td>
                        <td>
                          <form method="POST" action="<?= BASE_URL_ADMIN . '?act=cap-nhat-ton-kho' ?>" style="display: inline;">
                            <input type="hidden" name="san_pham_id" value="<?= $sanPham['id'] ?>">
                            <div class="input-group input-group-sm" style="width: 120px;">
                              <input type="number" name="so_luong_moi" class="form-control" min="1" value="10" required>
                              <div class="input-group-append">
                                <button type="submit" class="btn btn-primary btn-sm">
                                  <i class="fas fa-plus"></i>
                                </button>
                              </div>
                            </div>
                          </form>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php endif; ?>

      <!-- Low Stock Products -->
      <?php if (!empty($lowStockProducts)): ?>
      <div class="row">
        <div class="col-12">
          <div class="card card-warning">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-exclamation-triangle"></i>
                Sản Phẩm Sắp Hết Hàng (≤ 5 sản phẩm)
              </h3>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>STT</th>
                      <th>Hình Ảnh</th>
                      <th>Tên Sản Phẩm</th>
                      <th>Danh Mục</th>
                      <th>Giá</th>
                      <th>Tồn Kho</th>
                      <th>Thao Tác</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($lowStockProducts as $key => $sanPham): ?>
                      <tr>
                        <td><?= $key + 1 ?></td>
                        <td>
                          <img src="<?= BASE_URL . $sanPham['hinh_anh'] ?>" 
                               style="width: 50px; height: 50px; object-fit: cover;" 
                               alt="<?= $sanPham['ten_san_pham'] ?>">
                        </td>
                        <td><?= $sanPham['ten_san_pham'] ?></td>
                        <td><?= $sanPham['ten_danh_muc'] ?></td>
                        <td><?= number_format($sanPham['gia_khuyen_mai'] ?: $sanPham['gia_san_pham']) ?>đ</td>
                        <td>
                          <span class="badge badge-warning">
                            <i class="fas fa-exclamation-triangle"></i> <?= $sanPham['so_luong'] ?>
                          </span>
                        </td>
                        <td>
                          <form method="POST" action="<?= BASE_URL_ADMIN . '?act=cap-nhat-ton-kho' ?>" style="display: inline;">
                            <input type="hidden" name="san_pham_id" value="<?= $sanPham['id'] ?>">
                            <div class="input-group input-group-sm" style="width: 120px;">
                              <input type="number" name="so_luong_moi" class="form-control" min="1" value="20" required>
                              <div class="input-group-append">
                                <button type="submit" class="btn btn-primary btn-sm">
                                  <i class="fas fa-plus"></i>
                                </button>
                              </div>
                            </div>
                          </form>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php endif; ?>      <!-- All Products Inventory -->
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-boxes"></i>
                Tất Cả Sản Phẩm
              </h3>
              <div class="card-tools">
                <button type="button" class="btn btn-primary btn-sm" onclick="enableBulkEdit()">
                  <i class="fas fa-edit"></i> Chỉnh sửa hàng loạt
                </button>
                <a href="<?= BASE_URL_ADMIN . '?act=xuat-bao-cao-ton-kho' ?>" class="btn btn-success btn-sm">
                  <i class="fas fa-file-excel"></i> Xuất Excel
                </a>
              </div>
            </div>
            <div class="card-body">
              <!-- Bulk Update Form -->
              <form id="bulkUpdateForm" method="POST" action="<?= BASE_URL_ADMIN . '?act=cap-nhat-hang-loat-ton-kho' ?>" style="display: none;">
                <div class="row mb-3">
                  <div class="col-md-6">
                    <button type="submit" class="btn btn-success">
                      <i class="fas fa-save"></i> Lưu tất cả thay đổi
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="cancelBulkEdit()">
                      <i class="fas fa-times"></i> Hủy
                    </button>
                  </div>
                  <div class="col-md-6 text-right">
                    <small class="text-muted">Chỉ những sản phẩm có thay đổi mới được cập nhật</small>
                  </div>
                </div>
              </form>
              
              <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>STT</th>
                      <th>Hình Ảnh</th>
                      <th>Tên Sản Phẩm</th>
                      <th>Danh Mục</th>
                      <th>Giá</th>
                      <th>Tồn Kho</th>
                      <th>Trạng Thái</th>
                      <th>Thao Tác</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($allProducts as $key => $sanPham): ?>
                      <tr data-product-id="<?= $sanPham['id'] ?>">
                        <td><?= $key + 1 ?></td>
                        <td>
                          <img src="<?= BASE_URL . $sanPham['hinh_anh'] ?>" 
                               style="width: 50px; height: 50px; object-fit: cover;" 
                               alt="<?= $sanPham['ten_san_pham'] ?>">
                        </td>
                        <td><?= $sanPham['ten_san_pham'] ?></td>
                        <td><?= $sanPham['ten_danh_muc'] ?></td>
                        <td><?= number_format($sanPham['gia_khuyen_mai'] ?: $sanPham['gia_san_pham']) ?>đ</td>
                        <td>
                          <?php if ($sanPham['so_luong'] == 0): ?>
                            <span class="badge badge-danger">
                              <i class="fas fa-times"></i> <?= $sanPham['so_luong'] ?>
                            </span>
                          <?php elseif ($sanPham['so_luong'] <= 5): ?>
                            <span class="badge badge-warning">
                              <i class="fas fa-exclamation-triangle"></i> <?= $sanPham['so_luong'] ?>
                            </span>
                          <?php else: ?>
                            <span class="badge badge-success">
                              <i class="fas fa-check"></i> <?= $sanPham['so_luong'] ?>
                            </span>
                          <?php endif; ?>
                        </td>
                        <td>
                          <?php if ($sanPham['so_luong'] == 0): ?>
                            <span class="badge badge-danger">Hết hàng</span>
                          <?php elseif ($sanPham['so_luong'] <= 5): ?>
                            <span class="badge badge-warning">Sắp hết</span>
                          <?php else: ?>
                            <span class="badge badge-success">Còn hàng</span>
                          <?php endif; ?>
                        </td>
                        <td>
                          <!-- Single Update Form -->
                          <form method="POST" action="<?= BASE_URL_ADMIN . '?act=cap-nhat-ton-kho' ?>" style="display: inline;" class="single-update-form">
                            <input type="hidden" name="san_pham_id" value="<?= $sanPham['id'] ?>">
                            <div class="input-group input-group-sm" style="width: 120px;">
                              <input type="number" name="so_luong_moi" class="form-control" 
                                     min="0" value="<?= $sanPham['so_luong'] ?>" required>
                              <div class="input-group-append">
                                <button type="submit" class="btn btn-primary btn-sm">
                                  <i class="fas fa-save"></i>
                                </button>
                              </div>
                            </div>
                          </form>
                          
                          <!-- Bulk Update Input (Hidden by default) -->
                          <input type="number" class="form-control bulk-input" 
                                 style="display: none; width: 120px;" 
                                 min="0" value="<?= $sanPham['so_luong'] ?>" 
                                 data-original-value="<?= $sanPham['so_luong'] ?>"
                                 data-product-id="<?= $sanPham['id'] ?>">
                          
                          <a href="<?= BASE_URL_ADMIN . '?act=form-sua-san-pham&id_san_pham=' . $sanPham['id'] ?>" 
                             class="btn btn-warning btn-sm mt-1">
                            <i class="fas fa-edit"></i>
                          </a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Footer -->
<?php include './views/layout/footer.php'; ?>

<script>
$(function () {
  $("#example1").DataTable({
    "responsive": true, 
    "lengthChange": false, 
    "autoWidth": false,
    "pageLength": 10,
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Vietnamese.json"
    }
  }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
});

// Bulk edit functionality
let isBulkEditMode = false;

function enableBulkEdit() {
    isBulkEditMode = true;
    
    // Hide single update forms
    $('.single-update-form').hide();
    
    // Show bulk update inputs
    $('.bulk-input').show();
    
    // Show bulk update form
    $('#bulkUpdateForm').show();
    
    // Change button text
    $('.card-tools .btn-primary').text('Đang chỉnh sửa hàng loạt...');
    $('.card-tools .btn-primary').prop('disabled', true);
}

function cancelBulkEdit() {
    isBulkEditMode = false;
    
    // Show single update forms
    $('.single-update-form').show();
    
    // Hide bulk update inputs
    $('.bulk-input').hide();
    
    // Hide bulk update form
    $('#bulkUpdateForm').hide();
    
    // Reset all bulk inputs to original values
    $('.bulk-input').each(function() {
        $(this).val($(this).data('original-value'));
    });
    
    // Restore button
    $('.card-tools .btn-primary').html('<i class="fas fa-edit"></i> Chỉnh sửa hàng loạt');
    $('.card-tools .btn-primary').prop('disabled', false);
}

// Handle bulk form submission
$('#bulkUpdateForm').on('submit', function(e) {
    e.preventDefault();
    
    let updates = [];
    let hasChanges = false;
    
    // Collect all changed values
    $('.bulk-input').each(function() {
        let currentValue = parseInt($(this).val());
        let originalValue = parseInt($(this).data('original-value'));
        let productId = $(this).data('product-id');
        
        if (currentValue !== originalValue) {
            updates.push({
                san_pham_id: productId,
                so_luong_moi: currentValue
            });
            hasChanges = true;
        }
    });
    
    if (!hasChanges) {
        toastr.warning('Không có thay đổi nào để lưu!');
        return;
    }
    
    if (confirm(`Bạn có chắc chắn muốn cập nhật ${updates.length} sản phẩm?`)) {
        // Create form with updates
        let form = $('<form>', {
            method: 'POST',
            action: '<?= BASE_URL_ADMIN . "?act=cap-nhat-hang-loat-ton-kho" ?>'
        });
        
        updates.forEach(function(update, index) {
            form.append($('<input>', {
                type: 'hidden',
                name: `updates[${index}][san_pham_id]`,
                value: update.san_pham_id
            }));
            form.append($('<input>', {
                type: 'hidden',
                name: `updates[${index}][so_luong_moi]`,
                value: update.so_luong_moi
            }));
        });
        
        $('body').append(form);
        form.submit();
    }
});

// Show success/error messages
<?php if (isset($_SESSION['success'])): ?>
  toastr.success('<?= $_SESSION['success'] ?>');
  <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
  toastr.error('<?= $_SESSION['error'] ?>');
  <?php unset($_SESSION['error']); ?>
<?php endif; ?>

// Add real-time stock level indicators
$('.bulk-input').on('input', function() {
    let value = parseInt($(this).val());
    let row = $(this).closest('tr');
    let statusBadge = row.find('td:eq(6)'); // Status column
    let stockBadge = row.find('td:eq(5)'); // Stock column
    
    // Update status badge based on new value
    if (value === 0) {
        statusBadge.html('<span class="badge badge-danger">Hết hàng</span>');
        stockBadge.html('<span class="badge badge-danger"><i class="fas fa-times"></i> ' + value + '</span>');
    } else if (value <= 5) {
        statusBadge.html('<span class="badge badge-warning">Sắp hết</span>');
        stockBadge.html('<span class="badge badge-warning"><i class="fas fa-exclamation-triangle"></i> ' + value + '</span>');
    } else {
        statusBadge.html('<span class="badge badge-success">Còn hàng</span>');
        stockBadge.html('<span class="badge badge-success"><i class="fas fa-check"></i> ' + value + '</span>');
    }
    
    // Highlight changed rows
    let originalValue = parseInt($(this).data('original-value'));
    if (value !== originalValue) {
        row.addClass('table-warning');
    } else {
        row.removeClass('table-warning');
    }
});
</script>
