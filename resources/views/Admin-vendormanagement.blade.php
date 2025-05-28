@extends('layouts.adminlayout')

@section('title', 'Vendor Management')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .vendor-map {
        height: 400px;
        width: 100%;
        border-radius: 8px;
        margin-top: 10px;
        border: 2px solid #dee2e6;
        z-index: 1;
        position: relative;
    }
    
    .location-info {
        background: rgba(255,255,255,0.95);
        padding: 12px;
        border-radius: 8px;
        margin-top: 10px;
        font-size: 0.9em;
        border: 1px solid #dee2e6;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .map-instructions {
        background: rgba(52, 144, 220, 0.1);
        padding: 12px;
        border-radius: 5px;
        margin-top: 5px;
        font-size: 0.85em;
        color: #3490dc;
        border: 1px solid rgba(52, 144, 220, 0.3);
    }
    
    .map-instructions ul, .map-instructions ol {
        margin-bottom: 0.5rem;
    }
    
    .map-instructions li {
        margin-bottom: 0.25rem;
    }
    
    .location-selected {
        color: #28a745;
        font-weight: 500;
    }
    
    .modal-xl-custom {
        max-width: 1000px;
    }
    
    .modal-lg-custom {
        max-width: 1200px;
    }
    
    .modal-body {
        max-height: 80vh;
        overflow-y: auto;
    }
    
    /* Leaflet Control Fixes */
    .leaflet-control-container {
        z-index: 1000 !important;
    }
    
    .leaflet-control {
        z-index: 1000 !important;
    }
    
    .leaflet-popup {
        z-index: 1001 !important;
    }
      .leaflet-map-pane {
        z-index: 1 !important;
    }
</style>
@endpush

