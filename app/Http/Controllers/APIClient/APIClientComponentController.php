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

            $result = collect();
            /** @var Component $root */
            foreach ($roots as $root)
            {
                $root->run_client = 2;
                $root->save();
                $result = $result->push($availableCompoenet = $root->getLeavesWithCISI());
            }

            return $this->respondStandard((New SecureComponentTransformer())->transformCollection($result->toArray()));
        }

        return $this->respondNotFound();
    }

    public function update(Request $request, $code)
    {
        /*
        $component = Component::find($code);
        if (isset($component))
        {
            $component->last_run_client = Carbon::now();
            if ($component->run_client === 2)
            {
                $component->run_client = 0;
            }
            $component->run_quind = 1;
            $component->save();

        }
        */
        return $this->respond('OK');
    }

}
