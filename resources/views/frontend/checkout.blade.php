@extends('layouts.sincay')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/cart.css') }}">
@endpush

@section('content')
    <div class="container py-5 checkout-page">
        <h2 class="text-center mb-5">XÃ¡c nháº­n thÃ´ng tin giao hÃ ng</h2>

        <form action="{{ route('checkout') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Há» vÃ  tÃªn <span class="text-danger">*</span></label>
                        <input type="text" name="shipping_name" class="form-control"
                            value="{{ old('shipping_name', auth()->user()->full_name ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label>Sá»‘ Ä‘iá»‡n thoáº¡i <span class="text-danger">*</span></label>
                        <input type="text" name="shipping_phone" class="form-control"
                            value="{{ old('shipping_phone', auth()->user()->phone ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label>Äá»‹a chá»‰ giao hÃ ng <span class="text-danger">*</span></label>
                        <textarea name="shipping_address" class="form-control" rows="3" required>{{ old('shipping_address', $defaultAddressText) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Ghi chÃº</label>
                        <textarea name="note" class="form-control" rows="3">{{ old('note') }}</textarea>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="order-summary mb-4">
                        <h4 class="mb-4">
                            <i class="fas fa-shopping-cart text-primary mr-2"></i>
                            TÃ³m táº¯t Ä‘Æ¡n hÃ ng
                        </h4>

                        <div class="summary-item d-flex justify-content-between mb-2 pb-3">
                            <span>Táº¡m tÃ­nh:</span>
                            <span>{{ number_format($subtotalCents) }} Ä‘</span>
                        </div>

                        @if ($discountCents > 0)
                            <div class="summary-item d-flex justify-content-between mb-2 text-success pb-3">
                                <span>Giáº£m giÃ¡:</span>
                                <span>-{{ number_format($discountCents) }} Ä‘</span>
                            </div>
                        @endif

                        <div class="summary-item d-flex justify-content-between mb-2 pb-3">
                            <span>PhÃ­ váº­n chuyá»ƒn:</span>
                            <span>{{ number_format($shippingFeeCents) }} Ä‘</span>
                        </div>

                        <div class="summary-item d-flex justify-content-between mb-2 pb-3">
                            <span>VAT (10%):</span>
                            <span>{{ number_format($vatCents) }} Ä‘</span>
                        </div>

                        <hr>

                        <div class="summary-item d-flex justify-content-between mb-3 fw-bold pb-3">
                            <span>Tá»•ng cá»™ng:</span>
                            <span class="text-danger">{{ number_format($totalCents) }} Ä‘</span>
                        </div>
                    </div>

                    <h4 class="mb-4">
                        <i class="fas fa-credit-card text-primary mr-2"></i>
                        PhÆ°Æ¡ng thá»©c thanh toÃ¡n
                    </h4>

                    <div class="payment-methods-list">
                        <label
                            class="payment-method-item d-flex align-items-center p-3 mb-3 border rounded cursor-pointer {{ old('payment_method', 'cash') == 'cash' ? 'border-primary bg-light' : 'border-secondary' }}">
                            <input type="radio" name="payment_method" value="cash" class="form-check-input me-3"
                                {{ old('payment_method', 'cash') == 'cash' ? 'checked' : '' }} required>
                            <div class="d-flex align-items-center w-100">
                                <i class="fas fa-money-bill-wave fa-2x text-success me-3"></i>
                                <div>
                                    <strong>Tiá»n máº·t khi nháº­n hÃ ng (COD)</strong>
                                    <p class="text-muted mb-0 small pt-3">Thanh toÃ¡n trá»±c tiáº¿p cho shipper khi nháº­n hÃ ng</p>
                                </div>
                            </div>
                        </label>

                        <label
                            class="payment-method-item d-flex align-items-center p-3 mb-3 border rounded cursor-pointer {{ old('payment_method', 'cash') == 'bank_transfer' ? 'border-primary bg-light' : 'border-secondary' }}">
                            <input type="radio" name="payment_method" value="bank_transfer"
                                class="form-check-input me-3"
                                {{ old('payment_method', 'cash') == 'bank_transfer' ? 'checked' : '' }} required>
                            <div class="d-flex align-items-center w-100">
                                <i class="fas fa-university fa-2x text-primary me-3"></i>
                                <div>
                                    <strong>Chuyá»ƒn khoáº£n ngÃ¢n hÃ ng</strong>
                                    <p class="text-muted mb-0 small pt-3">Chuyá»ƒn khoáº£n trÆ°á»›c, quÃ¡n xÃ¡c nháº­n sau</p>
                                </div>
                            </div>
                        </label>

                        <label
                            class="payment-method-item d-flex align-items-center p-3 mb-3 border rounded cursor-pointer {{ old('payment_method', 'cash') == 'online' ? 'border-primary bg-light' : 'border-secondary' }}">
                            <input type="radio" name="payment_method" value="online" class="form-check-input me-3"
                                {{ old('payment_method', 'cash') == 'online' ? 'checked' : '' }} required>
                            <div class="d-flex align-items-center w-100">
                                <i class="fas fa-mobile-alt fa-2x text-info me-3"></i>
                                <div>
                                    <strong>Thanh toÃ¡n online</strong>
                                    <p class="text-muted mb-0 small pt-3">VNPay, Momo, ZaloPay, tháº» tÃ­n dá»¥ng</p>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="col-12 mt-3 checkout-actions">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">XÃ¡c nháº­n Ä‘áº·t hÃ ng</button>
                    <a href="{{ route('cart') }}" class="btn btn-secondary btn-block">Quay láº¡i giá» hÃ ng</a>
                </div>
            </div>
        </form>
    </div>
@endsection

