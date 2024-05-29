@extends('layouts.user')
@section('user-content')

<!-- Header -->
<div class="container-fluid mb-5 pb-5">
    <div class="row" style="background-color: #5e72e4 !important; padding-top: 35px;">
        <h2 class="text-center text-light fw-bold" >Profile</h2>
    </div>
</div>

<!-- End Header -->

<!-- Content -->
<div class="container-fluid">
    <div class="row mt-4">
        <div class="col-12 d-flex justify-content-center">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
            <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="btn btn-danger has-icon">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </div>
    </div>
</div>
<!-- End Content -->

<!-- Informasi Pengguna untuk Perangkat Mobile -->
<div class="d-sm-block d-lg-none">
    <div class="container">
        <div class="row">
            <div class="col">
                <!-- Card untuk Nama -->
                <div class="card m-3 border-0 shadow" style="border-radius: 10px;">
                    <div class="card-body text-right">
                        <h6 class="card-title" style="color:#000000;"><i class="bi bi-person"></i> Nama</h6>
                        <p class="card-text" style="color:#000000;">{{ Auth::user()->name }}</p>
                    </div>
                </div>

                <!-- Card untuk Email -->
                <div class="card m-3 border-0 shadow" style="border-radius: 10px;">
                    <div class="card-body text-right">
                        <h6 class="card-title" style="color:#000000;"><i class="bi bi-envelope"></i> Email</h6>
                        <p class="card-text" style="color:#000000;">{{ Auth::user()->email }}</p>
                    </div>
                </div>

                <!-- Card untuk Nomor -->
                <div class="card m-3 border-0 shadow" style="border-radius: 10px;">
                    <div class="card-body text-right">
                        <h6 class="card-title" style="color:#000000;"><i class="bi bi-telephone"></i> Nomor</h6>
                        <p class="card-text" style="color:#000000;">{{ Auth::user()->number }}</p>
                    </div>
                </div>

                <!-- Card untuk Alamat -->
                <div class="card m-3 border-0 shadow" style="border-radius: 10px;">
                    <div class="card-body text-right">
                        <h6 class="card-title" style="color:#000000;"><i class="bi bi-house-door"></i> Alamat</h6>
                        <p class="card-text" style="color:#000000;">{{ Auth::user()->address }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
