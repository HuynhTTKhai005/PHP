@extends('layouts.pato')

@section('content')
    <style>
        #toast-container { position: fixed; bottom: 20px; right: 20px; z-index: 9999; }
        .toast-notification { background-color: #333; color: #fff; padding: 15px 25px; border-radius: 5px; margin-top: 10px; opacity: 0; transition: opacity 0.5s; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .toast-notification.show { opacity: 1; }
        .btn-save-post:hover { transform: scale(1.05); }
    </style>
    <div id="toast-container"></div>

    <section class="bg-title-page flex-c-m p-t-160 p-b-80 p-l-15 p-r-15" 
             style="background-image: url({{ asset('assets/images/bg-title-page-01.jpg') }}); min-height: 300px; display: flex; align-items: center; justify-content: center;">
        <h2 class="tit6 t-center text-white text-center display-4 font-weight-bold">
            {{ $post['title'] }}
        </h2>
    </section>

    <section class="p-t-60 p-b-60" style="padding: 60px 0;">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-lg-9 m-l-r-auto">
                    <div class="p-t-30">
                        
                        <div class="blog-detail-img mb-4">
                            <img src="{{ asset($post['image']) }}" alt="{{ $post['title'] }}" class="img-fluid w-100 rounded">
                        </div>

                        <div class="blog-detail-meta mb-4 text-muted d-flex justify-content-between align-items-center border-bottom pb-3">
                            <div>
                                <span class="mr-3"><i class="fas fa-calendar text-danger"></i> {{ \Carbon\Carbon::parse($post['date'])->format('d/m/Y') }}</span>
                                <span class="mr-3"><i class="fas fa-user text-danger"></i> {{ $post['author'] }}</span>
                                <span class="mr-3"><i class="fas fa-folder text-danger"></i> {{ $post['category'] }}</span>
                            </div>
                            <button class="btn btn-outline-danger btn-save-post {{ $isSaved ? 'active' : '' }}" 
                                    onclick="savePost({{ $post['id'] }}, this)">
                                <i class="{{ $isSaved ? 'fas' : 'far' }} fa-heart"></i> 
                                {{ $isSaved ? 'Đã lưu bài này' : 'Lưu bài viết' }}
                            </button>
                        </div>

                        <div class="blog-detail-content text-justify" style="font-size: 16px; line-height: 1.8;">
                            <p class="mb-3 font-weight-bold">{{ $post['content'] }}</p>
                            
                            <p class="mb-3">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mỳ cay Sincay không chỉ là món ăn, đó là trải nghiệm. Với công thức nước dùng độc quyền hầm từ xương ống trong 12 giờ.
                            </p>
                            
                            <blockquote class="blockquote border-left pl-3" style="border-left: 5px solid #dc3545;">
                                <p class="mb-0 font-italic">"Vị cay không chỉ ở đầu lưỡi, mà còn đánh thức mọi giác quan của bạn."</p>
                            </blockquote>

                            <p class="mb-3">
                                Hãy đến và trải nghiệm ngay hôm nay.
                            </p>
                        </div>
                        
                        <div class="mt-5 pt-4 border-top">
                            <a href="{{ route('blog.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Quay lại danh sách
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function showToast(message) {
            var toast = document.createElement('div');
            toast.className = 'toast-notification show';
            toast.innerHTML = '<i class="fas fa-info-circle mr-2"></i> ' + message;
            document.getElementById('toast-container').appendChild(toast);
            setTimeout(function() {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 500);
            }, 3000);
        }

        function savePost(postId, btnElement) {
            fetch('{{ route('blog.save') }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ id: postId })
            })
            .then(res => res.json())
            .then(data => {
                showToast(data.message);
                const icon = btnElement.querySelector('i');
                if(data.action === 'added') {
                    btnElement.classList.add('active'); 
                    icon.classList.remove('far'); icon.classList.add('fas');
                    btnElement.innerHTML = '<i class="fas fa-heart"></i> Đã lưu bài này';
                } else {
                    btnElement.classList.remove('active');
                    icon.classList.remove('fas'); icon.classList.add('far');
                    btnElement.innerHTML = '<i class="far fa-heart"></i> Lưu bài viết';
                }
            });
        }
    </script>
@endsection