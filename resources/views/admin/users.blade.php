@extends('admin.app')
@section('content')
    <div class="content-area">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-title">
                <h1>Phân quyền & Nhật ký hoạt động</h1>
                <p>Quản lý vai trò, quyền truy cập và theo dõi mọi hành động trong hệ thống</p>
            </div>
            <div class="header-actions">
                <button class="btn btn-secondary">
                    <i class="fas fa-sync"></i> Làm mới
                </button>
                <button class="btn btn-primary" onclick="openModal('addRoleModal')">
                    <i class="fas fa-plus"></i> Thêm vai trò mới
                </button>
            </div>
        </div>

        <!-- Tabs -->
        <div class="card" style="margin-bottom: 25px;">
            <div class="card-header">
                <div class="options">
                    <button class="btn btn-secondary active" onclick="showTab('roles')">Vai trò & Quyền</button>
                    <button class="btn btn-secondary" onclick="showTab('audit')">Nhật ký hoạt động</button>
                </div>
            </div>
        </div>

        <!-- Tab 1: Roles & Permissions -->
        <div id="roles" class="tab-content">
            <!-- Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon icon-total"><i class="fas fa-users-cog"></i></div>
                    <div class="stat-content">
                        <h3>5</h3>
                        <p>Tổng số vai trò</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon icon-completed"><i class="fas fa-shield-alt"></i></div>
                    <div class="stat-content">
                        <h3>48</h3>
                        <p>Quyền đã cấp</p>
                    </div>
                </div>
            </div>

            <!-- Roles Table -->
            <div class="card products-container">
                <div class="section-header">
                    <h2>Danh sách vai trò</h2>
                    <div class="filter-actions">
                        <input type="text" class="filter-input" placeholder="Tìm vai trò...">
                    </div>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Vai trò</th>
                                <th>Số người</th>
                                <th>Quyền chính</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Quản trị viên</strong></td>
                                <td>2 người</td>
                                <td>Toàn quyền hệ thống</td>
                                <td><span class="status-badge status-completed">Hoạt động</span></td>
                                <td class="action-buttons">
                                    <button class="action-btn edit" onclick="openModal('editRoleModal')"><i
                                            class="fas fa-edit"></i></button>
                                    <button class="action-btn delete"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Nhân viên bán hàng</strong></td>
                                <td>8 người</td>
                                <td>Quản lý đơn hàng, sản phẩm</td>
                                <td><span class="status-badge status-completed">Hoạt động</span></td>
                                <td class="action-buttons">
                                    <button class="action-btn edit" onclick="openModal('editRoleModal')"><i
                                            class="fas fa-edit"></i></button>
                                    <button class="action-btn delete"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Khách hàng</strong></td>
                                <td>1.248 người</td>
                                <td>Đặt hàng, xem lịch sử</td>
                                <td><span class="status-badge status-completed">Hoạt động</span></td>
                                <td class="action-buttons">
                                    <button class="action-btn edit" onclick="openModal('editRoleModal')"><i
                                            class="fas fa-edit"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tab 2: Audit Logs -->
        <div id="audit" class="tab-content" style="display: none;">
            <div class="card products-container">
                <div class="section-header">
                    <h2>Nhật ký hoạt động (Audit Logs)</h2>
                    <div class="filter-actions">
                        <select class="filter-select">
                            <option>Tất cả hành động</option>
                            <option>Đăng nhập</option>
                            <option>Tạo đơn hàng</option>
                            <option>Cập nhật sản phẩm</option>
                        </select>
                        <input type="date" class="filter-input">
                        <button class="btn btn-primary"><i class="fas fa-filter"></i> Lọc</button>
                    </div>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Thời gian</th>
                                <th>Người thực hiện</th>
                                <th>Hành động</th>
                                <th>Chi tiết</th>
                                <th>IP</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>30/12/2025 14:32</td>
                                <td>admin@sincay.com</td>
                                <td>Đăng nhập</td>
                                <td>Đăng nhập thành công</td>
                                <td>113.172.35.28</td>
                            </tr>
                            <tr>
                                <td>30/12/2025 14:28</td>
                                <td>nhanvien1@sincay.com</td>
                                <td>Cập nhật sản phẩm</td>
                                <td>Sửa giá món "Phở bò đặc biệt"</td>
                                <td>192.168.1.105</td>
                            </tr>
                            <tr>
                                <td>30/12/2025 14:15</td>
                                <td>admin@sincay.com</td>
                                <td>Tạo vai trò</td>
                                <td>Tạo vai trò mới "Nhân viên kho"</td>
                                <td>113.172.35.28</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="pagination">
                    <div class="pagination-info">Hiển thị 1-10 của 156 bản ghi</div>
                    <div class="pagination-controls">
                        <button class="page-btn"><i class="fas fa-chevron-left"></i></button>
                        <button class="page-btn active">1</button>
                        <button class="page-btn">2</button>
                        <button class="page-btn">3</button>
                        <button class="page-btn"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Thêm/Sửa Vai trò -->
    <div class="modal" id="addRoleModal">
        <div class="modal-content" style="max-width: 600px;">
            <div class="modal-header">
                <h3>Thêm vai trò mới</h3>
                <button class="close-modal" onclick="closeModal('addRoleModal')">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group">
                        <label>Tên vai trò <span class="required">*</span></label>
                        <input type="text" class="form-control" placeholder="Ví dụ: Nhân viên kho">
                    </div>
                </div>
                <div class="form-group">
                    <label>Chọn quyền</label>
                    <div style="columns: 2; gap: 15px;">
                        <label><input type="checkbox" checked> Xem dashboard</label>
                        <label><input type="checkbox" checked> Quản lý sản phẩm</label>
                        <label><input type="checkbox" checked> Quản lý đơn hàng</label>
                        <label><input type="checkbox"> Quản lý khách hàng</label>
                        <label><input type="checkbox"> Quản lý khuyến mãi</label>
                        <label><input type="checkbox"> Xem nhật ký hoạt động</label>
                    </div>
                </div>
                <div class="form-actions">
                    <button class="btn btn-secondary" onclick="closeModal('addRoleModal')">Hủy</button>
                    <button class="btn btn-primary">Lưu vai trò</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Sửa (giống Add, chỉ đổi tiêu đề) -->
    <div class="modal" id="editRoleModal">
        <div class="modal-content" style="max-width: 600px;">
            <div class="modal-header">
                <h3>Chỉnh sửa vai trò</h3>
                <button class="close-modal" onclick="closeModal('editRoleModal')">&times;</button>
            </div>
            <div class="modal-body">…(nội dung giống modal Thêm ở trên)…</div>
        </div>
    </div>

    <script>
        function showTab(tab) {
            document.querySelectorAll('.tab-content').forEach(t => t.style.display = 'none');
            document.getElementById(tab).style.display = 'block';
            document.querySelectorAll('.card-header .btn').forEach(b => b.classList.remove('active'));
            event.target.classList.add('active');
        }

        function openModal(id) {
            document.getElementById(id).style.display = 'flex';
        }

        function closeModal(id) {
            document.getElementById(id).style.display = 'none';
        }
        // Đóng modal khi click ngoài
        window.onclick = function(e) {
            if (e.target.classList.contains('modal')) {
                e.target.style.display = 'none';
            }
        }
    </script>
@endsection
