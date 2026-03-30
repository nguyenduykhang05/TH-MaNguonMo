<?php ob_start(); ?>

<div class="page-header center" style="flex-direction: column; align-items: flex-start;">
    <h1>Chỉnh sửa sản phẩm</h1>
</div>

<div class="form-container">
    <form id="edit-product-form">
        <input type="hidden" name="id" value="<?php echo $product->getID(); ?>">
        <div class="form-group">
            <label for="name">Tên sản phẩm</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product->getName()); ?>" required>
        </div>

        <div class="form-group">
            <label for="category_id">Danh mục</label>
            <select id="category_id" name="category_id" required style="width: 100%; padding: 1rem 1.2rem; border: 2px solid var(--border); border-radius: var(--radius-sm); font-family: inherit; transition: var(--transition); background: #F8FAFC; font-size: 1rem; color: var(--secondary);">
                <option value="">-- Chọn danh mục --</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category->getId(); ?>" <?php echo $product->getCategoryId() == $category->getId() ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($category->getName()); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="description">Mô tả</label>
            <textarea id="description" name="description" rows="4" required><?php echo htmlspecialchars($product->getDescription()); ?></textarea>
        </div>

        <div class="form-group">
            <label for="price">Giá ($)</label>
            <input type="number" id="price" name="price" step="0.01" value="<?php echo $product->getPrice(); ?>" required>
        </div>

        <div class="form-group">
            <label for="image">URL Hình ảnh</label>
            <input type="url" id="image" name="image" value="<?php echo htmlspecialchars($product->getImage() ?? ''); ?>">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="<?php echo BASE_URL; ?>/Product/list" class="btn btn-outline">Hủy bỏ</a>
        </div>
    </form>
</div>

<script>
document.getElementById('edit-product-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const token = localStorage.getItem('jwtToken');
    if (!token) {
        alert('Vui lòng đăng nhập lại.');
        window.location.href = '<?php echo BASE_URL; ?>/User/login';
        return;
    }

    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());
    const productId = data.id;

    fetch('<?php echo BASE_URL; ?>/api/product/' + productId, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + token
        },
        body: JSON.stringify(data)
    })
    .then(async res => {
        const result = await res.json();
        if (res.ok) {
            alert('Cập nhật sản phẩm thành công!');
            window.location.href = '<?php echo BASE_URL; ?>/Product/list';
        } else {
            alert(result.message || 'Cập nhật thất bại');
        }
    })
    .catch(err => alert('Lỗi: ' + err.message));
});
</script>

<?php 
$content = ob_get_clean();
include 'app/views/layout.php';
?>
