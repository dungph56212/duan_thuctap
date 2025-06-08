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
          <h1>Cảnh Báo Tồn Kho</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN . '?act=quan-ly-ton-kho' ?>">Quản Lý Tồn Kho</a></li>
            <li class="breadcrumb-item active">Cảnh Báo Tồn Kho</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      
      <!-- Alerts Summary -->
      <div class="row mb-4">
        <div class="col-lg-4 col-6">
          <div class="small-box bg-warning">
            <div class="inner">
              <h3><?= count(array_filter($allAlerts, function($alert) { return $alert['alert_type'] == 'low_stock'; })) ?></h3>
              <p>Cảnh báo sắp hết hàng</p>
            </div>
            <div class="icon">
              <i class="fas fa-exclamation-triangle"></i>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-6">
          <div class="small-box bg-danger">
            <div class="inner">
              <h3><?= count(array_filter($allAlerts, function($alert) { return $alert['alert_type'] == 'out_of_stock'; })) ?></h3>
              <p>Cảnh báo hết hàng</p>
            </div>
            <div class="icon">
              <i class="fas fa-times-circle"></i>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h3><?= count($unreadAlerts) ?></h3>
              <p>Cảnh báo chưa đọc</p>
            </div>
            <div class="icon">
              <i class="fas fa-bell"></i>
            </div>
          </div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="row mb-3">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <button type="button" class="btn btn-success" onclick="markAllAsRead()">
                <i class="fas fa-check-double"></i> Đánh dấu tất cả đã đọc
              </button>
              <a href="<?= BASE_URL_ADMIN . '?act=quan-ly-ton-kho' ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại quản lý tồn kho
              </a>
              <button type="button" class="btn btn-info" onclick="refreshAlerts()">
                <i class="fas fa-sync-alt"></i> Làm mới
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Alerts List -->
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-bell"></i>
                Danh Sách Cảnh Báo (<?= count($allAlerts) ?> cảnh báo)
              </h3>
            </div>
            <div class="card-body">
              <?php if(!empty($allAlerts)): ?>
              <div id="alerts-container">
                <?php foreach($allAlerts as $alert): ?>
                  <div class="alert alert-<?= $alert['alert_type'] == 'out_of_stock' ? 'danger' : 'warning' ?> alert-dismissible" 
                       data-alert-id="<?= $alert['id'] ?>" 
                       style="<?= $alert['is_read'] ? 'opacity: 0.6;' : '' ?>">
                    <button type="button" class="close" onclick="markAsRead(<?= $alert['id'] ?>)">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="row align-items-center">                      <div class="col-md-1">
                        <img src="<?= getImageUrl($alert['hinh_anh']) ?>" 
                             class="img-circle img-size-50" 
                             alt="<?= htmlspecialchars($alert['ten_san_pham']) ?>"
                             onerror="this.src='<?= BASE_URL ?>assets/img/default-product.png'">
                      </div>
                      <div class="col-md-7">
                        <h5 class="alert-heading">
                          <i class="fas fa-<?= $alert['alert_type'] == 'out_of_stock' ? 'times-circle' : 'exclamation-triangle' ?>"></i>
                          <?= $alert['alert_type'] == 'out_of_stock' ? 'HẾT HÀNG' : 'SẮP HẾT HÀNG' ?>
                        </h5>
                        <p class="mb-1">
                          <strong><?= htmlspecialchars($alert['ten_san_pham']) ?></strong>
                        </p>
                        <p class="mb-0">
                          <?= htmlspecialchars($alert['message']) ?>
                        </p>
                        <small class="text-muted">
                          <i class="fas fa-clock"></i> <?= date('d/m/Y H:i:s', strtotime($alert['created_at'])) ?>
                          <?php if($alert['is_read']): ?>
                            <span class="badge badge-secondary ml-2">Đã đọc</span>
                          <?php else: ?>
                            <span class="badge badge-info ml-2">Chưa đọc</span>
                          <?php endif; ?>
                        </small>
                      </div>
                      <div class="col-md-2 text-center">
                        <div class="stock-indicator">
                          <h4 class="mb-0">
                            <span class="badge badge-<?= $alert['so_luong'] == 0 ? 'danger' : 'warning' ?> badge-lg">
                              <?= $alert['so_luong'] ?>
                            </span>
                          </h4>
                          <small class="text-muted">Còn lại</small>
                        </div>
                      </div>
                      <div class="col-md-2 text-right">
                        <div class="btn-group-vertical">
                          <a href="<?= BASE_URL_ADMIN . '?act=form-sua-san-pham&id_san_pham=' . $alert['san_pham_id'] ?>" 
                             class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> Chỉnh sửa
                          </a>
                          <form method="POST" action="<?= BASE_URL_ADMIN . '?act=cap-nhat-ton-kho' ?>" style="display: inline;">
                            <input type="hidden" name="san_pham_id" value="<?= $alert['san_pham_id'] ?>">
                            <div class="input-group input-group-sm mt-1">
                              <input type="number" name="so_luong_moi" class="form-control form-control-sm" 
                                     min="0" value="<?= $alert['so_luong'] + 20 ?>" 
                                     style="width: 70px;" required>
                              <div class="input-group-append">
                                <button type="submit" class="btn btn-success btn-sm">
                                  <i class="fas fa-plus"></i>
                                </button>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
              <?php else: ?>
                <div class="text-center py-5">
                  <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                  <h5 class="text-muted">Không có cảnh báo nào</h5>
                  <p class="text-muted">Tất cả sản phẩm đều có tồn kho ổn định.</p>
                  <a href="<?= BASE_URL_ADMIN . '?act=quan-ly-ton-kho' ?>" class="btn btn-primary">
                    <i class="fas fa-boxes"></i> Quản lý tồn kho
                  </a>
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
function markAsRead(alertId) {
    $.ajax({
        url: '<?= BASE_URL_ADMIN ?>?act=danh-dau-da-doc-canh-bao',
        method: 'POST',
        data: { alert_id: alertId },
        dataType: 'json',
        success: function(response) {
            if(response.success) {
                $('[data-alert-id="' + alertId + '"]').fadeOut(300);
                toastr.success('Đã đánh dấu cảnh báo là đã đọc');
                updateAlertCount();
            } else {
                toastr.error(response.message || 'Có lỗi xảy ra');
            }
        },
        error: function() {
            toastr.error('Không thể kết nối với máy chủ');
        }
    });
}

