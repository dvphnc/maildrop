<div align="center">

<br/>

# ✉️ MailDrop

### Pay. Send. Done.

*A pay-per-send email delivery web app — secured by PayPal, built with Laravel & Vue 3.*

<br/>

[![Live Demo](https://img.shields.io/badge/live-demo-1DB954?style=flat-square&logo=render&logoColor=white)](https://maildrop-620d.onrender.com)
[![GitHub](https://img.shields.io/badge/github-dvphnc-181818?style=flat-square&logo=github&logoColor=white)](https://github.com/dvphnc)
[![Made by](https://img.shields.io/badge/made%20by-Joana%20Daphne%20Sy-1DB954?style=flat-square)](https://github.com/dvphnc)

</div>

---

## What is MailDrop?

MailDrop is a pay-per-send email delivery platform built for simplicity. No accounts. No subscriptions. Just fill a form, pay with PayPal, and your email lands in seconds.

> You don't need a full email marketing suite to send one meaningful message. MailDrop gets it there — with proof of payment, file attachment support, and a beautiful dark interface that makes the whole thing feel intentional.

This started as a school activity — a PayPal integration exercise. It turned into something I'd actually want to use and show.

---

## What I Built

A full-stack Laravel + Vue 3 application with Inertia.js, PayPal Sandbox API integration, and real email delivery via Resend.

<details>
<summary>▶ The send experience</summary>
A split-layout form with a live email preview on the right. As you type, the preview updates in real time — showing exactly how your email will look to the recipient before you pay.
</details>

<details>
<summary>▶ PayPal payment flow</summary>
Clicking "Send Email" opens a modal with adjustable amount, preset buttons ($5, $10, $25, $50), and sandbox test credentials built right in for demo purposes.
</details>

<details>
<summary>▶ Drag & drop attachments</summary>
Drop a file or click to browse. The dropzone shows file name and size after selection, with a remove button. Files are saved temporarily, sent, then deleted from the server.
</details>

<details>
<summary>▶ Email history dashboard</summary>
A searchable table of all sent emails — recipient, message preview, attachment, amount paid, status, and date. Each row has a delete button.
</details>

<details>
<summary>▶ The landing page</summary>
A full marketing page with a custom cursor, scroll-reveal animations, marquee ticker, stats bar, how-it-works section, features grid, and pricing cards.
</details>

---

## Built With

```
Laravel 11        Backend framework, routing, mail
Vue 3             Frontend components
Inertia.js        SPA without the API — connects Laravel to Vue
PayPal SDK        Sandbox payment processing
Resend API        Email delivery (bypasses SMTP port blocks)
Vite              Asset bundling
Docker            Containerized deployment
Render            Hosting
SQLite            Database
```

---

## Run It Locally

### Prerequisites

```
PHP 8.2+
Composer
Node.js v18+
npm
Laravel
```

### Installation

```bash
# Clone the repository
git clone https://github.com/dvphnc/maildrop.git

# Navigate into the project
cd maildrop

# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Copy environment file
cp .env.example .env

# Generate app key
php artisan key:generate

# Run migrations
php artisan migrate

# Start Vite dev server
npm run dev
```

Open a second terminal and run:

```bash
php artisan serve
```

Visit `http://localhost:8000` and you're in.

---

## Environment Variables

Add these to your `.env`:

```env
APP_NAME=MailDrop
APP_ENV=local
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite

MAIL_MAILER=resend
RESEND_API_KEY=your_resend_api_key
MAIL_FROM_ADDRESS=onboarding@resend.dev
MAIL_FROM_NAME=MailDrop

PAYPAL_MODE=sandbox
PAYPAL_SANDBOX_CLIENT_ID=your_client_id
PAYPAL_SANDBOX_CLIENT_SECRET=your_secret
PAYPAL_CURRENCY=USD
```

---

## How It's Organized

```
maildrop/
│
├── app/
│   ├── Http/Controllers/
│   │   ├── EmailController.php       — handles email form & sending
│   │   ├── PayPalController.php      — PayPal order creation & capture
│   │   └── DashboardController.php   — email log CRUD
│   ├── Mail/
│   │   └── SendEmailMail.php         — mailable with attachment support
│   ├── Models/
│   │   └── EmailLog.php              — sent email record model
│   └── Providers/
│       └── AppServiceProvider.php    — forces HTTPS in production
│
├── resources/
│   ├── js/
│   │   ├── Pages/
│   │   │   ├── Welcome.vue           — landing page with animations
│   │   │   ├── SendEmail.vue         — split layout form + live preview
│   │   │   ├── Dashboard.vue         — email history with search & delete
│   │   │   └── Success.vue           — animated success page
│   │   └── app.js                    — Inertia + Vue + Toast setup
│   └── views/
│       ├── app.blade.php             — Inertia root layout
│       └── emails/
│           └── sendmail.blade.php    — HTML email template
│
├── routes/
│   └── web.php                       — all application routes
│
├── database/
│   └── migrations/                   — SQLite schema
│
├── public/
│   └── build/                        — compiled Vite assets
│
└── Dockerfile                        — Docker config for Render deployment
```

---

## Deployment

MailDrop is deployed on **Render** using Docker.

```bash
# Build assets before deploying
npm run build

# Push to GitHub — Render auto-deploys
git add .
git commit -m "your message"
git push
```

The `Dockerfile` handles PHP, Apache, Composer, Node, and migrations automatically on each deploy.

---

## Testing Payments

MailDrop runs in **PayPal Sandbox mode**. Use these credentials on the checkout page:

```
Email:    maildrop.buyer@personal.example.com
Password: MailDrop@2026
```

No real money is involved. The credentials are also shown inside the PayPal modal on the app.

---

## Author

<div align="center">

<img src="https://github.com/dvphnc.png" width="72" style="border-radius:50%" alt="Joana Daphne Sy"/>

<br/><br/>

**Joana Daphne Sy**

Developer · Designer · Builder of things

<br/>

[![GitHub](https://img.shields.io/badge/GitHub-dvphnc-1DB954?style=flat-square&logo=github&logoColor=white)](https://github.com/dvphnc)
[![Live Demo](https://img.shields.io/badge/Live%20Demo-maildrop--620d.onrender.com-181818?style=flat-square&logo=render&logoColor=white)](https://maildrop-620d.onrender.com)

</div>

---

<div align="center">

<sub>MailDrop &nbsp;·&nbsp; 2026 &nbsp;·&nbsp; Built with Laravel, Vue 3 & PayPal</sub>

</div>
