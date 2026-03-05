@extends('admin.app')

@section('content')
    <div class="content-area">
        <div class="section-header">
            <h2>Chỉnh sửa danh mục</h2>
            <div class="table-actions">
                <a href="{{ route('admin.categories') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>

        <div class="coupons-container">
            <form method="POST" action="{{ route('admin.categories.update', $category) }}">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group">
                        <label>Tên danh mục <span class="required">*</span></label>
                        <input type="text" class="form-control" name="name" value="{{ old('name', $category->name) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Slug</label>
                        <input type="text" class="form-control" name="slug" value="{{ old('slug', $category->slug) }}">
                    </div>
                </div>

                <div class="form-group">
                    <input type="hidden" name="is_active" value="0">
                    <label>
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                        Kích hoạt danh mục
                    </label>
                </div>

                <div class="form-actions">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-save"></i> Cập nhật danh mục
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection