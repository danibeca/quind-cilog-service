<?php

namespace App\Http\Controllers\APIClient;


use App\Http\Controllers\ApiController;
use App\Models\APIClient\APIClient;
use App\Models\Component\Component;
use App\Models\CISystem\CISystemInstance;
use App\Models\QualitySystem\QualitySystemInstance;
use App\Utils\Transformers\SecureComponentTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;

class APIClientComponentController extends ApiController
{
    public function index($code)
    {

        /** @var APIClient $client */
        $client = APIClient::where('code', $code)->get()->first();
        if (isset($client))
        {
            $cISystemInstance = CISystemInstance::where('api_client_id', $client->id)->get()->first();
            if ($cISystemInstance && ! $cISystemInstance->verified)
            {
                $cISystemInstance->verified = true;
                $cISystemInstance->save();
            }

            $ownerIds = $client->cISystemInstance()->get()->pluck('component_owner_id');
            $roots = Component::
            whereIn('id', $ownerIds)
                ->Where(function ($query) {
                    $query->where('run_client', 1)
                        ->orWhere('last_run_client', '<=', Carbon::now()->subHours(12));
                })->get();

            /** @var Component $root */
            foreach ($roots as $root)
            {
                $root->run_client = 2;
                $root->save();
            }

            return $this->respondStandard($roots->pluck('id'));
        }

        return $this->respondNotFound();
    }
}
