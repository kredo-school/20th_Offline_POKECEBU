@extends('layouts.user')

@section('content')

{{-- フォーム --}}
<div class="container py-5">
    <h2 class="text-center mb-3">
        <i class="fa-solid fa-clipboard-list me-2"></i>Register Your Business
    </h2>
    <p class="text-center text-muted mb-5">
        Fill out the form below to manage your hotel or restaurant bookings on our platform.
    </p>

    <form class="row g-4 justify-content-center">
        <!-- Restaurant Section -->
        <div class="col-md-5">
            <div class="card">
                <div class="card-header bg-white text-primary">
                    <i class="fa-solid fa-utensils me-2"></i>Restaurant
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Company Name</label>
                        <input type="text" class="form-control" placeholder="Enter your company name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Representative’s Name</label>
                        <input type="text" class="form-control" placeholder="Enter representative's full name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" placeholder="Enter your business email">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <div class="input-group">
                            <span class="input-group-text">+63</span>
                            <input type="tel" class="form-control" placeholder="Enter phone number">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Business Address</label>
                        <input type="text" class="form-control" placeholder="Enter your business address">
                    </div>
                </div>
            </div>
        </div>

        <!-- Hotel Section -->
        <div class="col-md-5">
            <div class="card">
                <div class="card-header bg-white text-success">
                    <i class="fa-solid fa-hotel me-2"></i>Hotel
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Company Name</label>
                        <input type="text" class="form-control" placeholder="Enter your company name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Representative’s Name</label>
                        <input type="text" class="form-control" placeholder="Enter representative's full name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" placeholder="Enter your business email">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <div class="input-group">
                            <span class="input-group-text">+63</span>
                            <input type="tel" class="form-control" placeholder="Enter phone number">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Business Address</label>
                        <input type="text" class="form-control" placeholder="Enter your business address">
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-custom mt-4">
                <i class="fa-solid fa-paper-plane me-2"></i>Register Now
            </button>
        </div>
    </form>
</div>
@endsection