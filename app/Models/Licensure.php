<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Licensure extends Model
{
    protected $table = 'licensure';

    protected $fillable = [
        'program_id',
        'school_college',
        'program_name',
        'weblink',
        'state_name',
        'state_abbreviation',
        'status',
        'description',
    ];

    protected $casts = [
        'program_id' => 'integer',
    ];
}
