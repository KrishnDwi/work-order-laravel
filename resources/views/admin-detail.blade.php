<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Work Order | Admin</title>
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
        .card { background: white; border-radius: 1rem; padding: 1.5rem; box-shadow: 0 20px 50px rgba(15,23,42,0.08); border: 1px solid rgba(148,163,184,0.12); margin-bottom: 1.5rem; }
        .card h2 { margin: 0 0 1rem; font-size: 1.125rem; font-weight: 700; }
        .card p { margin: 0.6rem 0; line-height: 1.6; color: #334155; }
        .details-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1rem; margin-bottom: 1.5rem; }
        .details-grid div { background: #f8fafc; border-radius: 0.85rem; padding: 1rem; }
        .details-grid strong { display: block; font-weight: 700; margin-bottom: 0.35rem; }
        .status-form { display: flex; flex-wrap: wrap; gap: 0.75rem; align-items: center; }
        .status-form select { border: 1px solid #cbd5e1; border-radius: 0.75rem; background: #f8fafc; color: #0f172a; padding: 0.85rem 1rem; min-width: 12rem; }
        .status-form button { border: none; border-radius: 0.75rem; background: #2563eb; color: white; padding: 0.85rem 1.25rem; cursor: pointer; font-weight: 700; }
        .status-form button:hover { background: #1d4ed8; }
        .status { display: inline-flex; padding: 0.35rem 0.75rem; border-radius: 9999px; font-size: 0.8rem; font-weight: 700; }
        .status.open { background: #dcfce7; color: #166534; }
        .status.pending { background: #fef3c7; color: #92400e; }
        .status.completed { background: #dbeafe; color: #1d4ed8; }
        .back-link { display: inline-flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem; color: #2563eb; }
        .message { margin-bottom: 1rem; padding: 1rem 1.25rem; border-radius: 0.75rem; background: #dcfce7; color: #166534; border: 1px solid #86efac; }
        @media (max-width: 920px) { .layout { grid-template-columns: 1fr; } .sidebar { flex-direction: row; flex-wrap: wrap; justify-content: space-between; } .nav { width: 100%; grid-template-columns: repeat(2, minmax(0, 1fr)); } .details-grid { grid-template-columns: 1fr; } }
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
                <p style="margin-top:1rem; color:#9ca3af; line-height:1.6;">Manage work orders, users, reports, and system settings from a single dashboard.</p>
            </div>
            <nav class="nav">
                <a href="/admin">Dashboard</a>
                <a href="/admin/orders" class="active">Work Orders</a>
                <a href="#details">Reports</a>
            </nav>
        </aside>
        <main class="content">
            <div class="topbar">
                <div>
                    <h1>Detail Work Order</h1>
                    <p>Ubah status dan lihat informasi lengkap work order.</p>
                </div>
            </div>
            <a href="/admin/orders" class="back-link">← Kembali ke Daftar Work Order</a>
            @if(session('status'))
                <div class="message">{{ session('status') }}</div>
            @endif
            <div class="card" id="details">
                <h2>{{ $order->wo_number }}</h2>
                <div class="details-grid">
                    <div>
                        <strong>Departemen</strong>
                        <p>{{ $order->department }}</p>
                    </div>
                    <div>
                        <strong>Jenis Masalah</strong>
                        <p>{{ $order->issue_type }}</p>
                    </div>
                    <div>
                        <strong>Status saat ini</strong>
                        <p><span class="status {{ strtolower(str_replace(' ', '-', $order->status)) }}">{{ $order->status }}</span></p>
                    </div>
                    <div>
                        <strong>Dibuat pada</strong>
                        <p>{{ date('d/m/Y H:i', strtotime($order->created_at)) }}</p>
                    </div>
                </div>
                <div>
                    <strong>Deskripsi</strong>
                    <p>{{ $order->description ?: 'Tidak ada deskripsi tambahan.' }}</p>
                </div>
            </div>
            <div class="card">
                <h2>Ubah Status Work Order</h2>
                <form class="status-form" method="POST" action="/admin/order/{{ $order->id }}/update-status">
                    @csrf
                    <select name="status">
                        <option value="Pending" {{ $order->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="On Progress" {{ $order->status === 'On Progress' ? 'selected' : '' }}>On Progress</option>
                        <option value="Completed" {{ $order->status === 'Completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    <button type="submit">Simpan Perubahan</button>
                </form>
            </div>
            <footer style="color:#6b7280; font-size:0.95rem; padding-top:1rem; border-top:1px solid #e5e7eb;">
                Work Order Admin • {{ date('Y') }}
            </footer>
        </main>
    </div>
</body>
</html>
