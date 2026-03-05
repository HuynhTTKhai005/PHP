@extends('admin.app')

@section('content')
    <div class="content-area users-page">
        <div class="section-header">
            <h2>Thêm người dùng</h2>
            <div class="table-actions">
                <a href="{{ route('admin.users') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger reservation-alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card products-container">
            <form action="{{ route('admin.users.store') }}" method="POST" class="users-create-form">
                @csrf
                <div class="users-create-grid">
                    <div class="form-group">
                        <label>Họ tên</label>
                        <input type="text" name="full_name" class="filter-input" value="{{ old('full_name') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="filter-input" value="{{ old('email') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="text" name="phone" class="filter-input" value="{{ old('phone') }}">
                    </div>
                    <div class="form-group">
                        <label>Quyền</label>
                        <select name="role_id" class="filter-select" required>
                            <option value="1" {{ old('role_id') === '1' ? 'selected' : '' }}>Admin</option>
                            <option value="2" {{ old('role_id') === '2' ? 'selected' : '' }}>Nhân viên</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Mật khẩu</label>
                        <input type="password" name="password" class="filter-input" required>
                    </div>
                    <div class="form-group">
                        <label>Nhập lại mật khẩu</label>
                        <input type="password" name="password_confirmation" class="filter-input" required>
                    </div>
                </div>

                <div class="users-create-actions">
                    <label class="users-checkbox">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }}>
                        Kích hoạt tài khoản ngay
                    </label>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Thêm người dùng
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
