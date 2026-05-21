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
        <aside class="sidebar">
            <div>
                <div class="brand">
                    <span class="brand-mark">W</span>
                    <span>WorkOrder Admin</span>
                </div>
                <p style="margin-top:1rem; color:#9ca3af; line-height:1.6;">Manage work orders, users, reports, and system settings from a single dashboard.</p>
            </div>
            <nav class="nav">
                <a href="/admin" class="active">Dashboard</a>
                <a href="#users">Users</a>
                <a href="#orders">Work Orders</a>
                <a href="#reports">Reports</a>
                <a href="#settings">Settings</a>
            </nav>
        </aside>
        <main class="content">
            <div class="topbar">
                <div>
                    <h1>Admin Dashboard</h1>
                    <p>Overview of current operations and recent activity.</p>
                </div>
                <div class="badge">Online</div>
            </div>

            <section class="grid-cards">
                <article class="card">
                    <h2>Open Work Orders</h2>
                    <div class="value">24</div>
                    <small>Active work orders requiring attention</small>
                </article>
                <article class="card">
                    <h2>Technicians</h2>
                    <div class="value">12</div>
                    <small>Team members currently assigned</small>
                </article>
                <article class="card">
                    <h2>Pending Approvals</h2>
                    <div class="value">8</div>
                    <small>Work orders waiting for approval</small>
                </article>
                <article class="card">
                    <h2>Monthly Completion</h2>
                    <div class="value">92%</div>
                    <small>Completion rate for this month</small>
                </article>
            </section>

            <section class="section" id="orders">
                <h2>Recent Work Orders</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Assigned To</th>
                            <th>Due Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#1024</td>
                            <td>Acme Co.</td>
                            <td>Rina</td>
                            <td>2026-05-24</td>
                            <td><span class="status open">Open</span></td>
                        </tr>
                        <tr>
                            <td>#1023</td>
                            <td>Evergreen</td>
                            <td>Jasper</td>
                            <td>2026-05-22</td>
                            <td><span class="status pending">Pending</span></td>
                        </tr>
                        <tr>
                            <td>#1022</td>
                            <td>Nova Interiors</td>
                            <td>Mira</td>
                            <td>2026-05-20</td>
                            <td><span class="status completed">Completed</span></td>
                        </tr>
                        <tr>
                            <td>#1021</td>
                            <td>Solaris</td>
                            <td>Leo</td>
                            <td>2026-05-19</td>
                            <td><span class="status open">Open</span></td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <section class="section" id="users">
                <h2>Team Activity</h2>
                <div class="grid-cards">
                    <article class="card">
                        <h2>Recent Logins</h2>
                        <div class="value">6</div>
                        <small>Users signed in over the last 24 hours</small>
                    </article>
                    <article class="card">
                        <h2>New Users</h2>
                        <div class="value">3</div>
                        <small>Accounts created this week</small>
                    </article>
                </div>
            </section>

            <footer style="color:#6b7280; font-size:0.95rem; padding-top:1rem; border-top:1px solid #e5e7eb;">
                Work Order Admin • {{ date('Y') }}
            </footer>
        </main>
    </div>
</body>
</html>
