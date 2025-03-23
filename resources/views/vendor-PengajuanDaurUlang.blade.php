@extends('layouts.vendorlayout')

@section('title', 'Pengajuan Daur Ulang')

@section('content')

<main class="main-content bgc-grey-100">
    <div id="mainContent">
        <div class="container-fluid">
            <h4 class="c-grey-900 mT-10 mB-30">Pengajuan Daur Ulang</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="bgc-white bd bdrs-3 p-20 mB-20">
                        <h4 class="c-grey-900 mB-20">Daftar Pengajuan</h4>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Kategori Sampah</th>
                                    <th scope="col">Berat (kg)</th>
                                    <th scope="col">Alamat</th>
                                    <th scope="col">Pemohon</th>
                                    <th scope="col">Jadwal Pengambilan</th> <!-- Tambahkan kolom ini -->
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($requests as $index => $request)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $request->kategori_sampah }}</td>
                                        <td>{{ $request->berat }}</td>
                                        <td>{{ $request->alamat }}</td>
                                        <td>{{ $request->user->name }}</td>
                                        <td>
                                            @if ($request->jadwal_pengambilan)
                                                {{ \Carbon\Carbon::parse($request->jadwal_pengambilan)->format('d-m-Y H:i') }}
                                            @else
                                                <span class="text-muted">Belum dijadwalkan</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($request->status === 'approved')
                                                <span class="badge bg-success">Accepted</span>
                                            @elseif ($request->status === 'rejected')
                                                <span class="badge bg-danger">Rejected</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="gap-10 peers">
                                                <div class="peer">
                                                    <a href="{{ route('ecocycle.show', $request->id) }}" class="btn cur-p btn-info btn-color">View</a>
                                                </div>
                                                <div class="peer">
                                                    <form action="{{ route('ecocycle.update', $request->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="approved">
                                                        <button type="submit" class="btn cur-p btn-success btn-color" onclick="return confirm('Apakah Anda yakin ingin menyetujui pengajuan ini?')">Approve</button>
                                                    </form>
                                                </div>
                                                <div class="peer">
                                                    <form action="{{ route('ecocycle.update', $request->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="rejected">
                                                        <button type="submit" class="btn cur-p btn-danger btn-color" onclick="return confirm('Apakah Anda yakin ingin menolak pengajuan ini?')">Reject</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="bgc-white bd bdrs-3 p-20 mB-20">
                        <h4 class="c-grey-900 mB-20">Riwayat Daur Ulang</h4>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Kategori Sampah</th>
                                    <th scope="col">Berat (kg)</th>
                                    <th scope="col">Alamat</th>
                                    <th scope="col">Pemohon</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($history as $index => $item)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $item->kategori_sampah }}</td>
                                        <td>{{ $item->berat }}</td>
                                        <td>{{ $item->alamat }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>
                                            @if ($item->status === 'approved')
                                                <span class="badge bg-success">Accepted</span>
                                            @elseif ($item->status === 'rejected')
                                                <span class="badge bg-danger">Rejected</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->updated_at->format('d-m-Y H:i') }}</td>
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