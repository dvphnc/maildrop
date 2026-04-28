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

        .logo-icon svg {
            width: 28px;
            height: 28px;
            fill: var(--black);
        }

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
            padding: 2rem 2rem;
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

        input::placeholder, textarea::placeholder {
            color: rgba(167,167,167,0.45);
        }

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

        .file-label:hover {
            border-color: var(--green);
            color: var(--white);
        }

        .file-label svg { flex-shrink: 0; }

        input[type="file"] { display: none; }

        #file-name {
            font-size: 0.8rem;
            color: var(--green);
            margin-top: 0.4rem;
            min-height: 1.1rem;
        }

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

        <form action="/send-email" method="POST" enctype="multipart/form-data">
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

            <button type="submit" class="btn">Send Email</button>
        </form>

    </div>

    <p class="footer-note">Powered by Laravel &amp; Gmail SMTP</p>

</div>

<script>
    document.getElementById('file').addEventListener('change', function () {
        const name = this.files[0] ? this.files[0].name : '';
        document.getElementById('file-name').textContent = name;
        document.getElementById('file-text').textContent = name ? name : 'Choose a file to attach';
    });
</script>

</body>
</html>