<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Login — StitchSpot</title>
  <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
  <link rel="shortcut icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'DM Sans', sans-serif;
      height: 100vh;
      display: flex;
      overflow: hidden;
    }

    /* ─── LEFT PANEL ─── */
    .login-left {
      width: 50%;
      background: #111111;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 60px 48px;
    }
    .login-brand {
      font-size: 42px;
      font-weight: 700;
      color: #fff;
      letter-spacing: -.03em;
      margin-bottom: 8px;
    }
    .login-brand span { color: #C9A96E; }
    .login-fashion {
      font-size: 12px;
      font-weight: 500;
      text-transform: uppercase;
      letter-spacing: .2em;
      color: rgba(255,255,255,.35);
      margin-bottom: 40px;
    }
    .login-tagline {
      font-size: 18px;
      font-weight: 300;
      color: rgba(255,255,255,.5);
      text-align: center;
      line-height: 1.6;
      max-width: 280px;
    }
    .login-deco {
      margin-top: 48px;
      display: flex;
      gap: 8px;
    }
    .login-deco-dot {
      width: 6px; height: 6px;
      background: rgba(255,255,255,.15);
      border-radius: 50%;
    }
    .login-deco-dot.active { background: #C9A96E; }

    /* ─── RIGHT PANEL ─── */
    .login-right {
      width: 50%;
      background: #fff;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 60px 48px;
    }
    .login-form-wrap {
      width: 100%;
      max-width: 380px;
    }
    .login-form-title {
      font-size: 26px;
      font-weight: 700;
      color: #1A1A1A;
      letter-spacing: -.02em;
      margin-bottom: 6px;
    }
    .login-form-sub {
      font-size: 13px;
      color: #888;
      margin-bottom: 36px;
    }

    .lf-group { margin-bottom: 20px; }
    .lf-label {
      display: block;
      font-size: 11px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .12em;
      color: #888;
      margin-bottom: 7px;
    }
    .lf-input {
      width: 100%;
      padding: 12px 16px;
      border: 1px solid #E5E7EB;
      background: #FAFAF8;
      font-size: 14px;
      color: #1A1A1A;
      font-family: 'DM Sans', sans-serif;
      outline: none;
      transition: border-color .2s, background .2s;
    }
    .lf-input:focus {
      border-color: #C9A96E;
      background: #fff;
    }
    .lf-input::placeholder { color: #bbb; }

    .lf-btn {
      width: 100%;
      padding: 13px;
      background: #1A1A1A;
      color: #fff;
      font-size: 14px;
      font-weight: 600;
      font-family: 'DM Sans', sans-serif;
      border: none;
      cursor: pointer;
      transition: background .22s;
      letter-spacing: .02em;
      margin-top: 8px;
    }
    .lf-btn:hover { background: #C9A96E; }

    .lf-error {
      margin-top: 16px;
      padding: 12px 16px;
      background: #FEF2F2;
      border-left: 3px solid #E63946;
      font-size: 13px;
      color: #E63946;
    }

    @media (max-width: 768px) {
      .login-left { display: none; }
      .login-right { width: 100%; padding: 40px 24px; }
    }
  </style>
</head>
<body>

  <!-- LEFT -->
  <div class="login-left">
    <div class="login-brand">Stitch<span>Spot</span></div>
    <div class="login-fashion">Fashion &amp; Tailoring</div>
    <div class="login-tagline">Manage your store with ease.</div>
    <div class="login-deco">
      <div class="login-deco-dot active"></div>
      <div class="login-deco-dot"></div>
      <div class="login-deco-dot"></div>
    </div>
  </div>

  <!-- RIGHT -->
  <div class="login-right">
    <div class="login-form-wrap">
      <h1 class="login-form-title">Admin Sign In</h1>
      <p class="login-form-sub">Enter your credentials to continue.</p>

      <form action="{{route('admin.auth')}}" method="post">
        @csrf

        <div class="lf-group">
          <label class="lf-label" for="email">Email Address</label>
          <input type="email" id="email" name="email" class="lf-input" placeholder="admin@stitchspot.com" required>
        </div>

        <div class="lf-group">
          <label class="lf-label" for="password">Password</label>
          <input type="password" id="password" name="password" class="lf-input" placeholder="••••••••" required>
        </div>

        <button type="submit" class="lf-btn">Sign In</button>

        @if(session('error'))
          <div class="lf-error">{{ session('error') }}</div>
        @endif
      </form>
    </div>
  </div>

</body>
</html>
