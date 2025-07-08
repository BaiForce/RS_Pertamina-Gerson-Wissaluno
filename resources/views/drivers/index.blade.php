@extends('layouts.app')

@section('title', 'Driver')

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
                <h1>Kelola Driver</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Kelola</a></div>
                    <div class="breadcrumb-item">Driver</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Driver</h2>
                <p class="section-lead">
                    Anda dapat melihat driver, menambah, mengedit, dan menghapus driver
                </p>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4>List Driver</h4>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary btn-lg" data-toggle="modal"
                                    data-target="#addModal">
                                    Tambah Driver +
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table-striped table" id="table-driver">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Driver</th>
                                                <th>Plat Nomor</th>
                                                {{-- <th>Total Jarak</th>
                                                <th>Total Biaya</th>
                                                <th>Total Keterlambatan</th> --}}
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($drivers as $driver)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $driver->name }}</td>
                                                    <td>{{ $driver->license_plate }}</td>
                                                    {{-- <td>{{ $driver->total_distance }} km</td> --}}
                                                    {{-- <td>Rp {{ number_format($driver->total_cost, 0, ',', '.') }}</td> --}}
                                                    {{-- <td>{{ $driver->total_late }} menit</td> --}}
                                                    <td>

                                                        <a class="btn btn-success btn-sm"
                                                            href="{{ route('drivers.edit', $driver->id) }}">
                                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                                        </a>
                                                        <form action="{{ route('drivers.delete', $driver->id) }}"
                                                            method="POST" style="display: inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Apakah Anda yakin ingin menghapus driver ini?')">
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

    <!-- Add Driver Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Driver Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="driverForm" action="{{ route('drivers.store') }}" method="POST" class="needs-validation"
                        novalidate>
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama Driver</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="license_plate">Plat Nomor</label>
                            <input type="text" class="form-control @error('license_plate') is-invalid @enderror"
                                id="license_plate" name="license_plate" value="{{ old('license_plate') }}" required>
                            @error('license_plate')
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
            $('#table-driver').DataTable();

            // Form validation
            $('#driverForm').submit(function(e) {
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
