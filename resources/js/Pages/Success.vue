<template>
  <div class="wrapper">
    <div class="bg-glow"></div>

    <!-- NAV -->
    <nav>
      <a href="/" class="nav-logo">
        <div class="logo-dot">
          <svg viewBox="0 0 24 24"><path d="M20 4H4C2.9 4 2 4.9 2 6v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
        </div>
        <span>MailDrop</span>
      </a>
    </nav>

    <main class="main">
      <div class="success-card" :class="{ visible: show }">

        <!-- Animated checkmark -->
        <div class="check-wrap">
          <svg class="check-svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
            <circle class="check-circle" cx="50" cy="50" r="45"/>
            <path class="check-mark" d="M28 50 L43 65 L72 35" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>

        <div class="success-badge">Payment Confirmed</div>
        <h1>Email <em>Delivered!</em></h1>
        <p class="success-sub">Your payment was processed and your email was sent successfully. The recipient should receive it shortly.</p>

        <!-- Details -->
        <div class="details">
          <div class="detail-row">
            <span class="detail-label">Status</span>
            <span class="detail-value green">
              <span class="status-dot"></span> Sent
            </span>
          </div>
          <div class="detail-row">
            <span class="detail-label">Payment</span>
            <span class="detail-value green">
              <span class="status-dot"></span> Completed
            </span>
          </div>
          <div class="detail-row">
            <span class="detail-label">Powered by</span>
            <span class="detail-value">Gmail SMTP + PayPal</span>
          </div>
        </div>

        <!-- Actions -->
        <div class="actions">
          <a href="/send-email" class="btn-primary">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
            Send Another
          </a>
          <a href="/" class="btn-ghost">Back to Home</a>
        </div>

      </div>

      <!-- Floating particles -->
      <div class="particles">
        <span v-for="i in 12" :key="i" class="particle" :style="particleStyle(i)"></span>
      </div>
    </main>

    <p class="footer-note">Powered by Laravel &amp; Gmail SMTP</p>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const show = ref(false)

function particleStyle(i) {
  const angle = (i / 12) * 360
  const distance = 120 + Math.random() * 80
  const size = 4 + Math.random() * 6
  const delay = (i * 0.08).toFixed(2)
  return {
    '--angle': angle + 'deg',
    '--distance': distance + 'px',
    '--size': size + 'px',
    '--delay': delay + 's',
  }
}

onMounted(() => {
  setTimeout(() => { show.value = true }, 100)
})
</script>

<style scoped>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

.wrapper {
  background: #0a0a0a; color: #fff;
  font-family: 'DM Sans', sans-serif;
  min-height: 100vh; position: relative;
  display: flex; flex-direction: column;
}

.bg-glow {
  position: fixed; top: 0; left: 0;
  width: 100%; height: 60vh;
  background: radial-gradient(ellipse at 50% -10%, rgba(29,185,84,0.15) 0%, transparent 65%);
  pointer-events: none; z-index: 0;
}

nav {
  position: fixed; top: 0; left: 0; right: 0; z-index: 100;
  display: flex; align-items: center; justify-content: center;
  padding: 1.25rem 3rem;
  border-bottom: 1px solid rgba(255,255,255,0.05);
  backdrop-filter: blur(20px);
  background: rgba(10,10,10,0.85);
}

