@extends('layouts.sincay')

@section('title', 'Đơn hàng của tôi')

@section('content')
    <section class="titles text-center text-white"
        style="background: url({{ asset('assets/images/bgintro.png') }}) center/cover no-repeat; min-height: 320px;">
        <div class="container">
            <h2 class="tit">Đơn hàng của tôi</h2>
        </div>
    </section>

    <section class="section-mainmenu p-t-110 p-b-70  ">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('my-orders') }}" method="GET" class="row g-3 mb-4">
                <div class="col-md-4">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                        placeholder="Tìm theo mã đơn">
                </div>
                <div class="col-md-4">
                    <select name="status" class="form-control">
                        <option value="">Tất cả trạng thái</option>
                        @foreach (['pending' => 'Đang chờ xử lý', 'confirmed' => 'Đã xác nhận', 'preparing' => 'Đang chuẩn bị', 'delivering' => 'Đang giao', 'completed' => 'Hoàn thành', 'cancelled' => 'Đã hủy'] as $value => $label)
                            <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-danger">Lọc</button>
                    <a href="{{ route('my-orders') }}" class="btn btn-secondary">Đặt lại</a>
                </div>
            </form>

            @if ($orders->isEmpty())
                <div class="text-center py-5">
                    <h4>Bạn chưa có đơn hàng nào</h4>
                    <a href="{{ route('menu') }}" class="btn btn-danger mt-3">Đặt món ngay</a>
                </div>
            @else
                <div class="table-responsive bg-white rounded shadow-sm p-3">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>M? don</th>
                                <th>Ngày đặt</th>
                                <th>Số món</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Thanh toán</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->order_number ?? '#' . str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $order->items_count }}</td>
                                    <td>{{ number_format($order->total_amount_cents, 0, ',', '.') }}đ</td>
                                    <td>{{ $order->status_text }}</td>
                                    <td>{{ $order->payment_status_text }}</td>
                                    <td>
                                        <a href="{{ route('my-orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Xem chi tiết</a>
                                        @if (in_array($order->status, ['pending', 'confirmed'], true))
                                            <form action="{{ route('my-orders.cancel', $order) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Hủy đơn</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection

