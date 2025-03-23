@extends('layouts.layout')

@section('title', $event->title)

@section('content')

<main>
    <section class="event-section section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-12 mx-auto">
                    <div class="event-block">
                        <div class="event-block-top">
                            <img src="{{ $event->image ? asset('storage/' . $event->image) : asset('assets/images/default-event.jpg') }}" class="event-image img-fluid" alt="{{ $event->title }}">
                        </div>
                        <div class="event-block-info">
                            <div class="d-flex mt-2">
                                <div class="event-block-date">
                                    <p>
                                        <i class="bi-calendar4 custom-icon me-1"></i>
                                        {{ $event->start_date->format('F d, Y') }} - {{ $event->end_date->format('F d, Y') }}
                                    </p>
                                </div>
                                <div class="event-block-location mx-5">
                                    <p>
                                        <i class="bi-geo-alt custom-icon me-1"></i>
                                        {{ $event->location }}
                                    </p>
                                </div>
                            </div>
                            <div class="event-block-title mb-2">
                                <h4>{{ $event->title }}</h4>
                            </div>
                            <div class="event-block-body">
                                <p>{!! nl2br(e($event->description)) !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection