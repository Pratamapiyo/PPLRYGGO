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
                        @if ($transactions->isEmpty())
                        <p class="text-center">No transactions found.</p>
                        @else
                        <ul class="list-group">
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
                        </ul>
                        <div class="d-flex justify-content-center mt-4">
                            {{ $transactions->links() }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
