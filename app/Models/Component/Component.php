<?php

namespace App\Models\Component;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{

    public function getLeaves()
    {
        $node = ComponentTree::where('component_id', $this->id)->get()->first();
        return Component::findMany($node->getDescendants()->pluck('component_id'))
            ->where('app_code', '!=',null);

    }

    public function ciSystem()
    {
        return $this->belongsTo('App\Models\CiSystem\CiSystem');
    }

    public function jobSeries()
    {
        return $this->hasMany('App\Models\Component\ComponentJobSerie');

    }

    public function getJobs()
    {
        return $this->jobSeries()
            ->whereCreatedAt(
                $this->jobSeries()->max('created_at')
            )->get();
    }

}
