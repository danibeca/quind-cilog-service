<?php

namespace App\Http\Controllers\Component;

use App\Models\Component\ComponentJobSerie;
use App\Models\Component\Indicator;
use App\Utils\Transformers\IndicatorSerieTransformer;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Input;

class ComponentJobController extends ApiController
{
    public function index($componentId)
    {

        $leaves = Input::get('data');
        foreach ($leaves as $leaf)
        {
            $jobs = $leaf['jobs'];
            foreach ($jobs as $jobI)
            {
                $job = new ComponentJobSerie();
                $job->name = $jobI['name'];
                $job->type = $jobI['type'];
                $job->external_id = $jobI['id'];
                $job->component_id = $leaf['id'];
                $job->save();
            }
        }

    }


}