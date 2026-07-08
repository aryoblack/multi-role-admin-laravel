<!-- Footer -->
<footer class="mt-auto bg-white border-t border-gray-200">
    <div class="px-4 sm:px-6 lg:px-8 py-4 lg:py-6">
        <div class="flex flex-col md:flex-row items-center justify-between gap-2">
            <div class="text-center md:text-left">
                <span class="text-sm text-gray-600">
                    {{ $appSetting->footer_text ?: '© ' . date('Y') . ' ' . ($appName ?? config('app.name')) . '. All rights reserved.' }}
                </span>
            </div>
            <div class="flex items-center gap-4 text-sm text-gray-500">
                <span class="flex items-center gap-1.5">
                    <i class="fas fa-code text-blue-500"></i>
                    <span>Version 1.0.0</span>
                </span>
                <span class="hidden sm:inline">&bull;</span>
                <span class="hidden sm:inline">Made with <i class="fas fa-heart text-red-500 animate-pulse"></i></span>
            </div>
        </div>
    </div>
</footer>

<!-- Back to Top Button -->
<button type="button"
        class="fixed bottom-6 right-6 w-12 h-12 bg-blue-600 text-white rounded-lg shadow-sm hover:bg-blue-700 hover:shadow-md transition-all duration-200 z-40 hidden items-center justify-center group"
        id="btn-back-to-top"
        title="Back to top">
    <i class="fas fa-arrow-up group-hover:-translate-y-1 transition-transform duration-300"></i>
</button>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const backToTopBtn = document.getElementById('btn-back-to-top');
    const mainContent = document.querySelector('main');

    if (backToTopBtn && mainContent) {
        mainContent.addEventListener('scroll', function() {
            if (mainContent.scrollTop > 300) {
                backToTopBtn.classList.remove('hidden');
                backToTopBtn.classList.add('flex');
            } else {
                backToTopBtn.classList.add('hidden');
                backToTopBtn.classList.remove('flex');
            }
        });

        backToTopBtn.addEventListener('click', function() {
            mainContent.scrollTo({
                top: 0,
                behavior: 'smooth',
            });
        });
    }
});
</script>
