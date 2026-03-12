@extends('admin.app')

@section('content')
    <div class="content-area">
        <div class="section-header">
            <h2>Thêm mã giảm giá</h2>
            <div class="table-actions">
                <a href="{{ route('admin.coupons') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>

        <div class="coupons-container">
            <form method="POST" action="{{ route('admin.coupons.store') }}">
                @csrf

                <div class="form-row">
                    <div class="form-group">
                        <label>Mã giảm giá <span class="required">*</span></label>
                        <input type="text" class="form-control" name="code" value="{{ old('code') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Loại giảm giá <span class="required">*</span></label>
                        <select class="form-control" name="discount_type" required>
                            <option value="percent" {{ old('discount_type') === 'percent' ? 'selected' : '' }}>Phần trăm
                                (%)</option>
                            <option value="fixed" {{ old('discount_type') === 'fixed' ? 'selected' : '' }}>Cố định
                            </option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Giá trị giảm <span class="required">*</span></label>
                        <input type="number" class="form-control" min="0" name="discount_value"
                            value="{{ old('discount_value', 0) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Đơn tối thiểu (cents)</label>
                        <input type="number" class="form-control" min="0" name="min_order_total_amount_cents"
                            value="{{ old('min_order_total_amount_cents', 0) }}">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Giảm tối đa (cents)</label>
                        <input type="number" class="form-control" min="0" name="max_discount_amount_cents"
                            value="{{ old('max_discount_amount_cents') }}">
                    </div>
                    <div class="form-group">
                        <label>Giới hạn sử dụng</label>
                        <input type="number" class="form-control" min="0" name="usage_limit"
                            value="{{ old('usage_limit') }}">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Bắt đầu</label>
                        <input type="datetime-local" class="form-control" name="starts_at" value="{{ old('starts_at') }}">
                    </div>
                    <div class="form-group">
                        <label>Hết hạn</label>
                        <input type="datetime-local" class="form-control" name="expires_at"
                            value="{{ old('expires_at') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label>Mô tả</label>
                    <textarea class="form-control" rows="3" name="description">{{ old('description') }}</textarea>
                </div>

                <div class="form-group">
                    <input type="hidden" name="is_active" value="0">
                    <label>
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                        Kích hoạt mã
                    </label>
                </div>

                <div class="form-actions">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> Lưu mã giảm giá</button>
                </div>
            </form>
        </div>
    </div>
@endsection
