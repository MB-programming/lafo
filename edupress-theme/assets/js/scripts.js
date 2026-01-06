/**
 * Main Scripts for EduPress Theme
 */

(function($) {
    'use strict';

    $(document).ready(function() {

        // Scroll to Top Button
        const scrollTopBtn = $('<button id="scroll-to-top" aria-label="الانتقال إلى الأعلى"><i class="fas fa-arrow-up"></i></button>');
        $('body').append(scrollTopBtn);

        $(window).on('scroll', function() {
            if ($(this).scrollTop() > 300) {
                scrollTopBtn.addClass('visible');
            } else {
                scrollTopBtn.removeClass('visible');
            }
        });

        scrollTopBtn.on('click', function() {
            $('html, body').animate({ scrollTop: 0 }, 600);
        });

        // Course Filter Functionality
        $('#category-filter, #level-filter').on('change', function() {
            const category = $('#category-filter').val();
            const level = $('#level-filter').val();

            let url = new URL(window.location);

            if (category) {
                url.searchParams.set('course_category', category);
            } else {
                url.searchParams.delete('course_category');
            }

            if (level) {
                url.searchParams.set('course_level', level);
            } else {
                url.searchParams.delete('course_level');
            }

            window.location.href = url.toString();
        });

        // Lazy Loading for Images
        if ('loading' in HTMLImageElement.prototype) {
            const images = document.querySelectorAll('img[loading="lazy"]');
            images.forEach(img => {
                img.src = img.dataset.src;
            });
        } else {
            // Fallback for browsers that don't support lazy loading
            const script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js';
            document.body.appendChild(script);
        }

        // Form Validation
        $('form').on('submit', function(e) {
            let isValid = true;

            $(this).find('input[required], textarea[required], select[required]').each(function() {
                if (!$(this).val()) {
                    isValid = false;
                    $(this).addClass('error');

                    if (!$(this).next('.error-message').length) {
                        $(this).after('<span class="error-message" style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">هذا الحقل مطلوب</span>');
                    }
                } else {
                    $(this).removeClass('error');
                    $(this).next('.error-message').remove();
                }
            });

            if (!isValid) {
                e.preventDefault();
            }
        });

        // Remove error message on input
        $('input, textarea, select').on('input change', function() {
            if ($(this).val()) {
                $(this).removeClass('error');
                $(this).next('.error-message').remove();
            }
        });

        // Card Hover Animation
        $('.card').each(function() {
            $(this).on('mouseenter', function() {
                $(this).css('transform', 'translateY(-5px)');
            });

            $(this).on('mouseleave', function() {
                $(this).css('transform', 'translateY(0)');
            });
        });

        // Stats Counter Animation
        function animateCounter(element) {
            const target = parseInt(element.text().replace(/[^0-9]/g, ''));
            const duration = 2000;
            const increment = target / (duration / 16);
            let current = 0;

            const timer = setInterval(function() {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }

                let displayValue = Math.floor(current);
                if (element.text().includes('+')) {
                    displayValue = displayValue.toLocaleString() + '+';
                } else if (element.text().includes('%')) {
                    displayValue = displayValue + '%';
                } else {
                    displayValue = displayValue.toLocaleString();
                }

                element.text(displayValue);
            }, 16);
        }

        // Intersection Observer for Stats Animation
        if ('IntersectionObserver' in window) {
            const statsObserver = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        $(entry.target).find('.stat-number').each(function() {
                            animateCounter($(this));
                        });
                        statsObserver.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.5 });

            $('.stats-section').each(function() {
                statsObserver.observe(this);
            });
        }

        // Video Modal/Lightbox
        $('a[href*="youtube.com"], a[href*="vimeo.com"]').on('click', function(e) {
            const videoUrl = $(this).attr('href');

            if (!$(this).hasClass('no-lightbox')) {
                e.preventDefault();

                let embedUrl = '';
                if (videoUrl.includes('youtube.com')) {
                    const videoId = videoUrl.match(/v=([^&]+)/)[1];
                    embedUrl = `https://www.youtube.com/embed/${videoId}?autoplay=1`;
                } else if (videoUrl.includes('vimeo.com')) {
                    const videoId = videoUrl.match(/vimeo.com\/(\d+)/)[1];
                    embedUrl = `https://player.vimeo.com/video/${videoId}?autoplay=1`;
                }

                const modal = $(`
                    <div class="video-modal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 9999; display: flex; align-items: center; justify-content: center;">
                        <div class="video-container" style="width: 90%; max-width: 900px; position: relative;">
                            <button class="close-modal" style="position: absolute; top: -40px; right: 0; background: none; border: none; color: #fff; font-size: 2rem; cursor: pointer;">&times;</button>
                            <iframe src="${embedUrl}" width="100%" height="500" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
                        </div>
                    </div>
                `);

                $('body').append(modal);

                modal.on('click', function(e) {
                    if ($(e.target).is('.video-modal') || $(e.target).is('.close-modal')) {
                        modal.fadeOut(300, function() {
                            $(this).remove();
                        });
                    }
                });
            }
        });

        // Print Button
        $('.print-page').on('click', function(e) {
            e.preventDefault();
            window.print();
        });

        // Share Buttons
        $('.share-facebook').on('click', function(e) {
            e.preventDefault();
            const url = encodeURIComponent(window.location.href);
            window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, 'facebook-share', 'width=580,height=296');
        });

        $('.share-twitter').on('click', function(e) {
            e.preventDefault();
            const url = encodeURIComponent(window.location.href);
            const text = encodeURIComponent(document.title);
            window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, 'twitter-share', 'width=580,height=296');
        });

        $('.share-linkedin').on('click', function(e) {
            e.preventDefault();
            const url = encodeURIComponent(window.location.href);
            window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${url}`, 'linkedin-share', 'width=580,height=296');
        });

        // Copy to Clipboard
        $('.copy-link').on('click', function(e) {
            e.preventDefault();
            const url = window.location.href;

            if (navigator.clipboard) {
                navigator.clipboard.writeText(url).then(function() {
                    alert('تم نسخ الرابط بنجاح!');
                });
            } else {
                // Fallback for older browsers
                const tempInput = $('<input>');
                $('body').append(tempInput);
                tempInput.val(url).select();
                document.execCommand('copy');
                tempInput.remove();
                alert('تم نسخ الرابط بنجاح!');
            }
        });

        // Tooltip Initialization (if using a tooltip library)
        if (typeof $.fn.tooltip !== 'undefined') {
            $('[data-toggle="tooltip"]').tooltip();
        }

        // Console Message
        console.log('%c🎓 EduPress Theme', 'font-size: 20px; font-weight: bold; color: #2563eb;');
        console.log('%cمرحباً بك في موقع EduPress التعليمي!', 'font-size: 14px; color: #64748b;');

    });

    // Window Load Event
    $(window).on('load', function() {
        // Remove loading class from body if it exists
        $('body').removeClass('loading');

        // Trigger a custom event for other scripts
        $(document).trigger('edupressLoaded');
    });

})(jQuery);
