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
                itemSelector: '.isotope-item',
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

// Admin roles: delete confirmation
(function () {
    document.addEventListener('submit', function (event) {
        var form = event.target;
        if (!form.classList || !form.classList.contains('js-delete-role-form')) {
            return;
        }

        var roleName = form.getAttribute('data-role-name') || 'vai tro nay';
        var ok = window.confirm('Ban co chac chan muon xoa vai tro ' + roleName + '?');

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
                showError('Há» vÃ  tÃªn pháº£i cÃ³ Ã­t nháº¥t 3 kÃ½ tá»±.');
                return;
            }
            if (!/^0\d{9}$/.test(phone.trim())) {
                event.preventDefault();
                showError('Sá»‘ Ä‘iá»‡n thoáº¡i khÃ´ng há»£p lá»‡. Äá»‹nh dáº¡ng: 0xxxxxxxxx.');
                return;
            }
            if (password.length < 6) {
                event.preventDefault();
                showError('Máº­t kháº©u pháº£i cÃ³ Ã­t nháº¥t 6 kÃ½ tá»±.');
                return;
            }
            if (password !== passwordConfirmation) {
                event.preventDefault();
                showError('XÃ¡c nháº­n máº­t kháº©u khÃ´ng khá»›p.');
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
                showError('Vui lÃ²ng nháº­p há» vÃ  tÃªn há»£p lá»‡.');
                return;
            }
            if (!/^0\d{9}$/.test(shippingPhone.trim())) {
                event.preventDefault();
                showError('Sá»‘ Ä‘iá»‡n thoáº¡i nháº­n hÃ ng khÃ´ng há»£p lá»‡.');
                return;
            }
            if (shippingAddress.trim().length < 10) {
                event.preventDefault();
                showError('Äá»‹a chá»‰ giao hÃ ng cáº§n chi tiáº¿t hÆ¡n.');
                return;
            }
            if (!paymentMethod) {
                event.preventDefault();
                showError('Vui lÃ²ng chá»n phÆ°Æ¡ng thá»©c thanh toÃ¡n.');
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
                showError('TÃªn sáº£n pháº©m pháº£i cÃ³ Ã­t nháº¥t 2 kÃ½ tá»±.');
                return;
            }
            if (isNaN(price) || price < 0) {
                event.preventDefault();
                showError('GiÃ¡ sáº£n pháº©m khÃ´ng há»£p lá»‡.');
                return;
            }
            if (isNaN(stock) || stock < 0) {
                event.preventDefault();
                showError('Sá»‘ lÆ°á»£ng tá»“n khÃ´ng há»£p lá»‡.');
            }
        }
    });
})();

// Admin users: delete confirmation
(function () {
    document.addEventListener('submit', function (event) {
        var form = event.target;
        if (!form.classList || !form.classList.contains('js-delete-user-form')) {
            return;
        }

        var name = form.getAttribute('data-user-name') || 'tai khoan nay';
        var ok = window.confirm('Ban co chac chan muon xoa tai khoan ' + name + '?');

        if (!ok) {
            event.preventDefault();
        }
    });
})();

// Admin categories: delete confirmation
(function () {
    document.addEventListener('submit', function (event) {
        var form = event.target;
        if (!form.classList || !form.classList.contains('js-delete-category-form')) {
            return;
        }

        var name = form.getAttribute('data-category-name') || 'danh muc nay';
        var ok = window.confirm('Ban co chac chan muon xoa danh muc ' + name + '?');

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

// Admin notifications: delete confirmation
(function () {
    document.addEventListener('submit', function (event) {
        var form = event.target;
        if (!form.classList || !form.classList.contains('js-delete-notification-form')) {
            return;
        }

        var title = form.getAttribute('data-notification-title') || 'thong bao nay';
        var ok = window.confirm('Ban co chac chan muon xoa thong bao: ' + title + '?');

        if (!ok) {
            event.preventDefault();
        }
    });
})();

