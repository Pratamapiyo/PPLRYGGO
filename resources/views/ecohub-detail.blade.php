@extends('layouts.layout')

@section('title', 'EcoHub Detail')

@section('content')
<section class="section-padding" id="section_ecohub_detail">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-12 text-center mb-4">
                <h2>{{ $ecohub->business_name }}</h2>
            </div>
          
        </div>

        <div class="row justify-content-center mt-5">
            <div class="col-lg-8 col-12">
                <div class="card card-custom shadow-sm border-1">
                    <div class="p-3 text-white rounded-top">
                        <h5 class="mb-0">Daur Ulang Sampah</h5>
                    </div>
                    <div class="card-body p-5">
                        <form id="ecocycleForm" action="{{ route('ecocycle.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="vendor_id" value="{{ $ecohub->id }}">
                            <div class="row">
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
                                <div class="col-md-6 mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <input type="text" name="alamat" id="alamat" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi (Opsional)</label>
                                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="foto" class="form-label">Upload Foto Sampah</label>
                                    <input type="file" name="foto" id="foto" class="form-control" accept="image/*" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="jadwal_pengambilan" class="form-label">Jadwal Pengambilan</label>
                                    <input type="datetime-local" name="jadwal_pengambilan" id="jadwal_pengambilan" class="form-control" required>
                                </div>
                            </div>
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

                            <!-- Success/Failure Modal -->
                            <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="statusModalLabel">Status Pengajuan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body" id="statusMessage">
                                            <!-- Status message will be dynamically updated -->
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.getElementById('confirmSubmit').addEventListener('click', function() {
        // Instead of submitting the form directly, trigger the AJAX submission
        submitFormWithAjax();
    });

    function submitFormWithAjax() {
        var formData = new FormData(document.getElementById('ecocycleForm'));
        
        $.ajax({
            type: 'POST',
            url: $('#ecocycleForm').attr('action'),
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    // Hide confirmation modal
                    $('#confirmationModal').modal('hide');
                    
                    // Show success message in status modal
                    const statusModal = new bootstrap.Modal(document.getElementById('statusModal'));
                    const statusMessage = document.getElementById('statusMessage');
                    statusMessage.textContent = 'Pengajuan berhasil diajukan!';
                    statusModal.show();
                    
                    // Clear the form
                    $('#ecocycleForm')[0].reset();
                    
                    // Redirect after modal is shown
                    statusModal._element.addEventListener('hidden.bs.modal', function () {
                        window.location.href = "{{ route('nearestecohub') }}";
                    });
                }
            },
            error: function(xhr) {
                // Hide confirmation modal
                $('#confirmationModal').modal('hide');
                
                let errorMessage = 'Terjadi kesalahan saat memproses pengajuan Anda.';
                
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMessage = '';
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        errorMessage += value + ' ';
                    });
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                // Show error message in status modal
                const statusModal = new bootstrap.Modal(document.getElementById('statusModal'));
                const statusMessage = document.getElementById('statusMessage');
                statusMessage.textContent = errorMessage;
                statusModal.show();
            }
        });
    }
</script>
@endsection