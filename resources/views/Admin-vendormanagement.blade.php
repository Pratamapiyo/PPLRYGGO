@extends('layouts.adminlayout')

@section('title', 'Vendor Management')

@section('content')
<main class="main-content bgc-grey-100">
    <div id="mainContent">
        <div class="container-fluid">
            <h4 class="c-grey-900 mT-10 mB-30">Vendor Management</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="bgc-white bd bdrs-3 p-20 mB-20">
                        <h4 class="c-grey-900 mB-20">Daftar Vendor</h4>
                        <button class="btn btn-primary mB-20" data-bs-toggle="modal" data-bs-target="#registerVendorModal">Register Vendor Baru</button>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama Vendor</th>
                                    <th scope="col">Nama Pemilik</th>
                                    <th scope="col">Lokasi</th>
                                    <th scope="col">Kontak</th>
                                    <th scope="col">Jarak (km)</th>
                                    <th scope="col">Spesialisasi</th> <!-- Add Spesialisasi Column -->
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th> <!-- Add Actions Column -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vendors as $index => $vendor)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $vendor->business_name }}</td>
                                        <td>{{ $vendor->user->name }}</td>
                                        <td>{{ $vendor->location }}</td>
                                        <td>{{ $vendor->contact }}</td>
                                        <td>{{ $vendor->distance ?? 'N/A' }}</td>
                                        <td>{{ $vendor->spesialisasi ?? 'N/A' }}</td> <!-- Display Spesialisasi -->
                                        <td>
                                            @if ($vendor->status === 'active')
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editVendorModal-{{ $vendor->id }}">Edit</button>
                                            <form action="{{ route('admin.vendor.toggleStatus', $vendor->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-info">
                                                    {{ $vendor->status === 'active' ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.vendor.delete', $vendor->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Edit Vendor Modal -->
                                    <div class="modal fade" id="editVendorModal-{{ $vendor->id }}" tabindex="-1" aria-labelledby="editVendorModalLabel-{{ $vendor->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editVendorModalLabel-{{ $vendor->id }}">Edit Vendor</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('admin.vendor.update', $vendor->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="business_name-{{ $vendor->id }}" class="form-label">Nama Vendor</label>
                                                            <input type="text" class="form-control" id="business_name-{{ $vendor->id }}" name="business_name" value="{{ $vendor->business_name }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="description-{{ $vendor->id }}" class="form-label">Deskripsi</label>
                                                            <textarea class="form-control" id="description-{{ $vendor->id }}" name="description">{{ $vendor->description }}</textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="location-{{ $vendor->id }}" class="form-label">Lokasi</label>
                                                            <input type="text" class="form-control" id="location-{{ $vendor->id }}" name="location" value="{{ $vendor->location }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="contact-{{ $vendor->id }}" class="form-label">Kontak</label>
                                                            <input type="text" class="form-control" id="contact-{{ $vendor->id }}" name="contact" value="{{ $vendor->contact }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="distance-{{ $vendor->id }}" class="form-label">Jarak (km)</label>
                                                            <input type="number" step="0.01" class="form-control" id="distance-{{ $vendor->id }}" name="distance" value="{{ $vendor->distance }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="email-{{ $vendor->id }}" class="form-label">Email</label>
                                                            <input type="email" class="form-control" id="email-{{ $vendor->id }}" name="email" value="{{ $vendor->user->email }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="password-{{ $vendor->id }}" class="form-label">Password (Kosongkan jika tidak ingin mengubah)</label>
                                                            <input type="password" class="form-control" id="password-{{ $vendor->id }}" name="password">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="spesialisasi-{{ $vendor->id }}" class="form-label">Spesialisasi</label>
                                                            <input type="text" class="form-control" id="spesialisasi-{{ $vendor->id }}" name="spesialisasi" value="{{ $vendor->spesialisasi }}" placeholder="Contoh: Plastik, Kertas, Logam">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-primary">Update Vendor</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Edit Vendor Modal -->
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal for Vendor Registration -->
<div class="modal fade" id="registerVendorModal" tabindex="-1" aria-labelledby="registerVendorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerVendorModalLabel">Register Vendor Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.vendor.register') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Pemilik</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="business_name" class="form-label">Nama Vendor</label>
                        <input type="text" class="form-control" id="business_name" name="business_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Lokasi</label>
                        <input type="text" class="form-control" id="location" name="location" required>
                    </div>
                    <div class="mb-3">
                        <label for="contact" class="form-label">Kontak</label>
                        <input type="text" class="form-control" id="contact" name="contact" required>
                    </div>
                    <div class="mb-3">
                        <label for="distance" class="form-label">Jarak (km)</label>
                        <input type="number" step="0.01" class="form-control" id="distance" name="distance" required>
                    </div>
                    <div class="mb-3">
                        <label for="spesialisasi" class="form-label">Spesialisasi</label>
                        <input type="text" class="form-control" id="spesialisasi" name="spesialisasi" placeholder="Contoh: Plastik, Kertas, Logam">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Register Vendor</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection