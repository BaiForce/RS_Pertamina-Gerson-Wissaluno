@extends('layouts.app')

@section('title', 'Rute')

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
                <h1>Kelola Rute</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Kelola</a></div>
                    <div class="breadcrumb-item">Rute</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Rute</h2>
                <p class="section-lead">
                    Anda dapat melihat rute, menambah, mengedit, dan menghapus rute
                </p>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4>List Rute</h4>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary btn-lg" data-toggle="modal"
                                    data-target="#addModal">
                                    Tambah Rute +
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table-striped table" id="table-rute">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Titik Awal</th>
                                                <th>Titik Akhir</th>
                                                <th>Jarak (km)</th>
                                                <th>Waktu Standar (menit)</th>
                                                <th>Harga per km</th>
                                                <th>Total Biaya</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($rutes as $route)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $route->start_point }}</td>
                                                    <td>{{ $route->end_point }}</td>
                                                    <td>{{ $route->distance }}</td>
                                                    <td>{{ $route->standard_time }}</td>
                                                    <td>Rp {{ number_format($route->price_per_km, 0, ',', '.') }}</td>
                                                    <td>{{ $route->total_cost }}</td>
                                                    <td>
                                                        <a class="btn btn-success btn-sm"
                                                            href="{{ route('rutes.edit', $route->id) }}">
                                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                                        </a>
                                                        <form action="{{ route('rutes.delete', $route->id) }}"
                                                            method="POST" style="display: inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Apakah Anda yakin ingin menghapus rute ini?')">
                                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Add Route Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Rute Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="ruteForm" action="{{ route('rutes.store') }}" method="POST" class="needs-validation"
                        novalidate>
                        @csrf
                        <div class="form-group">
                            <label for="start_point">Titik Awal</label>
                            <input type="text" class="form-control @error('start_point') is-invalid @enderror"
                                id="start_point" name="start_point" value="{{ old('start_point') }}" required
                                maxlength="50">
                            @error('start_point')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="end_point">Titik Akhir</label>
                            <input type="text" class="form-control @error('end_point') is-invalid @enderror"
                                id="end_point" name="end_point" value="{{ old('end_point') }}" required maxlength="50">
                            @error('end_point')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="distance">Jarak (km)</label>
                            <input type="number" class="form-control @error('distance') is-invalid @enderror"
                                id="distance" name="distance" value="{{ old('distance') }}" required min="1">
                            @error('distance')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="standard_time">Waktu Standar (menit)</label>
                            <input type="number" class="form-control @error('standard_time') is-invalid @enderror"
                                id="standard_time" name="standard_time" value="{{ old('standard_time') }}" required
                                min="1">
                            @error('standard_time')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="price_per_km">Harga per km</label>
                            <input type="number" class="form-control @error('price_per_km') is-invalid @enderror"
                                id="price_per_km" name="price_per_km" value="{{ old('price_per_km') }}" required
                                min="1">
                            @error('price_per_km')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
    <!-- JS Libraies -->
    <script src="{{ asset('library/prismjs/prism.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#table-rute').DataTable();

            // Form validation
            $('#ruteForm').submit(function(e) {
                let valid = true;
                $('.form-control').each(function() {
                    if ($(this).val() === '') {
                        $(this).addClass('is-invalid');
                        valid = false;
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });

                if (!valid) {
                    e.preventDefault();
                    return false;
                }
            });
        });
    </script>
@endpush
