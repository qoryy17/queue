<div class="col-lg-3 col-md-6 col-sm-12">
    <div class="card statistics-card-1">
        <div class="card-body">
            <img src="{{ asset('assets/images/widget/img-status-2.svg') }}" alt="img" class="img-fluid img-bg">
            <h3 class="text-center">
                {{ $counterName }}
            </h3>
            <h1 class="text-center text-primary" style="font-size:3rem;">
                {{ $counterCode }}{{ $number }}
            </h1>
            <button class="btn btn-primary w-100" wire:click="generate" wire:loading.class="opacity-25">
                Print / Cetak
            </button>
            <p class="m-0 mt-3">`
                {{ $counterDesc }}
            </p>
        </div>
    </div>
</div>
