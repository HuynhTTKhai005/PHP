@extends('layouts.sincay')

@section('title', 'Blog - Sincay')

@section('content')
    <section class="titles text-center text-white"
        style="background: url({{ asset('assets/images/bgintro.png') }}) center/cover no-repeat; min-height: 360px;">
        <div class="container">
            <h2 class="tit">Blog Sincay</h2>
         </div>
    </section>

    <section class="section-mainmenu p-t-110 p-b-70  ">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 order-lg-2">
                    

                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="mb-3">Sincay hôm nay</h5>
                            <p class="text-muted mb-3">
                                Mở cửa mỗi ngày 9:00 - 22:00. Đặt món nhanh qua menu online hoặc ghé quán để thưởng thức nóng
                                hổi.
                            </p>
                            <a href="{{ route('menu') }}" class="btn btn-outline-danger w-100">Xem thực đơn</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 order-lg-1">
                    <article class="card border-0 shadow-sm mb-4">
                        <div class="row g-0">
                            <div class="col-md-5">
                                <img src="{{ asset('assets/images/intro_1.png') }}" class="img-fluid w-100 h-100"
                                    style="object-fit: cover;" alt="Mì cay Sincay">
                            </div>
                            <div class="col-md-7">
                                <div class="card-body p-4">
                                    <span class="badge bg-danger mb-3">Bài nổi bật</span>
                                    <h3 class="mb-3">Mì cay chuẩn vị Hàn, điều gì làm nên sự khác biệt?</h3>
                                    <p class="text-muted mb-3">
                                        Tại Sincay, nước dùng được nấu nhiều giờ từ xương và rau củ, kết hợp 7 cấp độ cay để
                                        phù hợp mọi khẩu vị. Đây là bí quyết giữ vị đậm, thơm và hậu vị ngọt tự nhiên.
                                    </p>
                                 </div>
                            </div>
                        </div>
                    </article>

                    <article class="card border-0 shadow-sm mb-3">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="{{ asset('assets/images/intro_2.jpg') }}" class="img-fluid w-100 h-100"
                                    style="object-fit: cover;" alt="Topping mì cay">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="mb-2">5 loại topping được gọi nhiều nhất</h5>
                                    <p class="text-muted mb-2">Bò Mỹ, xúc xích, nấm kim châm, phô mai và tôm là combo được
                                        khách hàng chọn nhiều nhất.</p>
                                </div>
                            </div>
                        </div>
                    </article>

                    <article class="card border-0 shadow-sm mb-3">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="{{ asset('assets/images/intro_3.png') }}" class="img-fluid w-100 h-100"
                                    style="object-fit: cover;" alt="Không gian quán">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="mb-2">Không gian quán cho nhóm bạn cuối tuần</h5>
                                    <p class="text-muted mb-2">Thiết kế ấm cúng, bàn nhóm rộng rãi và khu vực riêng tư giúp
                                        bạn thoải mái tụ họp.</p>
                                </div>
                            </div>
                        </div>
                    </article>

                    <article class="card border-0 shadow-sm mb-3">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="{{ asset('assets/images/intro_4.jpg') }}" class="img-fluid w-100 h-100"
                                    style="object-fit: cover;" alt="Mức cay">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="mb-2">Chọn cấp độ cay sao cho hợp khẩu vị?</h5>
                                    <p class="text-muted mb-2">Người mới nên bắt đầu từ cấp 1-2, còn tín đồ cay có thể thử cấp
                                        5 trở lên để cảm nhận trọn vị.</p>
                                </div>
                            </div>
                        </div>
                    </article>

                    <article class="card border-0 shadow-sm">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="{{ asset('assets/images/intro_1.png') }}" class="img-fluid w-100 h-100"
                                    style="object-fit: cover;" alt="Khuyến mãi">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="mb-2">Ưu đãi theo khung giờ tại Sincay</h5>
                                    <p class="text-muted mb-2">Khung giờ trưa và đầu tuần thường có combo tiết kiệm, phù hợp
                                        cho học sinh sinh viên.</p>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <script>
        function showToast(message) {
            var toast = document.createElement('div');
            toast.className = 'toast-notification show';
            toast.innerHTML = '<i class="fas fa-check-circle mr-2"></i> ' + message;
            document.getElementById('toast-container').appendChild(toast);
            setTimeout(function() {
                toast.classList.remove('show');
                setTimeout(function() { toast.remove(); }, 500);
            }, 3000);
        }

        function savePost(postId, btnElement) {
            fetch('{{ route('blog.save') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id: postId })
            })
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success') {
                    showToast(data.message);                    
                    const archiveList = document.getElementById('spicy-archive-list');
                    if (archiveList) {
                        archiveList.innerHTML = data.archiveHtml;
                    }
                    
                    const mainBtn = document.querySelector(`.btn-save-post[data-id="${postId}"]`);
                    
                    if (mainBtn) {
                        const icon = mainBtn.querySelector('i');
                        if(data.action === 'added') {
                            mainBtn.classList.add('saved');
                            icon.classList.remove('far'); icon.classList.add('fas');
                            mainBtn.innerHTML = '<i class="fas fa-heart"></i> Đã lưu';
                        } else {                           
                            mainBtn.classList.remove('saved');
                            icon.classList.remove('fas'); icon.classList.add('far');
                            mainBtn.innerHTML = '<i class="far fa-heart"></i> Lưu';
                        }
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Có lỗi xảy ra, vui lòng thử lại.');
            });
        }
    </script>
@endsection