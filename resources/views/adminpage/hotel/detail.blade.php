 @extends('layouts.admin')

 @section('content')
     <div class="container py-5">
         <div class="row justify-content-center">
             <div class="col-lg-10">

                 <div class="mb-2"><a href="{{ route('admin.showList', 'hotel') }}">◀︎ List of Hotels</a></div>
                 {{-- 1. Hotel Info Section --}}
                 <div class="card bg-white border-0 shadow-sm mb-5 rounded-4 overflow-hidden">
                     <div class="card-body p-4">
                         <div class="d-flex justify-content-between align-items-start mb-4">
                             <div>
                                 <h1 class="fw-bold mb-2">{{ $hotel->name }}</h1>
                                 <div class="d-flex align-items-center flex-wrap gap-3">
                                     <p class="text-muted mb-0">
                                         <i class="fa-solid fa-location-dot me-1 text-danger"></i>
                                         {{ $hotel->address }}
                                     </p>

                                     {{-- Star Rating --}}
                                     @php
                                         $rating = $hotel->star_rating;
                                         $fullStars = floor($rating);
                                         $halfStar = $rating - $fullStars >= 0.5;
                                     @endphp
                                     <div class="text-warning">
                                         @for ($i = 1; $i <= $fullStars; $i++)
                                             <i class="fa-solid fa-star"></i>
                                         @endfor
                                         @if ($halfStar)
                                             <i class="fa-solid fa-star-half-stroke"></i>
                                         @endif
                                         <span class="text-muted ms-1 fw-bold">{{ number_format($rating, 1) }}</span>
                                     </div>
                                 </div>
                             </div>
                         </div>

                         {{-- Hotel Gallery --}}
                         <div class="hotel-images mb-4 hide-scrollbar" style="display: flex; overflow-x: auto; gap: 15px;">
                             @foreach ($hotel->hotelImages as $image)
                                 <img src="{{ asset('storage/' . $image->image) }}" alt="hotel image" class="rounded-3"
                                     style="height: 250px; object-fit: cover;">
                             @endforeach
                         </div>

                         <div class="border-top pt-4">
                             <h5 class="fw-bold mb-3">About this hotel</h5>
                             <p class="text-secondary lh-lg mb-0">
                                 {{ $hotel->description }}
                             </p>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 @endsection
