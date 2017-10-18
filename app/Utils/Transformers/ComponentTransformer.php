<?php

namespace App\Utils\Transformers;


class ComponentTransformer extends Transformer
{

    public function transform($component)
    {
        return [
            'id'  => $component['id'],
            'name' =>$component['app_code'],
            'collection' =>$component['collection'],
            'url' =>$component['api_server_url'],
            'username' =>$component['username'],
            'token' =>$component['password']
        ];

        return $component;
    }
}