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
                                                    <button type="button" class="btn cur-p btn-info btn-color view-details" 
                                                            data-id="{{ $request->id }}"
                                                            data-kategori="{{ $request->kategori_sampah }}"
                                                            data-berat="{{ $request->berat }}"
                                                            data-alamat="{{ $request->alamat }}"
                                                            data-pemohon="{{ $request->user->name }}"
                                                            data-deskripsi="{{ $request->deskripsi ?? 'Tidak ada deskripsi' }}"
                                                            data-jadwal="{{ $request->jadwal_pengambilan ? \Carbon\Carbon::parse($request->jadwal_pengambilan)->format('d-m-Y H:i') : 'Belum dijadwalkan' }}"
                                                            data-status="{{ $request->status }}"
                                                            data-foto="{{ $request->foto }}"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#detailsModal">
                                                        View
                                                    </button>
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
                                    <th scope="col">Aksi</th>
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
                                        <td>
                                            <button type="button" class="btn cur-p btn-info btn-color view-details" 
                                                    data-id="{{ $item->id }}"
                                                    data-kategori="{{ $item->kategori_sampah }}"
                                                    data-berat="{{ $item->berat }}"
                                                    data-alamat="{{ $item->alamat }}"
                                                    data-pemohon="{{ $item->user->name }}"
                                                    data-deskripsi="{{ $item->deskripsi ?? 'Tidak ada deskripsi' }}"
                                                    data-jadwal="{{ $item->jadwal_pengambilan ? \Carbon\Carbon::parse($item->jadwal_pengambilan)->format('d-m-Y H:i') : 'Belum dijadwalkan' }}"
                                                    data-status="{{ $item->status }}"
                                                    data-foto="{{ $item->foto }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#detailsModal">
                                                View
                                            </button>
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

<!-- Details Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModalLabel">Detail Pengajuan Daur Ulang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <p><strong>Kategori Sampah:</strong> <span id="detailKategori"></span></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <p><strong>Berat:</strong> <span id="detailBerat"></span> kg</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <p><strong>Alamat:</strong> <span id="detailAlamat"></span></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <p><strong>Pemohon:</strong> <span id="detailPemohon"></span></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <p><strong>Jadwal Pengambilan:</strong> <span id="detailJadwal"></span></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <p><strong>Status:</strong> <span id="detailStatus"></span></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <p><strong>Deskripsi:</strong> <span id="detailDeskripsi"></span></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p><strong>Foto Sampah:</strong></p>
                        <img id="detailFoto" src="" alt="Foto Sampah" class="img-fluid rounded" style="max-height: 300px;">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Handle click on view-details buttons to populate and show the modal
    document.addEventListener('DOMContentLoaded', function() {
        const viewButtons = document.querySelectorAll('.view-details');
        
        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Get data from button attributes
                const kategori = this.getAttribute('data-kategori');
                const berat = this.getAttribute('data-berat');
                const alamat = this.getAttribute('data-alamat');
                const pemohon = this.getAttribute('data-pemohon');
                const deskripsi = this.getAttribute('data-deskripsi');
                const jadwal = this.getAttribute('data-jadwal');
                const status = this.getAttribute('data-status');
                const foto = this.getAttribute('data-foto');
                
                // Populate modal with data
                document.getElementById('detailKategori').textContent = kategori;
                document.getElementById('detailBerat').textContent = berat;
                document.getElementById('detailAlamat').textContent = alamat;
                document.getElementById('detailPemohon').textContent = pemohon;
                document.getElementById('detailDeskripsi').textContent = deskripsi;
                document.getElementById('detailJadwal').textContent = jadwal;
                
                // Set status with appropriate badge color
                let statusHtml = '';
                if (status === 'approved') {
                    statusHtml = '<span class="badge bg-success">Accepted</span>';
                } else if (status === 'rejected') {
                    statusHtml = '<span class="badge bg-danger">Rejected</span>';
                } else {
                    statusHtml = '<span class="badge bg-warning text-dark">Pending</span>';
                }
                document.getElementById('detailStatus').innerHTML = statusHtml;
                
                // Set image source
                document.getElementById('detailFoto').src = `/storage/${foto}`;
            });
        });
    });
</script>

@endsection