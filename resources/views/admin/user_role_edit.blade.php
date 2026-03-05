@extends('admin.app')

@section('content')
    <div class="content-area">
        <div class="section-header">
            <h2>Chỉnh sửa vai trò</h2>
            <div class="table-actions"><a class="btn btn-secondary" href="{{ route('admin.users', ['tab' => 'roles']) }}"><i class="fas fa-arrow-left"></i> Quay lại</a></div>
        </div>

        <div class="card products-container">
            <form method="POST" action="{{ route('admin.users.roles.update', $role) }}">
                @csrf
                @method('PUT')
                <div class="form-row">
                    <div class="form-group">
                        <label>Tên vai trò <span class="required">*</span></label>
                        <input type="text" class="form-control" name="name" value="{{ old('name', $role->name) }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Mô tả</label>
                    <textarea class="form-control" name="description" rows="3">{{ old('description', $role->description) }}</textarea>
                </div>
                <div class="form-group">
                    <label>Chọn quyền</label>
                    <div style="columns: 2; gap: 15px;">
                        @foreach($permissions as $permission)
                            <label><input type="checkbox" name="permission_ids[]" value="{{ $permission->id }}" {{ in_array($permission->id, old('permission_ids', $selectedPermissionIds)) ? 'checked' : '' }}> {{ $permission->name }}</label>
                        @endforeach
                    </div>
                </div>
                <div class="form-actions">
                    <button class="btn btn-secondary" type="button" onclick="history.back()">Hủy</button>
                    <button class="btn btn-primary" type="submit">Cập nhật vai trò</button>
                </div>
            </form>
        </div>
    </div>
@endsection