<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Work Order - Admin</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <div class="layout">
        
        @include('partials.sidebar')

        <main class="content">
            <div class="topbar">
                <div>
                    <h1>Laporan Analisis Work Order</h1>
                    <p>Ringkasan data perbaikan dan pemeliharaan berdasarkan periode.</p>
                </div>
            </div>

            <section class="filter-panel">
                <form method="GET" action="/admin/report">
                    <div class="filter-grid">
                        <div>
                            <label for="from_date">Dari Tanggal</label>
                            <input type="date" name="from_date" id="from_date" value="{{ $filters['from_date'] ?? '' }}">
                        </div>
                        <div>
                            <label for="to_date">Sampai Tanggal</label>
                            <input type="date" name="to_date" id="to_date" value="{{ $filters['to_date'] ?? '' }}">
                        </div>
                        <div class="filter-actions">
                            <button type="submit">Filter Data</button>
                            <a href="/admin/report">Reset</a>
                        </div>
                    </div>
                </form>
            </section>

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
                <div class="card">
                    <h2>Berdasarkan Departemen</h2>
                    @if($departmentStats->isEmpty())
                        <p style="color: #64748b; text-align: center; padding: 2rem 0;">Belum ada data</p>
                    @else
                        <table class="table">
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
                                    <td style="text-align: right; font-weight: 700; color: #0f172a; font-size: 1.1rem;">{{ $count }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>

                <div class="card">
                    <h2>Berdasarkan Jenis Masalah</h2>
                    @if($issueStats->isEmpty())
                        <p style="color: #64748b; text-align: center; padding: 2rem 0;">Belum ada data</p>
                    @else
                        <table class="table">
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
                                    <td style="text-align: right; font-weight: 700; color: #0f172a; font-size: 1.1rem;">{{ $count }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </main>
    </div>
</body>
</html>