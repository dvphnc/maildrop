<template>
  <div class="page">
    <div class="cursor" ref="cursor"></div>
    <div class="cursor-ring" ref="cursorRing"></div>

    <!-- NAV -->
    <nav>
      <a href="/" class="nav-logo">
        <div class="nav-logo-dot">
          <svg viewBox="0 0 24 24"><path d="M20 4H4C2.9 4 2 4.9 2 6v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
        </div>
        <span>MailDrop</span>
      </a>
      <ul class="nav-links">
        <li><a href="#how">How it works</a></li>
        <li><a href="#features">Features</a></li>
        <li><a href="#pricing">Pricing</a></li>
        <li><a href="/dashboard">Dashboard</a></li>
        <li><a href="/send-email" class="nav-cta">Start Sending</a></li>
      </ul>
    </nav>

    <!-- HERO -->
    <section class="hero">
      <div class="hero-bg"></div>
      <div class="hero-grid"></div>
      <div class="hero-badge">Now in Sandbox Mode</div>
      <h1>Pay once.<br><em>Send forever.</em></h1>
      <p class="hero-sub">MailDrop is the simplest way to send emails with attachments — secured by PayPal. <br>No subscriptions. No accounts. <br>Just pay and send.</p>
      <div class="hero-actions">
        <a href="/send-email" class="btn-primary">
          Start Sending
          <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
        <a href="#how" class="btn-ghost">
          See how it works
          <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
        </a>
      </div>
      <div class="hero-scroll">
        <div class="scroll-line"></div>
        Scroll
      </div>
    </section>

    <!-- MARQUEE -->
    <div class="marquee-wrap">
      <div class="marquee-track">
        <span v-for="(item, i) in marqueeItems" :key="i" class="marquee-item">
          {{ item }} <span class="marquee-dot"></span>
        </span>
      </div>
    </div>

    <!-- STATS -->
    <div class="stats-bar">
      <div v-for="stat in stats" :key="stat.label" class="stat-item reveal" :class="{ visible: revealed }">
        <div class="stat-number" v-html="stat.number"></div>
        <div class="stat-label">{{ stat.label }}</div>
      </div>
    </div>

    <!-- HOW IT WORKS -->
    <section class="section" id="how">
      <div class="section-tag">How it works</div>
      <h2>Three steps.<br>That's all.</h2>
      <p class="section-sub">No signup. No monthly fees. Fill the form, pay with PayPal, and your email is sent instantly.</p>
      <div class="steps reveal" :class="{ visible: revealed }">
        <div v-for="step in steps" :key="step.num" class="step">
          <div class="step-num">{{ step.num }}</div>
          <div class="step-icon" v-html="step.icon"></div>
          <h3>{{ step.title }}</h3>
          <p>{{ step.desc }}</p>
        </div>
      </div>
    </section>

    <!-- FEATURES -->
    <section class="section" id="features">
      <div class="section-tag">Features</div>
      <h2>Built for simplicity.<br>Designed for trust.</h2>
      <p class="section-sub">Everything you need to send a one-off email securely, without the overhead of a full email platform.</p>
      <div class="features-grid reveal" :class="{ visible: revealed }">
        <div v-for="feature in features" :key="feature.title" class="feature">
          <div class="feature-icon" v-html="feature.icon"></div>
          <h3>{{ feature.title }}</h3>
          <p>{{ feature.desc }}</p>
        </div>
      </div>
    </section>

    <!-- PRICING -->
    <section class="section" id="pricing">
      <div class="section-tag">Pricing</div>
      <h2>Simple,<br>transparent pricing.</h2>
      <p class="section-sub">Choose your amount. No hidden fees. You decide what your email is worth.</p>
      <div class="pricing-grid reveal" :class="{ visible: revealed }">
        <div v-for="plan in plans" :key="plan.tier" class="pricing-card" :class="{ featured: plan.featured }">
          <div v-if="plan.featured" class="featured-badge">Most Popular</div>
          <div class="pricing-tier">{{ plan.tier }}</div>
          <div class="pricing-amount">
            <span class="pricing-currency">$</span>
            <span class="pricing-price">{{ plan.price }}</span>
          </div>
          <div class="pricing-per">per email</div>
          <p class="pricing-desc">{{ plan.desc }}</p>
          <ul class="pricing-features">
            <li v-for="f in plan.features" :key="f">{{ f }}</li>
          </ul>
          <a href="/send-email" class="pricing-btn" :class="plan.featured ? 'pricing-btn-solid' : 'pricing-btn-outline'">
            {{ plan.featured ? 'Send Now' : 'Get Started' }}
          </a>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <div class="cta-strip reveal" :class="{ visible: revealed }">
      <h2>Ready to drop a mail?</h2>
      <p>Fill the form, pay with PayPal, and your email lands in seconds.</p>
      <a href="/send-email" class="btn-primary">
        Start Sending
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
      </a>
    </div>

    <!-- FOOTER -->
    <footer>
      <a href="/" class="footer-logo">
        <div class="nav-logo-dot">
          <svg viewBox="0 0 24 24" style="width:14px;height:14px;fill:#000;"><path d="M20 4H4C2.9 4 2 4.9 2 6v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
        </div>
        <span>MailDrop</span>
      </a>
      <p class="footer-copy">&copy; 2026 MailDrop. Built with Laravel &amp; PayPal.</p>
      <ul class="footer-links">
        <li><a href="#how">How it works</a></li>
        <li><a href="#pricing">Pricing</a></li>
        <li><a href="/send-email">Send Email</a></li>
      </ul>
    </footer>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const cursor = ref(null)
