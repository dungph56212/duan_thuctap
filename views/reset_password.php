<?php require_once 'views/layout/header.php'; ?>
<style>
.reset-password-container {
    min-height: 80vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
}
.reset-password-card {
    max-width: 400px;
    width: 100%;
    border-radius: 12px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.08);
    padding: 2rem 2rem 1.5rem 2rem;
    background: #fff;
}
.reset-password-card .icon {
    font-size: 2.5rem;
    color: #43a047;
    margin-bottom: 1rem;
    display: flex;
    justify-content: center;
}
.reset-link-box {
    background: #e3f2fd;
    border: 1px solid #90caf9;
    color: #1565c0;
    border-radius: 8px;
    padding: 1rem;
    margin-top: 1.5rem;
    word-break: break-all;
    font-size: 1rem;
}
</style>
<div class="reset-password-container">
    <div class="reset-password-card">
        <div class="icon">
            <i class="fa fa-key"></i>
        </div>
        <h3 class="text-center mb-3">Đặt lại mật khẩu</h3>
        <form method="POST" action="?act=reset-password">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
            <div class="form-group mb-3">
                <label for="password">Mật khẩu mới</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu mới" required>
            </div>
            <div class="form-group mb-3">
                <label for="password_confirm">Nhập lại mật khẩu mới</label>
                <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Nhập lại mật khẩu mới" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Đặt lại mật khẩu</button>
        </form>
        <?php if (!empty($message)): ?>
            <div class="reset-link-box mt-3">
                <?= $message ?>
            </div>
        <?php endif; ?>
        <div class="mt-3 text-center">
            <a href="<?= BASE_URL ?>?act=login">Quay lại đăng nhập</a>
        </div>
    </div>
</div>
<?php require_once 'views/layout/footer.php'; ?> 