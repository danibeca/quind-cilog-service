<?php

namespace App\Utils\Transformers;


class SimpleComponentTransformer extends Transformer
{

    public function transform($component)
    {
        return [
            'id'  => $component['id'],
            'classifier_expression' =>$component['classifier_expression'],
            'jobs_path' =>$component['jobs_path'],
            'ci_system_instance_id' =>$component['ci_system_instance_id'],
        ];

        return $component;
    }
}
