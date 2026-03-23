@extends('layouts.user')

@section('title', 'Reviews for ' . $target->name)

@section('content')
    <style>
        .review-header {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            border: 1px solid #f1f5f9;
        }

        .rating-number {
            font-size: 3rem;
            font-weight: 800;
            color: #1e293b;
            line-height: 1;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            background: #ef4444;
            /* レストランらしく赤系のアクセント */
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
        }

        .review-item {
            border-bottom: 1px solid #f1f5f9;
            padding: 25px 0;
        }

        .review-item:last-child {
            border-bottom: none;
        }

        .star-filled {
            color: #ffc107;
        }

        .review-card {
            background: white;
            border-radius: 20px;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .badge-type {
            background-color: #fee2e2;
            color: #ef4444;
            font-weight: 700;
        }
    </style>

    <div class="container py-5">
        {{-- Navigation --}}
        <div class="mb-4">
            <a href="{{ route('user.restaurants.detail', $target->id) }}" class="text-decoration-none text-muted fw-bold">
                <i class="fa-solid fa-chevron-left me-2"></i> Back to Detail
            </a>
        </div>

        {{-- Header Summary --}}
        <div class="review-header d-flex align-items-center justify-content-between shadow-sm mb-4"
            style="background: white; border-radius: 20px; padding: 30px; border: 1px solid #f1f5f9;">

            <div class="flex-grow-1 me-4" style="min-width: 0;">
                <span class="badge badge-type mb-2 rounded-pill px-3 py-2 text-uppercase"
                    style="background-color: #fee2e2; color: #ef4444; font-weight: 700;">
                    <i class="fa-solid fa-utensils me-1"></i> {{ $type }}
                </span>

                <h1 class="fw-bold mb-1 text-dark"
                    style="overflow-wrap: break-word; word-break: break-word; font-size: 2.5rem;">
                    {{ $target->name }}
                </h1>

                <p class="text-muted mb-0">
                    <i class="fa-solid fa-location-dot me-1 text-danger"></i> {{ $target->address }}
                </p>
            </div>

            <div class="text-center bg-light p-3 rounded-4 border flex-shrink-0"
                style="min-width: 170px; align-self: center;">
                @php
                    $rating = $target->star_rating;
                    $fullStars = floor($rating);
                    $halfStar = $rating - $fullStars >= 0.5;
                @endphp

                <div class="rating-number mb-1" style="font-size: 3rem; font-weight: 800; color: #1e293b; line-height: 1;">
                    {{ number_format($rating, 1) }}
                </div>

                <div class="star-filled mb-1" style="color: #ffc107;">
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

                <div class="small text-muted text-uppercase fw-bold">{{ $reviews->total() }} Reviews</div>
            </div>
        </div>

        {{-- Review List Card --}}
        <div class="card review-card">
            <div class="card-body p-4 p-md-5">
                <h3 class="fw-bold mb-4 text-dark">
                    <i class="fa-solid fa-comments me-2 text-primary"></i>Latest Experiences
                </h3>

                @forelse($reviews as $review)
                    <div class="review-item">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-3">
                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $review->user->name }}</div>
                                    <div class="text-muted small">
                                        <i
                                            class="fa-regular fa-calendar me-1"></i>{{ $review->created_at->format('M d, Y') }}
                                    </div>
                                </div>
                            </div>
                            <div class="star-filled bg-light px-2 py-1 rounded">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa-{{ $i <= $review->rating ? 'solid' : 'regular' }} fa-star"></i>
                                @endfor
                            </div>
                        </div>

                        <div class="ms-md-5 ps-md-2">
                            <p class="text-secondary lh-lg mb-0" style="font-size: 1.1rem; white-space: pre-line;">
                                {{ $review->comment }}
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

                {{-- Pagination --}}
                <div class="d-flex justify-content-center mt-5">
                    {{ $reviews->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
