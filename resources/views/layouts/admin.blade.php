<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MAAK CMS') }} - Premium Terminal</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Leaflet Map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary: #ea580c;
            --primary-light: #fff7ed;
            --primary-dark: #c2410c;
            --primary-glow: rgba(234, 88, 12, 0.25);
            --accent: #f59e0b;
            --accent-light: #fffbeb;
            --bg-main: #fafaf9;
            --bg-warm: #fff7ed;
            --bg-glass: rgba(255, 255, 255, 0.88);
            --text-main: #1c1917;
            --text-muted: #78716c;
            --border: rgba(231, 229, 228, 0.9);
            --border-warm: rgba(253, 186, 116, 0.3);
            --shadow-sm: 0 1px 3px 0 rgba(124, 45, 18, 0.06), 0 1px 2px -1px rgba(124, 45, 18, 0.04);
            --shadow: 0 4px 8px -2px rgba(124, 45, 18, 0.1), 0 2px 4px -2px rgba(124, 45, 18, 0.06);
            --shadow-md: 0 12px 20px -4px rgba(124, 45, 18, 0.12), 0 4px 8px -4px rgba(124, 45, 18, 0.08);
            --shadow-orange: 0 8px 20px -4px rgba(234, 88, 12, 0.35);
            --glass-border: 1px solid rgba(255, 255, 255, 0.5);
            --glass-bg: rgba(255, 255, 255, 0.75);

            /* ── Dark mode tokens — Premium Obsidian ── */
            --dm-bg: #05050a;
            --dm-surface: #0a0c16;
            --dm-surface2: #0f1225;
            --dm-surface3: #151933;
            --dm-border: rgba(99, 148, 255, 0.15);
            --dm-border2: rgba(255, 255, 255, 0.03);
            --dm-border3: rgba(99, 148, 255, 0.06);
            --dm-text: #f0f2ff;
            --dm-text2: #c4c9e8;
            --dm-muted: #4a5380;
            --dm-sidebar: #020308;
            --dm-violet: #8b5cf6;
            --dm-violet2: #a78bfa;
            --dm-gold: #f5c542;
            --dm-gold2: #fbbf24;
            --dm-emerald: #10b981;
            --dm-rose: #f43f5e;
            --dm-glow-v: rgba(139, 92, 246, 0.2);
            --dm-glow-g: rgba(245, 197, 66, 0.15);
        }

        /* ══════════════════════════════════════════════
           PREMIUM OBSIDIAN DARK MODE
        ══════════════════════════════════════════════ */


        /* ══════════════════════════════════════════════════════
   MAAK — ULTRA PREMIUM OBSIDIAN DARK MODE
══════════════════════════════════════════════════════ */

/* ── Base ── */
[data-theme="dark"] html {
    min-height: 100%;
    background: #04040c;
}
[data-theme="dark"] body {
    min-height: 100vh;
    background:
        radial-gradient(ellipse 180% 120% at -5% -5%, rgba(99, 60, 255, 0.18) 0%, transparent 55%),
        radial-gradient(ellipse 80%  80% at 105% 110%, rgba(60, 20, 180, 0.07) 0%, transparent 55%),
        #04040c !important;
    color: #e8eaf6 !important;
}
[data-theme="dark"] .main-content {
    background: transparent !important;
    min-height: 100vh;
}

