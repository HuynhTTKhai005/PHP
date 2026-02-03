@extends('layouts.pato')


@section('title', 'Sincay - Nhà hàng cao cấp')

@section('content')
    <!-- Hero Slider (Bootstrap 5 Carousel) -->
    <section class="hero-slider position-relative">
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
            <!-- Indicators (dấu chấm dưới) -->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true"
                    aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>

            <!-- Slides -->
            <div class="carousel-inner">
                <!-- Slide 1 -->
                <div class="carousel-item active"
                    style="background-image: url('{{ asset('assets/images/slide1-01.jpg') }}'); min-height: 80vh; background-size: cover; background-position: center;">
                    <div
                        class="carousel-caption d-flex flex-column justify-content-center align-items-center h-100 text-center text-white">
                        <span class="hero-subtitle h3 mb-3 animate__animated animate__fadeInDown">Chào mừng đến với</span>
                        <h2 class="hero-title display-3 fw-bold mb-4 animate__animated animate__fadeInUp">Sincay Place</h2>
                        <a href="{{ url('menu') }}"
                            class="btn btn-primary btn-lg px-5 py-3 animate__animated animate__zoomIn">Xem Menu</a>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="carousel-item"
                    style="background-image: url('{{ asset('assets/images/master-slides-02.jpg') }}'); min-height: 80vh; background-size: cover; background-position: center;">
                    <div
                        class="carousel-caption d-flex flex-column justify-content-center align-items-center h-100 text-center text-white">
                        <span class="hero-subtitle h3 mb-3 animate__animated animate__rollIn">Chào mừng đến với</span>
                        <h2 class="hero-title display-3 fw-bold mb-4 animate__animated animate__lightSpeedIn">Sincay Place
                        </h2>
                        <a href="{{ url('menu') }}"
                            class="btn btn-primary btn-lg px-5 py-3 animate__animated animate__slideInUp">Xem Menu</a>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div class="carousel-item"
                    style="background-image: url('{{ asset('assets/images/master-slides-01.jpg') }}'); min-height: 80vh; background-size: cover; background-position: center;">
                    <div
                        class="carousel-caption d-flex flex-column justify-content-center align-items-center h-100 text-center text-white">
                        <span class="hero-subtitle h3 mb-3 animate__animated animate__rotateInDownLeft">Chào mừng đến
                            với</span>
                        <h2 class="hero-title display-3 fw-bold mb-4 animate__animated animate__rotateInUpRight">Sincay
                            Place</h2>
                        <a href="{{ url('menu') }}"
                            class="btn bg- btn-lg px-5 py-3 animate__animated animate__rotateIn">Xem Menu</a>
                    </div>
                </div>
            </div>

            <!-- Controls (nút prev/next) -->
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    <!-- Welcome -->
    <section class="welcome-section">
        <div class="container">
            <div class="content row align-items-center">
                <div class="col-lg-6 order-lg-1 order-2 py-4">
                    <div class="wrap-text-welcome text-center text-lg-start">
                        <span class="d-block fs-1 fw-bold text-uppercase mb-2">
                            Nhà Hàng Ý
                        </span>

                        <h3 class="display-4 fw-bold mb-4">
                            Chào Mừng
                        </h3>

                        <p class="lead mb-4">
                            Chào mừng bạn đến với nhà hàng của chúng tôi. Chúng tôi mang đến những món ăn ngon và trải
                            nghiệm tuyệt vời.
                        </p>

                        <a href="{{ route('about') }}" class="btn btn-outline-dark btn-lg">
                            Câu Chuyện Của Chúng Tôi
                            <i class="fas fa-long-arrow-alt-right ms-2"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-6 order-lg-2 order-1 py-4">
                    <div class="wrap-pic-welcome overflow-hidden rounded-3">
                        <img src="assets/images/our-story-01.jpg" alt="IMG-OUR" class="img-fluid   object-fit-cover">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Intro -->
    <section class="section-intro">
        <div class="header-intro parallax100 text-center py-5"
            style="background-image: url(assets/images/bg-intro-01.jpg);">
            <span class="tit2 px-3">
                Khám phá
            </span>

            <h3 class="tit4 text-center px-3 pt-1">
                Sincay Place
            </h3>
        </div>

        <div class="content-intro bg-white py-5">
            <div class="container">
                <div class="row g-4">
                    <div class="col-md-4">
                        <!-- Block1 -->
                        <div class="blo1">
                            <div class="wrap-pic-blo1 bo-rad-10 overflow-hidden">
                                <a href="#"><img src="assets/images/intro-01.jpg" alt="IMG-INTRO"
                                        class="img-fluid w-100"></a>
                            </div>

                            <div class="wrap-text-blo1 pt-4">
                                <a href="#" class="text-decoration-none">
                                    <h4 class="txt5 color0-hov m-b-13">
                                        Nhà Hàng Lãng Mạn
                                    </h4>
                                </a>

                                <p class="mb-3">
                                    Phasellus lorem enim, luctus ut velit eget, con-vallis egestas eros.
                                </p>

                                {{-- <a href="#" class="txt4 text-decoration-none">
                                Tìm Hiểu Thêm
                                <i class="fas fa-long-arrow-alt-right ms-2"></i>
                            </a> --}}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- Block1 -->
                        <div class="blo1">
                            <div class="wrap-pic-blo1 bo-rad-10 overflow-hidden">
                                <a href="#"><img src="assets/images/intro-02.jpg" alt="IMG-INTRO"
                                        class="img-fluid w-100"></a>
                            </div>

                            <div class="wrap-text-blo1 pt-4">
                                <a href="#" class="text-decoration-none">
                                    <h4 class="txt5 color0-hov m-b-13">
                                        Món ăn ngon miệng
                                    </h4>
                                </a>

                                <p class="mb-3">
                                    Aliquam eget aliquam magna, quis posuere risus ac justo ipsum nibh urna
                                </p>

                                {{-- <a href="#" class="txt4 text-decoration-none">
                                Tìm hiểu thêm
                                <i class="fas fa-long-arrow-alt-right ms-2"></i>
                            </a> --}}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- Block1 -->
                        <div class="blo1">
                            <div class="wrap-pic-blo1 bo-rad-10 overflow-hidden">
                                <a href="#"><img src="assets/images/intro-04.jpg" alt="IMG-INTRO"
                                        class="img-fluid w-100"></a>
                            </div>

                            <div class="wrap-text-blo1 pt-4">
                                <a href="#" class="text-decoration-none">
                                    <h4 class="txt5 color0-hov m-b-13">
                                        Những gì Bạn Yêu Thích
                                    </h4>
                                </a>

                                <p class="mb-3">
                                    Sed ornare ligula eget tortor tempor, quis porta tellus dictum.
                                </p>

                                {{-- <a href="#" class="txt4 text-decoration-none">
                                Tìm Hiểu Thêm
                                <i class="fas fa-long-arrow-alt-right ms-2"></i>
                            </a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our menu -->
    {{-- <section class="section-ourmenu bg2-pattern py-5">
    <div class="container">
        <div class="title-section-ourmenu text-center mb-4">
            <span class="tit2 text-center">
                Khám phá
            </span>

            <h3 class="tit5 text-center mt-1">
                Menu của chúng tôi
            </h3>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="row g-4">
                    <div class="col-md-6">
                        <!-- Item our menu -->
                        <div class="item-ourmenu bo-rad-10 position-relative">
                            <img src="assets/images/our-menu-01.jpg" alt="IMG-MENU" class="img-fluid w-100">

                            <!-- Button2 -->
                            <a href="#" class="btn2 d-flex justify-content-center align-items-center txt5">
                                Bữa Trưa
                            </a>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- Item our menu -->
                        <div class="item-ourmenu bo-rad-10 position-relative">
                            <img src="assets/images/our-menu-05.jpg" alt="IMG-MENU" class="img-fluid w-100">

                            <!-- Button2 -->
                            <a href="#" class="btn2 d-flex justify-content-center align-items-center txt5">
                                Bữa tối
                            </a>
                        </div>
                    </div>

                    <div class="col-12">
                        <!-- Item our menu -->
                        <div class="item-ourmenu bo-rad-10 position-relative">
                            <img src="assets/images/our-menu-13.jpg" alt="IMG-MENU" class="img-fluid w-100">

                            <!-- Button2 -->
                            <a href="#" class="btn2 d-flex justify-content-center align-items-center txt5">
                                Giờ Vui Vẻ
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="row g-4">
                    <div class="col-12">
                        <!-- Item our menu -->
                        <div class="item-ourmenu bo-rad-10 position-relative">
                            <img src="assets/images/our-menu-08.jpg" alt="IMG-MENU" class="img-fluid w-100">

                            <!-- Button2 -->
                            <a href="#" class="btn2 d-flex justify-content-center align-items-center txt5">
                                Đồ Uống
                            </a>
                        </div>
                    </div>

                    <div class="col-12">
                        <!-- Item our menu -->
                        <div class="item-ourmenu bo-rad-10 position-relative">
                            <img src="assets/images/our-menu-10.jpg" alt="IMG-MENU" class="img-fluid w-100">

                            <!-- Button2 -->
                            <a href="#" class="btn2 d-flex justify-content-center align-items-center txt5">
                                Khai Vị
                            </a>
                        </div>
                    </div>

                     
                </div>
            </div>
        </div>
    </div>
</section> --}}


    <!-- Booking -->
    <section class="section-booking bg1-pattern py-5">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <div class="text-center mb-4">
                        <span class="tit2 text-center">
                            Đặt Bàn
                        </span>
                        <h3 class="tit3 text-center mb-3">
                            Đặt Bàn
                        </h3>
                    </div>

                    <form class="booking-form">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <!-- Date -->
                                <div class="mb-3">
                                    <label class="txt9 mb-2">Ngày</label>
                                    <input type="date" class="form-control bo-rad-10 p-3" name="date">
                                </div>

                                <!-- Time -->
                                <div class="mb-3">
                                    <label class="txt9 mb-2">Giờ</label>
                                    <select class="form-select bo-rad-10 p-3" name="time">
                                        <option>9:00</option>
                                        <option>9:30</option>
                                        <option>10:00</option>
                                        <option>10:30</option>
                                        <!-- Thêm các option khác -->
                                    </select>
                                </div>

                                <!-- People -->
                                <div class="mb-3">
                                    <label class="txt9 mb-2">Số Người</label>
                                    <select class="form-select bo-rad-10 p-3" name="people">
                                        <option>1 người</option>
                                        <option>2 người</option>
                                        <option>3 người</option>
                                        <!-- Thêm các option khác -->
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Name -->
                                <div class="mb-3">
                                    <label class="txt9 mb-2">Tên</label>
                                    <input type="text" class="form-control bo-rad-10 p-3" name="name"
                                        placeholder="Tên">
                                </div>

                                <!-- Phone -->
                                <div class="mb-3">
                                    <label class="txt9 mb-2">Điện Thoại</label>
                                    <input type="tel" class="form-control bo-rad-10 p-3" name="phone"
                                        placeholder="Số điện thoại">
                                </div>

                                <!-- Email -->
                                <div class="mb-3">
                                    <label class="txt9 mb-2">Email</label>
                                    <input type="email" class="form-control bo-rad-10 p-3" name="email"
                                        placeholder="Email">
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn3 btn-lg">
                                Đặt Bàn
                            </button>
                        </div>
                    </form>
                </div>

                <div class="col-lg-6">
                    <div class="wrap-pic-booking bo-rad-10 overflow-hidden">
                        <img src="assets/images/booking-01.jpg" alt="IMG-OUR" class="img-fluid w-100">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Review - Carousel Bootstrap 5 -->
    <section class="section-review py-5">
        <div class="container">
            <div class="title-review text-center mb-5">
                <span class="tit2 px-3">
                    Khách Hàng Nói
                </span>
                <h3 class="tit8 text-center px-3 pt-1">
                    Đánh Giá
                </h3>
            </div>

            <div id="reviewCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <!-- Review 1 -->
                    <div class="carousel-item active">
                        <div class="text-center">
                            <div class="pic-review mb-4 mx-auto">
                                <img src="assets/images/avatar-01.jpg" alt="IGM-AVATAR" class="rounded-circle">
                            </div>
                            <div class="content-review">
                                <p class="txt12 mb-4">
                                    "We are lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean tellus sem,
                                    mattis in pre-tium nec, fermentum viverra dui"
                                </p>
                                <div class="star-review mb-3">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <div class="more-review txt4">
                                    Marie Simmons - New York
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Thêm các review khác -->
                </div>

                <!-- Carousel Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#reviewCarousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#reviewCarousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>

    <!-- Video Modal -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.youtube.com/embed/YOUR_VIDEO_ID" title="Video" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Video -->
    {{-- <section class="section-video parallax100" style="background-image: url(assets/images/bg-cover-video-02.jpg);">
    <div class="content-video text-center py-5">
        <span class="tit2 px-3">
            Discover
        </span>
        <h3 class="tit4 text-center px-3 pt-1">
            Our Video
        </h3>
        <button class="btn-play mx-auto mt-4" data-bs-toggle="modal" data-bs-target="#videoModal">
            <div class="circle-btn">
                <i class="fas fa-play"></i>
            </div>
        </button>
    </div>
</section> --}}

    <!-- Blog -->
    {{-- <section class="section-blog bg-white py-5">
    <div class="container">
        <div class="title-section-ourmenu text-center mb-5">
            <span class="tit2 text-center">
                Tin Tức Mới Nhất
            </span>
            <h3 class="tit5 text-center mt-1">
                Blog
            </h3>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <!-- Block1 -->
                <div class="blo1">
                    <div class="wrap-pic-blo1 bo-rad-10 overflow-hidden position-relative">
                        <a href="blog-detail.html">
                            <img src="assets/images/blog-01.jpg" alt="IMG-INTRO" class="img-fluid w-100">
                        </a>
                        <div class="time-blog">
                            21 Dec 2017
                        </div>
                    </div>

                    <div class="wrap-text-blo1 pt-4">
                        <a href="blog-detail.html" class="text-decoration-none">
                            <h4 class="txt5 color0-hov mb-3">
                                Best Places for Wine
                            </h4>
                        </a>
                        <p class="mb-3">
                            Phasellus lorem enim, luctus ut velit eget, con-vallis egestas eros.
                        </p>
                        <a href="blog-detail.html" class="txt4 text-decoration-none">
                            Đọc Tiếp
                            <i class="fas fa-long-arrow-alt-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Block1 -->
                <div class="blo1">
                    <div class="wrap-pic-blo1 bo-rad-10 overflow-hidden position-relative">
                        <a href="blog-detail.html">
                            <img src="assets/images/blog-02.jpg" alt="IMG-INTRO" class="img-fluid w-100">
                        </a>
                        <div class="time-blog">
                            15 Dec 2017
                        </div>
                    </div>

                    <div class="wrap-text-blo1 pt-4">
                        <a href="blog-detail.html" class="text-decoration-none">
                            <h4 class="txt5 color0-hov mb-3">
                                Eggs and Cheese
                            </h4>
                        </a>
                        <p class="mb-3">
                            Duis elementum, risus sit amet lobortis nunc justo condimentum ligula, vitae feugiat
                        </p>
                        <a href="blog-detail.html" class="txt4 text-decoration-none">
                            Continue Reading
                            <i class="fas fa-long-arrow-alt-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Block1 -->
                <div class="blo1">
                    <div class="wrap-pic-blo1 bo-rad-10 overflow-hidden position-relative">
                        <a href="blog-detail.html">
                            <img src="assets/images/blog-03.jpg" alt="IMG-INTRO" class="img-fluid w-100">
                        </a>
                        <div class="time-blog">
                            12 Dec 2017
                        </div>
                    </div>

                    <div class="wrap-text-blo1 pt-4">
                        <a href="blog-detail.html" class="text-decoration-none">
                            <h4 class="txt5 color0-hov mb-3">
                                Style the Wedding Party
                            </h4>
                        </a>
                        <p class="mb-3">
                            Sed ornare ligula eget tortor tempor, quis porta tellus dictum.
                        </p>
                        <a href="blog-detail.html" class="txt4 text-decoration-none">
                            Đọc Tiếp
                            <i class="fas fa-long-arrow-alt-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> --}}





@endsection
