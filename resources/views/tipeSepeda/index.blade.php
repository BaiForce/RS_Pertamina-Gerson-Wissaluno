@extends('layouts.app')

@section('title', 'Tipe Sepeda')

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
            <h1>Kelola Tipe Sepeda</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Kelola</a></div>
                <div class="breadcrumb-item">Tipe Sepeda</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Tipe Sepeda</h2>
            <p class="section-lead">
               Anda dapat melihat tipe sepeda, menambah, mengedit, dan menghapus tipe sepeda
            </p>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>List Tipe Sepeda</h4>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal"
                                data-target="#addModal">
                                Tambah Tipe Sepeda +
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table-striped table" id="table-user">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Jenis Sepeda</th>
                                            <th>Pict</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tipeSepeda as $item)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td><img style="width:20%;" src="{{ asset('storage/'.$item->pict) }}"
                                                    alt=""></td>
                                            <td>
                                                {{ $item->created_at }}
                                            </td>
                                            <td>
                                                <a class="btn btn-success btn-sm"
                                                    href="{{ route('tipeSepeda.edit', ['id' => $item->id]) }}"><i
                                                        class="fa fa-pencil" aria-hidden="true"></i></a>
                                                <a onclick="event.preventDefault(); document.getElementById('form-delete-tipeSepeda{{ $item->id }}').submit();"
                                                    class="btn btn-danger btn-sm"><i class="fa fa-trash"
                                                        aria-hidden="true"></i></a>
                                                <form id="form-delete-tipeSepeda{{ $item->id }}"
                                                    action="{{ route('tipeSepeda.delete',['id' => $item->id]) }}"
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
                <h5 class="modal-title">Add Tipe Sepeda</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form id="tipesepedaForm" action="{{ route('tipeSepeda.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate="">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Jenis Sepeda</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
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
                                    <input type="file" class="form-control-file @error('pict') is-invalid @enderror" name="pict" required>
                                    @error('pict')
                                        <div class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                    <div id="pict-error" class="invalid-feedback">
                                        <strong>Gambar tidak boleh kosong</strong>
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
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div> -->
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
