@extends('admin.app')

@section('content')
    <div class="content-area">
        <div class="section-header">
            <h2>Chỉnh sửa sản phẩm</h2>
            <div class="table-actions">
                <a href="{{ route('admin.products.show', $product) }}" class="btn btn-secondary">
                    <i class="fas fa-eye"></i> Xem chi tiết
                </a>
                <a href="{{ route('admin.products') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>

        <div class="products-container">
            <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group">
                        <label>Tên sản phẩm <span class="required">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}"
                            required>
                    </div>
                    <div class="form-group">
                        <label>Danh mục</label>
                        <select name="category_id" class="form-control">
                            <option value="">Chọn danh mục</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ (string) old('category_id', $product->category_id) === (string) $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Giá <span class="required">*</span></label>
                        <input type="number" name="base_price_cents" class="form-control" min="0"
                            value="{{ old('base_price_cents', $product->base_price_cents) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Số lượng tồn <span class="required">*</span></label>
                        <input type="number" name="stock" class="form-control" min="0"
                            value="{{ old('stock', $product->stock) }}" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Loại</label>
                        <select name="type" class="form-control">
                            <option value="">Không chọn</option>
                            <option value="food" {{ old('type', $product->type) === 'food' ? 'selected' : '' }}>Food
                            </option>
                            <option value="drink" {{ old('type', $product->type) === 'drink' ? 'selected' : '' }}>Drink
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Ảnh sản phẩm (upload từ máy)</label>
                        <input type="file" name="image_file" class="form-control" accept="image/*">
                    </div>
                </div>

                <div class="form-group">
                    <label>Hoặc nhập URL ảnh</label>
                    <input type="text" name="image_url" class="form-control"
                        value="{{ old('image_url', $product->image_url) }}" placeholder="Ví dụ: assets/images/product.jpg">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="is_spicy" value="1"
                                {{ old('is_spicy', $product->is_spicy) ? 'checked' : '' }}>
                            Có cay
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="is_available" value="1"
                                {{ old('is_available', $product->is_available) ? 'checked' : '' }}>
                            Đang bán
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Mô tả</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Cập nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
