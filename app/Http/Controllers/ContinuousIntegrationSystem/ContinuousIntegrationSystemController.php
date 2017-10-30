<?php

namespace App\Http\Controllers\QualitySystem;

use App\Http\Controllers\ApiController;
use App\Models\ContinuousIntegrationSystem\ContinuousIntegrationSystem;
use App\Models\QualitySystem\QualitySystem;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ContinuousIntegrationSystemController extends ApiController
{
    public function index()
    {
        return $this->respondData(ContinuousIntegrationSystem::where('active', true)->get());
    }


}