const cursorRing = ref(null)
const revealed = ref(false)

const marqueeItems = [
  'Instant Delivery', 'PayPal Secured', 'File Attachments',
  'Sandbox Testing', 'Laravel Powered', 'No Subscriptions',
  'Instant Delivery', 'PayPal Secured', 'File Attachments',
  'Sandbox Testing', 'Laravel Powered', 'No Subscriptions',
]

const stats = [
  { number: '99<span>%</span>', label: 'Delivery Rate' },
  { number: '&lt;2<span>s</span>', label: 'Send Time' },
  { number: '5<span>MB</span>', label: 'Max Attachment' },
  { number: '$<span>1</span>', label: 'Starting Price' },
]

const steps = [
  {
    num: '01',
    icon: `<svg viewBox="0 0 24 24" fill="none" stroke="#1DB954" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>`,
    title: 'Fill the form',
    desc: 'Enter the recipient\'s email, write your message, and optionally attach a file up to 5MB.',
  },
  {
    num: '02',
    icon: `<svg viewBox="0 0 24 24" fill="none" stroke="#1DB954" stroke-width="1.5"><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm-1-11v6l5-3-5-3z" stroke-linecap="round" stroke-linejoin="round"/></svg>`,
    title: 'Pay with PayPal',
    desc: 'A modal appears with your chosen amount. Complete the secure PayPal checkout in seconds.',
  },
  {
    num: '03',
    icon: `<svg viewBox="0 0 24 24" fill="none" stroke="#1DB954" stroke-width="1.5"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z" stroke-linecap="round" stroke-linejoin="round"/></svg>`,
    title: 'Email sent',
    desc: 'After payment is confirmed, your email is delivered instantly via Gmail SMTP with your attachment.',
  },
]

const features = [
  {
    icon: `<svg viewBox="0 0 24 24" fill="none" stroke="#1DB954" stroke-width="1.5"><path d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" stroke-linecap="round" stroke-linejoin="round"/></svg>`,
    title: 'File Attachments',
    desc: 'Attach PDFs, images, documents — up to 5MB. Files are saved temporarily, sent, then deleted immediately.',
  },
  {
    icon: `<svg viewBox="0 0 24 24" fill="none" stroke="#1DB954" stroke-width="1.5"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" stroke-linecap="round" stroke-linejoin="round"/></svg>`,
    title: 'PayPal Secured',
    desc: 'Every send is gated behind a PayPal payment, preventing spam and ensuring only serious senders use the service.',
  },
  {
    icon: `<svg viewBox="0 0 24 24" fill="none" stroke="#1DB954" stroke-width="1.5"><path d="M13 10V3L4 14h7v7l9-11h-7z" stroke-linecap="round" stroke-linejoin="round"/></svg>`,
    title: 'Instant Delivery',
    desc: 'Powered by Gmail SMTP, emails are delivered in under 2 seconds after payment confirmation.',
  },
  {
    icon: `<svg viewBox="0 0 24 24" fill="none" stroke="#1DB954" stroke-width="1.5"><path d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" stroke-linecap="round" stroke-linejoin="round"/></svg>`,
    title: 'Beautiful Templates',
    desc: 'Emails arrive with a polished dark-themed HTML template. Your recipients notice the difference.',
  },
]

