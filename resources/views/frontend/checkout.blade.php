    @extends('layouts.pato')

    @section('content')
        <div class="container py-5">
            <h2 class="text-center mb-5">Xác nhận thông tin giao hàng</h2>

            <form action="{{ route('checkout') }}" method="POST">
                @csrf
                <div class="row">
                    <!-- Form thông tin -->
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" name="shipping_name" class="form-control" value="{{ old('shipping_name') }}"
                                required>
                        </div>
                        <div class="form-group">
                            <label>Số điện thoại <span class="text-danger">*</span></label>
                            <input type="text" name="shipping_phone" class="form-control"
                                value="{{ old('shipping_phone') }}" required>
                        </div>
                        <div class="form-group">
                            <label>Địa chỉ giao hàng <span class="text-danger">*</span></label>
                            <textarea name="shipping_address" class="form-control" rows="3" required>{{ old('shipping_address') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Ghi chú</label>
                            <textarea name="note" class="form-control" rows="3">{{ old('note') }}</textarea>
                        </div>
                    </div>

                    <!-- Phương thức thanh toán -->
                    <div class="col-lg-6">
                        <div class="mt-5">
                            <h4 class="mb-4">
                                <i class="fas fa-credit-card text-primary mr-2"></i>
                                Phương thức thanh toán
                            </h4>

                            <div class="payment-methods-list">
                                <!-- Tiền mặt khi nhận hàng (COD) - Mặc định chọn -->
                                <label
                                    class="payment-method-item d-flex align-items-center p-3 mb-3 border rounded cursor-pointer {{ old('payment_method', 'cash') == 'cash' ? 'border-primary bg-light' : 'border-secondary' }}">
                                    <input type="radio" name="payment_method" value="cash" class="form-check-input me-3"
                                        {{ old('payment_method', 'cash') == 'cash' ? 'checked' : '' }} required>
                                    <div class="d-flex align-items-center w-100">
                                        <i class="fas fa-money-bill-wave fa-2x text-success me-3"></i>
                                        <div>
                                            <strong>Tiền mặt khi nhận hàng (COD)</strong>
                                            <p class="text-muted mb-0 small">Thanh toán trực tiếp cho shipper khi nhận hàng
                                            </p>
                                        </div>
                                    </div>
                                </label>

                                <!-- Chuyển khoản ngân hàng -->
                                <label
                                    class="payment-method-item d-flex align-items-center p-3 mb-3 border rounded cursor-pointer {{ old('payment_method', 'cash') == 'bank_transfer' ? 'border-primary bg-light' : 'border-secondary' }}">
                                    <input type="radio" name="payment_method" value="bank_transfer"
                                        class="form-check-input me-3"
                                        {{ old('payment_method', 'cash') == 'bank_transfer' ? 'checked' : '' }} required>
                                    <div class="d-flex align-items-center w-100">
                                        <i class="fas fa-university fa-2x text-primary me-3"></i>
                                        <div>
                                            <strong>Chuyển khoản ngân hàng</strong>
                                            <p class="text-muted mb-0 small">Chuyển khoản trước, quán xác nhận sau</p>
                                        </div>
                                    </div>
                                </label>

                                <!-- Thanh toán online (VNPay, Momo, ZaloPay...) -->
                                <label
                                    class="payment-method-item d-flex align-items-center p-3 mb-3 border rounded cursor-pointer {{ old('payment_method', 'cash') == 'online' ? 'border-primary bg-light' : 'border-secondary' }}">
                                    <input type="radio" name="payment_method" value="online" class="form-check-input me-3"
                                        {{ old('payment_method', 'cash') == 'online' ? 'checked' : '' }} required>
                                    <div class="d-flex align-items-center w-100">
                                        <i class="fas fa-mobile-alt fa-2x text-info me-3"></i>
                                        <div>
                                            <strong>Thanh toán online</strong>
                                            <p class="text-muted mb-0 small">VNPay, Momo, ZaloPay, thẻ tín dụng</p>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <!-- Thông báo nhỏ -->
                            <div class="alert alert-info mt-3 small">
                                <i class="fas fa-info-circle mr-2"></i>
                                Với thanh toán online, bạn sẽ được chuyển hướng đến cổng thanh toán an toàn sau khi xác
                                nhận.
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg btn-block">Xác nhận đặt hàng</button>
                        <a href="{{ route('cart') }}" class="btn btn-secondary btn-block">Quay lại giỏ hàng</a>
                    </div>
                </div>
            </form>
        </div>
    @endsection
