@extends('layouts.app')

@section('title', 'Edit Transaksi')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Transaksi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Kelola</a></div>
                    <div class="breadcrumb-item">Transaksi</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Edit Transaksi</h2>
                <p class="section-lead">
                    Anda dapat mengubah informasi transaksi.
                </p>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4>Edit Transaksi ID: {{ $transaction->id }}</h4>
                                <a href="{{ route('transactions.index') }}" class="btn btn-danger btn-lg">&lt; Back</a>
                            </div>
                            <div class="card-body">
                                @if (session('error'))
                                    <div class="alert alert-danger flash-message">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                <form action="{{ route('transactions.update', $transaction->id) }}" method="POST"
                                    class="needs-validation" novalidate>
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group">
                                        <label for="driver_id">Driver</label>
                                        <select class="form-control @error('driver_id') is-invalid @enderror"
                                            name="driver_id" id="driver_id" required>
                                            <option value="">Pilih Driver</option>
                                            @foreach ($driver as $d)
                                                <option value="{{ $d->id }}"
                                                    {{ $transaction->driver_id == $d->id ? 'selected' : '' }}>
                                                    {{ $d->name }} - {{ $d->license_plate }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('driver_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="rute_id">Rute</label>
                                        <select class="form-control @error('rute_id') is-invalid @enderror" name="rute_id"
                                            id="rute_id" required>
                                            <option value="">Pilih Rute</option>
                                            @foreach ($rutes as $rute)
                                                <option value="{{ $rute->id }}"
                                                    {{ $transaction->rute_id == $rute->id ? 'selected' : '' }}>
                                                    {{ $rute->start_point }} - {{ $rute->end_point }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('rute_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="date">Tanggal</label>
                                        <input type="date" class="form-control @error('date') is-invalid @enderror"
                                            name="date" id="date"
                                            value="{{ old('date', \Carbon\Carbon::parse($transaction->date)->format('Y-m-d')) }}"
                                            required>
                                        @error('date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="actual_time">Waktu Aktual (menit)</label>
                                        <input type="number" name="actual_time" id="actual_time" min="1"
                                            class="form-control @error('actual_time') is-invalid @enderror"
                                            value="{{ old('actual_time', $transaction->actual_time) }}" required>
                                        @error('actual_time')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- <div class="form-group">
                                    <label for="standard_time">Waktu Standar (menit)</label>
                                    <input type="number" name="standard_time" id="standard_time" min="1"
                                        class="form-control @error('standard_time') is-invalid @enderror"
                                        value="{{ old('standard_time', $transaction->standard_time) }}" required>
                                    @error('standard_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="total_cost">Total Biaya</label>
                                    <input type="number" name="total_cost" id="total_cost" min="1"
                                        class="form-control @error('total_cost') is-invalid @enderror"
                                        value="{{ old('total_cost', $transaction->total_cost) }}" required>
                                    @error('total_cost')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div> --}}

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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

@push('style')
    <style>
        .flash-message {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            width: auto;
            max-width: 400px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        setTimeout(() => {
            document.querySelectorAll('.flash-message').forEach(el => el.remove());
        }, 5000);
    </script>
@endpush
