# Sincay Restaurant (Laravel)

Dự án website nhà hàng gồm frontend đặt món/đặt bàn và admin quản trị sản phẩm, đơn hàng, khách hàng, danh mục, khuyến mãi.

## 1. Yêu cầu hệ thống

- PHP >= 8.1 (khuyến nghị 8.2)
- Composer >= 2
- MySQL/MariaDB
- Node.js >= 18
- NPM

Extension PHP cần bật:
- `openssl`, `pdo`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`

## 2. Cài đặt nhanh

```bash
git clone <repo-url>
cd php
composer install
npm install
```

## 3. Cấu hình môi trường

Tạo file `.env` từ mẫu:

```bash
cp .env.example .env
```

Nếu dùng Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

Kiểm tra lại thông tin DB trong `.env` (mặc định từ project):

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=restaurant
DB_USERNAME=root
DB_PASSWORD=123456
```

Tạo key ứng dụng:

```bash
php artisan key:generate
```

## 4. Khởi tạo database

Tạo database `restaurant` trong MySQL trước, sau đó chạy:

```bash
php artisan migrate
php artisan db:seed
```

Nếu cần làm mới toàn bộ dữ liệu:

```bash
php artisan migrate:fresh --seed
```

## 5. Chạy dự án

### Cách 1: Chạy tách 2 terminal

Terminal 1:
```bash
php artisan serve
```

Terminal 2:
```bash
npm run dev
```

### Cách 2: Build assets production

```bash
npm run build
php artisan serve
```

Truy cập:
- Frontend: `http://127.0.0.1:8000`
- Admin: đăng nhập rồi vào `http://127.0.0.1:8000/dashboard`

## 6. Tài khoản mẫu (sau khi seed)

- Admin:
  - Email: `admin@example.com`
  - Mật khẩu: `123456`

- Nhân viên:
  - `staff1@example.com` / `123456`
  - `staff2@example.com` / `123456`

## 7. Lệnh hữu ích

```bash
php artisan route:list
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

## 8. Troubleshooting

### Lỗi không kết nối được database
- Kiểm tra DB đã tạo chưa (`restaurant`)
- Kiểm tra lại `DB_USERNAME`, `DB_PASSWORD` trong `.env`
- Chạy lại:

```bash
php artisan config:clear
```

### Lỗi không load CSS/JS
- Chạy `npm install` và `npm run dev`
- Hard refresh trình duyệt (`Ctrl + F5`)

### Lỗi migration do bảng đã tồn tại

```bash
php artisan migrate:fresh --seed
```

### Lỗi quyền truy cập ảnh (nếu dùng storage)

```bash
php artisan storage:link
```

## 9. Ghi chú

- Dự án dùng Laravel MVC, dữ liệu chính qua Eloquent + Migration/Seeder.
- Khi chỉnh sửa tiếng Việt trong file, nên lưu UTF-8 để tránh lỗi phông chữ.