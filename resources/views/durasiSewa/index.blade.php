@extends('layouts.app')

@section('title', 'Durasi Sewa')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/prismjs/themes/prism.min.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Kelola Durasi Sewa</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/admin/home">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="/admin/durasiSewa/list">Kelola</a></div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Durasi Sewa</h2>
            <p class="section-lead">
                Anda dapat melihat, menambah, mengedit, dan menghapus durasi sewa
            </p>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>List Durasi Sewa</h4>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal"
                                data-target="#addModal">
                                Tambah Durasi Sewa +
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table-striped table" id="table-user">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Jenis Sepeda</th>
                                            <th>Durasi Sewa</th>
                                            <th>Harga</th>
                                            <th>Harga Denda</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($durasiSewa as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            {{-- <td>{{ $item->jenis->name }}</td> --}}
                                            <td>{{ $item->jenis ? $item->jenis->name : '-' }}</td>
                                            <td>{{ $item->duration }} Menit</td>
                                            <td>Rp{{ number_format($item->price) }}</td>
                                            <td>Rp{{ number_format($item->charge) }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>
                                                <a class="btn btn-success btn-sm"
                                                    href="{{ route('durasiSewa.edit', ['id' => $item->id]) }}"><i
                                                        class="fa fa-pencil" aria-hidden="true"></i></a>
                                                <a onclick="event.preventDefault(); document.getElementById('form-delete-durasiSewa{{ $item->id }}').submit();"
                                                    class="btn btn-danger btn-sm"><i class="fa fa-trash"
                                                        aria-hidden="true"></i></a>
                                                <form id="form-delete-durasiSewa{{ $item->id }}"
                                                    action="{{ route('durasiSewa.delete',['id' => $item->id]) }}"
                                                    method="POST" class="d-none">
                                                    @csrf
                                                    @method('DELETE')
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

<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Durasi Sewa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form id="durasiSewaForm" action="{{ route('durasiSewa.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate="">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="jenis_id">Jenis Sepeda</label>
                                    <select class="form-control @error('jenis_id') is-invalid @enderror" name="jenis_id" required>
                                    <option value="">Pilih Jenis ID</option>
                                    @foreach ($tipe as $item_tipe)
                                        <option value="{{ $item_tipe->id }}">{{ $item_tipe->name }}</option>
                                    @endforeach
                                    </select>
                                    @error('jenis_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                     @enderror
                                    <div id="jenis_id-error" class="invalid-feedback">
                                        <strong>Jenis Sepeda tidak boleh kosong</strong>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="duration">Durasi Sewa</label>
                                    <input type="text" class="form-control @error('duration') is-invalid @enderror" name="duration" required>
                                    <small class="text-danger">*hitungan menit</small>
                                    @error('duration')
                                        <div class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                        <div id="duration-error" class="invalid-feedback">
                                            <strong>Durasi tidak boleh kosong</strong>
                                        </div>
                                </div>
                                <div class="form-group">
                                    <label for="price">Harga</label>
                                    <input type="text" class="form-control @error('price') is-invalid @enderror" name="price" required>
                                    @error('price')
                                        <div class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                        <div id="price-error" class="invalid-feedback">
                                            <strong>Harga tidak boleh kosong</strong>
                                        </div>
                                </div>
                                <div class="form-group">
                                    <label for="charge">Denda</label>
                                    <input type="text" class="form-control @error('charge') is-invalid @enderror" name="charge" required>
                                    <small class="text-danger">*hitungan denda per 1 menit</small>
                                    @error('charge')
                                        <div class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                        <div id="charge-error" class="invalid-feedback">
                                            <strong>Denda tidak boleh kosong</strong>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-info" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- JS Libraries -->
<script src="{{ asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
<script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/modules-datatables.js') }}"></script>
<!-- JS Libraies -->
<script src="{{ asset('library/prismjs/prism.js') }}"></script>
@endpush
