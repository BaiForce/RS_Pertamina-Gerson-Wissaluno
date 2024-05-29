@php

use Carbon\Carbon;
Carbon::setLocale('id');

$timestamp = $item->created_at;

$carbonTimestamp = Carbon::parse($timestamp);

$date = $carbonTimestamp->format('Y-m-d');
$time = $carbonTimestamp->format('H:i');
$diff = $carbonTimestamp->diffForHumans();

$timeToAdd = intval($item->duration->duration);
$carbonTimestamp->addMinutes($timeToAdd);

$newTime = $carbonTimestamp->format('H:i');
@endphp
<div class="card m-3 border-0 shadow" style="width: 93vw; max-width: 400px; border-radius: 10px;">
    <div class="row g-0" style="border-radius: 10px;">
        <div class="col-4 d-flex align-items-center justify-content-center" style="padding-left: 25px;">
            <img style="width: 120px; height: 105px; border-radius: 10px;" src="{{ asset('storage/'.$item->sepeda->pict) }}" class="img-fluid rounded-start">
        </div>
        <div class="col-8">
            <div class="card-body">
                <h5 class="card-title text-start text-black">{{ $item->sepeda->jenis->name }}
                    {{ $item->sepeda->number }}</h5>
                <p class="card-text text-start">
                    <span class="badge bg-info text-start">Harga: {{ $item->total_price }}</span><br>
                    <span class="badge bg-info text-start">Peminjaman {{ $date }}</span><br>
                    <span class="badge bg-warning text-start">Pengembalian Seharusnya {{ $newTime }}</span>
                </p>
                <p class="p-0 card-text text-start"></p>
                <p class="card-text text-start"></p>
                <p class="card-text text-start"></p>
            </div>
        </div>
    </div>
</div>
