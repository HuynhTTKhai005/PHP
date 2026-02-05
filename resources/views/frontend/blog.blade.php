@extends('layouts.pato')

@section('content')
    <style>        
        #toast-container { position: fixed; bottom: 20px; right: 20px; z-index: 9999; }
        .toast-notification { background-color: #333; color: #fff; padding: 15px 25px; border-radius: 5px; margin-top: 10px; opacity: 0; transition: opacity 0.5s; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .toast-notification.show { opacity: 1; }                
        .btn-save-post { cursor: pointer; transition: all 0.3s; }
        .btn-save-post:hover { color: #dc3545 !important; transform: scale(1.1); }
        .btn-save-post.saved { color: #dc3545 !important; }        
        .spicy-scroll-container { max-height: 800px; overflow-y: auto; padding-right: 10px; }
        .spicy-scroll-container::-webkit-scrollbar { width: 6px; }
        .spicy-scroll-container::-webkit-scrollbar-track { background: #f1f1f1; }
        .spicy-scroll-container::-webkit-scrollbar-thumb { background: #dc3545; border-radius: 3px; }
                
        .spicy-pagination .page-item { margin: 0 3px; }
        .spicy-pagination .page-link {
            border: 1px solid #e9ecef;
            color: #333;
            border-radius: 5px;
            padding: 8px 16px;
            transition: all 0.3s;
        }
        .spicy-pagination .page-link:hover {
            background-color: #f8d7da;
            color: #dc3545;
            border-color: #dc3545;
        }
        .spicy-pagination .page-item.active .page-link {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
            box-shadow: 0 4px 6px rgba(220, 53, 69, 0.3);
        }
        
        .btn-remove-saved {
            cursor: pointer;
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s;
            color: #999;
        }
        .btn-remove-saved:hover {
            background-color: #dc3545;
            color: white;
        }
    </style>

    <div id="toast-container"></div>

    <section>
        <section class="titles text-center text-white"
            style="background: url({{ asset('assets/images/bg-title-page-01.jpg') }}) center/cover no-repeat; min-height: 400px;">
            <div class="container h-100 d-flex justify-content-center align-items-center" style="height: 400px;">
                <h2 class="tit display-3 font-weight-bold" style="font-size: 60px;">Tin Tức Mỳ Cay</h2>
            </div>
        </section>

        <div class="container" style="padding-top: 50px; padding-bottom: 50px;">
            <div class="row">
                <div class="col-lg-8 col-md-7">
                    <div class="spicy-blog-main">
                        
                        <div class="spicy-scroll-container mb-4">
                            @if($posts->count() > 0)
                                @foreach($posts as $post)
                                    @php
                                        $isSaved = in_array($post['id'], session('saved_posts', []));
                                    @endphp
                                    <div class="spicy-blog-post" style="margin-bottom: 50px; border-bottom: 1px dashed #ddd; padding-bottom: 30px;">
                                        <div class="spicy-blog-image position-relative" style="margin-bottom: 20px;">
                                            <a href="{{ route('blog.detail', $post['slug']) }}">
                                                <img src="{{ asset($post['image']) }}" alt="{{ $post['title'] }}" class="img-fluid" style="width: 100%;">
                                            </a>
                                            <div class="spicy-blog-date text-center" style="position: absolute; top: 20px; left: 20px; background: #dc3545; color: white; padding: 10px 15px;">
                                                <span class="spicy-blog-day d-block" style="font-size: 30px; font-weight: bold;">{{ \Carbon\Carbon::parse($post['date'])->day }}</span>
                                                <span class="spicy-blog-month d-block text-uppercase">{{ \Carbon\Carbon::parse($post['date'])->format('M, Y') }}</span>
                                            </div>
                                        </div>

                                        <div class="spicy-blog-content">
                                            <h3 class="spicy-blog-post-title" style="margin-bottom: 15px;">
                                                <a href="{{ route('blog.detail', $post['slug']) }}" class="text-dark font-weight-bold" style="font-size: 24px; text-decoration: none;">
                                                    {{ $post['title'] }}
                                                </a>
                                            </h3>

                                            <div class="spicy-blog-meta text-muted d-flex align-items-center justify-content-between" style="margin-bottom: 15px; font-size: 14px;">
                                                <div>
                                                    <span class="mr-3"><i class="fas fa-user"></i> {{ $post['author'] }}</span>
                                                    <span class="mr-3"><i class="fas fa-tags"></i> {{ $post['category'] }}</span>
                                                    <span><i class="fas fa-comments"></i> {{ $post['comments'] }} Bình Luận</span>
                                                </div>
                                                <div>
                                                    <button class="btn btn-sm btn-light border btn-save-post {{ $isSaved ? 'saved' : '' }}" 
                                                            onclick="savePost({{ $post['id'] }}, this)" 
                                                            data-id="{{ $post['id'] }}"
                                                            title="Lưu bài viết">
                                                        <i class="{{ $isSaved ? 'fas' : 'far' }} fa-heart"></i> 
                                                        {{ $isSaved ? 'Đã lưu' : 'Lưu' }}
                                                    </button>
                                                </div>
                                            </div>

                                            <p class="spicy-blog-excerpt" style="margin-bottom: 20px; color: #666;">
                                                {{ Str::limit($post['content'], 150) }}
                                            </p>

                                            <a href="{{ route('blog.detail', $post['slug']) }}" class="spicy-blog-readmore text-danger font-weight-bold" style="text-decoration: none;">
                                                ĐỌC TIẾP <i class="fas fa-long-arrow-alt-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="alert alert-warning">
                                    Không tìm thấy bài viết nào phù hợp.
                                </div>
                            @endif
                        </div>
                        
                        <div class="spicy-pagination d-flex justify-content-center mt-4">
                            {{ $posts->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-5">
                    <div class="spicy-sidebar pl-lg-4">
                        
                        <div class="spicy-search-form mb-5">
                            <form action="{{ route('blog.index') }}" method="GET" style="position: relative;">
                                <input class="spicy-search-input form-control" type="text" name="search" placeholder="Tìm kiếm..." value="{{ request('search') }}" style="height: 50px; padding-right: 50px;">
                                <button class="spicy-search-button" type="submit" style="position: absolute; right: 0; top: 0; height: 50px; width: 50px; background: none; border: none;">
                                    <i class="fas fa-search text-danger"></i>
                                </button>
                            </form>
                        </div>

                        <div class="spicy-categories mb-5">
                            <h4 class="spicy-sidebar-title font-weight-bold mb-4">Danh Mục</h4>
                            <ul class="spicy-categories-list list-unstyled">
                                <li class="mb-2 pb-2 border-bottom">
                                    <a href="{{ route('blog.index') }}" class="{{ !request('category') ? 'text-danger font-weight-bold' : 'text-secondary' }}">Tất cả</a>
                                </li>
                                @foreach($categories as $cat)
                                    <li class="spicy-categories-item mb-2 pb-2 border-bottom">
                                        <a href="{{ route('blog.index', ['category' => $cat]) }}" 
                                           class="spicy-categories-link {{ request('category') == $cat ? 'text-danger font-weight-bold' : 'text-secondary' }}" 
                                           style="text-decoration: none;">
                                            {{ $cat }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="spicy-archive mb-5">
                            <h4 class="spicy-sidebar-title font-weight-bold mb-4">
                                Bài Viết Đã Lưu <i class="fas fa-heart text-danger"></i>
                            </h4>
                            
                            <ul class="spicy-archive-list list-unstyled" id="spicy-archive-list">
                                @if(count($savedPostsList) > 0)
                                    @foreach($savedPostsList as $savedPost)
                                        <li class="spicy-archive-item mb-2 pb-2 border-bottom d-flex justify-content-between align-items-center">
                                            <div style="width: 85%;">
                                                <a href="{{ route('blog.detail', $savedPost['slug']) }}" class="text-dark font-weight-bold" style="text-decoration: none; font-size: 14px; display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                    {{ $savedPost['title'] }}
                                                </a>
                                                <span class="text-muted" style="font-size: 12px;">{{ \Carbon\Carbon::parse($savedPost['date'])->format('d/m/Y') }}</span>
                                            </div>
                                            <span class="btn-remove-saved" onclick="savePost({{ $savedPost['id'] }}, this)" title="Bỏ lưu">
                                                <i class="fas fa-times"></i>
                                            </span>
                                        </li>
                                    @endforeach
                                @else
                                    <p class="text-muted font-italic small">Bạn chưa lưu bài viết nào.</p>
                                @endif
                            </ul>
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