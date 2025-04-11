<div>
    @if ($notify)
        <div class="alert {{ $alert ?? 'alert-primary' }}" role="alert" id="autoDismissAlert"> {{ $notify }} </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-6">
                    <h5 class="card-title text-muted mb-1 fw-medium text-center">
                        Queue Now / Antrian Sekarang
                    </h5>
                    <h1 class="text-primary text-center" style="font-size: 5rem;">
                        @if ($nowQueue)
                            {{ str_replace('.', '', $nowQueue->queue_number) }}
                        @else
                            N/A
                        @endif
                    </h1>
                </div>
                <div class="col-md-6">
                    <h5 class="card-title text-muted mb-1 fw-medium text-center">
                        Last Queue / Antrian Terakhir
                    </h5>
                    <h1 class="text-secondary text-center" style="font-size: 5rem;">
                        @if ($lastQueue)
                            {{ str_replace('.', '', $lastQueue->queue_number) }}
                        @else
                            N/A
                        @endif
                    </h1>
                </div>
            </div>

            <button type="button" @if (!$nowQueue) disabled @endif
                class="btn btn-primary btn-lg w-100 mb-2"
                wire:click="callNowQueue({{ $nowQueue->id ?? '' }}, '{{ $nowQueue->queue_number ?? '' }}')">
                Call Queue / Panggil Antrian <i class="ph-duotone ph-speaker-high"></i>
            </button>
            <button type="button" @if (!$lastQueue) disabled @endif
                class="btn btn-warning btn-lg w-100 mb-2"
                wire:click="callNextQueue({{ $nowQueue->id ?? '' }}, '{{ $nowQueue->queue_number ?? '' }}')">
                Next Queue / Antrian Selanjutnya <i class="ph-duotone ph-fast-forward"></i>
            </button>
            <button type="button" @if (!$lastQueue) disabled @endif
                class="btn btn-danger btn-lg w-100 mb-2"
                wire:click="skipQueue({{ $nowQueue->id ?? '' }},'{{ $nowQueue->queue_number ?? '' }}')">
                Skip Queue / Lewati Antrian <i class="ph-duotone ph-skip-forward"></i>
            </button>
            <button type="button" class="btn btn-dark btn-lg w-100" wire:click="loadQueue">
                Load Queue / Memuat Antrian <i class="ph-duotone ph-arrows-clockwise"></i>
            </button>
        </div>
    </div>
</div>
<script>
    window.addEventListener('show-notification', event => {
        Swal.fire({
            icon: event.detail['0']['icon'],
            title: 'Notification',
            text: event.detail['0']['message'],
        });
    });

    setTimeout(function() {
        const alert = document.getElementById('autoDismissAlert');
        if (alert) {
            alert.classList.add('d-none');
        }
    }, 20000);
</script>
