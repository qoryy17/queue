<div>
    <div class="card">
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-6">
                    <h5 class="card-title text-muted mb-1 fw-medium text-center">
                        Queue Now / Antrian Sekarang
                    </h5>
                    <h1 class="text-primary text-center" style="font-size: 5rem;">
                        {{ $queue }}
                    </h1>
                </div>
                <div class="col-md-6">
                    <h5 class="card-title text-muted mb-1 fw-medium text-center">
                        Next Queue / Antrian Selanjutnya
                    </h5>
                    <h1 class="text-secondary text-center" style="font-size: 5rem;">
                        10
                    </h1>
                </div>
            </div>
            <button type="button" class="btn btn-primary btn-lg w-100 mb-2" wire:click="sendEvent">
                Recall Queue / Panggil Antrian <i class="ph-duotone ph-speaker-high"></i>
            </button>
            <button type="button" class="btn btn-warning btn-lg w-100 mb-2">
                Next Queue / Antrian Selanjutnya <i class="ph-duotone ph-fast-forward"></i>
            </button>
            <button type="button" class="btn btn-danger btn-lg w-100">
                Skip Queue / Lewati Antrian <i class="ph-duotone ph-skip-forward"></i>
            </button>
        </div>
    </div>
</div>
