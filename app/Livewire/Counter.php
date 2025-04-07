<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\CounterService;
use Illuminate\Support\Facades\Auth;

class Counter extends Component
{
    public $data;
    public $counter;

    public function mount(CounterService $counterService)
    {
        $this->counter = $counterService->handleCounter(Auth::user()->officer_id);
    }

    public function changeStatus(CounterService $counterService)
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
        ]);
    }

    public function changeBreak(CounterService $counterService)
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
        ]);
    }
    public function render()
    {
        $this->data = [
            'counter' => $this->counter['counter'],
            'buttonChange' => $this->counter['buttonChange'],
            'buttonColor' => $this->counter['buttonColor'],
        ];

        return view('livewire.counter', $this->data);
    }
}
