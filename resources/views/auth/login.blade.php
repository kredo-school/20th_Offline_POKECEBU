@extends('layouts.app')

@section('title', 'Auth')

@section('content')
<div class="ig-auth-screen">
    <div class="ig-auth-wrap">

        <div class="ig-lang">English</div>

        <div class="ig-logo" aria-label="App logo">
            <i class="fa-brands fa-instagram ig-logo-icon"></i>
        </div>

        <div class="auth-container" id="authContainer">
            <div class="auth-box" id="authBox">
                {{-- ======================
                Login
                ====================== --}}
                <div class="form login" id="loginSection">
                    <form method="POST" action="{{ route('login') }}" class="ig-form">
                        @csrf

                        <div class="ig-field">
                            <input id="login-email" type="email" name="email" value="{{ old('email') }}"
                                placeholder="Username, email or your phone number" autocomplete="username" required autofocus
                                class="@error('email') is-invalid @enderror">
                            @error('email')
                                <div class="ig-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="ig-field">
                            <input id="login-password" type="password" name="password" placeholder="Password"
                                autocomplete="current-password" required
                                class="@error('password') is-invalid @enderror">
                            @error('password')
                                <div class="ig-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="ig-btn">Login</button>

                        <a class="ig-link" href="{{ route('password.request') }}">
                            If you forgot your password
                        </a>

                        <div class="ig-switch">
                            Don't have an account?
                            <a href="javascript:void(0)" class="js-to-register">Register</a>
                        </div>
                    </form>
                </div>

                {{-- ======================
                Register
                ====================== --}}
                <div class="form register" id="registerSection">
                    <form method="POST" action="{{ route('register') }}" class="ig-form">
                        @csrf

                        <div class="ig-field">
                            <input id="name" type="text" name="name" value="{{ old('name') }}"
                                placeholder="Name" autocomplete="name" required
                                class="@error('name') is-invalid @enderror">
                            @error('name')
                                <div class="ig-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="ig-field">
                            <input id="register-email" type="email" name="email" value="{{ old('email') }}"
                                placeholder="Mail Address" autocomplete="email" required
                                class="@error('email') is-invalid @enderror">
                            @error('email')
                                <div class="ig-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="ig-field">
                            <input id="register-password" type="password" name="password" placeholder="Password"
                                autocomplete="new-password" required
                                class="@error('password') is-invalid @enderror">
                            @error('password')
                                <div class="ig-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="ig-field">
                            <input id="password-confirm" type="password" name="password_confirmation"
                                placeholder="Confirm Password" autocomplete="new-password" required>
                        </div>

                        <button type="submit" class="ig-btn">Get started</button>

                        <div class="ig-switch">
                            Already have an account?
                            <a href="javascript:void(0)" class="js-to-login">Login</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        <div class="ig-bottom">
            <a class="ig-btn-outline js-to-register" href="javascript:void(0)">
                Create a New Account
            </a>
            <div class="ig-meta">∞ Meta</div>
        </div>

    </div>
</div>
@endsection



