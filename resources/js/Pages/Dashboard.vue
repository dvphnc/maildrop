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
      <div class="nav-right">
        <a href="/send-email" class="nav-cta">
          <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
          Send Email
        </a>
      </div>
    </nav>

    <main class="main">

      <!-- HEADER -->
      <div class="page-header">
        <div>
          <div class="page-tag">Dashboard</div>
          <h1>Email <em>History</em></h1>
          <p>All emails sent through MailDrop, tracked in one place.</p>
        </div>
      </div>

      <!-- STATS -->
      <div class="stats-row">
        <div class="stat-card">
          <div class="stat-icon">
            <svg width="20" height="20" fill="none" stroke="#1DB954" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
          </div>
          <div class="stat-info">
            <div class="stat-number">{{ total }}</div>
            <div class="stat-label">Emails Sent</div>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon">
            <svg width="20" height="20" fill="none" stroke="#1DB954" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          </div>
          <div class="stat-info">
            <div class="stat-number">${{ Number(spent).toFixed(2) }}</div>
            <div class="stat-label">Total Spent</div>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon">
            <svg width="20" height="20" fill="none" stroke="#1DB954" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          </div>
          <div class="stat-info">
            <div class="stat-number">{{ total > 0 ? '100%' : '0%' }}</div>
            <div class="stat-label">Delivery Rate</div>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon">
            <svg width="20" height="20" fill="none" stroke="#1DB954" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
          </div>
          <div class="stat-info">
            <div class="stat-number">{{ logs.filter(l => l.attachment).length }}</div>
            <div class="stat-label">With Attachments</div>
          </div>
        </div>
      </div>

      <!-- TABLE -->
      <div class="table-card">
        <div class="table-header">
          <h2>Sent Emails</h2>
          <div class="search-wrap">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/></svg>
            <input v-model="search" type="text" placeholder="Search by name or email..." />
          </div>
        </div>

        <!-- Empty state -->
        <div v-if="filtered.length === 0" class="empty-state">
          <div class="empty-icon">
            <svg width="32" height="32" fill="none" stroke="#333" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
          </div>
          <p>{{ search ? 'No results found.' : 'No emails sent yet.' }}</p>
          <a v-if="!search" href="/send-email" class="btn-primary" style="margin-top:1rem;">Send your first email</a>
        </div>

        <!-- Table -->
        <div v-else class="table-wrap">
          <table>
            <thead>
              <tr>
                <th>#</th>
                <th>Sender</th>
                <th>Recipient</th>
                <th>Message</th>
                <th>Attachment</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(log, i) in filtered" :key="log.id" class="table-row">
                <td class="td-num">{{ i + 1 }}</td>
                <td class="td-name">{{ log.sender_name }}</td>
                <td class="td-email">{{ log.recipient_email }}</td>
                <td class="td-msg">
                  <span class="msg-preview">{{ log.message.slice(0, 40) }}{{ log.message.length > 40 ? '...' : '' }}</span>
                </td>
                <td>
                  <span v-if="log.attachment" class="attachment-badge">
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                    {{ log.attachment.slice(0, 15) }}{{ log.attachment.length > 15 ? '...' : '' }}
                  </span>
                  <span v-else class="no-attachment">—</span>
                </td>
                <td class="td-amount">${{ Number(log.amount).toFixed(2) }}</td>
                <td>
                  <span class="status-badge" :class="log.status">
                    <span class="status-dot"></span>
                    {{ log.status }}
                  </span>
                </td>
                <td class="td-date">{{ log.created_at }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

    </main>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
  logs: Array,
  total: Number,
  spent: Number,
})

const search = ref('')

const filtered = computed(() => {
  if (!search.value) return props.logs
  const q = search.value.toLowerCase()
  return props.logs.filter(l =>
    l.sender_name.toLowerCase().includes(q) ||
    l.recipient_email.toLowerCase().includes(q)
  )
})
</script>

<style scoped>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

.wrapper {
  background: #0a0a0a; color: #fff;
  font-family: 'DM Sans', sans-serif;
  min-height: 100vh;
}

.bg-glow {
  position: fixed; top: 0; left: 0;
  width: 100%; height: 40vh;
  background: radial-gradient(ellipse at 20% 0%, rgba(29,185,84,0.08) 0%, transparent 65%);
  pointer-events: none; z-index: 0;
}

