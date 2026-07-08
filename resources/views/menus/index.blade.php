@extends('layouts.app')

@section('title', 'Manajemen Menu')

@section('content')
<div class="page-shell">
    <!-- Page Header -->
    <div class="mb-4 sm:mb-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">
                    <span class="page-title-icon">
                        <i class="fas fa-bars text-lg"></i>
                    </span>
                    Manajemen Menu
                </h1>
                <p class="page-subtitle">Kelola menu navigasi sistem</p>
            </div>
            @if($pagePermission->can_add)
                <button type="button"
                    id="btnAdd"
                    class="btn-primary-theme">
                    <i class="fas fa-plus"></i>
                    <span>Tambah Menu</span>
                </button>
            @endif
        </div>
    </div>

    <!-- Table Card -->
    <div class="panel">
        <!-- Card Header -->
        <div class="panel-header">
            <h3 class="panel-title">
                <i class="fas fa-list"></i>
                <span class="hidden sm:inline">Daftar Menu</span>
                <span class="sm:hidden">Menus</span>
            </h3>
        </div>

        <!-- Table Container -->
        <div class="p-3 sm:p-6">
            <!-- Mobile Card View -->
            <div class="block lg:hidden space-y-3" id="mobileMenusList">
                <!-- Mobile cards will be inserted here by JavaScript -->
            </div>

            <!-- Desktop Table View -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full text-sm" id="menusTable">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-50" width="5%">No</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-50">Nama Menu</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-50">URL</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-50">Icon</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-50">Parent Menu</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-50">Urutan</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-50" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create/Edit using Component -->
