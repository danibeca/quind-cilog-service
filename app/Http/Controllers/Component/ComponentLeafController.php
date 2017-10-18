<?php

namespace App\Http\Controllers\Component;

use App\Models\Component\ComponentTree;
use App\Models\Component\Indicator;
use App\Utils\Models\Language\SelectedLanguage;
use App\Utils\Transformers\ComponentTransformer;
use App\Utils\Transformers\IndicatorSerieTransformer;
use App\Http\Controllers\ApiController;
use App\Models\Component\Component;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;

class ComponentLeafController extends ApiController
{
    public function index($componentId)
    {
        ComponentTree::fixTree();
        $component = Component::find($componentId);
        return $this->respondData((new ComponentTransformer())->transformCollection($component->getLeaves()->toArray()));
    }
}