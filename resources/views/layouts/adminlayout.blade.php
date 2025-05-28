<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <title>@yield('title', 'ReWasteX')</title>

    <style>
        #loader {
            transition: all 0.3s ease-in-out;
            opacity: 1;
            visibility: visible;
            position: fixed;
            height: 100vh;
            width: 100%;
            background: #fff;
            z-index: 90000;
        }

        #loader.fadeOut {
            opacity: 0;
            visibility: hidden;
        }

        .spinner {
            width: 40px;
            height: 40px;
            position: absolute;
            top: calc(50% - 20px);
            left: calc(50% - 20px);
            background-color: #333;
            border-radius: 100%;
            -webkit-animation: sk-scaleout 1.0s infinite ease-in-out;
            animation: sk-scaleout 1.0s infinite ease-in-out;
        }

        @-webkit-keyframes sk-scaleout {
            0% {
                -webkit-transform: scale(0)
            }

            100% {
                -webkit-transform: scale(1.0);
                opacity: 0;
            }
        }

        @keyframes sk-scaleout {
            0% {
                -webkit-transform: scale(0);
                transform: scale(0);
            }

            100% {
                -webkit-transform: scale(1.0);
                transform: scale(1.0);
                opacity: 0;
            }
        }
    </style>    <!-- Updated to use the correct paths -->
    <script defer="defer" src="{{ asset('admin/assets/main.js') }}"></script>
    <link href="{{ asset('admin/assets/style.css') }}" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Additional Styles from views -->
    @stack('styles')

    <!-- Remove Livewire styles -->
    {{-- @livewireStyles --}}
</head>

<body class="app">
    <div>

        @include('partials.admin.sidebar')

        <!-- #Main ============================ -->
        <div class="page-container">
            @include('partials.admin.navbar')

            <!-- ### $App Screen Content ### -->

            @yield('content')

            <!-- ### $App Screen Footer ### -->
            @include('partials.admin.footer')        </div>
    </div>

    <!-- Additional Scripts from views -->
    @stack('scripts')

    <!-- Remove Livewire scripts -->
    {{-- @livewireScripts --}}
</body>

</html>