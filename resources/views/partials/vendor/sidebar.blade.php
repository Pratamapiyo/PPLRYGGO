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
                    <a class="sidebar-link" href="">
                        <span class="icon-holder">
                            <i class="c-blue-500 ti-home"></i>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="sidebar-link" href="{{ route('vendor.requests') }}">
                        <span class="icon-holder">
                            <i class="c-light-blue-500 ti-pencil"></i>
                        </span>
                        <span class="title">Pengajuan Daur Ulang</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="sidebar-link" href="{{ route('vendor.store.index') }}">
                        <span class="icon-holder">
                            <i class="c-green-500 ti-package"></i>
                        </span>
                        <span class="title">Manajemen produk</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="sidebar-link" href="{{ route('vendor.buyer.index') }}">
                        <span class="icon-holder">
                            <i class="c-orange-500 ti-user"></i>
                        </span>
                        <span class="title">Manajemen Pembeli</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="sidebar-link" href="{{ route('vendor.profile') }}">
                        <span class="icon-holder">
                            <i class="c-purple-500 ti-id-badge"></i>
                        </span>
                        <span class="title">Profile</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>