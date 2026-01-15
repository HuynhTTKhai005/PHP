@extends('admin.app')
@section('content')
    <div class="content-area">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-title">
                <h1>Quản lý Thông báo</h1>
                <p>Gửi, theo dõi và quản lý tất cả thông báo trong hệ thống</p>
            </div>
            <div class="header-actions">
                <button class="btn btn-secondary">
                    <i class="fas fa-sync"></i> Làm mới
                </button>
                <button class="btn btn-primary" onclick="openModal('sendNotificationModal')">
                    <i class="fas fa-paper-plane"></i> Gửi thông báo mới
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon icon-total"><i class="fas fa-bell"></i></div>
                <div class="stat-content">
                    <h3>1,248</h3>
                    <p>Tổng thông báo đã gửi</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon icon-completed"><i class="fas fa-eye"></i></div>
                <div class="stat-content">
                    <h3>892</h3>
                    <p>Đã đọc (71.5%)</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon icon-pending"><i class="fas fa-eye-slash"></i></div>
                <div class="stat-content">
                    <h3>356</h3>
                    <p>Chưa đọc</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon icon-processing"><i class="fas fa-clock"></i></div>
                <div class="stat-content">
                    <h3>12</h3>
                    <p>Gửi hôm nay</p>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-group">
                <label>Loại thông báo</label>
                <select class="filter-select">
                    <option value="">Tất cả loại</option>
                    <option value="order_update">Cập nhật đơn hàng</option>
                    <option value="promotion">Khuyến mãi</option>
                    <option value="system_alert">Cảnh báo hệ thống</option>
                    <option value="password_reset">Đặt lại mật khẩu</option>
                </select>
            </div>
            <div class="filter-group">
                <label>Trạng thái đọc</label>
                <select class="filter-select">
                    <option value="">Tất cả</option>
                    <option value="1">Đã đọc</option>
                    <option value="0">Chưa đọc</option>
                </select>
            </div>
            <div class="filter-group">
                <label>Từ ngày</label>
                <input type="date" class="filter-input">
            </div>
            <div class="filter-group">
                <label>Đến ngày</label>
                <input type="date" class="filter-input">
            </div>
            <div class="filter-actions">
                <button class="btn btn-secondary">Xóa bộ lọc</button>
                <button class="btn btn-primary"><i class="fas fa-search"></i> Tìm kiếm</button>
            </div>
        </div>

        <!-- Notifications Table -->
        <div class="card products-container">
            <div class="section-header">
                <h2>Danh sách thông báo</h2>
                <div class="filter-actions">
                    <input type="text" class="filter-input" placeholder="Tìm theo tiêu đề hoặc nội dung...">
                </div>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Người nhận</th>
                            <th>Loại</th>
                            <th>Tiêu đề</th>
                            <th>Nội dung</th>
                            <th>Đã đọc</th>
                            <th>Thời gian gửi</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#1024</td>
                            <td>khachhang01@gmail.com</td>
                            <td><span class="status-badge"
                                    style="background: rgba(52, 152, 219, 0.1); color: #2980b9;">order_update</span></td>
                            <td>Đơn hàng #DH8921 đã giao thành công</td>
                            <td>Đơn hàng của bạn đã được giao đến địa chỉ...</td>
                            <td><span class="status-badge status-completed">Đã đọc</span></td>
                            <td>30/12/2025 15:45</td>
                            <td class="action-buttons">
                                <button class="action-btn edit" onclick="openModal('viewNotificationModal')"><i
                                        class="fas fa-eye"></i></button>
                                <button class="action-btn delete"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>#1023</td>
                            <td>Tất cả người dùng</td>
                            <td><span class="status-badge"
                                    style="background: rgba(155, 89, 182, 0.1); color: #8e44ad;">promotion</span></td>
                            <td>🔥 Giảm 20% toàn bộ menu dịp Tết!</td>
                            <td>Chỉ từ hôm nay đến 05/01/2026, áp dụng cho...</td>
                            <td><span class="status-badge status-pending">Chưa đọc</span></td>
                            <td>30/12/2025 10:00</td>
                            <td class="action-buttons">
                                <button class="action-btn edit" onclick="openModal('viewNotificationModal')"><i
                                        class="fas fa-eye"></i></button>
                                <button class="action-btn delete"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>#1022</td>
                            <td>admin@sincay.com</td>
                            <td><span class="status-badge status-cancelled"
                                    style="background: rgba(231, 76, 60, 0.1); color: #c0392b;">system_alert</span></td>
                            <td>Cảnh báo: Dung lượng lưu trữ sắp đầy</td>
                            <td>Hệ thống hiện còn 8% dung lượng trống...</td>
                            <td><span class="status-badge status-completed">Đã đọc</span></td>
                            <td>29/12/2025 22:15</td>
                            <td class="action-buttons">
                                <button class="action-btn edit" onclick="openModal('viewNotificationModal')"><i
                                        class="fas fa-eye"></i></button>
                                <button class="action-btn delete"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination">
                <div class="pagination-info">Hiển thị 1-20 của 1.248 thông báo</div>
                <div class="pagination-controls">
                    <button class="page-btn"><i class="fas fa-chevron-left"></i></button>
                    <button class="page-btn active">1</button>
                    <button class="page-btn">2</button>
                    <button class="page-btn">3</button>
                    <button class="page-btn">...</button>
                    <button class="page-btn">63</button>
                    <button class="page-btn"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Gửi thông báo mới -->
    <div class="modal" id="sendNotificationModal">
        <div class="modal-content" style="max-width: 700px;">
            <div class="modal-header">
                <h3>Gửi thông báo mới</h3>
                <button class="close-modal" onclick="closeModal('sendNotificationModal')">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group">
                        <label>Người nhận <span class="required">*</span></label>
                        <select class="form-control">
                            <option value="all">Tất cả người dùng</option>
                            <option value="specific">Chọn người dùng cụ thể</option>
                            <option value="role">Theo vai trò</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Loại thông báo <span class="required">*</span></label>
                        <select class="form-control">
                            <option value="order_update">Cập nhật đơn hàng</option>
                            <option value="promotion">Khuyến mãi</option>
                            <option value="system_alert">Cảnh báo hệ thống</option>
                            <option value="password_reset">Đặt lại mật khẩu</option>
                            <option value="other">Khác</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Tiêu đề <span class="required">*</span></label>
                    <input type="text" class="form-control" placeholder="Ví dụ: Đơn hàng của bạn đã được xác nhận">
                </div>

                <div class="form-group">
                    <label>Nội dung thông báo <span class="required">*</span></label>
                    <textarea class="form-control" rows="5" placeholder="Viết nội dung chi tiết..."></textarea>
                </div>

                <div class="form-actions">
                    <button class="btn btn-secondary" onclick="closeModal('sendNotificationModal')">Hủy</button>
                    <button class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Gửi ngay
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Xem chi tiết thông báo -->
    <div class="modal" id="viewNotificationModal">
        <div class="modal-content" style="max-width: 600px;">
            <div class="modal-header">
                <h3>Chi tiết thông báo #1024</h3>
                <button class="close-modal" onclick="closeModal('viewNotificationModal')">&times;</button>
            </div>
            <div class="modal-body">
                <div class="detail-group">
                    <label>Người nhận</label>
                    <p>khachhang01@gmail.com</p>
                </div>
                <div class="detail-group">
                    <label>Loại</label>
                    <p>order_update</p>
                </div>
                <div class="detail-group">
                    <label>Tiêu đề</label>
                    <p><strong>Đơn hàng #DH8921 đã giao thành công</strong></p>
                </div>
                <div class="detail-group">
                    <label>Nội dung</label>
                    <p>Đơn hàng của bạn đã được giao đến địa chỉ 123 Đường Láng, Hà Nội vào lúc 14:30 ngày 30/12/2025. Cảm
                        ơn bạn đã tin tưởng!</p>
                </div>
                <div class="detail-group">
                    <label>Trạng thái</label>
                    <p><span class="status-badge status-completed">Đã đọc</span> (vào 15:50 30/12/2025)</p>
                </div>
                <div class="detail-group">
                    <label>Thời gian gửi</label>
                    <p>30/12/2025 15:45</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Re-use các hàm modal từ trang trước (nếu chưa có thì thêm lại)
        function openModal(id) {
            document.getElementById(id).style.display = 'flex';
        }

        function closeModal(id) {
            document.getElementById(id).style.display = 'none';
        }
        window.onclick = function(e) {
            if (e.target.classList.contains('modal')) {
                e.target.style.display = 'none';
            }
        }
    </script>
@endsection
