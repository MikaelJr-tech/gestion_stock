<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} — @yield('title', 'Dashboard')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --white:           #ffffff;
            --bg-app:          #f7f8fc;
            --bg-card:         #ffffff;
            --bg-sidebar:      #0f172a;
            --bg-sidebar-item: rgba(255,255,255,0.06);
            --bg-sidebar-active: rgba(255,255,255,0.12);
            --sidebar-text:    rgba(255,255,255,0.65);
            --sidebar-active:  #ffffff;
            --sidebar-label:   rgba(255,255,255,0.3);
            --border:          #eaecf3;
            --border-input:    #d0d5e8;
            --accent:          #2563eb;
            --accent-hover:    #1d4ed8;
            --accent-light:    #eff6ff;
            --accent-mid:      #bfdbfe;
            --success:         #059669;
            --success-bg:      #ecfdf5;
            --success-border:  #a7f3d0;
            --warning:         #d97706;
            --warning-bg:      #fffbeb;
            --warning-border:  #fde68a;
            --danger:          #dc2626;
            --danger-bg:       #fef2f2;
            --danger-border:   #fecaca;
            --info:            #0891b2;
            --info-bg:         #ecfeff;
            --info-border:     #a5f3fc;
            --purple:          #7c3aed;
            --purple-bg:       #f5f3ff;
            --purple-border:   #ddd6fe;
            --text-900:        #0f172a;
            --text-700:        #334155;
            --text-500:        #64748b;
            --text-400:        #94a3b8;
            --text-300:        #cbd5e1;
            --sidebar-w:       252px;
            --topbar-h:        58px;
            --radius-xs:       4px;
            --radius-sm:       6px;
            --radius:          10px;
            --radius-lg:       14px;
            --radius-xl:       18px;
            --shadow-xs:       0 1px 2px rgba(15,23,42,.04);
            --shadow-sm:       0 1px 4px rgba(15,23,42,.06), 0 1px 2px rgba(15,23,42,.04);
            --shadow:          0 4px 16px rgba(15,23,42,.08), 0 1px 4px rgba(15,23,42,.04);
            --shadow-lg:       0 12px 40px rgba(15,23,42,.12), 0 4px 12px rgba(15,23,42,.06);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--bg-app);
            color: var(--text-900);
            min-height: 100vh;
            font-size: 13.5px;
            line-height: 1.55;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 99px; }

        /* ══════════════════════════════════
           APP SHELL
        ══════════════════════════════════ */
        .app-shell {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* ══════════════════════════════════
           SIDEBAR — dark navy
        ══════════════════════════════════ */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--bg-sidebar);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            overflow: hidden;
            position: relative;
        }

        /* subtle gradient overlay */
        .sidebar::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 200px;
            background: linear-gradient(180deg, rgba(37,99,235,.15) 0%, transparent 100%);
            pointer-events: none;
        }

        .sidebar-brand {
            padding: 20px 18px 16px;
            display: flex;
            align-items: center;
            gap: 11px;
            position: relative;
            border-bottom: 1px solid rgba(255,255,255,.07);
        }

        .brand-logo {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(37,99,235,.4);
        }

        .brand-info { overflow: hidden; }

        .brand-name {
            font-size: 14.5px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: -0.3px;
            white-space: nowrap;
        }

        .brand-tenant {
            font-size: 11px;
            color: var(--sidebar-label);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 168px;
            margin-top: 1px;
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 10px 10px 16px;
            position: relative;
        }

        .sidebar-nav::-webkit-scrollbar { width: 0; }

        .nav-group-label {
            font-size: 9.5px;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--sidebar-label);
            padding: 16px 10px 6px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-group-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255,255,255,.07);
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 11px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 400;
            color: var(--sidebar-text);
            text-decoration: none;
            transition: all 0.13s ease;
            margin-bottom: 1px;
            position: relative;
        }

        .nav-link:hover {
            background: var(--bg-sidebar-item);
            color: rgba(255,255,255,.9);
        }

        .nav-link.active {
            background: var(--bg-sidebar-active);
            color: var(--sidebar-active);
            font-weight: 500;
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0; top: 6px; bottom: 6px;
            width: 3px;
            background: #3b82f6;
            border-radius: 0 3px 3px 0;
        }

        .nav-icon {
            font-size: 14px;
            width: 18px;
            text-align: center;
            flex-shrink: 0;
            opacity: 0.8;
        }

        .nav-link.active .nav-icon { opacity: 1; }

        /* ── SIDEBAR FOOTER ── */
        .sidebar-footer {
            padding: 12px 14px;
            border-top: 1px solid rgba(255,255,255,.07);
            display: flex;
            align-items: center;
            gap: 10px;
            position: relative;
        }

        .user-avatar {
            width: 32px; height: 32px;
            border-radius: 8px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            display: flex; align-items: center; justify-content: center;
            font-size: 12.5px;
            font-weight: 700;
            color: white;
            flex-shrink: 0;
        }

        .user-info { flex: 1; min-width: 0; }

        .user-name {
            font-size: 12.5px;
            font-weight: 600;
            color: white;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role {
            font-size: 10.5px;
            color: var(--sidebar-label);
        }

        .logout-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: rgba(255,255,255,.3);
            font-size: 15px;
            padding: 5px;
            border-radius: var(--radius-sm);
            transition: all 0.13s;
            flex-shrink: 0;
            line-height: 1;
        }
        .logout-btn:hover {
            color: #f87171;
            background: rgba(248,113,113,.12);
        }

        /* ══════════════════════════════════
           MAIN AREA
        ══════════════════════════════════ */
        .main-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* ── TOPBAR ── */
        .topbar {
            height: var(--topbar-h);
            background: var(--white);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            flex-shrink: 0;
            box-shadow: var(--shadow-xs);
        }

        .topbar-left { display: flex; align-items: center; gap: 10px; }

        .topbar-title {
            font-size: 15.5px;
            font-weight: 600;
            color: var(--text-900);
            letter-spacing: -0.3px;
        }

        .topbar-right { display: flex; align-items: center; gap: 10px; }

        .topbar-date {
            font-size: 12px;
            color: var(--text-400);
            background: var(--bg-app);
            padding: 4px 10px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            font-weight: 500;
        }

        /* ── ALERTS ── */
        .alerts-zone { padding: 14px 28px 0; }

        .alert {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 10px;
            padding: 10px 14px;
            border-radius: var(--radius);
            margin-bottom: 8px;
            font-size: 13px;
            border: 1px solid;
            box-shadow: var(--shadow-xs);
        }

        .alert-success { background: var(--success-bg); border-color: var(--success-border); color: var(--success); }
        .alert-error   { background: var(--danger-bg);  border-color: var(--danger-border);  color: var(--danger); }

        .alert-close {
            background: none; border: none;
            color: inherit; cursor: pointer;
            font-size: 16px; opacity: 0.5;
            padding: 0 2px; flex-shrink: 0; line-height: 1;
        }
        .alert-close:hover { opacity: 1; }

        /* ── PAGE CONTENT ── */
        .page-content {
            flex: 1;
            overflow-y: auto;
            padding: 24px 28px;
        }

        /* ══════════════════════════════════
           COMPONENTS
        ══════════════════════════════════ */

        /* ── PAGE HEADER ── */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .page-title {
            font-size: 19px;
            font-weight: 700;
            color: var(--text-900);
            letter-spacing: -0.4px;
        }

        /* ── CARD ── */
        .card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .card-header {
            padding: 14px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-title {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text-900);
        }

        .card-body { padding: 20px; }

        /* ── STAT CARDS ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 14px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 18px 20px;
            box-shadow: var(--shadow-sm);
            transition: all 0.18s ease;
            cursor: default;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .stat-card:hover {
            box-shadow: var(--shadow);
            transform: translateY(-2px);
            border-color: #c7d7f0;
        }

        .stat-card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stat-icon {
            width: 38px; height: 38px;
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-size: 17px;
        }

        .stat-label {
            font-size: 11.5px;
            font-weight: 500;
            color: var(--text-400);
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 800;
            color: var(--text-900);
            letter-spacing: -0.8px;
            line-height: 1;
        }

        /* ── BUTTONS ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 500;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            border: 1px solid transparent;
            text-decoration: none;
            transition: all 0.13s ease;
            white-space: nowrap;
            line-height: 1.4;
            letter-spacing: -0.1px;
        }

        .btn-primary {
            background: var(--accent);
            color: white;
            border-color: var(--accent);
            box-shadow: 0 1px 3px rgba(37,99,235,.25), inset 0 1px 0 rgba(255,255,255,.1);
        }
        .btn-primary:hover {
            background: var(--accent-hover);
            border-color: var(--accent-hover);
            box-shadow: 0 4px 12px rgba(37,99,235,.3);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: var(--white);
            color: var(--text-700);
            border-color: var(--border);
            box-shadow: var(--shadow-xs);
        }
        .btn-secondary:hover {
            background: var(--bg-app);
            color: var(--text-900);
            border-color: var(--border-input);
        }

        .btn-success {
            background: var(--success-bg);
            color: var(--success);
            border-color: var(--success-border);
        }
        .btn-success:hover { background: #d1fae5; }

        .btn-danger {
            background: var(--danger-bg);
            color: var(--danger);
            border-color: var(--danger-border);
        }
        .btn-danger:hover { background: #fee2e2; }

        .btn-warning {
            background: var(--warning-bg);
            color: var(--warning);
            border-color: var(--warning-border);
        }
        .btn-warning:hover { background: #fef3c7; }

        .btn-info {
            background: var(--info-bg);
            color: var(--info);
            border-color: var(--info-border);
        }

        .btn-ghost {
            background: transparent;
            color: var(--text-500);
            border-color: transparent;
        }
        .btn-ghost:hover { background: var(--bg-app); color: var(--text-900); }

        .btn-sm  { padding: 5px 10px; font-size: 12px; border-radius: 5px; }
        .btn-lg  { padding: 9px 20px; font-size: 14px; }
        .btn-xs  { padding: 3px 8px;  font-size: 11px; border-radius: 4px; }

        /* ── BADGES ── */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 8px;
            border-radius: 99px;
            font-size: 11.5px;
            font-weight: 500;
            border: 1px solid;
            white-space: nowrap;
        }

        .badge-success { background: var(--success-bg); color: var(--success); border-color: var(--success-border); }
        .badge-warning { background: var(--warning-bg); color: var(--warning); border-color: var(--warning-border); }
        .badge-danger  { background: var(--danger-bg);  color: var(--danger);  border-color: var(--danger-border); }
        .badge-info    { background: var(--info-bg);    color: var(--info);    border-color: var(--info-border); }
        .badge-neutral { background: var(--bg-app);     color: var(--text-500); border-color: var(--border); }
        .badge-accent  { background: var(--accent-light); color: var(--accent); border-color: var(--accent-mid); }
        .badge-purple  { background: var(--purple-bg);  color: var(--purple);  border-color: var(--purple-border); }

        /* ── DATA TABLE ── */
        .table-wrap { overflow-x: auto; }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
        }

        table.data-table thead tr {
            background: var(--bg-app);
            border-bottom: 1px solid var(--border);
        }

        table.data-table th {
            padding: 9px 16px;
            text-align: left;
            font-size: 10.5px;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--text-400);
            white-space: nowrap;
        }

        table.data-table td {
            padding: 12px 16px;
            font-size: 13.5px;
            color: var(--text-700);
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        table.data-table tbody tr:last-child td { border-bottom: none; }

        table.data-table tbody tr {
            transition: background 0.1s;
        }

        table.data-table tbody tr:hover td {
            background: #f8faff;
        }

        table.data-table tfoot td {
            padding: 10px 16px;
            font-size: 13px;
            font-weight: 600;
            background: var(--bg-app);
            border-top: 2px solid var(--border);
            color: var(--text-900);
        }

        /* ── FORMS ── */
        .form-group { margin-bottom: 16px; }

        .form-label {
            display: block;
            font-size: 12.5px;
            font-weight: 500;
            color: var(--text-700);
            margin-bottom: 5px;
        }

        .form-label .req { color: var(--danger); margin-left: 2px; }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            background: var(--white);
            border: 1.5px solid var(--border-input);
            border-radius: var(--radius-sm);
            padding: 8px 12px;
            font-size: 13.5px;
            font-family: 'Inter', sans-serif;
            color: var(--text-900);
            transition: all 0.13s;
            outline: none;
            box-shadow: var(--shadow-xs);
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(37,99,235,.1);
        }

        .form-input:hover,
        .form-select:hover { border-color: #a0aec0; }

        .form-input::placeholder { color: var(--text-300); }

        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            padding-right: 28px;
        }

        .form-textarea { resize: vertical; min-height: 80px; }

        .form-error {
            font-size: 11.5px;
            color: var(--danger);
            margin-top: 4px;
        }

        .form-section {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text-700);
            padding-bottom: 10px;
            margin-bottom: 14px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* ── GRIDS ── */
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; }
        .grid-4 { display: grid; grid-template-columns: repeat(4,1fr); gap: 16px; }

        /* ── INLINE TABLE (lignes produits) ── */
        .inline-table {
            width: 100%;
            border-collapse: collapse;
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
        }

        .inline-table th {
            background: var(--bg-app);
            padding: 8px 12px;
            text-align: left;
            font-size: 10.5px;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--text-400);
            border-bottom: 1px solid var(--border);
        }

        .inline-table td {
            padding: 7px 10px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        .inline-table tbody tr:last-child td { border-bottom: none; }

        .inline-table tfoot td {
            padding: 9px 12px;
            background: var(--bg-app);
            border-top: 1.5px solid var(--border);
            font-weight: 700;
            color: var(--accent);
            font-size: 13px;
        }

        .inline-table input,
        .inline-table select {
            width: 100%;
            background: var(--white);
            border: 1.5px solid var(--border-input);
            border-radius: 5px;
            padding: 5px 8px;
            font-size: 13px;
            font-family: 'Inter', sans-serif;
            color: var(--text-900);
            outline: none;
            transition: border-color 0.13s;
            box-shadow: var(--shadow-xs);
        }

        .inline-table input:focus,
        .inline-table select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 2px rgba(37,99,235,.1);
        }

        /* ── DETAIL ROWS ── */
        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid var(--border);
            font-size: 13.5px;
        }
        .detail-row:last-child { border-bottom: none; }
        .detail-label { color: var(--text-400); font-weight: 500; }
        .detail-value { color: var(--text-900); font-weight: 500; text-align: right; }

        /* ── TTC BOX ── */
        .ttc-box {
            background: var(--accent-light);
            border: 1.5px solid var(--accent-mid);
            border-radius: var(--radius);
            padding: 12px 16px;
            font-size: 14px;
            color: var(--accent);
            font-weight: 700;
        }

        /* ── BACK LINK ── */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 13px;
            color: var(--text-400);
            text-decoration: none;
            margin-bottom: 16px;
            transition: color 0.12s;
            font-weight: 500;
        }
        .back-link:hover { color: var(--accent); }

        /* ── EMPTY STATE ── */
        .empty-state {
            text-align: center;
            padding: 48px 24px;
            color: var(--text-400);
        }
        .empty-state-icon { font-size: 28px; margin-bottom: 10px; opacity: 0.4; }
        .empty-state-text { font-size: 13px; font-weight: 500; }

        /* ── PAGINATION ── */
        nav[role="navigation"] { padding: 12px 16px; }
        .pagination { display: flex; flex-wrap: wrap; gap: 4px; }
        .pagination > * a,
        .pagination > * span {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            height: 30px;
            padding: 0 8px;
            border-radius: 5px;
            font-size: 12.5px;
            border: 1px solid var(--border);
            color: var(--text-500);
            text-decoration: none;
            background: var(--white);
            transition: all 0.12s;
        }
        .pagination > *.active span {
            background: var(--accent);
            border-color: var(--accent);
            color: white;
            font-weight: 600;
        }
        .pagination > * a:hover {
            border-color: var(--accent);
            color: var(--accent);
            background: var(--accent-light);
        }

        /* ── REGLER BOX ── */
        .regler-box {
            background: var(--success-bg);
            border: 1px solid var(--success-border);
            border-radius: var(--radius);
            padding: 16px;
            margin-top: 16px;
        }

        /* ── DIVIDER ── */
        .divider { height: 1px; background: var(--border); margin: 16px 0; }

        /* ── UTILITIES ── */
        .text-900    { color: var(--text-900)  !important; }
        .text-700    { color: var(--text-700)  !important; }
        .text-500    { color: var(--text-500)  !important; }
        .text-400    { color: var(--text-400)  !important; }
        .text-accent { color: var(--accent)    !important; }
        .text-success{ color: var(--success)   !important; }
        .text-danger { color: var(--danger)    !important; }
        .text-warning{ color: var(--warning)   !important; }
        .text-purple { color: var(--purple)    !important; }
        .text-info   { color: var(--info)      !important; }

        .fw-400 { font-weight: 400; }
        .fw-500 { font-weight: 500; }
        .fw-600 { font-weight: 600; }
        .fw-700 { font-weight: 700; }
        .fw-800 { font-weight: 800; }

        .font-mono {
            font-family: 'SF Mono', 'Fira Code', 'Cascadia Code', monospace;
            font-size: 12px;
        }

        .flex         { display: flex; }
        .flex-center  { display: flex; align-items: center; }
        .flex-between { display: flex; align-items: center; justify-content: space-between; }
        .flex-wrap    { flex-wrap: wrap; }
        .flex-col     { flex-direction: column; }
        .gap-4  { gap: 4px; }
        .gap-8  { gap: 8px; }
        .gap-12 { gap: 12px; }
        .gap-16 { gap: 16px; }

        .mb-4  { margin-bottom: 4px; }
        .mb-8  { margin-bottom: 8px; }
        .mb-12 { margin-bottom: 12px; }
        .mb-16 { margin-bottom: 16px; }
        .mb-20 { margin-bottom: 20px; }
        .mb-24 { margin-bottom: 24px; }
        .mt-8  { margin-top: 8px; }
        .mt-12 { margin-top: 12px; }
        .mt-16 { margin-top: 16px; }

        .w-full      { width: 100%; }
        .text-right  { text-align: right; }
        .text-center { text-align: center; }

        .truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* ── HOVER ACTIONS (show on row hover) ── */
        .actions-cell { white-space: nowrap; }
        .actions-cell .btn + .btn { margin-left: 4px; }

        /* ── SECTION BOX ── */
        .info-box {
            background: var(--bg-app);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 14px 16px;
        }

        /* ── BREADCRUMB ── */
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: var(--text-400);
            margin-bottom: 16px;
        }
        .breadcrumb a {
            color: var(--text-400);
            text-decoration: none;
            transition: color 0.12s;
        }
        .breadcrumb a:hover { color: var(--accent); }
        .breadcrumb-sep { color: var(--text-300); }
        .breadcrumb-current { color: var(--text-700); font-weight: 500; }
    </style>
