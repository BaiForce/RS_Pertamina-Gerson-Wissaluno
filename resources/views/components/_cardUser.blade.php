<div class="card m-3 border-0 shadow" style="width: 150px; height: 250px; border-radius: 10px;">
    <div class="card-body d-flex flex-column justify-content-between align-items-center">
        <div class="text-center">
            <img src="{{ asset('storage/'.$item->pict) }}" style="width:100px; height:100px; border-radius: 10px;" alt="">
        </div>
        <div class="text-center">
            <p class="card-text" style="color:#000000;">No {{ $item->number ?? '-'}}</p>
        </div>
        <div class="text-center">
            <p class="card-text" style="color:#000000;">{{ $item->jenis->name ?? '-'}}</p>
        </div>
        <div class="text-center">
            @if ($item->status == 1)
            <span class="badge bg-success" style="width: 100px; height: 30px; display: flex; align-items: center; justify-content: center;">Tersedia</span>
            @else
            <span class="badge bg-danger" style="width: 100px; height: 30px; display: flex; align-items: center; justify-content: center;">Tidak Tersedia</span>
            @endif
        </div>
    </div>
</div>
