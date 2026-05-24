<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Work Order - Admin</title>
    <style>
        :root {
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: #f8fafc;
            color: #111827;
        }
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; background: #f1f5f9; }
        a { color: inherit; text-decoration: none; }
        
        /* Layout Struktur Utama */
        .wrapper { display: flex; min-height: 100vh; }
        
        /* Sidebar Navigasi Kiri */
        .sidebar {
            width: 280px; 
            background: #111827; 
            color: #f9fafb; 
            padding: 2rem 1.5rem;
            position: fixed; 
            top: 0; 
            bottom: 0; 
            left: 0; 
            display: flex; 
            flex-direction: column;
            gap: 2rem; 
            box-shadow: 4px 0 12px rgba(0,0,0,0.05); 
            z-index: 100;
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

/* Sesuaikan margin area konten karena lebar sidebar berubah dari 260px menjadi 280px */
.main-content { flex: 1; margin-left: 280px; padding: 2rem 2.5rem; max-width: calc(100% - 280px); }
        
        /* Area Konten Utama (Kanan) */
        .main-content { flex: 1; margin-left: 260px; padding: 2rem 2.5rem; max-width: calc(100% - 260px); }
        
        .header-title { margin-bottom: 2rem; }
        .header-title h1 { margin: 0 0 0.5rem; font-size: 2rem; color: #0f172a; }
        .header-title p { margin: 0; color: #475569; }

        /* Filter Form */
        .filter-bar {
            background: white; padding: 1.25rem; border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.03); border: 1px solid #e2e8f0;
            margin-bottom: 2rem; display: flex; gap: 1rem; align-items: flex-end; flex-wrap: wrap;
        }
        .filter-bar .group { flex: 1; min-width: 200px; }
        .filter-bar label { display: block; font-size: 0.85rem; font-weight: 600; color: #475569; margin-bottom: 0.5rem; }
        .filter-bar input { width: 100%; padding: 0.75rem 1rem; border-radius: 0.5rem; border: 1px solid #cbd5e1; background: #f8fafc;}
        .filter-bar button { padding: 0.75rem 1.5rem; background: #2563eb; color: white; border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer; transition: 0.2s; }
        .filter-bar button:hover { background: #1d4ed8; }
        .filter-bar a.clear { padding: 0.75rem 1.5rem; background: #e2e8f0; color: #334155; border-radius: 0.5rem; font-weight: 600; text-align: center; display: inline-block; line-height: 1.2; }
        .filter-bar a.clear:hover { background: #cbd5e1; }

        /* Summary Cards */
        .metric-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
        .metric-card { background: white; padding: 1.5rem; border-radius: 1rem; box-shadow: 0 10px 25px rgba(15, 23, 42, 0.03); border: 1px solid #e2e8f0; display: flex; flex-direction: column; justify-content: center; }
        .metric-card.total { border-bottom: 4px solid #6366f1; }
        .metric-card.pending { border-bottom: 4px solid #f59e0b; }
        .metric-card.progress { border-bottom: 4px solid #3b82f6; }
        .metric-card.completed { border-bottom: 4px solid #10b981; }
        .metric-card h3 { margin: 0; color: #64748b; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 700;}
        .metric-card .value { font-size: 2.5rem; font-weight: 800; margin: 0.5rem 0 0; color: #0f172a; }

        /* Data Tables */
        .data-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 1.5rem; }
        .data-card { background: white; padding: 1.5rem; border-radius: 1rem; box-shadow: 0 10px 25px rgba(15, 23, 42, 0.03); border: 1px solid #e2e8f0; }
        .data-card h2 { margin: 0 0 1rem; font-size: 1.25rem; color: #0f172a; border-bottom: 1px solid #f1f5f9; padding-bottom: 1rem; }
        
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 1rem 0.5rem; text-align: left; border-bottom: 1px solid #f1f5f9; }
        th { color: #64748b; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; }
        td { color: #334155; font-weight: 500; }
        td.number { text-align: right; font-weight: 700; color: #0f172a; font-size: 1.1rem;}
        tr:last-child td { border-bottom: none; }
        
        /* Progress Bar */
        .bar-container { width: 100%; background: #e2e8f0; border-radius: 99px; height: 8px; margin-top: 8px; overflow: hidden; }
        .bar-fill { height: 100%; background: #2563eb; border-radius: 99px; }
        
        @media (max-width: 768px) {
            .wrapper { flex-direction: column; }
            .sidebar { width: 100%; position: static; padding: 1rem 1.5rem; gap: 1rem; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
            .sidebar > div > p { display: none; /* Menyembunyikan deskripsi panjang di layar kecil */ }
            .nav { display: flex; flex-wrap: wrap; gap: 0.5rem; }
            .nav a { padding: 0.5rem 0.75rem; }
            .main-content { margin-left: 0; padding: 1.5rem 1rem; max-width: 100%; }
            .filter-bar { flex-direction: column; align-items: stretch; }
            .filter-bar .group { width: 100%; }
            .data-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        
        @include('partials.sidebar')

        <div class="main-content">
            <div class="header-title">
                <h1>Laporan Analisis Work Order</h1>
                <p>Ringkasan data perbaikan dan pemeliharaan berdasarkan periode.</p>
            </div>

            <form method="GET" action="/admin/report" class="filter-bar">
                <div class="group">
                    <label for="from_date">Dari Tanggal</label>
                    <input type="date" name="from_date" id="from_date" value="{{ $filters['from_date'] ?? '' }}">
                </div>
                <div class="group">
                    <label for="to_date">Sampai Tanggal</label>
                    <input type="date" name="to_date" id="to_date" value="{{ $filters['to_date'] ?? '' }}">
                </div>
                <button type="submit">Filter Data</button>
                <a href="/admin/report" class="clear">Reset</a>
            </form>

            <div class="metric-grid">
                <div class="metric-card total">
                    <h3>Total Keseluruhan</h3>
                    <div class="value">{{ $totalOrders }}</div>
                </div>
                <div class="metric-card pending">
                    <h3>Status Pending</h3>
                    <div class="value">{{ $pendingOrders }}</div>
                </div>
                <div class="metric-card progress">
                    <h3>Sedang Dikerjakan</h3>
                    <div class="value">{{ $onProgressOrders }}</div>
                </div>
                <div class="metric-card completed">
                    <h3>Selesai</h3>
                    <div class="value">{{ $completedOrders }}</div>
                </div>
            </div>

            <div class="data-grid">
                <div class="data-card">
                    <h2>Berdasarkan Departemen</h2>
                    @if($departmentStats->isEmpty())
                        <p style="color: #64748b; text-align: center; padding: 2rem 0;">Belum ada data</p>
                    @else
                        <table>
                            <thead>
                                <tr>
                                    <th>Departemen</th>
                                    <th style="text-align: right;">Jumlah WO</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $maxDept = $departmentStats->max(); @endphp
                                @foreach($departmentStats as $dept => $count)
                                <tr>
                                    <td>
                                        {{ $dept }}
                                        <div class="bar-container">
                                            <div class="bar-fill" style="width: {{ ($count / $maxDept) * 100 }}%; background: #6366f1;"></div>
                                        </div>
                                    </td>
                                    <td class="number">{{ $count }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>

                <div class="data-card">
                    <h2>Berdasarkan Jenis Masalah</h2>
                    @if($issueStats->isEmpty())
                        <p style="color: #64748b; text-align: center; padding: 2rem 0;">Belum ada data</p>
                    @else
                        <table>
                            <thead>
                                <tr>
                                    <th>Jenis Masalah</th>
                                    <th style="text-align: right;">Jumlah WO</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $maxIssue = $issueStats->max(); @endphp
                                @foreach($issueStats as $issue => $count)
                                <tr>
                                    <td>
                                        {{ $issue }}
                                        <div class="bar-container">
                                            <div class="bar-fill" style="width: {{ ($count / $maxIssue) * 100 }}%;"></div>
                                        </div>
                                    </td>
                                    <td class="number">{{ $count }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>