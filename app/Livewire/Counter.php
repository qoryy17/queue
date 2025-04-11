<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\CounterService;
use App\Services\PusherService;
use Illuminate\Support\Facades\Auth;

class Counter extends Component
{
    public $data;
    public $counter, $countQueue, $waitingQueue, $completedQueue, $skippedQueue;

    public function mount(CounterService $counterService)
    {
        $this->counter = $counterService->handleCounter(Auth::user()->officer_id);
        $this->countQueue = $counterService->calculateQueue(Auth::user()->officer_id);

        $this->waitingQueue = $this->countQueue['waitingQueue'];
        $this->completedQueue = $this->countQueue['completedQueue'];
        $this->skippedQueue = $this->countQueue['skippedQueue'];
    }

    public function changeStatus(CounterService $counterService, PusherService $pusherService)
    {
        $officer = Auth::user()->officer_id;
        $this->counter = $counterService->handleCounter($officer);

        if ($this->counter['counter']->status === \App\Enum\CounterEnum::DISABLED->value) {
            return redirect()->route('queues.index')->with('error', 'Counter is disabled, please contact Administrator for enabled');
        }

        if ($this->counter['counter']->status === \App\Enum\CounterEnum::OPEN->value) {
            $this->counter['counter']->update(['status' => \App\Enum\CounterEnum::CLOSED->value]);
            $message = 'Counter status changed to closed';
        } else {
            $this->counter['counter']->update(['status' => \App\Enum\CounterEnum::OPEN->value]);
            $message = 'Counter status changed to open';
        }
        $this->counter = $counterService->handleCounter($officer);
        $this->dispatch('show-notification', [
            'message' => $message,
            'icon' => 'success'
        ]);

        // Broadcast pusher
        $pusher = $pusherService->init();
        $pusher->trigger('screen-channel', 'ScreenEvent', '');

        // Load count queue
        $this->countQueue = $counterService->calculateQueue(Auth::user()->officer_id);

        $this->waitingQueue = $this->countQueue['waitingQueue'];
        $this->completedQueue = $this->countQueue['completedQueue'];
        $this->skippedQueue = $this->countQueue['skippedQueue'];
    }

    public function changeBreak(CounterService $counterService, PusherService $pusherService)
    {
        $officer = Auth::user()->officer_id;
        $this->counter = $counterService->handleCounter($officer);

        if ($this->counter['counter']->status === \App\Enum\CounterEnum::DISABLED->value) {
            return redirect()->route('queues.index')->with('error', 'Counter is disabled, please contact Administrator for enabled');
        }

        if ($this->counter['counter']->status === \App\Enum\CounterEnum::BREAK ->value) {
            $this->counter['counter']->update(['status' => \App\Enum\CounterEnum::OPEN->value]);
            $message = 'Counter status changed to open';
        } else {
            $this->counter['counter']->update(['status' => \App\Enum\CounterEnum::BREAK ->value]);
            $message = 'Counter status changed to break time';
        }
        $this->counter = $counterService->handleCounter($officer);
        $this->dispatch('show-notification', [
            'message' => $message,
            'icon' => 'success'
        ]);

        // Broadcast pusher
        $pusher = $pusherService->init();
        $pusher->trigger('screen-channel', 'ScreenEvent', '');

        // Load count queue
        $this->countQueue = $counterService->calculateQueue(Auth::user()->officer_id);

        $this->waitingQueue = $this->countQueue['waitingQueue'];
        $this->completedQueue = $this->countQueue['completedQueue'];
        $this->skippedQueue = $this->countQueue['skippedQueue'];
    }

    public function loadCount(CounterService $counterService)
    {
        // Load count queue
        $this->countQueue = $counterService->calculateQueue(Auth::user()->officer_id);

        $this->waitingQueue = $this->countQueue['waitingQueue'];
        $this->completedQueue = $this->countQueue['completedQueue'];
        $this->skippedQueue = $this->countQueue['skippedQueue'];
    }

    public function render()
    {
        $this->data = [
            'counter' => $this->counter['counter'],
            'buttonChange' => $this->counter['buttonChange'],
            'buttonColor' => $this->counter['buttonColor'],
        ];

        return view('livewire.counter')->with(
            $this->data
        );
    }
}
