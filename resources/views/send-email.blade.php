<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MailDrop</title>
    <link href="https://fonts.googleapis.com/css2?family=Circular+Std:wght@400;500;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
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

        .logo-icon svg { width: 28px; height: 28px; fill: var(--black); }

        .logo-area h1 {
            font-family: 'DM Sans', sans-serif;
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
            letter-spacing: 0.2px;
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

        .alert-error ul { padding-left: 1.25rem; margin-top: 0.25rem; }
        .alert-error li { margin-top: 0.2rem; }

        .field { margin-bottom: 1.25rem; }

        label {
            display: block;
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 0.45rem;
        }

        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            background: var(--dark3);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: var(--radius);
            color: var(--white);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.95rem;
            padding: 0.75rem 1rem;
            outline: none;
            transition: border-color 0.2s, background 0.2s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        textarea:focus {
            border-color: var(--green);
            background: var(--dark4);
        }

        input::placeholder, textarea::placeholder { color: rgba(167,167,167,0.45); }
        textarea { resize: none; min-height: 110px; line-height: 1.6; }

        .file-label {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            background: var(--dark3);
            border: 1px dashed rgba(255,255,255,0.15);
            border-radius: var(--radius);
            padding: 0.75rem 1rem;
            cursor: pointer;
            transition: border-color 0.2s, background 0.2s;
            font-size: 0.875rem;
            color: var(--muted);
        }

        .file-label:hover { border-color: var(--green); color: var(--white); }
        .file-label svg { flex-shrink: 0; }
        input[type="file"] { display: none; }

        #file-name { font-size: 0.8rem; color: var(--green); margin-top: 0.4rem; min-height: 1.1rem; }

        .btn {
            width: 100%;
            margin-top: 0.75rem;
            background: var(--green);
            color: var(--black);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            padding: 0.9rem;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
        }

        .btn:hover { background: #1ed760; }
        .btn:active { transform: scale(0.98); }

        .footer-note {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.78rem;
            color: rgba(167,167,167,0.4);
            letter-spacing: 0.02em;
        }

        /* ── MODAL OVERLAY ── */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.75);
            backdrop-filter: blur(4px);
            z-index: 100;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .modal-overlay.active { display: flex; }

        .modal {
            background: var(--dark2);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 20px;
            padding: 2rem;
            width: 100%;
            max-width: 400px;
            position: relative;
            animation: slideUp 0.25s ease;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .modal-close {
            position: absolute;
            top: 1rem; right: 1rem;
            background: var(--dark3);
            border: none;
            color: var(--muted);
            width: 32px; height: 32px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s, color 0.2s;
        }

        .modal-close:hover { background: var(--dark4); color: var(--white); }

        .modal-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 0.3rem;
        }

        .modal-sub {
            font-size: 0.82rem;
            color: var(--muted);
            margin-bottom: 1.5rem;
        }

        .sandbox-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            background: rgba(255,196,57,0.1);
            border: 1px solid rgba(255,196,57,0.3);
            color: #FFC439;
            border-radius: 50px;
            padding: 0.25rem 0.65rem;
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 1.25rem;
        }

        .sandbox-badge::before {
            content: '';
            width: 5px; height: 5px;
            background: #FFC439;
            border-radius: 50%;
        }

        .amount-wrap {
            display: flex;
            align-items: center;
            background: var(--dark3);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: var(--radius);
            overflow: hidden;
            margin-bottom: 0.6rem;
            transition: border-color 0.2s;
        }

        .amount-wrap:focus-within { border-color: var(--green); }

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
            gap: 0.4rem;
            margin-bottom: 1.5rem;
        }

        .preset-btn {
            flex: 1;
            background: var(--dark3);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 50px;
            color: var(--muted);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.78rem;
            font-weight: 600;
            padding: 0.4rem 0;
            cursor: pointer;
            transition: all 0.2s;
        }

        .preset-btn:hover { border-color: var(--green); color: var(--green); }

        .paypal-btn {
            width: 100%;
            background: #FFC439;
            color: #003087;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
            padding: 0.85rem;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: background 0.2s, transform 0.1s;
        }

        .paypal-btn:hover { background: #f0b429; }
        .paypal-btn:active { transform: scale(0.98); }
        .paypal-btn svg { width: 18px; height: 18px; }
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
        <p>Send a message with a file attached</p>
    </div>

    <div class="card">

        @if(session('success'))
            <div class="alert-success">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="emailForm" action="/send-email" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="field">
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" placeholder="e.g. Juan dela Cruz" value="{{ old('name') }}" required>
            </div>

            <div class="field">
                <label for="email">Recipient Email</label>
                <input type="email" id="email" name="email" placeholder="someone@example.com" value="{{ old('email') }}" required>
            </div>

            <div class="field">
                <label>Attachment</label>
                <label class="file-label" for="file">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                    </svg>
                    <span id="file-text">Choose a file to attach</span>
                </label>
                <input type="file" id="file" name="file">
                <p id="file-name"></p>
            </div>

            <div class="field">
                <label for="message">Message</label>
                <textarea id="message" name="message" placeholder="Write something meaningful..." required>{{ old('message') }}</textarea>
            </div>

            {{-- This button opens the PayPal modal instead of submitting directly --}}
            <button type="button" class="btn" onclick="openPayPalModal()">Send Email</button>
        </form>
    </div>

    <p class="footer-note">Powered by Laravel &amp; Gmail SMTP</p>
</div>


{{-- ── PAYPAL MODAL ── --}}
<div class="modal-overlay" id="paypalModal">
    <div class="modal">
        <button class="modal-close" onclick="closePayPalModal()">✕</button>

        <div class="sandbox-badge">Sandbox Mode</div>
        <div class="modal-title">Complete Payment</div>
        <div class="modal-sub">Pay via PayPal to send your email.</div>

        <form id="paypalForm" action="/paypal/pay" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- Hidden fields to carry email form data --}}
            <input type="hidden" name="name" id="hidden_name">
            <input type="hidden" name="email" id="hidden_email">
            <input type="hidden" name="message" id="hidden_message">
            {{-- File will be re-submitted through this hidden file input --}}
            <input type="file" name="file" id="hidden_file" style="display:none;">
            <label style="margin-bottom:0.45rem;">Amount (USD)</label>
            <div class="amount-wrap">
                <span class="amount-prefix">$</span>
                <input type="number" name="amount" id="payAmount" value="10.00" min="1" step="0.01" required>
            </div>
            <div class="preset-btns">
                <button type="button" class="preset-btn" onclick="setAmount(5)">$5</button>
                <button type="button" class="preset-btn" onclick="setAmount(10)">$10</button>
                <button type="button" class="preset-btn" onclick="setAmount(25)">$25</button>
                <button type="button" class="preset-btn" onclick="setAmount(50)">$50</button>
            </div>

            <button type="submit" class="paypal-btn">
                <svg viewBox="0 0 24 24" fill="#003087" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.076 21.337H2.47a.641.641 0 0 1-.633-.74L4.944.901C5.026.382 5.474 0 5.998 0h7.46c2.57 0 4.578.543 5.69 1.81 1.01 1.15 1.304 2.42 1.012 4.287-.023.143-.047.288-.077.437-.983 5.05-4.349 6.797-8.647 6.797h-2.19c-.524 0-.968.382-1.05.9l-1.12 7.106zm14.146-14.42a3.35 3.35 0 0 0-.607-.541c-.013.076-.026.175-.041.254-.93 4.778-4.005 7.201-9.138 7.201h-2.19a.563.563 0 0 0-.556.479l-1.187 7.527h-.506l-.24 1.516a.56.56 0 0 0 .554.647h3.882c.46 0 .85-.334.922-.788.06-.26.76-4.852.816-5.09a.932.932 0 0 1 .923-.788h.58c3.76 0 6.705-1.528 7.565-5.946.36-1.847.174-3.388-.777-4.471z"/>
                </svg>
                Pay with PayPal
            </button>
        </form>
    </div>