@section('content')
<main class="main-content bgc-grey-100">
    <div id="mainContent">
        <div class="container-fluid">
            <h4 class="c-grey-900 mT-10 mB-30">Vendor Management</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="bgc-white bd bdrs-3 p-20 mB-20">
                        <h4 class="c-grey-900 mB-20">Daftar Vendor</h4>
                        <button class="btn btn-primary mB-20" data-bs-toggle="modal" data-bs-target="#registerVendorModal">Register Vendor Baru</button>                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama Vendor</th>
                                    <th scope="col">Nama Pemilik</th>
                                    <th scope="col">Lokasi</th>
                                    <th scope="col">Koordinat</th>
                                    <th scope="col">Kontak</th>
                                    <th scope="col">Spesialisasi</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vendors as $index => $vendor)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $vendor->business_name }}</td>
                                        <td>{{ $vendor->user->name }}</td>
                                        <td>{{ $vendor->location }}</td>
                                        <td>
                                            @if($vendor->user->latitude && $vendor->user->longitude)
                                                <small class="text-muted">
                                                    {{ number_format($vendor->user->latitude, 4) }}, {{ number_format($vendor->user->longitude, 4) }}
                                                </small>
                                            @else
                                                <span class="text-danger">Belum diset</span>
                                            @endif
                                        </td>
                                        <td>{{ $vendor->contact }}</td>
                                        <td>{{ $vendor->spesialisasi ?? 'N/A' }}</td>
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
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this vendor?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr><!-- Edit Vendor Modal -->                                    <div class="modal fade" id="editVendorModal-{{ $vendor->id }}" tabindex="-1" aria-labelledby="editVendorModalLabel-{{ $vendor->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg-custom">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editVendorModalLabel-{{ $vendor->id }}">Edit Vendor</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('admin.vendor.update', $vendor->id) }}" method="POST" class="edit-vendor-form" data-vendor-id="{{ $vendor->id }}">
                                                    @csrf
                                                    @method('PUT')                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <!-- Basic Information Section -->
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="business_name-{{ $vendor->id }}" class="form-label">Nama Vendor</label>
                                                                    <input type="text" class="form-control" id="business_name-{{ $vendor->id }}" name="business_name" value="{{ $vendor->business_name }}" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="description-{{ $vendor->id }}" class="form-label">Deskripsi</label>
                                                                    <textarea class="form-control" id="description-{{ $vendor->id }}" name="description">{{ $vendor->description }}</textarea>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="contact-{{ $vendor->id }}" class="form-label">Kontak</label>
                                                                    <input type="text" class="form-control" id="contact-{{ $vendor->id }}" name="contact" value="{{ $vendor->contact }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
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
                                                        </div>
                                                        
                                                        <!-- Location Selection Section - Moved to Bottom -->
                                                        <div class="row mt-4">
                                                            <div class="col-12">
                                                                <div class="mb-3">
                                                                    <label class="form-label">📍 Lokasi Vendor</label>
                                                                    <div class="input-group mb-2">
                                                                        <input type="text" name="location" id="location-{{ $vendor->id }}" class="form-control" placeholder="Klik pada map atau alamat akan terisi otomatis..." value="{{ $vendor->location }}" readonly required>
                                                                        <button type="button" class="btn btn-primary current-location-btn" data-vendor-id="{{ $vendor->id }}" title="Gunakan lokasi saya sekarang">
                                                                            <i class="bi bi-geo-alt-fill"></i> Lokasi Saya
                                                                        </button>
                                                                    </div>
                                                                    
                                                                    <!-- Hidden fields for coordinates -->
                                                                    <input type="hidden" name="latitude" id="latitude-{{ $vendor->id }}" value="{{ $vendor->user->latitude }}">
                                                                    <input type="hidden" name="longitude" id="longitude-{{ $vendor->id }}" value="{{ $vendor->user->longitude }}">
                                                                    <input type="hidden" name="full_address" id="full_address-{{ $vendor->id }}" value="{{ $vendor->user->full_address }}">
                                                                    
                                                                    <!-- Map Container -->
                                                                    <div id="map-{{ $vendor->id }}" class="vendor-map"></div>
                                                                    
                                                                    <!-- Map Instructions -->
                                                                    <div class="map-instructions" id="map-instructions-{{ $vendor->id }}">
                                                                        <i class="bi bi-info-circle"></i> <strong>Petunjuk:</strong>
                                                                        <ul class="mb-1 ps-3">
                                                                            <li>Klik tombol <strong>Lokasi Saya</strong> untuk menggunakan lokasi saat ini, atau</li>
                                                                            <li>Klik langsung pada peta untuk memilih lokasi secara manual</li>
                                                                        </ul>
                                                                    </div>
                                                                    
                                                                    <!-- Location Info -->
                                                                    <div id="location-info-{{ $vendor->id }}" style="display: none;" class="location-info">
                                                                        <div class="d-flex align-items-start">
                                                                            <i class="bi bi-geo-alt-fill text-success me-2 mt-1"></i>
                                                                            <div>
                                                                                <strong class="location-selected">Lokasi Terpilih:</strong><br>
                                                                                <span id="selected-address-{{ $vendor->id }}">-</span><br>
                                                                                <small class="text-muted">Koordinat: <span id="coordinates-{{ $vendor->id }}">-</span></small>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
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
    <div class="modal-dialog modal-dialog-centered modal-xl-custom">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerVendorModalLabel">Register Vendor Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.vendor.register') }}" method="POST" id="registerVendorForm">
                @csrf                    <div class="modal-body">
                        <div class="row">
                            <!-- Basic Information Section -->
                            <div class="col-md-6">
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
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="business_name" class="form-label">Nama Vendor</label>
                                    <input type="text" class="form-control" id="business_name" name="business_name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="contact" class="form-label">Kontak</label>
                                    <input type="text" class="form-control" id="contact" name="contact" required>
                                </div>
                                <div class="mb-3">
                                    <label for="spesialisasi" class="form-label">Spesialisasi</label>
                                    <input type="text" class="form-control" id="spesialisasi" name="spesialisasi" placeholder="Contoh: Plastik, Kertas, Logam">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Location Selection Section - Moved to Bottom -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">📍 Pilih Lokasi Vendor</label>
                                    <div class="input-group mb-2">
                                        <input type="text" name="location" id="location" class="form-control" placeholder="Klik pada map atau alamat akan terisi otomatis..." readonly required>
                                        <button type="button" class="btn btn-primary" id="current-location-btn" title="Gunakan lokasi saya sekarang">
                                            <i class="bi bi-geo-alt-fill"></i> Lokasi Saya
                                        </button>
                                    </div>
                                    
                                    <!-- Hidden fields for coordinates -->
                                    <input type="hidden" name="latitude" id="latitude">
                                    <input type="hidden" name="longitude" id="longitude">
                                    <input type="hidden" name="full_address" id="full_address">
                                    
                                    <!-- Map Container -->
                                    <div id="map" class="vendor-map"></div>
                                    
                                    <!-- Map Instructions -->
                                    <div class="map-instructions">
                                        <i class="bi bi-info-circle"></i> <strong>Petunjuk:</strong>
                                        <ul class="mb-1 ps-3">
                                            <li>Klik tombol <strong>Lokasi Saya</strong> untuk menggunakan lokasi saat ini, atau</li>
                                            <li>Klik langsung pada peta untuk memilih lokasi secara manual</li>
                                        </ul>
                                        <div class="mt-2 small border-top pt-2">
                                            <strong>Jika dialog izin lokasi tidak muncul:</strong>
                                            <ol class="mb-1 ps-3 mt-1">
                                                <li>Klik ikon kunci/info di address bar browser</li>
                                                <li>Cari pengaturan "Lokasi" atau "Location"</li>
                                                <li>Pilih "Reset" atau ubah ke "Ask"/"Tanya"</li>
                                                <li>Refresh halaman ini</li>
                                            </ol>
                                            <div class="fst-italic">Atau gunakan <strong>Mode Penyamaran (Incognito)</strong> untuk selalu diminta izin baru.</div>
                                        </div>
                                    </div>
                                    
                                    <!-- Location Info -->
                                    <div id="location-info" style="display: none;" class="location-info">
                                        <div class="d-flex align-items-start">
                                            <i class="bi bi-geo-alt-fill text-success me-2 mt-1"></i>
                                            <div>
                                                <strong class="location-selected">Lokasi Terpilih:</strong><br>
                                                <span id="selected-address">-</span><br>
                                                <small class="text-muted">Koordinat: <span id="coordinates">-</span></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
