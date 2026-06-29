<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pay Tailor — StitchSpot Admin</title>
  <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet">
  <script src="https://js.stripe.com/v3/"></script>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'DM Sans', sans-serif;
      background: #F4F2EF;
      color: #1A1A1A;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 16px;
    }

    .pay-wrap {
      width: 100%;
      max-width: 460px;
    }

    /* Top brand bar */
    .pay-brand-bar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 24px;
    }
    .pay-brand {
      font-size: 20px;
      font-weight: 700;
      color: #111;
      letter-spacing: -.02em;
    }
    .pay-brand span { color: #C9A96E; }
    .pay-back {
      font-size: 12px;
      color: #888;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 5px;
      transition: color .2s;
    }
    .pay-back:hover { color: #1A1A1A; }

    /* Main card */
    .pay-card {
      background: #fff;
      border: 1px solid #E5E7EB;
    }

    /* Order summary strip */
    .pay-summary {
      background: #111;
      padding: 22px 28px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .pay-summary-label {
      font-size: 11px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .15em;
      color: rgba(255,255,255,.45);
      margin-bottom: 4px;
    }
    .pay-summary-id {
      font-size: 13px;
      color: rgba(255,255,255,.7);
    }
    .pay-summary-amount {
      text-align: right;
    }
    .pay-summary-amount .label {
      font-size: 10px;
      text-transform: uppercase;
      letter-spacing: .15em;
      color: rgba(255,255,255,.4);
      margin-bottom: 2px;
    }
    .pay-summary-amount .value {
      font-size: 28px;
      font-weight: 700;
      color: #C9A96E;
      letter-spacing: -.02em;
      line-height: 1;
    }
    .pay-summary-amount .currency {
      font-size: 13px;
      font-weight: 400;
      color: rgba(255,255,255,.5);
      margin-right: 3px;
    }

    /* Form area */
    .pay-body { padding: 28px; }

    .pay-section-label {
      font-size: 10.5px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .15em;
      color: #9CA3AF;
      margin-bottom: 14px;
    }

    .StripeElement {
      padding: 13px 14px;
      border: 1px solid #E5E7EB;
      background: #FAFAF8;
      transition: border-color .2s, box-shadow .2s;
    }
    .StripeElement--focus {
      border-color: #C9A96E;
      box-shadow: 0 0 0 3px rgba(201,169,110,.12);
      outline: none;
    }
    .StripeElement--invalid { border-color: #E63946; }

    #card-errors {
      margin-top: 10px;
      padding: 10px 14px;
      background: #FEF2F2;
      border-left: 3px solid #E63946;
      font-size: 12px;
      color: #E63946;
      display: none;
    }

    .pay-divider {
      border: none;
      border-top: 1px solid #F3F2EF;
      margin: 24px 0;
    }

    .pay-btn {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      width: 100%;
      padding: 14px;
      background: #1A1A1A;
      color: #fff;
      font-size: 13px;
      font-weight: 600;
      font-family: 'DM Sans', sans-serif;
      letter-spacing: .05em;
      text-transform: uppercase;
      border: none;
      cursor: pointer;
      transition: background .22s;
    }
    .pay-btn:hover:not(:disabled) { background: #C9A96E; }
    .pay-btn:disabled { opacity: .55; cursor: not-allowed; }

    .pay-secure {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      margin-top: 14px;
      font-size: 11px;
      color: #9CA3AF;
    }

    .pay-success-msg {
      margin-bottom: 16px;
      padding: 12px 16px;
      background: #DCFCE7;
      border-left: 3px solid #16A34A;
      font-size: 13px;
      color: #16A34A;
    }
    .pay-error-msg {
      margin-bottom: 16px;
      padding: 12px 16px;
      background: #FEF2F2;
      border-left: 3px solid #E63946;
      font-size: 13px;
      color: #E63946;
    }

    /* Lock icon spinner */
    .spinner { display: none; width: 16px; height: 16px; border: 2px solid rgba(255,255,255,.4); border-top-color: #fff; border-radius: 50%; animation: spin .6s linear infinite; }
    @keyframes spin { to { transform: rotate(360deg); } }
  </style>
</head>
<body>

  <div class="pay-wrap">

    <div class="pay-brand-bar">
      <div class="pay-brand">Stitch<span>Spot</span></div>
      <a href="{{ url('/admin/tailor_order') }}" class="pay-back">
        &#8592; Back to Orders
      </a>
    </div>

    <div class="pay-card">

      {{-- Dark summary strip --}}
      <div class="pay-summary">
        <div>
          <div class="pay-summary-label">Tailor Payout</div>
          <div class="pay-summary-id">Order #{{ $id }} &nbsp;·&nbsp; Tailor #{{ $user_id }}</div>
        </div>
        <div class="pay-summary-amount">
          <div class="label">Amount</div>
          <div class="value"><span class="currency">PKR</span>{{ number_format($price, 0) }}</div>
        </div>
      </div>

      <div class="pay-body">

        @if(Session::has('success'))
          <div class="pay-success-msg">{{ Session::get('success') }}</div>
        @endif
        @if(Session::has('error'))
          <div class="pay-error-msg">{{ Session::get('error') }}</div>
        @endif

        <form action="{{ route('stripe_pay_tailor.post') }}" method="post" id="payment-form">
          @csrf
          <input type="hidden" name="id"       value="{{ $id }}">
          <input type="hidden" name="user_id"  value="{{ $user_id }}">

          <div class="pay-section-label">Card Details</div>
          <div id="card-element"></div>
          <div id="card-errors" role="alert"></div>

          <hr class="pay-divider">

          <button class="pay-btn" type="submit" id="submit-button">
            <svg id="lock-icon" xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            <div class="spinner" id="btn-spinner"></div>
            <span id="btn-text">Pay PKR {{ number_format($price, 0) }}</span>
          </button>
        </form>

        <div class="pay-secure">
          <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
          Secured by Stripe &nbsp;·&nbsp; End-to-end encrypted
        </div>

      </div>
    </div>
  </div>

<script>
  var stripe   = Stripe('{{ env('STRIPE_KEY') }}');
  var elements = stripe.elements();

  var card = elements.create('card', {
    hidePostalCode: true,
    style: {
      base: {
        color: '#1A1A1A',
        fontFamily: '"DM Sans", sans-serif',
        fontSmoothing: 'antialiased',
        fontSize: '14px',
        '::placeholder': { color: '#bbb' }
      },
      invalid: { color: '#E63946', iconColor: '#E63946' }
    }
  });
  card.mount('#card-element');

  card.on('change', function(e) {
    var el = document.getElementById('card-errors');
    el.textContent   = e.error ? e.error.message : '';
    el.style.display = e.error ? 'block' : 'none';
  });

  var form   = document.getElementById('payment-form');
  var btn    = document.getElementById('submit-button');
  var spinner = document.getElementById('btn-spinner');
  var lockIcon = document.getElementById('lock-icon');
  var btnText = document.getElementById('btn-text');

  form.addEventListener('submit', function(e) {
    e.preventDefault();
    btn.disabled      = true;
    lockIcon.style.display = 'none';
    spinner.style.display  = 'block';
    btnText.textContent    = 'Processing…';

    stripe.confirmCardPayment('{{ $client_secret }}', {
      payment_method: { card: card }
    }).then(function(result) {
      if (result.error) {
        var errEl = document.getElementById('card-errors');
        errEl.textContent   = result.error.message;
        errEl.style.display = 'block';
        btn.disabled           = false;
        spinner.style.display  = 'none';
        lockIcon.style.display = 'block';
        btnText.textContent    = 'Pay PKR {{ number_format($price, 0) }}';
      } else if (result.paymentIntent.status === 'succeeded') {
        var inp = document.createElement('input');
        inp.type  = 'hidden';
        inp.name  = 'stripeToken';
        inp.value = result.paymentIntent.id;
        form.appendChild(inp);
        btnText.textContent = 'Payment confirmed…';
        form.submit();
      }
    });
  });
</script>

</body>
</html>
