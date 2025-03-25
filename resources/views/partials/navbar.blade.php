<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="/">
            <img src="{{ asset('assets/images/rewastex-logo.png') }}" class="logo img-fluid" alt="Kind Heart Charity">
            <span>
                ReWasteX
                <small>Charity Organization</small>
            </span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="/">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('econews') ? 'active' : '' }}" href="{{ route('econews') }}">EcoNews</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('ecocycle.home') ? 'active' : '' }}" href="{{ route('ecocycle.home') }}">EcoCycle Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('store.index') ? 'active' : '' }}" href="{{ route('store.index') }}">Store</a>
                </li>


                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="moreDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Lainnya
                    </a>
                    <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="moreDropdown">
                        <li><a class="dropdown-item" href="{{ route('events.index') }}">Event Campaign</a></li>
                        <li><a class="dropdown-item" href="{{ route('forum') }}">Discussion Forum</a></li>
                        <li><a class="dropdown-item" href="{{ route('ecogive.index') }}">EcoGive</a></li>
                        <li><a class="dropdown-item" href="#section_8">Nearest EcoHub</a></li>
                        <li><a class="dropdown-item" href="#section_9">Leaderboard</a></li>
                        <li><a class="dropdown-item" href="{{ route('feedbacks.index') }}">Feedback</a></li>
                    </ul>
                </li>

                <li class="nav-item ms-3">
                    @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('assets/images/avatar/blankuser.png') }}"
                            alt="Profile Picture"
                            class="rounded-circle me-2"
                            style="width: 30px; height: 30px; object-fit: cover;">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="{{ route('profile') }}">Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('point') }}">Point</a></li>
                        <li><a class="dropdown-item" href="{{ route('profile.pointHistory') }}">Point History</a></li>
                        <li><a class="dropdown-item" href="{{ route('transaction.history') }}">Purchase History</a></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown custom-dropdown">
                    <a class="nav-link dropdown-toggle position-relative custom-dropdown-toggle" href="#" id="customNotificationDropdown" role="button" style="font-size: 1.5rem; display: flex; align-items: center;">
                        <i class="bi bi-bell me-2"></i>
                        @if (Auth::user()->unreadNotifications->count() > 0)
                        <span style="
                            position: relative;
                            background-color: red;
                            color: white;
                            font-size: 0.75rem;
                            font-weight: bold;
                            border-radius: 50%;
                            padding: 2px 6px;
                            line-height: 1;
                            z-index: 10;
                            top: 0px;
                            right: 0px;">
                            {{ Auth::user()->unreadNotifications->count() }}
                        </span>
                        @endif
                    </a>
                    <ul class="custom-dropdown-menu" id="customDropdownMenu" style="display: none; position: absolute; width: 250px; max-height: 500px; overflow-y: auto; word-wrap: break-word; padding: 10px; font-size: 1.1rem; background-color: #fff; border: 1px solid #ddd; border-radius: 5px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); z-index: 1051;">
                        @forelse (Auth::user()->unreadNotifications as $notification)
                        <li style="border-bottom: 1px solid #ddd; padding: 15px 20px;">
                            <a class="dropdown-item text-wrap" href="{{ route('notifications.read', $notification->id) }}">
                                {{ $notification->data['message'] }}
                            </a>
                        </li>
                        @empty
                        <li><span class="dropdown-item">No new notifications</span></li>
                        @endforelse
                        <li>
                            <a class="dropdown-item text-center text-primary" href="{{ route('notifications.markAllAsRead') }}">
                                Mark all as read
                            </a>
                        </li>
                    </ul>
                </li>

                @else
                <a class="nav-link custom-btn custom-border-btn btn {{ request()->routeIs('login.form') ? 'active' : '' }}" href="{{ route('login.form') }}">Login / Register</a>
                @endauth
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    .navbar-nav .nav-item {
        display: flex;
        align-items: center;
        height: 100%;
    }

    .navbar-nav .nav-link {
        padding: 0.5rem 1rem;
    }

    .custom-dropdown-toggle {
        display: flex;
        align-items: center;
    }

    .dropdown-menu {
        position: absolute;
        top: 100%; /* Ensure the dropdown appears below the menu */
        left: 0;
        width: auto;
        min-width: 10rem;
        padding: 0.5rem 0;
        font-size: 1rem;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 0.25rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        z-index: 1050; /* Ensure it appears above other elements */
    }

    .custom-dropdown-menu {
        display: none;
        position: absolute;
        top: 100%; /* Ensure the dropdown appears below the menu */
        left: 0;
        width: 250px;
        max-height: 500px;
        overflow-y: auto;
        word-wrap: break-word;
        padding: 10px;
        font-size: 1.1rem;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        z-index: 1051; /* Ensure it appears above other elements */
    }
</style>

<script>
    document.getElementById('customNotificationDropdown').addEventListener('click', function(event) {
        var dropdownMenu = document.getElementById('customDropdownMenu');
        // Toggle dropdown visibility
        if (dropdownMenu.style.display === 'none' || dropdownMenu.style.display === '') {
            dropdownMenu.style.display = 'block';
        } else {
            dropdownMenu.style.display = 'none';
        }
    });

    // Close dropdown when clicking outside
    window.addEventListener('click', function(event) {
        var dropdownMenu = document.getElementById('customDropdownMenu');
        var notificationDropdown = document.getElementById('customNotificationDropdown');
        if (!notificationDropdown.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.style.display = 'none';
        }
    });
</script>
