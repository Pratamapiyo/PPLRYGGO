@extends('layouts.layout')

@section('title', 'Profile')

@section('content')
<section class="profile-section section-padding" id="section_4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-12">
                <div class="card card-custom shadow-sm border border-secondary">
                    <div class="p-3 text-white rounded-top">
                        <h5 class="mb-0">Profile Information</h5>
                    </div>
                    <div class="card-body p-5">
                        <div class="row align-items-center">
                            <div class="col-md-4 text-center mb-4 mb-md-0">
                                <div class="symbol symbol-128">
                                    <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('assets/images/avatar/blankuser.png') }}"
                                        alt="Profile Picture"
                                        class="img-fluid rounded-circle"
                                        style="width: 128px; height: 128px; object-fit: cover;">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h4 class="mb-1 font-weight-bold">{{ Auth::user()->name }}</h4>
                                <p class="mb-2 text-muted">{{ Auth::user()->email }}</p>
                                <p class="mb-2 text-muted">Points: <strong>{{ Auth::user()->points }}</strong></p>
                               
                                <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-pill mt-3">Edit Profile</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Achievements Section -->
            <div class="col-lg-8 col-12 mt-5">
                <div class="card card-custom shadow-sm border border-secondary">
                    <div class="p-3 text-white rounded-top">
                        <h5 class="mb-0">Achievements</h5>
                    </div>
                    <div class="card-body p-5">
                        <div class="row">
                            @forelse (\App\Models\Achievement::where('required_points', '<=', Auth::user()->points)->get() as $achievement)
                                <div class="col-md-4 mb-4">
                                    <div class="card text-center">
                                        <img src="{{ $achievement->image ? asset('storage/' . $achievement->image) : asset('img/default-image.jpg') }}" 
                                             class="card-img-top img-fluid rounded"
                                             alt="{{ $achievement->name }}" 
                                             style="width: 100%; height: 150px; object-fit: contain;">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $achievement->name }}</h5>
                                            <p class="card-text">{{ $achievement->description }}</p>
                                            <p class="card-text"><strong>Points Required:</strong> {{ $achievement->required_points }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center">No achievements yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection