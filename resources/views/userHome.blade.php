 @extends('layouts.user')
 @section('user-content')

 <!-- Halaman Home -->
 <div class="container-fluid mb-5 pb-5">
    <div class="row" style="background-color: #5e72e4 !important; padding-top: 35px;">
     <h2 class="text-center text-light fw-bold">SAHABAT E-BIKE</h2>
   </div>
   <form action="{{ route('staff.dashboard') }}" method="GET">
     @csrf
     <div class="row mt-2">
       <div class="col-9">
         <div class="form-group">
           <input type="text" class="form-control" name="query" placeholder="Cari Jenis Sepeda ....">
         </div>
       </div>
       <div class="col-2">
         <button type="submit" class="btn btn-primary">Search</button>
       </div>
     </div>
   </form>

   <div class="row">
     @foreach ($sepeda as $item)
     <div class="col-6 d-flex justify-content-center">
       <button type="button" type="button" data-bs-toggle="modal" class="btn p-0"
         data-bs-target="#buyModal{{ $item->id }}">
         @include('components._cardUser', ['item' => $item])
       </button>
     </div>
     <!-- Modal -->
     @if ($item->status == 1)
    <div class="modal fade" id="buyModal{{ $item->id }}" tabindex="-1" aria-labelledby="buyModal{{ $item->id }}Label"
      aria-hidden="true">
      @include('components._modalUser', ['item' => $item,'duration' => $item->durasi])
    </div>
     @elseif ($item->status == 2)
    <div class="modal fade" id="buyModal{{ $item->id }}" tabindex="-1" aria-labelledby="buyModal{{ $item->id }}Label"
      aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header justify-content-between">
            <h5 class="modal-title" id="buyModal{{ $item->id }}Label">Sepeda No
                {{ $item->number }} Tidak Tersedia</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Sepeda yang Anda pilih tidak tersedia saat ini. Mohon pilih sepeda lain atau coba lagi nanti.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>
    @endif
     @endforeach
   </div>
 </div>

 <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
<script>
$(document).ready(function() {
  @foreach($sepeda as $js_item)
  $('#payment{{ $js_item->id }}').on('change', function() {
        var paymentMethod = $(this).val();
        if (paymentMethod === "tunai") {
            $('#price{{ $js_item->id }}').removeClass('d-none');
        } else {
            $('#price{{ $js_item->id }}').addClass('d-none');
        }
    });

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

@if (session('error'))
<script>
    Swal.fire({
        title: "Gagal",
        text: "{{ session('error') }}",
        icon: "error",
        confirmButtonText: "Ya"
    });
</script>
@endif

 @endsection