let registerMap, editMaps = {};
let registerMarker, editMarkers = {};
let selectedLatLng = null;

// Initialize maps when modals are shown
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing map event listeners');
    
    // Initialize register modal map
    const registerModal = document.getElementById('registerVendorModal');
    if (registerModal) {
        registerModal.addEventListener('shown.bs.modal', function() {
            console.log('Register modal shown, initializing map');
            setTimeout(function() {
                initializeRegisterMap();
            }, 300);
        });
    }
    
    // Initialize edit modal maps
    document.querySelectorAll('[id^="editVendorModal-"]').forEach(modal => {
        modal.addEventListener('shown.bs.modal', function() {
            const vendorId = modal.id.replace('editVendorModal-', '');
            console.log('Edit modal shown for vendor:', vendorId);
            setTimeout(function() {
                initializeEditMap(vendorId);
            }, 300);
        });
    });
    
    // Add event listeners for current location buttons
    const currentLocationBtn = document.getElementById('current-location-btn');
    if (currentLocationBtn) {
        currentLocationBtn.addEventListener('click', function() {
            getUserLocation('register');
        });
    }
    
    document.querySelectorAll('.current-location-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const vendorId = this.getAttribute('data-vendor-id');
            getUserLocation('edit', vendorId);
        });
    });
    
    // Form validation for register form
    const registerForm = document.getElementById('registerVendorForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            if (!selectedLatLng) {
                e.preventDefault();
                alert('Silakan pilih lokasi vendor pada map terlebih dahulu!');
                return false;
            }
        });
    }
    
    // Form validation for edit forms
    document.querySelectorAll('.edit-vendor-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const vendorId = this.getAttribute('data-vendor-id');
            const lat = document.getElementById(`latitude-${vendorId}`).value;
            const lng = document.getElementById(`longitude-${vendorId}`).value;
            
            if (!lat || !lng) {
                e.preventDefault();
                alert('Silakan pilih lokasi vendor pada map terlebih dahulu!');
                return false;
            }
        });
    });
});

