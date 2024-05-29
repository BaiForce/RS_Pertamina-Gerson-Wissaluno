@extends('layouts.user')

@section('user-content')

<!-- Halaman Peminjaman -->
<div class="container-fluid" style="padding-bottom: 75px !important;">
    <!-- Header Section -->
    <div class="row" style="background-color: #5e72e4; padding-top: 20px; text-align: center; color: white;">
        <h2 style="margin: 0;">PEMINJAMAN</h2>
        <p class="lead" style="margin: 0;">Daftar Peminjaman yang sedang aktif.</p>
    </div>
    <!-- Transaction Section -->
    <div class="row">
        @if ($transaction->isEmpty())
        <div class="col-12 d-flex justify-content-center" style="margin-top: 300px;">
            <span class="badge badge-info mt-5 text-center" style="background-color: #5e72e4;">Belum Ada Transaksi</span>
        </div>

        @else
            @foreach ($transaction as $item_transaction)
                <div class="col-12 d-flex justify-content-center">
                    <button type="button" data-bs-toggle="modal" class="btn p-0" data-bs-target="#returnModal{{ $item_transaction->id }}">
                        @include('components._cardUserPeminjaman', ['item' => $item_transaction])
                    </button>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="returnModal{{ $item_transaction->id }}" tabindex="-1" aria-labelledby="returnModal{{ $item_transaction->id }}Label" aria-hidden="true">
                    @include('components._modalUserPeminjaman', ['item' => $item_transaction])
                </div>
            @endforeach
        @endif
    </div>
</div>
<!-- End Content -->

<!-- jQuery -->
<script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        @foreach ($sepeda as $js_item)
            $.uploadPreview({
                input_field: "#image-upload-{{ $js_item->id }}",
                preview_box: "#image-preview-{{ $js_item->id }}",
                label_field: "#image-label-{{ $js_item->id }}",
                label_default: "Choose File",
                label_selected: "Change File",
                no_label: false,
                success_callback: null
            });
        @endforeach

        @foreach ($transaction as $item)
            var date = $('#end_date{{ $item->id }}').val();
            var time = $('#end_time{{ $item->id }}').val();
            $('#payment{{ $item->id }}').on('change', function() {
                var method = $(this).val();
                if (method === "tunai") {
                    $('#price{{ $item->id }}').removeClass('d-none');
                } else {
                    $('#price{{ $item->id }}').addClass('d-none');
                }
            });

            $('#end_date{{ $item->id }}').on('change', function() {
                var date = $(this).val();
                $.ajax({
                    type: "post",
                    url: "{{ route('showDenda') }}",
                    data: {
                        date: date,
                        time: time,
                        id: '{{ $item->id }}'
                    },
                    success: function(response) {
                        if (response.status == true) {
                            $('#harga{{ $item->id }}').val(response.data);
                            $('#payment{{ $item->id }}').attr('required', true);
                            $('.denda{{ $item->id }}').removeClass('d-none');
                        } else {
                            $('#harga{{ $item->id }}').val(0);
                            $('#payment{{ $item->id }}').removeAttr('required');
                            $('.denda{{ $item->id }}').addClass('d-none');
                            $('#price{{ $item->id }}').addClass('d-none');
                        }
                    },
                    error: function(error) {
                        //  console.log(error);
                    }
                });
            });

            $('#end_time{{ $item->id }}').on('change', function() {
                var time = $(this).val();
                $.ajax({
                    type: "post",
                    url: "{{ route('showDenda') }}",
                    data: {
                        date: date,
                        time: time,
                        id: '{{ $item->id }}'
                    },
                    success: function(response) {
                        if (response.status == true) {
                            $('#harga{{ $item->id }}').val(response.data);
                            $('#payment{{ $item->id }}').attr('required', true);
                            $('.denda{{ $item->id }}').removeClass('d-none');
                        } else {
                            $('#harga{{ $item->id }}').val(0);
                            $('#payment{{ $item->id }}').removeAttr('required');
                            $('.denda{{ $item->id }}').addClass('d-none');
                            $('#price{{ $item->id }}').addClass('d-none');
                        }
                    },
                    error: function(error) {
                        //  console.log(error);
                    }
                });
            });
        @endforeach
    });
</script>
@endsection
