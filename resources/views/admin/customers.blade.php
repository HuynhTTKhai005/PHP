@extends('admin.app')

@section('content')
    <div class="content-area">
        <div class="page-header fade-in">
            <div class="page-title">
                <h1>Quản lý khách hàng</h1>
                <p>Quản lý thông tin và tương tác với khách hàng</p>
            </div>
            <div class="header-actions">
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.customers.create') }}" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i>
                    </a>
                @endif
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card total fade-in">
                <div class="stat-header">
                    <div class="stat-icon icon-total">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($stats['total']) }}</h3>
                    <p>Tổng khách hàng</p>
                </div>
            </div>

            <div class="stat-card new fade-in">
                <div class="stat-header">
                    <div class="stat-icon icon-new">
                        <i class="fas fa-user-plus"></i>
                    </div>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($stats['new']) }}</h3>
                    <p>Khách hàng mới (tháng)</p>
                </div>
            </div>

            <div class="stat-card vip fade-in">
                <div class="stat-header">
                    <div class="stat-icon icon-vip">
                        <i class="fas fa-crown"></i>
                    </div>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($stats['vip']) }}</h3>
                    <p>Khách hàng VIP</p>
                </div>
            </div>

            <div class="stat-card inactive fade-in">
                <div class="stat-header">
                    <div class="stat-icon icon-inactive">
                        <i class="fas fa-user-slash"></i>
                    </div>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($stats['inactive']) }}</h3>
                    <p>Không hoạt động</p>
                </div>
            </div>
        </div>

        <div class="segments-section fade-in">
            <div class="section-header">
                <h2>Thống kê phân khúc khách hàng</h2>
            </div>
            <div class="segments-grid">
                <a class="segment-card" href="{{ route('admin.customers', array_merge(request()->query(), ['segment' => 'vip'])) }}">
                    <div class="segment-icon segment-vip"><i class="fas fa-crown"></i></div>
                    <div class="segment-info">
                        <h4>VIP</h4>
                        <p>{{ number_format($stats['segments']['vip']) }}</p>
                    </div>
                </a>
                <a class="segment-card" href="{{ route('admin.customers', array_merge(request()->query(), ['segment' => 'regular'])) }}">
                    <div class="segment-icon segment-regular"><i class="fas fa-user"></i></div>
                    <div class="segment-info">
                        <h4>Thường xuyên</h4>
                        <p>{{ number_format($stats['segments']['regular']) }}</p>
                    </div>
                </a>
                <a class="segment-card" href="{{ route('admin.customers', array_merge(request()->query(), ['segment' => 'new'])) }}">
                    <div class="segment-icon segment-new"><i class="fas fa-user-plus"></i></div>
                    <div class="segment-info">
                        <h4>Mới</h4>
                        <p>{{ number_format($stats['segments']['new']) }}</p>
                    </div>
                </a>
                <a class="segment-card" href="{{ route('admin.customers', array_merge(request()->query(), ['segment' => 'loyal'])) }}">
                    <div class="segment-icon segment-loyal"><i class="fas fa-heart"></i></div>
                    <div class="segment-info">
                        <h4>Trung thành</h4>
                        <p>{{ number_format($stats['segments']['loyal']) }}</p>
                    </div>
                </a>
                <a class="segment-card" href="{{ route('admin.customers', array_merge(request()->query(), ['segment' => 'inactive'])) }}">
                    <div class="segment-icon segment-inactive"><i class="fas fa-user-slash"></i></div>
                    <div class="segment-info">
                        <h4>Không hoạt động</h4>
                        <p>{{ number_format($stats['segments']['inactive']) }}</p>
                    </div>
                </a>
            </div>
        </div>

        <div class="filter-section fade-in">
            <form method="GET" action="{{ route('admin.customers') }}" style="display:flex;gap:15px;align-items:flex-end;flex-wrap:wrap;width:100%;">
                <div class="filter-group">
                    <label>Phân khúc</label>
                    <select class="filter-select" name="segment">
                        <option value="">Tất cả phân khúc</option>
                        <option value="vip" {{ request('segment') === 'vip' ? 'selected' : '' }}>VIP</option>
                        <option value="regular" {{ request('segment') === 'regular' ? 'selected' : '' }}>Thường xuyên</option>
                        <option value="new" {{ request('segment') === 'new' ? 'selected' : '' }}>Mới</option>
                        <option value="loyal" {{ request('segment') === 'loyal' ? 'selected' : '' }}>Trung thành</option>
                        <option value="inactive" {{ request('segment') === 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Trạng thái</label>
                    <select class="filter-select" name="status">
                        <option value="">Tất cả trạng thái</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Hoạt động</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
                        <option value="blocked" {{ request('status') === 'blocked' ? 'selected' : '' }}>Đã chặn</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Tìm kiếm</label>
                    <input type="text" class="filter-input" name="search" value="{{ request('search') }}" placeholder="Tên, email, SĐT...">
                </div>

                <div class="filter-actions">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-filter"></i> Lọc</button>
                    <a href="{{ route('admin.customers') }}" class="btn btn-secondary"><i class="fas fa-redo"></i> Đặt lại</a>
                </div>
            </form>
        </div>

        <div class="customers-container fade-in">
            <div class="section-header">
                <h2>Danh sách khách hàng</h2>
                <div class="table-actions">
                    <a class="btn btn-secondary" style="padding: 8px 16px; font-size: 13px;" href="{{ route('admin.customers', request()->query()) }}">
                        <i class="fas fa-sync-alt"></i> Làm mới
                    </a>
                </div>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Khách hàng</th>
                            <th>Thông tin liên hệ</th>
                            <th>Phân khúc</th>
                            <th>Trạng thái</th>
                            <th>Thống kê</th>
                            <th>Ngày tham gia</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $customer)
                            <tr>
                                <td>
                                    <div class="customer-info">
                                        <div class="customer-avatar">{{ $customer->avatar }}</div>
                                        <div class="customer-details">
                                            <h4>{{ $customer->full_name }}</h4>
                                            <p>{{ $customer->customer_code }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 600; margin-bottom: 5px;">{{ $customer->phone ?: '-' }}</div>
                                    <div style="color: var(--gray);">{{ $customer->email }}</div>
                                </td>
                                <td>
                                    <span class="segment-badge {{ $customer->segment_class }}">{{ $customer->segment_text }}</span>
                                </td>
                                <td>
                                    <span class="status-badge {{ $customer->status_class }}">{{ $customer->status_text }}</span>
                                </td>
                                <td>
                                    <div class="stats-numbers">
                                        <div><span class="number">{{ number_format($customer->total_orders) }}</span> <span class="label">đơn hàng</span></div>
                                        <div><span class="number">{{ number_format($customer->total_spent, 0, ',', '.') }}đ</span> <span class="label">tổng chi tiêu</span></div>
                                    </div>
                                </td>
                                <td>
                                    <div>{{ $customer->join_date }}</div>
                                    <div style="color: var(--gray); font-size: 12px;">{{ $customer->days_since_join }} ngày</div>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a class="action-btn view" title="Xem chi tiết" href="{{ route('admin.customers.show', array_merge(['customer' => $customer->id], request()->query())) }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if (auth()->user()->isAdmin())
                                            <a class="action-btn edit" title="Sửa" href="{{ route('admin.customers.edit', $customer) }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST" class="js-delete-customer-form" data-customer-name="{{ $customer->full_name }}" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="action-btn delete" type="submit" title="Xóa">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Không có dữ liệu khách hàng</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                <div class="pagination-info">
                    Hiển thị <strong>{{ $customers->firstItem() ?? 0 }}-{{ $customers->lastItem() ?? 0 }}</strong> của
                    <strong>{{ $customers->total() }}</strong> khách hàng
                </div>
                <div class="pagination-controls">
                    {{ $customers->links() }}
                </div>
            </div>
        </div>
    </div>

    <div id="customerModal" class="modal" style="display: {{ $selectedCustomer ? 'flex' : 'none' }};">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Thông tin khách hàng</h3>
                <a href="{{ route('admin.customers', request()->query()) }}" class="close-modal">&times;</a>
            </div>
            @if ($selectedCustomer)
                <div class="modal-body">
                    <div class="customer-details-grid">
                        <div class="detail-group">
                            <label>Khách hàng</label>
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <div id="modalAvatar" class="customer-avatar">{{ $selectedCustomer->avatar }}</div>
                                <div>
                                    <h4 id="modalName" style="font-size: 18px; margin-bottom: 5px;">{{ $selectedCustomer->full_name }}</h4>
                                    <p id="modalCustomerId" style="color: var(--gray); font-size: 13px;">{{ $selectedCustomer->customer_code }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="detail-group">
                            <label>Thông tin liên hệ</label>
                            <p id="modalPhone" style="margin-bottom: 5px;">{{ $selectedCustomer->phone ?: '-' }}</p>
                            <p id="modalEmail">{{ $selectedCustomer->email }}</p>
                        </div>
                        <div class="detail-group">
                            <label>Địa chỉ</label>
                            <p id="modalAddress">{{ $selectedCustomer->display_address }}</p>
                        </div>
                        <div class="detail-group">
                            <label>Phân loại</label>
                            <div style="display: flex; gap: 10px; margin-top: 10px;">
                                <span id="modalSegment" class="segment-badge {{ $selectedCustomer->segment_class }}">{{ $selectedCustomer->segment_text }}</span>
                                <span id="modalStatus" class="status-badge {{ $selectedCustomer->status_class }}">{{ $selectedCustomer->status_text }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="customer-stats">
                        <div class="customer-stat">
                            <div class="value" id="modalTotalOrders">{{ number_format($selectedCustomer->total_orders) }}</div>
                            <div class="label">Tổng đơn hàng</div>
                        </div>
                        <div class="customer-stat">
                            <div class="value" id="modalTotalSpent">{{ number_format($selectedCustomer->total_spent, 0, ',', '.') }}đ</div>
                            <div class="label">Tổng chi tiêu</div>
                        </div>
                        <div class="customer-stat">
                            <div class="value" id="modalAvgOrder">{{ number_format($selectedCustomer->avg_order, 0, ',', '.') }}đ</div>
                            <div class="label">Giá trị TB/đơn</div>
                        </div>
                        <div class="customer-stat">
                            <div class="value" id="modalLastOrder">{{ $selectedCustomer->last_order_text }}</div>
                            <div class="label">Đơn hàng cuối</div>
                        </div>
                    </div>

                    <div class="tabs">
                        <button class="tab active" type="button">Đơn hàng</button>
                    </div>

                    <div id="ordersTab" class="tab-content active">
                        <div class="orders-list" id="ordersList">
                            @forelse($selectedCustomerOrders as $order)
                                <div class="order-item">
                                    <div class="order-info">
                                        <h4>{{ $order->order_number }}</h4>
                                        <p>{{ $order->created_at?->format('d/m/Y H:i') }} - {{ $order->status_text }}</p>
                                    </div>
                                    <div style="display:flex; align-items:center; gap:10px;">
                                        <div class="order-amount">{{ number_format($order->total_amount_cents, 0, ',', '.') }}đ</div>
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-secondary" style="padding: 6px 10px; font-size: 12px;">
                                            Xem thêm
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="order-item">
                                    <div class="order-info">
                                        <h4>Chưa có đơn hàng</h4>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    @if (auth()->user()->isAdmin())
                        <div class="modal-actions">
                            <a class="btn btn-info" href="{{ route('admin.customers.edit', $selectedCustomer->id) }}">
                                <i class="fas fa-edit"></i> Chỉnh sửa
                            </a>
                            <form action="{{ route('admin.customers.destroy', $selectedCustomer->id) }}" method="POST" class="js-delete-customer-form" data-customer-name="{{ $selectedCustomer->full_name }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">
                                    <i class="fas fa-trash"></i> Xóa
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
@endsection