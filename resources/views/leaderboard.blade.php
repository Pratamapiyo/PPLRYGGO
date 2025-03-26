@extends('layouts.layout')

@section('title', 'Leaderboard')

@section('content')
<section class="leaderboard-section section-padding" id="section_4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-12">
                <div class="card card-custom shadow-sm border border-secondary">
                    <div class="p-3 text-white rounded-top">
                        <h5 class="mb-0">Leaderboard</h5>
                    </div>
                    <div class="card-body p-5">
                        <!-- Filter Form -->
                        <form action="{{ route('leaderboard') }}" method="GET" class="d-flex justify-content-between mb-4">
                            <select name="region" class="form-select w-50 me-2">
                                <option value="">All Regions</option>
                                @foreach ($regions as $region)
                                    <option value="{{ $region }}" {{ request('region') == $region ? 'selected' : '' }}>{{ $region }}</option>
                                @endforeach
                            </select>
                            <select name="limit" class="form-select w-25 me-2">
                                <option value="5" {{ request('limit') == 5 ? 'selected' : '' }}>Top 5</option>
                                <option value="10" {{ request('limit') == 10 ? 'selected' : '' }}>Top 10</option>
                                <option value="all" {{ request('limit') == 'all' ? 'selected' : '' }}>All</option>
                            </select>
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </form>

                        <!-- Leaderboard Cards -->
                        <div class="row">
                            @forelse ($users as $index => $user)
                                <div class="col-md-4 mb-4">
                                    <div class="card text-center {{ $index < 5 ? 'top-card' : '' }}"> <!-- Highlight Top 5 -->
                                        <div class="card-body">
                                            @if ($index < 5)
                                                <span class="badge bg-warning text-dark position-absolute top-0 start-50 translate-middle mt-2">
                                                    Top {{ $index + 1 }}
                                                </span>
                                            @endif
                                            <div class="symbol symbol-128 mb-3">
                                                <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('assets/images/avatar/blankuser.png') }}"
                                                    alt="Profile Picture"
                                                    class="img-fluid rounded-circle"
                                                    style="width: 128px; height: 128px; object-fit: cover;">
                                            </div>
                                            <h5 class="card-title">{{ $user->name }}</h5>
                                            <p class="card-text text-muted">Region: {{ $user->region ?? 'N/A' }}</p>
                                            <p class="card-text"><strong>Points:</strong> {{ $user->points }}</p>
                                            <p class="card-text"><strong>Rank:</strong> #{{ $index + 1 }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center">No users found in the leaderboard.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .top-card {
        background: linear-gradient(135deg, #ffdd00, #fbb034);
        color: #fff;
        border: 2px solid #ffc107;
    }

    .top-card .card-title {
        font-size: 1.25rem;
        font-weight: bold;
    }

    .top-card .card-text {
        font-size: 1rem;
    }

    .badge {
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
    }
</style>
@endsection