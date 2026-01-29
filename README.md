# Dự Án Sincay Website

## Mô Tả Dự Án

Đây là một dự án website Nhà hàng mỳ cay Hàn Quốc Sincay.
Bao gồm phần giao diện khách hàng và giao diện quản trị cùng với một số chức năng tuy chưa hoàn thiện.

## Hướng Dẫn Cài Đặt và Chạy Dự Án

1. **Clone repository** (nếu có):

2. **Cài đặt dependencies PHP**:

    ```
    composer install
    ```

3. **Cài đặt dependencies JavaScript**:

    ```
    npm install
    ```

4. **Thiết lập môi trường**:
    - Sao chép file `.env.example` thành `.env`:
        ```
        cp .env.example .env
        ```
    - Tạo application key:
        ```
        php artisan key:generate
        ```

5. **Thiết lập database**:
    - Tạo database mới trong MySQL.

    - Cập nhật thông tin database trong file `.env`.

    - Chạy migrations:
      php artisan migrate
    - Chạy seeders:
      php artisan db:seed

6. **Build assets**:

    npm run build

7. **Chạy ứng dụng**:
    - Chạy server:
      php artisan serve
    - Chạy development server cho assets:
      npm run dev

Ứng dụng sẽ chạy tại `http://localhost:8000`.

### Lệnh Hữu Ích

- **Chạy tất cả setup một lần**: `composer run setup`
- **Chạy development với concurrent servers**: `composer run dev`
- **Chạy tests**: `composer run test`

## Cấu Trúc Dự Án

- app/: Code chính của ứng dụng
- app/Http/Controllers: Chứa controller của Fe, /Admin của BE
- resources/views/: Templates Blade
- routes/: Định nghĩa routes
- database/migrations/: Database migrations
- public/: Assets tĩnh

## Ghi Chú Cho Giáo Viên

-Dự án giữa kì chưa hoàn thiện như mong đợi, em sẽ hoàn thiện toàn bộ chức năng vào cuối kì, cảm ơn cô đã dành thời gian xem qua..

## License

Dự án này sử dụng license MIT.