/* ── Sidebar ── */
[data-theme="dark"] .sidebar {
    background: linear-gradient(160deg, #2020557a 0%, #04040e 100%) !important;
    border-right: 1px solid rgba(99, 148, 255, 0.25) !important;
    box-shadow: 10px 0 40px rgba(0,0,0,0.8), 0 0 15px rgba(99, 148, 255, 0.1) !important;
}

[data-theme="dark"] .nav-item {
    color: #ffffff !important;
    font-weight: 600;
    transition: all 0.3s ease;
}

[data-theme="dark"] .nav-item i {
    color: #6394ff !important; /* Blue icons */
    transition: all 0.3s ease;
}

[data-theme="dark"] .nav-item:hover {
    background: rgba(99, 148, 255, 0.08) !important;
    color: #6394ff !important; /* Text changes to blue on hover */
    transform: translateX(5px);
}

[data-theme="dark"] .nav-item:hover i {
    color: #ffffff !important; /* Icon flips to white or bright blue on hover */
    filter: drop-shadow(0 0 8px rgba(99, 148, 255, 0.6));
}

[data-theme="dark"] .nav-item.active {
    background: linear-gradient(90deg, rgba(99, 148, 255, 0.15) 0%, transparent 100%) !important;
    color: #6394ff !important;
   
    box-shadow: inset 4px 0 15px rgba(99, 148, 255, 0.1) !important;
}

[data-theme="dark"] .nav-item.active i {
    color: #6394ff !important;
    filter: drop-shadow(0 0 10px rgba(99, 148, 255, 0.8)) !important;
}

[data-theme="dark"] .sidebar-footer { border-color: rgba(99, 148, 255, 0.1) !important; }
[data-theme="dark"] .user-name-mini { color: #ffffff !important; }
[data-theme="dark"] .user-role-mini { color: #64748b !important; }
[data-theme="dark"] .user-avatar-mini { background: linear-gradient(135deg, #6394ff, #4f46e5) !important; }

/* ── Mobile nav ── */
[data-theme="dark"] .mobile-nav {
    background: rgba(4,4,14,0.97) !important;
    border: 1px solid rgba(99,80,255,0.12) !important;
    box-shadow: 0 -12px 50px rgba(0,0,0,0.8) !important;
}
[data-theme="dark"] .m-nav-item { color: #2e3660 !important; }
[data-theme="dark"] .m-nav-item.active { color: #a594ff !important; }
[data-theme="dark"] .m-nav-item.active i { filter: drop-shadow(0 0 6px rgba(140,100,255,0.6)); }

/* ── Top bar — Jewel Glass ── */
[data-theme="dark"] .top-bar {
    background: rgba(4,4,14,0.65) !important;
    backdrop-filter: blur(32px) saturate(210%) !important;
    -webkit-backdrop-filter: blur(32px) saturate(210%) !important;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
    box-shadow: 0 10px 50px rgba(0,0,0,0.6), inset 0 1px 0 rgba(255,255,255,0.02) !important;
    padding: 0 2.5rem !important;
    height: 80px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
}




[data-theme="dark"] .page-title h1 {
    background: linear-gradient(110deg, #ffffff 0%, #c4c9ff 50%, #8b5cf6 100%) !important;
    -webkit-background-clip: text !important;
    -webkit-text-fill-color: transparent !important;
    font-weight: 800 !important;
    font-size: 1.4rem !important;
    letter-spacing: -0.5px;
}

[data-theme="dark"] .user-menu {
    display: flex !important;
    align-items: center !important;
    gap: 20px !important;
}

/* Profile Pill — Premium */
[data-theme="dark"] .profile-pill {
    display: flex !important;
    align-items: center !important;
    gap: 12px !important;
    background: rgba(255, 255, 255, 0.03) !important;
    padding: 6px 14px 6px 6px !important;
    border-radius: 50px !important;
    border: 1px solid rgba(255, 255, 255, 0.06) !important;
    box-shadow: 0 4px 20px rgba(0,0,0,0.3) !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    cursor: pointer;
}

[data-theme="dark"] .profile-pill:hover {
    background: rgba(255, 255, 255, 0.06) !important;
    border-color: rgba(99, 148, 255, 0.3) !important;
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.5), 0 0 15px rgba(99, 148, 255, 0.1) !important;
}

[data-theme="dark"] .user-avatar-shell {
    position: relative;
}

[data-theme="dark"] .user-avatar-mini {
    width: 38px !important;
    height: 38px !important;
    border-radius: 50% !important;
    background: linear-gradient(135deg, #6394ff, #8b5cf6) !important;
    color: #fff !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-weight: 800 !important;
    font-size: 0.9rem !important;
    box-shadow: 0 0 15px rgba(139, 92, 246, 0.4) !important;
}

[data-theme="dark"] .status-dot-live {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 10px;
    height: 10px;
    background: #10b981;
    border: 2px solid #05050a;
    border-radius: 50%;
    animation: livePulse 2s infinite;
}

@keyframes livePulse {
    0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
    70% { box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
    100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
}

[data-theme="dark"] .user-info-pill {
    display: flex;
    flex-direction: column;
}

[data-theme="dark"] .user-name-pill {
    color: #ffffff !important;
    font-weight: 700 !important;
    font-size: 0.85rem !important;
    line-height: 1.2;
}

[data-theme="dark"] .user-role-pill {
    color: #64748b !important;
    font-size: 0.65rem !important;
    font-weight: 700 !important;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Theme toggle — Refined */
[data-theme="dark"] .theme-toggle {
    width: 40px !important;
    height: 40px !important;
    border-radius: 12px !important;
    background: rgba(255, 255, 255, 0.03) !important;
    border: 1px solid rgba(255, 255, 255, 0.08) !important;
    color: #f5c542 !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    transition: all 0.3s ease !important;
}

[data-theme="dark"] .theme-toggle:hover {
    background: #fbbf24 !important;
    color: #04040c !important;
    box-shadow: 0 0 20px rgba(245, 197, 66, 0.4) !important;
    transform: rotate(15deg) scale(1.1);
}

/* ── Forms ── */
[data-theme="dark"] input,
[data-theme="dark"] select,
[data-theme="dark"] textarea {
    background: rgba(12,12,30,0.8) !important;
    color: #e8eaf6 !important;
    border-color: rgba(99,80,255,0.15) !important;
}
[data-theme="dark"] label { color: #8890c0 !important; }

/* ── Premium Card — Dark ── */
[data-theme="dark"] .card-premium {
    background: rgba(13,13,35,0.7) !important;
    border: 1px solid rgba(255,255,255,0.06) !important;
    box-shadow: 0 10px 40px rgba(0,0,0,0.4), inset 0 1px 0 rgba(255,255,255,0.02) !important;
    color: #e2e8f0 !important;
    backdrop-filter: blur(20px) !important;
}

[data-theme="dark"] h1, [data-theme="dark"] h2, [data-theme="dark"] h3, [data-theme="dark"] h4 {
    color: #ffffff !important;
}

/* ── Stats Grid & Cards ── */
[data-theme="dark"] .stat-card {
    background: rgba(13,13,35,0.7) !important;
    border: 1px solid rgba(255,255,255,0.06) !important;
    box-shadow: 0 4px 20px rgba(0,0,0,0.3) !important;
}

[data-theme="dark"] .stat-info h3 { color: rgba(255,255,255,0.6) !important; font-size: 0.75rem !important; }
[data-theme="dark"] .stat-info p { color: #ffffff !important; font-weight: 800 !important; }

/* ── Inline Background Fixes ── */
[data-theme="dark"] [style*="background: #fff"],
[data-theme="dark"] [style*="background:#fff"],
[data-theme="dark"] [style*="background: #ffffff"],
[data-theme="dark"] [style*="background: white"],
[data-theme="dark"] [style*="background: #f8fafc"],
[data-theme="dark"] [style*="background:#f8fafc"],
[data-theme="dark"] [style*="background: #f1f5f9"] {
    background: rgba(255,255,255,0.03) !important;
    border-color: rgba(255,255,255,0.08) !important;
    color: #e2e8f0 !important;
}

[data-theme="dark"] [style*="color: #475569"],
[data-theme="dark"] [style*="color: var(--text-muted)"] {
    color: #94a3b8 !important;
}

/* ══════════════════════════════════════════
   PROJECT PAGE
══════════════════════════════════════════ */

[data-theme="dark"] .pl-wrap,
[data-theme="dark"] .pl-page { background: transparent !important; }

/* Page title */
[data-theme="dark"] .pl-title {
    background: linear-gradient(110deg, #ffffff 0%, #b8b0ff 100%) !important;
    -webkit-background-clip: text !important;
    -webkit-text-fill-color: transparent !important;
}
[data-theme="dark"] .pl-subtitle { color:#c1c1c1 !important; }

/* New project button */
[data-theme="dark"] .btn-new-project {
    background: linear-gradient(135deg, #6394ff 0%, #1c159f 100%) !important;
    box-shadow: 0 8px 24px rgba(99, 68, 255, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.1) !important;
    border: 1px solid rgba(140, 100, 255, 0.3) !important;
}
[data-theme="dark"] .btn-new-project:hover {
    box-shadow: 0 12px 32px rgba(99,68,255,0.55), 0 0 0 1px rgba(140,100,255,0.4) !important;
    transform: translateY(-2px) scale(1.02) !important;
}

/* ── Stat Cards — Ultimate Premium ── */
[data-theme="dark"] .pl-stat {
    background: rgba(15, 20, 45, 0.4) !important;
    backdrop-filter: blur(20px) !important;
    border: 1px solid rgba(255, 255, 255, 0.05) !important;
    box-shadow: 0 10px 40px rgba(0,0,0,0.5), inset 0 1px 0 rgba(255,255,255,0.02) !important;
    border-radius: 22px !important;
    padding: 24px !important;
    position: relative;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
    z-index: 1;
}

[data-theme="dark"] .pl-stat:hover {
    transform: translateY(-6px) scale(1.02) !important;
    background: rgba(20, 30, 60, 0.6) !important;
    box-shadow: 0 25px 60px rgba(0,0,0,0.7) !important;
}

[data-theme="dark"] .stat-icon {
    position: absolute;
    right: -10px;
    bottom: -15px;
    font-size: 5rem;
    opacity: 0.07;
    transform: rotate(-15deg);
    transition: all 0.5s ease;
    z-index: -1;
}

[data-theme="dark"] .pl-stat:hover .stat-icon {
    transform: rotate(0deg) scale(1.2);
    opacity: 0.15;
}

/* Individual Color Accents */
[data-theme="dark"] .stat-total .pl-stat-lbl { color: #6394ff !important; }
[data-theme="dark"] .stat-total .stat-icon { color: #6394ff; }

[data-theme="dark"] .stat-active .pl-stat-lbl { color: #f59e0b !important; }
[data-theme="dark"] .stat-active .stat-icon { color: #f59e0b; }

[data-theme="dark"] .stat-done .pl-stat-lbl { color: #10b981 !important; }
[data-theme="dark"] .stat-done .stat-icon { color: #10b981; }

[data-theme="dark"] .stat-over { border-bottom: 3px solid #f43f5e !important; }
[data-theme="dark"] .stat-over .pl-stat-lbl { color: #f43f5e !important; }
[data-theme="dark"] .stat-over .stat-icon { color: #f43f5e; }

[data-theme="dark"] .pl-stat-val {
    font-size: 2.2rem !important;
    font-weight: 900 !important;
    letter-spacing: -1px;
    margin-top: 8px;
    color: #fff !important;
}

[data-theme="dark"] .pl-stat-lbl {
    font-size: 0.75rem !important;
    text-transform: uppercase !important;
    font-weight: 800 !important;
    letter-spacing: 1px;
}

/* Over budget stat blink — dark */
[data-theme="dark"] .stat-blink {
    border-color: rgba(244,63,94,0.3) !important;
    animation: dmStatPulse 2.2s ease-in-out infinite !important;
}
@keyframes dmStatPulse {
    0%,100% { box-shadow: 0 4px 24px rgba(0,0,0,0.5), 0 0 0 0 rgba(244,63,94,0); }
    50%     { box-shadow: 0 4px 24px rgba(0,0,0,0.5), 0 0 30px rgba(244,63,94,0.2); border-color: rgba(244,63,94,0.5) !important; }
}

/* ── Alert Bar ── */
[data-theme="dark"] .over-alert-bar {
    background: linear-gradient(90deg, rgba(180,20,50,0.18) 0%, rgba(120,10,30,0.08) 60%, transparent 100%) !important;
    border: 1px solid rgba(244,63,94,0.25) !important;
    box-shadow: 0 0 40px rgba(244,63,94,0.07), inset 0 1px 0 rgba(244,63,94,0.1) !important;
    border-radius: 14px !important;
    animation: dmAlertPulse 2.8s ease-in-out infinite !important;
}
@keyframes dmAlertPulse {
    0%,100% { box-shadow: 0 0 20px rgba(244,63,94,0.05); }
    50%     { box-shadow: 0 0 40px rgba(244,63,94,0.15); }
}

/* ── Table Shell ── */
[data-theme="dark"] .pl-shell {
    background: rgba(5,5,16,0.6) !important;
    backdrop-filter: blur(24px) !important;
    border: 1px solid rgba(99,80,255,0.1) !important;
    box-shadow: 0 8px 50px rgba(0,0,0,0.6), inset 0 1px 0 rgba(255,255,255,0.02) !important;
    border-radius: 22px !important;
    padding: 14px !important;
}

/* ── Table ── */
[data-theme="dark"] .pl-table {
    border-collapse: separate !important;
    border-spacing: 0 10px !important;
}
[data-theme="dark"] .pl-table thead tr { background: transparent !important; }
[data-theme="dark"] .pl-table th {
    color: rgba(255, 255, 255, 0.6) !important;
    font-size: 0.65rem !important;
    font-weight: 800 !important;
    letter-spacing: 1.2px !important;
    text-transform: uppercase !important;
    padding: 14px 1.4rem !important;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
}

/* ── Table rows ── */
[data-theme="dark"] .pl-table tbody tr {
    background: rgba(10,10,26,0.75) !important;
    transition: all 0.25s cubic-bezier(0.4,0,0.2,1) !important;
    border: none !important;
}

/* left cap */
[data-theme="dark"] .pl-table tbody tr td:first-child {
    border-radius: 14px 0 0 14px !important;
    border-left:   1px solid rgba(99,80,255,0.12) !important;
    border-top:    1px solid rgba(99,80,255,0.07) !important;
    border-bottom: 1px solid rgba(99,80,255,0.07) !important;
}
/* right cap */
[data-theme="dark"] .pl-table tbody tr td:last-child {
    border-radius: 0 14px 14px 0 !important;
    border-right:  1px solid rgba(99,80,255,0.12) !important;
    border-top:    1px solid rgba(99,80,255,0.07) !important;
    border-bottom: 1px solid rgba(99,80,255,0.07) !important;
}
/* middle */
[data-theme="dark"] .pl-table tbody tr td:not(:first-child):not(:last-child) {
    border-top:    1px solid rgba(99,80,255,0.07) !important;
    border-bottom: 1px solid rgba(99,80,255,0.07) !important;
}

/* hover */
[data-theme="dark"] .pl-table tbody tr:hover {
    background: rgba(18,16,48,0.9) !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 14px 40px rgba(0,0,0,0.55), 0 0 0 1px rgba(99,80,255,0.14) !important;
}
[data-theme="dark"] .pl-table tbody tr:hover td:first-child {
    border-left-color: rgba(140,100,255,0.3) !important;
}

[data-theme="dark"] .pl-table tbody td {
    color: #e8eaf6 !important;
    padding: 1.1rem 1.4rem !important;
}

/* ── Crisis row — deep crimson pulse ── */
[data-theme="dark"] .pl-table tbody tr.row-crisis {
    background: linear-gradient(90deg,
        rgba(160,10,35,0.28) 0%,
        rgba(100,8,25,0.14) 45%,
        rgba(60,4,16,0.06) 100%) !important;
    animation: dmBloodPulse 3s ease-in-out infinite !important;
}

@keyframes dmBloodPulse {
    0%,100% {
        background: linear-gradient(90deg, rgba(160,10,35,0.28) 0%, rgba(100,8,25,0.14) 45%, rgba(60,4,16,0.06) 100%);
        box-shadow: inset 3px 0 20px rgba(244,63,94,0.1);
    }
    50% {
        background: linear-gradient(90deg, rgba(210,15,50,0.38) 0%, rgba(140,10,35,0.2) 45%, rgba(60,4,16,0.06) 100%);
        box-shadow: inset 3px 0 30px rgba(244,63,94,0.2), 0 0 30px rgba(244,63,94,0.08);
    }
}

/* ── Warn row ── */
[data-theme="dark"] .pl-table tbody tr.row-warn {
    background: linear-gradient(90deg,
        rgba(180,120,0,0.15) 0%,
        rgba(120,80,0,0.08) 45%,
        transparent 100%) !important;
}


/* Kill white/inline backgrounds */
[data-theme="dark"] .pl-table td,
[data-theme="dark"] .pl-table td .sv-av,
[data-theme="dark"] .pl-table td .proj-av,
[data-theme="dark"] .pl-table td .cg-wrap,
[data-theme="dark"] .pl-table td[style*="background"],
[data-theme="dark"] .pl-table tr[style*="background"] {
    background-color: transparent !important;
    background-image: none !important;
}

/* ── Text ── */
[data-theme="dark"] .proj-name,
[data-theme="dark"] .sv-name,
[data-theme="dark"] .amount-main,
[data-theme="dark"] .cg-text,
[data-theme="dark"] .pl-title { color: #e8eaf6 !important; }

[data-theme="dark"] .proj-client,
[data-theme="dark"] .sv-role,
[data-theme="dark"] .amount-sub { color: #3a4070 !important; }

/* ── Supervisor avatar border ── */
[data-theme="dark"] .sv-av { border-color: rgba(99,80,255,0.2) !important; }

/* ── Stage chips ── */
[data-theme="dark"] .stage-idle {
    background: rgba(255,255,255,0.04) !important;
    color: #3a4070 !important;
    border: 1px solid rgba(255,255,255,0.05) !important;
}
[data-theme="dark"] .stage-active {
    background: rgba(99,80,255,0.14) !important;
    color: #b8a8ff !important;
    border: 1px solid rgba(99,80,255,0.28) !important;
    box-shadow: 0 0 12px rgba(99,80,255,0.12) !important;
    text-shadow: 0 0 12px rgba(140,100,255,0.5);
}
[data-theme="dark"] .stage-done {
    background: rgba(16,185,129,0.1) !important;
    color: #34d399 !important;
    border: 1px solid rgba(16,185,129,0.2) !important;
}

/* ── Badges ── */
[data-theme="dark"] .badge-ok {
    background: rgba(16,185,129,0.1) !important;
    color: #34d399 !important;
    border: 1px solid rgba(16,185,129,0.22) !important;
    box-shadow: 0 0 12px rgba(16,185,129,0.08) !important;
}
[data-theme="dark"] .badge-near {
    background: rgba(245,158,11,0.1) !important;
    color: #fbbf24 !important;
    border: 1px solid rgba(245,158,11,0.25) !important;
    box-shadow: 0 0 12px rgba(245,158,11,0.08) !important;
}
[data-theme="dark"] .badge-over {
    background: rgba(244,63,94,0.1) !important;
    color: #fb7185 !important;
    border: 1px solid rgba(244,63,94,0.28) !important;
    box-shadow: 0 0 14px rgba(244,63,94,0.1) !important;
    animation: dmBadgePulse 2s ease-in-out infinite !important;
}
@keyframes dmBadgePulse {
    0%,100% { box-shadow: 0 0 10px rgba(244,63,94,0.1); }
    50%     { box-shadow: 0 0 22px rgba(244,63,94,0.25); }
}

/* ── Action buttons ── */
[data-theme="dark"] .act-btn.btn-view {
    background: rgba(99,80,255,0.07) !important;
    color: #4a4e80 !important;
    border: 1px solid rgba(99,80,255,0.14) !important;
}
[data-theme="dark"] .act-btn.btn-view:hover {
    background: #6344ff !important;
    color: #fff !important;
    border-color: #6344ff !important;
    box-shadow: 0 0 20px rgba(99,68,255,0.45) !important;
    transform: scale(1.1) !important;
}
[data-theme="dark"] .act-btn.btn-edit {
    background: rgba(245,197,66,0.07) !important;
    color: #f5c542 !important;
    border: 1px solid rgba(245,197,66,0.18) !important;
}
[data-theme="dark"] .act-btn.btn-edit:hover {
    background: #fbbf24 !important;
    color: #04040c !important;
    border-color: #fbbf24 !important;
    box-shadow: 0 0 20px rgba(245,197,66,0.4) !important;
    transform: scale(1.1) !important;
}

/* ── Gauge track ── */
[data-theme="dark"] .cg-bg { stroke: rgba(99,80,255,0.1) !important; }

/* ── Alert exceed text ── */
[data-theme="dark"] .alert-exceed {
    color: #fb7185 !important;
    text-shadow: 0 0 12px rgba(244,63,94,0.4) !important;
}

/* ── Scrollbar ── */
[data-theme="dark"] ::-webkit-scrollbar-thumb { background: rgba(99,80,255,0.2) !important; }
[data-theme="dark"] ::-webkit-scrollbar-thumb:hover { background: rgba(99,80,255,0.4) !important; }

/* ── Canvas / charts ── */
[data-theme="dark"] canvas,
[data-theme="dark"] [class*="chart"],
[data-theme="dark"] [class*="graph"] {
    background: transparent !important;
    border: none !important;
    box-shadow: none !important;
}


        /* Dark mode toggle button */
        .theme-toggle {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            border: 1px solid var(--border);
            background: var(--bg-glass);
            color: var(--text-main);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.25s ease;
            backdrop-filter: blur(8px);
            flex-shrink: 0;
        }

        .theme-toggle:hover {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
            transform: scale(1.08);
        }

        [data-theme="dark"] .theme-toggle {
            background: var(--dm-surface2);
            border-color: var(--dm-border);
            color: #fbbf24;
        }

        [data-theme="dark"] .theme-toggle:hover {
            background: #fbbf24;
            color: #0d1117;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: #eaecf1;
            background-image: radial-gradient(circle at 1px 1px, rgba(234, 88, 12, 0.04) 1px, transparent 0);
            background-size: 32px 32px;
            color: var(--text-main);
            margin: 0;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        /* Glassmorphism Effect */
        .glass-effect {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: var(--glass-border);
        }

        /* Sidebar - Desktop Only */
        .sidebar {
            width: 280px;
            height: 94vh;
            background: rgb(11 19 30);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            position: fixed;
            left: 20px;
            top: 3vh;
            border-radius: 32px;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-header {
            padding: 3rem 2rem;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo-box {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #f97316, #ea580c);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.3rem;
            box-shadow: 0 8px 20px rgba(234, 88, 12, 0.3);
            position: relative;
        }

        .logo-box::after {
            content: '';
            position: absolute;
            inset: -4px;
            border-radius: 18px;
            border: 1px solid rgba(234, 88, 12, 0.3);
            opacity: 0.5;
        }

        .logo-text {
            color: #fff;
            font-weight: 900;
            font-size: 1.5rem;
            letter-spacing: -1px;
            font-family: 'Outfit', sans-serif;
        }

        .sidebar-nav {
            flex: 1;
            padding: 0 1.2rem;
            overflow-y: auto;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 1rem 1.4rem;
            color: #94a3b8;
            text-decoration: none;
            border-radius: 20px;
            margin-bottom: 0.5rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 600;
            font-size: 0.9rem;
            letter-spacing: 0.2px;
        }

        .nav-item i {
            width: 24px;
            font-size: 1.1rem;
            margin-right: 15px;
            opacity: 0.7;
            transition: all 0.3s ease;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.03);
            color: #fff;
            transform: translateX(5px);
        }

        .nav-item:hover i {
            opacity: 1;
            color: var(--primary);
        }

        .nav-item.active {
            background: linear-gradient(135deg, rgba(234, 88, 12, 0.2), rgba(234, 88, 12, 0.05));
            color: #fff;
            border: 1px solid rgba(234, 88, 12, 0.2);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .nav-item.active i {
            color: var(--primary);
            opacity: 1;
            filter: drop-shadow(0 0 8px var(--primary));
        }

        .sidebar-footer {
            padding: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .user-profile-mini {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .user-avatar-mini {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            color: #fff;
            font-size: 0.9rem;
        }

        .user-info-mini {
            flex: 1;
            min-width: 0;
        }

        .user-name-mini {
            font-size: 0.85rem;
            font-weight: 700;
            color: #fff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role-mini {
            font-size: 0.65rem;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Main Content */
        .main-content {
            margin-left: 320px;
            padding: 3vh 40px 100px 20px;
            transition: all 0.4s ease;
        }

        /* Premium Top Bar */
        .top-bar {
            background: var(--bg-glass);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 1rem 1.5rem;
            margin-bottom: 2.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid var(--border);
            position: sticky;
            top: 20px;
            z-index: 900;
            box-shadow: var(--shadow-sm);
        }

        .page-title h1 {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin: 0;
            background: linear-gradient(to right, #0f172a, #334155);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Premium Components */
        .card-premium {
            background: #fff;
            border-radius: 24px;
            padding: 2rem;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
        }

        .card-premium:hover {
            box-shadow: var(--shadow);
            transform: translateY(-2px);
        }

        .btn-premium {
            background: var(--primary);
            color: #fff;
            padding: 0.8rem 1.5rem;
            border-radius: 14px;
            font-weight: 700;
            border: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
            box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2);
        }

        .btn-premium:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
            background: var(--primary-dark);
        }

        /* Mobile Bottom Nav */
        .mobile-nav {
            display: none;
            position: fixed;
            bottom: 20px;
            left: 20px;
            right: 20px;
            background: rgba(202, 115, 0, 0.95);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            height: 70px;
            border-radius: 24px;
            z-index: 2000;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);
            padding: 0 15px;
            align-items: center;
            justify-content: space-around;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .m-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.65rem;
            font-weight: 700;
            transition: all 0.3s ease;
            width: 60px;
        }

        .m-nav-item i {
            font-size: 1.2rem;
        }

        .m-nav-item.active {
            color: #fff;
        }

        .m-nav-item.active i {
            color: var(--primary);
            transform: scale(1.1);
        }

        /* Mobile Specific */
        @media (max-width: 992px) {
            .sidebar {
                display: none;
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
                padding-bottom: 110px;
            }

            .mobile-nav {
                display: flex;
            }

            .top-bar {
                margin-bottom: 1.5rem;
                padding: 0.8rem 1.2rem;
            }

            .page-title h1 {
                font-size: 1.2rem;
            }

            .card-premium {
                padding: 1.2rem;
                border-radius: 20px;
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .stat-card {
            background: #fff;
            padding: 1.5rem;
            border-radius: 24px;
            border: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            gap: 12px;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }
    </style>
    @stack('styles')
</head>

<body>
    <!-- Sidebar for Desktop -->
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="logo-box">
                <i class="fas fa-building"></i>
            </div>
            <span class="logo-text">MAAK</span>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" style="margin-right: 12px;"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></g></svg>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.projects.index') }}"
                class="nav-item {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 36 36" style="margin-right:12px;"><path fill="currentColor" d="M31 8h-8v2h8v21h-8v2h10V10a2 2 0 0 0-2-2"/><path fill="currentColor" d="M19.88 3H6.12A2.12 2.12 0 0 0 4 5.12V33h18V5.12A2.12 2.12 0 0 0 19.88 3M20 31h-3v-3H9v3H6V5.12A.12.12 0 0 1 6.12 5h13.76a.12.12 0 0 1 .12.12Z"/><path fill="currentColor" d="M8 8h2v2H8z"/><path fill="currentColor" d="M12 8h2v2h-2z"/><path fill="currentColor" d="M16 8h2v2h-2z"/><path fill="currentColor" d="M8 13h2v2H8z"/><path fill="currentColor" d="M12 13h2v2h-2z"/><path fill="currentColor" d="M16 13h2v2h-2z"/><path fill="currentColor" d="M8 18h2v2H8z"/><path fill="currentColor" d="M12 18h2v2h-2z"/><path fill="currentColor" d="M16 18h2v2h-2z"/><path fill="currentColor" d="M8 23h2v2H8z"/><path fill="currentColor" d="M12 23h2v2h-2z"/><path fill="currentColor" d="M16 23h2v2h-2z"/><path fill="currentColor" d="M23 13h2v2h-2z"/><path fill="currentColor" d="M27 13h2v2h-2z"/><path fill="currentColor" d="M23 18h2v2h-2z"/><path fill="currentColor" d="M27 18h2v2h-2z"/><path fill="currentColor" d="M23 23h2v2h-2z"/><path fill="currentColor" d="M27 23h2v2h-2z"/></svg>
                <span>Projects</span>
            </a>
            <a href="{{ route('admin.expenses.index') }}"
                class="nav-item {{ request()->routeIs('admin.expenses.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 16 16" style="margin-right:12px;"><g fill="currentColor"><path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8a4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0a5 5 0 0 1 10 0"/><path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207c0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158c0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522c0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569c0 .339-.257.571-.709.614v-1.195z"/><path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z"/><path d="M9.998 5.083L10 5a2 2 0 1 0-3.132 1.65a6 6 0 0 1 3.13-1.567"/></g></svg>
                <span>Expenses</span>
            </a>
            <a href="{{ route('admin.payments.index') }}"
                class="nav-item {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" style="margin-right:12px;"><g fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"><path d="m14.022 16.483l-3.568 2.649c-.21.16-.52.48-.85.71a.7.7 0 0 1-.4.19a1.8 1.8 0 0 1-1.06-.55a14.5 14.5 0 0 1-1.448-1.69c-.79-1-1.56-1.999-2.3-2.999s-1.419-2.049-2.069-3.118c-1.349-2.18-1.269-1.41-.75-1.97q.47-.53 1-.999t1.11-.87l1.999-1.589l.66-.51c.16 0 .33.18.51.34q.372.349.7.74l.999 1.2l3.278 4.387a.361.361 0 1 0 .58-.43L9.254 7.488l-.95-1.26a7 7 0 0 0-1.119-1.16a1.48 1.48 0 0 0-.94-.32a1.4 1.4 0 0 0-.509.2q-.348.222-.66.49l-1.999 1.48c-.43.29-.84.59-1.24.91q-.6.497-1.139 1.059a4.6 4.6 0 0 0-.64.78a.7.7 0 0 0 0 .56q.144.381.36.73c.28.469.65.929.91 1.349c.65 1.089 1.34 2.168 2.119 3.208s1.6 2 2.449 2.999a11.5 11.5 0 0 0 1.999 1.999c.384.28.844.44 1.32.46a1.4 1.4 0 0 0 .76-.27q.526-.41.999-.88c.68-.56 1.36-1.14 1.999-1.689q.68-.549 1.38-1.08a.32.32 0 0 0-.36-.52z"/><path d="M8.915 11.175a2.38 2.38 0 0 0-3-.27a2.45 2.45 0 0 0-.889 1.74a2.15 2.15 0 0 0 .74 1.809c.397.308.887.47 1.39.46c.468.007.929-.117 1.329-.36a.33.33 0 0 0 .12-.44a.35.35 0 0 0 .27-.1a1.83 1.83 0 0 0 .04-2.839m-.58 2.309a.35.35 0 0 0 0 .47h-.12a1.76 1.76 0 0 1-1 .12a1.27 1.27 0 0 1-.77-.39a1.14 1.14 0 0 1-.23-1a1.33 1.33 0 0 1 .46-.89a1.24 1.24 0 0 1 1.55.07a1 1 0 0 1 .11 1.62m9.015-7.077a14 14 0 0 0-.379-1.55a7 7 0 0 0-.54-1.229a1.77 1.77 0 0 0-.81-.75a1.6 1.6 0 0 0-.739-.08q-.646.12-1.27.33a.324.324 0 1 0 .15.63q.495-.099 1-.13a.86.86 0 0 1 .45.09c.14.08.2.26.28.43q.215.518.32 1.07c.19.56.32 1.13.46 1.699s.33 1.17.49 1.75c.16.579.25.819.25.829c.079.42.619.08.659-.53c-.2-1.03-.12-1.53-.32-2.559m6.617 10.116a7.7 7.7 0 0 0-.51-2.12a6.7 6.7 0 0 0-1.12-1.889a8.18 8.18 0 0 0-4.367-2.598c-.36-.17-.63.09-.62.52a5.7 5.7 0 0 1-.71 1.579a2.71 2.71 0 0 1-2.759.38a1.35 1.35 0 0 0-.83.09a1.54 1.54 0 0 0-1.079 1.529a2 2 0 0 0 .8 1.609c.13.07.4.2.74.34c.77.32 1.999.74 2.468 1c-.08.2.21.73.26.88a5.5 5.5 0 0 0 1.07 1.808a1.8 1.8 0 0 0 1.44.62a.36.36 0 1 0 0-.72a1.1 1.1 0 0 1-.82-.45a4.3 4.3 0 0 1-.76-1.559c-.05-.18-.07-.75-.15-1a.6.6 0 0 0-.24-.34a5.6 5.6 0 0 0-.74-.399c-.87-.4-2.288-1-2.618-1.2a.77.77 0 0 1-.21-.57a.41.41 0 0 1 .25-.42a1 1 0 0 1 .35 0q.732.074 1.469.06a3 3 0 0 0 2.209-1.289a3.26 3.26 0 0 0 .48-1.709a7.6 7.6 0 0 1 3.448 2.56a7 7 0 0 1 .9 1.618c.234.583.402 1.19.5 1.81c.23 1.504.161 3.04-.2 4.518a.37.37 0 0 0 .25.45a.36.36 0 0 0 .44-.25c.556-1.556.78-3.21.66-4.858"/><path d="M14.852 10.066c-.29-1-.55-2-.83-3c-.18-.669-.39-1.329-.58-1.998a7.7 7.7 0 0 0-.75-2a1.45 1.45 0 0 0-1.079-.71a.87.87 0 0 0-.46.1q-.383.23-.74.5l-2.438 1.55a.32.32 0 1 0 .27.57l2.639-1.26c.45-.23.58-.89 1 .3c.18.48.29 1 .37 1.29c.389 1.189.769 2.368 1.189 3.548s.69 1.61 1.14 2.669c.199.58.719.72.719.29c-.21-.7-.24-1.15-.45-1.85"/></g></svg>
                <span>Payments</span>
            </a>
            <a href="{{ route('admin.reports.index') }}"
                class="nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 16 16" style="margin-right:12px;"><path fill="currentColor" d="M10.58 9.902a.41.41 0 0 1-.407.408H5.826a.408.408 0 0 1 0-.816h4.347a.41.41 0 0 1 .408.408m-.407-2.581H5.826a.408.408 0 0 0 0 .815h4.347a.408.408 0 0 0 0-.815m3.668-4.483v11.411a.95.95 0 0 1-.95.951H3.108a.95.95 0 0 1-.95-.95V2.837a.95.95 0 0 1 .95-.951h2.525a3.118 3.118 0 0 1 4.732 0h2.524a.95.95 0 0 1 .951.95M5.69 3.923v.135h4.618v-.135a2.31 2.31 0 1 0-4.619 0m7.335-1.087a.136.136 0 0 0-.136-.136h-2.015c.165.386.25.802.25 1.223v.543a.41.41 0 0 1-.408.408H5.283a.41.41 0 0 1-.408-.408v-.543c0-.42.085-.837.25-1.223H3.108a.136.136 0 0 0-.136.136v11.411a.136.136 0 0 0 .136.136h9.781a.136.136 0 0 0 .136-.136z"/></svg>
                <span>Reports</span>
            </a>
            <div
                style="margin: 1rem 1rem 0.5rem; font-size: 0.7rem; font-weight: 800; color: #475569; text-transform: uppercase; letter-spacing: 1px;">
                People</div>
            <a href="{{ route('admin.supervisors.index') }}"
                class="nav-item {{ request()->routeIs('admin.supervisors.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" style="margin-right:12px;"><path fill="currentColor" d="M15.225 14.275Q14.5 13.55 14.5 12.5t.725-1.775T17 10t1.775.725t.725 1.775t-.725 1.775T17 15t-1.775-.725M12 19v-.4q0-.6.313-1.112t.887-.738q.9-.375 1.863-.562T17 16t1.938.188t1.862.562q.575.225.888.738T22 18.6v.4q0 .425-.288.713T21 20h-8q-.425 0-.712-.288T12 19m-4.825-8.175Q6 9.65 6 8t1.175-2.825T10 4t2.825 1.175T14 8t-1.175 2.825T10 12t-2.825-1.175M2 17.2q0-.85.425-1.562T3.6 14.55q1.5-.75 3.113-1.15T10 13q.875 0 1.75.15t1.75.35l-.85.85l-.85.85q-.45-.125-.9-.162T10 15q-1.45 0-2.838.35t-2.662 1q-.25.125-.375.35T4 17.2v.8h6v.975q0 .325.125.588t.35.437H4q-.825 0-1.412-.587T2 18zm9.413-7.788Q12 8.825 12 8t-.587-1.412T10 6t-1.412.588T8 8t.588 1.413T10 10t1.413-.587"/></svg>
                <span>Supervisors</span>
            </a>
            <a href="{{ route('admin.clients.index') }}"
                class="nav-item {{ request()->routeIs('admin.clients.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 36 36" style="margin-right:12px;"><path fill="currentColor" d="M12 16.14h-.87a8.67 8.67 0 0 0-6.43 2.52l-.24.28v8.28h4.08v-4.7l.55-.62l.25-.29a11 11 0 0 1 4.71-2.86A6.6 6.6 0 0 1 12 16.14" class="clr-i-solid clr-i-solid-path-1"/><path fill="currentColor" d="M31.34 18.63a8.67 8.67 0 0 0-6.43-2.52a11 11 0 0 0-1.09.06a6.6 6.6 0 0 1-2 2.45a10.9 10.9 0 0 1 5 3l.25.28l.54.62v4.71h3.94v-8.32Z" class="clr-i-solid clr-i-solid-path-2"/><path fill="currentColor" d="M11.1 14.19h.31a6.45 6.45 0 0 1 3.11-6.29a4.09 4.09 0 1 0-3.42 6.33Z" class="clr-i-solid clr-i-solid-path-3"/><path fill="currentColor" d="M24.43 13.44a7 7 0 0 1 0 .69a4 4 0 0 0 .58.05h.19A4.09 4.09 0 1 0 21.47 8a6.53 6.53 0 0 1 2.96 5.44" class="clr-i-solid clr-i-solid-path-4"/><circle cx="17.87" cy="13.45" r="4.47" fill="currentColor" class="clr-i-solid clr-i-solid-path-5"/><path fill="currentColor" d="M18.11 20.3A9.7 9.7 0 0 0 11 23l-.25.28v6.33a1.57 1.57 0 0 0 1.6 1.54h11.49a1.57 1.57 0 0 0 1.6-1.54V23.3l-.24-.3a9.58 9.58 0 0 0-7.09-2.7" class="clr-i-solid clr-i-solid-path-6"/></svg>
                <span>Clients</span>
            </a>
        </nav>

        <div class="sidebar-footer" style="padding: 1.5rem; border-top: 1px solid rgba(255,255,255,0.05);">
            <a href="{{ route('admin.settings.index') }}"
                class="nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" style="margin-right:12px;"><g fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"><path d="M12 8.25a3.75 3.75 0 1 0 0 7.5a3.75 3.75 0 0 0 0-7.5M9.75 12a2.25 2.25 0 1 1 4.5 0a2.25 2.25 0 0 1-4.5 0"/><path d="M11.975 1.25c-.445 0-.816 0-1.12.02a2.8 2.8 0 0 0-.907.19a2.75 2.75 0 0 0-1.489 1.488c-.145.35-.184.72-.2 1.122a.87.87 0 0 1-.415.731a.87.87 0 0 1-.841-.005c-.356-.188-.696-.339-1.072-.389a2.75 2.75 0 0 0-2.033.545a2.8 2.8 0 0 0-.617.691c-.17.254-.356.575-.578.96l-.025.044c-.223.385-.408.706-.542.98c-.14.286-.25.568-.29.88a2.75 2.75 0 0 0 .544 2.033c.231.301.532.52.872.734a.87.87 0 0 1 .426.726a.87.87 0 0 1-.426.726c-.34.214-.64.433-.872.734a2.75 2.75 0 0 0-.545 2.033c.041.312.15.594.29.88c.135.274.32.595.543.98l.025.044c.222.385.408.706.578.96c.177.263.367.5.617.69a2.75 2.75 0 0 0 2.033.546c.376-.05.716-.2 1.072-.389a.87.87 0 0 1 .84-.005a.86.86 0 0 1 .417.731c.015.402.054.772.2 1.122a2.75 2.75 0 0 0 1.488 1.489c.29.12.59.167.907.188c.304.021.675.021 1.12.021h.05c.445 0 .816 0 1.12-.02c.318-.022.617-.069.907-.19a2.75 2.75 0 0 0 1.489-1.488c.145-.35.184-.72.2-1.122a.87.87 0 0 1 .415-.732a.87.87 0 0 1 .841.006c.356.188.696.339 1.072.388a2.75 2.75 0 0 0 2.033-.544c.25-.192.44-.428.617-.691c.17-.254.356-.575.578-.96l.025-.044c.223-.385.408-.706.542-.98c.14-.286.25-.569.29-.88a2.75 2.75 0 0 0-.544-2.033c-.231-.301-.532-.52-.872-.734a.87.87 0 0 1-.426-.726c0-.278.152-.554.426-.726c.34-.214.64-.433.872-.734a2.75 2.75 0 0 0 .545-2.033a2.8 2.8 0 0 0-.29-.88a18 18 0 0 0-.543-.98l-.025-.044a18 18 0 0 0-.578-.96a2.8 2.8 0 0 0-.617-.69a2.75 2.75 0 0 0-2.033-.546c-.376.05-.716.2-1.072.389a.87.87 0 0 1-.84.005a.87.87 0 0 1-.417-.731c-.015-.402-.054-.772-.2-1.122a2.75 2.75 0 0 0-1.488-1.489c-.29-.12-.59-.167-.907-.188c-.304-.021-.675-.021-1.12-.021zm-1.453 1.595c.077-.032.194-.061.435-.078c.247-.017.567-.017 1.043-.017s.796 0 1.043.017c.241.017.358.046.435.078c.307.127.55.37.677.677c.04.096.073.247.086.604c.03.792.439 1.555 1.165 1.974s1.591.392 2.292.022c.316-.167.463-.214.567-.227a1.25 1.25 0 0 1 .924.247c.066.051.15.138.285.338c.139.206.299.483.537.895s.397.69.506.912c.107.217.14.333.15.416a1.25 1.25 0 0 1-.247.924c-.064.083-.178.187-.48.377c-.672.422-1.128 1.158-1.128 1.996s.456 1.574 1.128 1.996c.302.19.416.294.48.377c.202.263.29.595.247.924c-.01.083-.044.2-.15.416c-.109.223-.268.5-.506.912s-.399.689-.537.895c-.135.2-.219.287-.285.338a1.25 1.25 0 0 1-.924.247c-.104-.013-.25-.06-.567-.227c-.7-.37-1.566-.398-2.292.021s-1.135 1.183-1.165 1.975c-.013.357-.046.508-.086.604a1.25 1.25 0 0 1-.677.677c-.077.032-.194.061-.435.078c-.247.017-.567.017-1.043.017s-.796 0-1.043-.017c-.241-.017-.358-.046-.435-.078a1.25 1.25 0 0 1-.677-.677c-.04-.096-.073-.247-.086-.604c-.03-.792-.439-1.555-1.165-1.974s-1.591-.392-2.292-.022c-.316.167-.463.214-.567.227a1.25 1.25 0 0 1-.924-.247c-.066-.051-.15-.138-.285-.338a17 17 0 0 1-.537-.895c-.238-.412-.397-.69-.506-.912c-.107-.217-.14-.333-.15-.416a1.25 1.25 0 0 1 .247-.924c.064-.083.178-.187.48-.377c.672-.422 1.128 1.158 1.128 1.996s-.456-1.574-1.128-1.996c-.302-.19-.416-.294-.48-.377a1.25 1.25 0 0 1-.247-.924c.01-.083.044-.2.15-.416c.109-.223.268-.5.506-.912s.399-.689.537-.895c.135-.2.219-.287.285-.338a1.25 1.25 0 0 1 .924-.247c.104.013.25.06.567.227c.7.37 1.566.398 2.292-.022c.726-.419 1.135-1.182 1.165-1.974c.013-.357.046-.508.086-.604c.127-.307.37-.55.677-.677"/></g></svg>
                <span>Settings</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-item"
                    style="width: 100%; border: none; background: none; cursor: pointer; color: #ef4444;">
                    <i class="fas fa-power-off"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Mobile Bottom Navigation -->
    <nav class="mobile-nav">
        <a href="{{ route('dashboard') }}" class="m-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-home"></i>
            <span>Home</span>
        </a>
        <a href="{{ route('admin.projects.index') }}"
            class="m-nav-item {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 36 36"><path fill="currentColor" d="M31 8h-8v2h8v21h-8v2h10V10a2 2 0 0 0-2-2"/><path fill="currentColor" d="M19.88 3H6.12A2.12 2.12 0 0 0 4 5.12V33h18V5.12A2.12 2.12 0 0 0 19.88 3M20 31h-3v-3H9v3H6V5.12A.12.12 0 0 1 6.12 5h13.76a.12.12 0 0 1 .12.12Z"/><path fill="currentColor" d="M8 8h2v2H8z"/><path fill="currentColor" d="M12 8h2v2h-2z"/><path fill="currentColor" d="M16 8h2v2h-2z"/><path fill="currentColor" d="M8 13h2v2H8z"/><path fill="currentColor" d="M12 13h2v2h-2z"/><path fill="currentColor" d="M16 13h2v2h-2z"/><path fill="currentColor" d="M8 18h2v2H8z"/><path fill="currentColor" d="M12 18h2v2h-2z"/><path fill="currentColor" d="M16 18h2v2h-2z"/><path fill="currentColor" d="M8 23h2v2H8z"/><path fill="currentColor" d="M12 23h2v2h-2z"/><path fill="currentColor" d="M16 23h2v2h-2z"/><path fill="currentColor" d="M23 13h2v2h-2z"/><path fill="currentColor" d="M27 13h2v2h-2z"/><path fill="currentColor" d="M23 18h2v2h-2z"/><path fill="currentColor" d="M27 18h2v2h-2z"/><path fill="currentColor" d="M23 23h2v2h-2z"/><path fill="currentColor" d="M27 23h2v2h-2z"/></svg>
            <span>Projects</span>
        </a>
        <a href="{{ route('admin.expenses.index') }}"
            class="m-nav-item {{ request()->routeIs('admin.expenses.*') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 16 16"><g fill="currentColor"><path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8a4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0a5 5 0 0 1 10 0"/><path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207c0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158c0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522c0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569c0 .339-.257.571-.709.614v-1.195z"/><path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z"/><path d="M9.998 5.083L10 5a2 2 0 1 0-3.132 1.65a6 6 0 0 1 3.13-1.567"/></g></svg>
            <span>Expenses</span>
        </a>
        <a href="{{ route('admin.reports.index') }}"
            class="m-nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 16 16"><path fill="currentColor" d="M10.58 9.902a.41.41 0 0 1-.407.408H5.826a.408.408 0 0 1 0-.816h4.347a.41.41 0 0 1 .408.408m-.407-2.581H5.826a.408.408 0 0 0 0 .815h4.347a.408.408 0 0 0 0-.815m3.668-4.483v11.411a.95.95 0 0 1-.95.951H3.108a.95.95 0 0 1-.95-.95V2.837a.95.95 0 0 1 .95-.951h2.525a3.118 3.118 0 0 1 4.732 0h2.524a.95.95 0 0 1 .951.95M5.69 3.923v.135h4.618v-.135a2.31 2.31 0 1 0-4.619 0m7.335-1.087a.136.136 0 0 0-.136-.136h-2.015c.165.386.25.802.25 1.223v.543a.41.41 0 0 1-.408.408H5.283a.41.41 0 0 1-.408-.408v-.543c0-.42.085-.837.25-1.223H3.108a.136.136 0 0 0-.136.136v11.411a.136.136 0 0 0 .136.136h9.781a.136.136 0 0 0 .136-.136z"/></svg>
            <span>Insight</span>
        </a>
        <a href="{{ route('admin.settings.index') }}"
            class="m-nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <i class="fas fa-user"></i>
            <span>Profile</span>
        </a>
    </nav>

    <div class="main-content">
        <div class="top-bar">
            <div class="page-title">
                <h1>@yield('title', 'Terminal')</h1>
            </div>
            <div class="user-menu">
                {{-- Dark / Light Toggle --}}
                <button class="theme-toggle" id="themeToggle" title="Toggle dark mode" aria-label="Toggle dark mode">
                    <i class="fas fa-moon" id="themeIcon"></i>
                </button>
                
                <div class="profile-pill">
                    <div class="user-avatar-shell">
                        <div class="user-avatar-mini">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <span class="status-dot-live"></span>
                    </div>
                    <div class="user-info-pill">
                        <span class="user-name-pill">{{ auth()->user()->name }}</span>
                        <span class="user-role-pill">{{ auth()->user()->role ?? 'Administrator' }}</span>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="card-premium"
                style="background: #f0fdf4; border-color: #bbf7d0; color: #166534; padding: 1rem 1.5rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px; font-weight: 600; font-size: 0.9rem;">
                <i class="fas fa-check-circle" style="font-size: 1.2rem;"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="card-premium"
                style="background: #fef2f2; border-color: #fecaca; color: #991b1b; padding: 1.5rem; margin-bottom: 1.5rem; border-radius: 20px;">
                <div style="font-weight: 800; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-shield-exclamation"></i> Action Required
                </div>
                <ul style="margin: 0; padding-left: 1.5rem; font-size: 0.9rem; font-weight: 500;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>

    @stack('scripts')

    <script>
        /* ── Dark Mode: init immediately to prevent flash ── */
        (function () {
            const saved = localStorage.getItem('maak-theme') || 'light';
            document.documentElement.setAttribute('data-theme', saved);
            const icon = document.getElementById('themeIcon');
            if (icon) icon.className = saved === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
        })();

        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('themeToggle');
            const icon = document.getElementById('themeIcon');
            const html = document.documentElement;

            /* Sync icon on load */
            const current = html.getAttribute('data-theme') || 'light';
            icon.className = current === 'dark' ? 'fas fa-sun' : 'fas fa-moon';

            btn.addEventListener('click', function () {
                const next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
                html.setAttribute('data-theme', next);
                localStorage.setItem('maak-theme', next);

                /* Smooth icon swap */
                btn.style.transform = 'scale(0.8) rotate(180deg)';
                btn.style.opacity = '0.5';
                setTimeout(function () {
                    icon.className = next === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
                    btn.style.transform = '';
                    btn.style.opacity = '';
                }, 200);
            });
        });
    </script>
</body>

</html>