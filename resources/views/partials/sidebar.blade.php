<aside class="sidebar">
    <div class="brand">
        <span class="brand-mark">W</span>
        <span class="brand-text">Harris Hotel Seminyak Bali</span>
    </div>
    <nav class="nav">
        <a href="/admin" class="{{ request()->is('admin') ? 'active' : '' }}" title="Dashboard">
            <span class="nav-label">Dashboard</span>
        </a>
        <a href="/admin/orders" class="{{ request()->is('admin/orders*') ? 'active' : '' }}" title="Work Order">
            <span class="nav-label">Work Order</span>
        </a>
        <a href="/admin/report" class="{{ request()->is('admin/report*') ? 'active' : '' }}" title="Report">
            <span class="nav-label">Report</span>
        </a>
    </nav>
</aside>