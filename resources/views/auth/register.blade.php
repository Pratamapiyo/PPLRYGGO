@extends('layouts.layout')

@section('title', 'Register Page')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map {
        height: 300px;
        width: 100%;
        border-radius: 8px;
        margin-top: 10px;
        border: 2px solid #dee2e6;
        z-index: 1; /* Ensure map displays above other elements */
    }
    .location-info {
        background: rgba(255,255,255,0.95);
        padding: 12px;
        border-radius: 8px;
        margin-top: 10px;
        font-size: 0.9em;
        border: 1px solid #dee2e6;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }    .map-instructions {
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
</style>
@endpush

@section('content')

<section class="volunteer-section section-padding" id="section_4">
    <div class="container">        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-12"> <!-- Wider for map -->
                <h2 class="text-white mb-4 text-center">Selamat Datang!</h2> <!-- Center the heading -->

                <!-- Alert Section -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="custom-form volunteer-form mb-5" action="{{ route('register') }}" method="post" role="form">
                    @csrf
                    <h3 class="mb-4 text-center">Register</h3> <!-- Center the subheading -->

                    <div class="row">
                        <div class="col-12">
                            <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{ old('name') }}" required>
                        </div>

                        <div class="col-12 mt-3">
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email Address" value="{{ old('email') }}" required>
                        </div>                        <div class="col-12 mt-3 position-relative">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                            <i id="password-icon" class="bi bi-eye position-absolute" style="cursor: pointer; top: 50%; right: 15px; transform: translateY(-50%);" onclick="togglePassword()"></i>
                        </div><div class="col-12 mt-3">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm Password" required>
                        </div>

                        <!-- Location Selection Section -->
                        <div class="col-12 mt-3">                            <label class="form-label text-white">📍 Pilih Lokasi Anda</label>                            <div class="input-group mb-2">
                                <input type="text" name="region" id="region" class="form-control" placeholder="Klik pada map atau alamat akan terisi otomatis..." value="{{ old('region') }}" readonly>
                                <button type="button" class="btn btn-primary" id="current-location-btn" title="Gunakan lokasi saya sekarang">
                                    <i class="bi bi-geo-alt-fill"></i> Lokasi Saya
                                </button>
                            </div>
                            
                            <!-- Hidden fields for coordinates -->
                            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
                            <input type="hidden" name="full_address" id="full_address" value="{{ old('full_address') }}">
                            
                            <!-- Map Container -->
                            <div id="map"></div>                              <!-- Map Instructions -->                            
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
                            <div id="location-info" class="location-info" style="display: none;">
                                <strong class="location-selected">📍 Lokasi Terpilih:</strong>
                                <div id="selected-address">Belum ada lokasi yang dipilih</div>
                                <small class="text-muted">Koordinat: <span id="coordinates"></span></small>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="form-control mt-4">Register</button>
                </form>

                <p class="text-center text-white">
                    Sudah punya akun? <a href="{{ route('login.form') }}" class="text-white" style="color: var(--primary-color) !important;">Login sekarang</a>
                </p>
            </div>
        </div>
    </div>
</section>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const passwordIcon = document.getElementById('password-icon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            passwordIcon.classList.remove('bi-eye');
            passwordIcon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            passwordIcon.classList.remove('bi-eye-slash');
            passwordIcon.classList.add('bi-eye');
        }    }
</script>

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
let map;
let marker;
let selectedLatLng = null;

// Initialize map
document.addEventListener('DOMContentLoaded', function() {
    initializeMap();
    
    // Add event listener for current location button
    document.getElementById('current-location-btn').addEventListener('click', function() {
        getUserLocation();
    });
});

function initializeMap() {
    // Default location (Indonesia center)
    const defaultLat = -2.5489;
    const defaultLng = 118.0149;
    
    // Initialize map
    map = L.map('map').setView([defaultLat, defaultLng], 5);
    
    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);
    
    // PENTING: TIDAK auto-detect lokasi saat load halaman
    // Hanya deteksi lokasi saat user klik tombol "Lokasi Saya"
    
    // Add click event to map
    map.on('click', function(e) {
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;
        addMarker(lat, lng);
    });
}

