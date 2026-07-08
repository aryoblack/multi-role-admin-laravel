@extends('layouts.app')

@section('title', 'Backup Database')

@section('content')
<div class="page-shell">
    <!-- Page Header -->
    <div class="mb-4 sm:mb-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">
                    <span class="page-title-icon">
                        <i class="fas fa-database text-lg"></i>
                    </span>
                    Backup Database
                </h1>
                <p class="page-subtitle">Kelola pencadangan dan pemulihan sistem</p>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" class="btn-secondary-theme" onclick="location.reload()">
                    <i class="fas fa-sync-alt"></i>
                    <span>Refresh</span>
                </button>
            </div>
        </div>
    </div>
    <!-- Info Alert -->
    <div class="mb-6">
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-500 text-lg"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        <strong>Informasi:</strong> Backup database disimpan dalam format .sql. Anda dapat mengunduh, memulihkan, atau mengekspor file untuk keperluan migrasi.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Create Backup Card -->
        <div class="panel group hover:border-blue-200 transition-all duration-300">
            <div class="panel-header">
                <h5 class="panel-title">
                    <i class="fas fa-plus-circle"></i>
                    Buat Backup Baru
                </h5>
            </div>
            <div class="p-6">
                <p class="text-sm text-gray-600 mb-6">Cadangkan database sistem saat ini ke dalam format .sql untuk keamanan data Anda.</p>
                <button type="button" class="btn-primary-theme w-full py-3" id="btnCreateBackup">
                    <i class="fas fa-plus-circle"></i>
                    <span>Eksekusi Backup</span>
                </button>
            </div>
        </div>

        <!-- Upload Backup Card -->
        <div class="panel group hover:border-emerald-200 transition-all duration-300">
            <div class="panel-header">
                <h5 class="panel-title">
                    <i class="fas fa-upload"></i>
                    Upload Backup
                </h5>
            </div>
            <div class="p-6">
                <form id="uploadForm" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div class="relative group">
                        <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider ml-1">Pilih File (.sql)</label>
                        <input type="file"
                            class="block w-full cursor-pointer rounded-lg border border-gray-300 p-1 text-sm text-gray-500 transition-all file:mr-4 file:rounded-lg file:border-0 file:bg-emerald-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-emerald-700 hover:file:bg-emerald-100"
                            id="backup_file" name="backup_file" accept=".sql" required>
                    </div>
                    <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-emerald-700">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <span>Upload & Masuk Antrian</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Database Info Card -->
        <div class="panel group hover:border-cyan-200 transition-all duration-300">
            <div class="panel-header">
                <h5 class="panel-title">
                    <i class="fas fa-info-circle"></i>
                    Info Koneksi
                </h5>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-2 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors">
                        <span class="text-sm font-medium text-gray-500">Database</span>
                        <span class="text-sm font-bold text-gray-900">{{ config('database.connections.mysql.database') }}</span>
                    </div>
                    <div class="flex items-center justify-between p-2 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors">
                        <span class="text-sm font-medium text-gray-500">Host / Port</span>
                        <span class="text-sm font-bold text-gray-900">{{ config('database.connections.mysql.host') }}:{{ config('database.connections.mysql.port') }}</span>
                    </div>
                    <div class="flex items-center justify-between p-2 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors">
                        <span class="text-sm font-medium text-gray-500">Total File</span>
                        <div class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">
                            {{ count($backups) }} File
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Backup List Card -->
    <div class="panel">
        <!-- Card Header -->
        <div class="panel-header flex items-center justify-between">
            <h3 class="panel-title">
                <i class="fas fa-server"></i>
                Daftar Backup Tersimpan
            </h3>
            <span class="hidden rounded-full border border-gray-200 bg-white px-4 py-1.5 text-xs font-semibold text-gray-600 sm:block">
                {{ count($backups) }} Tersedia
            </span>
        </div>

        <div class="p-0 sm:p-2">
            @if(count($backups) > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50/80">
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider" width="5%">No</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama File Backup</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Ukuran</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Tanggal Pembuatan</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider" width="200px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($backups as $index => $backup)
                        <tr class="hover:bg-blue-50/50 transition-colors">
                            <td class="px-6 py-4 text-gray-500 font-medium text-center">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform">
                                        <i class="fas fa-file-csv text-xl"></i>
                                    </div>
                                    <span class="font-bold text-gray-800 tracking-tight">{{ $backup['filename'] }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600 font-medium whitespace-nowrap">
                                <span class="px-3 py-1 bg-gray-100 rounded-lg text-xs">{{ $backup['size'] }}</span>
                            </td>
                            <td class="px-6 py-4 text-gray-600 text-center whitespace-nowrap">
                                {{ $backup['date'] }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <button type="button"
                                        onclick="downloadBackup('{{ $backup['filename'] }}')"
                                        class="icon-action bg-blue-600 hover:bg-blue-700 focus:ring-blue-500 group"
                                        title="Download">
                                        <i class="fas fa-download text-sm group-hover:scale-110 transition-transform"></i>
                                    </button>
                                    <button type="button"
                                        onclick="restoreBackup('{{ $backup['filename'] }}')"
                                        class="icon-action bg-emerald-600 hover:bg-emerald-700 focus:ring-emerald-500 group"
                                        title="Restore">
                                        <i class="fas fa-undo text-sm group-hover:rotate-[-45deg] transition-transform"></i>
                                    </button>
                                    <button type="button"
                                        onclick="exportCPanel('{{ $backup['filename'] }}')"
                                        class="icon-action icon-action-info group"
                                        title="Export cPanel">
                                        <i class="fas fa-file-export text-sm group-hover:translate-x-0.5 transition-transform"></i>
                                    </button>
                                    <button type="button"
                                        onclick="deleteBackup('{{ $backup['filename'] }}')"
                                        class="icon-action icon-action-delete group"
                                        title="Hapus">
                                        <i class="fas fa-trash text-sm group-hover:rotate-12 transition-transform"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="flex flex-col items-center justify-center py-16 text-center">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-database text-4xl text-gray-300"></i>
                </div>
                <h4 class="text-lg font-bold text-gray-900 mb-1">Backup Belum Tersedia</h4>
                <p class="text-sm text-gray-500 max-w-sm">Anda belum memiliki file cadangan database. Klik tombol "Eksekusi Backup" untuk membuat yang pertama.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Create backup
    $('#btnCreateBackup').click(function() {
        const btn = $(this);
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Membuat backup...');

        $.ajax({
            url: '{{ route("backups.create") }}',
            method: 'POST',
            success: function(response) {
                Toast.fire({
                    icon: 'success',
                    title: response.message
                });
                setTimeout(() => location.reload(), 1500);
            },
            error: function(xhr) {
                Toast.fire({
                    icon: 'error',
                    title: xhr.responseJSON?.message || 'Gagal membuat backup'
                });
                btn.prop('disabled', false).html('<i class="fas fa-database me-2"></i>Buat Backup');
            }
        });
    });

    // Upload form
    $('#uploadForm').submit(function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const submitBtn = $(this).find('button[type="submit"]');

        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Uploading...');

        $.ajax({
            url: '{{ route("backups.upload") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Toast.fire({
                    icon: 'success',
                    title: response.message
                });
                $('#uploadForm')[0].reset();
                setTimeout(() => location.reload(), 1500);
            },
            error: function(xhr) {
                Toast.fire({
                    icon: 'error',
                    title: xhr.responseJSON?.message || 'Gagal upload file'
                });
            },
            complete: function() {
                submitBtn.prop('disabled', false).html('<i class="fas fa-upload me-2"></i>Upload File');
            }
        });
    });

    // Download backup
    function downloadBackup(filename) {
        window.location.href = `/backups/download/${filename}`;
    }

    // Restore backup
    function restoreBackup(filename) {
        Swal.fire({
            title: 'Restore Database?',
            html: `<p>Anda akan me-restore database dari backup:</p><strong>${filename}</strong><br><br><span class="text-danger">⚠️ PERINGATAN: Semua data saat ini akan diganti dengan data dari backup!</span>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#858796',
            confirmButtonText: 'Ya, Restore!',
            cancelButtonText: 'Batal',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return $.ajax({
                    url: '{{ route("backups.restore") }}',
                    method: 'POST',
                    data: {
                        filename: filename,
                        _token: '{{ csrf_token() }}'
                    }
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: result.value.message,
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.reload();
                });
            }
        }).catch((error) => {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: error.responseJSON?.message || 'Terjadi kesalahan saat restore database'
            });
        });
    }

    // Export for cPanel
    function exportCPanel(filename) {
        Swal.fire({
            title: 'Export untuk cPanel',
            html: `File backup akan di-export dengan instruksi import untuk cPanel.<br><br>File: <strong>${filename}</strong>`,
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#17a2b8',
            cancelButtonColor: '#858796',
            confirmButtonText: 'Export',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `/backups/export-cpanel/${filename}`;
                Toast.fire({
                    icon: 'success',
                    title: 'File sedang diunduh...'
                });
            }
        });
    }

    // Delete backup
    function deleteBackup(filename) {
        Swal.fire({
            title: 'Hapus Backup?',
            html: `Anda akan menghapus backup:<br><strong>${filename}</strong>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74a3b',
            cancelButtonColor: '#858796',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/backups/${filename}`,
                    method: 'DELETE',
                    success: function(response) {
                        Toast.fire({
                            icon: 'success',
                            title: response.message
                        });
                        setTimeout(() => location.reload(), 1000);
                    },
                    error: function(xhr) {
                        Toast.fire({
                            icon: 'error',
                            title: xhr.responseJSON?.message || 'Gagal menghapus backup'
                        });
                    }
                });
            }
        });
    }
</script>
@endpush
