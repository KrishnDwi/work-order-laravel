<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Work Orders | Admin</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <div class="layout">
        @include('partials.sidebar')
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
