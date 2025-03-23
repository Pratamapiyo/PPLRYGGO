@extends('layouts.layout')

@section('title', 'EcoCycle Home')

@section('content')

<section class="news-detail-header-section text-center">
    <div class="section-overlay"></div>

    <div class="container">
        <div class="row">

            <div class="col-lg-12 col-12">
                <h1 class="text-white">Eco Cycle</h1>
            </div>

        </div>
    </div>
</section>

<section class="profile-section section-padding" id="section_4">
    <div class="container">
        <div class="row justify-content-center">
            <!-- Form Section -->
            <div class="col-lg-8 col-12 mb-4">
                <div class="card card-custom shadow-sm border-1">
                    <div class="p-3 text-white rounded-top">
                        <h5 class="mb-0">Daur Ulang Sampah</h5>
                    </div>
                    <div class="card-body p-5">
                        <form id="ecocycleForm" action="{{ route('ecocycle.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <!-- First Row -->
                                <div class="col-md-6 mb-3">
                                    <label for="kategori_sampah" class="form-label">Kategori Sampah</label>
                                    <select name="kategori_sampah" id="kategori_sampah" class="form-control" required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="plastik">Plastik</option>
                                        <option value="kertas">Kertas</option>
                                        <option value="logam">Logam</option>
                                        <option value="organik">Organik</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="berat" class="form-label">Berat Sampah (kg)</label>
                                    <input type="number" name="berat" id="berat" class="form-control" step="0.01" min="0" required>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Second Row -->
                                <div class="col-md-6 mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <input type="text" name="alamat" id="alamat" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="vendor_id" class="form-label">Pilih Vendor</label>
                                    <select name="vendor_id" id="vendor_id" class="form-control" required>
                                        <option value="">Pilih Vendor</option>
                                        @foreach($vendors as $vendor)
                                        <option value="{{ $vendor->id }}">{{ $vendor->business_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Third Row -->
                                <div class="col-md-6 mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi (Opsional)</label>
                                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3"></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="foto" class="form-label">Upload Foto Sampah</label>
                                    <input type="file" name="foto" id="foto" class="form-control" accept="image/*" required>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Fourth Row -->
                                <div class="col-md-12 mb-3">
                                    <label for="jadwal_pengambilan" class="form-label">Jadwal Pengambilan</label>
                                    <input type="datetime-local" name="jadwal_pengambilan" id="jadwal_pengambilan" class="form-control" required>
                                </div>
                            </div>
                            <!-- Submit Button -->
                            <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#confirmationModal">Ajukan Daur Ulang</button>

                            <!-- Bootstrap Modal -->
                            <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="confirmationModalLabel">Konfirmasi Pengajuan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin mengajukan daur ulang sampah ini?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="button" class="btn btn-primary" id="confirmSubmit">Ajukan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Riwayat Pengajuan Section -->
            <div class="col-lg-8 col-12">
                <div class="card card-custom shadow-sm border-1">
                    <div class="p-3 text-white rounded-top">
                        <h5 class="mb-0">Riwayat Pengajuan</h5>
                    </div>
                    <div class="card-body p-5">
                        @if ($ecoCycles->isEmpty())
                        <p class="text-center">Belum ada pengajuan.</p>
                        @else
                        <ul class="list-group">
                            @foreach ($ecoCycles as $ecoCycle)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $ecoCycle->kategori_sampah }}</strong> -
                                    {{ $ecoCycle->berat }} kg
                                    <span class="badge 
                                                {{ $ecoCycle->status === 'approved' ? 'bg-success' : ($ecoCycle->status === 'rejected' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                        {{ ucfirst($ecoCycle->status) }}
                                    </span>
                                </div>
                                <button class="btn btn-info btn-sm" data-id="{{ $ecoCycle->id }}" onclick="showDetails(this)">Lihat Detail</button>
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

<!-- Details Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content card card-custom shadow-sm border-1">
            <div class="p-3 bg-primary text-white rounded-top">
                <h5 class="mb-0" id="detailsModalLabel">Detail Pengajuan</h5>
            </div>
            <div class="card-body p-5">
                <div id="detailsContent">
                    <div class="row">
                        <!-- First Row -->
                        <div class="col-md-6 mb-3">
                            <p><strong>Kategori Sampah:</strong> <span id="detailKategori"></span></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p><strong>Berat:</strong> <span id="detailBerat"></span> kg</p>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Second Row -->
                        <div class="col-md-6 mb-3">
                            <p><strong>Alamat:</strong> <span id="detailAlamat"></span></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p><strong>Vendor:</strong> <span id="detailVendor"></span></p>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Third Row -->
                        <div class="col-md-6 mb-3">
                            <p><strong>Deskripsi:</strong> <span id="detailDeskripsi"></span></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p><strong>Status:</strong> <span id="detailStatus"></span></p>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Fourth Row -->
                        <div class="col-md-12">
                            <p><strong>Foto:</strong></p>
                            <img id="detailFoto" src="" alt="Foto Sampah" class="img-fluid rounded">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('confirmSubmit').addEventListener('click', function() {
        document.getElementById('ecocycleForm').submit();
    });

    function showDetails(button) {
        const id = button.getAttribute('data-id');
        fetch(`/ecocycle/details/${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('detailKategori').textContent = data.kategori_sampah;
                document.getElementById('detailBerat').textContent = data.berat;
                document.getElementById('detailAlamat').textContent = data.alamat;
                document.getElementById('detailVendor').textContent = data.vendor ? data.vendor.business_name : 'N/A';
                document.getElementById('detailDeskripsi').textContent = data.deskripsi || 'Tidak ada deskripsi';
                document.getElementById('detailStatus').textContent = data.status;
                document.getElementById('detailFoto').src = `/storage/${data.foto}`;
                const modal = new bootstrap.Modal(document.getElementById('detailsModal'));
                modal.show();
            })
            .catch(error => {
                console.error('Error fetching details:', error);
                alert('Gagal memuat detail. Silakan coba lagi.');
            });
    }
</script>

@endsection