const plans = [
  {
    tier: 'Basic', price: 2, featured: false,
    desc: 'Perfect for one-off sends.',
    features: ['Single email send', 'File attachment support', 'HTML email template', 'Instant delivery'],
  },
  {
    tier: 'Standard', price: 10, featured: true,
    desc: 'The default MailDrop experience.',
    features: ['Single email send', 'File attachment support', 'HTML email template', 'Priority delivery', 'Sandbox testing ready'],
  },
  {
    tier: 'Premium', price: 25, featured: false,
    desc: 'For when it really matters.',
    features: ['Single email send', 'File attachment support', 'HTML email template', 'Priority delivery', 'Custom amount option'],
  },
]

onMounted(() => {
  // Cursor
  let mx = 0, my = 0, rx = 0, ry = 0
  let cursorVisible = false

  document.addEventListener('mousemove', e => {
    mx = e.clientX; my = e.clientY
    if (!cursorVisible) {
      cursorVisible = true
      if (cursor.value) cursor.value.style.opacity = '1'
      if (cursorRing.value) cursorRing.value.style.opacity = '1'
    }
    if (cursor.value) {
      cursor.value.style.left = mx + 'px'
      cursor.value.style.top = my + 'px'
    }
  })

  function animateRing() {
    rx += (mx - rx) * 0.50
    ry += (my - ry) * 0.50
    if (cursorRing.value) {
      cursorRing.value.style.left = rx + 'px'
      cursorRing.value.style.top = ry + 'px'
    }
    requestAnimationFrame(animateRing)
  }
  animateRing()

  document.querySelectorAll('a, button').forEach(el => {
    el.addEventListener('mouseenter', () => {
      if (cursor.value) {
        cursor.value.style.transform = 'translate(-50%, -50%) scale(0)'
        cursor.value.style.opacity = '0'
      }
      if (cursorRing.value) {
        cursorRing.value.style.width = '56px'
        cursorRing.value.style.height = '56px'
        cursorRing.value.style.borderColor = 'rgba(29,185,84,0.8)'
        cursorRing.value.style.background = 'rgba(29,185,84,0.08)'
      }
    })
    el.addEventListener('mouseleave', () => {
      if (cursor.value) {
        cursor.value.style.transform = 'translate(-50%, -50%) scale(1)'
        cursor.value.style.opacity = '1'
      }
      if (cursorRing.value) {
        cursorRing.value.style.width = '36px'
        cursorRing.value.style.height = '36px'
        cursorRing.value.style.borderColor = 'rgba(29,185,84,0.4)'
        cursorRing.value.style.background = 'transparent'
      }
    })
  })

  // Staggered scroll reveal
  const revealEls = document.querySelectorAll('.reveal, .stat-item')
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const children = entry.target.querySelectorAll('.step, .feature, .pricing-card, .stat-item')
        if (children.length) {
          children.forEach((child, i) => {
            setTimeout(() => {
              child.style.opacity = '1'
              child.style.transform = 'translateY(0)'
            }, i * 120)
          })
        }
        setTimeout(() => { entry.target.classList.add('visible') }, 80)
        observer.unobserve(entry.target)
      }
    })
  }, { threshold: 0.08, rootMargin: '0px 0px -60px 0px' })

  revealEls.forEach(el => observer.observe(el))

  // Nav shrink on scroll
  const nav = document.querySelector('nav')
  window.addEventListener('scroll', () => {
    if (window.scrollY > 60) {
      nav.style.padding = '1rem 4rem'
      nav.style.background = 'rgba(10,10,10,0.95)'
    } else {
      nav.style.padding = '1.5rem 4rem'
      nav.style.background = 'rgba(10,10,10,0.8)'
    }
  }, { passive: true })
})
</script>

