window.togglePassword = function (id) {
    var fieldId = id || 'password';
    var field = document.getElementById(fieldId);
    if (!field) {
        return;
    }

    var wrapper = field.closest('.form-group') || field.parentElement;
    var icon = wrapper ? wrapper.querySelector('.password-toggle i') : null;

    if (field.type === 'password') {
        field.type = 'text';
        if (icon) {
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        }
    } else {
        field.type = 'password';
        if (icon) {
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
};

function formatCurrency(value) {
    var amount = Number(value || 0);
    return new Intl.NumberFormat('vi-VN').format(amount) + 'd';
}

function initMobileMenu() {
    var toggle = document.querySelector('.mobile-menu-toggle');
    var panel = document.getElementById('mobile-menu');
    var overlay = document.querySelector('.mobile-menu-overlay');
    if (!toggle || !panel || !overlay) {
        return;
    }

    function openMenu() {
        panel.classList.add('is-open');
        overlay.classList.add('is-open');
        document.body.classList.add('is-menu-open');
        panel.setAttribute('aria-hidden', 'false');
        toggle.setAttribute('aria-expanded', 'true');
    }

    function closeMenu() {
        panel.classList.remove('is-open');
        overlay.classList.remove('is-open');
        document.body.classList.remove('is-menu-open');
        panel.setAttribute('aria-hidden', 'true');
        toggle.setAttribute('aria-expanded', 'false');
    }

    toggle.addEventListener('click', function (event) {
        event.preventDefault();
        if (panel.classList.contains('is-open')) {
            closeMenu();
        } else {
            openMenu();
        }
    });

    overlay.addEventListener('click', closeMenu);

    panel.addEventListener('click', function (event) {
        if (event.target.closest('[data-mobile-close]')) {
            event.preventDefault();
            closeMenu();
        }
    });

    document.addEventListener('keyup', function (event) {
        if (event.key === 'Escape') {
            closeMenu();
        }
    });
}
function initAppNotification() {
    var notice = document.getElementById('app-notice');
    var overlay = document.getElementById('app-notification');
    if (!overlay) {
        return;
    }

    var messageEl = overlay.querySelector('.app-notification__message');
    var iconEl = overlay.querySelector('.app-notification__icon');
    var closeBtn = overlay.querySelector('.app-notification__close');
    var backdrop = overlay.querySelector('.app-notification__backdrop');

    function hideNotice() {
        overlay.classList.add('app-notification--hidden');
        overlay.classList.remove('is-success', 'is-error', 'is-warning');
    }

    var autoHideTimer = null;

    function showNotice(type, message) {
        if (!messageEl) {
            return;
        }
        messageEl.textContent = message || '';
        overlay.classList.remove('app-notification--hidden');
        overlay.classList.add('is-' + (type || 'success'));
        if (iconEl) {
            iconEl.textContent = type === 'error' ? '!' : '?';
        }

        if (autoHideTimer) {
            clearTimeout(autoHideTimer);
        }
        autoHideTimer = setTimeout(hideNotice, 3000);
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', hideNotice);
    }
    if (backdrop) {
        backdrop.addEventListener('click', hideNotice);
    }

    window.showAppNotification = showNotice;

    if (notice && notice.dataset) {
        var type = notice.dataset.type;
        var message = notice.dataset.message;
        if (message) {
            showNotice(type, message);
        }
    }
}

function initBlogSave() {
    var config = document.getElementById('blog-save-config');
    if (!config) {
        return;
    }

    var saveUrl = config.dataset.saveUrl;
    var csrfToken = document.querySelector('meta[name="csrf-token"]');
    var token = csrfToken ? csrfToken.getAttribute('content') : '';

    document.addEventListener('click', function (event) {
        var btn = event.target.closest('.btn-save-post');
        if (!btn || !saveUrl) {
            return;
        }
        event.preventDefault();

        var postId = btn.dataset.postId;
        fetch(saveUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({ id: postId })
        })
            .then(function (response) { return response.json(); })
            .then(function (data) {
                if (!data || data.status !== 'success') {
                    window.showAppNotification && window.showAppNotification('error', 'Có lỗi xảy ra, vui lòng thử lại.');
                    return;
                }

                window.showAppNotification && window.showAppNotification('success', data.message);
                var archiveList = document.getElementById('spicy-archive-list');
                if (archiveList && data.archiveHtml) {
                    archiveList.innerHTML = data.archiveHtml;
                }

                var icon = btn.querySelector('i');
                if (data.action === 'added') {
                    btn.classList.add('saved', 'active');
                    if (icon) {
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                    }
                    btn.innerHTML = '<i class="fas fa-heart"></i> Đã lưu';
                } else {
                    btn.classList.remove('saved', 'active');
                    if (icon) {
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                    }
                    btn.innerHTML = '<i class="far fa-heart"></i> Lưu';
                }
            })
            .catch(function () {
                window.showAppNotification && window.showAppNotification('error', 'Có lỗi xảy ra, vui lòng thử lại.');
            });
    });
}

function initCartSelection() {
    var cartSummary = document.getElementById('cart-summary');
    if (!cartSummary) {
        return;
    }
    if (cartSummary.dataset.bound === '1') {
        return;
    }
    cartSummary.dataset.bound = '1';

    var selectAll = document.getElementById('selectAll');
    var itemChecks = Array.prototype.slice.call(document.querySelectorAll('.item-check'));
    var removeForm = document.getElementById('remove-selected-form');
    var removeInput = document.getElementById('remove-selected-items');
    var removeBtn = document.getElementById('btn-remove-selected');
    var checkoutBtn = document.getElementById('btn-checkout');

    var subtotalEl = document.getElementById('summary-subtotal');
    var discountEl = document.getElementById('summary-discount');
    var discountRow = document.getElementById('discount-row');
    var vatEl = document.getElementById('summary-vat');
    var shippingEl = document.getElementById('summary-shipping');
    var totalEl = document.getElementById('summary-total');
    var freeShipMessage = document.getElementById('free-ship-message');
    var freeShipPercent = document.getElementById('free-ship-percent');
    var freeShipProgress = document.getElementById('free-ship-progress');

    var freeShipThreshold = parseInt(cartSummary.dataset.freeShipThreshold || '0', 10);
    var shippingFeeDefault = parseInt(cartSummary.dataset.shippingFeeDefault || '0', 10);
    var vatRate = parseFloat(cartSummary.dataset.vatRate || '0');
    var discountType = cartSummary.dataset.discountType || '';
    var discountValue = parseInt(cartSummary.dataset.discountValue || '0', 10);
    var discountMax = parseInt(cartSummary.dataset.discountMax || '0', 10);
    var discountMin = parseInt(cartSummary.dataset.discountMin || '0', 10);

    function getSelectedItems() {
        return itemChecks.filter(function (item) { return item.checked; });
    }

    function syncSelectAll() {
        if (!selectAll) {
            return;
        }
        var allChecked = itemChecks.length > 0 && itemChecks.every(function (item) { return item.checked; });
        selectAll.checked = allChecked;
    }

    function updateSummary() {
        var selected = getSelectedItems();
        var subtotal = selected.reduce(function (sum, item) {
            var price = parseInt(item.dataset.price || '0', 10);
            var qty = parseInt(item.dataset.qty || '0', 10);
            return sum + price * qty;
        }, 0);

        var discount = 0;
        if (subtotal > 0 && discountType) {
            if (discountMin && subtotal < discountMin) {
                discount = 0;
            } else if (discountType === 'percent') {
                discount = Math.round(subtotal * (discountValue / 100));
                if (discountMax > 0) {
                    discount = Math.min(discount, discountMax);
                }
            } else {
                discount = discountValue;
            }
            discount = Math.min(discount, subtotal);
        }

        var afterDiscount = subtotal - discount;
        var vat = Math.round(afterDiscount * vatRate);
        var isFreeShip = subtotal >= freeShipThreshold;
        var shipping = isFreeShip ? 0 : shippingFeeDefault;
        var total = afterDiscount + vat + shipping;
        var progress = freeShipThreshold > 0 ? Math.min(100, (subtotal / freeShipThreshold) * 100) : 100;

        if (subtotalEl) subtotalEl.textContent = formatCurrency(subtotal);
        if (discountEl) discountEl.textContent = '- ' + formatCurrency(discount);
        if (discountRow) discountRow.style.display = discount > 0 ? '' : 'none';
        if (vatEl) vatEl.textContent = formatCurrency(vat);
        if (shippingEl) {
            shippingEl.innerHTML = isFreeShip
                ? '<i class="fas fa-check-circle"></i> Miễn phí'
                : formatCurrency(shipping);
        }
        if (totalEl) totalEl.textContent = formatCurrency(total);
        if (freeShipMessage) {
            freeShipMessage.innerHTML = isFreeShip
                ? '<strong class="text-success">Bạn đã đủ điều kiện miễn phí ship!</strong>'
                : 'Thêm ' + formatCurrency(Math.max(0, freeShipThreshold - subtotal)) + ' để được miễn phí ship';
        }
        if (freeShipPercent) freeShipPercent.textContent = Math.round(progress) + '%';
        if (freeShipProgress) freeShipProgress.style.width = Math.round(progress) + '%';

        if (removeBtn) {
            removeBtn.disabled = selected.length === 0;
        }
    }

    if (selectAll) {
        selectAll.addEventListener('change', function () {
            itemChecks.forEach(function (item) {
                item.checked = selectAll.checked;
            });
            updateSummary();
        });
    }

    itemChecks.forEach(function (item) {
        item.addEventListener('change', function () {
            syncSelectAll();
            updateSummary();
        });
    });

    if (removeForm) {
        removeForm.addEventListener('submit', function (event) {
            var selected = getSelectedItems().map(function (item) { return item.value; });
            if (selected.length === 0) {
                event.preventDefault();
                window.showAppNotification && window.showAppNotification('warning', 'Vui lòng chọn sản phẩm cần xóa.');
                return;
            }
            if (removeInput) {
                removeInput.value = selected.join(',');
            }
        });
    }

    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', function (event) {
            event.preventDefault();
            var selected = getSelectedItems().map(function (item) { return item.value; });
            if (selected.length === 0) {
                window.showAppNotification && window.showAppNotification('warning', 'Vui lòng chọn ít nhất một món để thanh toán.');
                return;
            }
            window.location.href = checkoutBtn.href + '?items=' + selected.join(',');
        });
    }

    updateSummary();
    syncSelectAll();
}

