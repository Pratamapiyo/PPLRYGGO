@extends('layouts.layout')

@section('title', 'Transaction History')

@section('content')
<section class="section-padding" id="section_transaction_history">
    <div class="container">
        <div class="row justify-content-center">
            <!-- Transaction History Section -->
            <div class="col-lg-8 col-12">
                <div class="card card-custom shadow-sm border-1">
                    <div class="p-3 text-white rounded-top">
                        <h5 class="mb-0">Transaction History</h5>
                    </div>
                    <div class="card-body p-5">
                        @if ($transactions->isEmpty())
                        <p class="text-center">No transactions found.</p>
                        @else
                        <ul class="list-group">
                            @foreach ($transactions as $transaction)
                            <li class="list-group-item position-relative">
                                <span class="badge bg-{{ 
                                    strtolower($transaction->status) === 'completed' ? 'success' : 
                                    (strtolower($transaction->status) === 'rejected' ? 'danger' : 
                                    (strtolower($transaction->status) === 'processed' ? 'primary' : 
                                    (strtolower($transaction->status) === 'delivering' ? 'info' : 'warning'))) 
                                }} position-absolute top-0 end-0 mt-2 me-2">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                                <strong>Product:</strong> {{ $transaction->vendorProduct->name ?? 'N/A' }}<br>
                                <strong>Points Used:</strong> {{ $transaction->points_used }}<br>
                                <strong>Final Price:</strong> Rp {{ number_format($transaction->final_price, 0, ',', '.') }}<br>
                                <small class="text-muted">{{ $transaction->created_at->format('d M Y, H:i') }}</small>
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
