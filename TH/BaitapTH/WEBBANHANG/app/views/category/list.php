<?php ob_start(); ?>

<div class="page-header">
    <h1>Quản lý Danh mục</h1>
    <a href="<?php echo BASE_URL; ?>/Category/add" class="btn btn-primary">
        + Thêm danh mục
    </a>
</div>

<div class="category-list" style="background: var(--surface); border-radius: var(--radius); padding: 1.5rem; box-shadow: var(--shadow-sm);">
    <?php if (empty($categories)): ?>
        <p>Chưa có danh mục nào.</p>
    <?php else: ?>
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: var(--background); border-bottom: 2px solid var(--border);">
                <tr>
                    <th style="padding: 1rem; text-align: left;">ID</th>
                    <th style="padding: 1rem; text-align: left;">Tên danh mục</th>
                    <th style="padding: 1rem; text-align: left;">Mô tả</th>
                    <th style="padding: 1rem; text-align: center;">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                    <tr style="border-bottom: 1px solid var(--border);">
                        <td style="padding: 1rem;"><?php echo htmlspecialchars($category->getId()); ?></td>
                        <td style="padding: 1rem; font-weight: bold; color: var(--primary);"><?php echo htmlspecialchars($category->getName()); ?></td>
                        <td style="padding: 1rem; color: var(--text-muted);"><?php echo htmlspecialchars($category->getDescription()); ?></td>
                        <td style="padding: 1rem; text-align: center;">
                            <a href="<?php echo BASE_URL; ?>/Category/edit/<?php echo $category->getId(); ?>" class="btn btn-outline btn-sm">Sửa</a>
                            <a href="<?php echo BASE_URL; ?>/Category/delete/<?php echo $category->getId(); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này? Các sản phẩm thuộc danh mục cũng sẽ bị ảnh hưởng.');">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php 
$content = ob_get_clean();
include 'app/views/layout.php';
?>
