<aside class="sidebar">
    <div class="sidebar-header">
        <a href="/admin">
            <div class="brand">
                <div class="brand-text">Harris Hotel Seminyak</div>
            </div>
        </a>
        
        <div class="menu-toggle" id="admin-menu-toggle">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    <p class="sidebar-desc"></p>
    
    <nav class="nav" id="admin-nav-links">
        <a href="/admin" class="{{ request()->is('admin') ? 'active' : '' }}">
            <span class="nav-label">Dashboard</span>
        </a>
        <a href="/admin/orders" class="{{ request()->is('admin/orders') ? 'active' : '' }}">
            <span class="nav-label">Work Orders</span>
        </a>
        <a href="/admin/report" class="{{ request()->is('admin/report') ? 'active' : '' }}">
            <span class="nav-label">Laporan</span>
        </a>
    </nav>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('admin-menu-toggle');
        const navLinks = document.getElementById('admin-nav-links');
        
        if (toggleBtn && navLinks) {
            toggleBtn.addEventListener('click', function() {
                // Tambah/hapus class 'active' saat diklik
                toggleBtn.classList.toggle('active');
                navLinks.classList.toggle('active');
            });
        }
    });
</script>