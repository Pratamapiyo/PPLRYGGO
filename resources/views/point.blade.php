@extends('layouts.layout')

@section('title', 'Points')

@section('content')
<section class="points-section section-padding" id="section_4">
    <div class="container">
        <div class="row justify-content-center">
            <!-- Points Information -->
            <div class="col-lg-8 col-12">
                <div class="card card-custom shadow-sm border border-secondary">
                    <div class="p-3 text-white rounded-top d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Your Points</h5>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#pointHistoryModal">
                            View History
                        </button>
                    </div>
                    <div class="card-body p-5">
                        <h4 class="mb-1 font-weight-bold">Points: <strong>{{ $user->points }}</strong></h4>
                        <p class="mb-0">These points are earned from your recycling activities.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Point History Modal -->
<div class="modal fade" id="pointHistoryModal" tabindex="-1" aria-labelledby="pointHistoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pointHistoryModalLabel">Point History</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    @forelse ($pointHistories as $history)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $history->kategori_sampah }} ({{ $history->berat }} kg)
                        <span class="badge bg-primary rounded-pill">+{{ floor($history->berat) }} Points</span>
                    </li>
                    @empty
                    <p class="text-center">No point history available.</p>
                    @endforelse
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Catalog Section -->
<section class="section-padding" id="catalog-section">
    <div class="container">
        <div class="row g-4"> <!-- Add g-4 for spacing between rows -->
            <div class="col-lg-12 col-12 text-center mb-4">
                <h2>Point Catalog</h2>
            </div>

            @forelse ($products as $product)
            <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-0">
                <div class="custom-block-wrap">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('assets/images/default-product.jpg') }}" 
                         class="custom-block-image img-fluid" 
                         alt="{{ $product->name }}" 
                         style="height: 300px; object-fit: cover;">

                    <div class="custom-block">
                        <div class="custom-block-body">
                            <h5 class="mb-3">{{ $product->name }}</h5>
                            <p>{{ Str::limit($product->description, 100) }}</p>
                            <p><strong>Your Points:</strong> {{ $user->points }}</p>
                            <div class="progress mt-4">
                                <div class="progress-bar w-100" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            <div class="d-flex align-items-center my-2">
                                <p class="mb-0">
                                    <strong>Points Required:</strong>
                                    {{ $product->points }}
                                </p>

                                <p class="ms-auto mb-0">
                                    <strong>Stock:</strong>
                                    {{ $product->stock }}
                                </p>
                            </div>
                        </div>

                        <a href="javascript:void(0);" class="custom-btn btn redeem-link" data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}" data-bs-toggle="modal" data-bs-target="#redeemModal">Redeem</a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p>No products available in the catalog.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Redemption History Section -->
<section class="section-padding" id="redemption-history-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-12 text-center mb-4">
                <h2>Redemption History</h2>
            </div>

            <div class="col-lg-12 col-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Points Used</th>
                            <th>Status</th>
                            <th>Redeemed At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $index => $transaction)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $transaction->product->name }}</td>
                            <td>{{ $transaction->points_used }}</td>
                            <td>
                                @if ($transaction->status === 'completed')
                                    <span class="badge bg-success">Completed</span>
                                @elseif ($transaction->status === 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @elseif ($transaction->status === 'processed')
                                    <span class="badge bg-primary">Processed</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                            <td>{{ $transaction->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No redemption history available.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
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
                <p>Do you want to use your points to redeem <span id="modalProductName"></span>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="redeemButton">Redeem</button>
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
        const redeemLinks = document.querySelectorAll('.redeem-link');
        const redeemModal = new bootstrap.Modal(document.getElementById('redeemModal'));
        const resultModal = new bootstrap.Modal(document.getElementById('resultModal'));
        const modalProductName = document.getElementById('modalProductName');
        const resultMessage = document.getElementById('resultMessage');
        const redeemButton = document.getElementById('redeemButton');
        let selectedProductId = null;

        redeemLinks.forEach(link => {
            link.addEventListener('click', function() {
                selectedProductId = this.getAttribute('data-product-id');
                const productName = this.getAttribute('data-product-name');
                modalProductName.textContent = productName;
            });
        });

        redeemButton.addEventListener('click', function() {
            fetch(`/point/redeem/${selectedProductId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                redeemModal.hide();
                if (data.message) {
                    resultMessage.textContent = data.message;
                    resultModal.show();

                    // Refresh the page after 2 seconds
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                }
            })
            .catch(error => {
                redeemModal.hide();
                resultMessage.textContent = error.message || 'An unexpected error occurred.';
                resultModal.show();

                // Refresh the page after 2 seconds in case of an error
                setTimeout(() => {
                    location.reload();
                }, 2000);
            });
        });
    });
</script>
@endsection