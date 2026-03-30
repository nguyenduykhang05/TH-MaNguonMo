<?php require_once 'app/models/CategoryModel.php'; 
require_once 'app/helpers/SessionHelper.php';
SessionHelper::init();
// Lấy danh mục chung cho Sidebar ở tất cả các trang
$layoutCategories = CategoryModel::getAll();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KhangStore - Điện thoại, Laptop chính hãng</title>
    <!-- Thêm Query string động để chặn vĩnh viễn Browser Cache CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/css/style.css?v=<?php echo time(); ?>">
</head>
<body>
    <header>
        <div class="container">
            <a href="<?php echo BASE_URL; ?>/Product/list" class="brand">KhangStore</a>
            
            <form action="<?php echo BASE_URL; ?>/Product/list" method="GET" class="search-form" style="display: flex; flex: 1; max-width: 500px; margin: 0 2rem;">
                <input type="text" name="keyword" placeholder="Bạn cần tìm gì hôm nay?" style="flex: 1; padding: 0.5rem 1rem; border: none; border-radius: 20px 0 0 20px; outline: none; font-family: inherit;" value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>">
                <button type="submit" style="background: white; border: none; border-radius: 0 20px 20px 0; padding: 0 1rem; cursor: pointer; color: var(--text);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                </button>
            </form>

            <nav class="nav-links">
                <!-- Danh mục Dropdown -->
                <div class="nav-dropdown" id="catDropdown">
                    <div class="nav-dropdown-trigger">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        Danh mục
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="chevron"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </div>
                    <div class="nav-dropdown-menu">
                        <a href="<?php echo BASE_URL; ?>/Product/list" class="nav-dropdown-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>
                            Tất cả sản phẩm
                        </a>
                        <div class="nav-dropdown-divider"></div>
                        <?php foreach ($layoutCategories as $cat): ?>
                        <a href="<?php echo BASE_URL; ?>/Product/list?category_id=<?php echo $cat->getId(); ?>" class="nav-dropdown-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            <?php echo htmlspecialchars($cat->getName()); ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <a href="<?php echo BASE_URL; ?>/Cart/index" class="<?php echo (strpos($_SERVER['REQUEST_URI'], 'Cart') !== false) ? 'active' : ''; ?>">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                    Giỏ hàng 
                    <?php 
                    $cartCount = 0;
                    if(isset($_SESSION['cart'])) {
                        $cartCount = count($_SESSION['cart']);
                    }
                    if($cartCount > 0) {
                        echo "<span class='cart-badge'>$cartCount</span>";
                    }
                    ?>
                </a>
                <?php if(SessionHelper::isLoggedIn()): ?>
                    <?php if(SessionHelper::isAdmin()): ?>
                        <a href="<?php echo BASE_URL; ?>/Admin/dashboard" style="background: #fbbf24; color: #1e293b; font-weight: 700; border-radius: var(--radius-sm); padding: 8px 14px; display: flex; align-items: center; gap: 6px;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                            Admin Panel
                        </a>
                    <?php endif; ?>
                    <a href="<?php echo BASE_URL; ?>/User/logout" onclick="localStorage.removeItem('jwtToken');" style="color: var(--primary);">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                        Đăng xuất (<?php echo htmlspecialchars(SessionHelper::get('username')); ?>)
                    </a>
                <?php else: ?>
                    <a href="<?php echo BASE_URL; ?>/User/login" class="<?php echo (strpos($_SERVER['REQUEST_URI'], 'User/login') !== false) ? 'active' : ''; ?>">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        Đăng nhập
                    </a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <div class="container" style="max-width: 1200px; padding: 0 15px;">
        <main class="main-layout" style="display: block;">
            
            <!-- Category Top Nav Bar (Replacing Sidebar) -->
            <div class="top-category-bar" style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); padding: 10px 15px; margin-bottom: 20px; display: flex; gap: 15px; overflow-x: auto; white-space: nowrap;">
                <a href="<?php echo BASE_URL; ?>/Product/list" style="color: <?php echo !isset($_GET['category_id']) ? 'var(--primary)' : 'var(--text-dark)'; ?>; font-weight: 700; text-decoration: none; padding: 8px 12px; display: inline-flex; align-items: center; gap: 5px; border-bottom: <?php echo !isset($_GET['category_id']) ? '2px solid var(--primary)' : '2px solid transparent'; ?>;">
                   <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg> Tất cả
                </a>
                <?php foreach($layoutCategories as $cat): ?>
                    <a href="<?php echo BASE_URL; ?>/Product/list?category_id=<?php echo $cat->getId(); ?>" style="color: <?php echo (isset($_GET['category_id']) && $_GET['category_id'] == $cat->getId()) ? 'var(--primary)' : 'var(--text-dark)'; ?>; font-weight: 600; text-decoration: none; padding: 8px 12px; border-bottom: <?php echo (isset($_GET['category_id']) && $_GET['category_id'] == $cat->getId()) ? '2px solid var(--primary)' : '2px solid transparent'; ?>;">
                        <?php echo htmlspecialchars($cat->getName()); ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- Cột phải: Content chính (now full width) -->
            <section class="content-area" style="width: 100%;">
                <?php echo $content ?? ''; ?>
            </section>
        </main>
    </div>

    <footer class="enhanced-footer">
        <div class="container footer-grid">
            <div class="footer-col">
                <h4>Về KhangStore</h4>
                <ul>
                    <li><a href="#">Giới thiệu công ty</a></li>
                    <li><a href="#">Tiêu chí bán hàng</a></li>
                    <li><a href="#">Góp ý, khiếu nại</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Chính sách</h4>
                <ul>
                    <li><a href="#">Chính sách bảo hành</a></li>
                    <li><a href="#">Chính sách đổi trả</a></li>
                    <li><a href="#">Thông tin bảo mật</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Hỗ trợ khách hàng</h4>
                <ul>
                    <li><a href="#">Mua hàng trực tuyến: 1800.xxx.xxx</a></li>
                    <li><a href="#">Giải quyết khiếu nại: 1800.xxx.xxx</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Thanh toán miễn phí</h4>
                <div style="display:flex; gap: 10px; margin-top: 10px;">
                    <div style="width: 40px; height: 25px; background: #ddd; border-radius: 4px;"></div>
                    <div style="width: 40px; height: 25px; background: #ddd; border-radius: 4px;"></div>
                    <div style="width: 40px; height: 25px; background: #ddd; border-radius: 4px;"></div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> KhangStore - Project PHP MVC theo phong cách CellphoneS.</p>
        </div>
    </footer>

