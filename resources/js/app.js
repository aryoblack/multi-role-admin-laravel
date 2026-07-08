// Import DataTable Modern Helper
import './datatable-modern.js';

document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.getElementById('menu-toggle');
    const wrapper = document.getElementById('wrapper');
    const sidebarOverlay = document.getElementById('sidebar-overlay');
    const sidebarClose = document.getElementById('sidebar-close');
    const sidebarWrapper = document.getElementById('sidebar-wrapper');

    // Sidebar Toggle
    if (menuToggle && wrapper) {
        menuToggle.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            wrapper.classList.toggle('toggled');
            console.log('Sidebar toggled from app.js');
        });
    }

    if (sidebarOverlay && wrapper) {
        sidebarOverlay.addEventListener('click', function () {
            wrapper.classList.remove('toggled');
        });
    }

    if (sidebarClose && wrapper) {
        sidebarClose.addEventListener('click', function () {
            wrapper.classList.remove('toggled');
        });
    }

    // Close sidebar on escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && wrapper && wrapper.classList.contains('toggled')) {
            wrapper.classList.remove('toggled');
        }
    });

    // Close sidebar on click outside (mobile)
    document.addEventListener('click', function (e) {
        if (window.innerWidth <= 1023 && wrapper && menuToggle && sidebarWrapper) {
            if (!menuToggle.contains(e.target) && !sidebarWrapper.contains(e.target)) {
                if (wrapper.classList.contains('toggled')) {
                    wrapper.classList.remove('toggled');
                }
            }
        }
    });
});

// Smooth scroll
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (href !== '#' && href !== '#!') {
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }
    });
});

// Add loading state to buttons on form submit
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function () {
        const submitBtn = this.querySelector('button[type="submit"]');
        if (submitBtn && !submitBtn.disabled) {
            submitBtn.disabled = true;
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Loading...';

            // Re-enable after 5 seconds as fallback
            setTimeout(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }, 5000);
        }
    });
});

// Auto-hide alerts after 5 seconds
setTimeout(() => {
    document.querySelectorAll('.alert-auto-hide').forEach(alert => {
        alert.style.transition = 'opacity 0.5s ease';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
    });
}, 5000);
