<div>
    <div class="alert alert-warning" role="alert" id="autoDismissAlert"> The queue will be reset every day / Antrian akan
        direset setiap hari.</div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1 me-3">
                    <p class="mb-1 fw-medium text-muted">Counter Status</p>
                    <h4 class="mb-1">{{ $counter['counter']->name }} ({{ $counter['counter']->code }}) |
                        @if ($counter['counter']->status == 'Open')
                            <span class="badge bg-light-success">Open (Antrian Buka)</span>
                        @elseif ($counter['counter']->status == 'Closed')
                            <span class="badge bg-light-danger">Closed (Antrian Tutup)</span>
                        @elseif ($counter['counter']->status == 'Enabled')
                            <span class="badge bg-light-info">Enabled</span>
                        @elseif ($counter['counter']->status == 'Break')
                            <span class="badge bg-light-warning">Break (Antrian Istirahat)</span>
                        @elseif ($counter['counter']->status == 'Disabled')
                            <span class="badge bg-light-danger">Disabled</span>
                        @else
                            <span class="badge bg-light-secondary">Unknown</span>
                        @endif
                    </h4>
                    <p class="mb-0 text-sm">{{ $counter['counter']->description }}</p>
                </div>
                <div class="flex-shrink-0">
                    <div class="avtar avtar-l bg-light-primary rounded-circle">
                        <i class="ph-duotone ph-buildings f-28"></i>
                    </div>
                </div>
            </div>
            <div class="mt-3 d-flex flex-wrap flex-md-nowrap gap-2">
                <button class="btn {{ $buttonColor }}" wire:click="changeStatus">
                    <i class="ph-duotone ph-buildings"></i>
                    {{ $buttonChange }}
                </button>
                <button class="btn btn-warning" wire:click="changeBreak">
                    <i class="ph-duotone ph-timer"></i>
                    Break Time
                </button>
                <button class="btn btn-success" wire:click="loadCount">
                    <i class="ph-duotone ph-database"></i>
                    Load Count Queue
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 col-sm-12">
            <div class="card statistics-card-1 overflow-hidden ">
                <div class="card-body">
                    <img src="{{ asset('assets/images/widget/img-status-2.svg') }}" alt="img"
                        class="img-fluid img-bg">
                    <h5 class="mb-4">Queue Waiting</h5>
                    <div class="d-flex align-items-center mt-3">
                        <h3 class="f-w-300 d-flex align-items-center m-b-0">{{ $waitingQueue }}</h3>
                        <span class="badge bg-light-success ms-2">Service</span>
                    </div>
                    <p class="text-muted mb-2 text-sm mt-3">
                        Total waiting queue services
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card statistics-card-1 overflow-hidden ">
                <div class="card-body">
                    <img src="{{ asset('assets/images/widget/img-status-2.svg') }}" alt="img"
                        class="img-fluid img-bg">
                    <h5 class="mb-4">Queue Completed</h5>
                    <div class="d-flex align-items-center mt-3">
                        <h3 class="f-w-300 d-flex align-items-center m-b-0">{{ $completedQueue }}</h3>
                        <span class="badge bg-light-success ms-2">Service</span>
                    </div>
                    <p class="text-muted mb-2 text-sm mt-3">
                        Total completed queue services
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card statistics-card-1 overflow-hidden ">
                <div class="card-body">
                    <img src="{{ asset('assets/images/widget/img-status-2.svg') }}" alt="img"
                        class="img-fluid img-bg">
                    <h5 class="mb-4">Queue Skipped</h5>
                    <div class="d-flex align-items-center mt-3">
                        <h3 class="f-w-300 d-flex align-items-center m-b-0">{{ $skippedQueue }}</h3>
                        <span class="badge bg-light-success ms-2">Service</span>
                    </div>
                    <p class="text-muted mb-2 text-sm mt-3">
                        Total skipped queue services
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
