@extends('admin.app')

@section('content')
    <div class="content-area">
        <div class="section-header">
            <h2>Thêm danh mục</h2>
            <div class="table-actions">
                <a href="{{ route('admin.categories') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>

        <div class="coupons-container">
            <form method="POST" action="{{ route('admin.categories.store') }}">
                @csrf

                <div class="form-row">
                    <div class="form-group">
                        <label>Tên danh mục <span class="required">*</span></label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Slug</label>
                        <input type="text" class="form-control" name="slug" value="{{ old('slug') }}" placeholder="Để trống sẽ tự tạo từ tên">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Danh mục cha</label>
                        <select class="form-control" name="parent_id">
                            <option value="">Không có</option>
                            @foreach ($parents as $parent)
                                <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <input type="hidden" name="is_active" value="0">
                    <label>
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                        Kích hoạt danh mục
                    </label>
                </div>

                <div class="form-actions">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-save"></i> Lưu danh mục
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
