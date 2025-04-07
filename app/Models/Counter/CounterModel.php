<?php

namespace App\Models\Counter;

use App\Models\Queue\QueueModel;
use App\Models\Queue\QueueLogModel;
use App\Models\Officer\OfficerModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CounterModel extends Model
{
    use HasFactory;
    protected $table = 'counters';
    protected $primaryKey = 'id';
    protected $fillable = [
        'code',
        'name',
        'description',
        'status'
    ];

    public $timestamps = true;

    public function officer(): BelongsTo
    {
        return $this->belongsTo(OfficerModel::class);
    }

    public function queue(): BelongsTo
    {
        return $this->belongsTo(QueueModel::class);

    }
    public function queueLogs(): BelongsTo
    {
        return $this->belongsTo(QueueLogModel::class);
    }

}
