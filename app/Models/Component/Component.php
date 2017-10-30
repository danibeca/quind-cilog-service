<?php

namespace App\Models\Component;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Component extends Model
{

    protected $fillable = ['id', 'type_id', 'app_code', 'ci_system_instance_id'];

    public function continuousIntegrationSystemInstance()
    {
        return $this->belongsTo('\App\Models\QualitySystem\ContinuousIntegrationSystemInstance', 'quality_system_instance_id');
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
                ->with('continuousIntegrationSystemInstance', 'continuousIntegrationSystemInstance.continuousIntegrationSystem')
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
