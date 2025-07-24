{{-- resources/views/filament/technician/service-request-map.blade.php --}}
@if($getRecord()->lat && $getRecord()->lng)
    <div class="w-full">
        <!-- Map Container -->
        <div id="service-request-map" style="height: 400px; width: 100%; border-radius: 8px;"></div>
        
        <!-- Location Details -->
        <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div>
                    <span class="font-medium text-gray-700 dark:text-gray-300">Coordinates:</span>
                    <p class="text-gray-900 dark:text-gray-100">{{ $getRecord()->lat }}, {{ $getRecord()->lng }}</p>
                </div>
                <div>
                    <span class="font-medium text-gray-700 dark:text-gray-300">Distance Tools:</span>
                    <div class="flex space-x-2 mt-1">
                        <a href="https://www.google.com/maps?q={{ $getRecord()->lat }},{{ $getRecord()->lng }}" 
                           target="_blank" 
                           class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded hover:bg-blue-200">
                            📍 Google Maps
                        </a>
                        <a href="https://www.google.com/maps/dir//{{ $getRecord()->lat }},{{ $getRecord()->lng }}" 
                           target="_blank" 
                           class="inline-flex items-center px-2 py-1 bg-green-100 text-green-800 text-xs rounded hover:bg-green-200">
                            🧭 Get Directions
                        </a>
                    </div>
                </div>
                <div>
                    <span class="font-medium text-gray-700 dark:text-gray-300">Request Info:</span>
                    <p class="text-gray-900 dark:text-gray-100 text-xs">
                        {{ $getRecord()->vehicle_type }} - {{ $getRecord()->vehicle_model }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize the map only if it hasn't been initialized
            if (!window.serviceRequestMapInitialized) {
                // Load Leaflet CSS and JS
                if (!document.querySelector('link[href*="leaflet"]')) {
                    const leafletCSS = document.createElement('link');
                    leafletCSS.rel = 'stylesheet';
                    leafletCSS.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
                    document.head.appendChild(leafletCSS);
                }

                if (!window.L) {
                    const leafletJS = document.createElement('script');
                    leafletJS.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
                    leafletJS.onload = function() {
                        initializeMap();
                    };
                    document.head.appendChild(leafletJS);
                } else {
                    initializeMap();
                }
            }

            function initializeMap() {
                const lat = {{ $getRecord()->lat }};
                const lng = {{ $getRecord()->lng }};
                
                // Create map
                const map = L.map('service-request-map').setView([lat, lng], 15);

                // Add OpenStreetMap tiles
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                    maxZoom: 19
                }).addTo(map);

                // Custom marker icon
                const serviceIcon = L.divIcon({
                    html: `
                        <div style="
                            background-color: #ef4444;
                            width: 30px;
                            height: 30px;
                            border-radius: 50%;
                            border: 3px solid white;
                            box-shadow: 0 2px 4px rgba(0,0,0,0.3);
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            font-size: 14px;
                            color: white;
                        ">
                            🔧
                        </div>
                    `,
                    className: 'custom-service-marker',
                    iconSize: [30, 30],
                    iconAnchor: [15, 15]
                });

                // Add marker
                const marker = L.marker([lat, lng], { icon: serviceIcon }).addTo(map);

                // Popup content
                const popupContent = `
                    <div style="min-width: 200px;">
                        <h3 style="margin: 0 0 8px 0; font-weight: bold; color: #1f2937;">
                            Service Request #{{ $getRecord()->id }}
                        </h3>
                        <p style="margin: 4px 0; font-size: 14px;">
                            <strong>Customer:</strong> {{ $getRecord()->user->name ?? 'N/A' }}
                        </p>
                        <p style="margin: 4px 0; font-size: 14px;">
                            <strong>Service:</strong> {{ $getRecord()->service->name ?? 'N/A' }}
                        </p>
                        <p style="margin: 4px 0; font-size: 14px;">
                            <strong>Vehicle:</strong> {{ $getRecord()->vehicle_type }} - {{ $getRecord()->vehicle_model }}
                        </p>
                        <p style="margin: 4px 0; font-size: 14px;">
                            <strong>Status:</strong> 
                            <span style="
                                padding: 2px 6px; 
                                border-radius: 4px; 
                                font-size: 12px;
                                background-color: {{ $getRecord()->status === 'pending' ? '#fbbf24' : ($getRecord()->status === 'assigned' ? '#3b82f6' : ($getRecord()->status === 'completed' ? '#10b981' : '#ef4444')) }};
                                color: white;
                            ">
                                {{ ucfirst($getRecord()->status) }}
                            </span>
                        </p>
                        <div style="margin-top: 8px; text-align: center;">
                            <a href="https://www.google.com/maps/dir//{{ $getRecord()->lat }},{{ $getRecord()->lng }}" 
                               target="_blank" 
                               style="
                                   display: inline-block;
                                   padding: 4px 8px;
                                   background-color: #059669;
                                   color: white;
                                   text-decoration: none;
                                   border-radius: 4px;
                                   font-size: 12px;
                               ">
                                Get Directions
                            </a>
                        </div>
                    </div>
                `;

                marker.bindPopup(popupContent);

                // Add a circle to show approximate service area
                L.circle([lat, lng], {
                    color: '#ef4444',
                    fillColor: '#ef4444',
                    fillOpacity: 0.1,
                    radius: 500 // 500 meters radius
                }).addTo(map);

                // Add current location if available
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        const userLat = position.coords.latitude;
                        const userLng = position.coords.longitude;
                        
                        // Add user location marker
                        const userIcon = L.divIcon({
                            html: `
                                <div style="
                                    background-color: #059669;
                                    width: 20px;
                                    height: 20px;
                                    border-radius: 50%;
                                    border: 2px solid white;
                                    box-shadow: 0 2px 4px rgba(0,0,0,0.3);
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    font-size: 10px;
                                    color: white;
                                ">
                                    📍
                                </div>
                            `,
                            className: 'user-location-marker',
                            iconSize: [20, 20],
                            iconAnchor: [10, 10]
                        });

                        L.marker([userLat, userLng], { icon: userIcon })
                            .addTo(map)
                            .bindPopup('Your Current Location');

                        // Draw a line between user and service location
                        const distance = map.distance([userLat, userLng], [lat, lng]);
                        const distanceKm = (distance / 1000).toFixed(2);

                        L.polyline([
                            [userLat, userLng], 
                            [lat, lng]
                        ], {
                            color: '#059669',
                            weight: 3,
                            opacity: 0.7,
                            dashArray: '5, 5'
                        }).addTo(map).bindPopup(`Distance: ${distanceKm} km`);

                        // Fit map to show both locations
                        const group = new L.featureGroup([
                            L.marker([lat, lng]),
                            L.marker([userLat, userLng])
                        ]);
                        map.fitBounds(group.getBounds().pad(0.1));
                    }, function(error) {
                        console.log('Geolocation error:', error);
                    });
                }

                window.serviceRequestMapInitialized = true;
            }
        });
    </script>
    @endpush
@else
    <div class="flex items-center justify-center h-32 bg-gray-100 dark:bg-gray-800 rounded-lg">
        <div class="text-center">
            <p class="text-gray-500 dark:text-gray-400 mb-2">📍 Location not available</p>
            <p class="text-sm text-gray-400 dark:text-gray-500">No coordinates provided for this service request</p>
        </div>
    </div>
@endif