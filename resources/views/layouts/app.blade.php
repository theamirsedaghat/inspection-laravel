
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'InspectPro')</title>

    <style>
        :root {
            --bg: #0b1020;
            --panel: #141d32;
            --border: #293653;
            --text: #e8ecf8;
            --muted: #99a7c2;
            --accent: #8b7cf6;
            --danger: #ef6464;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--bg);
            color: var(--text);
            font-family: Arial, sans-serif;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .app {
            display: flex;
            min-height: 100vh;
            align-items: stretch;
        }

        /* Sidebar */
        .sidebar {
            width: 245px;
            min-width: 245px;
            padding: 28px 16px;
            background: #10172a;
            border-right: 1px solid var(--border);
            flex-shrink: 0;
            align-self: stretch;
        }

        .brand {
            font-size: 23px;
            font-weight: 800;
            margin: 0 0 35px 10px;
        }

        .brand span {
            color: var(--accent);
        }

        .nav-label {
            color: var(--muted);
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .7px;
            margin: 24px 10px 10px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 11px;
            width: 100%;
            min-height: 42px;
            padding: 11px 12px;
            border-radius: 9px;
            color: #b5bfd5;
            margin: 4px 0;
            font-size: 14px;
            line-height: 1.5;
            overflow-wrap: anywhere;
            transition: background .2s, color .2s;
        }

        .nav-link:hover,
        .nav-link.active {
            background: #292747;
            color: white;
        }

        .nav-icon {
            width: 22px;
            min-width: 22px;
            text-align: center;
            color: #b7aaff;
            font-weight: bold;
        }

        .nav-link.pending {
            color: #8491aa;
            cursor: default;
        }

        /* Main content */
        .main {
            flex: 1;
            min-width: 0;
            width: 0;
        }

        .topbar {
            min-height: 59px;
            padding: 18px 30px;
            border-bottom: 1px solid var(--border);
            background: #10172a;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
        }

        .content {
            width: 100%;
            max-width: 1600px;
            padding: 30px;
            margin: 0 auto;
        }

        h1 {
            font-size: 28px;
            margin: 0 0 8px;
        }

        h2 {
            font-size: 19px;
        }

        .muted {
            color: var(--muted);
        }

        /* Panels and statistics */
        .panel,
        .stat {
            background: var(--panel);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 22px;
            margin-bottom: 22px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin: 25px 0;
        }

        .stat-value {
            font-size: 30px;
            font-weight: 800;
            margin-top: 12px;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 11px 15px;
            border: 0;
            border-radius: 8px;
            background: var(--accent);
            color: white;
            cursor: pointer;
            font-size: 14px;
            line-height: 1.4;
        }

        .btn:hover {
            filter: brightness(1.12);
        }

        .btn-secondary {
            background: #28334d;
        }

        .btn-danger {
            background: #8e343e;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 9px;
        }

        /* Forms */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 8px;
            min-width: 0;
        }

        .field.full {
            grid-column: 1 / -1;
        }

        label {
            color: #cbd4e7;
            font-size: 14px;
        }

        input,
        select,
        textarea {
            width: 100%;
            background: #0d1426;
            color: var(--text);
            border: 1px solid #35415e;
            border-radius: 8px;
            padding: 12px;
            font: inherit;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: 2px solid var(--accent);
            outline-offset: 1px;
        }

        /* Tables */
        .table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 700px;
        }

        th,
        td {
            text-align: left;
            padding: 15px 12px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        th {
            color: var(--muted);
            font-size: 12px;
        }

        /* Status and messages */
        .status {
            display: inline-block;
            border-radius: 20px;
            background: #292747;
            color: #d2caff;
            padding: 6px 10px;
            font-size: 12px;
        }

        .alert {
            background: #28334d;
            border: 1px solid #455574;
            padding: 14px;
            border-radius: 9px;
            margin-bottom: 18px;
        }

        .error {
            color: #ff9292;
            font-size: 13px;
        }

        /* Dashboard cards */
        .dashboard {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .dashboard-hero {
            background: linear-gradient(120deg, #211b3a, #171522);
            border: 1px solid #373052;
            border-radius: 18px;
            padding: 30px;
            margin-bottom: 22px;
        }

        .dashboard-hero p {
            color: #b6b0ce;
            line-height: 1.8;
        }

        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
        }

        .dashboard-api-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
        }

        .dashboard-stat,
        .dashboard-card {
            min-width: 0;
            padding: 22px;
            border: 1px solid #302b43;
            border-radius: 15px;
            background: #191724;
        }

        .dashboard-stat small,
        .dashboard-card p {
            color: #aaa4c2;
            line-height: 1.7;
        }

        .dashboard-stat strong {
            display: block;
            font-size: 30px;
            margin-top: 12px;
        }

        .dashboard-card {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
            transition: transform .2s, border-color .2s;
        }

        a.dashboard-card:hover {
            transform: translateY(-3px);
            border-color: var(--accent);
        }

        .dashboard-card h3 {
            font-size: 17px;
            margin: 0;
        }

        .dashboard-card p {
            margin: 0;
            flex: 1;
        }

        .dashboard-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: #30254e;
            color: #c7baff;
            font-size: 21px;
        }

        .dashboard-link {
            color: #c3b5ff;
            font-weight: bold;
            margin-top: 8px;
        }

        @media (max-width: 1200px) {
            .dashboard-api-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .dashboard-stats,
            .stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 900px) {
            .sidebar {
                width: 210px;
                min-width: 210px;
                padding: 22px 12px;
            }

            .content {
                padding: 22px;
            }

            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 650px) {
            .app {
                display: block;
            }

            .sidebar {
                width: 100%;
                min-width: 0;
                padding: 18px;
                border-right: 0;
                border-bottom: 1px solid var(--border);
            }

            .brand {
                margin-bottom: 20px;
            }

            .nav-label {
                margin-top: 16px;
            }

            .topbar {
                padding: 16px 18px;
            }

            .content {
                padding: 16px;
            }

            .stats,
            .form-grid,
            .dashboard-stats,
            .dashboard-grid,
            .dashboard-api-grid {
                grid-template-columns: 1fr;
            }

            .field.full {
                grid-column: auto;
            }

            .dashboard-hero {
                padding: 22px;
            }
        }
    </style>
