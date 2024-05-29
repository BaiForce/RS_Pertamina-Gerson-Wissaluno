 @php

     use Carbon\Carbon;
     use App\Models\User;
     Carbon::setLocale('id');

     $timestamp = $item->start_time;

     $carbonTimestamp = Carbon::parse($timestamp);

     $date = $carbonTimestamp->format('Y-m-d');
     $time = $carbonTimestamp->format('H:i');
     $diff = $carbonTimestamp->diffForHumans();

     $timeToAdd = intval($item->duration->duration);
     $carbonTimestamp->addMinutes($timeToAdd);

     $newDate = $carbonTimestamp->format('Y-m-d');
     $newTime = $carbonTimestamp->format('H:i');

     $konsumens = User::findOrFail($item->user_id);

     $dateNow = Carbon::now()->format('Y-m-d');
     $timeNow = Carbon::now()->format('h:i A');
    //  dd($timeNow);

     // menghitung permenit
     $start_time = Carbon::parse($item->start_date . ' ' . $item->start_time);
     $start_time->addMinutes($timeToAdd);
     $end_time = Carbon::now();
     $durationInMinutes = $start_time->diffInMinutes($end_time);

     // menghitung total denda permenit
     $hitung = $item->duration->charge * $durationInMinutes;
     $kelipatan = 1000;
     $hasil_bulat = floor($hitung / $kelipatan) * $kelipatan;
     if ($hasil_bulat < 0) {
         $totalDenda = 0;
     } else {
         $totalDenda = number_format($hasil_bulat, 0);
     }
 @endphp
 <div class="modal-dialog">
     <div class="modal-content">
         <div class="modal-header">
             <h5 class="modal-title" id="buyModal{{ $item->id }}Label">Pengembalian Sepeda No
                 {{ $item->sepeda->number }}
             </h5>
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
             <form method="POST" id="bookingForm{{ $item->id }}" enctype="multipart/form-data">
                 @csrf
                 <input type="hidden" name="trans_id" value="{{ $item->id }}">
                 <input type="hidden" name="user_id" value="{{ $konsumens->id }}">
                 <input type="hidden" name="admin_id" value="{{ Auth::user()->id }}">
                 <input type="hidden" name="bike_id" value="{{ $item->sepeda->id }}">
                 <input type="hidden" name="latitude" id="latitude{{ $item->id }}" value="">
                 <input type="hidden" name="longitude" id="longitude{{ $item->id }}" value="">
                 <input type="hidden" id="routeName" value="{{ route('staff.pay.return') }}">

                 <div class="form-group">
                     <label for="name">Nama Pelanggan</label>
                     <input readonly value="{{ $konsumens->name }}" type="text" class="form-control" name="name">
                 </div>

                 <div class="form-group">
                     <label for="name">Nama Petugas</label>
                     <input readonly value="{{ Auth::user()->name }}" type="text" class="form-control"
                         name="name">
                 </div>

                 <div class="form-group">
                     <label for="duration_id">Durasi Sewa</label>
                     <input readonly value="{{ $item->duration->duration }} Menit" type="text" class="form-control"
                         name="duration_id">
                 </div>
                 <div class="form-group">
                     <label for="">Tanggal Peminjaman</label>
                     <input type="text" class="form-control" readonly value="{{ $date }}" name="start_date"
                         id="start_date">
                 </div>
                 <div class="form-group">
                     <label for="">Waktu Peminjaman</label>
                     <input type="text" class="form-control" readonly value="{{ $timeNow }}" name="start_time"
                         id="start_time">
                 </div>
                 <div class="form-group row mb-4">
                     <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Foto Jaminan</label>
                     <div class="col-sm-12 col-md-7">
                         <div id="image-preview" class="image-preview">
                             <img src="{{ asset('storage/' . $item->jaminan) }}" alt="">
                         </div>
                     </div>
                 </div>
                 <div class="form-group">
                     <label for="">Tanggal Pengembalian</label>
                     <input type="text" class="form-control datepicker" name="end_date"
                         id="end_date{{ $item->id }}" value="{{ $dateNow }}">
                 </div>
                 <div class="form-group">
                     <label for="">Waktu Pengembalian</label>
                     <input type="text" class="form-control timepicker" name="end_time"
                         id="end_time{{ $item->id }}" value="{{ $timeNow }}">
                 </div>
                 {{-- JIKA PENGEMBALIAN LEBIH DARI WAKTU YANG DI TENTUKAN MAKA AKAN MUNCUL DENDA --}}
                 <div class="form-group">
                     <label>Harga Denda</label>
                     <input type="text" class="form-control" id="harga{{ $item->id }}" readonly
                         value="{{ $totalDenda }}" name="ha">
                 </div>

                 <div class="form-group denda{{ $item->id }} {{ $totalDenda == 0 ? 'd-none' : '' }}">
                     <label for="payment{{ $item->id }}">Metode Pembayaran Denda</label>
                     <select class="form-control" name="payment" id="payment{{ $item->id }}"
                         {{ $totalDenda == 0 ? '' : 'required' }}>
                         <option value="">Pilih</option>
                         <option value="qris">QRIS</option>
                         <option value="tunai">Tunai</option>
                     </select>
                 </div>

                 <div class="form-group d-none" id="price{{ $item->id }}">
                     <label for="total_price{{ $item->id }}">Total Tunai</label>
                     <input type="number" class="form-control" name="total_price"
                         id="total_price{{ $item->id }}">
                 </div>

                 <div class="form-group d-flex justify-content-center">
                     <button class="btn btn-sm btn-info text-white" id="submitBtn">Proses Pengembalian</button>
                 </div>
             </form>
         </div>
     </div>
 </div>
 <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
 </script>
 <script>
     document.addEventListener('DOMContentLoaded', function() {
         var form = document.getElementById('bookingForm{{ $item->id }}');
         var routeName = document.getElementById('routeName').value;

         form.addEventListener('submit', function(e) {
             e.preventDefault(); // Prevent the default form submission

             // Serialize form data
             var formData = new FormData(form);

             // Submit form asynchronously using Fetch API
             var paymentMethod = form.querySelector('select[name="payment"]').value;
             var harga = form.querySelector('input[name="ha"]').value;
             if (paymentMethod === 'tunai' && harga !== '0') {
                 fetch(routeName, {
                         method: 'POST',
                         body: formData
                     })
                     .then(function(response) {
                         if (!response.ok) {
                             throw new Error('Network response was not ok');
                         }
                         // Handle the response
                         return response.json(); // Parse response JSON
                     })
                     .then(function(data) {
                         console.log(data);
                         Swal.close();
                         if (data.success == true) {
                             Swal.fire({
                                 icon: 'success',
                                 title: 'Success!',
                                 text: 'Pengembalian Berhasil !',
                             }).then(function() {
                                 window.location.reload();
                             });
                         } else {
                             Swal.fire({
                                 icon: 'error',
                                 title: 'Gagal!',
                                 text: data.message,
                             })
                         }
                     })
                     .catch(function(error) {
                         console.error('Fetch error:', error);
                     });
             } else if (paymentMethod === 'qris' && harga !== '0') {
                 fetch(routeName, {
                         method: 'POST',
                         body: formData
                     })
                     .then(function(response) {
                         if (!response.ok) {
                             throw new Error('Network response was not ok');
                         }
                         // Handle the response
                         return response.json(); // Parse response JSON
                     })
                     .then(function(data) {
                         Swal.close();
                         snap.pay(data.data, {
                             // Optional callbacks
                             onSuccess: function(result) {
                                 // Handle error response
                                 Swal.fire({
                                     icon: 'success',
                                     title: 'Success!',
                                     text: 'Pengembalian dan Pembayaran denda Berhasil !',
                                 }).then(function() {
                                     window.location.href =
                                         "{{ route('staff.borrow') }}";
                                 });
                                 console.log(result);
                             },
                             onPending: function(result) {
                                 console.log(result);
                             },
                             onError: function(result) {
                                 console.log(result);
                             }
                         });
                     })
                     .catch(function(error) {
                         console.error('Fetch error:', error);
                     });
             } else {
                 fetch(routeName, {
                         method: 'POST',
                         body: formData
                     })
                     .then(function(response) {
                         if (!response.ok) {
                             throw new Error('Network response was not ok');
                         }
                         // Handle the response
                         return response.json(); // Parse response JSON
                     })
                     .then(function(data) {
                         Swal.close();
                         if (data.success === true) {
                             Swal.fire({
                                 icon: 'success',
                                 title: 'Success!',
                                 text: 'Pengembalian Berhasil !',
                             }).then(function() {
                                 window.location.reload();
                             });
                         } else {
                             Swal.fire({
                                 icon: 'error',
                                 title: 'Oops...',
                                 text: 'Pengembalian Gagal!',
                             });
                         }
                     }).catch(error => {
                         console.error('Fetch error:', error);
                     });;
             }
         });
     });
 </script>
