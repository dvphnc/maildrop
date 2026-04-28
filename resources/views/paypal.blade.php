<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MailDrop — Pay to Send</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --green: #1DB954;
            --green-dark: #158a3e;
            --black: #000000;
            --dark: #121212;
            --dark2: #181818;
            --dark3: #282828;
            --dark4: #333333;
            --muted: #A7A7A7;
            --white: #FFFFFF;
            --radius: 8px;
        }

        body {
            background-color: var(--dark);
            color: var(--white);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 40vh;
            background: radial-gradient(ellipse at 60% 0%, rgba(29,185,84,0.18) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        .container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 480px;
        }

        .logo-area {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .logo-icon {
            width: 56px;
            height: 56px;
            background: var(--green);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        .logo-icon svg {
            width: 28px;
            height: 28px;
            fill: var(--black);
        }

        .logo-area h1 {
            font-size: 1.75rem;
            font-weight: 700;
            letter-spacing: -0.5px;
            color: var(--white);
        }

        .logo-area p {
            font-size: 0.9rem;
            color: var(--muted);
            margin-top: 0.35rem;
            font-weight: 300;
        }

        .card {
            background: var(--dark2);
            border-radius: 16px;
            padding: 2rem;
            border: 1px solid rgba(255,255,255,0.06);
        }

        .alert-success {
            background: rgba(29,185,84,0.12);
            border: 1px solid rgba(29,185,84,0.3);
            color: var(--green);
            border-radius: var(--radius);
            padding: 0.85rem 1rem;
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .alert-error {
            background: rgba(255,80,80,0.1);
            border: 1px solid rgba(255,80,80,0.25);
            color: #ff6b6b;
            border-radius: var(--radius);
            padding: 0.85rem 1rem;
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
        }

        .section-label {
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 1rem;
        }

        .amount-display {
            background: var(--dark3);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: var(--radius);
            padding: 1.25rem 1rem;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .amount-display .currency {
            font-size: 1rem;
            color: var(--muted);
            vertical-align: top;
            margin-top: 0.4rem;
            display: inline-block;
        }

        .amount-display .value {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--white);
            letter-spacing: -1px;
        }

        .field { margin-bottom: 1.25rem; }

        label.input-label {
            display: block;
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 0.45rem;
        }

        .amount-input-wrap {
            display: flex;
            align-items: center;
            background: var(--dark3);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: var(--radius);
            overflow: hidden;
            transition: border-color 0.2s;
        }

        .amount-input-wrap:focus-within {
            border-color: var(--green);
        }

        .amount-prefix {
            padding: 0 0.75rem;
            color: var(--muted);
            font-size: 1rem;
            font-weight: 500;
            border-right: 1px solid rgba(255,255,255,0.08);
        }

        input[type="number"] {
            flex: 1;
            background: transparent;
            border: none;
            color: var(--white);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.95rem;
            padding: 0.75rem 1rem;
            outline: none;
        }

        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button { opacity: 0.3; }

        .preset-btns {
            display: flex;
            gap: 0.5rem;
            margin-top: 0.6rem;
        }

        .preset-btn {
            flex: 1;
            background: var(--dark3);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 50px;
            color: var(--muted);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.45rem 0;
            cursor: pointer;
            transition: all 0.2s;
        }

        .preset-btn:hover {
            border-color: var(--green);
            color: var(--green);
        }

        .divider {
            border: none;
            border-top: 1px solid rgba(255,255,255,0.06);
            margin: 1.5rem 0;
        }

        .paypal-btn {
            width: 100%;
            background: #FFC439;
            color: #003087;
            font-family: 'DM Sans', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            padding: 0.9rem;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            transition: background 0.2s, transform 0.1s;
        }

        .paypal-btn:hover { background: #f0b429; }
        .paypal-btn:active { transform: scale(0.98); }

        .paypal-btn svg { width: 20px; height: 20px; }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 1rem;
            font-size: 0.82rem;
            color: var(--muted);
            text-decoration: none;
            transition: color 0.2s;
        }

        .back-link:hover { color: var(--green); }

        .footer-note {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.78rem;
            color: rgba(167,167,167,0.4);
        }

        .sandbox-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            background: rgba(255, 196, 57, 0.1);
            border: 1px solid rgba(255, 196, 57, 0.3);
            color: #FFC439;
            border-radius: 50px;
            padding: 0.3rem 0.75rem;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 1.25rem;
        }

        .sandbox-badge::before {
            content: '';
            width: 6px;
            height: 6px;
            background: #FFC439;
            border-radius: 50%;
        }
    </style>
</head>
<body>

<div class="container">

    <div class="logo-area">
        <div class="logo-icon">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M20 4H4C2.9 4 2 4.9 2 6v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
            </svg>
        </div>
        <h1>MailDrop</h1>
        <p>Complete payment to send your email</p>
    </div>

    <div class="card">

        <div class="sandbox-badge">Sandbox Mode</div>

        @if(session('success'))
            <div class="alert-success">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert-error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="/paypal/pay" method="POST">
            @csrf

            <div class="field">
                <label class="input-label">Payment Amount (USD)</label>
                <div class="amount-input-wrap">
                    <span class="amount-prefix">$</span>
                    <input type="number" name="amount" id="amount" value="10.00" min="1" step="0.01" required>
                </div>
                <div class="preset-btns">
                    <button type="button" class="preset-btn" onclick="setAmount(5)">$5</button>
                    <button type="button" class="preset-btn" onclick="setAmount(10)">$10</button>
                    <button type="button" class="preset-btn" onclick="setAmount(25)">$25</button>
                    <button type="button" class="preset-btn" onclick="setAmount(50)">$50</button>
                </div>
            </div>

            <hr class="divider">

            <button type="submit" class="paypal-btn">
                <!-- PayPal Logo SVG -->
                <svg viewBox="0 0 24 24" fill="#003087" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.076 21.337H2.47a.641.641 0 0 1-.633-.74L4.944.901C5.026.382 5.474 0 5.998 0h7.46c2.57 0 4.578.543 5.69 1.81 1.01 1.15 1.304 2.42 1.012 4.287-.023.143-.047.288-.077.437-.983 5.05-4.349 6.797-8.647 6.797h-2.19c-.524 0-.968.382-1.05.9l-1.12 7.106zm14.146-14.42a3.35 3.35 0 0 0-.607-.541c-.013.076-.026.175-.041.254-.93 4.778-4.005 7.201-9.138 7.201h-2.19a.563.563 0 0 0-.556.479l-1.187 7.527h-.506l-.24 1.516a.56.56 0 0 0 .554.647h3.882c.46 0 .85-.334.922-.788.06-.26.76-4.852.816-5.09a.932.932 0 0 1 .923-.788h.58c3.76 0 6.705-1.528 7.565-5.946.36-1.847.174-3.388-.777-4.471z"/>
                </svg>
                Pay with PayPal
            </button>

        </form>

        <a href="/send-email" class="back-link">← Back to MailDrop</a>

    </div>

    <p class="footer-note">Powered by Laravel &amp; PayPal Sandbox</p>

</div>

<script>
    function setAmount(val) {
        document.getElementById('amount').value = val.toFixed(2);
    }
</script>

</body>
</html>