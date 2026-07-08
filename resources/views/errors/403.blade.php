@extends('layouts.app')

@section('title', 'Akses Ditolak')

@section('content')
<div class="flex min-h-[60vh] items-center justify-center">
    <div class="panel max-w-xl text-center">
        <div class="panel-body p-10">
            <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-lg bg-red-50 text-red-600">
                <i class="fas fa-lock text-3xl"></i>
            </div>
            <p class="text-sm font-semibold uppercase tracking-wider text-red-600">403</p>
            <h1 class="mt-2 text-2xl font-bold text-gray-900">Akses Ditolak</h1>
            <p class="mt-3 text-sm leading-6 text-gray-600">
                {{ $exception->getMessage() ?: 'Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.' }}
            </p>
            <div class="mt-8">
                <a href="{{ route('dashboard') }}" class="btn-primary-theme">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
