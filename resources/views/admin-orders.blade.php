<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Work Orders | Admin</title>
    <style>
        :root {
            color-scheme: light;
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: #f4f6fb;
            color: #1f2937;
        }
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; background: #f4f6fb; }
        a { color: inherit; text-decoration: none; }
        .layout { display: grid; grid-template-columns: 280px 1fr; min-height: 100vh; }
        .sidebar { background: #111827; color: #f9fafb; padding: 2rem 1.5rem; display: flex; flex-direction: column; gap: 2rem; }
        .brand { display: flex; align-items: center; gap: 0.75rem; font-size: 1.25rem; font-weight: 700; }
        .brand-mark { width: 2rem; height: 2rem; border-radius: 0.75rem; background: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%); display: grid; place-items: center; color: white; font-size: 1rem; }
        .nav { display: grid; gap: 0.5rem; }
        .nav a { display: block; padding: 0.85rem 1rem; border-radius: 0.75rem; color: #d1d5db; transition: background 0.2s ease, color 0.2s ease; }
        .nav a:hover, .nav a.active { background: rgba(255,255,255,0.08); color: #f9fafb; }
        .content { padding: 2rem; }
        .topbar { display: flex; justify-content: space-between; align-items: center; gap: 1rem; margin-bottom: 2rem; }
        .topbar h1 { margin: 0; font-size: clamp(1.75rem, 2.25vw, 2.5rem); }
        .topbar p { margin: 0.25rem 0 0; color: #4b5563; }
        .badge { padding: 0.65rem 1rem; background: #e0f2fe; color: #0369a1; border-radius: 9999px; font-size: 0.9rem; font-weight: 600; }
        .filter-panel { background: white; border-radius: 1rem; padding: 1.5rem; box-shadow: 0 15px 35px rgba(15, 23, 42, 0.06); margin-bottom: 2rem; }
        .filter-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1rem; align-items: end; }
        .filter-grid label { display: block; font-weight: 700; color: #334155; margin-bottom: 0.5rem; }
        .filter-grid input, .filter-grid select { width: 100%; padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid #cbd5e1; background: #f8fafc; color: #0f172a; }
        .filter-actions { grid-column: 1 / -1; display: flex; flex-wrap: wrap; gap: 0.75rem; align-items: center; justify-content: flex-start; }
        .filter-actions button, .filter-actions a { display: inline-flex; align-items: center; justify-content: center; padding: 0.85rem 1rem; border-radius: 0.75rem; font-weight: 700; }
        .filter-actions button { background: #2563eb; color: white; border: none; cursor: pointer; }
        .filter-actions a { background: #e2e8f0; color: #0f172a; text-decoration: none; }
        .table-wrapper { overflow-x: auto; -webkit-overflow-scrolling: touch; border-radius: 1rem; }
        .section { margin-bottom: 2rem; }
        .section h2 { margin: 0 0 1rem; font-size: 1.125rem; font-weight: 700; }
        .table { width: 100%; border-collapse: collapse; background: white; border-radius: 1rem; overflow: hidden; box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08); }
        .table thead { background: #f8fafc; }
        .table th, .table td { padding: 1rem 1.25rem; text-align: left; border-bottom: 1px solid #e5e7eb; font-size: 0.95rem; }
        .table th { color: #6b7280; font-weight: 700; }
        .table tbody tr:last-child td { border-bottom: none; }
        .clickable-row { cursor: pointer; transition: background 0.2s ease, transform 0.1s ease; }
        .clickable-row:hover { background: #f8fafc; }
        .clickable-row:active { transform: translateY(1px); }
        .clickable-row td { position: relative; }
        .clickable-row td::after { content: ""; position: absolute; inset: 0; z-index: 0; }
        .table tbody tr td > * { position: relative; z-index: 1; }
        .status { display: inline-flex; padding: 0.35rem 0.75rem; border-radius: 9999px; font-size: 0.8rem; font-weight: 700; }
        .status.open { background: #dcfce7; color: #166534; }
        .status.pending { background: #fef3c7; color: #92400e; }
        .status.completed { background: #dbeafe; color: #1d4ed8; }
        @media (max-width: 920px) { .layout { grid-template-columns: 1fr; } .sidebar { flex-direction: row; flex-wrap: wrap; justify-content: space-between; } .nav { width: 100%; grid-template-columns: repeat(2, minmax(0, 1fr)); } .filter-grid { grid-template-columns: 1fr; } .filter-actions { justify-content: stretch; } .filter-actions button, .filter-actions a { width: 100%; } }
    </style>
</head>
<body>
    <div class="layout">
        <aside class="sidebar">
            <div>
                <div class="brand">
                    <span class="brand-mark">W</span>
                    <span>WorkOrder Admin</span>
                </div>
                <p style="margin-top:1rem; color:#9ca3af; line-height:1.6;">Manage all work orders and quickly find details from the admin panel.</p>
            </div>
            <nav class="nav">
                <a href="/admin">Dashboard</a>
                <a href="/admin/orders" class="active">Work Orders</a>
                <a href="#reports">Reports</a>
            </nav>
        </aside>
        <main class="content">
            <div class="topbar">
                <div>
                    <h1>Work Orders</h1>
                    <p>Filter and browse all work orders from the admin panel.</p>
                </div>
                <div class="badge">Online</div>
            </div>

            <section class="filter-panel">
                <form method="GET" action="/admin/orders">
                    <div class="filter-grid">
                        <div>
                            <label for="search">Cari</label>
                            <input id="search" name="search" type="text" value="{{ $filters['search'] ?? '' }}" placeholder="Nomor WO, departemen, jenis, deskripsi">
                        </div>
                        <div>
                            <label for="department">Departemen</label>
                            <select id="department" name="department">
                                <option value="">Semua departemen</option>
                                @foreach(["FB Kitchen","Housekeeping","Front Office","DT","FB Service","P&C","Security","Sales","Acct","A&G"] as $department)
                                    <option value="{{ $department }}" {{ (isset($filters['department']) && $filters['department'] === $department) ? 'selected' : '' }}>{{ $department }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="issue_type">Jenis Masalah</label>
                            <select id="issue_type" name="issue_type">
                                <option value="">Semua jenis</option>
                                @foreach(["ELECTRICAL","MECHANICAL","PLUMBING","HVAC","BUILDING","FURNITURE","AV","SAFETY","OTHER"] as $type)
                                    <option value="{{ $type }}" {{ (isset($filters['issue_type']) && $filters['issue_type'] === $type) ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="status">Status</label>
                            <select id="status" name="status">
                                <option value="">Semua status</option>
                                <option value="Pending" {{ (isset($filters['status']) && $filters['status'] === 'Pending') ? 'selected' : '' }}>Pending</option>
                                <option value="On Progress" {{ (isset($filters['status']) && $filters['status'] === 'On Progress') ? 'selected' : '' }}>On Progress</option>
                                <option value="Completed" {{ (isset($filters['status']) && $filters['status'] === 'Completed') ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                        <div>
                            <label for="from_date">Dari Tanggal</label>
                            <input id="from_date" name="from_date" type="date" value="{{ $filters['from_date'] ?? '' }}">
                        </div>
                        <div>
                            <label for="to_date">Sampai Tanggal</label>
                            <input id="to_date" name="to_date" type="date" value="{{ $filters['to_date'] ?? '' }}">
                        </div>
                        <div class="filter-actions">
                            <button type="submit">Terapkan</button>
                            <a href="/admin/orders">Reset</a>
                        </div>
                    </div>
                </form>
            </section>

            <section class="section">
                <h2>Daftar Work Orders</h2>
                <div class="table-wrapper">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nomor WO</th>
                                <th>Departemen</th>
                                <th>Jenis Masalah</th>
                                <th>Lokasi</th>
                                <th>Status</th>
                                <th>Dibuat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($workOrders as $order)
                                <tr class="clickable-row" data-href="/admin/order/{{ $order->id }}">
                                    <td><strong>{{ $order->wo_number }}</strong></td>
                                    <td>{{ $order->department }}</td>
                                    <td>{{ $order->issue_type }}</td>
                                    <td>{{ $order->location ?? '-' }}</td>
                                    <td>
                                        @if($order->status === 'Pending')
                                            <span class="status pending">{{ $order->status }}</span>
                                        @elseif($order->status === 'On Progress')
                                            <span class="status open">{{ $order->status }}</span>
                                        @else
                                            <span class="status completed">{{ $order->status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ date('d/m/Y H:i', strtotime($order->created_at)) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align:center; padding:2rem; color:#6b7280;">Tidak ada work order untuk filter ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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
