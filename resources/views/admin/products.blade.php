@extends('admin.app')

@section('content')
    <!-- Main Content Area -->
    <div class="content-area">
        <!-- Page Header -->
        <div class="page-header fade-in">
            <div class="page-title">
                <h1>Quản lý Sản phẩm</h1>
                <p>Tổng quan và quản lý danh mục sản phẩm của cửa hàng</p>
            </div>
            <div class="header-actions">
                <button class="btn btn-secondary">
                    <i class="fas fa-file-export"></i> Xuất Excel
                </button>
                <button class="btn btn-primary" id="addProductBtn">
                    <i class="fas fa-plus"></i> Thêm sản phẩm
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card fade-in">
                <div class="stat-header">
                    <div class="stat-icon icon-total">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="trend">
                        <i class="fas fa-arrow-up"></i> 12%
                    </div>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($totalProducts) }}</h3>
                    <p>Tổng sản phẩm</p>
                </div>
            </div>

            <div class="stat-card fade-in">
                <div class="stat-header">
                    <div class="stat-icon icon-stock">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="trend">
                        <i class="fas fa-arrow-up"></i> 8%
                    </div>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($inStockProducts) }}</h3>
                    <p>Còn hàng</p>
                </div>
            </div>

            <div class="stat-card fade-in">
                <div class="stat-header">
                    <div class="stat-icon icon-outofstock">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="trend down">
                        <i class="fas fa-arrow-down"></i> 3%
                    </div>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($outOfStockProducts) }}</h3>
                    <p>Hết hàng</p>
                </div>
            </div>

            <div class="stat-card fade-in">
                <div class="stat-header">
                    <div class="stat-icon icon-categories">
                        <i class="fas fa-tags"></i>
                    </div>
                    <div class="trend">
                        <i class="fas fa-arrow-up"></i> 5%
                    </div>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($totalCategories) }}</h3>
                    <p>Danh mục</p>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section fade-in">
            <form method="GET" action="{{ route('admin.products') }}">
                <div class="filter-group">
                    <label>Danh mục</label>
                    <select name="category" class="filter-select">
                        <option value="">Tất cả danh mục</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label>Tình trạng</label>
                    <select name="status" class="filter-select">
                        <option value="">Tất cả</option>
                        <option value="instock" {{ request('status') == 'instock' ? 'selected' : '' }}>Còn hàng</option>
                        <option value="lowstock" {{ request('status') == 'lowstock' ? 'selected' : '' }}>Sắp hết</option>
                        <option value="outofstock" {{ request('status') == 'outofstock' ? 'selected' : '' }}>Hết hàng
                        </option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Tìm kiếm</label>
                    <input type="text" name="search" value="{{ request('search') }}" class="filter-input"
                        placeholder="Tên sản phẩm, mã SKU...">
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Lọc
                    </button>
                    <a href="{{ route('admin.products') }}" class="btn btn-secondary">
                        <i class="fas fa-redo"></i> Đặt lại
                    </a>
                </div>
            </form>
        </div>

        <!-- Products Table -->
        <div class="products-container fade-in">
            <div class="section-header">
                <h2>Danh sách sản phẩm</h2>
                <div class="table-actions">
                    <button class="btn btn-secondary" onclick="location.reload()">
                        <i class="fas fa-sync-alt"></i> Làm mới
                    </button>
                </div>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Danh mục</th>
                            <th>Giá</th>
                            <th>Tồn kho</th>
                            <th>Trạng thái</th>
                            <th>Đã bán</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            @php
                                $totalStock = $product->variants->sum('stock_quantity');
                                $progressWidth = $totalStock > 0 ? min(100, ($totalStock / 100) * 100) : 0;
                                $statusClass =
                                    $totalStock > 10 ? 'instock' : ($totalStock > 0 ? 'lowstock' : 'outofstock');
                                $statusText =
                                    $totalStock > 10 ? 'Còn hàng' : ($totalStock > 0 ? 'Sắp hết' : 'Hết hàng');
                            @endphp
                            <tr>
                                <td>
                                    <div class="product-info">
                                        <div class="product-image">
                                            @if ($product->images?->first())
                                                <img src="{{ asset(images->images->first()->path) }}"
                                                    alt="{{ $product->name }}">
                                            @else
                                                <i class="fas fa-box"></i>
                                            @endif
                                        </div>
                                        <div class="product-details">
                                            <h4>{{ $product->name }}</h4>
                                            <p>SKU: {{ $product->sku }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span
                                        class="category-badge">{{ $product->category?->name ?? 'Không có danh mục' }}</span>
                                </td>
                                <td class="price">{{ number_format($product->price, 0, ',', '.') }}đ</td>
                                <td>
                                    <div class="stock-progress">
                                        <span>{{ $totalStock }}</span>
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: {{ $progressWidth }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge status-{{ $statusClass }}">
                                        {{ $statusText }}
                                    </span>
                                </td>
                                <td>{{ $product->sold ?? 0 }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn" onclick="viewProduct({{ $product->id }})">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="action-btn edit" onclick="editProduct({{ $product->id }})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn delete"
                                                onclick="return confirm('Xóa sản phẩm này?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Không có sản phẩm nào</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination">
                {{ $products->links() }}
            </div>
        </div>
    </div>

    <!-- Modal Thêm/Sửa Sản phẩm -->
    <div id="productModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Thêm sản phẩm mới</h3>
                <button class="close-modal" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form id="productForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <input type="hidden" id="productId" name="product_id">

                    <div class="form-row">
                        <div class="form-group">
                            <label>Tên sản phẩm <span class="required">*</span></label>
                            <input type="text" name="name" id="productName" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Mã SKU <span class="required">*</span></label>
                            <input type="text" name="sku" id="productSKU" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Danh mục <span class="required">*</span></label>
                            <select name="category_id" id="productCategory" class="form-control" required>
                                <option value="">Chọn danh mục</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Thương hiệu</label>
                            <input type="text" name="brand" id="productBrand" class="form-control">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Giá bán <span class="required">*</span></label>
                            <input type="number" name="price" id="productPrice" class="form-control" min="0"
                                required>
                        </div>
                        <div class="form-group">
                            <label>Giá nhập</label>
                            <input type="number" name="cost" id="productCost" class="form-control" min="0">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Số lượng tồn <span class="required">*</span></label>
                            <input type="number" name="stock" id="productStock" class="form-control" min="0"
                                required>
                        </div>
                        <div class="form-group">
                            <label>Đơn vị tính</label>
                            <input type="text" name="unit" id="productUnit" class="form-control" value="Cái">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Mô tả sản phẩm</label>
                        <textarea name="description" id="productDescription" class="form-control" rows="4"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Hình ảnh sản phẩm</label>
                        <div class="image-upload" onclick="document.getElementById('imageInput').click()">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>Kéo thả hình ảnh vào đây hoặc nhấn để chọn</p>
                            <span>Chọn từ máy tính</span>
                            <input type="file" name="images[]" id="imageInput" accept="image/*" multiple
                                style="display: none;">
                        </div>
                        <div class="image-preview" id="imagePreview"></div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="closeModal()">
                            Hủy bỏ
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Lưu sản phẩm
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // JS chỉ để mở modal và preview image
        document.getElementById('addProductBtn').addEventListener('click', function() {
            document.getElementById('modalTitle').textContent = 'Thêm sản phẩm mới';
            document.getElementById('productForm').reset();
            document.getElementById('productForm').action = '{{ route('admin.products.store') }}';
            const methodInput = document.getElementById('productForm').querySelector('[name="_method"]');
            if (methodInput) methodInput.remove();
            document.getElementById('imagePreview').innerHTML = '';
            document.getElementById('productModal').style.display = 'flex';
        });

        function editProduct(id) {
            alert('Chức năng chỉnh sửa chờ)');
        }

        function closeModal() {
            document.getElementById('productModal').style.display = 'none';
        }

        document.getElementById('imageInput').addEventListener('change', function(e) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = '';
            for (let file of e.target.files) {
                const reader = new FileReader();
                reader.onload = function(ev) {
                    const div = document.createElement('div');
                    div.className = 'preview-item';
                    div.innerHTML = `<img src="${ev.target.result}" alt="Preview">`;
                    preview.appendChild(div);
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
