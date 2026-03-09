@extends('layouts.sincay')


@section('content')
    <section class="titles text-center text-white "
        style="background: url({{ asset('assets/images/bgintro.png') }}) center/cover no-repeat; min-height: 400px;">
        <div class="container">
            <h2 class="tit">Thư viện Sincay</h2>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="noodle-gallery-section">
        <div class="container">
            <!-- Gallery Slider -->
            <div class="noodle-gallery-slider">
                <div class="noodle-gallery-item">
                    <img src="assets/images/gallery/gallery-1.jpg" alt="Sự kiện nhà hàng" class="noodle-gallery-img">
                    <div class="noodle-gallery-overlay">
                        <a href="assets/images/gallery/gallery-1.jpg" class="noodle-gallery-view" target="_blank">
                            <i class="fas fa-search"></i>
                        </a>
                    </div>
                </div>

                <div class="noodle-gallery-item">
                    <img src="assets/images/gallery/gallery-2.jpg" alt="Món mỳ cay" class="noodle-gallery-img">
                    <div class="noodle-gallery-overlay">
                        <a href="assets/images/gallery/gallery-2.jpg" class="noodle-gallery-view" target="_blank">
                            <i class="fas fa-search"></i>
                        </a>
                    </div>
                </div>

                <div class="noodle-gallery-item">
                    <img src="assets/images/gallery/gallery-3.jpg" alt="Tiệc tối" class="noodle-gallery-img">
                    <div class="noodle-gallery-overlay">
                        <a href="assets/images/gallery/gallery-3.jpg" class="noodle-gallery-view" target="_blank">
                            <i class="fas fa-search"></i>
                        </a>
                    </div>
                </div>

                <div class="noodle-gallery-item">
                    <img src="assets/images/gallery/gallery-4.jpg" alt="Món ăn Hàn Quốc" class="noodle-gallery-img">
                    <div class="noodle-gallery-overlay">
                        <a href="assets/images/gallery/gallery-4.jpg" class="noodle-gallery-view" target="_blank">
                            <i class="fas fa-search"></i>
                        </a>
                    </div>
                </div>
                <div class="noodle-gallery-item">
                    <img src="assets/images/gallery/gallery-6.jpg" alt="Món ăn Hàn Quốc" class="noodle-gallery-img">
                    <div class="noodle-gallery-overlay">
                        <a href="assets/images/gallery/gallery-6.jpg" class="noodle-gallery-view" target="_blank">
                            <i class="fas fa-search"></i>
                        </a>
                    </div>
                </div>
                <div class="noodle-gallery-item">
                    <img src="assets/images/gallery/gallery-1.jpg" alt="Sự kiện nhà hàng" class="noodle-gallery-img">
                    <div class="noodle-gallery-overlay">
                        <a href="assets/images/gallery/gallery-1.jpg" class="noodle-gallery-view" target="_blank">
                            <i class="fas fa-search"></i>
                        </a>
                    </div>
                </div>

                <div class="noodle-gallery-item">
                    <img src="assets/images/gallery/gallery-2.jpg" alt="Món mỳ cay" class="noodle-gallery-img">
                    <div class="noodle-gallery-overlay">
                        <a href="assets/images/gallery/gallery-2.jpg" class="noodle-gallery-view" target="_blank">
                            <i class="fas fa-search"></i>
                        </a>
                    </div>
                </div>

                <div class="noodle-gallery-item">
                    <img src="assets/images/gallery/gallery-3.jpg" alt="Tiệc tối" class="noodle-gallery-img">
                    <div class="noodle-gallery-overlay">
                        <a href="assets/images/gallery/gallery-3.jpg" class="noodle-gallery-view" target="_blank">
                            <i class="fas fa-search"></i>
                        </a>
                    </div>
                </div>

                <div class="noodle-gallery-item">
                    <img src="assets/images/gallery/gallery-4.jpg" alt="Món ăn Hàn Quốc" class="noodle-gallery-img">
                    <div class="noodle-gallery-overlay">
                        <a href="assets/images/gallery/gallery-4.jpg" class="noodle-gallery-view" target="_blank">
                            <i class="fas fa-search"></i>
                        </a>
                    </div>
                </div>

                <div class="noodle-gallery-item">
                    <img src="assets/images/gallery/gallery-6.jpg" alt="Món ăn Hàn Quốc" class="noodle-gallery-img">
                    <div class="noodle-gallery-overlay">
                        <a href="assets/images/gallery/gallery-6.jpg" class="noodle-gallery-view" target="_blank">
                            <i class="fas fa-search"></i>
                        </a>
                    </div>
                </div>
            </div>


        </div>
    </section>



    <!-- Phiên bản có filter thật sự (nếu cần) -->
    <div class="d-none">
        <input type="radio" name="noodle-filter" id="noodle-radio-all" class="noodle-gallery-radio-filter" checked>
        <input type="radio" name="noodle-filter" id="noodle-radio-interior" class="noodle-gallery-radio-filter">
        <input type="radio" name="noodle-filter" id="noodle-radio-food" class="noodle-gallery-radio-filter">
        <input type="radio" name="noodle-filter" id="noodle-radio-events" class="noodle-gallery-radio-filter">
        <input type="radio" name="noodle-filter" id="noodle-radio-guests" class="noodle-gallery-radio-filter">

        <div class="noodle-gallery-filter">
            <label for="noodle-radio-all" class="noodle-filter-label noodle-gallery-filter-btn">Tất Cả Ảnh</label>
            <label for="noodle-radio-interior" class="noodle-filter-label noodle-gallery-filter-btn">Nội Thất</label>
            <label for="noodle-radio-food" class="noodle-filter-label noodle-gallery-filter-btn">Đồ Ăn</label>
            <label for="noodle-radio-events" class="noodle-filter-label noodle-gallery-filter-btn">Sự Kiện</label>
            <label for="noodle-radio-guests" class="noodle-filter-label noodle-gallery-filter-btn">Khách VIP</label>
        </div>
    </div>
@endsection

