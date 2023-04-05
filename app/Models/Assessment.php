<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{

    protected $fillable = ['resource_name', 'resource_description'];

    /**
     * Get the user that owns the assessment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function results()
    {
        return $this->hasmany(Result::class);
    }

}
