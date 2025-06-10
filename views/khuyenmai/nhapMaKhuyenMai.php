<?php require_once 'views/layout/header.php'; ?>
<div class="container mt-5" style="max-width: 400px;">
    <h3 class="mb-3 text-center">Nhập mã khuyến mãi</h3>
    <form method="POST" action="?act=nhap-ma-khuyen-mai">
        <div class="form-group">
            <input type="text" name="ma_khuyen_mai" class="form-control" placeholder="Nhập mã khuyến mãi" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Áp dụng</button>
    </form>
    <?php if (!empty($message)): ?>
        <div class="alert alert-info mt-3 text-center"> <?= $message ?> </div>
    <?php endif; ?>
</div>
<?php require_once 'views/layout/footer.php'; ?> 