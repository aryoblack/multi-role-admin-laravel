@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
<div class="page-shell">
    <!-- Page Header -->
    <div class="mb-4 sm:mb-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">
                    <span class="page-title-icon">
                        <i class="fas fa-users text-lg"></i>
                    </span>
                    Manajemen User
                </h1>
                <p class="page-subtitle">Kelola data pengguna sistem</p>
            </div>
            <button type="button"
                id="btnAdd"
                class="btn-primary-theme">
                <i class="fas fa-plus"></i>
                <span>Tambah User</span>
            </button>
        </div>
    </div>

    <!-- Table Card -->
    <div class="panel">
        <!-- Card Header -->
        <div class="panel-header">
            <h3 class="panel-title">
                <i class="fas fa-table"></i>
                <span class="hidden sm:inline">Daftar User</span>
                <span class="sm:hidden">Users</span>
            </h3>
        </div>

        <!-- Table Container -->
        <div class="p-3 sm:p-6">
            <!-- Mobile Card View -->
            <div class="block lg:hidden space-y-3" id="mobileUsersList">
                <!-- Mobile cards will be inserted here by JavaScript -->
            </div>

            <!-- Desktop Table View -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full text-sm" id="usersTable">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-50" width="5%">No</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-50">Nama</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-50">Email</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-50">Phone</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-50">Role</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-50">Status</th>
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
<x-modal id="userModal" title="Tambah User" icon="fas fa-user-plus" formId="userForm">
    <input type="hidden" id="userId" name="userId">
    <input type="hidden" id="formMethod" name="_method" value="POST">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
        <!-- Nama Lengkap -->
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors">
                    <i class="fas fa-user text-sm"></i>
                </div>
                <input type="text" id="name" name="name" required placeholder="Masukkan nama lengkap"
                    class="block w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all duration-300 outline-none text-gray-900 bg-gray-50 focus:bg-white placeholder-gray-400">
            </div>
            <div class="invalid-feedback text-red-500 text-xs mt-1"></div>
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors">
                    <i class="fas fa-envelope text-sm"></i>
                </div>
                <input type="email" id="email" name="email" required placeholder="email@contoh.com"
                    class="block w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all duration-300 outline-none text-gray-900 bg-gray-50 focus:bg-white placeholder-gray-400">
            </div>
            <div class="invalid-feedback text-red-500 text-xs mt-1"></div>
        </div>

        <!-- Phone -->
        <div>
            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Nomor Telepon</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors">
                    <i class="fas fa-phone-alt text-sm"></i>
                </div>
                <input type="text" id="phone" name="phone" placeholder="08xxxxxxxxxx"
                    class="block w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all duration-300 outline-none text-gray-900 bg-gray-50 focus:bg-white placeholder-gray-400">
            </div>
            <div class="invalid-feedback text-red-500 text-xs mt-1"></div>
        </div>

        <!-- Role -->
        <div>
            <label for="role_id" class="block text-sm font-semibold text-gray-700 mb-2">Role <span class="text-red-500">*</span></label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors">
                    <i class="fas fa-id-badge text-sm"></i>
                </div>
                <select id="role_id" name="role_id" required
                    class="block w-full pl-11 pr-10 py-3 border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all duration-300 outline-none text-gray-900 bg-gray-50 focus:bg-white appearance-none cursor-pointer">
                    <option value="">Pilih Role</option>
                    @foreach($roles ?? [] as $role)
                    <option value="{{ $role->id }}">{{ $role->nama_role }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-400 group-focus-within:text-blue-500">
                    <i class="fas fa-chevron-down text-xs"></i>
                </div>
            </div>
            <div class="invalid-feedback text-red-500 text-xs mt-1"></div>
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password <span class="text-red-500" id="passwordRequired">*</span></label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-purple-500 transition-colors">
                    <i class="fas fa-lock text-sm"></i>
                </div>
                <input type="password" id="password" name="password" placeholder="••••••••"
                    class="block w-full pl-11 pr-10 py-3 border border-gray-200 rounded-xl focus:ring-4 focus:ring-purple-500/10 focus:border-purple-500 transition-all duration-300 outline-none text-gray-900 bg-gray-50 focus:bg-white placeholder-gray-400">
                <button type="button" class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600 toggle-password focus:outline-none">
                    <i class="fas fa-eye text-sm"></i>
                </button>
            </div>
            <p class="text-[11px] text-gray-500 mt-1.5 flex items-center gap-1">
                <i class="fas fa-info-circle text-blue-500"></i> Min. 8 karakter, kombinasi huruf & angka
            </p>
            <div class="invalid-feedback text-red-500 text-xs mt-1"></div>
        </div>

        <!-- Konfirmasi Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password <span class="text-red-500" id="passwordConfRequired">*</span></label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-purple-500 transition-colors">
                    <i class="fas fa-shield-alt text-sm"></i>
                </div>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••"
                    class="block w-full pl-11 pr-10 py-3 border border-gray-200 rounded-xl focus:ring-4 focus:ring-purple-500/10 focus:border-purple-500 transition-all duration-300 outline-none text-gray-900 bg-gray-50 focus:bg-white placeholder-gray-400">
                <button type="button" class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600 toggle-password focus:outline-none">
                    <i class="fas fa-eye text-sm"></i>
                </button>
            </div>
            <div class="invalid-feedback text-red-500 text-xs mt-1"></div>
        </div>

        <!-- Status -->
        <div class="md:col-span-2 pt-2 border-t border-gray-100 mt-2">
            <label class="block text-sm font-semibold text-gray-700 mb-3">
                Status Akun <span class="text-red-500">*</span>
            </label>
            <div class="flex items-center gap-4 bg-gray-50 p-3 rounded-xl border border-gray-100">
                <label class="relative flex items-center cursor-pointer">
                    <input type="radio" name="status" value="active" class="peer sr-only" checked>
                    <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:border-green-500 flex items-center justify-center transition-colors">
                        <div class="w-2.5 h-2.5 bg-green-500 rounded-full scale-0 peer-checked:scale-100 transition-transform"></div>
                    </div>
                    <span class="ml-2 text-sm font-medium text-gray-700 peer-checked:text-green-700">Active</span>
                </label>

                <label class="relative flex items-center cursor-pointer">
                    <input type="radio" name="status" value="inactive" class="peer sr-only">
                    <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:border-red-500 flex items-center justify-center transition-colors">
                        <div class="w-2.5 h-2.5 bg-red-500 rounded-full scale-0 peer-checked:scale-100 transition-transform"></div>
                    </div>
                    <span class="ml-2 text-sm font-medium text-gray-700 peer-checked:text-red-700">Inactive</span>
                </label>
            </div>
            <div class="invalid-feedback text-red-500 text-xs mt-1"></div>
        </div>
    </div>
</x-modal>

@endsection

@push('scripts')
<script>
    // Modal functions (Scalable for any modal ID)
    function openModal(id = 'userModal') {
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

    function closeModal(id = 'userModal') {
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
                if (typeof resetForm === 'function' && id === 'userModal') {
                    resetForm();
                }
            }, 200); // 200ms matches transition duration
        }
    }

    $(document).ready(function() {
        // Initialize DataTable with modern styling
        const table = DataTableModern.init('#usersTable', {
            ajax: '{{ route("users.index") }}',
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'phone',
                    name: 'phone',
                    defaultContent: '-'
                },
                {
                    data: 'role_name',
                    name: 'role.nama_role'
                },
                {
                    data: 'status_badge',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        }, {
            container: '#mobileUsersList',
            emptyMessage: 'Tidak ada data user',
            cardTemplate: DataTableModern.userCardTemplate
        });

        // Add button
        $('#btnAdd').click(function() {
            resetForm();
            $('#modalTitle').html('<i class="fas fa-user-plus"></i> Tambah User');
            $('#formMethod').val('POST');
            $('#userForm').attr('action', '{{ route("users.store") }}');
            $('#passwordRequired, #passwordConfRequired').show();
            $('#password, #password_confirmation').prop('required', true);
            openModal();
        });

        // Edit button
        $(document).on('click', '.edit-btn', function() {
            const userId = $(this).data('id');

            $.ajax({
                url: `/users/${userId}/edit`,
                method: 'GET',
                success: function(response) {
                    resetForm();
                    $('#modalTitle').html('<i class="fas fa-user-edit"></i> Edit User');
                    $('#formMethod').val('PUT');
                    $('#userForm').attr('action', `/users/${userId}`);
                    $('#userId').val(userId);
                    $('#name').val(response.user.name);
                    $('#email').val(response.user.email);
                    $('#phone').val(response.user.phone || '');
                    $('#role_id').val(response.user.role_id);
                    $('#status').val(response.user.status);
                    $('#passwordRequired, #passwordConfRequired').hide();
                    $('#password, #password_confirmation').prop('required', false);
                    openModal();
                },
                error: function(xhr) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Gagal memuat data user'
                    });
                }
            });
        });

        // Delete button
        $(document).on('click', '.delete-btn', function() {
            const userId = $(this).data('id');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data user akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74a3b',
                cancelButtonColor: '#858796',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/users/${userId}`,
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
                                title: xhr.responseJSON?.message || 'Gagal menghapus user'
                            });
                        }
                    });
                }
            });
        });

        // Form submit
        $('#userForm').submit(function(e) {
            e.preventDefault();

            const url = $(this).attr('action');
            const method = $('#formMethod').val();
            const formData = new FormData(this);

            // Add _method for PUT request
            if (method === 'PUT') {
                formData.append('_method', 'PUT');
            }

            // Show loading state
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
            $('#userForm')[0].reset();
            $('.border-red-500').removeClass('border-red-500');
            $('.invalid-feedback').text('').hide();
            $('#userId').val('');
        }

        // Make resetForm available globally
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