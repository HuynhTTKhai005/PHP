@extends('layouts.pato')

@section('content')
    <!-- Phần Header với tiêu đề -->
    <section class="titles text-center text-white"
        style="background:   url({{ asset('assets/images/bgintro.png') }}) center/cover no-repeat; min-height: 400px;">
        <div class="container">
            <h2 class="tit">Liên hệ Sincay</h2>
        </div>
    </section>

    <!-- Phần chính với map và form liên hệ -->
    <section class="spicy-contact-section">
        <div class="container">
            <!-- Google Maps -->
            <div class="spicy-map-container">
                <div class="spicy-map">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d29804.32622626954!2d106.64019445!3d10.7750359!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752ea144839ef1%3A0x798819bdcd0522b0!2zQ2FvIMSQ4bqzbmcgQ8O0bmcgTmdo4buHIFRow7RuZyBUaW4gVFAuSENN!5e1!3m2!1svi!2s!4v1765330404359!5m2!1svi!2s"
                        width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>

            <!-- Tiêu đề form -->
            <h3 class="spicy-section-title">
                Gửi Tin Nhắn Cho Chúng Tôi
            </h3>

            <!-- Form liên hệ -->
            <div class="spicy-form-container">
                <form class="row g-4">
                    <div class="col-md-4">
                        <label class="spicy-form-label">Tên</label>
                        <input class="spicy-form-input" type="text" name="name" placeholder="Nhập tên của bạn">
                    </div>

                    <div class="col-md-4">
                        <label class="spicy-form-label">Email</label>
                        <input class="spicy-form-input" type="email" name="email" placeholder="Nhập địa chỉ email">
                    </div>

                    <div class="col-md-4">
                        <label class="spicy-form-label">Điện Thoại</label>
                        <input class="spicy-form-input" type="text" name="phone" placeholder="Nhập số điện thoại">
                    </div>

                    <div class="col-12">
                        <label class="spicy-form-label">Tin Nhắn</label>
                        <textarea class="spicy-form-textarea" name="message" placeholder="Nhập nội dung tin nhắn"></textarea>
                    </div>

                    <div class="col-12 text-center">
                        <button type="submit" class="spicy-btn-submit">
                            <i class="fas fa-paper-plane me-2"></i> Gửi Tin Nhắn
                        </button>
                    </div>
                </form>
            </div>

            <!-- Thông tin liên hệ -->
            <div class="spicy-info-container">
                <div class="row">
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="spicy-info-box">
                            <div class="spicy-info-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h4 class="spicy-info-title">Địa Điểm</h4>
                                <p class="spicy-info-text">
                                    123 Đường Ẩm Thực, Quận 1<br>
                                    Thành phố Hồ Chí Minh, Việt Nam
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="spicy-info-box">
                            <div class="spicy-info-icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div>
                                <h4 class="spicy-info-title">Gọi Cho Chúng Tôi</h4>
                                <p class="spicy-info-text">
                                    (+84) 28 1234 5678<br>
                                    (+84) 909 123 456
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="spicy-info-box">
                            <div class="spicy-info-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <h4 class="spicy-info-title">Giờ Mở Cửa</h4>
                                <p class="spicy-info-text">
                                    Thứ 2 - Thứ 6: 9:00 - 22:00<br>
                                    Thứ 7 & CN: 9:00 - 23:00
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
