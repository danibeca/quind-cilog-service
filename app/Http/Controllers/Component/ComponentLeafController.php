<?php

namespace App\Http\Controllers\Component;

use App\Models\Component\ComponentTree;
use App\Utils\Transformers\ComponentTransformer;
use App\Utils\Transformers\IndicatorSerieTransformer;
use App\Http\Controllers\ApiController;
use App\Models\Component\Component;


class ComponentLeafController extends ApiController
{
    public function index($componentId)
    {
        ComponentTree::fixTree();
        $component = Component::find($componentId);

        return $this->respondStandard((New ComponentTransformer())
            ->transformCollection($component->getLeavesWithCISI()->toArray()));
    }
}