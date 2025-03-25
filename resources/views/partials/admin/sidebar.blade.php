<!-- #Left Sidebar ==================== -->
    <div class="sidebar">
        <div class="sidebar-inner">
            <!-- ### $Sidebar Header ### -->
            <div class="sidebar-logo">
                <div class="peers ai-c fxw-nw">
                    <div class="peer peer-greed">
                        <a class="sidebar-link td-n" href="index.html">
                            <div class="peers ai-c fxw-nw">
                                <div class="peer">
                                    <div class="logo">
                                        <img src="assets/static/images/logo.png" alt="">
                                    </div>
                                </div>
                                <div class="peer peer-greed">
                                    <h5 class="lh-1 mB-0 logo-text">Admin Dashboard</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="peer">
                        <div class="mobile-toggle sidebar-toggle">
                            <a href="" class="td-n">
                                <i class="ti-arrow-circle-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ### $Sidebar Menu ### -->
            <ul class="sidebar-menu scrollable pos-r">
                <li class="nav-item mT-30 actived">
                    <a class="sidebar-link" href="{{ route('admin.econews.manage') }}">
                        <span class="icon-holder">
                            <i class="c-blue-500 ti-home"></i>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="sidebar-link" href="{{ route('admin.econews.manage') }}">
                        <span class="icon-holder">
                            <i class="c-light-blue-500 ti-pencil"></i>
                        </span>
                        <span class="title">Manajemen EcoNews</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="sidebar-link" href="{{ route('admin.tags-categories.manage') }}">
                        <span class="icon-holder">
                            <i class="c-green-500 ti-tag"></i>
                        </span>
                        <span class="title">Tag dan Kategori</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="sidebar-link" href="{{ route('achievements.index') }}">
                        <span class="icon-holder">
                            <i class="c-orange-500 ti-medall"></i>
                        </span>
                        <span class="title">Manajemen Achievement</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="sidebar-link" href="{{ route('admin.events.index') }}">
                        <span class="icon-holder">
                            <i class="c-purple-500 ti-calendar"></i>
                        </span>
                        <span class="title">Manajemen Events</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="sidebar-link" href="{{ route('admin.store.index') }}">
                        <span class="icon-holder">
                            <i class="c-red-500 ti-shopping-cart"></i>
                        </span>
                        <span class="title">Produk Poin</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="sidebar-link" href="{{ route('admin.donations.index') }}">
                        <span class="icon-holder">
                            <i class="c-teal-500 ti-heart"></i>
                        </span>
                        <span class="title">Manajemen Donasi</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="sidebar-link" href="{{ route('admin.redemption.management') }}">
                        <span class="icon-holder">
                            <i class="c-indigo-500 ti-receipt"></i>
                        </span>
                        <span class="title">Manajemen Redeem Poin</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="sidebar-link" href="{{ route('admin.forum.manage') }}">
                        <span class="icon-holder">
                            <i class="c-brown-500 ti-comments"></i>
                        </span>
                        <span class="title">Forum Management</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>