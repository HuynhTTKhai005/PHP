@extends('admin.app')
@section('content')
 
    <!-- Main Content Area -->
    <div class="content-area">
        <!-- Page Header -->
        <div class="page-header fade-in">
            <div class="page-title">
                <h1>Quản lý Mã Giảm Giá</h1>
                <p>Tạo và quản lý mã giảm giá, khuyến mãi cho cửa hàng</p>
            </div>
            <div class="header-actions">
                <button class="btn btn-secondary" id="exportBtn">
                    <i class="fas fa-file-export"></i> Xuất Excel
                </button>
                <button class="btn btn-purple" id="bulkCreateBtn">
                    <i class="fas fa-bolt"></i> Tạo hàng loạt
                </button>
                <button class="btn btn-primary" id="addCouponBtn">
                    <i class="fas fa-plus"></i> Thêm mã giảm giá
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card fade-in">
                <div class="stat-header">
                    <div class="stat-icon icon-total">
                        <i class="fas fa-tags"></i>
                    </div>
                    <div class="trend">
                        <i class="fas fa-arrow-up"></i> 15%
                    </div>
                </div>
                <div class="stat-content">
                    <h3 id="totalCoupons">48</h3>
                    <p>Tổng mã giảm giá</p>
                </div>
            </div>
            
            <div class="stat-card fade-in">
                <div class="stat-header">
                    <div class="stat-icon icon-active">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="trend">
                        <i class="fas fa-arrow-up"></i> 8%
                    </div>
                </div>
                <div class="stat-content">
                    <h3 id="activeCoupons">32</h3>
                    <p>Đang hoạt động</p>
                </div>
            </div>
            
            <div class="stat-card fade-in">
                <div class="stat-header">
                    <div class="stat-icon icon-expired">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="trend down">
                        <i class="fas fa-arrow-down"></i> 3%
                    </div>
                </div>
                <div class="stat-content">
                    <h3 id="expiredCoupons">12</h3>
                    <p>Đã hết hạn</p>
                </div>
            </div>
            
            <div class="stat-card fade-in">
                <div class="stat-header">
                    <div class="stat-icon icon-upcoming">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="trend">
                        <i class="fas fa-arrow-up"></i> 5%
                    </div>
                </div>
                <div class="stat-content">
                    <h3 id="upcomingCoupons">4</h3>
                    <p>Sắp diễn ra</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions fade-in">
            <div class="quick-action-btn" onclick="generateRandomCoupon()">
                <i class="fas fa-random"></i>
                <span>Tạo mã ngẫu nhiên</span>
            </div>
            <div class="quick-action-btn" onclick="copyAllActiveCodes()">
                <i class="fas fa-copy"></i>
                <span>Sao chép mã đang hoạt động</span>
            </div>
            <div class="quick-action-btn" onclick="exportToClipboard()">
                <i class="fas fa-clipboard"></i>
                <span>Xuất danh sách mã</span>
            </div>
            <div class="quick-action-btn" onclick="disableExpiredCoupons()">
                <i class="fas fa-ban"></i>
                <span>Vô hiệu hóa mã hết hạn</span>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section fade-in">
            <div class="filter-group">
                <label>Trạng thái</label>
                <select class="filter-select" id="statusFilter">
                    <option value="">Tất cả trạng thái</option>
                    <option value="active">Đang hoạt động</option>
                    <option value="expired">Đã hết hạn</option>
                    <option value="upcoming">Sắp diễn ra</option>
                    <option value="disabled">Đã vô hiệu hóa</option>
                </select>
            </div>
            
            <div class="filter-group">
                <label>Loại giảm giá</label>
                <select class="filter-select" id="typeFilter">
                    <option value="">Tất cả loại</option>
                    <option value="percentage">Phần trăm (%)</option>
                    <option value="fixed">Giảm giá cố định</option>
                    <option value="free_shipping">Miễn phí vận chuyển</option>
                </select>
            </div>
            
            <div class="filter-group">
                <label>Tìm kiếm</label>
                <input type="text" class="filter-input" id="searchInput" placeholder="Mã giảm giá, tên...">
            </div>
            
            <div class="filter-actions">
                <button class="btn btn-primary" onclick="applyFilters()">
                    <i class="fas fa-filter"></i> Lọc
                </button>
                <button class="btn btn-secondary" onclick="resetFilters()">
                    <i class="fas fa-redo"></i> Đặt lại
                </button>
            </div>
        </div>

        <!-- Coupons Table -->
        <div class="coupons-container fade-in">
            <div class="section-header">
                <h2>Danh sách mã giảm giá</h2>
                <div class="table-actions">
                    <button class="btn btn-secondary" style="padding: 8px 16px; font-size: 13px;" onclick="refreshCoupons()">
                        <i class="fas fa-sync-alt"></i> Làm mới
                    </button>
                </div>
            </div>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Mã giảm giá</th>
                            <th>Tên</th>
                            <th>Loại giảm giá</th>
                            <th>Giá trị</th>
                            <th>Trạng thái</th>
                            <th>Sử dụng</th>
                            <th>Hạn sử dụng</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="couponsTableBody">
                        <!-- Dữ liệu sẽ được thêm bằng JavaScript -->
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="pagination">
                <div class="pagination-info">
                    Hiển thị <strong>1-10</strong> của <strong>48</strong> mã giảm giá
                </div>
                <div class="pagination-controls">
                    <button class="page-btn" onclick="changePage(-1)">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="page-btn active">1</button>
                    <button class="page-btn" onclick="changePage(2)">2</button>
                    <button class="page-btn" onclick="changePage(3)">3</button>
                    <button class="page-btn" onclick="changePage(4)">4</button>
                    <button class="page-btn" onclick="changePage(5)">5</button>
                    <button class="page-btn" onclick="changePage(1)">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Coupon Modal -->
    <div id="couponModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Thêm mã giảm giá mới</h3>
                <button class="close-modal" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body">
                <!-- Coupon Preview -->
                <div class="coupon-preview" id="couponPreview">
                    <div class="coupon-preview-content">
                        <h3 id="previewCode">SUMMER2024</h3>
                        <p id="previewDescription">Giảm giá mùa hè</p>
                    </div>
                    <div class="coupon-preview-discount">
                        <div class="amount" id="previewAmount">20%</div>
                        <div class="type" id="previewType">Giảm giá</div>
                    </div>
                </div>
                
                <form id="couponForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Mã giảm giá <span class="required">*</span></label>
                            <input type="text" class="form-control" id="couponCode" required 
                                   maxlength="20" oninput="updatePreview()">
                            <small style="color: var(--gray); margin-top: 5px; display: block;">
                                Chỉ chứa chữ in hoa, số và gạch dưới. Tối đa 20 ký tự.
                            </small>
                        </div>
                        <div class="form-group">
                            <label>Tên mã giảm giá <span class="required">*</span></label>
                            <input type="text" class="form-control" id="couponName" required 
                                   oninput="updatePreview()">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Loại giảm giá <span class="required">*</span></label>
                            <div class="discount-type">
                                <div class="type-option">
                                    <input type="radio" id="typePercentage" name="discountType" value="percentage" checked onchange="updatePreview()">
                                    <label for="typePercentage">Phần trăm (%)</label>
                                </div>
                                <div class="type-option">
                                    <input type="radio" id="typeFixed" name="discountType" value="fixed" onchange="updatePreview()">
                                    <label for="typeFixed">Giảm giá cố định</label>
                                </div>
                                <div class="type-option">
                                    <input type="radio" id="typeShipping" name="discountType" value="free_shipping" onchange="updatePreview()">
                                    <label for="typeShipping">Miễn phí vận chuyển</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row" id="discountValueRow">
                        <div class="form-group">
                            <label>Giá trị giảm <span class="required">*</span></label>
                            <div style="display: flex; gap: 10px; align-items: center;">
                                <input type="number" class="form-control" id="discountValue" min="0" step="0.01" required 
                                       oninput="updatePreview()" style="flex: 1;">
                                <span id="discountUnit" style="white-space: nowrap;">%</span>
                            </div>
                            <small style="color: var(--gray); margin-top: 5px; display: block;">
                                Đối với phần trăm: 1-100%. Đối với giảm cố định: số tiền giảm.
                            </small>
                        </div>
                        <div class="form-group">
                            <label>Giá trị đơn tối thiểu</label>
                            <input type="number" class="form-control" id="minOrderValue" min="0" step="1000">
                            <small style="color: var(--gray); margin-top: 5px; display: block;">
                                Đơn hàng tối thiểu để áp dụng mã. Để trống nếu không yêu cầu.
                            </small>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Số lần sử dụng tối đa</label>
                            <input type="number" class="form-control" id="usageLimit" min="0">
                            <small style="color: var(--gray); margin-top: 5px; display: block;">
                                Giới hạn số lần sử dụng mã. Để 0 nếu không giới hạn.
                            </small>
                        </div>
                        <div class="form-group">
                            <label>Số lần sử dụng cho mỗi người</label>
                            <input type="number" class="form-control" id="usagePerUser" min="0">
                            <small style="color: var(--gray); margin-top: 5px; display: block;">
                                Số lần tối đa mỗi khách hàng được sử dụng.
                            </small>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Ngày bắt đầu <span class="required">*</span></label>
                            <input type="datetime-local" class="form-control" id="startDate" required>
                        </div>
                        <div class="form-group">
                            <label>Ngày kết thúc</label>
                            <input type="datetime-local" class="form-control" id="endDate">
                            <small style="color: var(--gray); margin-top: 5px; display: block;">
                                Để trống nếu mã không có hạn sử dụng.
                            </small>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Mô tả</label>
                        <textarea class="form-control" id="couponDescription" rows="3" 
                                  oninput="updatePreview()"></textarea>
                    </div>
                    
                    <div class="form-check">
                        <input type="checkbox" id="isActive" checked>
                        <label for="isActive">Kích hoạt mã ngay sau khi tạo</label>
                    </div>
                    
                    <div class="form-check">
                        <input type="checkbox" id="applyToAllProducts">
                        <label for="applyToAllProducts">Áp dụng cho tất cả sản phẩm</label>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="closeModal()">
                            Hủy bỏ
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Lưu mã giảm giá
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Sample coupon data
        const sampleCoupons = [
            {
                id: 1,
                code: 'SUMMER2024',
                name: 'Giảm giá mùa hè 2024',
                type: 'percentage',
                value: 20,
                description: 'Giảm 20% cho tất cả đơn hàng trong mùa hè',
                status: 'active',
                startDate: '2024-06-01T00:00:00',
                endDate: '2024-08-31T23:59:59',
                minOrder: 0,
                usageLimit: 1000,
                usedCount: 342,
                usagePerUser: 1,
                isActive: true,
                applyToAll: true
            },
            {
                id: 2,
                code: 'FREESHIP99',
                name: 'Miễn phí vận chuyển',
                type: 'free_shipping',
                value: 0,
                description: 'Miễn phí vận chuyển cho đơn hàng từ 500k',
                status: 'active',
                startDate: '2024-01-01T00:00:00',
                endDate: '2024-12-31T23:59:59',
                minOrder: 500000,
                usageLimit: 0,
                usedCount: 1256,
                usagePerUser: 3,
                isActive: true,
                applyToAll: true
            },
            {
                id: 3,
                code: 'WELCOME50K',
                name: 'Chào mừng thành viên mới',
                type: 'fixed',
                value: 50000,
                description: 'Giảm 50k cho thành viên mới',
                status: 'active',
                startDate: '2024-01-01T00:00:00',
                endDate: null,
                minOrder: 200000,
                usageLimit: 5000,
                usedCount: 2341,
                usagePerUser: 1,
                isActive: true,
                applyToAll: true
            },
            {
                id: 4,
                code: 'BLACKFRIDAY30',
                name: 'Black Friday 30%',
                type: 'percentage',
                value: 30,
                description: 'Giảm 30% trong ngày Black Friday',
                status: 'expired',
                startDate: '2023-11-24T00:00:00',
                endDate: '2023-11-24T23:59:59',
                minOrder: 0,
                usageLimit: 2000,
                usedCount: 1987,
                usagePerUser: 1,
                isActive: false,
                applyToAll: true
            },
            {
                id: 5,
                code: 'VIPMEMBER15',
                name: 'Thành viên VIP 15%',
                type: 'percentage',
                value: 15,
                description: 'Giảm 15% cho thành viên VIP',
                status: 'active',
                startDate: '2024-01-01T00:00:00',
                endDate: null,
                minOrder: 0,
                usageLimit: 0,
                usedCount: 567,
                usagePerUser: 0,
                isActive: true,
                applyToAll: false
            },
            {
                id: 6,
                code: 'NEWYEAR2024',
                name: 'Chào năm mới 2024',
                type: 'fixed',
                value: 100000,
                description: 'Giảm 100k đón năm mới',
                status: 'expired',
                startDate: '2024-01-01T00:00:00',
                endDate: '2024-01-07T23:59:59',
                minOrder: 500000,
                usageLimit: 3000,
                usedCount: 2890,
                usagePerUser: 1,
                isActive: false,
                applyToAll: true
            },
            {
                id: 7,
                code: 'MIDYEAR25',
                name: 'Giữa năm 25%',
                type: 'percentage',
                value: 25,
                description: 'Giảm 25% giữa năm',
                status: 'upcoming',
                startDate: '2024-06-15T00:00:00',
                endDate: '2024-06-30T23:59:59',
                minOrder: 1000000,
                usageLimit: 1500,
                usedCount: 0,
                usagePerUser: 1,
                isActive: true,
                applyToAll: true
            },
            {
                id: 8,
                code: 'FLASHSALE10',
                name: 'Flash Sale 10%',
                type: 'percentage',
                value: 10,
                description: 'Giảm 10% flash sale cuối ngày',
                status: 'active',
                startDate: '2024-03-01T00:00:00',
                endDate: '2024-12-31T23:59:59',
                minOrder: 0,
                usageLimit: 0,
                usedCount: 890,
                usagePerUser: 1,
                isActive: true,
                applyToAll: true
            },
            {
                id: 9,
                code: 'BIRTHDAY20',
                name: 'Sinh nhật 20%',
                type: 'percentage',
                value: 20,
                description: 'Giảm 20% nhân dịp sinh nhật',
                status: 'disabled',
                startDate: '2024-01-01T00:00:00',
                endDate: null,
                minOrder: 0,
                usageLimit: 0,
                usedCount: 123,
                usagePerUser: 1,
                isActive: false,
                applyToAll: true
            },
            {
                id: 10,
                code: 'FIRSTORDER10',
                name: 'Đơn hàng đầu tiên 10%',
                type: 'percentage',
                value: 10,
                description: 'Giảm 10% cho đơn hàng đầu tiên',
                status: 'active',
                startDate: '2024-01-01T00:00:00',
                endDate: null,
                minOrder: 0,
                usageLimit: 10000,
                usedCount: 4567,
                usagePerUser: 1,
                isActive: true,
                applyToAll: true
            }
        ];

        // Initialize the coupon management
        document.addEventListener('DOMContentLoaded', function() {
            loadCoupons();
            setupEventListeners();
            updateStats();
            updateDiscountType();
        });

        // Load coupons into table
        function loadCoupons(coupons = sampleCoupons) {
            const tbody = document.getElementById('couponsTableBody');
            tbody.innerHTML = '';
            
            coupons.forEach(coupon => {
                const row = document.createElement('tr');
                
                // Calculate usage percentage for progress bar
                const usagePercentage = coupon.usageLimit > 0 ? 
                    Math.min(100, (coupon.usedCount / coupon.usageLimit) * 100) : 0;
                
                // Status text mapping
                const statusMap = {
                    'active': {text: 'Đang hoạt động', class: 'status-active'},
                    'expired': {text: 'Đã hết hạn', class: 'status-expired'},
                    'upcoming': {text: 'Sắp diễn ra', class: 'status-upcoming'},
                    'disabled': {text: 'Đã vô hiệu hóa', class: 'status-disabled'}
                };
                
                // Type text mapping
                const typeMap = {
                    'percentage': 'Phần trăm',
                    'fixed': 'Giảm cố định',
                    'free_shipping': 'Miễn phí vận chuyển'
                };
                
                // Format discount value
                let discountValue = '';
                if (coupon.type === 'percentage') {
                    discountValue = `${coupon.value}%`;
                } else if (coupon.type === 'fixed') {
                    discountValue = formatPrice(coupon.value) + 'đ';
                } else {
                    discountValue = 'Miễn phí VC';
                }
                
                // Format dates
                const startDate = new Date(coupon.startDate);
                const endDate = coupon.endDate ? new Date(coupon.endDate) : null;
                
                row.innerHTML = `
                    <td>
                        <div class="coupon-code">${coupon.code}</div>
                        <small style="color: var(--gray); font-size: 12px;">ID: ${coupon.id}</small>
                    </td>
                    <td>
                        <div style="font-weight: 600;">${coupon.name}</div>
                        <div style="font-size: 13px; color: var(--gray);">${coupon.description || 'Không có mô tả'}</div>
                    </td>
                    <td>
                        <span class="type-badge">${typeMap[coupon.type]}</span>
                    </td>
                    <td class="discount-amount">${discountValue}</td>
                    <td>
                        <span class="status-badge ${statusMap[coupon.status].class}">
                            ${statusMap[coupon.status].text}
                        </span>
                    </td>
                    <td>
                        <div class="usage-progress">
                            <span>${coupon.usedCount}/${coupon.usageLimit || '∞'}</span>
                            ${coupon.usageLimit > 0 ? `
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: ${usagePercentage}%"></div>
                                </div>
                            ` : ''}
                        </div>
                    </td>
                    <td>
                        <div style="font-size: 13px;">
                            <div>Từ: ${formatDate(startDate)}</div>
                            <div>Đến: ${endDate ? formatDate(endDate) : 'Không hạn'}</div>
                        </div>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-btn copy" onclick="copyCouponCode('${coupon.code}')" title="Sao chép mã">
                                <i class="fas fa-copy"></i>
                            </button>
                            <button class="action-btn edit" onclick="editCoupon(${coupon.id})" title="Sửa">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn" onclick="toggleCouponStatus(${coupon.id})" title="${coupon.isActive ? 'Vô hiệu hóa' : 'Kích hoạt'}">
                                <i class="fas fa-power-off"></i>
                            </button>
                            <button class="action-btn delete" onclick="deleteCoupon(${coupon.id})" title="Xóa">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                `;
                
                tbody.appendChild(row);
            });
        }

        // Format price with thousands separators
        function formatPrice(price) {
            return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Format date
        function formatDate(date) {
            return date.toLocaleDateString('vi-VN', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
        }

        // Update stats cards
        function updateStats(coupons = sampleCoupons) {
            const total = coupons.length;
            const active = coupons.filter(c => c.status === 'active').length;
            const expired = coupons.filter(c => c.status === 'expired').length;
            const upcoming = coupons.filter(c => c.status === 'upcoming').length;
            
            document.getElementById('totalCoupons').textContent = total;
            document.getElementById('activeCoupons').textContent = active;
            document.getElementById('expiredCoupons').textContent = expired;
            document.getElementById('upcomingCoupons').textContent = upcoming;
        }

        // Apply filters
        function applyFilters() {
            const status = document.getElementById('statusFilter').value;
            const type = document.getElementById('typeFilter').value;
            const search = document.getElementById('searchInput').value.toLowerCase();
            
            let filteredCoupons = sampleCoupons;
            
            // Filter by status
            if (status) {
                filteredCoupons = filteredCoupons.filter(coupon => coupon.status === status);
            }
            
            // Filter by type
            if (type) {
                filteredCoupons = filteredCoupons.filter(coupon => coupon.type === type);
            }
            
            // Filter by search term
            if (search) {
                filteredCoupons = filteredCoupons.filter(coupon => 
                    coupon.code.toLowerCase().includes(search) || 
                    coupon.name.toLowerCase().includes(search) ||
                    (coupon.description && coupon.description.toLowerCase().includes(search))
                );
            }
            
            loadCoupons(filteredCoupons);
            updateStats(filteredCoupons);
        }

        // Reset filters
        function resetFilters() {
            document.getElementById('statusFilter').value = '';
            document.getElementById('typeFilter').value = '';
            document.getElementById('searchInput').value = '';
            
            loadCoupons(sampleCoupons);
            updateStats(sampleCoupons);
        }

        // Copy coupon code to clipboard
        function copyCouponCode(code) {
            navigator.clipboard.writeText(code).then(() => {
                showNotification(`Đã sao chép mã: ${code}`, 'success');
            });
        }

        // Edit coupon
        function editCoupon(couponId) {
            const coupon = sampleCoupons.find(c => c.id === couponId);
            if (!coupon) return;
            
            // Set modal title
            document.getElementById('modalTitle').textContent = 'Chỉnh sửa mã giảm giá';
            
            // Populate form with coupon data
            document.getElementById('couponCode').value = coupon.code;
            document.getElementById('couponName').value = coupon.name;
            document.getElementById('couponDescription').value = coupon.description || '';
            
            // Set discount type
            document.querySelector(`input[value="${coupon.type}"]`).checked = true;
            updateDiscountType();
            
            document.getElementById('discountValue').value = coupon.value;
            document.getElementById('minOrderValue').value = coupon.minOrder || '';
            document.getElementById('usageLimit').value = coupon.usageLimit || '';
            document.getElementById('usagePerUser').value = coupon.usagePerUser || '';
            
            // Format dates for datetime-local input
            const startDate = new Date(coupon.startDate);
            document.getElementById('startDate').value = startDate.toISOString().slice(0, 16);
            
            if (coupon.endDate) {
                const endDate = new Date(coupon.endDate);
                document.getElementById('endDate').value = endDate.toISOString().slice(0, 16);
            } else {
                document.getElementById('endDate').value = '';
            }
            
            document.getElementById('isActive').checked = coupon.isActive;
            document.getElementById('applyToAllProducts').checked = coupon.applyToAll;
            
            // Update preview
            updatePreview();
            
            // Show modal
            document.getElementById('couponModal').style.display = 'flex';
            
            // Store coupon ID for update
            document.getElementById('couponForm').dataset.couponId = couponId;
        }

        // Delete coupon
        function deleteCoupon(couponId) {
            const coupon = sampleCoupons.find(c => c.id === couponId);
            if (!coupon) return;
            
            if (confirm(`Bạn có chắc chắn muốn xóa mã giảm giá "${coupon.code}"?`)) {
                // In a real app, you would make an API call to delete the coupon
                showNotification(`Đã xóa mã giảm giá: ${coupon.code}`, 'success');
                
                // Remove from sample data
                const index = sampleCoupons.findIndex(c => c.id === couponId);
                if (index > -1) {
                    sampleCoupons.splice(index, 1);
                    loadCoupons(sampleCoupons);
                    updateStats(sampleCoupons);
                }
            }
        }

        // Toggle coupon status
        function toggleCouponStatus(couponId) {
            const coupon = sampleCoupons.find(c => c.id === couponId);
            if (!coupon) return;
            
            coupon.isActive = !coupon.isActive;
            
            // Update status based on dates and active state
            const now = new Date();
            const startDate = new Date(coupon.startDate);
            const endDate = coupon.endDate ? new Date(coupon.endDate) : null;
            
            if (!coupon.isActive) {
                coupon.status = 'disabled';
            } else if (endDate && endDate < now) {
                coupon.status = 'expired';
            } else if (startDate > now) {
                coupon.status = 'upcoming';
            } else {
                coupon.status = 'active';
            }
            
            loadCoupons(sampleCoupons);
            updateStats(sampleCoupons);
            
            showNotification(
                `${coupon.isActive ? 'Kích hoạt' : 'Vô hiệu hóa'} mã: ${coupon.code}`,
                coupon.isActive ? 'success' : 'warning'
            );
        }

        // Add new coupon
        document.getElementById('addCouponBtn').addEventListener('click', function() {
            // Set modal title
            document.getElementById('modalTitle').textContent = 'Thêm mã giảm giá mới';
            
            // Reset form
            document.getElementById('couponForm').reset();
            
            // Set default values
            const now = new Date();
            const tomorrow = new Date(now);
            tomorrow.setDate(tomorrow.getDate() + 30);
            
            document.getElementById('startDate').value = now.toISOString().slice(0, 16);
            document.getElementById('endDate').value = tomorrow.toISOString().slice(0, 16);
            document.getElementById('isActive').checked = true;
            document.getElementById('applyToAllProducts').checked = true;
            
            // Generate random code
            document.getElementById('couponCode').value = generateCouponCode();
            
            // Remove coupon ID from form data
            delete document.getElementById('couponForm').dataset.couponId;
            
            // Update preview
            updatePreview();
            updateDiscountType();
            
            // Show modal
            document.getElementById('couponModal').style.display = 'flex';
        });

        // Generate random coupon code
        function generateCouponCode() {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            let code = '';
            for (let i = 0; i < 8; i++) {
                code += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            return code;
        }

        // Update discount type UI
        function updateDiscountType() {
            const type = document.querySelector('input[name="discountType"]:checked').value;
            const unitElement = document.getElementById('discountUnit');
            const valueElement = document.getElementById('discountValue');
            const minElement = document.getElementById('minOrderValue');
            const discountValueRow = document.getElementById('discountValueRow');
            
            if (type === 'percentage') {
                unitElement.textContent = '%';
                valueElement.placeholder = '0-100';
                valueElement.max = 100;
                valueElement.min = 0;
                valueElement.step = 1;
                valueElement.value = valueElement.value || '10';
            } else if (type === 'fixed') {
                unitElement.textContent = 'đ';
                valueElement.placeholder = 'Số tiền';
                valueElement.max = null;
                valueElement.min = 0;
                valueElement.step = 1000;
                valueElement.value = valueElement.value || '50000';
            } else if (type === 'free_shipping') {
                discountValueRow.style.display = 'none';
                return;
            }
            
            discountValueRow.style.display = 'grid';
        }

        // Update preview
        function updatePreview() {
            const code = document.getElementById('couponCode').value || 'NEWCODE';
            const name = document.getElementById('couponName').value || 'Mã giảm giá mới';
            const description = document.getElementById('couponDescription').value || 'Mô tả mã giảm giá';
            const type = document.querySelector('input[name="discountType"]:checked').value;
            const value = document.getElementById('discountValue').value || '0';
            
            document.getElementById('previewCode').textContent = code;
            document.getElementById('previewDescription').textContent = description;
            
            if (type === 'percentage') {
                document.getElementById('previewAmount').textContent = `${value}%`;
                document.getElementById('previewType').textContent = 'Giảm giá';
            } else if (type === 'fixed') {
                document.getElementById('previewAmount').textContent = formatPrice(value) + 'đ';
                document.getElementById('previewType').textContent = 'Giảm giá';
            } else {
                document.getElementById('previewAmount').textContent = 'FREE';
                document.getElementById('previewType').textContent = 'Vận chuyển';
            }
        }

        // Handle form submission
        document.getElementById('couponForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const couponId = this.dataset.couponId;
            const isEdit = !!couponId;
            
            // Get form values
            const couponData = {
                code: document.getElementById('couponCode').value.toUpperCase(),
                name: document.getElementById('couponName').value,
                type: document.querySelector('input[name="discountType"]:checked').value,
                value: parseFloat(document.getElementById('discountValue').value) || 0,
                description: document.getElementById('couponDescription').value,
                minOrder: parseInt(document.getElementById('minOrderValue').value) || 0,
                usageLimit: parseInt(document.getElementById('usageLimit').value) || 0,
                usagePerUser: parseInt(document.getElementById('usagePerUser').value) || 0,
                startDate: document.getElementById('startDate').value,
                endDate: document.getElementById('endDate').value || null,
                isActive: document.getElementById('isActive').checked,
                applyToAll: document.getElementById('applyToAllProducts').checked,
                usedCount: 0
            };
            
            // Validate coupon code
            if (!/^[A-Z0-9_]+$/.test(couponData.code)) {
                alert('Mã giảm giá chỉ được chứa chữ in hoa, số và gạch dưới!');
                return;
            }
            
            // Check for duplicate code (except when editing)
            if (!isEdit && sampleCoupons.some(c => c.code === couponData.code)) {
                alert('Mã giảm giá đã tồn tại! Vui lòng chọn mã khác.');
                return;
            }
            
            // Determine status based on dates
            const now = new Date();
            const startDate = new Date(couponData.startDate);
            const endDate = couponData.endDate ? new Date(couponData.endDate) : null;
            
            if (!couponData.isActive) {
                couponData.status = 'disabled';
            } else if (endDate && endDate < now) {
                couponData.status = 'expired';
            } else if (startDate > now) {
                couponData.status = 'upcoming';
            } else {
                couponData.status = 'active';
            }
            
            if (isEdit) {
                // Update existing coupon
                const index = sampleCoupons.findIndex(c => c.id === parseInt(couponId));
                if (index > -1) {
                    // Preserve some existing data
                    couponData.id = sampleCoupons[index].id;
                    couponData.usedCount = sampleCoupons[index].usedCount;
                    
                    sampleCoupons[index] = couponData;
                    showNotification('Cập nhật mã giảm giá thành công!', 'success');
                }
            } else {
                // Add new coupon
                couponData.id = sampleCoupons.length > 0 ? 
                    Math.max(...sampleCoupons.map(c => c.id)) + 1 : 1;
                sampleCoupons.push(couponData);
                showNotification('Thêm mã giảm giá thành công!', 'success');
            }
            
            // Reload coupons and update stats
            loadCoupons(sampleCoupons);
            updateStats(sampleCoupons);
            
            // Close modal
            closeModal();
        });

        // Close modal
        function closeModal() {
            document.getElementById('couponModal').style.display = 'none';
        }

        // Change page
        function changePage(pageNum) {
            showNotification(`Chuyển đến trang ${pageNum} (mô phỏng)`, 'info');
            // In a real app, you would load data for the selected page
        }

        // Refresh coupons
        function refreshCoupons() {
            loadCoupons(sampleCoupons);
            updateStats(sampleCoupons);
            showNotification('Đã làm mới danh sách mã giảm giá', 'info');
        }

        // Quick actions
        function generateRandomCoupon() {
            document.getElementById('couponCode').value = generateCouponCode();
            updatePreview();
            showNotification('Đã tạo mã ngẫu nhiên mới', 'success');
        }

        function copyAllActiveCodes() {
            const activeCodes = sampleCoupons
                .filter(c => c.status === 'active')
                .map(c => c.code)
                .join(', ');
            
            navigator.clipboard.writeText(activeCodes).then(() => {
                showNotification(`Đã sao chép ${activeCodes.split(', ').length} mã đang hoạt động`, 'success');
            });
        }

        function exportToClipboard() {
            const csv = sampleCoupons.map(c => 
                `${c.code},${c.name},${c.type},${c.value},${c.status},${c.usedCount}`
            ).join('\n');
            
            navigator.clipboard.writeText(csv).then(() => {
                showNotification('Đã xuất danh sách mã vào clipboard', 'success');
            });
        }

        function disableExpiredCoupons() {
            const now = new Date();
            let count = 0;
            
            sampleCoupons.forEach(coupon => {
                if (coupon.endDate) {
                    const endDate = new Date(coupon.endDate);
                    if (endDate < now && coupon.status !== 'disabled') {
                        coupon.status = 'expired';
                        coupon.isActive = false;
                        count++;
                    }
                }
            });
            
            if (count > 0) {
                loadCoupons(sampleCoupons);
                updateStats(sampleCoupons);
                showNotification(`Đã vô hiệu hóa ${count} mã hết hạn`, 'warning');
            } else {
                showNotification('Không có mã nào cần vô hiệu hóa', 'info');
            }
        }

        // Show notification
        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML = `
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'}"></i>
                    <span>${message}</span>
                </div>
            `;
            
            // Style the notification
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 15px 25px;
                background: ${type === 'success' ? '#2ecc71' : type === 'warning' ? '#f39c12' : '#3498db'};
                color: white;
                border-radius: var(--radius-sm);
                box-shadow: var(--shadow-lg);
                z-index: 2000;
                animation: slideIn 0.3s ease;
            `;
            
            // Add to document
            document.body.appendChild(notification);
            
            // Remove after 3 seconds
            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Setup event listeners
        function setupEventListeners() {
            // Search on Enter key
            document.getElementById('searchInput').addEventListener('keyup', function(e) {
                if (e.key === 'Enter') {
                    applyFilters();
                }
            });
            
            // Close modal on ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeModal();
                }
            });
            
            // Close modal when clicking outside
            document.getElementById('couponModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal();
                }
            });
            
            // Update discount type when changed
            document.querySelectorAll('input[name="discountType"]').forEach(input => {
                input.addEventListener('change', updateDiscountType);
            });
            
            // Export button
            document.getElementById('exportBtn').addEventListener('click', function() {
                showNotification('Đã xuất file Excel (mô phỏng)', 'success');
            });
            
            // Bulk create button
            document.getElementById('bulkCreateBtn').addEventListener('click', function() {
                showNotification('Mở tính năng tạo mã hàng loạt (mô phỏng)', 'info');
            });
        }

        // Add CSS for notifications
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            
            @keyframes slideOut {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>
@endsection