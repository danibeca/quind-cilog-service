<?php

namespace App\Http\Controllers\APIClient;

use App\Models\APIClient\APIClient;
use App\Http\Controllers\ApiController;
use App\Models\QualitySystem\QualitySystemInstance;
use App\Models\QualitySystem\QualitySystemInstanceResource;
use Illuminate\Support\Facades\Input;

class APIClientResourceController extends ApiController
{
    public function store($code)
    {

        /** @var APIClient $client */
        $client = APIClient::where('code', $code)->get()->first();
        if (isset($client))
        {
            $qualitySystemInstance = QualitySystemInstance::where('api_client_id', $client->id)->get()->first();
            QualitySystemInstanceResource::where('quality_system_instance_id', $qualitySystemInstance->id)->delete();
            $resources = Input::all();

            foreach ($resources as $resource)
            {
                $value = new QualitySystemInstanceResource($resource);
                $value->quality_system_instance_id = $qualitySystemInstance->id;
                $value->save();
            }

            return $this->respond('OK');
        }

        return $this->respondNotFound();

    }


}