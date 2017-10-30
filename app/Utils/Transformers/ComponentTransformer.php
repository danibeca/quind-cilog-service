<?php

namespace App\Utils\Transformers;


class ComponentTransformer extends Transformer
{

    public function transform($component)
    {
        return [
            'id'  => $component['id'],
            'app_code' =>$component['app_code']
        ];

        return $component;
    }
}