@extends('layouts.app')

@section('title', 'Edit Durasi Sewa')

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
            <h1>Edit Durasi Sewa</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/admin/home">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="/admin/durasiSewa/list">Kelola</a></div>
                <div class="breadcrumb-item">Durasi Sewa</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Durasi Sewa</h2>
            <p class="section-lead">
               Anda dapat mengedit data durasi sewa
            </p>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Edit Tipe Sepeda {{ $durasiSewa->name }}</h4>
                            <!-- Button trigger modal -->
                            <a href="{{ route('durasiSewa.index') }}" class="btn btn-danger btn-lg">
                                < Back </a>
                        </div>
                        <div class="card-body">
                            <form id="editDurasiForm" action="{{ route('durasiSewa.update',['id' => $durasiSewa->id]) }}" method="POST"
                                enctype="multipart/form-data" id="durasiSewaForm" class="needs-validation" novalidate="">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="jenis_id">Jenis ID</label>
                                            <select class="form-control @error('jenis_id') is-invalid @enderror" name="jenis_id" required>
                                                <option value="">Pilih Jenis ID</option>
                                                @foreach ($tipe as $item_tipe)
                                                    <option @if ($item_tipe->id == $durasiSewa->jenis_id) selected @endif
                                                        value="{{ $item_tipe->id }}">{{ $item_tipe->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('jenis_id')
                                                <div class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                            <div id="jenis-error" class="invalid-feedback">
                                                <strong>Jenis Sepeda tidak boleh kosong</strong>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="duration">Durasi Sewa</label>
                                            <input type="text" class="form-control @error('duration') is-invalid @enderror" name="duration" value="{{ $durasiSewa->duration }}" required>
                                            <small class="text-danger">*hitungan menit</small>
                                            @error('duration')
                                                <div class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                            <div id="durasi-error" class="invalid-feedback">
                                                <strong>Durasi tidak boleh kosong</strong>
                                            </div>
                                        </div>                                        
                                        <div class="form-group">
                                            <label for="price">Harga</label>
                                            <input type="text" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ $durasiSewa->price }}" required>
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
                                            <input type="text" class="form-control @error('charge') is-invalid @enderror" name="charge" value="{{ $durasiSewa->charge }}" required>
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

                                        <div class="form-group">
                                            <button class="btn btn-info" type="submit">Submit</button>
                                        </div>
                                    </div>
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
<!-- JS Libraies -->
<script src="{{ asset('library/prismjs/prism.js') }}"></script>




@endpush
