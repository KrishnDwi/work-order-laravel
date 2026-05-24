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
