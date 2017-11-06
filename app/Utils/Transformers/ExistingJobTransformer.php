<?php

namespace App\Utils\Transformers;


class ExistingJobTransformer extends Transformer
{

    public function transform($component)
    {
        return [
            //'id' =>$component['existing_jobs']['phase_job_id']
            'id' =>$component['phase_job_id']
        ];
    }
}
