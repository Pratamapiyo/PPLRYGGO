<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="index.html">
            <span class="align-middle">AdminKit</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Pages
            </li>

            <li class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.dashboard') }}">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('admin.econews.manage') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.econews.manage') }}">
                    <i class="align-middle" data-feather="grid"></i> <span class="align-middle">Manajemen EcoNews</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('admin.tags-categories.manage') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.tags-categories.manage') }}">
                    <i class="align-middle" data-feather="tag"></i> <span class="align-middle">Tag/Category News</span>
                </a>
            </li>
        </ul>
    </div>
</nav>