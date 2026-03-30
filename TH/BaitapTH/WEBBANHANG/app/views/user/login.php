<?php
$content = '
<div class="form-container" style="max-width: 400px; margin: 50px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
    <h2 style="text-align: center; color: var(--primary);">Đăng Nhập (JWT)</h2>
    <div id="login-error" style="color: red; text-align: center; margin-top: 10px; display: none;"></div>
    
    <form id="login-form" style="display: flex; flex-direction: column; gap: 15px; margin-top: 20px;">
        <div>
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Tên đăng nhập / Email</label>
            <input type="text" name="username" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; outline: none;">
        </div>
        <div>
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Mật khẩu</label>
            <input type="password" name="password" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; outline: none;">
        </div>
        <button type="submit" style="background: var(--primary); color: white; padding: 12px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; font-weight: bold; margin-top: 5px; transition: opacity 0.2s;">Đăng Nhập</button>
    </form>
    <p style="text-align: center; margin-top: 20px; color: #555;">Chưa có tài khoản? <a href="' . BASE_URL . '/User/register" style="color: var(--primary); text-decoration: none; font-weight: bold;">Đăng ký ngay</a></p>
</div>

<script>
document.getElementById("login-form").addEventListener("submit", function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());
    const errorDiv = document.getElementById("login-error");

    fetch("' . BASE_URL . '/api/user/login", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data)
    })
    .then(async res => {
        const result = await res.json();
        if (res.ok) {
            localStorage.setItem("jwtToken", result.token);
            localStorage.setItem("user", JSON.stringify(result.user));
            // Chuyển hướng về trang danh sách
            window.location.href = "' . BASE_URL . '/Product/list";
        } else {
            errorDiv.textContent = result.message || "Đăng nhập thất bại";
            errorDiv.style.display = "block";
        }
    })
    .catch(err => {
        errorDiv.textContent = "Lỗi kết nối máy chủ";
        errorDiv.style.display = "block";
    });
});
</script>
';

require_once 'app/views/layout.php';
?>
