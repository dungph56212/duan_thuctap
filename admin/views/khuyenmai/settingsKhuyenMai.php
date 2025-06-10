<?php require_once 'layout/header.php'; ?>
<?php require_once 'layout/sidebar.php'; ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-cogs text-secondary"></i>
                        Cài đặt khuyến mãi
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang chủ</a></li>
                        <li class="breadcrumb-item">Khuyến mãi</li>
                        <li class="breadcrumb-item active">Cài đặt</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i>
                    <?= $_SESSION['success'] ?>
                    <button type="button" class="close" data-dismiss="alert">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <form action="<?= BASE_URL_ADMIN ?>?act=post-cai-dat-khuyen-mai" method="post">
                <div class="row">
                    <!-- General Settings -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-sliders-h"></i>
                                    Cài đặt chung
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="max_promotions_per_user">
                                        <i class="fas fa-user"></i>
                                        Số khuyến mãi tối đa mỗi khách hàng
                                    </label>
                                    <input type="number" 
                                           class="form-control" 
                                           id="max_promotions_per_user" 
                                           name="max_promotions_per_user" 
                                           value="<?= $settings['max_promotions_per_user'] ?? 5 ?>"
                                           min="1" max="20">
                                    <small class="form-text text-muted">
                                        Giới hạn số lượng khuyến mãi một khách hàng có thể sử dụng cùng lúc
                                    </small>
                                </div>

                                <div class="form-group">
                                    <label for="default_validity_days">
                                        <i class="fas fa-calendar"></i>
                                        Thời hạn mặc định (ngày)
                                    </label>
                                    <input type="number" 
                                           class="form-control" 
                                           id="default_validity_days" 
                                           name="default_validity_days" 
                                           value="<?= $settings['default_validity_days'] ?? 30 ?>"
                                           min="1" max="365">
                                    <small class="form-text text-muted">
                                        Thời hạn mặc định cho khuyến mãi mới
                                    </small>
                                </div>

                                <div class="form-group">
                                    <label for="auto_deactivate">
                                        <i class="fas fa-toggle-on"></i>
                                        Tự động vô hiệu hóa
                                    </label>
                                    <select class="form-control" id="auto_deactivate" name="auto_deactivate">
                                        <option value="1" <?= ($settings['auto_deactivate'] ?? 1) == 1 ? 'selected' : '' ?>>
                                            Có - Tự động vô hiệu hóa khi hết hạn
                                        </option>
                                        <option value="0" <?= ($settings['auto_deactivate'] ?? 1) == 0 ? 'selected' : '' ?>>
                                            Không - Giữ nguyên trạng thái
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notification Settings -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-bell"></i>
                                    Cài đặt thông báo
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="notify_expiring_days">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        Cảnh báo sắp hết hạn (ngày)
                                    </label>
                                    <input type="number" 
                                           class="form-control" 
                                           id="notify_expiring_days" 
                                           name="notify_expiring_days" 
                                           value="<?= $settings['notify_expiring_days'] ?? 7 ?>"
                                           min="1" max="30">
                                    <small class="form-text text-muted">
                                        Số ngày trước khi hết hạn để hiển thị cảnh báo
                                    </small>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" 
                                               class="custom-control-input" 
                                               id="email_notifications" 
                                               name="email_notifications"
                                               value="1" 
                                               <?= ($settings['email_notifications'] ?? 1) == 1 ? 'checked' : '' ?>>
                                        <label class="custom-control-label" for="email_notifications">
                                            <i class="fas fa-envelope"></i>
                                            Gửi email thông báo khuyến mãi mới
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" 
                                               class="custom-control-input" 
                                               id="sms_notifications" 
                                               name="sms_notifications"
                                               value="1" 
                                               <?= ($settings['sms_notifications'] ?? 0) == 1 ? 'checked' : '' ?>>
                                        <label class="custom-control-label" for="sms_notifications">
                                            <i class="fas fa-sms"></i>
                                            Gửi SMS thông báo khuyến mãi
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Validation Rules -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-shield-alt"></i>
                                    Quy tắc xác thực
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="min_order_amount">
                                        <i class="fas fa-money-bill-wave"></i>
                                        Giá trị đơn hàng tối thiểu
                                    </label>
                                    <input type="number" 
                                           class="form-control" 
                                           id="min_order_amount" 
                                           name="min_order_amount" 
                                           value="<?= $settings['min_order_amount'] ?? 0 ?>"
                                           min="0" step="1000">
                                    <small class="form-text text-muted">
                                        Giá trị đơn hàng tối thiểu để áp dụng khuyến mãi (VNĐ)
                                    </small>
                                </div>

                                <div class="form-group">
                                    <label for="max_discount_percent">
                                        <i class="fas fa-percentage"></i>
                                        Tỷ lệ giảm giá tối đa (%)
                                    </label>
                                    <input type="number" 
                                           class="form-control" 
                                           id="max_discount_percent" 
                                           name="max_discount_percent" 
                                           value="<?= $settings['max_discount_percent'] ?? 50 ?>"
                                           min="1" max="100">
                                    <small class="form-text text-muted">
                                        Tỷ lệ giảm giá tối đa cho phép
                                    </small>
                                </div>

                                <div class="form-group">
                                    <label for="max_discount_amount">
                                        <i class="fas fa-coins"></i>
                                        Số tiền giảm tối đa
                                    </label>
                                    <input type="number" 
                                           class="form-control" 
                                           id="max_discount_amount" 
                                           name="max_discount_amount" 
                                           value="<?= $settings['max_discount_amount'] ?? 1000000 ?>"
                                           min="1000" step="1000">
                                    <small class="form-text text-muted">
                                        Số tiền giảm giá tối đa cho phép (VNĐ)
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Display Settings -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-eye"></i>
                                    Cài đặt hiển thị
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" 
                                               class="custom-control-input" 
                                               id="show_on_homepage" 
                                               name="show_on_homepage"
                                               value="1" 
                                               <?= ($settings['show_on_homepage'] ?? 1) == 1 ? 'checked' : '' ?>>
                                        <label class="custom-control-label" for="show_on_homepage">
                                            <i class="fas fa-home"></i>
                                            Hiển thị khuyến mãi trên trang chủ
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" 
                                               class="custom-control-input" 
                                               id="show_countdown" 
                                               name="show_countdown"
                                               value="1" 
                                               <?= ($settings['show_countdown'] ?? 1) == 1 ? 'checked' : '' ?>>
                                        <label class="custom-control-label" for="show_countdown">
                                            <i class="fas fa-clock"></i>
                                            Hiển thị đếm ngược thời gian
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="promotion_banner_text">
                                        <i class="fas fa-bullhorn"></i>
                                        Văn bản banner khuyến mãi
                                    </label>
                                    <textarea class="form-control" 
                                              id="promotion_banner_text" 
                                              name="promotion_banner_text" 
                                              rows="3"><?= $settings['promotion_banner_text'] ?? 'Khuyến mãi đặc biệt! Giảm giá lên đến 50% cho tất cả sản phẩm!' ?></textarea>
                                    <small class="form-text text-muted">
                                        Văn bản hiển thị trên banner khuyến mãi
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i>
                                    Lưu cài đặt
                                </button>
                                <button type="reset" class="btn btn-secondary ml-2">
                                    <i class="fas fa-undo"></i>
                                    Khôi phục
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

<?php require_once 'layout/footer.php'; ?>
