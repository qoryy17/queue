<?php
namespace App\Services;

use Carbon\Carbon;
use App\Models\Queue\QueueModel;
use App\Models\Officer\OfficerModel;

class CounterService
{
    public function handleCounter($officer = null)
    {
        $counter = OfficerModel::findOrFail($officer)->counter()->first();

        if ($counter->status == 'Open') {
            $buttonChange = 'Close Counter';
            $buttonColor = 'btn-danger';
        } elseif ($counter->status == 'Close') {
            $buttonChange = 'Open Counter';
            $buttonColor = 'btn-primary';
        } else {
            $buttonChange = 'Open Counter';
            $buttonColor = 'btn-primary';
        }

        return [
            'counter' => $counter,
            'buttonChange' => $buttonChange,
            'buttonColor' => $buttonColor,
        ];
    }

    public function calculateQueue($officer = null)
    {
        $counter = OfficerModel::findOrFail($officer)->counter()->first();

        $waitingQueue = QueueModel::where('counter_id', $counter->id)->where('status', 'Waiting')->whereDate('created_at', Carbon::today())->count();
        $completedQueue = QueueModel::where('counter_id', $counter->id)->where('status', 'Completed')->whereDate('created_at', Carbon::today())->count();
        $skippedQueue = QueueModel::where('counter_id', $counter->id)->where('status', 'Skipped')->whereDate('created_at', Carbon::today())->count();

        return [
            'waitingQueue' => $waitingQueue,
            'completedQueue' => $completedQueue,
            'skippedQueue' => $skippedQueue
        ];
    }
}
