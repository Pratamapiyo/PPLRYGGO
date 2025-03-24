@extends('layouts.layout')

@section('title', 'EcoGive')

@section('content')

<section class="section-padding" id="section_ecogive">
    <div class="container">
        <div class="row">

            <div class="col-lg-12 col-12 text-center mb-4">
                <h2>EcoGive Programs</h2>
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

            @forelse ($programs as $program)
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <div class="custom-block-wrap">
                        <img src="{{ $program->image ? asset('storage/' . $program->image) : asset('assets/images/default-donation.jpg') }}" class="custom-block-image img-fluid" alt="{{ $program->name }}">

                        <div class="custom-block">
                            <div class="custom-block-body">
                                <h5 class="mb-3">{{ $program->name }}</h5>
                                <p>{{ Str::limit($program->description, 100) }}</p>
                                <p><strong>Goal Points:</strong> {{ $program->goal_points }}</p>
                                <p><strong>Collected Points:</strong> {{ $program->collected_points }}</p>
                            </div>

                            <a href="{{ route('ecogive.show', $program->id) }}" class="custom-btn btn">View Details</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p>No donation programs available at the moment.</p>
                </div>
            @endforelse

        </div>
    </div>
</section>

@endsection
