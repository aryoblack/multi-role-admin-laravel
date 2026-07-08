/**
 * App Enhancements - Modern UI Interactions
 * Version: 1.0.0
 */

(function($) {
    'use strict';

    // ============================================
    // PAGE LOADER
    // ============================================
    const PageLoader = {
        init: function() {
            // Hide loader when page is fully loaded
            $(window).on('load', function() {
                $('.page-loader').fadeOut(300);
            });
        }
    };

    // ============================================
    // SIDEBAR ENHANCEMENTS
    // ============================================
    const SidebarEnhancements = {
        init: function() {
            this.handleCollapse();
            this.handleActiveState();
            this.handleMobileClose();
        },

        handleCollapse: function() {
            // Smooth collapse animation
            $('.nav-link[data-bs-toggle="collapse"]').on('click', function() {
                const $this = $(this);
                const $arrow = $this.find('.nav-arrow i');
                
                // Rotate arrow
                $arrow.toggleClass('rotate-180');
            });
        },

        handleActiveState: function() {
            // Highlight active menu on page load
            const currentPath = window.location.pathname;
            
            $('.nav-link, .submenu-link').each(function() {
                const $link = $(this);
                const href = $link.attr('href');
                
                if (href && currentPath.includes(href.replace(window.location.origin, ''))) {
                    $link.addClass('active');
                    
                    // Expand parent if submenu
                    if ($link.hasClass('submenu-link')) {
                        $link.closest('.collapse').addClass('show');
                        $link.closest('.nav-item').find('.nav-link').addClass('active');
                    }
                }
            });
        },

        handleMobileClose: function() {
            // Close sidebar when clicking outside on mobile
            $(document).on('click', function(e) {
                if ($(window).width() <= 768) {
                    const $wrapper = $('#wrapper');
                    const $sidebar = $('#sidebar-wrapper');
                    const $toggle = $('#menu-toggle');
                    
                    if ($wrapper.hasClass('toggled') && 
                        !$sidebar.is(e.target) && 
                        $sidebar.has(e.target).length === 0 &&
                        !$toggle.is(e.target) &&
                        $toggle.has(e.target).length === 0) {
                        $wrapper.removeClass('toggled');
                    }
                }
            });
        }
    };

    // ============================================
    // CARD ANIMATIONS
    // ============================================
    const CardAnimations = {
        init: function() {
            this.observeCards();
        },

        observeCards: function() {
            // Intersection Observer for card animations
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('animate-in');
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.1
                });

                // Observe all cards
                document.querySelectorAll('.card, .stat-card, .welcome-banner').forEach(card => {
                    observer.observe(card);
                });
            }
        }
    };

    // ============================================
    // FORM ENHANCEMENTS
    // ============================================
    const FormEnhancements = {
        init: function() {
            this.handleValidation();
            this.handleFileInputs();
        },

        handleValidation: function() {
            // Bootstrap form validation
            const forms = document.querySelectorAll('.needs-validation');
            
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        },

        handleFileInputs: function() {
            // Custom file input labels
            $('.custom-file-input').on('change', function() {
                const fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').html(fileName);
            });
        }
    };

    // ============================================
    // TOOLTIPS & POPOVERS
    // ============================================
    const BootstrapComponents = {
        init: function() {
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(
                document.querySelectorAll('[data-bs-toggle="tooltip"]')
            );
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Initialize popovers
            const popoverTriggerList = [].slice.call(
                document.querySelectorAll('[data-bs-toggle="popover"]')
            );
            popoverTriggerList.map(function(popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl);
            });
        }
    };

    // ============================================
    // SMOOTH SCROLL
    // ============================================
    const SmoothScroll = {
        init: function() {
            $('a[href^="#"]').on('click', function(e) {
                const target = $(this.getAttribute('href'));
                
                if (target.length) {
                    e.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top - 100
                    }, 600);
                }
            });
        }
    };

    // ============================================
    // DATATABLE ENHANCEMENTS
    // ============================================
    const DataTableEnhancements = {
        defaultConfig: {
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari...",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                infoFiltered: "(difilter dari _MAX_ total data)",
                zeroRecords: "Tidak ada data yang ditemukan",
                emptyTable: "Tidak ada data tersedia",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            pageLength: 10,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
            order: [[0, 'asc']]
        },

        init: function(selector, customConfig = {}) {
            const config = $.extend({}, this.defaultConfig, customConfig);
            return $(selector).DataTable(config);
        }
    };

    // ============================================
    // ALERT AUTO DISMISS
    // ============================================
    const AlertAutoDismiss = {
        init: function() {
            $('.alert:not(.alert-permanent)').each(function() {
                const $alert = $(this);
                setTimeout(function() {
                    $alert.fadeOut(300, function() {
                        $(this).remove();
                    });
                }, 5000);
            });
        }
    };

    // ============================================
    // COPY TO CLIPBOARD
    // ============================================
    const CopyToClipboard = {
        init: function() {
            $('[data-copy]').on('click', function() {
                const text = $(this).data('copy');
                const $btn = $(this);
                
                navigator.clipboard.writeText(text).then(function() {
                    const originalText = $btn.html();
                    $btn.html('<i class="fas fa-check"></i> Copied!');
                    
                    setTimeout(function() {
                        $btn.html(originalText);
                    }, 2000);
                    
                    Toast.fire({
                        icon: 'success',
                        title: 'Copied to clipboard!'
                    });
                });
            });
        }
    };

    

    // ============================================
    // INITIALIZE ALL
    // ============================================
    $(document).ready(function() {
        PageLoader.init();
        SidebarEnhancements.init();
        CardAnimations.init();
        FormEnhancements.init();
        BootstrapComponents.init();
        SmoothScroll.init();
        AlertAutoDismiss.init();
        CopyToClipboard.init();
    });

    // ============================================
    // EXPOSE TO GLOBAL
    // ============================================
    window.AppEnhancements = {
        DataTable: DataTableEnhancements,
        Toast: typeof Toast !== 'undefined' ? Toast : null
    };

})(jQuery);
