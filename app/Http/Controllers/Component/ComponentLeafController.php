<?php

namespace App\Http\Controllers\Component;

use App\Utils\Transformers\IndicatorSerieTransformer;
use App\Http\Controllers\ApiController;
use App\Models\Component\Component;
use App\Utils\Transformers\SecureComponentTransformer;


class ComponentLeafController extends ApiController
{
    public function index($componentId)
    {
        /** @var Component $component */
        $component = Component::find($componentId);

        if (isset($component))
        {
            return $this->respondStandard((New SecureComponentTransformer())
                ->transformCollection($component->getLeavesWithCISI()->toArray()));
        }

        return $this->respondNotFound();
    }
}