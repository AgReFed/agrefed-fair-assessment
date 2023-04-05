<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{

    protected $fillable = [
        'assessment_id',
        'assessment_version',
        'resource_url',
        'assessment_reason',
        'assessment_result',
        'fuji_result',
        'submitted'
    ];

    protected $casts = [
        'assessment_result' => 'array',
        'fuji_result' => 'array'
    ];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

}
