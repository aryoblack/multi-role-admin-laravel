@extends('layouts.app')

@section('title', 'Dashboard')
@section('header_title', 'Dashboard Overview')

@section('content')
<div class="container-fluid">
    <!-- Welcome Banner -->
    <div class="card gradient-primary text-white mb-4 hover-lift">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2 fw-bold">Welcome back, {{ Auth::user()->name }}! 👋</h2>
                    <p class="mb-0 opacity-75">Here's what's happening with your inventory today.</p>
                </div>
                <div class="col-md-4 text-end d-none d-md-block">
                    <i class="fas fa-chart-line" style="font-size: 5rem; opacity: 0.2;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 hover-lift">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-box gradient-primary me-3">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">Total Items</h6>
                            <h3 class="mb-0 fw-bold">1,234</h3>
                        </div>
                    </div>
                    <div class="progress-modern mt-3">
                        <div class="progress-bar" style="width: 75%"></div>
                    </div>
                    <small class="text-muted mt-2 d-block">
                        <i class="fas fa-arrow-up text-success me-1"></i> 12% from last month
                    </small>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 hover-lift">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-box gradient-success me-3">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">Active Users</h6>
                            <h3 class="mb-0 fw-bold">{{ \App\Models\User::where('status', 'active')->count() }}</h3>
                        </div>
                    </div>
                    <div class="progress-modern mt-3">
                        <div class="progress-bar bg-success" style="width: 60%"></div>
                    </div>
                    <small class="text-muted mt-2 d-block">
                        <i class="fas fa-arrow-up text-success me-1"></i> 8% from last month
                    </small>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 hover-lift">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-box gradient-warning me-3">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">Low Stock</h6>
                            <h3 class="mb-0 fw-bold">23</h3>
                        </div>
                    </div>
                    <div class="progress-modern mt-3">
                        <div class="progress-bar bg-warning" style="width: 30%"></div>
                    </div>
                    <small class="text-muted mt-2 d-block">
                        <i class="fas fa-arrow-down text-danger me-1"></i> 5% from last month
                    </small>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 hover-lift">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-box gradient-info me-3">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">Total Value</h6>
                            <h3 class="mb-0 fw-bold">$45.2K</h3>
                        </div>
                    </div>
                    <div class="progress-modern mt-3">
                        <div class="progress-bar bg-info" style="width: 85%"></div>
                    </div>
                    <small class="text-muted mt-2 d-block">
                        <i class="fas fa-arrow-up text-success me-1"></i> 18% from last month
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts & Activity -->
    <div class="row g-4">
        <div class="col-xl-8">
            <div class="card border-0 hover-lift">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-chart-line text-primary me-2"></i>
                        Inventory Overview
                    </h5>
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-outline-primary active">Week</button>
                        <button type="button" class="btn btn-outline-primary">Month</button>
                        <button type="button" class="btn btn-outline-primary">Year</button>
                    </div>
                </div>
                <div class="card-body">
                    <div style="height: 300px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); border-radius: 0.85rem;">
                        <div class="text-center">
                            <i class="fas fa-chart-area" style="font-size: 4rem; color: rgba(54, 153, 255, 0.3);"></i>
                            <p class="text-muted mt-3 mb-0">Chart will be displayed here</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card border-0 hover-lift">
                <div class="card-header bg-transparent border-0">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-clock text-primary me-2"></i>
                        Recent Activity
                    </h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-semibold">New item added</h6>
                                    <p class="text-muted mb-1" style="font-size: 0.875rem;">Laptop Dell XPS 15 added to inventory</p>
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>2 hours ago
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-semibold">Stock updated</h6>
                                    <p class="text-muted mb-1" style="font-size: 0.875rem;">Mouse Logitech stock increased by 50</p>
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>5 hours ago
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-semibold">Low stock alert</h6>
                                    <p class="text-muted mb-1" style="font-size: 0.875rem;">Keyboard Mechanical running low</p>
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>1 day ago
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-semibold">New user registered</h6>
                                    <p class="text-muted mb-1" style="font-size: 0.875rem;">John Doe joined the system</p>
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>2 days ago
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-4 mt-2">
        <div class="col-12">
            <div class="card border-0 hover-lift">
                <div class="card-header bg-transparent border-0">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-bolt text-primary me-2"></i>
                        Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3 col-sm-6">
                            <a href="#" class="text-decoration-none">
                                <div class="p-4 text-center rounded hover-lift" style="background: linear-gradient(135deg, rgba(54, 153, 255, 0.1) 0%, rgba(54, 153, 255, 0.05) 100%); border: 1px solid rgba(54, 153, 255, 0.2);">
                                    <i class="fas fa-plus-circle text-primary mb-3" style="font-size: 2.5rem;"></i>
                                    <h6 class="mb-0 fw-semibold text-dark">Add New Item</h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('users.index') }}" class="text-decoration-none">
                                <div class="p-4 text-center rounded hover-lift" style="background: linear-gradient(135deg, rgba(27, 197, 189, 0.1) 0%, rgba(27, 197, 189, 0.05) 100%); border: 1px solid rgba(27, 197, 189, 0.2);">
                                    <i class="fas fa-user-plus text-success mb-3" style="font-size: 2.5rem;"></i>
                                    <h6 class="mb-0 fw-semibold text-dark">Manage Users</h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('settings.index') }}" class="text-decoration-none">
                                <div class="p-4 text-center rounded hover-lift" style="background: linear-gradient(135deg, rgba(137, 80, 252, 0.1) 0%, rgba(137, 80, 252, 0.05) 100%); border: 1px solid rgba(137, 80, 252, 0.2);">
                                    <i class="fas fa-cog text-info mb-3" style="font-size: 2.5rem;"></i>
                                    <h6 class="mb-0 fw-semibold text-dark">Settings</h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="#" class="text-decoration-none">
                                <div class="p-4 text-center rounded hover-lift" style="background: linear-gradient(135deg, rgba(255, 168, 0, 0.1) 0%, rgba(255, 168, 0, 0.05) 100%); border: 1px solid rgba(255, 168, 0, 0.2);">
                                    <i class="fas fa-file-export text-warning mb-3" style="font-size: 2.5rem;"></i>
                                    <h6 class="mb-0 fw-semibold text-dark">Export Report</h6>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.12);
    }
    
    .icon-box {
        animation: float-animation 3s ease-in-out infinite;
    }
    
    @keyframes float-animation {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
</style>
@endpush
