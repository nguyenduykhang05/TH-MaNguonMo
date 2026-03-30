<?php ob_start(); ?>

<div class="breadcrumb">
    <a href="<?php echo BASE_URL; ?>/Product/list">Trang chủ</a> 
    <span class="sep">›</span> 
    <a href="<?php echo BASE_URL; ?>/Product/list?category_id=<?php echo htmlspecialchars($product->getCategoryId()); ?>"><?php echo htmlspecialchars($product->getCategoryName()); ?></a> 
    <span class="sep">›</span> 
    <span class="current" style="color: var(--text-dark);"><?php echo htmlspecialchars($product->getName()); ?></span>
</div>

<div class="detail-layout">
    <div class="detail-gallery">
        <div class="detail-main-img-box">
            <?php if ($product->getImage()): ?>
                <img src="<?php echo htmlspecialchars($product->getImage()); ?>" alt="<?php echo htmlspecialchars($product->getName()); ?>">
            <?php else: ?>
                <div style="display: flex; align-items: center; justify-content: center; width: 100%; height: 100%; background: var(--background);">
                    <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="detail-features">
            <div class="detail-features-title">TÍNH NĂNG NỔI BẬT</div>
            <ul>
                <li>Pin khủng 5000 mAh bền bỉ hỗ trợ sạc nhanh, tối ưu trải nghiệm cả ngày dài</li>
                <li>Màn hình siêu nét tần số quét 120Hz sáng rực rỡ, vuốt chạm cực kì mượt mà</li>
                <li>Thiết kế nguyên khối khung hợp kim cao cấp chuẩn kháng nước IP68 (Thông tin mô phỏng tự động)</li>
            </ul>
        </div>
    </div>
    
    <div class="detail-info">
        <h1 class="detail-title"><?php echo htmlspecialchars($product->getName()); ?></h1>
        
        <div class="detail-price-box">
            <div>
                <div class="detail-price-current"><?php echo number_format($product->getPrice(), 0, ',', '.'); ?>đ</div>
                <div class="detail-price-old"><?php echo number_format($product->getPrice() * 1.15, 0, ',', '.'); ?>đ</div>
            </div>
            <div class="detail-price-trade">
                <span class="label">Thu cũ lên đời chỉ từ</span>
                <span class="val"><?php echo number_format($product->getPrice() * 0.85, 0, ',', '.'); ?>đ</span>
                <a href="#" style="font-size: 0.8rem; color: #2563EB;">Trợ giá đến 2 triệu. Định giá ngay!</a>
            </div>
        </div>
        
        <div class="detail-variants">
            <h4>Phiên bản bộ nhớ</h4>
            <div class="variant-grid">
                <div class="variant-item active">
                    <span class="size">Tiêu chuẩn</span>
                    <span class="v-price"><?php echo number_format($product->getPrice(), 0, ',', '.'); ?>đ</span>
                </div>
                <!-- Mock Options -->
                <div class="variant-item">
                    <span class="size">Bản nâng cấp</span>
                    <span class="v-price"><?php echo number_format($product->getPrice() * 1.1, 0, ',', '.'); ?>đ</span>
                </div>
                <div class="variant-item">
                    <span class="size">Bản cao cấp Max</span>
                    <span class="v-price"><?php echo number_format($product->getPrice() * 1.25, 0, ',', '.'); ?>đ</span>
                </div>
            </div>
        </div>

        <div class="detail-variants">
            <h4>Màu sắc</h4>
            <div class="detail-color-grid">
                <div class="color-item active">
                    <div class="color-swatch" style="background: #e2e8f0;"></div>
                    <div style="font-size: 0.8rem;">Bản Trắng<br><strong style="color:var(--primary);"><?php echo number_format($product->getPrice(), 0, ',', '.'); ?>đ</strong></div>
                </div>
                <div class="color-item">
                    <div class="color-swatch" style="background: #1e293b;"></div>
                    <div style="font-size: 0.8rem;">Bản Đen<br><strong><?php echo number_format($product->getPrice(), 0, ',', '.'); ?>đ</strong></div>
                </div>
            </div>
        </div>
        
        <div class="detail-promos">
            <div class="promo-header">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                Khuyến mãi và Ưu đãi (Độc quyền KhangStore)
            </div>
            <div class="promo-body">
                <ul>
                    <li>Giảm thêm <strong>300.000đ</strong> khi thanh toán qua thẻ tín dụng liên kết.</li>
                    <li>Tặng Voucher mua phụ kiện trị giá <strong>500.000đ</strong> áp dụng trong 30 ngày.</li>
                    <li>Ưu đãi đặc quyền học sinh, sinh viên: Trợ giá thêm <strong>đến 5% giá máy</strong>.</li>
                </ul>
                <div style="padding: 10px; border: 1px dashed #ef4444; border-radius: 6px; background: #fef2f2; margin-top: 10px; font-size: 0.85rem; color: #b91c1c;">
                    <strong style="display:block; margin-bottom: 5px;">Cam kết chính hãng:</strong>
                    ✓ Bảo hành 12 tháng tại trung tâm ủy quyền.<br>
                    ✓ 1 đổi 1 trong 30 ngày nếu có lỗi phần cứng do NSX.
                </div>
            </div>
        </div>
        
        <div class="detail-actions">
            <a href="<?php echo BASE_URL; ?>/Cart/add/<?php echo $product->getID(); ?>" class="btn-buy-now" style="text-decoration: none;">
                <strong>MUA NGAY</strong>
                <small>Giao hàng miễn phí tận nơi hoặc nhận tại cửa hàng</small>
            </a>
            <button class="btn-installment">
                <strong>TRẢ GÓP 0%</strong>
                <small>Duyệt hồ sơ nhanh</small>
            </button>
        </div>
        
        <div style="margin-top: 20px; font-size: 0.95rem;">
            <h4 style="border-bottom: 1px solid var(--border); padding-bottom: 10px; margin-bottom: 10px;">Đặc điểm nổi bật (Chi tiết)</h4>
            <div style="line-height: 1.6; color: #444;">
                <?php echo nl2br(htmlspecialchars($product->getDescription())); ?>
            </div>
        </div>
        
    </div>
