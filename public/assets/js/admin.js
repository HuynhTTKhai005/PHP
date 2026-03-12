(function () {
    function getCsrfToken() {
        var meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    function showAdminNotice(message, type) {
        var existing = document.getElementById('admin-notice');
        if (!existing) {
            existing = document.createElement('div');
            existing.id = 'admin-notice';
            existing.className = 'admin-notice';
            document.body.appendChild(existing);
        }
        existing.textContent = message || '';
        existing.classList.remove('is-success', 'is-error');
        existing.classList.add(type === 'error' ? 'is-error' : 'is-success');
        existing.classList.add('show');

        clearTimeout(existing._timer);
        existing._timer = setTimeout(function () {
            existing.classList.remove('show');
        }, 1200);
    }

    function showLoader() {
        var loader = document.getElementById('page-loader');
        if (loader) {
            loader.classList.remove('is-hidden');
        }
    }

    function hideLoader() {
        var loader = document.getElementById('page-loader');
        if (loader) {
            loader.classList.add('is-hidden');
        }
    }

    function initPageLoader() {
        document.addEventListener('click', function (event) {
            var link = event.target.closest('a');
            if (!link) {
                return;
            }
            var href = link.getAttribute('href');
            if (!href || href.startsWith('#') || link.hasAttribute('data-no-loader') || link.target === '_blank') {
                return;
            }

            var body = document.body;
            var reloadUrl = body ? body.getAttribute('data-reload-url') : '';
            var useReload = body && body.getAttribute('data-use-reload') === '1';
            if (useReload && reloadUrl) {
                var targetHref = href;
                try {
                    var targetUrl = new URL(href, window.location.origin);
                    if (targetUrl.origin !== window.location.origin) {
                        return;
                    }
                    targetHref = targetUrl.pathname + targetUrl.search + targetUrl.hash;
                } catch (e) {
                    // keep original href
                }
                event.preventDefault();
                showLoader();
                window.location.href = reloadUrl + '?to=' + encodeURIComponent(targetHref);
                return;
            }

            showLoader();
        });

        document.addEventListener('submit', function (event) {
            var form = event.target;
            if (!form || form.hasAttribute('data-ajax')) {
                return;
            }
            showLoader();
        });

        window.addEventListener('pageshow', hideLoader);
        window.addEventListener('pagehide', showLoader);
    }

    function fetchHtml(url) {
        return fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        }).then(function (response) { return response.json(); });
    }

    function initOrdersAjax() {
        var filterForm = document.querySelector('.js-admin-orders-filter');
        var tableWrapper = document.getElementById('admin-orders-table');
        if (!filterForm || !tableWrapper) {
            return;
        }

        function loadOrders(url, push) {
            showLoader();
            fetchHtml(url).then(function (data) {
                hideLoader();
                if (data && data.html) {
                    tableWrapper.innerHTML = '<div class="section-header"><h2>Danh sách đơn hàng</h2></div>' + data.html;
                    if (push) {
                        window.history.pushState({}, '', url);
                    }
                }
            });
        }

        filterForm.addEventListener('submit', function (event) {
            event.preventDefault();
            var params = new URLSearchParams(new FormData(filterForm));
            loadOrders(filterForm.getAttribute('action') + '?' + params.toString(), true);
        });

        document.addEventListener('click', function (event) {
            var link = event.target.closest('#admin-orders-table .pagination a');
            if (!link) {
                return;
            }
            event.preventDefault();
            loadOrders(link.getAttribute('href'), true);
        });

        window.addEventListener('popstate', function () {
            loadOrders(window.location.href, false);
        });
    }

    function initReservationsAjax() {
        var filterForm = document.querySelector('.js-admin-reservations-filter');
        var statsWrapper = document.getElementById('admin-reservations-stats');
        var tableWrapper = document.getElementById('admin-reservations-table');
        if (!filterForm || !statsWrapper || !tableWrapper) {
            return;
        }

        function loadReservations(url, push) {
            showLoader();
            fetchHtml(url).then(function (data) {
                hideLoader();
                if (data && data.stats_html) {
                    statsWrapper.innerHTML = data.stats_html;
                }
                if (data && data.table_html) {
                    tableWrapper.innerHTML = data.table_html;
                }
                if (push) {
                    window.history.pushState({}, '', url);
                }
            });
        }

        filterForm.addEventListener('submit', function (event) {
            event.preventDefault();
            var params = new URLSearchParams(new FormData(filterForm));
            loadReservations(filterForm.getAttribute('action') + '?' + params.toString(), true);
        });

        document.addEventListener('click', function (event) {
            var link = event.target.closest('#admin-reservations-table .pagination a');
            if (!link) {
                return;
            }
            event.preventDefault();
            loadReservations(link.getAttribute('href'), true);
        });

        document.addEventListener('submit', function (event) {
            var form = event.target;
            if (!form.classList || !form.classList.contains('js-admin-reservation-form')) {
                return;
            }
            event.preventDefault();

            var formData = new FormData(form);
            fetch(form.getAttribute('action'), {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken()
                },
                body: formData
            })
                .then(function (response) {
                    return response.json().then(function (data) {
                        return { ok: response.ok, data: data };
                    });
                })
                .then(function (result) {
                    if (!result.ok) {
                        showAdminNotice(result.data.message || 'Có lỗi xảy ra.', 'error');
                        return;
                    }
                    showAdminNotice(result.data.message || 'Cập nhật thành công', 'success');
                    loadReservations(window.location.href, false);
                });
        });
    }

    function initOrderStatusAjax() {
        document.addEventListener('submit', function (event) {
            var form = event.target;
            if (!form.classList || !form.classList.contains('js-admin-order-status-form')) {
                return;
            }
            event.preventDefault();

            var formData = new FormData(form);
            fetch(form.getAttribute('action'), {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken()
                },
                body: formData
            })
                .then(function (response) {
                    return response.json().then(function (data) {
                        return { ok: response.ok, data: data };
                    });
                })
                .then(function (result) {
                    if (!result.ok) {
                        showAdminNotice(result.data.message || 'Có lỗi xảy ra.', 'error');
                        return;
                    }
                    showAdminNotice(result.data.message || 'Cập nhật thành công', 'success');
                });
        });
    }

    function initDashboardAjax() {
        var dashboardWrapper = document.getElementById('admin-dashboard-content');
        if (!dashboardWrapper) {
            return;
        }

        var interval = parseInt(dashboardWrapper.getAttribute('data-refresh-interval'), 10);
        if (!interval || interval < 15000) {
            interval = 60000;
        }

        function loadDashboard() {
            fetchHtml(window.location.href).then(function (data) {
                if (data && data.html) {
                    dashboardWrapper.innerHTML = data.html;
                    if (window.initRevenueChart) {
                        window.initRevenueChart();
                    }
                }
            });
        }

        setInterval(loadDashboard, interval);
    }

    document.addEventListener('DOMContentLoaded', function () {
        initPageLoader();
        initOrdersAjax();
        initReservationsAjax();
        initOrderStatusAjax();
        initDashboardAjax();
    });
})();
