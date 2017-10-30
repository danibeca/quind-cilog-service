<?php

namespace App\Http\Controllers\Component;

use App\Models\Component\ComponentTree;
use App\Utils\Transformers\ComponentTransformer;
use App\Utils\Transformers\IndicatorSerieTransformer;
use App\Http\Controllers\ApiController;
use App\Models\Component\Component;
use App\Utils\Transformers\SecureComponentTransformer;


class ComponentLeafController extends ApiController
{
    public function index($componentId)
    {
        $component = Component::find($componentId);

        return $this->respondStandard((New SecureComponentTransformer())
            ->transformCollection($component->getLeavesWithCISI()->toArray()));
    }
}