<?php

namespace App\Utils\Transformers;


class SecureComponentTransformer extends Transformer
{

    public function transform($component)
    {
        return [
            'id'  => $component['id'],
            'app_code' =>$component['app_code'],
            'url' =>$component['quality_system_instance']['url'],
            'username' =>$component['quality_system_instance']['username'],
            'password' =>$component['quality_system_instance']['password'],
            'wrapper_class' =>$component['quality_system_instance']['quality_system']['wrapper_class'],
            'quality_system_id' =>$component['quality_system_instance']['quality_system']['id']
        ];

        return $component;
    }
}