.nav-logo { display: flex; align-items: center; gap: 0.6rem; text-decoration: none; }
.logo-dot {
  width: 28px; height: 28px; background: #1DB954;
  border-radius: 50%; display: flex; align-items: center; justify-content: center;
}
.logo-dot svg { width: 14px; height: 14px; fill: #000; }
.nav-logo span { font-family: 'Syne', sans-serif; font-size: 1.05rem; font-weight: 700; color: #fff; }

.main {
  flex: 1; display: flex; align-items: center; justify-content: center;
  padding: 6rem 2rem 4rem; position: relative; z-index: 1;
}

.success-card {
  background: #111; border: 1px solid rgba(255,255,255,0.06);
  border-radius: 24px; padding: 3rem 2.5rem;
  width: 100%; max-width: 480px; text-align: center;
  opacity: 0; transform: translateY(30px) scale(0.97);
  transition: opacity 0.7s cubic-bezier(0.23,1,0.32,1),
              transform 0.7s cubic-bezier(0.23,1,0.32,1);
  position: relative; overflow: hidden;
}

.success-card::before {
  content: '';
  position: absolute; top: -1px; left: 15%; right: 15%; height: 1px;
  background: linear-gradient(90deg, transparent, #1DB954, transparent);
}

.success-card.visible { opacity: 1; transform: translateY(0) scale(1); }

/* CHECKMARK */
.check-wrap {
  width: 90px; height: 90px; margin: 0 auto 1.75rem;
}

.check-svg { width: 100%; height: 100%; }

.check-circle {
  fill: none; stroke: #1DB954; stroke-width: 4;
  stroke-dasharray: 283; stroke-dashoffset: 283;
  transform: rotate(-90deg); transform-origin: 50% 50%;
  animation: drawCircle 0.8s 0.3s cubic-bezier(0.23,1,0.32,1) forwards;
}

.check-mark {
  fill: none; stroke: #1DB954; stroke-width: 6;
  stroke-dasharray: 60; stroke-dashoffset: 60;
  animation: drawCheck 0.4s 1s cubic-bezier(0.23,1,0.32,1) forwards;
}

@keyframes drawCircle {
  to { stroke-dashoffset: 0; }
}

@keyframes drawCheck {
  to { stroke-dashoffset: 0; }
}

.success-badge {
  display: inline-flex; align-items: center; gap: 0.4rem;
  background: rgba(29,185,84,0.1); border: 1px solid rgba(29,185,84,0.25);
  color: #1DB954; border-radius: 50px; padding: 0.3rem 0.85rem;
  font-size: 0.7rem; font-weight: 600; letter-spacing: 0.1em;
  text-transform: uppercase; margin-bottom: 1.25rem;
}

h1 {
  font-family: 'Syne', sans-serif;
  font-size: 2.2rem; font-weight: 800;
  letter-spacing: -1px; line-height: 1.1;
  margin-bottom: 1rem;
  animation: fadeUp 0.6s 0.5s ease both;
}

h1 em { font-style: normal; color: #1DB954; }

.success-sub {
  font-size: 0.875rem; color: #555; line-height: 1.8;
  font-weight: 300; margin-bottom: 2rem;
  animation: fadeUp 0.6s 0.6s ease both;
}

/* DETAILS */
.details {
  background: #0d0d0d; border: 1px solid rgba(255,255,255,0.05);
  border-radius: 14px; padding: 0.5rem 1.25rem;
  margin-bottom: 2rem;
  animation: fadeUp 0.6s 0.7s ease both;
}

.detail-row {
  display: flex; align-items: center; justify-content: space-between;
  padding: 0.75rem 0;
  border-bottom: 1px solid rgba(255,255,255,0.04);
}
.detail-row:last-child { border-bottom: none; }

.detail-label { font-size: 0.78rem; color: #444; }
.detail-value { font-size: 0.82rem; color: #888; font-weight: 500; display: flex; align-items: center; gap: 0.4rem; }
.detail-value.green { color: #1DB954; }

.status-dot {
  width: 6px; height: 6px; background: #1DB954;
  border-radius: 50%; animation: pulse 2s ease infinite;
}

@keyframes pulse {
  0%, 100% { opacity: 1; transform: scale(1); }
  50% { opacity: 0.4; transform: scale(0.7); }
}

/* ACTIONS */
.actions {
  display: flex; flex-direction: column; gap: 0.75rem;
  animation: fadeUp 0.6s 0.8s ease both;
}

.btn-primary {
  background: #1DB954; color: #000;
  font-family: 'Syne', sans-serif; font-size: 0.9rem; font-weight: 700;
  padding: 0.9rem 2rem; border-radius: 50px;
  text-decoration: none; display: inline-flex;
  align-items: center; justify-content: center; gap: 0.5rem;
  transition: background 0.2s, transform 0.15s;
  letter-spacing: 0.02em;
}
.btn-primary:hover { background: #1ed760; transform: translateY(-1px); }

.btn-ghost {
  color: #333; font-size: 0.82rem; text-decoration: none;
  transition: color 0.2s; padding: 0.5rem;
}
.btn-ghost:hover { color: #fff; }

/* PARTICLES */
.particles {
  position: absolute; top: 50%; left: 50%;
  pointer-events: none;
}

.particle {
  position: absolute;
  width: var(--size); height: var(--size);
  background: #1DB954; border-radius: 50%;
  opacity: 0;
  animation: burst 1s var(--delay) cubic-bezier(0.23,1,0.32,1) forwards;
}

@keyframes burst {
  0% { opacity: 1; transform: translate(-50%, -50%) rotate(var(--angle)) translateY(0); }
  100% { opacity: 0; transform: translate(-50%, -50%) rotate(var(--angle)) translateY(calc(var(--distance) * -1)); }
}

@keyframes fadeUp {
  from { opacity: 0; transform: translateY(16px); }
  to { opacity: 1; transform: translateY(0); }
}

.footer-note {
  text-align: center; padding: 1.5rem;
  font-size: 0.72rem; color: #1a1a1a;
  position: relative; z-index: 1;
}
</style>