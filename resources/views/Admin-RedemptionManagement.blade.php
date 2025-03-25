@extends('layouts.adminlayout')

@section('title', 'Manajemen Redeem Poin')

@section('content')
<main class="main-content bgc-grey-100">
    <div id="mainContent">
        <div class="container-fluid">
            <h4 class="c-grey-900 mT-10 mB-30">Manajemen Redeem Poin</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="bgc-white bd bdrs-3 p-20 mB-20">
                        <h4 class="c-grey-900 mB-20">Daftar Transaksi</h4>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama Produk</th>
                                    <th scope="col">Pengguna</th>
                                    <th scope="col">Poin Digunakan</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $index => $transaction)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $transaction->product->name }}</td>
                                        <td>{{ $transaction->user->name }}</td>
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
                                        <td>{{ $transaction->created_at->format('d-m-Y H:i') }}</td>
                                        <td>
                                            <div class="gap-10 peers">
                                                @if ($transaction->status === 'pending')
                                                    <div class="peer">
                                                        <form action="{{ route('admin.transactions.update', $transaction->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="processed">
                                                            <button type="submit" class="btn cur-p btn-primary btn-color" onclick="return confirm('Are you sure you want to process this transaction?')">Process</button>
                                                        </form>
                                                    </div>
                                                    <div class="peer">
                                                        <form action="{{ route('admin.transactions.update', $transaction->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="rejected">
                                                            <button type="submit" class="btn cur-p btn-danger btn-color" onclick="return confirm('Are you sure you want to reject this transaction?')">Reject</button>
                                                        </form>
                                                    </div>
                                                @elseif ($transaction->status === 'processed')
                                                    <div class="peer">
                                                        <form action="{{ route('admin.transactions.update', $transaction->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="completed">
                                                            <button type="submit" class="btn cur-p btn-success btn-color" onclick="return confirm('Are you sure you want to mark this transaction as completed?')">Complete</button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection