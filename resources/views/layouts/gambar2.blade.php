<style>
.image-preview2-{{ $item->id }} {
    width: 200px; /* Lebar bingkai */
    height: 200px; /* Tinggi bingkai */
    border: 1px dashed black; /* Gaya garis putus-putus */
    display: flex; /* Mengatur elemen secara horizontal */
    align-items: center; /* Pusatkan vertikal */
    justify-content: center; /* Pusatkan horizontal */
    position: relative; /* Diperlukan untuk menempatkan label pada posisi yang tepat */
    overflow: hidden; /* Menghindari gambar keluar dari bingkai */
}

.image-input {
    display: none; /* Sembunyikan input file asli */
}

.image-label {
    position: absolute; /* Letakkan label di atas bingkai */
    z-index: 1; /* Pastikan label muncul di atas garis putus-putus */
    cursor: pointer; /* Ubah kursor saat di atas label */
}

.image-preview2-{{ $item->id }} img {
    width: 100%; /* Membuat gambar mengisi lebar bingkai */
    height: 100%; /* Memastikan gambar mengisi tinggi bingkai */
    object-fit: cover; /* Gambar diatur untuk mengisi ruang yang tersedia tanpa memengaruhi proporsinya */
}
</style>