function getCsrfToken() {
    var meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
}

function updateCartBadge(count) {
    var cartLink = document.querySelector('.cart-hitem');
    if (!cartLink) {
        return;
    }

    var badge = cartLink.querySelector('.cart-badge');
    if (count > 0) {
        if (!badge) {
            badge = document.createElement('span');
            badge.className = 'cart-badge';
            cartLink.appendChild(badge);
        }
        badge.textContent = count;
    } else if (badge) {
        badge.remove();
    }
}

function handleCartResponse(data) {
    if (!data) {
        return;
    }

    if (data.message) {
        window.showAppNotification && window.showAppNotification(data.status || 'success', data.message);
    }

    if (typeof data.cart_count === 'number') {
        updateCartBadge(data.cart_count);
    }

    if (data.items_html) {
        var itemsWrapper = document.getElementById('cart-items-wrapper');
        if (itemsWrapper) {
            itemsWrapper.innerHTML = data.items_html;
        }
    }

    if (data.summary_html) {
        var summaryWrapper = document.getElementById('cart-summary-wrapper');
        if (summaryWrapper) {
            summaryWrapper.innerHTML = data.summary_html;
        }
    }

    initCartSelection();
}

function sendFormAjax(form) {
    var formData = new FormData(form);
    var method = (form.getAttribute('method') || 'POST').toUpperCase();
    var url = form.getAttribute('action');

    return fetch(url, {
        method: method,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken()
        },
        body: formData
    }).then(function (response) {
        return response.json().then(function (data) {
            return { ok: response.ok, status: response.status, data: data };
        });
    });
}

