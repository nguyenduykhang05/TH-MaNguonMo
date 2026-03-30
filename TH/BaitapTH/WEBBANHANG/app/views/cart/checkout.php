<?php ob_start(); ?>

<div class="breadcrumb" style="margin-bottom: 20px;">
    <a href="<?php echo BASE_URL; ?>/Product/list">Trang chủ</a> 
    <span class="sep">›</span> 
    <a href="<?php echo BASE_URL; ?>/Cart/index">Giỏ hàng</a> 
    <span class="sep">›</span> 
    <span class="current" style="color: var(--text-dark);">Thanh toán</span>
</div>

<div class="detail-layout" style="max-width: 1000px; margin: 0 auto;">
    
    <div style="flex: 1.5;">
        <h2 style="margin-bottom: 20px; font-size: 1.25rem;">Thông tin giao hàng</h2>
        
        <form action="<?php echo BASE_URL; ?>/Cart/processOrder" method="post" class="form-container" style="max-width: 100%; border: none; box-shadow: none; padding: 0;">
            <div class="form-group">
                <label>Họ và tên người nhận</label>
                <input type="text" name="fullname" required placeholder="Nhập họ và tên">
            </div>
            <div class="form-group">
                <label>Số điện thoại</label>
                <input type="text" name="phone" required placeholder="Nhập số điện thoại liên hệ">
            </div>
            <div class="form-group">
                <label>Địa chỉ nhận hàng</label>
                <textarea name="address" required rows="3" placeholder="Nhập địa chỉ chi tiết (Số nhà, Hẻm, Phường, Quận...)"></textarea>
            </div>
            
            <h2 style="margin-top: 30px; margin-bottom: 20px; font-size: 1.25rem;">Phương thức thanh toán</h2>
            <div style="border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 15px; margin-bottom: 10px;">
                <label style="display: flex; align-items: center; gap: 10px; margin: 0; cursor: pointer;">
                    <input type="radio" name="payment_method" value="cod" checked style="width: auto;">
                    <span>Thanh toán khi nhận hàng (COD)</span>
                </label>
            </div>
            <div style="border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 15px; background: #f9fafc opacity: 0.6; cursor: not-allowed;">
                <label style="display: flex; align-items: center; gap: 10px; margin: 0; opacity: 0.6;">
                    <input type="radio" name="payment_method" value="vnpay" disabled style="width: auto;">
                    <span>Thanh toán online (Đang bảo trì)</span>
                </label>
            </div>

            <button type="submit" class="btn btn-primary btn-block" style="padding: 15px; font-size: 1.1rem; margin-top: 30px;">
                XÁC NHẬN ĐẶT HÀNG
            </button>
        </form>
    </div>

    <div style="flex: 1;">
        <div style="background: #F9FAFC; border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 25px; position: sticky; top: 100px;">
            <h3 style="margin-bottom: 20px; font-size: 1.1rem; border-bottom: 1px solid var(--border); padding-bottom: 10px;">Đơn hàng của bạn</h3>
            
            <div style="max-height: 300px; overflow-y: auto; margin-bottom: 20px; padding-right: 10px;">
                <?php 
                $totalPrice = 0;
                foreach ($_SESSION['cart'] as $id => $quantity): 
                    $product = ProductModel::findById($id);
                    if ($product):
                        $itemTotal = $product->getPrice() * $quantity;
                        $totalPrice += $itemTotal;
                ?>
                <div style="display: flex; justify-content: space-between; margin-bottom: 15px; align-items: flex-start; gap: 10px;">
                    <div>
                        <div style="font-weight: 500; font-size: 0.9rem; margin-bottom: 4px;"><?php echo htmlspecialchars($product->getName()); ?></div>
                        <div style="color: var(--text-muted); font-size: 0.8rem;">SL: <?php echo $quantity; ?></div>
                    </div>
                    <div style="font-weight: 700; color: var(--text-dark); font-size: 0.9rem; text-align: right; flex-shrink: 0;">
                        <?php echo number_format($itemTotal, 0, ',', '.'); ?>đ
                    </div>
                </div>
                <?php endif; endforeach; ?>
            </div>
            
            <div style="border-top: 1px dashed var(--border); padding-top: 15px; margin-bottom: 15px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 0.95rem; color: #555;">
                    <span>Tạm tính:</span>
                    <span style="font-weight: 600; color: var(--text-dark);"><?php echo number_format($totalPrice, 0, ',', '.'); ?>đ</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 0.95rem; color: #555;">
                    <span>Phí vận chuyển:</span>
                    <span style="font-weight: 600; color: #10b981;">0đ</span>
                </div>
            </div>
            
            <div style="display: flex; justify-content: space-between; align-items: flex-end; border-top: 1px solid var(--border); padding-top: 15px;">
                <strong>Tổng thanh toán:</strong>
                <strong style="color: var(--primary); font-size: 1.5rem;"><?php echo number_format($totalPrice, 0, ',', '.'); ?>đ</strong>
            </div>
        </div>
    </div>

</div>

<?php 
$content = ob_get_clean(); 
include 'app/views/layout.php'; 
?>
