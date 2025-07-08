@extends('layouts.app')

@section('title', 'Transaksi')

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
                <h1>Kelola Transaksi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Kelola</a></div>
                    <div class="breadcrumb-item">Transaksi</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Transaksi</h2>
                <p class="section-lead">
                    Anda dapat melihat transaksi, menambah, mengedit, dan menghapus transaksi
                </p>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4>List Transaksi</h4>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary btn-lg" data-toggle="modal"
                                    data-target="#addModal">
                                    Tambah Transaksi +
                                </button>
                            </div>
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table class="table-striped table" id="table-transaction">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Driver</th>
                                                <th>Rute</th>
                                                <th>Tanggal</th>
                                                <th>Jarak</th>
                                                <th>Waktu Aktual (menit)</th>
                                                <th>Waktu Standar (menit)</th>
                                                <th>Total Biaya</th>
                                                <th>Total Keterlambatan</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($transactions as $transaction)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $transaction->driver->name }}</td>
                                                    <td>{{ $transaction->rute->start_point }} -->
                                                        {{ $transaction->rute->end_point }}</td>
                                                    <td>{{ $transaction->date }}</td>
                                                    <td>{{ $transaction->rute->distance }}</td>
                                                    <td>{{ $transaction->actual_time }}</td>
                                                    <td>{{ $transaction->standard_time }}</td>
                                                    <td>Rp {{ number_format($transaction->total_cost, 0, ',', '.') }}</td>
                                                    <td>{{ $transaction->late }}</td>
                                                    <td>
                                                        <a class="btn btn-success btn-sm"
                                                            href="{{ route('transactions.edit', $transaction->id) }}">
                                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                                        </a>
                                                        <form action="{{ route('transactions.delete', $transaction->id) }}"
                                                            method="POST" style="display: inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
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

    <!-- Add Transaction Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Transaksi Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="transactionForm" action="{{ route('transactions.store') }}" method="POST"
                        class="needs-validation" novalidate>
                        @csrf
                        <div class="form-group">
                            <label for="driver_id">Driver</label>
                            <select class="form-control @error('driver_id') is-invalid @enderror" name="driver_id"
                                id="driver_id" required>
                                <option value="">Pilih Driver</option>
                                @foreach ($drivers as $driver)
                                    <option value="{{ $driver->id }}"
                                        {{ old('driver_id') == $driver->id ? 'selected' : '' }}>
                                        {{ $driver->name }} - {{ $driver->license_plate }}
                                    </option>
                                @endforeach
                            </select>
                            @error('driver_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="rute_id">Rute</label>
                            <select class="form-control @error('rute_id') is-invalid @enderror" name="rute_id"
                                id="rute_id" required>
                                <option value="">Pilih Rute</option>
                                @foreach ($rutes as $rute)
                                    <option value="{{ $rute->id }}"
                                        {{ old('rute_id') == $rute->id ? 'selected' : '' }}>
                                        {{ $rute->start_point }} - {{ $rute->end_point }}
                                    </option>
                                @endforeach
                            </select>
                            @error('rute_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="date">Tanggal</label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror" id="date"
                                name="date" value="{{ old('date') }}" required>
                            @error('date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="actual_time">Waktu Aktual (menit)</label>
                            <input type="number" class="form-control @error('actual_time') is-invalid @enderror"
                                id="actual_time" name="actual_time" value="{{ old('actual_time') }}" required
                                min="1">
                            @error('actual_time')
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
            $('#table-transaction').DataTable();

            // Form validation
            $('#transactionForm').submit(function(e) {
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
