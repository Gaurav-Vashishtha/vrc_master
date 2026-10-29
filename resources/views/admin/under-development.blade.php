@extends('admin.template.base')
@section('title', 'Under Development')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="d-flex flex-column align-items-center justify-content-center text-center" style="height: 80vh;">
            <div class="mb-4">
                <i class="mdi mdi-cart-outline" style="font-size: 60px; color: #f39c12;"></i>
            </div>
            <h2 class="text-warning mb-2">Feature Under Development</h2>
            <p class="text-muted mb-2" style="max-width: 550px;">
                This section is part of our upcoming eCommerce enhancements. We’re actively working to bring new features that will help you better manage your store, customers, and performance.
            </p>
            <p class="text-muted">Stay tuned! New capabilities are on their way very soon.</p>
            <a href="{{ url('admin/dashboard') }}" class="btn btn-outline-primary mt-4">
                <i class="mdi mdi-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
