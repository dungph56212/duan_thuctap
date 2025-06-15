<?php include './views/layout/header.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>📚 Dashboard - Quản lý sách</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Quản lý sách</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">📚 Dashboard Quản Lý Sách</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Quản lý sách</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-1">
                            <p class="text-truncate font-size-14 mb-2">Tổng số sách</p>
                            <h4 class="mb-2"><?= number_format($stats['total_books'] ?? 0) ?></h4>
                            <p class="text-muted mb-0">
                                <span class="text-success fw-bold font-size-12 me-2">
                                    <i class="ri-arrow-right-up-line me-1 align-middle"></i>
                                    +<?= $stats['new_this_week'] ?? 0 ?>
                                </span>tuần này
                            </p>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-primary-subtle text-primary rounded-3">
                                <i class="ri-book-line font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-1">
                            <p class="text-truncate font-size-14 mb-2">Còn hàng</p>
                            <h4 class="mb-2"><?= number_format($stats['in_stock'] ?? 0) ?></h4>
                            <p class="text-muted mb-0">
                                <span class="text-danger fw-bold font-size-12 me-2">
                                    <i class="ri-arrow-right-down-line me-1 align-middle"></i>
                                    <?= $stats['out_stock'] ?? 0 ?>
                                </span>hết hàng
                            </p>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-success-subtle text-success rounded-3">
                                <i class="ri-store-line font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-1">
                            <p class="text-truncate font-size-14 mb-2">Tổng số lượng</p>
                            <h4 class="mb-2"><?= number_format($stats['total_quantity'] ?? 0) ?></h4>
                            <p class="text-muted mb-0">
                                <span class="text-primary fw-bold font-size-12 me-2">
                                    <i class="ri-stack-line me-1 align-middle"></i>
                                    Kho
                                </span>trong kho
                            </p>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-info-subtle text-info rounded-3">
                                <i class="ri-stack-line font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-1">
                            <p class="text-truncate font-size-14 mb-2">Giá trị kho</p>
                            <h4 class="mb-2"><?= number_format($stats['total_value'] ?? 0) ?>đ</h4>
                            <p class="text-muted mb-0">
                                <span class="text-warning fw-bold font-size-12 me-2">
                                    <i class="ri-money-dollar-circle-line me-1 align-middle"></i>
                                    VNĐ
                                </span>tổng giá trị
                            </p>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-warning-subtle text-warning rounded-3">
                                <i class="ri-money-dollar-circle-line font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">⚡ Thao tác nhanh</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="<?= BASE_URL_ADMIN ?>?act=book-add" class="btn btn-primary w-100">
                                <i class="ri-add-line me-2"></i>Thêm sách mới
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="<?= BASE_URL_ADMIN ?>?act=book-bulk-add" class="btn btn-success w-100">
                                <i class="ri-file-add-line me-2"></i>Thêm hàng loạt
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="<?= BASE_URL_ADMIN ?>?act=book-list" class="btn btn-info w-100">
                                <i class="ri-list-check me-2"></i>Danh sách sách
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="<?= BASE_URL_ADMIN ?>?act=category-manager" class="btn btn-warning w-100">
                                <i class="ri-folder-line me-2"></i>Quản lý danh mục
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Books & Popular Books -->
    <div class="row">
        <!-- Recent Books -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">📖 Sách mới nhất</h4>
                    <div class="flex-shrink-0">
                        <a href="<?= BASE_URL_ADMIN ?>?act=book-list" class="btn btn-soft-primary btn-sm">
                            Xem tất cả <i class="ri-arrow-right-line align-middle"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty($recentBooks)): ?>
                        <div class="table-responsive">
                            <table class="table table-borderless table-nowrap align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">Sách</th>
                                        <th scope="col">Giá</th>
                                        <th scope="col">SL</th>
                                        <th scope="col">Ngày</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentBooks as $book): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-xs me-3">
                                                        <span class="avatar-title rounded-circle bg-primary-subtle text-primary">
                                                            📚
                                                        </span>
                                                    </div>
                                                    <div class="flex-1">
                                                        <h5 class="font-size-14 mb-1">
                                                            <a href="<?= BASE_URL_ADMIN ?>?act=book-edit&id=<?= $book['id'] ?>" class="text-dark">
                                                                <?= htmlspecialchars($book['ten_san_pham']) ?>
                                                            </a>
                                                        </h5>
                                                        <p class="text-muted mb-0"><?= htmlspecialchars($book['ten_danh_muc'] ?? 'Chưa phân loại') ?></p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?= number_format($book['gia_san_pham']) ?>đ</td>
                                            <td>
                                                <span class="badge badge-soft-<?= $book['so_luong'] > 0 ? 'success' : 'danger' ?>">
                                                    <?= $book['so_luong'] ?>
                                                </span>
                                            </td>
                                            <td><?= date('d/m', strtotime($book['ngay_nhap'])) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <p class="text-muted">Chưa có sách nào</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Popular Books -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">🔥 Sách bán chạy</h4>
                    <div class="flex-shrink-0">
                        <a href="<?= BASE_URL_ADMIN ?>?act=chatbot-analytics" class="btn btn-soft-success btn-sm">
                            Analytics <i class="ri-bar-chart-line align-middle"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty($popularBooks)): ?>
                        <div class="table-responsive">
                            <table class="table table-borderless table-nowrap align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">Sách</th>
                                        <th scope="col">Lượt xem</th>
                                        <th scope="col">Giá</th>
                                        <th scope="col">SL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($popularBooks as $book): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-xs me-3">
                                                        <span class="avatar-title rounded-circle bg-success-subtle text-success">
                                                            🔥
                                                        </span>
                                                    </div>
                                                    <div class="flex-1">
                                                        <h5 class="font-size-14 mb-1">
                                                            <a href="<?= BASE_URL_ADMIN ?>?act=book-edit&id=<?= $book['id'] ?>" class="text-dark">
                                                                <?= htmlspecialchars($book['ten_san_pham']) ?>
                                                            </a>
                                                        </h5>
                                                        <p class="text-muted mb-0"><?= htmlspecialchars($book['ten_danh_muc'] ?? 'Chưa phân loại') ?></p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-soft-primary"><?= number_format($book['luot_xem']) ?></span>
                                            </td>
                                            <td><?= number_format($book['gia_san_pham']) ?>đ</td>
                                            <td>
                                                <span class="badge badge-soft-<?= $book['so_luong'] > 0 ? 'success' : 'danger' ?>">
                                                    <?= $book['so_luong'] ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <p class="text-muted">Chưa có dữ liệu</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Overview -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">📁 Tổng quan danh mục</h4>
                    <div class="flex-shrink-0">
                        <div class="dropdown">
                            <a class="dropdown-toggle text-reset" href="#" data-bs-toggle="dropdown">
                                <span class="text-muted">Xem thêm<i class="mdi mdi-chevron-down ms-1"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="<?= BASE_URL_ADMIN ?>?act=category-manager">Quản lý danh mục</a>
                                <a class="dropdown-item" href="<?= BASE_URL_ADMIN ?>?act=book-list">Danh sách sách</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty($categories)): ?>
                        <div class="row">
                            <?php foreach ($categories as $category): ?>
                                <div class="col-xl-3 col-md-6 mb-4">
                                    <div class="card border">
                                        <div class="card-body text-center">
                                            <div class="avatar-sm mx-auto mb-3">
                                                <span class="avatar-title rounded-circle bg-info-subtle text-info font-size-16">
                                                    📁
                                                </span>
                                            </div>
                                            <h5 class="font-size-15 mb-1"><?= htmlspecialchars($category['ten_danh_muc']) ?></h5>
                                            <p class="text-muted mb-2"><?= $category['book_count'] ?> sách</p>
                                            <div class="progress" style="height: 6px;">
                                                <div class="progress-bar bg-info" style="width: <?= min(100, ($category['book_count'] / max(1, $stats['total_books'] ?? 1)) * 100) ?>%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <p class="text-muted">Chưa có danh mục nào</p>
                            <a href="<?= BASE_URL_ADMIN ?>?act=category-manager" class="btn btn-primary">
                                <i class="ri-add-line me-2"></i>Thêm danh mục
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>        </div>
    </section>
</div>

<?php include './views/layout/footer.php'; ?>
