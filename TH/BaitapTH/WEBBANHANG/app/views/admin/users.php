<?php
$pageTitle = 'Quản lý Người dùng';
ob_start();
?>
<div class="admin-card">
    <div class="admin-card-header">
        <h3>Danh sách Tài khoản (<?php echo count($users); ?>)</h3>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Avatar</th>
                <th>Tên đăng nhập</th>
                <th>Email</th>
                <th>Vai trò</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($users)): ?>
                <tr><td colspan="5" style="text-align:center;color:#94a3b8;padding:30px;">Chưa có tài khoản nào</td></tr>
            <?php else: ?>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td style="color:#94a3b8;font-size:0.8rem;">#<?php echo $user['id']; ?></td>
                    <td>
                        <div style="width:36px;height:36px;border-radius:50%;background:<?php echo $user['role'] === 'admin' ? '#d70018' : '#2563eb'; ?>;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:0.9rem;">
                            <?php echo strtoupper(substr($user['username'], 0, 1)); ?>
                        </div>
                    </td>
                    <td style="font-weight:600;"><?php echo htmlspecialchars($user['username']); ?></td>
                    <td style="color:#64748b;"><?php echo htmlspecialchars($user['email']); ?></td>
                    <td>
                        <?php if ($user['role'] === 'admin'): ?>
                            <span class="badge badge-red">Quản trị viên</span>
                        <?php else: ?>
                            <span class="badge badge-blue">Khách hàng</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php
$adminContent = ob_get_clean();
include 'app/views/admin/layout.php';
?>
