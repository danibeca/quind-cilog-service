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
        $job = new PhaseJob();
        $job->process_phase_id = $id;
        $job->regular_expression = $request->regular_expression;
        $job->name = $request->name;
        $job->save();
        $this->updateRun($id);

        return $this->respondResourceCreated($job);
    }

    public function update(Request $request, $phaseId, $jobId)
    {
        $job = PhaseJob::where('id', $jobId)->where('process_phase_id', $phaseId)->get()->first();
        if (isset($job))
        {
            $this->updateRun($phaseId);
            $job->regular_expression = $request->regular_expression;
            $job->name = $request->name;
            $job->save();
        }


        return $this->respond($job);

    }

    public function destroy(Request $request, $phaseId, $jobId)
    {
        PhaseJob::where('id', $jobId)->where('process_phase_id', $phaseId)->delete();
        $this->updateRun($phaseId);
        return $this->respondResourceDeleted();
    }

    public function updateRun($idPhase)
    {
        $rootId = ProcessPhase::find($idPhase)->component_owner_id;
        $root = Component::find($rootId);

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
