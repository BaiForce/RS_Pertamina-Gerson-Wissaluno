<style>
    #map {
        height: 500px;
        width: 100%;
    }

    #response {
        margin-top: 20px;
        border: 1px solid #ccc;
        padding: 10px;
        border-radius: 5px;
    }

    /* Gaya untuk nomor sepeda di dalam lingkaran */
    .bicycle-marker {
        background-color: #6596a7;
        /* Warna biru muda */
        color: black;
        border-radius: 500%;
        width: 50px;
        height: 50px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: bold;
    }

    .bicycle-marker.clicked {
        background-color: red;
        /* Warna merah untuk marker yang diklik */
    }
</style>
