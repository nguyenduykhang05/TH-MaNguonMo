<?php ob_start(); ?>

<div class="page-header">
    <h1>Sửa Danh Mục: <span style="color: var(--primary);"><?php echo htmlspecialchars($category->getName()); ?></span></h1>
    <a href="<?php echo BASE_URL; ?>/Category/list" class="btn btn-outline">← Quay lại danh sách</a>
</div>

<div class="form-container">
    <?php if (!empty($errors)): ?>
        <div class="alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo BASE_URL; ?>/Category/edit/<?php echo $category->getId(); ?>">
        <div class="form-group">
            <label for="name">Tên danh mục: <span style="color: red;">*</span></label>
            <input type="text" id="name" name="name" required value="<?php echo htmlspecialchars($category->getName()); ?>">
        </div>
        
        <div class="form-group">
            <label for="description">Mô tả:</label>
            <textarea id="description" name="description" rows="4"><?php echo htmlspecialchars($category->getDescription()); ?></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Cập nhật Danh Mục</button>
            <a href="<?php echo BASE_URL; ?>/Category/list" class="btn btn-outline">Hủy bỏ</a>
        </div>
    </form>
</div>

<?php 
$content = ob_get_clean();
include 'app/views/layout.php';
?>
