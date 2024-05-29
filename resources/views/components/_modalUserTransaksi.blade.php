 @php


 use Carbon\Carbon;
 use App\Models\User;
 Carbon::setLocale('id');

 //Created At
 $timestamp = $item->created_at;

 $carbonTimestamp = Carbon::parse($timestamp);

 $date = $carbonTimestamp->format('Y-m-d');
 $time = $carbonTimestamp->format('H:i');
 $diff = $carbonTimestamp->diffForHumans();

 $timeToAdd = intval($item->duration->duration);
 $carbonTimestamp->addMinutes($timeToAdd);

 $newTime = $carbonTimestamp->format('H:i');

 //Updated At
 $timestampUpdate = $item->updated_at;

 $carbonTimestampUpdate = Carbon::parse($timestampUpdate);

 $dateUpdate = $carbonTimestampUpdate->format('Y-m-d');
 $timeUpdate = $carbonTimestampUpdate->format('H:i');
 $diffUpdate = $carbonTimestampUpdate->diffForHumans();

 $konsumens = User::findOrFail($item->user_id);
 @endphp
 @include('layouts.gambar')


 <div class="modal-dialog">
     <div class="modal-content">
         <div class="modal-header">
             <h5 class="modal-title" id="buyModal{{ $item->id }}Label">Transaksi Sepeda No
                 {{ $item->sepeda->number }}
             </h5>
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
             <div class="form-group">
                 <label for="name">Status</label>
                 <input readonly value="LUNAS" type="text" class="form-control" name="name">
             </div>

             <div class="form-group">
                 <label for="name">Nama Pelanggan</label>
                 <input readonly value="{{ $konsumens->name }}" type="text" class="form-control" name="name">
             </div>

             <div class="form-group">
                 <label for="name">Nama Petugas</label>
                 <input readonly value="{{ Auth::user()->name }}" type="text" class="form-control" name="name">
             </div>

             <div class="form-group">
                 <label for="duration_id">Durasi Sewa</label>
                 <input readonly value="{{ $item->duration->duration }} Menit" type="text" class="form-control"
                     name="duration_id">
             </div>
             <div class="form-group">
                 <label for="">Tanggal Peminjaman</label>
                 <input type="text" class="form-control" readonly value="{{ $date }}" name="start_date" id="start_date">
             </div>
             <div class="form-group">
                 <label for="">Waktu Peminjaman</label>
                 <input type="text" class="form-control" readonly value="{{ $time }}" name="start_time" id="start_time">
             </div>
             <div class="form-group">
                 <label for="">Tanggal Pengembalian</label>
                 <input type="text" class="form-control datepicker" readonly value="{{ $dateUpdate }}" name="end_date"
                     id="end_date">
             </div>
             <div class="form-group">
                 <label for="">Waktu Pengembalian</label>
                 <input type="text" class="form-control timepicker" readonly value="{{ $timeUpdate }}" name="end_time"
                     id="end_time">
             </div>
             <div class="form-group row mb-4">
                 <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Foto Jaminan</label>
                 <div class="col-sm-12 col-md-7">
                        <div class="image-preview2" id="image-preview2">
                            <img src="{{ asset('storage/'.$item->jaminan) }}" alt="" style="max-width: 180%; height: auto;">
                        </div>
                    </div>
             </div>
         </div>
         <div class="modal-footer">
             <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
         </div>
     </div>
 </div>

