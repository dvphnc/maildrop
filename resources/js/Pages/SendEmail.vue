<template>
  <div class="wrapper">
    <div class="bg-glow"></div>

    <!-- TOP NAV -->
    <nav>
  <a href="/" class="nav-logo">
    <div class="logo-dot">
      <svg viewBox="0 0 24 24"><path d="M20 4H4C2.9 4 2 4.9 2 6v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
    </div>
    <span>MailDrop</span>
  </a>
  <div style="display:flex; gap:1.5rem; align-items:center;">
    <a href="/dashboard" class="nav-back">Dashboard</a>
    <a href="/" class="nav-back">← Back to home</a>
  </div>
</nav>

    <!-- SPLIT LAYOUT -->
    <main class="split">

      <!-- LEFT: FORM -->
      <div class="form-side">
        <div class="form-header">
          <h1>Send a <em>MailDrop</em></h1>
          <p>Fill in the details, preview your email live, then pay to send.</p>
        </div>

        <div class="form-card">

          <!-- Validation errors -->
          <div v-if="errors && Object.keys(errors).length" class="alert-error">
            <ul><li v-for="error in errors" :key="error">{{ error }}</li></ul>
          </div>

          <div class="field">
            <label>Your Name</label>
            <input v-model="form.name" type="text" placeholder="e.g. Juan dela Cruz" required />
          </div>

          <div class="field">
            <label>Recipient Email</label>
            <input v-model="form.email" type="email" placeholder="someone@example.com" required />
          </div>

          <div class="field">
            <label>Attachment <span class="optional">optional</span></label>
            <div
              class="dropzone"
              :class="{ 'dropzone-active': isDragging, 'dropzone-has-file': fileName }"
              @dragenter.prevent="isDragging = true"
              @dragleave.prevent="isDragging = false"
              @dragover.prevent
              @drop.prevent="handleDrop"
              @click="fileInput.click()"
            >
              <input type="file" ref="fileInput" @change="handleFile" style="display:none" />
              <div v-if="!fileName" class="dropzone-empty">
                <div class="dropzone-icon">
                  <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 16v-8m0 0l-3 3m3-3l3 3M4 16.5A3.5 3.5 0 007.5 20h9a3.5 3.5 0 000-7h-.5A5 5 0 006 9.5a5 5 0 00-2 9z"/>
                  </svg>
                </div>
                <p class="dropzone-text">Drop file or <span>browse</span></p>
                <p class="dropzone-sub">Max 5MB</p>
              </div>
              <div v-else class="dropzone-file">
                <div class="dropzone-file-icon">
                  <svg width="18" height="18" fill="none" stroke="#1DB954" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                  </svg>
                </div>
                <div class="dropzone-file-info">
                  <p class="dropzone-file-name">{{ fileName }}</p>
                  <p class="dropzone-file-size">{{ fileSize }}</p>
                </div>
                <button type="button" class="dropzone-remove" @click.stop="removeFile">✕</button>
              </div>
            </div>
          </div>

          <div class="field">
            <label>Message</label>
            <textarea v-model="form.message" placeholder="Write something meaningful..." required></textarea>
          </div>

          <button type="button" class="btn-send" @click="openPaypal">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
            Send Email
          </button>
        </div>

        <p class="footer-note">Powered by Laravel &amp; Gmail SMTP</p>
      </div>

      <!-- RIGHT: LIVE PREVIEW -->
      <div class="preview-side">
        <div class="preview-sticky">
          <div class="preview-top-label">
            <span class="preview-dot"></span>
            Live Preview
          </div>

          <div class="email-preview">
            <!-- Email Header -->
            <div class="ep-header">
              <div class="ep-logo">
                <svg viewBox="0 0 24 24" style="width:16px;height:16px;fill:#000"><path d="M20 4H4C2.9 4 2 4.9 2 6v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
              </div>
              <span class="ep-new-msg">New Message</span>
              <h3 class="ep-name" :class="{ placeholder: !form.name }">
                {{ form.name || 'Your Name' }}
              </h3>
              <p class="ep-sub">sent you a message</p>
            </div>

            <!-- Email Body -->
            <div class="ep-body">
              <!-- From -->
              <div class="ep-from">
                <span class="ep-from-label">From</span>
                <span class="ep-from-email" :class="{ placeholder: !form.email }">
                  {{ form.email || 'recipient@example.com' }}
                </span>
              </div>

              <!-- Message -->
              <div class="ep-msg-label">Message</div>
              <div class="ep-msg" :class="{ placeholder: !form.message }">
                {{ form.message || 'Your message will appear here as you type...' }}
              </div>

              <!-- Attachment -->
              <transition name="fade">
                <div v-if="fileName" class="ep-attachment">
                  <svg width="13" height="13" fill="none" stroke="#1DB954" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                  </svg>
                  {{ fileName }}
                </div>
              </transition>

              <div class="ep-divider"></div>
              <p class="ep-footer">This email was sent via <strong>MailDrop</strong> — powered by Laravel &amp; Gmail SMTP.</p>
            </div>

            <!-- Email Bottom Bar -->
            <div class="ep-bottom">© {{ new Date().getFullYear() }} MailDrop. All rights reserved.</div>
          </div>

          <!-- Completeness indicator -->
          <div class="completeness">
            <div class="completeness-bar">
              <div class="completeness-fill" :style="{ width: completeness + '%' }"></div>
            </div>
            <span class="completeness-label">{{ completeness }}% complete</span>
          </div>
        </div>
      </div>

    </main>

    <!-- PAYPAL MODAL -->
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
            <svg viewBox="0 0 24 24" fill="#003087"><path d="M7.076 21.337H2.47a.641.641 0 0 1-.633-.74L4.944.901C5.026.382 5.474 0 5.998 0h7.46c2.57 0 4.578.543 5.69 1.81 1.01 1.15 1.304 2.42 1.012 4.287-.023.143-.047.288-.077.437-.983 5.05-4.349 6.797-8.647 6.797h-2.19c-.524 0-.968.382-1.05.9l-1.12 7.106zm14.146-14.42a3.35 3.35 0 0 0-.607-.541c-.013.076-.026.175-.041.254-.93 4.778-4.005 7.201-9.138 7.201h-2.19a.563.563 0 0 0-.556.479l-1.187 7.527h-.506l-.24 1.516a.56.56 0 0 0 .554.647h3.882c.46 0 .85-.334.922-.788.06-.26.76-4.852.816-5.09a.932.932 0 0 1 .923-.788h.58c3.76 0 6.705-1.528 7.565-5.946.36-1.847.174-3.388-.777-4.471z"/></svg>
            Pay with PayPal
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import { useToast } from 'vue-toastification'
import { usePage } from '@inertiajs/vue3'

