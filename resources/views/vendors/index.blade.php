@extends('layouts.app')

@section('title', 'Data Vendor')
@section('header_title', 'Data Vendor')

@section('content')
<div class="page-shell">
    <div class="page-header">
        <div>
            <h1 class="page-title">
                <span class="page-title-icon">
                    <i class="fas fa-truck text-lg"></i>
                </span>
                Data Vendor
            </h1>
            <p class="page-subtitle">Kelola data vendor dan supplier</p>
        </div>
        <a href="{{ route('vendors.create') }}" class="btn-primary-theme">
            <i class="fas fa-plus"></i>
            <span>Tambah Vendor</span>
        </a>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="stat-card">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Vendor</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900">{{ $vendors->count() }}</p>
                </div>
                <div class="stat-icon bg-blue-50 text-blue-600">
                    <i class="fas fa-truck"></i>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Item</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900">{{ $vendors->sum('items_count') }}</p>
                </div>
                <div class="stat-icon bg-emerald-50 text-emerald-600">
                    <i class="fas fa-box"></i>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Procurement</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900">{{ $vendors->sum('procurements_count') }}</p>
                </div>
                <div class="stat-icon bg-cyan-50 text-cyan-600">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Repair</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900">{{ $vendors->sum('repairs_count') }}</p>
                </div>
                <div class="stat-icon bg-amber-50 text-amber-600">
                    <i class="fas fa-tools"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header flex items-center justify-between gap-3">
            <h3 class="panel-title">
                <i class="fas fa-truck"></i>
                Daftar Vendor
            </h3>
            <a href="{{ route('vendors.create') }}" class="btn-primary-theme px-4 py-2">
                <i class="fas fa-plus"></i>
                <span class="hidden sm:inline">Tambah Vendor</span>
                <span class="sm:hidden">Tambah</span>
            </a>
        </div>

        <div class="panel-body">
            <div class="overflow-x-auto">
                <table id="vendorsTable" class="w-full text-sm">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-700" style="width: 80px;">Kode</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-700">Nama Vendor</th>
                            <th class="hidden px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 md:table-cell">Contact Person</th>
                            <th class="hidden px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 lg:table-cell">Telepon</th>
                            <th class="hidden px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 xl:table-cell">Email</th>
                            <th class="hidden px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 xl:table-cell">Alamat</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-700">Total Item</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-700" style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($vendors as $vendor)
                        <tr class="transition-colors hover:bg-blue-50/50">
                            <td class="px-4 py-3 text-center">
                                <span class="dt-badge dt-badge-primary">{{ $vendor->kode_vendor }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="font-semibold text-gray-900">{{ $vendor->nama_vendor }}</div>
                                <div class="mt-1 text-xs text-gray-500 md:hidden">
                                    @if($vendor->contact_person)
                                    <div><i class="fas fa-user mr-1"></i>{{ $vendor->contact_person }}</div>
                                    @endif
                                    @if($vendor->telepon)
                                    <div><i class="fas fa-phone mr-1"></i>{{ $vendor->telepon }}</div>
                                    @endif
                                </div>
                            </td>
                            <td class="hidden px-4 py-3 text-gray-600 md:table-cell">{{ $vendor->contact_person ?? '-' }}</td>
                            <td class="hidden px-4 py-3 lg:table-cell">
                                @if($vendor->telepon)
                                <a href="tel:{{ $vendor->telepon }}" class="font-medium text-blue-600 hover:text-blue-700">
                                    <i class="fas fa-phone mr-1 text-xs"></i>{{ $vendor->telepon }}
                                </a>
                                @else
                                <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="hidden px-4 py-3 xl:table-cell">
                                @if($vendor->email)
                                <a href="mailto:{{ $vendor->email }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">
                                    {{ $vendor->email }}
                                </a>
                                @else
                                <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="hidden px-4 py-3 text-gray-600 xl:table-cell">{{ Str::limit($vendor->alamat ?? '-', 40) }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="dt-badge dt-badge-info">{{ $vendor->items_count }} item</span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('vendors.edit', $vendor) }}" class="icon-action icon-action-edit" title="Edit">
                                        <i class="fas fa-edit text-xs"></i>
                                    </a>
                                    <form action="{{ route('vendors.destroy', $vendor) }}" method="POST" class="delete-form inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="icon-action icon-action-delete" title="Hapus">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center gap-3 text-gray-500">
                                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-gray-100">
                                        <i class="fas fa-inbox text-3xl text-gray-400"></i>
                                    </div>
                                    <p class="font-medium">Belum ada data vendor</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#vendorsTable').DataTable({
            responsive: true,
            language: {
                url: '{{ asset("vendor/datatables/i18n/id.json") }}'
            },
            pageLength: 10,
            lengthMenu: [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ],
            order: [
                [0, 'asc']
            ],
            columnDefs: [{
                orderable: false,
                targets: -1
            }]
        });

        $('.delete-form').on('submit', function(e) {
            e.preventDefault();
            const form = this;

            Swal.fire({
                title: 'Hapus Vendor?',
                text: 'Data vendor akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
