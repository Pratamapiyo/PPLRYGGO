@extends('layouts.layout')

@section('title', 'Nearest EcoHub')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .main-map {
        height: 500px;
        width: 100%;
        border-radius: 12px;
        margin-bottom: 20px;
        border: 2px solid #e8f5e8;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        z-index: 1;
        position: relative;
    }
      .location-controls {
        background: linear-gradient(135deg, #4a90e2, #357abd);
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        color: white;
        box-shadow: 0 4px 15px rgba(74, 144, 226, 0.3);
    }
    
    .location-status {
        background: rgba(255,255,255,0.95);
        padding: 15px;
        border-radius: 8px;
        margin-top: 15px;
        color: #333;
        border-left: 4px solid #28a745;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .vendor-list {
        max-height: 500px;
        overflow-y: auto;
        background: #f8f9fa;
        border-radius: 12px;
        padding: 15px;
        border: 1px solid #e8f5e8;
    }
    
    .vendor-item {
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    
    .vendor-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        border-color: #28a745;
    }
    
    .vendor-item.selected {
        border-color: #28a745;
        background: #f8fff8;
        box-shadow: 0 3px 15px rgba(40, 167, 69, 0.2);
    }
    
    .vendor-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 4px;
        background: #28a745;
        transform: scaleY(0);
        transition: transform 0.3s ease;
    }
    
    .vendor-item:hover::before,
    .vendor-item.selected::before {
        transform: scaleY(1);
    }
    
    .vendor-distance {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.85em;
        font-weight: 600;
        display: inline-block;
        margin-bottom: 8px;
        box-shadow: 0 2px 8px rgba(0, 123, 255, 0.3);
    }
    
    .vendor-name {
        font-size: 1.1em;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
    }
    
    .vendor-details {
        font-size: 0.9em;
        color: #6c757d;
        line-height: 1.4;
    }
    
    .vendor-spesialisasi {
        background: #17a2b8;
        color: white;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 0.8em;
        display: inline-block;
        margin-top: 5px;
    }
    
    .filters-section {
        background: white;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        border: 1px solid #e8f5e8;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
      .btn-location {
        background: linear-gradient(135deg, #ff6b6b, #ee5a52);
        border: none;
        color: white;
        font-weight: 600;
        padding: 12px 24px;
        border-radius: 25px;
        transition: all 0.3s ease;
        box-shadow: 0 3px 12px rgba(255, 107, 107, 0.3);
    }
    
    .btn-location:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(255, 107, 107, 0.4);
        color: white;
    }
    
    .btn-location:disabled {
        opacity: 0.7;
        transform: none;
        box-shadow: 0 3px 12px rgba(255, 107, 107, 0.2);
    }
    
    .filter-controls .form-select {
        border-radius: 8px;
        border: 2px solid #e8f5e8;
        padding: 10px 15px;
        transition: all 0.3s ease;
    }
    
    .filter-controls .form-select:focus {
        border-color: #28a745;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    }
    
    .no-vendors {
        text-align: center;
        padding: 40px;
        color: #6c757d;
        background: white;
        border-radius: 12px;
        border: 2px dashed #dee2e6;
    }
    
    .leaflet-popup-content {
        font-family: 'Segoe UI', sans-serif;
        line-height: 1.4;
    }
    
    .popup-title {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
        font-size: 1.1em;
    }
    
    .popup-details {
        font-size: 0.9em;
        color: #6c757d;
    }
    
    .leaflet-control-container {
        z-index: 1000 !important;
    }
    
    .map-legend {
        background: rgba(255, 255, 255, 0.95);
        padding: 12px;
        border-radius: 8px;
        position: absolute;
        bottom: 20px;
        left: 20px;
        z-index: 1000;
        border: 1px solid #ddd;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .legend-item {
        display: flex;
        align-items: center;
        margin-bottom: 5px;
        font-size: 0.85em;
    }
    
    .legend-icon {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin-right: 8px;
    }
    
    @media (max-width: 768px) {
        .main-map {
            height: 350px;
        }
        
        .location-controls {
            padding: 15px;
        }
        
        .vendor-list {
            max-height: 400px;
        }
        
        .map-legend {
            bottom: 10px;
            left: 10px;
            padding: 8px;
            font-size: 0.8em;
        }
    }
</style>
@endpush

@section('content')

<section class="section-padding" id="section_nearest_ecohub">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-12 text-center mb-4">
                <h2>🗺️ Nearest EcoHub Locations</h2>
                <p class="text-muted">Find recycling vendors near you with interactive map and real-time distance calculation</p>
            </div>
            
            <!-- Location Controls -->
            <div class="col-lg-12 col-12">
                <div class="location-controls">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="mb-2">📍 Find Your Location</h5>
                            <p class="mb-0">Click the button to detect your location and find the nearest EcoHub vendors</p>
                        </div>
                        <div class="col-md-4 text-md-end text-center mt-3 mt-md-0">
                            <button id="get-location-btn" class="btn btn-location">
                                <i class="bi bi-geo-alt-fill me-2"></i>Get My Location
                            </button>
                        </div>
                    </div>
                    <div id="location-status" class="location-status" style="display: none;">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                            <div>
                                <strong>Location Found:</strong><br>
                                <span id="user-address">-</span><br>
                                <small class="text-muted">Coordinates: <span id="user-coordinates">-</span></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Filters -->
            <div class="col-lg-12 col-12">
                <div class="filters-section">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h6 class="mb-3">🔍 Filter Options</h6>
                        </div>
                        <div class="col-md-6">
                            <div class="row filter-controls">
                                <div class="col-md-6 mb-2 mb-md-0">
                                    <select id="distance-filter" class="form-select">
                                        <option value="">Sort by Distance</option>
                                        <option value="nearest">🎯 Nearest First</option>
                                        <option value="farthest">📍 Farthest First</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select id="specialization-filter" class="form-select">
                                        <option value="">All Specializations</option>
                                        @foreach ($spesialisasiOptions as $option)
                                            <option value="{{ $option }}">🔄 {{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <!-- Map Column -->
            <div class="col-lg-8 col-12 mb-4">
                <div id="vendors-map" class="main-map"></div>
                <div class="map-legend">
                    <div class="legend-item">
                        <div class="legend-icon" style="background: #dc3545;"></div>
                        <span>Your Location</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-icon" style="background: #28a745;"></div>
                        <span>EcoHub Vendors</span>
                    </div>
                </div>
            </div>
            
            <!-- Vendors List Column -->
            <div class="col-lg-4 col-12">
                <h5 class="mb-3">📋 Available Vendors</h5>
                <div id="vendors-list" class="vendor-list">
                    <div class="no-vendors">
                        <i class="bi bi-geo-alt text-muted" style="font-size: 2rem;"></i>
                        <p class="mt-2 mb-0">Click "Get My Location" to find nearby vendors</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
let vendorsMap;
let userMarker;
let vendorMarkers = [];
let userLocation = null;
let allVendors = @json($ecohubs);
let selectedVendorId = null;

// Initialize map when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('Initializing vendors map...');
    console.log('All vendors data:', allVendors);
    console.log('Number of vendors:', allVendors.length);
    
    // Check if vendors have user relationship
    allVendors.forEach((vendor, index) => {
        console.log(`Vendor ${index + 1} (${vendor.business_name}):`, {
            id: vendor.id,
            has_user: !!vendor.user,
            user_data: vendor.user,
            latitude: vendor.user?.latitude,
            longitude: vendor.user?.longitude
        });
    });
    
    initializeMap();
    
    // Setup event listeners
    setupEventListeners();
    
    // Load initial vendors data
    displayVendorsList(allVendors);
});

function initializeMap() {
    // Default center: Indonesia
    const defaultLat = -2.5489;
    const defaultLng = 118.0149;
      try {
        // Initialize map
        vendorsMap = L.map('vendors-map').setView([defaultLat, defaultLng], 5);
        
        // Add CartoDB Positron tiles (cleaner, less detailed style)
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
            subdomains: 'abcd',
            maxZoom: 19
        }).addTo(vendorsMap);
        
        console.log('Vendors map initialized successfully');
        
        // Add existing vendors to map (without distance calculation initially)
        addVendorsToMap(allVendors);
        
    } catch (error) {
        console.error('Error initializing vendors map:', error);
    }
}

