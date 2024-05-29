@extends('layouts.app')

@section('title', 'Pantau Konsumen')

@push('style')
@endpush
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
@include('components.peta')



<!-- Leaflet JavaScript -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Pantau Konsumen</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Pantau</a></div>
                <div class="breadcrumb-item">Konsumen</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Konsumen</h2>
            <p class="section-lead">
               Anda dapat melihat semua data penyewaan sepeda
            </p>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Pantau Konsumen {{ $transaction->user->name ?? '' }}</h4>
                            <!-- Button trigger modal -->
                            <a href="{{ route('transaksi.index') }}" class="btn btn-danger btn-lg">
                                < Back </a>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Nama Konsumen</label>
                                        <input type="text" readonly class="form-control"
                                             value="{{ $transaction->user->name ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email">Nomor Sepeda</label>
                                        <input type="text" readonly class="form-control"
                                            value="{{ $transaction->sepeda->number  ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email">Nomor GPS Sepeda</label>
                                        <input type="text" readonly class="form-control"
                                            value="{{ $transaction->sepeda->gps_number  ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email">Jenis Sepeda</label>
                                        <input type="text" readonly class="form-control"
                                            value="{{ $transaction->sepeda->jenis->name  ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email">Tanggal Peminjaman</label>
                                        <input type="text" readonly class="form-control"
                                            value="{{ $transaction->start_date }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email">Waktu Peminjaman</label>
                                        <input type="text" readonly class="form-control"
                                            value="{{ $transaction->start_time }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email">Tanggal Pengembalian</label>
                                        <input type="text" readonly class="form-control"
                                            value="{{ $transaction->end_date }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email">Waktu Pengembalian</label>
                                        <input type="text" readonly class="form-control"
                                            value="{{ $transaction->end_time }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email">Harga Sewa</label>
                                        <input type="text" readonly class="form-control"
                                            value="Rp{{ number_format($transaction->amount) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email">Harga Denda</label>
                                        <input type="text" readonly class="form-control"
                                            value="Rp{{ number_format($transaction->charge) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email">Harga Total</label>
                                        <input type="text" readonly class="form-control"
                                            value="Rp{{ number_format($transaction->total ) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email">Status</label>
                                        @if ($transaction->status == '1')
                                        <span class="badge badge-warning">Sedang Dipinjam</span>
                                        @elseif ($transaction->status == '2')
                                        <span class="badge badge-success">Sudah Pengembalian</span>
                                        @elseif ($transaction->status == '3')
                                        <span class="badge badge-danger">Kadaluarsa</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="email">Foto Jaminan</label>
                                        <!-- <img style="width:300px" src="{{ asset('storage/'.$transaction->jaminan) }}"
                                            alt=""> -->
                                        <div class="gallery">
                                            <div class="gallery-item"
                                                data-image="{{ asset('storage/'.$transaction->jaminan) }}"
                                                data-title="Foto Jaminan"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <!-- Div for the map -->
                                    <div id="map" style="height: 400px;"></div>
                                </div>



                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

</div>
</section>
</div>


</div>
</div>
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
