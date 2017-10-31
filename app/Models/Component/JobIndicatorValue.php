<?php

namespace App\Models\Component;

use Illuminate\Database\Eloquent\Model;

class JobIndicatorValue extends Model
{
    protected $fillable = ['component_id','phase_id', 'total_jobs', 'existing_jobs', 'value'];

}
