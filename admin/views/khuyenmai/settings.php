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
                    <h1>Cài đặt khuyến mãi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="?act=">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Cài đặt khuyến mãi</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $_SESSION['success'] ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['errors'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        <?php foreach ($_SESSION['errors'] as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php unset($_SESSION['errors']); ?>
            <?php endif; ?>

            <form method="POST" action="?act=post-cai-dat-khuyen-mai">
                
                <!-- General Settings -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Cài đặt chung</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="auto_deactivate_expired">Tự động vô hiệu hóa khuyến mãi hết hạn</label>
                                    <select class="form-control" id="auto_deactivate_expired" name="auto_deactivate_expired">
                                        <option value="1" <?= ($settings['auto_deactivate_expired'] ?? 1) ? 'selected' : '' ?>>Có</option>
                                        <option value="0" <?= (!($settings['auto_deactivate_expired'] ?? 1)) ? 'selected' : '' ?>>Không</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="expiry_warning_days">Cảnh báo trước khi hết hạn (ngày)</label>
                                    <input type="number" class="form-control" id="expiry_warning_days" 
                                           name="expiry_warning_days" value="<?= $settings['expiry_warning_days'] ?? 7 ?>" 
                                           min="1" max="30">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="allow_stacking">Cho phép chồng khuyến mãi</label>
                                    <select class="form-control" id="allow_stacking" name="allow_stacking">
                                        <option value="1" <?= ($settings['allow_stacking'] ?? 0) ? 'selected' : '' ?>>Có</option>
                                        <option value="0" <?= (!($settings['allow_stacking'] ?? 0)) ? 'selected' : '' ?>>Không</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="max_discount_per_order">Giảm giá tối đa mỗi đơn hàng</label>
                                    <input type="number" class="form-control" id="max_discount_per_order" 
                                           name="max_discount_per_order" value="<?= $settings['max_discount_per_order'] ?? 0 ?>" 
                                           min="0" placeholder="0 = không giới hạn">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Code Generation Settings -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Cài đặt mã khuyến mãi</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="code_prefix">Tiền tố mã khuyến mãi</label>
                                    <input type="text" class="form-control" id="code_prefix" 
                                           name="code_prefix" value="<?= $settings['code_prefix'] ?? 'KM' ?>" 
                                           maxlength="10">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="code_length">Độ dài mã khuyến mãi</label>
                                    <input type="number" class="form-control" id="code_length" 
                                           name="code_length" value="<?= $settings['code_length'] ?? 8 ?>" 
                                           min="6" max="20">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="code_format">Định dạng mã khuyến mãi</label>
                                    <select class="form-control" id="code_format" name="code_format">
                                        <option value="alphanumeric" <?= ($settings['code_format'] ?? 'alphanumeric') === 'alphanumeric' ? 'selected' : '' ?>>Chữ và số</option>
                                        <option value="numeric" <?= ($settings['code_format'] ?? 'alphanumeric') === 'numeric' ? 'selected' : '' ?>>Chỉ số</option>
                                        <option value="alphabetic" <?= ($settings['code_format'] ?? 'alphanumeric') === 'alphabetic' ? 'selected' : '' ?>>Chỉ chữ</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Usage Limits -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Giới hạn sử dụng</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="default_usage_limit">Giới hạn sử dụng mặc định</label>
                                    <input type="number" class="form-control" id="default_usage_limit" 
                                           name="default_usage_limit" value="<?= $settings['default_usage_limit'] ?? 100 ?>" 
                                           min="1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="max_usage_per_customer">Tối đa mỗi khách hàng</label>
                                    <input type="number" class="form-control" id="max_usage_per_customer" 
                                           name="max_usage_per_customer" value="<?= $settings['max_usage_per_customer'] ?? 1 ?>" 
                                           min="1">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="min_order_amount">Giá trị đơn hàng tối thiểu</label>
                                    <input type="number" class="form-control" id="min_order_amount" 
                                           name="min_order_amount" value="<?= $settings['min_order_amount'] ?? 0 ?>" 
                                           min="0" placeholder="0 = không giới hạn">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="require_login">Yêu cầu đăng nhập</label>
                                    <select class="form-control" id="require_login" name="require_login">
                                        <option value="1" <?= ($settings['require_login'] ?? 1) ? 'selected' : '' ?>>Có</option>
                                        <option value="0" <?= (!($settings['require_login'] ?? 1)) ? 'selected' : '' ?>>Không</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notification Settings -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Cài đặt thông báo</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="notify_on_expiry">Thông báo khi sắp hết hạn</label>
                                    <select class="form-control" id="notify_on_expiry" name="notify_on_expiry">
                                        <option value="1" <?= ($settings['notify_on_expiry'] ?? 1) ? 'selected' : '' ?>>Có</option>
                                        <option value="0" <?= (!($settings['notify_on_expiry'] ?? 1)) ? 'selected' : '' ?>>Không</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="notify_on_usage">Thông báo khi được sử dụng</label>
                                    <select class="form-control" id="notify_on_usage" name="notify_on_usage">
                                        <option value="1" <?= ($settings['notify_on_usage'] ?? 0) ? 'selected' : '' ?>>Có</option>
                                        <option value="0" <?= (!($settings['notify_on_usage'] ?? 0)) ? 'selected' : '' ?>>Không</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="notification_email">Email nhận thông báo</label>
                                    <input type="email" class="form-control" id="notification_email" 
                                           name="notification_email" value="<?= $settings['notification_email'] ?? '' ?>" 
                                           placeholder="admin@example.com">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Analytics Settings -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Cài đặt báo cáo</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="track_analytics">Theo dõi phân tích</label>
                                    <select class="form-control" id="track_analytics" name="track_analytics">
                                        <option value="1" <?= ($settings['track_analytics'] ?? 1) ? 'selected' : '' ?>>Có</option>
                                        <option value="0" <?= (!($settings['track_analytics'] ?? 1)) ? 'selected' : '' ?>>Không</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="auto_report_frequency">Tần suất báo cáo tự động</label>
                                    <select class="form-control" id="auto_report_frequency" name="auto_report_frequency">
                                        <option value="never" <?= ($settings['auto_report_frequency'] ?? 'never') === 'never' ? 'selected' : '' ?>>Không bao giờ</option>
                                        <option value="daily" <?= ($settings['auto_report_frequency'] ?? 'never') === 'daily' ? 'selected' : '' ?>>Hàng ngày</option>
                                        <option value="weekly" <?= ($settings['auto_report_frequency'] ?? 'never') === 'weekly' ? 'selected' : '' ?>>Hàng tuần</option>
                                        <option value="monthly" <?= ($settings['auto_report_frequency'] ?? 'never') === 'monthly' ? 'selected' : '' ?>>Hàng tháng</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Lưu cài đặt
                        </button>
                        <a href="?act=danh-sach-khuyen-mai" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Hủy
                        </a>
                    </div>
                </div>

            </form>

        </div>
    </section>
</div>

<script>
$(document).ready(function() {
    // Preview code format
    $('#code_prefix, #code_length, #code_format').on('change keyup', function() {
        generateCodePreview();
    });
    
    function generateCodePreview() {
        var prefix = $('#code_prefix').val() || 'KM';
        var length = parseInt($('#code_length').val()) || 8;
        var format = $('#code_format').val();
        
        var chars = '';
        switch(format) {
            case 'numeric':
                chars = '0123456789';
                break;
            case 'alphabetic':
                chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
            default:
                chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        }
        
        var preview = prefix;
        for (var i = 0; i < (length - prefix.length); i++) {
            preview += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        
        // Show preview if element exists
        if ($('#code_preview').length) {
            $('#code_preview').text('Ví dụ: ' + preview);
        }
    }
    
    // Initial preview
    generateCodePreview();
});
</script>

<?php require './views/layout/footer.php' ?>