</div>

<?php if (!empty($relatedProducts)): ?>
<div class="product-slider-wrapper" style="margin-top: 40px;">
    <div class="product-slider-header">
        <h2 class="product-slider-title" style="font-size: 1.3rem;">Khám phá các sản phẩm tương tự</h2>
    </div>
    <div class="product-grid" style="display: flex; overflow-x: auto; flex-wrap: nowrap; gap: 15px;">
        <?php foreach ($relatedProducts as $relProduct): ?>
            <a href="<?php echo BASE_URL; ?>/Product/detail/<?php echo $relProduct->getID(); ?>" class="product-card" style="flex: 0 0 200px; min-width: 200px; text-decoration: none; color: inherit;">
                <div class="product-image" style="height: 150px;">
                    <?php if ($relProduct->getImage()): ?>
                        <img src="<?php echo htmlspecialchars($relProduct->getImage()); ?>" alt="<?php echo htmlspecialchars($relProduct->getName()); ?>">
                    <?php else: ?>
                        <div style="display: flex; align-items: center; justify-content: center; width: 100%; height: 100%; background: var(--background);">无图</div>
                    <?php endif; ?>
                </div>
                <div class="product-content">
                    <h3 class="product-title" style="font-size: 0.85rem;"><?php echo htmlspecialchars($relProduct->getName()); ?></h3>
                    <div class="product-price-box" style="margin-bottom: 0;">
                        <span class="product-price" style="font-size: 1rem;"><?php echo number_format($relProduct->getPrice(), 0, ',', '.'); ?> đ</span>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<?php 
$content = ob_get_clean();
include 'app/views/layout.php';
?>
