<?php

namespace App\Livewire\Screen;

use Livewire\Component;
use App\Services\QueueService;

class CardQueue extends Component
{

    public $counterId, $counterCode, $counterName, $counterDesc, $number;
    public function mount(QueueService $loadQueue)
    {
        $this->number = $loadQueue->loadQueue($this->counterId);
    }

    public function generate(QueueService $queueService)
    {
        // Generate number from service
        $this->number = $queueService->generateNumber($this->counterId);
        $this->number = $queueService->loadQueue($this->counterId);
    }
    public function render()
    {
        return view('livewire..screen.card-queue');
    }
}
