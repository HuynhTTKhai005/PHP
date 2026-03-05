@extends('layouts.sincay')


@section('content')
    <section class="titles text-center text-white "
        style="background: url({{ asset('assets/images/bgintro.png') }}) center/cover no-repeat; min-height: 400px;">
        <div class="container">
            <h2 class="tit">ThÆ° viá»‡n Sincay</h2>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="noodle-gallery-section">
        <div class="container">
            <!-- Gallery Slider -->
            <div class="noodle-gallery-slider">
                <div class="noodle-gallery-item">
                    <img src="assets/images/gallery/gallery-1.jpg" alt="Sá»± kiá»‡n nhÃ  hÃ ng" class="noodle-gallery-img">
                    <div class="noodle-gallery-overlay">
                        <a href="assets/images/gallery/gallery-1.jpg" class="noodle-gallery-view" target="_blank">
                            <i class="fas fa-search"></i>
                        </a>
                    </div>
                </div>

                <div class="noodle-gallery-item">
                    <img src="assets/images/gallery/gallery-2.jpg" alt="MÃ³n má»³ cay" class="noodle-gallery-img">
                    <div class="noodle-gallery-overlay">
                        <a href="assets/images/gallery/gallery-2.jpg" class="noodle-gallery-view" target="_blank">
                            <i class="fas fa-search"></i>
                        </a>
                    </div>
                </div>

                <div class="noodle-gallery-item">
                    <img src="assets/images/gallery/gallery-3.jpg" alt="Tiá»‡c tá»‘i" class="noodle-gallery-img">
                    <div class="noodle-gallery-overlay">
                        <a href="assets/images/gallery/gallery-3.jpg" class="noodle-gallery-view" target="_blank">
                            <i class="fas fa-search"></i>
                        </a>
                    </div>
                </div>

                <div class="noodle-gallery-item">
                    <img src="assets/images/gallery/gallery-4.jpg" alt="MÃ³n Äƒn HÃ n Quá»‘c" class="noodle-gallery-img">
                    <div class="noodle-gallery-overlay">
                        <a href="assets/images/gallery/gallery-4.jpg" class="noodle-gallery-view" target="_blank">
                            <i class="fas fa-search"></i>
                        </a>
                    </div>
                </div>
                <div class="noodle-gallery-item">
                    <img src="assets/images/gallery/gallery-6.jpg" alt="MÃ³n Äƒn HÃ n Quá»‘c" class="noodle-gallery-img">
                    <div class="noodle-gallery-overlay">
                        <a href="assets/images/gallery/gallery-6.jpg" class="noodle-gallery-view" target="_blank">
                            <i class="fas fa-search"></i>
                        </a>
                    </div>
                </div>
                <div class="noodle-gallery-item">
                    <img src="assets/images/gallery/gallery-1.jpg" alt="Sá»± kiá»‡n nhÃ  hÃ ng" class="noodle-gallery-img">
                    <div class="noodle-gallery-overlay">
                        <a href="assets/images/gallery/gallery-1.jpg" class="noodle-gallery-view" target="_blank">
                            <i class="fas fa-search"></i>
                        </a>
                    </div>
                </div>

                <div class="noodle-gallery-item">
                    <img src="assets/images/gallery/gallery-2.jpg" alt="MÃ³n má»³ cay" class="noodle-gallery-img">
                    <div class="noodle-gallery-overlay">
                        <a href="assets/images/gallery/gallery-2.jpg" class="noodle-gallery-view" target="_blank">
                            <i class="fas fa-search"></i>
                        </a>
                    </div>
                </div>

                <div class="noodle-gallery-item">
                    <img src="assets/images/gallery/gallery-3.jpg" alt="Tiá»‡c tá»‘i" class="noodle-gallery-img">
                    <div class="noodle-gallery-overlay">
                        <a href="assets/images/gallery/gallery-3.jpg" class="noodle-gallery-view" target="_blank">
                            <i class="fas fa-search"></i>
                        </a>
                    </div>
                </div>

                <div class="noodle-gallery-item">
                    <img src="assets/images/gallery/gallery-4.jpg" alt="MÃ³n Äƒn HÃ n Quá»‘c" class="noodle-gallery-img">
                    <div class="noodle-gallery-overlay">
                        <a href="assets/images/gallery/gallery-4.jpg" class="noodle-gallery-view" target="_blank">
                            <i class="fas fa-search"></i>
                        </a>
                    </div>
                </div>

                <div class="noodle-gallery-item">
                    <img src="assets/images/gallery/gallery-6.jpg" alt="MÃ³n Äƒn HÃ n Quá»‘c" class="noodle-gallery-img">
                    <div class="noodle-gallery-overlay">
                        <a href="assets/images/gallery/gallery-6.jpg" class="noodle-gallery-view" target="_blank">
                            <i class="fas fa-search"></i>
                        </a>
                    </div>
                </div>
            </div>


        </div>
    </section>



    <!-- PhiÃªn báº£n cÃ³ filter tháº­t sá»± (náº¿u cáº§n) -->
    <div class="d-none">
        <input type="radio" name="noodle-filter" id="noodle-radio-all" class="noodle-gallery-radio-filter" checked>
        <input type="radio" name="noodle-filter" id="noodle-radio-interior" class="noodle-gallery-radio-filter">
        <input type="radio" name="noodle-filter" id="noodle-radio-food" class="noodle-gallery-radio-filter">
        <input type="radio" name="noodle-filter" id="noodle-radio-events" class="noodle-gallery-radio-filter">
        <input type="radio" name="noodle-filter" id="noodle-radio-guests" class="noodle-gallery-radio-filter">

        <div class="noodle-gallery-filter">
            <label for="noodle-radio-all" class="noodle-filter-label noodle-gallery-filter-btn">Táº¥t Cáº£ áº¢nh</label>
            <label for="noodle-radio-interior" class="noodle-filter-label noodle-gallery-filter-btn">Ná»™i Tháº¥t</label>
            <label for="noodle-radio-food" class="noodle-filter-label noodle-gallery-filter-btn">Äá»“ Ä‚n</label>
            <label for="noodle-radio-events" class="noodle-filter-label noodle-gallery-filter-btn">Sá»± Kiá»‡n</label>
            <label for="noodle-radio-guests" class="noodle-filter-label noodle-gallery-filter-btn">KhÃ¡ch VIP</label>
        </div>
    </div>
@endsection