function setupEventListeners() {
    // Get location button
    const getLocationBtn = document.getElementById('get-location-btn');
    if (getLocationBtn) {
        getLocationBtn.addEventListener('click', getUserLocation);
    }
    
    // Filter controls
    const distanceFilter = document.getElementById('distance-filter');
    const specializationFilter = document.getElementById('specialization-filter');
    
    if (distanceFilter) {
        distanceFilter.addEventListener('change', applyFilters);
    }
    
    if (specializationFilter) {
        specializationFilter.addEventListener('change', applyFilters);
    }
}

function getUserLocation() {
    const btn = document.getElementById('get-location-btn');
    const locationStatus = document.getElementById('location-status');
    
    if (!navigator.geolocation) {
        alert('Geolocation is not supported by this browser. Please use a modern browser or enter your location manually.');
        return;
    }
    
    // Update button state
    btn.disabled = true;
    btn.innerHTML = '<i class="bi bi-arrow-clockwise spin me-2"></i>Getting Location...';
    
    navigator.geolocation.getCurrentPosition(
        function(position) {
            userLocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            
            console.log('User location obtained:', userLocation);
            
            // Update map view
            vendorsMap.setView([userLocation.lat, userLocation.lng], 12);
            
            // Add user marker
            addUserMarker(userLocation.lat, userLocation.lng);
            
            // Calculate distances and update vendors
            calculateDistancesAndUpdate();
            
            // Update location status
            reverseGeocode(userLocation.lat, userLocation.lng);
            
            // Reset button
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-check-circle-fill me-2"></i>Location Found';
            
            // Show location status
            locationStatus.style.display = 'block';
            
        },
        function(error) {
            console.error('Geolocation error:', error);
            let errorMessage = 'Unable to get your location. ';
            
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    errorMessage += 'Please allow location access and try again.';
                    break;
                case error.POSITION_UNAVAILABLE:
                    errorMessage += 'Location information is unavailable.';
                    break;
                case error.TIMEOUT:
                    errorMessage += 'Location request timed out.';
                    break;
                default:
                    errorMessage += 'An unknown error occurred.';
                    break;
            }
            
            alert(errorMessage);
            
            // Reset button
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-geo-alt-fill me-2"></i>Get My Location';
        },
        {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        }
    );
}

