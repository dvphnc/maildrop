<template>
  <div class="wrapper">
    <!-- Background glow -->
    <div class="bg-glow"></div>

    <div class="container">

      <!-- Logo -->
      <div class="logo-area">
        <div class="logo-icon">
          <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M20 4H4C2.9 4 2 4.9 2 6v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
          </svg>
        </div>
        <h1>MailDrop</h1>
        <p>Send a message with a file attached</p>
      </div>

      <!-- Card -->
      <div class="card">

        <!-- Success -->
        <div v-if="$page.props.flash?.success" class="alert-success">
          <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
          </svg>
          {{ $page.props.flash.success }}
        </div>

        <!-- Error -->
        <div v-if="$page.props.flash?.error" class="alert-error">
          {{ $page.props.flash.error }}
        </div>

        <!-- Validation errors -->
        <div v-if="Object.keys(errors).length" class="alert-error">
          <ul>
            <li v-for="error in errors" :key="error">{{ error }}</li>
          </ul>
        </div>

        <!-- Form -->
        <form @submit.prevent="openModal">

          <div class="field">
            <label for="name">Your Name</label>
            <input v-model="form.name" type="text" id="name" placeholder="e.g. Juan dela Cruz" required />
          </div>

          <div class="field">
            <label for="email">Recipient Email</label>
            <input v-model="form.email" type="email" id="email" placeholder="someone@example.com" required />
          </div>

          <div class="field">
            <label>Attachment</label>
            <label class="file-label" for="file">
              <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
              </svg>
              <span>{{ fileName || 'Choose a file to attach' }}</span>
            </label>
            <input type="file" id="file" ref="fileInput" @change="handleFile" />
            <p class="file-name">{{ fileName }}</p>
          </div>

          <div class="field">
            <label for="message">Message</label>
            <textarea v-model="form.message" id="message" placeholder="Write something meaningful..." required></textarea>
          </div>

          <button type="submit" class="btn">Send Email</button>
        </form>
      </div>

      <p class="footer-note">Powered by Laravel &amp; Gmail SMTP</p>
    </div>

    <!-- PayPal Modal -->
    <div class="modal-overlay" :class="{ active: showModal }" @click.self="showModal = false">
      <div class="modal">
        <button class="modal-close" @click="showModal = false">✕</button>

        <div class="sandbox-badge">Sandbox Mode</div>
        <div class="modal-title">Complete Payment</div>
        <div class="modal-sub">Pay via PayPal to send your email.</div>

        <form method="POST" action="/paypal/pay" enctype="multipart/form-data" ref="paypalForm">
          <input type="hidden" name="_token" :value="csrf" />
          <input type="hidden" name="name" :value="form.name" />
          <input type="hidden" name="email" :value="form.email" />
          <input type="hidden" name="message" :value="form.message" />
          <input type="file" name="file" ref="paypalFile" style="display:none" />

          <label class="input-label">Amount (USD)</label>
          <div class="amount-wrap">
            <span class="amount-prefix">$</span>
            <input type="number" name="amount" v-model="amount" min="1" step="0.01" required />
          </div>

          <div class="preset-btns">
            <button type="button" class="preset-btn" @click="amount = 5">$5</button>
            <button type="button" class="preset-btn" @click="amount = 10">$10</button>
            <button type="button" class="preset-btn" @click="amount = 25">$25</button>
            <button type="button" class="preset-btn" @click="amount = 50">$50</button>
          </div>

          <button type="button" class="paypal-btn" @click="submitPaypal">
            <svg viewBox="0 0 24 24" fill="#003087" xmlns="http://www.w3.org/2000/svg">
              <path d="M7.076 21.337H2.47a.641.641 0 0 1-.633-.74L4.944.901C5.026.382 5.474 0 5.998 0h7.46c2.57 0 4.578.543 5.69 1.81 1.01 1.15 1.304 2.42 1.012 4.287-.023.143-.047.288-.077.437-.983 5.05-4.349 6.797-8.647 6.797h-2.19c-.524 0-.968.382-1.05.9l-1.12 7.106zm14.146-14.42a3.35 3.35 0 0 0-.607-.541c-.013.076-.026.175-.041.254-.93 4.778-4.005 7.201-9.138 7.201h-2.19a.563.563 0 0 0-.556.479l-1.187 7.527h-.506l-.24 1.516a.56.56 0 0 0 .554.647h3.882c.46 0 .85-.334.922-.788.06-.26.76-4.852.816-5.09a.932.932 0 0 1 .923-.788h.58c3.76 0 6.705-1.528 7.565-5.946.36-1.847.174-3.388-.777-4.471z"/>
            </svg>
            Pay with PayPal
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({ errors: Object, flash: Object })

