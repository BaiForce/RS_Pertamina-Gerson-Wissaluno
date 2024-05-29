@extends('layouts.app')

@section('title', 'Edit User')

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
            <h1>Kelola User</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Kelola</a></div>
                <div class="breadcrumb-item">User</div>
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
                            <h4>Edit User {{ $users->name }}</h4>
                            <!-- Button trigger modal -->
                            <a href="{{ route('user.index') }}" class="btn btn-danger btn-lg">
                                < Back </a>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('user.update',['id' => $users->id]) }}" method="POST" class="needs-validation" novalidate="">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Nama Pengguna</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $users->name }}" required>
                                            @error('name')
                                                <div class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                            <div id="name-error" class="invalid-feedback">
                                                <strong>Nama Pengguna tidak boleh kosong</strong>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email Pengguna</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $users->email }}" required>
                                            @error('email')
                                                <div class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                            <div id="email-error" class="invalid-feedback">
                                                <strong>Email Pengguna tidak boleh kosong</strong>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" name="password">
                                            <small class="text-danger">*lewati jika tidak dirubah</small>
                                        </div>
                                        <div class="form-group">
                                            <label for="number">Nomor Pengguna</label>
                                            <input type="number" class="form-control @error('number') is-invalid @enderror" name="number" value="{{ $users->number }}" required>
                                            @error('number')
                                                <div class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                            <div id="number-error" class="invalid-feedback">
                                                <strong>Nomor Pengguna tidak boleh kosong</strong>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="address">Alamat Pengguna</label>
                                            <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ $users->address }}" required>
                                            @error('address')
                                                <div class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                            <div id="address-error" class="invalid-feedback">
                                                <strong>Alamat Pengguna tidak boleh kosong</strong>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="role">Role</label>
                                            <select class="form-control" name="role">
                                                <option @if ($users->role == 'admin') selected @endif
                                                    value="admin">Admin</option>
                                                <option @if ($users->role == 'staff') selected @endif
                                                    value="staff">Staff</option>
                                                <option @if ($users->role == 'konsumen') selected @endif
                                                    value="konsumen">Konsumen</option>
                                            </select>
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
