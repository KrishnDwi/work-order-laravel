<aside>
    <div class="brand">
        Harris Hotel Seminyak
        <div style="font-size: 0.85rem; font-weight: 400; color: #9ca3af; margin-top: 2px;">Admin Panel</div>
    </div>
    <ul class="nav-links">
        <li>
            <a href="/admin" class="{{ request()->is('admin') ? 'active' : '' }}">Dashboard Admin</a>
        </li>
        <li>
            <a href="/admin/orders" class="{{ request()->is('admin/orders*') ? 'active' : '' }}">Semua Order</a>
        </li>
        <li>
            <a href="/admin/report" class="{{ request()->is('admin/report*') ? 'active' : '' }}">Laporan</a>
        </li>
    </ul>
</aside>