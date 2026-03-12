@extends('admin.app')

@section('content')
    <div class="content-area">
        <div class="page-header fade-in">
            <div class="page-title">
                <h1>Quản lý Mã giảm giá</h1>
                <p>Tạo và quản lý mã giảm giá, khuyến mãi cho của hàng</p>
            </div>
            <div class="header-actions">
                <a class="btn btn-primary" href="{{ route('admin.coupons.create') }}">
                    <i class="fas fa-plus"></i> Thêm mã giảm giá
                </a>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card fade-in">
                <div class="stat-header">
                    <div class="stat-icon icon-total"><i class="fas fa-tags"></i></div>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($stats['total']) }}</h3>
                    <p>Tổng mã giảm giá</p>
                </div>
            </div>

            <div class="stat-card fade-in">
                <div class="stat-header">
                    <div class="stat-icon icon-active"><i class="fas fa-check-circle"></i></div>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($stats['active']) }}</h3>
                    <p>Đang hoạt động</p>
                </div>
            </div>

            <div class="stat-card fade-in">
                <div class="stat-header">
                    <div class="stat-icon icon-expired"><i class="fas fa-exclamation-triangle"></i></div>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($stats['expired']) }}</h3>
                    <p>Đã hết hạn</p>
                </div>
            </div>

            <div class="stat-card fade-in">
                <div class="stat-header">
                    <div class="stat-icon icon-upcoming"><i class="fas fa-clock"></i></div>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($stats['upcoming']) }}</h3>
                    <p>Sắp diễn ra</p>
                </div>
            </div>
        </div>

        <div class="filter-section fade-in">
            <form method="GET" action="{{ route('admin.coupons') }}"
                style="display:flex;gap:15px;align-items:flex-end;flex-wrap:wrap;width:100%;">
                <div class="filter-group">
                    <label>Trạng thái</label>
                    <select class="filter-select" name="status">
                        <option value="">Tất cả trạng thái</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Đang hoạt động
                        </option>
                        <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Đã hết hạn
                        </option>
                        <option value="upcoming" {{ request('status') === 'upcoming' ? 'selected' : '' }}>Sắp diễn ra
                        </option>
                        <option value="disabled" {{ request('status') === 'disabled' ? 'selected' : '' }}>Đã vô hiệu hóa
                        </option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Loại giảm giá</label>
                    <select class="filter-select" name="type">
                        <option value="">Tất cả lo?i</option>
                        <option value="percent" {{ request('type') === 'percent' ? 'selected' : '' }}>Phần trăm (%)
                        </option>
                        <option value="fixed" {{ request('type') === 'fixed' ? 'selected' : '' }}>Cố định</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Tìm kiếm</label>
                    <input type="text" class="filter-input" name="search" value="{{ request('search') }}"
                        placeholder="Mã giảm giá, mô tả...">
                </div>

                <div class="filter-actions">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-filter"></i> Lọc</button>
                    <a class="btn btn-secondary" href="{{ route('admin.coupons') }}"><i class="fas fa-redo"></i> D?t
                        l?i</a>
                </div>
            </form>
        </div>

        <div class="coupons-container fade-in">
            <div class="section-header">
                <h2>Danh sách mã giảm giá</h2>
                <div class="table-actions">
                    <a class="btn btn-secondary" style="padding: 8px 16px; font-size: 13px;"
                        href="{{ route('admin.coupons', request()->query()) }}">
                        <i class="fas fa-sync-alt"></i> Làm mới
                    </a>
                </div>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Mã giảm giá</th>
                            <th>Mô tả</th>
                            <th>Loại giảm giá</th>
                            <th>Giá trị</th>
                            <th>Trạng thái</th>
                            <th>Sử dụng</th>
                            <th>Hạn sử dụng</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($coupons as $coupon)
                            <tr>
                                <td>
                                    <div class="coupon-code">{{ $coupon->code }}</div>
                                    <small style="color: var(--gray); font-size: 12px;">ID: {{ $coupon->id }}</small>
                                </td>
                                <td>
                                    <div style="font-weight: 600;">{{ $coupon->description ?: '-' }}</div>
                                </td>
                                <td><span class="type-badge">{{ $coupon->type_text }}</span></td>
                                <td>{{ $coupon->discount_display }}</td>
                                <td><span class="status-badge {{ $coupon->status_class }}">{{ $coupon->status_text }}</span></td>
                                <td>
                                    <span>{{ $coupon->usage_display }}</span>
                                    @if ($coupon->usage_percentage > 0)
                                        <div class="progress-bar" style="margin-top:5px;">
                                            <div class="progress-fill" style="width: {{ $coupon->usage_percentage }}%"></div>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div>{{ $coupon->starts_at?->format('d/m/Y H:i') ?: '-' }}</div>
                                    <div style="color: var(--gray); font-size: 12px;">
                                        {{ $coupon->expires_at?->format('d/m/Y H:i') ?: 'Không giới hạn' }}</div>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a class="action-btn view" title="Xem"
                                            href="{{ route('admin.coupons.show', array_merge(['coupon' => $coupon->id], request()->query())) }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('admin.coupons.toggleStatus', $coupon) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button class="action-btn {{ $coupon->is_active ? 'edit' : 'view' }}"
                                                type="submit"
                                                title="{{ $coupon->is_active ? 'Tắt hoạt động' : 'Bật ho?t d?ng' }}">
                                                <i
                                                    class="fas {{ $coupon->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                            </button>
                                        </form>
                                        <a class="action-btn edit" title="Sửa"
                                            href="{{ route('admin.coupons.edit', $coupon) }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST"
                                            class="js-delete-coupon-form" data-coupon-code="{{ $coupon->code }}"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="action-btn delete" type="submit" title="Xóa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Không có dữ liệu mã giảm giá</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                <div class="pagination-info">
                    Hiển thị <strong>{{ $coupons->firstItem() ?? 0 }}-{{ $coupons->lastItem() ?? 0 }}</strong> của
                    <strong>{{ $coupons->total() }}</strong> mã giảm giá
                </div>
                <div class="pagination-controls">
                    {{ $coupons->links() }}
                </div>
            </div>
        </div>
    </div>

    <div id="couponModal" class="modal" style="display: {{ $selectedCoupon ? 'flex' : 'none' }};">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Chi tiết mã giảm giá</h3>
                <a href="{{ route('admin.coupons', request()->query()) }}" class="close-modal">&times;</a>
            </div>
            @if ($selectedCoupon)
                <div class="modal-body">
                    <div class="coupon-preview" id="couponPreview">
                        <div class="coupon-preview-content">
                            <h3>{{ $selectedCoupon->code }}</h3>
                            <p>{{ $selectedCoupon->description ?: '-' }}</p>
                        </div>
                        <div class="coupon-preview-discount">
                            <div class="amount">{{ $selectedCoupon->discount_display }}</div>
                            <div class="type">{{ $selectedCoupon->type_text }}</div>
                        </div>
                    </div>

                    <div class="customer-details-grid">
                        <div class="detail-group">
                            <label>Trạng thái</label>
                            <p><span
                                    class="status-badge {{ $selectedCoupon->status_class }}">{{ $selectedCoupon->status_text }}</span>
                            </p>
                        </div>
                        <div class="detail-group">
                            <label>Đơn tối thiểu</label>
                            <p>{{ number_format($selectedCoupon->min_order_total_amount_cents, 0, ',', '.') }}d</p>
                        </div>
                        <div class="detail-group">
                            <label>Giảm tối đa</label>
                            <p>{{ $selectedCoupon->max_discount_amount_cents ? number_format($selectedCoupon->max_discount_amount_cents, 0, ',', '.') . 'd' : '-' }}
                            </p>
                        </div>
                        <div class="detail-group">
                            <label>Sử dụng</label>
                            <p>{{ $selectedCoupon->usage_display }}</p>
                        </div>
                    </div>

                    <div class="orders-list">
                        @forelse($selectedCoupon->orderCoupons as $orderCoupon)
                            <div class="order-item">
                                <div class="order-info">
                                    <h4>{{ $orderCoupon->order?->order_number ?: 'Không có don' }}</h4>
                                    <p>{{ $orderCoupon->created_at?->format('d/m/Y H:i') }}</p>
                                </div>
                                <div class="order-amount">{{ number_format($orderCoupon->discount_amount_cents, 0, ',', '.') }}
                                    d</div>
                            </div>
                        @empty
                            <div class="order-item">
                                <div class="order-info">
                                    <h4>Chưa có lịch sử sử dụng</h4>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <div class="modal-actions">
                        <a class="btn btn-info" href="{{ route('admin.coupons.edit', $selectedCoupon) }}"><i
                                class="fas fa-edit"></i> Chỉnh sửa</a>
                        <form action="{{ route('admin.coupons.destroy', $selectedCoupon) }}" method="POST"
                            class="js-delete-coupon-form" data-coupon-code="{{ $selectedCoupon->code }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit"><i class="fas fa-trash"></i> Xóa</button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
