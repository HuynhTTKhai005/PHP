<footer class="footer">
    <div class="footer-container">
        <div class="row">
            <!-- Cột 1: Logo và mô tả -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="footer-logo">
                    <div class="logo">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('assets/images/icons/logo.png') }}" alt="Sincay Logo" height="60">
                        </a>
                    </div> Mỳ Cay <span>Hàn Quốc</span>
                </div>
                <p class="footer-about">
                    Nhà hàng chuyên phục vụ các món mỳ cay Hàn Quốc chính hiệu với nhiều cấp độ cay.
                    Chúng tôi cam kết mang đến trải nghiệm ẩm thực Hàn Quốc đích thực.
                </p>
                <div class="footer-social">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-tiktok"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            <!-- Cột 2: Liên kết nhanh -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h4 class="footer-title">Liên kết nhanh</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li><a href="{{ route('menu') }}">Thực đơn</a></li>
                    <li><a href="{{ route('about') }}">Về chúng tôi</a></li>
                    <li><a href="{{ route('home') }}#booking">Đặt bàn</a></li>
                    <li><a href="{{ route('contact') }}">Liên hệ</a></li>
                </ul>
            </div>

            <!-- Cột 3: Thông tin liên hệ -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h4 class="footer-title">Thông tin liên hệ</h4>
                <div class="footer-contact">
                    <p><i class="fas fa-map-marker-alt"></i> 123 Đường Ẩm Thực, Quận 1, TP.HCM</p>
                    <p><i class="fas fa-phone-alt"></i> (+84) 84 273 9991</p>
                    <p><i class="fas fa-envelope"></i> sincaysystem@gmail.com</p>
                    <p><i class="fas fa-clock"></i> Mở cửa: 9:00 - 22:00 hằng ngày</p>
                </div>
            </div>

            <!-- Cột 4: Giờ mở cửa -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h4 class="footer-title">Giờ mở cửa</h4>
                <div class="footer-hours">
                    <p><span class="day">Thứ 2 - Thứ 6:</span> <span>9:00 - 22:00</span></p>
                    <p><span class="day">Thứ 7:</span> <span>9:00 - 23:00</span></p>
                    <p><span class="day">Chủ nhật:</span> <span>9:00 - 22:00</span></p>
                    <p><span class="day">Ngày lễ:</span> <span>10:00 - 21:00</span></p>
                </div>

                <h4 class="footer-title mt-4">Thanh toán</h4>
                <div class="footer-payment">
                    <i class="fab fa-cc-visa"></i>
                    <i class="fab fa-cc-mastercard"></i>
                    <i class="fab fa-cc-paypal"></i>
                    <i class="fas fa-qrcode"></i>
                </div>
            </div>
        </div>

        <!-- Phần bottom -->
        <div class="footer-bottom">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                    &copy; 2023 Nhà Hàng Sincay - Mỳ Cay Hàn Quốc.
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="#">Chính sách bảo mật</a> |
                    <a href="#">Điều khoản sử dụng</a> |
                </div>
            </div>
        </div>
    </div>
</footer>
