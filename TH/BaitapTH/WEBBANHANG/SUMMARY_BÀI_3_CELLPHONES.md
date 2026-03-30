# BÁO CÁO NHẬT KÝ NÂNG CẤP DỰ ÁN (BÀI 3)
*Ngày thực hiện: 02/03/2026*

## I. MỤC ĐÍCH
Biến đổi hoàn toàn bộ khung giao diện của ứng dụng web tĩnh hiện tại thành trang web Bán lẻ Sản Phẩm Công nghệ động chuyên nghiệp, lấy cảm hứng và phong cách chuẩn từ hệ thống CellphoneS hiện nay (Đổi lại tên thương hiệu là **KhangStore**).
Kết nối toàn bộ các chức năng lọc và hiển thị sản phẩm sang MySQL Database (`my_store`).

---

## II. CHI TIẾT CÁC THAY ĐỔI ĐÃ THỰC HIỆN

### 1. Cấu trúc CSDL (Database: `my_store`)
- **Khởi tạo và Seed dữ liệu:** Đã tạo file `setup_my_store.php` thực thi bằng PHP PDO để tạo mới CSDL nếu chưa có, tạo cấu trúc 2 bảng Core là `category` (Danh mục) và `product` (Sản phẩm).
- **Dữ liệu mẫu tiền VNĐ:** Cập nhật 4 sản phẩm điện thoại/táo chất lượng cao làm mồi (Seed Data) với giá trị thực tế theo VNĐ (Vd: iPhone 15 Pro Max - 29.990.000 đ, S24 Ultra, Macbook M3 Max, AirPods).

### 2. Định hình Giao Diện (Core CSS)
- **Tập tin `public/css/style.css`:** Xóa sạch code Glassmorphism/màu xanh dương cũ. Đập đi xây lại hệ thống CSS 100% bằng:
  - Tông màu Đỏ/Trắng/Đen làm chuẩn (`--primary: #d70018;`).
  - Layout Grid 2 cột: Cột trái dọc hiển thị Danh mục sản phẩm (Sidebar), bên phải hiển thị danh sách dạng thẻ sản phẩm dạng lưới (Grid).
  - Component Thẻ Sản Phẩm (Product Card): Thêm nhãn "Giảm sập sàn" đè lên góc trên bên trái bức hình, làm nổi bật font chữ của giá tiền.
  - Fix hiệu ứng hover nhẹ nhàng (zoom kích thước ảnh 105%), bo góc cứng cáp hơn.

### 3. Tái cấu trúc Views (Giao diện hiển thị HTML)
- **`app/views/layout.php`:**
  - Import Layout 2 cột mới.
  - Lấy danh mục tự động từ `$layoutCategories` để rải vào vòng lặp (Menu dọc bên trái trang).
  - Sửa Menu Header (Nav-links) gồm Nút Sản phẩm và Nút Giỏ hàng (Mỗi nút chèn thêm 1 bộ Icon SVG sinh động).
  - Tích hợp Badge (Vòng tròn đỏ) đếm số lượng mặt hàng đang có trong Giỏ. Số đếm hiện tại chỉ "đếm số lượng mã mặt hàng" - `count($_SESSION['cart'])` chứ không cộng dồn số lượng từng món.
  - Đổi thương hiệu chữ hiển thị, bản quyền Footer thành **KhangStore**.
- **`app/views/product/list.php`:** 
  - Render theo thẻ sản phẩm CellphoneS style. 
  - Đổi text nút Call-to-action từ "MUA NGAY" thành **"Thêm vào giỏ hàng"**.

### 4. Code Logic (Controllers & Models)
- **Bộ lọc trang Chủ (Filter Category):**
  - **`app/models/ProductModel.php`:** Bổ sung hàm lõi `getByCategory($categoryId)` để query danh sách đồ dùng dựa trên ID của Danh Mục.
  - **`app/controllers/ProductController.php`:** Mở rộng hàm `list()`, cho phép nhận dữ liệu `isset($_GET['category_id'])` từ đường link để gọi model lọc sản phẩm mà không cần tải lại toàn bộ trang web hoặc tạo file mới.
- **Giỏ Hàng (CartController):**
  - **`app/views/cart/index.php`:** Cập nhật file view này để hiển thị đúng chuẩn tiền tệ của Việt Nam (VD: `$3,499.00` => `87.490.000 đ`). Sử dụng tham số `,`, `.` của PHP `number_format()`.
  - Fix lại đường dẫn cho nút vào thanh Menu trong màn `layout.php` vào chuẩn logic `CartController` (Từ `/Cart/view` thành `/Cart/index`).

---

## III. DỮ LIỆU ĐANG ĐƯỢC LƯU TRỮ RA SAO?
Do dự án của bạn (Project 1 - WEBBANHANG) được xây dựng theo mô hình **PHP MVC** thủ công kết hợp cùng **Laragon**, nên:
- Mọi dữ liệu như Sản Phẩm, Danh mục lúc này đều đã được **lưu vĩnh viễn** ở dưới cấu hình MySQL server (Data directory của Laragon). 
- Toàn bộ giao diện màu Đỏ (KhangStore CellphoneS-style) đều đã được lưu đè lên file `style.css` nằm trong folder `public`.
- Việc bạn Restart Server, Tắt máy tính không làm mất dữ liệu sản phẩm, cũng không làm mất giao diện mới này của bạn, vì tất cả đã được ghi trực tiếp đè vào ổ cứng.

***
**Tài liệu này được xuất tự động vào ngày 02/03/2026. File được đặt tại thư mục Root của Project để tiện tra cứu sau này.**
