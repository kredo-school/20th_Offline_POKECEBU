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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <style>
        :root {
            --sec-1: #6FA9DE;
            --sec-2: #8DBCDA;
            --sec-3: #51C9D0;
            --acc-1: #96CCB9;
            --acc-2: #B7E1DA;
            --acc-3: #FDBF79;
            --acc-4: #FE9978;
            --white: #FFFFFF;
            --cream: #FFFEEF;
            --sand: #FFF6EE;
            --border: #E9E3D3;
            --ink: #1f2c3a;
            --muted: #6b7a8a;
            --shadow: 0 18px 55px rgba(20, 40, 60, .10);
            --radius: 18px;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            /* font-family: "Poppins", system-ui, sans-serif; */
            color: var(--ink);
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 28px 16px;
            background:
                radial-gradient(900px 500px at 15% 15%, rgba(253, 191, 121, .45), transparent 60%),
                radial-gradient(700px 420px at 90% 20%, rgba(81, 201, 208, .35), transparent 60%),
                radial-gradient(900px 520px at 60% 110%, rgba(150, 204, 185, .38), transparent 60%),
                linear-gradient(180deg, var(--cream) 0%, var(--sand) 55%, #ffffff 100%);
        }

        /* ── Card ────────────────────────────────────────────── */
        .card {
            position: relative;
            width: min(900px, 100%);
            min-height: 520px;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            background: rgba(255, 255, 255, .92);
            border: 1px solid rgba(233, 227, 211, .85);
            backdrop-filter: blur(10px);
            display: flex;
            overflow: hidden;
        }

        /* ── Two form panels side by side inside card ─────────── */
        .formsWrap {
            display: flex;
            width: 100%;
        }

        .formPanel {
            width: 50%;
            flex-shrink: 0;
            padding: 32px 36px;
            display: flex;
            flex-direction: column;
        }

        .cardHead {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 18px;
        }

        .cardHead h2 {
            margin: 0;
            font-size: 20px;
            font-weight: 800;
        }

        .cardHead .sub {
            margin: 3px 0 0;
            color: var(--muted);
            font-size: 13px;
        }

        /* ── Tabs ─────────────────────────────────────────────── */
        .tabs {
            display: flex;
            gap: 6px;
            background: rgba(255, 255, 255, .65);
            border: 1px solid rgba(233, 227, 211, .85);
            border-radius: 999px;
            padding: 5px;
            flex-shrink: 0;
        }

        .tab {
            border: 0;
            background: transparent;
            padding: 7px 14px;
            border-radius: 999px;
            cursor: pointer;
            font-weight: 800;
            font-size: 13px;
            color: var(--ink);
            opacity: .55;
            transition: .15s ease;
            /* font-family: "Poppins", sans-serif; */
        }

        .tab.is-active {
            opacity: 1;
            background: linear-gradient(135deg, rgba(111, 169, 222, .35), rgba(81, 201, 208, .22));
            box-shadow: 0 6px 14px rgba(111, 169, 222, .18);
        }

        /* ── Form fields ──────────────────────────────────────── */
        .field { margin-bottom: 12px; }

        label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .req { color: #e24b4b; }

        .input {
            width: 100%;
            padding: 11px 13px;
            border-radius: 12px;
            border: 1px solid rgba(233, 227, 211, .95);
            background: rgba(255, 255, 255, .9);
            outline: none;
            transition: .15s ease;
            font-size: 14px;
            /* font-family: "Poppins", sans-serif; */
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

        /* ── Buttons ──────────────────────────────────────────── */
        .btn {
            width: 100%;
            border: 0;
            border-radius: 13px;
            padding: 12px 14px;
            font-weight: 600;
            font-size: 14px;
            /* font-family: "Poppins", sans-serif; */
            cursor: pointer;
            transition: transform .05s ease, filter .15s ease;
        }

        .btn:active { transform: translateY(1px); }

        .btn-primary {
            color: #0b2233;
            background: linear-gradient(135deg, var(--sec-1), var(--sec-3));
            box-shadow: 0 10px 20px rgba(111, 169, 222, .25);
            margin-top: 20px;
        }

        .btn-primary:hover { filter: brightness(1.03); }

        .btn-soft {
            color: #0b2233;
            background: linear-gradient(135deg, rgba(253, 191, 121, .75), rgba(255, 238, 239, .55));
            border: 1px solid rgba(233, 227, 211, .85);
            margin-bottom: 12px;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 12px 0;
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

        .linkRow {
            display: flex;
            justify-content: center;
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

        .linkRow a:hover { text-decoration: underline; }

        .error {
            margin-top: 5px;
            font-size: 12px;
            color: #e24b4b;
            font-weight: 700;
        }

        /* ── Overlay: slides over the forms ──────────────────── */
        /*
         * Login mode  → overlay is on the RIGHT (covers register form)
         * Register mode → overlay slides to the LEFT (covers login form)
         */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;                /* anchor to left edge */
            width: 50%;
            height: 100%;
            background: linear-gradient(135deg, var(--sec-1), var(--sec-3));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            border-radius: var(--radius) 0 0 var(--radius);
            /* Default (login): sit on the right half */
            transform: translateX(100%);
            transition: transform .55s cubic-bezier(.4, 0, .2, 1);
            z-index: 10;
        }

        /* Register mode: overlay moves to left half */
        .card.show-register .overlay {
            transform: translateX(0%);
            border-radius: 0 var(--radius) var(--radius) 0;
        }

        /* "Hello there!" panel — shown in login mode (overlay on right) */
        .overlay-right {
            opacity: 1;
            pointer-events: auto;
            transform: translateX(0);
        }

        .card.show-register .overlay-right {
            opacity: 0;
            pointer-events: none;
            transform: translateX(20px);
        }

        /* "Welcome Back!" panel — shown in register mode (overlay on left) */
        .overlay-left {
            opacity: 0;
            pointer-events: none;
            transform: translateX(-20px);
        }

        .card.show-register .overlay-left {
            opacity: 1;
            pointer-events: auto;
            transform: translateX(0);
        }

        .overlay-btn {
            padding: 10px 28px;
            border-radius: 999px;
            border: 2px solid white;
            background: transparent;
            color: white;
            font-weight: 800;
            font-size: 14px;
            /* font-family: "Poppins", sans-serif; */
            cursor: pointer;
            transition: background .15s ease;
        }

        .overlay-btn:hover {
            background: rgba(255, 255, 255, .15);
        }

        /* ── Overlay brand images ─────────────────────────────── */
        .overlay-panel {
            position: absolute;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-end;
            padding: 32px;
            transition: opacity .25s ease, transform .25s ease;
        }

        .overlay-brand {
            position: absolute;
            inset: 0;
            display: flex;
            justify-content: center;
        }

        .overlay-icon {
            width: 100%;
            height: 50%;
            object-fit: cover;
            object-position: 70%;
            opacity: .85;
        }

        .overlay-text {
            position: relative;
            z-index: 2;
            text-align: center;
            padding-bottom: 150px;
        }

        .overlay-text h2 {
            margin: 0 0 8px;
            font-size: 22px;
            font-weight: 800;
        }

        .overlay-text p {
            margin: 0 0 18px;
            opacity: .9;
            font-size: 14px;
        }

        /* ── Responsive ───────────────────────────────────────── */
        @media (max-width: 640px) {
            .formsWrap { flex-direction: column; }
            .formPanel { width: 100%; padding: 24px 20px; }
            .overlay { display: none; }
            .row { grid-template-columns: 1fr; }
        }
    </style>
</head>

<body>

    <section class="card" id="authCard">
        <!-- Overlay (slides over forms) -->
        <div class="overlay" id="overlay">
            <!-- Login mode: overlay on RIGHT, shows "Hello there!" -->
            <div class="overlay-panel overlay-right">
                <div class="overlay-brand">
                    <img src="{{ asset('images/Icon.png') }}" alt="POKECEBU icon" class="overlay-icon">
                </div>
                <div class="overlay-text">
                    <h2>Hello there!</h2>
                    <p>Don't have an account yet?<br>Join POKECEBU today.</p>
                    <button class="overlay-btn" id="overlayRegister">Sign Up</button>
                </div>
            </div>
            <!-- Register mode: overlay on LEFT, shows "Welcome Back!" -->
            <div class="overlay-panel overlay-left">
                <div class="overlay-brand">
                    <img src="{{ asset('images/Icon.png') }}" alt="POKECEBU icon" class="overlay-icon">
                </div>
                <div class="overlay-text">
                    <h2>Welcome Back!</h2>
                    <p>Already have an account?<br>Sign in and continue.</p>
                    <button class="overlay-btn" id="overlayLogin">Sign In</button>
                </div>
            </div>
        </div>

        <!-- Both form panels sit side by side -->
        <div class="formsWrap">

            <!-- LEFT: Login form -->
            <div class="formPanel" id="loginPanel">
                <div class="cardHead">
                    <div>
                        <h2>Login</h2>
                        <p class="sub">Enter your email and password to continue.</p>
                    </div>
                </div>

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
                    </div>
                </form>
            </div>

            <!-- RIGHT: Register form -->
            <div class="formPanel" id="registerPanel">
                <div class="cardHead">
                    <div>
                        <h2>Register</h2>
                        <p class="sub">Create your account in a minute.</p>
                    </div>
                </div>
                <button class="btn btn-soft" type="button"
                    onclick="location.href='{{ route('company.signup') }}'">Register For Companies
                    <i class="fa-solid fa-angles-right"></i>
                </button>
                <div style="height: 2px; background: #E9E3D3; margin: 8px 0 16px;"></div>
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
                </form>
            </div>
        </div><!-- /formsWrap -->
    </section>

    <script>
        (function () {
            const card     = document.getElementById('authCard');
            const tabLogin  = document.getElementById('tabLogin');
            const tabReg    = document.getElementById('tabRegister');
            const tabLogin2 = document.getElementById('tabLogin2');
            const tabReg2   = document.getElementById('tabRegister2');

            function setMode(mode) {
                if (mode === 'register') {
                    card.classList.add('show-register');
                    tabReg.classList.add('is-active');   tabLogin.classList.remove('is-active');
                    tabReg2.classList.add('is-active');  tabLogin2.classList.remove('is-active');
                } else {
                    card.classList.remove('show-register');
                    tabLogin.classList.add('is-active');  tabReg.classList.remove('is-active');
                    tabLogin2.classList.add('is-active'); tabReg2.classList.remove('is-active');
                }
            }

            document.getElementById('overlayLogin').addEventListener('click',    () => setMode('login'));
            document.getElementById('overlayRegister').addEventListener('click', () => setMode('register'));
            tabLogin.addEventListener('click',  () => setMode('login'));
            tabReg.addEventListener('click',    () => setMode('register'));
            tabLogin2.addEventListener('click', () => setMode('login'));
            tabReg2.addEventListener('click',   () => setMode('register'));
            document.querySelectorAll('.js-to-login').forEach(el =>
                el.addEventListener('click', () => setMode('login')));
            document.querySelectorAll('.js-to-register').forEach(el =>
                el.addEventListener('click', () => setMode('register')));

            // Initial mode from URL
            const path   = window.location.pathname || '';
            const params = new URLSearchParams(window.location.search);
            const initial = (path.includes('/register') || params.get('mode') === 'register')
                ? 'register' : 'login';
            setMode(initial);
        })();
    </script>

</body>
</html>