@extends('layouts.app')

@section('title', 'Daftar Pesanan')

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
                   Anda dapat melihat semua tranksaksi penyewaan sepeda
                </p>
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
                                            <th>No</th>
                                            <th>Nama Pelanggan</th>
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
                                            <td>{{ $item->user->name ?? '-' }}</td>
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
                                            <td>{{ $item->admin->name ?? '-' }}</td>
                                            <td>
                                                <a href="{{ route('transaksi.edit',['id' => $item->id]) }}" class="btn btn-info btn-md">
                                                    <i class="fa fa-map-marker" aria-hidden="true"></i> Pantau
                                                </a>
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
