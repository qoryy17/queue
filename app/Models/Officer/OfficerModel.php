<?php

namespace App\Models\Officer;

use App\Models\User;
use App\Models\Counter\CounterModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OfficerModel extends Model
{
    use HasFactory;
    protected $table = 'officers';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nip',
        'name',
        'position',
        'counter_id',
        'photo',
        'block'
    ];
    public $timestamps = true;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function counter(): HasOne
    {
        return $this->hasOne(CounterModel::class, 'id', 'counter_id');
    }
}
