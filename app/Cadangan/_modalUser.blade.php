<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="buyModal{{ $item->id }}Label">Peminjaman Sepeda No
                {{ $item->number }}
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form method="POST" id="bookingForm{{ $item->id }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="admin_id" value="{{ Auth::user()->id }}">
                <input type="hidden" name="bike_id" value="{{ $item->id }}">
                <input type="hidden" name="latitude" id="latitude{{ $item->id }}" value="">
                <input type="hidden" name="longitude" id="longitude{{ $item->id }}" value="">
                <input type="hidden" id="routeName" value="{{ route('staff.pay.borrow') }}">

                <input type="hidden" id="routeNameCash" value="{{ route('staff.paycash.borrow') }}">
                <input type="hidden" id="routeNameApi" value="{{ route('staff.pay.success') }}">


                <div class="form-group">
                    <label for="user_id">Nama Pelanggan</label>
                    <select class="form-control" name="user_id" id="user_id">
                        @foreach ($konsumen as $item_konsumen)
                            <option value="{{ $item_konsumen->id }}">{{ $item_konsumen->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="duration_id">Durasi Sewa Dan Harga Sewa</label>
                    <select class="form-control" name="duration_id" id="duration_id">
                        @foreach ($duration as $item_duration)
                            <option value="{{ $item_duration->id }}">
                                {{ $item_duration->duration }} Menit |
                                {{ number_format($item_duration->price, 0, '', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="payment{{ $item->id }}">Metode Pembayaran</label>
                    <select class="form-control" name="payment" id="payment{{ $item->id }}">
                        <option value="qris">QRIS</option>
                        <option value="tunai">Tunai</option>
                    </select>
                </div>
                <div class="form-group d-none" id="price{{ $item->id }}">
                    <label for="total_price{{ $item->id }}">Total Tunai</label>
                    <input type="number" class="form-control" name="total_price" id="total_price{{ $item->id }}">
                </div>
                <div class="form-group">
                    <label for="">Tanggal Peminjaman</label>
                    <input type="text" class="form-control datepicker" name="start_date" id="start_date">
                </div>
                <div class="form-group">
                    <label for="">Waktu Peminjaman</label>
                    <input type="text" class="form-control timepicker" name="start_time" id="start_time"
                        value="<?php echo date('H:i A'); ?>">
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Foto Jaminan</label>
                    <div class="col-sm-12 col-md-7">
                        <div class="image-preview" id="image-preview-{{ $item->id }}">
                            <label for="image-upload-{{ $item->id }}" class="image-label">Choose
                                File</label>
                            <input type="file" name="pict{{ $item->id }}" id="image-upload-{{ $item->id }}"
                                class="image-input" required />
                        </div>
                    </div>
                </div>

                <div class="form-group d-flex justify-content-center">
                    <button class="btn btn-sm btn-info text-white" id="submitBtn">Proses Peminjaman</button>
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
        var routeNameCash = document.getElementById('routeNameCash').value;
        var routeName = document.getElementById('routeName').value;

        form.addEventListener('submit', function(e) {
            e.preventDefault();




            var formData = new FormData(form);

            // Append files from all file inputs to formData
            appendFilesFromInputs(form, formData);

            // Get the payment method
            var paymentMethod = form.querySelector('select[name="payment"]').value;

            if (paymentMethod === 'tunai') {
                fetch(routeNameCash, {
                        method: 'POST',
                        body: formData
                    })
                    .then(handleResponse)
                    .then(function(data) {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Peminjaman Berhasil!',
                            }).then(function() {
                                window.location.href = "{{ route('staff.dashboard') }}";
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

            } else if (paymentMethod === 'qris') {
                var routeName = document.getElementById('routeName').value;
                fetch(routeName, {
                        method: 'POST',
                        body: formData
                    })
                    .then(handleResponse)
                    .then(function(data) {
                        snap.pay(data.data, {
                            onSuccess: function(result) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: 'Pembayaran Berhasil !',
                                });
                                var routeNameApi = document.getElementById(
                                    'routeNameApi').value;
                                formData.append('invoice', result.order_id);
                                fetch(routeNameApi, {
                                        method: 'POST',
                                        body: formData
                                    })
                                    .then(handleResponse)
                                    .then(function(responseData) {})
                                window.location.href =
                                    "{{ route('staff.dashboard') }}";
                            },
                            onPending: function(result) {
                                console.log('Pending : ' + result.status_code);
                            },
                            onError: function(result) {
                                console.log('Error : ' + result.status_code);
                            },
                        });
                    })
                    .catch(function(error) {
                        console.error('Fetch error:', error);
                    });
            }
        });

        function appendFilesFromInputs(form, formData) {
            var fileInputs = form.querySelectorAll('input[type="file"]');
            var fileData = {}; // Objek untuk menyimpan data file

            fileInputs.forEach(function(input) {
                var name = input.name;
                var files = input.files;

                // Inisialisasi array untuk setiap input file
                fileData[name] = [];

                for (var i = 0; i < files.length; i++) {
                    // Append data file ke objek FormData
                    formData.append(name, files[i]);

                    // Simpan data file ke dalam objek fileData
                    fileData[name].push({
                        name: files[i].name,
                        type: files[i].type,
                        size: files[i].size
                    });
                }
            });

            return fileData; // Kembalikan objek fileData
        }

        function handleResponse(response) {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        }
    });
</script>
