/**
 * Modern DataTable Helper
 * Global functions for DataTable styling and mobile view
 */

window.DataTableModern = {
    /**
     * Default DataTable configuration
     */
    defaultConfig: {
        processing: true,
        serverSide: true,
        language: {
            url: '/vendor/datatables/i18n/id.json'
        },
        dom: '<"flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4"<"flex items-center gap-2"l><"flex-1"f>>rt<"flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mt-6 pt-6 border-t border-gray-100"ip>',
        drawCallback: function (settings) {
            // Add hover effect to rows
            $(this.api().table().node()).find('tbody tr').addClass('hover:bg-blue-50 transition-colors duration-150 cursor-pointer');
        },
        initComplete: function () {
            // Style DataTable elements
            DataTableModern.styleElements();
        }
    },

    /**
     * Initialize DataTable with modern styling
     * @param {string} selector - Table selector
     * @param {object} config - DataTable configuration
     * @param {object} mobileConfig - Mobile view configuration
     * @returns {object} DataTable instance
     */
    init: function (selector, config = {}, mobileConfig = null) {
        // Merge default config with custom config
        const finalConfig = $.extend(true, {}, this.defaultConfig, config);

        // Add mobile view callback if provided
        if (mobileConfig) {
            const originalDrawCallback = finalConfig.drawCallback;
            finalConfig.drawCallback = function (settings) {
                // Call original callback
                if (originalDrawCallback) {
                    originalDrawCallback.call(this, settings);
                }
                // Update mobile view
                DataTableModern.updateMobileView(settings.json, mobileConfig);
            };
        }

        // Initialize DataTable
        const table = $(selector).DataTable(finalConfig);

        return table;
    },

    /**
     * Style DataTable elements with Tailwind classes
     */
    styleElements: function () {
        // Search input
        $('.dataTables_filter input')
            .addClass('px-4 py-2 border border-gray-300 rounded-lg')
            .addClass('focus:ring-2 focus:ring-blue-500 focus:border-blue-500')
            .addClass('transition-all duration-200 text-sm outline-none')
            .attr('placeholder', 'Cari...');

        $('.dataTables_filter label')
            .addClass('flex items-center gap-2 text-sm text-gray-700 font-medium');

        // Length select
        $('.dataTables_length select')
            .addClass('px-3 py-2 border border-gray-300 rounded-lg')
            .addClass('focus:ring-2 focus:ring-blue-500 focus:border-blue-500')
            .addClass('transition-all duration-200 text-sm outline-none cursor-pointer');

        $('.dataTables_length label')
            .addClass('flex items-center gap-2 text-sm text-gray-700 font-medium');

        // Info text
        $('.dataTables_info')
            .addClass('text-sm text-gray-600 font-medium');

        // Pagination
        $('.dataTables_paginate')
            .addClass('flex items-center gap-1 flex-wrap');

        $('.paginate_button')
            .addClass('px-3 py-2 text-sm font-medium text-gray-700')
            .addClass('bg-white border border-gray-300 rounded-lg')
            .addClass('hover:bg-blue-50 hover:border-blue-500 hover:text-blue-600')
            .addClass('transition-all duration-200 cursor-pointer select-none');

        $('.paginate_button.current')
            .addClass('!bg-blue-600')
            .addClass('!text-white !border-blue-600 shadow-sm');

        $('.paginate_button.disabled')
            .addClass('opacity-50 cursor-not-allowed')
            .addClass('hover:!bg-white hover:!border-gray-300 hover:!text-gray-700');

        // Processing indicator
        $('.dataTables_processing')
            .addClass('!fixed !top-1/2 !left-1/2 !transform !-translate-x-1/2 !-translate-y-1/2')
            .addClass('!bg-white !border-2 !border-blue-500 !text-blue-600')
            .addClass('!font-semibold !rounded-lg !shadow-xl !px-6 !py-4 !z-50');
    },

    /**
     * Update mobile card view
     * @param {object} data - DataTable JSON data
     * @param {object} config - Mobile view configuration
     */
    updateMobileView: function (data, config) {
        if (!data || !data.data || !config || !config.container) return;

        const container = $(config.container);
        container.empty();

        if (data.data.length === 0) {
            container.append(this.getEmptyState(config.emptyMessage));
            return;
        }

        data.data.forEach((item, index) => {
            const card = config.cardTemplate(item, index);
            container.append(card);
        });
    },

    /**
     * Get empty state HTML
     * @param {string} message - Empty message
     * @returns {string} HTML
     */
    getEmptyState: function (message = 'Tidak ada data') {
        return `
            <div class="text-center py-12">
                <div class="flex flex-col items-center justify-center gap-3">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-inbox text-3xl text-gray-400"></i>
                    </div>
                    <p class="text-gray-500 font-medium">${message}</p>
                </div>
            </div>
        `;
    },

    /**
     * Create mobile card template for users
     * @param {object} user - User data
     * @returns {string} HTML
     */
    userCardTemplate: function (user) {
        return `
            <div class="mobile-card">
                <div class="mobile-card-header">
                    <div class="flex items-center gap-3 flex-1">
                        <div class="mobile-card-avatar">
                            ${user.name.charAt(0).toUpperCase()}
                        </div>
                        <div class="mobile-card-content">
                            <h4 class="mobile-card-title">${user.name}</h4>
                            <p class="mobile-card-subtitle">${user.email}</p>
                        </div>
                    </div>
                    ${user.status_badge || ''}
                </div>
                
                <div class="mobile-card-body">
                    <div class="mobile-card-info">
                        <i class="fas fa-phone w-4"></i>
                        <span>${user.phone || '-'}</span>
                    </div>
                    <div class="mobile-card-info">
                        <i class="fas fa-user-tag w-4"></i>
                        <span>${user.role_name || '-'}</span>
                    </div>
                </div>
                
                <div class="mobile-card-footer">
                    ${user.action || ''}
                </div>
            </div>
        `;
    },

    /**
     * Create mobile card template for menus
     * @param {object} menu - Menu data
     * @returns {string} HTML
     */
    menuCardTemplate: function (menu) {
        return `
            <div class="mobile-card">
                <div class="mobile-card-header">
                    <div class="flex items-center gap-3 flex-1">
                        <div class="mobile-card-avatar">
                            ${menu.icon_html || '<i class="fas fa-bars"></i>'}
                        </div>
                        <div class="mobile-card-content">
                            <h4 class="mobile-card-title">${menu.nama_menu}</h4>
                            <p class="mobile-card-subtitle">${menu.url_display || menu.url}</p>
                        </div>
                    </div>
                    <span class="dt-badge dt-badge-primary">
                        #${menu.urutan}
                    </span>
                </div>
                
                ${menu.parent_name ? `
                <div class="mb-3 px-3 py-2 bg-gray-50 rounded-lg">
                    <p class="text-xs text-gray-500">Parent Menu:</p>
                    <p class="text-sm text-gray-700 font-medium">${menu.parent_name}</p>
                </div>
                ` : ''}
                
                <div class="mobile-card-footer">
                    ${menu.action || ''}
                </div>
            </div>
        `;
    },

    /**
     * Create action buttons HTML
     * @param {object} config - Button configuration
     * @returns {string} HTML
     */
    actionButtons: function (config) {
        let html = '<div class="flex items-center justify-center gap-2">';

        if (config.view) {
            html += `
                <a href="${config.view.url}" 
                   class="dt-action-btn dt-action-btn-view" 
                   title="${config.view.title || 'Lihat'}">
                    <i class="fas fa-eye text-sm"></i>
                </a>
            `;
        }

        if (config.edit) {
            html += `
                <a href="${config.edit.url}" 
                   class="dt-action-btn dt-action-btn-edit" 
                   title="${config.edit.title || 'Edit'}">
                    <i class="fas fa-edit text-sm"></i>
                </a>
            `;
        }

        if (config.delete) {
            const disabled = config.delete.disabled ? 'disabled' : '';
            html += `
                <button type="button" 
                        class="dt-action-btn dt-action-btn-delete delete-btn" 
                        data-id="${config.delete.id}"
                        ${disabled}
                        title="${config.delete.title || 'Hapus'}">
                    <i class="fas fa-trash text-sm"></i>
                </button>
            `;
        }

        if (config.custom) {
            config.custom.forEach(btn => {
                html += `
                    <a href="${btn.url}" 
                       class="dt-action-btn ${btn.class || 'dt-action-btn-primary'}" 
                       title="${btn.title || ''}">
                        <i class="${btn.icon} text-sm"></i>
                    </a>
                `;
            });
        }

        html += '</div>';
        return html;
    },

    /**
     * Create badge HTML
     * @param {string} text - Badge text
     * @param {string} type - Badge type (primary, success, warning, danger, info)
     * @returns {string} HTML
     */
    badge: function (text, type = 'primary') {
        return `<span class="dt-badge dt-badge-${type}">${text}</span>`;
    },

    /**
     * Reload DataTable
     * @param {object} table - DataTable instance
     */
    reload: function (table) {
        if (table && typeof table.ajax === 'object') {
            table.ajax.reload(null, false);
        }
    },

    /**
     * Show loading state
     */
    showLoading: function () {
        if ($('.dataTables_processing').length === 0) {
            $('body').append(`
                <div class="dataTables_processing" style="display: block;">
                    <i class="fas fa-spinner fa-spin mr-2"></i>
                    Memuat data...
                </div>
            `);
        }
    },

    /**
     * Hide loading state
     */
    hideLoading: function () {
        $('.dataTables_processing').remove();
    }
};

// Auto-initialize on document ready
$(document).ready(function () {
    // Style existing DataTables
    if ($.fn.DataTable) {
        DataTableModern.styleElements();
    }
});
