<div>
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
            <div class="mt-3" style="gap: 10px;">
                <button class="btn {{ $buttonColor }}" wire:click="changeStatus">
                    <i class="ph-duotone ph-buildings"></i>
                    {{ $buttonChange }}
                </button>
                <button class="btn btn-warning" wire:click="changeBreak">
                    <i class="ph-duotone ph-timer"></i>
                    Break Time
                </button>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1 me-3">
                    <p class="mb-1 fw-medium text-muted">Queue Status</p>
                    <h4 class="mb-1">{{ $counter['counter']->name }} ({{ $counter['counter']->code }}) |
                        <span class="badge bg-light-success">Queue is running now</span>
                    </h4>
                    <p class="mb-0 text-sm">{{ $counter['counter']->description }}</p>
                </div>
                <div class="flex-shrink-0">
                    <div class="avtar avtar-l bg-light-primary rounded-circle">
                        <i class="ph-duotone ph-buildings f-28"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('show-notification', event => {
        Swal.fire({
            icon: 'success',
            title: 'Notification',
            text: event.detail['0']['message'],
            confirmButtonText: 'OK'
        });
    });
</script>
