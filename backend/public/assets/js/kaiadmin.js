document.addEventListener('livewire:navigate', (event) => {
    "use strict";

    // Sync logo header from sidebar to main header
    const logoHeaderContent = document.querySelector('.sidebar .logo-header')?.innerHTML;
    if (logoHeaderContent) {
        document.querySelector('.main-header .logo-header').innerHTML = logoHeaderContent;
    }

    // Input focus for nav search
    document.querySelectorAll('.nav-search .input-group > input').forEach(input => {
        input.addEventListener('focus', () => input.closest('.input-group').classList.add('focus'));
        input.addEventListener('blur', () => input.closest('.input-group').classList.remove('focus'));
    });

    // Initialize Bootstrap tooltips and popovers
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => new bootstrap.Tooltip(el));
    document.querySelectorAll('[data-bs-toggle="popover"]').forEach(el => new bootstrap.Popover(el));

    // Layout color handling
    const layoutsColors = () => {
        if (document.querySelector('.sidebar')?.hasAttribute('data-background-color')) {
            document.documentElement.classList.add('sidebar-color');
        } else {
            document.documentElement.classList.remove('sidebar-color');
        }
    };

    // Custom background color handling
    const customBackgroundColor = () => {
        document.querySelectorAll('*[data-background-color="custom"]').forEach(el => {
            if (el.hasAttribute('custom-color')) {
                el.style.background = el.getAttribute('custom-color');
            } else if (el.hasAttribute('custom-background')) {
                el.style.backgroundImage = `url(${el.getAttribute('custom-background')})`;
            }
        });
    };

    layoutsColors();
    customBackgroundColor();

    // Legend click callback for charts
    function legendClickCallback(event) {
        event = event || window.event;
        let target = event.target || event.srcElement;
        while (target.nodeName !== 'LI') {
            target = target.parentElement;
        }
        const parent = target.parentElement;
        const chartId = parseInt(parent.classList[0].split("-")[0], 10);
        const chart = Chart.instances[chartId];
        const index = Array.prototype.indexOf.call(parent.children, target);

        chart.legend.options.onClick.call(chart, event, chart.legend.legendItems[index]);
        target.classList.toggle('hidden', !chart.isDatasetVisible(index));
    }

    // Wait for DOM ready
    document.addEventListener('DOMContentLoaded', () => {

        // Refresh card
        document.querySelectorAll('.btn-refresh-card').forEach(btn => {
            btn.addEventListener('click', () => {
                const card = btn.closest('.card');
                if (card) {
                    card.classList.add('is-loading');
                    setTimeout(() => card.classList.remove('is-loading'), 3000);
                }
            });
        });

        // Initialize scrollbars
        const scrollbarSelectors = [
            '.sidebar .scrollbar',
            '.main-panel .content-scroll',
            '.messages-scroll',
            '.tasks-scroll',
            '.quick-scroll',
            '.message-notif-scroll',
            '.notif-scroll',
            '.quick-actions-scroll',
            '.dropdown-user-scroll'
        ];

        scrollbarSelectors.forEach(selector => {
            document.querySelectorAll(selector).forEach(el => $(el).scrollbar());
        });

        // Search nav collapse focus
        $('#search-nav').on('shown.bs.collapse', () => $('.nav-search .form-control').focus());

        // Sidebar toggle states
        let nav_open = 0,
            quick_sidebar_open = 0,
            topbar_open = 0,
            mini_sidebar = 0,
            page_sidebar_open = 0,
            overlay_sidebar_open = 0,
            first_toggle_sidebar = false;

        // Sidebar toggle
        $('.sidenav-toggler').on('click', function () {
            nav_open = nav_open ? 0 : 1;
            document.documentElement.classList.toggle('nav_open', !!nav_open);
            $(this).toggleClass('toggled', !!nav_open);
        });

        // Quick sidebar toggle
        $('.quick-sidebar-toggler').on('click', function () {
            quick_sidebar_open = quick_sidebar_open ? 0 : 1;
            document.documentElement.classList.toggle('quick_sidebar_open', !!quick_sidebar_open);
            $(this).toggleClass('toggled', !!quick_sidebar_open);
            if (quick_sidebar_open) $('<div class="quick-sidebar-overlay"></div>').insertAfter('.quick-sidebar');
            else $('.quick-sidebar-overlay').remove();
        });

        // Close quick sidebar on overlay click
        $('.wrapper').on('mouseup', e => {
            const sidebar = document.querySelector('.quick-sidebar');
            if (!sidebar.contains(e.target)) {
                document.documentElement.classList.remove('quick_sidebar_open');
                $('.quick-sidebar-toggler').removeClass('toggled');
                $('.quick-sidebar-overlay').remove();
                quick_sidebar_open = 0;
            }
        });
        $(".close-quick-sidebar").on('click', () => {
            document.documentElement.classList.remove('quick_sidebar_open');
            $('.quick-sidebar-toggler').removeClass('toggled');
            $('.quick-sidebar-overlay').remove();
            quick_sidebar_open = 0;
        });

        // Topbar toggle
        $('.topbar-toggler').on('click', function () {
            topbar_open = topbar_open ? 0 : 1;
            document.documentElement.classList.toggle('topbar_open', !!topbar_open);
            $(this).toggleClass('toggled', !!topbar_open);
        });

        // Minimize sidebar
        const minibutton = $('.toggle-sidebar');
        if ($('.wrapper').hasClass('sidebar_minimize')) {
            minibutton.addClass('toggled').html('<i class="gg-more-vertical-alt"></i>');
            mini_sidebar = 1;
        }
        minibutton.on('click', function () {
            mini_sidebar = mini_sidebar ? 0 : 1;
            $('.wrapper').toggleClass('sidebar_minimize', !!mini_sidebar);
            minibutton.toggleClass('toggled', !!mini_sidebar);
            minibutton.html(mini_sidebar ? '<i class="gg-more-vertical-alt"></i>' : '<i class="gg-menu-right"></i>');
            $(window).trigger('resize');
            first_toggle_sidebar = true;
        });

        // Overlay sidebar toggle
        $('.sidenav-overlay-toggler').on('click', function () {
            overlay_sidebar_open = overlay_sidebar_open ? 0 : 1;
            $('.wrapper').toggleClass('is-show', !!overlay_sidebar_open);
            $(this).toggleClass('toggled', !!overlay_sidebar_open);
            $(this).html(overlay_sidebar_open ? '<i class="icon-options-vertical"></i>' : '<i class="icon-menu"></i>');
            $(window).trigger('resize');
        });

        // Sidebar hover for mini
        $('.sidebar').hover(
            () => { if (mini_sidebar && !first_toggle_sidebar) $('.wrapper').addClass('sidebar_minimize_hover'); },
            () => { if (mini_sidebar && first_toggle_sidebar) $('.wrapper').removeClass('sidebar_minimize_hover'); first_toggle_sidebar = false; }
        );

        // Nav-item submenu toggle
        $(".nav-item a").on('click', function () {
            $(this).parent().toggleClass('submenu', !$(this).parent().find('.collapse').hasClass("show"));
        });

        // Chat toggle
        $('.messages-contact .user a').on('click', () => $('.tab-chat').addClass('show-chat'));
        $('.messages-wrapper .return').on('click', () => $('.tab-chat').removeClass('show-chat'));

        // Select all checkboxes
        $('[data-select="checkbox"]').on('change', function () {
            const target = $(this).attr('data-target');
            $(target).prop('checked', $(this).prop("checked"));
        });

        // Form group focus
        $(".form-group-default .form-control").on('focus', function () { $(this).parent().addClass("active"); })
            .on('blur', function () { $(this).parent().removeClass("active"); });
    });

    // Input file preview
    function readURL(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => $(input).closest('.input-file-image').find('.img-upload-preview').attr('src', e.target.result);
            reader.readAsDataURL(input.files[0]);
        }
    }
    $('.input-file-image input[type="file"]').on('change', function () { readURL(this); });

    // Show/hide password
    $('.show-password').on('click', function () {
        const input = $(this).closest('.input-group').find('input');
        input.attr('type', input.attr('type') === 'password' ? 'text' : 'password');
    });

    // Sign In / Sign Up toggle
    let showSignIn = true, showSignUp = false;
    const containerSignIn = $('.container-login'), containerSignUp = $('.container-signup');
    const changeContainer = () => {
        containerSignIn.toggle(showSignIn);
        containerSignUp.toggle(showSignUp);
    };
    $('#show-signup').on('click', () => { showSignUp = true; showSignIn = false; changeContainer(); });
    $('#show-signin').on('click', () => { showSignUp = false; showSignIn = true; changeContainer(); });
    changeContainer();

    // Floating label
    $('.form-floating-label .form-control').on('keyup', function () {
        $(this).toggleClass('filled', $(this).val() !== '');
    });
});