<style scoped>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

.page {
  background: #0a0a0a;
  color: #fff;
  font-family: 'DM Sans', sans-serif;
  overflow-x: hidden;
  cursor: none;
  border: none;
  outline: none;
}

:global(html, body) {
  margin: 0;
  padding: 0;
  background: #0a0a0a;
  border: none;
  outline: none;
  scrollbar-color: #222 #0a0a0a;
  scrollbar-width: thin;
}

:global(::-webkit-scrollbar) { width: 6px; }
:global(::-webkit-scrollbar-track) { background: #0a0a0a; }
:global(::-webkit-scrollbar-thumb) { background: #222; border-radius: 3px; }
:global(::-webkit-scrollbar-thumb:hover) { background: #333; }

.cursor {
  width: 8px; height: 8px;
  background: #1DB954;
  border-radius: 50%;
  position: fixed;
  pointer-events: none;
  z-index: 9999;
  transform: translate(-50%, -50%);
  opacity: 0;
  transition: transform 0.2s cubic-bezier(0.23, 1, 0.32, 1),
              opacity 0.3s ease;
  will-change: left, top, transform;
}

.cursor-ring {
  width: 36px; height: 36px;
  border: 1.5px solid rgba(29,185,84,0.4);
  border-radius: 50%;
  position: fixed;
  pointer-events: none;
  z-index: 9998;
  transform: translate(-50%, -50%);
  opacity: 0;
  background: transparent;
  transition: width 0.3s cubic-bezier(0.23, 1, 0.32, 1),
              height 0.3s cubic-bezier(0.23, 1, 0.32, 1),
              border-color 0.2s ease,
              background 0.2s ease,
              opacity 0.3s ease;
  will-change: left, top;
}

nav {
  position: fixed; top: 0; left: 0; right: 0;
  z-index: 100;
  display: flex; align-items: center; justify-content: space-between;
  padding: 1.5rem 4rem;
  border-bottom: 1px solid rgba(255,255,255,0.04);
  backdrop-filter: blur(20px);
  background: rgba(10,10,10,0.8);
  transition: padding 0.4s cubic-bezier(0.23,1,0.32,1), background 0.4s ease;
}

.nav-logo { display: flex; align-items: center; gap: 0.6rem; text-decoration: none; }

.nav-logo-dot {
  width: 28px; height: 28px;
  background: #1DB954; border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
}

.nav-logo-dot svg { width: 14px; height: 14px; fill: #000; }
.nav-logo span { font-family: 'Syne', sans-serif; font-size: 1.1rem; font-weight: 700; color: #fff; letter-spacing: -0.3px; }

.nav-links { display: flex; align-items: center; gap: 2.5rem; list-style: none; }
.nav-links a { font-size: 0.82rem; color: #999; text-decoration: none; letter-spacing: 0.05em; text-transform: uppercase; transition: color 0.2s; }
.nav-links a:hover { color: #fff; }

.nav-cta {
  background: #1DB954 !important; color: #000 !important;
  padding: 0.55rem 1.25rem !important; border-radius: 50px !important;
  font-weight: 600 !important;
}

.hero {
  min-height: 100vh;
  display: flex; flex-direction: column; align-items: center; justify-content: center;
  text-align: center; padding: 6rem 2rem 6rem;
  position: relative; overflow: hidden;
}

.hero-bg {
  position: absolute; inset: 0;
  background: radial-gradient(ellipse 60% 50% at 50% -10%, rgba(29,185,84,0.15) 0%, transparent 70%);
  pointer-events: none;
}

.hero-grid {
  position: absolute; inset: 0;
  background-image: linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
  background-size: 60px 60px;
  mask-image: radial-gradient(ellipse 80% 60% at 50% 0%, black 0%, transparent 70%);
  pointer-events: none;
}

.hero-badge {
  display: inline-flex; align-items: center; gap: 0.5rem;
  background: #1a1a1a; border: 1px solid rgba(29,185,84,0.25);
  border-radius: 50px; padding: 0.4rem 1rem;
  font-size: 0.75rem; font-weight: 500; color: #1DB954;
  letter-spacing: 0.08em; text-transform: uppercase;
  margin-bottom: 2.5rem; animation: fadeUp 0.8s ease both;
}

.hero-badge::before {
  content: ''; width: 6px; height: 6px;
  background: #1DB954; border-radius: 50%;
  animation: pulse 2s ease infinite;
}

@keyframes pulse {
  0%, 100% { opacity: 1; transform: scale(1); }
  50% { opacity: 0.4; transform: scale(0.8); }
}

.hero h1 {
  font-family: 'Syne', sans-serif;
  font-size: clamp(3.5rem, 9vw, 8rem);
  font-weight: 800; line-height: 0.95;
  letter-spacing: -3px; color: #fff;
  margin-bottom: 2rem;
  animation: fadeUp 0.8s 0.1s ease both;
}

.hero h1 em { font-style: normal; color: #1DB954; }

.hero-sub {
  font-size: clamp(1rem, 2vw, 1.2rem);
  color: #999; font-weight: 300;
  max-width: 500px; line-height: 1.7;
  margin-bottom: 3rem;
  animation: fadeUp 0.8s 0.2s ease both;
}

.hero-actions { display: flex; align-items: center; gap: 1rem; animation: fadeUp 0.8s 0.3s ease both; }

.btn-primary {
  background: #1DB954; color: #000;
  font-family: 'Syne', sans-serif; font-size: 0.9rem; font-weight: 700;
  padding: 1rem 2.5rem; border-radius: 50px;
  text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;
  transition: background 0.2s, transform 0.15s;
}
.btn-primary:hover { background: #1ed760; transform: translateY(-2px); }

.btn-ghost {
  color: #999; font-size: 0.85rem; text-decoration: none;
  display: inline-flex; align-items: center; gap: 0.4rem;
  transition: color 0.2s; padding: 1rem;
}
.btn-ghost:hover { color: #fff; }

.hero-scroll {
  position: absolute; bottom: 3rem;
  left: 50%; transform: translateX(-50%);
  display: flex; flex-direction: column; align-items: center; gap: 0.5rem;
  color: #666; font-size: 0.7rem; letter-spacing: 0.15em; text-transform: uppercase;
  animation: fadeUp 1s 0.6s ease both;
  white-space: nowrap;
}

.scroll-line {
  width: 1px; height: 50px;
  background: linear-gradient(to bottom, #666, transparent);
  animation: scrollLine 2s ease infinite;
}

@keyframes scrollLine {
  0% { transform: scaleY(0); transform-origin: top; }
  50% { transform: scaleY(1); transform-origin: top; }
  51% { transform: scaleY(1); transform-origin: bottom; }
  100% { transform: scaleY(0); transform-origin: bottom; }
}

@keyframes fadeUp {
  from { opacity: 0; transform: translateY(24px); }
  to { opacity: 1; transform: translateY(0); }
}

.marquee-wrap {
  overflow: hidden;
  border-top: 1px solid rgba(255,255,255,0.04);
  border-bottom: 1px solid rgba(255,255,255,0.04);
  padding: 1.2rem 0; background: #111;
}

.marquee-track {
  display: flex; gap: 3rem;
  animation: marquee 20s linear infinite;
  white-space: nowrap;
}

.marquee-item {
  font-family: 'Syne', sans-serif; font-size: 0.72rem; font-weight: 600;
  letter-spacing: 0.2em; text-transform: uppercase; color: #666;
  display: flex; align-items: center; gap: 1rem; flex-shrink: 0;
}

.marquee-dot { width: 4px; height: 4px; background: #1DB954; border-radius: 50%; }

@keyframes marquee {
  from { transform: translateX(0); }
  to { transform: translateX(-50%); }
}

.stats-bar {
  border-top: 1px solid rgba(255,255,255,0.05);
  border-bottom: 1px solid rgba(255,255,255,0.05);
  background: #111; padding: 2rem 4rem;
  display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem;
}

.stat-item {
  text-align: center; padding: 1rem;
  border-right: 1px solid rgba(255,255,255,0.05);
  opacity: 0; transform: translateY(20px);
  transition: opacity 0.6s ease, transform 0.6s ease;
}
.stat-item:last-child { border-right: none; }
.stat-item.visible { opacity: 1; transform: translateY(0); }

.stat-number { font-family: 'Syne', sans-serif; font-size: 2.5rem; font-weight: 800; color: #fff; letter-spacing: -1px; line-height: 1; }
.stat-number :deep(span) { color: #1DB954; }
.stat-label { font-size: 0.75rem; color: #666; text-transform: uppercase; letter-spacing: 0.1em; margin-top: 0.4rem; }

.section { padding: 8rem 4rem; max-width: 1200px; margin: 0 auto; }

.section-tag {
  display: inline-flex; align-items: center; gap: 0.5rem;
  font-size: 0.72rem; font-weight: 600; letter-spacing: 0.15em;
  text-transform: uppercase; color: #1DB954; margin-bottom: 1.5rem;
}
.section-tag::before { content: ''; width: 20px; height: 1px; background: #1DB954; }

.section h2 {
  font-family: 'Syne', sans-serif;
  font-size: clamp(2rem, 4vw, 3.5rem);
  font-weight: 800; letter-spacing: -1.5px; line-height: 1.05;
  color: #fff; margin-bottom: 1.5rem;
}

.section-sub { font-size: 1rem; color: #999; font-weight: 300; max-width: 480px; line-height: 1.8; margin-bottom: 4rem; }

.reveal { opacity: 0; transform: translateY(40px); transition: opacity 0.9s cubic-bezier(0.23,1,0.32,1), transform 0.9s cubic-bezier(0.23,1,0.32,1); }
.reveal.visible { opacity: 1; transform: translateY(0); }

.steps {
  display: grid; grid-template-columns: repeat(3, 1fr);
  gap: 1.5px; background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,255,255,0.05); border-radius: 20px; overflow: hidden;
}

.step { background: #111; padding: 3rem 2.5rem; transition: background 0.3s, opacity 0.6s cubic-bezier(0.23,1,0.32,1), transform 0.6s cubic-bezier(0.23,1,0.32,1); opacity: 0; transform: translateY(24px); }
.step:hover { background: #1a1a1a; }
.step-num { font-family: 'Syne', sans-serif; font-size: 4rem; font-weight: 800; color: rgba(255,255,255,0.04); line-height: 1; margin-bottom: 1.5rem; letter-spacing: -2px; }

.step-icon {
  width: 44px; height: 44px;
  background: rgba(29,185,84,0.12); border: 1px solid rgba(29,185,84,0.2);
  border-radius: 12px; display: flex; align-items: center; justify-content: center;
  margin-bottom: 1.5rem;
}
.step-icon :deep(svg) { width: 20px; height: 20px; }

.step h3 { font-family: 'Syne', sans-serif; font-size: 1.1rem; font-weight: 700; color: #fff; margin-bottom: 0.75rem; }
.step p { font-size: 0.875rem; color: #999; line-height: 1.8; font-weight: 300; }

.features-grid {
  display: grid; grid-template-columns: repeat(2, 1fr);
  gap: 1px; background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,255,255,0.05); border-radius: 20px; overflow: hidden;
}

.feature { background: #111; padding: 3rem; transition: background 0.3s, opacity 0.6s cubic-bezier(0.23,1,0.32,1), transform 0.6s cubic-bezier(0.23,1,0.32,1); position: relative; overflow: hidden; opacity: 0; transform: translateY(24px); }
.feature:hover { background: #1a1a1a; }

.feature-icon {
  width: 48px; height: 48px; background: #242424;
  border: 1px solid rgba(255,255,255,0.06); border-radius: 14px;
  display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;
}
.feature-icon :deep(svg) { width: 22px; height: 22px; }

.feature h3 { font-family: 'Syne', sans-serif; font-size: 1.05rem; font-weight: 700; color: #fff; margin-bottom: 0.6rem; }
.feature p { font-size: 0.875rem; color: #999; line-height: 1.8; font-weight: 300; }

.pricing-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-top: 4rem; }

.pricing-card {
  background: #111; border: 1px solid rgba(255,255,255,0.06);
  border-radius: 20px; padding: 2.5rem 2rem; position: relative;
  opacity: 0; transform: translateY(24px);
  transition: border-color 0.3s, transform 0.6s cubic-bezier(0.23,1,0.32,1), opacity 0.6s cubic-bezier(0.23,1,0.32,1);
}
.pricing-card:hover { transform: translateY(-4px); border-color: rgba(255,255,255,0.12); }
.pricing-card.featured { border-color: rgba(29,185,84,0.4); background: linear-gradient(135deg, rgba(29,185,84,0.06) 0%, #111 60%); }
.pricing-card.featured:hover { border-color: #1DB954; }

.featured-badge {
  position: absolute; top: -12px; left: 50%; transform: translateX(-50%);
  background: #1DB954; color: #000;
  font-family: 'Syne', sans-serif; font-size: 0.65rem; font-weight: 700;
  padding: 0.3rem 1rem; border-radius: 50px; letter-spacing: 0.1em;
  text-transform: uppercase; white-space: nowrap;
}

.pricing-tier { font-size: 0.72rem; font-weight: 600; letter-spacing: 0.15em; text-transform: uppercase; color: #666; margin-bottom: 1.5rem; }
.pricing-amount { display: flex; align-items: baseline; gap: 0.2rem; margin-bottom: 0.5rem; }
.pricing-currency { font-family: 'Syne', sans-serif; font-size: 1.2rem; font-weight: 700; color: #999; }
.pricing-price { font-family: 'Syne', sans-serif; font-size: 3rem; font-weight: 800; color: #fff; letter-spacing: -2px; line-height: 1; }
.pricing-per { font-size: 0.8rem; color: #666; }
.pricing-desc { font-size: 0.82rem; color: #999; margin: 0.75rem 0 2rem; line-height: 1.6; }

.pricing-features { list-style: none; margin-bottom: 2.5rem; }
.pricing-features li {
  display: flex; align-items: center; gap: 0.6rem;
  font-size: 0.82rem; color: #999;
  padding: 0.4rem 0; border-bottom: 1px solid rgba(255,255,255,0.03);
}
.pricing-features li::before {
  content: '✓'; color: #1DB954; font-weight: 700; font-size: 0.75rem;
  width: 16px; height: 16px; display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}

.pricing-btn {
  width: 100%; padding: 0.85rem; border-radius: 50px;
  font-family: 'Syne', sans-serif; font-size: 0.85rem; font-weight: 700;
  cursor: pointer; transition: all 0.2s; text-align: center;
  text-decoration: none; display: block; letter-spacing: 0.03em;
}
.pricing-btn-outline { background: transparent; border: 1px solid rgba(255,255,255,0.12); color: #fff; }
.pricing-btn-outline:hover { border-color: rgba(255,255,255,0.3); background: rgba(255,255,255,0.04); }
.pricing-btn-solid { background: #1DB954; border: none; color: #000; }
.pricing-btn-solid:hover { background: #1ed760; transform: translateY(-1px); }

.cta-strip {
  margin: 0 4rem 8rem; background: #111;
  border: 1px solid rgba(255,255,255,0.03); border-radius: 24px;
  padding: 5rem 4rem; text-align: center; position: relative; overflow: hidden;
}
.cta-strip::before {
  content: ''; position: absolute; top: -1px; left: 20%; right: 20%; height: 1px;
  background: linear-gradient(90deg, transparent, #1DB954, transparent);
}
.cta-strip h2 { font-family: 'Syne', sans-serif; font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; letter-spacing: -1px; color: #fff; margin-bottom: 1rem; }
.cta-strip p { font-size: 0.95rem; color: #999; margin-bottom: 2.5rem; font-weight: 300; }

footer {
  border-top: 1px solid rgba(255,255,255,0.05);
  padding: 3rem 4rem;
  display: flex; align-items: center; justify-content: space-between;
}

.footer-logo { display: flex; align-items: center; gap: 0.6rem; text-decoration: none; }
.footer-logo span { font-family: 'Syne', sans-serif; font-size: 1rem; font-weight: 700; color: #fff; }
.footer-copy { font-size: 0.78rem; color: #666; }
.footer-links { display: flex; gap: 2rem; list-style: none; }
.footer-links a { font-size: 0.78rem; color: #666; text-decoration: none; transition: color 0.2s; }
.footer-links a:hover { color: #fff; }

/* MOBILE */
@media (max-width: 1024px) {
  /* Hide cursor on touch devices */
  .cursor, .cursor-ring { display: none !important; }

  nav {
    padding: 1rem 1.25rem;
    flex-wrap: nowrap;
  }

  /* Hide all nav links except Start Sending on mobile */
  .nav-links li { display: none; }
  .nav-links li:last-child { display: block; }

  .nav-cta {
    padding: 0.45rem 0.9rem !important;
    font-size: 0.75rem !important;
    white-space: nowrap;
  }

  .hero { padding: 5rem 1.25rem 3rem; min-height: auto; }
  .hero h1 { font-size: clamp(2.5rem, 10vw, 4rem); letter-spacing: -2px; }
  .hero-sub { font-size: 0.9rem; padding: 0 0.5rem; }
  .hero-actions { flex-direction: column; width: 100%; gap: 0.75rem; }
  .btn-primary { width: 100%; justify-content: center; padding: 0.9rem 1.5rem; }
  .btn-ghost { width: 100%; justify-content: center; }
  .hero-scroll { display: none; }

  .marquee-wrap { display: none; }

  .stats-bar {
    grid-template-columns: repeat(2, 1fr);
    padding: 1.25rem; gap: 0;
  }
  .stat-item {
    border-right: none;
    border-bottom: 1px solid rgba(255,255,255,0.05);
    padding: 0.85rem;
  }
  .stat-item:nth-child(odd) { border-right: 1px solid rgba(255,255,255,0.05); }
  .stat-item:nth-last-child(-n+2) { border-bottom: none; }
  .stat-number { font-size: 1.8rem; }

  .section { padding: 3.5rem 1.25rem; }
  .section h2 { font-size: clamp(1.7rem, 7vw, 2.5rem); letter-spacing: -0.5px; }
  .section-sub { font-size: 0.875rem; }

  .steps { grid-template-columns: 1fr; border-radius: 14px; }
  .step { padding: 2rem 1.5rem; }

  .features-grid { grid-template-columns: 1fr; border-radius: 14px; }
  .feature { padding: 2rem 1.5rem; }

  .pricing-grid { grid-template-columns: 1fr; gap: 1rem; }
  .pricing-card { padding: 2rem 1.5rem; }

  .cta-strip { margin: 0 1.25rem 4rem; padding: 2.5rem 1.5rem; }
  .cta-strip h2 { font-size: clamp(1.5rem, 7vw, 2.5rem); }
  .cta-strip p { font-size: 0.875rem; }

  footer {
    flex-direction: column; gap: 1.25rem;
    padding: 2rem 1.25rem; text-align: center;
  }
  .footer-links { flex-wrap: wrap; justify-content: center; gap: 1rem; }
}

/* iPad */
@media (min-width: 769px) and (max-width: 1024px) {
  nav { padding: 1.25rem 2rem; }
  .nav-links { gap: 1.5rem; }

  .hero { padding: 6rem 2rem 4rem; }
  .hero h1 { font-size: clamp(3rem, 8vw, 5rem); }

  .stats-bar { padding: 1.5rem 2rem; }

  .section { padding: 5rem 2rem; }

  .steps { grid-template-columns: 1fr; }
  .features-grid { grid-template-columns: 1fr 1fr; }
  .pricing-grid { grid-template-columns: 1fr; gap: 1rem; }

  .cta-strip { margin: 0 2rem 5rem; }

  footer { padding: 2rem; }
}

@media (max-width: 430px) {
  nav { padding: 0.85rem 1rem; }
  .nav-logo span { font-size: 0.9rem; }
  .hero h1 { font-size: clamp(2.2rem, 11vw, 3rem); }
  .hero-badge { font-size: 0.65rem; padding: 0.35rem 0.85rem; }
  .stat-number { font-size: 1.6rem; }
}
</style>