<?php

namespace App\Models\Configure;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoiceModel extends Model
{
    use HasFactory;
    protected $table = 'voices';
    protected $primaryKey = 'id';
    protected $fillable = [
        'api_key',
        'language',
        'path_sound',
    ];

    public $timestamps = true;

}
