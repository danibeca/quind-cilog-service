<?php

namespace App\Models\Component;

use Illuminate\Database\Eloquent\Model;

class JobValue extends Model
{
    protected $fillable = ['name','component_id', 'type'];

}
