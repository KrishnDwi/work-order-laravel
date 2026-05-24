<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Panel | Work Order</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
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
                <div style="display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap;">
                    <a href="/admin/report/pdf?from_date={{ date('Y-m-d') }}&to_date={{ date('Y-m-d') }}" 
                       style="background: #10b981; color: white; padding: 0.65rem 1rem; border-radius: 0.5rem; font-weight: 600; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 0.4rem;">
                       Download Laporan Hari Ini
                    </a>
                    
                    <a href="/" 
                       style="background: #2563eb; color: white; padding: 0.65rem 1rem; border-radius: 0.5rem; font-weight: 600; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 0.4rem;">
                       ➕ Buat WO Baru
                    </a>
                </div>
            </div>

            @if(session('status'))
                <div class="message">
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

            @if($urgentOrders->count() > 0)
            <section class="card" style="border-left: 4px solid #ef4444; background: #fef2f2;">
                <h2 style="color: #b91c1c; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                    Work Order Baru 
                </h2>
                <div class="table-wrapper" style="margin-bottom: 0; box-shadow: none;">
                    <table class="table" style="background: transparent; box-shadow: none;">
                        <thead>
                            <tr>
                                <th>Nomor WO</th>
                                <th>Departemen</th>
                                <th>Jenis Masalah</th>
                                <th>Waktu Tunggu</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($urgentOrders as $urgent)
                            <tr>
                                <td><strong>{{ $urgent->wo_number }}</strong></td>
                                <td>{{ $urgent->department }}</td>
                                <td>{{ $urgent->issue_type }}</td>
                                <td style="color: #ef4444; font-weight: 600;">
                                    {{ \Carbon\Carbon::parse($urgent->created_at)->diffForHumans() }}
                                </td>
                                <td>
                                    <a href="/admin/order/{{ $urgent->id }}" style="color: #2563eb; font-weight: 700; font-size: 0.9rem;">
                                        Tindak Lanjuti &rarr;
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
            @endif

            @include('partials.footer')
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
