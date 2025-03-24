@extends('layouts.layout')

@section('title', $program->name)

@section('content')

<main>
    <section class="news-section section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-12 mx-auto">
                    <div class="news-block">
                        <div class="news-block-top">
                            <img src="{{ $program->image ? asset('storage/' . $program->image) : asset('assets/images/default-donation.jpg') }}" class="news-image img-fluid" alt="{{ $program->name }}" style="width: 100%; height: 400px; object-fit: none;">
                        </div>
                        <div class="news-block-info">
                            <div class="d-flex mt-2">
                                <div class="news-block-date">
                                    <p>
                                        <i class="bi-calendar4 custom-icon me-1"></i>
                                        Created on {{ $program->created_at->format('F d, Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="news-block-title mb-2">
                                <h4>{{ $program->name }}</h4>
                            </div>
                            <div class="news-block-body">
                                <p>{!! nl2br(e($program->description)) !!}</p>
                            </div>

                            <div class="row mt-5 mb-4">
                                <div class="col-lg-6 col-12 mb-4 mb-lg-0">
                                    <p><strong>Goal Points:</strong> {{ $program->goal_points }}</p>
                                </div>
                                <div class="col-lg-6 col-12 text-lg-end">
                                    <p><strong>Your Points:</strong> <span class="badge bg-primary">{{ Auth::check() ? Auth::user()->points : 0 }}</span></p>
                                </div>
                            </div>

                            <div class="progress mb-4 position-relative" style="height: 30px;">
                                <div class="progress-bar" role="progressbar" style="width: {{ ($program->collected_points / $program->goal_points) * 100 }}%;" aria-valuenow="{{ $program->collected_points }}" aria-valuemin="0" aria-valuemax="{{ $program->goal_points }}"></div>
                                <span class="position-absolute top-0 end-0 me-2 mt-1" style="font-weight: bold;">
                                    Poin akumulasi terkumpul: {{ $program->collected_points }}
                                </span>
                            </div>

                            @if(Auth::check())
                                <button class="btn btn-lg w-100 rounded-pill donate-btn" style="background-color: var(--custom-btn-bg-color); color: white; transition: background-color 0.3s;" data-program-id="{{ $program->id }}">
                                    Donate
                                </button>
                            @else
                                <p class="mt-4">
                                    <a href="{{ route('login.form') }}" class="btn btn-lg w-100 rounded-pill text-center" style="background-color: var(--custom-btn-bg-color); color: white; transition: background-color 0.3s;">
                                        Login to Donate
                                    </a>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirm Donation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to donate <input type="number" id="donationPointsInput" class="form-control" min="1" max="{{ Auth::user()->points }}" value="1"> points to <strong>{{ $program->name }}</strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmDonationButton">Confirm</button>
            </div>
        </div>
    </div>
</div>

<!-- Feedback Modal -->
<div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="feedbackModalLabel">Feedback</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="feedbackModalBody">
                <!-- Feedback message will be injected here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
        const feedbackModal = new bootstrap.Modal(document.getElementById('feedbackModal'));
        const feedbackModalLabel = document.getElementById('feedbackModalLabel');
        const feedbackModalBody = document.getElementById('feedbackModalBody');
        const donationPointsInput = document.getElementById('donationPointsInput');
        const confirmDonationButton = document.getElementById('confirmDonationButton');
        const donateButtons = document.querySelectorAll('.donate-btn');

        let selectedProgramId = null;

        donateButtons.forEach(button => {
            button.addEventListener('click', function() {
                selectedProgramId = this.getAttribute('data-program-id');
                confirmationModal.show();
            });
        });

        confirmDonationButton.addEventListener('click', function() {
            const pointsToDonate = donationPointsInput.value;

            fetch(`/donations/${selectedProgramId}/donate`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ points_donated: pointsToDonate }),
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(data => {
                        throw new Error(data.message || 'An error occurred.');
                    });
                }
                return response.json();
            })
            .then(data => {
                feedbackModalLabel.textContent = 'Success';
                feedbackModalBody.textContent = data.message;
                feedbackModal.show();

                setTimeout(() => location.reload(), 2000);
            })
            .catch(error => {
                feedbackModalLabel.textContent = 'Error';
                feedbackModalBody.textContent = error.message;
                feedbackModal.show();
            });

            confirmationModal.hide();
        });
    });
</script>

<style>
    .btn:hover {
        background-color: var(--custom-btn-bg-hover-color) !important;
    }
</style>

@endsection
