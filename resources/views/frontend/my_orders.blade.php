@extends('layouts.sincay')

@section('title', 'Đơn hàng của tôi')

@push('styles')
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
                        @foreach (['pending' => 'Đang chờ xử lý', 'confirmed' => 'Đã xác nhận', 'preparing' => 'Đang chuẩn bị', 'delivering' => 'Đang giao', 'completed' => 'Hoàn thành', 'cancel_requested' => 'Chờ duyệt hủy', 'cancelled' => 'Đã hủy'] as $value => $label)
                            <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>
                                {{ $label }}</option>
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
                                    <th class="py-3">Phương thức thanh toán</th>
                                    <th class="py-3 text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr data-order-id="{{ $order->id }}">
                                        <td class="fw-bold text-primary">
                                            {{ $order->order_number ?? '#' . str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-secondary rounded-pill">{{ $order->items_count }}</span>
                                        </td>
                                        <td class="fw-bold text-danger text-end">
                                            {{ number_format($order->total_amount_cents, 0, ',', '.') }}đ</td>
                                        <td data-order-status>{{ $order->status_text }}</td>
                                        <td>
                                            <span class="badge bg-light text-dark">
                                                {{ $order->payment_method_text ?? 'Tiền mặt' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('my-orders.show', $order) }}"
                                                    class="btn btn-sm btn-outline-primary" title="Xem chi tiết">
                                                    <i class="fas fa-eye"></i> Xem
                                                </a>
                                                @if (in_array($order->status, ['pending', 'confirmed'], true))
                                                    <form action="{{ route('my-orders.cancel', $order) }}" method="POST"
                                                        class="d-inline m-0 js-cancel-order-form"
                                                        data-order-id="{{ $order->id }}"
                                                        onsubmit="return confirm('Bạn có chắc chắn muốn gửi yêu cầu hủy đơn hàng này không?');">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            title="Yêu cầu hủy">
                                                            <i class="fas fa-times"></i> Yêu cầu hủy
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

                <div class="d-flex justify-content-center mt-4">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection