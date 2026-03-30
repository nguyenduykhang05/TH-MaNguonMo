<?php ob_start(); ?>

<div style="max-width: 600px; margin: 40px auto; background: white; padding: 40px 30px; border-radius: var(--radius); text-align: center; box-shadow: var(--shadow-sm); border: 1px solid var(--border);">
    
    <div style="width: 80px; height: 80px; background: #dcfce7; color: #16a34a; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
    </div>
    
    <h1 style="color: #16a34a; font-size: 1.6rem; margin-bottom: 10px;">ĐẶT HÀNG THÀNH CÔNG!</h1>
    
    <p style="color: var(--text-main); margin-bottom: 30px; font-size: 1.05rem;">
        Cảm ơn bạn đã tin tưởng mua sắm tại <strong>KhangStore</strong>.<br>
        Nhân viên của chúng tôi sẽ sớm liên hệ với bạn để xác nhận đơn hàng qua số điện thoại.
    </p>

    <div style="background: #f8fafc; padding: 20px; border-radius: var(--radius-sm); border: 1px dashed var(--border); margin-bottom: 30px; text-align: left;">
        <h3 style="font-size: 1rem; margin-bottom: 15px; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px;">Thông tin nhận hàng</h3>
        <p style="margin-bottom: 5px;"><strong>Người nhận:</strong> <?php echo htmlspecialchars($_POST['fullname'] ?? ''); ?></p>
        <p style="margin-bottom: 5px;"><strong>SĐT:</strong> <?php echo htmlspecialchars($_POST['phone'] ?? ''); ?></p>
        <p style="margin-bottom: 5px;"><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($_POST['address'] ?? ''); ?></p>
        <p style="margin-bottom: 0;"><strong>Hình thức thu tiền:</strong> Trực tiếp (COD)</p>
    </div>
    
    <a href="<?php echo BASE_URL; ?>/Product/list" class="btn btn-primary" style="padding: 12px 25px; font-size: 1.05rem;">
        TIẾP TỤC MUA HÀNG
    </a>
</div>

<?php 
$content = ob_get_clean(); 
include 'app/views/layout.php'; 
?>