function markAllAsRead() {
    if(confirm('Bạn có chắc chắn muốn đánh dấu tất cả cảnh báo là đã đọc?')) {
        let alertIds = [];
        $('[data-alert-id]').each(function() {
            alertIds.push($(this).data('alert-id'));
        });
        
        // Mark each alert as read
        let promises = alertIds.map(function(alertId) {
            return $.ajax({
                url: '<?= BASE_URL_ADMIN ?>?act=danh-dau-da-doc-canh-bao',
                method: 'POST',
                data: { alert_id: alertId },
                dataType: 'json'
            });
        });
        
        Promise.all(promises).then(function() {
            location.reload();
        }).catch(function() {
            toastr.error('Có lỗi xảy ra khi đánh dấu cảnh báo');
        });
    }
}

function refreshAlerts() {
    location.reload();
}

function updateAlertCount() {
    // Update alert count in the summary boxes
    let visibleAlerts = $('[data-alert-id]:visible').length;
    $('.small-box .inner h3').first().text(visibleAlerts);
}

// Show success/error messages
<?php if (isset($_SESSION['success'])): ?>
  toastr.success('<?= $_SESSION['success'] ?>');
  <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
  toastr.error('<?= $_SESSION['error'] ?>');
  <?php unset($_SESSION['error']); ?>
<?php endif; ?>

// Auto-refresh alerts every 5 minutes
setInterval(function() {
    refreshAlerts();
}, 300000);
</script>

<style>
.badge-lg {
    font-size: 1.2em;
    padding: 0.5em 0.8em;
}

.stock-indicator {
    border-left: 2px solid #dee2e6;
    padding-left: 15px;
}

.alert {
    border-left: 4px solid;
}

.alert-warning {
    border-left-color: #ffc107;
}

.alert-danger {
    border-left-color: #dc3545;
}
</style>
