@extends('admin.app')

@section('content')
    <div class="content-area products-show-page">
        <div class="section-header">
            <h2>Chi tiết sản phẩm</h2>
            <div class="table-actions">
                <a href="{{ route('admin.products') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Chỉnh sửa
                    </a>
                @endif
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success reservation-alert">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger reservation-alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="products-container">
            <div class="table-container">
                <table>
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <td>{{ $product->id }}</td>
                        </tr>
                        <tr>
                            <th>Tên</th>
                            <td>{{ $product->name }}</td>
                        </tr>
                        <tr>
                            <th>Slug</th>
                            <td>{{ $product->slug }}</td>
                        </tr>
                        <tr>
                            <th>Danh mục</th>
                            <td>{{ $product->category?->name ?? 'Không có' }}</td>
                        </tr>
                        <tr>
                            <th>Giá</th>
                            <td>{{ number_format($product->base_price_cents, 0, ',', '.') }}đ</td>
                        </tr>
                        <tr>
                            <th>Tồn kho sản phẩm</th>
                            <td>{{ (int) $product->stock }}</td>
                        </tr>
                        <tr>
                            <th>Tồn kho biến thể mặc định</th>
                            <td>{{ (int) ($defaultVariant?->stock_quantity ?? 0) }}</td>
                        </tr>
                        <tr>
                            <th>Loại</th>
                            <td>{{ $product->type ?? 'Không có' }}</td>
                        </tr>
                        <tr>
                            <th>Cay</th>
                            <td>{{ $product->is_spicy ? 'Có' : 'Không' }}</td>
                        </tr>
                        <tr>
                            <th>Hiển thị</th>
                            <td>{{ $product->is_available ? 'Có' : 'Không' }}</td>
                        </tr>
                        <tr>
                            <th>Mô tả</th>
                            <td>{{ $product->description ?: 'Không có' }}</td>
                        </tr>
                        <tr>
                            <th>Ảnh</th>
                            <td>
                                @if ($product->image_url)
                                    <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}"
                                        class="product-show-image">
                                @else
                                    Không có
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="products-container product-show-stockin">
            <div class="section-header">
                <h2>Nhập hàng vào kho (IN)</h2>
            </div>
            <form method="POST" action="{{ route('admin.products.stockIn', $product) }}" class="users-create-form">
                @csrf
                <div class="users-create-grid">
                    <div class="form-group">
                        <label>Số lượng nhập</label>
                        <input type="number" min="1" name="quantity" class="filter-input" required>
                    </div>
                    <div class="form-group">
                        <label>Lý do</label>
                        <input type="text" name="reason" class="filter-input" placeholder="nhap_hang_ncc">
                    </div>
                    <div class="form-group">
                        <label>Ghi chú</label>
                        <input type="text" name="note" class="filter-input" placeholder="Ghi chú nhập kho">
                    </div>
                </div>
                <div class="users-create-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> Nhập kho
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
