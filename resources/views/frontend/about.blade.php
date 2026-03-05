@extends('layouts.pato')

@section('content')
    <!-- Header -->
    <section class="titles text-center text-white"
        style="background: url({{ asset('assets/images/bgintro.png') }}) center/cover no-repeat; min-height: 400px;">
        <div class="container">
            <h2 class="tit">Câu chuyện Sincay</h2>
        </div>
    </section>

    <!-- Our Story Section -->
    <section class="noodle-about-section noodle-about-bg-pattern">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <p class="noodle-about-section-text">
                        Chúng tôi bắt đầu hành trình của mình với niềm đam mê ẩm thực Hàn Quốc đích thực. Từ những ngày đầu
                        tiên, chúng tôi đã cam kết mang đến những món mỳ cay tươi ngon, nguyên liệu chất lượng cao và trải
                        nghiệm ẩm thực tuyệt vời. Nhà hàng
                        của chúng tôi không chỉ là nơi thưởng thức ẩm thực mà còn là nơi kể chuyện về truyền thống ẩm thực
                        Hàn Quốc, nơi
                        mọi khách hàng đều cảm nhận được sự ấm áp và chân thành.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Video Section -->
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
                Khám phá nhà hàng
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


    <!-- Features Section -->
    <section class="noodle-about-section noodle-about-bg-light">
        <div class="container">
            <!-- Feature 1 -->
            <div class="row align-items-center mb-5">
                <div class="col-lg-6">
                    <div class="noodle-about-feature-text">
                        <span class="noodle-about-subtitle">Ngon Miệng</span>
                        <h3 class="noodle-about-feature-title">CÔNG THỨC ĐẶC BIỆT</h3>
                        <p class="noodle-about-feature-description">
                            Các công thức mỳ cay của chúng tôi được chế biến từ những nguyên liệu tươi ngon nhất nhập khẩu
                            từ Hàn Quốc. Chúng tôi
                            luôn chú trọng đến sự sáng tạo và hương vị tinh tế, mang đến những món ăn không chỉ ngon
                            miệng mà còn đầy dinh dưỡng với nhiều cấp độ cay phù hợp cho mọi thực khách.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="noodle-about-feature-image">
                        <img src="assets/images/intro_3.jpg" alt="Công thức nấu ăn">
                    </div>
                </div>
            </div>

            <!-- Feature 2 -->
            <div class="row align-items-center flex-lg-row-reverse mt-5">
                <div class="col-lg-6">
                    <div class="noodle-about-feature-text">
                        <span class="noodle-about-subtitle">Trải Nghiệm</span>
                        <h3 class="noodle-about-feature-title">KHÔNG GIAN ĐẶC BIỆT</h3>
                        <p class="noodle-about-feature-description">
                            Nhà hàng của chúng tôi là nơi lý tưởng cho những buổi hẹn hò, gặp gỡ bạn bè và gia đình. Với
                            không gian ấm
                            cúng, thiết kế theo phong cách Hàn Quốc hiện đại và âm nhạc du dương, chúng tôi tạo nên bầu
                            không khí thoải mái để bạn tận
                            hưởng những khoảnh khắc đặc biệt bên người thương.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="noodle-about-feature-image">
                        <img src="assets/images/intro_1.png" alt="Không gian nhà hàng">
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Chef Section -->
    <section class="noodle-about-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <span class="noodle-about-subtitle">Gặp Gỡ</span>
                    <h2 class="noodle-about-section-title">ĐẦU BẾP CỦA CHÚNG TÔI</h2>
                </div>
            </div>

            <div class="row mt-4">
                <!-- Chef 1 -->
                <div class="col-lg-4 col-md-6">
                    <div class="noodle-about-chef-card">
                        <div class="noodle-about-chef-image">
                            <img src="https://images.unsplash.com/photo-1581299894007-aaa50297cf16?ixlib=rb-4.0.3&auto=format&fit=crop&w=687&q=80"
                                alt="Đầu bếp Lee Min Ho">
                        </div>
                        <div class="noodle-about-chef-info">
                            <a href="#" class="noodle-about-chef-name">Lee Min Ho</a>
                            <span class="noodle-about-chef-role">Bếp Trưởng</span>
                            <p class="noodle-about-chef-description">
                                Lee là một đầu bếp tài ba với hơn 15 năm kinh nghiệm trong lĩnh vực ẩm thực Hàn Quốc. Anh ấy
                                chuyên về các món mỳ cay và lẩu Hàn Quốc, luôn sáng tạo để mang đến những hương vị mới lạ và
                                tinh tế.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Chef 2 -->
                <div class="col-lg-4 col-md-6">
                    <div class="noodle-about-chef-card">
                        <div class="noodle-about-chef-image">
                            <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=687&q=80"
                                alt="Đầu bếp Park Ji Eun">
                        </div>
                        <div class="noodle-about-chef-info">
                            <a href="#" class="noodle-about-chef-name">Park Ji Eun</a>
                            <span class="noodle-about-chef-role">Đầu Bếp Chuyên Món Cay</span>
                            <p class="noodle-about-chef-description">
                                Park là một chuyên gia về các món cay Hàn Quốc với 12 năm kinh nghiệm. Cô ấy đam mê tạo ra
                                những
                                công thức nước dùng độc đáo, cân bằng giữa vị cay và hương vị đậm đà truyền thống.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Chef 3 -->
                <div class="col-lg-4 col-md-6">
                    <div class="noodle-about-chef-card">
                        <div class="noodle-about-chef-image">
                            <img src="https://images.unsplash.com/photo-1595475038784-bbe439ff41e6?ixlib=rb-4.0.3&auto=format&fit=crop&w=687&q=80"
                                alt="Đầu bếp Kim Soo Hyun">
                        </div>
                        <div class="noodle-about-chef-info">
                            <a href="#" class="noodle-about-chef-name">Kim Soo Hyun</a>
                            <span class="noodle-about-chef-role">Đầu Bếp Sáng Tạo</span>
                            <p class="noodle-about-chef-description">
                                Kim là một đầu bếp sáng tạo với khả năng kết hợp các hương vị truyền thống và hiện đại.
                                Anh ấy luôn tìm kiếm những cách mới để nâng cao chất lượng món ăn và mang đến sự hài lòng
                                tối đa cho khách hàng.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
