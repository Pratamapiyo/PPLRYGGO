// Fungsi yang ditingkatkan untuk meminta izin lokasi dengan lebih baik
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
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        errorMessage = 'Akses lokasi ditolak';
                        errorDetails = 'Anda perlu mengizinkan akses lokasi di browser Anda untuk menggunakan fitur ini. Silakan ikuti langkah-langkah berikut:';
                        errorDetails += '<ol><li>Klik ikon kunci/info di address bar browser</li><li>Pilih "Izinkan" atau "Allow" untuk akses lokasi</li><li>Refresh halaman dan coba lagi</li></ol>';
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
    } else {
        alert('Browser Anda tidak mendukung geolocation. Silakan gunakan browser yang lebih baru atau pilih lokasi secara manual di peta.');
    }
}