function addUserMarker(lat, lng) {
    // Remove existing user marker
    if (userMarker) {
        vendorsMap.removeLayer(userMarker);
    }
      // Create user marker with red icon
    const userIcon = L.divIcon({
        html: '<div style="background: #dc3545; border: 3px solid white; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.3);"><i class="bi bi-geo-alt-fill" style="color: white; font-size: 12px;"></i></div>',
        iconSize: [26, 26],
        iconAnchor: [13, 13],
        className: 'user-location-marker'
    });
    
    userMarker = L.marker([lat, lng], { icon: userIcon })
        .addTo(vendorsMap)
        .bindPopup('<div class="popup-title">📍 Your Location</div><div class="popup-details">You are here</div>');
}

function addVendorsToMap(vendors) {
    // Clear existing vendor markers
    vendorMarkers.forEach(marker => vendorsMap.removeLayer(marker));
    vendorMarkers = [];
    
    console.log('Adding vendors to map:', vendors.length, 'vendors');
    console.log('First vendor data:', vendors[0]);
    
    vendors.forEach(vendor => {
        console.log(`Vendor ${vendor.business_name}:`, vendor.user);
        if (vendor.user && vendor.user.latitude && vendor.user.longitude) {
            const lat = parseFloat(vendor.user.latitude);
            const lng = parseFloat(vendor.user.longitude);
            
            console.log(`Adding marker for ${vendor.business_name} at:`, lat, lng);
              // Create vendor marker with green icon
            const vendorIcon = L.divIcon({
                html: '<div style="background: #28a745; border: 3px solid white; border-radius: 50%; width: 18px; height: 18px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.3);"><i class="bi bi-building" style="color: white; font-size: 10px;"></i></div>',
                iconSize: [24, 24],
                iconAnchor: [12, 12],
                className: 'vendor-location-marker'
            });
            
            const marker = L.marker([lat, lng], { icon: vendorIcon })
                .addTo(vendorsMap)
                .bindPopup(createVendorPopup(vendor));
            
            // Add click event to highlight vendor in list
            marker.on('click', function() {
                highlightVendorInList(vendor.id);
            });
            
            vendorMarkers.push(marker);
        }
    });
}