nav {
  position: fixed; top: 0; left: 0; right: 0; z-index: 100;
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

.nav-cta {
  display: inline-flex; align-items: center; gap: 0.4rem;
  background: #1DB954; color: #000;
  font-family: 'Syne', sans-serif; font-size: 0.8rem; font-weight: 700;
  padding: 0.5rem 1.1rem; border-radius: 50px; text-decoration: none;
  transition: background 0.2s; letter-spacing: 0.02em;
}
.nav-cta:hover { background: #1ed760; }

.main {
  max-width: 1200px; margin: 0 auto;
  padding: 6rem 3rem 4rem;
  position: relative; z-index: 1;
}

.page-header {
  display: flex; align-items: flex-end; justify-content: space-between;
  margin-bottom: 2.5rem;
}

.page-tag {
  font-size: 0.7rem; font-weight: 600;
  letter-spacing: 0.15em; text-transform: uppercase;
  color: #1DB954; margin-bottom: 0.5rem;
  display: flex; align-items: center; gap: 0.5rem;
}
.page-tag::before { content: ''; width: 20px; height: 1px; background: #1DB954; }

h1 {
  font-family: 'Syne', sans-serif;
  font-size: 2.2rem; font-weight: 800;
  letter-spacing: -1px; margin-bottom: 0.4rem;
}
h1 em { font-style: normal; color: #1DB954; }

.page-header p { font-size: 0.85rem; color: #444; font-weight: 300; }

/* STATS */
.stats-row {
  display: grid; grid-template-columns: repeat(4, 1fr);
  gap: 1rem; margin-bottom: 2rem;
}

.stat-card {
  background: #111; border: 1px solid rgba(255,255,255,0.05);
  border-radius: 16px; padding: 1.25rem 1.5rem;
  display: flex; align-items: center; gap: 1rem;
  transition: border-color 0.2s;
}
.stat-card:hover { border-color: rgba(29,185,84,0.2); }

.stat-icon {
  width: 44px; height: 44px;
  background: rgba(29,185,84,0.08); border-radius: 12px;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}

.stat-number {
  font-family: 'Syne', sans-serif;
  font-size: 1.5rem; font-weight: 800;
  color: #fff; letter-spacing: -0.5px; line-height: 1;
}

.stat-label { font-size: 0.72rem; color: #444; margin-top: 0.25rem; text-transform: uppercase; letter-spacing: 0.08em; }

/* TABLE CARD */
.table-card {
  background: #111; border: 1px solid rgba(255,255,255,0.05);
  border-radius: 20px; overflow: hidden;
}

.table-header {
  display: flex; align-items: center; justify-content: space-between;
  padding: 1.5rem 2rem;
  border-bottom: 1px solid rgba(255,255,255,0.05);
}

.table-header h2 {
  font-family: 'Syne', sans-serif; font-size: 1rem; font-weight: 700;
}

.search-wrap {
  display: flex; align-items: center; gap: 0.6rem;
  background: #161616; border: 1px solid rgba(255,255,255,0.06);
  border-radius: 8px; padding: 0.5rem 0.85rem;
  color: #444; transition: border-color 0.2s;
}
.search-wrap:focus-within { border-color: rgba(29,185,84,0.3); }
.search-wrap input {
  background: transparent; border: none; outline: none;
  color: #fff; font-family: 'DM Sans', sans-serif;
  font-size: 0.82rem; width: 200px;
}
.search-wrap input::placeholder { color: #333; }

/* EMPTY STATE */
.empty-state {
  padding: 5rem 2rem; text-align: center;
  display: flex; flex-direction: column; align-items: center;
}
.empty-icon {
  width: 64px; height: 64px; background: #161616;
  border-radius: 16px; display: flex; align-items: center;
  justify-content: center; margin-bottom: 1rem;
}
.empty-state p { font-size: 0.875rem; color: #444; }

.btn-primary {
  background: #1DB954; color: #000;
  font-family: 'Syne', sans-serif; font-size: 0.85rem; font-weight: 700;
  padding: 0.75rem 1.75rem; border-radius: 50px;
  text-decoration: none; display: inline-flex; align-items: center;
  transition: background 0.2s;
}
.btn-primary:hover { background: #1ed760; }

/* TABLE */
.table-wrap { overflow-x: auto; }

table { width: 100%; border-collapse: collapse; }

thead tr {
  border-bottom: 1px solid rgba(255,255,255,0.05);
}

th {
  padding: 0.85rem 1.25rem;
  font-size: 0.68rem; font-weight: 600;
  letter-spacing: 0.1em; text-transform: uppercase;
  color: #333; text-align: left; white-space: nowrap;
}

.table-row {
  border-bottom: 1px solid rgba(255,255,255,0.03);
  transition: background 0.2s;
}
.table-row:last-child { border-bottom: none; }
.table-row:hover { background: rgba(255,255,255,0.02); }

td { padding: 1rem 1.25rem; font-size: 0.82rem; vertical-align: middle; }

.td-num { color: #333; font-size: 0.75rem; }
.td-name { color: #fff; font-weight: 500; }
.td-email { color: #666; }
.td-amount { color: #1DB954; font-weight: 600; font-family: 'Syne', sans-serif; }
.td-date { color: #333; font-size: 0.75rem; white-space: nowrap; }

.msg-preview { color: #555; }

.attachment-badge {
  display: inline-flex; align-items: center; gap: 0.3rem;
  background: rgba(29,185,84,0.08); border: 1px solid rgba(29,185,84,0.15);
  color: #1DB954; border-radius: 6px; padding: 0.2rem 0.5rem;
  font-size: 0.72rem;
}

.no-attachment { color: #222; }

.status-badge {
  display: inline-flex; align-items: center; gap: 0.35rem;
  border-radius: 50px; padding: 0.25rem 0.6rem;
  font-size: 0.72rem; font-weight: 600; text-transform: capitalize;
}

.status-badge.sent {
  background: rgba(29,185,84,0.08);
  border: 1px solid rgba(29,185,84,0.2);
  color: #1DB954;
}

.status-dot {
  width: 5px; height: 5px; border-radius: 50%;
  background: currentColor;
}

/* TABLET - iPad Air */
@media (min-width: 769px) and (max-width: 1024px) {
  nav { padding: 1rem 1.5rem; }
  .main { padding: 5.5rem 1.5rem 3rem; }

  .stats-row { grid-template-columns: repeat(2, 1fr); gap: 0.75rem; }

  .table-header { flex-direction: column; gap: 0.75rem; align-items: flex-start; }
  .search-wrap { width: 100%; }
  .search-wrap input { width: 100%; }

  /* Hide less important columns on iPad */
  th:nth-child(4), td:nth-child(4),
  th:nth-child(5), td:nth-child(5),
  th:nth-child(8), td:nth-child(8) { display: none; }

  .table-wrap { overflow-x: auto; }
  th, td { padding: 0.85rem 1rem; font-size: 0.8rem; }
}

/* MOBILE - iPhone & Samsung */
@media (max-width: 768px) {
  nav { padding: 0.85rem 1rem; }
  .nav-logo span { font-size: 0.9rem; }
  .nav-cta { padding: 0.45rem 0.85rem !important; font-size: 0.75rem !important; }

  .main { padding: 5rem 1rem 3rem; overflow-x: hidden; }

  .page-header { flex-direction: column; gap: 0.75rem; margin-bottom: 1.5rem; }
  h1 { font-size: 1.75rem; letter-spacing: -0.5px; }
  .page-header p { font-size: 0.8rem; }

  .stats-row {
    grid-template-columns: repeat(2, 1fr);
    gap: 0.6rem;
    margin-bottom: 1.25rem;
  }

  .stat-card {
    padding: 0.875rem;
    gap: 0.6rem;
    border-radius: 12px;
  }

  .stat-icon { width: 36px; height: 36px; border-radius: 10px; }
  .stat-icon svg { width: 16px; height: 16px; }
  .stat-number { font-size: 1.2rem; }
  .stat-label { font-size: 0.65rem; }

  .table-card { border-radius: 14px; }

  .table-header {
    flex-direction: column;
    gap: 0.75rem;
    align-items: flex-start;
    padding: 1.25rem 1rem;
  }

  .table-header h2 { font-size: 0.95rem; }

  .search-wrap { width: 100%; box-sizing: border-box; }
  .search-wrap input { width: 100%; min-width: 0; }

  .table-wrap { overflow-x: hidden; width: 100%; }

  table { width: 100%; table-layout: fixed; }

  /* Show only # Sender Amount on mobile */
  th:nth-child(1), td:nth-child(1) { width: 30px; }
  th:nth-child(2), td:nth-child(2) { width: auto; }
  th:nth-child(6), td:nth-child(6) { width: 70px; }

  th:nth-child(3), td:nth-child(3),
  th:nth-child(4), td:nth-child(4),
  th:nth-child(5), td:nth-child(5),
  th:nth-child(7), td:nth-child(7),
  th:nth-child(8), td:nth-child(8) { display: none; }

  th, td { padding: 0.75rem 0.75rem; font-size: 0.78rem; }
  .td-name { font-size: 0.82rem; }
  .td-amount { font-size: 0.82rem; }
}

@media (max-width: 430px) {
  .main { padding: 4.5rem 0.875rem 3rem; }
  .stat-card { padding: 0.75rem; }
  .stat-number { font-size: 1.1rem; }
  h1 { font-size: 1.5rem; }
}
</style>