</head>

<body>
<div class="app">

    {{-- Sidebar: navigation only --}}
    <aside class="sidebar">
        <div class="brand">Inspect<span>Pro</span></div>


<nav>
    <div class="nav-label">WORKSPACE</div>

    <a href="{{ route('dashboard') }}" class="nav-link">
        <span class="nav-icon">⌂</span>
        Dashboard
    </a>

    <div class="nav-label">INSPECTION TYPES</div>
    <a href="{{ route('inspection-types.index') }}" class="nav-link">
        <span class="nav-icon">◈</span>
        All Inspection Types
    </a>
    <a href="{{ route('inspection-types.create') }}" class="nav-link">
        <span class="nav-icon">＋</span>
        Add New Type
    </a>

    <div class="nav-label">INSPECTION PLANS</div>
    <a href="{{ route('inspection-plans.index') }}" class="nav-link">
        <span class="nav-icon">▦</span>
        All Inspection Plans
    </a>
    <a href="{{ route('inspection-plans.create') }}" class="nav-link">
        <span class="nav-icon">＋</span>
        Create New Plan
    </a>

    <div class="nav-label">INSPECTIONS</div>
    <a href="{{ route('inspections.index') }}" class="nav-link">
        <span class="nav-icon">✓</span>
        All Inspections
    </a>
    <a href="{{ route('inspections.create') }}" class="nav-link">
        <span class="nav-icon">＋</span>
        Create Inspection
    </a>

    <div class="nav-label">ITEMS & FINDINGS</div>
    <a href="{{ route('inspections.index') }}" class="nav-link">
        <span class="nav-icon">☷</span>
        Manage Inspection Items
    </a>
    <a href="{{ route('inspections.index') }}" class="nav-link">
        <span class="nav-icon">⚑</span>
        Manage Findings
    </a>

    <div class="nav-label">API TESTING</div>
    <a href="{{ url('/api/v1/inspection-types') }}" class="nav-link" target="_blank" rel="noopener">
        <span class="nav-icon">{ }</span>
        Types API
    </a>
    <a href="{{ url('/api/v1/inspection-plans') }}" class="nav-link" target="_blank" rel="noopener">
        <span class="nav-icon">{ }</span>
        Plans API
    </a>
    <a href="{{ url('/api/v1/inspections') }}" class="nav-link" target="_blank" rel="noopener">
        <span class="nav-icon">{ }</span>
        Inspections API
    </a>
    <a href="{{ url('/api/v1/inspectors') }}" class="nav-link" target="_blank" rel="noopener">
        <span class="nav-icon">{ }</span>
        Inspectors API
    </a>
</nav>

    </aside>
    {{-- IMPORTANT: Sidebar ends here. Main content is outside it. --}}

    <div class="main">
        <header class="topbar">
            <strong>@yield('heading', 'Inspection Management')</strong>
            <span class="muted">Inspection Service</span>
        </header>

        <main class="content">
            @if (session('success'))
                <div class="alert">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert">
                    <strong>Please correct these errors:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="error">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</div>

@stack('scripts')
</body>
</html>