function createVendorPopup(vendor) {
    const distanceText = vendor.calculated_distance 
        ? `<br><strong>Distance:</strong> ${vendor.calculated_distance.toFixed(2)} km` 
        : '';
    
    const spesialisasiText = vendor.spesialisasi 
        ? `<br><strong>Specialization:</strong> ${vendor.spesialisasi}` 
        : '';
    
    return `
        <div class="popup-title">🏢 ${vendor.business_name}</div>
        <div class="popup-details">
            <strong>Location:</strong> ${vendor.location}<br>
            <strong>Contact:</strong> ${vendor.contact}${distanceText}${spesialisasiText}
        </div>
        <div class="mt-2">
            <a href="/ecohub/${vendor.id}" class="btn btn-sm btn-success">View Details</a>
        </div>
    `;
}

function calculateDistancesAndUpdate() {
    if (!userLocation) return;
    
    // Calculate distance for each vendor
    allVendors.forEach(vendor => {
        if (vendor.user && vendor.user.latitude && vendor.user.longitude) {
            const vendorLat = parseFloat(vendor.user.latitude);
            const vendorLng = parseFloat(vendor.user.longitude);
            
            vendor.calculated_distance = calculateDistance(
                userLocation.lat, userLocation.lng,
                vendorLat, vendorLng
            );
        } else {
            vendor.calculated_distance = null;
        }
    });
    
    console.log('Distances calculated for', allVendors.length, 'vendors');
    
    // Apply current filters and update display
    applyFilters();
    
    // Update map popups
    addVendorsToMap(allVendors);
}

