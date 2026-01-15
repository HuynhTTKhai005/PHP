
@extends('admin.app')
@section('content')
 
     
   
   
    <!-- Main Content Area -->
    <div class="content-area">
        <!-- Page Header -->
        <div class="page-header fade-in">
            <div class="page-title">
                <h1>Quản lý Khách hàng</h1>
                <p>Quản lý thông tin và tương tác với khách hàng</p>
            </div>
            <div class="header-actions">
                <button class="btn btn-secondary" id="exportBtn">
                    <i class="fas fa-file-export"></i> Xuất Excel
                </button>
                <button class="btn btn-info" id="sendEmailBtn">
                    <i class="fas fa-envelope"></i> Gửi email
                </button>
                <button class="btn btn-primary" id="addCustomerBtn">
                    <i class="fas fa-user-plus"></i> Thêm khách hàng
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card total fade-in">
                <div class="stat-header">
                    <div class="stat-icon icon-total">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="trend">
                        <i class="fas fa-arrow-up"></i> 15%
                    </div>
                </div>
                <div class="stat-content">
                    <h3 id="totalCustomers">2,847</h3>
                    <p>Tổng khách hàng</p>
                </div>
            </div>
            
            <div class="stat-card new fade-in">
                <div class="stat-header">
                    <div class="stat-icon icon-new">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="trend">
                        <i class="fas fa-arrow-up"></i> 8%
                    </div>
                </div>
                <div class="stat-content">
                    <h3 id="newCustomers">128</h3>
                    <p>Khách hàng mới (tháng)</p>
                </div>
            </div>
            
            <div class="stat-card vip fade-in">
                <div class="stat-header">
                    <div class="stat-icon icon-vip">
                        <i class="fas fa-crown"></i>
                    </div>
                    <div class="trend">
                        <i class="fas fa-arrow-up"></i> 5%
                    </div>
                </div>
                <div class="stat-content">
                    <h3 id="vipCustomers">342</h3>
                    <p>Khách hàng VIP</p>
                </div>
            </div>
            
            <div class="stat-card inactive fade-in">
                <div class="stat-header">
                    <div class="stat-icon icon-inactive">
                        <i class="fas fa-user-slash"></i>
                    </div>
                    <div class="trend down">
                        <i class="fas fa-arrow-down"></i> 3%
                    </div>
                </div>
                <div class="stat-content">
                    <h3 id="inactiveCustomers">56</h3>
                    <p>Không hoạt động</p>
                </div>
            </div>
        </div>

        <!-- Customer Segments -->
        <div class="segments-section fade-in">
            <div class="section-header">
                <h2>Phân khúc khách hàng</h2>
                <button class="btn btn-secondary" style="padding: 8px 16px; font-size: 13px;" onclick="manageSegments()">
                    <i class="fas fa-chart-pie"></i> Phân tích
                </button>
            </div>
            <div class="segments-grid">
                <div class="segment-card active" onclick="filterBySegment('vip')">
                    <div class="segment-icon segment-vip">
                        <i class="fas fa-crown"></i>
                    </div>
                    <div class="segment-info">
                        <h4>VIP</h4>
                        <p>342</p>
                    </div>
                </div>
                <div class="segment-card" onclick="filterBySegment('regular')">
                    <div class="segment-icon segment-regular">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="segment-info">
                        <h4>Thường xuyên</h4>
                        <p>1,245</p>
                    </div>
                </div>
                <div class="segment-card" onclick="filterBySegment('new')">
                    <div class="segment-icon segment-new">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="segment-info">
                        <h4>Mới</h4>
                        <p>128</p>
                    </div>
                </div>
                <div class="segment-card" onclick="filterBySegment('loyal')">
                    <div class="segment-icon segment-loyal">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="segment-info">
                        <h4>Trung thành</h4>
                        <p>856</p>
                    </div>
                </div>
                <div class="segment-card" onclick="filterBySegment('inactive')">
                    <div class="segment-icon segment-inactive">
                        <i class="fas fa-user-clock"></i>
                    </div>
                    <div class="segment-info">
                        <h4>Không hoạt động</h4>
                        <p>56</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section fade-in">
            <div class="filter-group">
                <label>Phân khúc</label>
                <select class="filter-select" id="segmentFilter">
                    <option value="">Tất cả phân khúc</option>
                    <option value="vip">VIP</option>
                    <option value="regular">Thường xuyên</option>
                    <option value="new">Mới</option>
                    <option value="loyal">Trung thành</option>
                    <option value="inactive">Không hoạt động</option>
                </select>
            </div>
            
            <div class="filter-group">
                <label>Trạng thái</label>
                <select class="filter-select" id="statusFilter">
                    <option value="">Tất cả trạng thái</option>
                    <option value="active">Hoạt động</option>
                    <option value="inactive">Không hoạt động</option>
                    <option value="blocked">Đã chặn</option>
                </select>
            </div>
            
            <div class="filter-group">
                <label>Tìm kiếm</label>
                <input type="text" class="filter-input" id="searchInput" placeholder="Tên, email, SĐT...">
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

        <!-- Customers Table -->
        <div class="customers-container fade-in">
            <div class="section-header">
                <h2>Danh sách khách hàng</h2>
                <div class="table-actions">
                    <button class="btn btn-secondary" style="padding: 8px 16px; font-size: 13px;" onclick="refreshCustomers()">
                        <i class="fas fa-sync-alt"></i> Làm mới
                    </button>
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
                    <tbody id="customersTableBody">
                        <!-- Dữ liệu sẽ được thêm bằng JavaScript -->
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="pagination">
                <div class="pagination-info">
                    Hiển thị <strong>1-10</strong> của <strong>2,847</strong> khách hàng
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

        <!-- Import Section -->
        <div class="import-section fade-in">
            <div class="import-info">
                <h4>Nhập danh sách khách hàng</h4>
                <p>Nhập khách hàng từ file Excel/CSV với đầy đủ thông tin</p>
            </div>
            <div>
                <button class="btn btn-success" onclick="importCustomers()">
                    <i class="fas fa-file-import"></i> Nhập file
                </button>
            </div>
        </div>
    </div>

    <!-- Customer Detail Modal -->
    <div id="customerModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Thông tin khách hàng</h3>
                <button class="close-modal" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="customer-details-grid">
                    <div class="detail-group">
                        <label>Khách hàng</label>
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <div id="modalAvatar" class="customer-avatar">
                                <!-- Avatar will be set by JavaScript -->
                            </div>
                            <div>
                                <h4 id="modalName" style="font-size: 18px; margin-bottom: 5px;"></h4>
                                <p id="modalCustomerId" style="color: var(--gray); font-size: 13px;"></p>
                            </div>
                        </div>
                    </div>
                    <div class="detail-group">
                        <label>Thông tin liên hệ</label>
                        <p id="modalPhone" style="margin-bottom: 5px;"></p>
                        <p id="modalEmail"></p>
                    </div>
                    <div class="detail-group">
                        <label>Địa chỉ</label>
                        <p id="modalAddress"></p>
                    </div>
                    <div class="detail-group">
                        <label>Phân loại</label>
                        <div style="display: flex; gap: 10px; margin-top: 10px;">
                            <span id="modalSegment" class="segment-badge"></span>
                            <span id="modalStatus" class="status-badge"></span>
                        </div>
                    </div>
                </div>

                <!-- Customer Stats -->
                <div class="customer-stats">
                    <div class="customer-stat">
                        <div class="value" id="modalTotalOrders">0</div>
                        <div class="label">Tổng đơn hàng</div>
                    </div>
                    <div class="customer-stat">
                        <div class="value" id="modalTotalSpent">0đ</div>
                        <div class="label">Tổng chi tiêu</div>
                    </div>
                    <div class="customer-stat">
                        <div class="value" id="modalAvgOrder">0đ</div>
                        <div class="label">Giá trị TB/đơn</div>
                    </div>
                    <div class="customer-stat">
                        <div class="value" id="modalLastOrder">-</div>
                        <div class="label">Đơn hàng cuối</div>
                    </div>
                </div>

                <!-- Tabs -->
                <div class="tabs">
                    <button class="tab active" onclick="switchTab('orders')">Đơn hàng</button>
                    <button class="tab" onclick="switchTab('activity')">Hoạt động</button>
                    <button class="tab" onclick="switchTab('notes')">Ghi chú</button>
                </div>

                <!-- Orders Tab -->
                <div id="ordersTab" class="tab-content active">
                    <div class="orders-list" id="ordersList">
                        <!-- Orders will be loaded here -->
                    </div>
                </div>

                <!-- Activity Tab -->
                <div id="activityTab" class="tab-content">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="timeline-content">
                                <h4>Đặt hàng #ORD-10045</h4>
                                <p>Đơn hàng trị giá 2,500,000đ</p>
                                <div class="timeline-time">Hôm nay, 14:30</div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="fas fa-comment"></i>
                            </div>
                            <div class="timeline-content">
                                <h4>Để lại đánh giá</h4>
                                <p>Đánh giá 5 sao cho sản phẩm iPhone 15 Pro Max</p>
                                <div class="timeline-time">Hôm qua, 09:15</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notes Tab -->
                <div id="notesTab" class="tab-content">
                    <div class="form-group">
                        <label>Thêm ghi chú</label>
                        <textarea class="form-control" id="customerNote" placeholder="Nhập ghi chú về khách hàng..."></textarea>
                    </div>
                    <button class="btn btn-primary" style="margin-top: 15px;" onclick="addCustomerNote()">
                        <i class="fas fa-save"></i> Lưu ghi chú
                    </button>
                </div>

                <div class="modal-actions">
                    <button class="btn btn-secondary" onclick="sendMessageToCustomer()">
                        <i class="fas fa-comment"></i> Nhắn tin
                    </button>
                    <button class="btn btn-info" onclick="editCustomer()">
                        <i class="fas fa-edit"></i> Chỉnh sửa
                    </button>
                    <button class="btn btn-danger" onclick="deleteCurrentCustomer()">
                        <i class="fas fa-trash"></i> Xóa
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Customer Modal -->
    <div id="customerFormModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="formModalTitle">Thêm khách hàng mới</h3>
                <button class="close-modal" onclick="closeFormModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form id="customerForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Họ và tên <span class="required">*</span></label>
                            <input type="text" class="form-control" id="customerName" required>
                        </div>
                        <div class="form-group">
                            <label>Email <span class="required">*</span></label>
                            <input type="email" class="form-control" id="customerEmail" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Số điện thoại <span class="required">*</span></label>
                            <input type="tel" class="form-control" id="customerPhone" required>
                        </div>
                        <div class="form-group">
                            <label>Ngày sinh</label>
                            <input type="date" class="form-control" id="customerBirthday">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Địa chỉ</label>
                        <textarea class="form-control" id="customerAddress" rows="3"></textarea>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Phân khúc</label>
                            <select class="form-control" id="customerSegment">
                                <option value="regular">Thường xuyên</option>
                                <option value="vip">VIP</option>
                                <option value="new">Mới</option>
                                <option value="loyal">Trung thành</option>
                                <option value="inactive">Không hoạt động</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select class="form-control" id="customerStatus">
                                <option value="active">Hoạt động</option>
                                <option value="inactive">Không hoạt động</option>
                                <option value="blocked">Đã chặn</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nguồn khách hàng</label>
                            <select class="form-control" id="customerSource">
                                <option value="website">Website</option>
                                <option value="facebook">Facebook</option>
                                <option value="instagram">Instagram</option>
                                <option value="referral">Giới thiệu</option>
                                <option value="offline">Offline</option>
                                <option value="other">Khác</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Giới tính</label>
                            <select class="form-control" id="customerGender">
                                <option value="male">Nam</option>
                                <option value="female">Nữ</option>
                                <option value="other">Khác</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Ghi chú</label>
                        <textarea class="form-control" id="customerNotes" rows="3"></textarea>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="closeFormModal()">
                            Hủy bỏ
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Lưu khách hàng
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Sample customer data
        const sampleCustomers = [
            {
                id: 1,
                code: 'KH-001234',
                name: 'Nguyễn Văn A',
                email: 'nguyenvana@email.com',
                phone: '0987 654 321',
                avatar: 'NA',
                address: '123 Đường ABC, Quận 1, TP.HCM',
                segment: 'vip',
                status: 'active',
                totalOrders: 24,
                totalSpent: 125000000,
                avgOrder: 5208333,
                lastOrder: '15/01/2024',
                joinDate: '12/03/2022',
                source: 'website',
                gender: 'male',
                notes: 'Khách hàng VIP, thường xuyên mua hàng điện tử'
            },
            {
                id: 2,
                code: 'KH-001235',
                name: 'Trần Thị B',
                email: 'tranthib@email.com',
                phone: '0912 345 678',
                avatar: 'TB',
                address: '456 Đường XYZ, Quận 3, TP.HCM',
                segment: 'regular',
                status: 'active',
                totalOrders: 12,
                totalSpent: 45000000,
                avgOrder: 3750000,
                lastOrder: '14/01/2024',
                joinDate: '25/05/2023',
                source: 'facebook',
                gender: 'female',
                notes: 'Khách hàng thường xuyên, thích mua thời trang'
            },
            {
                id: 3,
                code: 'KH-001236',
                name: 'Lê Văn C',
                email: 'levanc@email.com',
                phone: '0933 222 111',
                avatar: 'LC',
                address: '789 Đường DEF, Quận 5, TP.HCM',
                segment: 'new',
                status: 'active',
                totalOrders: 2,
                totalSpent: 8500000,
                avgOrder: 4250000,
                lastOrder: '14/01/2024',
                joinDate: '10/01/2024',
                source: 'website',
                gender: 'male',
                notes: 'Khách hàng mới, cần chăm sóc đặc biệt'
            },
            {
                id: 4,
                code: 'KH-001237',
                name: 'Phạm Thị D',
                email: 'phamthid@email.com',
                phone: '0978 999 000',
                avatar: 'PD',
                address: '321 Đường GHI, Quận 7, TP.HCM',
                segment: 'loyal',
                status: 'active',
                totalOrders: 38,
                totalSpent: 189000000,
                avgOrder: 4973684,
                lastOrder: '13/01/2024',
                joinDate: '15/08/2021',
                source: 'referral',
                gender: 'female',
                notes: 'Khách hàng trung thành, giới thiệu nhiều người mua'
            },
            {
                id: 5,
                code: 'KH-001238',
                name: 'Hoàng Văn E',
                email: 'hoangvane@email.com',
                phone: '0944 555 666',
                avatar: 'HE',
                address: '654 Đường JKL, Quận 10, TP.HCM',
                segment: 'inactive',
                status: 'inactive',
                totalOrders: 5,
                totalSpent: 21500000,
                avgOrder: 4300000,
                lastOrder: '15/11/2023',
                joinDate: '20/02/2023',
                source: 'website',
                gender: 'male',
                notes: 'Không hoạt động trong 2 tháng qua'
            },
            {
                id: 6,
                code: 'KH-001239',
                name: 'Vũ Thị F',
                email: 'vuthif@email.com',
                phone: '0966 777 888',
                avatar: 'VF',
                address: '987 Đường MNO, Quận Bình Thạnh, TP.HCM',
                segment: 'vip',
                status: 'active',
                totalOrders: 31,
                totalSpent: 156000000,
                avgOrder: 5032258,
                lastOrder: '12/01/2024',
                joinDate: '05/04/2022',
                source: 'instagram',
                gender: 'female',
                notes: 'Khách hàng VIP, thích mỹ phẩm cao cấp'
            },
            {
                id: 7,
                code: 'KH-001240',
                name: 'Đặng Văn G',
                email: 'dangvang@email.com',
                phone: '0901 234 567',
                avatar: 'DG',
                address: '147 Đường PQR, Quận Tân Bình, TP.HCM',
                segment: 'regular',
                status: 'blocked',
                totalOrders: 8,
                totalSpent: 32000000,
                avgOrder: 4000000,
                lastOrder: '10/12/2023',
                joinDate: '30/06/2023',
                source: 'facebook',
                gender: 'male',
                notes: 'Đã chặn do vi phạm chính sách'
            },
            {
                id: 8,
                code: 'KH-001241',
                name: 'Bùi Thị H',
                email: 'buithih@email.com',
                phone: '0923 456 789',
                avatar: 'BH',
                address: '258 Đường STU, Quận Phú Nhuận, TP.HCM',
                segment: 'new',
                status: 'active',
                totalOrders: 1,
                totalSpent: 3500000,
                avgOrder: 3500000,
                lastOrder: '13/01/2024',
                joinDate: '12/01/2024',
                source: 'website',
                gender: 'female',
                notes: 'Khách hàng mới, đơn hàng đầu tiên'
            }
        ];

        // Initialize the customer management
        document.addEventListener('DOMContentLoaded', function() {
            loadCustomers();
            setupEventListeners();
            updateStats();
        });

        // Load customers into table
        function loadCustomers(customers = sampleCustomers) {
            const tbody = document.getElementById('customersTableBody');
            tbody.innerHTML = '';
            
            customers.forEach(customer => {
                const row = document.createElement('tr');
                
                // Segment text mapping
                const segmentMap = {
                    'vip': {text: 'VIP', class: 'segment-vip-badge'},
                    'regular': {text: 'Thường xuyên', class: 'segment-regular-badge'},
                    'new': {text: 'Mới', class: 'segment-new-badge'},
                    'loyal': {text: 'Trung thành', class: 'segment-loyal-badge'},
                    'inactive': {text: 'Không hoạt động', class: 'segment-inactive-badge'}
                };
                
                // Status text mapping
                const statusMap = {
                    'active': {text: 'Hoạt động', class: 'status-active'},
                    'inactive': {text: 'Không hoạt động', class: 'status-inactive'},
                    'blocked': {text: 'Đã chặn', class: 'status-blocked'}
                };
                
                row.innerHTML = `
                    <td>
                        <div class="customer-info">
                            <div class="customer-avatar">
                                ${customer.avatar}
                            </div>
                            <div class="customer-details">
                                <h4>${customer.name}</h4>
                                <p>${customer.code}</p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div style="font-size: 13px;">
                            <div style="font-weight: 600; margin-bottom: 5px;">${customer.phone}</div>
                            <div style="color: var(--gray);">${customer.email}</div>
                        </div>
                    </td>
                    <td>
                        <span class="segment-badge ${segmentMap[customer.segment].class}">
                            ${segmentMap[customer.segment].text}
                        </span>
                    </td>
                    <td>
                        <span class="status-badge ${statusMap[customer.status].class}">
                            ${statusMap[customer.status].text}
                        </span>
                    </td>
                    <td>
                        <div class="stats-numbers">
                            <div>
                                <span class="number">${customer.totalOrders}</span>
                                <span class="label"> đơn hàng</span>
                            </div>
                            <div>
                                <span class="number">${formatPrice(customer.totalSpent)}đ</span>
                                <span class="label"> tổng chi</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div style="font-size: 13px;">
                            <div>${customer.joinDate}</div>
                            <div style="color: var(--gray); font-size: 12px;">${calculateDaysSince(customer.joinDate)} ngày</div>
                        </div>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-btn view" onclick="viewCustomer(${customer.id})" title="Xem chi tiết">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="action-btn edit" onclick="editCustomerForm(${customer.id})" title="Sửa">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn" onclick="toggleCustomerStatus(${customer.id})" title="${customer.status === 'active' ? 'Vô hiệu hóa' : 'Kích hoạt'}">
                                <i class="fas fa-power-off"></i>
                            </button>
                            <button class="action-btn delete" onclick="deleteCustomer(${customer.id})" title="Xóa">
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

        // Calculate days since join date
        function calculateDaysSince(joinDate) {
            const join = new Date(joinDate.split('/').reverse().join('-'));
            const today = new Date();
            const diffTime = Math.abs(today - join);
            return Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        }

        // Update stats cards
        function updateStats(customers = sampleCustomers) {
            const total = customers.length;
            const newCustomers = customers.filter(c => c.segment === 'new').length;
            const vipCustomers = customers.filter(c => c.segment === 'vip').length;
            const inactiveCustomers = customers.filter(c => c.status === 'inactive').length;
            
            document.getElementById('totalCustomers').textContent = total.toLocaleString();
            document.getElementById('newCustomers').textContent = newCustomers;
            document.getElementById('vipCustomers').textContent = vipCustomers;
            document.getElementById('inactiveCustomers').textContent = inactiveCustomers;
        }

        // Apply filters
        function applyFilters() {
            const segment = document.getElementById('segmentFilter').value;
            const status = document.getElementById('statusFilter').value;
            const search = document.getElementById('searchInput').value.toLowerCase();
            
            let filteredCustomers = sampleCustomers;
            
            // Filter by segment
            if (segment) {
                filteredCustomers = filteredCustomers.filter(customer => customer.segment === segment);
            }
            
            // Filter by status
            if (status) {
                filteredCustomers = filteredCustomers.filter(customer => customer.status === status);
            }
            
            // Filter by search term
            if (search) {
                filteredCustomers = filteredCustomers.filter(customer => 
                    customer.name.toLowerCase().includes(search) || 
                    customer.email.toLowerCase().includes(search) ||
                    customer.phone.toLowerCase().includes(search) ||
                    customer.code.toLowerCase().includes(search)
                );
            }
            
            loadCustomers(filteredCustomers);
            updateStats(filteredCustomers);
        }

        // Filter by segment from segment cards
        function filterBySegment(segment) {
            document.getElementById('segmentFilter').value = segment;
            
            // Update active segment card
            document.querySelectorAll('.segment-card').forEach(card => {
                card.classList.remove('active');
            });
            event.currentTarget.classList.add('active');
            
            applyFilters();
        }

        // Reset filters
        function resetFilters() {
            document.getElementById('segmentFilter').value = '';
            document.getElementById('statusFilter').value = '';
            document.getElementById('searchInput').value = '';
            
            // Reset active segment card
            document.querySelectorAll('.segment-card').forEach(card => {
                card.classList.remove('active');
            });
            document.querySelector('.segment-card:nth-child(1)').classList.add('active');
            
            loadCustomers(sampleCustomers);
            updateStats(sampleCustomers);
        }

        // View customer details
        function viewCustomer(customerId) {
            const customer = sampleCustomers.find(c => c.id === customerId);
            if (!customer) return;
            
            // Set modal title
            document.getElementById('modalTitle').textContent = `Khách hàng: ${customer.name}`;
            
            // Populate customer info
            document.getElementById('modalName').textContent = customer.name;
            document.getElementById('modalCustomerId').textContent = customer.code;
            document.getElementById('modalPhone').textContent = customer.phone;
            document.getElementById('modalEmail').textContent = customer.email;
            document.getElementById('modalAddress').textContent = customer.address;
            
            // Set avatar
            const avatar = document.getElementById('modalAvatar');
            avatar.textContent = customer.avatar;
            avatar.style.background = `linear-gradient(135deg, ${getRandomColor()}, ${getRandomColor()})`;
            
            // Set segment and status badges
            const segmentMap = {
                'vip': {text: 'VIP', class: 'segment-vip-badge'},
                'regular': {text: 'Thường xuyên', class: 'segment-regular-badge'},
                'new': {text: 'Mới', class: 'segment-new-badge'},
                'loyal': {text: 'Trung thành', class: 'segment-loyal-badge'},
                'inactive': {text: 'Không hoạt động', class: 'segment-inactive-badge'}
            };
            
            const statusMap = {
                'active': {text: 'Hoạt động', class: 'status-active'},
                'inactive': {text: 'Không hoạt động', class: 'status-inactive'},
                'blocked': {text: 'Đã chặn', class: 'status-blocked'}
            };
            
            const segmentEl = document.getElementById('modalSegment');
            segmentEl.textContent = segmentMap[customer.segment].text;
            segmentEl.className = `segment-badge ${segmentMap[customer.segment].class}`;
            
            const statusEl = document.getElementById('modalStatus');
            statusEl.textContent = statusMap[customer.status].text;
            statusEl.className = `status-badge ${statusMap[customer.status].class}`;
            
            // Set stats
            document.getElementById('modalTotalOrders').textContent = customer.totalOrders;
            document.getElementById('modalTotalSpent').textContent = formatPrice(customer.totalSpent) + 'đ';
            document.getElementById('modalAvgOrder').textContent = formatPrice(customer.avgOrder) + 'đ';
            document.getElementById('modalLastOrder').textContent = customer.lastOrder;
            
            // Load orders
            loadCustomerOrders(customerId);
            
            // Store current customer ID
            document.getElementById('customerModal').dataset.customerId = customerId;
            
            // Show modal
            document.getElementById('customerModal').style.display = 'flex';
        }

        // Load customer orders
        function loadCustomerOrders(customerId) {
            const ordersList = document.getElementById('ordersList');
            ordersList.innerHTML = '';
            
            // Sample orders data
            const sampleOrders = [
                { id: 'ORD-10045', date: '15/01/2024', amount: 2500000, status: 'Đã giao' },
                { id: 'ORD-10032', date: '10/01/2024', amount: 1850000, status: 'Đã giao' },
                { id: 'ORD-10021', date: '05/01/2024', amount: 3200000, status: 'Đã giao' },
                { id: 'ORD-10015', date: '28/12/2023', amount: 4500000, status: 'Đã giao' },
                { id: 'ORD-10008', date: '20/12/2023', amount: 2750000, status: 'Đã giao' }
            ];
            
            sampleOrders.forEach(order => {
                const orderItem = document.createElement('div');
                orderItem.className = 'order-item';
                orderItem.innerHTML = `
                    <div class="order-info">
                        <h4>${order.id}</h4>
                        <p>${order.date} - ${order.status}</p>
                    </div>
                    <div class="order-amount">${formatPrice(order.amount)}đ</div>
                `;
                ordersList.appendChild(orderItem);
            });
        }

        // Edit customer form
        function editCustomerForm(customerId) {
            const customer = sampleCustomers.find(c => c.id === customerId);
            if (!customer) return;
            
            // Set modal title
            document.getElementById('formModalTitle').textContent = 'Chỉnh sửa khách hàng';
            
            // Populate form with customer data
            document.getElementById('customerName').value = customer.name;
            document.getElementById('customerEmail').value = customer.email;
            document.getElementById('customerPhone').value = customer.phone;
            document.getElementById('customerBirthday').value = '';
            document.getElementById('customerAddress').value = customer.address;
            document.getElementById('customerSegment').value = customer.segment;
            document.getElementById('customerStatus').value = customer.status;
            document.getElementById('customerSource').value = customer.source;
            document.getElementById('customerGender').value = customer.gender;
            document.getElementById('customerNotes').value = customer.notes;
            
            // Store customer ID
            document.getElementById('customerForm').dataset.customerId = customerId;
            
            // Show modal
            closeModal();
            document.getElementById('customerFormModal').style.display = 'flex';
        }

        // Delete customer
        function deleteCustomer(customerId) {
            const customer = sampleCustomers.find(c => c.id === customerId);
            if (!customer) return;
            
            if (confirm(`Bạn có chắc chắn muốn xóa khách hàng "${customer.name}"?`)) {
                // In a real app, you would make an API call to delete the customer
                showNotification(`Đã xóa khách hàng: ${customer.name}`, 'success');
                
                // Remove from sample data
                const index = sampleCustomers.findIndex(c => c.id === customerId);
                if (index > -1) {
                    sampleCustomers.splice(index, 1);
                    loadCustomers(sampleCustomers);
                    updateStats(sampleCustomers);
                }
            }
        }

        // Toggle customer status
        function toggleCustomerStatus(customerId) {
            const customer = sampleCustomers.find(c => c.id === customerId);
            if (!customer) return;
            
            if (customer.status === 'active') {
                customer.status = 'inactive';
                showNotification(`Đã vô hiệu hóa khách hàng: ${customer.name}`, 'warning');
            } else {
                customer.status = 'active';
                showNotification(`Đã kích hoạt khách hàng: ${customer.name}`, 'success');
            }
            
            loadCustomers(sampleCustomers);
            updateStats(sampleCustomers);
        }

        // Add new customer
        document.getElementById('addCustomerBtn').addEventListener('click', function() {
            // Set modal title
            document.getElementById('formModalTitle').textContent = 'Thêm khách hàng mới';
            
            // Reset form
            document.getElementById('customerForm').reset();
            
            // Remove customer ID from form data
            delete document.getElementById('customerForm').dataset.customerId;
            
            // Show modal
            document.getElementById('customerFormModal').style.display = 'flex';
        });

        // Handle form submission
        document.getElementById('customerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const customerId = this.dataset.customerId;
            const isEdit = !!customerId;
            
            // Get form values
            const customerData = {
                name: document.getElementById('customerName').value,
                email: document.getElementById('customerEmail').value,
                phone: document.getElementById('customerPhone').value,
                address: document.getElementById('customerAddress').value,
                segment: document.getElementById('customerSegment').value,
                status: document.getElementById('customerStatus').value,
                source: document.getElementById('customerSource').value,
                gender: document.getElementById('customerGender').value,
                notes: document.getElementById('customerNotes').value,
                avatar: getInitials(document.getElementById('customerName').value)
            };
            
            // Generate customer code
            customerData.code = `KH-${String(sampleCustomers.length + 1).padStart(6, '0')}`;
            
            if (isEdit) {
                // Update existing customer
                const index = sampleCustomers.findIndex(c => c.id === parseInt(customerId));
                if (index > -1) {
                    // Preserve some existing data
                    customerData.id = sampleCustomers[index].id;
                    customerData.totalOrders = sampleCustomers[index].totalOrders;
                    customerData.totalSpent = sampleCustomers[index].totalSpent;
                    customerData.avgOrder = sampleCustomers[index].avgOrder;
                    customerData.lastOrder = sampleCustomers[index].lastOrder;
                    customerData.joinDate = sampleCustomers[index].joinDate;
                    
                    sampleCustomers[index] = customerData;
                    showNotification('Cập nhật khách hàng thành công!', 'success');
                }
            } else {
                // Add new customer
                customerData.id = sampleCustomers.length > 0 ? 
                    Math.max(...sampleCustomers.map(c => c.id)) + 1 : 1;
                customerData.totalOrders = 0;
                customerData.totalSpent = 0;
                customerData.avgOrder = 0;
                customerData.lastOrder = '-';
                customerData.joinDate = new Date().toLocaleDateString('vi-VN');
                
                sampleCustomers.push(customerData);
                showNotification('Thêm khách hàng thành công!', 'success');
            }
            
            // Reload customers and update stats
            loadCustomers(sampleCustomers);
            updateStats(sampleCustomers);
            
            // Close modal
            closeFormModal();
        });

        // Get initials from name
        function getInitials(name) {
            return name.split(' ')
                .map(word => word[0])
                .join('')
                .toUpperCase()
                .substring(0, 2);
        }

        // Get random color for avatar
        function getRandomColor() {
            const colors = ['#4361ee', '#7209b7', '#2ecc71', '#f39c12', '#e74c3c', '#3498db', '#9b59b6'];
            return colors[Math.floor(Math.random() * colors.length)];
        }

        // Switch tabs in modal
        function switchTab(tabName) {
            // Update tab buttons
            document.querySelectorAll('.tab').forEach(tab => {
                tab.classList.remove('active');
            });
            event.target.classList.add('active');
            
            // Update tab content
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });
            document.getElementById(`${tabName}Tab`).classList.add('active');
        }

        // Add customer note
        function addCustomerNote() {
            const note = document.getElementById('customerNote').value;
            if (note.trim()) {
                showNotification('Đã thêm ghi chú cho khách hàng', 'success');
                document.getElementById('customerNote').value = '';
            }
        }

        // Send message to customer
        function sendMessageToCustomer() {
            const customerId = document.getElementById('customerModal').dataset.customerId;
            const customer = sampleCustomers.find(c => c.id === parseInt(customerId));
            
            if (customer) {
                showNotification(`Đã gửi tin nhắn cho ${customer.name}`, 'success');
            }
        }

        // Edit current customer
        function editCustomer() {
            const customerId = document.getElementById('customerModal').dataset.customerId;
            if (customerId) {
                closeModal();
                editCustomerForm(parseInt(customerId));
            }
        }

        // Delete current customer
        function deleteCurrentCustomer() {
            const customerId = document.getElementById('customerModal').dataset.customerId;
            if (customerId) {
                if (confirm('Bạn có chắc chắn muốn xóa khách hàng này?')) {
                    deleteCustomer(parseInt(customerId));
                    closeModal();
                }
            }
        }

        // Close modal
        function closeModal() {
            document.getElementById('customerModal').style.display = 'none';
        }

        // Close form modal
        function closeFormModal() {
            document.getElementById('customerFormModal').style.display = 'none';
        }

        // Change page
        function changePage(pageNum) {
            showNotification(`Chuyển đến trang ${pageNum} (mô phỏng)`, 'info');
        }

        // Refresh customers
        function refreshCustomers() {
            loadCustomers(sampleCustomers);
            updateStats(sampleCustomers);
            showNotification('Đã làm mới danh sách khách hàng', 'info');
        }

        // Import customers
        function importCustomers() {
            showNotification('Mở tính năng nhập file khách hàng (mô phỏng)', 'info');
        }

        // Manage segments
        function manageSegments() {
            showNotification('Mở tính năng phân tích phân khúc (mô phỏng)', 'info');
        }

        // Send email to customers
        document.getElementById('sendEmailBtn').addEventListener('click', function() {
            showNotification('Mở tính năng gửi email hàng loạt (mô phỏng)', 'info');
        });

        // Export customers
        document.getElementById('exportBtn').addEventListener('click', function() {
            showNotification('Đã xuất file Excel (mô phỏng)', 'success');
        });

        // Show notification
        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `notification ${type === 'error' ? 'error' : type === 'warning' ? 'warning' : ''}`;
            notification.innerHTML = `
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'}"></i>
                    <span>${message}</span>
                </div>
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
                    closeFormModal();
                }
            });
            
            // Close modal when clicking outside
            document.getElementById('customerModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal();
                }
            });
            
            document.getElementById('customerFormModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeFormModal();
                }
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
 
@endsection