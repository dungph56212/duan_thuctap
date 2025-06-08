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
          <h1>Lịch Sử Tồn Kho</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN . '?act=quan-ly-ton-kho' ?>">Quản Lý Tồn Kho</a></li>
            <li class="breadcrumb-item active">Lịch Sử Tồn Kho</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      
      <!-- Filter Section -->
      <div class="row mb-3">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-filter"></i>
                Lọc Lịch Sử
              </h3>
            </div>
            <div class="card-body">
              <form method="GET" action="<?= BASE_URL_ADMIN . '?act=lich-su-ton-kho' ?>">
                <input type="hidden" name="act" value="lich-su-ton-kho">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Sản phẩm:</label>
                      <select name="san_pham_id" class="form-control">
                        <option value="">Tất cả sản phẩm</option>
                        <?php foreach($allProducts as $product): ?>
                          <option value="<?= $product['id'] ?>" <?= (isset($_GET['san_pham_id']) && $_GET['san_pham_id'] == $product['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($product['ten_san_pham']) ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>Số bản ghi:</label>
                      <select name="limit" class="form-control">
                        <option value="50" <?= (isset($_GET['limit']) && $_GET['limit'] == '50') ? 'selected' : '' ?>>50</option>
                        <option value="100" <?= (isset($_GET['limit']) && $_GET['limit'] == '100') ? 'selected' : '' ?>>100</option>
                        <option value="200" <?= (isset($_GET['limit']) && $_GET['limit'] == '200') ? 'selected' : '' ?>>200</option>
                        <option value="500" <?= (isset($_GET['limit']) && $_GET['limit'] == '500') ? 'selected' : '' ?>>500</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>&nbsp;</label>
                      <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-search"></i> Tìm kiếm
                      </button>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>&nbsp;</label>
                      <a href="<?= BASE_URL_ADMIN . '?act=quan-ly-ton-kho' ?>" class="btn btn-secondary btn-block">
                        <i class="fas fa-arrow-left"></i> Quay lại
                      </a>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Inventory History Table -->
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-history"></i>
                Lịch Sử Thay Đổi Tồn Kho (<?= count($inventoryHistory) ?> bản ghi)
              </h3>
            </div>
            <div class="card-body">
              <?php if(!empty($inventoryHistory)): ?>
              <div class="table-responsive">
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>STT</th>
                      <th>Thời gian</th>
                      <th>Sản phẩm</th>
                      <th>Số lượng cũ</th>
                      <th>Số lượng mới</th>
                      <th>Thay đổi</th>
                      <th>Loại thay đổi</th>
                      <th>Người thực hiện</th>
                      <th>Mã đơn hàng</th>
                      <th>Ghi chú</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($inventoryHistory as $key => $history): ?>
                      <tr>
                        <td><?= $key + 1 ?></td>
                        <td>
                          <small>
                            <?= date('d/m/Y H:i:s', strtotime($history['created_at'])) ?>
                          </small>
                        </td>
                        <td>
                          <strong><?= htmlspecialchars($history['ten_san_pham']) ?></strong>
                        </td>
                        <td>
                          <span class="badge badge-secondary"><?= $history['old_quantity'] ?></span>
                        </td>
                        <td>
                          <span class="badge badge-primary"><?= $history['new_quantity'] ?></span>
                        </td>
                        <td>
                          <?php if($history['change_quantity'] > 0): ?>
                            <span class="badge badge-success">
                              <i class="fas fa-arrow-up"></i> +<?= $history['change_quantity'] ?>
                            </span>
                          <?php elseif($history['change_quantity'] < 0): ?>
                            <span class="badge badge-danger">
                              <i class="fas fa-arrow-down"></i> <?= $history['change_quantity'] ?>
                            </span>
                          <?php else: ?>
                            <span class="badge badge-secondary">0</span>
                          <?php endif; ?>
                        </td>
                        <td>
                          <?php
                          $changeTypeMap = [
                            'manual' => ['badge-info', 'Thủ công'],
                            'order' => ['badge-warning', 'Đặt hàng'],
                            'cancel' => ['badge-success', 'Hủy đơn'],
                            'adjustment' => ['badge-primary', 'Điều chỉnh'],
                            'restock' => ['badge-success', 'Nhập hàng']
                          ];
                          $typeInfo = $changeTypeMap[$history['change_type']] ?? ['badge-secondary', 'Khác'];
                          ?>
                          <span class="badge <?= $typeInfo[0] ?>">
                            <?= $typeInfo[1] ?>
                          </span>
                        </td>
                        <td>
                          <?= $history['user_name'] ? htmlspecialchars($history['user_name']) : '<small class="text-muted">Hệ thống</small>' ?>
                        </td>
                        <td>
                          <?php if($history['ma_don_hang']): ?>
                            <a href="<?= BASE_URL_ADMIN . '?act=chi-tiet-don-hang&id_don_hang=' . $history['order_id'] ?>" class="badge badge-info">
                              <?= htmlspecialchars($history['ma_don_hang']) ?>
                            </a>
                          <?php else: ?>
                            <small class="text-muted">-</small>
                          <?php endif; ?>
                        </td>
                        <td>
                          <small><?= $history['note'] ? htmlspecialchars($history['note']) : '-' ?></small>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
              <?php else: ?>
                <div class="text-center py-4">
                  <i class="fas fa-history fa-3x text-muted mb-3"></i>
                  <h5 class="text-muted">Không có lịch sử thay đổi nào</h5>
                  <p class="text-muted">Chọn sản phẩm cụ thể hoặc điều chỉnh bộ lọc để xem lịch sử.</p>
                </div>
              <?php endif; ?>
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
// Show success/error messages
<?php if (isset($_SESSION['success'])): ?>
  toastr.success('<?= $_SESSION['success'] ?>');
  <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
  toastr.error('<?= $_SESSION['error'] ?>');
  <?php unset($_SESSION['error']); ?>
<?php endif; ?>
</script>
