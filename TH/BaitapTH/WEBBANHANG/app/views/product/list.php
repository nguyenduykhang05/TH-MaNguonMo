<?php
require_once 'app/helpers/SessionHelper.php';
SessionHelper::init();
ob_start();
?>

<div class="page-header">
    <h1>Khám phá Sản phẩm</h1>
    <?php if (SessionHelper::isAdmin()): ?>
    <a href="<?php echo BASE_URL; ?>/Product/add" class="btn btn-primary">
        + Thêm sản phẩm
    </a>
    <?php endif; ?>
</div>

<?php if (!isset($_GET['category_id']) && empty($_GET['keyword'])): ?>
<!-- ========== BANNER SLIDER ========== -->
<div class="banner-slider" style="margin-bottom: 1.5rem; position: relative; border-radius: var(--radius); overflow: hidden; box-shadow: var(--shadow);">

    <!-- Slide 1: Sắm Tết -->
    <div class="banner-slide active" style="background: linear-gradient(135deg, #d70018, #8b0000);">
        <div class="hero-banner-content">
            <h2 class="hero-banner-title">SẮM TẾT<br>RƯỚC LỘC</h2>
            <p class="hero-banner-desc">Săn deal chớp nhoáng hàng công nghệ chính hãng. Số lượng có hạn - Mua ngay kẻo lỡ!</p>
            <a href="#hot-deals" class="hero-banner-btn">Khám Phá Ngay</a>
        </div>
        <img src="https://images.unsplash.com/photo-1550009158-9effb6ba3573?auto=format&fit=crop&w=1200&q=80" alt="Tech Banner" class="hero-banner-image">
    </div>

    <!-- Slide 2: Laptop Gaming -->
    <div class="banner-slide" style="background: linear-gradient(135deg, #1a1a2e, #16213e);">
        <div class="hero-banner-content">
            <h2 class="hero-banner-title" style="font-size: 2rem;">LAPTOP GAMING<br>ĐỈNH CAO 2024</h2>
            <p class="hero-banner-desc">RTX 4060 – 4090, màn hình 165Hz. Phá đảo mọi tựa game với hiệu năng siêu việt.</p>
            <a href="<?php echo BASE_URL; ?>/Product/list?category_id=2" class="hero-banner-btn">Mua Laptop Ngay</a>
        </div>
        <img src="https://images.unsplash.com/photo-1603302576837-37561b2e2302?auto=format&fit=crop&w=1200&q=80" alt="Gaming Laptop" class="hero-banner-image">
    </div>

    <!-- Slide 3: Điện thoại iPhone -->
    <div class="banner-slide" style="background: linear-gradient(135deg, #1c1c1e, #3a3a3c);">
        <div class="hero-banner-content">
            <h2 class="hero-banner-title" style="font-size: 2rem;">iPHONE 15<br>PRO MAX</h2>
            <p class="hero-banner-desc">Camera Titanium 48MP, chip A17 Pro, pin siêu bền. Trải nghiệm đẳng cấp Apple chính hãng.</p>
            <a href="<?php echo BASE_URL; ?>/Product/list?category_id=1" class="hero-banner-btn">Xem Điện Thoại</a>
        </div>
        <img src="https://images.unsplash.com/photo-1695048133142-1a20484d2569?auto=format&fit=crop&w=1200&q=80" alt="iPhone 15" class="hero-banner-image">
    </div>

    <!-- Slide 4: Âm thanh Marshall -->
    <div class="banner-slide" style="background: linear-gradient(135deg, #2d4a22, #1a3a10);">
        <div class="hero-banner-content">
            <h2 class="hero-banner-title" style="font-size: 2rem;">ÂM THANH<br>ĐỈNH CỦA ĐỈNH</h2>
            <p class="hero-banner-desc">Loa Marshall, Tai nghe Sony, AirPods Pro. Chìm đắm trong thế giới âm nhạc không giới hạn.</p>
            <a href="<?php echo BASE_URL; ?>/Product/list?category_id=5" class="hero-banner-btn">Nghe Thử Ngay</a>
        </div>
        <img src="https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?auto=format&fit=crop&w=1200&q=80" alt="Audio" class="hero-banner-image">
    </div>

    <!-- Prev / Next Arrows -->
    <button class="banner-arrow banner-prev" onclick="changeBanner(-1)" aria-label="Prev">&#8249;</button>
    <button class="banner-arrow banner-next" onclick="changeBanner(1)" aria-label="Next">&#8250;</button>

    <!-- Dots -->
    <div class="banner-dots">
        <span class="banner-dot active" onclick="goToBanner(0)"></span>
        <span class="banner-dot" onclick="goToBanner(1)"></span>
        <span class="banner-dot" onclick="goToBanner(2)"></span>
        <span class="banner-dot" onclick="goToBanner(3)"></span>
    </div>
