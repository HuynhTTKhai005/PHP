@extends('admin.app')

@section('content')
    <div class="content-area">
        <div class="section-header">
            <h2>Thêm vai trò mới</h2>
            <div class="table-actions"><a class="btn btn-secondary" href="{{ route('admin.users', ['tab' => 'roles']) }}"><i class="fas fa-arrow-left"></i> Quay lai</a></div>
        </div>

        <div class="card products-container">
            <form method="POST" action="{{ route('admin.users.roles.store') }}">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label>Ten vai trò <span class="required">*</span></label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Mô tả</label>
                    <textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
                </div>
                <div class="form-group">
                    <label>Chọn quyền</label>
                    <div style="columns: 2; gap: 15px;">
                        @foreach($permissions as $permission)
                            <label><input type="checkbox" name="permission_ids[]" value="{{ $permission->id }}" {{ in_array($permission->id, old('permission_ids', [])) ? 'checked' : '' }}> {{ $permission->name }}</label>
                        @endforeach
                    </div>
                </div>
                <div class="form-actions">
                    <button class="btn btn-secondary" type="button" onclick="history.back()">Hủy</button>
                    <button class="btn btn-primary" type="submit">Lưu vai trò</button>
                </div>
            </form>
        </div>
    </div>
@endsection
