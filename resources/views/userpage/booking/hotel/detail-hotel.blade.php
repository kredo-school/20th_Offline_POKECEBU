@extends('layouts.user')

@section('title', 'Detail Hotel')

@section('content')

<div class="container py-5">
<div class="row justify-content-center">
<div class="col-lg-10">

{{-- Hotel Info --}}
<div class="card border-0 shadow-sm mb-5 rounded-4 overflow-hidden">
<div class="card-body p-4">

<h1 class="fw-bold mb-2">{{ $hotel->name }}</h1>

<p class="text-muted">
<i class="fa-solid fa-location-dot text-danger"></i>
{{ $hotel->address }}
</p>

{{-- Rating --}}
@php
$rating = $hotel->star_rating;
$fullStars = floor($rating);
$halfStar = $rating - $fullStars >= 0.5;
@endphp

<div class="text-warning mb-3">
@for ($i = 1; $i <= $fullStars; $i++)
<i class="fa-solid fa-star"></i>
@endfor

@if ($halfStar)
<i class="fa-solid fa-star-half-stroke"></i>
@endif

<span class="text-muted ms-1">{{ number_format($rating,1) }}</span>
</div>

{{-- Favorite --}}
@if ($hotel->isFavorited())
<form method="POST" action="{{ route('user.favorite.destroy',['hotel',$hotel->id]) }}">
@csrf
@method('DELETE')
<button class="btn border-0 bg-transparent p-0">
<i class="fa-solid fa-heart text-danger"></i>
</button>
</form>
@else
<form method="POST" action="{{ route('user.favorite.store',['hotel',$hotel->id]) }}">
@csrf
<button class="btn border-0 bg-transparent p-0">
<i class="fa-regular fa-heart text-secondary"></i>
</button>
</form>
@endif

{{-- Hotel Images --}}
<div class="hotel-images mt-4">
@foreach ($hotel->hotelImages as $image)
<img src="{{ asset('storage/'.$image->image) }}" class="img-fluid rounded mb-2">
@endforeach
</div>

<div class="border-top pt-4 mt-4">
<h5 class="fw-bold">About this hotel</h5>
<p class="text-secondary">{{ $hotel->description }}</p>
</div>

</div>
</div>


{{-- Room List --}}
<h3 class="fw-bold mb-4">Available Rooms</h3>

@foreach ($rooms as $room)

@php
$isAvailable = $room->status->name == 'Available';
@endphp

<div class="card mb-4 shadow-sm rounded-4 overflow-hidden {{ !$isAvailable ? 'opacity-75' : '' }}">
<div class="row g-0">

{{-- Room Images --}}
<div class="col-md-5 bg-light">

@foreach ($room->images as $image)
<img src="{{ asset('storage/'.$image->image) }}" class="img-fluid">
@endforeach

</div>

{{-- Room Info --}}
<div class="col-md-7">

<div class="card-body">

<h5 class="fw-bold">{{ $room->type->name }}</h5>

<p class="text-muted small">
Floor {{ $room->floor_number }} |
Max {{ $room->max_guests }} guests
</p>

<p class="text-secondary">
{{ Str::limit($room->detail,150) }}
</p>

<div class="d-flex justify-content-between align-items-center mt-3">

<div>
<small class="text-muted">Price per night</small>
<h4 class="text-primary fw-bold">
₱{{ number_format($room->charges) }}
</h4>
</div>

@if($isAvailable)

<button
class="btn btn-primary rounded-pill"
data-bs-toggle="modal"
data-bs-target="#roomModal{{ $room->id }}">
Details
</button>

@else

<button class="btn btn-secondary rounded-pill disabled">
Unavailable
</button>

@endif

</div>

</div>
</div>

</div>
</div>


{{-- Modal --}}
<div class="modal fade" id="roomModal{{ $room->id }}" tabindex="-1">
<div class="modal-dialog modal-lg modal-dialog-centered">
<div class="modal-content rounded-4">

<div class="modal-header border-0">
<h5 class="modal-title">{{ $room->type->name }}</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<div class="row">

<div class="col-md-6">
@foreach ($room->images as $image)
<img src="{{ asset('storage/'.$image->image) }}"
class="img-fluid rounded mb-2">
@endforeach
</div>

<div class="col-md-6">

<p class="text-muted">Room No. {{ $room->room_number }}</p>

<p>{{ $room->detail }}</p>

<div class="mt-3">

<p><b>Floor:</b> {{ $room->floor_number }}</p>
<p><b>Max Guests:</b> {{ $room->max_guests }}</p>
<p class="fw-bold text-primary">
₱{{ number_format($room->charges) }}
</p>

</div>

</div>

</div>

</div>

<div class="modal-footer border-0">

<button class="btn btn-light" data-bs-dismiss="modal">
Close
</button>

@if($isAvailable)

<form method="GET" action="{{ route('user.hotels.show',['hotel'=>$hotel->id]) }}">

<input type="hidden" name="clear_reservation_session" value="1">

<input type="hidden" name="guests" value="{{ request('guests',1) }}">
<input type="hidden" name="checkin" value="{{ request('checkin') }}">
<input type="hidden" name="checkout" value="{{ request('checkout') }}">

<button class="btn btn-primary">
Reserve Now
</button>

</form>

@endif

</div>

</div>
</div>
</div>

@endforeach


</div>
</div>
</div>

@endsection