const form = ref({ name: '', email: '', message: '' })
const amount = ref(10)
const fileName = ref('')
const showModal = ref(false)
const fileInput = ref(null)
const paypalForm = ref(null)
const paypalFile = ref(null)
const csrf = document.querySelector('meta[name="csrf-token"]')?.content

function handleFile(e) {
  const file = e.target.files[0]
  fileName.value = file ? file.name : ''
}

function openModal() {
  showModal.value = true
}

function submitPaypal() {
  // Move file into paypal form
  const file = fileInput.value?.files[0]
  if (file && paypalFile.value) {
    const dt = new DataTransfer()
    dt.items.add(file)
    paypalFile.value.files = dt.files
  }
  paypalForm.value.submit()
}
</script>

<style scoped>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

.wrapper {
  background-color: #121212;
  color: #fff;
  font-family: 'DM Sans', sans-serif;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 2rem 1rem;
  position: relative;
}

.bg-glow {
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

.logo-area { text-align: center; margin-bottom: 2.5rem; }

.logo-icon {
  width: 56px; height: 56px;
  background: #1DB954;
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 1rem;
}

.logo-icon svg { width: 28px; height: 28px; fill: #000; }
.logo-area h1 { font-size: 1.75rem; font-weight: 700; letter-spacing: -0.5px; }
.logo-area p { font-size: 0.9rem; color: #A7A7A7; margin-top: 0.35rem; font-weight: 300; }

.card {
  background: #181818;
  border-radius: 16px;
  padding: 2rem;
  border: 1px solid rgba(255,255,255,0.06);
}

.alert-success {
  background: rgba(29,185,84,0.12);
  border: 1px solid rgba(29,185,84,0.3);
  color: #1DB954;
  border-radius: 8px;
  padding: 0.85rem 1rem;
  font-size: 0.875rem;
  margin-bottom: 1.5rem;
  display: flex; align-items: center; gap: 0.5rem;
}

.alert-error {
  background: rgba(255,80,80,0.1);
  border: 1px solid rgba(255,80,80,0.25);
  color: #ff6b6b;
  border-radius: 8px;
  padding: 0.85rem 1rem;
  font-size: 0.875rem;
  margin-bottom: 1.5rem;
}

.alert-error ul { padding-left: 1.25rem; }

.field { margin-bottom: 1.25rem; }

label {
  display: block;
  font-size: 0.78rem;
  font-weight: 600;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  color: #A7A7A7;
  margin-bottom: 0.45rem;
}

input[type="text"], input[type="email"], textarea {
  width: 100%;
  background: #282828;
  border: 1px solid rgba(255,255,255,0.08);
  border-radius: 8px;
  color: #fff;
  font-family: 'DM Sans', sans-serif;
  font-size: 0.95rem;
  padding: 0.75rem 1rem;
  outline: none;
  transition: border-color 0.2s, background 0.2s;
}

input[type="text"]:focus, input[type="email"]:focus, textarea:focus {
  border-color: #1DB954;
  background: #333;
}

textarea { resize: none; min-height: 110px; line-height: 1.6; }

.file-label {
  display: flex; align-items: center; gap: 0.6rem;
  background: #282828;
  border: 1px dashed rgba(255,255,255,0.15);
  border-radius: 8px;
  padding: 0.75rem 1rem;
  cursor: pointer;
  font-size: 0.875rem;
  color: #A7A7A7;
  transition: border-color 0.2s;
}

.file-label:hover { border-color: #1DB954; color: #fff; }
input[type="file"] { display: none; }
.file-name { font-size: 0.8rem; color: #1DB954; margin-top: 0.4rem; min-height: 1.1rem; }

.btn {
  width: 100%; margin-top: 0.75rem;
  background: #1DB954; color: #000;
  font-family: 'DM Sans', sans-serif;
  font-size: 0.95rem; font-weight: 700;
  padding: 0.9rem; border: none;
  border-radius: 50px; cursor: pointer;
  transition: background 0.2s, transform 0.1s;
}
.btn:hover { background: #1ed760; }
.btn:active { transform: scale(0.98); }

.footer-note { text-align: center; margin-top: 1.5rem; font-size: 0.78rem; color: rgba(167,167,167,0.4); }

/* MODAL */
.modal-overlay {
  display: none;
  position: fixed; inset: 0;
  background: rgba(0,0,0,0.75);
  backdrop-filter: blur(4px);
  z-index: 100;
  align-items: center; justify-content: center;
  padding: 1rem;
}
.modal-overlay.active { display: flex; }

.modal {
  background: #181818;
  border: 1px solid rgba(255,255,255,0.08);
  border-radius: 20px;
  padding: 2rem;
  width: 100%; max-width: 400px;
  position: relative;
  animation: slideUp 0.25s ease;
}

@keyframes slideUp {
  from { opacity: 0; transform: translateY(20px); }
  to   { opacity: 1; transform: translateY(0); }
}

.modal-close {
  position: absolute; top: 1rem; right: 1rem;
  background: #282828; border: none; color: #A7A7A7;
  width: 32px; height: 32px; border-radius: 50%;
  cursor: pointer; font-size: 1.1rem;
  display: flex; align-items: center; justify-content: center;
  transition: background 0.2s, color 0.2s;
}
.modal-close:hover { background: #333; color: #fff; }

.sandbox-badge {
  display: inline-flex; align-items: center; gap: 0.35rem;
  background: rgba(255,196,57,0.1);
  border: 1px solid rgba(255,196,57,0.3);
  color: #FFC439; border-radius: 50px;
  padding: 0.25rem 0.65rem;
  font-size: 0.7rem; font-weight: 600;
  letter-spacing: 0.05em; text-transform: uppercase;
  margin-bottom: 1.25rem;
}

.modal-title { font-size: 1.1rem; font-weight: 700; margin-bottom: 0.3rem; }
.modal-sub { font-size: 0.82rem; color: #A7A7A7; margin-bottom: 1.5rem; }

.input-label {
  display: block; font-size: 0.78rem; font-weight: 600;
  letter-spacing: 0.08em; text-transform: uppercase;
  color: #A7A7A7; margin-bottom: 0.45rem;
}

.amount-wrap {
  display: flex; align-items: center;
  background: #282828;
  border: 1px solid rgba(255,255,255,0.08);
  border-radius: 8px; overflow: hidden;
  margin-bottom: 0.6rem;
  transition: border-color 0.2s;
}
.amount-wrap:focus-within { border-color: #1DB954; }
.amount-prefix { padding: 0 0.75rem; color: #A7A7A7; font-size: 1rem; border-right: 1px solid rgba(255,255,255,0.08); }

input[type="number"] {
  flex: 1; background: transparent; border: none;
  color: #fff; font-family: 'DM Sans', sans-serif;
  font-size: 0.95rem; padding: 0.75rem 1rem; outline: none;
}

.preset-btns { display: flex; gap: 0.4rem; margin-bottom: 1.5rem; }
.preset-btn {
  flex: 1; background: #282828;
  border: 1px solid rgba(255,255,255,0.08);
  border-radius: 50px; color: #A7A7A7;
  font-family: 'DM Sans', sans-serif;
  font-size: 0.78rem; font-weight: 600;
  padding: 0.4rem 0; cursor: pointer;
  transition: all 0.2s;
}
.preset-btn:hover { border-color: #1DB954; color: #1DB954; }

.paypal-btn {
  width: 100%; background: #FFC439; color: #003087;
  font-family: 'DM Sans', sans-serif;
  font-size: 0.95rem; font-weight: 700;
  padding: 0.85rem; border: none; border-radius: 50px;
  cursor: pointer; display: flex; align-items: center;
  justify-content: center; gap: 0.5rem;
  transition: background 0.2s, transform 0.1s;
}
.paypal-btn:hover { background: #f0b429; }
.paypal-btn:active { transform: scale(0.98); }
.paypal-btn svg { width: 18px; height: 18px; }
</style>