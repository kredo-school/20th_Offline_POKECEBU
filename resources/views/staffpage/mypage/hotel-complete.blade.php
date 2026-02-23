@extends('layouts.app')

@section('content')
<div class="container my-5 text-center">
    <h2 class="fw-bold mb-3">Hotel Application Complete 🎉</h2>

    <p class="mb-4">Your hotel information has been successfully submitted.</p>

    <a href="{{ route('hotel.mypage.hotel') }}" class="btn btn-primary">
        Back to My Page
    </a>
</div>
@endsection