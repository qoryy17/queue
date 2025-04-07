<?php

namespace App\Models\Queue;

use App\Models\Queue\QueueModel;
use App\Models\Counter\CounterModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QueueLogModel extends Model
{
    protected $table = 'queue_logs';
    protected $primaryKey = 'id';

    protected $fillable = [
        'queue_id',
        'queue_number',
        'counter_id',
        'counter_name',
    ];
    public $timestamps = true;

    public function queue(): BelongsTo
    {
        return $this->belongsTo(QueueModel::class, 'queue_id', 'id');
    }
    public function counter(): BelongsTo
    {
        return $this->belongsTo(CounterModel::class, 'counter_id', 'id');
    }
}