</div>

<style>
.banner-slide {
    display: none;
    position: relative;
    align-items: center;
    justify-content: space-between;
    padding: 2rem 3rem;
    color: white;
    min-height: 220px;
}
.banner-slide.active { display: flex; animation: bannerFadeIn 0.5s ease; }
@keyframes bannerFadeIn { from { opacity: 0; transform: scale(1.02); } to { opacity: 1; transform: scale(1); } }

.banner-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255,255,255,0.2);
    border: none;
    color: white;
    font-size: 2.5rem;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    cursor: pointer;
    line-height: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(6px);
    transition: background 0.2s;
    z-index: 10;
}
.banner-arrow:hover { background: rgba(255,255,255,0.35); }
.banner-prev { left: 14px; }
.banner-next { right: 14px; }

.banner-dots {
    position: absolute;
    bottom: 12px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 8px;
    z-index: 10;
}
.banner-dot {
    width: 10px; height: 10px;
    background: rgba(255,255,255,0.5);
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.3s;
}
.banner-dot.active { background: white; transform: scale(1.3); }
</style>

<script>
let bannerIndex = 0;
let bannerTimer;
const slides = document.querySelectorAll('.banner-slide');
const dots   = document.querySelectorAll('.banner-dot');

function goToBanner(n) {
    slides[bannerIndex].classList.remove('active');
    dots[bannerIndex].classList.remove('active');
    bannerIndex = (n + slides.length) % slides.length;
    slides[bannerIndex].classList.add('active');
    dots[bannerIndex].classList.add('active');
    resetBannerTimer();
}
function changeBanner(dir) { goToBanner(bannerIndex + dir); }
function resetBannerTimer() {
    clearInterval(bannerTimer);
    bannerTimer = setInterval(() => changeBanner(1), 2000);
}
resetBannerTimer();
</script>


<div class="product-slider-wrapper" id="hot-deals">
    <div class="product-slider-header">
        <h2 class="product-slider-title" style="color: var(--primary);">🔥 DEAL SẬP SÀN</h2>
        <a href="#" style="color: var(--primary); font-weight: 600; text-decoration: none;">Xem tất cả ></a>
    </div>
    <div class="product-grid" id="hot-deals-grid" style="display: flex; overflow-x: auto; flex-wrap: nowrap; gap: 15px;">
        <!-- Hot Deals rendered by JS -->
    </div>
</div>

<h2 class="product-slider-title" style="margin-bottom: 20px;">🎮 Gợi ý cho bạn</h2>
<?php endif; ?>