function initializeRegisterMap() {
    console.log('Initializing register map...');
    const defaultLat = -2.5489;
    const defaultLng = 118.0149;
    
    // Check if map container exists
    const mapContainer = document.getElementById('map');
    if (!mapContainer) {
        console.error('Map container #map not found');
        return;
    }
    
    // Remove existing map if any
    if (registerMap) {
        console.log('Removing existing register map');
        registerMap.remove();
        registerMap = null;
    }
    
    try {
        // Initialize map
        registerMap = L.map('map').setView([defaultLat, defaultLng], 5);
        
        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(registerMap);
        
        // Add click event to map
        registerMap.on('click', function(e) {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;
            addMarker(lat, lng, 'register');
        });
        
        console.log('Register map initialized successfully');
        
        // Force map resize after a short delay
        setTimeout(function() {
            registerMap.invalidateSize();
        }, 100);
        
    } catch (error) {
        console.error('Error initializing register map:', error);
    }
}

function initializeEditMap(vendorId) {
    console.log('Initializing edit map for vendor:', vendorId);
    const mapId = `map-${vendorId}`;
    const defaultLat = -2.5489;
    const defaultLng = 118.0149;
    
    // Check if map container exists
    const mapContainer = document.getElementById(mapId);
    if (!mapContainer) {
        console.error('Map container not found:', mapId);
        return;
    }
    
    // Get existing coordinates
    const existingLat = document.getElementById(`latitude-${vendorId}`).value;
    const existingLng = document.getElementById(`longitude-${vendorId}`).value;
    
    // Remove existing map if any
    if (editMaps[vendorId]) {
        console.log('Removing existing edit map for vendor:', vendorId);
        editMaps[vendorId].remove();
        delete editMaps[vendorId];
    }
    
    try {
        // Use existing coordinates if available, otherwise use default
        const lat = existingLat ? parseFloat(existingLat) : defaultLat;
        const lng = existingLng ? parseFloat(existingLng) : defaultLng;
        const zoom = (existingLat && existingLng) ? 16 : 5;
        
        // Initialize map
        editMaps[vendorId] = L.map(mapId).setView([lat, lng], zoom);
        
        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(editMaps[vendorId]);
        
        // Add existing marker if coordinates exist
        if (existingLat && existingLng) {
            addMarker(lat, lng, 'edit', vendorId);
            
            // Show location info
            const locationInfo = document.getElementById(`location-info-${vendorId}`);
            const coordsDisplay = document.getElementById(`coordinates-${vendorId}`);
            const addressDisplay = document.getElementById(`selected-address-${vendorId}`);
            
            if (locationInfo && coordsDisplay && addressDisplay) {
                locationInfo.style.display = 'block';
                coordsDisplay.textContent = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                
                const fullAddress = document.getElementById(`full_address-${vendorId}`).value;
                if (fullAddress) {
                    addressDisplay.textContent = fullAddress;
                } else {
                    addressDisplay.textContent = document.getElementById(`location-${vendorId}`).value;
                }
            }
        }
        
        // Add click event to map
        editMaps[vendorId].on('click', function(e) {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;
            addMarker(lat, lng, 'edit', vendorId);
        });
        
        console.log('Edit map initialized successfully for vendor:', vendorId);
        
        // Force map resize after a short delay
        setTimeout(function() {
            editMaps[vendorId].invalidateSize();
        }, 100);
        
    } catch (error) {
        console.error('Error initializing edit map for vendor:', vendorId, error);
    }
}