<x-modal id="menuModal" title="Tambah Menu" icon="fas fa-plus-circle" formId="menuForm">
    <input type="hidden" id="menuId" name="menuId">
    <input type="hidden" id="formMethod" name="_method" value="POST">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
        <!-- Nama Menu -->
        <div>
            <label for="nama_menu" class="block text-sm font-semibold text-gray-700 mb-2">Nama Menu <span class="text-red-500">*</span></label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors">
                    <i class="fas fa-bars text-sm"></i>
                </div>
                <input type="text" id="nama_menu" name="nama_menu" required placeholder="Contoh: Pengaturan"
                    class="block w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all duration-300 outline-none text-gray-900 bg-gray-50 focus:bg-white placeholder-gray-400">
            </div>
            <div class="invalid-feedback text-red-500 text-xs mt-1"></div>
        </div>

        <!-- URL -->
        <div>
            <label for="url" class="block text-sm font-semibold text-gray-700 mb-2">URL <span class="text-red-500">*</span></label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors">
                    <i class="fas fa-link text-sm"></i>
                </div>
                <input type="text" id="url" name="url" placeholder="/dashboard" required
                    class="block w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all duration-300 outline-none text-gray-900 bg-gray-50 focus:bg-white placeholder-gray-400">
            </div>
            <div class="invalid-feedback text-red-500 text-xs mt-1"></div>
        </div>

        <!-- Icon -->
        <div>
            <label for="icon" class="block text-sm font-semibold text-gray-700 mb-2">Icon (Font Awesome)</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors">
                    <i class="fab fa-font-awesome-flag text-sm"></i>
                </div>
                <input type="text" id="icon" name="icon" placeholder="fas fa-home"
                    class="block w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all duration-300 outline-none text-gray-900 bg-gray-50 focus:bg-white placeholder-gray-400">
            </div>
            <p class="text-[11px] text-gray-500 mt-1.5 flex items-center gap-1">
                <i class="fas fa-info-circle text-blue-500"></i> Contoh: fas fa-home, fas fa-users
            </p>
            <div class="invalid-feedback text-red-500 text-xs mt-1"></div>
        </div>

        <!-- Parent Menu -->
        <div>
            <label for="parent_id" class="block text-sm font-semibold text-gray-700 mb-2">Parent Menu</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors">
                    <i class="fas fa-sitemap text-sm"></i>
                </div>
                <select id="parent_id" name="parent_id"
                    class="block w-full pl-11 pr-10 py-3 border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all duration-300 outline-none text-gray-900 bg-gray-50 focus:bg-white appearance-none cursor-pointer">
                    <option value="">-- Tidak Ada Parent (Menu Utama) --</option>
                    @foreach($parentMenus as $parent)
                    <option value="{{ $parent->id }}">{{ $parent->nama_menu }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-400 group-focus-within:text-blue-500">
                    <i class="fas fa-chevron-down text-xs"></i>
                </div>
            </div>
            <div class="invalid-feedback text-red-500 text-xs mt-1"></div>
        </div>

        <!-- Urutan -->
        <div class="md:col-span-2">
            <label for="urutan" class="block text-sm font-semibold text-gray-700 mb-2">Urutan <span class="text-red-500">*</span></label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors">
                    <i class="fas fa-sort-numeric-down text-sm"></i>
                </div>
                <input type="number" id="urutan" name="urutan" min="0" required
                    class="block w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all duration-300 outline-none text-gray-900 bg-gray-50 focus:bg-white placeholder-gray-400">
            </div>
            <div class="invalid-feedback text-red-500 text-xs mt-1"></div>
        </div>
    </div>
</x-modal>
@endsection

@push('scripts')
<script>
    // Modal functions (Scalable for any modal ID)
    function openModal(id = 'menuModal') {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Add slight delay for animation to kick in smoothly
            setTimeout(() => {
                const modalContainer = modal.querySelector('.transform');
                if (modalContainer) {
                    modalContainer.classList.add('scale-100', 'opacity-100');
                    modalContainer.classList.remove('scale-95', 'opacity-0');
                }
            }, 10);
        }
    }

    function closeModal(id = 'menuModal') {
        const modal = document.getElementById(id);
        if (modal) {
            const modalContainer = modal.querySelector('.transform');
            if (modalContainer) {
                modalContainer.classList.remove('scale-100', 'opacity-100');
                modalContainer.classList.add('scale-95', 'opacity-0');
            }

            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
                if (typeof resetForm === 'function' && id === 'menuModal') {
                    resetForm();
                }
            }, 200); // 200ms matches transition duration
        }
    }

    $(document).ready(function() {
        // Initialize DataTable with modern styling
        const table = DataTableModern.init('#menusTable', {
            ajax: '{{ route("menus.index") }}',
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama_menu',
                    name: 'nama_menu'
                },
                {
                    data: 'url_display',
                    name: 'url'
                },
                {
                    data: 'icon_display',
                    name: 'icon'
                },
                {
                    data: 'parent_name',
                    name: 'parent.nama_menu'
                },
                {
                    data: 'urutan',
                    name: 'urutan'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        }, {
            container: '#mobileMenusList',
            emptyMessage: 'Tidak ada data menu',
            cardTemplate: DataTableModern.menuCardTemplate
        });

        // Add button
        $('#btnAdd').click(function() {
            resetForm();
            $('#menuModalRealTitle').text('Tambah Menu');
            $('#menuModal-title i').attr('class', 'fas fa-plus-circle text-lg');
            $('#formMethod').val('POST');
            $('#menuForm').attr('action', '{{ route("menus.store") }}');
            openModal();
        });

        // Edit button
        $(document).on('click', '.edit-btn', function() {
            const menuId = $(this).data('id');

            $.ajax({
                url: `/menus/${menuId}/edit`,
                method: 'GET',
                success: function(response) {
                    resetForm();
                    $('#menuModalRealTitle').text('Edit Menu');
                    $('#menuModal-title i').attr('class', 'fas fa-edit text-lg');
                    $('#formMethod').val('PUT');
                    $('#menuForm').attr('action', `/menus/${menuId}`);
                    $('#menuId').val(menuId);
                    $('#nama_menu').val(response.menu.nama_menu);
                    $('#url').val(response.menu.url);
                    $('#icon').val(response.menu.icon || '');
                    $('#parent_id').val(response.menu.parent_id || '');
                    $('#urutan').val(response.menu.urutan);

                    // Update parent menu options
                    $('#parent_id').html('<option value="">-- Tidak Ada Parent (Menu Utama) --</option>');
                    response.parentMenus.forEach(function(parent) {
                        $('#parent_id').append(`<option value="${parent.id}">${parent.nama_menu}</option>`);
                    });
                    $('#parent_id').val(response.menu.parent_id || '');

                    openModal();
                },
                error: function(xhr) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Gagal memuat data menu'
                    });
                }
            });
        });

        // Delete button
        $(document).on('click', '.delete-btn', function() {
            const menuId = $(this).data('id');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data menu akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74a3b',
                cancelButtonColor: '#858796',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/menus/${menuId}`,
                        method: 'DELETE',
                        success: function(response) {
                            Toast.fire({
                                icon: 'success',
                                title: response.message
                            });
                            table.ajax.reload();
                        },
                        error: function(xhr) {
                            Toast.fire({
                                icon: 'error',
                                title: xhr.responseJSON?.message || 'Gagal menghapus menu'
                            });
                        }
                    });
                }
            });
        });

        // Form submit
        $('#menuForm').submit(function(e) {
            e.preventDefault();

            const url = $(this).attr('action');
            const method = $('#formMethod').val();
            const formData = new FormData(this);

            if (method === 'PUT') {
                formData.append('_method', 'PUT');
            }

            const btnSave = $('#btnSave');
            const originalText = btnSave.html();
            btnSave.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');

            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    closeModal();
                    Toast.fire({
                        icon: 'success',
                        title: response.message || 'Data berhasil disimpan!'
                    });
                    table.ajax.reload();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        $('.border-red-500').removeClass('border-red-500');
                        $('.invalid-feedback').text('').hide();

                        $.each(errors, function(key, value) {
                            $(`#${key}`).addClass('border-red-500');
                            $(`#${key}`).siblings('.invalid-feedback').text(value[0]).show();
                        });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: xhr.responseJSON?.message || 'Terjadi kesalahan'
                        });
                    }
                },
                complete: function() {
                    btnSave.prop('disabled', false).html(originalText);
                }
            });
        });

        // Reset form
        function resetForm() {
            $('#menuForm')[0].reset();
            $('.border-red-500').removeClass('border-red-500');
            $('.invalid-feedback').text('').hide();
            $('#menuId').val('');
        }

        window.resetForm = resetForm;

        // Close modal on ESC key
        $(document).keydown(function(e) {
            if (e.key === "Escape") {
                closeModal();
            }
        });
    });
</script>
@endpush
