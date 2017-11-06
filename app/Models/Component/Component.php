<?php

namespace App\Models\Component;

use App\Models\ProcessPhase\ExistingJob;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProcessPhase\PhaseJob;
use App\Models\ProcessPhase\ProcessPhase;
use Illuminate\Support\Facades\Log;

class Component extends Model
{

    protected $fillable = ['id', 'type_id', 'ci_system_instance_id', 'classifier_expression', 'jobs_path'];


    public function cISystemInstance()
    {
        return $this->belongsTo('\App\Models\CISystem\CISystemInstance', 'ci_system_instance_id');
    }

    public function existingJobs()
    {
        return $this->hasMany('\App\Models\ProcessPhase\ExistingJob', 'component_id');
    }

    public function getLeavesWithCISI()
    {
        $result = collect();
        $tree = ComponentTree::where('component_id', $this->id)->get()->first()->getDescendants();
        if ($tree->count() > 0)
        {
            $ids = $tree->pluck('component_id');
            $result = Component::whereIn('id', $ids)
                ->where('type_id', 3)
                ->with('cISystemInstance', 'cISystemInstance.cISystem')
                ->get();
        }

        return $result;

    }

    public function getLeaves()
    {
        $result = collect();
        $tree = ComponentTree::where('component_id', $this->id)->get()->first()->getDescendants();
        if ($tree->count() > 0)
        {
            $ids = $tree->pluck('component_id');
            $result = Component::whereIn('id', $ids)->where('type_id', 3)->get();

        }

        return $result;

    }

    public function calculateLeaf($phase)
    {

        $totalJobsPerPhase = $phase->jobs()->count();
        $totalExistingJobs = 0;

        /** @var PhaseJob $job */
        foreach ($phase->jobs as $job)
        {

            /** @var JobValue $jobValue */
            foreach (JobValue::where('component_id', $this->id)->get() as $jobValue)
            {
                if ($job->evaluate($jobValue->name))
                {
                    $totalExistingJobs++;
                    $existingJob = new ExistingJob();
                    $existingJob->component_id = $this->id;
                    $existingJob->phase_job_id = $job->id;
                    $existingJob->save();
                    break;
                }
            }
        }

        $jiv = new JobIndicatorValue();
        $jiv->component_id = $this->id;
        $jiv->phase_id = $phase->id;
        $jiv->total_jobs = $totalJobsPerPhase;
        $jiv->existing_jobs = $totalExistingJobs;
        $jiv->value = $this->getIndicatorPercentageValue($jiv->existing_jobs, $jiv->total_jobs);

        return $jiv;

    }

    public function calculateJobIndicator($root)
    {
        JobIndicatorValue::where('component_id', $this->id)->delete();
        ExistingJob::where('component_id', $this->id)->delete();

        $jobIndicatorValueGeneral = new JobIndicatorValue();
        $jobIndicatorValueGeneral->component_id = $this->id;
        $jobIndicatorValueGeneral->phase_id = 0;
        /** @var ProcessPhase $phase */
        foreach (ProcessPhase::where('component_owner_id', $root->id)->get() as $phase)
        {
            $jobIndicatorValue = new JobIndicatorValue();
            $jobIndicatorValue->phase_id = $phase->id;
            $jobIndicatorValue->total_jobs = 0;
            $jobIndicatorValue->existing_jobs = 0;
            if ($this->type_id === 3)
            {
                $jobIndicatorValue = $this->calculateLeaf($phase);
            } else
            {
                foreach ($this->getLeaves() as $leaf)
                {
                    $jobIndicatorLeafValue = JobIndicatorValue::where('phase_id', $phase->id)
                        ->where('component_id', $leaf->id)->get()->first();
                    $jobIndicatorValue->total_jobs += $jobIndicatorLeafValue->total_jobs;
                    $jobIndicatorValue->existing_jobs += $jobIndicatorLeafValue->existing_jobs;
                }

                $jobIndicatorValue->value = $this->getIndicatorPercentageValue($jobIndicatorValue->existing_jobs, $jobIndicatorValue->total_jobs);

            }
            $jobIndicatorValue->component_id = $this->id;
            $jobIndicatorValue->save();

            $jobIndicatorValueGeneral->total_jobs += $jobIndicatorValue->total_jobs;
            $jobIndicatorValueGeneral->existing_jobs += $jobIndicatorValue->existing_jobs;

        }

        $jobIndicatorValueGeneral->value = $this->getIndicatorPercentageValue($jobIndicatorValueGeneral->existing_jobs, $jobIndicatorValueGeneral->total_jobs);
        $jobIndicatorValueGeneral->save();
    }

    public function getIndicatorPercentageValue($existing_jobs, $total_jobs)
    {
        $result = 0;
        if ($total_jobs && $total_jobs !== 0)
        {
            $result = $existing_jobs / $total_jobs;
        }

        return $result * 100;
    }
}