function initCartAjax() {
    document.addEventListener('submit', function (event) {
        var form = event.target;
        if (!form.classList || !form.classList.contains('js-cart-form')) {
            return;
        }

        event.preventDefault();
        sendFormAjax(form).then(function (result) {
            if (!result.ok) {
                handleCartResponse(result.data);
                return;
            }
            handleCartResponse(result.data);
        });
    });

    document.addEventListener('click', function (event) {
        var removeLink = event.target.closest('.js-cart-remove');
        if (!removeLink) {
            return;
        }
        event.preventDefault();

        fetch(removeLink.getAttribute('href'), {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
            .then(function (response) {
                return response.json().then(function (data) {
                    return { ok: response.ok, data: data };
                });
            })
            .then(function (result) {
                handleCartResponse(result.data);
            });
    });
}

function initWishlistAjax() {
    document.addEventListener('submit', function (event) {
        var form = event.target;
        if (!form.classList || !form.classList.contains('js-wishlist-form')) {
            return;
        }

        event.preventDefault();
        sendFormAjax(form).then(function (result) {
            if (!result.data) {
                return;
            }
            window.showAppNotification && window.showAppNotification('success', result.data.message || '');

            var button = form.querySelector('button');
            if (!button) {
                return;
            }

            if (result.data.action === 'added') {
                button.innerHTML = '<i class="fas fa-heart"></i> Yêu thích';
                form.setAttribute('data-action', 'remove');
                if (!form.querySelector('input[name="_method"]')) {
                    var method = document.createElement('input');
                    method.type = 'hidden';
                    method.name = '_method';
                    method.value = 'DELETE';
                    form.appendChild(method);
                }
            } else if (result.data.action === 'removed') {
                button.innerHTML = '<i class="far fa-heart"></i> Yêu thích';
                form.setAttribute('data-action', 'add');
                var methodInput = form.querySelector('input[name="_method"]');
                if (methodInput) {
                    methodInput.remove();
                }

                var wishlistCard = form.closest('.wishlist-card');
                if (wishlistCard) {
                    var wrapper = wishlistCard.closest('[class*="col-"]') || wishlistCard;
                    wrapper.remove();

                    var countEl = document.querySelector('.wishlist-count');
                    if (countEl) {
                        var current = parseInt(countEl.textContent, 10);
                        if (!isNaN(current) && current > 0) {
                            countEl.textContent = (current - 1) + ' sản phẩm';
                        }
                    }

                    var remaining = document.querySelectorAll('.wishlist-card').length;
                    if (remaining === 0) {
                        var listRow = document.querySelector('.wishlist-page .row.g-4');
                        if (listRow) {
                            listRow.innerHTML = '';
                        }
                        var container = document.querySelector('.wishlist-page .container');
                        if (container) {
                            var empty = document.createElement('div');
                            empty.className = 'wishlist-empty';
                            empty.innerHTML = '<i class="fas fa-heart-broken"></i>' +
                                '<h4>Chưa có sản phẩm yêu thích nào</h4>' +
                                '<p>Hãy khám phá thực đơn và lưu lại món bạn muốn sau.</p>' +
                                '<a href="/menu" class="btn btn-danger">Đi đến thực đơn</a>';
                            container.appendChild(empty);
                        }
                    }
                }
            }
        });
    });
}

function initOrderAjax() {
    document.addEventListener('submit', function (event) {
        var form = event.target;
        if (!form.classList || !form.classList.contains('js-cancel-order-form')) {
            return;
        }

        event.preventDefault();
        sendFormAjax(form).then(function (result) {
            if (!result.data) {
                return;
            }
            window.showAppNotification && window.showAppNotification(result.data.status || 'success', result.data.message || '');
            if (!result.ok) {
                return;
            }

            var orderId = form.getAttribute('data-order-id');
            if (!orderId) {
                return;
            }
            var row = document.querySelector('[data-order-id="' + orderId + '"]');
            if (row) {
                var statusCell = row.querySelector('[data-order-status]');
                if (statusCell) {
                    statusCell.textContent = result.data.order_status_text || 'Chờ duyệt hủy';
                }
            }
            var statusInline = document.querySelector('#order-actions[data-order-id="' + orderId + '"] [data-order-status]');
            if (statusInline) {
                statusInline.textContent = result.data.order_status_text || 'Chờ duyệt hủy';
            }
            form.remove();
        });
    });
}

function initMenuAjax() {
    var menuPage = document.querySelector('[data-menu-page]');
    if (!menuPage) {
        return;
    }

    var menuContent = document.getElementById('menu-content');
    var searchForm = document.getElementById('menu-search-form');

    function updateActiveFilters(url) {
        var params = new URL(url, window.location.origin).searchParams;
        var category = params.get('category') || '';
        var items = document.querySelectorAll('#menu-filters li');
        items.forEach(function (li) {
            var liCategory = li.getAttribute('data-category') || '';
            li.classList.toggle('active', liCategory === category);
        });

        if (searchForm) {
            var input = searchForm.querySelector('input[name="search"]');
            if (input) {
                input.value = params.get('search') || '';
            }
        }
    }

    function fetchMenu(url, pushState) {
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
            .then(function (response) { return response.json(); })
            .then(function (data) {
                if (data && data.html && menuContent) {
                    menuContent.innerHTML = data.html;
                    updateActiveFilters(url);
                    if (pushState) {
                        window.history.pushState({}, '', url);
                    }
                    if (typeof initIsotope === 'function') {
                        initIsotope();
                    }
                }
            });
    }

    if (searchForm) {
        searchForm.addEventListener('submit', function (event) {
            event.preventDefault();
            var formData = new FormData(searchForm);
            var params = new URLSearchParams(formData);
            var url = searchForm.getAttribute('action') + '?' + params.toString();
            fetchMenu(url, true);
        });
    }

    document.addEventListener('click', function (event) {
        var link = event.target.closest('.js-menu-filter');
        if (link) {
            event.preventDefault();
            fetchMenu(link.getAttribute('href'), true);
            return;
        }

        var paginationLink = event.target.closest('#menu-content .pagination a');
        if (paginationLink) {
            event.preventDefault();
            fetchMenu(paginationLink.getAttribute('href'), true);
        }
    });

    window.addEventListener('popstate', function () {
        fetchMenu(window.location.href, false);
    });
}

function initAddToCartAjax() {
    document.addEventListener('submit', function (event) {
        var form = event.target;
        if (!form.classList || !form.classList.contains('js-add-to-cart')) {
            return;
        }

        event.preventDefault();
        sendFormAjax(form).then(function (result) {
            if (!result.data) {
                return;
            }
            handleCartResponse(result.data);

            var modal = form.closest('.modal');
            if (modal && window.bootstrap) {
                var instance = window.bootstrap.Modal.getInstance(modal);
                if (instance) {
                    instance.hide();
                }
            }
        });
    });
}

function initPageLoader() {
    var loader = document.getElementById('page-loader');
    if (!loader) {
        return;
    }

    function showLoader() {
        loader.classList.remove('is-hidden');
    }

    function hideLoader() {
        loader.classList.add('is-hidden');
    }

    document.addEventListener('click', function (event) {
        var link = event.target.closest('a');
        if (!link) {
            return;
        }
        var href = link.getAttribute('href');
        if (!href || href.startsWith('#') || link.hasAttribute('data-no-loader') || link.target === '_blank') {
            return;
        }
        if (link.classList.contains('js-cart-remove')) {
            return;
        }
        if (link.classList.contains('js-menu-filter')) {
            return;
        }
        if (link.closest('#menu-content') && link.closest('.pagination')) {
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
        if (!form || form.classList.contains('js-cart-form') || form.classList.contains('js-add-to-cart')
            || form.classList.contains('js-wishlist-form') || form.classList.contains('js-cancel-order-form')
            || form.id === 'menu-search-form') {
            return;
        }
        showLoader();
    });

    window.addEventListener('pageshow', hideLoader);
    window.addEventListener('pagehide', showLoader);
}

document.addEventListener('DOMContentLoaded', function () {
    initAppNotification();
    initBlogSave();
    initCartSelection();
    initCartAjax();
    initWishlistAjax();
    initOrderAjax();
    initMenuAjax();
    initAddToCartAjax();
    initPageLoader();  
    initMobileMenu();
    initReloadPage();
});

(function ($) {
    "use strict";

    /*[ Load page ]
    ===========================================================*/
    $(".animsition").animsition({
        inClass: 'fade-in',
        outClass: 'fade-out',
        inDuration: 1500,
        outDuration: 800,
        linkElement: '.animsition-link',
        loading: false,
        loadingParentElement: 'html',
        loadingClass: 'animsition-loading-1',
        loadingInner: '<div class="cp-spinner cp-meter"></div>',
        timeout: false,
        timeoutCountdown: 5000,
        onLoadEvent: true,
        browser: ['animation-duration', '-webkit-animation-duration'],
        overlay: false,
        overlayClass: 'animsition-overlay-slide',
        overlayParentElement: 'html',
        transition: function (url) { window.location.href = url; }
    });

    /*[ Back to top ]
    ===========================================================*/
    var $backToTop = $('#myBtn');
    var windowH = $(window).height() / 2;

    function toggleBackToTop() {
        if ($(window).scrollTop() > windowH) {
            $backToTop.addClass('show-back-to-top');
        } else {
            $backToTop.removeClass('show-back-to-top');
        }
    }

    toggleBackToTop();
    $(window).on('scroll', toggleBackToTop);

    $backToTop.on('click', function (e) {
        e.preventDefault();
        $('html, body').animate({ scrollTop: 0 }, 300);
    });


    /*[ Select ]
    ===========================================================*/
    $(".selection-1").select2({
        minimumResultsForSearch: 20,
        dropdownParent: $('#dropDownSelect1')
    });

    /*[ Daterangepicker ]
    ===========================================================*/
    $('.my-calendar').daterangepicker({
        "singleDatePicker": true,
        "showDropdowns": true,
        locale: {
            format: 'DD/MM/YYYY'
        },
    });

    var myCalendar = $('.my-calendar');
    var isClick = 0;

    $(window).on('click', function () {
        isClick = 0;
    });

    $(myCalendar).on('apply.daterangepicker', function () {
        isClick = 0;
    });

    $('.btn-calendar').on('click', function (e) {
        e.stopPropagation();

        if (isClick == 1) isClick = 0;
        else if (isClick == 0) isClick = 1;

        if (isClick == 1) {
            myCalendar.focus();
        }
    });

    $(myCalendar).on('click', function (e) {
        e.stopPropagation();
        isClick = 1;
    });

    $('.daterangepicker').on('click', function (e) {
        e.stopPropagation();
    });


    /*[ Video modal: stop audio when closed ]
    ===========================================================*/
    function bindVideoModal(modalSelector) {
        var $modal = $(modalSelector);
        if (!$modal.length) {
            return;
        }

        var $iframe = $modal.find('iframe').first();
        if (!$iframe.length) {
            return;
        }

        var baseSrc = $iframe.attr('data-src') || $iframe.attr('src') || '';
        $iframe.attr('data-src', baseSrc);

        $modal.on('show.bs.modal', function () {
            if (!baseSrc) {
                return;
            }

            var videoSrc = baseSrc;
            if (videoSrc.indexOf('autoplay=1') === -1) {
                videoSrc += (videoSrc.indexOf('?') === -1 ? '?' : '&') + 'autoplay=1';
            }

            $iframe.attr('src', videoSrc);
        });

        $modal.on('hidden.bs.modal', function () {
            // Force-stop video to prevent background audio
            $iframe.attr('src', '');
            $iframe.attr('src', baseSrc);
        });
    }

    bindVideoModal('#videoModal');
    bindVideoModal('#modal-video-01');


    /*[ Fixed Header ]
    ===========================================================*/
    var header = $('header');
    var logo = $(header).find('.logo img');
    var linkLogo1 = $(logo).attr('src');
    var linkLogo2 = $(logo).data('logofixed');

    function syncHeaderFixedState() {
        var shouldFix = $(window).scrollTop() > 20 && $(window).width() > 992;

        if (shouldFix) {
            if (linkLogo2) {
                $(logo).attr('src', linkLogo2);
            }
            $(header).addClass('header-fixed');
            return;
        }

        $(header).removeClass('header-fixed');
        $(logo).attr('src', linkLogo1);
    }

    syncHeaderFixedState();
    $(window).on('scroll resize', syncHeaderFixedState);

    /*[ Show/hide sidebar ]
    ===========================================================*/
    $('body').append('<div class="overlay-sidebar trans-0-4"></div>');
    var ovlSideBar = $('.overlay-sidebar');
    var btnShowSidebar = $('.btn-show-sidebar');
    var btnHideSidebar = $('.btn-hide-sidebar');
    var sidebar = $('.sidebar');

    $(btnShowSidebar).on('click', function () {
        $(sidebar).addClass('show-sidebar');
        $(ovlSideBar).addClass('show-overlay-sidebar');
    })

    $(btnHideSidebar).on('click', function () {
        $(sidebar).removeClass('show-sidebar');
        $(ovlSideBar).removeClass('show-overlay-sidebar');
    })

    $(ovlSideBar).on('click', function () {
        $(sidebar).removeClass('show-sidebar');
        $(ovlSideBar).removeClass('show-overlay-sidebar');
    })


    /*[ Isotope ]
    ===========================================================*/
    var $topeContainer = $('.isotope-grid');
    var $filter = $('.filter-tope-group');

    // filter items on button click
    $filter.each(function () {
        $filter.on('click', 'button', function () {
            var filterValue = $(this).attr('data-filter');
            $topeContainer.isotope({ filter: filterValue });
        });

    });

    // init Isotope
    $(window).on('load', function () {
        var $grid = $topeContainer.each(function () {
            $(this).isotope({
                itemSelector: '.Isotope-item',
                percentPosition: true,
                animationEngine: 'best-available',
                masonry: {
                    columnWidth: '.isotope-item'
                }
            });
        });
    });

    var labelGallerys = $('.label-gallery');

    $(labelGallerys).each(function () {
        $(this).on('click', function () {
            for (var i = 0; i < labelGallerys.length; i++) {
                $(labelGallerys[i]).removeClass('is-actived');
            }

            $(this).addClass('is-actived');
        });
    });



})(jQuery);/*[ Isotope Init ]
===========================================================*/
function initIsotope() {
    var $grid = $('.grid');
    if (!$grid.length || typeof $.fn.isotope !== 'function') {
        return;
    }

    $grid.isotope({
        itemSelector: '.all',
        layoutMode: 'fitRows',
        percentPosition: true,
    });
}

// Init isotope once after DOM ready (script already loaded in layout)
$(document).ready(function () {
    if (typeof $.fn.isotope === 'function') {
        initIsotope();
    }
});
// Admin products: xác nhận xóa
(function () {
    document.addEventListener('submit', function (event) {
        var form = event.target;
        if (!form.classList || !form.classList.contains('js-delete-product-form')) {
            return;
        }

        var name = form.getAttribute('data-product-name') || 'sản phẩm này';
        var ok = window.confirm('Bạn có chắc chắn muốn xóa ' + name + '?');

        if (!ok) {
            event.preventDefault();
        }
    });
})();

// Admin customers: xác nhận xóa
(function () {
    document.addEventListener('submit', function (event) {
        var form = event.target;
        if (!form.classList || !form.classList.contains('js-delete-customer-form')) {
            return;
        }

        var name = form.getAttribute('data-customer-name') || 'khách hàng này';
        var ok = window.confirm('Bạn có chắc chắn muốn xóa ' + name + '?');

        if (!ok) {
            event.preventDefault();
        }
    });
})();

// Admin coupons: xác nhận xóa
(function () {
    document.addEventListener('submit', function (event) {
        var form = event.target;
        if (!form.classList || !form.classList.contains('js-delete-coupon-form')) {
            return;
        }

        var code = form.getAttribute('data-coupon-code') || 'mã giảm giá này';
        var ok = window.confirm('Bạn có chắc chắn muốn xóa ' + code + '?');

        if (!ok) {
            event.preventDefault();
        }
    });
})();

// Admin roles: xác nhận xóa
(function () {
    document.addEventListener('submit', function (event) {
        var form = event.target;
        if (!form.classList || !form.classList.contains('js-delete-role-form')) {
            return;
        }

        var roleName = form.getAttribute('data-role-name') || 'vai trò này';
        var ok = window.confirm('Bạn có chắc chắn muốn xóa vai trò ' + roleName + '?');

        if (!ok) {
            event.preventDefault();
        }
    });
})();

// Client-side validation for key forms
(function () {
    function showError(message) {
        window.alert(message);
    }

    document.addEventListener('submit', function (event) {
        var form = event.target;
        if (!form || form.tagName !== 'FORM') {
            return;
        }

        var action = (form.getAttribute('action') || '').toLowerCase();
        var method = (form.getAttribute('method') || 'get').toLowerCase();

        // Register form
        if (form.id === 'registerForm') {
            var fullName = (form.querySelector('[name="full_name"]') || {}).value || '';
            var phone = (form.querySelector('[name="phone"]') || {}).value || '';
            var password = (form.querySelector('[name="password"]') || {}).value || '';
            var passwordConfirmation = (form.querySelector('[name="password_confirmation"]') || {}).value || '';

            if (fullName.trim().length < 3) {
                event.preventDefault();
                showError('Họ và tên phải có ít nhất 3 ký tự.');
                return;
            }
            if (!/^0\d{9}$/.test(phone.trim())) {
                event.preventDefault();
                showError('Số điện thoại không hợp lệ. Định dạng: 0xxxxxxxxx.');
                return;
            }
            if (password.length < 6) {
                event.preventDefault();
                showError('Mật khẩu phải có ít nhất 6 ký tự.');
                return;
            }
            if (password !== passwordConfirmation) {
                event.preventDefault();
                showError('Xác nhận mật khẩu không khớp.');
                return;
            }
        }

        // Checkout form
        if (method === 'post' && action.indexOf('/checkout') !== -1) {
            var shippingName = (form.querySelector('[name="shipping_name"]') || {}).value || '';
            var shippingPhone = (form.querySelector('[name="shipping_phone"]') || {}).value || '';
            var shippingAddress = (form.querySelector('[name="shipping_address"]') || {}).value || '';
            var paymentMethod = form.querySelector('input[name="payment_method"]:checked');

            if (shippingName.trim().length < 2) {
                event.preventDefault();
                showError('Vui lòng nhập họ và tên hợp lệ.');
                return;
            }
            if (!/^0\d{9}$/.test(shippingPhone.trim())) {
                event.preventDefault();
                showError('Số điện thoại nhận hàng không hợp lệ.');
                return;
            }
            if (shippingAddress.trim().length < 10) {
                event.preventDefault();
                showError('Địa chỉ giao hàng cần chi tiết hơn.');
                return;
            }
            if (!paymentMethod) {
                event.preventDefault();
                showError('Vui lòng chọn phương thức thanh toán.');
                return;
            }
        }

        // Admin create product form
        if (method === 'post' && action.indexOf('/admin/products') !== -1 && action.indexOf('/stock-in') === -1) {
            var name = (form.querySelector('[name="name"]') || {}).value || '';
            var price = parseInt((form.querySelector('[name="base_price_cents"]') || {}).value || '0', 10);
            var stock = parseInt((form.querySelector('[name="stock"]') || {}).value || '0', 10);

            if (name.trim().length < 2) {
                event.preventDefault();
                showError('Tên sản phẩm phải có ít nhất 2 ký tự.');
                return;
            }
            if (isNaN(price) || price < 0) {
                event.preventDefault();
                showError('Giá sản phẩm không hợp lệ.');
                return;
            }
            if (isNaN(stock) || stock < 0) {
                event.preventDefault();
                showError('Số lượng tồn không hợp lệ.');
            }
        }
    });
})();

// Admin users: xác nhận xóa
(function () {
    document.addEventListener('submit', function (event) {
        var form = event.target;
        if (!form.classList || !form.classList.contains('js-delete-user-form')) {
            return;
        }

        var name = form.getAttribute('data-user-name') || 'tài khoản này';
        var ok = window.confirm('Bạn có chắc chắn muốn xóa tài khoản ' + name + '?');

        if (!ok) {
            event.preventDefault();
        }
    });
})();

// Admin categories: xác nhận xóa
(function () {
    document.addEventListener('submit', function (event) {
        var form = event.target;
        if (!form.classList || !form.classList.contains('js-delete-category-form')) {
            return;
        }

        var name = form.getAttribute('data-category-name') || 'danh mục này';
        var ok = window.confirm('Bạn có chắc chắn muốn xóa danh mục ' + name + '?');

        if (!ok) {
            event.preventDefault();
        }
    });
})();

// Frontend gallery: horizontal carousel
$(document).ready(function () {
    var $gallery = $('.noodle-gallery-slider');
    if (!$gallery.length || typeof $gallery.slick !== 'function') {
        return;
    }

    if ($gallery.hasClass('slick-initialized')) {
        return;
    }

    $gallery.slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        infinite: true,
        arrows: false,
        dots: false,
        autoplay: true,
        autoplaySpeed: 0,
        speed: 4500,
        cssEase: 'linear',
        pauseOnHover: false,
        pauseOnFocus: false,
        responsive: [
            {
                breakpoint: 992,
                settings: { slidesToShow: 3 }
            },
            {
                breakpoint: 576,
                settings: { slidesToShow: 2 }
            }
        ]
    });
});


function initReloadPage() {
    var reloadPage = document.querySelector('.reload-page');
    if (!reloadPage) {
        return;
    }

    var target = reloadPage.getAttribute('data-reload-target') || '';
    if (!target) {
        return;
    }

    setTimeout(function () {
        window.location.replace(target);
    }, 300);
}