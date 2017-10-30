<?php

namespace App\Http\Controllers\Component;


use App\Http\Controllers\ApiController;
use App\Models\Component\Component;

use Carbon\Carbon;
use Illuminate\Http\Request;

class ComponentAPIClientController extends ApiController
{

    public function update(Request $request, $code)
    {

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
        return $this->respond('OK');
    }

}
