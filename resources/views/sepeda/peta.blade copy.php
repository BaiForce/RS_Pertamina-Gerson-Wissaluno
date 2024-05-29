@extends('layouts.app')

@section('title', 'Pantau Konsumen')

@push('style')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    @include('components.peta')
@endpush


@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Pantau Konsumen</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Kelola</a></div>
                <div class="breadcrumb-item">Tracking</div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Pantau Sepeda </h4>
                        <!-- Button trigger modal -->
                        <a href="{{ route('sepeda.index') }}" class="btn btn-danger btn-lg">&lt; Back</a>
                    </div>
                    <div class="card-body">
                                     <!-- Div for the map -->
                                    <div id="map" style="height: 400px;"></div>
                                </div>
                        <!-- Tambahkan div untuk menampilkan respons JSON -->
                        <div id="response"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<!-- Leaflet JavaScript -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    var map = L.map('map').setView([-1.2687, 116.8314], 12); // Inisialisasi peta dengan posisi awal di Balikpapan
    var markerLayer = L.layerGroup().addTo(map); // Grup untuk menyimpan marker
    var clickedMarkerId = null; // Untuk menyimpan ID sepeda yang diklik

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Fungsi untuk memperbarui posisi marker pada peta
    function updateMap() {
        // Hapus marker yang ada sebelumnya
        markerLayer.clearLayers();

        fetch(`/latestcoordinates/{sepedaId}`)
            .then(response => response.json())
            .then(data => {
                data.forEach(sepeda => {
                    var latitude = sepeda.latitude;
                    var longitude = sepeda.longitude;
                    var idSepeda = sepeda.id_sepeda;
                    var number = sepeda.number;

                    // Menambahkan marker untuk setiap sepeda dengan ikon kustom
                    var marker = L.marker([latitude, longitude], {
                        icon: L.divIcon({
                            className: 'bicycle-marker' + (idSepeda === clickedMarkerId ?
                                ' clicked' : ''
                            ), // Tambahkan kelas "clicked" jika ID sepeda sama dengan yang diklik
                            html: number
                        })
                    }).addTo(markerLayer);

                    // Tambahkan event listener untuk menangani klik pada marker
                    marker.on('click', function() {
                        // Perbarui ID sepeda yang diklik
                        clickedMarkerId = idSepeda;
                        // Panggil fungsi untuk memperbarui tampilan peta
                        updateMap();
                    });
                });

                // Mendapatkan bounding box untuk semua marker
                var bounds = markerLayer.getBounds();

                // Set view peta agar marker terlihat dengan baik
                map.fitBounds(bounds);
            })
            .catch(error => console.error('Error:', error));
    }

    // Panggil fungsi updateMap secara periodik setiap 5 detik
    setInterval(updateMap, 5000);

    // Panggil fungsi updateMap saat halaman dimuat
    updateMap();
</script>
@endpush

