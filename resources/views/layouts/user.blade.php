@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/user.css/user.css') }}">
<link rel="stylesheet" href="{{ asset('css/user.css/signup-for-company.css') }}">
<link rel="stylesheet" href="{{ asset('css/user.css/detail-hotel.css') }}">
<link rel="stylesheet" href="{{ asset('css/user.css/detail-restaurant.css') }}">
<link rel="stylesheet" href="{{ asset('css/user.css/hotel-serch-result.css') }}">
<style>
    #mainNavbar {
        background: rgba(255, 255, 255, 0.94);
    }
    #mainNavbar.scrolled {
        background: rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        box-shadow: 0 1px 20px rgba(0, 0, 0, 0.08);
    }
    /* ナビバー分のスペースを確保 */
    body {
        padding-top: 80px;
    }
    /* nav-item ホバーエフェクト */
    #mainNavbar .nav-link {
        transition: transform 0.2s, color 0.2s;
        display: inline-block;
    }
    
    #mainNavbar .nav-link:hover {
        transform: scale(1.2);
        color: #fbc70d !important; /* 好みの色に変更 */
    }
</style>
@endpush

@push('scripts')
<script>
    const nav = document.getElementById('mainNavbar');
    window.addEventListener('scroll', () => {
        nav.classList.toggle('scrolled', window.scrollY > 20);
    }, { passive: true });
</script>
@endpush

@section('navbar')
<nav class="navbar navbar-expand-md navbar-fixed"
     id="mainNavbar"
     style="height:80px; position: fixed; top: 0; left: 0; right: 0; z-index: 1030; transition: background 0.3s, backdrop-filter 0.3s, box-shadow 0.3s;">
    @include('layouts.partials.nav-user')
</nav>
@endsection

@section('footer')
    @include('layouts.partials.footer-user')
@endsection