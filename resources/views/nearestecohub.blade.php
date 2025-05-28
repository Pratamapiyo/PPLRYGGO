@extends('layouts.layout')

@section('title', 'Nearest EcoHub')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
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
    
    /* Route button styling */
    .btn-info {
        background: linear-gradient(135deg, #17a2b8, #138496);
        border-color: #17a2b8;
        color: white;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-info:hover {
        background: linear-gradient(135deg, #138496, #0f6674);
        border-color: #138496;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(23, 162, 184, 0.3);
    }
    
    .btn-info:active {
        transform: translateY(0);
    }
    
    /* Route popup styling improvements */
    .leaflet-popup-content {
        margin: 12px 16px !important;
        line-height: 1.4 !important;
    }
    
    .popup-title {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
        font-size: 1em;
    }
    
    .popup-details p {
        margin-bottom: 8px;
        color: #6c757d;
        font-size: 0.9em;
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
    
    /* Success state for location button */
    .btn-success {
        background: linear-gradient(135deg, #28a745, #20c997);
        border: none;
        color: white;
        font-weight: 600;
        padding: 12px 24px;
        border-radius: 25px;
        transition: all 0.3s ease;
        box-shadow: 0 3px 12px rgba(40, 167, 69, 0.3);
    }
    
    .btn-success:hover {
        background: linear-gradient(135deg, #20c997, #17a2b8);
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(40, 167, 69, 0.4);
        color: white;
    }
    
    /* Warning state for location button */
    .btn-warning {
        background: linear-gradient(135deg, #ffc107, #fd7e14);
        border: none;
        color: white;
        font-weight: 600;
        padding: 12px 24px;
        border-radius: 25px;
        transition: all 0.3s ease;
        box-shadow: 0 3px 12px rgba(255, 193, 7, 0.3);
    }
    
    .btn-warning:hover {
        background: linear-gradient(135deg, #fd7e14, #dc3545);
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(255, 193, 7, 0.4);
        color: white;
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
                <div class="location-controls">                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="mb-2">📍 Your Location</h5>
                            <p class="mb-0">We'll automatically detect your location to find the nearest EcoHub vendors. You can also manually refresh your location if needed.</p>
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
                <h5 class="mb-3">📋 Available Vendors</h5>                <div id="vendors-list" class="vendor-list">
                    <div class="no-vendors">
                        <i class="bi bi-geo-alt text-muted" style="font-size: 2rem;"></i>
                        <p class="mt-2 mb-0">Detecting your location to find nearby vendors...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
<script>
let vendorsMap;
let userMarker;
let vendorMarkers = [];
let userLocation = null;
let allVendors = @json($ecohubs);
let selectedVendorId = null;
let routeControl = null;

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
    
    // Automatically attempt to get user location
    autoGetUserLocation();
});

function initializeMap() {
    // Default center: Indonesia
    const defaultLat = -2.5489;
    const defaultLng = 118.0149;
      try {
        // Initialize map with closer zoom level
        vendorsMap = L.map('vendors-map').setView([defaultLat, defaultLng], 7);
        
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
    
    requestUserLocation(btn, locationStatus, true);
}

function autoGetUserLocation() {
    const btn = document.getElementById('get-location-btn');
    const locationStatus = document.getElementById('location-status');
    
    if (!navigator.geolocation) {
        console.log('Geolocation is not supported by this browser');
        updateLocationButton(btn, 'not-supported');
        return;
    }
    
    console.log('Automatically attempting to get user location...');
    
    // Update button state to show auto-detection
    btn.disabled = true;
    btn.innerHTML = '<i class="bi bi-arrow-clockwise spin me-2"></i>Auto-detecting Location...';
    
    requestUserLocation(btn, locationStatus, false);
}

function requestUserLocation(btn, locationStatus, isManualRequest) {
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
            
            // Refresh vendor list to show route buttons
            displayVendorsList(allVendors);
            
            // Update location status
            reverseGeocode(userLocation.lat, userLocation.lng);
            
            // Update button state
            updateLocationButton(btn, 'success');
            
            // Show location status
            locationStatus.style.display = 'block';
            
            // Enable route functionality message
            console.log('Route functionality is now available for all vendors');
            
        },
        function(error) {
            console.error('Geolocation error:', error);
            let errorMessage = 'Unable to get your location. ';
            
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    errorMessage += 'Please allow location access and try again.';
                    updateLocationButton(btn, 'permission-denied');
                    break;
                case error.POSITION_UNAVAILABLE:
                    errorMessage += 'Location information is unavailable.';
                    updateLocationButton(btn, 'unavailable');
                    break;
                case error.TIMEOUT:
                    errorMessage += 'Location request timed out.';
                    updateLocationButton(btn, 'timeout');
                    break;
                default:
                    errorMessage += 'An unknown error occurred.';
                    updateLocationButton(btn, 'error');
                    break;
            }
            
            // Only show alert for manual requests
            if (isManualRequest) {
                alert(errorMessage);
            } else {
                console.log('Auto-location detection failed:', errorMessage);
            }
        },
        {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 300000 // Cache location for 5 minutes
        }
    );
}

function updateLocationButton(btn, status) {
    btn.disabled = false;
    
    switch(status) {
        case 'success':
            btn.innerHTML = '<i class="bi bi-check-circle-fill me-2"></i>Location Found';
            btn.classList.add('btn-success');
            btn.classList.remove('btn-location');
            break;
        case 'permission-denied':
            btn.innerHTML = '<i class="bi bi-exclamation-triangle-fill me-2"></i>Permission Needed';
            btn.classList.add('btn-warning');
            btn.classList.remove('btn-location');
            break;
        case 'unavailable':
        case 'timeout':
        case 'error':
            btn.innerHTML = '<i class="bi bi-geo-alt-fill me-2"></i>Try Again';
            break;
        case 'not-supported':
            btn.innerHTML = '<i class="bi bi-x-circle-fill me-2"></i>Not Supported';
            btn.disabled = true;
            break;
        default:
            btn.innerHTML = '<i class="bi bi-geo-alt-fill me-2"></i>Get My Location';
            break;
    }
}

function addUserMarker(lat, lng) {
    // Remove existing user marker
    if (userMarker) {
        vendorsMap.removeLayer(userMarker);
    }
    
    // Get current zoom level to determine marker size
    const zoom = vendorsMap.getZoom();
    const size = getMarkerSize(zoom, 'user');
    
    // Create user marker with red icon
    const userIcon = L.divIcon({
        html: `<div style="background: #dc3545; border: 3px solid white; border-radius: 50%; width: ${size}px; height: ${size}px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.3);"><i class="bi bi-geo-alt-fill" style="color: white; font-size: ${Math.max(8, size * 0.6)}px;"></i></div>`,
        iconSize: [size + 6, size + 6],
        iconAnchor: [(size + 6) / 2, (size + 6) / 2],
        className: 'user-location-marker'
    });
    
    userMarker = L.marker([lat, lng], { icon: userIcon })
        .addTo(vendorsMap)
        .bindPopup('<div class="popup-title">📍 Your Location</div><div class="popup-details">You are here</div>');
    
    // Update marker size on zoom
    vendorsMap.on('zoom', function() {
        if (userMarker) {
            const newZoom = vendorsMap.getZoom();
            const newSize = getMarkerSize(newZoom, 'user');
            const newIcon = L.divIcon({
                html: `<div style="background: #dc3545; border: 3px solid white; border-radius: 50%; width: ${newSize}px; height: ${newSize}px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.3);"><i class="bi bi-geo-alt-fill" style="color: white; font-size: ${Math.max(8, newSize * 0.6)}px;"></i></div>`,
                iconSize: [newSize + 6, newSize + 6],
                iconAnchor: [(newSize + 6) / 2, (newSize + 6) / 2],
                className: 'user-location-marker'
            });
            userMarker.setIcon(newIcon);
        }
    });
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
            
            // Get current zoom level to determine marker size
            const zoom = vendorsMap.getZoom();
            const size = getMarkerSize(zoom, 'vendor');
            
            // Create vendor marker with green icon
            const vendorIcon = L.divIcon({
                html: `<div style="background: #28a745; border: 3px solid white; border-radius: 50%; width: ${size}px; height: ${size}px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.3);"><i class="bi bi-building" style="color: white; font-size: ${Math.max(6, size * 0.5)}px;"></i></div>`,
                iconSize: [size + 6, size + 6],
                iconAnchor: [(size + 6) / 2, (size + 6) / 2],
                className: 'vendor-location-marker'
            });
              const marker = L.marker([lat, lng], { icon: vendorIcon })
                .addTo(vendorsMap)
                .bindPopup(createVendorPopup(vendor));
            
            // Add click event to highlight vendor in list and optionally show route
            marker.on('click', function() {
                highlightVendorInList(vendor.id);
                
                // If user location is available and user has already shown interest in routing,
                // we could auto-show route on marker click, but let's keep it optional via popup button
            });
            
            // Store vendor data in marker for reference
            marker.vendorData = vendor;
            
            vendorMarkers.push(marker);
        }
    });
    
    // Update vendor marker sizes on zoom
    vendorsMap.off('zoom.vendors'); // Remove previous listener
    vendorsMap.on('zoom.vendors', function() {
        const newZoom = vendorsMap.getZoom();
        vendorMarkers.forEach(marker => {
            if (marker.vendorData) {
                const newSize = getMarkerSize(newZoom, 'vendor');
                const newIcon = L.divIcon({
                    html: `<div style="background: #28a745; border: 3px solid white; border-radius: 50%; width: ${newSize}px; height: ${newSize}px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.3);"><i class="bi bi-building" style="color: white; font-size: ${Math.max(6, newSize * 0.5)}px;"></i></div>`,
                    iconSize: [newSize + 6, newSize + 6],
                    iconAnchor: [(newSize + 6) / 2, (newSize + 6) / 2],
                    className: 'vendor-location-marker'
                });
                marker.setIcon(newIcon);
            }
        });
    });
}

function createVendorPopup(vendor) {
    const distanceText = vendor.calculated_distance 
        ? `<br><strong>Distance:</strong> ${vendor.calculated_distance.toFixed(2)} km` 
        : '';
    
    const spesialisasiText = vendor.spesialisasi 
        ? `<br><strong>Specialization:</strong> ${vendor.spesialisasi}` 
        : '';
    
    const routeButton = userLocation && vendor.calculated_distance 
        ? `<button onclick="showRoute(${vendor.user.latitude}, ${vendor.user.longitude}, '${vendor.business_name}')" class="btn btn-sm btn-info me-1">📍 Show Route</button>`
        : '';
    
    return `
        <div class="popup-title">🏢 ${vendor.business_name}</div>
        <div class="popup-details">
            <strong>Location:</strong> ${vendor.location}<br>
            <strong>Contact:</strong> ${vendor.contact}${distanceText}${spesialisasiText}
        </div>
        <div class="mt-2">
            ${routeButton}
            <a href="/ecohub/${vendor.id}" class="btn btn-sm btn-success">View Details</a>
        </div>
    `;
}

function getMarkerSize(zoom, type) {
    // Calculate marker size based on zoom level
    // At very small zoom levels, markers should be much bigger for visibility
    // At higher zoom levels, markers can be smaller
    let baseSize;
    
    if (type === 'user') {
        baseSize = 20;
    } else {
        baseSize = 18;
    }
    
    if (zoom <= 4) {
        return baseSize + 25; // Extra big at very small zoom for country/continent view
    } else if (zoom <= 6) {
        return baseSize + 20; // Much bigger at small zoom for state/region view
    } else if (zoom <= 8) {
        return baseSize + 15; // Bigger for city view
    } else if (zoom <= 10) {
        return baseSize + 8; // Slightly bigger for district view
    } else if (zoom <= 12) {
        return baseSize + 3; // Normal plus for neighborhood view
    } else if (zoom <= 14) {
        return baseSize; // Normal size for street view
    } else {
        return Math.max(baseSize - 3, 12); // Slightly smaller for detailed view but not too small
    }
}

function showRoute(destLat, destLng, vendorName) {
    if (!userLocation) {
        alert('Please get your location first to show route.');
        return;
    }
    
    // Remove existing route
    if (routeControl) {
        vendorsMap.removeControl(routeControl);
    }
    
    // Create route control
    routeControl = L.Routing.control({
        waypoints: [
            L.latLng(userLocation.lat, userLocation.lng),
            L.latLng(destLat, destLng)
        ],
        routeWhileDragging: false,
        addWaypoints: false,
        createMarker: function() {
            return null; // Don't create additional markers
        },
        lineOptions: {
            styles: [{
                color: '#007bff',
                weight: 6,
                opacity: 0.8
            }]
        },
        show: false, // Hide the instruction panel
        collapsible: true,
        formatter: new L.Routing.Formatter({
            language: 'en'
        })
    }).addTo(vendorsMap);
      // Add route info popup with better styling
    const routePopup = L.popup()
        .setLatLng([destLat, destLng])
        .setContent(`
            <div class="popup-title">🛣️ Route to ${vendorName}</div>
            <div class="popup-details">
                <p class="mb-2">Route calculated from your location</p>
                <div class="d-flex gap-1">
                    <button onclick="clearRoute()" class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-x-circle me-1"></i>Clear Route
                    </button>
                    <button onclick="vendorsMap.fitBounds(routeControl.getBounds())" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-arrows-fullscreen me-1"></i>Fit Route
                    </button>
                </div>
            </div>
        `)
        .openOn(vendorsMap);
}

function clearRoute() {
    if (routeControl) {
        vendorsMap.removeControl(routeControl);
        routeControl = null;
    }
    vendorsMap.closePopup();
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
        
        // Create route button if vendor has coordinates and user location is available
        const routeButtonHtml = (vendor.user && vendor.user.latitude && vendor.user.longitude && userLocation)
            ? `<button onclick="event.stopPropagation(); showRoute(${vendor.user.latitude}, ${vendor.user.longitude}, '${vendor.business_name.replace(/'/g, '\\\'')}')" class="btn btn-sm btn-info me-1" title="Show route to this vendor">
                <i class="bi bi-geo-alt-fill me-1"></i>Get Directions
               </button>`
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
                    ${routeButtonHtml}
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