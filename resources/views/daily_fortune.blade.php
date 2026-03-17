@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(180deg, #fffef7 0%, #fff8ee 100%);
        font-family: 'Segoe UI', sans-serif;
    }

    .fortune-wrapper {
        max-width: 800px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .fortune-card {
        border-radius: 20px;
        background: #ffffff;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .fortune-header {
        background: linear-gradient(135deg, #ffd36e, #ffb86c);
        color: #4a3100;
        padding: 40px 20px;
        text-align: center;
    }

    .fortune-header h1 {
        font-size: 2.2rem;
        font-weight: 800;
        margin-bottom: 10px;
    }

    .fortune-header p {
        font-size: 1rem;
        margin: 0;
    }

    .fortune-body {
        padding: 30px;
    }

    .draw-btn {
        border: none;
        border-radius: 20px;
        padding: 14px 28px;
        font-weight: 700;
        background: linear-gradient(135deg, #6FA9DE, #51C9D0);
        color: #fff;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .draw-btn:hover {
        background: linear-gradient(135deg, #51C9D0, #6FA9DE);
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(81, 201, 208, 0.3);
    }

    .spot-card {
        border-radius: 16px;
        padding: 24px;
        background: #fdfdfd;
        box-shadow: 0 6px 16px rgba(0,0,0,0.05);
        margin-top: 20px;
    }

    .spot-name {
        font-size: 1.6rem;
        font-weight: 800;
        color: #1e3447;
        margin-bottom: 12px;
    }

    .spot-meta {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 999px;
        background: #eef9fb;
        color: #15435a;
        font-weight: 600;
        margin-right: 8px;
        margin-bottom: 10px;
    }

    .spot-description {
        color: #5d7181;
        line-height: 1.8;
        margin-top: 10px;
    }

    .spot-image {
        width: 100%;
        max-height: 500px;
        object-fit: cover;
        border-radius: 18px;
        margin-bottom: 18px;
        box-shadow: 0 12px 24px rgba(0,0,0,0.25);
    }
</style>

<div class="container fortune-wrapper">
    <div class="fortune-card">
        <div class="fortune-header">
            <h1>Today's Cebu Fortune</h1>
            <p>Let's draw today's recommended spot for you.</p>
        </div>

        <div class="fortune-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('message'))
                <div class="alert alert-info">{{ session('message') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if(!$fortuneLog)
                <div class="text-center">
                    <p class="mb-4">You haven't drawn today's fortune yet.</p>
                    <form action="{{ route('user.daily.fortune.draw') }}" method="POST">
                        @csrf
                        <button type="submit" class="draw-btn">
                            Draw today's recommendation
                        </button>
                    </form>
                </div>
            @else
                <div class="spot-card">
                    @if($fortuneLog->fortuneSpot->image)
                        <img
                            src="{{ asset('storage/' . $fortuneLog->fortuneSpot->image) }}"
                            alt="{{ $fortuneLog->fortuneSpot->name }}"
                            class="spot-image"
                        >
                    @endif

                    <div class="spot-name">
                        {{ $fortuneLog->fortuneSpot->name }}
                    </div>

                    @if($fortuneLog->fortuneSpot->location)
                        <div class="spot-meta">
                            {{ $fortuneLog->fortuneSpot->location }}
                        </div>
                    @endif

                    @if($fortuneLog->fortuneSpot->category)
                        <div class="spot-meta">
                            {{ $fortuneLog->fortuneSpot->category }}
                        </div>
                    @endif

                    @if($fortuneLog->fortuneSpot->description)
                        <div class="spot-description">
                            {{ $fortuneLog->fortuneSpot->description }}
                        </div>
                    @endif
                </div>

                <div class="mt-4 text-center text-muted">
                    You have already drawn today's fortune. Please look forward to tomorrow's result.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

