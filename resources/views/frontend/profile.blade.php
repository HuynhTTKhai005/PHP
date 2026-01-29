@extends('layouts.pato')

@section('content')
    <section>
        <div class="container mt-5 pt-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow">
                        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Hồ Sơ Khách Hàng</h5>
                            <button class="btn btn-sm btn-outline-light" id="btn-toggle-edit" onclick="toggleEdit()">
                                <i class="fa fa-edit"></i> Chỉnh sửa
                            </button>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                @method('patch')
                                <div class="mb-4">
                                    <label class="text-muted small">Họ và Tên</label>
                                    <div class="view-mode font-weight-bold">{{ $user->full_name }}</div>
                                    <input type="text" name="full_name" class="form-control edit-mode d-none"
                                        value="{{ $user->full_name }}">
                                </div>
                                <div class="mb-4">
                                    <label class="text-muted small">Số điện thoại</label>
                                    <div class="view-mode font-weight-bold">{{ $user->phone }}</div>
                                    <input type="text" name="phone" class="form-control edit-mode d-none"
                                        value="{{ $user->phone }}">
                                </div>
                                <div class="mb-4">
                                    <label class="text-muted small">Email (Tên đăng nhập)</label>
                                    <div class="font-weight-bold text-primary">{{ $user->email }}</div>
                                    <small class="text-muted italic">* Email không thể thay đổi</small>
                                </div>
                                <div class="mb-4">
                                    <label class="text-muted small">Điểm tích lũy (Loyalty Points)</label>
                                    <div><span class="badge badge-success">{{ number_format($user->loyalty_points) }}
                                            điểm</span></div>
                                </div>
                                <div class="edit-mode d-none border-top pt-3">
                                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                    <button type="button" class="btn btn-secondary" onclick="toggleEdit()">Hủy</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label class="text-muted small">Địa chỉ nhận hàng mặc định</label>
                @if ($user->addresses->isNotEmpty())
                    @php $addr = $user->addresses->first(); @endphp
                    <div class="view-mode font-weight-bold">
                        {{ $addr->address_detail }}, {{ $addr->ward }}, {{ $addr->district }}, {{ $addr->city }}
                    </div>
                @else
                    <div class="text-danger small italic">Chưa có thông tin địa chỉ</div>
                @endif
            </div>
        </div>
        <script>
            function toggleEdit() {
                const viewFields = document.querySelectorAll('.view-mode');
                const editFields = document.querySelectorAll('.edit-mode');
                const btn = document.getElementById('btn-toggle-edit');
                viewFields.forEach(el => el.classList.toggle('d-none'));
                editFields.forEach(el => el.classList.toggle('d-none'));
                if (btn.style.display === "none") {
                    btn.style.display = "block";
                } else {
                    btn.style.display = "none";
                }
            }
        </script>
    </section>
@endsection
