@extends('layouts.sincay')


@section('title', 'Sincay - Nhà hàng cao cấp')

@section('content')
    <!-- Hero Slider (Bootstrap 5 Carousel) -->
    <section class="hero-slider position-relative top-0">
        <div id="heroCarousel" class="carousel carousel-fade" data-bs-ride="carousel">
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
                    style="background-image: url('{{ asset('assets/images/slide_1.jpg') }}'); min-height: 80vh; background-size: cover; background-position: center;">
                    <div
                        class="carousel-caption d-flex flex-column justify-content-center align-items-center h-100 text-center text-white">
                        <span class="hero-subtitle h3 mb-5 animate__animated animate__fadeInDown">Chào mừng đến với</span>
                        <h2 class="hero-title display-3 fw-bold mb-4 animate__animated animate__fadeInUp">Sincay Place</h2>
                        <a href="{{ url('menu') }}"
                            class="btn btn-danger btn-lg px-5 py-3 animate__animated animate__zoomIn">Xem Menu</a>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="carousel-item"
                    style="background-image: url('{{ asset('assets/images/slide_2.png') }}'); min-height: 80vh; background-size: cover; background-position: center;">
                    <div
                        class="carousel-caption d-flex flex-column justify-content-center align-items-center h-100 text-center text-white">
                        <span class="hero-subtitle h3 mb-3 animate__animated animate__rollIn">Chào mừng đến với</span>
                        <h2 class="hero-title display-3 fw-bold mb-4 animate__animated animate__lightSpeedIn">Sincay Place
                        </h2>
                        <a href="{{ url('menu') }}"
                            class="btn btn-danger btn-lg px-5 py-3 animate__animated animate__slideInUp">Xem Menu</a>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div class="carousel-item"
                    style="background-image: url('{{ asset('assets/images/slide_3.png') }}'); min-height: 80vh; background-size: cover; background-position: center;">
                    <div
                        class="carousel-caption d-flex flex-column justify-content-center align-items-center h-100 text-center text-white">
                        <span class="hero-subtitle h3 mb-3 animate__animated animate__rotateInDownLeft">Chào mừng đến
                            với</span>
                        <h2 class="hero-title display-3 fw-bold mb-4 animate__animated animate__rotateInUpRight">Sincay
                            Place</h2>
                        <a href="{{ url('menu') }}"
                            class="btn btn-danger bg-btn-lg px-5 py-3 animate__animated animate__rotateIn">Xem Menu</a>
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
                            Nhà Hàng Sincay
                        </span>

                        <h3 class="display-4 fw-bold mb-4">
                            Mì Cay Hàn Quốc
                        </h3>

                        <p class="lead mb-4">
                            Chào mừng bạn đến với nhà hàng của chúng tôi. Chúng tôi mang đến những món ăn ngon và trải
                            nghiệm tuyệt vời.
                        </p>

                        <a href="{{ route('about') }}" class="btn btn-outline-danger btn-lg">
                            Câu Chuyện Của Chúng Tôi
                            <i class="fas fa-long-arrow-alt-right ms-2"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-6 order-lg-2 order-1 py-4">
                    <div class="wrap-pic-welcome overflow-hidden  ">
                        <img src="assets/images/story_1.jpg" alt="IMG-OUR" class="img-fluid rounded-3  object-fit-cover">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Intro -->
    <section class="section-intro">
        <div class="header-intro parallax100 text-center py-5" style="background-image: url(assets/images/bgintro.png);">
            <span class="tit2 px-3">
                 Sincay Place
            </span>

            <h3 class="tit4 text-center px-3 pt-1">
                Khám phá
            </h3>
        </div>

        <div class="content-intro bg-white py-5">
            <div class="container">
                <div class="row g-4">
                    <div class="col-md-4">
                        <!-- Block1 -->
                        <div class="blo1">
                            <div class="wrap-pic-blo1 bo-rad-10 overflow-hidden">
                                <a href="#"><img src="assets/images/intro_1.png" alt="IMG-INTRO"
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


                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- Block1 -->
                        <div class="blo1">
                            <div class="wrap-pic-blo1 bo-rad-10 overflow-hidden">
                                <a href="#"><img src="assets/images/intro_3.jpg" alt="IMG-INTRO"
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


                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- Block1 -->
                        <div class="blo1">
                            <div class="wrap-pic-blo1 bo-rad-10 overflow-hidden">
                                <a href="#"><img src="assets/images/intro_3.png" alt="IMG-INTRO"
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

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- Booking -->
    <section id="booking" class="section-booking  py-5">
        <div class="header-intro parallax100 text-center py-5" style="background-image: url(assets/images/bgintro.png);">
            <span class="tit2 px-3">
                Sincay
            </span>

            <h3 class="tit4 text-center px-3 pt-1">
                Đặt Bàn 
            </h3>
        </div>
        <div class="container">

            <div class="row g-5 align-items-center">
                <div class="col-lg-6">


                    <form class="booking-form" action="{{ route('reservation.store') }}" method="POST">
                        @csrf

                        {{-- @if (session('success'))
                            <div class="alert alert-success mb-4">
                                {{ session('success') }}
                            </div>
                        @endif --}}

                        @if ($errors->any())
                            <div class="alert alert-danger mb-4">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row g-4">
                            <div class="col-md-6">
                                <!-- Date -->
                                <div class="mb-3">
                                    <label class="txt9 mb-2">Ngày</label>
                                    <input type="date" class="form-control bo-rad-10 p-3" name="date"
                                        value="{{ old('date') }}">
                                </div>

                                <!-- Time -->
                                <div class="mb-3">
                                    <label class="txt9 mb-2">Giờ</label>
                                    <select class="form-select bo-rad-10 p-3" name="time">
                                        <option value="">Chọn giờ</option>
                                        <option value="09:00" {{ old('time') === '09:00' ? 'selected' : '' }}>09:00
                                        </option>
                                        <option value="09:30" {{ old('time') === '09:30' ? 'selected' : '' }}>09:30
                                        </option>
                                        <option value="10:00" {{ old('time') === '10:00' ? 'selected' : '' }}>10:00
                                        </option>
                                        <option value="10:30" {{ old('time') === '10:30' ? 'selected' : '' }}>10:30
                                        </option>
                                        <option value="11:00" {{ old('time') === '11:00' ? 'selected' : '' }}>11:00
                                        </option>
                                        <option value="11:30" {{ old('time') === '11:30' ? 'selected' : '' }}>11:30
                                        </option>
                                        <option value="12:00" {{ old('time') === '12:00' ? 'selected' : '' }}>12:00
                                        </option>
                                        <option value="12:30" {{ old('time') === '12:30' ? 'selected' : '' }}>12:30
                                        </option>
                                        <option value="13:00" {{ old('time') === '13:00' ? 'selected' : '' }}>13:00
                                        </option>
                                        <option value="13:30" {{ old('time') === '13:30' ? 'selected' : '' }}>13:30
                                        </option>
                                        <option value="14:00" {{ old('time') === '14:00' ? 'selected' : '' }}>14:00
                                        </option>
                                        <option value="14:30" {{ old('time') === '14:30' ? 'selected' : '' }}>14:30
                                        </option>
                                        <option value="15:00" {{ old('time') === '15:00' ? 'selected' : '' }}>15:00
                                        </option>
                                        <option value="15:30" {{ old('time') === '15:30' ? 'selected' : '' }}>15:30
                                        </option>
                                        <option value="16:00" {{ old('time') === '16:00' ? 'selected' : '' }}>16:00
                                        </option>
                                        <option value="16:30" {{ old('time') === '16:30' ? 'selected' : '' }}>16:30
                                        </option>
                                        <option value="17:00" {{ old('time') === '17:00' ? 'selected' : '' }}>17:00
                                        </option>
                                        <option value="17:30" {{ old('time') === '17:30' ? 'selected' : '' }}>17:30
                                        </option>
                                        <option value="18:00" {{ old('time') === '18:00' ? 'selected' : '' }}>18:00
                                        </option>
                                        <option value="18:30" {{ old('time') === '18:30' ? 'selected' : '' }}>18:30
                                        </option>
                                        <option value="19:00" {{ old('time') === '19:00' ? 'selected' : '' }}>19:00
                                        </option>
                                        <option value="19:30" {{ old('time') === '19:30' ? 'selected' : '' }}>19:30
                                        </option>
                                        <option value="20:00" {{ old('time') === '20:00' ? 'selected' : '' }}>20:00
                                        </option>
                                    </select>
                                </div>

                                <!-- People -->
                                <div class="mb-3">
                                    <label class="txt9 mb-2">Số Người</label>
                                    <select class="form-select bo-rad-10 p-3" name="people">
                                        <option value="">Chọn số người</option>
                                        @for ($i = 1; $i <= 20; $i++)
                                            <option value="{{ $i }}"
                                                {{ (string) old('people') === (string) $i ? 'selected' : '' }}>
                                                {{ $i }} người
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Name -->
                                <div class="mb-3">
                                    <label class="txt9 mb-2">Tên</label>
                                    <input type="text" class="form-control bo-rad-10 p-3" name="name"
                                        placeholder="Tên" value="{{ old('name') }}">
                                </div>

                                <!-- Phone -->
                                <div class="mb-3">
                                    <label class="txt9 mb-2">Điện Thoại</label>
                                    <input type="tel" class="form-control bo-rad-10 p-3" name="phone"
                                        placeholder="Số điện thoại" value="{{ old('phone') }}">
                                </div>

                                <!-- Email -->
                                <div class="mb-3">
                                    <label class="txt9 mb-2">Email</label>
                                    <input type="email" class="form-control bo-rad-10 p-3" name="email"
                                        placeholder="Email" value="{{ old('email') }}">
                                </div>

                                <div class="mb-3">
                                    <label class="txt9 mb-2">Ghi chú</label>
                                    <textarea class="form-control bo-rad-10 p-3" name="note" rows="3" placeholder="Yêu cầu thêm (nếu có)">{{ old('note') }}</textarea>
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
                        <img src="assets/images/table.jpg" alt="IMG-OUR" class="img-fluid w-100">
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- Video Modal -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.youtube.com/embed/onE9lph5pzo?si=K2XqwLdVavFT-PxU" title="Video"
                            allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Video -->
    <section class="section-video d-flex align-items-center justify-content-center"
        style="background-image: url(assets/images/bgintro.png);">
        <div class="content-video text-center w-100 h-100">
            <span class="tit2 px-3">
                Bật mí
            </span>
            <h3 class="tit4 text-center px-3 pt-1">
                Video Nhà Hàng
            </h3>
            <button class="btn-play mx-auto mt-4" data-bs-toggle="modal" data-bs-target="#videoModal">
                <div class="circle-btn">
                    <i class="fas fa-play"></i>
                </div>
            </button>
        </div>
    </section>

@endsection

