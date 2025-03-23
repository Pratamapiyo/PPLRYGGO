@extends('layouts.layout')

@section('title', 'Feedback Saya')

@section('content')
<section class="feedback-section section-padding" id="section_my_feedback">
    <div class="container">
        <div class="row justify-content-center">
            <!-- My Feedback Section -->
            <div class="col-lg-8 col-12">
                <div class="card card-custom shadow-sm border-1">
                    <div class="p-3 text-white rounded-top">
                        <h5 class="mb-0">Feedback Saya</h5>
                    </div>
                    <div class="card-body p-5">
                        @if ($feedbacks->isEmpty())
                        <p class="text-center">Anda belum mengirimkan feedback.</p>
                        @else
                        <ul class="list-group">
                            @foreach ($feedbacks as $feedback)
                            <li class="list-group-item">
                                {{ $feedback->message }}
                                <br>
                                <small class="text-muted">{{ $feedback->created_at->format('d M Y, H:i') }}</small>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection