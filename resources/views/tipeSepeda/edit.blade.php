@extends('layouts.app')

@section('title', 'Edit Tipe Sepeda')

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
            <h1>Edit Tipe Sepeda</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Kelola</a></div>
                <div class="breadcrumb-item">Tipe Sepeda</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Tipe Sepeda</h2>
            <p class="section-lead">
               Anda dapat mengedit data tipe sepeda
            </p>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Edit Tipe Sepeda {{ $tipeSepeda->name }}</h4>
                            <!-- Button trigger modal -->
                            <a href="{{ route('tipeSepeda.index') }}" class="btn btn-danger btn-lg">
                                < Back </a>
                        </div>
                        <div class="card-body">
                            <form id="editTipeSepedaForm" action="{{ route('tipeSepeda.update',['id' => $tipeSepeda->id]) }}" method="POST"
                                enctype="multipart/form-data" class="needs-validation" novalidate="">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Jenis Sepeda</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $tipeSepeda->name }}" required>
                                            @error('name')
                                                <div class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                            <div id="name-error" class="invalid-feedback">
                                                <strong>Jenis Sepeda tidak boleh kosong</strong>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="pict">Gambar</label>
                                            <input type="file" class="form-control-file" name="pict" id="pict"
                                                placeholder="" aria-describedby="fileHelpId">
                                            <small id="fileHelpId" class="form-text text-danger">*Lewati jika tidak
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
