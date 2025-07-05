<x-app-layout-admin>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-label mb-0">User's Current Locations</h2>
            <button id="refreshBtn" class="btn btn-sm btn-primary">🔄 Refresh</button>
        </div>

        <div class="card-body">
            <div id="map" style="height: 600px;"></div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    @endpush

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script>
            let userLocationMap = L.map('map').setView([26.2006, 92.9376], 8);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(userLocationMap);

            let markers = [];

            function loadMarkers() {
                // Clear old markers
                markers.forEach(marker => userLocationMap.removeLayer(marker));
                markers = [];

                fetch('{{ route('admin.user-locations.ajax') }}')
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(loc => {
                            if (loc.latitude && loc.longitude) {
                                const marker = L.marker([loc.latitude, loc.longitude])
                                    .addTo(userLocationMap)
                                    .bindPopup(`
                                        <strong>${loc.user?.name ?? 'Unnamed'}</strong><br>
                                        ${loc.user?.email ?? 'No email'}<br>
                                        Updated: ${loc.updated_at_formatted}
                                    `);
                                markers.push(marker);
                            }
                        });
                    });
            }

            // Initial load
            loadMarkers();

            // Refresh button
            document.getElementById('refreshBtn').addEventListener('click', loadMarkers);

            // Auto refresh every 1 minute
            setInterval(loadMarkers, 60 * 1000);
        </script>
    @endpush

</x-app-layout-admin>
