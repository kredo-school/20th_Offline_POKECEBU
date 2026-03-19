@extends('layouts.user')

@section('title', 'Reviews for ' . $target->name)

@section('content')
<style>
    .review-header {
        background: white;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        margin-bottom: 40px;
        border: 1px solid #f1f5f9;
    }

    .rating-big-number {
        font-size: 3.5rem;
        font-weight: 800;
        color: #1e293b;
        line-height: 1;
    }

    .user-avatar {
        width: 50px;
        height: 50px;
        background: #4f46e5;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: white;
        font-size: 1.2rem;
        box-shadow: 0 4px 6px rgba(79, 70, 229, 0.2);
    }

    .review-item {
        border-bottom: 1px solid #f1f5f9;
        padding: 30px 0;
        transition: all 0.2s ease;
    }

    .review-item:last-child {
        border-bottom: none;
    }

    .star-filled {
        color: #ffc107;
        font-size: 0.9rem;
    }

    .review-content-card {
        background: white;
        border-radius: 24px;
        border: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    }

    .back-link {
        color: #64748b;
        font-weight: 600;
        transition: color 0.2s;
    }

    .back-link:hover {
        color: #4f46e5;
    }
</style>

<div class="container py-5">
    <div class="mb-4">
        <a href="{{ route('user.hotels.detail', $target->id) }}" class="text-decoration-none back-link">
            <i class="fa-solid fa-chevron-left me-2"></i>Back to Detail
        </a>
    </div>

    <div class="review-header d-flex align-items-center justify-content-between flex-wrap gap-4">
        <div class="flex-grow-1">
            <span class="badge bg-soft-primary text-primary mb-3 rounded-pill px-3 py-2 fw-bold" style="background: #eef2ff;">
                <i class="fa-solid fa-tag me-1"></i> {{ ucfirst($type) }}
            </span>
            <h1 class="fw-bold mb-2 text-dark" style="font-size: 2.5rem;">{{ $target->name }}</h1>
            <p class="text-muted mb-0 fs-5">
                <i class="fa-solid fa-location-dot me-2 text-danger"></i>{{ $target->address }}
            </p>
        </div>

        <div class="text-center p-4 rounded-4" style="background: #f8fafc; min-width: 200px; border: 1px solid #e2e8f0;">
            <div class="rating-big-number mb-2">
                {{ number_format($target->star_rating, 1) }}
            </div>
            <div class="star-filled mb-2">
                @php
                    $rating = $target->star_rating;
                    $fullStars = floor($rating);
                    $halfStar = ($rating - $fullStars) >= 0.5;
                @endphp
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= $fullStars)
                        <i class="fa-solid fa-star"></i>
                    @elseif ($halfStar && $i == $fullStars + 1)
                        <i class="fa-solid fa-star-half-stroke"></i>
                    @else
                        <i class="fa-regular fa-star text-muted opacity-50"></i>
                    @endif
                @endfor
            </div>
            <div class="text-muted small fw-bold text-uppercase">
                {{ $reviews->total() }} Community Reviews
            </div>
        </div>
    </div>

    <div class="card review-content-card">
        <div class="card-body p-4 p-md-5">
            <h3 class="fw-bold mb-5 text-dark">
                <i class="fa-solid fa-comments me-2 text-primary"></i>Latest Experiences
            </h3>

            @forelse($reviews as $review)
                <div class="review-item">
                    <div class="d-flex justify-content-between align-items-start mb-3 flex-wrap gap-2">
                        <div class="d-flex align-items-center">
                            <div class="user-avatar me-3">
                                {{ strtoupper(substr($review->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-bold text-dark fs-5">{{ $review->user->name }}</div>
                                <div class="text-muted small">
                                    <i class="fa-regular fa-calendar-check me-1"></i>{{ $review->created_at->format('M d, Y') }}
                                </div>
                            </div>
                        </div>
                        <div class="star-filled bg-light px-3 py-2 rounded-pill">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fa-{{ $i <= $review->rating ? 'solid' : 'regular' }} fa-star"></i>
                            @endfor
                            <span class="ms-1 fw-bold text-dark">{{ $review->rating }}.0</span>
                        </div>
                    </div>

                    <div class="ms-md-5 ps-md-3">
                        <p class="text-secondary lh-lg mb-0" style="font-size: 1.1rem; white-space: pre-line;">
                            "{{ $review->comment }}"
                        </p>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fa-solid fa-comment-slash text-muted opacity-25" style="font-size: 5rem;"></i>
                    </div>
                    <h4 class="text-muted fw-bold">No reviews found</h4>
                    <p class="text-secondary">Be the first to share your experience with the community!</p>
                </div>
            @endforelse

            <div class="d-flex justify-content-center mt-5">
                {{ $reviews->links() }}
            </div>
        </div>
    </div>
</div>
@endsection