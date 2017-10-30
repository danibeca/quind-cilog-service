<?php

namespace App\Utils\Transformers;


class QualitySystemInstanceTransformer extends Transformer
{

    public function transform($instance)
    {
        return [
            'id' => $instance['id'],
            'name'  => $instance['quality_system']['name'],
            'url'  => $instance['url'],
            'username'  => $instance['username'],
            'type'  => $instance['type'],
            'quality_system_id' => $instance['type'],
            'verified' =>$instance['verified'],
            'component_owner_id' =>$instance['component_owner_id']
        ];

        return $instance;
    }
}