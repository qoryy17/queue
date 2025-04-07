<?php

namespace App\Models\Queue;

use App\Models\Counter\CounterModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QueueModel extends Model
{
    protected $table = 'queues';
    protected $primaryKey = 'id';

    protected $fillable = [
        'queue_index',
        'queue_number',
        'counter_id',
        'code',
        'status',
        'called_at',
        'completed_at',
        'skipped_at'
    ];
    public $timestamps = true;

    public function queueLogs(): BelongsTo
    {
        return $this->belongsTo(QueueLogModel::class);
    }
    public function counter(): BelongsTo
    {
        return $this->belongsTo(CounterModel::class, 'counter_id', 'id');
    }
}