function getUserLocation(type, vendorId = null) {
    const locationBtn = type === 'register' ? 
        document.getElementById('current-location-btn') : 
        document.querySelector(`.current-location-btn[data-vendor-id="${vendorId}"]`);
    const mapInstructionsId = type === 'register' ? 
        '.map-instructions' : 
        `#map-instructions-${vendorId}`;
    const mapInstructions = document.querySelector(mapInstructionsId);
    
    if (!locationBtn || !mapInstructions) {
        console.error('Location button or map instructions not found');
        return;
    }
    
    if (navigator.geolocation) {
        const originalContent = locationBtn.innerHTML;
        locationBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Mencari...';
        locationBtn.disabled = true;
        
        const originalInstructions = mapInstructions.innerHTML;
        mapInstructions.innerHTML = '<i class="bi bi-info-circle-fill text-primary"></i> <strong>Perhatian:</strong> Browser akan meminta izin untuk mengakses lokasi Anda. Harap izinkan untuk mendapatkan lokasi yang akurat.';
        mapInstructions.style.background = 'rgba(255, 193, 7, 0.1)';
        mapInstructions.style.border = '1px solid rgba(255, 193, 7, 0.5)';
        mapInstructions.style.color = '#856404';
        
        navigator.geolocation.getCurrentPosition(
            function(position) {
                const userLat = position.coords.latitude;
                const userLng = position.coords.longitude;
                
                const currentMap = type === 'register' ? registerMap : editMaps[vendorId];
                if (currentMap) {
                    currentMap.setView([userLat, userLng], 16);
                    addMarker(userLat, userLng, type, vendorId);
                    
                    // Force map resize
                    setTimeout(function() {
                        currentMap.invalidateSize();
                    }, 100);
                }
                
                // Reset button and instructions
                locationBtn.innerHTML = originalContent;
                locationBtn.disabled = false;
                mapInstructions.innerHTML = originalInstructions;
                mapInstructions.style.background = '';
                mapInstructions.style.border = '';
                mapInstructions.style.color = '';
                
                // Show success feedback
                const locationInfoId = type === 'register' ? 'location-info' : `location-info-${vendorId}`;
                const locationInfo = document.getElementById(locationInfoId);
                if (locationInfo) {
                    locationInfo.style.display = 'block';
                    locationInfo.style.background = 'rgba(40, 167, 69, 0.1)';
                    locationInfo.style.border = '1px solid rgba(40, 167, 69, 0.3)';
                    setTimeout(() => {
                        locationInfo.style.background = '';
                        locationInfo.style.border = '';
                    }, 3000);
                }
            },
            function(error) {
                console.error('Error getting current location:', error);
                let errorMessage = 'Tidak dapat menemukan lokasi Anda.';
                let errorDetails = '';
                
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        errorMessage = 'Akses lokasi ditolak';
                        errorDetails = 'Anda perlu mengizinkan akses lokasi di browser. Silakan ikuti petunjuk reset izin lokasi di bawah.';
                        break;
                    case error.POSITION_UNAVAILABLE:
                        errorMessage = 'Informasi lokasi tidak tersedia';
                        errorDetails = 'Perangkat Anda tidak dapat menentukan lokasi saat ini. Silakan coba lagi nanti.';
                        break;
                    case error.TIMEOUT:
                        errorMessage = 'Permintaan lokasi habis waktu';
                        errorDetails = 'Permintaan lokasi membutuhkan waktu terlalu lama. Silakan coba lagi atau pilih lokasi secara manual di peta.';
                        break;
                    default:
                        errorMessage = 'Terjadi kesalahan yang tidak diketahui';
                        errorDetails = 'Silakan coba lagi atau pilih lokasi secara manual di peta.';
                        break;
                }
                
                // Reset button
                locationBtn.innerHTML = originalContent;
                locationBtn.disabled = false;
                
                // Show error message
                mapInstructions.innerHTML = `<i class="bi bi-exclamation-triangle-fill text-danger"></i> <strong>${errorMessage}:</strong> ${errorDetails}`;
                mapInstructions.style.background = 'rgba(220, 53, 69, 0.1)';
                mapInstructions.style.border = '1px solid rgba(220, 53, 69, 0.3)';
                mapInstructions.style.color = '#721c24';
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    } else {
        alert('Browser Anda tidak mendukung geolocation. Silakan gunakan browser yang lebih baru atau pilih lokasi secara manual di peta.');
    }
}

function addMarker(lat, lng, type, vendorId = null) {
    const currentMap = type === 'register' ? registerMap : editMaps[vendorId];
    
    if (!currentMap) {
        console.error('Map not found for type:', type, 'vendorId:', vendorId);
        return;
    }
    
    // Remove existing marker
    if (type === 'register') {
        if (registerMarker) {
            currentMap.removeLayer(registerMarker);
        }
        registerMarker = L.marker([lat, lng]).addTo(currentMap);
        selectedLatLng = {lat: lat, lng: lng};
        
        // Update form fields
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
        document.getElementById('coordinates').textContent = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
    } else {
        if (editMarkers[vendorId]) {
            currentMap.removeLayer(editMarkers[vendorId]);
        }
        editMarkers[vendorId] = L.marker([lat, lng]).addTo(currentMap);
        
        // Update form fields
        document.getElementById(`latitude-${vendorId}`).value = lat;
        document.getElementById(`longitude-${vendorId}`).value = lng;
        document.getElementById(`coordinates-${vendorId}`).textContent = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
    }
    
    // Reverse geocoding to get address
    reverseGeocode(lat, lng, type, vendorId);
}

async function reverseGeocode(lat, lng, type, vendorId = null) {
    try {
        const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`);
        const data = await response.json();
        
        if (data && data.display_name) {
            const address = data.display_name;
            const shortAddress = extractShortAddress(data);
            
            // Update form fields based on type
            if (type === 'register') {
                document.getElementById('location').value = shortAddress;
                document.getElementById('full_address').value = address;
                document.getElementById('selected-address').textContent = address;
                document.getElementById('location-info').style.display = 'block';
            } else {
                document.getElementById(`location-${vendorId}`).value = shortAddress;
                document.getElementById(`full_address-${vendorId}`).value = address;
                document.getElementById(`selected-address-${vendorId}`).textContent = address;
                document.getElementById(`location-info-${vendorId}`).style.display = 'block';
            }
        } else {
            handleGeocodeError(lat, lng, type, vendorId);
        }
    } catch (error) {
        console.error('Reverse geocoding error:', error);
        handleGeocodeError(lat, lng, type, vendorId);
    }
}

function handleGeocodeError(lat, lng, type, vendorId = null) {
    const coordString = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
    const fallbackAddress = `Koordinat: ${coordString}`;
    
    if (type === 'register') {
        document.getElementById('location').value = coordString;
        document.getElementById('full_address').value = fallbackAddress;
        document.getElementById('selected-address').textContent = 'Lokasi berhasil dipilih (alamat tidak tersedia)';
        document.getElementById('location-info').style.display = 'block';
    } else {
        document.getElementById(`location-${vendorId}`).value = coordString;
        document.getElementById(`full_address-${vendorId}`).value = fallbackAddress;
        document.getElementById(`selected-address-${vendorId}`).textContent = 'Lokasi berhasil dipilih (alamat tidak tersedia)';
        document.getElementById(`location-info-${vendorId}`).style.display = 'block';
    }
}

function extractShortAddress(data) {
    const parts = [];
    
    if (data.address) {
        if (data.address.village || data.address.suburb) {
            parts.push(data.address.village || data.address.suburb);
        }
        if (data.address.city || data.address.town) {
            parts.push(data.address.city || data.address.town);
        }
        if (data.address.state) {
            parts.push(data.address.state);
        }
    }
    
    return parts.length > 0 ? parts.join(', ') : 'Lokasi Terpilih';
}
</script>
@endpush