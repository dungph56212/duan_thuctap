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
            <h1>Báo cáo thống kê</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>    <div class="content">
      <div class="container-fluid">
        <!-- Statistics Cards Row -->
        <div class="row mb-4">
          <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?= number_format($totalOrders) ?></h3>
                <p>Tổng đơn hàng</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?= number_format($totalRevenue, 0, ',', '.') ?>đ</h3>
                <p>Tổng doanh thu</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?= number_format($totalProducts) ?></h3>
                <p>Tổng sản phẩm</p>
              </div>
              <div class="icon">
                <i class="ion ion-cube"></i>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?= number_format($totalCustomers) ?></h3>
                <p>Khách hàng</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
            </div>
          </div>        </div>
        
        <!-- Inventory Alerts -->
        <?php if (isset($inventoryStats) && ($inventoryStats['low_stock_count'] > 0 || $inventoryStats['out_of_stock_count'] > 0)): ?>
        <div class="row mb-4">
          <div class="col-12">
            <div class="alert alert-warning alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h5><i class="icon fas fa-exclamation-triangle"></i> Cảnh báo tồn kho!</h5>
              <div class="row">
                <?php if ($inventoryStats['out_of_stock_count'] > 0): ?>
                <div class="col-md-6">
                  <div class="callout callout-danger">
                    <h5>Sản phẩm hết hàng</h5>
                    <p>Có <strong><?= $inventoryStats['out_of_stock_count'] ?></strong> sản phẩm đã hết hàng.</p>
                    <a href="<?= BASE_URL_ADMIN . '?act=quan-ly-ton-kho' ?>" class="btn btn-danger btn-sm">
                      <i class="fas fa-boxes"></i> Xem chi tiết
                    </a>
                  </div>
                </div>
                <?php endif; ?>
                
                <?php if ($inventoryStats['low_stock_count'] > 0): ?>
                <div class="col-md-6">
                  <div class="callout callout-warning">
                    <h5>Sản phẩm sắp hết hàng</h5>
                    <p>Có <strong><?= $inventoryStats['low_stock_count'] ?></strong> sản phẩm sắp hết hàng (≤5 sản phẩm).</p>
                    <a href="<?= BASE_URL_ADMIN . '?act=quan-ly-ton-kho' ?>" class="btn btn-warning btn-sm">
                      <i class="fas fa-exclamation-triangle"></i> Xem chi tiết
                    </a>
                  </div>
                </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>
        
        <div class="row">
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Lượt truy cập cửa hàng</h3>
                  <a href="javascript:void(0);">Xem báo cáo</a>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg"><?= number_format($visitorStats['total_visitors']) ?></span>
                    <span>Lượt truy cập theo thời gian</span>
                  </p>
                  <p class="ml-auto d-flex flex-column text-right">
                    <span class="text-success">
                      <i class="fas fa-arrow-up"></i> <?= $visitorStats['growth_rate'] ?>%
                    </span>
                    <span class="text-muted">Từ tuần trước</span>
                  </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                  <canvas id="visitors-chart" height="200"></canvas>
                </div>                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> Tuần này
                  </span>

                  <span>
                    <i class="fas fa-square text-gray"></i> Tuần trước
                  </span>
                </div>
              </div>
            </div>
            <!-- /.card -->

            <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title">Sản phẩm bán chạy</h3>
                <div class="card-tools">
                  <a href="<?= BASE_URL_ADMIN ?>?act=san-pham" class="btn btn-tool btn-sm">
                    <i class="fas fa-download"></i>
                  </a>
                  <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-bars"></i>
                  </a>
                </div>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle">
                  <thead>
                  <tr>
                    <th>Sản phẩm</th>
                    <th>Đã bán</th>
                    <th>Doanh thu</th>
                    <th>Thao tác</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php if (!empty($topSellingProducts)): ?>
                    <?php foreach ($topSellingProducts as $product): ?>
                    <tr>
                      <td>
                        <img src="<?= BASE_URL . $product['hinh_anh'] ?>" alt="<?= htmlspecialchars($product['ten_san_pham']) ?>" class="img-circle img-size-32 mr-2" onerror="this.src='<?= BASE_URL ?>assets/img/default-product.png'">
                        <?= htmlspecialchars($product['ten_san_pham']) ?>
                      </td>
                      <td>
                        <small class="text-success mr-1">
                          <i class="fas fa-arrow-up"></i>
                        </small>
                        <?= number_format($product['da_ban']) ?> đã bán
                      </td>
                      <td><?= number_format($product['doanh_thu'], 0, ',', '.') ?>đ</td>
                      <td>
                        <a href="<?= BASE_URL_ADMIN ?>?act=chi-tiet-san-pham&id_san_pham=<?= $product['id'] ?? '#' ?>" class="text-muted">
                          <i class="fas fa-search"></i>
                        </a>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="4" class="text-center">Chưa có dữ liệu sản phẩm bán chạy</td>
                    </tr>
                  <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col-md-6 -->          <div class="col-lg-6">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Doanh thu</h3>
                  <a href="<?= BASE_URL_ADMIN ?>?act=don-hang">Xem báo cáo</a>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg"><?= number_format($totalRevenue, 0, ',', '.') ?>đ</span>
                    <span>Doanh thu theo thời gian</span>
                  </p>
                  <p class="ml-auto d-flex flex-column text-right">
                    <span class="text-success">
                      <i class="fas fa-arrow-up"></i> <?= $salesRate['sales_rate'] ?>%
                    </span>
                    <span class="text-muted">Từ tháng trước</span>
                  </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                  <canvas id="sales-chart" height="200"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> Năm nay
                  </span>

                  <span>
                    <i class="fas fa-square text-gray"></i> Năm trước
                  </span>
                </div>
              </div>
            </div>
            <!-- /.card -->            <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title">Tổng quan cửa hàng</h3>
                <div class="card-tools">
                  <a href="<?= BASE_URL_ADMIN ?>?act=don-hang" class="btn btn-sm btn-tool">
                    <i class="fas fa-download"></i>
                  </a>
                  <a href="#" class="btn btn-sm btn-tool">
                    <i class="fas fa-bars"></i>
                  </a>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                  <p class="text-success text-xl">
                    <i class="ion ion-ios-refresh-empty"></i>
                  </p>
                  <p class="d-flex flex-column text-right">
                    <span class="font-weight-bold">
                      <i class="ion ion-android-arrow-up text-success"></i> <?= $conversionStats['conversion_rate'] ?>%
                    </span>
                    <span class="text-muted">TỶ LỆ CHUYỂN ĐỔI</span>
                  </p>
                </div>
                <!-- /.d-flex -->
                <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                  <p class="text-warning text-xl">
                    <i class="ion ion-ios-cart-outline"></i>
                  </p>
                  <p class="d-flex flex-column text-right">
                    <span class="font-weight-bold">
                      <i class="ion ion-android-arrow-up text-warning"></i> <?= $salesRate['sales_rate'] ?>%
                    </span>
                    <span class="text-muted">TỶ LỆ BÁN HÀNG</span>
                  </p>
                </div>
                <!-- /.d-flex -->
                <div class="d-flex justify-content-between align-items-center mb-0">
                  <p class="text-danger text-xl">
                    <i class="ion ion-ios-people-outline"></i>
                  </p>
                  <p class="d-flex flex-column text-right">
                    <span class="font-weight-bold">
                      <i class="ion ion-android-arrow-<?= $registrationRate['registration_rate'] > 1 ? 'up text-success' : 'down text-danger' ?>"></i> <?= $registrationRate['registration_rate'] ?>%
                    </span>
                    <span class="text-muted">TỶ LỆ ĐĂNG KÝ</span>
                  </p>
                </div>
                <!-- /.d-flex -->
              </div>
            </div>          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
        
        <!-- Recent Orders Section -->
        <div class="row mt-4">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Đơn hàng gần đây</h3>
                <div class="card-tools">
                  <a href="<?= BASE_URL_ADMIN ?>?act=don-hang" class="btn btn-primary btn-sm">
                    Xem tất cả đơn hàng
                  </a>
                </div>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Mã đơn hàng</th>
                      <th>Khách hàng</th>
                      <th>Ngày đặt</th>
                      <th>Trạng thái</th>
                      <th>Tổng tiền</th>
                      <th>Thao tác</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($recentOrders)): ?>
                      <?php foreach ($recentOrders as $order): ?>
                      <tr>
                        <td><?= htmlspecialchars($order['ma_don_hang']) ?></td>
                        <td><?= htmlspecialchars($order['ho_ten'] ?? $order['ten_nguoi_nhan']) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($order['ngay_dat'])) ?></td>
                        <td>
                          <span class="badge badge-<?= 
                            $order['trang_thai_id'] == 1 ? 'warning' : 
                            ($order['trang_thai_id'] == 2 ? 'success' : 
                            ($order['trang_thai_id'] == 3 ? 'info' : 'danger')) 
                          ?>">
                            <?= htmlspecialchars($order['ten_trang_thai']) ?>
                          </span>
                        </td>
                        <td><?= number_format($order['tong_tien'], 0, ',', '.') ?>đ</td>
                        <td>
                          <a href="<?= BASE_URL_ADMIN ?>?act=chi-tiet-don-hang&id_don_hang=<?= $order['id'] ?>" class="btn btn-primary btn-xs">
                            <i class="fas fa-eye"></i>
                          </a>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <tr>
                        <td colspan="6" class="text-center">Chưa có đơn hàng nào</td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Low Stock Alert -->
        <?php if (!empty($lowStockProducts)): ?>
        <div class="row mt-4">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title text-warning">
                  <i class="fas fa-exclamation-triangle"></i>
                  Cảnh báo sản phẩm sắp hết hàng
                </h3>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Tên sản phẩm</th>
                      <th>Danh mục</th>
                      <th>Số lượng còn lại</th>
                      <th>Thao tác</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($lowStockProducts as $product): ?>
                    <tr>
                      <td>
                        <img src="<?= BASE_URL . $product['hinh_anh'] ?>" alt="<?= htmlspecialchars($product['ten_san_pham']) ?>" class="img-circle img-size-32 mr-2" onerror="this.src='<?= BASE_URL ?>assets/img/default-product.png'">
                        <?= htmlspecialchars($product['ten_san_pham']) ?>
                      </td>
                      <td><?= htmlspecialchars($product['ten_danh_muc']) ?></td>
                      <td>
                        <span class="badge badge-<?= $product['so_luong'] <= 5 ? 'danger' : 'warning' ?>">
                          <?= $product['so_luong'] ?>
                        </span>
                      </td>
                      <td>
                        <a href="<?= BASE_URL_ADMIN ?>?act=form-sua-san-pham&id_san_pham=<?= $product['id'] ?>" class="btn btn-warning btn-xs">
                          <i class="fas fa-edit"></i> Nhập hàng
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
        <?php endif; ?>
        
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- Main content -->
    
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->   <!-- footer -->
    <?php require './views/layout/footer.php'; ?>
    <!-- end footer -->

<!-- Chart.js Scripts -->
<script>
$(function () {
  'use strict'

  // Visitor Chart Data
  var visitorChartData = {
    labels: ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'CN'],
    datasets: [
      {
        label: 'Tuần này',
        backgroundColor: 'rgba(60,141,188,0.9)',
        borderColor: 'rgba(60,141,188,0.8)',
        pointRadius: false,
        pointColor: '#3b8bba',
        pointStrokeColor: 'rgba(60,141,188,1)',
        pointHighlightFill: '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
        data: [
          <?php 
          // Generate random visitor data for demo
          $visitorData = [];
          for ($i = 0; $i < 7; $i++) {
            $visitorData[] = rand(50, 200);
          }
          echo implode(',', $visitorData);
          ?>
        ]
      },
      {
        label: 'Tuần trước',
        backgroundColor: 'rgba(210, 214, 222, 1)',
        borderColor: 'rgba(210, 214, 222, 1)',
        pointRadius: false,
        pointColor: 'rgba(210, 214, 222, 1)',
        pointStrokeColor: '#c1c7d1',
        pointHighlightFill: '#fff',
        pointHighlightStroke: 'rgba(220,220,220,1)',
        data: [
          <?php 
          // Generate random visitor data for previous week
          $prevVisitorData = [];
          for ($i = 0; $i < 7; $i++) {
            $prevVisitorData[] = rand(30, 180);
          }
          echo implode(',', $prevVisitorData);
          ?>
        ]
      }
    ]
  }

  // Sales Chart Data  
  var salesChartData = {
    labels: [
      <?php 
      $months = [];
      for ($i = 11; $i >= 0; $i--) {
        $months[] = "'" . date('M Y', strtotime("-$i months")) . "'";
      }
      echo implode(',', $months);
      ?>
    ],
    datasets: [
      {
        label: 'Doanh thu',
        backgroundColor: 'rgba(60,141,188,0.9)',
        borderColor: 'rgba(60,141,188,0.8)',
        pointRadius: false,
        pointColor: '#3b8bba',
        pointStrokeColor: 'rgba(60,141,188,1)',
        pointHighlightFill: '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
        data: [
          <?php 
          // Use actual revenue data if available, otherwise generate sample data
          if (!empty($revenueByMonth)) {
            $monthlyRevenue = array_fill(0, 12, 0);
            foreach ($revenueByMonth as $revenue) {
              $monthIndex = ($revenue['nam'] - date('Y')) * 12 + $revenue['thang'] - 1;
              if ($monthIndex >= 0 && $monthIndex < 12) {
                $monthlyRevenue[11 - $monthIndex] = $revenue['doanh_thu'];
              }
            }
            echo implode(',', $monthlyRevenue);
          } else {
            // Generate sample data
            $sampleRevenue = [];
            for ($i = 0; $i < 12; $i++) {
              $sampleRevenue[] = rand(5000000, 50000000);
            }
            echo implode(',', $sampleRevenue);
          }
          ?>
        ]
      }
    ]
  }

  // Visitor Chart Options
  var areaChartOptions = {
    maintainAspectRatio: false,
    responsive: true,
    legend: {
      display: false
    },
    scales: {
      xAxes: [{
        gridLines: {
          display: false,
        }
      }],
      yAxes: [{
        gridLines: {
          display: false,
        }
      }]
    }
  }

  // Create Visitor Chart
  var visitorsChartCanvas = $('#visitors-chart').get(0).getContext('2d')
  var visitorsChart = new Chart(visitorsChartCanvas, {
    type: 'line',
    data: visitorChartData,
    options: areaChartOptions
  })

  // Create Sales Chart
  var salesChartCanvas = $('#sales-chart').get(0).getContext('2d')
  var salesChart = new Chart(salesChartCanvas, {
    type: 'bar',
    data: salesChartData,
    options: {
      maintainAspectRatio: false,
      responsive: true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines: {
            display: false,
          }
        }],
        yAxes: [{
          gridLines: {
            display: false,
          },
          ticks: {
            callback: function(value) {
              return new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
              }).format(value);
            }
          }
        }]
      },
      tooltips: {
        callbacks: {
          label: function(tooltipItem, data) {
            return new Intl.NumberFormat('vi-VN', {
              style: 'currency', 
              currency: 'VND'
            }).format(tooltipItem.value);
          }
        }
      }
    }
  })
})
</script>

<!-- Code injected by live-server -->

</body>
</html>
