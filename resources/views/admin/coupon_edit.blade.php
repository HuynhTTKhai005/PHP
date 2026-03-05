@extends('admin.app')

@section('content')
    <div class="content-area">
        <div class="section-header">
            <h2>Chỉnh sửa mã giảm giá</h2>
            <div class="table-actions">
                <a href="{{ route('admin.coupons.show', $coupon) }}" class="btn btn-secondary">
                    <i class="fas fa-eye"></i> Xem chi tiết
                </a>
                <a href="{{ route('admin.coupons') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>

        <div class="coupons-container">
            <form method="POST" action="{{ route('admin.coupons.update', $coupon) }}">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group">
                        <label>Mã giảm giá <span class="required">*</span></label>
                        <input type="text" class="form-control" name="code" value="{{ old('code', $coupon->code) }}"
                            required>
                    </div>
                    <div class="form-group">
                        <label>Loại giảm giá <span class="required">*</span></label>
                        <select class="form-control" name="discount_type" required>
                            <option value="percent"
                                {{ old('discount_type', $coupon->discount_type) === 'percent' ? 'selected' : '' }}>Phần
                                trăm (%)</option>
                            <option value="fixed"
                                {{ old('discount_type', $coupon->discount_type) === 'fixed' ? 'selected' : '' }}>Cố định
                            </option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Giá trị giảm <span class="required">*</span></label>
                        <input type="number" class="form-control" min="0" name="discount_value"
                            value="{{ old('discount_value', $coupon->discount_value) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Đơn tối thiểu (cents)</label>
                        <input type="number" class="form-control" min="0" name="min_order_total_amount_cents"
                            value="{{ old('min_order_total_amount_cents', $coupon->min_order_total_amount_cents) }}">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Giảm tối đa (cents)</label>
                        <input type="number" class="form-control" min="0" name="max_discount_amount_cents"
                            value="{{ old('max_discount_amount_cents', $coupon->max_discount_amount_cents) }}">
                    </div>
                    <div class="form-group">
                        <label>Giới hạn sử dụng</label>
                        <input type="number" class="form-control" min="0" name="usage_limit"
                            value="{{ old('usage_limit', $coupon->usage_limit) }}">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Số lần đã dùng</label>
                        <input type="number" class="form-control" min="0" name="used_count"
                            value="{{ old('used_count', $coupon->used_count) }}">
                    </div>
                    <div class="form-group">
                        <label>Kích hoạt</label>
                        <div style="padding-top: 12px;">
                            <input type="hidden" name="is_active" value="0">
                            <label>
                                <input type="checkbox" name="is_active" value="1"
                                    {{ old('is_active', (int) $coupon->is_active) ? 'checked' : '' }}>
                                Đang hoạt động
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Bắt đầu</label>
                        <input type="datetime-local" class="form-control" name="starts_at"
                            value="{{ old('starts_at', optional($coupon->starts_at)->format('Y-m-d\\TH:i')) }}">
                    </div>
                    <div class="form-group">
                        <label>Hết hạn</label>
                        <input type="datetime-local" class="form-control" name="expires_at"
                            value="{{ old('expires_at', optional($coupon->expires_at)->format('Y-m-d\\TH:i')) }}">
                    </div>
                </div>

                <div class="form-group">
                    <label>Mô tả</label>
                    <textarea class="form-control" rows="3" name="description">{{ old('description', $coupon->description) }}</textarea>
                </div>

                <div class="form-actions">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> Cập nhật mã giảm giá</button>
                </div>
            </form>
        </div>
    </div>
@endsection
