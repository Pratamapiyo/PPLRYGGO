@extends('layouts.layout')

@section('title', 'Store')

@section('content')

<section class="section-padding" id="section_3">
    <div class="container">
        <div class="row">

            <div class="col-lg-12 col-12 text-center mb-4">
                <h2>Our Products</h2>
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

            @forelse ($products as $product)
            <div class="col-lg-4 col-md-6 col-12 mb-4">
                <div class="custom-block-wrap">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('assets/images/default-product.jpg') }}" class="custom-block-image img-fluid" alt="{{ $product->name }}">

                    <div class="custom-block">
                        <div class="custom-block-body">
                            <h5 class="mb-3">{{ $product->name }}</h5>
                            <p>{{ Str::limit($product->description, 100) }}</p>

                            <p><strong>Stock:</strong> {{ $product->stock }}</p>

                            @php
                            $userPoints = Auth::user()->points ?? 0; // Get user points or default to 0
                            $progress = min(100, ($userPoints / $product->points) * 100); // Calculate progress percentage
                            @endphp

                            <div class="progress mt-4">
                                <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            <div class="d-flex align-items-center my-2">
                                <p class="mb-0">
                                    <strong>Your Points:</strong>
                                    {{ $userPoints }}
                                </p>

                                <p class="ms-auto mb-0">
                                    <strong>Required Points:</strong>
                                    {{ $product->points }}
                                </p>
                            </div>
                        </div>

                        <button class="custom-btn btn redeem-btn" data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}">Redeem</button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p>No products available at the moment.</p>
            </div>
            @endforelse

        </div>
    </div>
</section>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirm Redeem</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to redeem <span id="productName"></span>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="redeemForm" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Confirm</button>
                </form>
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
        const redeemButtons = document.querySelectorAll('.redeem-btn');
        const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
        const feedbackModal = new bootstrap.Modal(document.getElementById('feedbackModal'));
        const productNameSpan = document.getElementById('productName');
        const redeemForm = document.getElementById('redeemForm');
        const feedbackModalLabel = document.getElementById('feedbackModalLabel');
        const feedbackModalBody = document.getElementById('feedbackModalBody');

        redeemButtons.forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id');
                const productName = this.getAttribute('data-product-name');

                productNameSpan.textContent = productName;
                redeemForm.action = `/store/${productId}/redeem`;

                confirmationModal.show();
            });
        });

        redeemForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const action = this.action;

            fetch(action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
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
                    // Show success message in the modal
                    feedbackModalLabel.textContent = 'Success';
                    feedbackModalBody.textContent = data.message;
                    feedbackModal.show();

                    // Optionally, reload the page after a delay to reflect changes
                    setTimeout(() => location.reload(), 2000);
                })
                .catch(error => {
                    // Show error message in the modal
                    feedbackModalLabel.textContent = 'Error';
                    feedbackModalBody.textContent = error.message;
                    feedbackModal.show();
                });

            confirmationModal.hide();
        });
    });
</script>

@endsection