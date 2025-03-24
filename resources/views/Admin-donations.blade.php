@extends('layouts.adminlayout')

@section('title', 'Manajemen Donasi')

@section('content')
<main class="main-content bgc-grey-100">
    <div id="mainContent">
        <div class="container-fluid">
            <h4 class="c-grey-900 mT-10 mB-30">Manajemen Donasi</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="bgc-white bd bdrs-3 p-20 mB-20">
                        <h4 class="c-grey-900 mB-20">Daftar Program Donasi</h4>
                        <button class="btn btn-success mB-20" data-bs-toggle="modal" data-bs-target="#addDonationModal">Tambah Program Donasi</button>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Deskripsi</th>
                                    <th>Target Poin</th>
                                    <th>Poin Terkumpul</th>
                                    <th>Gambar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($programs as $index => $program)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $program->name }}</td>
                                        <td>{{ $program->description }}</td>
                                        <td>{{ $program->goal_points }}</td>
                                        <td>{{ $program->collected_points }}</td>
                                        <td>
                                            @if ($program->image)
                                                <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->name }}" style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <span>Tidak ada gambar</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editDonationModal" 
                                                data-id="{{ $program->id }}" 
                                                data-name="{{ $program->name }}" 
                                                data-description="{{ $program->description }}" 
                                                data-goal_points="{{ $program->goal_points }}" 
                                                data-image="{{ $program->image }}">Edit</button>
                                            <form action="{{ route('admin.donations.destroy', $program->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus program ini?')">Hapus</button>
                                            </form>
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

<!-- Add Donation Modal -->
<div class="modal fade" id="addDonationModal" tabindex="-1" aria-labelledby="addDonationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDonationModalLabel">Tambah Program Donasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.donations.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="goal_points" class="form-label">Target Poin</label>
                        <input type="number" class="form-control" id="goal_points" name="goal_points" required>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Gambar</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Donation Modal -->
<div class="modal fade" id="editDonationModal" tabindex="-1" aria-labelledby="editDonationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDonationModalLabel">Edit Program Donasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editDonationForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_goal_points" class="form-label">Target Poin</label>
                        <input type="number" class="form-control" id="edit_goal_points" name="goal_points" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_image" class="form-label">Gambar</label>
                        <input type="file" class="form-control" id="edit_image" name="image" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const editDonationModal = document.getElementById('editDonationModal');
    editDonationModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const name = button.getAttribute('data-name');
        const description = button.getAttribute('data-description');
        const goalPoints = button.getAttribute('data-goal_points');

        const form = editDonationModal.querySelector('#editDonationForm');
        form.action = `/admin/donations/${id}`;

        form.querySelector('#edit_name').value = name;
        form.querySelector('#edit_description').value = description;
        form.querySelector('#edit_goal_points').value = goalPoints;
    });
</script>
@endsection
