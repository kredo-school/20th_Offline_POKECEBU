<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>POKECEBU - Login / Register</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:wght@400;600;700&display=swap"
        rel="stylesheet">

    <style>
        :root {
            /* Secondary */
            --sec-1: #6FA9DE;
            --sec-2: #8DBCDA;
            --sec-3: #51C9D0;

            /* Accent */
            --acc-1: #96CCB9;
            --acc-2: #B7E1DA;
            --acc-3: #FDBF79;
            --acc-4: #FE9978;

            /* Neutral */
            --white: #FFFFFF;
            --cream: #FFFEEF;
            --sand: #FFF6EE;
            --border: #E9E3D3;

            --ink: #1f2c3a;
            --muted: #6b7a8a;
            --shadow: 0 18px 55px rgba(20, 40, 60, .10);
            --radius: 18px;
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

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Poppins", system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, sans-serif;
            color: var(--ink);
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 28px 16px;

            /* tropical background */
            background:
                radial-gradient(900px 500px at 15% 15%, rgba(253, 191, 121, .45), transparent 60%),
                radial-gradient(700px 420px at 90% 20%, rgba(81, 201, 208, .35), transparent 60%),
                radial-gradient(900px 520px at 60% 110%, rgba(150, 204, 185, .38), transparent 60%),
                linear-gradient(180deg, var(--cream) 0%, var(--sand) 55%, #ffffff 100%);
        }

        .waves {
            position: fixed;
            inset: auto 0 0 0;
            height: 180px;
            pointer-events: none;
            opacity: .55;
            background:
                radial-gradient(1200px 220px at 50% 0%, rgba(111, 169, 222, .25), transparent 65%),
                radial-gradient(1200px 220px at 35% 30%, rgba(81, 201, 208, .22), transparent 65%),
                radial-gradient(1200px 220px at 70% 55%, rgba(150, 204, 185, .20), transparent 65%);
            filter: blur(1px);
        }

        .wrap {
            width: min(980px, 100%);
            display: grid;
            grid-template-columns: 1.05fr .95fr;
            gap: 18px;
            align-items: stretch;
        }

        @media (max-width: 900px) {
            .wrap {
                grid-template-columns: 1fr;
            }
        }

        .hero {
            border-radius: var(--radius);
            padding: 28px;
            box-shadow: var(--shadow);
            background:
                linear-gradient(135deg, rgba(183, 225, 218, .55), rgba(111, 169, 222, .25)),
                linear-gradient(180deg, rgba(255, 255, 255, .85), rgba(255, 255, 255, .70));
            border: 1px solid rgba(233, 227, 211, .75);
            position: relative;
            overflow: hidden;
        }

        /* 右側：透かしヤシの葉（hero内の右寄せ） */
        .hero::after {
            content: "";
            position: absolute;
            right: -40px;
            top: 20px;
            width: 360px;
            height: 360px;
            opacity: .16;
            pointer-events: none;
            background-repeat: no-repeat;
            background-size: contain;
            transform: rotate(10deg);
            /* SVGをそのまま埋め込み（色は薄いグリーン系） */
            background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='512' height='512' viewBox='0 0 512 512'><path fill='%2396CCB9' d='M468 92c-72 6-129 31-173 75-13 13-24 27-33 42 10-55 9-112-4-171-3-13-22-12-24 1-12 63-12 124 2 183-13-18-28-34-45-49C138 126 83 99 16 92c-14-2-18 18-4 23 58 20 104 50 139 90 27 31 45 68 54 112-26-26-58-47-95-62-10-4-18 9-9 16 45 36 76 82 92 139 8 27 12 56 12 87 0 14 22 14 22 0 0-32-4-62-12-91 32-33 70-58 114-74 30-11 62-18 95-22 14-2 14-23 0-24-63-5-121 3-174 25-18 7-35 16-51 27 6-37 16-70 32-99 33-60 90-98 172-114 14-3 10-24-4-23z'/></svg>");
            filter: blur(.2px);
        }

        .badge {
            display: inline-flex;
            gap: 10px;
            align-items: center;
            padding: 10px 12px;
            background: rgba(255, 255, 255, .72);
            border: 1px solid rgba(233, 227, 211, .9);
            border-radius: 999px;
            backdrop-filter: blur(8px);
        }

        .dot {
            width: 10px;
            height: 10px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--acc-3), var(--acc-4));
            box-shadow: 0 0 0 4px rgba(253, 191, 121, .25);
        }

        .hero h1 {
            margin: 18px 0 6px;
            font-family: "Pacifico", cursive;
            font-size: clamp(34px, 4.2vw, 50px);
            letter-spacing: .2px;
            color: #0f2233;
        }

        .hero p {
            margin: 0 0 12px;
            color: var(--muted);
            line-height: 1.6;
            max-width: 46ch;
        }

        .chips {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 16px;
        }

        .chip {
            font-size: 13px;
            padding: 8px 10px;
            border-radius: 999px;
            border: 1px solid rgba(233, 227, 211, .9);
            background: rgba(255, 255, 255, .70);
        }

        .chip strong {
            font-weight: 700;
        }

        .card {
            border-radius: var(--radius);
            padding: 26px;
            box-shadow: var(--shadow);
            background: rgba(255, 255, 255, .85);
            border: 1px solid rgba(233, 227, 211, .85);
            backdrop-filter: blur(10px);
            overflow: hidden;
            position: relative;
        }

        .cardHead {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 14px;
        }

        .card h2 {
            margin: 0;
            font-size: 18px;
            font-weight: 800;
        }

        .card .sub {
            margin: 2px 0 0;
            color: var(--muted);
            font-size: 13px;
        }

        .tabs {
            display: flex;
            gap: 8px;
            background: rgba(255, 255, 255, .65);
            border: 1px solid rgba(233, 227, 211, .85);
            border-radius: 999px;
            padding: 6px;
        }

        .tab {
            border: 0;
            background: transparent;
            padding: 8px 12px;
            border-radius: 999px;
            cursor: pointer;
            font-weight: 800;
            font-size: 13px;
            color: #0f2233;
            opacity: .65;
            transition: .15s ease;
        }

        .tab.is-active {
            opacity: 1;
            background: linear-gradient(135deg, rgba(111, 169, 222, .35), rgba(81, 201, 208, .22));
            box-shadow: 0 10px 18px rgba(111, 169, 222, .18);
        }

        .slider {
            width: 100%;
            overflow: hidden;
        }

        .sliderTrack {
            display: flex;
            width: 200%;
            transition: transform .45s cubic-bezier(.2, .9, .2, 1);
        }

        .panel {
            width: 50%;
            padding-top: 6px;
        }

        .field {
            margin-bottom: 12px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .req {
            color: #e24b4b;
        }

        .input {
            width: 100%;
            padding: 12px 12px;
            border-radius: 12px;
            border: 1px solid rgba(233, 227, 211, .95);
            background: rgba(255, 255, 255, .9);
            outline: none;
            transition: .15s ease;
            font-size: 14px;
        }

        .input:focus {
            border-color: rgba(81, 201, 208, .75);
            box-shadow: 0 0 0 4px rgba(81, 201, 208, .18);
        }

        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        @media (max-width: 520px) {
            .row {
                grid-template-columns: 1fr;
            }
        }

        .btn {
            width: 100%;
            border: 0;
            border-radius: 14px;
            padding: 12px 14px;
            font-weight: 900;
            cursor: pointer;
            transition: transform .05s ease, filter .15s ease;
        }

        .btn:active {
            transform: translateY(1px);
        }

        .btn-primary {
            color: #0b2233;
            background: linear-gradient(135deg, var(--sec-1), var(--sec-3));
            box-shadow: 0 10px 20px rgba(111, 169, 222, .25);
        }

        .btn-primary:hover {
            filter: brightness(1.02);
        }

        .btn-soft {
            color: #0b2233;
            background: linear-gradient(135deg, rgba(253, 191, 121, .75), rgba(255, 238, 239, .55));
            border: 1px solid rgba(233, 227, 211, .85);
            margin-top: 10px;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 14px 0;
            color: var(--muted);
            font-size: 12px;
        }

        .divider:before,
        .divider:after {
            content: "";
            height: 1px;
            flex: 1;
            background: rgba(233, 227, 211, .95);
        }

        .btn-google {
            display: flex;
            gap: 10px;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, .9);
            border: 1px solid rgba(233, 227, 211, .95);
        }

        .googleG {
            width: 18px;
            height: 18px;
            border-radius: 6px;
            display: grid;
            place-items: center;
            background: linear-gradient(135deg, var(--acc-1), var(--acc-2));
            font-weight: 900;
            color: #0b2233;
            font-size: 12px;
        }

        .linkRow {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-top: 8px;
            font-size: 13px;
            color: var(--muted);
        }

        .linkRow a {
            color: #0b5bd3;
            text-decoration: none;
            font-weight: 800;
        }

        .linkRow a:hover {
            text-decoration: underline;
        }

        .error {
            margin-top: 6px;
            font-size: 12px;
            color: #e24b4b;
            font-weight: 700;
        }
    </style>
