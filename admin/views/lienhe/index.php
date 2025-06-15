<?php require_once __DIR__ . '/../layout/header.php'; ?>
<div class="container mt-4">
    <h2 class="mb-4">Quản lý liên hệ</h2>
    <table class="table table-bordered table-hover bg-white">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Nội dung</th>
                <th>Thời gian</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ds_lienhe as $lh): ?>
                <tr>
                    <td><?= $lh['id'] ?></td>
                    <td><?= htmlspecialchars($lh['name']) ?></td>
                    <td><?= htmlspecialchars($lh['email']) ?></td>
                    <td><?= nl2br(htmlspecialchars($lh['message'])) ?></td>
                    <td><?= $lh['created_at'] ?></td>
                    <td>
                        <a href="index.php?ctl=lienhe_delete&id=<?= $lh['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xóa liên hệ này?')">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once __DIR__ . '/../layout/footer.php'; ?>
