@extends('layouts.app')

@section('title', 'Edit Sepeda')

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
            <h1>Edit Sepeda</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Kelola</a></div>
                <div class="breadcrumb-item">Sepeda</div>
            </div>
        </div>

        <div class="section-body">
            <!-- <h2 class="section-title">DataTables</h2>
            <p class="section-lead">
                We use 'DataTables' made by @SpryMedia. You can check the full documentation <a
                    href="https://datatables.net/">here</a>.
            </p> -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Edit Sepeda {{ $sepeda->name }}</h4>
                            <!-- Button trigger modal -->
                            <a href="{{ route('sepeda.index') }}" class="btn btn-danger btn-lg">
                                < Back </a>
                        </div>
                        <div class="card-body">
                            <form id="editSepedaForm" action="{{ route('sepeda.update',['id' => $sepeda->id]) }}" method="POST"
                                enctype="multipart/form-data" class="needs-validation" novalidate="">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="jenis_id">Jenis Sepeda</label>
                                            <select class="form-control @error('jenis_id') is-invalid @enderror" name="jenis_id" required>
                                                <option value="">Pilih Jenis ID</option>
                                                @foreach ($tipe as $item_tipe)
                                                    <option @if ($item_tipe->id == $sepeda->jenis_id) selected @endif
                                                        value="{{ $item_tipe->id }}">{{ $item_tipe->name }}</option>
                                                @endforeach
                                            </select>
                                            <div id="jenis_id-error" class="invalid-feedback">
                                                <strong>Jenis Sepeda tidak boleh kosong</strong>
                                            </div>
                                            </select>
                                        </div>
                                        {{-- <div class="form-group">
                                            <label for="gps_number">Nomor GPS</label>
                                            <input type="number" class="form-control @error('gps_number') is-invalid @enderror" name="gps_number" value="{{ $sepeda->gps_number }}" required>
                                                @error('gps_number')
                                                <div class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                                @enderror
                                                <div id="gps_number-error" class="invalid-feedback">
                                                    <strong>Nomor GPS tidak boleh kosong</strong>
                                                </div>
                                        </div> --}}
                                        <div class="form-group">
                                            <label for="number">Nomor Sepeda</label>
                                            <input type="number" class="form-control @error('number') is-invalid @enderror" name="number" value="{{ $sepeda->number }}" required>
                                                @error('number')
                                                <div class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                                @enderror
                                                <div id="number-error" class="invalid-feedback">
                                                    <strong>Nomor tidak boleh kosong</strong>
                                                </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="color">Warna Sepeda</label>
                                            <input type="text" class="form-control @error('color') is-invalid @enderror" name="color" value="{{ $sepeda->color }}" required>
                                            @error('color')
                                            <div class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                            @enderror
                                            <div id="color-error" class="invalid-feedback">
                                                <strong>Warna sepeda tidak boleh kosong</strong>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="pict">Gambar</label>
                                            <input type="file" class="form-control-file" name="pict">
                                            <small id="fileHelpId" class="form-text text-danger">Lewati jika tidak
                                                dirubah</small>
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
@endpush
