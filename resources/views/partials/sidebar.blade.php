<aside class="sidebar">
    <div>
        <div class="brand">
            <span class="brand-mark">W</span>
            <span>Harris Hotel Seminyak Bali</span>
        </div>
        <p style="margin-top:1rem; color:#9ca3af; line-height:1.6; font-size: 0.85rem;">Manage work orders, users, reports, and system settings from a single dashboard.</p>
    </div>
    <nav class="nav">
        <a href="/admin" class="{{ request()->is('admin') ? 'active' : '' }}">Dashboard</a>
        <a href="/admin/orders" class="{{ request()->is('admin/orders*') ? 'active' : '' }}">Work Order</a>
        <a href="/admin/report" class="{{ request()->is('admin/report*') ? 'active' : '' }}">Report</a>
    </nav>
</aside>