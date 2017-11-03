<?php

namespace App\Http\Controllers\ContinuousIntegrationSystem;

use App\Http\Controllers\ApiController;
use App\Models\Component\Component;
use App\Models\Component\ComponentTree;
use App\Models\ProcessPhase\PhaseJob;
use App\Models\ProcessPhase\ProcessPhase;
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
        $this->updateRun($id);

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
        $this->updateRun($phaseId);

        return $this->respond($phase);

    }

    public function destroy(Request $request, $phaseId, $jobId)
    {
        PhaseJob::where('id', $jobId)->where('process_phase_id', $phaseId)->delete();
        $this->updateRun($phaseId);
        return $this->respondResourceDeleted();
    }

    public function updateRun($idPhase)
    {
        $root = new Component(
            ComponentTree::where('component_id',
                ProcessPhase::find($idPhase)->component_id)
                ->get()->first()->getRoot()->component_id);
        if ($root)
        {
            if ($root->run_client === 2 || $root->run_quind === 2 || $root->run_quind === 1)
            {
                $root->run_client = 3;
            } else
            {
                $root->run_client = 1;
            }

            $root->save();
        }
    }


}
