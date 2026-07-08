@extends('layouts.app')

@section('title', 'Edit Vendor')
@section('header_title', 'Edit Vendor')

@section('content')
<div class="page-shell">
    <div class="page-header">
        <div>
            <h1 class="page-title">
                <span class="page-title-icon">
                    <i class="fas fa-edit text-lg"></i>
                </span>
                Edit Vendor
            </h1>
            <p class="page-subtitle">Perbarui data vendor dan kontak supplier</p>
        </div>
        <a href="{{ route('vendors.index') }}" class="btn-secondary-theme">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-12">
        <div class="xl:col-span-8">
            <div class="panel">
                <div class="panel-header">
                    <h3 class="panel-title">
                        <i class="fas fa-truck"></i>
                        Form Edit Vendor
                    </h3>
                </div>

                <div class="panel-body">
                    <form action="{{ route('vendors.update', $vendor) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="kode_vendor" class="form-label">Kode Vendor <span class="text-red-500">*</span></label>
                                <input type="text" class="form-field @error('kode_vendor') border-red-500 @enderror" id="kode_vendor" name="kode_vendor" value="{{ old('kode_vendor', $vendor->kode_vendor) }}" required>
                                @error('kode_vendor')
                                <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-xs text-gray-500">Kode unik untuk vendor.</p>
                            </div>

                            <div>
                                <label for="nama_vendor" class="form-label">Nama Vendor <span class="text-red-500">*</span></label>
                                <input type="text" class="form-field @error('nama_vendor') border-red-500 @enderror" id="nama_vendor" name="nama_vendor" value="{{ old('nama_vendor', $vendor->nama_vendor) }}" required>
                                @error('nama_vendor')
                                <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-field @error('alamat') border-red-500 @enderror" id="alamat" name="alamat" rows="3" placeholder="Alamat lengkap vendor">{{ old('alamat', $vendor->alamat) }}</textarea>
                                @error('alamat')
                                <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                            <h4 class="mb-4 flex items-center gap-2 text-sm font-semibold text-gray-900">
                                <i class="fas fa-address-book text-blue-600"></i>
                                Informasi Kontak
                            </h4>

                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label for="contact_person" class="form-label">Contact Person</label>
                                    <input type="text" class="form-field @error('contact_person') border-red-500 @enderror" id="contact_person" name="contact_person" value="{{ old('contact_person', $vendor->contact_person) }}" placeholder="Nama kontak person">
                                    @error('contact_person')
                                    <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="telepon" class="form-label">Telepon</label>
                                    <input type="text" class="form-field @error('telepon') border-red-500 @enderror" id="telepon" name="telepon" value="{{ old('telepon', $vendor->telepon) }}" placeholder="Nomor telepon">
                                    @error('telepon')
                                    <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-field @error('email') border-red-500 @enderror" id="email" name="email" value="{{ old('email', $vendor->email) }}" placeholder="email@vendor.com">
                                    @error('email')
                                    <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 border-t border-gray-100 pt-6">
                            <a href="{{ route('vendors.index') }}" class="btn-secondary-theme">
                                <i class="fas fa-times"></i>
                                Batal
                            </a>
                            <button type="submit" class="btn-primary-theme">
                                <i class="fas fa-save"></i>
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="xl:col-span-4">
            <div class="panel">
                <div class="panel-header">
                    <h3 class="panel-title">
                        <i class="fas fa-chart-bar"></i>
                        Statistik Vendor
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="grid grid-cols-2 gap-3">
                        <div class="rounded-lg bg-blue-50 p-4 text-center">
                            <p class="text-2xl font-bold text-blue-700">{{ $vendor->items_count }}</p>
                            <p class="mt-1 text-xs font-medium text-blue-700/70">Total Item</p>
                        </div>
                        <div class="rounded-lg bg-emerald-50 p-4 text-center">
                            <p class="text-2xl font-bold text-emerald-700">{{ $vendor->procurements_count }}</p>
                            <p class="mt-1 text-xs font-medium text-emerald-700/70">Pengadaan</p>
                        </div>
                        <div class="rounded-lg bg-amber-50 p-4 text-center">
                            <p class="text-2xl font-bold text-amber-700">{{ $vendor->repairs_count }}</p>
                            <p class="mt-1 text-xs font-medium text-amber-700/70">Perbaikan</p>
                        </div>
                        <div class="rounded-lg bg-cyan-50 p-4 text-center">
                            <p class="text-2xl font-bold text-cyan-700">{{ $vendor->calibrations_count }}</p>
                            <p class="mt-1 text-xs font-medium text-cyan-700/70">Kalibrasi</p>
                        </div>
                    </div>

                    <div class="mt-6 divide-y divide-gray-100 rounded-lg border border-gray-200">
                        <div class="flex items-center justify-between px-4 py-3">
                            <span class="text-sm text-gray-500">Dibuat</span>
                            <span class="text-sm font-semibold text-gray-900">{{ $vendor->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex items-center justify-between px-4 py-3">
                            <span class="text-sm text-gray-500">Update Terakhir</span>
                            <span class="text-sm font-semibold text-gray-900">{{ $vendor->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('kode_vendor').addEventListener('input', function(e) {
        e.target.value = e.target.value.toUpperCase();
    });
</script>
@endpush
