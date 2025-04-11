@include('layout.header-screen')
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
<div class="container-fluid bg-white pt-3">
    <div class="pc-content">
        <div class="card statistics-card-1">
            <div class="card-body">
                <img src="{{ asset('assets/images/widget/img-status-2.svg') }}" alt="img" class="img-fluid img-bg">
                <div class="d-flex align-items-center justify-content-center">
                    <div class="text-center">
                        <div>
                            <h2 class="mb-0 f-w-700 text-primary" style="text-transform:uppercase;">
                                {{ $config->unit ?? '' }}</h2>
                            {{-- <h2 class="mb-0 f-w-500">Print Ticket To Get Service Queue</h2> --}}
                        </div>
                        <p class="text-muted mb-0">Print Ticket To Get Service Queue/ Cetak Tiket Untuk Mendapatkan
                            Antrian Layanan </br>
                            One Gate Integrated Service Queue / Antrian Pelayanan Terpadu Satu Pintu
                        </p>
                    </div>
                </div>
            </div>
        </div>
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
<footer class="fixed-bottom">
    <div class="container-fluid">
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
<script src="https://code.responsivevoice.org/responsivevoice.js?key={{ Crypt::decrypt($voice->api_key) }}"></script>
<script>
    var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
        cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
    });

    pusher.connection.bind('connected', function() {
        console.log('Pusher connected successfully.');
    });

    pusher.connection.bind('disconnected', function() {
        console.log('Pusher disconnected.');
    });

    pusher.connection.bind('error', function(err) {
        console.error('Pusher connection error:', err);
    });

    var channel = pusher.subscribe('screen-channel');
    channel.bind('ScreenEvent', function(data) {
        window.location.reload();
    });

    var callingChannel = pusher.subscribe('calling-channel');
    callingChannel.bind('CallingEvent', function(data) {
        if (responsiveVoice.voiceSupport()) {
            responsiveVoice.speak(data,
                "Indonesian Female", {
                    volume: 10,
                    rate: 1,
                    pitch: 0.9
                });
        } else {
            console.log("ResponsiveVoice is not supported in this browser.");
        }

    });
</script>
@include('layout.footer-screen')