function calculateDistance(lat1, lng1, lat2, lng2) {
    const R = 6371; // Radius of the Earth in kilometers
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLng = (lng2 - lng1) * Math.PI / 180;
    const a = 
        Math.sin(dLat/2) * Math.sin(dLat/2) +
        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * 
        Math.sin(dLng/2) * Math.sin(dLng/2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    const distance = R * c;
    
    return distance;
}

function applyFilters() {
    const distanceFilter = document.getElementById('distance-filter').value;
    const specializationFilter = document.getElementById('specialization-filter').value;
    
    let filteredVendors = [...allVendors];
    
    // Apply specialization filter
    if (specializationFilter) {
        filteredVendors = filteredVendors.filter(vendor => 
            vendor.spesialisasi === specializationFilter
        );
    }
    
    // Apply distance sorting
    if (distanceFilter && userLocation) {
        filteredVendors = filteredVendors.filter(vendor => vendor.calculated_distance !== null);
        
        if (distanceFilter === 'nearest') {
            filteredVendors.sort((a, b) => a.calculated_distance - b.calculated_distance);
        } else if (distanceFilter === 'farthest') {
            filteredVendors.sort((a, b) => b.calculated_distance - a.calculated_distance);
        }
    }
    
    console.log('Filters applied. Showing', filteredVendors.length, 'vendors');
    
    // Update vendors list
    displayVendorsList(filteredVendors);
    
    // Update map markers
    addVendorsToMap(filteredVendors);
}

function displayVendorsList(vendors) {
    const vendorsList = document.getElementById('vendors-list');
    
    if (vendors.length === 0) {
        vendorsList.innerHTML = `
            <div class="no-vendors">
                <i class="bi bi-search text-muted" style="font-size: 2rem;"></i>
                <p class="mt-2 mb-0">No vendors found matching your criteria</p>
            </div>
        `;
        return;
    }
    
    let html = '';
    vendors.forEach(vendor => {
        const distanceHtml = vendor.calculated_distance 
            ? `<div class="vendor-distance">📍 ${vendor.calculated_distance.toFixed(2)} km away</div>`
            : '';
        
        const spesialisasiHtml = vendor.spesialisasi 
            ? `<span class="vendor-spesialisasi">${vendor.spesialisasi}</span>`
            : '';
        
        html += `
            <div class="vendor-item" data-vendor-id="${vendor.id}" onclick="selectVendor(${vendor.id})">
                ${distanceHtml}
                <div class="vendor-name">${vendor.business_name}</div>
                <div class="vendor-details">
                    <div><strong>📍 Location:</strong> ${vendor.location}</div>
                    <div><strong>📞 Contact:</strong> ${vendor.contact}</div>
                    <div class="mt-1">${spesialisasiHtml}</div>
                </div>
                <div class="mt-2">
                    <a href="/ecohub/${vendor.id}" class="btn btn-sm btn-outline-success">View Details</a>
                </div>
            </div>
        `;
    });
    
    vendorsList.innerHTML = html;
}

function selectVendor(vendorId) {
    selectedVendorId = vendorId;
    
    // Remove previous selections
    document.querySelectorAll('.vendor-item').forEach(item => {
        item.classList.remove('selected');
    });
    
    // Add selection to clicked vendor
    const vendorItem = document.querySelector(`[data-vendor-id="${vendorId}"]`);
    if (vendorItem) {
        vendorItem.classList.add('selected');
    }
    
    // Find vendor and center map on it
    const vendor = allVendors.find(v => v.id == vendorId);
    if (vendor && vendor.user && vendor.user.latitude && vendor.user.longitude) {
        const lat = parseFloat(vendor.user.latitude);
        const lng = parseFloat(vendor.user.longitude);
        
        vendorsMap.setView([lat, lng], 15);
        
        // Open popup for the selected vendor
        const marker = vendorMarkers.find(marker => {
            const markerLatLng = marker.getLatLng();
            return Math.abs(markerLatLng.lat - lat) < 0.0001 && Math.abs(markerLatLng.lng - lng) < 0.0001;
        });
        
        if (marker) {
            marker.openPopup();
        }
    }
}

function highlightVendorInList(vendorId) {
    selectedVendorId = vendorId;
    
    // Remove previous selections
    document.querySelectorAll('.vendor-item').forEach(item => {
        item.classList.remove('selected');
    });
    
    // Add selection to vendor
    const vendorItem = document.querySelector(`[data-vendor-id="${vendorId}"]`);
    if (vendorItem) {
        vendorItem.classList.add('selected');
        
        // Scroll to vendor item
        vendorItem.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
}

async function reverseGeocode(lat, lng) {
    try {
        const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`);
        const data = await response.json();
        
        if (data && data.display_name) {
            document.getElementById('user-address').textContent = data.display_name;
            document.getElementById('user-coordinates').textContent = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
        } else {
            handleGeocodeError(lat, lng);
        }
    } catch (error) {
        console.error('Reverse geocoding error:', error);
        handleGeocodeError(lat, lng);
    }
}

function handleGeocodeError(lat, lng) {
    const coordString = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
    document.getElementById('user-address').textContent = 'Location detected (address unavailable)';
    document.getElementById('user-coordinates').textContent = coordString;
}

// Add spinning animation for loading button
const style = document.createElement('style');
style.textContent = `
    .spin {
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
`;
document.head.appendChild(style);
</script>
@endpush