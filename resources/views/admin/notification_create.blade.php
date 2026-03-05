@extends('admin.app')

@section('content')
    <div class="content-area">
        <div class="section-header">
            <h2>Gửi thông báo mới</h2>
            <div class="table-actions"><a class="btn btn-secondary" href="{{ route('admin.notifications') }}"><i class="fas fa-arrow-left"></i> Quay lai</a></div>
        </div>

        <div class="card products-container">
            <form method="POST" action="{{ route('admin.notifications.store') }}">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label>Người nhận <span class="required">*</span></label>
                        <select class="form-control" name="recipient_mode" required>
                            <option value="all" {{ old('recipient_mode') === 'all' ? 'selected' : '' }}>Tất cả người dùng</option>
                            <option value="role" {{ old('recipient_mode') === 'role' ? 'selected' : '' }}>Theo vai trò</option>
                            <option value="user" {{ old('recipient_mode') === 'user' ? 'selected' : '' }}>Người dùng cu the</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Loại thông báo <span class="required">*</span></label>
                        <select class="form-control" name="type" required>
                            <option value="order_update" {{ old('type') === 'order_update' ? 'selected' : '' }}>Cập nhật đơn hàng</option>
                            <option value="promotion" {{ old('type') === 'promotion' ? 'selected' : '' }}>Khuyến mãi</option>
                            <option value="system_alert" {{ old('type') === 'system_alert' ? 'selected' : '' }}>Cảnh báo hệ thống</option>
                            <option value="password_reset" {{ old('type') === 'password_reset' ? 'selected' : '' }}>Dat lai mat khau</option>
                            <option value="other" {{ old('type') === 'other' ? 'selected' : '' }}>Khac</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Vai trò (neu gui theo vai trò)</label>
                        <select class="form-control" name="role_id">
                            <option value="">Chon vai trò</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ (string)old('role_id') === (string)$role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Người dùng (neu gui ca nhan)</label>
                        <select class="form-control" name="user_id">
                            <option value="">Chọn người dùng</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ (string)old('user_id') === (string)$user->id ? 'selected' : '' }}>{{ $user->full_name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Tiêu đề <span class="required">*</span></label>
                    <input type="text" class="form-control" name="title" value="{{ old('title') }}" required>
                </div>

                <div class="form-group">
                    <label>Nội dung thông báo <span class="required">*</span></label>
                    <textarea class="form-control" rows="5" name="message" required>{{ old('message') }}</textarea>
                </div>

                <div class="form-actions">
                    <button class="btn btn-secondary" type="button" onclick="history.back()">Hủy</button>
                    <button class="btn btn-primary" type="submit"><i class="fas fa-paper-plane"></i> Gui ngay</button>
                </div>
            </form>
        </div>
    </div>
@endsection