<div class="product-grid" id="product-grid">
    <!-- Main product grid rendered by JS -->
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const baseUrl = '<?php echo BASE_URL; ?>';
    const isAdmin = <?php echo SessionHelper::isAdmin() ? 'true' : 'false'; ?>;
    
    const urlParams = new URLSearchParams(window.location.search);
    const categoryId = urlParams.get('category_id');
    const keyword = urlParams.get('keyword');
    
    const token = localStorage.getItem('jwtToken');
    if (!token) {
        window.location.href = `${baseUrl}/User/login`;
        return;
    }
    
    fetch(`${baseUrl}/api/product`, {
        headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json'
        }
    })
        .then(response => {
            if (response.status === 401) {
                localStorage.removeItem('jwtToken');
                window.location.href = `${baseUrl}/User/login`;
                throw new Error('Unauthorized');
            }
            return response.json();
        })
        .then(data => {
            let filteredData = data;
            if (categoryId) {
                filteredData = filteredData.filter(p => p.category_id == categoryId);
            }
            if (keyword) {
                const kw = keyword.toLowerCase();
                filteredData = filteredData.filter(p => p.name.toLowerCase().includes(kw));
            }

            const hotDealsContainer = document.getElementById('hot-deals-grid');
            const mainGrid = document.getElementById('product-grid');
            
            if (hotDealsContainer) hotDealsContainer.innerHTML = '';
            if (mainGrid) mainGrid.innerHTML = '';
            
            if (filteredData.length === 0) {
                if (mainGrid) mainGrid.innerHTML = '<p>Chưa có sản phẩm nào.</p>';
            } else {
                filteredData.forEach((product, index) => {
                    const priceFormatted = new Intl.NumberFormat('vi-VN').format(product.price) + ' đ';
                    const priceStrike = new Intl.NumberFormat('vi-VN').format(product.price * 1.05) + ' đ';
                    const priceDealStrike = new Intl.NumberFormat('vi-VN').format(product.price * 1.15) + ' đ';
                    const imageHtml = product.image ? 
                        `<img src="${product.image}" alt="${product.name}">` : 
                        `<div style="display: flex; flex-direction: column; align-items: center; justify-content: center; width: 100%; height: 100%; background: var(--background);">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--text-muted); opacity: 0.5;">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                <polyline points="21 15 16 10 5 21"></polyline>
                            </svg>
                        </div>`;
                    
                    const adminHtml = isAdmin ? `
                        <div class="actions-row">
                             <a href="${baseUrl}/Product/edit/${product.id}" class="btn btn-outline btn-sm">Sửa</a>
                             <button class="btn btn-danger btn-sm" onclick="deleteProduct(${product.id})">Xóa</button>
                        </div>
                    ` : '';

                    const categoryBadge = product.category_name ? 
                        `<span style="display: inline-block; background: var(--primary-light); color: var(--primary); padding: 0.2rem 0.5rem; border: 1px solid var(--primary); border-radius: 4px; font-size: 0.7rem; font-weight: 700; margin-bottom: 0.5rem; width: fit-content; text-transform: uppercase;">
                            ${product.category_name}
                        </span>` : '';

                    const mainCardHtml = `
                        <div class="product-card">
                            <div class="badge-installment">Trả góp 0%</div>
                            <div class="product-image">
                                <a href="${baseUrl}/Product/detail/${product.id}" style="display:block; width:100%; height:100%;">
                                    ${imageHtml}
                                </a>
                            </div>
                            <div class="product-content">
                                <h3 class="product-title">
                                    <a href="${baseUrl}/Product/detail/${product.id}" style="color:inherit; text-decoration:none;">${product.name}</a>
                                </h3>
                                ${categoryBadge}
                                <div class="product-price-box">
                                    <span class="product-price">${priceFormatted}</span>
                                    <span class="price-strike">${priceStrike}</span>
                                </div>
                                <div class="product-desc">${product.description.substring(0, 80)}...</div>
                                <div class="product-footer">
                                    <a href="${baseUrl}/Cart/add/${product.id}" class="btn btn-primary btn-block">Thêm vào giỏ hàng</a>
                                    ${adminHtml}
                                </div>
                            </div>
                        </div>
                    `;

                    if (mainGrid) {
                        mainGrid.insertAdjacentHTML('beforeend', mainCardHtml);
                    }

                    if (hotDealsContainer && index <= 5) {
                        const hotDealHtml = `
                            <div class="product-card" style="flex: 0 0 240px; min-width: 240px;">
                                <div class="ribbon">Giảm 15%</div>
                                <div class="badge-installment">Trả góp 0%</div>
                                <div class="product-image">
                                    <a href="${baseUrl}/Product/detail/${product.id}" style="display:block; width:100%; height:100%;">
                                        ${imageHtml}
                                    </a>
                                </div>
                                <div class="product-content">
                                    <h3 class="product-title">
                                        <a href="${baseUrl}/Product/detail/${product.id}" style="color:inherit; text-decoration:none;">${product.name}</a>
                                    </h3>
                                    <div class="product-price-box">
                                        <span class="product-price">${priceFormatted}</span>
                                        <span class="price-strike">${priceDealStrike}</span>
                                    </div>
                                </div>
                            </div>
                        `;
                        hotDealsContainer.insertAdjacentHTML('beforeend', hotDealHtml);
                    }
                });
            }
        });
});

function deleteProduct(id) {
    if (!confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) return;
    
    const token = localStorage.getItem('jwtToken');
    const baseUrl = '<?php echo BASE_URL; ?>';
    
    if (!token) {
        alert('Vui lòng đăng nhập lại.');
        window.location.href = `${baseUrl}/User/login`;
        return;
    }

    fetch(`${baseUrl}/api/product/${id}`, {
        method: 'DELETE',
        headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json'
        }
    })
    .then(async res => {
        const result = await res.json();
        if (res.ok) {
            alert('Xóa sản phẩm thành công!');
            location.reload();
        } else {
            alert(result.message || 'Xóa thất bại');
        }
    })
    .catch(err => alert('Lỗi: ' + err.message));
}
</script>

<?php 
$content = ob_get_clean();
include 'app/views/layout.php';
?>
