<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard Registrasi' }}</title>
    <style>
        :root {
            --bg: #f4f6fb;
            --card: #ffffff;
            --text: #1f2a44;
            --muted: #5f6c8a;
            --primary: #1f4fe0;
            --danger: #c62828;
            --border: #d8e0f3;
            --success-bg: #e8f7ed;
            --success-text: #17663a;
            --error-bg: #fde8e8;
            --error-text: #8f1d1d;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: radial-gradient(circle at top right, #dfe9ff, var(--bg) 50%);
            color: var(--text);
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 14px 22px;
            background: #14213d;
            color: #fff;
            position: sticky;
            top: 0;
            z-index: 20;
        }

        .topbar h1 {
            margin: 0;
            font-size: 18px;
            letter-spacing: 0.3px;
        }

        .topbar a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
        }

        .wrap {
            max-width: 1200px;
            margin: 28px auto;
            padding: 0 16px 28px;
        }

        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 10px 24px rgba(31, 42, 68, 0.08);
        }

        .flash,
        .error-box {
            border-radius: 10px;
            padding: 12px 14px;
            margin-bottom: 16px;
            font-size: 14px;
        }

        .flash {
            background: var(--success-bg);
            color: var(--success-text);
            border: 1px solid #b5dfc5;
        }

        .error-box {
            background: var(--error-bg);
            color: var(--error-text);
            border: 1px solid #f1bcbc;
        }

        .btn,
        button {
            border: none;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .btn-primary {
            background: var(--primary);
            color: #fff;
        }

        .btn-secondary {
            background: #eef2ff;
            color: #223266;
            border: 1px solid #c9d6ff;
        }

        .btn-danger {
            background: #fff;
            color: var(--danger);
            border: 1px solid #f3b5b5;
        }

        form.inline {
            display: inline;
        }

        input,
        select,
        textarea {
            width: 100%;
            border: 1px solid #c9d3ec;
            border-radius: 10px;
            padding: 10px 12px;
            font-size: 14px;
            color: var(--text);
            background: #fff;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #7ca3ff;
            box-shadow: 0 0 0 3px rgba(31, 79, 224, 0.15);
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .field.full {
            grid-column: 1 / -1;
        }

        .field label {
            font-size: 13px;
            color: var(--muted);
            font-weight: 600;
        }

        .field .error {
            font-size: 12px;
            color: var(--danger);
        }

        .muted {
            color: var(--muted);
            font-size: 13px;
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
            margin-top: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 980px;
        }

        th,
        td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #e7ebf7;
            font-size: 13px;
            vertical-align: top;
        }

        th {
            color: #374470;
            background: #f8faff;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .toolbar {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 12px;
        }

        .toolbar .actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .pagination {
            margin-top: 14px;
        }

        .checkbox-row {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .checkbox-row input[type="checkbox"] {
            width: 16px;
            height: 16px;
            margin: 0;
        }

        @media (max-width: 768px) {
            .grid {
                grid-template-columns: 1fr;
            }

            .topbar {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>
    @php
        $isDashboardLoggedIn = session('dashboard.authenticated', false);
    @endphp

    <header class="topbar">
        <h1>Dashboard Registrasi MBMT</h1>
        @if ($isDashboardLoggedIn)
            <div style="display:flex; gap:10px; align-items:center;">
                <a href="{{ route('dashboard.registrations.index') }}">Data Pendaftar</a>
                <form method="POST" action="{{ route('dashboard.logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="btn btn-secondary">Logout</button>
                </form>
            </div>
        @endif
    </header>

    <main class="wrap">
        <div class="card">
            @if (session('status'))
                <div class="flash">{{ session('status') }}</div>
            @endif

            @if (session('error'))
                <div class="error-box">{{ session('error') }}</div>
            @endif

            @if ($errors->any())
                <div class="error-box">
                    <strong>Periksa data berikut:</strong>
                    <ul style="margin: 8px 0 0 18px; padding: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>
</body>

</html>
