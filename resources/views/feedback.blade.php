@extends('layouts.layout')

@section('title', 'Feedback')

@section('content')
<section class="feedback-section section-padding" id="section_feedback">
    <div class="container">
        <div class="row justify-content-center">
            <!-- Form Section -->
            <div class="col-lg-8 col-12 mb-4">
                <div class="card card-custom shadow-sm border-1">
                    <div class="p-3 text-white rounded-top">
                        <h5 class="mb-0">Kirim Feedback</h5>
                    </div>
                    <div class="card-body p-5">
                        <form id="feedbackForm" action="{{ route('feedbacks.store') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="message" class="form-label">Pesan Feedback</label>
                                <textarea name="message" id="message" class="form-control" rows="4" placeholder="Tulis feedback Anda di sini..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Kirim Feedback</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Feedback List Section -->
            <div class="col-lg-8 col-12">
                <div class="card card-custom shadow-sm border-1">
                    <div class="d-flex justify-content-between align-items-center p-3 text-white rounded-top">
                        <h5 class="mb-0">Feedback Pengguna</h5>
                        <a href="{{ route('feedbacks.user') }}" class="btn btn-secondary btn-sm">Feedback Saya</a>
                    </div>
                    <div class="card-body p-5">
                        @if ($feedbacks->isEmpty())
                        <p class="text-center">Belum ada feedback.</p>
                        @else
                        <ul class="list-group">
                            @foreach ($feedbacks as $feedback)
                            <li class="list-group-item">
                                <strong>{{ $feedback->user->name }}</strong>: {{ $feedback->message }}
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