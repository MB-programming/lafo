/**
 * Navigation Scripts for EduPress Theme
 */

(function($) {
    'use strict';

    $(document).ready(function() {

        // Mobile Menu Toggle
        $('.mobile-menu-toggle').on('click', function() {
            $(this).toggleClass('active');
            $('.mobile-navigation').toggleClass('active');

            // Toggle icon
            const icon = $(this).find('i');
            if (icon.hasClass('fa-bars')) {
                icon.removeClass('fa-bars').addClass('fa-times');
            } else {
                icon.removeClass('fa-times').addClass('fa-bars');
            }

            // Prevent body scroll when menu is open
            $('body').toggleClass('menu-open');
        });

        // Close mobile menu when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.mobile-menu-toggle, .mobile-navigation').length) {
                $('.mobile-navigation').removeClass('active');
                $('.mobile-menu-toggle').removeClass('active');
                $('.mobile-menu-toggle i').removeClass('fa-times').addClass('fa-bars');
                $('body').removeClass('menu-open');
            }
        });

        // Close mobile menu when window is resized to desktop
        $(window).on('resize', function() {
            if ($(window).width() > 768) {
                $('.mobile-navigation').removeClass('active');
                $('.mobile-menu-toggle').removeClass('active');
                $('.mobile-menu-toggle i').removeClass('fa-times').addClass('fa-bars');
                $('body').removeClass('menu-open');
            }
        });

        // Sticky Header on Scroll
        let lastScrollTop = 0;
        const header = $('.site-header');
        const headerHeight = header.outerHeight();

        $(window).on('scroll', function() {
            const scrollTop = $(this).scrollTop();

            if (scrollTop > headerHeight) {
                header.addClass('scrolled');

                // Hide header on scroll down, show on scroll up
                if (scrollTop > lastScrollTop) {
                    header.css('transform', 'translateY(-100%)');
                } else {
                    header.css('transform', 'translateY(0)');
                }
            } else {
                header.removeClass('scrolled');
                header.css('transform', 'translateY(0)');
            }

            lastScrollTop = scrollTop;
        });

        // Smooth Scroll for Anchor Links
        $('a[href*="#"]').not('[href="#"]').not('[href="#0"]').on('click', function(e) {
            if (
                location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') &&
                location.hostname === this.hostname
            ) {
                let target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');

                if (target.length) {
                    e.preventDefault();
                    $('html, body').animate({
                        scrollTop: target.offset().top - headerHeight
                    }, 800);
                }
            }
        });

        // Add active class to current menu item
        const currentUrl = window.location.href;
        $('.main-navigation a, .mobile-nav-menu a').each(function() {
            if (this.href === currentUrl) {
                $(this).addClass('active');
                $(this).parents('li').addClass('active');
            }
        });

        // Dropdown Menu Accessibility
        $('.main-navigation .menu-item-has-children > a').on('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                $(this).parent().toggleClass('open');
            }
        });

        // Focus trap in mobile menu
        const focusableElements = '.mobile-navigation a, .mobile-navigation button';
        const mobileNav = $('.mobile-navigation');

        mobileNav.on('keydown', function(e) {
            if (e.key === 'Tab') {
                const focusable = mobileNav.find(focusableElements).filter(':visible');
                const firstFocusable = focusable.first();
                const lastFocusable = focusable.last();

                if (e.shiftKey) {
                    if (document.activeElement === firstFocusable[0]) {
                        e.preventDefault();
                        lastFocusable.focus();
                    }
                } else {
                    if (document.activeElement === lastFocusable[0]) {
                        e.preventDefault();
                        firstFocusable.focus();
                    }
                }
            }

            if (e.key === 'Escape') {
                $('.mobile-menu-toggle').trigger('click');
                $('.mobile-menu-toggle').focus();
            }
        });

    });

})(jQuery);
