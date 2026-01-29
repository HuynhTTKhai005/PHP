@extends('layouts.pato')


@section('content')
    <section class="titles text-center text-white"
        style="background: url({{ asset('assets/images/bg-title-page-01.jpg') }}) center/cover no-repeat; min-height: 400px;">
        <div class="container">
            <h2 class="tit">Sincay Menu</h2>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="noodle-gallery-section">
        <div class="container">
            <!-- Filter Buttons -->
            <div class="noodle-gallery-filter">
                <button class="noodle-gallery-filter-btn active">Tất Cả Ảnh</button>
                <button class="noodle-gallery-filter-btn">Nội Thất</button>
                <button class="noodle-gallery-filter-btn">Đồ Ăn</button>
                <button class="noodle-gallery-filter-btn">Sự Kiện</button>
                <button class="noodle-gallery-filter-btn">Khách VIP</button>
            </div>

            <!-- Gallery Grid -->
            <div class="noodle-gallery-grid">
                <!-- Item 1 - Events & Guests -->
                <div class="noodle-gallery-item">
                    <img src="assets/images/photo-gallery-13.jpg" alt="Sự kiện nhà hàng" class="noodle-gallery-img">
                    <div class="noodle-gallery-overlay">
                        <a href="assets/images/photo-gallery-13.jpg" class="noodle-gallery-view" target="_blank">
                            <i class="fas fa-search"></i>
                        </a>
                    </div>
                </div>

                <!-- Item 2 - Food -->
                <div class="noodle-gallery-item">
                    <img src="assets/images/photo-gallery-14.jpg" alt="Món mỳ cay" class="noodle-gallery-img">
                    <div class="noodle-gallery-overlay">
                        <a href="assets/images/photo-gallery-14.jpg" class="noodle-gallery-view" target="_blank">
                            <i class="fas fa-search"></i>
                        </a>
                    </div>
                </div>

                <!-- Item 3 - Events -->
                <div class="noodle-gallery-item">
                    <img src="assets/images/photo-gallery-15.jpg" alt="Tiệc tối" class="noodle-gallery-img">
                    <div class="noodle-gallery-overlay">
                        <a href="assets/images/photo-gallery-15.jpg" class="noodle-gallery-view" target="_blank">
                            <i class="fas fa-search"></i>
                        </a>
                    </div>
                </div>

                <!-- Item 4 - Food -->
                <div class="noodle-gallery-item">
                    <img src="assets/images/photo-gallery-16.jpg" alt="Món ăn Hàn Quốc" class="noodle-gallery-img">
                    <div class="noodle-gallery-overlay">
                        <a href="assets/images/photo-gallery-16.jpg" class="noodle-gallery-view" target="_blank">
                            <i class="fas fa-search"></i>
                        </a>
                    </div>
                </div>

                <!-- Item 5 - Food -->
                <div class="noodle-gallery-item">
                    <img src="assets/images/photo-gallery-17.jpg" alt="Mỳ cay đặc biệt" class="noodle-gallery-img">
                    <div class="noodle-gallery-overlay">
                        <a href="assets/images/photo-gallery-17.jpg" class="noodle-gallery-view" target="_blank">
                            <i class="fas fa-search"></i>
                        </a>
                    </div>
                </div>

                <!-- Item 6 - Interior & Guests -->
                <div class="noodle-gallery-item">
                    <img src="assets/images/photo-gallery-18.jpg" alt="Không gian nhà hàng" class="noodle-gallery-img">
                    <div class="noodle-gallery-overlay">
                        <a href="assets/images/photo-gallery-18.jpg" class="noodle-gallery-view" target="_blank">
                            <i class="fas fa-search"></i>
                        </a>
                    </div>
                </div>

                <!-- Item 7 - Interior -->
                <div class="noodle-gallery-item">
                    <img src="assets/images/photo-gallery-19.jpg" alt="Nội thất hiện đại" class="noodle-gallery-img">
                    <div class="noodle-gallery-overlay">
                        <a href="assets/images/photo-gallery-19.jpg" class="noodle-gallery-view" target="_blank">
                            <i class="fas fa-search"></i>
                        </a>
                    </div>
                </div>

                <!-- Item 8 - Interior -->
                <div class="noodle-gallery-item">
                    <img src="assets/images/photo-gallery-20.jpg" alt="Khu vực bếp" class="noodle-gallery-img">
                    <div class="noodle-gallery-overlay">
                        <a href="assets/images/photo-gallery-20.jpg" class="noodle-gallery-view" target="_blank">
                            <i class="fas fa-search"></i>
                        </a>
                    </div>
                </div>

                <!-- Item 9 - Events -->
                <div class="noodle-gallery-item">
                    <img src="assets/images/photo-gallery-21.jpg" alt="Sự kiện đặc biệt" class="noodle-gallery-img">
                    <div class="noodle-gallery-overlay">
                        <a href="assets/images/photo-gallery-21.jpg" class="noodle-gallery-view" target="_blank">
                            <i class="fas fa-search"></i>
                        </a>
                    </div>
                </div>

                <!-- Thêm một số ảnh để gallery phong phú hơn -->
                <div class="noodle-gallery-item">
                    <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80"
                        alt="Món ăn đặc sắc" class="noodle-gallery-img">
                    <div class="noodle-gallery-overlay">
                        <a href="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80"
                            class="noodle-gallery-view" target="_blank">
                            <i class="fas fa-search"></i>
                        </a>
                    </div>
                </div>

                <div class="noodle-gallery-item">
                    <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80"
                        alt="Không gian sang trọng" class="noodle-gallery-img">
                    <div class="noodle-gallery-overlay">
                        <a href="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80"
                            class="noodle-gallery-view" target="_blank">
                            <i class="fas fa-search"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="noodle-gallery-pagination">
                <a href="#" class="noodle-gallery-page active">1</a>
                <a href="#" class="noodle-gallery-page">2</a>
                <a href="#" class="noodle-gallery-page">3</a>
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
