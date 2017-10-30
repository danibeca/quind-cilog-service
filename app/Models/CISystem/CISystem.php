<?php

namespace App\Models\CISystem;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class CISystem extends Model
{

    protected $table = 'ci_systems';
    protected $fillable = ['name'];


    public static function active(Builder $builder, Model $model)
    {
        $builder->where('active', true);
    }

}
