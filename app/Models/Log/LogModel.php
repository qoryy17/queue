<?php

namespace App\Models\Log;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogModel extends Model
{
    use HasFactory;
    protected $table = 'logs';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'activity',
    ];

    public $timestamps = true;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