</head>

<body>
    <div class="wrap">
        <!-- Left: Tropical info panel -->
        <section class="hero">
            <div class="badge">
                <span class="dot"></span>
                <span style="font-size:13px; font-weight:900;">POKECEBU</span>
                <span style="font-size:12px; color:var(--muted); font-weight:700;">Cebu Travel Guide</span>
            </div>

            <h1>Welcome back</h1>
            <p>
                ログインして、ホテル・レストランの予約、ジップニーガイド、クーポンなどをまとめて管理しよう。
            </p>

            <div class="chips">
                <span class="chip"><strong style="color:var(--sec-3);">✔</strong> Easy booking</span>
                <span class="chip"><strong style="color:var(--acc-1);">✔</strong> Local tips</span>
                <span class="chip"><strong style="color:var(--acc-4);">✔</strong> Coupons</span>
            </div>
        </section>

        <!-- Right: Auth card (Login + Register) -->
        <section class="card">
            <div class="cardHead">
                <div>
                    <h2 id="cardTitle">Login</h2>
                    <p class="sub" id="cardSub">Enter your email and password to continue.</p>
                </div>

                <div class="tabs" aria-label="auth tabs">
                    <button class="tab is-active" type="button" id="tabLogin">Login</button>
                    <button class="tab" type="button" id="tabRegister">Register</button>
                </div>
            </div>

            <div class="slider" id="slider">
                <div class="sliderTrack" id="track">
                    <!-- ===== Login Panel ===== -->
                    <div class="panel" id="loginPanel">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="field">
                                <label>Email <span class="req">*</span></label>
                                <input class="input" type="email" name="email" value="{{ old('email') }}"
                                    placeholder="Enter your email" autocomplete="username" required autofocus>
                                @error('email')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="field">
                                <label>Password <span class="req">*</span></label>
                                <input class="input" type="password" name="password" placeholder="Password"
                                    autocomplete="current-password" required>
                                @error('password')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>

                            <button class="btn btn-primary" type="submit">Login</button>

                            <div class="linkRow">
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}">Forgot password?</a>
                                @else
                                    <span></span>
                                @endif
                                <a href="javascript:void(0)" class="js-to-register">Create account</a>
                            </div>
                        </form>
                    </div>

                    <!-- ===== Register Panel ===== -->
                    <div class="panel" id="registerPanel">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="field">
                                <label>Name <span class="req">*</span></label>
                                <input class="input" type="text" name="name" value="{{ old('name') }}"
                                    placeholder="Enter your name" autocomplete="name" required>
                                @error('name')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="field">
                                <label>Email <span class="req">*</span></label>
                                <input class="input" type="email" name="email" value="{{ old('email') }}"
                                    placeholder="Enter your email" autocomplete="email" required>
                                @error('email')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="field">
                                    <label>Password <span class="req">*</span></label>
                                    <input class="input" type="password" name="password" placeholder="Password"
                                        autocomplete="new-password" required>
                                    @error('password')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="field">
                                    <label>Confirm <span class="req">*</span></label>
                                    <input class="input" type="password" name="password_confirmation"
                                        placeholder="Confirm" autocomplete="new-password" required>
                                </div>
                            </div>

                            <button class="btn btn-primary" type="submit">Get started</button>
                            <button class="btn btn-soft" type="button" onclick="location.href='#'">For
                                Companies</button>

                            <div class="divider">or</div>

                            <button class="btn btn-google" type="button">
                                <span class="googleG">G</span>
                                Sign up with Google
                            </button>

                            <div class="linkRow" style="justify-content:center; margin-top:10px;">
                                <a href="javascript:void(0)" class="js-to-login">Already have an account? Log in</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </section>
    </div>

    <div class="waves"></div>

    <script>
        (function() {
            const track = document.getElementById('track');
            const tabLogin = document.getElementById('tabLogin');
            const tabRegister = document.getElementById('tabRegister');
            const title = document.getElementById('cardTitle');
            const sub = document.getElementById('cardSub');

            function setMode(mode, smooth = true) {
                const x = (mode === 'register') ? -50 : 0; // track is 200%, each panel is 50%
                track.style.transition = smooth ? 'transform .45s cubic-bezier(.2,.9,.2,1)' : 'none';
                track.style.transform = 'translateX(' + x + '%)';

                if (mode === 'register') {
                    tabRegister.classList.add('is-active');
                    tabLogin.classList.remove('is-active');
                    title.textContent = 'Register';
                    sub.textContent = 'Create your account in a minute.';
                } else {
                    tabLogin.classList.add('is-active');
                    tabRegister.classList.remove('is-active');
                    title.textContent = 'Login';
                    sub.textContent = 'Enter your email and password to continue.';
                }
            }

            tabLogin.addEventListener('click', () => setMode('login'));
            tabRegister.addEventListener('click', () => setMode('register'));

            document.querySelectorAll('.js-to-login').forEach(el => el.addEventListener('click', () => setMode(
                'login')));
            document.querySelectorAll('.js-to-register').forEach(el => el.addEventListener('click', () => setMode(
                'register')));

            // /register で開いたら register 側を最初から表示
            const path = window.location.pathname || '';
            const params = new URLSearchParams(window.location.search);
            const initial = (path.includes('/register') || params.get('mode') === 'register') ? 'register' : 'login';
            setMode(initial, false);
        })();
    </script>
</body>

</html>