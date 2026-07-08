@extends('layouts.app')

@section('title', 'Contoh Penggunaan Template')

@section('header_title', 'Contoh Template')

{{-- Custom CSS untuk halaman ini --}}
@push('styles')
<style>
    .example-card {
        border-left: 4px solid var(--primary-color);
    }
    
    .code-block {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
        font-family: 'Courier New', monospace;
        font-size: 0.875rem;
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card example-card">
            <div class="card-header">
                <i class="fas fa-code me-2"></i>
                Contoh Penggunaan Template
            </div>
            <div class="card-body">
                <h5>1. Struktur Dasar</h5>
                <div class="code-block mb-4">
                    @verbatim
                    @extends('layouts.app')
                    
                    @section('title', 'Judul Halaman')
                    @section('header_title', 'Judul Header')
                    
                    @section('content')
                        <!-- Konten Anda -->
                    @endsection
                    @endverbatim
                </div>

                <h5>2. Menambahkan Custom CSS</h5>
                <div class="code-block mb-4">
                    @verbatim
                    @push('styles')
                    <style>
                        .custom-class {
                            color: red;
                        }
                    </style>
                    @endpush
                    @endverbatim
                </div>

                <h5>3. Menambahkan Custom JavaScript</h5>
                <div class="code-block mb-4">
                    @verbatim
                    @push('scripts')
                    <script>
                        $(document).ready(function() {
                            console.log('Custom script loaded');
                        });
                    </script>
                    @endpush
                    @endverbatim
                </div>

                <h5>4. Menampilkan Alert dari Controller</h5>
                <div class="code-block mb-4">
                    // Success<br>
                    return redirect()->route('dashboard')->with('success', 'Berhasil!');<br><br>
                    
                    // Error<br>
                    return back()->with('error', 'Terjadi kesalahan!');<br><br>
                    
                    // Warning<br>
                    return back()->with('warning', 'Peringatan!');<br><br>
                    
                    // Info<br>
                    return back()->with('info', 'Informasi!');
                </div>

                <h5>5. Komponen Template</h5>
                <ul>
                    <li><strong>Head:</strong> layouts/partials/head.blade.php</li>
                    <li><strong>Styles:</strong> layouts/partials/styles.blade.php</li>
                    <li><strong>Header:</strong> layouts/partials/header.blade.php</li>
                    <li><strong>Sidebar:</strong> layouts/sidebar.blade.php</li>
                    <li><strong>Footer:</strong> layouts/partials/footer.blade.php</li>
                    <li><strong>Alerts:</strong> layouts/partials/alerts.blade.php</li>
                    <li><strong>Scripts:</strong> layouts/partials/scripts.blade.php</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-palette me-2"></i>
                Contoh Card
            </div>
            <div class="card-body">
                <p>Ini adalah contoh card dengan styling default.</p>
                <button class="btn btn-primary">
                    <i class="fas fa-check me-2"></i>Button Primary
                </button>
                <button class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i>Button Secondary
                </button>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-table me-2"></i>
                Contoh Tabel
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Item 1</td>
                            <td><span class="badge bg-success">Aktif</span></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Item 2</td>
                            <td><span class="badge bg-warning">Pending</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Custom JavaScript untuk halaman ini --}}
@push('scripts')
<script>
    $(document).ready(function() {
        console.log('Template usage example page loaded');
        
        // Contoh SweetAlert Toast
        Toast.fire({
            icon: 'info',
            title: 'Halaman contoh template berhasil dimuat!'
        });
    });
</script>
@endpush
