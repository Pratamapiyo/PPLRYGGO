@extends('layouts.layout')

@section('title', 'Events')

@section('content')

<section class="section-padding" id="section_3">
    <div class="container">
        <div class="row">

            <div class="col-lg-12 col-12 text-center mb-4">
                <h2>Available Events</h2>
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

            @forelse ($events as $event)
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <div class="custom-block-wrap">
                        <img src="{{ $event->image ? asset('storage/' . $event->image) : asset('assets/images/default-event.jpg') }}" class="custom-block-image img-fluid" alt="{{ $event->title }}">

                        <div class="custom-block">
                            <div class="custom-block-body">
                                <h5 class="mb-3">{{ $event->title }}</h5>
                                <p>{{ Str::limit($event->description, 100) }}</p>
                                <p><strong>Location:</strong> {{ $event->location }}</p>
                                <p><strong>Date:</strong> {{ $event->start_date->format('d M Y') }} - {{ $event->end_date->format('d M Y') }}</p>
                            </div>

                            <a href="{{ route('events.show', $event->id) }}" class="custom-btn btn">View Details</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p>No events available at the moment.</p>
                </div>
            @endforelse

        </div>
    </div>
</section>

@endsection