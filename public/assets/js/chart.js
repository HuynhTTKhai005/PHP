document.addEventListener("DOMContentLoaded", async function () {

    const canvas = document.getElementById('revenueChart');

    // Nếu không phải trang dashboard thì dừng
    if (!canvas) return;

    try {

        const response = await fetch('/api/revenue-by-month');
        const data = await response.json();

        // Tạo mảng 12 tháng mặc định = 0
        let monthlyRevenue = Array(12).fill(0);

        // Gán dữ liệu đúng tháng
        for (let month in data) {
            monthlyRevenue[month - 1] = data[month];
        }

        new Chart(canvas, {
            type: 'bar',
            data: {
                labels: [
                    'T1', 'T2', 'T3', 'T4', 'T5', 'T6',
                    'T7', 'T8', 'T9', 'T10', 'T11', 'T12'
                ],
                datasets: [{
                    label: 'Doanh thu (VND)',
                    data: monthlyRevenue,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1000000,
                            callback: function (value) {
                                return value.toLocaleString('vi-VN') + ' đ';
                            }
                        }

                    }
                }
            }
        });
 

    } catch (error) {
        console.error('Lỗi khi tải dữ liệu biểu đồ:', error);
    }

});
