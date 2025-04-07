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
            return redirect()->route('homeScreeen.index')->with('error', 'Could not find counter.');
        }

        $lastQueue = QueueModel::where('counter_id', Crypt::decrypt($counterId))->whereDate('created_at', Carbon::today())->latest()->first();
        $number = $lastQueue ? $lastQueue->queue_index + 1 : 1;

        $formData = [
            'queue_index' => $number,
            'queue_number' => $counter->code . $number,
            'counter_id' => $counter->id,
            'code' => $counter->code,
            'status' => 'Waiting',
        ];

        $saveQueue = QueueModel::create($formData);

        if (!$saveQueue) {
            return redirect()->route('homeScreeen.index')->with('error', 'Could not generate queue number.');
        }

        return $number;
    }

}
