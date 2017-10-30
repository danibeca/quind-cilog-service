<?php

namespace App\Models\Component;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{

    protected $fillable = ['id', 'type_id', 'app_code', 'ci_system_instance_id'];

    public function cISystemInstance()
    {
        return $this->belongsTo('\App\Models\CISystem\CISystemInstance', 'ci_system_instance_id');
    }

    public function getLeavesWithCISI()
    {
        $result = collect();
        $tree = ComponentTree::where('component_id', $this->id)->get()->first()->getDescendants();
        if ($tree->count() > 0)
        {
            $ids = $tree->pluck('component_id');
            $result = Component::whereIn('id', $ids)
                ->where('type_id', 3)
                ->with('cISystemInstance', 'cISystemInstance.cISystem')
                ->get();
        }

        return $result;

    }

    public function getLeaves()
    {
        $result = collect();
        $tree = ComponentTree::where('component_id', $this->id)->get()->first()->getDescendants();
        if ($tree->count() > 0)
        {
            $ids = $tree->pluck('component_id');
            $result = Component::whereIn('id', $ids)->where('type_id', 3)->get();

        }

        return $result;

    }
}
