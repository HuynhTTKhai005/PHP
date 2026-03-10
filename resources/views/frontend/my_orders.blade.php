@extends('layouts.sincay')

@section('title', 'Đơn hàng của tôi')

@push('styles')
<style>
    /* CSS cho khung cuộn đơn hàng */
    .table-scrollable-container {
        max-height: 450px; /* Chiều cao tối đa của khung cuộn */
        overflow-y: auto;
        border-radius: 8px;
    }

    /* Tùy chỉnh thanh cuộn (Scrollbar) cho đẹp giống trang giỏ hàng */
    .table-scrollable-container::-webkit-scrollbar {
        width: 8px;
    }
    .table-scrollable-container::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 4px;
    }
    .table-scrollable-container::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    .table-scrollable-container::-webkit-scrollbar-thumb:hover {
        background: #ea5313; /* Màu cam đỏ của Sincay */
    }

    /* Giữ cố định tiêu đề bảng (Header) khi cuộn xuống */
    .table-scrollable-container thead th {
        position: sticky;
        top: 0;
        background-color: #f8f9fa; /* Màu nền cho header để che đi nội dung cuộn bên dưới */
        z-index: 1;
        box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.1); /* Đổ bóng nhẹ cho header */
    }
</style>
@endpush

@section('content')
    <section class="titles text-center text-white"
        style="background: url({{ asset('assets/images/bgintro.png') }}) center/cover no-repeat; min-height: 320px;">
        <div class="container">
            <h2 class="tit">Đơn hàng của tôi</h2>
        </div>
    </section>

    <section class="section-mainmenu p-t-110 p-b-70">
        <div class="container">
            {{-- @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif --}}
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('my-orders') }}" method="GET" class="row g-3 mb-4">
                <div class="col-md-4">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                        placeholder="Tìm theo mã đơn">
                </div>
                <div class="col-md-4">
                    <select name="status" class="form-select">
                        <option value="">Tất cả trạng thái</option>
                        @foreach (['pending' => 'Đang chờ xử lý', 'confirmed' => 'Đã xác nhận', 'preparing' => 'Đang chuẩn bị', 'delivering' => 'Đang giao', 'completed' => 'Hoàn thành', 'cancelled' => 'Đã hủy'] as $value => $label)
                            <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-danger px-4">Lọc</button>
                    <a href="{{ route('my-orders') }}" class="btn btn-secondary px-4">Đặt lại</a>
                </div>
            </form>

            @if ($orders->isEmpty())
                <div class="text-center py-5 bg-white rounded shadow-sm border">
                    <i class="fas fa-box-open fa-4x text-muted mb-3 opacity-50"></i>
                    <h4>Bạn chưa có đơn hàng nào</h4>
                    <p class="text-muted">Có vẻ như bạn chưa nếm thử món mì cay trứ danh của chúng tôi.</p>
                    <a href="{{ route('menu') }}" class="btn btn-danger mt-3 px-4 rounded-pill">Đặt món ngay</a>
                </div>
            @else
                <div class="bg-white rounded shadow-sm p-3 border">
                    <div class="table-responsive table-scrollable-container">
                        <table class="table align-middle table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-3">Mã đơn</th>
                                    <th class="py-3">Ngày đặt</th>
                                    <th class="py-3 text-center">Số món</th>
                                    <th class="py-3 text-end">Tổng tiền</th>
                                    <th class="py-3">Trạng thái</th>
                                    <th class="py-3">Thanh toán</th>
                                    <th class="py-3 text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td class="fw-bold text-primary">{{ $order->order_number ?? '#' . str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-secondary rounded-pill">{{ $order->items_count }}</span>
                                        </td>
                                        <td class="fw-bold text-danger text-end">{{ number_format($order->total_amount_cents, 0, ',', '.') }}đ</td>
                                        <td>
                                            {{ $order->status_text }}
                                        </td>
                                        <td>
                                            <span class="badge {{ $order->payment_status == 'paid' ? 'bg-success' : 'bg-warning text-dark' }}">
                                                {{ $order->payment_status_text ?? 'Chưa thanh toán' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('my-orders.show', $order) }}" class="btn btn-sm btn-outline-primary" title="Xem chi tiết">
                                                    <i class="fas fa-eye"></i> Xem
                                                </a>
                                                @if (in_array($order->status, ['pending', 'confirmed'], true))
                                                    <form action="{{ route('my-orders.cancel', $order) }}" method="POST" class="d-inline m-0" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?');">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hủy đơn">
                                                            <i class="fas fa-times"></i> Hủy
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    </div>

                {{-- <div class="d-flex justify-content-center mt-4">
                    {{ $orders->links() }}
                </div> --}}
            @endif
        </div>
    </section>
@endsection