const props = defineProps({ errors: Object })
const page = usePage()
const toast = useToast()

watch(() => page.props.flash, (flash) => {
  if (flash?.success) toast.success(flash.success)
  if (flash?.error) toast.error(flash.error)
}, { immediate: true, deep: true })

const form = ref({ name: '', email: '', message: '' })
const amount = ref(10)
const fileName = ref('')
const fileSize = ref('')
const isDragging = ref(false)
const showModal = ref(false)
const fileInput = ref(null)
const paypalForm = ref(null)
const paypalFile = ref(null)
const csrf = document.querySelector('meta[name="csrf-token"]')?.content

const completeness = computed(() => {
  let score = 0
  if (form.value.name) score += 34
  if (form.value.email) score += 33
  if (form.value.message) score += 33
  return score
})

function formatSize(bytes) {
  if (bytes < 1024) return bytes + ' B'
  if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB'
  return (bytes / (1024 * 1024)).toFixed(1) + ' MB'
}

function handleFile(e) {
  const file = e.target.files[0]
  if (file) { fileName.value = file.name; fileSize.value = formatSize(file.size) }
}

function handleDrop(e) {
  isDragging.value = false
  const file = e.dataTransfer.files[0]
  if (file) {
    fileName.value = file.name; fileSize.value = formatSize(file.size)
    const dt = new DataTransfer(); dt.items.add(file)
    fileInput.value.files = dt.files
  }
}

function removeFile() {
  fileName.value = ''; fileSize.value = ''
  fileInput.value.value = ''
}

function openPaypal() {
  if (!form.value.name || !form.value.email || !form.value.message) {
    toast.warning('Please fill in all required fields.')
    return
  }
  showModal.value = true
}

function submitPaypal() {
  const file = fileInput.value?.files[0]
  if (file && paypalFile.value) {
    const dt = new DataTransfer(); dt.items.add(file)
    paypalFile.value.files = dt.files
  }
  paypalForm.value.submit()
}
</script>

<style scoped>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

.wrapper {
  background: #0a0a0a;
  color: #fff;
  font-family: 'DM Sans', sans-serif;
  min-height: 100vh;
  position: relative;
}

.bg-glow {
  position: fixed; top: 0; left: 0;
  width: 100%; height: 50vh;
  background: radial-gradient(ellipse at 30% 0%, rgba(29,185,84,0.1) 0%, transparent 65%);
  pointer-events: none; z-index: 0;
}