function getUserLocation() {
    if (navigator.geolocation) {
        // Show loading indicator on button
        const locationBtn = document.getElementById('current-location-btn');
        const originalContent = locationBtn.innerHTML;
        locationBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Mencari...';
        locationBtn.disabled = true;
        
        // Tampilkan pesan sebelum meminta izin lokasi
        const mapInstructions = document.querySelector('.map-instructions');
        const originalInstructions = mapInstructions.innerHTML;
        mapInstructions.innerHTML = '<i class="bi bi-info-circle-fill text-primary"></i> <strong>Perhatian:</strong> Browser akan meminta izin untuk mengakses lokasi Anda. Harap izinkan untuk mendapatkan lokasi yang akurat.';
        mapInstructions.style.background = 'rgba(255, 193, 7, 0.1)';
        mapInstructions.style.border = '1px solid rgba(255, 193, 7, 0.5)';
        mapInstructions.style.color = '#856404';
        
        // Feature detection untuk mendeteksi status izin
        if (navigator.permissions && navigator.permissions.query) {
            navigator.permissions.query({ name: 'geolocation' }).then(function(result) {
                // Jika status 'prompt', dialog akan muncul
                if (result.state === 'prompt') {
                    console.log('Browser akan menampilkan dialog izin lokasi');
                } else if (result.state === 'granted') {
                    console.log('Izin lokasi sudah diberikan sebelumnya');
                } else if (result.state === 'denied') {
                    console.log('Izin lokasi telah ditolak sebelumnya');                    // Tampilkan pesan bahwa izin telah ditolak
                    mapInstructions.innerHTML = '<i class="bi bi-exclamation-triangle-fill text-danger"></i> <strong>Akses lokasi ditolak:</strong> Anda perlu mengizinkan akses lokasi di browser. Silakan ikuti petunjuk di bawah untuk mengatur ulang izin lokasi.';
                    mapInstructions.style.background = 'rgba(220, 53, 69, 0.1)';
                    mapInstructions.style.border = '1px solid rgba(220, 53, 69, 0.3)';
                    mapInstructions.style.color = '#721c24';
                    
                    // Reset button
                    locationBtn.innerHTML = originalContent;
                    locationBtn.disabled = false;
                    return; // Stop execution if permission is denied
                }
                
                // Lanjutkan dengan getCurrentPosition
                requestGeolocation(locationBtn, originalContent, mapInstructions, originalInstructions);
            });
        } else {
            // Browser tidak mendukung Permissions API, langsung pakai getCurrentPosition
            requestGeolocation(locationBtn, originalContent, mapInstructions, originalInstructions);
        }
    } else {
        alert('Browser Anda tidak mendukung geolocation. Silakan gunakan browser yang lebih baru atau pilih lokasi secara manual di peta.');
    }
}

function requestGeolocation(locationBtn, originalContent, mapInstructions, originalInstructions) {
    navigator.geolocation.getCurrentPosition(
        function(position) {
            const userLat = position.coords.latitude;
            const userLng = position.coords.longitude;
            map.setView([userLat, userLng], 16);
            addMarker(userLat, userLng);
            
            // Force map resize to ensure proper rendering
            setTimeout(function() {
                map.invalidateSize();
            }, 100);
            
            // Reset button and instructions
            locationBtn.innerHTML = originalContent;
            locationBtn.disabled = false;
            mapInstructions.innerHTML = originalInstructions;
            mapInstructions.style.background = '';
            mapInstructions.style.border = '';
            mapInstructions.style.color = '';
            
            // Tampilkan pesan sukses
            const locationInfo = document.getElementById('location-info');
            locationInfo.style.display = 'block';
            locationInfo.style.background = 'rgba(40, 167, 69, 0.1)';
            locationInfo.style.border = '1px solid rgba(40, 167, 69, 0.3)';
            setTimeout(() => {
                locationInfo.style.background = '';
                locationInfo.style.border = '';
            }, 3000);
        },
        function(error) {
            console.error('Error getting current location:', error);
            let errorMessage = 'Tidak dapat menemukan lokasi Anda.';
            let errorDetails = '';
            
            // Customize error message based on error code
            switch(error.code) {                case error.PERMISSION_DENIED:
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
                case error.UNKNOWN_ERROR:
                    errorMessage = 'Terjadi kesalahan yang tidak diketahui';
                    errorDetails = 'Silakan coba lagi atau pilih lokasi secara manual di peta.';
                    break;
            }
            
            // Reset button
            locationBtn.innerHTML = originalContent;
            locationBtn.disabled = false;
            
            // Tampilkan pesan error
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
}

function addMarker(lat, lng) {
    // Remove existing marker
    if (marker) {
        map.removeLayer(marker);
    }
    
    // Add new marker
    marker = L.marker([lat, lng]).addTo(map);
    selectedLatLng = {lat: lat, lng: lng};
    
    // Update hidden fields
    document.getElementById('latitude').value = lat;
    document.getElementById('longitude').value = lng;
    
    // Update coordinates display
    document.getElementById('coordinates').textContent = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
    
    // Reverse geocoding to get address
    reverseGeocode(lat, lng);
}

async function reverseGeocode(lat, lng) {
    try {
        const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`);
        const data = await response.json();
        
        if (data && data.display_name) {
            const address = data.display_name;
            const shortAddress = extractShortAddress(data);
            
            // Update form fields
            document.getElementById('region').value = shortAddress;
            document.getElementById('full_address').value = address;
            
            // Show location info
            document.getElementById('selected-address').textContent = address;
            document.getElementById('location-info').style.display = 'block';
        } else {
            // Handle case when display_name is not available
            handleGeocodeError(lat, lng);
        }
    } catch (error) {
        console.error('Reverse geocoding error:', error);
        handleGeocodeError(lat, lng);
    }
}

function handleGeocodeError(lat, lng) {
    // Fallback for geocoding errors
    document.getElementById('region').value = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
    document.getElementById('full_address').value = `Koordinat: ${lat.toFixed(6)}, ${lng.toFixed(6)}`;
    document.getElementById('location-info').style.display = 'block';
    document.getElementById('selected-address').textContent = 'Lokasi berhasil dipilih (alamat tidak tersedia)';
}

function extractShortAddress(data) {
    // Extract relevant parts for short address
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

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    if (!selectedLatLng) {
        e.preventDefault();
        alert('Silakan pilih lokasi Anda pada map terlebih dahulu!');
        return false;
    }
});
</script>
@endpush

@endsection