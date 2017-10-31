<?php

namespace App\Http\Controllers\Component;

use App\Models\Component\ComponentJobSerie;
use App\Models\Component\Indicator;
use App\Models\Component\JobValue;
use App\Utils\Transformers\IndicatorSerieTransformer;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Input;

class ComponentJobValueController extends ApiController
{
    public function store($componentId)
    {

        $jobs = Input::all();
        JobValue::where('component_id', $componentId)->delete();
        foreach ($jobs as $jobI)
        {
            $job = new JobValue();
            $job->name = $jobI['name'];
            $job->type = $jobI['type'];
            $job->component_id = $componentId;
            $job->save();
        }

        return $this->respondResourceCreated();

    }


}