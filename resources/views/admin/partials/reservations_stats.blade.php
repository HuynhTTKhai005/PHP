<div class="stats-grid">
    <div class="stat-card fade-in">
        <div class="stat-icon icon-total"><i class="fas fa-calendar-alt"></i></div>
        <div class="stat-info">
            <h3>{{ number_format($stats['total']) }}</h3>
            <p>Tổng lượt đặt bàn</p>
        </div>
    </div>

    <div class="stat-card fade-in">
        <div class="stat-icon icon-processing"><i class="fas fa-calendar-day"></i></div>
        <div class="stat-info">
            <h3>{{ number_format($stats['today']) }}</h3>
            <p>Đặt bàn hôm nay</p>
        </div>
    </div>

    <div class="stat-card fade-in">
        <div class="stat-icon icon-pending"><i class="fas fa-hourglass-half"></i></div>
        <div class="stat-info">
            <h3>{{ number_format($stats['pending']) }}</h3>
            <p>Chờ xác nhận</p>
        </div>
    </div>

    <div class="stat-card fade-in">
        <div class="stat-icon icon-completed"><i class="fas fa-check-circle"></i></div>
        <div class="stat-info">
            <h3>{{ number_format($stats['confirmed']) }}</h3>
            <p>Đã xác nhận</p>
        </div>
    </div>

    <div class="stat-card fade-in">
        <div class="stat-icon icon-cancelled"><i class="fas fa-times-circle"></i></div>
        <div class="stat-info">
            <h3>{{ number_format($stats['cancelled']) }}</h3>
            <p>Đã hủy</p>
        </div>
    </div>
</div>