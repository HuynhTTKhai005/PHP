@extends('layouts.sincay')

@section('content')
    <!-- Header -->
    <section class="titles text-center text-white"
        style="background: url({{ asset('assets/images/bgintro.png') }}) center/cover no-repeat; min-height: 400px;">
        <div class="container">
            <h2 class="tit">CÃ¢u chuyá»‡n Sincay</h2>
        </div>
    </section>

    <!-- Our Story Section -->
    <section class="noodle-about-section noodle-about-bg-pattern">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <p class="noodle-about-section-text">
                        ChÃºng tÃ´i báº¯t Ä‘áº§u hÃ nh trÃ¬nh cá»§a mÃ¬nh vá»›i niá»m Ä‘am mÃª áº©m thá»±c HÃ n Quá»‘c Ä‘Ã­ch thá»±c. Tá»« nhá»¯ng ngÃ y Ä‘áº§u
                        tiÃªn, chÃºng tÃ´i Ä‘Ã£ cam káº¿t mang Ä‘áº¿n nhá»¯ng mÃ³n má»³ cay tÆ°Æ¡i ngon, nguyÃªn liá»‡u cháº¥t lÆ°á»£ng cao vÃ  tráº£i
                        nghiá»‡m áº©m thá»±c tuyá»‡t vá»i. NhÃ  hÃ ng
                        cá»§a chÃºng tÃ´i khÃ´ng chá»‰ lÃ  nÆ¡i thÆ°á»Ÿng thá»©c áº©m thá»±c mÃ  cÃ²n lÃ  nÆ¡i ká»ƒ chuyá»‡n vá» truyá»n thá»‘ng áº©m thá»±c
                        HÃ n Quá»‘c, nÆ¡i
                        má»i khÃ¡ch hÃ ng Ä‘á»u cáº£m nháº­n Ä‘Æ°á»£c sá»± áº¥m Ã¡p vÃ  chÃ¢n thÃ nh.
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
                KhÃ¡m phÃ¡ nhÃ  hÃ ng
            </span>
            <h3 class="tit4 text-center px-3 pt-1">
                Video NhÃ  HÃ ng
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
                        <span class="noodle-about-subtitle">Ngon Miá»‡ng</span>
                        <h3 class="noodle-about-feature-title">CÃ”NG THá»¨C Äáº¶C BIá»†T</h3>
                        <p class="noodle-about-feature-description">
                            CÃ¡c cÃ´ng thá»©c má»³ cay cá»§a chÃºng tÃ´i Ä‘Æ°á»£c cháº¿ biáº¿n tá»« nhá»¯ng nguyÃªn liá»‡u tÆ°Æ¡i ngon nháº¥t nháº­p kháº©u
                            tá»« HÃ n Quá»‘c. ChÃºng tÃ´i
                            luÃ´n chÃº trá»ng Ä‘áº¿n sá»± sÃ¡ng táº¡o vÃ  hÆ°Æ¡ng vá»‹ tinh táº¿, mang Ä‘áº¿n nhá»¯ng mÃ³n Äƒn khÃ´ng chá»‰ ngon
                            miá»‡ng mÃ  cÃ²n Ä‘áº§y dinh dÆ°á»¡ng vá»›i nhiá»u cáº¥p Ä‘á»™ cay phÃ¹ há»£p cho má»i thá»±c khÃ¡ch.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="noodle-about-feature-image">
                        <img src="assets/images/intro_3.jpg" alt="CÃ´ng thá»©c náº¥u Äƒn">
                    </div>
                </div>
            </div>

            <!-- Feature 2 -->
            <div class="row align-items-center flex-lg-row-reverse mt-5">
                <div class="col-lg-6">
                    <div class="noodle-about-feature-text">
                        <span class="noodle-about-subtitle">Tráº£i Nghiá»‡m</span>
                        <h3 class="noodle-about-feature-title">KHÃ”NG GIAN Äáº¶C BIá»†T</h3>
                        <p class="noodle-about-feature-description">
                            NhÃ  hÃ ng cá»§a chÃºng tÃ´i lÃ  nÆ¡i lÃ½ tÆ°á»Ÿng cho nhá»¯ng buá»•i háº¹n hÃ², gáº·p gá»¡ báº¡n bÃ¨ vÃ  gia Ä‘Ã¬nh. Vá»›i
                            khÃ´ng gian áº¥m
                            cÃºng, thiáº¿t káº¿ theo phong cÃ¡ch HÃ n Quá»‘c hiá»‡n Ä‘áº¡i vÃ  Ã¢m nháº¡c du dÆ°Æ¡ng, chÃºng tÃ´i táº¡o nÃªn báº§u
                            khÃ´ng khÃ­ thoáº£i mÃ¡i Ä‘á»ƒ báº¡n táº­n
                            hÆ°á»Ÿng nhá»¯ng khoáº£nh kháº¯c Ä‘áº·c biá»‡t bÃªn ngÆ°á»i thÆ°Æ¡ng.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="noodle-about-feature-image">
                        <img src="assets/images/intro_1.png" alt="KhÃ´ng gian nhÃ  hÃ ng">
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
                    <span class="noodle-about-subtitle">Gáº·p Gá»¡</span>
                    <h2 class="noodle-about-section-title">Äáº¦U Báº¾P Cá»¦A CHÃšNG TÃ”I</h2>
                </div>
            </div>

            <div class="row mt-4">
                <!-- Chef 1 -->
                <div class="col-lg-4 col-md-6">
                    <div class="noodle-about-chef-card">
                        <div class="noodle-about-chef-image">
                            <img src="https://images.unsplash.com/photo-1581299894007-aaa50297cf16?ixlib=rb-4.0.3&auto=format&fit=crop&w=687&q=80"
                                alt="Äáº§u báº¿p Lee Min Ho">
                        </div>
                        <div class="noodle-about-chef-info">
                            <a href="#" class="noodle-about-chef-name">Lee Min Ho</a>
                            <span class="noodle-about-chef-role">Báº¿p TrÆ°á»Ÿng</span>
                            <p class="noodle-about-chef-description">
                                Lee lÃ  má»™t Ä‘áº§u báº¿p tÃ i ba vá»›i hÆ¡n 15 nÄƒm kinh nghiá»‡m trong lÄ©nh vá»±c áº©m thá»±c HÃ n Quá»‘c. Anh áº¥y
                                chuyÃªn vá» cÃ¡c mÃ³n má»³ cay vÃ  láº©u HÃ n Quá»‘c, luÃ´n sÃ¡ng táº¡o Ä‘á»ƒ mang Ä‘áº¿n nhá»¯ng hÆ°Æ¡ng vá»‹ má»›i láº¡ vÃ 
                                tinh táº¿.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Chef 2 -->
                <div class="col-lg-4 col-md-6">
                    <div class="noodle-about-chef-card">
                        <div class="noodle-about-chef-image">
                            <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=687&q=80"
                                alt="Äáº§u báº¿p Park Ji Eun">
                        </div>
                        <div class="noodle-about-chef-info">
                            <a href="#" class="noodle-about-chef-name">Park Ji Eun</a>
                            <span class="noodle-about-chef-role">Äáº§u Báº¿p ChuyÃªn MÃ³n Cay</span>
                            <p class="noodle-about-chef-description">
                                Park lÃ  má»™t chuyÃªn gia vá» cÃ¡c mÃ³n cay HÃ n Quá»‘c vá»›i 12 nÄƒm kinh nghiá»‡m. CÃ´ áº¥y Ä‘am mÃª táº¡o ra
                                nhá»¯ng
                                cÃ´ng thá»©c nÆ°á»›c dÃ¹ng Ä‘á»™c Ä‘Ã¡o, cÃ¢n báº±ng giá»¯a vá»‹ cay vÃ  hÆ°Æ¡ng vá»‹ Ä‘áº­m Ä‘Ã  truyá»n thá»‘ng.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Chef 3 -->
                <div class="col-lg-4 col-md-6">
                    <div class="noodle-about-chef-card">
                        <div class="noodle-about-chef-image">
                            <img src="https://images.unsplash.com/photo-1595475038784-bbe439ff41e6?ixlib=rb-4.0.3&auto=format&fit=crop&w=687&q=80"
                                alt="Äáº§u báº¿p Kim Soo Hyun">
                        </div>
                        <div class="noodle-about-chef-info">
                            <a href="#" class="noodle-about-chef-name">Kim Soo Hyun</a>
                            <span class="noodle-about-chef-role">Äáº§u Báº¿p SÃ¡ng Táº¡o</span>
                            <p class="noodle-about-chef-description">
                                Kim lÃ  má»™t Ä‘áº§u báº¿p sÃ¡ng táº¡o vá»›i kháº£ nÄƒng káº¿t há»£p cÃ¡c hÆ°Æ¡ng vá»‹ truyá»n thá»‘ng vÃ  hiá»‡n Ä‘áº¡i.
                                Anh áº¥y luÃ´n tÃ¬m kiáº¿m nhá»¯ng cÃ¡ch má»›i Ä‘á»ƒ nÃ¢ng cao cháº¥t lÆ°á»£ng mÃ³n Äƒn vÃ  mang Ä‘áº¿n sá»± hÃ i lÃ²ng
                                tá»‘i Ä‘a cho khÃ¡ch hÃ ng.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

