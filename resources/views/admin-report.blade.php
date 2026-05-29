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
                            <a href="/admin/report" class="clear" style="background: #e2e8f0; color: #0f172a;">Reset</a>
                            
                            <a href="{{ url('/admin/report/pdf') }}?from_date={{ request('from_date') }}&to_date={{ request('to_date') }}" 
                            style="background: #10b981; color: white; padding: 0.85rem 1rem; border-radius: 0.75rem; font-weight: 700; margin-left: auto;">
                            Download PDF
                            </a>
                        </div>
                    </div>
                </form>
            </section>

            <div class="metric-grid">
                <div class="metric-card total">
                    <h3>Total Tiket Masuk</h3>
                    <p class="value">{{ $totalOrders }}</p>
                </div>
                <div class="metric-card completed">
                    <h3>Terselesaikan</h3>
                    <p class="value">{{ $completedOrders }}</p>
                </div>
                <div class="metric-card progress">
                    <h3>Sedang Dikerjakan</h3>
                    <p class="value">{{ $onProgressOrders }}</p>
                </div>
                <div class="metric-card pending">
                    <h3>Belum Ditangani</h3>
                    <p class="value">{{ $pendingOrders }}</p>
                </div>
                <div class="metric-card" style="border-bottom: 4px solid #6366f1; background: #f8fafc;">
                    <h3 style="color: #4f46e5;">⏱️ Rata-rata Durasi</h3>
                    <p class="value" style="font-size: 1.8rem; margin-top: 1rem; color: #4f46e5;">{{ $avgResolutionTime }}</p>
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
            @include('partials.footer')
        </main>
    </div>
</body>
</html>