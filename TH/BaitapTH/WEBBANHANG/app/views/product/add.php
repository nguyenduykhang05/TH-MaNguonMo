<?php ob_start(); ?>

<div class="page-header center" style="flex-direction: column; align-items: flex-start;">
    <h1>Thêm sản phẩm mới</h1>
</div>

<div class="form-container">
    <?php if (!empty($errors)): ?>
        <div class="alert-danger">
            <ul style="list-style: disc; padding-left: 1.5rem;">
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form id="add-product-form">
        <div class="form-group">
            <label for="name">Tên sản phẩm</label>
            <input type="text" id="name" name="name" required placeholder="Nhập tên sản phẩm...">
        </div>

        <div class="form-group">
            <label for="category_id">Danh mục</label>
            <select id="category_id" name="category_id" required style="width: 100%; padding: 1rem 1.2rem; border: 2px solid var(--border); border-radius: var(--radius-sm); font-family: inherit; transition: var(--transition); background: #F8FAFC; font-size: 1rem; color: var(--secondary);">
                <option value="">-- Chọn danh mục --</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category->getId(); ?>"><?php echo htmlspecialchars($category->getName()); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="description">Mô tả</label>
            <textarea id="description" name="description" rows="4" required placeholder="Mô tả chi tiết..."></textarea>
        </div>

        <div class="form-group">
            <label for="price">Giá ($)</label>
            <input type="number" id="price" name="price" step="0.01" required placeholder="0.00">
        </div>

        <div class="form-group">
            <label for="image">URL Hình ảnh</label>
            <input type="url" id="image" name="image" placeholder="https://example.com/image.jpg">
            <small style="color: var(--text-muted);">Copy link ảnh từ internet paste vào đây</small>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Lưu sản phẩm</button>
            <a href="<?php echo BASE_URL; ?>/Product/list" class="btn btn-outline">Hủy bỏ</a>
        </div>
    </form>
</div>

<script>
document.getElementById('add-product-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const token = localStorage.getItem('jwtToken');
    if (!token) {
        alert('Vui lòng đăng nhập lại.');
        window.location.href = '<?php echo BASE_URL; ?>/User/login';
        return;
    }

    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());

    fetch('<?php echo BASE_URL; ?>/api/product', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + token
        },
        body: JSON.stringify(data)
    })
    .then(async res => {
        const result = await res.json();
        if (res.ok) {
            alert('Thêm sản phẩm thành công!');
            window.location.href = '<?php echo BASE_URL; ?>/Product/list';
        } else {
            alert(result.message || result.errors.join('\n'));
        }
    })
    .catch(err => alert('Lỗi: ' + err.message));
});
</script>

<?php 
$content = ob_get_clean();
include 'app/views/layout.php';
?>
