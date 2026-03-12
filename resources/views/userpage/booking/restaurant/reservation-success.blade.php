@extends('layouts.app')

@section('content')
<div class="container my-5 text-center">
    <h2 class="fw-bold mb-3">Reservation Completed 🎉</h2>

    <p class="mb-4">The payment process is for testing purposes only.</p>

    <div class="mt-4">
        <a href="{{ route('user.mypage') }}" class="btn btn-primary">
            Back to My Page
        </a>
    </div>
</div>
@endsection
