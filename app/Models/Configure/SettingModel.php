<?php

namespace App\Models\Configure;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingModel extends Model
{
    use HasFactory;
    protected $table = 'settings'; // For configuration application
    protected $primaryKey = 'id';
    protected $fillable = [
        'institution',
        'eselon',
        'jurisdiction',
        'unit',
        'address',
        'province',
        'city',
        'post_code',
        'email',
        'website',
        'contact',
        'logo',
        'license'
    ];
    public $timestamps = true;
}
