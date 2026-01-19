@extends('layouts.app')

@section('content')
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>POKECEBU - Create an account</title>

  <!-- Fonts (optional) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    :root{
      /* Secondary */
      --sec-1:#6FA9DE;
      --sec-2:#8DBCDA;
      --sec-3:#51C9D0;

      /* Accent */
      --acc-1:#96CCB9;
      --acc-2:#B7E1DA;
      --acc-3:#FDBF79;
      --acc-4:#FE9978;

      /* Neutral */
      --white:#FFFFFF;
      --cream:#FFFEEF;
      --sand:#FFF6EE;
      --border:#E9E3D3;

      --ink:#1f2c3a;
      --muted:#6b7a8a;
      --shadow: 0 18px 55px rgba(20, 40, 60, .10);
      --radius: 18px;
    }

    *{ box-sizing:border-box; }
    body{
      margin:0;
      font-family: "Poppins", system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, sans-serif;
      color:var(--ink);
      min-height:100vh;
      display:grid;
      place-items:center;
      padding:28px 16px;

      /* tropical background */
      background:
        radial-gradient(900px 500px at 15% 15%, rgba(253,191,121,.45), transparent 60%),
        radial-gradient(700px 420px at 90% 20%, rgba(81,201,208,.35), transparent 60%),
        radial-gradient(900px 520px at 60% 110%, rgba(150,204,185,.38), transparent 60%),
        linear-gradient(180deg, var(--cream) 0%, var(--sand) 55%, #ffffff 100%);
    }

    /* soft “wave” decoration */
    .waves{
      position:fixed; inset:auto 0 0 0;
      height:180px;
      pointer-events:none;
      opacity:.55;
      background:
        radial-gradient(1200px 220px at 50% 0%, rgba(111,169,222,.25), transparent 65%),
        radial-gradient(1200px 220px at 35% 30%, rgba(81,201,208,.22), transparent 65%),
        radial-gradient(1200px 220px at 70% 55%, rgba(150,204,185,.20), transparent 65%);
      filter: blur(1px);
    }

    .wrap{
      width: min(980px, 100%);
      display:grid;
      grid-template-columns: 1.05fr .95fr;
      gap: 18px;
      align-items:stretch;
    }

    @media (max-width: 900px){
      .wrap{ grid-template-columns: 1fr; }
    }

    .hero{
      border-radius: var(--radius);
      padding: 28px;
      box-shadow: var(--shadow);
      background:
        linear-gradient(135deg, rgba(183,225,218,.55), rgba(111,169,222,.25)),
        linear-gradient(180deg, rgba(255,255,255,.85), rgba(255,255,255,.70));
      border: 1px solid rgba(233,227,211,.75);
      position:relative;
      overflow:hidden;
    }

    .badge{
      display:inline-flex;
      gap:10px;
      align-items:center;
      padding:10px 12px;
      background: rgba(255,255,255,.72);
      border: 1px solid rgba(233,227,211,.9);
      border-radius: 999px;
      backdrop-filter: blur(8px);
    }

    .dot{
      width:10px;height:10px;border-radius:999px;
      background: linear-gradient(135deg, var(--acc-3), var(--acc-4));
      box-shadow: 0 0 0 4px rgba(253,191,121,.25);
    }

    .hero h1{
      margin: 18px 0 6px;
      font-family: "Pacifico", cursive;
      font-size: clamp(34px, 4.2vw, 50px);
      letter-spacing:.2px;
      color: #0f2233;
    }
    .hero p{
      margin: 0 0 12px;
      color: var(--muted);
      line-height:1.6;
      max-width: 46ch;
    }

    .chips{
      display:flex; flex-wrap:wrap; gap:10px;
      margin-top: 16px;
    }
    .chip{
      font-size: 13px;
      padding: 8px 10px;
      border-radius: 999px;
      border: 1px solid rgba(233,227,211,.9);
      background: rgba(255,255,255,.70);
    }
    .chip strong{ font-weight:700; }

    .card{
      border-radius: var(--radius);
      padding: 26px;
      box-shadow: var(--shadow);
      background: rgba(255,255,255,.85);
      border: 1px solid rgba(233,227,211,.85);
      backdrop-filter: blur(10px);
    }

    .card h2{
      margin: 0 0 6px;
      font-size: 18px;
      font-weight: 700;
    }
    .card .sub{
      margin: 0 0 18px;
      color: var(--muted);
      font-size: 13px;
    }

    .field{ margin-bottom: 12px; }
    label{
      display:block;
      font-size: 13px;
      font-weight: 600;
      margin-bottom: 6px;
    }
    .req{ color: #e24b4b; }

    .input{
      width:100%;
      padding: 12px 12px;
      border-radius: 12px;
      border: 1px solid rgba(233,227,211,.95);
      background: rgba(255,255,255,.9);
      outline:none;
      transition: .15s ease;
      font-size: 14px;
    }
    .input:focus{
      border-color: rgba(81,201,208,.75);
      box-shadow: 0 0 0 4px rgba(81,201,208,.18);
    }

    .row{
      display:grid;
      grid-template-columns: 1fr 1fr;
      gap: 10px;
    }
    @media (max-width: 520px){
      .row{ grid-template-columns:1fr; }
    }

    .btn{
      width:100%;
      border:0;
      border-radius: 14px;
      padding: 12px 14px;
      font-weight: 700;
      cursor:pointer;
      transition: transform .05s ease, filter .15s ease;
    }
    .btn:active{ transform: translateY(1px); }

    .btn-primary{
      color:#0b2233;
      background: linear-gradient(135deg, var(--sec-1), var(--sec-3));
      box-shadow: 0 10px 20px rgba(111,169,222,.25);
    }
    .btn-primary:hover{ filter: brightness(1.02); }

    .btn-soft{
      color:#0b2233;
      background: linear-gradient(135deg, rgba(253,191,121,.75), rgba(255,238,239,.55));
      border: 1px solid rgba(233,227,211,.85);
      margin-top: 10px;
    }

    .divider{
      display:flex;
      align-items:center;
      gap:10px;
      margin: 14px 0;
      color: var(--muted);
      font-size: 12px;
    }
    .divider:before, .divider:after{
      content:"";
      height:1px;
      flex:1;
      background: rgba(233,227,211,.95);
    }

    .btn-google{
      display:flex;
      gap:10px;
      align-items:center;
      justify-content:center;
      background: rgba(255,255,255,.9);
      border: 1px solid rgba(233,227,211,.95);
    }

    .googleG{
      width: 18px; height: 18px;
      border-radius: 6px;
      display:grid; place-items:center;
      background: linear-gradient(135deg, var(--acc-1), var(--acc-2));
      font-weight:800;
      color:#0b2233;
      font-size: 12px;
    }

    .footer{
      margin-top: 14px;
      text-align:center;
      font-size: 13px;
      color: var(--muted);
    }
    .footer a{
      color: #0b5bd3;
      text-decoration:none;
      font-weight:700;
    }
    .footer a:hover{ text-decoration:underline; }
  </style>
</head>

<body>
  <div class="wrap">
    <!-- Left: Tropical info panel -->
    <section class="hero">
      <div class="badge">
        <span class="dot"></span>
        <span style="font-size:13px; font-weight:700;">POKECEBU</span>
        <span style="font-size:12px; color:var(--muted);">Cebu Travel Guide</span>
      </div>

      <h1>Create an account</h1>
      <p>
        Start your journey! ホテル・レストランの予約、ジップニーガイド、現地のおすすめをまとめて管理。
      </p>

      <div class="chips">
        <span class="chip"><strong style="color:var(--sec-3);">✔</strong> Easy booking</span>
        <span class="chip"><strong style="color:var(--acc-1);">✔</strong> Local tips</span>
        <span class="chip"><strong style="color:var(--acc-4);">✔</strong> Coupons</span>
      </div>
    </section>

    <!-- Right: Register card -->
    <section class="card">
      <h2>Sign up</h2>
      <p class="sub">Please enter your details to create an account.</p>

      <form>
        <div class="field">
          <label>Name <span class="req">*</span></label>
          <input class="input" type="text" placeholder="Enter your name" />
        </div>

        <div class="field">
          <label>Email <span class="req">*</span></label>
          <input class="input" type="email" placeholder="Enter your email" />
        </div>

        <div class="row">
          <div class="field">
            <label>Password <span class="req">*</span></label>
            <input class="input" type="password" placeholder="Password" />
          </div>
          <div class="field">
            <label>Confirm <span class="req">*</span></label>
            <input class="input" type="password" placeholder="Confirm" />
          </div>
        </div>

        <button class="btn btn-primary" type="submit">Get started</button>
        <button class="btn btn-soft" type="button">For Companies</button>

        <div class="divider">or</div>

        <button class="btn btn-google" type="button">
          <span class="googleG">G</span>
          Sign up with Google
        </button>

        <div class="footer">
          Already have an account? <a href="#">Log in</a>
        </div>
      </form>
    </section>
  </div>

  <div class="waves"></div>
</body>
</html>

@endsection
