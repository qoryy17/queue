@include('layout.header')
@if (session()->has('success'))
    <script>
        'use strict';
        window.onload = function() {
            Swal.fire({
                icon: "success",
                title: "Notification",
                text: "{{ session('success') }}"
            });
        }
    </script>
@elseif (session()->has('error'))
    <script>
        'use strict';
        window.onload = function() {
            Swal.fire({
                icon: "error",
                title: "Notification",
                text: "{{ session('error') }}"
            });
        }
    </script>
@endif
<div class="bg-primary p-3">
    <h3 class="text-center text-white">{{ env('APP_NAME') }} - Pengadilan Negeri Lubuk Pakam</h3>
    <p class="text-center text-white m-0">
        One Gate Integrated Service Queue / Antrian Pelayanan Terpadu Satu Pintu
    </p>
</div>
<div class="container-fluid mt-3">
    <div class="pc-content">
        <h3 class="text-center">Print Ticket To Get Service Queue</h3>
        <p class="text-center m-0 mb-4">
            Cetak Tiket Untuk Mendapatkan Antrian Layanan
        </p>
        <div class="row text-center d-flex justify-content-center">
            @if ($counters)
                @foreach ($counters->get() as $counter)
                    <livewire:screen.card-queue :counterId="Crypt::encrypt($counter->id)" :counterCode="$counter->code" :counterName="$counter->name"
                        :counterDesc="$counter->description" />
                @endforeach
            @else
            @endif
        </div>
    </div>
</div>
<footer class="pc-footer">
    <div class="footer-wrapper container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <p class="m-0">Support By <a href="https://www.instagram.com/qori_chairawan17/" target="_blank">
                        {{ env('APP_AUTHOR') }}
                    </a>
                </p>
            </div>
            <div class="col-lg-6">
                <p class="m-0 text-end">
                    Version {{ env('APP_VERSION') }}
                </p>
            </div>
        </div>
    </div>
</footer>
@include('layout.footer')
