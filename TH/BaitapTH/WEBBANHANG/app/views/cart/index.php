<?php ob_start(); ?>

<div class="breadcrumb" style="margin-bottom: 20px;">
    <a href="<?php echo BASE_URL; ?>/Product/list">Trang chủ</a> 
    <span class="sep">›</span> 
    <span class="current" style="color: var(--text-dark);">Giỏ hàng của bạn</span>
</div>

<div class="form-container" style="max-width: 900px; margin: 0 auto; padding: 30px;">
    <h1 style="text-align: center; margin-bottom: 30px; color: var(--text-dark);">GIỎ HÀNG</h1>
    
    <?php if (empty($cartItems)): ?>
        <div style="text-align: center; padding: 40px 0;">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color: #cbd5e1; margin-bottom: 15px;"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
            <h3 style="color: var(--text-main); margin-bottom: 15px;">Chưa có sản phẩm nào trong giỏ hàng</h3>
            <a href="<?php echo BASE_URL; ?>/Product/list" class="hero-banner-btn" style="background: var(--primary); color: white;">Về trang chủ mua sắm</a>
        </div>
    <?php else: ?>
        <form action="<?php echo BASE_URL; ?>/Cart/update" method="post">
            <div style="background: #F9FAFC; border: 1px solid var(--border); border-radius: var(--radius-sm); overflow: hidden; margin-bottom: 25px;">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="background: white; border-bottom: 1px solid var(--border);">
                            <th style="padding: 15px; width: 50%;">Sản phẩm</th>
                            <th style="padding: 15px; text-align: center;">Đơn giá</th>
                            <th style="padding: 15px; text-align: center;">Số lượng</th>
                            <th style="padding: 15px; text-align: right;">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cartItems as $item): ?>
                            <tr style="border-bottom: 1px solid var(--border);">
                                <td style="padding: 15px;">
                                    <div style="display: flex; gap: 15px; align-items: center;">
                                        <div style="width: 80px; height: 80px; flex-shrink: 0; background: white; border: 1px solid var(--border); border-radius: 4px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                            <?php if ($item['product']->getImage()): ?>
                                                <img src="<?php echo htmlspecialchars($item['product']->getImage()); ?>" style="max-height: 100%; object-fit: contain;">
                                            <?php else: ?>
                                                <span style="color: #ccc; font-size: 0.8rem;">No Image</span>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <a href="<?php echo BASE_URL; ?>/Product/detail/<?php echo $item['product']->getID(); ?>" style="font-weight: 700; color: var(--text-dark); display: block; margin-bottom: 5px;"><?php echo htmlspecialchars($item['product']->getName()); ?></a>
                                            <a href="<?php echo BASE_URL; ?>/Cart/remove/<?php echo $item['product']->getID(); ?>" style="font-size: 0.8rem; color: #ef4444; font-weight: 500; display: inline-flex; align-items: center; gap: 4px;">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                                Xóa
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 15px; text-align: center; font-weight: 500;">
                                    <?php echo number_format($item['product']->getPrice(), 0, ',', '.'); ?>đ
                                </td>
                                <td style="padding: 15px; text-align: center;">
                                    <input type="number" name="quantities[<?php echo $item['product']->getID(); ?>]" value="<?php echo $item['quantity']; ?>" min="1" max="99" style="width: 60px; text-align: center; padding: 5px; border-radius: 4px; border: 1px solid #ccc;">
                                </td>
                                <td style="padding: 15px; text-align: right; font-weight: 700; color: var(--primary);">
                                    <?php echo number_format($item['total'], 0, ',', '.'); ?>đ
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 20px;">
                <div>
                    <button type="submit" class="btn btn-outline">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 5px;"><polyline points="23 4 23 10 17 10"></polyline><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path></svg>
                        Cập nhật giỏ hàng
                    </button>
                    <a href="<?php echo BASE_URL; ?>/Product/list" class="btn btn-danger" style="margin-top: 10px; border-color: transparent; background: transparent; padding-left:0;">
                        Tiếp tục mua sắm
                    </a>
                </div>
                
                <div style="background: white; border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 25px; width: 350px;">
                    <h3 style="margin-bottom: 20px; font-size: 1.1rem; border-bottom: 1px solid var(--border); padding-bottom: 10px;">Tổng tiền giỏ hàng</h3>
                    
                    <div style="display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 0.95rem; color: #555;">
                        <span>Tạm tính:</span>
                        <span style="font-weight: 600; color: var(--text-dark);"><?php echo number_format($totalParam, 0, ',', '.'); ?>đ</span>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 0.95rem; color: #555;">
                        <span>Phí vận chuyển:</span>
                        <span style="font-weight: 600; color: #10b981;">Miễn phí</span>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; margin-bottom: 25px; font-size: 1.1rem; border-top: 1px dashed var(--border); padding-top: 15px;">
                        <strong>Tổng cộng:</strong>
                        <strong style="color: var(--primary); font-size: 1.4rem;"><?php echo number_format($totalParam, 0, ',', '.'); ?>đ</strong>
                    </div>
                    
                    <a href="<?php echo BASE_URL; ?>/Cart/checkout" class="btn btn-primary btn-block" style="text-decoration: none; padding: 12px; font-size: 1.05rem;">
                        TIẾN HÀNH ĐẶT HÀNG
                    </a>
                </div>
            </div>
        </form>
    <?php endif; ?>
</div>

<?php 
$content = ob_get_clean(); 
include 'app/views/layout.php'; 
?>