<?php if (isset($_GET['registered']) && $_GET['registered'] == 'true'): ?>
    <!-- Promo Modal (v2: Show on successful registration) -->
    <div class="promo-modal-overlay active" id="promoModal" style="display: flex; opacity: 1; animation: none;">
        <div class="promo-modal-content" style="transform: scale(1);">
            <span class="promo-modal-close" onclick="closePromoModal()">&times;</span>
            <div class="promo-modal-left">
                <h2 class="promo-modal-title">CHÚC MỪNG BẠN<br>ĐÃ TRỞ THÀNH THÀNH VIÊN</h2>
                <div class="promo-modal-highlight">Nhận ngay đặc quyền & Voucher</div>
                <div class="promo-modal-note">* Nhập Email bên dưới để KhangStore gửi tặng bạn mã giảm giá 10% cho đơn hàng đầu tiên!</div>
                <form class="promo-modal-form" onsubmit="event.preventDefault(); alert(\'Voucher đã được gửi tới Email của bạn!\'); closePromoModal();">
                    <input type="email" placeholder="Email nhận Voucher *" required>
                    <label class="promo-modal-checkbox">
                        <input type="checkbox" required checked>
                        Tôi đồng ý nhận tin khuyến mãi từ KhangStore
                    </label>
                    <div class="promo-modal-actions">
                        <button type="submit" class="promo-btn-submit">NHẬN VOUCHER NGAY</button>
                        <a class="promo-btn-cancel" onclick="closePromoModal()" style="cursor: pointer;">Không, cảm ơn</a>
                    </div>
                </form>
            </div>
            <div class="promo-modal-right">
                <img src="<?php echo BASE_URL; ?>/public/img/mascot.png" alt="Mascot Promo">
            </div>
        </div>
    </div>
    <script>
        function closePromoModal() {
            var modal = document.getElementById("promoModal");
            if(modal) {
                modal.classList.remove("active");
                modal.style.display = "none";
                // Xóa param registered khỏi URL để refresh không bị hiện lại
                var url = new URL(window.location);
                url.searchParams.delete("registered");
                window.history.replaceState(null, null, url);
            }
        }
    </script>
<?php endif; ?>

    <!-- JS logic -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Hiệu ứng hoa mai rơi
        const totalPetals = 35;
        for (let i = 0; i < totalPetals; i++) {
            let petal = document.createElement("div");
            petal.className = "apricot-petal";
            petal.innerHTML = "✿"; // Hoa mai
            petal.style.left = Math.random() * 100 + "vw";
            petal.style.animationDuration = (Math.random() * 5 + 5) + "s, " + (Math.random() * 3 + 2) + "s"; // fall duration, sway duration
            petal.style.animationDelay = (Math.random() * 5) + "s, " + (Math.random() * 5) + "s";
            petal.style.fontSize = (Math.random() * 12 + 10) + "px"; // 10px to 22px
            petal.style.opacity = Math.random() * 0.5 + 0.5; // 0.5 to 1
            document.body.appendChild(petal);
        }
    });
    </script>
</body>
</html>
