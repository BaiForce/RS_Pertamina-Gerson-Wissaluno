@extends('layouts.app')

@section('title', 'Edit Rute')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="assets/modules/datatables/datatables.min.css">
    <link rel="stylesheet" href="assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/prismjs/themes/prism.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Rute</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Kelola</a></div>
                    <div class="breadcrumb-item">Rute</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Edit Rute</h2>
                <p class="section-lead">
                    Anda dapat mengedit data rute.
                </p>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4>Edit Rute: {{ $rute->start_point }} - {{ $rute->end_point }}</h4>
                                <a href="{{ route('rutes.index') }}" class="btn btn-danger btn-lg">&lt; Back</a>
                            </div>
                            <div class="card-body">
                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                <form action="{{ route('rutes.update', $rute->id) }}" method="POST"
                                    class="needs-validation" novalidate>
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group">
                                        <label for="start_point">Titik Awal</label>
                                        <input type="text" name="start_point" id="start_point"
                                            class="form-control @error('start_point') is-invalid @enderror"
                                            value="{{ old('start_point', $rute->start_point) }}" required maxlength="50">
                                        @error('start_point')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="end_point">Titik Akhir</label>
                                        <input type="text" name="end_point" id="end_point"
                                            class="form-control @error('end_point') is-invalid @enderror"
                                            value="{{ old('end_point', $rute->end_point) }}" required maxlength="50">
                                        @error('end_point')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="distance">Jarak (km)</label>
                                        <input type="number" name="distance" id="distance"
                                            class="form-control @error('distance') is-invalid @enderror"
                                            value="{{ old('distance', $rute->distance) }}" required min="1">
                                        @error('distance')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="standard_time">Waktu Standar (menit)</label>
                                        <input type="number" name="standard_time" id="standard_time"
                                            class="form-control @error('standard_time') is-invalid @enderror"
                                            value="{{ old('standard_time', $rute->standard_time) }}" required
                                            min="1">
                                        @error('standard_time')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="price_per_km">Harga per km</label>
                                        <input type="number" name="price_per_km" id="price_per_km"
                                            class="form-control @error('price_per_km') is-invalid @enderror"
                                            value="{{ old('price_per_km', $rute->price_per_km) }}" required min="1">
                                        @error('price_per_km')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-info">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
    <script src="{{ asset('library/prismjs/prism.js') }}"></script>
@endpush
