<?php

namespace App\Http\Controllers\Component;

use App\Models\Component\ComponentJobSerie;
use App\Models\Component\Indicator;
use App\Utils\Transformers\IndicatorSerieTransformer;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Input;

class ComponentJobController extends ApiController
{
    public function create($componentId)
    {

        $jobs = Input::all();

            foreach ($jobs as $jobI)
            {
                $job = new ComponentJobSerie();
                $job->name = $jobI['name'];
                $job->type = $jobI['type'];
                $job->external_id = $jobI['id'];
                $job->component_id = $componentId;
                $job->save();
            }

        return $this->respondResourceCreated();

    }


}