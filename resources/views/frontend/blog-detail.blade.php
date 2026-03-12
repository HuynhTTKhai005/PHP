@extends('layouts.sincay')

@section('content')
    <div id="blog-save-config" data-save-url="{{ route('blog.save') }}"></div>

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
                            <img src="{{ asset($post['image']) }}" alt="{{ $post['title'] }}"
                                class="img-fluid w-100 rounded">
                        </div>

                        <div
                            class="blog-detail-meta mb-4 text-muted d-flex justify-content-between align-items-center border-bottom pb-3">
                            <div>
                                <span class="mr-3"><i class="fas fa-calendar text-danger"></i>
                                    {{ \Carbon\Carbon::parse($post['date'])->format('d/m/Y') }}</span>
                                <span class="mr-3"><i class="fas fa-user text-danger"></i> {{ $post['author'] }}</span>
                                <span class="mr-3"><i class="fas fa-folder text-danger"></i>
                                    {{ $post['category'] }}</span>
                            </div>
                            <button class="btn btn-outline-danger btn-save-post {{ $isSaved ? 'active' : '' }}"
                                data-post-id="{{ $post['id'] }}">
                                <i class="{{ $isSaved ? 'fas' : 'far' }} fa-heart"></i>
                                {{ $isSaved ? 'Đã lưu bài này' : 'Lưu bài viết' }}
                            </button>
                        </div>

                        <div class="blog-detail-content text-justify" style="font-size: 16px; line-height: 1.8;">
                            <p class="mb-3 font-weight-bold">{{ $post['content'] }}</p>

                            <p class="mb-3">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mì cay Sincay không chỉ là món ăn,
                                đó là trải nghiệm. Với công thức nước dùng đặc quyền hầm từ xương trong 12 giờ.
                            </p>

                            <blockquote class="blockquote border-left pl-3" style="border-left: 5px solid #dc3545;">
                                <p class="mb-0 font-italic">"Vị cay không chỉ ở đầu lưỡi, mà còn đánh thức mới giác quan của
                                    bạn."</p>
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
@endsection
