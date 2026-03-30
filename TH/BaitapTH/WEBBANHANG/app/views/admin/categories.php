<?php
$pageTitle = 'Quản lý Danh mục';
ob_start();
?>
<div class="admin-card">
    <div class="admin-card-header">
        <h3>Danh sách Danh mục (<?php echo count($categories); ?>)</h3>
        <a href="<?php echo BASE_URL; ?>/Category/add" class="btn-add">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Thêm danh mục
        </a>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên danh mục</th>
                <th>Mô tả</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($categories)): ?>
                <tr><td colspan="4" style="text-align:center;color:#94a3b8;padding:30px;">Chưa có danh mục nào</td></tr>
            <?php else: ?>
                <?php foreach ($categories as $cat): ?>
                <tr>
                    <td style="color:#94a3b8;font-size:0.8rem;">#<?php echo $cat->getId(); ?></td>
                    <td style="font-weight:600;"><?php echo htmlspecialchars($cat->getName()); ?></td>
                    <td style="color:#64748b;"><?php echo htmlspecialchars($cat->getDescription()); ?></td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <a href="<?php echo BASE_URL; ?>/Category/edit/<?php echo $cat->getId(); ?>" class="tbl-btn tbl-btn-edit">Sửa</a>
                            <a href="<?php echo BASE_URL; ?>/Category/delete/<?php echo $cat->getId(); ?>" class="tbl-btn tbl-btn-del" onclick="return confirm('Xóa danh mục này?')">Xóa</a>
                        </div>
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
