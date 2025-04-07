<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\PusherService;

class Queue extends Component
{
    public $queue;

    public function sendEvent(PusherService $pusherService)
    {

        $data['message'] = 'hello world';
        $this->queue = 1;

        $pusher = $pusherService->init();
        $pusher->trigger('queue-channel', 'QueueEvent', $data);
    }

    public function render()
    {
        return view('livewire.queue');
    }
}
