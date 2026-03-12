@extends('admin.app')

@section('content')
    <div class="content-area reservations-page">
        <div class="page-header fade-in">
            <div class="page-title">
                <h1>Quản lý đặt bàn</h1>
                <p>Theo dõi và xử lý yêu cầu đặt bàn của khách hàng</p>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success reservation-alert">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger reservation-alert">
                {{ session('error') }}
            </div>
        @endif

        <div id="admin-reservations-stats">
            @include('admin.partials.reservations_stats', ['stats' => $stats])
        </div>

        <div class="filter-section fade-in">
            <form method="GET" action="{{ route('admin.reservations') }}"
                class="reservations-filter-form js-admin-reservations-filter">
                <div class="filter-group">
                    <label>Trạng thái</label>
                    <select class="filter-select" name="status">
                        <option value="">Tất cả</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Chờ xác nhận
                        </option>
                        <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Đã xác nhận
                        </option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Hoàn thành
                        </option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Từ ngày</label>
                    <input type="date" class="filter-input" name="date_from" value="{{ request('date_from') }}">
                </div>

                <div class="filter-group">
                    <label>Đến ngày</label>
                    <input type="date" class="filter-input" name="date_to" value="{{ request('date_to') }}">
                </div>

                <div class="filter-group">
                    <label>Tìm kiếm</label>
                    <input type="text" class="filter-input" name="search" value="{{ request('search') }}"
                        placeholder="Tên, SDT, email...">
                </div>

                <div class="filter-actions">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-filter"></i> Lọc</button>
                    <a class="btn btn-secondary" href="{{ route('admin.reservations') }}"><i class="fas fa-redo"></i> Đặt
                        lại</a>
                </div>
            </form>
        </div>

        <div id="admin-reservations-table">
            @include('admin.partials.reservations_table', ['reservations' => $reservations])
        </div>
    </div>
@endsection
