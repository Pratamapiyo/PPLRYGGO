@extends('layouts.layout')

@section('title', 'Nearest EcoHub')

@section('content')

<section class="section-padding" id="section_nearest_ecohub">
    <div class="container">
        <div class="row">

            <div class="col-lg-12 col-12 text-center mb-4">
                <h2>Nearest EcoHub Locations</h2>
            </div>

            <div class="col-lg-12 col-12 text-center mb-4">
                <form method="GET" action="{{ route('nearestecohub') }}" class="d-inline-block">
                    <select name="filter" class="form-select d-inline-block w-auto" onchange="this.form.submit()">
                        <option value="">Filter by Distance</option>
                        <option value="nearest" {{ request('filter') == 'nearest' ? 'selected' : '' }}>Terdekat</option>
                        <option value="farthest" {{ request('filter') == 'farthest' ? 'selected' : '' }}>Terjauh</option>
                    </select>
                </form>
                <form method="GET" action="{{ route('nearestecohub') }}" class="d-inline-block">
                    <select name="spesialisasi" class="form-select d-inline-block w-auto" onchange="this.form.submit()">
                        <option value="">Filter by Spesialisasi</option>
                        @foreach ($spesialisasiOptions as $option)
                            <option value="{{ $option }}" {{ request('spesialisasi') == $option ? 'selected' : '' }}>
                                {{ $option }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <style>
                .custom-block-wrap {
                    height: 100%;
                    display: flex;
                    flex-direction: column;
                }
                .custom-block-image {
                    height: 200px;
                    object-fit: cover;
                    width: 100%;
                }
                .custom-block {
                    flex-grow: 1;
                    display: flex;
                    flex-direction: column;
                    justify-content: space-between;
                }
                .custom-block-body {
                    flex-grow: 1;
                }
                .custom-btn {
                    margin-top: auto;
                }
            </style>

            @forelse ($ecohubs as $ecohub)
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <div class="custom-block-wrap">

                        <div class="custom-block">
                            <div class="custom-block-body">
                                <h5 class="mb-3">{{ $ecohub->business_name }}</h5>
                                <p>{{ Str::limit($ecohub->description, 100) }}</p>
                                <p><strong>Location:</strong> {{ $ecohub->location }}</p>
                                <p><strong>Contact:</strong> {{ $ecohub->contact }}</p>
                                <p><strong>Distance:</strong> {{ $ecohub->distance ?? 'N/A' }} km</p>
                                <p><strong>Spesialisasi:</strong> {{ $ecohub->spesialisasi ?? 'N/A' }}</p>
                            </div>

                            <a href="{{ route('ecohub.detail', ['id' => $ecohub->id]) }}" class="custom-btn btn">View Details</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p>No EcoHub locations available at the moment.</p>
                </div>
            @endforelse

        </div>
    </div>
</section>

@endsection