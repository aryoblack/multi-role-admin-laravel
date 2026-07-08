@extends('layouts.app')

@section('title', 'UI Components')
@section('header_title', 'UI Components')

@section('content')
{{-- Page Header --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="page-header">
            <h2 class="page-title">UI Components</h2>
            <p class="page-subtitle">Koleksi komponen UI yang tersedia dalam template</p>
        </div>
    </div>
</div>

{{-- Buttons --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-mouse-pointer me-2"></i>Buttons
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <button class="btn btn-primary">
                        <i class="fas fa-check me-2"></i>Primary
                    </button>
                    <button class="btn btn-success">
                        <i class="fas fa-check-circle me-2"></i>Success
                    </button>
                    <button class="btn btn-danger">
                        <i class="fas fa-times me-2"></i>Danger
                    </button>
                    <button class="btn btn-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>Warning
                    </button>
                    <button class="btn btn-info">
                        <i class="fas fa-info-circle me-2"></i>Info
                    </button>
                    <button class="btn btn-light">
                        <i class="fas fa-circle me-2"></i>Light
                    </button>
                </div>
                
                <div class="d-flex flex-wrap gap-2">
                    <button class="btn btn-primary btn-sm">Small</button>
                    <button class="btn btn-primary">Regular</button>
                    <button class="btn btn-primary btn-lg">Large</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Alerts --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bell me-2"></i>Alerts
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-primary alert-permanent mb-3">
                    <i class="fas fa-info-circle"></i>
                    <strong>Info!</strong> This is a primary alert message.
                </div>
                <div class="alert alert-success alert-permanent mb-3">
                    <i class="fas fa-check-circle"></i>
                    <strong>Success!</strong> Your action was completed successfully.
                </div>
                <div class="alert alert-warning alert-permanent mb-3">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Warning!</strong> Please check your input.
                </div>
                <div class="alert alert-danger alert-permanent mb-0">
                    <i class="fas fa-times-circle"></i>
                    <strong>Error!</strong> Something went wrong.
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Badges --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-tag me-2"></i>Badges
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge badge-primary">
                        <i class="fas fa-circle me-1"></i>Primary
                    </span>
                    <span class="badge badge-success">
                        <i class="fas fa-check me-1"></i>Success
                    </span>
                    <span class="badge badge-danger">
                        <i class="fas fa-times me-1"></i>Danger
                    </span>
                    <span class="badge badge-warning">
                        <i class="fas fa-exclamation me-1"></i>Warning
                    </span>
                    <span class="badge badge-info">
                        <i class="fas fa-info me-1"></i>Info
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Forms --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-edit me-2"></i>Form Elements
                </h5>
            </div>
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Text Input</label>
                            <input type="text" class="form-control" placeholder="Enter text">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email Input</label>
                            <input type="email" class="form-control" placeholder="Enter email">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Select</label>
                            <select class="form-select">
                                <option selected>Choose...</option>
                                <option value="1">Option 1</option>
                                <option value="2">Option 2</option>
                                <option value="3">Option 3</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date Input</label>
                            <input type="date" class="form-control">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Textarea</label>
                            <textarea class="form-control" rows="3" placeholder="Enter description"></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Submit
                            </button>
                            <button type="reset" class="btn btn-light">
                                <i class="fas fa-undo me-2"></i>Reset
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Cards Grid --}}
<div class="row g-4">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <div class="mb-3">
                    <i class="fas fa-rocket fa-3x text-primary"></i>
                </div>
                <h5 class="card-title">Fast Performance</h5>
                <p class="card-text">Optimized for speed and efficiency</p>
                <a href="#" class="btn btn-primary btn-sm">Learn More</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <div class="mb-3">
                    <i class="fas fa-shield-alt fa-3x text-success"></i>
                </div>
                <h5 class="card-title">Secure</h5>
                <p class="card-text">Built with security best practices</p>
                <a href="#" class="btn btn-success btn-sm">Learn More</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <div class="mb-3">
                    <i class="fas fa-mobile-alt fa-3x text-info"></i>
                </div>
                <h5 class="card-title">Responsive</h5>
                <p class="card-text">Works on all devices and screen sizes</p>
                <a href="#" class="btn btn-info btn-sm">Learn More</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.page-header {
    margin-bottom: 2rem;
}

.page-title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.page-subtitle {
    font-size: 1rem;
    color: var(--text-secondary);
    margin: 0;
}
</style>
@endpush
