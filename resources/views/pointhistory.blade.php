@extends('layouts.layout')

@section('title', 'Point History')

@section('content')
<section class="section-padding" id="section_point_history">
    <div class="container">
        <div class="row justify-content-center">
            <!-- Point History Section -->
            <div class="col-lg-8 col-12">
                <div class="card card-custom shadow-sm border-1">
                    <div class="p-3 text-white rounded-top">
                        <h5 class="mb-0">Point History</h5>
                    </div>
                    <div class="card-body p-5">
                        @if ($transactions->isEmpty() && $donations->isEmpty())
                        <p class="text-center">No transactions or donations found.</p>
                        @else
                        <!-- Filter Buttons -->
                        <div class="mb-4 text-center">
                            <button class="btn btn-primary filter-btn" data-filter="transactions">Product Transactions</button>
                            <button class="btn btn-secondary filter-btn" data-filter="donations">Donations</button>
                        </div>

                        <ul class="list-group">
                            <!-- Product Transactions -->
                            <div class="filter-content" id="transactions">
                                @foreach ($transactions as $transaction)
                                <li class="list-group-item position-relative">
                                    <span class="badge bg-{{ $transaction->status === 'Completed' ? 'success' : 'danger' }} position-absolute top-0 end-0 mt-2 me-2">
                                        {{ $transaction->status }}
                                    </span>
                                    <strong>Product:</strong> {{ $transaction->product->name ?? 'N/A' }}<br>
                                    <strong>Points Used:</strong> {{ $transaction->points_used }}<br>
                                    <small class="text-muted">{{ $transaction->created_at->format('d M Y, H:i') }}</small>
                                </li>
                                @endforeach
                            </div>

                            <!-- Donation History -->
                            <div class="filter-content d-none" id="donations">
                                @foreach ($donations as $donation)
                                <li class="list-group-item position-relative">
                                    <span class="badge bg-success position-absolute top-0 end-0 mt-2 me-2">
                                        {{ $donation->status }}
                                    </span>
                                    <strong>Donation Program:</strong> {{ $donation->donationProgram->name ?? 'N/A' }}<br>
                                    <strong>Points Donated:</strong> {{ $donation->points_donated }}<br>
                                    <small class="text-muted">{{ $donation->created_at->format('d M Y, H:i') }}</small>
                                </li>
                                @endforeach
                            </div>
                        </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filterButtons = document.querySelectorAll('.filter-btn');
        const filterContents = document.querySelectorAll('.filter-content');

        filterButtons.forEach(button => {
            button.addEventListener('click', function () {
                const filter = this.getAttribute('data-filter');

                filterButtons.forEach(btn => btn.classList.remove('btn-primary'));
                this.classList.add('btn-primary');

                filterContents.forEach(content => {
                    if (content.id === filter) {
                        content.classList.remove('d-none');
                    } else {
                        content.classList.add('d-none');
                    }
                });
            });
        });
    });
</script>
@endsection