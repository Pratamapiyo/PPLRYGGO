@extends('layouts.layout')

@section('title', 'Store')

@section('content')

<section class="section-padding" id="section_3">
    <div class="container">
        <div class="row">

            <div class="col-lg-12 col-12 text-center mb-4">
                <h2>Our Vendor Products</h2>
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
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('assets/images/default-product.jpg') }}" 
                         class="custom-block-image img-fluid" 
                         alt="{{ $product->name }}" 
                         style="height: 300px; object-fit: cover;">

                    <div class="custom-block">
                        <div class="custom-block-body">
                            <h5 class="mb-3">{{ $product->name }}</h5>
                            <p>{{ Str::limit($product->description, 100) }}</p>
                            <p><strong>Your Points:</strong> {{ Auth::user()->points }}</p>
                            <p><strong>Price:</strong> Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <p><strong>Max Redeemable Points:</strong> {{ $product->max_redeemable_points }} (Rp {{ number_format($product->max_redeemable_points * 1000, 0, ',', '.') }})</p>

                            @php
                            $userPointsInCurrency = (Auth::user()->points ?? 0) * 1000; // Convert user points to currency
                            $maxDiscount = $product->max_redeemable_points * 1000; // Max discount in currency
                            $discount = min($userPointsInCurrency, $maxDiscount); // Calculate discount
                            $finalPrice = $product->price - $discount; // Calculate final price
                            @endphp

                            <p><strong>Discount:</strong> Rp {{ number_format($discount, 0, ',', '.') }}</p>
                            <p><strong>Final Price:</strong> Rp {{ number_format($finalPrice, 0, ',', '.') }}</p>

                            <p><strong>Stock:</strong> {{ $product->stock }}</p>
                        </div>

                        <button class="custom-btn btn redeem-btn" data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}" data-bs-toggle="modal" data-bs-target="#redeemModal">Redeem</button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p>No vendor products available at the moment.</p>
            </div>
            @endforelse

        </div>
    </div>
</section>

<!-- Redeem Confirmation Modal -->
<div class="modal fade" id="redeemModal" tabindex="-1" aria-labelledby="redeemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="redeemModalLabel">Redeem Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Do you want to use your points to get a discount for <span id="modalProductName"></span>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="usePointsButton">Use Points</button>
                <button type="button" class="btn btn-success" id="dontUsePointsButton">Don't Use Points</button>
            </div>
        </div>
    </div>
</div>

<!-- Redeem Result Modal -->
<div class="modal fade" id="resultModal" tabindex="-1" aria-labelledby="resultModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resultModalLabel">Redeem Result</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="resultMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const redeemButtons = document.querySelectorAll('.redeem-btn');
        const redeemModal = new bootstrap.Modal(document.getElementById('redeemModal'));
        const resultModal = new bootstrap.Modal(document.getElementById('resultModal'));
        const modalProductName = document.getElementById('modalProductName');
        const usePointsButton = document.getElementById('usePointsButton');
        const dontUsePointsButton = document.getElementById('dontUsePointsButton');
        const resultMessage = document.getElementById('resultMessage');
        let selectedProductId = null;

        redeemButtons.forEach(button => {
            button.addEventListener('click', function() {
                selectedProductId = this.getAttribute('data-product-id');
                const productName = this.getAttribute('data-product-name');
                modalProductName.textContent = productName;
            });
        });

        usePointsButton.addEventListener('click', function() {
            redeemProduct(true); // Use points
        });

        dontUsePointsButton.addEventListener('click', function() {
            redeemProduct(false); // Don't use points
        });

        function redeemProduct(usePoints) {
            fetch(`/store/${selectedProductId}/redeem`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ use_points: usePoints })
            })
            .then(response => response.json())
            .then(data => {
                redeemModal.hide(); // Hide the confirmation modal
                if (data.message) {
                    resultMessage.textContent = data.message; // Update message to reflect pending status
                    resultModal.show(); // Show the result modal
                }
            })
            .catch(error => {
                redeemModal.hide(); // Hide the confirmation modal
                resultMessage.textContent = error.message || 'An unexpected error occurred.';
                resultModal.show(); // Show the result modal
            });
        }
    });
</script>

@endsection