@extends('layouts.app')

@section('title', 'Laporan')

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
            <h1>Kelola Laporan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Kelola</a></div>
                <div class="breadcrumb-item">Laporan</div>
            </div>
        </div>
        <h2 class="section-title">Lpaoran</h2>
        <p class="section-lead">
           Anda dapat melihat semua laporan, filter dan export laporan
        </p>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Filter Laporan</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('laporan.index') }}" method="GET">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="start_date">Start Date</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date"
                                            value="{{ request()->input('start_date') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="end_date">End Date</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date"
                                            value="{{ request()->input('end_date') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary mt-4">Filter</button>
                                    </div>
                                </div>
                            </form>
                            {{-- <br style="margin-bottom: 20px;"></br> --}}
                            <div style="margin-bottom: 20px;"></div>


                            <div class="row bottom-space">
                                <div class="col-md-4">
                                    <form action="{{ route('laporan.export') }}" method="POST">
                                        @csrf
                                        <button type="submit" name="format" value="excel" class="btn btn-success mr-2">Export to Excel</button>
                                        <button type="submit" name="format" value="csv" class="btn btn-primary mr-2">Export to CSV</button>
                                        <!-- <button type="submit" name="format" value="pdf" class="btn btn-danger">Export to PDF</button> -->
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Laporan Transaksi</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="">Pemasukan</label>
                                    <h5>Keseluruhan : Rp.{{ number_format($overallTotal) }}</h5>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Pemasukan</label>

                                    <h5>Bulan Ini : Rp.{{ number_format($thisMonthTotal) }}</h5>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Pemasukan</label>

                                    <h5>Hari Ini : Rp.{{ number_format($todayTotal) }}</h5>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Peminjaman</label>

                                    <h5>Keseluruhan : {{ $status1OverallCount }} Sepeda</h5>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Peminjaman</label>

                                    <h5>Bulan Ini : {{ $status1ThisMonthCount }} Sepeda</h5>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Peminjaman</label>

                                    <h5>Hari Ini : {{ $status1TodayCount }} Sepeda</h5>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Pengembalian</label>

                                    <h5>Keseluruhan : {{ $status2OverallCount }} Sepeda</h5>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Pengembalian</label>

                                    <h5>Bulan Ini : {{ $status2ThisMonthCount }} Sepeda</h5>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Pengembalian</label>

                                    <h5>Hari Ini : {{ $status2TodayCount }} Sepeda</h5>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>List Transaksi</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table-striped table" id="table-user">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                No
                                            </th>
                                            <th>Nama Pelanggan</th>
                                            <th>Nama Admin</th>
                                            <th>Nomor Sepeda</th>
                                            <th>Jenis Sepeda</th>
                                            <th>Waktu Peminjaman</th>
                                            <th>Waktu Pengembalian</th>
                                            <th>Metode Pembayaran</th>
                                            <th>Nama Petugas</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach ($transaction as $item)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $item->user->name }}</td>
                                                <td>{{ $item->admin->name }}</td>
                                                <td>{{ $item->sepeda->number }}</td>
                                                <td>{{ $item->sepeda->jenis->name }}</td>
                                                <td>{{ $item->start_time }}</td>
                                                <td>{{ $item->end_time }}</td>
                                                <td>
                                                    @if ($item->payment == 'qris')
                                                        <div class="badge badge-info">QRIS</div>
                                                    @elseif ($item->payment == 'tunai')
                                                        <div class="badge badge-success">TUNAI</div>
                                                    @endif
                                                </td>
                                                <td>{{ $item->admin->name }}</td>
                                                <td>
                                                    <a href="{{ route('transaksi.edit',['id' => $item->id]) }}"
                                                        class="btn btn-info btn-md"> <i class="fa fa-map-marker" aria-hidden="true"></i> Pantau</a>
                                                </td>
                                            </tr>
                                        @endforeach --}}

                                        @foreach ($transaction as $item)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $item->user->name ?? '-'}}</td>
                                                <td>{{ $item->admin->name ?? '-'}}</td>
                                                <td>{{ $item->sepeda->number ?? '-' }}</td>
                                                <td>{{ $item->sepeda->jenis->name ?? '-' }}</td>
                                                <td>{{ $item->start_time }}</td>
                                                <td>{{ $item->end_time }}</td>
                                                <td>
                                                    @if ($item->payment == 'qris')
                                                        <div class="badge badge-info">QRIS</div>
                                                    @elseif ($item->payment == 'tunai')
                                                        <div class="badge badge-success">TUNAI</div>
                                                    @endif
                                                </td>
                                                <td>{{ $item->admin->name }}</td>
                                                <td>
                                                    <a href="{{ route('transaksi.edit',['id' => $item->id]) }}"
                                                        class="btn btn-info btn-md"> <i class="fa fa-map-marker" aria-hidden="true"></i> Pantau</a>
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
@endpush
