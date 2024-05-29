<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAHABAT E-BIKE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <!-- Include SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <!-- Include SweetAlert JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- buat warna navbar warna biru -->
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
    <!--
</head>

<body>

    <!-- Bottom Navbar -->
    <nav class="navbar navbar-light bg-white border navbar-expand fixed-bottom">
        <ul class="navbar-nav nav-justified w-100">

            <li class="nav-item"><a class="nav-link position-relative {{ Request::is('staff/home') ? 'active' : '' }}"
                    href="{{ route('staff.dashboard') }}">
                    <div class="nav-icon"><svg xmlns="http://www.w3.org/2000/svg" width="2rem" fill="currentColor"
                            class="bi bi-house fs-3" viewBox="0 0 16 16">
                            <path
                                d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z" />
                        </svg></div>Home
                </a></li>
            <li class="nav-item"><a class="nav-link position-relative {{ Request::is('staff/borrow') ? 'active' : '' }}"
                    href="{{ route('staff.borrow') }}">
                    <div class="nav-icon"><svg xmlns="http://www.w3.org/2000/svg" width="2rem" fill="currentColor"
                            class="bi bi-bicycle fs-3" viewBox="0 0 16 16">
                            <path
                                d="M4 4.5a.5.5 0 0 1 .5-.5H6a.5.5 0 0 1 0 1v.5h4.14l.386-1.158A.5.5 0 0 1 11 4h1a.5.5 0 0 1 0 1h-.64l-.311.935.807 1.29a3 3 0 1 1-.848.53l-.508-.812-2.076 3.322A.5.5 0 0 1 8 10.5H5.959a3 3 0 1 1-1.815-3.274L5 5.856V5h-.5a.5.5 0 0 1-.5-.5m1.5 2.443-.508.814c.5.444.85 1.054.967 1.743h1.139zM8 9.057 9.598 6.5H6.402zM4.937 9.5a2 2 0 0 0-.487-.877l-.548.877zM3.603 8.092A2 2 0 1 0 4.937 10.5H3a.5.5 0 0 1-.424-.765zm7.947.53a2 2 0 1 0 .848-.53l1.026 1.643a.5.5 0 1 1-.848.53z" />
                        </svg></div>Peminjaman
                </a></li>
            <li class="nav-item"><a
                    class="nav-link position-relative {{ Request::is('staff/transaction') ? 'active' : '' }}"
                    href="{{ route('staff.transaction') }}">
                    <div class="nav-icon"><svg xmlns="http://www.w3.org/2000/svg" width="2rem" fill="currentColor"
                            class="bi bi-stack fs-3" viewBox="0 0 16 16">
                            <path
                                d="m14.12 10.163 1.715.858c.22.11.22.424 0 .534L8.267 15.34a.6.6 0 0 1-.534 0L.165 11.555a.299.299 0 0 1 0-.534l1.716-.858 5.317 2.659c.505.252 1.1.252 1.604 0l5.317-2.66zM7.733.063a.6.6 0 0 1 .534 0l7.568 3.784a.3.3 0 0 1 0 .535L8.267 8.165a.6.6 0 0 1-.534 0L.165 4.382a.299.299 0 0 1 0-.535z" />
                            <path
                                d="m14.12 6.576 1.715.858c.22.11.22.424 0 .534l-7.568 3.784a.6.6 0 0 1-.534 0L.165 7.968a.299.299 0 0 1 0-.534l1.716-.858 5.317 2.659c.505.252 1.1.252 1.604 0z" />
                        </svg></div>Transaksi
                </a></li>
            <li class="nav-item"><a
                    class="nav-link position-relative {{ Request::is('staff/profile') ? 'active' : '' }}"
                    href="{{ route('staff.profile') }}">
                    <div class="nav-icon"><svg xmlns="http://www.w3.org/2000/svg" width="2rem" fill="currentColor"
                            class="bi bi-person-fill" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                        </svg></div>Setting
                </a></li>
        </ul>
    </nav>
    <!-- End Bottom Navbar -->

    @yield('user-content')




    <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('library/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script src="{{ asset('library/moment/min/moment.min.js') }}"></script>

    <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('library/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('library/upload-preview/upload-preview.js') }}"></script>
    <script>
        // Timepicker
        if (jQuery().timepicker && $(".timepicker").length) {
            $(".timepicker").timepicker({
                icons: {
                    up: 'fas fa-chevron-up',
                    down: 'fas fa-chevron-down'
                }
            });
        }
        // Daterangepicker
        if (jQuery().daterangepicker) {
            if ($(".datepicker").length) {
                $('.datepicker').daterangepicker({
                    locale: {
                        format: 'YYYY-MM-DD'
                    },
                    singleDatePicker: true,
                });
            }
            if ($(".datetimepicker").length) {
                $('.datetimepicker').daterangepicker({
                    locale: {
                        format: 'YYYY-MM-DD hh:mm'
                    },
                    singleDatePicker: true,
                    timePicker: true,
                    timePicker24Hour: true,
                });
            }
            if ($(".daterange").length) {
                $('.daterange').daterangepicker({
                    locale: {
                        format: 'YYYY-MM-DD'
                    },
                    drops: 'down',
                    opens: 'right'
                });
            }
        }
    </script>

</body>

</html>
