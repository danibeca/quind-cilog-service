<?php

namespace App\Http\Controllers\ContinuousIntegrationSystem;

use App\Http\Controllers\ApiController;
use App\Models\CISystem\CISystem;

class CISystemController extends ApiController
{
    public function index()
    {
        return $this->respondData(CISystem::where('active', true)->get());
    }

}
