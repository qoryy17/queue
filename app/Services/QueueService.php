<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Queue\QueueModel;
use App\Models\Counter\CounterModel;
use Illuminate\Support\Facades\Crypt;

class QueueService
{
    public function loadQueue($counterId = null)
    {
        // Logic to search counter
        $counter = CounterModel::findOrFail(Crypt::decrypt($counterId));
        if (!$counter) {
            return redirect()->back()->with('error', 'Could not find counter.');
        }

        // Load last number queue
        $lastQueue = QueueModel::where('counter_id', Crypt::decrypt($counterId))->whereDate('created_at', Carbon::today())->latest()->first();
        $number = $lastQueue ? $lastQueue->queue_index + 1 : 1;

        return $number;
    }
    public function generateNumber($counterId = null)
    {
        // Logic to search counter
        $counter = CounterModel::findOrFail(Crypt::decrypt($counterId));
        if (!$counter) {
            return redirect()->back()->with('error', 'Could not find counter.');
        }

        // If counter its open ?
        if ($counter->status != \App\Enum\CounterEnum::OPEN->value) {
            return redirect()->back()->with('error', 'Counter not open !');
        }

        $saveQueue = null;

        $lastQueue = QueueModel::where('counter_id', Crypt::decrypt($counterId))->whereDate('created_at', Carbon::today())->latest()->first();
        $number = $lastQueue ? $lastQueue->queue_index + 1 : 1;

        // Generate queue number
        $queueNumber = $counter->code . '.' . $number;

        $formData = [
            'queue_index' => $number,
            'queue_number' => $queueNumber,
            'counter_id' => $counter->id,
            'code' => $counter->code,
            'status' => 'Waiting',
        ];

        $saveQueue = QueueModel::create($formData);


        if (!$saveQueue) {
            return redirect()->back()->with('error', 'Could not generate queue number.');
        }

        return $number;
    }

    public function loadCallQueue($counterId = null)
    {
        // Logic to search counter
        $counter = CounterModel::findOrFail($counterId);
        if (!$counter) {
            return redirect()->route('queues.index')->with('error', 'Could not find counter.');
        }

        // Get now queue

        $nowQueue = QueueModel::where('counter_id', $counter->id)->where('status', 'Called')->whereDate('created_at', Carbon::today())->oldest()->first();
        if (!$nowQueue) {
            $nowQueue = QueueModel::where('counter_id', $counter->id)->where('status', 'Waiting')->whereDate('created_at', Carbon::today())->oldest()->first();
        }

        // Get last queue
        $lasQueue = QueueModel::where('counter_id', $counter->id)->where('status', 'Waiting')->whereDate('created_at', Carbon::today())->latest()->first();

        return [
            'nowQueueId' => $nowQueue->id ?? null,
            'nowQueue' => $nowQueue,
            'lastQueueId' => $lasQueue->id ?? null,
            'lastQueue' => $lasQueue
        ];
    }

    public function checkStatusCounter($id = null, $counterId = null)
    {
        return QueueModel::with('counter')->where('counter_id', '<>', $counterId)->where('status', 'Called')->first();
    }

    public function deleteDuplicateQueue($counterId = null, $queueNumber = null)
    {
        // Delete duplicate queue number
        $queue = QueueModel::where('queue_number', $queueNumber)->where('status', 'Waiting')->where('counter_id', $counterId)->whereDate('created_at', Carbon::today());
        if ($queue) {
            return $queue->delete();
        }

        return true;
    }

    public function updateQueue($id = null, $parameters = null)
    {
        $queue = QueueModel::findOrFail($id);
        if ($queue) {
            $queue->update($parameters);
        }

        return redirect()->back()->with('error', 'Queue not found !');
    }

}
