@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        {{-- ホテル一覧（左側） --}}
        <div class="col-lg-3 mb-4">
            <h4 class="mb-3"><i class="fa-solid fa-building me-2"></i>Pending Hotels</h4>
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Maple Crown Hotel
                    <a href="#" class="btn btn-sm btn-outline-primary">Review</a>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Ocean Breeze Resort
                    <a href="#" class="btn btn-sm btn-outline-primary">Review</a>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Cebu Sunset Inn
                    <a href="#" class="btn btn-sm btn-outline-primary">Review</a>
                </li>
            </ul>
        </div>

        {{-- ホテル詳細（右側） --}}
        <div class="col-lg-9">
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-0">Maple Crown Hotel</h2>
                        <div class="text-warning fs-5">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary btn-lg rounded-pill">
                            <i class="fa-solid fa-check me-1"></i> Approve
                        </button>
                        <button class="btn btn-danger btn-lg rounded-pill">
                            <i class="fa-solid fa-xmark me-1"></i>  Reject
                        </button>
                    </div>
                </div>

                <p class="mt-2"><i class="fa-solid fa-location-dot me-1"></i> Cebu City, Philippines</p>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <img src="https://ak-d.tripcdn.com/images/1mc1o12000dn2ylpx0267_R_600_600_R5_D.jpg_.webp"
                            class="img-fluid rounded mb-2" alt="Hotel Image 1">
                    </div>
                    <div class="col-md-6">
                        <img src="https://ak-d.tripcdn.com/images/1mc1o12000dn2ylpx0267_R_600_600_R5_D.jpg_.webp"
                            class="img-fluid rounded mb-2" alt="Hotel Image 2">
                    </div>
                </div>

                <div class="mb-3">
                    <span class="badge bg-secondary me-1"><i class="fa-solid fa-mug-saucer me-1"></i>Café</span>
                    <span class="badge bg-secondary me-1"><i class="fa-solid fa-champagne-glasses me-1"></i>Lounge</span>
                    <span class="badge bg-secondary me-1"><i class="fa-solid fa-person-booth me-1"></i>Exhibition</span>
                </div>

                <h4 class="mt-3"><i class="fa-solid fa-circle-info me-2"></i>Hotel Details</h4>
                <p>This hotel is a modern seaside resort located along the beautiful coastline of Cebu. With stunning
                    ocean views and thoughtfully designed spaces, it offers a relaxing and comfortable stay for both
                    leisure and business travelers.</p>
            </div>
        </div>
    </div>
</div>
@endsection