/* NAV */
nav {
  position: fixed; top: 0; left: 0; right: 0;
  z-index: 100;
  display: flex; align-items: center; justify-content: space-between;
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
.nav-back { font-size: 0.8rem; color: #555; text-decoration: none; transition: color 0.2s; }
.nav-back:hover { color: #1DB954; }

/* SPLIT LAYOUT */
.split {
  display: grid;
  grid-template-columns: 1fr 1fr;
  min-height: 100vh;
  padding-top: 65px;
  position: relative; z-index: 1;
}

/* FORM SIDE */
.form-side {
  padding: 3rem 3rem 3rem 4rem;
  display: flex; flex-direction: column;
  border-right: 1px solid rgba(255,255,255,0.05);
}

.form-header { margin-bottom: 2rem; }
.form-header h1 {
  font-family: 'Syne', sans-serif;
  font-size: 2rem; font-weight: 800;
  letter-spacing: -1px; line-height: 1.1;
  margin-bottom: 0.5rem;
}
.form-header h1 em { font-style: normal; color: #1DB954; }
.form-header p { font-size: 0.85rem; color: #555; font-weight: 300; line-height: 1.6; }

.form-card {
  background: #111;
  border: 1px solid rgba(255,255,255,0.05);
  border-radius: 20px;
  padding: 2rem;
  flex: 1;
}

.alert-error {
  background: rgba(255,80,80,0.1);
  border: 1px solid rgba(255,80,80,0.25);
  color: #ff6b6b; border-radius: 8px;
  padding: 0.85rem 1rem; font-size: 0.875rem;
  margin-bottom: 1.5rem;
}
.alert-error ul { padding-left: 1.25rem; }

.field { margin-bottom: 1.25rem; }

label {
  display: flex; align-items: center; gap: 0.5rem;
  font-size: 0.72rem; font-weight: 600;
  letter-spacing: 0.1em; text-transform: uppercase;
  color: #555; margin-bottom: 0.5rem;
}

.optional {
  font-size: 0.65rem; color: #333;
  text-transform: none; letter-spacing: 0;
  font-weight: 400; background: #1a1a1a;
  padding: 0.1rem 0.4rem; border-radius: 4px;
}

input[type="text"], input[type="email"], textarea {
  width: 100%;
  background: #161616;
  border: 1px solid rgba(255,255,255,0.06);
  border-radius: 10px; color: #fff;
  font-family: 'DM Sans', sans-serif;
  font-size: 0.9rem; padding: 0.8rem 1rem;
  outline: none;
  transition: border-color 0.2s, background 0.2s;
}
input:focus, textarea:focus { border-color: #1DB954; background: #1a1a1a; }
input::placeholder, textarea::placeholder { color: rgba(255,255,255,0.15); }
textarea { resize: none; min-height: 120px; line-height: 1.6; }

/* DROPZONE */
.dropzone {
  background: #161616; border: 2px dashed rgba(255,255,255,0.07);
  border-radius: 10px; padding: 1.25rem;
  cursor: pointer; transition: all 0.25s cubic-bezier(0.23,1,0.32,1);
  display: flex; align-items: center; justify-content: center;
}
.dropzone:hover { border-color: rgba(29,185,84,0.3); background: #1a1a1a; }
.dropzone-active { border-color: #1DB954 !important; background: rgba(29,185,84,0.05) !important; transform: scale(1.01); }
.dropzone-has-file { border-style: solid; border-color: rgba(29,185,84,0.3); background: #141f17; }

.dropzone-empty {
  display: flex; flex-direction: column; align-items: center;
  gap: 0.3rem; width: 100%; text-align: center;
}
.dropzone-icon {
  width: 40px; height: 40px;
  background: rgba(29,185,84,0.1); border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  color: #1DB954; margin-bottom: 0.25rem;
  transition: background 0.2s, transform 0.2s;
}
.dropzone:hover .dropzone-icon { background: rgba(29,185,84,0.18); transform: translateY(-2px); }
.dropzone-text { font-size: 0.82rem; color: #888; }
.dropzone-text span { color: #1DB954; border-bottom: 1px solid rgba(29,185,84,0.3); }
.dropzone-sub { font-size: 0.72rem; color: #444; }

.dropzone-file { display: flex; align-items: center; gap: 0.75rem; width: 100%; }
.dropzone-file-icon {
  width: 36px; height: 36px; background: rgba(29,185,84,0.1);
  border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.dropzone-file-info { flex: 1; min-width: 0; }
.dropzone-file-name { font-size: 0.82rem; color: #fff; font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.dropzone-file-size { font-size: 0.7rem; color: #444; margin-top: 0.1rem; }
.dropzone-remove {
  background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.06);
  color: #444; width: 26px; height: 26px; border-radius: 50%; cursor: pointer;
  display: flex; align-items: center; justify-content: center; font-size: 0.7rem;
  flex-shrink: 0; transition: all 0.2s;
}
.dropzone-remove:hover { background: rgba(255,80,80,0.12); color: #ff6b6b; border-color: rgba(255,80,80,0.2); }

.btn-send {
  width: 100%; margin-top: 0.5rem;
  background: #1DB954; color: #000;
  font-family: 'Syne', sans-serif;
  font-size: 0.95rem; font-weight: 700;
  padding: 0.9rem; border: none; border-radius: 50px;
  cursor: pointer; display: flex; align-items: center;
  justify-content: center; gap: 0.5rem;
  transition: background 0.2s, transform 0.15s;
  letter-spacing: 0.02em;
}
.btn-send:hover { background: #1ed760; transform: translateY(-1px); }
.btn-send:active { transform: scale(0.98); }

.footer-note { text-align: center; margin-top: 1.5rem; font-size: 0.72rem; color: #2a2a2a; }

/* PREVIEW SIDE */
.preview-side {
  padding: 3rem 4rem 3rem 3rem;
  background: #080808;
}

.preview-sticky {
  position: sticky; top: 85px;
}

.preview-top-label {
  display: flex; align-items: center; gap: 0.5rem;
  font-size: 0.72rem; font-weight: 600;
  letter-spacing: 0.12em; text-transform: uppercase;
  color: #333; margin-bottom: 1.25rem;
}

.preview-dot {
  width: 6px; height: 6px; background: #1DB954;
  border-radius: 50%; animation: pulse 2s ease infinite;
}

@keyframes pulse {
  0%, 100% { opacity: 1; transform: scale(1); }
  50% { opacity: 0.4; transform: scale(0.8); }
}

/* EMAIL PREVIEW */
.email-preview {
  background: #111;
  border: 1px solid rgba(255,255,255,0.06);
  border-radius: 16px; overflow: hidden;
  transition: all 0.3s ease;
}

.ep-header {
  background: linear-gradient(135deg, #1a3d2b 0%, #111 80%);
  padding: 2rem 1.5rem;
  text-align: center;
  border-bottom: 1px solid rgba(255,255,255,0.05);
  display: flex; flex-direction: column; align-items: center; gap: 0.35rem;
}

.ep-logo {
  width: 40px; height: 40px; background: #1DB954;
  border-radius: 50%; display: flex; align-items: center;
  justify-content: center; margin-bottom: 0.5rem;
}

.ep-new-msg {
  font-size: 0.62rem; font-weight: 600;
  letter-spacing: 0.15em; text-transform: uppercase; color: #1DB954;
}

.ep-name {
  font-size: 1.1rem; font-weight: 700; color: #fff;
  letter-spacing: -0.3px; transition: all 0.2s;
}

.ep-sub { font-size: 0.75rem; color: #444; }

.ep-body { padding: 1.25rem; }

.ep-from {
  background: #1a1a1a; border-radius: 8px;
  padding: 0.75rem 1rem; margin-bottom: 1rem;
}
.ep-from-label {
  font-size: 0.62rem; font-weight: 600;
  letter-spacing: 0.12em; text-transform: uppercase;
  color: #444; display: block; margin-bottom: 0.2rem;
}
.ep-from-email { font-size: 0.82rem; color: #1DB954; font-weight: 500; transition: all 0.2s; }

.ep-msg-label {
  font-size: 0.62rem; font-weight: 600;
  letter-spacing: 0.12em; text-transform: uppercase;
  color: #444; margin-bottom: 0.5rem;
}

.ep-msg {
  background: #1a1a1a;
  border-left: 3px solid #1DB954;
  border-radius: 0 8px 8px 0;
  padding: 0.85rem 1rem;
  font-size: 0.82rem; color: #ccc;
  line-height: 1.7; margin-bottom: 1rem;
  min-height: 60px; word-break: break-word;
  white-space: pre-wrap; transition: all 0.2s;
}

.ep-attachment {
  display: flex; align-items: center; gap: 0.5rem;
  background: rgba(29,185,84,0.07);
  border: 1px solid rgba(29,185,84,0.15);
  border-radius: 6px; padding: 0.45rem 0.75rem;
  font-size: 0.75rem; color: #1DB954; margin-bottom: 1rem;
}

.ep-divider { border: none; border-top: 1px solid rgba(255,255,255,0.04); margin-bottom: 1rem; }
.ep-footer { font-size: 0.7rem; color: #333; text-align: center; line-height: 1.6; }
.ep-footer strong { color: #1DB954; }

.ep-bottom {
  background: #0d0d0d; padding: 0.75rem;
  text-align: center; font-size: 0.65rem; color: #2a2a2a;
  border-top: 1px solid rgba(255,255,255,0.03);
}

.placeholder { color: #333 !important; font-style: italic; }

/* COMPLETENESS BAR */
.completeness {
  display: flex; align-items: center; gap: 0.75rem;
  margin-top: 1rem;
}
.completeness-bar {
  flex: 1; height: 3px; background: #1a1a1a;
  border-radius: 2px; overflow: hidden;
}
.completeness-fill {
  height: 100%; background: #1DB954;
  border-radius: 2px;
  transition: width 0.4s cubic-bezier(0.23,1,0.32,1);
}
.completeness-label { font-size: 0.7rem; color: #333; white-space: nowrap; }

/* FADE TRANSITION */
.fade-enter-active, .fade-leave-active { transition: opacity 0.3s ease, transform 0.3s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; transform: translateY(-4px); }

/* PAYPAL MODAL */
.modal-overlay {
  display: none; position: fixed; inset: 0;
  background: rgba(0,0,0,0.8); backdrop-filter: blur(6px);
  z-index: 200; align-items: center; justify-content: center; padding: 1rem;
}
.modal-overlay.active { display: flex; }

.modal {
  background: #111; border: 1px solid rgba(255,255,255,0.08);
  border-radius: 20px; padding: 2rem; width: 100%; max-width: 400px;
  position: relative; animation: slideUp 0.25s cubic-bezier(0.23,1,0.32,1);
}

@keyframes slideUp {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

.modal-close {
  position: absolute; top: 1rem; right: 1rem;
  background: #1a1a1a; border: none; color: #555;
  width: 32px; height: 32px; border-radius: 50%;
  cursor: pointer; font-size: 1rem;
  display: flex; align-items: center; justify-content: center;
  transition: background 0.2s, color 0.2s;
}
.modal-close:hover { background: #222; color: #fff; }

.sandbox-badge {
  display: inline-flex; align-items: center; gap: 0.35rem;
  background: rgba(255,196,57,0.08); border: 1px solid rgba(255,196,57,0.25);
  color: #FFC439; border-radius: 50px; padding: 0.25rem 0.65rem;
  font-size: 0.68rem; font-weight: 600; letter-spacing: 0.05em;
  text-transform: uppercase; margin-bottom: 1.25rem;
}

.modal-title { font-size: 1.1rem; font-weight: 700; margin-bottom: 0.3rem; font-family: 'Syne', sans-serif; }
.modal-sub { font-size: 0.82rem; color: #555; margin-bottom: 1.5rem; }

.input-label {
  display: block; font-size: 0.72rem; font-weight: 600;
  letter-spacing: 0.1em; text-transform: uppercase;
  color: #555; margin-bottom: 0.5rem;
}

.amount-wrap {
  display: flex; align-items: center;
  background: #161616; border: 1px solid rgba(255,255,255,0.06);
  border-radius: 10px; overflow: hidden; margin-bottom: 0.6rem;
  transition: border-color 0.2s;
}
.amount-wrap:focus-within { border-color: #1DB954; }
.amount-prefix { padding: 0 0.75rem; color: #444; font-size: 1rem; border-right: 1px solid rgba(255,255,255,0.06); }

input[type="number"] {
  flex: 1; background: transparent; border: none;
  color: #fff; font-family: 'DM Sans', sans-serif;
  font-size: 0.9rem; padding: 0.8rem 1rem; outline: none;
}

.preset-btns { display: flex; gap: 0.4rem; margin-bottom: 1.5rem; }
.preset-btn {
  flex: 1; background: #161616;
  border: 1px solid rgba(255,255,255,0.06);
  border-radius: 50px; color: #555;
  font-family: 'DM Sans', sans-serif;
  font-size: 0.78rem; font-weight: 600;
  padding: 0.4rem 0; cursor: pointer; transition: all 0.2s;
}
.preset-btn:hover { border-color: #1DB954; color: #1DB954; }

.paypal-btn {
  width: 100%; background: #FFC439; color: #003087;
  font-family: 'Syne', sans-serif; font-size: 0.9rem; font-weight: 700;
  padding: 0.85rem; border: none; border-radius: 50px;
  cursor: pointer; display: flex; align-items: center;
  justify-content: center; gap: 0.5rem;
  transition: background 0.2s, transform 0.1s;
}
.paypal-btn:hover { background: #f0b429; }
.paypal-btn:active { transform: scale(0.98); }
.paypal-btn svg { width: 18px; height: 18px; }
</style>