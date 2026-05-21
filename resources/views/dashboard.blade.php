<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard | Work Order</title>
    <style>
        :root {
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: #f3f4f6;
            color: #111827;
        }
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            min-height: 100vh;
            background: #f3f4f6;
        }
        a {
            color: inherit;
            text-decoration: none;
        }
        .page {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }
        .header {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 1rem;
            align-items: center;
            margin-bottom: 2rem;
        }
        .hero {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.08);
            flex: 1 1 360px;
        }
        .hero h1 {
            margin: 0;
            font-size: clamp(1.75rem, 2.5vw, 2.75rem);
        }
        .hero p {
            margin: 1rem 0 0;
            color: #6b7280;
            line-height: 1.75;
        }
        .create-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 0.75rem;
            padding: 0.95rem 1.5rem;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s ease;
            text-decoration: none;
        }
        .create-btn:hover {
            background: #1d4ed8;
        }
        .panel {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 15px 35px rgba(15, 23, 42, 0.06);
            margin-bottom: 2rem;
        }
        .panel h2 {
            margin: 0 0 1rem;
            font-size: 1.1rem;
        }
        .alert {
            margin-bottom: 1.5rem;
            padding: 1rem 1.25rem;
            border-radius: 0.85rem;
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        .table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        th, td {
            text-align: left;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #e5e7eb;
            font-size: 0.95rem;
            white-space: nowrap;
        }
        th {
            color: #6b7280;
            background: #f8fafc;
            font-weight: 700;
        }
        tbody tr:last-child td {
            border-bottom: none;
        }
        .tag {
            display: inline-flex;
            padding: 0.35rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 700;
        }
        .tag.pending { background: #fef3c7; color: #92400e; }
        .tag.progress { background: #bfdbfe; color: #1d4ed8; }
        .tag.completed { background: #d1fae5; color: #065f46; }
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
        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.6);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            z-index: 200;
        }
        .modal-backdrop.active {
            display: flex;
        }
        .modal {
            width: min(600px, 100%);
            background: white;
            border-radius: 1rem;
            box-shadow: 0 25px 80px rgba(15, 23, 42, 0.2);
            overflow: hidden;
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.25rem 1.5rem;
            background: #111827;
            color: white;
        }
        .modal-header h3 {
            margin: 0;
            font-size: 1.125rem;
        }
        .modal-close {
            background: none;
            border: none;
            color: white;
            font-size: 1.25rem;
            cursor: pointer;
        }
        .modal-body {
            padding: 1.5rem;
            color: #111827;
        }
        .modal-body p {
            margin: 0.75rem 0;
            line-height: 1.75;
        }
        .modal-body strong {
            display: block;
            margin-top: 1rem;
            font-weight: 700;
        }
        @media (max-width: 768px) {
            th, td {
                padding: 0.75rem;
                font-size: 0.875rem;
            }
        }
        .empty {
            text-align: center;
            padding: 2rem;
            color: #6b7280;
        }
        .empty p {
            margin: 1rem 0;
        }
        .stats-grid {
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            margin-bottom: 2rem;
        }
        .stat-card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 15px 35px rgba(15, 23, 42, 0.06);
        }
        .stat-card strong {
            display: block;
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        .stat-card span {
            color: #6b7280;
        }
        @media (max-width: 900px) {
            .header {
                flex-direction: column;
            }
        }
        nav {
            background: #111827;
            color: #f9fafb;
            padding: 1rem 1.5rem;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        nav .container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        nav .brand {
            font-weight: 700;
            font-size: 1.25rem;
        }
        nav .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        nav .nav-links a {
            color: #d1d5db;
            transition: color 0.2s ease;
        }
        nav .nav-links a:hover,
        nav .nav-links a.active {
            color: #f9fafb;
        }
        .hamburger {
            display: none;
            flex-direction: column;
            cursor: pointer;
            gap: 0.5rem;
            background: none;
            border: none;
        }
        .hamburger span {
            width: 25px;
            height: 3px;
            background: #d1d5db;
            border-radius: 2px;
            transition: all 0.3s ease;
        }
        .hamburger.active span:nth-child(1) {
            transform: rotate(45deg) translate(10px, 10px);
        }
        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }
        .hamburger.active span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -7px);
        }
        @media (max-width: 768px) {
            nav .nav-links {
                position: absolute;
                top: 60px;
                left: 0;
                right: 0;
                background: #1f2937;
                flex-direction: column;
                gap: 0;
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.3s ease;
            }
            nav .nav-links.active {
                max-height: 300px;
            }
            nav .nav-links a {
                display: block;
                padding: 1rem 1.5rem;
                border-bottom: 1px solid rgba(255,255,255,0.1);
            }
            .hamburger {
                display: flex;
            }
            .page {
                padding: 2rem 1rem;
            }
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hamburger = document.querySelector('.hamburger');
            const navLinks = document.querySelector('.nav-links');
            
            hamburger?.addEventListener('click', function() {
                hamburger.classList.toggle('active');
                navLinks.classList.toggle('active');
            });

            const navAnchors = document.querySelectorAll('.nav-links a');
            navAnchors.forEach(anchor => {
                anchor.addEventListener('click', function() {
                    hamburger.classList.remove('active');
                    navLinks.classList.remove('active');
                });
            });
        });
    </script>