<style>
    /* ====== 全体 ====== */
    .ig-auth-screen {
        min-height: calc(100vh - 0px);
        background: #0f1720;
        color: #e6edf3;
        display: flex;
        justify-content: center;
        padding: 18px 0 28px;
    }

    .ig-auth-wrap {
        width: min(420px, 92vw);
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .ig-lang {
        margin-top: 6px;
        font-size: 14px;
        color: #9aa7b4;
    }

    .ig-logo {
        margin: 44px 0 26px;
        display: flex;
        justify-content: center;
    }

    .ig-logo-icon {
        font-size: 68px;
        line-height: 1;
        display: inline-block;
        background: radial-gradient(circle at 30% 30%, #ffdc80, transparent 45%),
            radial-gradient(circle at 70% 30%, #fcaf45, transparent 40%),
            radial-gradient(circle at 30% 70%, #f77737, transparent 40%),
            radial-gradient(circle at 70% 70%, #833ab4, transparent 45%),
            linear-gradient(135deg, #f56040, #833ab4);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        -webkit-text-fill-color: transparent;
        filter: drop-shadow(0 10px 30px rgba(0, 0, 0, .35));
    }

    /* ====== スクロール枠（ここがキモ） ====== */
    .auth-container {
        width: min(360px, 92vw);
        overflow-x: auto;
        overflow-y: hidden;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none; /* Firefox */
    }
    .auth-container::-webkit-scrollbar { display: none; } /* Chrome */

    .auth-box {
        display: flex;
        width: 200%;
    }

    .form {
        width: 100%;
        padding: 0;
        box-sizing: border-box;
        scroll-snap-align: start;
        scroll-snap-stop: always;
    }

    /* ====== フォーム ====== */
    .ig-form {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .ig-field input {
        width: 100%;
        height: 52px;
        padding: 0 14px;
        border-radius: 12px;
        border: 1px solid #2a3a47;
        background: #121d28;
        color: #e6edf3;
        outline: none;
        font-size: 15px;
    }

    .ig-field input::placeholder { color: #7f8c97; }

    .ig-field input:focus {
        border-color: rgba(29, 155, 240, .75);
        box-shadow: 0 0 0 4px rgba(29, 155, 240, .12);
    }

    .ig-btn {
        margin-top: 4px;
        height: 52px;
        border: 0;
        border-radius: 26px;
        background: #1d9bf0;
        color: #fff;
        font-weight: 700;
        font-size: 16px;
        cursor: pointer;
    }
    .ig-btn:active { background: #1384cf; }

    .ig-link {
        text-align: center;
        text-decoration: none;
        font-size: 14px;
        color: #c7d2db;
        opacity: .9;
    }

    .ig-switch {
        text-align: center;
        font-size: 14px;
        color: #9aa7b4;
    }

    .ig-switch a {
        color: rgba(29, 155, 240, .95);
        font-weight: 700;
        text-decoration: none;
    }
    .ig-switch a:hover { text-decoration: underline; }

    .ig-error {
        margin-top: 6px;
        font-size: 13px;
        color: #ff8a8a;
    }

    .is-invalid { border-color: rgba(255, 138, 138, .65) !important; }

    /* ====== 下部 ====== */
    .ig-bottom {
        margin-top: 34px;
        width: min(360px, 92vw);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 16px;
    }

    .ig-btn-outline {
        width: 100%;
        height: 52px;
        border-radius: 26px;
        border: 1px solid rgba(29, 155, 240, .7);
        color: rgba(29, 155, 240, .95);
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-weight: 700;
    }
    .ig-btn-outline:active { background: rgba(29, 155, 240, .08); }

    .ig-meta {
        color: #7f8c97;
        font-weight: 600;
        letter-spacing: .2px;
    }

    /* Chromeの自動入力(autofill)で背景が白くなるのを防ぐ */
    .ig-field input:-webkit-autofill,
    .ig-field input:-webkit-autofill:hover,
    .ig-field input:-webkit-autofill:focus,
    .ig-field input:-webkit-autofill:active {
        -webkit-text-fill-color: #e6edf3 !important;
        caret-color: #e6edf3;
        -webkit-box-shadow: 0 0 0 1000px #121d28 inset !important;
        box-shadow: 0 0 0 1000px #121d28 inset !important;
        border: 1px solid #2a3a47 !important;
        transition: background-color 9999s ease-in-out 0s;
    }
</style>
<script>
    // 横スクロールで login / register を切り替える
    document.addEventListener('DOMContentLoaded', () => {
        const container = document.getElementById('authContainer');

        const scrollToLogin = () => {
            container.scrollTo({ left: 0, behavior: 'smooth' });
        };

        const scrollToRegister = () => {
            container.scrollTo({ left: container.clientWidth, behavior: 'smooth' });
        };

        document.querySelectorAll('.js-to-login').forEach(el => el.addEventListener('click', scrollToLogin));
        document.querySelectorAll('.js-to-register').forEach(el => el.addEventListener('click', scrollToRegister));

        // navbar から ?mode=register で来たら register 側を開く
        const params = new URLSearchParams(window.location.search);
        if (params.get('mode') === 'register') {
            // 画面幅確定後に移動
            requestAnimationFrame(() => scrollToRegister());
        }
    });
</script>

