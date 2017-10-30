<?php

namespace App\Models\ContinuousIntegrationSystem;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class ContinuousIntegrationSystem extends Model
{
    protected $fillable = ['name'];


    public static function active(Builder $builder, Model $model)
    {
        $builder->where('active', true);
    }

}
