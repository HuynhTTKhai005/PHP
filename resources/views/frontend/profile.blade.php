@extends('layouts.pato')

@section('content')

 <section class="titles text-center text-white"
        style="background: url({{ asset('assets/images/bgintro.png') }}) center/cover no-repeat; min-height: 360px;">
        <div class="container">
            <h2 class="tit">Thông tin cá nhân</h2>
         </div>
    </section>

         <div class="container mt-5 pt-5  ">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow">
                        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Hồ sơ khách hàng</h5>
                        </div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                @method('patch')

                                <div class="mb-3">
                                    <label class="text-muted small">Họ và tên</label>
                                    <input type="text" name="full_name" class="form-control"
                                        value="{{ old('full_name', $user->full_name) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="text-muted small">Số điện thoại</label>
                                    <input type="text" name="phone" class="form-control"
                                        value="{{ old('phone', $user->phone) }}">
                                </div>

                                <div class="mb-3">
                                    <label class="text-muted small">Email (Tên đăng nhập)</label>
                                    <div class="fw-bold text-primary">{{ $user->email }}</div>
                                    <small class="text-muted">* Email không thể thay đổi</small>
                                </div>

                                <div class="mb-3">
                                    <label class="text-muted small">Điểm tích lũy</label>
                                    <div>
                                        <span class="badge bg-success">{{ number_format($user->loyalty_point ?? 0) }} điểm</span>
                                    </div>
                                </div>

                                <div class="border-top pt-3">
                                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3 mt-4">
                <label class="text-muted small">Địa chỉ nhận hàng mặc định</label>
                @if ($defaultAddress)
                    <div class="fw-bold">
                        {{ $defaultAddress->address_detail }},
                        {{ $defaultAddress->ward }},
                        {{ $defaultAddress->district }},
                        {{ $defaultAddress->city }}
                    </div>
                @else
                    <div class="text-danger small">Chưa có thông tin địa chỉ</div>
                @endif
            </div>
        </div>
 @endsection
