<?php
$pageTitle = 'Quản lý Sản phẩm';
ob_start();
?>
<div class="admin-card">
    <div class="admin-card-header">
        <h3>Danh sách Sản phẩm (<?php echo count($products); ?>)</h3>
        <a href="<?php echo BASE_URL; ?>/Product/add" class="btn-add">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Thêm sản phẩm
        </a>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Danh mục</th>
                <th>Giá</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($products)): ?>
                <tr><td colspan="6" style="text-align:center;color:#94a3b8;padding:30px;">Chưa có sản phẩm nào</td></tr>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td style="color:#94a3b8;font-size:0.8rem;">#<?php echo $product->getID(); ?></td>
                    <td>
                        <?php if ($product->getImage()): ?>
                            <img src="<?php echo htmlspecialchars($product->getImage()); ?>" alt="">
                        <?php else: ?>
                            <div style="width:44px;height:44px;background:#f1f5f9;border-radius:6px;display:flex;align-items:center;justify-content:center;color:#94a3b8;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td style="font-weight:600;max-width:250px;">
                        <a href="<?php echo BASE_URL; ?>/Product/detail/<?php echo $product->getID(); ?>" target="_blank" style="color:#1e293b;">
                            <?php echo htmlspecialchars($product->getName()); ?>
                        </a>
                    </td>
                    <td><span class="badge badge-blue"><?php echo htmlspecialchars($product->getCategoryName() ?: 'N/A'); ?></span></td>
                    <td style="font-weight:700;color:#d70018;"><?php echo number_format($product->getPrice(), 0, ',', '.'); ?>đ</td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <a href="<?php echo BASE_URL; ?>/Product/detail/<?php echo $product->getID(); ?>" target="_blank" class="tbl-btn tbl-btn-view">Xem</a>
                            <a href="<?php echo BASE_URL; ?>/Product/edit/<?php echo $product->getID(); ?>" class="tbl-btn tbl-btn-edit">Sửa</a>
                            <a href="<?php echo BASE_URL; ?>/Product/delete/<?php echo $product->getID(); ?>" class="tbl-btn tbl-btn-del" onclick="return confirm('Bạn chắc chắn muốn xóa sản phẩm này?')">Xóa</a>
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
