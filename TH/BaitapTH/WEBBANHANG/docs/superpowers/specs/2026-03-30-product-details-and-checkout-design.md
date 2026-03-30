# 2026-03-30 Product Details and Checkout Design

## MỤC TIÊU & MÔ TẢ (GOAL)
Hoàn thiện kiến trúc thương mại điện tử "KhangStore" dựa trên bộ khung CellphoneS. Người dùng sẽ có khả năng xem chi tiết thông số kỹ thuật sản phẩm, kiểm tra giỏ hàng và thanh toán (để lại thông tin đặt hàng).

## 1. THIẾT KẾ CƠ SỞ DỮ LIỆU (DATABASE ARCHITECTURE)
Để hỗ trợ lưu trữ đơn hàng thay vì chỉ lưu tạm trên Session:
**Hai bảng (Tables) mới được thêm vào database `my_store`:**
1. **`orders`**: Ghi nhận thông tin khái quát đơn hàng và người đặt.
   - `id` (INT Auto Increment Primary Key)
   - `customer_name` (VARCHAR)
   - `customer_phone` (VARCHAR)
   - `customer_address` (TEXT)
   - `notes` (TEXT) - Lời nhắn thêm của khách.
   - `total_amount` (DECIMAL 12,2)
   - `status` (ENUM: 'pending', 'completed', 'cancelled')
   - `created_at` (TIMESTAMP)
2. **`order_details`**: Ghi nhận chi tiết từng món hàng (có thể nhiều món trong 1 đơn).
   - `id` (INT Auto Increment)
   - `order_id` (INT Foreign Key)
   - `product_id` (INT Foreign Key)
   - `quantity` (INT)
   - `price` (DECIMAL 12,2)

*Dự định tạo file SQL script riêng hoặc gộp chung vào `setup_my_store.php` để tạo bảng nếu chưa có.*

## 2. LUỒNG XỬ LÝ (USER FLOW)
- **Trang Chi Tiết Sản Phẩm (`/product/detail/[id]`)**: 
  - Khách hàng bấm từ màn hình danh sách, lấy được `product_id`. 
  - Giao diện có khu vực Ảnh sản phẩm bên trái, Các thông số kỹ thuật bên phải (tạm lấy từ `description`).
  - Nút "Thêm vào giỏ hàng" lớn, kích hoạt phương thức POST qua `/cart/add`.
- **Giỏ Hàng (`/cart/index`)**:
  - Load toàn bộ `product_id` từ `$_SESSION['cart']`.
  - Hiển thị danh sách thiết bị. (Kèm cột hình ảnh, Tên, Số lượng, Giá, Tổng phụ).
  - Có các nút Update (+/- số lượng) và Xóa sản phẩm.
  - Phía dưới chứa Form "Thông tin khách mua hàng".
- **Thanh Toán (Checkout - POST `/cart/checkout`)**:
  - Tiếp nhận Form từ Trang Giỏ hàng.
  - Kiểm tra xem Giỏ có rỗng không.
  - Insert dữ liệu `$_POST` vào bảng `orders`.
  - Duyệt `$_SESSION['cart']` => Insert từng mục vào phần `order_details`.
  - `unset($_SESSION['cart'])` để xóa trống giỏ -> Chuyển hướng tới trang "Cảm ơn".

## 3. UI LỚP TRANG (VIEWS) & CONTROLLERS
- `app/controllers/ProductController.php`: Bổ sung thêm function `detail($id)` gọi đến view chi tiết sản phẩm.
- `app/controllers/CartController.php`: Sửa đổi view `index.php` chứa giao diện Giỏ hàng + Form Đặt hàng. Thêm hàm `checkout()`.
- Lấy lại `style.css` hiện có, tạo thêm style cho lưới (grid) Thông số Cấu hình giống các website công nghệ lớn.

## 4. XÉT DUYỆT RỦI RO (SELF-REVIEW)
- Mâu thuẫn logic: Cột giá trong bảng `order_details` lưu giá thực tế tại thời điểm mua (vì nhỡ sau này sản phẩm lên xuống giá trong DB thì lịch sử Order bị sai -> nên đây là thiết kế bắt buộc).
- Ambiguity: URL `product/detail` sẽ định dạng sao? Sẽ dùng tham số GET `?id=123`.
- Placeholder TBD: Phần Form chỉ cần tối thiểu Tên, SĐT, Địa chỉ. Email có thể bỏ qua để tối đa tốc độ chuyển đổi.

MÔ TẢ THIẾT KẾ ĐÃ HOÀN TẤT VÀ CHẤP THUẬN CƠ BẢN TỪ USER.