</div>

<script>
    // File input label update
    document.getElementById('file').addEventListener('change', function () {
        const name = this.files[0] ? this.files[0].name : '';
        document.getElementById('file-name').textContent = name;
        document.getElementById('file-text').textContent = name ? name : 'Choose a file to attach';
    });

    function openPayPalModal() {
        const form = document.getElementById('emailForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        // Copy email form values into PayPal modal hidden fields
        document.getElementById('hidden_name').value    = document.getElementById('name').value;
        document.getElementById('hidden_email').value   = document.getElementById('email').value;
        document.getElementById('hidden_message').value = document.getElementById('message').value;

        // Transfer file to PayPal form
        const fileInput = document.getElementById('file');
        const hiddenFile = document.getElementById('hidden_file');
        if (fileInput.files.length > 0) {
            const dt = new DataTransfer();
            dt.items.add(fileInput.files[0]);
            hiddenFile.files = dt.files;
        }

        document.getElementById('paypalModal').classList.add('active');
    }

    function closePayPalModal() {
        document.getElementById('paypalModal').classList.remove('active');
    }

    // Close modal when clicking outside
    document.getElementById('paypalModal').addEventListener('click', function(e) {
        if (e.target === this) closePayPalModal();
    });

    function setAmount(val) {
        document.getElementById('payAmount').value = val.toFixed(2);
    }

    // Auto-open modal if payment was just completed (success flash)
    @if(session('paid'))
        document.getElementById('emailForm').submit();
    @endif
</script>

</body>
</html>