</head>
<body>
    <nav>
        <div class="container">
            <div class="brand">WorkOrder System</div>
            <ul class="nav-links">
                <li><a href="/" class="active">Dashboard</a></li>
                <li><a href="/add">Buat Work Order</a></li>
            </ul>
            <button class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>

    <div class="page">
        <header class="header">
            <div class="hero">
                <h1>Dashboard Work Order</h1>
                <p>Kelola dan pantau semua work order dari satu tempat.</p>
            </div>
            <a href="/add" class="create-btn">+ Buat Work Order Baru</a>
        </header>

        @if(session('status'))
            <div class="alert">
                {{ session('status') }}
            </div>
        @endif

        <div class="stats-grid">
            <div class="stat-card">
                <strong>{{ $workOrders->count() }}</strong>
                <span>Total Work Order</span>
            </div>
            <div class="stat-card">
                <strong>{{ $workOrders->where('status', 'Pending')->count() }}</strong>
                <span>Pending</span>
            </div>
            <div class="stat-card">
                <strong>{{ $workOrders->where('status', 'On Progress')->count() }}</strong>
                <span>On Progress</span>
            </div>
            <div class="stat-card">
                <strong>{{ $workOrders->where('status', 'Completed')->count() }}</strong>
                <span>Completed</span>
            </div>
        </div>

        <div class="panel">
            <h2>Daftar Work Order</h2>
            @if($workOrders->count() > 0)
                <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Nomor WO</th>
                            <th>Departemen</th>
                            <th>Jenis Masalah</th>
                            <th>Status</th>
                            <th>Tanggal Dibuat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($workOrders as $order)
                            <tr class="clickable-row" data-wo-number="{{ $order->wo_number }}" data-department="{{ $order->department }}" data-issue-type="{{ $order->issue_type }}" data-status="{{ $order->status }}" data-created-at="{{ date('d/m/Y H:i', strtotime($order->created_at)) }}" data-description="{{ $order->description ?? 'Tidak ada deskripsi.' }}">
                                <td><strong>{{ $order->wo_number }}</strong></td>
                                <td>{{ $order->department }}</td>
                                <td>{{ $order->issue_type }}</td>
                                <td>
                                    @if($order->status == 'Pending')
                                        <span class="tag pending">{{ $order->status }}</span>
                                    @elseif($order->status == 'On Progress')
                                        <span class="tag progress">{{ $order->status }}</span>
                                    @else
                                        <span class="tag completed">{{ $order->status }}</span>
                                    @endif
                                </td>
                                <td>{{ date('d/m/Y H:i', strtotime($order->created_at)) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            @else
                <div class="empty">
                    <p>Belum ada work order</p>
                    <a href="/add" class="create-btn">Buat Work Order Pertama</a>
                </div>
            @endif
        </div>
    </div>

    <div class="modal-backdrop" id="order-detail-modal">
        <div class="modal" role="dialog" aria-modal="true" aria-labelledby="modal-title">
            <div class="modal-header">
                <h3 id="modal-title">Detail Work Order</h3>
                <button class="modal-close" id="modal-close" aria-label="Tutup detail">×</button>
            </div>
            <div class="modal-body" id="modal-body">
                <p><strong>Nomor WO</strong> <span id="modal-wo-number"></span></p>
                <p><strong>Departemen</strong> <span id="modal-department"></span></p>
                <p><strong>Jenis Masalah</strong> <span id="modal-issue-type"></span></p>
                <p><strong>Status</strong> <span id="modal-status"></span></p>
                <p><strong>Tanggal Dibuat</strong> <span id="modal-created-at"></span></p>
                <p><strong>Deskripsi</strong></p>
                <p id="modal-description"></p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hamburger = document.querySelector('.hamburger');
            const navLinks = document.querySelector('.nav-links');
            const modal = document.getElementById('order-detail-modal');
            const modalClose = document.getElementById('modal-close');
            const modalFields = {
                woNumber: document.getElementById('modal-wo-number'),
                department: document.getElementById('modal-department'),
                issueType: document.getElementById('modal-issue-type'),
                status: document.getElementById('modal-status'),
                createdAt: document.getElementById('modal-created-at'),
                description: document.getElementById('modal-description'),
            };

            hamburger?.addEventListener('click', function() {
                hamburger.classList.toggle('active');
                navLinks.classList.toggle('active');
            });

            const navAnchors = document.querySelectorAll('.nav-links a');
            navAnchors.forEach(anchor => {
                anchor.addEventListener('click', function() {
                    hamburger.classList.remove('active');
                    navLinks.classList.remove('active');
                });
            });

            document.querySelectorAll('.clickable-row').forEach(function(row) {
                row.addEventListener('click', function() {
                    modalFields.woNumber.textContent = row.dataset.woNumber;
                    modalFields.department.textContent = row.dataset.department;
                    modalFields.issueType.textContent = row.dataset.issueType;
                    modalFields.status.textContent = row.dataset.status;
                    modalFields.createdAt.textContent = row.dataset.createdAt;
                    modalFields.description.textContent = row.dataset.description;
                    modal.classList.add('active');
                });
            });

            modalClose?.addEventListener('click', function() {
                modal.classList.remove('active');
            });

            modal.addEventListener('click', function(event) {
                if (event.target === modal) {
                    modal.classList.remove('active');
                }
            });

            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && modal.classList.contains('active')) {
                    modal.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html>
