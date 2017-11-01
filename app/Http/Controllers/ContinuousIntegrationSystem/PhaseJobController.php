<?php

namespace App\Http\Controllers\ContinuousIntegrationSystem;

use App\Http\Controllers\ApiController;
use App\Models\CISystem\CISystem;
use App\Models\ProcessPhase\PhaseJob;
use Illuminate\Http\Request;

class PhaseJobController extends ApiController
{

    public function index($phaseId)
    {
        return $this->respondData(PhaseJob::where('process_phase_id', $phaseId)->get());
    }

    public function store(Request $request, $id)
    {
        $phase = new PhaseJob();
        $phase->process_phase_id = $id;
        $phase->regular_expression = $request->regular_expression;
        $phase->name = $request->name;
        $phase->save();

        return $this->respondResourceCreated($phase);
    }

    public function update(Request $request, $phaseId, $jobId)
    {

        $phase = PhaseJob::where('id', $jobId)->where('process_phase_id', $phaseId)->get()->first();
        if (isset($phase))
        {
            $phase->regular_expression = $request->regular_expression;
            $phase->name = $request->name;
            $phase->save();
        }

        return $this->respond('OK');

    }

    public function destroy(Request $request, $phaseId, $jobId)
    {
        PhaseJob::where('id', $jobId)->where('process_phase_id', $phaseId)->delete();

        return $this->respondResourceDeleted();
    }


}
