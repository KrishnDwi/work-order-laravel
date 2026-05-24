<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Panel | Work Order</title>
    <style>
        :root {
            color-scheme: light;
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: #f4f6fb;
            color: #1f2937;
        }
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            min-height: 100vh;
            background: #f4f6fb;
        }
        a {
            color: inherit;
            text-decoration: none;
        }
        .layout {
            display: grid;
            grid-template-columns: 280px 1fr;
            min-height: 100vh;
        }
        .sidebar {
            background: #111827;
            color: #f9fafb;
            padding: 2rem 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }
        .brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.25rem;
            font-weight: 700;
        }
        .brand-mark {
            width: 2rem;
            height: 2rem;
            border-radius: 0.75rem;
            background: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%);
            display: grid;
            place-items: center;
            color: white;
            font-size: 1rem;
        }
        .nav {
            display: grid;
            gap: 0.5rem;
        }
        .nav a {
            display: block;
            padding: 0.85rem 1rem;
            border-radius: 0.75rem;
            color: #d1d5db;
            transition: background 0.2s ease, color 0.2s ease;
        }
        .nav a:hover,
        .nav a.active {
            background: rgba(255, 255, 255, 0.08);
            color: #f9fafb;
        }
        .content {
            padding: 2rem;
        }
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .topbar h1 {
            margin: 0;
            font-size: clamp(1.75rem, 2.25vw, 2.5rem);
        }
        .topbar p {
            margin: 0.25rem 0 0;
            color: #4b5563;
        }
        .badge {
            padding: 0.65rem 1rem;
            background: #e0f2fe;
            color: #0369a1;
            border-radius: 9999px;
            font-size: 0.9rem;
            font-weight: 600;
        }
        .grid-cards {
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            margin-bottom: 2rem;
        }
        .card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
            border: 1px solid rgba(148, 163, 184, 0.12);
        }
        .card h2 {
            margin: 0;
            font-size: 1rem;
            color: #6b7280;
            font-weight: 600;
        }
        .card .value {
            margin-top: 1rem;
            font-size: 2.25rem;
            font-weight: 700;
            color: #111827;
        }
        .card small {
            display: block;
            margin-top: 0.75rem;
            color: #6b7280;
        }
        .filter-panel {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 15px 35px rgba(15, 23, 42, 0.06);
            margin-bottom: 2rem;
        }
        .filter-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
            align-items: end;
        }
        .filter-grid label {
            display: block;
            font-weight: 700;
            color: #334155;
            margin-bottom: 0.5rem;
        }
        .filter-grid input,
        .filter-grid select {
            width: 100%;
            padding: 0.85rem 1rem;
            border-radius: 0.75rem;
            border: 1px solid #cbd5e1;
            background: #f8fafc;
            color: #0f172a;
        }
        .filter-actions {
            grid-column: 1 / -1;
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            align-items: center;
            justify-content: flex-start;
        }
        .filter-actions button,
        .filter-actions a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.85rem 1rem;
            border-radius: 0.75rem;
            font-weight: 700;
        }
        .filter-actions button {
            background: #2563eb;
            color: white;
            border: none;
            cursor: pointer;
        }
        .filter-actions a {
            background: #e2e8f0;
            color: #0f172a;
            text-decoration: none;
        }
        .table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            border-radius: 1rem;
        }
        @media (max-width: 920px) {
            .layout {
                grid-template-columns: 1fr;
            }
            .sidebar {
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: space-between;
            }
            .nav {
                width: 100%;
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
            .filter-grid {
                grid-template-columns: 1fr;
            }
            .filter-actions {
                justify-content: stretch;
            }
            .filter-actions button,
            .filter-actions a {
                width: 100%;
            }
        }
        .section {
            margin-bottom: 2rem;
        }
        .section h2 {
            margin: 0 0 1rem;
            font-size: 1.125rem;
            font-weight: 700;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
        }
        .table thead {
            background: #f8fafc;
        }
        .table th,
        .table td {
            padding: 1rem 1.25rem;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
            font-size: 0.95rem;
        }
        .table th {
            color: #6b7280;
            font-weight: 700;
        }
        .table tbody tr:last-child td {
            border-bottom: none;
        }
        .clickable-row {
            cursor: pointer;
            transition: background 0.2s ease, transform 0.1s ease;
        }
        .clickable-row:hover {
            background: #f8fafc;
        }
        .clickable-row:active {
            transform: translateY(1px);
        }
        .clickable-row td {
            position: relative;
        }
        .clickable-row td::after {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 0;
        }
        .table tbody tr td > * {
            position: relative;
            z-index: 1;
        }
        .status {
            display: inline-flex;
            padding: 0.35rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 700;
        }
        .status.open { background: #dcfce7; color: #166534; }
        .status.pending { background: #fef3c7; color: #92400e; }
        .status.completed { background: #dbeafe; color: #1d4ed8; }
        .status-form {
            display: flex;
            gap: 0.5rem;
            align-items: center;
            flex-wrap: wrap;
        }
        .status-form select {
            border: 1px solid #cbd5e1;
            border-radius: 0.75rem;
            background: #f8fafc;
            color: #0f172a;
            padding: 0.65rem 0.8rem;
            min-width: 10rem;
        }
        .status-form button {
            border: none;
            border-radius: 0.75rem;
            background: #2563eb;
            color: white;
            padding: 0.65rem 1rem;
            cursor: pointer;
            font-weight: 700;
        }
        .status-form button:hover {
            background: #1d4ed8;
        }
        @media (max-width: 920px) {
            .layout {
                grid-template-columns: 1fr;
            }
            .sidebar {
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: space-between;
            }
            .nav {
                width: 100%;
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }
    </style>
</head>
<body>
    <div class="layout">
        @include('partials.sidebar')
        <main class="content">
            <div class="topbar">
                <div>
                    <h1>Admin Dashboard</h1>
                    <p>Overview of current operations and recent activity.</p>
                </div>
                <div class="badge">Online</div>
            </div>

            @if(session('status'))
                <div style="margin-bottom:1.5rem; padding:1rem 1.25rem; background:#dcfce7; border:1px solid #bef264; color:#166534; border-radius:0.75rem;">
                    {{ session('status') }}
                </div>
            @endif
            <section class="grid-cards">
                <article class="card">
                    <h2>Total Work Orders</h2>
                    <div class="value">{{ $workOrders->count() }}</div>
                    <small>Jumlah semua work order</small>
                </article>
                <article class="card">
                    <h2>Pending</h2>
                    <div class="value">{{ $workOrders->where('status', 'Pending')->count() }}</div>
                    <small>Work order dengan status Pending</small>
                </article>
                <article class="card">
                    <h2>On Progress</h2>
                    <div class="value">{{ $workOrders->where('status', 'On Progress')->count() }}</div>
                    <small>Work order yang sedang dikerjakan</small>
                </article>
                <article class="card">
                    <h2>Completed</h2>
                    <div class="value">{{ $workOrders->where('status', 'Completed')->count() }}</div>
                    <small>Work order yang selesai</small>
                </article>
            </section>


            <footer style="color:#6b7280; font-size:0.95rem; padding-top:1rem; border-top:1px solid #e5e7eb;">
                Work Order Admin • {{ date('Y') }}
            </footer>
        </main>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.clickable-row').forEach(function (row) {
                row.addEventListener('click', function () {
                    var href = row.getAttribute('data-href');
                    if (href) {
                        window.location.href = href;
                    }
                });
                row.addEventListener('keypress', function (event) {
                    if (event.key === 'Enter' || event.key === ' ') {
                        var href = row.getAttribute('data-href');
                        if (href) {
                            window.location.href = href;
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
