<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>MailDrop — Pay. Send. Done.</title>
    <meta name="description" content="MailDrop is the simplest way to send emails with attachments — secured by PayPal. No subscriptions. No accounts. Just pay and send.">
    <meta name="theme-color" content="#1DB954">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="apple-touch-icon" href="/favicon.svg">

    <!-- Open Graph -->
    <meta property="og:title" content="MailDrop — Pay. Send. Done.">
    <meta property="og:description" content="Send emails with attachments secured by PayPal. No subscriptions, no accounts.">
    <meta property="og:type" content="website">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,300&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @inertiaHead
</head>
<body>
    @inertia
</body>
</html>