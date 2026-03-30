<?php
$content = '
<div class="form-container" style="max-width: 400px; margin: 50px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
    <h2 style="text-align: center; color: var(--primary);">Đăng Ký Tài Khoản</h2>
    ' . (isset($error) ? '<p style="color: red; text-align: center; margin-top: 10px;">' . htmlspecialchars($error) . '</p>' : '') . '
    <form action="' . BASE_URL . '/User/register" method="POST" style="display: flex; flex-direction: column; gap: 15px; margin-top: 20px;">
        <div>
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Tên đăng nhập</label>
            <input type="text" name="username" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; outline: none;">
        </div>
        <div>
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Email</label>
            <input type="email" name="email" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; outline: none;">
        </div>
        <div>
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Mật khẩu</label>
            <input type="password" name="password" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; outline: none;">
        </div>
        <div>
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Xác nhận mật khẩu</label>
            <input type="password" name="confirm_password" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; outline: none;">
        </div>
        <button type="submit" style="background: var(--primary); color: white; padding: 12px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; font-weight: bold; margin-top: 5px; transition: opacity 0.2s;">Đăng Ký</button>
    </form>
    <p style="text-align: center; margin-top: 20px; color: #555;">Đã có tài khoản? <a href="' . BASE_URL . '/User/login" style="color: var(--primary); text-decoration: none; font-weight: bold;">Đăng nhập</a></p>
</div>
';
require_once 'app/views/layout.php';
?>
