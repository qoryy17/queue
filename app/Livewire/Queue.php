<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Services\QueueService;
use App\Services\PusherService;
use App\Models\Queue\QueueLogModel;
use App\Models\Officer\OfficerModel;
use Illuminate\Support\Facades\Auth;

class Queue extends Component
{
    // Declaration variabel
    public $loadQueueService, $nowQueue, $lastQueue, $notify, $alert;

    public function mount()
    {
        // Call load queue
        $this->loadQueue();
    }

    public function loadQueue()
    {
        // Load queue on page
        $officer = OfficerModel::findOrFail(Auth::user()->officer_id);

        $queueService = new QueueService();
        $allQueue = $queueService->loadCallQueue($officer->counter_id);
        $this->nowQueue = $allQueue['nowQueue'];
        $this->lastQueue = $allQueue['lastQueue'];
    }

    public function checkCounter()
    {
        // Check if counter not open return with message
        $availableCounter = OfficerModel::with('counter')->findOrFail(Auth::user()->officer_id);
        if ($availableCounter->counter->status != \App\Enum\CounterEnum::OPEN->value) {
            return $this->dispatch('show-notification', [
                'message' => 'You must open counter to call queue !',
                'icon' => 'error'
            ]);
        }
        return $availableCounter;
    }

    public function callNowQueue($id = null, $queue = null, QueueService $queueService, PusherService $pusherService)
    {
        // Check if counter not open return with message
        $counterReady = $this->checkCounter();

        // Check another counter its calling
        $anotherCounter = $queueService->checkStatusCounter($id, $counterReady->counter->id);
        if (!$anotherCounter) {
            $parameters = [
                'status' => 'Called',
                'called_at' => Carbon::now()
            ];

            // Update status queue
            $queueService->updateQueue($id, $parameters);

            // Delete duplicate queue number
            $queueService->deleteDuplicateQueue($counterReady->counter->id, $queue);

            // Send notification alert
            $this->notify = $queue . ' Queue Calling ! / Memanggil Antrian ' . $queue;
            $this->alert = 'alert-primary';

            // Broadcast pusher
            $pusher = $pusherService->init();
            $message = 'Nomor antrian. ' . $queue . ' .Silahkan menuju loket antrian .' . $counterReady->counter->name;
            $pusher->trigger('calling-channel', 'CallingEvent', $message);
        } else {
            // Send notification alert
            $this->notify = 'Calling hold on, ' . $anotherCounter->counter->name . ' is calling, please waiting for finished !';
            $this->alert = 'alert-danger';

            $this->dispatch('show-notification', [
                'message' => 'Calling hold on, ' . $anotherCounter->counter->name . ' is calling, please waiting for finished !',
                'icon' => 'error'
            ]);
        }
    }

    public function callNextQueue($id = null, $queue = null, QueueService $queueService, PusherService $pusherService)
    {
        // Check if counter not open return with message
        $counterReady = $this->checkCounter();

        $parameters = [
            'status' => 'Completed',
            'completed_at' => Carbon::now()
        ];

        // Update status queue
        $queueService->updateQueue($id, $parameters);


        // Delete duplicate queue number
        $queueService->deleteDuplicateQueue($counterReady->counter->id, $queue);

        // Load queues on page
        $this->loadQueue();

        // Save to queue log
        QueueLogModel::create([
            'queue_id' => $id,
            'queue_number' => $queue,
            'counter_id' => $counterReady->counter->id,
            'counter_name' => $counterReady->counter->name,
            'status' => 'Completed'
        ]);

        // Send notification alert
        $this->notify = $queue . ' Queue Completed, Call Next Queue ! / Antrian ' . $queue . ' diselesaikan, memanggil antrian berikutnya !';
        $this->alert = 'alert-success';

    }

    public function skipQueue($id = null, $queue = null, QueueService $queueService)
    {
        // Check if counter not open return with message
        $counterReady = $this->checkCounter();

        $parameters = [
            'status' => 'Skipped',
            'skipped_at' => Carbon::now()
        ];

        // Update status queue
        $queueService->updateQueue($id, $parameters);

        // Delete duplicate queue number
        $queueService->deleteDuplicateQueue($counterReady->counter->id, $queue);


        // Load queues on page
        $this->loadQueue();

        // Save to queue log
        QueueLogModel::create([
            'queue_id' => $id,
            'queue_number' => $queue,
            'counter_id' => $counterReady->counter->id,
            'counter_name' => $counterReady->counter->name,
            'status' => 'Skipped'
        ]);

        // Send notification alert
        $this->notify = $queue . ' Queue Skipped ! / Antrian ' . $queue . ' dilewatkan !';
        $this->alert = 'alert-warning';
    }

    public function render()
    {
        return view('livewire.queue');
    }
}
