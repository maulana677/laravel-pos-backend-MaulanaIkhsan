<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Pos Maulana Ikhsan</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>


            <li class="nav-item {{ setSidebarActive(['home']) }}">
                <a href="{{ route('home') }}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>

            <li class="menu-header">Master</li>
            <li class="nav-item dropdown {{ setSidebarActive(['user.*']) }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Users</span></a>
                <ul class="dropdown-menu">
                    <li class="nav-item {{ setSidebarActive(['user.*']) }}">
                        <a class="nav-link" href="{{ route('user.index') }}">All User</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown {{ setSidebarActive(['product.*']) }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Products</span></a>
                <ul class="dropdown-menu">
                    <li class="nav-item {{ setSidebarActive(['product.*']) }}">
                        <a class="nav-link" href="{{ route('product.index') }}">All Products</a>
                    </li>
                </ul>
            </li>
        </ul>

    </aside>
</div>
