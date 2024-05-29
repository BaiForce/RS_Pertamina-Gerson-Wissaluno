 @extends('layouts.user')
 @section('user-content')

 <!-- Content -->
<div class="container-fluid" style="padding-bottom: 75px !important;">
    <!-- Header Section -->
    <div class="row" style="background-color: #5e72e4; padding-top: 20px; text-align: center; color: white;">
        <h2 style="margin: 0;">Transaksi</h2>
        <p class="lead" style="margin: 0;">Daftar Transaksi selesai</p>
    </div>
     <div class="row">
         @if ($transaction->isEmpty())
         <div class="col-12 d-flex justify-content-center" style="margin-top: 300px;">
            <span class="badge badge-info mt-5 text-center" style="background-color: #5e72e4;">Belum Ada Transaksi</span>
        </div>
         @else
         @foreach ($transaction as $item_transaction)
         <div class="col-12 d-flex justify-content-center">
             <button type="button" type="button" data-bs-toggle="modal" class="btn p-0"
                 data-bs-target="#returnModal{{ $item_transaction->id }}">
                 @include('components._cardUserTransaksi', ['item' => $item_transaction])
             </button>
         </div>
         <!-- Modal -->
         <div class="modal fade" id="returnModal{{ $item_transaction->id }}" tabindex="-1"
             aria-labelledby="returnModal{{ $item_transaction->id }}Label" aria-hidden="true">
             @include('components._modalUserTransaksi', ['item' => $item_transaction])
         </div>
         @endforeach
         @endif
     </div>
 </div>
 <!-- End Content -->
 <script>
$(document).ready(function() {
    @foreach($sepeda as $js_item)
    $.uploadPreview({
        input_field: "#image-upload-{{ $js_item->id }}", // Default: .image-upload
        preview_box: "#image-preview-{{ $js_item->id }}", // Default: .image-preview
        label_field: "#image-label-{{ $js_item->id }}", // Default: .image-label
        label_default: "Choose File", // Default: Choose File
        label_selected: "Change File", // Default: Change File
        no_label: false, // Default: false
        success_callback: null // Default: null
    });
    @endforeach
});
 </script>
 @endsection
