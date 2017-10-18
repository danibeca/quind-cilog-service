<?php

namespace App\Utils\Transformers;


class ComponentTransformer extends Transformer
{

    public function transform($component)
    {
        /*$name = $indicator->tmpname;
        if($indicator->lr_name !== null){
            $name = $indicator->name;
        }*/
        return [
            'id'  => $component['id'],
            'name' =>$component['app_code'],
            'url' =>$component['api_server_url'],
            'username' =>$component['username'],
            'password' =>$component['password'],
            'url' =>$component['api_server_url'],
            'collection' =>$component['collection'],
            'collectionId' =>$component['collection_id'],
            'providerId' =>$component['provider_id']
        ];

        return $component;
    }
}