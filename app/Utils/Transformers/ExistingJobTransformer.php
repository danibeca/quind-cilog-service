<?php

namespace App\Utils\Transformers;


class ExistingJobTransformer extends Transformer
{

    public function transform($component)
    {
        return [
            'id' =>$component['existing_jobs'][0]['phase_job_id']
        ];
    }
}