</head>
<body>

<div class="app-shell">

    {{-- ══ SIDEBAR ══ --}}
    <aside class="sidebar">

        <div class="sidebar-brand">
            <div class="brand-logo">📦</div>
            <div class="brand-info">
                <div class="brand-name">Gestion Stock</div>
                <div class="brand-tenant">{{ auth()->user()->tenant->nom_entreprise ?? 'Entreprise' }}</div>
            </div>
        </div>

        <nav class="sidebar-nav">

            <a href="{{ route('dashboard') }}"
               class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <span class="nav-icon">⊞</span> Dashboard
            </a>

            @if(auth()->user()->hasAnyPermission(['appro.commandes.voir','appro.factures.voir','appro.bons-entree.voir']))
            <div class="nav-group-label">Approvisionnements</div>

            @can('appro.commandes.voir')
            <a href="{{ route('appro.commandes.index') }}"
               class="nav-link {{ request()->routeIs('appro.commandes.*') ? 'active' : '' }}">
                <span class="nav-icon">📋</span> Bons de commande
            </a>
            @endcan

            @can('appro.factures.voir')
            <a href="{{ route('appro.factures.index') }}"
               class="nav-link {{ request()->routeIs('appro.factures.*') ? 'active' : '' }}">
                <span class="nav-icon">🧾</span> Factures fournisseur
            </a>
            @endcan

            @can('appro.bons-entree.voir')
            <a href="{{ route('appro.bons-entree.index') }}"
               class="nav-link {{ request()->routeIs('appro.bons-entree.*') ? 'active' : '' }}">
                <span class="nav-icon">📥</span> Bons d'entrée / Dons
            </a>
            @endcan
            @endif

            @if(auth()->user()->hasAnyPermission(['ventes.commandes.voir','ventes.factures.voir','ventes.bons-sortie.voir']))
            <div class="nav-group-label">Ventes</div>

            @can('ventes.commandes.voir')
            <a href="{{ route('ventes.commandes.index') }}"
               class="nav-link {{ request()->routeIs('ventes.commandes.*') ? 'active' : '' }}">
                <span class="nav-icon">🛒</span> Commandes client
            </a>
            @endcan

            @can('ventes.factures.voir')
            <a href="{{ route('ventes.factures.index') }}"
               class="nav-link {{ request()->routeIs('ventes.factures.*') ? 'active' : '' }}">
                <span class="nav-icon">🧾</span> Factures client
            </a>
            @endcan

            @can('ventes.bons-sortie.voir')
            <a href="{{ route('ventes.bons-sortie.index') }}"
               class="nav-link {{ request()->routeIs('ventes.bons-sortie.*') ? 'active' : '' }}">
                <span class="nav-icon">📤</span> Bons de sortie
            </a>
            @endcan
            @endif

            @if(auth()->user()->hasAnyPermission(['produits.voir','familles.voir','fournisseurs.voir','clients.voir','categories.voir','banques.voir','versements.voir']))
            <div class="nav-group-label">Structure</div>

            @can('produits.voir')
            <a href="{{ route('produits.index') }}"
               class="nav-link {{ request()->routeIs('produits.*') ? 'active' : '' }}">
                <span class="nav-icon">📦</span> Produits
            </a>
            @endcan

            @can('familles.voir')
            <a href="{{ route('familles.index') }}"
               class="nav-link {{ request()->routeIs('familles.*') ? 'active' : '' }}">
                <span class="nav-icon">🗂</span> Familles
            </a>
            @endcan

            @can('fournisseurs.voir')
            <a href="{{ route('fournisseurs.index') }}"
               class="nav-link {{ request()->routeIs('fournisseurs.*') ? 'active' : '' }}">
                <span class="nav-icon">🏭</span> Fournisseurs
            </a>
            @endcan

            @can('clients.voir')
            <a href="{{ route('clients.index') }}"
               class="nav-link {{ request()->routeIs('clients.*') ? 'active' : '' }}">
                <span class="nav-icon">👥</span> Clients
            </a>
            @endcan

            @can('categories.voir')
            <a href="{{ route('categories.index') }}"
               class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                <span class="nav-icon">🏷</span> Catégories clients
            </a>
            @endcan

            @can('banques.voir')
            <a href="{{ route('banques.index') }}"
               class="nav-link {{ request()->routeIs('banques.*') ? 'active' : '' }}">
                <span class="nav-icon">🏦</span> Banques
            </a>
            @endcan

            @can('versements.voir')
            <a href="{{ route('versements.index') }}"
               class="nav-link {{ request()->routeIs('versements.*') ? 'active' : '' }}">
                <span class="nav-icon">💰</span> Versements
            </a>
            @endcan
            @endif

            @if(auth()->user()->hasAnyPermission(['rapports.achats','rapports.ventes','rapports.versements']))
            <div class="nav-group-label">Rapports</div>

            @can('rapports.achats')
            <a href="{{ route('rapports.achats-jour') }}"
               class="nav-link {{ request()->routeIs('rapports.achats*') ? 'active' : '' }}">
                <span class="nav-icon">📊</span> Achats
            </a>
            @endcan

            @can('rapports.ventes')
            <a href="{{ route('rapports.ventes-jour') }}"
               class="nav-link {{ request()->routeIs('rapports.ventes*') ? 'active' : '' }}">
                <span class="nav-icon">📈</span> Ventes
            </a>
            @endcan

            @can('rapports.versements')
            <a href="{{ route('rapports.versements-banque') }}"
               class="nav-link {{ request()->routeIs('rapports.versements*') ? 'active' : '' }}">
                <span class="nav-icon">🏦</span> Versements banque
            </a>
            @endcan
            @endif

            @role('Administrateur')
                <div class="nav-group-label">Administration</div>
                <a href="{{ route('utilisateurs.index') }}"
                class="nav-link {{ request()->routeIs('utilisateurs.*') ? 'active' : '' }}">
                    <span class="nav-icon">👤</span> Utilisateurs
                </a>
                <a href="{{ route('groupes.index') }}"
                class="nav-link {{ request()->routeIs('groupes.*') ? 'active' : '' }}">
                    <span class="nav-icon">🔐</span> Groupes & Droits
                </a>
                <a href="{{ route('archives.index') }}"
                class="nav-link {{ request()->routeIs('archives.*') ? 'active' : '' }}">
                    <span class="nav-icon">🗄</span> Archives XML
                </a>
            @endrole

        </nav>

        <div class="sidebar-footer">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div class="user-info">
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">{{ auth()->user()->getRoleNames()->first() ?? 'Utilisateur' }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn" title="Déconnexion">⏻</button>
            </form>
        </div>

    </aside>

    {{-- ══ MAIN AREA ══ --}}
    <div class="main-area">

        <header class="topbar">
            <div class="topbar-left">
                <span class="topbar-title">@yield('title', 'Dashboard')</span>
            </div>
            <div class="topbar-right">
                <span class="topbar-date">{{ now()->isoFormat('ddd D MMM YYYY') }}</span>
            </div>
        </header>

        <div class="alerts-zone">
            @if(session('success'))
            <div class="alert alert-success">
                <span>✓ &nbsp;{{ session('success') }}</span>
                <button class="alert-close" onclick="this.parentElement.remove()">×</button>
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-error">
                <span>✕ &nbsp;{{ session('error') }}</span>
                <button class="alert-close" onclick="this.parentElement.remove()">×</button>
            </div>
            @endif
            @if($errors->any())
            <div class="alert alert-error">
                <div>
                    @foreach($errors->all() as $error)
                        <div>✕ &nbsp;{{ $error }}</div>
                    @endforeach
                </div>
                <button class="alert-close" onclick="this.parentElement.remove()">×</button>
            </div>
            @endif
        </div>

        <main class="page-content">
            @yield('content')
        </main>

    </div>
</div>

</body>
</html>
