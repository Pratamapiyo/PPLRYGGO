@extends('layouts.layout')

@section('title', 'Login Page')

@section('content')

<section class="volunteer-section section-padding" id="section_4">
    <div class="container">
        <div class="row justify-content-center"> <!-- Center the row -->
            <div class="col-lg-6 col-md-8 col-12"> <!-- Adjust column width -->
                <h2 class="text-white mb-4 text-center">Selamat Datang!</h2> <!-- Center the heading -->

                <form class="custom-form volunteer-form mb-5" action="{{ route('login.submit') }}" method="post" role="form">
                    @csrf
                    <h3 class="mb-4 text-center">Login</h3> <!-- Center the subheading -->

                    <div class="row">
                        <div class="col-12">
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email Address" required>
                        </div>

                        <div class="col-12 mt-3 position-relative">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                            <i id="password-icon" class="bi bi-eye" onclick="togglePassword()" style="cursor: pointer;"></i>
                        </div>
                    </div>

                    <button type="submit" class="form-control mt-4">Login</button>
                </form>

                <p class="text-center text-white">
                    Belum punya akun? <a href="{{ route('register') }}" class="text-white" style="color: var(--primary-color) !important;">Daftar sekarang</a>
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