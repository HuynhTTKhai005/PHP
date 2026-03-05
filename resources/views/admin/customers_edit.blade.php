@extends('admin.app')

@section('content')
    <div class="content-area">
        <div class="section-header">
            <h2>Chỉnh sửa khách hàng</h2>
            <div class="table-actions">
                <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-secondary">
                    <i class="fas fa-eye"></i> Xem chi tiết
                </a>
                <a href="{{ route('admin.customers') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>

        <div class="customers-container">
            <form method="POST" action="{{ route('admin.customers.update', $customer) }}">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group">
                        <label>Họ và tên <span class="required">*</span></label>
                        <input type="text" class="form-control" name="full_name"
                            value="{{ old('full_name', $customer->full_name) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Email <span class="required">*</span></label>
                        <input type="email" class="form-control" name="email"
                            value="{{ old('email', $customer->email) }}" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="text" class="form-control" name="phone" value="{{ old('phone', $customer->phone) }}">
                    </div>
                    <div class="form-group">
                        <label>Địa chỉ</label>
                        <input type="text" class="form-control" name="address" value="{{ old('address', $address) }}">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Mật khẩu mới (để trống nếu không đổi)</label>
                        <input type="password" class="form-control" name="password">
                    </div>
                    <div class="form-group">
                        <label>Nhập lại mật khẩu mới</label>
                        <input type="password" class="form-control" name="password_confirmation">
                    </div>
                </div>

                <div class="form-group">
                    <input type="hidden" name="is_active" value="0">
                    <label>
                        <input type="checkbox" name="is_active" value="1"
                            {{ old('is_active', (int) $customer->is_active) ? 'checked' : '' }}>
                        Trạng thái hoạt động (bỏ chọn để tạm khóa)
                    </label>
                </div>

                <div class="form-actions">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-save"></i> Cập nhật khách hàng
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
