<?php require_once 'views/layout/header.php'; ?>
<style>
.auth-bg {
    min-height: 100vh;
    background: linear-gradient(135deg, #e0e7ff 0%, #f8fafc 100%);
    display: flex;
    align-items: center;
    justify-content: center;
}
.auth-card {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.12);
    padding: 2.5rem 2rem 2rem 2rem;
    max-width: 420px;
    width: 100%;
    margin: 2rem 0;
    animation: fadeIn .7s;
}
@keyframes fadeIn { from { opacity: 0; transform: translateY(40px);} to { opacity: 1; transform: none;}}
.auth-card .icon {
    font-size: 3rem;
    color: #43a047;
    margin-bottom: 1rem;
    display: flex;
    justify-content: center;
}
.auth-card h3 {
    font-weight: 700;
    color: #22223b;
}
.auth-card .form-control {
    border-radius: 10px;
    font-size: 1.08rem;
    padding: 0.75rem 1rem;
    margin-bottom: 1rem;
    border: 1.5px solid #e0e7ff;
    transition: border-color 0.2s;
}
.auth-card .form-control:focus {
    border-color: #43a047;
    box-shadow: 0 0 0 2px #43a04733;
}
.auth-card .btn-main {
    background: linear-gradient(90deg, #43a047 0%, #60a5fa 100%);
    color: #fff;
    border: none;
    border-radius: 24px;
    font-weight: 600;
    font-size: 1.1rem;
    padding: 0.7rem 0;
    margin-top: 0.5rem;
    transition: background 0.2s;
}
.auth-card .btn-main:hover {
    background: linear-gradient(90deg, #60a5fa 0%, #43a047 100%);
}
.auth-card .auth-links {
    display: flex;
    justify-content: space-between;
    margin-top: 1.2rem;
    font-size: 0.98rem;
}
.auth-card .auth-links a {
    color: #43a047;
    text-decoration: none;
    transition: color 0.2s;
}
.auth-card .auth-links a:hover {
    color: #22223b;
    text-decoration: underline;
}
.auth-card .alert {
    border-radius: 8px;
    margin-top: 1rem;
    font-size: 1rem;
}
</style>
<div class="auth-bg">
  <div class="auth-card">
    <div class="icon"><i class="fa fa-user-plus"></i></div>
    <h3 class="text-center mb-3">Đăng ký tài khoản</h3>
    <?php echo displayNotification(); ?>
    <form action="<?= BASE_URL . '?act=register' ?>" method="post">
      <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
      <input type="text" class="form-control" name="ho_ten" placeholder="Nhập họ tên của bạn..." value="<?= old('ho_ten') ?>" required />
      <?= displayFieldError('ho_ten') ?>
      <input type="email" class="form-control" name="email" placeholder="Nhập email..." value="<?= old('email') ?>" required />
      <?= displayFieldError('email') ?>
      <div class="form-row">
        <div class="col-md-6 mb-2 mb-md-0">
          <input type="password" class="form-control" name="mat_khau" placeholder="Nhập mật khẩu..." required />
          <?= displayFieldError('mat_khau') ?>
        </div>
        <div class="col-md-6">
          <input type="password" class="form-control" name="xac_nhan_mat_khau" placeholder="Xác nhận mật khẩu..." required />
          <?= displayFieldError('xac_nhan_mat_khau') ?>
        </div>
      </div>
      <div class="form-group mb-2">
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="subnewsletter">
          <label class="custom-control-label" for="subnewsletter">
            Đăng ký bản tin của chúng tôi
          </label>
        </div>
      </div>
      <button class="btn btn-main w-100" type="submit">Đăng ký</button>
      <div class="text-center mt-3">
        <p>Đã có tài khoản? <a href="<?= BASE_URL.'?act=login'?>">Đăng nhập ngay</a></p>
      </div>
    </form>
  </div>
</div>
<?php require_once 'views/layout/footer.php'; ?>