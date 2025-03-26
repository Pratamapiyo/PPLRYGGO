@extends('layouts.layout')

@section('title', 'Register Page')

@section('content')

<section class="volunteer-section section-padding" id="section_4">
    <div class="container">
        <div class="row justify-content-center"> <!-- Center the row -->
            <div class="col-lg-6 col-md-8 col-12"> <!-- Adjust column width -->
                <h2 class="text-white mb-4 text-center">Selamat Datang!</h2> <!-- Center the heading -->

                <!-- Alert Section -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="custom-form volunteer-form mb-5" action="{{ route('register') }}" method="post" role="form">
                    @csrf
                    <h3 class="mb-4 text-center">Register</h3> <!-- Center the subheading -->

                    <div class="row">
                        <div class="col-12">
                            <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{ old('name') }}" required>
                        </div>

                        <div class="col-12 mt-3">
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email Address" value="{{ old('email') }}" required>
                        </div>

                        <div class="col-12 mt-3 position-relative">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                            <i id="password-icon" class="bi bi-eye" onclick="togglePassword()" style="cursor: pointer;"></i>
                        </div>

                        <div class="col-12 mt-3">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm Password" required>
                        </div>

                        <div class="col-12 mt-3">
                            <input type="text" name="region" id="region" class="form-control" placeholder="Region (Asal Daerah)" value="{{ old('region') }}" required>
                        </div>
                    </div>

                    <button type="submit" class="form-control mt-4">Register</button>
                </form>

                <p class="text-center text-white">
                    Sudah punya akun? <a href="{{ route('login.form') }}" class="text-white" style="color: var(--primary-color) !important;">Login sekarang</a>
                </p>
            </div>
        </div>
    </div>
</section>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const passwordIcon = document.getElementById('password-icon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            passwordIcon.classList.remove('bi-eye');
            passwordIcon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            passwordIcon.classList.remove('bi-eye-slash');
            passwordIcon.classList.add('bi-eye');
        }
    }
</script>

@endsection